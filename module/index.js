'use strict';

var util = require('util');
var path = require('path');
var yeoman = require('yeoman-generator');
var colors = require('colors');
var fs = require('fs')

var ModuleGenerator = module.exports = function ModuleGenerator(args, options, config) {
	yeoman.generators.Base.apply(this, arguments);

	this.on('end', function () {
	    this.installDependencies({ skipInstall: options['skip-install'] });
		console.log('The module ' + (this.module.slug).yellow.bold + ' has been created.');
	});
	
	console.log(
		'\nWelcome to the ' + 'Phalcon module generator'.bold + '.\n\n' +
		'I will create a new ' + 'Phalcon module'.yellow + ' for your application.\n'
	);

	this.module = false;
	this.project = false;

	if (options.moduleName) {
  		this.module = this.getModuleObject(options.moduleName);
	}

	if (options.projectName) {
  		this.project = this.getProjectObject(options.projectName);
  	}
};

util.inherits(ModuleGenerator, yeoman.generators.Base);

ModuleGenerator.prototype.askFor = function askFor()
{
	var prompts,
		cb = this.async();

 	if (!this.module || !this.project) {
 		console.log('Please answer these simple questions:\n');
		prompts = [
			{
				type: 'input',
				name: 'projectName',
				message: 'What is the namespace of the project this module should belong to?',
				validate: function (input) {
					if (!input) {
						return 'I think your ' +
							'project'.red +
							' deserves an awesome ' +
							'namespace'.red + '!';
					}
					return true;
				}
			},
			{
		      type: 'input',
		      name: 'moduleName',
		      message: 'How would you like to name your module?',
		      validate: function (input) {
		        if (!input) {
		          return 'Please specify a valid ' +
		            'module name'.red +
		            ' - this is not too difficult since it may be any string ...';
		        }
		        return true;
		      }
		    }
		];

		this.prompt(prompts, function (props) {
			this.project = this.getProjectObject(props.projectName);
			this.module = this.getModuleObject(props.moduleName);
			this.files();
			cb();
		}.bind(this));
	} else {
		this.files();
		cb();
	}
};

/*
 * Create module directory structure and module specific files,
 * copy the view files to the public resources
 */
ModuleGenerator.prototype.files = function files()
{
	this.moduleFiles();
	this.addModuleConfig();
};

/*
 * Add a module config entry to the application wide  modules configuration.
 */
ModuleGenerator.prototype.addModuleConfig = function addModuleConfig()
{
	 var file = 'private/config/modules.php',
	 	moduleString = "\n\t'" + this.module.slug + "' => array(\n\t\t" +
				"'className' => '\\" + this.project.namespace + "\\" + this.module.namespace + "\\Module',\n\t\t" +
				"'path' => __DIR__ . '/../modules/" + this.module.slug + "/Module.php',\n\t" +
			"),\n" +
		");\n";

	fs.readFile(file, 'utf8', function (err, data) {
		if (err) {
			return console.log(err);
		} else {
			var result = data.replace(/\);/g, moduleString);
			fs.writeFile(file, result, 'utf8', function (err) {
				 if (err) {
					return console.log(err);
				}
			});
		}
	});
};

/*
 * Create module directory structure and module specific files,
 * copy the view files to the public resources
 */
ModuleGenerator.prototype.moduleFiles = function moduleFiles()
{
  var dir = 'private/modules/' + this.module.slug;
  this.mkdir(dir);
  this.directory('module', dir);

  /* copy the views dir to public resources */
  dir = 'public/src/app/modules/' + this.module.slug + '/views';
  this.mkdir(dir);
  this.directory('views', dir);
};

ModuleGenerator.prototype.getProjectObject = function getProjectObject(projectName)
{
	return {
		name: projectName,
        namespace: this._.camelize(this._.capitalize(projectName)),
        slug: this._.slugify(projectName),
        camelCase: this._.camelize(projectName),
        rewritePath: '/' + this._.slugify(projectName) + '/',
        layoutsDir: "__DIR__ . '/../../../public/src/app/layouts/'"
	};
};

ModuleGenerator.prototype.getModuleObject = function getModuleObject(moduleName)
{
	return {
		name: moduleName,
		namespace: this._.camelize(this._.capitalize(moduleName)),
		slug: this._.slugify(moduleName),
		camelCase: this._.camelize(moduleName),
		viewsDir: "__DIR__ . '/../../../public/src/app/modules/" + this._.slugify(moduleName) + "/views/'"
	};
};
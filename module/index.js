'use strict';

var util = require('util');
var yeoman = require('yeoman-generator');
var colors = require('colors');
var fs = require('fs')

var ModuleGenerator = module.exports = function ModuleGenerator(args, options, config) {
	// By calling `NamedBase` here, we get the argument to the subgenerator call
	// as `this.name`.
	yeoman.generators.NamedBase.apply(this, arguments);

	 this.module = {
			name: this.name,
			namespace: this._.camelize(this._.capitalize(this.name)),
			slug: this._.slugify(this.name),
			camelCase: this._.camelize(this.name),
			viewsDir: "__DIR__ . '/../../../public/src/app/" + this._.slugify(this.name) + "/views/'"
	};
};

util.inherits(ModuleGenerator, yeoman.generators.NamedBase);

ModuleGenerator.prototype.askFor = function askFor()
{
	var cb = this.async();
	var you = ' his dudeness '.blue;

	// have Yeoman greet the user
	// console.log(this.yeoman);
	console.log('\nWelcome to the ' + 'Phalcon module generator'.bold + '.\n\n' +
			'I will create a new ' + 'Phalcon module'.yellow + ' for your application.\n' +
			'Your new module will be called ' + this.name.green + '.\n' +
			'Please answer a simple question:\n'
	);
 
	var prompts = [
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
		}
	];

	this.prompt(prompts, function (props) {
		this.project = {
				name: props.projectName,
				namespace: this._.camelize(this._.capitalize(props.projectName)),
				slug: this._.slugify(props.projectName),
				camelCase: this._.camelize(props.projectName),
				rewritePath: '/' + this._.slugify(props.projectName) + '/'
		};
		cb();
	}.bind(this));
};

/*
 * Create module directory structure and module specific files,
 * copy the view files to the public resources
 */
ModuleGenerator.prototype.files = function files()
{
	var dir = 'private/modules/' + this.module.slug;
	this.mkdir(dir);
	this.directory('module', dir);

	/* copy the views dir to public resources */
	dir = 'public/src/app/' + this.module.slug + '/views';
	this.mkdir(dir);
	this.directory('views', dir);

	this.addModuleConfig();
};

/*
 * Add a module config entry to the application wide  modules configuration.
 */
ModuleGenerator.prototype.addModuleConfig = function addModuleConfig()
{
	 var file = 'private/config/modules.php'
	 var moduleString = "\n\t,'" + this.module.slug + "' => array(\n\t\t" +
			"'className' => '" + this.project.namespace + "\\" + this.module.namespace + "\\Module',\n\t\t" +
			"'path' => __DIR__ . '/../modules/" + this.module.slug + "/Module.php'\n\t" +
		")\n" +
		");\n";

		fs.readFile(file, 'utf8', function (err, data) {
			if (err) {
				return console.log(err);
			}
			var result = data.replace(/\);/g, moduleString);
			fs.writeFile(file, result, 'utf8', function (err) {
				 if (err) {
					return console.log(err);
				}
			});
		});
};

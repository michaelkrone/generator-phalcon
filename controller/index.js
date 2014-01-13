'use strict';

var util = require('util');
var path = require('path');
var yeoman = require('yeoman-generator');
var colors = require('colors');
var fs = require('fs')

var ControllerGenerator = module.exports = function ControllerGenerator(args, options, config) {
	yeoman.generators.Base.apply(this, arguments);

	this.on('end', function () {
	    this.installDependencies({ skipInstall: options['skip-install'] });
		console.log('The controller ' + (this.controller.fullName).yellow.bold + ' has been created.');
	});
	
	console.log(
		'\nWelcome to the ' + 'Phalcon controller generator'.bold + '.\n\n' +
		'I will create a new ' + 'Phalcon controller'.yellow + ' for your application.\n'
	);

	this.controller = false;
	this.module = false;
	this.project = false;

	if (options.controllerName) {
  		this.controller = this.getControllerObject(options.controllerName);
	}

	if (options.moduleName) {
  		this.module = this.getModuleObject(options.moduleName);
	}

	if (options.projectName) {
  		this.project = this.getProjectObject(options.projectName);
  	}
};

util.inherits(ControllerGenerator, yeoman.generators.Base);

ControllerGenerator.prototype.askFor = function askFor()
{
	var prompts,
		cb = this.async();

 	if (!this.module || !this.project) {
 		console.log('Please answer these simple questions:\n');
		prompts = [
			{
				type: 'input',
				name: 'projectName',
				message: 'What is the namespace of the project this controller should belong to?',
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
		      message: 'How is the namespace of the module your controller should belong to?',
		      validate: function (input) {
		        if (!input) {
		          return 'Please specify a valid ' +
		            'module name'.red +
		            ' - this is not too difficult since it may be any string ...';
		        }
		        return true;
		      }
		    },
			{
		      type: 'input',
		      name: 'controllerName',
		      message: 'What is the name of your controller (Without "Controller" suffix)?',
		      validate: function (input) {
		        if (!input) {
		          return 'Please specify a valid ' +
		            'controller name'.red +
		            ' - this is not too difficult since it may be any string ...';
		        }
		        return true;
		      }
		    }
		];

		this.prompt(prompts, function (props) {
			this.controller = this.getControllerObject(props.controllerName);
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
ControllerGenerator.prototype.files = function files()
{
	this.controllerFiles();
	this.viewFiles();
};

/*
 * Create module directory structure and module specific files
 */
ControllerGenerator.prototype.controllerFiles = function controllerFiles()
{
  var dir = 'private/modules/' + this.module.slug + '/controllers/api/';
  this.mkdir(dir);
  this.template('controllers/api/IndexController.php', dir + this.controller.fileName);

  dir = 'test/modules/' + this.module.slug + '/';
  this.mkdir(dir);
  this.template('test/ControllerTest.php', dir + this.controller.name + 'ControllerTest.php');

};

/*
 * Create module directory structure and module specific files,
 * copy the view files to the public resources
 */
ControllerGenerator.prototype.viewFiles = function viewFiles()
{
  var dir = 'public/src/app/modules/' + this.module.slug + '/views/' + this.controller.slug;
  this.mkdir(dir);
  this.template('views/index/index.html', dir + '/index.html');
};
  
ControllerGenerator.prototype.getProjectObject = function getProjectObject(projectName)
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

ControllerGenerator.prototype.getModuleObject = function getModuleObject(moduleName)
{
	return {
		name: moduleName,
		namespace: this._.camelize(this._.capitalize(moduleName)),
		slug: this._.slugify(moduleName),
		camelCase: this._.camelize(moduleName),
		viewsDir: "__DIR__ . '/../../../public/src/app/modules/" + this._.slugify(moduleName) + "/views/'"
	};
};

ControllerGenerator.prototype.getControllerObject = function getControllerObject(controllerName)
{
	return {
		name: controllerName,
		fullName: controllerName + 'Controller',
		fileName: controllerName + 'Controller.php',
        namespace: this._.camelize(this._.capitalize(controllerName)),
        slug: this._.slugify(controllerName),
        camelCase: this._.camelize(controllerName)
	};
};

'use strict';

var util = require('util');
var path = require('path');
var colors = require('colors');
var yeoman = require('yeoman-generator');

var PhalconGenerator = module.exports = function PhalconGenerator(args, options, config) {
  yeoman.generators.Base.apply(this, arguments);

  this.on('end', function () {
    this.installDependencies({ skipInstall: options['skip-install'] });

    // we assume project slug as root folder, inform the user about this fact
    console.log(
      'Please make sure this project is located in the ' +
      (this.project.slug).yellow.bold +
      ' directory under your webserver root!'
    );

     // call module generator
    this.invoke('phalcon:module', {
      options: {
        'skip-install': true,
        'moduleName': this.module.name,
        'projectName': this.project.name,
      }
    });
  });
 
  this.pkg = JSON.parse(this.readFileAsString(path.join(__dirname, '../package.json')));
};

util.inherits(PhalconGenerator, yeoman.generators.Base);

PhalconGenerator.prototype.askFor = function askFor()
{
  var cb = this.async();

  // have Yeoman greet the user
  // console.log(this.yeoman);
  console.log('\nI welcome you to the ' + 'Phalcon project generator'.bold + '.\n\n' +
      'I will create a new ' + 'Phalcon multi module application'.yellow + '\n' +
      'Please answer some questions first:\n'
  );
  
  var prompts = [
    {
      type: 'input',
      name: 'projectName',
      message: 'How would you like to call the new Project?',
      validate: function (input) {
        if (!input) {
          return 'I think your ' + 'project'.red + ' deserves an awesome ' + 'name'.red + '!';
        }
        return true;
      }
    },

    {
      type: 'input',
      name: 'moduleName',
      message: 'How would you like to name the main module?',
      validate: function (input) {
        if (!input) {
          return 'Please specify a valid ' + 'module name'.red + ' - this is not too difficult since it may be any string ...';
        }
        return true;
      }
    }
  ];

  this.prompt(prompts, function (props) {
    this.project = this.getProjectObject(props.projectName);
    this.module = this.getModuleObject(props.moduleName);
    cb();
  }.bind(this));
};

PhalconGenerator.prototype.app = function app()
{
  this.publicDirs();
  this.privateDirs();
  
  /* copy .htaccess file as template */
  this.template('phalcon/.htaccess', '.htaccess');
  
  /* build related files */
  this.copy('_package.json', 'package.json');
  this.copy('_bower.json', 'bower.json');
};

/*
 * Create public directory structure
 */
PhalconGenerator.prototype.publicDirs = function publicDirs()
{
  var dir = 'public';
  this.mkdir(dir);
  this.mkdir(dir + '/assets');
  this.mkdir(dir + '/common');
  this.mkdir(dir + '/styles');
  this.directory('phalcon/public', dir);
};

/*
 * Create private directory structure
 */
PhalconGenerator.prototype.privateDirs = function privateDirs()
{
  var dir = 'private';
  this.mkdir(dir);
  this.directory('phalcon/private', dir);
};

PhalconGenerator.prototype.projectfiles = function projectfiles()
{
  this.copy('editorconfig', '.editorconfig');
  this.copy('jshintrc', '.jshintrc');
};

PhalconGenerator.prototype.getModuleObject = function getModuleObject(moduleName)
{
  return {
    name: moduleName,
    namespace: this._.camelize(this._.capitalize(moduleName)),
    slug: this._.slugify(moduleName),
    camelCase: this._.camelize(moduleName),
    viewsDir: "__DIR__ . '/../../../public/src/app/" + this._.slugify(moduleName) + "/views/'"
  };
};

PhalconGenerator.prototype.getProjectObject = function getProjectObject(projectName)
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
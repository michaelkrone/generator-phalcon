'use strict';

var util = require('util');
var path = require('path');
var colors = require('colors');
var yeoman = require('yeoman-generator');

var PhalconGenerator = module.exports = function PhalconGenerator(args, options, config) {
  yeoman.generators.Base.apply(this, arguments);

  this.on('end', function () {
    this.installDependencies({ skipInstall: options['skip-install'] });
    console.log(
      'Please make sure this project is located in the ' +
      (this.project.slug).yellow.bold +
      ' directory under your webserver root!'
    );
  });
 
  this.pkg = JSON.parse(this.readFileAsString(path.join(__dirname, '../package.json')));
};

util.inherits(PhalconGenerator, yeoman.generators.Base);

PhalconGenerator.prototype.askFor = function askFor()
{
  var cb = this.async();
  var you = ' you ';

  // have Yeoman greet the user
  // console.log(this.yeoman);
  console.log('\nI welcome his dudeness to the ' + 'Phalcon project generator'.bold + '.\n\n' +
      'I will create a new ' + 'Phalcon multi module application'.yellow + '\n' +
      'Please answer some questions first:\n'
  );
  
  var prompts = [
    {
      type: 'input',
      name: 'projectName',
      message: 'How would' + you + 'like to call the new Project?',
      validate: function (input) {
        if (!input) {
          return 'I think your ' +
            'project'.red +
            ' deserves an awesome ' + 'name'.red + '!';
        }
        return true;
      }
    },

    {
      type: 'input',
      name: 'moduleName',
      message: 'How would' + you + 'like to name the main module?',
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
    this.project = {
        name: props.projectName,
        namespace: this._.camelize(this._.capitalize(props.projectName)),
        slug: this._.slugify(props.projectName),
        camelCase: this._.camelize(props.projectName),
        rewritePath: '/' + this._.slugify(props.projectName) + '/'
    };

    this.module = {
        name: props.moduleName,
        namespace: this._.camelize(this._.capitalize(props.moduleName)),
        slug: this._.slugify(props.moduleName),
        camelCase: this._.camelize(props.moduleName),
        viewsDir: "__DIR__ . '/../../../public/src/app/" + this._.slugify(props.moduleName) + "/views/'"
    };

    cb();
  }.bind(this));
};

PhalconGenerator.prototype.app = function app()
{
  this.publicDirs();
  this.privateDirs();
  this.moduleFiles();

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

/*
 * Create module directory structure and module specific files,
 * copy the view files to the public resources
 */
PhalconGenerator.prototype.moduleFiles = function moduleFiles()
{
  var dir = 'private/modules/' + this.module.slug;
  this.mkdir(dir);
  this.directory('phalcon/modules/module', dir);

  /* copy the views dir to public resources */
  dir = 'public/src/app/' + this.module.slug + '/views';
  this.mkdir(dir);
  this.directory('phalcon/modules/views', dir);
};

PhalconGenerator.prototype.projectfiles = function projectfiles()
{
  this.copy('editorconfig', '.editorconfig');
  this.copy('jshintrc', '.jshintrc');
};

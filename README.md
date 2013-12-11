# generator-phalcon 

A generator for [Yeoman](http://yeoman.io). Let Yeoman generate a multi module [Phalcon PHP Framework](http://phalconphp.com) application.


## Getting Started

Since this is a Yeoman generator you have to install it/him first:

```
$ npm install -g yo
```

### Phalcon Generator

To install generator-phalcon from npm, run:

```
$ npm install -g generator-phalcon
```

Finally, initiate the generator:

```
$ yo phalcon
```

You will be asked some questions about your application. Finally you have a working multi-module application set up:

```
I welcome you to the Phalcon project generator.
                                                                                                   
I will create a new Phalcon multi module application
Please answer some questions first:
                                                                                                   
[?] How would you like to call the new Project? (Enter the global namespace of the project, eg. MyApplication)
[?] How would you like to name the main module? (Enter the namespace of the default module, eg. MyMainModule)
                                                                                                   
```

### Module Subgenerator

If you would like to add another module to your project, just issue the module subgenerator like this:

```
$ yo phalcon:module
```

This will kickstart the module generator which will include a new module in your project. This works for every project created by the generator-phalcon generator.

The subgenerator will ask you about the project namespace and the namespace of the new module:

```
I will create a new Phalcon module for your application.
                                                                                                   
Please answer these simple questions:
                                                                                                   
[?] What is the namespace of the project this module should belong to? (Enter the global namespace of the project, eg. MyApplication) 
[?] How would you like to name your module? (Enter the namespace of your new module, eg. MyNewModule)
```

### About the generated project

As every Yeoman generator, this generator is opinionated about how you should manage your application, be it directory structure, class inheritance or every other detail of your application.
As Phalcon is a very flexible framework feel free to adjust the project to your needs.
The project generated with the generator-phalcon generator will have the following structure:
```
.
├── .htaccess
└── private
   └── common
      ├── lib
      └── application
         └── controllers
            ├── ApplicationApiController.php
            └── ApplicationController.php
         └── interfaces
            ├── ApplicationModule.php
            ├── ConfigurationInitable.php
            └── CustomerConfigurationInitable.php
         └── models
            └── ApplicationModel.php
         └── router
            └── ApplicationRouter.php
         └── Application.php
   └── config
   └── modules
      └── modulename
         └── config
            └── config.php
         └── controllers
            ├── api
            ├── ModuleApiController.php
            └── ModuleController.php
         ├── lib
         └── models
            └── ModuleModel.php
         ├── test
         ├── Module.php
         └── ModuleRoutes.php         
└── public
   ├── .htaccess
   ├── assets
   ├── common
   ├── styles
   └── src
      └── app
         └── layouts
            └── index.html
         └── modules
            └── modulename
               └── views
                  └── index
                     └── index.html
         └── partials
            └── index.html

```

### Todo

   * Subgenerators for models, controllers, maybe routes
   * Automatically generate tests
   * Documentation

### Getting To Know Yeoman

Yeoman has a heart of gold. He's a person with feelings and opinions, but he's very easy to work with. If you think he's too opinionated, he can be easily convinced.

If you'd like to get to know Yeoman better and meet some of his friends, [Grunt](http://gruntjs.com) and [Bower](http://bower.io), check out the complete [Getting Started Guide](https://github.com/yeoman/yeoman/wiki/Getting-Started).


## License

[MIT License](http://en.wikipedia.org/wiki/MIT_License)

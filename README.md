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

### Controller Subgenerator

If you would like to add another controller to your project, just issue the module subgenerator like this:

```
$ yo phalcon:controller
```

This will kickstart the module generator which will include a new module in your project. This works for every project created by the generator-phalcon generator.

The subgenerator will ask you about the project namespace and the namespace of the new module:

```
I will create a new Phalcon controller for your application.

Please answer these simple questions:

[?] What is the namespace of the project this controller should belong to? (Enter the global namespace of the project, eg. MyApplication)
[?] How is the namespace of the module your controller should belong to? (Enter the namespace of your new module, eg. MyNewModule)
[?] What is the name of your controller (Without "Controller" suffix)? (Enter the simple controller name, eg. Auth)

```

### About the generated project

As every Yeoman generator, this generator is opinionated about how you should manage your application, be it directory structure, class inheritance or every other detail of your application.
As Phalcon is a very flexible framework feel free to adjust the project to your needs.
The project generated with the generator-phalcon generator will have the following structure:
```
.
├── bower.json
├── composer.json
├── package.json
├── private
│   ├── common
│   │   └── lib
│   │       └── application
│   │           ├── ApplicationModule.php
│   │           ├── Application.php
│   │           ├── controllers
│   │           │   ├── ApplicationApiController.php
│   │           │   └── ApplicationController.php
│   │           ├── models
│   │           │   └── ApplicationModel.php
│   │           ├── RoutedModule.php
│   │           └── router
│   │               └── ApplicationRouter.php
│   ├── config
│   │   ├── config.php
│   │   └── modules.php
│   ├── modules
│   │   └── main
│   │       ├── config
│   │       │   └── config.php
│   │       ├── controllers
│   │       │   ├── api
│   │       │   │   └── IndexController.php
│   │       │   ├── ModuleApiController.php
│   │       │   └── ModuleController.php
│   │       ├── lib
│   │       ├── models
│   │       │   └── ModuleModel.php
│   │       ├── Module.php
│   │       └── ModuleRoutes.php
│   └── test
│       ├── application
│       │   ├── ApplicationTest.php
│       │   └── phpunit.xml
│       ├── helpers
│       │   ├── TestHelper.php
│       │   └── UnitTestCase.php
│       ├── modules
│       │   └── main
│       │       ├── helpers
│       │       │   ├── ModuleTestHelper.php
│       │       │   └── ModuleUnitTestCase.php
│       │       ├── IndexTest.php
│       │       ├── ModuleTest.php
│       │       └── phpunit.xml
│       └── phalcon
│           ├── FunctionalTestCase.php
│           ├── ModelTestCase.php
│           └── UnitTestCase.php
└── public
    ├── assets
    ├── common
    ├── index.php
    ├── src
    │   └── app
    │       ├── layouts
    │       │   └── main.html
    │       ├── modules
    │       │   └── main
    │       │       └── views
    │       │           └── index
    │       │               └── index.html
    │       └── partials
    │           └── index.html
    └── styles

```

### Todo

   * Documentation
   * Subgenerators for models, routes

### Getting To Know Yeoman

Yeoman has a heart of gold. He's a person with feelings and opinions, but he's very easy to work with. If you think he's too opinionated, he can be easily convinced.

If you'd like to get to know Yeoman better and meet some of his friends, [Grunt](http://gruntjs.com) and [Bower](http://bower.io), check out the complete [Getting Started Guide](https://github.com/yeoman/yeoman/wiki/Getting-Started).


## License

[MIT License](http://en.wikipedia.org/wiki/MIT_License)

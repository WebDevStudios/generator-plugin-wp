'use strict';
var base = require('../plugin-wp-base');
var chalk = require('chalk');
var yosay = require('yosay');
var fs = require('fs');
var request = require( 'request' );
var child_process = require('child_process');


module.exports = base.extend({

  constructor: function () {

    base.apply(this, arguments);

    this.option('do-install', {
      type: Boolean,
      required: false,
      desc: 'Automatically install dependecies'
    });

    this.option('php52', {
      type: Boolean,
      required: false,
      desc: 'Include PHP 5.2 support'
    });
  },

  initializing: function () {

    // Grab package.json.
    this.pkg = require('../package.json');

    // Set the initial value.
    this.currentVersionWP = '4.7.2';

    // Get the latest WP version.
    this.getLatestWPVersion();

    // Set Composer to false.
    this.autoloaderList = ['Basic', 'None'];

    // Check and see if Composer is available.
    this.checkComposerStatus();

    // Get the plugin gen version.
    var pjson = require( '../package.json' );
    this.plugingenversion = pjson.version;

  },

  prompting: function () {
    var done = this.async();

    // Have Yeoman greet the user.
    this.log(yosay(
      'Welcome to the neat ' + chalk.red('Plugin WP') + ' generator!'
    ));

    // Set up all our prompts.
    var prompts = [{
      type   : 'input',
      name   : 'name',
      message: 'Name',
      default: 'WDS Client Plugin Name'
    }, {
      type   : 'input',
      name   : 'homepage',
      message: 'Homepage',
      default: 'https://webdevstudios.com',
      store: true
    }, {
      type   : 'input',
      name   : 'description',
      message: 'Description',
      default: 'A radical new plugin for WordPress!'
    }, {
      type   : 'input',
      name   : 'version',
      message: 'Version',
      default: '0.0.0'
    }, {
      type   : 'input',
      name   : 'author',
      message: 'Author',
      default: 'WebDevStudios',
      save   : true,
      store: true
    }, {
      type   : 'input',
      name   : 'authoremail',
      message: 'Author Email',
      default: 'contact@webdevstudios.com',
      save   : true,
      store: true
    }, {
      type   : 'input',
      name   : 'authorurl',
      message: 'Author URL',
      default: 'https://webdevstudios.com',
      save   : true,
      store: true
    }, {
      type   : 'input',
      name   : 'license',
      message: 'License',
      default: 'GPLv2',
      store: true
    }, {
      type   : 'input',
      name   : 'slug',
      message: 'Plugin Slug',
      default: function( p ) {
        return this._.slugify( p.name );
      }.bind(this)
    }, {
      type   : 'input',
      name   : 'classname',
      message: 'Plugin Class Name',
      default: function( p ) {
        return this._wpClassify( p.name );
      }.bind(this)
    }, {
      type   : 'input',
      name   : 'prefix',
      message: 'Plugin Prefix',
      default: function( p ) {
        return this._.underscored( this._.slugify( p.slug ) );
      }.bind(this)
    }, {
      type   : 'list',
      name   : 'autoloader',
      message: 'Use Autoloader',
      choices: this.autoloaderList,
      store: true
    }];

     // Sanitize inputs.
    this.prompt(prompts, function (props) {
      this.name               = this._.clean( props.name );
      this.homepage           = this._.clean( props.homepage );
      this.description        = this._.clean( props.description );
      this.descriptionEscaped = this._escapeDoubleQuotes( this.description );
      this.version            = this._.clean( props.version );
      this.author             = this._.clean( props.author );
      this.authoremail        = this._.clean( props.authoremail );
      this.authorurl          = this._.clean( props.authorurl );
      this.license            = this._.clean( props.license );
      this.slug               = this._.slugify( props.slug );
      this.classname          = this._wpClassify( props.classname );
      this.mainclassname      = this.classname;
      this.classprefix        = this._wpClassPrefix( this.classname );
      this.prefix             = this._.underscored( props.prefix );
      this.year               = new Date().getFullYear();
      this.autoloader         = props.autoloader;
      this.php52              = this.options.php52;

      // All done.
      done();
    }.bind(this));
  },

  writing: {

    folder: function() {
      var done = this.async();

      // Grab our destination path folder.
      fs.lstat( this.destinationPath( this.slug ), function(err, stats) {

        // If its not an error, but it exists, flag that to the user.
        if (!err && stats.isDirectory()) {
          this.log( chalk.red( 'A plugin already exists with this folder name, exiting...' ) );
          process.exit();
        }

        // Set our destination to our slug.
        this.destinationRoot( this.slug );

        // Done.
        done();
      }.bind(this));
    },

    dotfiles: function() {
      this.fs.copy(
        this.templatePath('_bowerrc'),
        this.destinationPath('/.bowerrc')
      );
      this.fs.copyTpl(
        this.templatePath('_gitignore'),
        this.destinationPath('/.gitignore'),
        this
      );
      this.fs.copyTpl(
          this.templatePath('_sass-lint.yml'),
          this.destinationPath('/.sass-lint.yml'),
          this
      );
      this.fs.copyTpl(
          this.templatePath('_eslintrc.js'),
          this.destinationPath('/.eslintrc.js'),
          this
      );
      this.fs.copyTpl(
          this.templatePath('_editorconfig'),
          this.destinationPath('/.editorconfig'),
          this
      );
    },

    configs: function() {
      this.fs.copyTpl(
        this.templatePath('bower.json'),
        this.destinationPath('/bower.json'),
        this
      );
      this.fs.copyTpl(
        this.templatePath('package.json'),
        this.destinationPath('/package.json'),
        this
      );
      if ( this.autoloader === 'Composer' ) {
        this.fs.copyTpl(
          this.templatePath('composer.json'),
          this.destinationPath('/composer.json'),
          this
        );
      }
      this.fs.copy(
        this.templatePath('Gruntfile.js'),
        this.destinationPath('/Gruntfile.js')
      );
      this.fs.copy(
          this.templatePath('Gulpfile.js'),
          this.destinationPath('/Gulpfile.js')
      );
      this.fs.copy(
          this.templatePath('phpcs.xml'),
          this.destinationPath('/phpcs.xml')
      );
    },

    php: function() {
      this.fs.copyTpl(
        this.templatePath('plugin.php'),
        this.destinationPath('/' + this.slug + '.php'),
        this
      );
    },

    readme: function() {
      this.fs.copyTpl(
        this.templatePath('README.md'),
        this.destinationPath('/README.md'),
        this
      );
    },

    tests: function() {
      this.fs.copy(
        this.templatePath('phpunit.xml'),
        this.destinationPath('/phpunit.xml'),
        this
      );

      this.fs.copy(
        this.templatePath('.travis.yml'),
        this.destinationPath('/.travis.yml'),
        this
      );

      this.fs.copy(
        this.templatePath('Dockunit.json'),
        this.destinationPath('/Dockunit.json'),
        this
      );

      this.fs.copy(
        this.templatePath('bin/install-wp-tests.sh'),
        this.destinationPath('bin/install-wp-tests.sh'),
        this
      );


      this.fs.copyTpl(
        this.templatePath('tests/bootstrap.php'),
        this.destinationPath('tests/bootstrap.php'),
        this
      );

      this.fs.copyTpl(
        this.templatePath('tests/test-base.php'),
        this.destinationPath('tests/test-base.php'),
        this
      );
    },

    folders: function() {
      this.fs.copyTpl(
        this.templatePath('assets/README.md'),
        this.destinationPath('assets/README.md'),
        this
      );

      this.fs.copyTpl(
        this.templatePath('assets/repo/README.md'),
        this.destinationPath('assets/repo/README.md'),
        this
      );

      this.fs.copyTpl(
        this.templatePath('includes/README.md'),
        this.destinationPath('includes/README.md'),
        this
      );
    },

    saveConfig: function() {
      this.config.set( 'name', this.name );
      this.config.set( 'homepage', this.homepage );
      this.config.set( 'description', this.description );
      this.config.set( 'version', this.version );
      this.config.set( 'author', this.author );
      this.config.set( 'authoremail', this.authoremail );
      this.config.set( 'authorurl', this.authorurl );
      this.config.set( 'license', this.license );
      this.config.set( 'slug', this.slug );
      this.config.set( 'classname', this.classname );
      this.config.set( 'mainclassname', this.classname );
      this.config.set( 'classprefix', this.classprefix );
      this.config.set( 'prefix', this.prefix );
      this.config.set( 'year', this.year );

      this.config.set( 'currentVersionWP', this.currentVersionWP );

      this.config.set( 'plugingenversion', this.plugingenversion );

      this.config.save();
    }
  },

  checkComposerStatus: function() {
    var composerResult = child_process.spawnSync('composer',['--version', '--no-ansi']);

    if ( 0 === composerResult.status) {
      this.autoloaderList = ['Basic', 'Composer', 'None'];
    }

  },

  getLatestWPVersion: function() {
    request.get({
      url: 'https://api.wordpress.org/core/version-check/1.7/',
      json: true,
      headers: { 'User-Agent': 'request' }
    }, function (err, res, data) {
      // Check for status code.
      if ( ! err && ( 200 === res.statusCode ) ) {
        // Loop through results to find only the "upgrade" version
        for ( var i in data.offers ) {
          if ( 'upgrade' === data.offers[i].response ) {
            this.currentVersionWP = data.offers[i].current;
          }
        }
      }
    });
  },

  install: function () {

    // If we flagged we want an install, install our dependecies.
    if ( this.options['do-install'] ) {
      this.installDependencies();

      // If we're loading Composer, run a composer install.
      if ( this.autoloader === 'Composer' ) {
        this.spawnCommand('composer', ['install']);
      }
    }
  }
});

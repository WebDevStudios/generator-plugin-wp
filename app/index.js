'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');

module.exports = yeoman.generators.Base.extend({
  initializing: function () {
    this.pkg = require('../package.json');
  },

  _wpClassify: function( s ) {
    var words  = this._.words( s ),
        result = '';

    for ( var i = 0; i < words.length; i += 1 ) {
      result += this._.capitalize( words[i] );
      if ( (i + 1) < words.length ) {
        result += '_';
      }
    }

    return result;
  },

  prompting: function () {
    var done = this.async();

    // Have Yeoman greet the user.
    this.log(yosay(
      'Welcome to the neat ' + chalk.red('Plugin WP') + ' generator!'
    ));

    var prompts = [{
      type: 'input',
      name: 'name',
      message: 'Name',
      default: 'WDS Client Plugin Name'
    }, {
      type: 'input',
      name: 'homepage',
      message: 'Homepage',
      default: 'http://webdevstudios.com'
    }, {
      type: 'input',
      name: 'description',
      message: 'Description',
      default: 'A radical new plugin for WordPress!'
    }, {
      type: 'input',
      name: 'version',
      message: 'Version',
      default: '0.1.0'
    }, {
      type: 'input',
      name: 'author',
      message: 'Author',
      default: 'WebDevStudios',
      save: true
    }, {
      type: 'input',
      name: 'authoremail',
      message: 'Author Email',
      default: 'contact@webdevstudios.com',
      save: true
    }, {
      type: 'input',
      name: 'authorurl',
      message: 'Author URL',
      default: 'http://webdevstudios.com',
      save: true
    }, {
      type: 'input',
      name: 'license',
      message: 'License',
      default: 'GPLv2'
    }, {
      type: 'input',
      name: 'slug',
      message: 'Plugin Slug',
      default: function( prompts ) {
        return this._.slugify( prompts.name );
      }.bind(this)
    }, {
      type: 'input',
      name: 'classname',
      message: 'Plugin Class Name',
      default: function( prompts ) {
        return this._wpClassify( prompts.name );
      }.bind(this)
    }, {
      type: 'input',
      name: 'prefix',
      message: 'Plugin Prefix',
      default: function( prompts ) {
        return this._.underscored( prompts.name );
      }.bind(this)
    }];

    this.prompt(prompts, function (props) {
      // Sanitize inputs
      this.name        = this._.titleize( props.name );
      this.homepage    = this._.clean( props.homepage );
      this.description = this._.clean( props.description );
      this.version     = this._.clean( props.version );
      this.author      = this._.clean( props.author );
      this.authoremail = this._.clean( props.authoremail );
      this.authorurl   = this._.clean( props.authorurl );
      this.license     = this._.clean( props.license );
      this.slug        = this._.slugify( props.slug );
      this.classname   = this._wpClassify( props.classname );
      this.prefix      = this._.underscored( props.prefix );
      this.year        = new Date().getFullYear();

      done();
    }.bind(this));
  },

  writing: {
    folder: function() {
      this.destinationRoot( this.slug );
    },

    dotfiles: function() {
      this.fs.copy(
        this.templatePath('_bowerrc'),
        this.destinationPath( '/.bowerrc' )
      );
      this.fs.copy(
        this.templatePath('_gitignore'),
        this.destinationPath( '/.gitignore' )
      );
    },

    configs: function() {
      this.fs.copyTpl(
        this.templatePath('*.json'),
        this.destinationPath( '/'),
        this
      );
      this.fs.copy(
        this.templatePath('Gruntfile.js'),
        this.destinationPath( '/Gruntfile.js')
      );
    },

    php: function() {
      this.fs.copyTpl(
        this.templatePath('plugin.php'),
        this.destinationPath( '/' + this.slug + '.php'),
        this
      );
    },

    readmes: function() {
      this.fs.copyTpl(
        this.templatePath('README.md'),
        this.destinationPath( '/README.md'),
        this
      );

      this.fs.copyTpl(
        this.templatePath('readme.txt'),
        this.destinationPath( '/readme.txt'),
        this
      );
    },

    folders: function() {
      this.fs.copyTpl(
        this.templatePath('assets/README.md'),
        this.destinationPath( 'assets/README.md'),
        this
      );

      this.fs.copyTpl(
        this.templatePath('includes/README.md'),
        this.destinationPath( 'includes/README.md'),
        this
      );
    }
  },

  install: function () {
    this.installDependencies({
      skipInstall: this.options['skip-install']
    });

    this.spawnCommand('composer', ['install']);
  }
});

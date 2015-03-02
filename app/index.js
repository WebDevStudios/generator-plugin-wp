'use strict';
var yeoman = require('yeoman-generator');
var chalk = require('chalk');
var yosay = require('yosay');

module.exports = yeoman.generators.Base.extend({
  initializing: function () {
    this.pkg = require('../package.json');
  },

  prompting: function () {
    var done = this.async();

    // Have Yeoman greet the user.
    this.log(yosay(
      'Welcome to the neat' + chalk.red('Plugin WP') + ' generator!'
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
      default: 'WebDevStudios'
    }, {
      type: 'input',
      name: 'authorurl',
      message: 'Author URL',
      default: 'http://webdevstudios.com'
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
        return this._.classify( prompts.name );
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
      this.authorurl   = this._.clean( props.authorurl );
      this.license     = this._.clean( props.license );
      this.slug        = this._.slugify( props.slug );
      this.classname   = this._.classify( props.classname );
      this.prefix      = this._.underscored( props.prefix );

      done();
    }.bind(this));
  },

  writing: {
    dotfiles: function() {
      this.fs.copy(
        this.templatePath('_bowerrc'),
        this.destinationPath( this.slug + '/.bowerrc' )
      );
      this.fs.copy(
        this.templatePath('_gitignore'),
        this.destinationPath( this.slug + '/.gitignore' )
      );
    },

    configs: function() {
      this.fs.copyTpl(
        this.templatePath('*.json'),
        this.destinationPath( this.slug + '/'),
        this
      );
      this.fs.copyTpl(
        this.templatePath('Gruntfile.js'),
        this.destinationPath( this.slug + '/Gruntfile.js'),
        this
      );
    },

    php: function() {
      this.fs.copyTpl(
        this.templatePath('plugin.php'),
        this.destinationPath( this.slug + '/' + this.slug + '.php'),
        this
      );
    },

    readmes: function() {
      this.fs.copyTpl(
        this.templatePath('README.md'),
        this.destinationPath( this.slug + '/README.md'),
        this
      );

      this.fs.copyTpl(
        this.templatePath('readme.txt'),
        this.destinationPath( this.slug + '/readme.txt'),
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

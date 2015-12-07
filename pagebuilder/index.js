'use strict';
var yeoman = require('yeoman-generator');
var base = require('../plugin-wp-base');
var ghdownload = require('github-download');

module.exports = base.extend({
  constructor: function () {
    base.apply(this, arguments);

    this.argument('name', {
      required: false,
      type    : String,
      desc    : 'The page builder include class name'
    });

    this.option('partsdir', {
      desc    : 'Directory to place parts in',
      type    : String,
      defaults: 'includes/parts'
    });
  },

  initializing: {
    intro: function () {
      // Have Yeoman greet the user.
      this.log('Welcome to the neat Plugin WP WDS Simple Page Builder subgenerator!');
    },

    readingYORC: function() {
      this.rc = this.config.getAll() || {};
    },

    readingPackage: function() {
      this.pkg = this.fs.readJSON( this.destinationPath('package.json')) || {};
    },

    settingValues: function() {
      this.composer   = this.fs.exists('composer.json');
      this.version    = this.pkg.version;

      if ( this.name ) {
        this.name     = this._.titleize( this.name.split('-').join(' ') );
        this.nameslug     = this._.slugify( this.name );
      }
      this.slug       = this.rc.slug;

      this.pluginname = this.rc.name;
      this.classname  = this.rc.classprefix + this._wpClassify( this.name );
      this.prefix     = this.rc.prefix;

      this.composer   = this.fs.exists('composer.json');

      this.partsdir = this.options.partsdir;
    }
  },

  prompting: function () {
    var done = this.async();

    var prompts = [];

    if ( !this.version ) {
      prompts.push({
        type   : 'input',
        name   : 'version',
        message: 'Version',
        default: '0.1.0'
      });
    }

    if ( !this.name ) {
      prompts.push({
        type   : 'input',
        name   : 'name',
        message: 'Include Name',
        default: 'pagebuilder'
      });
    }

    if ( !this.pluginname ) {
      prompts.push({
        type   : 'input',
        name   : 'pluginname',
        message: 'Plugin Name',
        default: 'WDS Client Plugin'
      });
    }

    if ( prompts.length > 0 ) {
      this.log( 'Missing some info about the original plugin, help me out?' );
      this.prompt(prompts, function (props) {
        if ( props.version ) {
          this.version = props.version;
        }

        if ( props.name ) {
          this.name     = this._.titleize( props.name );
          this.nameslug     = this._.slugify( this.name );
        }

        if ( props.pluginname ) {
          this.pluginname  = props.pluginname;
          this.slug = this._.slugify( props.pluginname );
        }

        done();
      }.bind(this));
    } else {
      done();
    }
  },

  writing: function () {
    this.fs.copyTpl(
      this.templatePath('class-pagebuilder.php'),
      this.destinationPath('includes/class-' + this._.slugify( this.name ) + '.php'),
      this
    );

    if ( !this.rc.notests ) {
      this.fs.copyTpl(
        this.templatePath('tests.php'),
        this.destinationPath('tests/test-' + this._.slugify( this.name ) + '.php'),
        this
      );
    }

    this._addIncludeClass( this._.slugify( this.name ), this.classname );
  },

  install: function () {
    if ( this.options['skip-install'] ) {
      return;
    }
  }
});

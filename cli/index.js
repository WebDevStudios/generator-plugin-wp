'use strict';
var yeoman = require('yeoman-generator');
var base = require('../plugin-wp-base');

module.exports = base.extend({
  constructor: function () {
    base.apply(this, arguments);

    this.argument('name', {
      required: false,
      type    : String,
      desc    : 'The include name'
    });
  },

  initializing: {
    intro: function () {
      // Have Yeoman greet the user.
      this.log('Welcome to the neat Plugin WP Include subgenerator!');
    },

    readingYORC: function() {
      this.rc = this.config.getAll() || {};
    },

    readingPackage: function() {
      this.pkg = this.fs.readJSON( this.destinationPath('package.json')) || {};
    },

    settingValues: function() {
      this.version     = this.pkg.version;
      if ( this.name ) {
        this.name      = this._.titleize( this.name.split('-').join(' ') );
        this.nameslug      = this._.slugify( this.name );
      }
      this.pluginname  = this.rc.name;
      this.includename = this.pluginname + ' ' + this._.capitalize( this.name );
      this.classname   = this.rc.classprefix + this._wpClassify( this.name );

      // get the main classname
      this.mainclassname = this._wpClassify( this.pluginname );
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
        default: 'frontend'
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
          this.name = this._.titleize( props.name.split('-').join(' ') );
          this.nameslug = this._.slugify( this.name );
        }

        if ( props.pluginname ) {
          this.pluginname  = props.pluginname;
        }

        if ( props.name || props.pluginname ) {
          this.includename = this.pluginname + ' ' + this._.capitalize( this.name );
          this.classname   = this._wpClassPrefix( this.pluginname ) + this._wpClassify( this.name );
        }

        done();
      }.bind(this));
    } else {
      done();
    }
  },

  writing: function () {
    this.fs.copyTpl(
      this.templatePath('include.php'),
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
  }
});

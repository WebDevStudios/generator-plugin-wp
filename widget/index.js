'use strict';
var yeoman = require('yeoman-generator');
var base = require('../plugin-wp-base');

module.exports = base.extend({
  constructor: function () {
    yeoman.generators.Base.apply(this, arguments);

    this.argument('name', {
      required: false,
      type    : String,
      desc    : 'The widget name'
    });
  },

  initializing: {
    intro: function () {
      // Have Yeoman greet the user.
      this.log('Welcome to the neat Plugin WP Widget subgenerator!');
    },

    readingYORC: function() {
      this.rc = this.config.getAll() || {};
    },

    readingPackage: function() {
      this.pkg = this.fs.readJSON( this.destinationPath('package.json')) || {};
    },

    settingValues: function() {
      this.version      = this.pkg.version;
      if ( this.name ) {
        this.name       = this._.titleize( this.name.split('-').join(' ') );
      }
      this.pluginname   = this.rc.name;
      this.widgetname   = this.pluginname + ' ' + this._.capitalize( this.name );
      this.classname    = this.rc.classprefix + this._wpClassify( this.name );
      this.slug         = this.rc.slug;
      this.widgetslug   = this.slug + '-' + this._.slugify( this.name );
      this.widgetprefix = this._.underscored( this.slug + ' ' + this.name );
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
        message: 'Widget Name',
        default: 'basic-widget'
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
        }

        if ( props.pluginname ) {
          this.pluginname  = props.pluginname;
          this.slug        = this._.slugify( props.pluginname );
        }

        if ( props.name || props.pluginname ) {
          this.widgetname   = this.pluginname + ' ' + this._.capitalize( this.name );
          this.classname    = this._wpClassPrefix( this.pluginname ) + this._wpClassify( this.name );
          this.widgetslug   = this.slug + '-' + this._.slugify( this.name );
          this.widgetprefix = this._.underscored( this.slug + ' ' + this.name );
        }

        done();
      }.bind(this));
    } else {
      done();
    }
  },

  writing: function () {
    this.fs.copyTpl(
      this.templatePath('widget.php'),
      this.destinationPath('includes/' + this._.slugify( this.name ) + '.php'),
      this
    );
  }
});

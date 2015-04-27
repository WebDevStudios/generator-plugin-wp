'use strict';
var yeoman = require('yeoman-generator');

module.exports = yeoman.generators.Base.extend({
  constructor: function () {
    yeoman.generators.Base.apply(this, arguments);

    this.argument('name', {
      required: false,
      type: String,
      desc: 'The include name'
    });
  },

  initializing: {
    intro: function () {
      // Have Yeoman greet the user.
      this.log('Welcome to the neat Plugin WP Include subgenerator!');
    },

    readingYORC: function() {
      this.rc = this.config.getAll()
    },

    readingPackage: function() {
      this.pkg = this.fs.readJSON( this.destinationPath('package.json'));
    },

    settingValues: function() {
      this.version     = this.pkg.version;
      if ( this.name ) {
        this.name        = this._.titleize( this.name.replace('-', ' ') );
      }
      this.pluginname  = this.rc.name;
      this.includename = this.pluginname + ' ' + this._.capitalize( this.name );
      this.classname   = this.rc.classprefix + this._wpClassify( this.name );
    }
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

  _wpClassPrefix: function( s ) {
    var words = s.replace( /_/g, ' ' );
    var letters = words.replace(/[a-z]/g, '');
    var prefix = letters.replace(/\s/g, '');
    return prefix + '_';
  },

  prompting: function () {
    var done = this.async();

    var prompts = [];

    if ( ! this.version ) {
      prompts.push({
        type: 'input',
        name: 'version',
        message: 'Version',
        default: '0.1.0'
      });
    }

    if ( ! this.name ) {
      prompts.push({
        type: 'input',
        name: 'name',
        message: 'Include Name',
        default: 'frontend'
      });
    }

    if ( ! this.pluginname ) {
      prompts.push({
        type: 'input',
        name: 'pluginname',
        message: 'Plugin Name',
        default: 'WDS Client Plugin'
      });
    }

    if ( prompts.length > 0 ) {
      this.prompt(prompts, function (props) {
        if ( props.version ) {
          this.version = props.version;
        }

        if ( props.name ) {
          this.name = this._.titleize( props.name.replace('-', ' ') );
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
      this.destinationPath('includes/' + this._.slugify( this.name ) + '.php'),
      this
    );
  }
});

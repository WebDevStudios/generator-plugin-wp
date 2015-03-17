'use strict';
var yeoman = require('yeoman-generator');

module.exports = yeoman.generators.Base.extend({
  initializing: function () {
    this.argument('name', {
      required: true,
      type: String,
      desc: 'The include name'
    });

    this.log('You called the PluginWP subgenerator with the name ' + this.name + '.');
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

  configuring: {

    readingYORC: function() {
      this.rc = this.config.getAll()
    },

    readingPackage: function() {
      this.pkg = this.fs.readJSON( this.destinationPath('package.json'));
    },

    settingValues: function() {
      this.version     = this.pkg.version;
      this.name        = this._.titleize( this.name.replace('-', ' ') );
      this.includename = this.rc.name + ' ' + this._.capitalize( this.name );
      this.classname   = this.rc.classname + '_' + this._wpClassify( this.name );
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

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

  configuring: {

    readingYORC: function() {
      this.rc = this.config.getAll()
    },

    readingPackage: function() {
      this.pkg = this.fs.readJSON( this.destinationPath('package.json'));
    },

    settingValues: function() {
      this.version = this.pkg.version;
      this.includename = this.rc.name + ' ' + this._.capitalize( this.name );
      this.classname = this.rc.classname + '_' + this._.capitalize( this.name ).trim();
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

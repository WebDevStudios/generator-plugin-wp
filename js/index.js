'use strict';
var yeoman = require('yeoman-generator');
var path = require('path');

module.exports = yeoman.generators.Base.extend({
  initializing: function () {
    this.pkg = require('../package.json');
    this.rc = this.config.getAll()
  },

  prompting: function () {
    var done = this.async();

    // Have Yeoman greet the user.
    this.log('Welcome to the neat Plugin WP Javascript subgenerator!');

    var prompts = [{
      type: 'list',
      name: 'type',
      message: 'Javascript setup',
      choices: ['Browserify', 'Concat', 'Basic']
    }];

    this.prompt(prompts, function (props) {
      // Sanitize inputs
      this.type        = props.type;

      done();
    }.bind(this));
  },

  configuring: function() {

    if ( this.type === 'Basic' ) {
      this.gruntfile.insertConfig('jshint', "{all: ['assets/js/**/*.js','!**/*.min.js']}");
    } else {
      this.gruntfile.insertConfig('jshint', "{all: ['assets/js/components/**/*.js','!**/*.min.js']}");
    }
    this.gruntfile.registerTask('scripts', 'jshint');

    if ( this.type === 'Concat' ) {
      this.gruntfile.insertConfig('concat', "{dist: {files: {'assets/js/" + this.rc.slug + ".js': 'assets/js/components/**/*.js'}}}");

      this.gruntfile.registerTask('scripts', 'concat');
    }

    if ( this.type === 'Browserify' ) {
      this.gruntfile.insertConfig('browserify', "{dist: {files: {'assets/js/" + this.rc.slug + ".js': 'assets/js/components/main.js'}}}");

      this.gruntfile.registerTask('scripts', 'browserify');
    }
    this.gruntfile.insertConfig('uglify', "{dist: {files: {'assets/js/" + this.rc.slug + ".min.js': 'assets/js/" + this.rc.slug + ".js'}}}");
    this.gruntfile.registerTask('scripts', 'uglify');
  },

  writing: function () {
    var mainfile = 'assets/js/';

    if ( this.type !== 'Basic' ) {
      mainfile += 'components/main.js';
    } else {
      mainfile += this.slug + '.js';
    }

    this.fs.copyTpl(
      this.templatePath('main.js'),
      this.destinationPath(mainfile),
      this
    );
  },

  install: function () {
    if ( ! this.options['skip-install'] ) {
      this.npmInstall(['grunt-contrib-uglify'], { 'saveDev': true });
      this.npmInstall(['grunt-contrib-jshint'], { 'saveDev': true });

      if ( this.type === 'Concat' ) {
        this.npmInstall(['grunt-contrib-concat'], { 'saveDev': true });
      }

      if ( this.type === 'Browserify' ) {
        this.npmInstall(['grunt-browserify'], { 'saveDev': true });
      }
    }
  },
});

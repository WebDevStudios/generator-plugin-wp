'use strict';
var yeoman = require('yeoman-generator');
var base = require('../plugin-wp-base');
var updateNotifier = require('update-notifier');

module.exports = base.extend({
  initializing: function () {
    this.pkg = require('../package.json');
    this.rc = this.config.getAll();

    // Have Yeoman greet the user.
    this.log('Welcome to the neat Plugin WP Styles subgenerator!');
  },

  prompting: function () {
    var done = this.async();

    var prompts = [{
      type: 'list',
      name: 'type',
      message: 'Style setup',
      choices: ['SASS', 'Basic']
    }];

    this.prompt(prompts, function (props) {
      // Sanitize inputs
      this.type        = props.type;

      done();
    }.bind(this));
  },

  configuring: function() {
    if ( ! this.fs.exists( 'Gruntfile.js') ){
      this.log( 'No Gruntfile.js found, no Grunt tasks added.' );
      return;
    }

    if ( this.type === 'SASS' ) {
      this.gruntfile.insertConfig('sass', "{dist: {options: {style: 'expanded', lineNumbers: true}, files: {'assets/css/" + this.rc.slug + ".css': 'assets/css/sass/styles.scss'}}}");;
      this.gruntfile.registerTask('styles', 'sass');
    }

    this.gruntfile.insertConfig('cssmin', "{dist: {files: {'assets/css/" + this.rc.slug + ".min.css': 'assets/css/" + this.rc.slug + ".css'}}}");
    this.gruntfile.insertConfig('usebanner', "{ taskName: { options: { position: 'top', banner: bannerTemplate, linebreak: true }, files: { src: [ 'assets/css/" + this.rc.slug + ".min.css' ] } } }");

    this.gruntfile.registerTask('styles', 'cssmin');
    this.gruntfile.registerTask('styles', 'usebanner');
  },

  writing: function () {
    if ( this.type === 'SASS' ) {
      this.fs.copyTpl(
        this.templatePath('styles.css'),
        this.destinationPath('assets/css/sass/styles.scss'),
        this
      );
    } else {
      this.fs.copyTpl(
        this.templatePath('styles.css'),
        this.destinationPath('assets/css/' + this.rc.slug + '.css'),
        this
      );
    }
  },

  install: function () {
    if ( ! this.options['skip-install'] ) {
      if ( this.type === 'SASS' ) {
        this.npmInstall(['grunt-contrib-sass'], { 'saveDev': true });
      }
      this.npmInstall(['grunt-contrib-cssmin'], { 'saveDev': true });
      this.npmInstall(['grunt-banner'], { 'saveDev': true });
    }
  }
});

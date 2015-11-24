'use strict';
var base = require('../plugin-wp-base');

module.exports = base.extend({
  initializing: function () {
    this.pkg = require('../package.json');
    this.rc = this.config.getAll();

    // Have Yeoman greet the user.
    this.log('Welcome to the neat Plugin WP Javascript subgenerator!');
  },

  prompting: function () {
    var done = this.async();

    var prompts = [{
      type: 'list',
      name: 'type',
      message: 'Javascript setup',
      choices: ['Browserify', 'Concat', 'Basic']
    }];

    this.prompt(prompts, function (props) {
      // Sanitize inputs
      this.type = props.type;

      done();
    }.bind(this));
  },

  configuring: function() {
    if ( !this.fs.exists( 'Gruntfile.js') ){
      this.log( 'No Gruntfile.js found, no Grunt tasks added.' );
      return;
    }

    if ( this.type === 'Basic' ) {
      this.gruntfile.insertConfig('jshint', "{all: ['assets/js/**/*.js','!**/*.min.js'], options: { browser: true, predef: [ 'document', 'window', 'jQuery', '" + this.classname + "' ] } }");
    } else {
      this.gruntfile.insertConfig('jshint', "{all: ['assets/js/components/**/*.js','!**/*.min.js'], options: { browser: true, esnext: true, predef: [ 'document', 'window', 'jQuery', 'require', '" + this.classname + "' ] } }");
    }
    this.gruntfile.registerTask('scripts', 'jshint');

    if ( this.type === 'Concat' ) {
      this.gruntfile.insertConfig('concat', "{options: { stripBanners: true, banner: bannerTemplate }, dist: {files: {'assets/js/" + this.rc.slug + ".js': 'assets/js/components/**/*.js'}}}");

      this.gruntfile.registerTask('scripts', 'concat');
    }

    if ( this.type === 'Browserify' ) {
      this.gruntfile.insertConfig('browserify', "{options: { stripBanners: true, banner: bannerTemplate, transform: [['babelify', { presets: ['es2015'] }], 'browserify-shim'] }, dist: { files: { 'assets/js/" + this.rc.slug + ".js': 'assets/js/components/main.js' } } }");
      this.gruntfile.registerTask('scripts', 'browserify');
    }

    this.gruntfile.insertConfig('uglify', "{dist: { files: { 'assets/js/" + this.rc.slug + ".min.js': 'assets/js/" + this.rc.slug + ".js' }, options: { banner: compactBannerTemplate } } }");
    this.gruntfile.registerTask('scripts', 'uglify');
  },

  writing: function () {
    var mainfile = 'assets/js/';

    if ( this.type !== 'Basic' ) {
      mainfile += 'components/main.js';
    } else {
      mainfile += this.rc.slug + '.js';
    }

    this.fs.copyTpl(
      this.templatePath('main.js'),
      this.destinationPath(mainfile),
      this
    );
  },

  install: function () {
    if ( !this.options['skip-install'] ) {
      this.npmInstall(['grunt-contrib-uglify'], { 'saveDev': true });
      this.npmInstall(['grunt-contrib-jshint'], { 'saveDev': true });

      if ( this.type === 'Concat' ) {
        this.npmInstall(['grunt-contrib-concat'], { 'saveDev': true });
      }

      if ( this.type === 'Browserify' ) {
        this.npmInstall(['grunt-browserify'], { 'saveDev': true });
        this.npmInstall(['browserify-shim'], { 'saveDev': true });
        this.npmInstall(['babelify'], { 'saveDev': true });
        this.npmInstall(['babel-preset-es2015'], { 'saveDev': true });

        var pack = this.fs.readJSON( 'package.json' );
        pack['browserify-shim'] = {
          'jquery': 'global:jQuery'
        };
        this.fs.writeJSON( 'package.json', pack );
      }
    }
  }
});

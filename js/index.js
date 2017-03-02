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

      this.jsclassname = this.rc.classname.replace( /\_/gi, '' );

      done();
    }.bind(this));
  },

  configuring: function() {
    if ( !this.fs.exists( 'Gruntfile.js') ){
      this.log( 'No Gruntfile.js found, no Grunt tasks added.' );
      return;
    }

    if ( this.type === 'Basic' ) {
      this.gruntfile.insertConfig('eslint', "{src: ['assets/js/**/*.js','!**/*.min.js'] }");
    } else {
      this.gruntfile.insertConfig('eslint', "{src: ['assets/js/components/**/*.js','!**/*.min.js'] }");
    }
    this.gruntfile.loadNpmTasks('gruntify-eslint');
    this.gruntfile.registerTask('scripts', 'eslint');

    if ( this.type === 'Concat' ) {
      this.gruntfile.insertConfig('concat', "{options: { stripBanners: true, banner: bannerTemplate }, dist: {files: {'assets/js/" + this.rc.slug + ".js': 'assets/js/components/**/*.js'}}}");

      this.gruntfile.registerTask('scripts', 'concat');
    }

    if ( this.type === 'Browserify' ) {
      this.gruntfile.insertConfig('browserify', "{options: { stripBanners: true, banner: bannerTemplate, transform: [['babelify', { presets: ['es2015'] }], ['browserify-shim', { global: true }]] }, dist: { files: { 'assets/js/" + this.rc.slug + ".js': 'assets/js/components/main.js' } } }");
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

    this.fs.copy(
      this.templatePath('_eslintrc.json'),
      this.destinationPath('.eslintrc.json')
    );
  },

  install: function () {
  }
});

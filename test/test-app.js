'use strict';

var path = require('path');
var assert = require('yeoman-generator').assert;
var helpers = require('yeoman-generator').test;
var os = require('os');

describe('plugin-wp:app', function () {
  before(function (done) {
    helpers.run(path.join(__dirname, '../app'))
      .inDir(path.join(os.tmpdir(), './temp-test'))
      .withOptions()
      .withPrompt({
        name: 'Test Plugin NAME'
      })
      .on('end', done);
  });

  it('creates files', function () {
    assert.file([
      'bower.json',
      'package.json',
      '.bowerrc',
      '.gitignore',
      'README.md',
      'test-plugin-name.php',
      'assets/css/style.css',
      'assets/js/index.js',
      'assets/README.md',
      'includes/README.md',
      'config/settings.js',
      'config/webpack.config.js'
    ]);
  });
});

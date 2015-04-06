'use strict';

var path = require('path');
var assert = require('yeoman-generator').assert;
var helpers = require('yeoman-generator').test;
var fs = require('fs-extra');
var os = require('os');

describe('PluginWp:js', function () {
  before(function (done) {
    helpers.run(path.join( __dirname, '../js'))
      .inDir(path.join(os.tmpdir(), './sub-js-test'), function (dir) {
        fs.copySync(path.join(__dirname, './test-assets/subgenerator-test-plugin'), dir);
      })
      .withOptions({ 'skip-install': true })
      .withPrompt({ type: 'Browserify' })
      .on('end', done);
  });

  it('creates files', function () {
    assert.file([
      'assets/js/components/main.js'
    ]);
  });
});

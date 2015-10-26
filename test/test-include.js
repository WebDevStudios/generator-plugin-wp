'use strict';

var path = require('path');
var assert = require('yeoman-generator').assert;
var helpers = require('yeoman-generator').test;
var fs = require('fs-extra');

describe('plugin-wp:include', function () {
  before(function (done) {
    helpers.run(path.join( __dirname, '../include'))
      .inTmpDir( function (dir) {
        fs.copySync(path.join(__dirname, './test-assets/subgenerator-test-plugin'), dir);
      })
      .withOptions({ skipInstall: true, force: true })
      .withArguments('new-include')
      .withLocalConfig({
        "name": "Subgenerator Test",
        "homepage": "http://webdevstudios.com",
        "description": "A radical new plugin for WordPress!",
        "version": "0.1.0",
        "author": "WebDevStudios",
        "authoremail": "contact@webdevstudios.com",
        "authorurl": "http://webdevstudios.com",
        "license": "GPLv2",
        "slug": "subgenerator-test",
        "classname": "Subgenerator_Test",
        "prefix": "subgenerator_test",
        "year": 2015
      })
      .on('end', done);
  });

  it('creates files', function () {
    assert.file([
      'includes/new-include.php',
      'tests/test-new-include.php'
    ]);
  });
});

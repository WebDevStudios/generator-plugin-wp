'use strict';

var path = require('path');
var assert = require('yeoman-generator').assert;
var helpers = require('yeoman-generator').test;
var fs = require('fs-extra');
var os = require('os');

describe('PluginWp:include', function () {
  before(function (done) {
    helpers.run(path.join( __dirname, '../include'))
      .inDir(path.join(os.tmpdir(), './sub-inc-test'), function (dir) {
        fs.copySync(path.join(__dirname, './test-assets/subgenerator-test-plugin'), dir);
      })
      .withArguments('new-include', '--force')
      .on('end', done);
  });

  it('creates files', function () {
    assert.file([
      'includes/new-include.php'
    ]);
  });
});

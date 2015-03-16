'use strict';

var path = require('path');
var assert = require('yeoman-generator').assert;
var helpers = require('yeoman-generator').test;
var os = require('os');

describe('PluginWp:include', function () {
  before(function (done) {
     helpers.run(path.join(__dirname, '../app'))
      .inDir(path.join(os.tmpdir(), './temp-test'))
      .withOptions({ 'skip-install': true })
      .withPrompt({
        name: 'Test Plugin NAME'
      })
      .on('end', function() {
         helpers.run(path.join(__dirname, '../include'))
          .withArguments('name', '--force')
          .withOptions({ 'skip-install': true })
          .on('end', done);
      });
  });

  it('creates files', function () {
    assert.file([
      'includes/name.php'
    ]);
  });
});

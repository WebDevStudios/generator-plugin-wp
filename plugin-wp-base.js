'use strict';
var yeoman = require('yeoman-generator');
var updateNotifier = require('update-notifier');

module.exports = yeoman.generators.Base.extend({
	constructor: function () {
		// Calling the super constructor is important so our generator is correctly set up
		yeoman.generators.Base.apply(this, arguments);

		updateNotifier({
				pkg: require('./package.json')
			}).notify({defer: false});
	},

	_wpClassify: function( s ) {
		var words  = this._.words( s );
		var result = '';

		for ( var i = 0; i < words.length; i += 1 ) {
			if ( this._.classify( words[i] ) ) {
				result += this._.capitalize( words[i] );
				if ( (i + 1) < words.length ) {
					result += '_';
				}
			}
		}

		return result;
	},

	_wpClassPrefix: function( s ) {
		var words = s.replace( /_/g, ' ' );
		var letters = words.replace(/[a-z]/g, '');
		var prefix = letters.replace(/\s/g, '');
		return prefix + '_';
	},

	_escapeDoubleQuotes: function( s ) {
		return s.replace( /"/g, '\\"');
	},

	_addStringToPluginClasses: function( toAdd ) {
		if ( ! this.rc.slug ) {
			return;
		}

		var mainPluginFile = this.fs.read( this.destinationPath( this.rc.slug + '.php' ) );
		var endComment = '	} // END OF PLUGIN CLASSES FUNCTION';
		var newInclude = '		' + toAdd + '\n' + endComment;

		mainPluginFile = mainPluginFile.replace( endComment, newInclude );

		this.fs.write( this.destinationPath( this.rc.slug + '.php' ), mainPluginFile );
	},

	_addIncludeClass: function( slug, className ) {
		this._addStringToPluginClasses( '$this->' + this._.underscored( slug ) + ' = new ' + className + '( $this );' );
	}
});

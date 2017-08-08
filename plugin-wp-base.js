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

		result = result.replace('-', '_');
		return result;

	},

	_wpClassPrefix: function( s ) {
		var words = s.replace( /_/g, ' ' );
		var letters = words.replace(/[a-z]/g, '');
		var hyphens = letters.replace(/\s/g, '');
		var prefix  = hyphens.replace(/-/g,'');
		return prefix + '_';
	},

	_wpNameSpace: function( s ) {
		var words = s.replace( /_/g, ' ' );
		var letters = words.replace(/[a-z]/g, '');
		var hyphens = letters.replace(/\s/g, '');
		return hyphens.replace(/-/g,'');
	},

	_escapeDoubleQuotes: function( s ) {
		return s.replace( /"/g, '\\"');
	},

	__addStringToPluginClasses: function( mainPluginFile, toAdd ) {
		var endComment = '\t} // END OF PLUGIN CLASSES FUNCTION';
		var newInclude = '\t\t' + toAdd + '\n' + endComment;

		return mainPluginFile.replace( endComment, newInclude );
	},

	_addStringToPluginClasses: function( toAdd ) {
		if ( ! this.rc.slug ) {
			return;
		}

		var mainPluginFile = this.fs.read( this.destinationPath( this.rc.slug + '.php' ) );
		mainPluginFile = this.__addStringToPluginClasses( mainPluginFile, toAdd );

		this.fs.write( this.destinationPath( this.rc.slug + '.php' ), mainPluginFile );
	},

	_addPluginProperty: function( file, slug, className, version ) {

		var toAdd = '\t/**';
		toAdd += '\n\t * Instance of ' + className;
		toAdd += '\n\t *';
		toAdd += '\n\t * @since' + version;
		toAdd += '\n\t * @var ' + className;
		toAdd += '\n\t */';
		toAdd += '\n\tprotected $' + slug + ';';

		var endComment = '\t/**\n\t * Creates or returns an instance of this class.';

		return file.replace( endComment, toAdd + '\n\n' + endComment );
	},

	_addPluginClass: function( file, slug, className ) {
		var toAdd = '$this->' + slug + ' = new ' + className + '( $this );';
		var toRemove = '\n\t\t// $this->plugin_class = new ' + this.rc.classprefix + 'Plugin_Class( $this );';
		return this.__addStringToPluginClasses( file.replace( toRemove, '' ), toAdd );
	},

	_addNamespacedPluginClass: function( file, slug, className ) {
		var toAdd = 'new ' + className + '();';
		var toRemove = '\n\t\t// $this->plugin_class = new ' + this.rc.classprefix + 'Plugin_Class( $this );';
		return this.__addStringToPluginClasses( file.replace( toRemove, '' ), toAdd );
	},

	_addUse: function( file, slug, className ) {
		var toAdd = 'use' + className + ';';
		var toRemove = '\n\t\t// use Use\\Path;';
		return this.__addStringToPluginClasses( file.replace( toRemove, '' ), toAdd );
	},

	_addPropertyMagicGetter: function( file, slug ) {

		var toAdd = '\t\t\tcase \'' + slug + '\':';
		var endComment = '\t\t\t\treturn $this->$field;';
		var newInclude = toAdd + '\n' + endComment;

		return file.replace( endComment, newInclude );
	},

	_addIncludeClass: function( slug, className, version ) {

		if ( ! this.rc.slug ) {
			return;
		}

		slug    = this._.underscored( slug );
		var mainPluginFile = this.fs.read( this.destinationPath( this.rc.slug + '.php' ) );

		if ( 'Namespace' !== autoloder ) {
			mainPluginFile = this._addPluginProperty( mainPluginFile, slug, className, version );
			mainPluginFile = this._addPluginClass( mainPluginFile, slug, className );
			mainPluginFile = this._addPropertyMagicGetter( mainPluginFile, slug );
		} else {
			mainPluginFile = this._addNamespacedPluginClass( mainPluginFile, slug, className );
			mainPluginFile = this._addUse( mainPluginFile, slug, className );
		}
		this.fs.write( this.destinationPath( this.rc.slug + '.php' ), mainPluginFile );
	}

});

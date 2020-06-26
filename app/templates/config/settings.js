/**
 * Config settings.
 */
const path = require( 'path' );

/**
 * Resolve path.
 *
 * @since 1.0.0
 *
 * @param {string} src Path of the entry source.
 * @return {string} Resolved path.
 */
const resolvePath = ( src ) => {
	return path.resolve( process.cwd(), src );
};

module.exports = {
	entries: {
		index: resolvePath( './assets/js/index.js' ),

		// Stylesheets.
		style: resolvePath( './assets/css/style.css' ),
	},
	filename: {
		js: 'js/[name].js',
		css: 'css/[name].css',
	},
	paths: {
		src: {
			base: './assets/',
			css: './assets/css',
			js: './assets/js',
		},
		dist: {
			base: resolvePath( './dist/' ),
		},
	},
	BrowserSyncConfig: {
		host: 'localhost',
		port: 3000,
		proxy: 'https://<%= slug %>.local',
		open: false,
		files: [ '**/*.php', 'dist/js/**/*.js', 'dist/css/**/*.css' ],
	},
};

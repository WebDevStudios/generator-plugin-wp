/**
 * Webpack config.
 */
const settings = require( './settings' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const FixStyleOnlyEntriesPlugin = require( 'webpack-fix-style-only-entries' );
const StyleLintPlugin = require( 'stylelint-webpack-plugin' );
const WebpackBar = require( 'webpackbar' );
const BrowserSyncPlugin = require( 'browser-sync-webpack-plugin' );
const { mode, resolve, stats, devtool } = defaultConfig;

const isProduction = 'production' === mode;

module.exports = {
	mode,
	entry: settings.entries,
	output: {
		path: settings.paths.dist.base,
		pathinfo: true,
		filename: settings.filename.js,
	},
	resolve,
	module: {
		...defaultConfig.module,
		rules: [ ...defaultConfig.module.rules ],
	},
	plugins: [
		new MiniCssExtractPlugin( {
			filename: settings.filename.css,
			chunkFilename: settings.filename.css,
		} ),

		new FixStyleOnlyEntriesPlugin( {
			silent: true,
		} ),

		// Lint CSS.
		new StyleLintPlugin( {
			context: settings.paths.src.css,
			files: '**/*.css',
		} ),

		// Webpack bar.
		new WebpackBar(),

		! isProduction &&
			new BrowserSyncPlugin(
				{
					host: settings.BrowserSyncConfig.host,
					port: settings.BrowserSyncConfig.port,
					proxy: settings.BrowserSyncConfig.proxy,
					open: settings.BrowserSyncConfig.open,
					files: settings.BrowserSyncConfig.files,
				},
				{
					injectCss: true,
					reload: false,
				}
			),
	].filter( Boolean ),
	stats,
	devtool,
};

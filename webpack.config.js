/**
 * Custom Webpack Config
 *
 * Extends the WordPress WP-Scripts configuration for our local use.
 *
 * WP-Scripts webpack config documentation:
 * https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/#default-webpack-config
 */

const { resolve, extname } = require( 'path' );
const { sync: glob } = require( 'fast-glob' );
const pkg = require( './package.json' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const RemoveEmptyScriptsPlugin = require( 'webpack-remove-empty-scripts' );

/**
 * General theme scripts & styles entry points
 *
 * The entry point names are prefixed with `assets` to direct their output into
 * an assets subdirectory in the root dist folder.
 */
const assetEntryPoints = () => {
	return {
		'admin': resolve(
			pkg.directories.admin,
			'',
			'admin.js'
		),
		'public': resolve(
			pkg.directories.public,
			'',
			'public.js'
		)
	};
};

module.exports = {
	...defaultConfig,
	entry: {
		...assetEntryPoints()
	},
	output: {
		...defaultConfig.output,
		path: resolve( './', 'dist' ), // Change the output path to `dist` instead of `build`
	},
	plugins: [
		...defaultConfig.plugins,

		/**
		 * Remove empty auto-generated index.js files
		 *
		 * Webpack auto-generates an empty index.js file for every entry point.
		 * When we create a styles-only entry point such as print.pcss
		 * this plugin deletes that empty index.js file after it is built.
		 */
		new RemoveEmptyScriptsPlugin( {
			stage: RemoveEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
		} ),
	],
};

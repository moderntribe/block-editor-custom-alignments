/**
 * PostCSS Config
 */

const postcssGlobalData = require('@csstools/postcss-global-data');
const postcssMixins = require('postcss-mixins');

const isProduction = process.env.NODE_ENV === 'production';

const plugins = [
	'postcss-import',
	// postcssGlobalData({
	// 	files: [
	// 		'./themes/core/assets/pcss/global/mixins.pcss',
	// 		'./themes/core/assets/pcss/global/media-queries.pcss',
	// 		'./themes/core/assets/pcss/global/selectors.pcss'
	// 	]
	// }),
	postcssMixins(),
	[
		'postcss-preset-env',
		{
			stage: 0,
			autoprefixer: { grid: true },
			features: {
				'clamp': false,
				'custom-properties': false,
				'focus-visible-pseudo-class': false,
				'focus-within-pseudo-class': false,
				'logical-properties-and-values': false,
				'has-pseudo-class': true,
			},
		},
	],
];

module.exports = {
	plugins: isProduction ? [ ...plugins, require( 'cssnano' ) ] : plugins,
};

/**
 * PostCSS Config
 */

const isProduction = process.env.NODE_ENV === 'production';

const plugins = [
	'postcss-import',
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

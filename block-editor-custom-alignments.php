<?php declare(strict_types=1);

/**
 * Block Editor Custom Alignments
 *
 * @link              https://tri.be
 *
 * @since             1.0.0
 *
 * @package           Block_Editor_Custom_Alignments
 *
 * @wordpress-plugin
 * Plugin Name:       Block Editor Custom Alignments
 * Plugin URI:        https://https://github.com/moderntribe/block-editor-custom-alignments
 * Description:       Allows developers to add custom alignments to `theme.json` for use in the block editor.
 * Version:           1.0.0
 * Author:            Modern Tribe
 * Author URI:        https://tri.be
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       block-editor-custom-alignments
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BLOCK_EDITOR_CUSTOM_ALIGNMENTS_VERSION', '1.0.0' );

/**
 * Define name for the plugin for use later
 */
define( 'BLOCK_EDITOR_CUSTOM_ALIGNMENTS_NAME', 'block-editor-custom-alignments' );

/**
 * Define base URL for the plugin for use later
 */
define( 'BLOCK_EDITOR_CUSTOM_ALIGNMENTS_BASE_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * Returns a JSON object for theme.json from the currently activated theme.
 *
 * @return object
 */
function block_editor_custom_alignments_theme_json(): object {
	if ( ! file_exists( trailingslashit( get_stylesheet_directory() ) . 'theme.json' ) ) {
		return new stdClass();
	}

	return json_decode( file_get_contents( trailingslashit( get_stylesheet_directory_uri() ) . 'theme.json' ) );
}

/**
 * Handles admin scripts for the plugin
 */
function block_editor_custom_alignments_admin_scripts(): void {
	$theme_json = block_editor_custom_alignments_theme_json();

	wp_enqueue_script( BLOCK_EDITOR_CUSTOM_ALIGNMENTS_NAME, BLOCK_EDITOR_CUSTOM_ALIGNMENTS_BASE_URL . 'dist/admin.js', [ 'jquery' ], BLOCK_EDITOR_CUSTOM_ALIGNMENTS_VERSION, false );

	// localize the theme.json contents as a global variable
	if ( $theme_json === new stdClass() ) {
		return;
	}

	wp_localize_script( BLOCK_EDITOR_CUSTOM_ALIGNMENTS_NAME, 'tribe', [
		'theme_json' => $theme_json,
	]);
}

/**
 * Handles admin styles for the plugin
 */
function block_editor_custom_alignments_admin_styles(): void {
	$theme_json = block_editor_custom_alignments_theme_json();

	// enqueue main styles for the admin
	wp_enqueue_style( BLOCK_EDITOR_CUSTOM_ALIGNMENTS_NAME, BLOCK_EDITOR_CUSTOM_ALIGNMENTS_BASE_URL . 'dist/admin.css', [], BLOCK_EDITOR_CUSTOM_ALIGNMENTS_VERSION, 'all' );

	// enqueue theme.json inline styles
	if ( $theme_json === new stdClass() || ! $theme_json->settings->_experimentalLayout ) { /** @phpstan-ignore-line */
		return;
	}

	$admin_css = '';

	foreach ( $theme_json->settings->_experimentalLayout as $alignment ) {
		$admin_css .= "
				:is(.editor-styles-wrapper) .block-editor-block-list__layout.is-root-container .wp-block.align{$alignment->slug} {
						max-width: {$alignment->width};
				}
		";
	}

	wp_add_inline_style( BLOCK_EDITOR_CUSTOM_ALIGNMENTS_NAME, $admin_css );
}

/**
 * Handles public styles for the plugin
 */
function block_editor_custom_alignments_public_styles(): void {
	$theme_json = block_editor_custom_alignments_theme_json();

	if ( $theme_json === new stdClass() || ! $theme_json->settings->_experimentalLayout ) { /** @phpstan-ignore-line */
		return;
	}

	wp_enqueue_style( BLOCK_EDITOR_CUSTOM_ALIGNMENTS_NAME, BLOCK_EDITOR_CUSTOM_ALIGNMENTS_BASE_URL . 'dist/public.css', [], BLOCK_EDITOR_CUSTOM_ALIGNMENTS_VERSION, 'all' );

	$theme_css = '';

	foreach ( $theme_json->settings->_experimentalLayout as $alignment ) {
		$theme_css .= "
				body .align{$alignment->slug} {
						max-width: {$alignment->width};
				}
		";
	}

	wp_add_inline_style( BLOCK_EDITOR_CUSTOM_ALIGNMENTS_NAME, $theme_css );
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_block_editor_custom_alignments(): void {

	add_action( 'admin_enqueue_scripts', 'block_editor_custom_alignments_admin_scripts', 10 );
	add_action( 'admin_enqueue_scripts', 'block_editor_custom_alignments_admin_styles', 10 );
	add_action( 'wp_enqueue_scripts', 'block_editor_custom_alignments_public_styles', 10 );
}

run_block_editor_custom_alignments();

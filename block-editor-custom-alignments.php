<?php

/**
 * Block Editor Custom Alignments
 *
 * @link              https://tri.be
 * @since             1.0.0
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
 * Define base URL for the plugin for use later
 */
define( 'BLOCK_EDITOR_CUSTOM_ALIGNMENTS_BASE_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-block-editor-custom-alignments-activator.php
 */
function activate_block_editor_custom_alignments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-block-editor-custom-alignments-activator.php';
	Block_Editor_Custom_Alignments_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-block-editor-custom-alignments-deactivator.php
 */
function deactivate_block_editor_custom_alignments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-block-editor-custom-alignments-deactivator.php';
	Block_Editor_Custom_Alignments_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_block_editor_custom_alignments' );
register_deactivation_hook( __FILE__, 'deactivate_block_editor_custom_alignments' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-block-editor-custom-alignments.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_block_editor_custom_alignments() {

	$plugin = new Block_Editor_Custom_Alignments();
	$plugin->run();

}
run_block_editor_custom_alignments();

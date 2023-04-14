<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://tri.be
 * @since             1.0.0
 * @package           Gutenberg_Custom_Alignments
 *
 * @wordpress-plugin
 * Plugin Name:       Gutenberg Custom Alignments
 * Plugin URI:        https://https://github.com/moderntribe/gutenberg-custom-alignments
 * Description:       Allows developers to add custom alignments to `theme.json` for use in the block editor. 
 * Version:           1.0.0
 * Author:            Modern Tribe
 * Author URI:        https://tri.be
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gutenberg-custom-alignments
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
define( 'GUTENBERG_CUSTOM_ALIGNMENTS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gutenberg-custom-alignments-activator.php
 */
function activate_gutenberg_custom_alignments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gutenberg-custom-alignments-activator.php';
	Gutenberg_Custom_Alignments_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gutenberg-custom-alignments-deactivator.php
 */
function deactivate_gutenberg_custom_alignments() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gutenberg-custom-alignments-deactivator.php';
	Gutenberg_Custom_Alignments_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gutenberg_custom_alignments' );
register_deactivation_hook( __FILE__, 'deactivate_gutenberg_custom_alignments' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gutenberg-custom-alignments.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gutenberg_custom_alignments() {

	$plugin = new Gutenberg_Custom_Alignments();
	$plugin->run();

}
run_gutenberg_custom_alignments();

<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://tri.be
 * @since      1.0.0
 *
 * @package    Gutenberg_Custom_Alignments
 * @subpackage Gutenberg_Custom_Alignments/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Gutenberg_Custom_Alignments
 * @subpackage Gutenberg_Custom_Alignments/includes
 * @author     Modern Tribe <info@tri.be>
 */
class Gutenberg_Custom_Alignments_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'gutenberg-custom-alignments',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}

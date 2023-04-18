<?php declare(strict_types=1);

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 *
 * @package    Block_Editor_Custom_Alignments
 *
 * @subpackage Block_Editor_Custom_Alignments/includes
 *
 * @author     Modern Tribe <info@tri.be>
 */

namespace Tribe\Includes;

class Block_Editor_Custom_Alignments_I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */

	public function load_plugin_textdomain(): void {

		load_plugin_textdomain(
			'block-editor-custom-alignments',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}

}

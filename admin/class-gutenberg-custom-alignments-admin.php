<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://tri.be
 * @since      1.0.0
 *
 * @package    Gutenberg_Custom_Alignments
 * @subpackage Gutenberg_Custom_Alignments/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Gutenberg_Custom_Alignments
 * @subpackage Gutenberg_Custom_Alignments/admin
 * @author     Modern Tribe <info@tri.be>
 */
class Gutenberg_Custom_Alignments_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Data from theme.json of the activated theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      object    $theme_json    Data from theme.json of the activated theme.
	 */
	private $theme_json;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $theme_json ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->theme_json = $theme_json;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// enqueue main styles for the admin
		wp_enqueue_style( $this->plugin_name, GUTENBERG_CUSTOM_ALIGNMENTS_BASE_URL . 'dist/admin.css', array(), $this->version, 'all' );


		// enqueue theme.json inline styles
		if ( $this->theme_json && $this->theme_json->settings->_experimentalLayout ) {
			$admin_css = '';

			foreach ( $this->theme_json->settings->_experimentalLayout as $alignment ) {
				$admin_css .= "
					:is(.editor-styles-wrapper) .block-editor-block-list__layout.is-root-container .wp-block.align{$alignment->slug} {
						max-width: {$alignment->width};
					}
				";
			}

			wp_add_inline_style( $this->plugin_name, $admin_css );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, GUTENBERG_CUSTOM_ALIGNMENTS_BASE_URL . 'dist/admin.js', array( 'jquery' ), $this->version, false );

		// localize the theme.json contents as a global variable
		if ( $this->theme_json ) {
			wp_localize_script( $this->plugin_name, 'tribe', [
				'theme_json' => $this->theme_json,
			]);
		}

	}

}

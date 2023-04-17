<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://tri.be
 * @since      1.0.0
 *
 * @package    Gutenberg_Custom_Alignments
 * @subpackage Gutenberg_Custom_Alignments/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Gutenberg_Custom_Alignments
 * @subpackage Gutenberg_Custom_Alignments/public
 * @author     Modern Tribe <info@tri.be>
 */
class Gutenberg_Custom_Alignments_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $theme_json ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->theme_json = $theme_json;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, GUTENBERG_CUSTOM_ALIGNMENTS_BASE_URL . 'dist/public.css', array(), $this->version, 'all' );

		if ( $this->theme_json && $this->theme_json->settings->_experimentalLayout ) {
			$theme_css  = '';

			foreach ( $this->theme_json->settings->_experimentalLayout as $alignment ) {
				$theme_css .= "
					body .align{$alignment->slug} {
						max-width: {$alignment->width};
					}
				";
			}

			wp_add_inline_style( $this->plugin_name, $theme_css );
		}

	}

}

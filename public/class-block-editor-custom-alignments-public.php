<?php declare(strict_types=1);

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Block_Editor_Custom_Alignments
 *
 * @subpackage Block_Editor_Custom_Alignments/public
 *
 * @author     Modern Tribe <info@tri.be>
 */

namespace Tribe\Public;

class Block_Editor_Custom_Alignments_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 *
	 * @access   private
	 *
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private string $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 *
	 * @access   private
	 *
	 * @var      string    $version    The current version of this plugin.
	 */
	private string $version;

	/**
	 * Data from theme.json of the activated theme.
	 *
	 * @since    1.0.0
	 *
	 * @access   private
	 *
	 * @var      object    $theme_json    Data from theme.json of the activated theme.
	 */
	private object $theme_json;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string    $plugin_name       The name of the plugin.
	 *
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version, object $theme_json ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->theme_json  = $theme_json;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {

		wp_enqueue_style( $this->plugin_name, BLOCK_EDITOR_CUSTOM_ALIGNMENTS_BASE_URL . 'dist/public.css', [], $this->version, 'all' ); /** @phpstan-ignore-line */

		if ( ! $this->theme_json || ! $this->theme_json->settings->_experimentalLayout ) {  /** @phpstan-ignore-line */
			return;
		}

		$theme_css = '';

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

<?php declare(strict_types=1);

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Block_Editor_Custom_Alignments
 *
 * @subpackage Block_Editor_Custom_Alignments/admin
 *
 * @author     Modern Tribe <info@tri.be>
 */

namespace Tribe\Admin;

class Block_Editor_Custom_Alignments_Admin {

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
	 * @param    string    $plugin_name       The name of this plugin.
	 *
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version, object $theme_json ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->theme_json  = $theme_json;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {

		// enqueue main styles for the admin
		wp_enqueue_style( $this->plugin_name, BLOCK_EDITOR_CUSTOM_ALIGNMENTS_BASE_URL . 'dist/admin.css', [], $this->version, 'all' ); /** @phpstan-ignore-line */

		// enqueue theme.json inline styles
		if ( ! $this->theme_json || ! $this->theme_json->settings->_experimentalLayout ) { /** @phpstan-ignore-line */
			return;
		}

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

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts(): void {

		wp_enqueue_script( $this->plugin_name, BLOCK_EDITOR_CUSTOM_ALIGNMENTS_BASE_URL . 'dist/admin.js', [ 'jquery' ], $this->version, false ); /** @phpstan-ignore-line */

		// localize the theme.json contents as a global variable
		if ( ! $this->theme_json ) { /** @phpstan-ignore-line */
			return;
		}

		wp_localize_script( $this->plugin_name, 'tribe', [
			'theme_json' => $this->theme_json,
		]);
	}

}

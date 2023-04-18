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

namespace Tribe;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Block_Editor_Custom_Alignments {

	// current plugin version
	private string $version;

	// plugin name / slug
	private string $name;

	// plugin base url
	private string $base_url;

	// JSON object created from theme.json file, if it exists
	private object $theme_json;

	/**
	 * constructs class / adds actions related to plugin
	 */
	public function __construct() {
		$this->version    = '1.0.0';
		$this->name       = 'block-editor-custom-alignments';
		$this->base_url   = trailingslashit( plugin_dir_url( __FILE__ ) );
		$this->theme_json = $this->block_editor_custom_alignments_theme_json();

		add_action( 'admin_enqueue_scripts', [ $this, 'block_editor_custom_alignments_admin_scripts' ], 10 );
		add_action( 'admin_enqueue_scripts', [ $this, 'block_editor_custom_alignments_admin_styles' ], 10 );
		add_action( 'wp_enqueue_scripts', [ $this, 'block_editor_custom_alignments_public_styles' ], 10 );
	}

	/**
	 * Handles admin scripts for the plugin
	 */
	public function block_editor_custom_alignments_admin_scripts(): void {
		wp_enqueue_script( $this->name, $this->base_url . 'dist/admin.js', [ 'jquery' ], $this->version, false );

		// localize the theme.json contents as a global variable
		if ( $this->theme_json === new \stdClass() ) {
			return;
		}

		wp_localize_script( $this->name, 'tribe', [
			'theme_json' => $this->theme_json,
		]);
	}

	/**
	 * Handles admin styles for the plugin
	 */
	public function block_editor_custom_alignments_admin_styles(): void {
		// enqueue main styles for the admin
		wp_enqueue_style( $this->name, $this->base_url . 'dist/admin.css', [], $this->version, 'all' );

		// enqueue theme.json inline styles
		if ( $this->theme_json === new \stdClass() || ! $this->theme_json->settings->_experimentalLayout ) { /** @phpstan-ignore-line */
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

		wp_add_inline_style( $this->name, $admin_css );
	}

	/**
	 * Handles public styles for the plugin
	 */
	public function block_editor_custom_alignments_public_styles(): void {
		if ( $this->theme_json === new \stdClass() || ! $this->theme_json->settings->_experimentalLayout ) { /** @phpstan-ignore-line */
			return;
		}

		wp_enqueue_style( $this->name, $this->base_url . 'dist/public.css', [], $this->version, 'all' );

		$theme_css = '';

		foreach ( $this->theme_json->settings->_experimentalLayout as $alignment ) {
			$theme_css .= "
					body .align{$alignment->slug} {
							max-width: {$alignment->width};
					}
			";
		}

		wp_add_inline_style( $this->name, $theme_css );
	}

	/**
	 * If it exists, grabs the
	 */
	private function block_editor_custom_alignments_theme_json(): object {
		if ( ! file_exists( trailingslashit( get_stylesheet_directory() ) . 'theme.json' ) ) {
			return new \stdClass();
		}

		return json_decode( file_get_contents( trailingslashit( get_stylesheet_directory_uri() ) . 'theme.json' ) );
	}

}

new Block_Editor_Custom_Alignments();

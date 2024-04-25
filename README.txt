=== Block Editor Custom Alignments ===
Contributors: moderntribe
Donate link: https://tri.be
Tags: blocks, editor, alignment
Requires at least: 6.0
Tested up to: 6.5.2
Stable tag: 1.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows developers to add custom alignments to `theme.json` for use in the block editor.

== Description ==

The plugin runs off of an `_experimentalLayout` attribute in `theme.json` that allows a developer to define extra alignments (widths) for blocks that support alignment. If a block doesn't support alignment, this feature will not display.

== Installation ==

1. Upload Block Editor Custom Alignments to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 1.0.7 =
* Updates plugin to also create CSS variables for each defined width.

= 1.0.6 =
* Fixes an issue where blocks could get a class of `alignfalse` when selecting the "None" alignment in the toolbar.

= 1.0.5 =
* Use `enqueue_block_editor_assets` instead of `admin_enqueue_scripts` to prevent dependency errors

= 1.0.4 =
* Use `wp_remote_get` for grabbing `theme.json` to prevent SSL errors

= 1.0.3 =
* Fix how the admin scripts get enqueued (dependencies)

= 1.0.2 =
* Update versions to match release.

= 1.0.1 =
* Fix issue with `_experimentalLayout` check

= 1.0.0 =
* Initial release.

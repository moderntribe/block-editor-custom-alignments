# Block Editor Custom Alignments

Allows developers to add custom alignments to `theme.json` for use in the block editor. 

## Usage

The plugin runs off of an `_experimentalLayout` attribute in `theme.json` that allows a developer to define extra alignments (widths) for blocks that support alignment. If a block doesn't support alignment, this feature will not display. All values within the `_experimentalLayout` array's objects are required. Excluding this array from your `theme.json` file will disable most features of the plugin.

```
"_experimentalLayout": [
  {
    "name": "Narrow",
    "slug": "narrow",
    "icon": "M5 9v6h14V9H5zm11-4.8H8v1.5h8V4.2zM8 19.8h8v-1.5H8v1.5z",
    "width": "400px",
    "textdomain": "tribe"
  },
  {
    "name": "Extra Wide",
    "slug": "extrawide",
    "icon": "M5 9v6h14V9H5zm11-4.8H8v1.5h8V4.2zM8 19.8h8v-1.5H8v1.5z",
    "width": "1300px",
    "textdomain": "tribe"
  }
],
```

You are still able to define `contentSize` and `wideSize` within the `layout` attribute as normal, and they will populate in the new control created by the plugin. You can find the documentation for layout from core [here](https://developer.wordpress.org/themes/advanced-topics/theme-json/#layout).

```
"layout": {
  "contentSize": "652px",
  "wideSize": "883px"
},
```

### Includes Array

The plugin also offers support for only include specific blocks from having custom alignment support via the `_experimentalLayoutInclude` array within `theme.json`.

```
"_experimentalLayoutInclude": [
	"core/group",
  "core/columns"
],
```

### Excludes Array

The plugin also offers support for excluding specific blocks from having custom alignment support via the `_experimentalLayoutExclude` array within `theme.json`.

```
"_experimentalLayoutExclude": [
  "core/group"
],
```

## Local Development

Since this is a small plugin, local development uses mostly Wordpress default build scripts via `wp-scripts`, with some overrides. 

To get started:
1. Clone the plugin / download the repo ZIP into your `plugins` folder within Wordpress.
1. `cd block-editor-custom-alignments`
1. `composer install`
1. `nvm use`
1. `npm install`
1. `npm run dev` or `npm run dist`

The plugin also offers scripts for linting and formatting:
- `npm run lint` will run formatting and linting on all PCSS & JS files.
- `npm run format` will run `wp-scripts format` on all PCSS & JS files.
- Linting is also available per language via their own respective commands:
    - `npm run lint:css` will return linting errors in your PCSS files.
	- `npm run lint:css:fix` will fix linting errors in your PCSS files.
	- `npm run lint:js` will return linting errors in your JS files.
	- `npm run lint:js:fix` will fix linting errors in your JS files.

## Modern Tribe

[![Modern Tribe](https://moderntribe-common.s3.us-west-2.amazonaws.com/marketing/ModernTribe-Banner.png)](https://tri.be/contact/)

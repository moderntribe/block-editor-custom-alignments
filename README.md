# Gutenberg Custom Alignments

Allows developers to add custom alignments to `theme.json` for use in the block editor. 

## Usage

The plugin runs off of an `_experimentalLayout` attribute in `theme.json` that allows a developer to define extra alignments (widths) for blocks that support alignment. If a block doesn't support alignment, this feature will not display. All values within the `_experimentalLayout` array's objects are required.

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

You are still able to define `contentSize` and `wideSize` within the `layout` attribute as normal, and they will populate in the new control created by the plugin.

```
"layout": {
  "contentSize": "652px",
  "wideSize": "883px"
},
```

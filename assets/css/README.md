StoreCore Amplified Material Design (AMD)
=========================================

The default MDL (Material Design Lite) CSS template included in StoreCore uses
blue as the primary color and orange as the accent color.  The minified CSS
file is hosted on the Google MDL CDN at:

https://code.getmdl.io/1.1.3/material.blue-orange.min.css


# Changelog for StoreCore AMP MDL

- Drop h5 and h6 headings.
- Merge the opacity .54 and .87 selectors.
- Upgrade `Helvetica` to `'Helvetica Neue'`.
- Add missing Roboto to the font stacks.
- Strip double quotes from `"Roboto"` and `"Arial"`.
- Move color definitions out to separate files.
- Merge font stack into a single font-family declaration.
- Merge default `font-weight: 400` into a single declaration.
- Drop the `-force-` classes.

# Overwrites not supported

The following MDL `-force-` class names are not supported in StoreCore CSS:

- .mdl-typography--body-1-force-preferred-font
- .mdl-typography--body-1-force-preferred-font-color-contrast
- .mdl-typography--body-2-force-preferred-font
- .mdl-typography--body-2-force-preferred-font-color-contrast
- .mdl-typography--caption-force-preferred-font
- .mdl-typography--caption-force-preferred-font-color-contrast
- .mdl-typography--caption-force-preferred-font
- .mdl-typography--caption-force-preferred-font-color-contrast

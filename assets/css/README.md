StoreCore Amplified Material Design (AMD)
=========================================

The default [Material Design Lite (MDL)](https://getmdl.io/index.html) CSS
template included in StoreCore uses blue as the primary color and orange as the
accent color.  The minified CSS file is hosted on the Google MDL CDN at:

https://code.getmdl.io/1.3.0/material.blue-orange.min.css

The StoreCore administration CSS in the
[admin.css file](https://github.com/storecore/core/blob/develop/assets/css/admin.css)
and the minified admin.min.css file uses light green as the primary color and
ligth blue as the accent color.  This file was derived from the minified file
located at:

https://code.getmdl.io/1.3.0/material.light_green-light_blue.min.css

To allow for tracking changes, the admin.css file is partially minified.  The
minified lines are unchanged CSS declarations from MDL.  The unminified CSS
declarations contain changes or additions for StoreCore.


## Changelog for StoreCore AMP MDL

- Add fallback color `#212121` for `rgba(0,0,0,.87)`.
- Drop h5 and h6 headings.
- Merge the opacity .54 and .87 selectors.
- Add missing Roboto to some font stacks.
- Upgrade `Helvetica` to `"Helvetica Neue"`.
- Strip double quotes from `"Roboto"` and `"Arial"`.
- Move color definitions out to separate files.
- Merge font stack into a single font-family declaration.
- Merge default `font-weight: 400` into a single declaration.
- Drop the `-force-` classes.
- Drop the `--` duplicates of class names with `__`.
- Drop extreme font weights 100, 200, and 900.
- Drop italic for the blockquote element.


## Forcing Preferred Fonts Not Supported

The following MDL `force-preferred-font` class names are not supported in
StoreCore CSS.  In StoreCore the preferred font is used for all elements, so
there is no need to force it anywhere.

- .mdl-typography--body-1-force-preferred-font
- .mdl-typography--body-1-force-preferred-font-color-contrast
- .mdl-typography--body-2-force-preferred-font
- .mdl-typography--body-2-force-preferred-font-color-contrast
- .mdl-typography--caption-force-preferred-font
- .mdl-typography--caption-force-preferred-font-color-contrast
- .mdl-typography--caption-force-preferred-font
- .mdl-typography--caption-force-preferred-font-color-contrast


## Duplicate Class Names

In some cases MDL uses duplicate CSS class definitions with a `--` and a `__`
delimiter, for example `.mdl-mega-footer—heading` and
`.mdl-mega-footer__heading`.  The duplicate MDL classes with `--` are not
supported by StoreCore.

| Not supported                       | Preferred class name                |
| ----------------------------------- | ----------------------------------- |
| .mdl-mega-footer--bottom-section    | .mdl-mega-footer__bottom-section    |
| .mdl-mega-footer--drop-down-section | .mdl-mega-footer__drop-down-section |
| .mdl-mega-footer--heading-checkbox  | .mdl-mega-footer__heading-checkbox  |
| .mdl-mega-footer--heading           | .mdl-mega-footer__heading           |
| .mdl-mega-footer--left-section      | .mdl-mega-footer__left-section      |
| .mdl-mega-footer--link-list         | .mdl-mega-footer__link-list         |
| .mdl-mega-footer--middle-section    | .mdl-mega-footer__middle-section    |
| .mdl-mega-footer--right-section     | .mdl-mega-footer__right-section     |
| .mdl-mega-footer--social-btn        | .mdl-mega-footer__social-btn        |
| .mdl-mega-footer--top-section       | .mdl-mega-footer__top-section       |
| .mdl-mini-footer--left-section      | .mdl-mini-footer__left-section      |
| .mdl-mini-footer--link-list         | .mdl-mini-footer__link-list         |
| .mdl-mini-footer--right-section     | .mdl-mini-footer__right-section     |
| .mdl-mini-footer--social-btn        | .mdl-mini-footer__social-btn        |

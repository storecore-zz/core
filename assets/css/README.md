StoreCore Amplified Material Design (AMD)
=========================================

The default MDL (Material Design Lite) CSS template included in StoreCore uses
blue as the primary color and orange as the accent color.  The minified CSS
file is hosted on the Google MDL CDN at:

https://code.getmdl.io/1.1.3/material.blue-orange.min.css


## Changelog for StoreCore AMP MDL

- Drop h5 and h6 headings.
- Merge the opacity .54 and .87 selectors.
- Upgrade `Helvetica` to `'Helvetica Neue'`.
- Add missing Roboto to the font stacks.
- Strip double quotes from `"Roboto"` and `"Arial"`.
- Move color definitions out to separate files.
- Merge font stack into a single font-family declaration.
- Merge default `font-weight: 400` into a single declaration.
- Drop the `-force-` classes.
- Drop the `--` duplicates of class names with `__`.
- Drop extreme font weights 100, 200, and 900.
- Drop italic.


## Overwrites Not Supported

The following MDL `-force-` class names are not supported in StoreCore CSS:

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

<?php
namespace StoreCore\AMP;

use \StoreCore\Types\StringableInterface as StringableInterface;

/**
 * AMP Custom Style.
 *
 * @author    Ward van der Put <Ward.van.der.Put@storecore.org>
 * @copyright Copyright © 2019 StoreCore™
 * @license   https://www.gnu.org/licenses/gpl.html GNU General Public License
 * @package   StoreCore\CMS
 * @version   0.1.0
 */
class CustomStyle implements StringableInterface
{
    /**
     * @var string VERSION
     *   Semantic Version (SemVer).
     */
    const VERSION = '0.1.0';

    /**
     * @var string $CustomStyleSheet
     *   Cascading Style Sheets (CSS) for additions or overrides.
     */
    protected $CustomStyleSheet = null;

    /**
     * @var array $Root
     *   CSS `:root` element with CSS variables for the current theme.
     */
    protected $Root = array(
        'mdc-layout-grid-margin-desktop'         => '24px',
        'mdc-layout-grid-gutter-desktop'         => '24px',
        'mdc-layout-grid-column-width-desktop'   => '72px',
        'mdc-layout-grid-margin-tablet'          => '16px',
        'mdc-layout-grid-gutter-tablet'          => '16px',
        'mdc-layout-grid-column-width-tablet'    => '72px',
        'mdc-layout-grid-margin-phone'           => '16px',
        'mdc-layout-grid-gutter-phone'           => '16px',
        'mdc-layout-grid-column-width-phone'     => '72px',

        'mdc-theme-primary'                      => '#6200ee',
        'mdc-theme-secondary'                    => '#018786',
        'mdc-theme-background'                   => '#fff',
        'mdc-theme-surface'                      => '#fff',
        'mdc-theme-error'                        => '#b00020',
        'mdc-theme-on-primary'                   => '#fff',
        'mdc-theme-on-secondary'                 => '#fff',
        'mdc-theme-on-surface'                   => '#000',
        'mdc-theme-on-error'                     => '#fff',
        'mdc-theme-text-primary-on-background'   => 'rgba(0,0,0,.87)',
        'mdc-theme-text-secondary-on-background' => 'rgba(0,0,0,.54)',
        'mdc-theme-text-hint-on-background'      => 'rgba(0,0,0,.38)',
        'mdc-theme-text-disabled-on-background'  => 'rgba(0,0,0,.38)',
        'mdc-theme-text-icon-on-background'      => 'rgba(0,0,0,.38)',
        'mdc-theme-text-primary-on-light'        => 'rgba(0,0,0,.87)',
        'mdc-theme-text-secondary-on-light'      => 'rgba(0,0,0,.54)',
        'mdc-theme-text-hint-on-light'           => 'rgba(0,0,0,.38)',
        'mdc-theme-text-disabled-on-light'       => 'rgba(0,0,0,.38)',
        'mdc-theme-text-icon-on-light'           => 'rgba(0,0,0,.38)',
        'mdc-theme-text-primary-on-dark'         => '#fff',
        'mdc-theme-text-secondary-on-dark'       => 'rgba(255,255,255,.7)',
        'mdc-theme-text-hint-on-dark'            => 'rgba(255,255,255,.5)',
        'mdc-theme-text-disabled-on-dark'        => 'rgba(255,255,255,.5)',
        'mdc-theme-text-icon-on-dark'            => 'rgba(255,255,255,.5)',
    );

    /**
     * @var string $StyleSheet
     *   Cascading Style Sheets (CSS) contents of the `<style amp-custom>…</style>`
     *   AMP HTML container.
     */
    protected $StyleSheet = '
        .mdc-button{font:.875rem/2.25rem Roboto,sans-serif;font-weight:500;letter-spacing:.0892857143em;text-decoration:none;text-transform:uppercase;padding:0 8px 0 8px;display:inline-flex;position:relative;align-items:center;justify-content:center;box-sizing:border-box;min-width:64px;height:36px;border:none;outline:none;line-height:inherit;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;-webkit-appearance:none;overflow:hidden;vertical-align:middle;border-radius:4px}
        .mdc-button::-moz-focus-inner{padding:0;border:0}
        .mdc-button:active{outline:none}
        .mdc-button:hover{cursor:pointer}
        .mdc-button:disabled{background-color:transparent;color:rgba(0,0,0,.37);cursor:default;pointer-events:none}
        .mdc-button.mdc-button--dense{border-radius:4px}
        .mdc-button:not(:disabled){background-color:transparent}
        .mdc-button .mdc-button__icon{margin-left:0;margin-right:8px;display:inline-block;width:18px;height:18px;font-size:18px;vertical-align:top}
        .mdc-button:not(:disabled){color:#6200ee;color:var(--mdc-theme-primary,#6200ee)}
        .mdc-button__label+.mdc-button__icon{margin-left:8px;margin-right:0}
        svg.mdc-button__icon{fill:currentColor}
        .mdc-button--raised .mdc-button__icon,.mdc-button--unelevated .mdc-button__icon,.mdc-button--outlined .mdc-button__icon{margin-left:-4px;margin-right:8px}
        .mdc-button--raised .mdc-button__label+.mdc-button__icon,.mdc-button--unelevated .mdc-button__label+.mdc-button__icon,.mdc-button--outlined .mdc-button__label+.mdc-button__icon{margin-left:8px;margin-right:-4px}
        .mdc-button--raised,.mdc-button--unelevated{padding:0 16px 0 16px}
        .mdc-button--raised:disabled,.mdc-button--unelevated:disabled{background-color:rgba(0,0,0,.12);color:rgba(0,0,0,.37)}
        .mdc-button--raised:not(:disabled),.mdc-button--unelevated:not(:disabled){background-color:#6200ee}
        @supports not (-ms-ime-align:auto){.mdc-button--raised:not(:disabled),.mdc-button--unelevated:not(:disabled){background-color:var(--mdc-theme-primary,#6200ee)}}
        .mdc-button--raised:not(:disabled),.mdc-button--unelevated:not(:disabled){color:#fff;color:var(--mdc-theme-on-primary,#fff)}
        .mdc-button--raised{box-shadow:0 3px 1px -2px rgba(0,0,0,.2),0 2px 2px 0 rgba(0,0,0,.14),0 1px 5px 0 rgba(0,0,0,.12);transition:box-shadow 280ms cubic-bezier(.4,0,.2,1)}
        .mdc-button--raised:hover,.mdc-button--raised:focus{box-shadow:0 2px 4px -1px rgba(0,0,0,.2),0 4px 5px 0 rgba(0,0,0,.14),0 1px 10px 0 rgba(0,0,0,.12)}
        .mdc-button--raised:active{box-shadow:0 5px 5px -3px rgba(0,0,0,.2),0 8px 10px 1px rgba(0,0,0,.14),0 3px 14px 2px rgba(0,0,0,.12)}
        .mdc-button--raised:disabled{box-shadow:0 0 0 0 rgba(0,0,0,.2),0 0 0 0 rgba(0,0,0,.14),0 0 0 0 rgba(0,0,0,.12)}
        .mdc-button--outlined{border-style:solid;padding:0 15px 0 15px;border-width:1px}
        .mdc-button--outlined:disabled{border-color:rgba(0,0,0,.37)}
        .mdc-button--outlined:not(:disabled){border-color:#6200ee;border-color:var(--mdc-theme-primary,#6200ee)}
        .mdc-button--dense{height:32px;font-size:.8125rem}
        @keyframes mdc-ripple-fg-radius-in{from{animation-timing-function:cubic-bezier(.4,0,.2,1);transform:translate(var(--mdc-ripple-fg-translate-start,0)) scale(1)}to{transform:translate(var(--mdc-ripple-fg-translate-end,0)) scale(var(--mdc-ripple-fg-scale,1))}}
        @keyframes mdc-ripple-fg-opacity-in{from{animation-timing-function:linear;opacity:0}to{opacity:var(--mdc-ripple-fg-opacity,0)}}
        @keyframes mdc-ripple-fg-opacity-out{from{animation-timing-function:linear;opacity:var(--mdc-ripple-fg-opacity,0)}to{opacity:0}}
        .mdc-ripple-surface--test-edge-var-bug{--mdc-ripple-surface-test-edge-var:1px solid #000;visibility:hidden}
        .mdc-ripple-surface--test-edge-var-bug::before{border:var(--mdc-ripple-surface-test-edge-var)}
        .mdc-button{--mdc-ripple-fg-size:0;--mdc-ripple-left:0;--mdc-ripple-top:0;--mdc-ripple-fg-scale:1;--mdc-ripple-fg-translate-end:0;--mdc-ripple-fg-translate-start:0;-webkit-tap-highlight-color:rgba(0,0,0,0);will-change:transform,opacity}
        .mdc-button::before,.mdc-button::after{position:absolute;border-radius:50%;opacity:0;pointer-events:none;content:""}
        .mdc-button::before{transition:opacity 15ms linear,background-color 15ms linear;z-index:1}
        .mdc-button::before,.mdc-button::after{background-color:#6200ee;top:calc(50% - 100%);left:calc(50% - 100%);width:200%;height:200%}
        @supports not (-ms-ime-align:auto){.mdc-button::before,.mdc-button::after{background-color:var(--mdc-theme-primary,#6200ee)}}
        .mdc-button:hover::before{opacity:.04}
        .mdc-button:focus::before,.mdc-button:active::after{transition-duration:75ms;opacity:.12}
        .mdc-button::after{transition:opacity 150ms linear}
        .mdc-button--raised::before,.mdc-button--raised::after,.mdc-button--unelevated::before,.mdc-button--unelevated::after{background-color:#fff}
        @supports not (-ms-ime-align:auto){.mdc-button--raised::before,.mdc-button--raised::after,.mdc-button--unelevated::before,.mdc-button--unelevated::after{background-color:var(--mdc-theme-on-primary,#fff)}}
        .mdc-button--raised:hover::before,.mdc-button--unelevated:hover::before{opacity:.08}
        .mdc-button--raised:focus::before,.mdc-button--unelevated:focus::before,.mdc-button--raised:active::after,.mdc-button--unelevated:active::after{transition-duration:75ms;opacity:.24}
        .mdc-button--raised::after,.mdc-button--unelevated::after{transition:opacity 150ms linear}

        .mdc-card{border-radius:4px;background-color:#fff;background-color:var(--mdc-theme-surface,#fff);box-shadow:0 2px 1px -1px rgba(0,0,0,.2),0 1px 1px 0 rgba(0,0,0,.14),0 1px 3px 0 rgba(0,0,0,.12);display:flex;flex-direction:column;box-sizing:border-box}
        .mdc-card--outlined{box-shadow:0 0 0 0 rgba(0,0,0,.2),0 0 0 0 rgba(0,0,0,.14),0 0 0 0 rgba(0,0,0,.12);border-width:1px;border-style:solid;border-color:#e0e0e0}
        .mdc-card__media{position:relative;box-sizing:border-box;background-repeat:no-repeat;background-position:center;background-size:cover}
        .mdc-card__media::before{display:block;content:""}
        .mdc-card__media:first-child{border-top-left-radius:inherit;border-top-right-radius:inherit}
        .mdc-card__media:last-child{border-bottom-left-radius:inherit;border-bottom-right-radius:inherit}
        .mdc-card__media--square::before{margin-top:100%}
        .mdc-card__media--16-9::before{margin-top:56.25%}
        .mdc-card__media-content{position:absolute;top:0;right:0;bottom:0;left:0;box-sizing:border-box}
        .mdc-card__primary-action{display:flex;flex-direction:column;box-sizing:border-box;position:relative;outline:none;color:inherit;text-decoration:none;cursor:pointer;overflow:hidden}
        .mdc-card__primary-action:first-child{border-top-left-radius:inherit;border-top-right-radius:inherit}
        .mdc-card__primary-action:last-child{border-bottom-left-radius:inherit;border-bottom-right-radius:inherit}
        .mdc-card__actions{display:flex;flex-direction:row;align-items:center;box-sizing:border-box;min-height:52px;padding:8px}
        .mdc-card__actions--full-bleed{padding:0}
        .mdc-card__action-buttons,.mdc-card__action-icons{display:flex;flex-direction:row;align-items:center;box-sizing:border-box}
        .mdc-card__action-icons{color:rgba(0,0,0,.6);flex-grow:1;justify-content:flex-end}
        .mdc-card__action-buttons+.mdc-card__action-icons{margin-left:16px;margin-right:0}
        .mdc-card__action{display:inline-flex;flex-direction:row;align-items:center;box-sizing:border-box;justify-content:center;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}
        .mdc-card__action:focus{outline:none}
        .mdc-card__action--button{margin-left:0;margin-right:8px;padding:0 8px}
        .mdc-card__action--button:last-child{margin-left:0;margin-right:0}
        .mdc-card__actions--full-bleed .mdc-card__action--button{justify-content:space-between;width:100%;height:auto;max-height:none;margin:0;padding:8px 16px;text-align:left}
        .mdc-card__action--icon{margin:-6px 0;padding:12px}
        .mdc-card__action--icon:not(:disabled){color:rgba(0,0,0,.6)}
        .mdc-card__primary-action{--mdc-ripple-fg-size:0;--mdc-ripple-left:0;--mdc-ripple-top:0;--mdc-ripple-fg-scale:1;--mdc-ripple-fg-translate-end:0;--mdc-ripple-fg-translate-start:0;-webkit-tap-highlight-color:rgba(0,0,0,0);will-change:transform,opacity}
        .mdc-card__primary-action::before,.mdc-card__primary-action::after{position:absolute;border-radius:50%;opacity:0;pointer-events:none;content:""}
        .mdc-card__primary-action::before{transition:opacity 15ms linear,background-color 15ms linear;z-index:1}
        .mdc-card__primary-action::before,.mdc-card__primary-action::after{background-color:#000;top:calc(50% - 100%);left:calc(50% - 100%);width:200%;height:200%}
        .mdc-card__primary-action:hover::before{opacity:.04}
        .mdc-card__primary-action::after{transition:opacity 150ms linear}
        .mdc-card__primary-action:focus::before,.mdc-card__primary-action:active::after{transition-duration:75ms;opacity:.12}

        .mdc-chip__icon--leading,.mdc-chip__icon--trailing{color:rgba(0,0,0,.54)}
        .mdc-chip__icon--trailing:hover{color:rgba(0,0,0,.62)}
        .mdc-chip__icon--trailing:focus{color:rgba(0,0,0,.87)}
        .mdc-chip__icon.mdc-chip__icon--leading:not(.mdc-chip__icon--leading-hidden){width:20px;height:20px;font-size:20px}
        .mdc-chip__icon.mdc-chip__icon--trailing{width:18px;height:18px;font-size:18px}
        .mdc-chip__icon--trailing{margin:0 -4px 0 4px}
        .mdc-chip{border-radius:16px;background-color:#e0e0e0;color:rgba(0,0,0,.87);font:.875rem/1.25 Roboto,sans-serif;font-weight:400;letter-spacing:.0178571429em;text-decoration:inherit;text-transform:inherit;height:32px;display:inline-flex;position:relative;align-items:center;box-sizing:border-box;padding:7px 12px;outline:none;cursor:pointer;overflow:hidden}
        .mdc-chip:hover{color:rgba(0,0,0,.87)}
        .mdc-chip.mdc-chip--selected .mdc-chip__checkmark,.mdc-chip .mdc-chip__icon--leading:not(.mdc-chip__icon--leading-hidden){margin-left:-4px;margin-right:4px;margin-top:-4px;margin-bottom:-4px}
        .mdc-chip:hover{color:#000;color:var(--mdc-theme-on-surface,#000)}
        .mdc-chip--exit{transition:opacity 75ms cubic-bezier(.4,0,.2,1),width 150ms cubic-bezier(0,0,.2,1),padding 100ms linear,margin 100ms linear;opacity:0}
        .mdc-chip__text{white-space:nowrap}
        .mdc-chip__icon{border-radius:50%;outline:none;vertical-align:middle}
        .mdc-chip__checkmark{height:20px}
        .mdc-chip__checkmark-path{transition:stroke-dashoffset 150ms 50ms cubic-bezier(.4,0,.6,1);stroke-width:2px;stroke-dashoffset:29.7833385;stroke-dasharray:29.7833385}
        .mdc-chip--selected .mdc-chip__checkmark-path{stroke-dashoffset:0}
        .mdc-chip-set--choice .mdc-chip.mdc-chip--selected{color:#6200ee;color:var(--mdc-theme-primary,#6200ee)}
        .mdc-chip-set--choice .mdc-chip.mdc-chip--selected .mdc-chip__icon--leading{color:rgba(98,0,238,.54)}
        .mdc-chip-set--choice .mdc-chip.mdc-chip--selected:hover{color:#6200ee;color:var(--mdc-theme-primary,#6200ee)}
        .mdc-chip-set--choice .mdc-chip .mdc-chip__checkmark-path{stroke:#6200ee;stroke:var(--mdc-theme-primary,#6200ee)}
        .mdc-chip-set--choice .mdc-chip--selected{background-color:#fff;background-color:var(--mdc-theme-surface,#fff)}
        .mdc-chip__checkmark-svg{width:0;height:20px;transition:width 150ms cubic-bezier(.4,0,.2,1)}
        .mdc-chip--selected .mdc-chip__checkmark-svg{width:20px}
        .mdc-chip-set--filter .mdc-chip__icon--leading{transition:opacity 75ms linear;transition-delay:-50ms;opacity:1}
        .mdc-chip-set--filter .mdc-chip__icon--leading+.mdc-chip__checkmark{transition:opacity 75ms linear;transition-delay:80ms;opacity:0}
        .mdc-chip-set--filter .mdc-chip__icon--leading+.mdc-chip__checkmark .mdc-chip__checkmark-svg{transition:width 0ms}
        .mdc-chip-set--filter .mdc-chip--selected .mdc-chip__icon--leading{opacity:0}
        .mdc-chip-set--filter .mdc-chip--selected .mdc-chip__icon--leading+.mdc-chip__checkmark{width:0;opacity:1}
        .mdc-chip-set--filter .mdc-chip__icon--leading-hidden.mdc-chip__icon--leading{width:0;opacity:0}
        .mdc-chip-set--filter .mdc-chip__icon--leading-hidden.mdc-chip__icon--leading+.mdc-chip__checkmark{width:20px}
        .mdc-chip{--mdc-ripple-fg-size:0;--mdc-ripple-left:0;--mdc-ripple-top:0;--mdc-ripple-fg-scale:1;--mdc-ripple-fg-translate-end:0;--mdc-ripple-fg-translate-start:0;-webkit-tap-highlight-color:rgba(0,0,0,0)}
        .mdc-chip::before,.mdc-chip::after{position:absolute;border-radius:50%;opacity:0;pointer-events:none;content:""}
        .mdc-chip::before{transition:opacity 15ms linear,background-color 15ms linear;z-index:1}
        .mdc-chip::before,.mdc-chip::after{top:calc(50% - 100%);left:calc(50% - 100%);width:200%;height:200%}
        .mdc-chip::before,.mdc-chip::after{background-color:rgba(0,0,0,.87)}
        .mdc-chip:hover::before{opacity:.04}
        .mdc-chip:focus::before{transition-duration:75ms;opacity:.12}
        .mdc-chip::after{transition:opacity 150ms linear}
        .mdc-chip:active::after{transition-duration:75ms;opacity:.12}
        .mdc-chip-set--choice .mdc-chip.mdc-chip--selected::before{opacity:.08}
        .mdc-chip-set--choice .mdc-chip.mdc-chip--selected::before,.mdc-chip-set--choice .mdc-chip.mdc-chip--selected::after{background-color:#6200ee}
        @supports not (-ms-ime-align:auto){.mdc-chip-set--choice .mdc-chip.mdc-chip--selected::before,.mdc-chip-set--choice .mdc-chip.mdc-chip--selected::after{background-color:var(--mdc-theme-primary,#6200ee)}}
        .mdc-chip-set--choice .mdc-chip.mdc-chip--selected:hover::before{opacity:.12}
        .mdc-chip-set--choice .mdc-chip.mdc-chip--selected:focus::before{transition-duration:75ms;opacity:.2}
        .mdc-chip-set--choice .mdc-chip.mdc-chip--selected::after{transition:opacity 150ms linear}
        .mdc-chip-set--choice .mdc-chip.mdc-chip--selected:active::after{transition-duration:75ms;opacity:.2}
        @keyframes mdc-chip-entry{from{transform:scale(.8);opacity:.4}to{transform:scale(1);opacity:1}}
        .mdc-chip-set{padding:4px;display:flex;flex-wrap:wrap;box-sizing:border-box}
        .mdc-chip-set .mdc-chip{margin:4px}
        .mdc-chip-set--input .mdc-chip{animation:mdc-chip-entry 100ms cubic-bezier(0,0,.2,1)}

        .mdc-drawer{border-color:rgba(0,0,0,.12);background-color:#fff;border-radius:0;width:256px;display:flex;flex-direction:column;flex-shrink:0;box-sizing:border-box;height:100%;transition-property:transform;transition-timing-function:cubic-bezier(.4,0,.2,1);border-right-width:1px;border-right-style:solid;overflow:hidden}
        .mdc-drawer .mdc-drawer__title,.mdc-drawer .mdc-list-item{color:rgba(0,0,0,.87)}
        .mdc-drawer .mdc-list-group__subheader,.mdc-drawer .mdc-drawer__subtitle,.mdc-drawer .mdc-list-item__graphic{color:rgba(0,0,0,.6)}
        .mdc-drawer .mdc-list-item--activated .mdc-list-item__graphic{color:#6200ee}
        .mdc-drawer .mdc-list-item--activated{color:rgba(98,0,238,.87)}
        .mdc-drawer .mdc-list-item{border-radius:4px}
        .mdc-drawer .mdc-list-item{font:.875rem/1.375rem Roboto,sans-serif;font-weight:500;letter-spacing:.0071428571em;text-decoration:inherit;text-transform:inherit;height:calc(48px - 2 * 4px);margin:8px 8px;padding:0 8px}
        .mdc-drawer .mdc-list-item:nth-child(1){margin-top:2px}
        .mdc-drawer .mdc-list-item:nth-last-child(1){margin-bottom:0}
        .mdc-drawer .mdc-list-group__subheader{font:.875rem/1.25 Roboto,sans-serif;font-weight:400;letter-spacing:.0178571429em;text-decoration:inherit;text-transform:inherit;display:block;margin-top:0;line-height:normal;margin:0;padding:0 16px}
        .mdc-drawer .mdc-list-group__subheader::before{display:inline-block;width:0;height:24px;content:"";vertical-align:0}
        .mdc-drawer .mdc-list-divider{margin:3px 0 4px 0}
        .mdc-drawer .mdc-list-item__text,.mdc-drawer .mdc-list-item__graphic{pointer-events:none}
        .mdc-drawer__header{flex-shrink:0;box-sizing:border-box;min-height:64px;padding:0 16px 4px}
        .mdc-drawer__title{font:1.25rem/2rem Roboto,sans-serif;font-weight:500;letter-spacing:.0125em;text-decoration:inherit;text-transform:inherit;display:block;margin-top:0;line-height:normal;margin-bottom:-20px}
        .mdc-drawer__title::before{display:inline-block;width:0;height:36px;content:"";vertical-align:0}
        .mdc-drawer__title::after{display:inline-block;width:0;height:20px;content:"";vertical-align:-20px}
        .mdc-drawer__subtitle{font:.875rem/1.25 Roboto,sans-serif;font-weight:400;letter-spacing:.0178571429em;text-decoration:inherit;text-transform:inherit;display:block;margin-top:0;line-height:normal;margin-bottom:0}
        .mdc-drawer__subtitle::before{display:inline-block;width:0;height:20px;content:"";vertical-align:0}
        .mdc-drawer__content{height:100%;overflow-y:auto;-webkit-overflow-scrolling:touch}
        .mdc-drawer-app-content{margin-left:0;margin-right:0;position:relative}

        .mdc-fab{box-shadow:0 3px 5px -1px rgba(0,0,0,.2),0 6px 10px 0 rgba(0,0,0,.14),0 1px 18px 0 rgba(0,0,0,.12);display:inline-flex;position:relative;align-items:center;justify-content:center;box-sizing:border-box;width:56px;height:56px;padding:0;border:none;fill:currentColor;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;-moz-appearance:none;-webkit-appearance:none;overflow:hidden;transition:box-shadow 280ms cubic-bezier(.4,0,.2,1),opacity 15ms linear 30ms,transform 270ms 0ms cubic-bezier(0,0,.2,1);background-color:#018786;color:#fff;color:var(--mdc-theme-on-secondary,#fff)}
        .mdc-fab:not(.mdc-fab--extended){border-radius:50%}
        .mdc-fab::-moz-focus-inner{padding:0;border:0}
        .mdc-fab:hover,.mdc-fab:focus{box-shadow:0 5px 5px -3px rgba(0,0,0,.2),0 8px 10px 1px rgba(0,0,0,.14),0 3px 14px 2px rgba(0,0,0,.12)}
        .mdc-fab:active{box-shadow:0 7px 8px -4px rgba(0,0,0,.2),0 12px 17px 2px rgba(0,0,0,.14),0 5px 22px 4px rgba(0,0,0,.12)}
        .mdc-fab:active,.mdc-fab:focus{outline:none}
        .mdc-fab:hover{cursor:pointer}
        .mdc-fab>svg{width:100%}
        @supports not (-ms-ime-align:auto){.mdc-fab{background-color:var(--mdc-theme-secondary,#018786)}}
        .mdc-fab .mdc-fab__icon{width:24px;height:24px;font-size:24px}
        .mdc-fab--mini{width:40px;height:40px}
        .mdc-fab--extended{font:.875rem/2.25rem Roboto,sans-serif;font-weight:500;letter-spacing:.0892857143em;text-decoration:none;text-transform:uppercase;border-radius:24px;padding:0 20px;width:auto;max-width:100%;height:48px}
        .mdc-fab--extended .mdc-fab__icon{margin-left:-8px;margin-right:12px}
        .mdc-fab--extended .mdc-fab__label+.mdc-fab__icon{margin-left:12px;margin-right:-8px}
        .mdc-fab__label{justify-content:flex-start;text-overflow:ellipsis;white-space:nowrap;overflow:hidden}
        .mdc-fab__icon{transition:transform 180ms 90ms cubic-bezier(0,0,.2,1);fill:currentColor;will-change:transform}
        .mdc-fab .mdc-fab__icon{display:inline-flex;align-items:center;justify-content:center}
        .mdc-fab--exited{transform:scale(0);opacity:0;transition:opacity 15ms linear 150ms,transform 180ms 0ms cubic-bezier(.4,0,1,1)}
        .mdc-fab--exited .mdc-fab__icon{transform:scale(0);transition:transform 135ms 0ms cubic-bezier(.4,0,1,1)}
        .mdc-fab{--mdc-ripple-fg-size:0;--mdc-ripple-left:0;--mdc-ripple-top:0;--mdc-ripple-fg-scale:1;--mdc-ripple-fg-translate-end:0;--mdc-ripple-fg-translate-start:0;-webkit-tap-highlight-color:rgba(0,0,0,0);will-change:transform,opacity}
        .mdc-fab::before,.mdc-fab::after{position:absolute;border-radius:50%;opacity:0;pointer-events:none;content:""}
        .mdc-fab::before{transition:opacity 15ms linear,background-color 15ms linear;z-index:1}
        .mdc-fab::before,.mdc-fab::after{background-color:#fff;top:calc(50% - 100%);left:calc(50% - 100%);width:200%;height:200%}
        @supports not (-ms-ime-align:auto){.mdc-fab::before,.mdc-fab::after{background-color:var(--mdc-theme-on-secondary,#fff)}}
        .mdc-fab:hover::before{opacity:.08}
        .mdc-fab::after{transition:opacity 150ms linear}
        .mdc-fab:focus::before,.mdc-fab:active::after{transition-duration:75ms;opacity:.24}

        .mdc-list{font:1rem/1.75rem Roboto,sans-serif;font-weight:400;letter-spacing:.009375em;text-decoration:inherit;text-transform:inherit;line-height:1.5rem;margin:0;padding:8px 0;list-style-type:none;color:rgba(0,0,0,.87);color:var(--mdc-theme-text-primary-on-background,rgba(0,0,0,.87))}
        .mdc-list:focus{outline:none}
        .mdc-list-item__secondary-text{color:rgba(0,0,0,.54);color:var(--mdc-theme-text-secondary-on-background,rgba(0,0,0,.54))}
        .mdc-list-item__graphic{background-color:transparent;color:rgba(0,0,0,.38);color:var(--mdc-theme-text-icon-on-background,rgba(0,0,0,.38))}
        .mdc-list-item__meta{color:rgba(0,0,0,.38);color:var(--mdc-theme-text-hint-on-background,rgba(0,0,0,.38))}
        .mdc-list-group__subheader{color:rgba(0,0,0,.87);color:var(--mdc-theme-text-primary-on-background,rgba(0,0,0,.87))}
        .mdc-list--dense{padding-top:4px;padding-bottom:4px;font-size:.812rem}
        .mdc-list-item{display:flex;position:relative;align-items:center;justify-content:flex-start;height:48px;padding:0 16px;overflow:hidden}
        .mdc-list-item:focus{outline:none}
        .mdc-list-item--selected,.mdc-list-item--activated{color:#6200ee;color:var(--mdc-theme-primary,#6200ee)}
        .mdc-list-item--selected .mdc-list-item__graphic,.mdc-list-item--activated .mdc-list-item__graphic{color:#6200ee;color:var(--mdc-theme-primary,#6200ee)}
        .mdc-list-item--disabled{color:rgba(0,0,0,.38);color:var(--mdc-theme-text-disabled-on-background,rgba(0,0,0,.38))}
        .mdc-list-item__graphic{margin-left:0;margin-right:32px;width:24px;height:24px;flex-shrink:0;align-items:center;justify-content:center;fill:currentColor}
        .mdc-list .mdc-list-item__graphic{display:inline-flex}
        .mdc-list-item__meta{margin-left:auto;margin-right:0}
        .mdc-list-item__meta:not(.material-icons){font:.75rem/1.25rem Roboto,sans-serif;font-weight:400;letter-spacing:.0333333333em;text-decoration:inherit;text-transform:inherit}
        .mdc-list-item__text{text-overflow:ellipsis;white-space:nowrap;overflow:hidden}
        .mdc-list-item__text[for]{pointer-events:none}
        .mdc-list-item__primary-text{text-overflow:ellipsis;white-space:nowrap;overflow:hidden;display:block;margin-top:0;line-height:normal;margin-bottom:-20px;display:block}
        .mdc-list-item__primary-text::before{display:inline-block;width:0;height:32px;content:"";vertical-align:0}
        .mdc-list-item__primary-text::after{display:inline-block;width:0;height:20px;content:"";vertical-align:-20px}
        .mdc-list--dense .mdc-list-item__primary-text{display:block;margin-top:0;line-height:normal;margin-bottom:-20px}
        .mdc-list--dense .mdc-list-item__primary-text::before{display:inline-block;width:0;height:24px;content:"";vertical-align:0}
        .mdc-list--dense .mdc-list-item__primary-text::after{display:inline-block;width:0;height:20px;content:"";vertical-align:-20px}
        .mdc-list-item__secondary-text{font:.875rem/1.25 Roboto,sans-serif;font-weight:400;letter-spacing:.0178571429em;text-decoration:inherit;text-transform:inherit;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;display:block;margin-top:0;line-height:normal;display:block}
        .mdc-list-item__secondary-text::before{display:inline-block;width:0;height:20px;content:"";vertical-align:0}
        .mdc-list--dense .mdc-list-item__secondary-text{display:block;margin-top:0;line-height:normal;font-size:inherit}
        .mdc-list--dense .mdc-list-item__secondary-text::before{display:inline-block;width:0;height:20px;content:"";vertical-align:0}
        .mdc-list--dense .mdc-list-item{height:40px}
        .mdc-list--dense .mdc-list-item__graphic{margin-left:0;margin-right:36px;width:20px;height:20px}
        .mdc-list--avatar-list .mdc-list-item{height:56px}
        .mdc-list--avatar-list .mdc-list-item__graphic{margin-left:0;margin-right:16px;width:40px;height:40px;border-radius:50%}
        .mdc-list--two-line .mdc-list-item__text{align-self:flex-start}
        .mdc-list--two-line .mdc-list-item{height:72px}
        .mdc-list--two-line.mdc-list--dense .mdc-list-item,.mdc-list--avatar-list.mdc-list--dense .mdc-list-item{height:60px}
        .mdc-list--avatar-list.mdc-list--dense .mdc-list-item__graphic{margin-left:0;margin-right:20px;width:36px;height:36px}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item{cursor:pointer}
        a.mdc-list-item{color:inherit;text-decoration:none}
        .mdc-list-divider{height:0;margin:0;border:none;border-bottom-width:1px;border-bottom-style:solid}
        .mdc-list-divider{border-bottom-color:rgba(0,0,0,.12)}
        .mdc-list-divider--padded{margin:0 16px}
        .mdc-list-divider--inset{margin-left:72px;margin-right:0;width:calc(100% - 72px)}
        .mdc-list-divider--inset.mdc-list-divider--padded{width:calc(100% - 72px - 16px)}
        .mdc-list-group .mdc-list{padding:0}
        .mdc-list-group__subheader{font:1rem/1.75rem Roboto,sans-serif;font-weight:400;letter-spacing:.009375em;text-decoration:inherit;text-transform:inherit;margin:.75rem 16px}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item{--mdc-ripple-fg-size:0;--mdc-ripple-left:0;--mdc-ripple-top:0;--mdc-ripple-fg-scale:1;--mdc-ripple-fg-translate-end:0;--mdc-ripple-fg-translate-start:0;-webkit-tap-highlight-color:rgba(0,0,0,0)}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item::after{position:absolute;border-radius:50%;opacity:0;pointer-events:none;content:""}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item::before{transition:opacity 15ms linear,background-color 15ms linear;z-index:1}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item::after{top:calc(50% - 100%);left:calc(50% - 100%);width:200%;height:200%}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item::after{background-color:#000}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item:hover::before{opacity:.04}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item:not(.mdc-ripple-upgraded):focus::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item.mdc-ripple-upgraded--background-focused::before{transition-duration:75ms;opacity:.12}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item:not(.mdc-ripple-upgraded)::after{transition:opacity 150ms linear}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item:not(.mdc-ripple-upgraded):active::after{transition-duration:75ms;opacity:.12}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated::before{opacity:.12}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated::after{background-color:#6200ee}
        @supports not (-ms-ime-align:auto){:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated::after{background-color:var(--mdc-theme-primary,#6200ee)}}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated:hover::before{opacity:.16}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated:not(.mdc-ripple-upgraded):focus::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated.mdc-ripple-upgraded--background-focused::before{transition-duration:75ms;opacity:.24}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated:not(.mdc-ripple-upgraded)::after{transition:opacity 150ms linear}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--activated:not(.mdc-ripple-upgraded):active::after{transition-duration:75ms;opacity:.24}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected::before{opacity:.08}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected::after{background-color:#6200ee}
        @supports not (-ms-ime-align:auto){:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected::after{background-color:var(--mdc-theme-primary,#6200ee)}}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected:hover::before{opacity:.12}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected:not(.mdc-ripple-upgraded):focus::before,:not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected.mdc-ripple-upgraded--background-focused::before{transition-duration:75ms;opacity:.2}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected:not(.mdc-ripple-upgraded)::after{transition:opacity 150ms linear}
        :not(.mdc-list--non-interactive)>:not(.mdc-list-item--disabled).mdc-list-item--selected:not(.mdc-ripple-upgraded):active::after{transition-duration:75ms;opacity:.2}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled{--mdc-ripple-fg-size:0;--mdc-ripple-left:0;--mdc-ripple-top:0;--mdc-ripple-fg-scale:1;--mdc-ripple-fg-translate-end:0;--mdc-ripple-fg-translate-start:0;-webkit-tap-highlight-color:rgba(0,0,0,0)}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled::before,:not(.mdc-list--non-interactive)>.mdc-list-item--disabled::after{position:absolute;border-radius:50%;opacity:0;pointer-events:none;content:""}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled::before{transition:opacity 15ms linear,background-color 15ms linear;z-index:1}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled.mdc-ripple-upgraded::before{transform:scale(var(--mdc-ripple-fg-scale,1))}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled.mdc-ripple-upgraded::after{top:0;left:0;transform:scale(0);transform-origin:center center}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled.mdc-ripple-upgraded--unbounded::after{top:var(--mdc-ripple-top,0);left:var(--mdc-ripple-left,0)}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled.mdc-ripple-upgraded--foreground-activation::after{animation:mdc-ripple-fg-radius-in 225ms forwards,mdc-ripple-fg-opacity-in 75ms forwards}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled.mdc-ripple-upgraded--foreground-deactivation::after{animation:mdc-ripple-fg-opacity-out 150ms;transform:translate(var(--mdc-ripple-fg-translate-end,0)) scale(var(--mdc-ripple-fg-scale,1))}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled::before,:not(.mdc-list--non-interactive)>.mdc-list-item--disabled::after{top:calc(50% - 100%);left:calc(50% - 100%);width:200%;height:200%}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled.mdc-ripple-upgraded::after{width:var(--mdc-ripple-fg-size,100%);height:var(--mdc-ripple-fg-size,100%)}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled::before,:not(.mdc-list--non-interactive)>.mdc-list-item--disabled::after{background-color:#000}
        :not(.mdc-list--non-interactive)>.mdc-list-item--disabled:not(.mdc-ripple-upgraded):focus::before,:not(.mdc-list--non-interactive)>.mdc-list-item--disabled.mdc-ripple-upgraded--background-focused::before{transition-duration:75ms;opacity:.12}

        .mdc-tab{position:relative;font:.875rem/2.25rem Roboto,sans-serif;font-weight:500;letter-spacing:.0892857143em;text-decoration:none;text-transform:uppercase;padding-right:24px;padding-left:24px;display:flex;flex:1 0 auto;justify-content:center;box-sizing:border-box;height:48px;margin:0;padding-top:0;padding-bottom:0;border:none;outline:none;background:none;text-align:center;white-space:nowrap;cursor:pointer;-webkit-appearance:none;z-index:1}
        .mdc-tab .mdc-tab__text-label{color:rgba(0,0,0,.6)}
        .mdc-tab .mdc-tab__icon{color:rgba(0,0,0,.54);fill:currentColor}
        .mdc-tab::-moz-focus-inner{padding:0;border:0}
        .mdc-tab--min-width{flex:0 1 auto}
        .mdc-tab__ripple{--mdc-ripple-fg-size:0;--mdc-ripple-left:0;--mdc-ripple-top:0;--mdc-ripple-fg-scale:1;--mdc-ripple-fg-translate-end:0;--mdc-ripple-fg-translate-start:0;-webkit-tap-highlight-color:rgba(0,0,0,0);will-change:transform,opacity;position:absolute;top:0;left:0;width:100%;height:100%;overflow:hidden}
        .mdc-tab__ripple::before,.mdc-tab__ripple::after{position:absolute;border-radius:50%;opacity:0;pointer-events:none;content:""}
        .mdc-tab__ripple::before{transition:opacity 15ms linear,background-color 15ms linear;z-index:1}
        .mdc-tab__ripple::before,.mdc-tab__ripple::after{top:calc(50% - 100%);left:calc(50% - 100%);width:200%;height:200%}
        .mdc-tab__ripple::before,.mdc-tab__ripple::after{background-color:#6200ee}
        @supports not (-ms-ime-align:auto){.mdc-tab__ripple::before,.mdc-tab__ripple::after{background-color:var(--mdc-theme-primary,#6200ee)}}
        .mdc-tab__ripple:hover::before{opacity:.04}
        .mdc-tab__ripple:focus::before{transition-duration:75ms;opacity:.12}
        .mdc-tab__ripple::after{transition:opacity 150ms linear}
        .mdc-tab__ripple:active::after{transition-duration:75ms;opacity:.12}
        .mdc-tab__content{position:relative;display:flex;align-items:center;justify-content:center;height:inherit;pointer-events:none}
        .mdc-tab__text-label,.mdc-tab__icon{transition:150ms color linear;z-index:2}
        .mdc-tab__text-label{display:inline-block;line-height:1}
        .mdc-tab__icon{width:24px;height:24px;font-size:24px}
        .mdc-tab--stacked{height:72px}
        .mdc-tab--stacked .mdc-tab__content{flex-direction:column;align-items:center;justify-content:space-between}
        .mdc-tab--stacked .mdc-tab__icon{padding-top:12px}
        .mdc-tab--stacked .mdc-tab__text-label{padding-bottom:16px}
        .mdc-tab--active .mdc-tab__text-label{color:#6200ee}
        .mdc-tab--active .mdc-tab__icon{color:#6200ee;fill:currentColor}
        .mdc-tab--active .mdc-tab__text-label,.mdc-tab--active .mdc-tab__icon{transition-delay:100ms}
        .mdc-tab:not(.mdc-tab--stacked) .mdc-tab__icon+.mdc-tab__text-label{padding-left:8px;padding-right:0}
        .mdc-tab-bar{width:100%}
        .mdc-tab-indicator{display:flex;position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:1}
        .mdc-tab-indicator .mdc-tab-indicator__content--underline{border-color:#6200ee;border-color:var(--mdc-theme-primary,#6200ee)}
        .mdc-tab-indicator .mdc-tab-indicator__content--underline{border-top-width:2px}
        .mdc-tab-indicator .mdc-tab-indicator__content--icon{color:#018786;color:var(--mdc-theme-secondary,#018786)}
        .mdc-tab-indicator .mdc-tab-indicator__content--icon{height:34px;font-size:34px}
        .mdc-tab-indicator__content{transform-origin:left;opacity:0}
        .mdc-tab-indicator__content--underline{align-self:flex-end;box-sizing:border-box;width:100%;border-top-style:solid}
        .mdc-tab-indicator__content--icon{align-self:center;margin:0 auto}
        .mdc-tab-indicator--active .mdc-tab-indicator__content{opacity:1}
        .mdc-tab-indicator .mdc-tab-indicator__content{transition:250ms transform cubic-bezier(.4,0,.2,1)}
        .mdc-tab-indicator--no-transition .mdc-tab-indicator__content{transition:none}
        .mdc-tab-indicator--fade .mdc-tab-indicator__content{transition:150ms opacity linear}
        .mdc-tab-indicator--active.mdc-tab-indicator--fade .mdc-tab-indicator__content{transition-delay:100ms}
        .mdc-tab-scroller{overflow-y:hidden}
        .mdc-tab-scroller__test{position:absolute;top:-9999px;width:100px;height:100px;overflow-x:scroll}
        .mdc-tab-scroller__scroll-area{-webkit-overflow-scrolling:touch;display:flex;overflow-x:hidden}
        .mdc-tab-scroller__scroll-area::-webkit-scrollbar,.mdc-tab-scroller__test::-webkit-scrollbar{display:none}
        .mdc-tab-scroller__scroll-area--scroll{overflow-x:scroll}
        .mdc-tab-scroller__scroll-content{position:relative;display:flex;flex:1 0 auto;transform:none;will-change:transform}
        .mdc-tab-scroller--align-start .mdc-tab-scroller__scroll-content{justify-content:flex-start}
        .mdc-tab-scroller--align-end .mdc-tab-scroller__scroll-content{justify-content:flex-end}
        .mdc-tab-scroller--align-center .mdc-tab-scroller__scroll-content{justify-content:center}
        .mdc-tab-scroller--animating .mdc-tab-scroller__scroll-area{-webkit-overflow-scrolling:auto}
        .mdc-tab-scroller--animating .mdc-tab-scroller__scroll-content{transition:250ms transform cubic-bezier(.4,0,.2,1)}

        .mdc-text-field--with-leading-icon .mdc-text-field__icon,.mdc-text-field--with-trailing-icon .mdc-text-field__icon{position:absolute;bottom:16px;cursor:pointer}
        .mdc-text-field{--mdc-ripple-fg-size:0;--mdc-ripple-left:0;--mdc-ripple-top:0;--mdc-ripple-fg-scale:1;--mdc-ripple-fg-translate-end:0;--mdc-ripple-fg-translate-start:0;-webkit-tap-highlight-color:rgba(0,0,0,0);border-radius:4px 4px 0 0;display:inline-flex;position:relative;box-sizing:border-box;height:56px;overflow:hidden;will-change:opacity,transform,color}
        .mdc-text-field::before,.mdc-text-field::after{position:absolute;border-radius:50%;opacity:0;pointer-events:none;content:""}
        .mdc-text-field::before{transition:opacity 15ms linear,background-color 15ms linear;z-index:1}
        .mdc-text-field::before,.mdc-text-field::after{background-color:rgba(0,0,0,.87)}
        .mdc-text-field:hover::before{opacity:.04}
        .mdc-text-field::before,.mdc-text-field::after{top:calc(50% - 100%);left:calc(50% - 100%);width:200%;height:200%}
        .mdc-text-field:not(.mdc-text-field--disabled) .mdc-text-field__input{color:rgba(0,0,0,.87)}
        .mdc-text-field .mdc-text-field__input{caret-color:#6200ee;caret-color:var(--mdc-theme-primary,#6200ee)}
        .mdc-text-field:not(.mdc-text-field--disabled):not(.mdc-text-field--outlined):not(.mdc-text-field--textarea) .mdc-text-field__input{border-bottom-color:rgba(0,0,0,.42)}
        .mdc-text-field:not(.mdc-text-field--disabled):not(.mdc-text-field--outlined):not(.mdc-text-field--textarea) .mdc-text-field__input:hover{border-bottom-color:rgba(0,0,0,.87)}
        .mdc-text-field .mdc-line-ripple{background-color:#6200ee;background-color:var(--mdc-theme-primary,#6200ee)}
        .mdc-text-field:not(.mdc-text-field--disabled):not(.mdc-text-field--textarea){border-bottom-color:rgba(0,0,0,.12)}
        .mdc-text-field:not(.mdc-text-field--disabled) .mdc-text-field__icon{color:rgba(0,0,0,.54)}
        .mdc-text-field:not(.mdc-text-field--disabled){background-color:#f5f5f5}
        .mdc-text-field__input{font:1rem/1.75rem Roboto,sans-serif;font-weight:400;letter-spacing:.009375em;text-decoration:inherit;text-transform:inherit;align-self:flex-end;box-sizing:border-box;width:100%;height:100%;padding:20px 16px 6px;transition:opacity 150ms cubic-bezier(.4,0,.2,1);border:none;border-bottom:1px solid;border-radius:0;background:none;-webkit-appearance:none;-moz-appearance:none;appearance:none}
        .mdc-text-field__input::-webkit-input-placeholder{transition:opacity 67ms cubic-bezier(.4,0,.2,1);opacity:0;color:rgba(0,0,0,.54)}
        .mdc-text-field__input::placeholder{transition:opacity 67ms cubic-bezier(.4,0,.2,1);opacity:0;color:rgba(0,0,0,.54)}
        .mdc-text-field--fullwidth .mdc-text-field__input::-webkit-input-placeholder,.mdc-text-field--no-label .mdc-text-field__input::-webkit-input-placeholder,.mdc-text-field--focused .mdc-text-field__input::-webkit-input-placeholder{transition-delay:40ms;transition-duration:110ms;opacity:1}
        .mdc-text-field--fullwidth .mdc-text-field__input::placeholder,.mdc-text-field--no-label .mdc-text-field__input::placeholder,.mdc-text-field--focused .mdc-text-field__input::placeholder{transition-delay:40ms;transition-duration:110ms;opacity:1}
        .mdc-text-field__input:focus{outline:none}
        .mdc-text-field__input:invalid{box-shadow:none}
        .mdc-text-field--with-leading-icon .mdc-text-field__icon{left:16px;right:initial}
        .mdc-text-field--with-leading-icon .mdc-text-field__input{padding-left:48px;padding-right:16px}
        .mdc-text-field--fullwidth{width:100%}
        .mdc-text-field--fullwidth:not(.mdc-text-field--textarea){display:block}
        .mdc-text-field--fullwidth:not(.mdc-text-field--textarea)::before,.mdc-text-field--fullwidth:not(.mdc-text-field--textarea)::after{content:none}
        .mdc-text-field--fullwidth:not(.mdc-text-field--textarea):not(.mdc-text-field--disabled){background-color:transparent}
        .mdc-text-field--fullwidth:not(.mdc-text-field--textarea) .mdc-text-field__input{padding:0}

        .mdc-theme--background{background-color:#fff;background-color:var(--mdc-theme-background,#fff)}
        .mdc-theme--surface{background-color:#fff;background-color:var(--mdc-theme-surface,#fff)}

        .mdc-top-app-bar{background-color:#6200ee;background-color:var(--mdc-theme-primary,#6200ee);color:#fff;display:flex;position:fixed;flex-direction:column;justify-content:space-between;box-sizing:border-box;width:100%;z-index:4}
        .mdc-top-app-bar .mdc-top-app-bar__action-item,.mdc-top-app-bar .mdc-top-app-bar__navigation-icon{color:#fff;color:var(--mdc-theme-on-primary,#fff)}
        .mdc-top-app-bar .mdc-top-app-bar__action-item::before,.mdc-top-app-bar .mdc-top-app-bar__action-item::after,.mdc-top-app-bar .mdc-top-app-bar__navigation-icon::before,.mdc-top-app-bar .mdc-top-app-bar__navigation-icon::after{background-color:#fff}
        @supports not (-ms-ime-align:auto){.mdc-top-app-bar .mdc-top-app-bar__action-item::before,.mdc-top-app-bar .mdc-top-app-bar__action-item::after,.mdc-top-app-bar .mdc-top-app-bar__navigation-icon::before,.mdc-top-app-bar .mdc-top-app-bar__navigation-icon::after{background-color:var(--mdc-theme-on-primary,#fff)}}
        .mdc-top-app-bar .mdc-top-app-bar__action-item:hover::before,.mdc-top-app-bar .mdc-top-app-bar__navigation-icon:hover::before{opacity:.08}
        .mdc-top-app-bar .mdc-top-app-bar__action-item:focus::before,.mdc-top-app-bar .mdc-top-app-bar__navigation-icon:focus::before{transition-duration:75ms;opacity:.24}
        .mdc-top-app-bar .mdc-top-app-bar__action-item::after,.mdc-top-app-bar .mdc-top-app-bar__navigation-icon::after{transition:opacity 150ms linear}
        .mdc-top-app-bar .mdc-top-app-bar__action-item:active::after,.mdc-top-app-bar .mdc-top-app-bar__navigation-icon:active::after{transition-duration:75ms;opacity:.24}
        .mdc-top-app-bar__row{display:flex;position:relative;box-sizing:border-box;width:100%;height:64px}
        .mdc-top-app-bar__section{display:inline-flex;flex:1 1 auto;align-items:center;min-width:0;padding:8px 12px;z-index:1}
        .mdc-top-app-bar__section--align-start{justify-content:flex-start;order:-1}
        .mdc-top-app-bar__section--align-end{justify-content:flex-end;order:1}
        .mdc-top-app-bar__title{font:1.25rem/2rem Roboto,sans-serif;font-weight:500;letter-spacing:.0125em;text-decoration:inherit;text-transform:inherit;padding-left:20px;padding-right:0;text-overflow:ellipsis;white-space:nowrap;overflow:hidden;z-index:1}
        .mdc-top-app-bar__action-item,.mdc-top-app-bar__navigation-icon{--mdc-ripple-fg-size:0;--mdc-ripple-left:0;--mdc-ripple-top:0;--mdc-ripple-fg-scale:1;--mdc-ripple-fg-translate-end:0;--mdc-ripple-fg-translate-start:0;-webkit-tap-highlight-color:rgba(0,0,0,0);display:flex;position:relative;flex-shrink:0;align-items:center;justify-content:center;box-sizing:border-box;width:48px;height:48px;padding:12px;border:none;outline:none;background-color:transparent;fill:currentColor;color:inherit;text-decoration:none;cursor:pointer}
        .mdc-top-app-bar__action-item::before,.mdc-top-app-bar__action-item::after,.mdc-top-app-bar__navigation-icon::before,.mdc-top-app-bar__navigation-icon::after{position:absolute;border-radius:50%;opacity:0;pointer-events:none;content:""}
        .mdc-top-app-bar__action-item::before,.mdc-top-app-bar__navigation-icon::before{transition:opacity 15ms linear,background-color 15ms linear;z-index:1}
        .mdc-top-app-bar__action-item::before,.mdc-top-app-bar__action-item::after,.mdc-top-app-bar__navigation-icon::before,.mdc-top-app-bar__navigation-icon::after{top:calc(50% - 50%);left:calc(50% - 50%);width:100%;height:100%}
        .mdc-top-app-bar--fixed{transition:box-shadow 200ms linear}
        .mdc-top-app-bar--fixed-scrolled{box-shadow:0 2px 4px -1px rgba(0,0,0,.2),0 4px 5px 0 rgba(0,0,0,.14),0 1px 10px 0 rgba(0,0,0,.12);transition:box-shadow 200ms linear}
        .mdc-top-app-bar--fixed-adjust{padding-top:64px}
        @media(max-width:599px){
          .mdc-top-app-bar__row{height:56px}
          .mdc-top-app-bar__section{padding:4px}
          .mdc-top-app-bar--fixed-adjust{padding-top:56px}
        }

        .mdc-typography{font-family:Roboto,sans-serif}
        h1,.mdc-typography--headline1{font:6rem/6rem Roboto,sans-serif;font-weight:300;letter-spacing:-.015625em;text-decoration:inherit;text-transform:inherit}
        h2,.mdc-typography--headline2{font:3.75rem/3.75rem Roboto,sans-serif;font-weight:300;letter-spacing:-.0083333333em;text-decoration:inherit;text-transform:inherit}
        h3,.mdc-typography--headline3{font:3rem/3.125rem Roboto,sans-serif;font-weight:400;letter-spacing:normal;text-decoration:inherit;text-transform:inherit}
        h4,.mdc-typography--headline4{font:2.125rem/2.5rem Roboto,sans-serif;font-weight:400;letter-spacing:.0073529412em;text-decoration:inherit;text-transform:inherit}
        h5,.mdc-typography--headline5{font:1.5rem/2rem Roboto,sans-serif;font-weight:400;letter-spacing:normal;text-decoration:inherit;text-transform:inherit}
        h6,.mdc-typography--headline6{font:1.25rem/2rem Roboto,sans-serif;font-weight:500;letter-spacing:.0125em;text-decoration:inherit;text-transform:inherit}
        .mdc-typography--subtitle1{font:1rem/1.75rem Roboto,sans-serif;font-weight:400;letter-spacing:.009375em;text-decoration:inherit;text-transform:inherit}
        .mdc-typography--subtitle2{font:.875rem/1.375rem Roboto,sans-serif;font-weight:500;letter-spacing:.0071428571em;text-decoration:inherit;text-transform:inherit}
        p,.mdc-typography--body1{font:1rem/1.5rem Roboto,sans-serif;font-weight:400;letter-spacing:.03125em;text-decoration:inherit;text-transform:inherit}
        p small,.mdc-typography--body2{font:.875rem/1.25 Roboto,sans-serif;font-weight:400;letter-spacing:.0178571429em;text-decoration:inherit;text-transform:inherit}
        figcaption,.mdc-typography--caption{font:.75rem/1.25rem Roboto,sans-serif;font-weight:400;letter-spacing:.0333333333em;text-decoration:inherit;text-transform:inherit}
        .mdc-typography--button{font:.875rem/2.25rem Roboto,sans-serif;font-weight:500;letter-spacing:.0892857143em;text-decoration:none;text-transform:uppercase}
        .mdc-typography--overline{font:.75rem/2rem Roboto,sans-serif;font-weight:500;letter-spacing:.1666666667em;text-decoration:none;text-transform:uppercase}
    ';

    /**
     * Create the <style amp-custom> AMP HTML component.
     *
     * @param void
     *
     * @return string
     *   Returns the `<style amp-custom>…</style>` container with the CSS
     *   `:root` element, CSS variables, and a custom MDC theme.
     */
    public function __toString()
    {
        /*
         * Start of with minified normalize.css.
         *
         * @version v8.0.1
         * @license https://github.com/necolas/normalize.css/blob/master/LICENSE.md MIT License
         * @see     https://github.com/necolas/normalize.css
         */
        $css = 'html{line-height:1.15;-webkit-text-size-adjust:100%}'
            . 'body{margin:0}'
            . 'main{display:block}'
            . 'h1{font-size:2em;margin:0.67em 0}'
        //  . 'hr{box-sizing:content-box;height:0;overflow:visible}'
            . 'pre{font-family:monospace,monospace;font-size:1em}'
            . 'a{background-color:transparent}'
        //  . 'abbr[title]{border-bottom:none;text-decoration:underline;text-decoration:underline dotted}'
            . 'b,strong{font-weight:bolder}'
            . 'code,kbd,samp{font-family:monospace, monospace;font-size:1em}'
            . 'small{font-size:80%}'
            . 'sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}'
            . 'sub{bottom:-0.25em}'
            . 'sup{top:-0.5em}'
            . 'img{border-style:none}'
            . 'button,input,optgroup,select,textarea{font-family:inherit;font-size:100%;line-height:1.15;margin:0}'
            . 'button,input{overflow:visible}'
            . 'button,select{text-transform:none}'
            . 'button,[type="button"],[type="reset"],[type="submit"]{-webkit-appearance:button}'
            . 'button::-moz-focus-inner,[type="button"]::-moz-focus-inner,[type="reset"]::-moz-focus-inner,[type="submit"]::-moz-focus-inner{border-style:none;padding:0}'
            . 'button:-moz-focusring,[type="button"]:-moz-focusring,[type="reset"]:-moz-focusring,[type="submit"]:-moz-focusring{outline:1px dotted ButtonText}'
            . 'fieldset{padding:0.35em 0.75em 0.625em}'
            . 'legend{box-sizing:border-box;color:inherit;display:table;max-width:100%;padding:0;white-space:normal}'
            . 'progress{vertical-align:baseline}'
            . 'textarea{overflow:auto}'
            . '[type="checkbox"],[type="radio"]{box-sizing:border-box;padding:0}'
            . '[type="number"]::-webkit-inner-spin-button,[type="number"]::-webkit-outer-spin-button{height:auto}'
            . '[type="search"]{-webkit-appearance:textfield;outline-offset:-2px}'
            . '[type="search"]::-webkit-search-decoration{-webkit-appearance:none}'
            . '::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}'
            . 'details{display:block}'
            . 'summary{display:list-item}'
            . 'template{display:none}'
            . '[hidden]{display:none}';

        /*
         * Add a better `<hr>` from Material Design Lite (MDL).
         *
         * @version   v1.3.0
         * @license   https://github.com/google/material-design-lite/blob/mdl-1.x/LICENSE Apache License 2.0
         * @copyright 2015 Google, Inc.
         * @see       https://github.com/google/material-design-lite
         */
        $css .= 'hr{box-sizing:content-box;display:block;height:1px;border:0;border-top:1px solid #ccc;margin:1em 0;padding:0;overflow:visible}';

        // Hide `abbr` bottom border and underline.
        $css .= 'abbr[title]{border-bottom:none;text-decoration:none}';

        // Disable italics to limit the need for font variants.
        $css .= 'dfn,em{font-style:normal;font-weight:bolder}';

        // Add the CSS `:root{…}` element
        $css .= $this->getRoot();

        // Typographic fixes.
        $css .= 'main article{margin:auto 1em}';
        $css .= 'main article p{max-width:45em}';

        // Add AMD Omnibox
        $css .= '#amd-omnibox{background-color:#e0e0e0}'
            . '#amd-omnibox form{background-color:#fff}'
            . '#amd-omnibox input{padding-left:56px;padding-right:1em}';

        // Add style sheets
        $this->StyleSheet = trim($this->StyleSheet);
        $css .= $this->StyleSheet . $this->CustomStyleSheet;

        // Replace MDC theme variables
        $css = str_replace('background-color:#fff;background-color:var(--mdc-theme-background,#fff)', 'background-color:' . $this->Root['mdc-theme-background'], $css);
        $css = str_replace('background-color:#fff;background-color:var(--mdc-theme-surface,#fff)', 'background-color:' . $this->Root['mdc-theme-surface'], $css);

        // Minify
        $css = str_replace("\r\n", "\n", $css);
        $css = str_replace("\n          ", null, $css);
        $css = str_replace("\n        ",   null, $css);
        $css = str_replace("\n",           null, $css);

        return '<style amp-custom>' . $css . '</style>';
    }

    /**
     * Add custom CSS.
     *
     * @param string $css
     *   CSS code for additions and overrides, added at the end of the default
     *   CSS code.
     *
     * @return void
     */
    public function append($css)
    {
        $this->CustomStyleSheet .= trim($css);
    }

    /**
     * Get the CSS root.
     *
     * @param void
     *
     * @return string
     *   Returns the CSS `:root{…}` element as a string, starting with a system
     *   font stack.
     */
    public function getRoot()
    {
        $css  = ':root{';
        $css .= 'font-family:Roboto,"Droid Sans","Helvetica Neue","Segoe UI",Oxygen,Ubuntu,Cantarell,"Fira Sans",Arial,sans-serif;';
        foreach ($this->Root as $key => $value) {
            $key = '--' . ltrim($key, '-');
            $css .= $key . ':' . $value . ';';
        }
        $css = rtrim($css, ';') . '}';
        return $css;
    }

    /**
     * Set a theme value.
     *
     * @param string $name
     *   Name of the setting, usually the name of an MDC or CSS variable.
     *
     * @param string $value
     *   Value to set as a string.
     *
     * @return void
     */
    public function set($name, $value)
    {
        $name = trim($name);
        $name = ltrim($name, '-');
        $value = trim($value);
        $this->Root[$name] = $value;
    }
}

<?php
namespace Wporg\TranslationEvents\Templates\NewDesign\Parts;

use Wporg\TranslationEvents\Templates;

/** @var string $html_title */
/** @var string $url */
/** @var string $html_description */
/** @var string $image_url */

Templates::block( 'wporg/global-header' );

gp_enqueue_styles( array( 'gp-jquery-webui-popover', 'driver-js' ) );
gp_enqueue_scripts( array( 'gp-tour' ) );
add_css();
add_social_tags( $html_title, $url, $html_description, $image_url );
add_filter( 'wporg_block_navigation_menus', __NAMESPACE__ . '\add_site_navigation_menus' );

Templates::pattern( 'wporg-translate-events/local-nav' );

/**
 * Provide a list with a navigation menu.
 *
 * @return array
 */
function add_site_navigation_menus(): array {
	return array(
		'site-header-menu' => array(
			array(
				'label' => esc_html__( 'Events', 'wporg-plugins' ),
				'url'   => 'https://translate.wordpress.org/events/',
			),
			array(
				'label' => esc_html__( 'Team', 'wporg-plugins' ),
				'url'   => 'https://make.wordpress.org/polyglots/teams/',
			),
			array(
				'label' => esc_html__( 'Requests', 'wporg-plugins' ),
				'url'   => 'https://make.wordpress.org/polyglots/?resolved=unresolved',
			),
			array(
				'label' => esc_html__( 'Weekly Chats', 'wporg-plugins' ),
				'url'   => 'https://make.wordpress.org/polyglots/category/weekly-chats/',
			),
			array(
				'label' => esc_html__( 'Translate', 'wporg-plugins' ),
				'url'   => 'https://translate.wordpress.org/',
			),
			array(
				'label' => esc_html__( 'Handbook', 'wporg-plugins' ),
				'url'   => 'https://make.wordpress.org/polyglots/handbook/',
			),
		),
	);
}
/**
 * Add inline CSS to the page, needed for the new design.
 *
 * This should be replaced with a proper enqueueing of styles or a call to a proper method.
 */
function add_css() {
	echo '<script type="text/javascript">document.body.className = document.body.className.replace("no-js","js");</script>';
	$inline_css = '
		<style id="global-styles-inline-css">
			  body{
			    --wp--preset--color--black: #000000;--wp--preset--color--cyan-bluish-gray: #abb8c3;--wp--preset--color--white: #ffffff;--wp--preset--color--pale-pink: #f78da7;--wp--preset--color--vivid-red: #cf2e2e;--wp--preset--color--luminous-vivid-orange: #ff6900;--wp--preset--color--luminous-vivid-amber: #fcb900;--wp--preset--color--light-green-cyan: #7bdcb5;--wp--preset--color--vivid-green-cyan: #00d084;--wp--preset--color--pale-cyan-blue: #8ed1fc;--wp--preset--color--vivid-cyan-blue: #0693e3;--wp--preset--color--vivid-purple: #9b51e0;--wp--preset--color--charcoal-0: #1a1919;--wp--preset--color--charcoal-1: #1e1e1e;--wp--preset--color--charcoal-2: #23282d;--wp--preset--color--charcoal-3: #40464d;--wp--preset--color--charcoal-4: #656a71;--wp--preset--color--charcoal-5: #979aa1;--wp--preset--color--light-grey-1: #d9d9d9;--wp--preset--color--light-grey-2: #f6f6f6;--wp--preset--color--white-opacity-15: #ffffff26;--wp--preset--color--black-opacity-15: #00000026;--wp--preset--color--dark-blueberry: #1d35b4;--wp--preset--color--deep-blueberry: #213fd4;--wp--preset--color--blueberry-1: #3858e9;--wp--preset--color--blueberry-2: #7b90ff;--wp--preset--color--blueberry-3: #c7d1ff;--wp--preset--color--blueberry-4: #eff2ff;--wp--preset--color--pomegrade-1: #e26f56;--wp--preset--color--pomegrade-2: #ffb7a7;--wp--preset--color--pomegrade-3: #ffe9de;--wp--preset--color--acid-green-1: #33f078;--wp--preset--color--acid-green-2: #c7ffdb;--wp--preset--color--acid-green-3: #e2ffed;--wp--preset--color--lemon-1: #fff972;--wp--preset--color--lemon-2: #fffcb5;--wp--preset--color--lemon-3: #fffdd6;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%);--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%);--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%);--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);--wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);--wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);--wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);--wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);--wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);--wp--preset--font-size--small: 14px;--wp--preset--font-size--medium: 20px;--wp--preset--font-size--large: 20px;--wp--preset--font-size--x-large: 42px;--wp--preset--font-size--extra-small: 12px;--wp--preset--font-size--normal: 16px;--wp--preset--font-size--extra-large: 24px;--wp--preset--font-size--huge: 32px;--wp--preset--font-size--heading-6: 22px;--wp--preset--font-size--heading-5: 26px;--wp--preset--font-size--heading-4: 30px;--wp--preset--font-size--heading-3: 36px;--wp--preset--font-size--heading-2: 50px;--wp--preset--font-size--heading-1: 70px;--wp--preset--font-size--heading-cta: 120px;--wp--preset--font-family--eb-garamond: "EB Garamond", serif;--wp--preset--font-family--inter: "Inter", sans-serif;--wp--preset--font-family--monospace: "IBM Plex Mono", monospace;--wp--preset--font-family--ibm-plex-sans: "IBM Plex Sans", san-serif;--wp--preset--font-family--courier-prime: "Courier Prime", serif;--wp--preset--font-family--anton: "Anton", serif;--wp--preset--font-family--newsreader: "Newsreader", serif;--wp--preset--spacing--20: 20px;--wp--preset--spacing--30: 30px;--wp--preset--spacing--40: clamp(30px, 5vw, 50px);--wp--preset--spacing--50: clamp(40px, calc(5vw + 10px), 60px);--wp--preset--spacing--60: clamp(20px, calc(10vw - 40px), 80px);--wp--preset--spacing--70: 100px;--wp--preset--spacing--80: clamp(80px, calc(6.67vw + 40px), 120px);--wp--preset--spacing--edge-space: 80px;--wp--preset--spacing--10: 10px;--wp--preset--spacing--90: clamp(80px, 13.33vw, 160px);--wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);--wp--custom--alignment--aligned-max-width: 50%;--wp--custom--button--color--background: var(--wp--preset--color--blueberry-1);--wp--custom--button--color--text: var(--wp--preset--color--white);--wp--custom--button--border--color: var(--wp--preset--color--blueberry-1);--wp--custom--button--border--radius: 2px;--wp--custom--button--border--style: solid;--wp--custom--button--border--width: 1px;--wp--custom--button--hover--color--background: var(--wp--preset--color--deep-blueberry);--wp--custom--button--hover--color--text: var(--wp--preset--color--white);--wp--custom--button--focus--border--color: var(--wp--preset--color--blueberry-1);--wp--custom--button--active--border--color: var(--wp--preset--color--blueberry-1);--wp--custom--button--active--color--background: var(--wp--preset--color--charcoal-1);--wp--custom--button--active--color--text: var(--wp--preset--color--white);--wp--custom--button--outline--border--color: currentColor;--wp--custom--button--outline--color--background: transparent;--wp--custom--button--outline--color--text: var(--wp--preset--color--blueberry-1);--wp--custom--button--outline--hover--border--color: var(--wp--preset--color--blueberry-1);--wp--custom--button--outline--hover--color--background: var(--wp--preset--color--deep-blueberry);--wp--custom--button--outline--hover--color--text: var(--wp--preset--color--white);--wp--custom--button--outline--focus--border--color: var(--wp--preset--color--blueberry-1);--wp--custom--button--outline--focus--color--background: var(--wp--preset--color--blueberry-1);--wp--custom--button--outline--focus--color--text: var(--wp--preset--color--white);--wp--custom--button--outline--active--border--color: var(--wp--preset--color--charcoal-1);--wp--custom--button--outline--active--color--background: var(--wp--preset--color--charcoal-1);--wp--custom--button--outline--active--color--text: var(--wp--preset--color--white);--wp--custom--button--small--spacing--padding--top: 7px;--wp--custom--button--small--spacing--padding--bottom: 7px;--wp--custom--button--small--spacing--padding--left: 12px;--wp--custom--button--small--spacing--padding--right: 12px;--wp--custom--button--small--typography--font-size: var(--wp--preset--font-size--small);--wp--custom--button--spacing--padding--top: 16px;--wp--custom--button--spacing--padding--bottom: 16px;--wp--custom--button--spacing--padding--left: 32px;--wp--custom--button--spacing--padding--right: 32px;--wp--custom--button--text--typography--font-weight: 400;--wp--custom--button--typography--font-size: var(--wp--preset--font-size--normal);--wp--custom--button--typography--font-weight: 600;--wp--custom--button--typography--line-height: var(--wp--custom--body--small--typography--line-height);--wp--custom--form--padding--inline: calc(var(--wp--preset--spacing--10) * 1.5);--wp--custom--form--padding--block: calc(var(--wp--preset--spacing--10) * 0.8);--wp--custom--form--border--color: transparent;--wp--custom--form--border--radius: 2px;--wp--custom--form--border--style: solid;--wp--custom--form--border--width: 0;--wp--custom--form--color--label: inherit;--wp--custom--form--color--background: var(--wp--preset--color--white);--wp--custom--form--color--text: var(--wp--preset--color--charcoal-1);--wp--custom--form--color--box-shadow: none;--wp--custom--form--typography--font-size: var(--wp--preset--font-size--small);--wp--custom--form--active--color--background: var(--wp--preset--color--white);--wp--custom--form--active--color--text: var(--wp--preset--color--charcoal-1);--wp--custom--form--search--color--label: var(--wp--preset--color--charcoal-4);--wp--custom--form--search--color--background: var(--wp--preset--color--light-grey-2);--wp--custom--form--search--color--text: var(--wp--preset--color--charcoal-1);--wp--custom--gallery--caption--font-size: var(--wp--preset--font-size--small);--wp--custom--body--typography--line-height: 1.875;--wp--custom--body--typography--text-wrap: pretty;--wp--custom--body--short-text--typography--line-height: 1.625;--wp--custom--body--extra-small--typography--line-height: 1.67;--wp--custom--body--small--typography--line-height: 1.714;--wp--custom--body--large--typography--line-height: 1.7;--wp--custom--body--extra-large--typography--line-height: 1.58;--wp--custom--body--extra-large--breakpoint--small-only--typography--font-size: 20px;--wp--custom--body--extra-large--breakpoint--small-only--typography--line-height: 1.5;--wp--custom--body--huge--typography--line-height: 1.5;--wp--custom--heading--typography--font-family: var(--wp--preset--font-family--eb-garamond);--wp--custom--heading--typography--font-weight: 400;--wp--custom--heading--typography--line-height: 1.3;--wp--custom--heading--typography--text-wrap: balance;--wp--custom--heading--cta--typography--line-height: 1;--wp--custom--heading--cta--breakpoint--small-only--typography--font-size: 52px;--wp--custom--heading--cta--breakpoint--small-only--typography--line-height: 1.08;--wp--custom--heading--level-1--typography--line-height: 1.05;--wp--custom--heading--level-1--breakpoint--small-only--typography--font-size: 52px;--wp--custom--heading--level-1--breakpoint--small-only--typography--line-height: 1.08;--wp--custom--heading--level-2--typography--line-height: 1.2;--wp--custom--heading--level-2--breakpoint--small-only--typography--font-size: 30px;--wp--custom--heading--level-2--breakpoint--small-only--typography--line-height: 1.07;--wp--custom--heading--level-3--typography--line-height: 1.28;--wp--custom--heading--level-3--breakpoint--small-only--typography--font-size: 26px;--wp--custom--heading--level-3--breakpoint--small-only--typography--line-height: 1.15;--wp--custom--heading--level-4--typography--line-height: 1.33;--wp--custom--heading--level-4--breakpoint--small-only--typography--font-size: 22px;--wp--custom--heading--level-4--breakpoint--small-only--typography--line-height: 1.09;--wp--custom--heading--level-5--typography--line-height: 1.3;--wp--custom--heading--level-5--breakpoint--small-only--typography--font-size: 20px;--wp--custom--heading--level-5--breakpoint--small-only--typography--line-height: 1.2;--wp--custom--heading--level-6--typography--line-height: 1.27;--wp--custom--heading--level-6--breakpoint--small-only--typography--font-size: 18px;--wp--custom--heading--level-6--breakpoint--small-only--typography--line-height: 1.22;--wp--custom--layout--content-size: 680px;--wp--custom--layout--wide-size: 1160px;--wp--custom--layout--content-meta-size: calc( var(--wp--custom--layout--wide-size) - var(--wp--custom--layout--content-size) );--wp--custom--link--color--text: var(--wp--preset--color--blueberry-1);--wp--custom--list--spacing--padding--left: var(--wp--custom--margin--horizontal);--wp--custom--margin--baseline: 10px;--wp--custom--margin--horizontal: 30px;--wp--custom--margin--vertical: 30px;--wp--custom--post-comment--typography--font-size: var(--wp--preset--font-size--normal);--wp--custom--post-comment--typography--line-height: var(--wp--custom--body--typography--line-height);--wp--custom--pullquote--breakpoint--medium--typography--font-size: 50px;--wp--custom--pullquote--citation--breakpoint--medium--typography--font-size: 30px;--wp--custom--pullquote--citation--typography--font-size: 20px;--wp--custom--pullquote--citation--typography--font-family: inherit;--wp--custom--pullquote--citation--typography--font-style: italic;--wp--custom--pullquote--citation--spacing--margin--top: var(--wp--custom--margin--vertical);--wp--custom--pullquote--spacing--min-height: 430px;--wp--custom--pullquote--typography--font-size: 40px;--wp--custom--pullquote--typography--line-height: 1.4;--wp--custom--pullquote--typography--text-align: left;--wp--custom--quote--citation--typography--font-size: 20px;--wp--custom--quote--citation--typography--font-family: inherit;--wp--custom--quote--citation--typography--font-style: normal;--wp--custom--quote--typography--text-align: left;--wp--custom--separator--opacity: 1;--wp--custom--separator--margin: var(--wp--custom--margin--vertical) auto;--wp--custom--separator--width: 150px;--wp--custom--latest-news--link--color: var(--wp--preset--color--charcoal-1);--wp--custom--latest-news--link--spacing: var(--wp--preset--spacing--10);--wp--custom--latest-news--link--details--font-size: var(--wp--preset--font-size--small);--wp--custom--latest-news--spacing: var(--wp--preset--spacing--40);--wp--custom--latest-news--title--font-family: var(--wp--preset--font-family--eb-garamond);--wp--custom--latest-news--title--font-size: var(--wp--preset--font-size--heading-5);--wp--custom--latest-news--title--line-height: var(--wp--custom--heading--level-3--typography--line-height);--wp--custom--brush-stroke--spacing--height: 16px;}body { margin: 0;--wp--style--global--content-size: 680px;--wp--style--global--wide-size: 1160px; }.wp-site-blocks > .alignleft { float: left; margin-right: 2em; }.wp-site-blocks > .alignright { float: right; margin-left: 2em; }.wp-site-blocks > .aligncenter { justify-content: center; margin-left: auto; margin-right: auto; }:where(.wp-site-blocks) > * { margin-block-start: 20px; margin-block-end: 0; }:where(.wp-site-blocks) > :first-child:first-child { margin-block-start: 0; }:where(.wp-site-blocks) > :last-child:last-child { margin-block-end: 0; }body { --wp--style--block-gap: 20px; }:where(body .is-layout-flow)  > :first-child:first-child{margin-block-start: 0;}:where(body .is-layout-flow)  > :last-child:last-child{margin-block-end: 0;}:where(body .is-layout-flow)  > *{margin-block-start: 20px;margin-block-end: 0;}:where(body .is-layout-constrained)  > :first-child:first-child{margin-block-start: 0;}:where(body .is-layout-constrained)  > :last-child:last-child{margin-block-end: 0;}:where(body .is-layout-constrained)  > *{margin-block-start: 20px;margin-block-end: 0;}:where(body .is-layout-flex) {gap: 20px;}:where(body .is-layout-grid) {gap: 20px;}body .is-layout-flow > .alignleft{float: left;margin-inline-start: 0;margin-inline-end: 2em;}body .is-layout-flow > .alignright{float: right;margin-inline-start: 2em;margin-inline-end: 0;}body .is-layout-flow > .aligncenter{margin-left: auto !important;margin-right: auto !important;}body .is-layout-constrained > .alignleft{float: left;margin-inline-start: 0;margin-inline-end: 2em;}body .is-layout-constrained > .alignright{float: right;margin-inline-start: 2em;margin-inline-end: 0;}body .is-layout-constrained > .aligncenter{margin-left: auto !important;margin-right: auto !important;}body .is-layout-constrained > :where(:not(.alignleft):not(.alignright):not(.alignfull)){max-width: var(--wp--style--global--content-size);margin-left: auto !important;margin-right: auto !important;}body .is-layout-constrained > .alignwide{max-width: var(--wp--style--global--wide-size);}body .is-layout-flex{display: flex;}body .is-layout-flex{flex-wrap: wrap;align-items: center;}body .is-layout-flex > *{margin: 0;}body .is-layout-grid{display: grid;}body .is-layout-grid > *{margin: 0;}body{background-color: var(--wp--preset--color--white);color: var(--wp--preset--color--charcoal-1);font-family: var(--wp--preset--font-family--inter);font-size: var(--wp--preset--font-size--normal);line-height: var(--wp--custom--body--typography--line-height);padding-top: 0px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;}.has-black-color{color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-color{color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-color{color: var(--wp--preset--color--white) !important;}.has-pale-pink-color{color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-color{color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-color{color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-color{color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-color{color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-color{color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-color{color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-color{color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-color{color: var(--wp--preset--color--vivid-purple) !important;}.has-charcoal-0-color{color: var(--wp--preset--color--charcoal-0) !important;}.has-charcoal-1-color{color: var(--wp--preset--color--charcoal-1) !important;}.has-charcoal-2-color{color: var(--wp--preset--color--charcoal-2) !important;}.has-charcoal-3-color{color: var(--wp--preset--color--charcoal-3) !important;}.has-charcoal-4-color{color: var(--wp--preset--color--charcoal-4) !important;}.has-charcoal-5-color{color: var(--wp--preset--color--charcoal-5) !important;}.has-light-grey-1-color{color: var(--wp--preset--color--light-grey-1) !important;}.has-light-grey-2-color{color: var(--wp--preset--color--light-grey-2) !important;}.has-white-opacity-15-color{color: var(--wp--preset--color--white-opacity-15) !important;}.has-black-opacity-15-color{color: var(--wp--preset--color--black-opacity-15) !important;}.has-dark-blueberry-color{color: var(--wp--preset--color--dark-blueberry) !important;}.has-deep-blueberry-color{color: var(--wp--preset--color--deep-blueberry) !important;}.has-blueberry-1-color{color: var(--wp--preset--color--blueberry-1) !important;}.has-blueberry-2-color{color: var(--wp--preset--color--blueberry-2) !important;}.has-blueberry-3-color{color: var(--wp--preset--color--blueberry-3) !important;}.has-blueberry-4-color{color: var(--wp--preset--color--blueberry-4) !important;}.has-pomegrade-1-color{color: var(--wp--preset--color--pomegrade-1) !important;}.has-pomegrade-2-color{color: var(--wp--preset--color--pomegrade-2) !important;}.has-pomegrade-3-color{color: var(--wp--preset--color--pomegrade-3) !important;}.has-acid-green-1-color{color: var(--wp--preset--color--acid-green-1) !important;}.has-acid-green-2-color{color: var(--wp--preset--color--acid-green-2) !important;}.has-acid-green-3-color{color: var(--wp--preset--color--acid-green-3) !important;}.has-lemon-1-color{color: var(--wp--preset--color--lemon-1) !important;}.has-lemon-2-color{color: var(--wp--preset--color--lemon-2) !important;}.has-lemon-3-color{color: var(--wp--preset--color--lemon-3) !important;}.has-black-background-color{background-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-background-color{background-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-background-color{background-color: var(--wp--preset--color--white) !important;}.has-pale-pink-background-color{background-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-background-color{background-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-background-color{background-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-background-color{background-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-background-color{background-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-background-color{background-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-background-color{background-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-background-color{background-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-background-color{background-color: var(--wp--preset--color--vivid-purple) !important;}.has-charcoal-0-background-color{background-color: var(--wp--preset--color--charcoal-0) !important;}.has-charcoal-1-background-color{background-color: var(--wp--preset--color--charcoal-1) !important;}.has-charcoal-2-background-color{background-color: var(--wp--preset--color--charcoal-2) !important;}.has-charcoal-3-background-color{background-color: var(--wp--preset--color--charcoal-3) !important;}.has-charcoal-4-background-color{background-color: var(--wp--preset--color--charcoal-4) !important;}.has-charcoal-5-background-color{background-color: var(--wp--preset--color--charcoal-5) !important;}.has-light-grey-1-background-color{background-color: var(--wp--preset--color--light-grey-1) !important;}.has-light-grey-2-background-color{background-color: var(--wp--preset--color--light-grey-2) !important;}.has-white-opacity-15-background-color{background-color: var(--wp--preset--color--white-opacity-15) !important;}.has-black-opacity-15-background-color{background-color: var(--wp--preset--color--black-opacity-15) !important;}.has-dark-blueberry-background-color{background-color: var(--wp--preset--color--dark-blueberry) !important;}.has-deep-blueberry-background-color{background-color: var(--wp--preset--color--deep-blueberry) !important;}.has-blueberry-1-background-color{background-color: var(--wp--preset--color--blueberry-1) !important;}.has-blueberry-2-background-color{background-color: var(--wp--preset--color--blueberry-2) !important;}.has-blueberry-3-background-color{background-color: var(--wp--preset--color--blueberry-3) !important;}.has-blueberry-4-background-color{background-color: var(--wp--preset--color--blueberry-4) !important;}.has-pomegrade-1-background-color{background-color: var(--wp--preset--color--pomegrade-1) !important;}.has-pomegrade-2-background-color{background-color: var(--wp--preset--color--pomegrade-2) !important;}.has-pomegrade-3-background-color{background-color: var(--wp--preset--color--pomegrade-3) !important;}.has-acid-green-1-background-color{background-color: var(--wp--preset--color--acid-green-1) !important;}.has-acid-green-2-background-color{background-color: var(--wp--preset--color--acid-green-2) !important;}.has-acid-green-3-background-color{background-color: var(--wp--preset--color--acid-green-3) !important;}.has-lemon-1-background-color{background-color: var(--wp--preset--color--lemon-1) !important;}.has-lemon-2-background-color{background-color: var(--wp--preset--color--lemon-2) !important;}.has-lemon-3-background-color{background-color: var(--wp--preset--color--lemon-3) !important;}.has-black-border-color{border-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-border-color{border-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-border-color{border-color: var(--wp--preset--color--white) !important;}.has-pale-pink-border-color{border-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-border-color{border-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-border-color{border-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-border-color{border-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-border-color{border-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-border-color{border-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-border-color{border-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-border-color{border-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-border-color{border-color: var(--wp--preset--color--vivid-purple) !important;}.has-charcoal-0-border-color{border-color: var(--wp--preset--color--charcoal-0) !important;}.has-charcoal-1-border-color{border-color: var(--wp--preset--color--charcoal-1) !important;}.has-charcoal-2-border-color{border-color: var(--wp--preset--color--charcoal-2) !important;}.has-charcoal-3-border-color{border-color: var(--wp--preset--color--charcoal-3) !important;}.has-charcoal-4-border-color{border-color: var(--wp--preset--color--charcoal-4) !important;}.has-charcoal-5-border-color{border-color: var(--wp--preset--color--charcoal-5) !important;}.has-light-grey-1-border-color{border-color: var(--wp--preset--color--light-grey-1) !important;}.has-light-grey-2-border-color{border-color: var(--wp--preset--color--light-grey-2) !important;}.has-white-opacity-15-border-color{border-color: var(--wp--preset--color--white-opacity-15) !important;}.has-black-opacity-15-border-color{border-color: var(--wp--preset--color--black-opacity-15) !important;}.has-dark-blueberry-border-color{border-color: var(--wp--preset--color--dark-blueberry) !important;}.has-deep-blueberry-border-color{border-color: var(--wp--preset--color--deep-blueberry) !important;}.has-blueberry-1-border-color{border-color: var(--wp--preset--color--blueberry-1) !important;}.has-blueberry-2-border-color{border-color: var(--wp--preset--color--blueberry-2) !important;}.has-blueberry-3-border-color{border-color: var(--wp--preset--color--blueberry-3) !important;}.has-blueberry-4-border-color{border-color: var(--wp--preset--color--blueberry-4) !important;}.has-pomegrade-1-border-color{border-color: var(--wp--preset--color--pomegrade-1) !important;}.has-pomegrade-2-border-color{border-color: var(--wp--preset--color--pomegrade-2) !important;}.has-pomegrade-3-border-color{border-color: var(--wp--preset--color--pomegrade-3) !important;}.has-acid-green-1-border-color{border-color: var(--wp--preset--color--acid-green-1) !important;}.has-acid-green-2-border-color{border-color: var(--wp--preset--color--acid-green-2) !important;}.has-acid-green-3-border-color{border-color: var(--wp--preset--color--acid-green-3) !important;}.has-lemon-1-border-color{border-color: var(--wp--preset--color--lemon-1) !important;}.has-lemon-2-border-color{border-color: var(--wp--preset--color--lemon-2) !important;}.has-lemon-3-border-color{border-color: var(--wp--preset--color--lemon-3) !important;}.has-vivid-cyan-blue-to-vivid-purple-gradient-background{background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;}.has-light-green-cyan-to-vivid-green-cyan-gradient-background{background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;}.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;}.has-luminous-vivid-orange-to-vivid-red-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;}.has-very-light-gray-to-cyan-bluish-gray-gradient-background{background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;}.has-cool-to-warm-spectrum-gradient-background{background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;}.has-blush-light-purple-gradient-background{background: var(--wp--preset--gradient--blush-light-purple) !important;}.has-blush-bordeaux-gradient-background{background: var(--wp--preset--gradient--blush-bordeaux) !important;}.has-luminous-dusk-gradient-background{background: var(--wp--preset--gradient--luminous-dusk) !important;}.has-pale-ocean-gradient-background{background: var(--wp--preset--gradient--pale-ocean) !important;}.has-electric-grass-gradient-background{background: var(--wp--preset--gradient--electric-grass) !important;}.has-midnight-gradient-background{background: var(--wp--preset--gradient--midnight) !important;}.has-small-font-size{font-size: var(--wp--preset--font-size--small) !important;}.has-medium-font-size{font-size: var(--wp--preset--font-size--medium) !important;}.has-large-font-size{font-size: var(--wp--preset--font-size--large) !important;}.has-x-large-font-size{font-size: var(--wp--preset--font-size--x-large) !important;}.has-extra-small-font-size{font-size: var(--wp--preset--font-size--extra-small) !important;}.has-normal-font-size{font-size: var(--wp--preset--font-size--normal) !important;}.has-extra-large-font-size{font-size: var(--wp--preset--font-size--extra-large) !important;}.has-huge-font-size{font-size: var(--wp--preset--font-size--huge) !important;}.has-heading-6-font-size{font-size: var(--wp--preset--font-size--heading-6) !important;}.has-heading-5-font-size{font-size: var(--wp--preset--font-size--heading-5) !important;}.has-heading-4-font-size{font-size: var(--wp--preset--font-size--heading-4) !important;}.has-heading-3-font-size{font-size: var(--wp--preset--font-size--heading-3) !important;}.has-heading-2-font-size{font-size: var(--wp--preset--font-size--heading-2) !important;}.has-heading-1-font-size{font-size: var(--wp--preset--font-size--heading-1) !important;}.has-heading-cta-font-size{font-size: var(--wp--preset--font-size--heading-cta) !important;}.has-eb-garamond-font-family{font-family: var(--wp--preset--font-family--eb-garamond) !important;}.has-inter-font-family{font-family: var(--wp--preset--font-family--inter) !important;}.has-monospace-font-family{font-family: var(--wp--preset--font-family--monospace) !important;}.has-ibm-plex-sans-font-family{font-family: var(--wp--preset--font-family--ibm-plex-sans) !important;}.has-courier-prime-font-family{font-family: var(--wp--preset--font-family--courier-prime) !important;}.has-anton-font-family{font-family: var(--wp--preset--font-family--anton) !important;}.has-newsreader-font-family{font-family: var(--wp--preset--font-family--newsreader) !important;}
				.wp-block-pullquote{font-family: var(--wp--preset--font-family--eb-garamond);font-size: var(--wp--custom--pullquote--typography--font-size);font-weight: 400;line-height: var(--wp--custom--pullquote--typography--line-height);}
				.wp-block-navigation{font-size: var(--wp--preset--font-size--normal);}
				.wp-block-navigation a:where(:not(.wp-element-button)){color: inherit;}
				.wp-block-button .wp-block-button__link{background-color: var(--wp--custom--button--color--background);border-radius: var(--wp--custom--button--border--radius);border-color: var(--wp--custom--button--border--color);border-width: var(--wp--custom--button--border--width);border-style: var(--wp--custom--button--border--style);color: var(--wp--custom--button--color--text);font-family: var(--wp--preset--font-family--inter);font-size: var(--wp--custom--button--typography--font-size);font-weight: var(--wp--custom--button--typography--font-weight);line-height: var(--wp--custom--button--typography--line-height);}
				.wp-block-code{font-family: var(--wp--preset--font-family--monospace);}
				.wp-block-comment-author-name{font-weight: 600;}
				.wp-block-comment-author-name a:where(:not(.wp-element-button)){text-decoration: none;}
				.wp-block-comment-author-name a:where(:not(.wp-element-button)):hover{text-decoration: underline;}
				.wp-block-comment-date{font-size: var(--wp--preset--font-size--small);}
				.wp-block-comment-date a:where(:not(.wp-element-button)){color: var(--wp--preset--color--charcoal-4);text-decoration: none;}
				.wp-block-comment-date a:where(:not(.wp-element-button)):hover{text-decoration: underline;}
				.wp-block-post-date{font-size: var(--wp--preset--font-size--small);}
				.wp-block-post-navigation-link a:where(:not(.wp-element-button)){text-decoration: none;}
				.wp-block-post-navigation-link a:where(:not(.wp-element-button)):hover{text-decoration: underline;}
				.wp-block-post-terms{font-size: var(--wp--preset--font-size--small);}
				.wp-block-post-title{font-family: var(--wp--custom--heading--typography--font-family);font-size: var(--wp--preset--font-size--heading-1);line-height: var(--wp--custom--heading--level-1--typography--line-height);}
				.wp-block-post-title a:where(:not(.wp-element-button)){text-decoration: none;}
				.wp-block-post-title a:where(:not(.wp-element-button)):hover{text-decoration: underline;}
				.wp-block-query h1,.wp-block-query  h2,.wp-block-query  h3,.wp-block-query  h4,.wp-block-query  h5,.wp-block-query  h6{font-size: var(--wp--preset--font-size--heading-2);line-height: var(--wp--custom--heading--level-2--typography--line-height);}
				.wp-block-query-pagination a:where(:not(.wp-element-button)){text-decoration: none;}
				.wp-block-query-pagination a:where(:not(.wp-element-button)):hover{text-decoration: underline;}
				.wp-block-separator{border-color: currentColor;border-width: 0 0 1px 0;border-style: solid;}
				.wp-block-site-title{font-size: clamp(20px, calc(100vw / 12), 120px);}
				.wp-block-site-title a:where(:not(.wp-element-button)){text-decoration: none;}
				.wp-block-site-title a:where(:not(.wp-element-button)):hover{text-decoration: underline;}
				.wp-block-quote{border-radius: 0px;border-color: var(--wp--preset--color--deep-blueberry);border-width: 0 0 0 2px;border-style: solid;font-family: var(--wp--preset--font-family--eb-garamond);font-size: 30px;font-style: normal;font-weight: 400;line-height: 1.3;padding-left: var(--wp--custom--margin--horizontal);}
				.wp-block-wporg-download-counter{font-family: var(--wp--preset--font-family--monospace);font-size: clamp(40px, calc(100vw / 8), 120px);line-height: 1;}
				.wp-block-cover .wp-block-embed.no-min-sizing {
							min-width: unset;
				min-height: unset;
			 }
		</style>';
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	echo $inline_css;
}

/**
 * Add social tags to the head of the page.
 *
 * @param string $html_title       The title of the page.
 * @param string $url              The URL of the page.
 * @param string $html_description The description of the page.
 * @param string $image_url        The URL of the image to use.
 *
 * @return void
 */
function add_social_tags( string $html_title, string $url, string $html_description, string $image_url ) {
	$meta_tags = array(
		'name'     => array(
			'twitter:card'        => 'summary',
			'twitter:site'        => '@WordPress',
			'twitter:title'       => esc_attr( $html_title ),
			'twitter:description' => esc_attr( $html_description ),
			'twitter:creator'     => '@WordPress',
			'twitter:image'       => esc_url( $image_url ),
			'twitter:image:alt'   => esc_attr( $html_title ),
		),
		'property' => array(
			'og:url'              => esc_url( $url ),
			'og:title'            => esc_attr( $html_title ),
			'og:description'      => esc_attr( $html_description ),
			'og:site_name'        => esc_attr( get_bloginfo() ),
			'og:image:url'        => esc_url( $image_url ),
			'og:image:secure_url' => esc_url( $image_url ),
			'og:image:type'       => 'image/png',
			'og:image:width'      => '1200',
			'og:image:height'     => '675',
			'og:image:alt'        => esc_attr( $html_title ),
		),
	);

	foreach ( $meta_tags as $name => $content ) {
		foreach ( $content as $key => $value ) {
			// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo '<meta ' . esc_attr( $name ) . '="' . esc_attr( $key ) . '" content="' . esc_attr( $value ) . '" />' . "\n";
		}
	}
}

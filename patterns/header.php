<?php
/**
 * Title: Header
 * Slug: industry/header
 * Keywords: header, navigation
 * Block Types: core/template-part/header
 * Description: The template's two rows: a charcoal bar with social links, phone and email, over the logo and the navigation.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"industry-header","backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull industry-header has-base-background-color has-background"><!-- wp:group {"align":"full","className":"industry-topbar","backgroundColor":"charcoal","textColor":"overlay","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull industry-topbar has-overlay-color has-charcoal-background-color has-text-color has-background"><!-- wp:group {"className":"industry-topbar__row","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group industry-topbar__row"><!-- wp:social-links {"size":"has-small-icon-size","className":"is-style-industry-plain","layout":{"type":"flex","justifyContent":"left","flexWrap":"wrap"}} -->
<ul class="wp-block-social-links has-small-icon-size is-style-industry-plain"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#","service":"youtube"} /--></ul>
<!-- /wp:social-links -->

<!-- wp:paragraph {"className":"industry-topbar__contacts","textColor":"overlay"} -->
<p class="industry-topbar__contacts has-overlay-color has-text-color"><a href="tel:+441632960214">+44 1632 960 214</a><a href="mailto:hello@yourdomain.com">hello@yourdomain.com</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"industry-header__main","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group industry-header__main"><!-- wp:group {"className":"industry-header__brand","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"center"}} -->
<div class="wp-block-group industry-header__brand"><!-- wp:site-logo {"width":130} /-->

<!-- wp:site-title {"level":0} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"industry-header__nav","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right","verticalAlignment":"center"}} -->
<div class="wp-block-group industry-header__nav"><!-- wp:navigation {"layout":{"type":"flex","justifyContent":"right","flexWrap":"wrap"}} /-->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"industry-scheme-toggle"} -->
<div class="wp-block-button industry-scheme-toggle"><a class="wp-block-button__link wp-element-button" href="#"><span class="screen-reader-text">Switch between light and dark mode</span></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

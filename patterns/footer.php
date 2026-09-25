<?php
/**
 * Title: Footer
 * Slug: industry/footer
 * Keywords: footer, newsletter
 * Block Types: core/template-part/footer
 * Description: Three columns on the dark ground — about and copyright, a newsletter sign-up, and social links.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"industry-footer","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"dark","textColor":"on-dark","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull industry-footer has-on-dark-color has-dark-background-color has-text-color has-background" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"className":"industry-footer__columns","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns industry-footer__columns"><!-- wp:column {"width":"41.66%"} -->
<div class="wp-block-column" style="flex-basis:41.66%"><!-- wp:heading {"className":"industry-footer__title","textColor":"overlay","fontSize":"large"} -->
<h2 class="wp-block-heading industry-footer__title has-overlay-color has-text-color has-large-font-size">About us</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"on-dark"} -->
<p class="has-on-dark-color has-text-color">Industry designs, builds and maintains industrial plant for manufacturers, ports, utilities and logistics firms, with engineers on call around the clock.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"industry-footer__legal","textColor":"on-dark","fontSize":"small"} -->
<p class="industry-footer__legal has-on-dark-color has-text-color has-small-font-size">© Industry. All rights reserved. Theme by <a href="https://colorlib.com/" rel="nofollow">Colorlib</a>.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"41.66%"} -->
<div class="wp-block-column" style="flex-basis:41.66%"><!-- wp:heading {"className":"industry-footer__title","textColor":"overlay","fontSize":"large"} -->
<h2 class="wp-block-heading industry-footer__title has-overlay-color has-text-color has-large-font-size">Newsletter</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"on-dark"} -->
<p class="has-on-dark-color has-text-color">Site notes and case studies from our engineers, once a month.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[industry_form type="newsletter"]
<!-- /wp:shortcode --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"16.66%"} -->
<div class="wp-block-column" style="flex-basis:16.66%"><!-- wp:heading {"className":"industry-footer__title","textColor":"overlay","fontSize":"large"} -->
<h2 class="wp-block-heading industry-footer__title has-overlay-color has-text-color has-large-font-size">Follow us</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"textColor":"on-dark"} -->
<p class="has-on-dark-color has-text-color">Photos from the yard, the shop floor and the road.</p>
<!-- /wp:paragraph -->

<!-- wp:social-links {"size":"has-small-icon-size","className":"is-style-industry-plain","layout":{"type":"flex","justifyContent":"left","flexWrap":"wrap"}} -->
<ul class="wp-block-social-links has-small-icon-size is-style-industry-plain"><!-- wp:social-link {"url":"#","service":"facebook"} /-->

<!-- wp:social-link {"url":"#","service":"x"} /-->

<!-- wp:social-link {"url":"#","service":"linkedin"} /-->

<!-- wp:social-link {"url":"#","service":"youtube"} /--></ul>
<!-- /wp:social-links --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

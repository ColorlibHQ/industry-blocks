<?php
/**
 * Title: About with the quote form
 * Slug: industry/about-quote
 * Categories: industry-sections
 * Keywords: about, quote, form, enquiry
 * Description: The company's story and a button beside the quote request form on a darkened photograph of valves.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"industry-about","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"surface","layout":{"type":"constrained"},"anchor":"quote"} -->
<div class="wp-block-group alignfull industry-about has-surface-background-color has-background" id="quote" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:columns {"verticalAlignment":"center","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center"><!-- wp:column {"verticalAlignment":"center","width":"66.66%","className":"industry-about-text"} -->
<div class="wp-block-column is-vertically-aligned-center industry-about-text" style="flex-basis:66.66%"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"industry-kicker"} -->
<p class="industry-kicker">Engineering and construction since 1984</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">One contractor, <br>survey to handover</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"industry-lede"} -->
<p class="industry-lede">Design, fabrication, installation and maintenance under one contract.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Industry began as a two-man pipe-fitting firm on the docks. Forty years on we are 640 engineers, welders, electricians and project managers working for manufacturers, ports, utilities and logistics firms. Every project is run by one engineer from the first site visit to the final sign-off, and our own fabrication shop turns drawings into steel without waiting on anyone else's schedule.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"industry-wide"} -->
<div class="wp-block-button industry-wide"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/about/' ) ); ?>">About the company</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"33.33%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:33.33%"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/quote.webp' ) ); ?>","dimRatio":80,"overlayColor":"dark","isUserOverlayColor":true,"className":"industry-quote-panel","layout":{"type":"constrained"}} -->
<div class="wp-block-cover industry-quote-panel"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/quote.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-80 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:heading {"textColor":"overlay","fontSize":"x-large"} -->
<h2 class="wp-block-heading has-overlay-color has-text-color has-x-large-font-size">Request a quote</h2>
<!-- /wp:heading -->

<!-- wp:shortcode -->
[industry_form type="quote" layout="compact" button="Request free quote"]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

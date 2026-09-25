<?php
/**
 * Title: Hero
 * Slug: industry/hero
 * Categories: industry-sections
 * Keywords: hero, banner
 * Description: Full-screen photograph of a port at dusk with a spaced eyebrow, the headline, a line of copy and a button.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.webp' ) ); ?>","dimRatio":40,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":88,"minHeightUnit":"vh","align":"full","className":"industry-hero industry-hero\u002d\u002dfill","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull industry-hero industry-hero--fill" style="min-height:88vh"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim-40 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"730px"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"is-style-industry-eyebrow","style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} -->
<p class="has-text-align-center is-style-industry-eyebrow has-overlay-color has-text-color">Industrial engineering &amp; construction</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"className":"industry-hero__title","style":{"typography":{"textAlign":"center"}},"textColor":"overlay","fontSize":"display"} -->
<h1 class="wp-block-heading has-text-align-center industry-hero__title has-overlay-color has-text-color has-display-font-size">We build for heavy industry</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"industry-hero__text","style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} -->
<p class="has-text-align-center industry-hero__text has-overlay-color has-text-color">Plant rooms, process piping, steel structures and planned maintenance for factories, ports and warehouses, delivered by one team from the first survey to the handover.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"industry-caps"} -->
<div class="wp-block-button industry-caps"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/#quote' ) ); ?>">Request a quote</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

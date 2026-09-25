<?php
/**
 * Title: Post banner
 * Slug: industry/hidden-single-banner
 * Description: The photograph banner a post title sits on.
 * Inserter: no
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.webp' ) ); ?>","dimRatio":50,"overlayColor":"dark","isUserOverlayColor":true,"minHeight":356,"align":"full","className":"industry-banner","layout":{"type":"constrained"}} -->
<div class="wp-block-cover alignfull industry-banner" style="min-height:356px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-dark-background-color has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-title {"level":1,"style":{"typography":{"textAlign":"center"}},"textColor":"overlay"} /-->

<!-- wp:group {"className":"industry-breadcrumb","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center","verticalAlignment":"center"}} -->
<div class="wp-block-group industry-breadcrumb"><!-- wp:paragraph {"className":"industry-breadcrumb__home","textColor":"overlay"} -->
<p class="industry-breadcrumb__home has-overlay-color has-text-color"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"textColor":"overlay"} -->
<p class="has-overlay-color has-text-color">Blog</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div></div>
<!-- /wp:cover -->

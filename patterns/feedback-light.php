<?php
/**
 * Title: Client reviews on a pale ground
 * Slug: industry/feedback-light
 * Categories: industry-sections
 * Keywords: testimonials, reviews, video
 * Description: The reviews and the play tile on the pale ground, as the template's inner pages have it.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"industry-feedback industry-feedback\u002d\u002dlight","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"surface","layout":{"type":"constrained"},"anchor":"reviews"} -->
<div class="wp-block-group alignfull industry-feedback industry-feedback--light has-surface-background-color has-background" id="reviews" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:group {"className":"industry-section-head","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"730px"}} -->
<div class="wp-block-group industry-section-head"><!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center">What our clients say</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center">Plant managers and project directors on working with our crews.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"verticalAlignment":"center","className":"industry-feedback__row","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center industry-feedback__row"><!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:cover {"url":"<?php echo esc_url( get_theme_file_uri( 'assets/images/film.webp' ) ); ?>","dimRatio":70,"overlayColor":"brand","isUserOverlayColor":true,"minHeight":350,"className":"industry-film","layout":{"type":"constrained"}} -->
<div class="wp-block-cover industry-film" style="min-height:350px"><img class="wp-block-cover__image-background" alt="" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/film.webp' ) ); ?>" data-object-fit="cover"/><span aria-hidden="true" class="wp-block-cover__background has-brand-background-color has-background-dim-70 has-background-dim"></span><div class="wp-block-cover__inner-container"><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons"><!-- wp:button {"className":"industry-video industry-play"} -->
<div class="wp-block-button industry-video industry-play"><a class="wp-block-button__link wp-element-button" href="https://www.youtube.com/watch?v=3Cy5Kgls0U8"><span class="screen-reader-text">Play the film: a power plant built in time-lapse</span></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"50%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:50%"><!-- wp:group {"className":"industry-slider","layout":{"type":"default"}} -->
<div class="wp-block-group industry-slider"><!-- wp:group {"className":"industry-quote industry-slide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group industry-quote industry-slide"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"industry-quote__name","fontSize":"large"} -->
<p class="industry-quote__name has-large-font-size">Fannie Rowe</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"industry-stars industry-stars\u002d\u002d5"} -->
<p class="industry-stars industry-stars--5"><span class="screen-reader-text">Rated 5 out of 5</span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p>They rebuilt our main hydraulic press over a bank-holiday weekend, and we were pressing parts again on the Tuesday morning. The engineer rang with an update every few hours.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"industry-quote__role","fontSize":"small"} -->
<p class="industry-quote__role has-small-font-size">Plant manager, automotive supplier</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"industry-quote industry-slide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group industry-quote industry-slide"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"industry-quote__name","fontSize":"large"} -->
<p class="industry-quote__name has-large-font-size">Daniel Osei</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"industry-stars industry-stars\u002d\u002d5"} -->
<p class="industry-stars industry-stars--5"><span class="screen-reader-text">Rated 5 out of 5</span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p>We have used three contractors for planned maintenance in ten years. Industry is the first whose reports we actually read, because they are short and they are right.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"industry-quote__role","fontSize":"small"} -->
<p class="industry-quote__role has-small-font-size">Engineering manager, food manufacturer</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"industry-quote industry-slide","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group industry-quote industry-slide"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","verticalAlignment":"center"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"industry-quote__name","fontSize":"large"} -->
<p class="industry-quote__name has-large-font-size">Marta Kowalczyk</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"industry-stars industry-stars\u002d\u002d4"} -->
<p class="industry-stars industry-stars--4"><span class="screen-reader-text">Rated 4 out of 5</span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph -->
<p>The new boiler house came in two weeks early. Their site manager handled the cranes, the neighbours and the building inspector without once needing me.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"industry-quote__role","fontSize":"small"} -->
<p class="industry-quote__role has-small-font-size">Project director, energy developer</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

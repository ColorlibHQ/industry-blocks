<?php
/**
 * Title: Sectors: three photograph cards
 * Slug: industry/sectors
 * Categories: industry-sections
 * Keywords: services, sectors, cards
 * Description: Three market sectors, each a photograph that zooms on hover, a title and a line of copy.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"},"anchor":"sectors"} -->
<div class="wp-block-group alignfull" id="sectors" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:group {"className":"industry-section-head","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"730px"}} -->
<div class="wp-block-group industry-section-head"><!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center">Sectors we build for</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center">The industries our engineers know from the inside.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"industry-sector","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group industry-sector"><!-- wp:image {"aspectRatio":"360/250","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"industry-sector__photo"} -->
<figure class="wp-block-image size-large industry-sector__photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sector-1.webp' ) ); ?>" alt="Blue pumps in a row along a pump-house floor, with yellow-lagged pipes overhead" style="aspect-ratio:360/250;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Process and utilities</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Pump stations, compressed air, steam and cooling water: plant-room piping designed, installed and commissioned.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"industry-sector","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group industry-sector"><!-- wp:image {"aspectRatio":"360/250","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"industry-sector__photo"} -->
<figure class="wp-block-image size-large industry-sector__photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sector-2.webp' ) ); ?>" alt="A multi-level highway interchange lit up at dusk, with a city behind it" style="aspect-ratio:360/250;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Civil and infrastructure</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Bridges, access roads, yard surfacing and drainage for ports, depots and the business parks around them.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"industry-sector","style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group industry-sector"><!-- wp:image {"aspectRatio":"360/250","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"industry-sector__photo"} -->
<figure class="wp-block-image size-large industry-sector__photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/sector-3.webp' ) ); ?>" alt="Rocket stages lying side by side on stands in a bright assembly hall" style="aspect-ratio:360/250;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Advanced manufacturing</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Assembly halls, overhead cranes and clean production lines for aerospace and precision engineering.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

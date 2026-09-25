<?php
/**
 * Title: Projects: four photographs
 * Slug: industry/projects
 * Categories: industry-sections
 * Keywords: projects, portfolio, gallery
 * Description: Four captioned project photographs in the template's mosaic, enlarging on click.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"layout":{"type":"constrained"},"anchor":"projects"} -->
<div class="wp-block-group alignfull" id="projects" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:group {"className":"industry-section-head","style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"730px"}} -->
<div class="wp-block-group industry-section-head"><!-- wp:heading {"style":{"typography":{"textAlign":"center"}}} -->
<h2 class="wp-block-heading has-text-align-center">Latest finished projects</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}}} -->
<p class="has-text-align-center">A few of the jobs our crews signed off this year.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"industry-projects","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group industry-projects"><!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:image {"lightbox":{"enabled":true},"aspectRatio":"750/380","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"industry-project"} -->
<figure class="wp-block-image size-large industry-project"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/project-1.webp' ) ); ?>" alt="A long, sunlit industrial hall with steel roof trusses and a yellow gantry crane" style="aspect-ratio:750/380;object-fit:cover"/><figcaption class="wp-element-caption"><strong>Riverside rail works</strong> Conversion to a distribution hall</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:image {"lightbox":{"enabled":true},"aspectRatio":"360/380","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"industry-project industry-project\u002d\u002dfill"} -->
<figure class="wp-block-image size-large industry-project industry-project--fill"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/project-2.webp' ) ); ?>" alt="A workshop lamp lighting a bench grinder and glass jars on a dark workbench" style="aspect-ratio:360/380;object-fit:cover"/><figcaption class="wp-element-caption"><strong>Toolroom refit</strong> Maintenance</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"lightbox":{"enabled":true},"aspectRatio":"555/380","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"industry-project"} -->
<figure class="wp-block-image size-large industry-project"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/project-3.webp' ) ); ?>" alt="Rows of cast-iron looms with white cloth beams in a textile mill" style="aspect-ratio:555/380;object-fit:cover"/><figcaption class="wp-element-caption"><strong>Textile mill machinery</strong> Restoration</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:image {"lightbox":{"enabled":true},"aspectRatio":"555/380","scale":"cover","sizeSlug":"large","linkDestination":"none","className":"industry-project"} -->
<figure class="wp-block-image size-large industry-project"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/project-4.webp' ) ); ?>" alt="Copper hydraulic lines fanning out from a brass manifold on a press" style="aspect-ratio:555/380;object-fit:cover"/><figcaption class="wp-element-caption"><strong>Hydraulic press rebuild</strong> Breakdown and repair</figcaption></figure>
<!-- /wp:image --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

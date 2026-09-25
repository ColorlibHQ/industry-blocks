<?php
/**
 * Title: Sidebar
 * Slug: industry/sidebar
 * Keywords: sidebar
 * Description: Search, categories, recent posts, archive and tags, each in a bordered box.
 * Inserter: no
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"className":"industry-sidebar","style":{"spacing":{"blockGap":"var:preset|spacing|50"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group industry-sidebar"><!-- wp:group {"className":"is-style-industry-box","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-industry-box"><!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search posts","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-industry-box","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-industry-box"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size">Post categories</h2>
<!-- /wp:heading -->

<!-- wp:categories {"showPostCounts":true,"className":"industry-counts"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-industry-box","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-industry-box"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size">Recent posts</h2>
<!-- /wp:heading -->

<!-- wp:latest-posts {"postsToShow":4,"displayPostDate":true,"displayFeaturedImage":true,"featuredImageAlign":"left","featuredImageSizeWidth":75,"featuredImageSizeHeight":75,"className":"industry-recent"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-industry-box","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-industry-box"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size">Post archive</h2>
<!-- /wp:heading -->

<!-- wp:archives {"showPostCounts":true,"className":"industry-counts"} /--></div>
<!-- /wp:group -->

<!-- wp:group {"className":"is-style-industry-box","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group is-style-industry-box"><!-- wp:heading {"fontSize":"large"} -->
<h2 class="wp-block-heading has-large-font-size">Tag cloud</h2>
<!-- /wp:heading -->

<!-- wp:tag-cloud {"smallestFontSize":"0.875rem","largestFontSize":"0.875rem","className":"industry-tags"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

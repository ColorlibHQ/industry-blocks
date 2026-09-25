<?php
/**
 * Title: Contact: map, details and form
 * Slug: industry/contact
 * Categories: industry-sections
 * Keywords: contact, form, map
 * Description: A map across the width, then the address, phone and email beside the message form.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","className":"industry-contact","style":{"spacing":{"padding":{"top":"var:preset|spacing|80","bottom":"var:preset|spacing|80"}}},"backgroundColor":"surface","layout":{"type":"constrained"},"anchor":"contact"} -->
<div class="wp-block-group alignfull industry-contact has-surface-background-color has-background" id="contact" style="padding-top:var(--wp--preset--spacing--80);padding-bottom:var(--wp--preset--spacing--80)"><!-- wp:html -->
<iframe class="industry-map" title="Map of the docks around our works" loading="lazy" src="https://www.openstreetmap.org/export/embed.html?bbox=-0.3150%2C53.7330%2C-0.2350%2C53.7560&amp;layer=mapnik" style="width:100%;height:445px;border:0"></iframe>
<!-- /wp:html -->

<!-- wp:spacer {"height":"var(\u002d\u002dwp\u002d\u002dpreset\u002d\u002dspacing\u002d\u002d70)"} -->
<div style="height:var(--wp--preset--spacing--70)" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:columns {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns"><!-- wp:column {"width":"33.33%"} -->
<div class="wp-block-column" style="flex-basis:33.33%"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"industry-contact-item industry-icon\u002d\u002dhome"} -->
<p class="industry-contact-item industry-icon--home"><strong>Riverside Works, Dock Road</strong><br>Hull, United Kingdom</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"industry-contact-item industry-icon\u002d\u002dphone"} -->
<p class="industry-contact-item industry-icon--phone"><strong><a href="tel:+441632960214">+44 1632 960 214</a></strong><br>Monday to Friday, 7am to 6pm</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"industry-contact-item industry-icon\u002d\u002dmail"} -->
<p class="industry-contact-item industry-icon--mail"><strong><a href="mailto:hello@yourdomain.com">hello@yourdomain.com</a></strong><br>Breakdowns: call any time, day or night</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"66.66%"} -->
<div class="wp-block-column" style="flex-basis:66.66%"><!-- wp:shortcode -->
[industry_form type="contact" layout="split" button="Send message"]
<!-- /wp:shortcode --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->

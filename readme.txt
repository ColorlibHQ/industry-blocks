=== Industry ===

Contributors: colorlib
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.1
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: blog, portfolio, full-site-editing, block-patterns, block-styles, template-editing, wide-blocks, accessibility-ready, translation-ready, custom-colors, custom-menu, custom-logo, featured-images, threaded-comments, one-column, two-columns, right-sidebar, rtl-language-support, sticky-post, theme-options

A block theme for industrial manufacturers, engineering contractors and construction firms.

== Description ==

Industry is a full site editing theme for industrial manufacturers,
engineering contractors and construction firms: services and market sectors,
a captioned project mosaic that opens in a lightbox, counters that count up,
client reviews beside a video, a quote request form, a contact page with a
map, a newsletter sign-up and a blog. The quote, contact and newsletter forms
need no plugin.

It is built from the Industry HTML template: the charcoal top bar over the
white navigation, the full-screen hero, the hexagon features, the about block
beside the quote form, the ringed counters, the project mosaic and the dark
footer are all there, as blocks you can edit.

Activate it on a new site and it builds the pages for you — Home, About,
Services, Projects, Blog and Contact — with a menu to match. On a site that
already has pages it leaves them alone.

Eight colour palettes and five type pairings, each checked for contrast before
release rather than by eye. Visitor-facing dark mode that follows the reader's
system setting until they choose for themselves. WooCommerce is styled if you
install it and loads nothing if you do not.

== Installation ==

1. In WordPress, go to Appearance → Themes → Add New Theme → Upload Theme.
2. Choose industry.zip and click Install Now, then Activate.
3. Appearance → Editor is where the header, footer, colours and templates live.

== Frequently Asked Questions ==

= Do I need a plugin for the quote form? =

No. The quote, contact and newsletter forms are part of the theme and send
with WordPress's own wp_mail() to the site's admin address. If your host cannot
send mail, install any SMTP plugin — whatever fixes a lost password-reset email
fixes the forms too. To send submissions somewhere else (a CRM, a mailing
list), hook the `industry_form_handlers` filter and return true. The services
offered in the quote form's first field come from the
`industry_quote_services` filter.

= How do I change the colours? =

Appearance → Editor → Styles → Browse styles. Eight palettes are included —
Industry (the template's own yellow), Hi-vis, Steel, Signal, Machine, Copper,
and the dark Night shift and Graphite — and each restyles every section.

= Why are links amber rather than the brand yellow? =

The template's yellow, #fab700, is 1.8:1 against white, and white words on it
are 1.8:1 too; both fail WCAG AA. So the yellow stays as the button fill with
dark words on it (9:1), with a darker edge so a yellow button still reads as
a button on a white page, and a deeper amber carries links and small coloured
text. The yellow also draws the rules, the counter rings and the logo mark.

= How do I change the map on the contact page? =

The map is a Custom HTML block holding an OpenStreetMap embed. Open
openstreetmap.org, find your site, choose Share → HTML, and paste the new
address into the block's src.

= How do I change the video? =

Select the play button in the reviews section and change its link to any
YouTube address. It opens in a popup; without JavaScript it is a plain link.

= Can I turn dark mode off? =

Yes: add add_filter( 'industry_enable_dark_mode', '__return_false' ); to a
child theme or a small plugin. The switch in the header disappears with it.

= Can I turn the scroll animations off? =

Yes: add add_filter( 'industry_enable_scroll_animations', '__return_false' );
to a child theme or a small plugin. That stops the reveals and the counting;
visitors who have asked their system for reduced motion never see either. The
reviews slider and the video popup keep working.

= What does the update check send? =

Industry is distributed from colorlib.com, not the WordPress.org directory, so
it asks updates.colorlib.com for new versions, twice a day at most. It sends
the theme's version, the WordPress and PHP versions, the locale, whether the
site is a multisite, and a one-way hash of the site address — no site name, no
email address, nothing personal. add_filter( 'industry_check_for_updates',
'__return_false' ); stops it entirely.

== Theme Check ==

Theme Check reports REQUIRED findings that are deliberate, and each is the
price of something the theme does on purpose.

1. **add_shortcode() in inc/enquiry.php.** The forms have to keep working after
   a pattern is expanded into a page's content, where PHP never runs. A
   shortcode is the only mechanism WordPress offers for that. Moving it to a
   plugin would mean the quote form stops working the moment the plugin is
   disabled, on a page the theme built.
2. **Update URI in style.css.** This theme is distributed outside the
   WordPress.org directory and checks colorlib.com for its own updates. A theme
   inside the directory must not carry this header.
3. **Photo credits naming Pixabay.** Every photograph ships under the Pexels
   License, but five of them were uploaded to Pexels by its Pixabay account,
   and the credit below names that account. The Pexels License is not
   GPL-compatible; replace the photographs with your own and the finding goes
   with them.

== Copyright ==

Industry WordPress Theme, (C) 2026 Colorlib.
Industry is distributed under the terms of the GNU GPL v2 or later.

Poppins and Oswald
License: SIL Open Font License 1.1
Source: https://fontsource.org/

Tabler Icons
License: MIT, https://github.com/tabler/tabler-icons/blob/main/LICENSE
Source: https://tabler.io/icons

The logo mark and the hexagons (assets/icons/mark.svg, hexagon*.svg) are the
theme's own, under the GPL.

Photographs
All from Pexels, under the Pexels License, https://www.pexels.com/license/.
Photographer, then the photograph's page.

* hero.webp — Felix Rottmann,
  https://www.pexels.com/photo/aerial-shot-of-a-harbor-center-10027239/
* quote.webp — Pixabay (Pexels account),
  https://www.pexels.com/photo/ageing-plant-357440/
* film.webp — Kateryna Babaieva,
  https://www.pexels.com/photo/person-welding-wearing-a-prootective-metal-mask-3158651/
* feedback.webp — Kateryna Babaieva,
  https://www.pexels.com/photo/man-standing-near-fire-3361235/
* counters.webp — Pixabay (Pexels account),
  https://www.pexels.com/photo/low-angle-view-of-slightly-opened-door-structure-221047/
* sector-1.webp — Sonny Vermeer,
  https://www.pexels.com/photo/old-abandoned-factory-somewhere-in-belgium-17728782/
* sector-2.webp — Korie Jenkins,
  https://www.pexels.com/photo/city-at-night-9501147/
* sector-3.webp — Pixabay (Pexels account),
  https://www.pexels.com/photo/rocket-factory-256297/
* sector-4.webp — Willians Huerta,
  https://www.pexels.com/photo/industrial-warehouse-with-forklift-and-shelving-36398150/
* sector-5.webp — Gustavo Fring,
  https://www.pexels.com/photo/electricians-inspecting-the-solar-panels-4254167/
* sector-6.webp — Daniel Dan,
  https://www.pexels.com/photo/stainless-steel-tank-in-an-industrial-plant-7598915/
* project-1.webp — Pixabay (Pexels account),
  https://www.pexels.com/photo/train-subway-236698/
* project-2.webp — Pixabay (Pexels account),
  https://www.pexels.com/photo/lighted-lamp-280014/
* project-3.webp — T6 Adventures,
  https://www.pexels.com/photo/machinery-in-an-old-textile-factory-in-lodz-16472162/
* project-4.webp — ClickerHappy,
  https://www.pexels.com/photo/engine-engineering-equipment-factory-633860/
* project-5.webp — Kritsada Channel,
  https://www.pexels.com/photo/factory-in-countryside-26855281/
* project-6.webp — Mike van Schoonderwalt,
  https://www.pexels.com/photo/yellow-tower-cranes-5504388/
* project-7.webp — Mark Stebnicki,
  https://www.pexels.com/photo/steel-tanks-in-brewery-17765433/

== Changelog ==


= 1.0.1 =
* Update requests no longer name the site. WordPress's default User-Agent carries the site address; the update check and core's package download to updates.colorlib.com now send only the theme and WordPress versions, so the one-way site identifier is the only thing that tells installs apart.

= 1.0.0 =
* Initial release.

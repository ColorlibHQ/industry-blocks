#!/usr/bin/env python3
"""Generate Industry's patterns.

Run from the theme root:

    python3 .dev/build_patterns.py
    node .dev/normalize-blocks.mjs      # then let the editor re-serialise them
    node .dev/validate-blocks.mjs       # and refuse anything it calls invalid

Every pattern file is committed as generated. Edit this file, never
patterns/*.php.

The sections follow the Industry HTML template section by section: the
two-row header (a charcoal bar with social links and contacts over the white
navigation row), the full-screen hero, the three hexagon features, the about
block beside the quote form, the market-sector cards, the ringed counters over
a warehouse, the project mosaic, the reviews band with its play tile, the
blog cards and the three-column dark footer. The copy is one engineering and
construction contractor's, start to finish.
"""

import json
import os
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))

from patternlib import (  # noqa: E402
    button, buttons, column, columns, cover, group, heading, image,
    paragraph, shortcode, sp, spacer,
)

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
PATTERNS = os.path.join(ROOT, "patterns")
WRITTEN = []

SECTIONS = ["industry-sections"]
PAGES = ["industry-pages"]

PHONE = "+44 1632 960 214"
PHONE_HREF = "tel:+441632960214"
EMAIL = "hello@yourdomain.com"
# Tennessee Valley Authority's own time-lapse of a power plant going up:
# public, embeddable, and exactly what this firm does.
VIDEO = "https://www.youtube.com/watch?v=3Cy5Kgls0U8"


def write(slug, title, content, categories=None, keywords=None,
          description=None, inserter=True, block_types=None):
    header = ["Title: " + title, "Slug: industry/" + slug]
    if categories:
        header.append("Categories: " + ", ".join(categories))
    if keywords:
        header.append("Keywords: " + ", ".join(keywords))
    if block_types:
        header.append("Block Types: " + ", ".join(block_types))
    if description:
        header.append("Description: " + description)
    if not inserter:
        header.append("Inserter: no")

    body = (
        "<?php\n/**\n * " + "\n * ".join(header) + "\n *\n * @package Industry\n */\n\n"
        "defined( 'ABSPATH' ) || exit;\n?>\n" + content.strip() + "\n"
    )
    with open(os.path.join(PATTERNS, slug + ".php"), "w") as fh:
        fh.write(body)
    WRITTEN.append(slug)


def home(path="/"):
    """A link to one of the starter pages, resolved when the pattern loads.

    A literal `/contact/` breaks on a site installed in a subdirectory; `#`
    goes nowhere. The pattern is PHP, so it can ask WordPress, and the link is
    correct in the page activation builds from it.
    """
    return "<?php echo esc_url( home_url( '%s' ) ); ?>" % path


def icon(name):
    """The class that draws a Tabler icon on the block that carries it.

    style.css draws the icon from the class with a mask filled in the text
    colour, so it follows the palette and dark mode, shows in the editor (an
    empty inline element would not), and changing it is an edit to Advanced →
    Additional CSS class(es). Every name needs a `.industry-icon--<name>` rule;
    .dev/dead-selectors.py checks it."""
    return "industry-icon--%s" % name


def flex_row(inner, justify=None, gap=None, wrap="wrap", vertical="center", extra_class=None):
    """A horizontal group, written directly; normalize-blocks.mjs canonicalises it."""
    layout = {"type": "flex", "flexWrap": wrap}
    if justify:
        layout["justifyContent"] = justify
    if vertical:
        layout["verticalAlignment"] = vertical
    data = {}
    if extra_class:
        data["className"] = extra_class
    if gap is not None:
        data["style"] = {"spacing": {"blockGap": sp(gap) if gap != "0" else "0"}}
    data["layout"] = layout
    cls = "wp-block-group" + (" " + extra_class if extra_class else "")
    return '<!-- wp:group %s -->\n<div class="%s">\n%s\n</div>\n<!-- /wp:group -->' % (
        json.dumps(data, separators=(",", ":")), cls, inner
    )


def eyebrow(text, align=None, color=None):
    """The small spaced capitals above the hero's headline."""
    return paragraph(text, align=align, color=color, style="industry-eyebrow")


def kicker(text):
    """The template's coloured line above a heading, in sentence case."""
    return paragraph(text, extra_class="industry-kicker")


def section_head(title, blurb=None, color=None, blurb_color=None, align="center"):
    """A section title and one line beneath it, 60px above the content."""
    parts = [heading(title, level=2, align=align, color=color)]
    if blurb:
        parts.append(paragraph(blurb, align=align, color=blurb_color))
    return group("\n".join(parts), layout="constrained", content_size="730px" if align else None,
                 gap="20", extra_class="industry-section-head")


def social_links(style="industry-plain", justify="left", services=("facebook", "x", "linkedin", "youtube")):
    data = {"size": "has-small-icon-size", "className": "is-style-" + style,
            "layout": {"type": "flex", "justifyContent": justify, "flexWrap": "wrap"}}
    return (
        '<!-- wp:social-links %s -->\n'
        '<ul class="wp-block-social-links has-small-icon-size is-style-%s">%s</ul>\n'
        '<!-- /wp:social-links -->' % (
            json.dumps(data, separators=(",", ":")), style,
            "".join('<!-- wp:social-link {"url":"#","service":"%s"} /-->' % s for s in services))
    )


def section(inner, background=None, padding="80", anchor=None, extra_class=None):
    return group(inner, align="full", background=background, padding_y=padding,
                 layout="constrained", anchor=anchor, extra_class=extra_class)


# ---------------------------------------------------------------------------
# Parts
# ---------------------------------------------------------------------------
def build_header():
    # The switch needs text inside it: an empty core/button renders nothing at
    # all. The label is for screen readers; inc/scheme.php adds the pressed state.
    toggle = buttons([button('<span class="screen-reader-text">Switch between light and dark mode</span>', "#",
                             extra_class="industry-scheme-toggle")])

    contacts = paragraph('<a href="%s">%s</a><a href="mailto:%s">%s</a>' % (PHONE_HREF, PHONE, EMAIL, EMAIL),
                         color="overlay", extra_class="industry-topbar__contacts")
    topbar = group(flex_row(social_links(style="industry-plain") + "\n" + contacts,
                            justify="space-between", gap="30", wrap="nowrap", extra_class="industry-topbar__row"),
                   align="full", background="charcoal", text="overlay", layout="constrained",
                   extra_class="industry-topbar")

    brand = flex_row('<!-- wp:site-logo {"width":130} /-->\n<!-- wp:site-title {"level":0} /-->',
                     gap="30", wrap="nowrap", extra_class="industry-header__brand")
    nav = flex_row("\n".join([
        '<!-- wp:navigation {"overlayMenu":"mobile","layout":{"type":"flex","justifyContent":"right","flexWrap":"wrap"}} /-->',
        toggle,
    ]), justify="right", gap="30", wrap="nowrap", extra_class="industry-header__nav")
    main = flex_row(brand + "\n" + nav, justify="space-between", gap="40", wrap="nowrap",
                    extra_class="industry-header__main")

    write("header", "Header",
          group("\n".join([topbar, main]), align="full", background="base", layout="constrained",
                extra_class="industry-header"),
          keywords=["header", "navigation"],
          description="The template's two rows: a charcoal bar with social links, phone and email, over "
                      "the logo and the navigation.",
          block_types=["core/template-part/header"])


def build_footer():
    title = lambda text: heading(text, level=2, size="large", color="overlay", extra_class="industry-footer__title")
    col_about = column("\n".join([
        title("About us"),
        paragraph("Industry designs, builds and maintains industrial plant for manufacturers, ports, "
                  "utilities and logistics firms, with engineers on call around the clock.", color="on-dark"),
        paragraph('&copy; Industry. All rights reserved. Theme by <a href="https://colorlib.com/" rel="nofollow">Colorlib</a>.',
                  color="on-dark", size="small", extra_class="industry-footer__legal"),
    ]), width="41.66%")
    col_news = column("\n".join([
        title("Newsletter"),
        paragraph("Site notes and case studies from our engineers, once a month.", color="on-dark"),
        shortcode('[industry_form type="newsletter"]'),
    ]), width="41.66%")
    col_social = column("\n".join([
        title("Follow us"),
        paragraph("Photos from the yard, the shop floor and the road.", color="on-dark"),
        social_links(style="industry-plain"),
    ]), width="16.66%")
    body = columns([col_about, col_news, col_social], gap="60", extra_class="industry-footer__columns")
    write("footer", "Footer",
          group(body, align="full", background="dark", text="on-dark", padding_y="80", layout="constrained",
                extra_class="industry-footer"),
          keywords=["footer", "newsletter"],
          description="Three columns on the dark ground — about and copyright, a newsletter sign-up, "
                      "and social links.",
          block_types=["core/template-part/footer"])


def box(title, inner):
    """One of the sidebar's bordered boxes."""
    parts = []
    if title:
        parts.append(heading(title, level=2, size="large"))
    parts.append(inner)
    return group("\n".join(parts), layout="constrained", gap="40", style="industry-box")


def build_sidebar():
    inner = "\n".join([
        box(None, '<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search posts","buttonText":"Search","buttonPosition":"button-inside","buttonUseIcon":true} /-->'),
        box("Post categories", '<!-- wp:categories {"showPostCounts":true,"className":"industry-counts"} /-->'),
        box("Recent posts", '<!-- wp:latest-posts {"postsToShow":4,"displayPostDate":true,"displayFeaturedImage":true,"featuredImageSizeSlug":"thumbnail","featuredImageAlign":"left","featuredImageSizeWidth":75,"featuredImageSizeHeight":75,"className":"industry-recent"} /-->'),
        box("Post archive", '<!-- wp:archives {"showPostCounts":true,"className":"industry-counts"} /-->'),
        box("Tag cloud", '<!-- wp:tag-cloud {"smallestFontSize":"0.875rem","largestFontSize":"0.875rem","className":"industry-tags"} /-->'),
    ])
    write("sidebar", "Sidebar", group(inner, layout="constrained", gap="50", extra_class="industry-sidebar"),
          keywords=["sidebar"], inserter=False,
          description="Search, categories, recent posts, archive and tags, each in a bordered box.")


# ---------------------------------------------------------------------------
# Sections
# ---------------------------------------------------------------------------
def build_hero():
    inner = "\n".join([
        eyebrow("Industrial engineering &amp; construction", align="center", color="overlay"),
        heading("We build for heavy industry", level=1, align="center", color="overlay",
                size="display", extra_class="industry-hero__title"),
        paragraph("Plant rooms, process piping, steel structures and planned maintenance for factories, "
                  "ports and warehouses, delivered by one team from the first survey to the handover.",
                  align="center", color="overlay", extra_class="industry-hero__text"),
        buttons([button("Request a quote", home("/#quote"), extra_class="industry-caps")], align="center"),
    ])
    # Dimmed 40 on the `dark` ground: the template dims 50% black, but this
    # photograph is a dusk shot and already darker than the template's. The height
    # is the screen less the header, set in style.css: the template's hero
    # fills the window.
    write("hero", "Hero",
          cover(group(inner, layout="constrained", content_size="730px", gap="30"), "hero", dim=40,
                min_height=88, min_height_unit="vh", extra_class="industry-hero industry-hero--fill"),
          categories=SECTIONS, keywords=["hero", "banner"],
          description="Full-screen photograph of a port at dusk with a spaced eyebrow, the headline, a line "
                      "of copy and a button.")


FEATURES = [
    ("tool", "Planned maintenance",
     "Scheduled inspections, servicing and spares for pumps, compressors, cranes and conveyors, so a "
     "breakdown becomes the exception."),
    ("building-factory-2", "Design and build",
     "Plant rooms, mezzanines and production halls designed in-house, fabricated in our own shop and "
     "installed by our own crews."),
    ("urgent", "Breakdown response",
     "Engineers on call day and night, in vans stocked for the plant they are driving to. Most sites "
     "see us within four hours."),
]


def build_features():
    def item(name, title, text):
        return column(group("\n".join([
            paragraph("", extra_class="industry-hex " + icon(name), placeholder=" "),
            heading(title, level=3, align="center", size="large"),
            paragraph(text, align="center"),
        ]), layout="constrained", gap="30", extra_class="industry-feature"))

    write("features", "Features: three hexagon icons",
          section(columns([item(*f) for f in FEATURES], gap="60"), anchor="services-overview"),
          categories=SECTIONS, keywords=["features", "services", "icons"],
          description="Three services, each under a hexagon icon that fills with the brand colour on hover.")


def build_about_quote():
    text = "\n".join([
        kicker("Engineering and construction since 1984"),
        heading("One contractor, <br>survey to handover", level=2),
        paragraph("Design, fabrication, installation and maintenance under one contract.",
                  extra_class="industry-lede"),
        paragraph("Industry began as a two-man pipe-fitting firm on the docks. Forty years on we are 640 "
                  "engineers, welders, electricians and project managers working for manufacturers, ports, "
                  "utilities and logistics firms. Every project is run by one engineer from the first site "
                  "visit to the final sign-off, and our own fabrication shop turns drawings into steel "
                  "without waiting on anyone else's schedule."),
        buttons([button("About the company", home("/about/"), extra_class="industry-wide")]),
    ])
    form = cover(group("\n".join([
        heading("Request a quote", level=2, size="x-large", color="overlay"),
        shortcode('[industry_form type="quote" layout="compact" button="Request free quote"]'),
    ]), layout="constrained", gap="30"), "quote", dim=80, align=None, extra_class="industry-quote-panel")
    write("about-quote", "About with the quote form",
          section(columns([
              column(group(text, layout="constrained", gap="30"), width="66.66%", vertical="center",
                     extra_class="industry-about-text"),
              column(form, width="33.33%", vertical="center"),
          ], gap="60", vertical="center"), background="surface", anchor="quote", extra_class="industry-about"),
          categories=SECTIONS, keywords=["about", "quote", "form", "enquiry"],
          description="The company's story and a button beside the quote request form on a darkened "
                      "photograph of valves.")


SECTORS = [
    ("sector-1", "Blue pumps in a row along a pump-house floor, with yellow-lagged pipes overhead",
     "Process and utilities",
     "Pump stations, compressed air, steam and cooling water: plant-room piping designed, installed and "
     "commissioned."),
    ("sector-2", "A multi-level highway interchange lit up at dusk, with a city behind it",
     "Civil and infrastructure",
     "Bridges, access roads, yard surfacing and drainage for ports, depots and the business parks around them."),
    ("sector-3", "Rocket stages lying side by side on stands in a bright assembly hall",
     "Advanced manufacturing",
     "Assembly halls, overhead cranes and clean production lines for aerospace and precision engineering."),
    ("sector-4", "A long warehouse aisle between blue racking, a forklift at the far end",
     "Warehousing and logistics",
     "Racking, dock levellers, sprinklers and slab repairs for distribution centres that cannot close for "
     "the work."),
    ("sector-5", "Two engineers in hard hats beside a field of solar panels under a blue sky",
     "Energy and renewables",
     "Rooftop and ground-mounted solar, substations and battery rooms, from structural survey to grid "
     "connection."),
    ("sector-6", "Polished stainless-steel process tanks and pipework in a white production hall",
     "Food and drink",
     "Hygienic stainless pipework, tank farms and cleaning systems installed to the standard a food "
     "auditor checks."),
]


def sector_card(slug, alt, title, text):
    return column(group("\n".join([
        image(slug, alt, ratio="360/250", extra_class="industry-sector__photo"),
        heading(title, level=3, size="large"),
        paragraph(text),
    ]), layout="constrained", gap="30", extra_class="industry-sector"))


def build_sectors():
    inner = section_head("Sectors we build for",
                         "The industries our engineers know from the inside.")
    write("sectors", "Sectors: three photograph cards",
          section(inner + "\n" + columns([sector_card(*s) for s in SECTORS[:3]], gap="40"), anchor="sectors"),
          categories=SECTIONS, keywords=["services", "sectors", "cards"],
          description="Three market sectors, each a photograph that zooms on hover, a title and a line of copy.")

    rows = "\n".join(columns([sector_card(*s) for s in SECTORS[i:i + 3]], gap="40") for i in (0, 3))
    inner = section_head("What we do, sector by sector",
                         "Six industries, one team, and the same engineer on your job from start to finish.")
    write("sectors-all", "Sectors: six photograph cards",
          section(inner + "\n" + group(rows, layout="constrained", gap="60"), anchor="sectors"),
          categories=SECTIONS, keywords=["services", "sectors", "cards"],
          description="Six market sectors in two rows of three photograph cards.")


COUNTERS = [
    ("1,800+", "Projects delivered"),
    ("640", "Engineers and trades"),
    ("320", "Repeat clients"),
    ("42", "Years on site"),
]


def build_counters():
    def item(number, label):
        return column(group("\n".join([
            paragraph(number, align="center", extra_class="industry-counter__number"),
            paragraph(label, align="center", color="overlay", extra_class="industry-counter__label"),
        ]), layout="constrained", gap="30", extra_class="industry-counter"))

    write("counters", "Counters on a photograph",
          cover(columns([item(*c) for c in COUNTERS], gap="40", extra_class="industry-counters"),
                "counters", dim=70, min_height=None, extra_class="industry-counters-band", padding_y="80"),
          categories=SECTIONS, keywords=["counters", "numbers", "facts"],
          description="Four figures in ringed brand-colour discs over a darkened warehouse; they count up "
                      "when scrolled into view.")


PROJECTS = [
    ("project-1", "A long, sunlit industrial hall with steel roof trusses and a yellow gantry crane",
     "Riverside rail works", "Conversion to a distribution hall"),
    ("project-2", "A workshop lamp lighting a bench grinder and glass jars on a dark workbench",
     "Toolroom refit", "Maintenance"),
    ("project-3", "Rows of cast-iron looms with white cloth beams in a textile mill",
     "Textile mill machinery", "Restoration"),
    ("project-4", "Copper hydraulic lines fanning out from a brass manifold on a press",
     "Hydraulic press rebuild", "Breakdown and repair"),
    ("project-5", "A blue steel boiler house under construction beside a green field",
     "Biomass boiler house", "Design and build"),
    ("project-6", "Two yellow tower cranes against a pale sky",
     "Harbourside logistics hub", "Steelwork"),
    ("project-7", "Tall stainless fermentation tanks lining both sides of a brewery hall",
     "Brewery tank hall", "Food and drink"),
]


def project(slug, alt, title, kind, ratio, fill=False):
    """A project photograph that enlarges on click, captioned over its foot.

    `fill` marks the narrow tile beside the wide one: on a desktop it takes the
    row's height from its neighbour instead of its own ratio, so the two end
    level, as the template's 750x380 and 360x380 do. Stacked on a phone it
    keeps its ratio."""
    img = image(slug, alt, ratio=ratio, lightbox=True,
                extra_class="industry-project" + (" industry-project--fill" if fill else ""))
    caption = '<figcaption class="wp-element-caption"><strong>%s</strong> %s</figcaption>' % (title, kind)
    return img.replace("/></figure>", "/>" + caption + "</figure>")


def build_projects():
    p = PROJECTS
    grid = "\n".join([
        columns([column(project(*p[0], ratio="750/380"), width="66.66%"),
                 column(project(*p[1], ratio="360/380", fill=True), width="33.33%")], gap="40"),
        columns([column(project(*p[2], ratio="555/380")), column(project(*p[3], ratio="555/380"))], gap="40"),
    ])
    inner = section_head("Latest finished projects", "A few of the jobs our crews signed off this year.")
    write("projects", "Projects: four photographs",
          section(inner + "\n" + group(grid, layout="constrained", gap="40", extra_class="industry-projects"),
                  anchor="projects"),
          categories=SECTIONS, keywords=["projects", "portfolio", "gallery"],
          description="Four captioned project photographs in the template's mosaic, enlarging on click.")

    grid = grid + "\n" + columns([column(project(*x, ratio="360/380")) for x in p[4:7]], gap="40")
    inner = section_head("Recent projects",
                         "From a one-week toolroom refit to a two-year design and build.")
    write("projects-all", "Projects: seven photographs",
          section(inner + "\n" + group(grid, layout="constrained", gap="40", extra_class="industry-projects"),
                  anchor="projects"),
          categories=SECTIONS, keywords=["projects", "portfolio", "gallery"],
          description="Seven captioned project photographs: the mosaic and a row of three beneath it.")


QUOTES = [
    ("They rebuilt our main hydraulic press over a bank-holiday weekend, and we were pressing parts again "
     "on the Tuesday morning. The engineer rang with an update every few hours.",
     "Fannie Rowe", "Plant manager, automotive supplier", 5),
    ("We have used three contractors for planned maintenance in ten years. Industry is the first whose "
     "reports we actually read, because they are short and they are right.",
     "Daniel Osei", "Engineering manager, food manufacturer", 5),
    ("The new boiler house came in two weeks early. Their site manager handled the cranes, the neighbours "
     "and the building inspector without once needing me.",
     "Marta Kowalczyk", "Project director, energy developer", 4),
]


def quote(text, name, role, stars, light):
    # On the photograph the role is white like the rest: `on-dark` grey
    # measured 3.5:1 against the brightest tenth of the foundry's pixels.
    body = "overlay" if not light else None
    return group("\n".join([
        flex_row("\n".join([
            paragraph(name, color=None if light else "overlay", size="large", extra_class="industry-quote__name"),
            paragraph('<span class="screen-reader-text">Rated %d out of 5</span>' % stars,
                      extra_class="industry-stars industry-stars--%d" % stars),
        ]), gap="40", wrap="wrap"),
        paragraph(text, color=None if light else "overlay"),
        paragraph(role, color=body, size="small", extra_class="industry-quote__role"),
    ]), layout="constrained", gap="20", extra_class="industry-quote industry-slide")


def feedback_row(light):
    slider = group("\n".join(quote(*q, light=light) for q in QUOTES), layout="default",
                   extra_class="industry-slider")
    play = buttons([button('<span class="screen-reader-text">Play the film: a power plant built in time-lapse</span>',
                           VIDEO, extra_class="industry-video industry-play")], align="center")
    film = cover(play, "film", overlay="brand", dim=70, min_height=350, align=None, extra_class="industry-film")
    return columns([column(film, width="50%", vertical="center"),
                    column(slider, width="50%", vertical="center")],
                   gap="40", vertical="center", extra_class="industry-feedback__row")


def build_feedback():
    head = section_head("What our clients say",
                        "Plant managers and project directors on working with our crews.",
                        color="overlay", blurb_color="overlay")
    write("feedback", "Client reviews on a photograph",
          cover(head + "\n" + feedback_row(False), "feedback", dim=70, min_height=None,
                extra_class="industry-feedback", padding_y="80", anchor="reviews"),
          categories=SECTIONS, keywords=["testimonials", "reviews", "video"],
          description="A play tile that opens the film, beside a slider of client reviews with star "
                      "ratings, over a darkened foundry.")
    head = section_head("What our clients say",
                        "Plant managers and project directors on working with our crews.")
    write("feedback-light", "Client reviews on a pale ground",
          section(head + "\n" + feedback_row(True), background="surface", anchor="reviews",
                  extra_class="industry-feedback industry-feedback--light"),
          categories=SECTIONS, keywords=["testimonials", "reviews", "video"],
          description="The reviews and the play tile on the pale ground, as the template's inner pages have it.")


def build_latest_posts():
    query = (
        '<!-- wp:query {"queryId":2,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post",'
        '"order":"desc","orderBy":"date","inherit":false},"className":"industry-news","layout":{"type":"default"}} -->\n'
        '<div class="wp-block-query industry-news"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":3}} -->\n'
        '<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"360/220"} /-->\n'
        + flex_row("\n".join([
            '<!-- wp:post-author {"avatarSize":24,"fontSize":"small","className":"industry-news__author"} /-->',
            flex_row("\n".join([
                '<!-- wp:post-date {"format":"jS M","fontSize":"small"} /-->',
                '<!-- wp:post-comments-count {"fontSize":"small","className":"industry-comments-count"} /-->',
            ]), gap="30", wrap="nowrap"),
        ]), justify="space-between", gap="30", extra_class="industry-news__meta") + '\n'
        '<!-- wp:post-title {"isLink":true,"level":3,"fontSize":"large","className":"industry-news__title"} /-->\n'
        '<!-- wp:post-excerpt {"excerptLength":28} /-->\n'
        '<!-- /wp:post-template -->\n'
        '<!-- wp:query-no-results -->\n'
        + paragraph("Notes from our engineers will appear here as soon as the first post is published.",
                    align="center") + '\n'
        '<!-- /wp:query-no-results --></div>\n'
        '<!-- /wp:query -->'
    )
    inner = section_head("Latest from our blog",
                         "Site notes, case studies and practical advice from the people who do the work.")
    write("latest-posts", "Latest posts: three cards",
          section(inner + "\n" + query),
          categories=SECTIONS, keywords=["blog", "news", "posts"],
          description="The three most recent posts, each with a photograph, author, date, comments and excerpt.")


STEPS = [
    ("01", "Survey", "An engineer visits, measures and photographs, and writes down what you actually need."),
    ("02", "Design", "Drawings, calculations and a fixed price, checked by a chartered engineer before you see them."),
    ("03", "Build", "Our own fabrication shop and crews, one site manager, and a written report every Friday."),
    ("04", "Maintain", "A maintenance plan from the day of handover, so what we built keeps working."),
]


def build_process():
    def item(number, title, text):
        return column(group("\n".join([
            paragraph(number, extra_class="industry-step__number"),
            heading(title, level=3, size="large"),
            paragraph(text),
        ]), layout="constrained", gap="30", extra_class="industry-step"))

    inner = section_head("How a project runs", "The same four steps, whether it is one valve or a new building.")
    write("process", "Process: four steps",
          section(inner + "\n" + columns([item(*s) for s in STEPS], gap="40"), background="surface",
                  anchor="process"),
          categories=SECTIONS, keywords=["process", "steps", "how we work"],
          description="Four numbered steps from survey to maintenance, each under a brand-colour rule.")


def build_contact():
    def item(name, first, second):
        return paragraph("<strong>%s</strong><br>%s" % (first, second), extra_class="industry-contact-item " + icon(name))

    details = group("\n".join([
        item("home", "Riverside Works, Dock Road", "Hull, United Kingdom"),
        item("phone", '<a href="%s">%s</a>' % (PHONE_HREF, PHONE), "Monday to Friday, 7am to 6pm"),
        item("mail", '<a href="mailto:%s">%s</a>' % (EMAIL, EMAIL), "Breakdowns: call any time, day or night"),
    ]), layout="constrained", gap="40")
    form = shortcode('[industry_form type="contact" layout="split" button="Send message"]')
    map_block = (
        '<!-- wp:html -->\n'
        '<iframe class="industry-map" title="Map of the docks around our works" loading="lazy" '
        'src="https://www.openstreetmap.org/export/embed.html?bbox=-0.3150%2C53.7330%2C-0.2350%2C53.7560&amp;layer=mapnik" '
        'style="width:100%;height:445px;border:0"></iframe>\n'
        '<!-- /wp:html -->'
    )
    inner = map_block + "\n" + spacer("70") + "\n" + columns(
        [column(details, width="33.33%"), column(form, width="66.66%")], gap="60")
    write("contact", "Contact: map, details and form",
          section(inner, background="surface", anchor="contact", extra_class="industry-contact"),
          categories=SECTIONS, keywords=["contact", "form", "map"],
          description="A map across the width, then the address, phone and email beside the message form.")


# ---------------------------------------------------------------------------
# Hidden patterns: the pieces templates are built from.
# ---------------------------------------------------------------------------
def breadcrumb(current):
    """Home → current, as the template's banner has it."""
    return flex_row("\n".join([
        paragraph('<a href="%s">Home</a>' % home("/"), color="overlay", extra_class="industry-breadcrumb__home"),
        current,
    ]), justify="center", gap="30", wrap="wrap", extra_class="industry-breadcrumb")


def banner(slug, title, description, title_block, current):
    inner = "\n".join([title_block, breadcrumb(current)])
    write(slug, title, cover(group(inner, layout="constrained", gap="20"), "hero", dim=50, min_height=356,
                             extra_class="industry-banner"),
          inserter=False, description=description)


def build_hidden():
    here = lambda text: paragraph(text, color="overlay")
    banner("hidden-page-banner", "Page banner", "The photograph banner a page title sits on.",
           '<!-- wp:post-title {"level":1,"textAlign":"center","textColor":"overlay"} /-->',
           '<!-- wp:post-title {"level":0,"textColor":"overlay"} /-->')
    banner("hidden-single-banner", "Post banner", "The photograph banner a post title sits on.",
           '<!-- wp:post-title {"level":1,"textAlign":"center","textColor":"overlay"} /-->',
           here("Blog"))
    banner("hidden-blog-banner", "Blog banner", "The heading for the posts page.",
           heading("Blog", level=1, align="center", color="overlay"), here("Blog"))
    banner("hidden-archive-banner", "Archive banner", "The banner an archive title sits on.",
           '<!-- wp:query-title {"type":"archive","textAlign":"center","textColor":"overlay"} /-->',
           here("Archive"))
    banner("hidden-search-banner", "Search banner", "The banner search results sit under.",
           '<!-- wp:query-title {"type":"search","textAlign":"center","textColor":"overlay"} /-->',
           here("Search"))
    banner("hidden-404-banner", "Not found banner", "The banner of the page that is not there.",
           heading("Page not found", level=1, align="center", color="overlay"), here("404"))

    posts = (
        '<!-- wp:query {"queryId":0,"query":{"perPage":6,"pages":0,"offset":0,"postType":"post",'
        '"order":"desc","orderBy":"date","inherit":true},"className":"industry-posts","layout":{"type":"default"}} -->\n'
        '<div class="wp-block-query industry-posts"><!-- wp:post-template {"style":{"spacing":{"blockGap":"var:preset|spacing|70"}}} -->\n'
        '<!-- wp:post-featured-image {"isLink":true,"aspectRatio":"750/350"} /-->\n'
        '<!-- wp:post-terms {"term":"category","textColor":"contrast","fontSize":"small"} /-->\n'
        '<!-- wp:post-title {"isLink":true,"level":2} /-->\n'
        '<!-- wp:post-excerpt {"excerptLength":45} /-->\n'
        + flex_row("\n".join([
            '<!-- wp:post-date {"fontSize":"small"} /-->',
            '<!-- wp:post-comments-count {"fontSize":"small","className":"industry-comments-count"} /-->',
        ]), gap="40", extra_class="industry-post__meta") + '\n'
        '<!-- /wp:post-template -->\n'
        '<!-- wp:query-no-results -->\n'
        + paragraph("Nothing here yet. Try a search, or start again from the home page.") + '\n'
        '<!-- /wp:query-no-results -->\n'
        '<!-- wp:query-pagination {"layout":{"type":"flex","justifyContent":"left"}} -->\n'
        '<!-- wp:query-pagination-previous /-->\n'
        '<!-- wp:query-pagination-numbers /-->\n'
        '<!-- wp:query-pagination-next /-->\n'
        '<!-- /wp:query-pagination --></div>\n'
        '<!-- /wp:query -->'
    )
    write("hidden-posts-list", "Posts list", posts, inserter=False,
          description="The post list used by the blog and every archive: photograph, categories, title, excerpt.")

    meta = flex_row("\n".join([
        '<!-- wp:post-terms {"term":"category","textColor":"contrast","fontSize":"small"} /-->',
        '<!-- wp:post-date {"fontSize":"small"} /-->',
        '<!-- wp:post-author-name {"fontSize":"small","className":"industry-author"} /-->',
    ]), gap="40", extra_class="industry-post__meta")
    write("hidden-post-meta", "Post meta", meta, inserter=False,
          description="Categories, date and author for a single post.")

    comments = (
        '<!-- wp:comments {"className":"industry-comments"} -->\n'
        '<div class="wp-block-comments industry-comments">\n'
        '<!-- wp:comments-title {"level":2,"fontSize":"medium"} /-->\n'
        '<!-- wp:comment-template -->\n'
        '<!-- wp:columns {"isStackedOnMobile":false,"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|40"}}}} -->\n'
        '<div class="wp-block-columns is-not-stacked-on-mobile">'
        '<!-- wp:column {"width":"60px"} -->\n<div class="wp-block-column" style="flex-basis:60px">'
        '<!-- wp:avatar {"size":60} /--></div>\n<!-- /wp:column -->\n'
        '<!-- wp:column -->\n<div class="wp-block-column">'
        '<!-- wp:comment-author-name {"fontSize":"medium"} /-->\n'
        '<!-- wp:comment-date {"fontSize":"small"} /-->\n'
        '<!-- wp:comment-content /-->\n'
        '<!-- wp:comment-reply-link {"className":"industry-reply","fontSize":"x-small"} /-->'
        '</div>\n<!-- /wp:column --></div>\n'
        '<!-- /wp:columns -->\n'
        '<!-- /wp:comment-template -->\n'
        '<!-- wp:comments-pagination {"layout":{"type":"flex","justifyContent":"left"}} -->\n'
        '<!-- wp:comments-pagination-previous /-->\n'
        '<!-- wp:comments-pagination-numbers /-->\n'
        '<!-- wp:comments-pagination-next /-->\n'
        '<!-- /wp:comments-pagination -->\n'
        '<!-- wp:post-comments-form /-->\n'
        '</div>\n'
        '<!-- /wp:comments -->'
    )
    write("hidden-comments", "Comments", comments, inserter=False,
          description="The comments and the reply form for a single post.")

    notfound = "\n".join([
        heading("Nothing on this drawing", level=2, align="center"),
        paragraph("The address may be old, or the page may have been moved. "
                  "Try a search, or start again from the home page.", align="center"),
        '<!-- wp:search {"label":"Search","showLabel":false,"placeholder":"Search the site","buttonText":"Search","align":"center"} /-->',
        buttons([button("Back to the home page", home("/"))], align="center"),
    ])
    write("hidden-404", "404 content",
          section(group(notfound, layout="constrained", content_size="620px", gap="40")),
          inserter=False, description="What a visitor sees when nothing is there.")


# ---------------------------------------------------------------------------
# Whole pages
# ---------------------------------------------------------------------------
def ref(slug):
    return '<!-- wp:pattern {"slug":"industry/%s"} /-->' % slug


def build_pages():
    # Grounds alternate on every page: no two neighbouring sections share one.
    pages = {
        "page-home": ("Page: home", ["hero", "features", "about-quote", "sectors", "counters", "projects",
                                     "feedback", "latest-posts"]),
        "page-about": ("Page: about", ["about-quote", "features", "counters", "sectors", "feedback-light"]),
        "page-services": ("Page: services", ["sectors-all", "process", "feedback"]),
        "page-projects": ("Page: projects", ["projects-all", "counters", "feedback-light"]),
        "page-contact": ("Page: contact", ["contact"]),
    }
    for slug, (title, refs) in pages.items():
        write(slug, title, "\n".join(ref(r) for r in refs), categories=PAGES,
              description="A complete %s page, built from the theme's sections, as the template lays it out."
              % title.split(": ")[1])


def main():
    os.makedirs(PATTERNS, exist_ok=True)
    for name in os.listdir(PATTERNS):
        if name.endswith(".php"):
            os.remove(os.path.join(PATTERNS, name))
    build_header()
    build_footer()
    build_sidebar()
    build_hidden()
    build_hero()
    build_features()
    build_about_quote()
    build_sectors()
    build_counters()
    build_projects()
    build_feedback()
    build_latest_posts()
    build_process()
    build_contact()
    build_pages()

    for slug in sorted(WRITTEN):
        print("  patterns/%s.php" % slug)
    print("\n%d patterns" % len(WRITTEN))


if __name__ == "__main__":
    main()

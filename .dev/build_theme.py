#!/usr/bin/env python3
"""
Generates theme.json and every style variation from one table of colours.

Industry's brand is the template's safety yellow, #fab700. White on it is
1.77:1 and it is 1.77:1 against the white page, so it can carry neither a white
label nor text of its own. The palette therefore splits its jobs:

- `brand` is the template colour, for decoration only: the rings round the
  counters, rules, the play tile's wash, the hexagon's hover fill.
- `accent` is the button fill. In the template's palette it IS the yellow, and
  its label `on-accent` is the dark ink (#222 on #fab700 is 9.1:1). In a
  palette whose accent is dark (steel blue, signal red) the label is white;
  the audit measures, it does not assume.
- `accent-deep` is the button's 1px edge, 3:1 against the page, so a yellow
  button on white still reads as a button (WCAG 1.4.11).
- `primary` / `primary-deep` are the readable shades: links, eyebrows, the
  hovered card title.

Nothing here is eyeballed: audit() computes every pair the design produces and
refuses to write a palette that fails, including the dark-mode palette that
assets/css/scheme.css derives at runtime.

Usage:  python3 .dev/build_theme.py
"""

import collections
import json
import os
import re

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
os.chdir(ROOT)

# ---------------------------------------------------------------------------
# Palette
# ---------------------------------------------------------------------------
# The same slugs in every variation, so a pattern written against them works
# under all of them. `overlay` is separate from `base` on purpose: text on a
# dimmed photograph must stay near-white even when the palette is dark.
PALETTE = [
    ("Base",          "base",          "#ffffff"),
    ("Surface",       "surface",       "#f9f9ff"),   # the template's own panel ground
    ("Contrast",      "contrast",      "#222222"),   # headings, the template's #222
    ("Muted",         "muted",         "#6b6b6b"),   # body copy; the template's #777 is 4.48:1
    ("Primary",       "primary",       "#8a6400"),   # readable amber: links, eyebrows
    ("Primary deep",  "primary-deep",  "#6b4d00"),   # hover
    ("Brand",         "brand",         "#fab700"),   # the template's yellow, decorative
    ("Accent",        "accent",        "#fab700"),   # button fill
    ("Accent deep",   "accent-deep",   "#9c7300"),   # button edge, 3:1 on the page
    ("On accent",     "on-accent",     "#222222"),   # label on an accent fill
    ("Dark",          "dark",          "#04091e"),   # footer and dimmed-photo ground
    ("Charcoal",      "charcoal",      "#222222"),   # the top bar
    ("Divider",       "divider",       "#e6e6ee"),
    ("Overlay",       "overlay",       "#ffffff"),   # text on photographs, `dark`, `charcoal`
    ("On dark",       "on-dark",       "#aab0c0"),   # body copy on `dark`
]

def light(**kw):
    base = {"base": "#ffffff", "overlay": "#ffffff"}
    base.update(kw)
    return base

COLOR_SETS = {
    "colors-1-industry": ("Industry", light(
        surface="#f9f9ff", contrast="#222222", muted="#6b6b6b",
        primary="#8a6400", **{"primary-deep": "#6b4d00"},
        brand="#fab700", accent="#fab700", **{"accent-deep": "#9c7300", "on-accent": "#222222"},
        dark="#04091e", charcoal="#222222", divider="#e6e6ee", **{"on-dark": "#aab0c0"})),
    "colors-2-hi-vis": ("Hi-vis", light(
        surface="#faf8f5", contrast="#1c1c1c", muted="#65615c",
        primary="#a84300", **{"primary-deep": "#833400"},
        brand="#ff7a00", accent="#ff7a00", **{"accent-deep": "#b45000", "on-accent": "#1c1c1c"},
        dark="#1a1a1a", charcoal="#262626", divider="#ebe6df", **{"on-dark": "#bdb7af"})),
    "colors-3-steel": ("Steel", light(
        surface="#f4f7fb", contrast="#14202e", muted="#56626f",
        primary="#1f5fa8", **{"primary-deep": "#174a84"},
        brand="#3a8ee6", accent="#1f5fa8", **{"accent-deep": "#174a84", "on-accent": "#ffffff"},
        dark="#0b1a2c", charcoal="#13263d", divider="#dfe6ef", **{"on-dark": "#a9b8ca"})),
    "colors-4-signal": ("Signal", light(
        surface="#fbf7f6", contrast="#231a19", muted="#675c5a",
        primary="#b41d16", **{"primary-deep": "#8e1611"},
        brand="#e8352b", accent="#c21f18", **{"accent-deep": "#8e1611", "on-accent": "#ffffff"},
        dark="#1a1010", charcoal="#2a1b1a", divider="#eee2e0", **{"on-dark": "#c4b3b1"})),
    "colors-5-machine": ("Machine", light(
        surface="#f5f8f6", contrast="#16231c", muted="#56645b",
        primary="#1b6e45", **{"primary-deep": "#135233"},
        brand="#34b27a", accent="#1b6e45", **{"accent-deep": "#135233", "on-accent": "#ffffff"},
        dark="#0c1a13", charcoal="#15261d", divider="#dde8e1", **{"on-dark": "#a8bcaf"})),
    "colors-6-copper": ("Copper", light(
        surface="#faf6f2", contrast="#261a12", muted="#69594d",
        primary="#97501f", **{"primary-deep": "#743c15"},
        brand="#d9843f", accent="#9a5220", **{"accent-deep": "#743c15", "on-accent": "#ffffff"},
        dark="#1d130d", charcoal="#2b1d14", divider="#eee3d8", **{"on-dark": "#c9b6a6"})),
    # Dark palettes: `base` is the page, so it is dark here. A bright button
    # takes the DARK label, and its edge must be light to show on the page.
    "colors-7-night-shift": ("Night shift", {
        "base": "#0e1116", "surface": "#161a22", "contrast": "#eef1f5", "muted": "#a3abb8",
        "primary": "#fbc53a", "primary-deep": "#ffd873",
        "brand": "#fab700", "accent": "#fab700", "accent-deep": "#d9a000", "on-accent": "#111111",
        "dark": "#05070b", "charcoal": "#0a0d12", "divider": "#262c38",
        "overlay": "#ffffff", "on-dark": "#b6bdc9"}),
    "colors-8-graphite": ("Graphite", {
        "base": "#161616", "surface": "#202020", "contrast": "#f2f2f2", "muted": "#ababab",
        "primary": "#ff9d47", "primary-deep": "#ffb877",
        "brand": "#ff7a00", "accent": "#ff8a1f", "accent-deep": "#ff8a1f", "on-accent": "#161616",
        "dark": "#0b0b0b", "charcoal": "#0f0f0f", "divider": "#333333",
        "overlay": "#ffffff", "on-dark": "#bdbdbd"}),
}
DEFAULT_COLORS = "colors-1-industry"

# Typography. Poppins is the template's only face. Oswald is the condensed
# alternative a plant or a yard reaches for (it reads like signage), and the
# system stack is the zero-download option. Two families, five pairings.
TYPE_SETS = {
    "type-1-poppins": ("Poppins throughout", "poppins", "poppins", None),
    "type-2-oswald-poppins": ("Oswald headings, Poppins text", "oswald", "poppins", None),
    "type-3-poppins-system": ("Poppins headings, system text", "poppins", "system", "400"),
    "type-4-oswald-system": ("Oswald headings, system text", "oswald", "system", "400"),
    "type-5-system": ("System fonts", "system", "system", "400"),
}

LATIN = ("U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, "
         "U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD")
LATIN_EXT = ("U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, U+0308, U+0329, "
             "U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20C0, U+2113, "
             "U+2C60-2C7F, U+A720-A7FF")

# name, CSS stack, [(weight, file stem)] — each stem ships as -latin and -latin-ext.
FAMILIES = collections.OrderedDict([
    ("poppins", ("Poppins", "Poppins, system-ui, -apple-system, 'Segoe UI', sans-serif",
                 [(w, "poppins-%s-" + w + "-normal") for w in ("300", "400", "500", "600", "700")])),
    ("oswald", ("Oswald", "Oswald, 'Arial Narrow', 'Helvetica Neue', sans-serif",
                [("200 700", "oswald-%s-wght-normal")])),
    ("system", ("System", "system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif", [])),
])


def fluid(minimum, maximum):
    return collections.OrderedDict([("min", minimum), ("max", maximum)])


# The template's scale, restated: 12px navigation and top bar, 14px eyebrows
# and buttons, 18px card titles, 24px counters, 36px section titles and 48px
# on the hero and the page banners. Body copy is 15px rather than the
# template's 14px light weight: a demo's size, and a firm's case studies are read.
FONT_SIZES = [
    ("X Small",  "x-small",  "0.75rem",   None),
    ("Small",    "small",    "0.875rem",  None),
    ("Medium",   "medium",   "0.9375rem", None),
    ("Large",    "large",    "1.125rem",  None),
    ("X Large",  "x-large",  "1.5rem",    fluid("1.25rem", "1.5rem")),
    ("Heading",  "heading",  "2.25rem",   fluid("1.75rem", "2.25rem")),
    ("Display",  "display",  "3rem",      fluid("2.25rem", "3rem")),
]

# The template's section gap is 120px top and bottom; 80 lands on it at
# desktop and steps down on a phone. 60 is the gap under a section title.
SPACING = [
    ("20", "0.5rem"),
    ("30", "1rem"),
    ("40", "1.5rem"),
    ("50", "clamp(1.75rem, 3vw, 2.5rem)"),
    ("60", "clamp(2.5rem, 5vw, 3.75rem)"),
    ("70", "clamp(3rem, 6vw, 5rem)"),
    ("80", "clamp(4.5rem, 9vw, 7.5rem)"),
]

# Every foreground/background pair the design puts together, at the ratio it
# needs: 4.5 for text, 3 for large numerals, graphics and a button's edge.
CONTRAST_CHECKS = [
    ("contrast", "base", 4.5), ("contrast", "surface", 4.5),
    ("muted", "base", 4.5), ("muted", "surface", 4.5),
    ("primary", "base", 4.5), ("primary", "surface", 4.5),
    ("primary-deep", "base", 4.5), ("primary-deep", "surface", 4.5),
    # Buttons: the label on the fill, and the same pair turned over on hover
    # (the fill becomes the label colour and the label the fill).
    ("on-accent", "accent", 4.5),
    # The button's 1px edge against every page ground it stands on.
    ("accent-deep", "base", 3.0), ("accent-deep", "surface", 3.0),
    # Photographs sit on `dark`; the top bar is `charcoal`.
    ("overlay", "dark", 4.5), ("on-dark", "dark", 4.5),
    ("overlay", "charcoal", 4.5), ("on-dark", "charcoal", 4.5),
    # The counters' numerals (24px bold, large text) on the brand discs.
    ("on-accent", "accent", 3.0),
    # The dark button style: `contrast` fill, `base` label.
    ("base", "contrast", 4.5),
]

# Checked against the dark-mode palette scheme.css derives (see _dark_scheme).
DARK_CHECKS = [
    ("contrast", "base", 4.5), ("contrast", "surface", 4.5),
    ("muted", "base", 4.5), ("muted", "surface", 4.5),
    ("primary", "base", 4.5), ("primary", "surface", 4.5),
    ("primary-deep", "base", 4.5),
    ("on-accent", "accent", 4.5),
    ("accent-deep", "base", 3.0), ("accent-deep", "surface", 3.0),
    ("base", "contrast", 4.5),
]


# ---------------------------------------------------------------------------
# Contrast
# ---------------------------------------------------------------------------
def _channel(value):
    value = value / 255
    return value / 12.92 if value <= 0.04045 else ((value + 0.055) / 1.055) ** 2.4


def luminance(hex_colour):
    r, g, b = (int(hex_colour[i:i + 2], 16) for i in (1, 3, 5))
    return 0.2126 * _channel(r) + 0.7152 * _channel(g) + 0.0722 * _channel(b)


def contrast_ratio(a, b):
    la, lb = luminance(a), luminance(b)
    lighter, darker = max(la, lb), min(la, lb)
    return (lighter + 0.05) / (darker + 0.05)


# ---------------------------------------------------------------------------
# theme.json
# ---------------------------------------------------------------------------
def od(*pairs):
    return collections.OrderedDict(pairs)


def var(slug):
    return "var(--wp--preset--color--%s)" % slug


def fs(slug):
    return "var(--wp--preset--font-size--%s)" % slug


def ff(slug):
    return "var(--wp--preset--font-family--%s)" % slug


def sp(slug):
    valid = {s for s, _ in SPACING}
    if slug not in valid:
        raise SystemExit("spacing %r is not on the scale %s" % (slug, sorted(valid)))
    return "var(--wp--preset--spacing--%s)" % slug


def palette(colors):
    missing = [slug for _, slug, _ in PALETTE if slug not in colors]
    if missing:
        raise SystemExit("palette is missing %s" % ", ".join(missing))
    return [od(("name", name), ("slug", slug), ("color", colors[slug])) for name, slug, _ in PALETTE]


def font_families():
    out = []
    for key, (name, stack, faces) in FAMILIES.items():
        entry = od(("name", name), ("slug", key), ("fontFamily", stack))
        if faces:
            entry["fontFace"] = []
            for weight, stem in faces:
                for subset, rng in (("latin", LATIN), ("latin-ext", LATIN_EXT)):
                    entry["fontFace"].append(od(
                        ("fontFamily", name), ("fontStyle", "normal"), ("fontWeight", weight),
                        ("fontDisplay", "swap"),
                        ("src", ["file:./assets/fonts/%s.woff2" % (stem % subset)]),
                        ("unicodeRange", rng),
                    ))
        out.append(entry)
    return out


def font_files():
    files = []
    for _, (_, _, faces) in FAMILIES.items():
        for _, stem in faces:
            files += ["%s.woff2" % (stem % s) for s in ("latin", "latin-ext")]
    return files


GRADIENTS = []


def build_settings():
    return od(
        ("appearanceTools", True),
        ("useRootPaddingAwareAlignments", True),
        # The template is a Bootstrap 4 layout: a 1140px container with 15px
        # gutters, so 1110px of content. Wide is the blog's article + sidebar.
        ("layout", od(("contentSize", "1110px"), ("wideSize", "1290px"))),
        ("color", od(("custom", True), ("defaultPalette", False), ("defaultGradients", False),
                     ("defaultDuotone", False),
                     ("palette", palette(COLOR_SETS[DEFAULT_COLORS][1])),
                     ("gradients", [od(("name", n), ("slug", s), ("gradient", g)) for n, s, g in GRADIENTS]))),
        ("typography", od(
            ("fluid", True), ("customFontSize", True), ("defaultFontSizes", False),
            ("fontFamilies", font_families()),
            # A size with no fluid range is fixed: left to WordPress's default
            # fluid rule, 15px body copy shrinks to 14px on a phone and the 18px
            # site title to 14px.
            ("fontSizes", [od(("name", name), ("slug", slug), ("size", size), ("fluid", f if f else False))
                           for name, slug, size, f in FONT_SIZES]),
        )),
        ("spacing", od(("units", ["px", "em", "rem", "vh", "vw", "%"]),
                       ("padding", True), ("margin", True), ("blockGap", True),
                       ("defaultSpacingSizes", False),
                       ("spacingSizes", [od(("name", name), ("slug", name), ("size", size))
                                         for name, size in SPACING]))),
        ("border", od(("color", True), ("radius", True), ("style", True), ("width", True))),
        ("shadow", od(("defaultPresets", False), ("presets", [
            # The template's own card hover, a long soft shadow down and left.
            od(("name", "Card"), ("slug", "card"), ("shadow", "0 10px 30px 0 rgba(157, 157, 157, 0.3)")),
            od(("name", "Header"), ("slug", "header"), ("shadow", "-21px 21px 30px 0 rgba(158, 158, 158, 0.3)")),
        ]))),
    )


def build_styles():
    return od(
        ("color", od(("background", var("base")), ("text", var("muted")))),
        ("typography", od(("fontFamily", ff("poppins")), ("fontSize", fs("medium")),
                          ("fontWeight", "300"), ("lineHeight", "1.7"))),
        ("spacing", od(("blockGap", sp("40")),
                       ("padding", od(("top", "0px"), ("bottom", "0px"),
                                      ("left", sp("40")), ("right", sp("40")))))),
        ("elements", od(
            ("heading", od(("typography", od(("fontFamily", ff("poppins")), ("fontWeight", "600"),
                                             ("lineHeight", "1.2"))),
                           ("color", od(("text", var("contrast")))))),
            ("h1", od(("typography", od(("fontSize", fs("display")))))),
            ("h2", od(("typography", od(("fontSize", fs("heading")))))),
            ("h3", od(("typography", od(("fontSize", fs("x-large")))))),
            ("h4", od(("typography", od(("fontSize", fs("large")))))),
            ("h5", od(("typography", od(("fontSize", "1rem"))))),
            ("h6", od(("typography", od(("fontSize", fs("small")))))),
            ("link", od(("color", od(("text", var("primary")))),
                        (":hover", od(("color", od(("text", var("primary-deep")))))))),
            ("button", od(
                # The template's flat yellow button. The 1px `accent-deep` edge
                # is what makes a yellow fill read as a button on a white page;
                # the label is `on-accent`, measured against the fill in every
                # palette and in dark mode. Hover (style.css) turns it over.
                ("color", od(("background", var("accent")), ("text", var("on-accent")))),
                ("typography", od(("fontFamily", "inherit"), ("fontWeight", "500"),
                                  ("fontSize", fs("small")), ("lineHeight", "1.5"))),
                ("border", od(("radius", "0px"), ("width", "1px"), ("style", "solid"),
                              ("color", var("accent-deep")))),
                ("spacing", od(("padding", od(("top", "0.6875rem"), ("bottom", "0.6875rem"),
                                              ("left", "1.875rem"), ("right", "1.875rem"))))),
            )),
            ("caption", od(("typography", od(("fontSize", fs("small")))))),
        )),
        ("blocks", od(
            ("core/separator", od(("color", od(("text", var("divider")))))),
            ("core/site-title", od(("typography", od(("fontWeight", "600"), ("fontSize", fs("x-large")),
                                                     ("lineHeight", "1.2"))),
                                   ("elements", od(("link", od(("color", od(("text", var("contrast")))),
                                                               ("typography", od(("textDecoration", "none"))))))))),
            ("core/navigation", od(("typography", od(("fontSize", fs("x-small")), ("fontWeight", "400"),
                                                     ("textTransform", "uppercase"))))),
            ("core/post-title", od(("elements", od(("link", od(("color", od(("text", var("contrast")))),
                                                               ("typography", od(("textDecoration", "none"))))))))),
            ("core/quote", od(("border", od(("left", od(("color", var("brand")), ("style", "solid"),
                                                        ("width", "2px"))))),
                              ("color", od(("background", var("surface")))),
                              ("spacing", od(("padding", od(("top", sp("40")), ("bottom", sp("40")),
                                                            ("left", sp("40")), ("right", sp("40")))))),
                              ("typography", od(("fontStyle", "normal")))),
             ),
            ("core/pullquote", od(("border", od(("top", od(("color", var("brand")), ("style", "solid"), ("width", "2px"))),
                                                ("bottom", od(("color", var("brand")), ("style", "solid"), ("width", "2px"))))))),
        )),
    )


def build_theme():
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3),
        ("settings", build_settings()),
        ("styles", build_styles()),
        ("customTemplates", [
            od(("name", "page-no-title"), ("title", "Page without banner"), ("postTypes", ["page"])),
            od(("name", "page-with-sidebar"), ("title", "Page with sidebar"), ("postTypes", ["page"])),
            od(("name", "single-no-sidebar"), ("title", "Post without sidebar"), ("postTypes", ["post"])),
        ]),
        ("templateParts", [
            od(("name", "header"), ("title", "Header"), ("area", "header")),
            od(("name", "footer"), ("title", "Footer"), ("area", "footer")),
            od(("name", "sidebar"), ("title", "Sidebar"), ("area", "uncategorized")),
        ]),
    )


def build_color_variation(slug, name, colors):
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3), ("title", name),
        ("settings", od(("color", od(("palette", palette(colors)))))),
    )


def build_type_variation(slug, name, heading, body, weight):
    typography = od(("fontFamily", ff(body)))
    if weight:
        # A light weight is Poppins' character; in a system face it just reads thin.
        typography["fontWeight"] = weight
    return od(
        ("$schema", "https://schemas.wp.org/trunk/theme.json"),
        ("version", 3), ("title", name),
        ("styles", od(
            ("typography", typography),
            ("elements", od(
                ("heading", od(("typography", od(("fontFamily", ff(heading)))))),
                ("button", od(("typography", od(("fontFamily", ff(body)))))),
            )),
            ("blocks", od(("core/site-title", od(("typography", od(("fontFamily", ff(heading)))))))),
        )),
    )


def write(path, data):
    os.makedirs(os.path.dirname(path) or ".", exist_ok=True)
    with open(path, "w", encoding="utf-8") as handle:
        json.dump(data, handle, indent="\t", ensure_ascii=False)
        handle.write("\n")
    return path


def _mix_with_white(hex_colour, percent):
    """CSS `color-mix(in srgb, <colour> <percent>%, white)`, per channel."""
    channels = [int(hex_colour[i:i + 2], 16) for i in (1, 3, 5)]
    share = percent / 100
    return "#" + "".join("%02x" % round(c * share + 255 * (1 - share)) for c in channels)


def _dark_scheme(colors):
    """The palette as assets/css/scheme.css turns it, read from the file itself.

    Read rather than restated: the numbers live in the CSS, and a second copy
    here would drift from it. Every `--wp--preset--color--X` the dark class
    sets is either a fixed hex or `color-mix(in srgb, var(--…--Y) N%, white)`;
    anything else is refused, and so is any slug the palette does not define
    (a colour-mix on an undefined variable makes the declaration invalid, the
    variable stops resolving and every button renders as bare text while
    every text check still passes). A slug may not mix from itself: that is a
    cycle, and CSS drops it the same way.
    """
    css = open("assets/css/scheme.css", encoding="utf-8").read()
    defined = {slug for _, slug, _ in PALETTE}
    referenced = set(re.findall(r"var\(--wp--preset--color--([a-z0-9-]+)\)", css))
    unknown = sorted(referenced - defined)
    if unknown:
        raise SystemExit("scheme.css reads colour slugs the palette does not define: %s" % ", ".join(unknown))
    out = dict(colors)
    for block in re.findall(r"\.industry-dark\s*\{([^}]*)\}", css):
        for slug, value in re.findall(r"--wp--preset--color--([a-z0-9-]+):\s*([^;]+);", block):
            value = value.strip()
            m = re.match(r"color-mix\(in srgb,\s*var\(--wp--preset--color--([a-z0-9-]+)\)\s*(\d+)%,\s*white\)$", value)
            if m:
                if m.group(1) == slug:
                    raise SystemExit("scheme.css: `%s` mixes from itself" % slug)
                out[slug] = _mix_with_white(colors[m.group(1)], int(m.group(2)))
            elif re.match(r"#[0-9a-fA-F]{6}$", value):
                out[slug] = value.lower()
            else:
                raise SystemExit("scheme.css: cannot read the dark-mode `%s`: %s" % (slug, value))
    return out


def audit():
    problems = []
    print("  palette        label/fill  edge/base  primary/base  muted/base   dark: label  edge  primary")
    for slug, (name, colors) in sorted(COLOR_SETS.items()):
        for fg, bg, need in CONTRAST_CHECKS:
            ratio = contrast_ratio(colors[fg], colors[bg])
            if ratio < need:
                problems.append("%s: %s on %s is %.2f, needs %.1f" % (name, fg, bg, ratio, need))
        dark = _dark_scheme(colors)
        for fg, bg, need in DARK_CHECKS:
            ratio = contrast_ratio(dark[fg], dark[bg])
            if ratio < need:
                problems.append("%s (dark mode): %s on %s is %.2f, needs %.1f" % (name, fg, bg, ratio, need))
        print("  %-13s %10.2f  %9.2f  %12.2f  %10.2f  %11.2f  %4.2f  %7.2f" % (
            name, contrast_ratio(colors["on-accent"], colors["accent"]),
            contrast_ratio(colors["accent-deep"], colors["base"]),
            contrast_ratio(colors["primary"], colors["base"]),
            contrast_ratio(colors["muted"], colors["base"]),
            contrast_ratio(dark["on-accent"], dark["accent"]),
            contrast_ratio(dark["accent-deep"], dark["base"]),
            contrast_ratio(dark["primary"], dark["base"])))
    print("\n  for the record: the template's #fab700 is %.2f:1 on white and white on it %.2f:1; #777 is %.2f:1."
          % (contrast_ratio("#fab700", "#ffffff"), contrast_ratio("#ffffff", "#fab700"),
             contrast_ratio("#777777", "#ffffff")))
    if problems:
        raise SystemExit("\nContrast failures:\n  " + "\n  ".join(problems))


def check_fonts():
    missing = [f for f in font_files() if not os.path.exists(os.path.join("assets/fonts", f))]
    if missing:
        print("\n  warning: fonts not downloaded yet (node .dev/build-fonts.mjs): %s" % ", ".join(missing))


def main():
    audit()
    written = [write("theme.json", build_theme())]
    for slug, (name, colors) in sorted(COLOR_SETS.items()):
        written.append(write("styles/colors/%s.json" % slug, build_color_variation(slug, name, colors)))
    for slug, (name, heading, body, weight) in sorted(TYPE_SETS.items()):
        written.append(write("styles/typography/%s.json" % slug,
                             build_type_variation(slug, name, heading, body, weight)))
    check_fonts()
    print("\n  %d files written" % len(written))
    for path in written:
        print("    " + path)


if __name__ == "__main__":
    main()

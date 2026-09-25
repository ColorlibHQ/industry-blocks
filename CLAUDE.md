# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What this is

**Industry 1.0.0** is a Colorlib **WordPress block theme** (Full Site Editing)
for industrial manufacturers, engineering contractors and construction firms.
31 patterns, 14 templates, 3 parts, 8 colour palettes × 5 type pairings, 6
starter pages built on activation, visitor dark mode, WooCommerce styling, and
quote / contact / newsletter forms that need no plugin. Text domain and slug
`industry`.

It was rebuilt from the **Industry HTML template**
(`preview.colorlib.com/theme/industry/`, Bootstrap 4 + jQuery): the charcoal
top bar over the white navigation, the full-screen hero, the three hexagon
features, the about block beside the quote form, the market-sector cards, the
ringed counters over a warehouse, the project mosaic, the reviews band with
its play tile, the blog cards and the dark three-column footer. Judged with
side-by-side full-page renders (`.dev/compare.mjs`), not property by property.
The Elementor edition's demo is `colorlibhub.com/industry/` (repo
`ColorlibHQ/industry`, which bundles its companion in `inc/industry-companion/`
and needs Elementor).

**Block theme only, no companion plugin, no page builder, no jQuery.**
Distribution is **outside WordPress.org**: `Update URI` points at
`updates.colorlib.com`. It is **not** a static HTML template — the HTML-template
upgrade phases and R2 preview flow in the global instructions do not apply.

Provenance: toolchain and `inc/` ported from Horseclub
(`~/Fresh Projects/horseclub-blocks`, its fixed checkers) with Dreamrs'
directory-independent updater, child-theme-safe stylesheet enqueue,
`check-rendered.sh`, `capture.mjs` and `theme-check.mjs`. **Every leftover word
from a source theme is a silent bug**: `grep -riE "horseclub|dreamrs|unioncorp|pato|daren"`
must find nothing outside this paragraph.

## The story (demo content)

One firm: an engineering and construction contractor on the docks, founded
1984, 640 staff, that designs, fabricates, installs and maintains industrial
plant. Every photograph is Pexels (readme.txt credits each). The template's
photographs were traced by reverse image search (TinEye JSON + Yandex, then
OpenCV template matching); Freepik/iStock ones (the foundry, the pump room,
the highway), a removed Pexels copy (the port hero) and a Creative Market /
deleted-Unsplash one (the loom) were replaced, and the skateboarder in a
derelict hall was swapped for a finished-looking hall because it could not
read as "a finished project". Kept template photos were re-cut from the
Pexels originals at 2× the same crop. Demo post photos (`.dev/demo/media/`)
are separate from the theme's.

## Commands

```bash
python3 .dev/build_theme.py        # theme.json + styles/**; audits every palette (and dark mode), refuses a failing one
python3 .dev/build_patterns.py     # patterns/*.php (deletes and rewrites them all)
node    .dev/build-fonts.mjs       # assets/fonts: Poppins 300–700 + Oswald variable, latin + latin-ext

# A throwaway WordPress on this theme's port (9493). Restart it after any
# pattern change: starter pages are copies made at activation.
npx -y @wp-playground/cli@3.1.54 server --port=9493 --php=8.3 --wp=latest \
  --mount-before-install="$PWD:/wordpress/wp-content/themes/industry" \
  --blueprint=.dev/blueprint.json --login

node .dev/normalize-blocks.mjs     # ALWAYS after build_patterns.py (twice: the second must rewrite 0)
node .dev/validate-blocks.mjs      # 0 invalid across patterns, templates, parts, stored pages, menus
node .dev/editor-check.mjs         # every pattern opened in the editor
bash .dev/check-rendered.sh        # contrast + buttons (8 palettes × light/dark) + overflow + alignment + dead selectors
python3 .dev/dead-selectors.py
node .dev/compare.mjs              # .dev/compare/<page>-<width>.jpg, template left, theme right
bash .dev/build-zip.sh             # /tmp/industry-build/industry.zip
```

Playwright and sharp come from `node_modules`, a symlink (gitignored) to
`~/Fresh Projects/tailwind-templates/node_modules`.

Theme Check: `bash .dev/build-zip.sh <dir>`, mount `<dir>/industry` in a
Playground with `.dev/blueprint-themecheck.json`, then `node .dev/theme-check.mjs`.

## Where things live

| Concern | File(s) |
| --- | --- |
| Palettes, type, spacing, element styles | `.dev/build_theme.py` → `theme.json`, `styles/**` (never edit the JSON) |
| Every section, part body, hidden partial and page | `.dev/build_patterns.py` (+ `.dev/patternlib.py`) → `patterns/*.php` |
| Header / footer / sidebar parts | `parts/*.html`, each one `wp:pattern` reference |
| Templates (14) | `templates/*.html` — hand-written, validated by validate-blocks |
| Components, block styles, header, icons | `style.css` (also the editor stylesheet) |
| Quote, contact and newsletter forms | `inc/enquiry.php` (`[industry_form type= layout= button=]`) + `assets/css/forms.css` |
| Starter pages + menu on activation | `inc/front-page-setup.php` |
| Dark mode | `inc/scheme.php`, `assets/css/scheme.css`, `assets/js/scheme-toggle.js` |
| Reveals, counters, reviews slider, video popup, header shadow | `assets/js/interactions.js` |
| Self-hosted updates | `inc/updates.php` (matched by Update URI, not directory) |
| WooCommerce | `inc/woocommerce.php`, `assets/css/woocommerce.css` |
| Demo content (colorlibhub + Playground, not shipped) | `.dev/demo/import.php`, `.dev/demo/media/` |
| colorlib.com page material | `.dev/publish/` |

## Conventions that matter

- **Never hand-write pattern markup.** Generate it, then `normalize-blocks.mjs`
  re-serialises it through the real `wp.blocks.serialize`.
- **Colours are palette slugs that name jobs.** `brand` is the template's
  yellow and decorative only (rules, counter rings, logo mark, play-tile wash,
  stars). `accent` is the button fill with `on-accent` as its label;
  `accent-deep` is the button's 1px edge (3:1 on the page). `primary` /
  `primary-deep` are the readable amber for links and small coloured text.
  `overlay` is text on photographs, `dark` and `charcoal`; `on-dark` is body
  copy on `dark` (not on photographs — it measured 3.5:1 on the foundry).
  `charcoal` is the top bar. Every pair is in `CONTRAST_CHECKS`/`DARK_CHECKS`.
- **Buttons hover by turning over**: fill becomes `on-accent`, label `accent`.
  The template's hover (yellow words on white) is 1.8:1.
- **Dark mode mixes from `brand`**, which it never redefines: a slug mixed from
  itself is a CSS cycle and the declaration is dropped. build_theme.py reads
  scheme.css, refuses unknown slugs and self-mixes, and audits the result.
- **Preset classes carry `!important`**; size eyebrows and counters by class.
- **Icons are classes on the block** (`industry-icon--<name>` sets
  `--industry-icon`); the hexagon is `.industry-hex` on an empty, sized
  paragraph so the editor draws it. Every name needs a rule; dead-selectors checks.
- **Counters** are plain paragraphs (`.industry-counter__number`); the script
  counts up from whatever figure is typed, keeping decimals and suffixes.
- **Projects**: core images with lightbox and a caption drawn as a dark tag;
  the narrow first-row tile (`industry-project--fill`) takes its row's height
  on desktop.
- **The header is sticky** on `.wp-site-blocks > header`; the top bar hides
  below 768px; navigation collapses at 959px.
- **Starter content is inserted with `wp_slash()` and with kses lifted** for
  the theme's own inserts (the contact map iframe).
- **`get_page_by_path()` also matches attachments** — never use it.
- **Forms are one shortcode**; redirect target in a hidden field checked with
  `wp_validate_redirect()`; honeypot; nonce; `industry_form_handlers` lets a
  demo or a CRM take the submission.
- **Nothing depends on the directory name**: updates match the Update URI, the
  stylesheet is enqueued by template path, and no code compares
  `get_stylesheet()` to a literal. Tested mounted as `industry-blocks`.

## Release checklist

1. `php -l` every PHP file, `node --check` every JS file, JSON parses.
2. Regenerate; `build_theme.py` must print no contrast failures.
3. Fresh Playground; normalize → validate → editor-check → check-rendered.sh.
4. `compare.mjs` and look at the renders.
5. Bump `Version:` (style.css), `INDUSTRY_VERSION` (functions.php), `Stable tag:`
   (readme.txt) and add a changelog entry.
6. `build-zip.sh`, Theme Check the built theme, regenerate the .pot.

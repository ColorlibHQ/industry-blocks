#!/usr/bin/env python3
"""Scale shoot.mjs's raw captures into the product page's images.

Section shots: 1440x1000 -> exactly 1140x792, LANCZOS, progressive JPEG q82.
Cards: 1200x800 and 1200x900, written as captured.
Palettes: eight tiles four across, 12px gutters, a label under each, exactly
1140 wide.

    python3 .dev/publish/finish.py <raw-dir>
"""

import os
import sys

from PIL import Image, ImageDraw, ImageFont

raw = sys.argv[1]
out = os.path.join(os.path.dirname(os.path.abspath(__file__)), "images")
os.makedirs(out, exist_ok=True)


def save(im, name):
    path = os.path.join(out, name + ".jpg")
    im.convert("RGB").save(path, quality=82, progressive=True, optimize=True)
    print("%s.jpg %dx%d" % (name, im.width, im.height))


for f in sorted(os.listdir(raw)):
    if not f.endswith(".png") or f.startswith("palette-"):
        continue
    name = f[:-4]
    im = Image.open(os.path.join(raw, f))
    if name == "card-800":
        save(im, "industry-free-industrial-wordpress-theme")
    elif name == "card-900":
        save(im, "industry-free-industrial-wordpress-theme-card")
    else:
        assert im.size == (1440, 1000), (f, im.size)
        save(im.resize((1140, 792), Image.LANCZOS), name)

PALETTES = [
    ("colors-1-industry", "Industry"), ("colors-2-hi-vis", "Hi-vis"), ("colors-3-steel", "Steel"),
    ("colors-4-signal", "Signal"), ("colors-5-machine", "Machine"), ("colors-6-copper", "Copper"),
    ("colors-7-night-shift", "Night shift"), ("colors-8-graphite", "Graphite"),
]
GAP, COLS, WIDTH, LABEL = 12, 4, 1140, 30
tile_w = (WIDTH - GAP * (COLS - 1)) // COLS          # 276
tile_h = round(tile_w * 1000 / 1440)                  # 192
rows = (len(PALETTES) + COLS - 1) // COLS
height = rows * (tile_h + LABEL) + (rows - 1) * GAP
grid = Image.new("RGB", (WIDTH, height), "white")
draw = ImageDraw.Draw(grid)
try:
    font = ImageFont.truetype("/System/Library/Fonts/Supplemental/Arial Bold.ttf", 16)
except OSError:
    font = ImageFont.load_default()
left_over = WIDTH - (tile_w * COLS + GAP * (COLS - 1))
for i, (slug, label) in enumerate(PALETTES):
    tile = Image.open(os.path.join(raw, "palette-%s.png" % slug)).resize((tile_w, tile_h), Image.LANCZOS)
    col, row = i % COLS, i // COLS
    x = col * (tile_w + GAP) + (left_over if col == COLS - 1 else 0)
    y = row * (tile_h + LABEL + GAP)
    grid.paste(tile, (x, y))
    draw.text((x, y + tile_h + 7), label, fill="#1d2230", font=font)
save(grid, "industry-block-theme-colour-palettes")

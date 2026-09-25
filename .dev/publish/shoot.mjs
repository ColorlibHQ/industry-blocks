/**
 * The colorlib.com product page's screenshots, from a Playground with the demo
 * content imported (.dev/blueprint.json runs .dev/demo/import.php).
 *
 * Every section shot is one 1440x1000 viewport at scale 1, scaled with
 * LANCZOS to exactly 1140x792 (.dev/publish/finish.py does the scaling and
 * the JPEG encoding, so every image goes through the same resampler). The
 * palette image is the home page's about band under each of the eight
 * palettes, applied client-side exactly as a style variation would, in a grid
 * four across.
 *
 *   WP_URL=http://127.0.0.1:9493 node .dev/publish/shoot.mjs <raw-dir>
 *   python3 .dev/publish/finish.py <raw-dir>
 *
 * @package Industry
 */

import { chromium } from 'playwright';
import { mkdirSync, readFileSync } from 'node:fs';
import { join } from 'node:path';
import { fileURLToPath } from 'node:url';

const base = ( process.env.WP_URL || 'http://127.0.0.1:9493' ).replace( /\/$/, '' );
const raw = process.argv[ 2 ];
if ( ! raw ) {
	console.error( 'Usage: node .dev/publish/shoot.mjs <raw-dir>' );
	process.exit( 1 );
}
mkdirSync( raw, { recursive: true } );
const root = fileURLToPath( new URL( '../../', import.meta.url ) );

// name, path, section to put under the header (or null for the page top),
// px of the section's own ground to keep above it, options.
const SHOTS = [
	[ 'industry-block-theme-home', '/', null, 0 ],
	[ 'industry-block-theme-quote-form', '/', '#quote', 100 ],
	[ 'industry-block-theme-sectors', '/services/', '#sectors', 0 ],
	[ 'industry-block-theme-projects', '/', '#projects', 0 ],
	[ 'industry-block-theme-reviews', '/', '#reviews', 80 ],
	[ 'industry-block-theme-dark-mode', '/', '#sectors', 0, { dark: true } ],
	[ 'industry-block-theme-blog', '/blog/', '.industry-posts', 60 ],
	// The cards: the home hero only.
	[ 'card-800', '/', null, 0, { height: 800, width: 1200 } ],
	[ 'card-900', '/', null, 0, { height: 900, width: 1200 } ],
];

const PALETTES = [
	[ 'colors-1-industry', 'Industry' ],
	[ 'colors-2-hi-vis', 'Hi-vis' ],
	[ 'colors-3-steel', 'Steel' ],
	[ 'colors-4-signal', 'Signal' ],
	[ 'colors-5-machine', 'Machine' ],
	[ 'colors-6-copper', 'Copper' ],
	[ 'colors-7-night-shift', 'Night shift' ],
	[ 'colors-8-graphite', 'Graphite' ],
];

function paletteCss( slug ) {
	const data = JSON.parse( readFileSync( join( root, 'styles/colors', slug + '.json' ), 'utf8' ) );
	return ':root{' + data.settings.color.palette.map( ( p ) => `--wp--preset--color--${ p.slug }:${ p.color };` ).join( '' ) + '}';
}

const browser = await chromium.launch();

async function open( path, width, height ) {
	const context = await browser.newContext( { viewport: { width, height }, deviceScaleFactor: 1, reducedMotion: 'reduce' } );
	const page = await context.newPage();
	await page.goto( base + path, { waitUntil: 'networkidle', timeout: 90000 } );
	// --login signs every visitor in: no admin bar in a product shot.
	await page.addStyleTag( { content: '#wpadminbar{display:none!important}html{margin-top:0!important}.wp-site-blocks>header.wp-block-template-part{top:0!important}' } );
	// Every image decoded and every reveal fired before anything is captured.
	await page.evaluate( async () => {
		document.querySelectorAll( 'img[loading="lazy"]' ).forEach( ( img ) => {
			img.loading = 'eager';
		} );
		for ( let y = 0; y < document.body.scrollHeight; y += 400 ) {
			window.scrollTo( 0, y );
			await new Promise( ( r ) => setTimeout( r, 60 ) );
		}
		await Promise.allSettled( [ ...document.images ].map( ( img ) => img.decode().catch( () => {} ) ) );
		window.scrollTo( 0, 0 );
	} );
	await page.waitForTimeout( 800 );
	return { context, page };
}

async function scrollTo( page, selector, pad ) {
	if ( ! selector ) {
		return;
	}
	// The section's top lands just under the sticky header.
	await page.evaluate( ( [ sel, gap ] ) => {
		const el = document.querySelector( sel );
		const header = document.querySelector( 'header.wp-block-template-part' );
		const offset = header ? header.getBoundingClientRect().height : 0;
		window.scrollTo( 0, el.getBoundingClientRect().top + window.scrollY - offset - gap );
	}, [ selector, pad ] );
	await page.waitForTimeout( 800 );
}

for ( const [ name, path, selector, pad, opts = {} ] of SHOTS ) {
	const { context, page } = await open( path, opts.width || 1440, opts.height || 1000 );
	if ( opts.dark ) {
		await page.evaluate( () => document.documentElement.classList.add( 'industry-dark' ) );
		await page.waitForTimeout( 500 );
	}
	await scrollTo( page, selector, pad );
	// Nothing may be cut at the frame's edges: any line of text crossing the
	// top (below the header) or the bottom of the viewport is reported.
	const cut = await page.evaluate( () => {
		const vh = window.innerHeight;
		const header = document.querySelector( 'header.wp-block-template-part' );
		const top = header ? header.getBoundingClientRect().bottom : 0;
		const out = [];
		const walker = document.createTreeWalker( document.body, NodeFilter.SHOW_TEXT );
		while ( walker.nextNode() ) {
			const node = walker.currentNode;
			if ( ! node.textContent.trim() || node.parentElement.closest( 'header, .screen-reader-text' ) ) {
				continue;
			}
			const range = document.createRange();
			range.selectNodeContents( node );
			for ( const r of range.getClientRects() ) {
				if ( r.height && ( ( r.top < vh && r.bottom > vh ) || ( r.top < top && r.bottom > top ) ) ) {
					out.push( node.textContent.trim().slice( 0, 40 ) );
				}
			}
		}
		return out;
	} );
	await page.screenshot( { path: join( raw, name + '.png' ) } );
	console.log( name + ( cut.length ? '  CUT: ' + cut.join( ' | ' ) : '' ) );
	await context.close();
}

// Palettes: the about band (heading, button, the quote form on its photograph)
// under each palette.
const { context, page } = await open( '/', 1440, 1000 );
await scrollTo( page, '#quote', 100 );
for ( const [ slug, label ] of PALETTES ) {
	const style = await page.addStyleTag( { content: paletteCss( slug ) } );
	await page.waitForTimeout( 300 );
	await page.screenshot( { path: join( raw, 'palette-' + slug + '.png' ) } );
	await style.evaluate( ( el ) => el.remove() );
	console.log( 'palette ' + label );
}
await context.close();
await browser.close();

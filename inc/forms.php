<?php
/**
 * Form styling, for Industry's own forms and for whichever plugin a site uses.
 *
 * A company site often ends up with a form plugin as well, and every one of them
 * ships markup that ignores the theme: its own input borders, its own button
 * colours, its own spacing. Rather than let a Contact Form 7 block sit in the
 * middle of an Industry page looking like a different website, the stylesheet
 * maps each plugin's classes onto the theme's tokens.
 *
 * It always loads: the footer carries the newsletter form on every page, so
 * there is no page on which a form cannot appear.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;

/**
 * The form stylesheet.
 */
function industry_enqueue_form_styles() {
	wp_enqueue_style(
		'industry-forms',
		get_template_directory_uri() . '/assets/css/forms.css',
		array( 'industry-style' ),
		INDUSTRY_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'industry_enqueue_form_styles' );

/**
 * The same stylesheet in the editor, so a form block looks right there.
 */
function industry_editor_form_styles() {
	add_editor_style( 'assets/css/forms.css' );
}
add_action( 'after_setup_theme', 'industry_editor_form_styles', 20 );

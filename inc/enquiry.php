<?php
/**
 * The theme's own forms: quote request, contact and newsletter.
 *
 * An engineering contractor's site exists to bring in enquiries, so Industry
 * ships the forms rather than requiring a plugin for the one thing a visitor
 * came to do. One shortcode draws all three:
 *
 *     [industry_form type="quote" layout="compact" button="Request free quote"]
 *     [industry_form type="contact" layout="split"]
 *     [industry_form type="newsletter"]
 *
 * It is a **shortcode**, not inline PHP in a pattern. That is not a style
 * preference: inc/front-page-setup.php expands patterns into real post content
 * so the copy stays editable, and PHP inside stored post content never runs.
 * A pattern that rendered the form inline would freeze whatever it produced at
 * activation into the page forever.
 *
 * A theme must not create database tables or register a post type, so Industry
 * stores nothing. It validates, then hands the submission to whoever wants it:
 *
 *   - `industry_form_handlers` — return true from any handler to say the
 *     submission has been dealt with, and the built-in email is skipped. This
 *     is where a CRM, a mailing list or a webhook hooks in, and where a
 *     demo site swallows mail.
 *   - `industry_form_email_to` / `_subject` / `_body` — adjust the email the
 *     theme sends when nothing else claims the submission.
 *   - `industry_form_fields` — add, remove or relabel fields, per form type.
 *
 * The forms work with JavaScript off: each is a plain POST to the same URL,
 * answered with a redirect carrying the result.
 *
 * @package Industry
 */

defined( 'ABSPATH' ) || exit;

const INDUSTRY_FORM_ACTION = 'industry_form';

/**
 * The form types and their fields.
 *
 * @param string $type quote, contact or newsletter.
 * @return array<string, array<string, mixed>>
 */
function industry_form_fields( $type ) {
	$name  = array(
		'label'        => __( 'Your name', 'industry' ),
		'type'         => 'text',
		'autocomplete' => 'name',
		'required'     => true,
	);
	$email = array(
		'label'        => __( 'Email address', 'industry' ),
		'type'         => 'email',
		'autocomplete' => 'email',
		'required'     => true,
	);

	$sets = array(
		'quote'      => array(
			'service' => array(
				'label'    => __( 'Service', 'industry' ),
				'type'     => 'select',
				'required' => true,
				'options'  => industry_quote_services(),
			),
			'company' => array(
				'label'        => __( 'Company', 'industry' ),
				'type'         => 'text',
				'autocomplete' => 'organization',
				'required'     => false,
			),
			'name'    => $name,
			'email'   => $email,
			'phone'   => array(
				'label'        => __( 'Phone number', 'industry' ),
				'type'         => 'tel',
				'autocomplete' => 'tel',
				'required'     => false,
			),
			'message' => array(
				'label'    => __( 'Project details: site, scope and timing', 'industry' ),
				'type'     => 'textarea',
				'required' => true,
			),
		),
		'contact'    => array(
			'name'    => $name,
			'email'   => $email,
			'subject' => array(
				'label'    => __( 'Subject', 'industry' ),
				'type'     => 'text',
				'required' => false,
			),
			'message' => array(
				'label'    => __( 'Message', 'industry' ),
				'type'     => 'textarea',
				'required' => true,
			),
		),
		'newsletter' => array(
			'email' => $email,
		),
	);

	$fields = isset( $sets[ $type ] ) ? $sets[ $type ] : array();

	/**
	 * Filters the fields of one of the theme's forms.
	 *
	 * @param array  $fields Field definitions keyed by name.
	 * @param string $type   quote, contact or newsletter.
	 */
	return apply_filters( 'industry_form_fields', $fields, $type );
}

/**
 * The services a quote can be for: the first choice in the quote form.
 *
 * @return string[]
 */
function industry_quote_services() {
	/**
	 * Filters the services offered in the quote form's first field.
	 *
	 * @param string[] $services Service names, in the order shown.
	 */
	return apply_filters(
		'industry_quote_services',
		array(
			__( 'Planned maintenance', 'industry' ),
			__( 'Design and build', 'industry' ),
			__( 'Breakdown and repair', 'industry' ),
			__( 'Process piping and plant rooms', 'industry' ),
			__( 'Steelwork and structures', 'industry' ),
			__( 'Something else', 'industry' ),
		)
	);
}

/**
 * The known form types.
 *
 * @return string[]
 */
function industry_form_types() {
	return array( 'quote', 'contact', 'newsletter' );
}

/**
 * Render one field, label included.
 *
 * Every field has a real <label for>. The compact and inline layouts hide it
 * visually and show the same words as the placeholder, as the design does —
 * the label is still what a screen reader announces.
 *
 * @param string $form  Form type.
 * @param string $name  Field name.
 * @param array  $field Field definition.
 * @param bool   $quiet Whether the label is visually hidden.
 * @return string
 */
function industry_form_field( $form, $name, $field, $quiet ) {
	$id       = 'industry-' . $form . '-' . $name;
	$required = ! empty( $field['required'] );

	$attributes = array(
		'id'    => $id,
		'name'  => $name,
		'class' => 'industry-field__control',
	);

	if ( $required ) {
		$attributes['required'] = 'required';
	}
	if ( ! empty( $field['autocomplete'] ) ) {
		$attributes['autocomplete'] = $field['autocomplete'];
	}
	if ( isset( $field['min'] ) ) {
		$attributes['min'] = $field['min'];
	}
	if ( $quiet && 'select' !== $field['type'] ) {
		$attributes['placeholder'] = $field['label'] . ( $required ? ' *' : '' );
	}

	$label_class = 'industry-field__label' . ( $quiet ? ' screen-reader-text' : '' );

	$out  = '<p class="industry-field industry-field--' . esc_attr( $name ) . '">';
	$out .= '<label class="' . esc_attr( $label_class ) . '" for="' . esc_attr( $id ) . '">' . esc_html( $field['label'] );
	if ( $required ) {
		$out .= ' <span class="industry-field__required" aria-hidden="true">*</span>';
	}
	$out .= '</label>';

	if ( 'textarea' === $field['type'] ) {
		$attributes['rows'] = 4;
		$out               .= '<textarea' . industry_attributes( $attributes ) . '></textarea>';
	} elseif ( 'select' === $field['type'] ) {
		// The first option is the prompt, and it is empty, so `required` makes
		// the browser insist on a real choice before the form is sent.
		$out .= '<select' . industry_attributes( $attributes ) . '>';
		$out .= '<option value="">' . esc_html( $field['label'] . ( $required ? ' *' : '' ) ) . '</option>';
		foreach ( (array) $field['options'] as $option ) {
			$out .= '<option value="' . esc_attr( $option ) . '">' . esc_html( $option ) . '</option>';
		}
		$out .= '</select>';
	} else {
		$attributes['type'] = $field['type'];
		$out               .= '<input' . industry_attributes( $attributes ) . '>';
	}

	return $out . '</p>';
}

/**
 * Build an attribute string from a map, escaping every value.
 *
 * @param array $attributes Attribute map.
 * @return string
 */
function industry_attributes( $attributes ) {
	$out = '';
	foreach ( $attributes as $key => $value ) {
		if ( '' === $value ) {
			continue;
		}
		$out .= ' ' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
	}
	return $out;
}

/**
 * The form shortcode.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function industry_form( $atts = array() ) {
	$atts = shortcode_atts(
		array(
			'type'   => 'quote',
			'layout' => '',
			'button' => '',
		),
		$atts,
		'industry_form'
	);

	$type = in_array( $atts['type'], industry_form_types(), true ) ? $atts['type'] : 'quote';

	$defaults = array(
		'quote'      => array( 'compact', __( 'Request free quote', 'industry' ) ),
		'contact'    => array( 'split', __( 'Send message', 'industry' ) ),
		'newsletter' => array( 'inline', __( 'Subscribe', 'industry' ) ),
	);

	$layout = in_array( $atts['layout'], array( 'compact', 'split', 'inline', 'stacked' ), true ) ? $atts['layout'] : $defaults[ $type ][0];
	$label  = '' !== $atts['button'] ? $atts['button'] : $defaults[ $type ][1];
	$quiet  = 'stacked' !== $layout;
	$anchor = 'industry-form-' . $type;

	$out  = '<form class="industry-form industry-form--' . esc_attr( $layout ) . ' industry-form--' . esc_attr( $type ) . '" method="post" action="' . esc_url( industry_current_url() ) . '#' . esc_attr( $anchor ) . '">';
	$out .= '<span id="' . esc_attr( $anchor ) . '" class="industry-form__anchor"></span>';
	$out .= industry_form_notice( $type );
	$out .= wp_nonce_field( INDUSTRY_FORM_ACTION, 'industry_form_nonce', true, false );
	$out .= '<input type="hidden" name="action" value="' . esc_attr( INDUSTRY_FORM_ACTION ) . '">';
	$out .= '<input type="hidden" name="industry_form_type" value="' . esc_attr( $type ) . '">';

	// The page to come back to, carried explicitly.
	//
	// wp_get_referer() cannot do this job: it returns false whenever the
	// referer matches the current request URI, which is always the case for a
	// form that posts to its own page, and the visitor would land on the front
	// page with no form in sight. Validated with wp_validate_redirect() on the
	// way back out, so a crafted value cannot send anyone off-site.
	$out .= '<input type="hidden" name="industry_redirect" value="' . esc_url( industry_current_url() ) . '">';

	// A field no visitor sees and no visitor fills in. Bots fill everything.
	$out .= '<p class="industry-form__trap" aria-hidden="true">';
	$out .= '<label for="industry-' . esc_attr( $type ) . '-website">' . esc_html__( 'Leave this field empty', 'industry' ) . '</label>';
	$out .= '<input id="industry-' . esc_attr( $type ) . '-website" type="text" name="industry_website" tabindex="-1" autocomplete="off">';
	$out .= '</p>';

	$out .= '<div class="industry-form__grid">';
	foreach ( industry_form_fields( $type ) as $name => $field ) {
		$out .= industry_form_field( $type, $name, $field, $quiet );
	}

	if ( 'inline' === $layout ) {
		// A square button with an arrow, as the template's newsletter has it:
		// the words are for screen readers.
		$out .= '<button type="submit" class="industry-form__round wp-element-button"><span class="screen-reader-text">' . esc_html( $label ) . '</span></button>';
		$out .= '</div>';
	} else {
		$out .= '</div>';
		$out .= '<p class="industry-form__actions">';
		$out .= '<button type="submit" class="wp-block-button__link wp-element-button">' . esc_html( $label ) . '</button>';
		$out .= '</p>';
	}

	$out .= '</form>';

	return $out;
}
add_shortcode( 'industry_form', 'industry_form' );

/**
 * The current URL, without any previous result parameters.
 *
 * @return string
 */
function industry_current_url() {
	$url = is_singular() ? get_permalink() : '';
	if ( ! $url ) {
		$url = home_url( add_query_arg( array() ) );
	}
	return remove_query_arg( array( 'industry-form', 'industry-form-type' ), $url );
}

/**
 * The message shown after a submission, on the form that was submitted.
 *
 * @param string $type Form type.
 * @return string
 */
function industry_form_notice( $type ) {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- display only.
	$result = isset( $_GET['industry-form'] ) ? sanitize_key( wp_unslash( $_GET['industry-form'] ) ) : '';
	$which  = isset( $_GET['industry-form-type'] ) ? sanitize_key( wp_unslash( $_GET['industry-form-type'] ) ) : '';
	// phpcs:enable

	if ( $which !== $type ) {
		return '';
	}

	$sent = array(
		'quote'      => __( 'Thank you — your request is with our estimating team. An engineer will call or email within one working day.', 'industry' ),
		'contact'    => __( 'Thank you — your message is with us. We will reply by email shortly.', 'industry' ),
		'newsletter' => __( 'Thank you — you are on the list for the next newsletter.', 'industry' ),
	);

	$messages = array(
		'sent'    => array( 'ok', $sent[ $type ] ),
		'invalid' => array( 'error', __( 'Please check the form: every field marked * needs an answer.', 'industry' ) ),
		'email'   => array( 'error', __( 'That email address does not look right.', 'industry' ) ),
		'failed'  => array( 'error', __( 'Sorry, that could not be sent. Please call or email us instead.', 'industry' ) ),
		'expired' => array( 'error', __( 'That form had been open a while and expired. Please send it again.', 'industry' ) ),
	);

	if ( ! isset( $messages[ $result ] ) ) {
		return '';
	}

	list( $kind, $text ) = $messages[ $result ];

	return '<p class="industry-form__notice is-' . esc_attr( $kind ) . '" role="status">' . esc_html( $text ) . '</p>';
}

/**
 * Handle a submitted form.
 *
 * Runs on `template_redirect` so it can redirect before anything is sent —
 * the POST/redirect/GET that stops a refresh from sending it twice.
 */
function industry_handle_form() {
	if ( 'POST' !== ( isset( $_SERVER['REQUEST_METHOD'] ) ? $_SERVER['REQUEST_METHOD'] : '' ) ) {
		return;
	}
	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- checked immediately below.
	if ( ! isset( $_POST['action'] ) || INDUSTRY_FORM_ACTION !== $_POST['action'] ) {
		return;
	}

	// phpcs:disable WordPress.Security.NonceVerification.Missing -- nonce checked below; these only select the form and where to go.
	$type     = isset( $_POST['industry_form_type'] ) ? sanitize_key( wp_unslash( $_POST['industry_form_type'] ) ) : '';
	$posted   = isset( $_POST['industry_redirect'] ) ? esc_url_raw( wp_unslash( $_POST['industry_redirect'] ) ) : '';
	// phpcs:enable
	$type     = in_array( $type, industry_form_types(), true ) ? $type : 'quote';
	$redirect = wp_validate_redirect( $posted, home_url( '/' ) );
	$redirect = remove_query_arg( array( 'industry-form', 'industry-form-type' ), $redirect );

	$nonce = isset( $_POST['industry_form_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['industry_form_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, INDUSTRY_FORM_ACTION ) ) {
		industry_form_redirect( $redirect, $type, 'expired' );
	}

	// Silently accept and discard anything that filled the honeypot: telling a
	// bot it failed only teaches it to try again differently.
	if ( ! empty( $_POST['industry_website'] ) ) {
		industry_form_redirect( $redirect, $type, 'sent' );
	}

	$submission = array();
	foreach ( industry_form_fields( $type ) as $name => $field ) {
		$raw = isset( $_POST[ $name ] ) ? wp_unslash( $_POST[ $name ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitised by type below.
		$raw = is_string( $raw ) ? $raw : '';

		if ( 'textarea' === $field['type'] ) {
			$value = sanitize_textarea_field( $raw );
		} elseif ( 'select' === $field['type'] ) {
			// Only one of the offered choices is a value; anything else is empty.
			$value = in_array( $raw, (array) $field['options'], true ) ? $raw : '';
		} elseif ( 'email' === $field['type'] ) {
			$value = sanitize_email( $raw );
		} else {
			$value = sanitize_text_field( $raw );
		}

		// Something typed that is not an address gets the email message, not
		// "every field marked * needs an answer": sanitize_email() empties it.
		if ( 'email' === $field['type'] && '' !== trim( $raw ) && ! is_email( $value ) ) {
			industry_form_redirect( $redirect, $type, 'email' );
		}

		if ( ! empty( $field['required'] ) && '' === $value ) {
			industry_form_redirect( $redirect, $type, 'invalid' );
		}

		$submission[ $name ] = $value;
	}

	if ( ! empty( $submission['email'] ) && ! is_email( $submission['email'] ) ) {
		industry_form_redirect( $redirect, $type, 'email' );
	}

	/**
	 * Filters whether the submission has already been handled.
	 *
	 * Return true from any handler and Industry will not send its own email —
	 * which is how a CRM, a mailing list or a webhook takes over, and how a
	 * demo site keeps from sending mail.
	 *
	 * @param bool   $handled    Whether something has dealt with it.
	 * @param array  $submission The sanitised submission.
	 * @param string $type       quote, contact or newsletter.
	 */
	$handled = apply_filters( 'industry_form_handlers', false, $submission, $type );

	if ( ! $handled ) {
		$handled = industry_form_email( $submission, $type );
	}

	industry_form_redirect( $redirect, $type, $handled ? 'sent' : 'failed' );
}
add_action( 'template_redirect', 'industry_handle_form' );

/**
 * Redirect back to the form with a result, and stop.
 *
 * @param string $url    Where to go.
 * @param string $type   Form type.
 * @param string $result Result key.
 */
function industry_form_redirect( $url, $type, $result ) {
	$url = add_query_arg(
		array(
			'industry-form'      => $result,
			'industry-form-type' => $type,
		),
		$url
	);
	wp_safe_redirect( $url . '#industry-form-' . $type, 303 );
	exit;
}

/**
 * Email the submission to the site's admin address.
 *
 * From: is the site's own address, never the visitor's. Putting the visitor
 * there fails SPF and DMARC — the mail is sent by this server, not by their
 * provider — and it is the classic route to header injection. Reply-To carries
 * them instead, and wp_mail() rejects a header containing a newline.
 *
 * @param array  $submission Sanitised submission.
 * @param string $type       Form type.
 * @return bool
 */
function industry_form_email( $submission, $type ) {
	$to = apply_filters( 'industry_form_email_to', get_option( 'admin_email' ), $type );

	if ( ! $to || ! is_email( $to ) ) {
		return false;
	}

	$site = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
	$what = array(
		/* translators: %s: site name. */
		'quote'      => __( '[%s] Quote request', 'industry' ),
		/* translators: %s: site name. */
		'contact'    => __( '[%s] Website message', 'industry' ),
		/* translators: %s: site name. */
		'newsletter' => __( '[%s] Newsletter sign-up', 'industry' ),
	);
	$subject = sprintf( $what[ $type ], $site );
	$subject = apply_filters( 'industry_form_email_subject', $subject, $submission, $type );

	$lines  = array();
	$fields = industry_form_fields( $type );
	foreach ( $submission as $name => $value ) {
		if ( '' === $value ) {
			continue;
		}
		$label   = isset( $fields[ $name ]['label'] ) ? $fields[ $name ]['label'] : $name;
		$lines[] = $label . ': ' . $value;
	}

	$body = implode( "\n", $lines );
	$body = apply_filters( 'industry_form_email_body', $body, $submission, $type );

	$headers = array( 'Content-Type: text/plain; charset=UTF-8' );
	if ( ! empty( $submission['email'] ) && is_email( $submission['email'] ) ) {
		$headers[] = 'Reply-To: ' . $submission['email'];
	}

	return (bool) wp_mail( $to, $subject, $body, $headers );
}

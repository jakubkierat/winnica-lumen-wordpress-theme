<?php
/**
 * Obsługa formularza kontaktowego strony "Kontakt" (page-kontakt.php).
 *
 * Bez zewnętrznych wtyczek (typu Contact Form 7) — czysty PHP + wp_mail(),
 * z walidacją po stronie serwera, nonce i prostym honeypotem anty-spamowym.
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Przetwarza POST formularza kontaktowego, jeśli został wysłany.
 *
 * @return array{
 *     submitted: bool,
 *     success: bool,
 *     errors: array<string,string>,
 *     values: array<string,string>
 * }
 */
function winnica_lumen_handle_contact_form() {
	$result = array(
		'submitted' => false,
		'success'   => false,
		'errors'    => array(),
		'values'    => array(
			'name'    => '',
			'email'   => '',
			'phone'   => '',
			'message' => '',
		),
	);

	$is_post = isset( $_SERVER['REQUEST_METHOD'] ) && 'POST' === $_SERVER['REQUEST_METHOD'];

	if ( ! $is_post || ! isset( $_POST['winnica_lumen_contact_submit'] ) ) {
		return $result;
	}

	$result['submitted'] = true;

	// Honeypot: pole niewidoczne dla ludzi, wypełniane tylko przez boty.
	if ( ! empty( $_POST['website_url'] ) ) {
		// Udajemy sukces, żeby nie zdradzać botom, że zostały wykryte,
		// ale nic nie wysyłamy.
		$result['success'] = true;
		return $result;
	}

	if ( ! isset( $_POST['winnica_lumen_contact_nonce'] ) ||
		! wp_verify_nonce(
			sanitize_text_field( wp_unslash( $_POST['winnica_lumen_contact_nonce'] ) ),
			'winnica_lumen_contact_form'
		)
	) {
		$result['errors']['form'] = __( 'Sesja formularza wygasła. Odśwież stronę i spróbuj ponownie.', 'winnica-lumen' );
		return $result;
	}

	$name    = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';

	$result['values'] = compact( 'name', 'email', 'phone', 'message' );

	if ( mb_strlen( trim( $name ) ) < 2 ) {
		$result['errors']['name'] = __( 'Podaj imię i nazwisko (min. 2 znaki).', 'winnica-lumen' );
	}

	if ( '' === $email || ! is_email( $email ) ) {
		$result['errors']['email'] = __( 'Podaj poprawny adres e-mail.', 'winnica-lumen' );
	}

	if ( mb_strlen( trim( $message ) ) < 10 ) {
		$result['errors']['message'] = __( 'Wiadomość jest zbyt krótka (min. 10 znaków).', 'winnica-lumen' );
	}

	if ( ! empty( $result['errors'] ) ) {
		return $result;
	}

	$to      = get_option( 'admin_email' );
	$subject = sprintf(
		/* translators: %s: imię i nazwisko nadawcy. */
		__( 'Nowa wiadomość ze strony — od %s', 'winnica-lumen' ),
		$name
	);

	$body  = __( 'Nowa wiadomość z formularza kontaktowego Winnica Lumen:', 'winnica-lumen' ) . "\n\n";
	$body .= __( 'Imię i nazwisko:', 'winnica-lumen' ) . ' ' . $name . "\n";
	$body .= __( 'E-mail:', 'winnica-lumen' ) . ' ' . $email . "\n";

	if ( '' !== $phone ) {
		$body .= __( 'Telefon:', 'winnica-lumen' ) . ' ' . $phone . "\n";
	}

	$body .= "\n" . $message . "\n";

	$headers = array( 'Reply-To: ' . $name . ' <' . $email . '>' );

	$sent = wp_mail( $to, $subject, $body, $headers );

	$result['success'] = (bool) $sent;

	if ( ! $sent ) {
		$result['errors']['form'] = __( 'Nie udało się wysłać wiadomości. Spróbuj ponownie później lub napisz bezpośrednio e-mail.', 'winnica-lumen' );
	}

	return $result;
}

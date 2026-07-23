<?php
/**
 * Template Name: Kontakt
 *
 * Szablon strony kontaktowej z formularzem obsługiwanym po stronie PHP
 * (patrz inc/contact-form.php) — bez wtyczek typu Contact Form 7.
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact_result = winnica_lumen_handle_contact_form();
$values         = $contact_result['values'];
$errors         = $contact_result['errors'];

get_header();
?>

<section class="section" style="margin-top:40px;">
	<div class="container">
		<div class="contact-panel reveal">
			<div>
				<p class="eyebrow" style="color: var(--color-gold-light);"><?php esc_html_e( 'Kontakt', 'winnica-lumen' ); ?></p>
				<h2><?php esc_html_e( 'Napisz do nas', 'winnica-lumen' ); ?></h2>
				<p>
					<?php esc_html_e( 'Odpowiadamy zwykle w ciągu jednego dnia roboczego. Możesz też zadzwonić lub wpaść do nas osobiście.', 'winnica-lumen' ); ?>
				</p>

				<div class="contact-info-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6.5-5.44-6.5-10.5a6.5 6.5 0 1 1 13 0C18.5 15.56 12 21 12 21Z" /></svg>
					<span><?php esc_html_e( 'ul. Winna 12, 45-000 Opole', 'winnica-lumen' ); ?></span>
				</div>
				<div class="contact-info-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Z" /></svg>
					<span>kontakt@winnicalumen.example</span>
				</div>
				<div class="contact-info-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h.75a1.5 1.5 0 0 0 1.5-1.5v-2.373a1.5 1.5 0 0 0-1.06-1.435l-3.114-.935a1.5 1.5 0 0 0-1.514.39l-.943.944a10.5 10.5 0 0 1-6.364-6.364l.944-.943a1.5 1.5 0 0 0 .39-1.514l-.935-3.114A1.5 1.5 0 0 0 6.123 2.25H3.75a1.5 1.5 0 0 0-1.5 1.5v.75Z" /></svg>
					<span>+48 600 000 000</span>
				</div>
			</div>

			<div>
				<?php if ( $contact_result['submitted'] && $contact_result['success'] ) : ?>
					<p class="form-notice is-success">
						<?php esc_html_e( 'Dziękujemy! Wiadomość została wysłana — odezwiemy się wkrótce.', 'winnica-lumen' ); ?>
					</p>
				<?php elseif ( $contact_result['submitted'] && ! empty( $errors['form'] ) ) : ?>
					<p class="form-notice is-error"><?php echo esc_html( $errors['form'] ); ?></p>
				<?php elseif ( $contact_result['submitted'] && ! empty( $errors ) ) : ?>
					<p class="form-notice is-error">
						<?php esc_html_e( 'Popraw zaznaczone pola i spróbuj wysłać formularz ponownie.', 'winnica-lumen' ); ?>
					</p>
				<?php endif; ?>

				<form method="post" data-contact-form novalidate>
					<?php wp_nonce_field( 'winnica_lumen_contact_form', 'winnica_lumen_contact_nonce' ); ?>
					<input type="hidden" name="winnica_lumen_contact_submit" value="1" />

					<div class="form-honeypot" aria-hidden="true">
						<label for="website_url">Zostaw to pole puste</label>
						<input type="text" id="website_url" name="website_url" tabindex="-1" autocomplete="off" />
					</div>

					<div class="form-field <?php echo isset( $errors['name'] ) ? 'has-error' : ''; ?>">
						<label for="contact-name"><?php esc_html_e( 'Imię i nazwisko', 'winnica-lumen' ); ?></label>
						<input
							type="text"
							id="contact-name"
							name="name"
							value="<?php echo esc_attr( $values['name'] ); ?>"
							placeholder="<?php esc_attr_e( 'Jan Kowalski', 'winnica-lumen' ); ?>"
							data-error-message="<?php esc_attr_e( 'Podaj imię i nazwisko (min. 2 znaki).', 'winnica-lumen' ); ?>"
							required
						/>
						<?php if ( isset( $errors['name'] ) ) : ?>
							<p class="form-error"><?php echo esc_html( $errors['name'] ); ?></p>
						<?php endif; ?>
					</div>

					<div class="form-field <?php echo isset( $errors['email'] ) ? 'has-error' : ''; ?>">
						<label for="contact-email"><?php esc_html_e( 'E-mail', 'winnica-lumen' ); ?></label>
						<input
							type="email"
							id="contact-email"
							name="email"
							value="<?php echo esc_attr( $values['email'] ); ?>"
							placeholder="jan@przyklad.pl"
							data-error-message="<?php esc_attr_e( 'Podaj poprawny adres e-mail.', 'winnica-lumen' ); ?>"
							required
						/>
						<?php if ( isset( $errors['email'] ) ) : ?>
							<p class="form-error"><?php echo esc_html( $errors['email'] ); ?></p>
						<?php endif; ?>
					</div>

					<div class="form-field">
						<label for="contact-phone"><?php esc_html_e( 'Telefon (opcjonalnie)', 'winnica-lumen' ); ?></label>
						<input
							type="tel"
							id="contact-phone"
							name="phone"
							value="<?php echo esc_attr( $values['phone'] ); ?>"
							placeholder="+48 600 000 000"
						/>
					</div>

					<div class="form-field <?php echo isset( $errors['message'] ) ? 'has-error' : ''; ?>">
						<label for="contact-message"><?php esc_html_e( 'Wiadomość', 'winnica-lumen' ); ?></label>
						<textarea
							id="contact-message"
							name="message"
							rows="4"
							placeholder="<?php esc_attr_e( 'Opowiedz nam o okazji, liczbie gości i budżecie…', 'winnica-lumen' ); ?>"
							data-error-message="<?php esc_attr_e( 'Wiadomość jest zbyt krótka (min. 10 znaków).', 'winnica-lumen' ); ?>"
							required
						><?php echo esc_textarea( $values['message'] ); ?></textarea>
						<?php if ( isset( $errors['message'] ) ) : ?>
							<p class="form-error"><?php echo esc_html( $errors['message'] ); ?></p>
						<?php endif; ?>
					</div>

					<button type="submit" class="btn btn-gold"><?php esc_html_e( 'Wyślij wiadomość', 'winnica-lumen' ); ?></button>
				</form>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

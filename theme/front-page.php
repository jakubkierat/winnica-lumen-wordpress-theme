<?php
/**
 * Szablon strony głównej (Template Hierarchy: front-page.php).
 *
 * Jednostronicowy układ - formularz kontaktowy jest częścią tej samej
 * strony (sekcja #kontakt), a nie osobną podstroną.
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

<section class="hero">
	<div class="container hero-layout">
		<div class="hero-inner">
			<p class="hero-eyebrow hero-enter hero-enter-1"><?php esc_html_e( 'Winnica rodzinna od 2011 roku', 'winnica-lumen' ); ?></p>
			<h1 class="hero-enter hero-enter-2"><?php esc_html_e( 'Wina, które opowiadają', 'winnica-lumen' ); ?> <em><?php esc_html_e( 'historię miejsca', 'winnica-lumen' ); ?></em></h1>
			<p class="lead hero-enter hero-enter-3">
				<?php esc_html_e( 'Winnica Lumen to niewielka, kameralna winiarnia i sklep z winami - selekcjonujemy roczniki, które lubimy pić sami, i chętnie pomożemy Ci znaleźć butelkę na każdą okazję.', 'winnica-lumen' ); ?>
			</p>

			<div class="hero-actions hero-enter hero-enter-4">
				<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/wina/' ) ); ?>">
					<?php esc_html_e( 'Zobacz wina', 'winnica-lumen' ); ?>
				</a>
				<a class="btn btn-outline" href="#kontakt">
					<?php esc_html_e( 'Umów degustację', 'winnica-lumen' ); ?>
				</a>
			</div>

			<div class="hero-stats hero-enter hero-enter-5">
				<div>
					<strong data-counter data-target="120" data-suffix="+">0</strong>
					<span><?php esc_html_e( 'etykiet w ofercie', 'winnica-lumen' ); ?></span>
				</div>
				<div>
					<strong data-counter data-target="14">0</strong>
					<span><?php esc_html_e( 'lat doświadczenia', 'winnica-lumen' ); ?></span>
				</div>
				<div>
					<strong data-counter data-target="5">0</strong>
					<span><?php esc_html_e( 'regionów winiarskich', 'winnica-lumen' ); ?></span>
				</div>
			</div>
		</div>

		<div class="hero-collage hero-enter hero-enter-3" aria-hidden="true">
			<span class="hero-collage-badge"><?php esc_html_e( 'od 2011', 'winnica-lumen' ); ?></span>
			<div class="hero-collage-main">
				<img src="<?php echo esc_url( winnica_lumen_photo_url( 'hero', 1000 ) ); ?>" alt="<?php echo esc_attr( winnica_lumen_photo_alt( 'hero' ) ); ?>" loading="eager" fetchpriority="high" />
			</div>
			<div class="hero-collage-accent">
				<img src="<?php echo esc_url( winnica_lumen_photo_url( 'gallery-pour', 500 ) ); ?>" alt="<?php echo esc_attr( winnica_lumen_photo_alt( 'gallery-pour' ) ); ?>" loading="lazy" />
			</div>
		</div>
	</div>
</section>

<section id="oferta" class="section">
	<div class="container">
		<div class="section-head reveal" style="display:flex; align-items:flex-end; justify-content:space-between; gap:24px; flex-wrap:wrap;">
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Oferta', 'winnica-lumen' ); ?></p>
				<h2><?php esc_html_e( 'Wybrane wina z naszej piwnicy', 'winnica-lumen' ); ?></h2>
				<p><?php esc_html_e( 'Przewiń w bok, żeby zobaczyć więcej. Pełny katalog znajdziesz w zakładce Wina.', 'winnica-lumen' ); ?></p>
			</div>
		</div>

		<?php
		$featured_wina = new WP_Query(
			array(
				'post_type'      => 'wino',
				'posts_per_page' => 6,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'no_found_rows'  => true,
			)
		);
		?>

		<?php if ( $featured_wina->have_posts() ) : ?>
			<div class="wine-carousel reveal-group" data-carousel>
				<?php
				while ( $featured_wina->have_posts() ) :
					$featured_wina->the_post();
					get_template_part( 'template-parts/content', 'wino' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
			<div class="carousel-nav">
				<button type="button" data-carousel-prev aria-label="<?php esc_attr_e( 'Poprzednie wina', 'winnica-lumen' ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
				</button>
				<button type="button" data-carousel-next aria-label="<?php esc_attr_e( 'Następne wina', 'winnica-lumen' ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m9 18 6-6-6-6" /></svg>
				</button>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Katalog win pojawi się tutaj, gdy tylko dodasz pierwsze wpisy typu „Wino” w panelu WordPressa.', 'winnica-lumen' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section id="o-nas" class="section">
	<div class="container about-layout">
		<div class="reveal">
			<p class="eyebrow"><?php esc_html_e( 'O nas', 'winnica-lumen' ); ?></p>
			<h2><?php esc_html_e( 'Mała winnica, duża pasja', 'winnica-lumen' ); ?></h2>

			<p class="about-quote">
				<?php esc_html_e( '„Nie sprzedajemy wina, które sami byśmy odstawili na półkę. Jeśli czegoś nie pijemy w domu, nie trafia do naszej oferty.”', 'winnica-lumen' ); ?>
			</p>

			<p>
				<?php esc_html_e( 'Zaczynaliśmy od kilkunastu win na własne potrzeby. Dziś prowadzimy sklep stacjonarny i internetowy, organizujemy degustacje i pomagamy dobrać wino do wydarzeń - od kameralnej kolacji po firmowe spotkania.', 'winnica-lumen' ); ?>
			</p>
			<p>
				<?php esc_html_e( 'Współpracujemy bezpośrednio z kilkunastoma niewielkimi producentami z Europy i Polski - jeździmy na winnice, degustujemy przed zakupem i wybieramy roczniki, które nas przekonują, a nie tylko dobrze wyglądają w katalogu.', 'winnica-lumen' ); ?>
			</p>

			<div class="about-features-row">
				<div class="about-feature-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 2h6l-1 8.5a4 4 0 0 1-4 3.5 4 4 0 0 1-4-3.5L9 2Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14v8M8 22h8" /></svg>
					<strong><?php esc_html_e( 'Selekcja od źródła', 'winnica-lumen' ); ?></strong>
					<span><?php esc_html_e( 'bezpośrednio od producentów', 'winnica-lumen' ); ?></span>
				</div>
				<div class="about-feature-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6.5-5.44-6.5-10.5a6.5 6.5 0 1 1 13 0C18.5 15.56 12 21 12 21Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75a2.25 2.25 0 1 0 0-4.5 2.25 2.25 0 0 0 0 4.5Z" /></svg>
					<strong><?php esc_html_e( 'Degustacje na miejscu', 'winnica-lumen' ); ?></strong>
					<span><?php esc_html_e( 'w Opolu, dla grup i par', 'winnica-lumen' ); ?></span>
				</div>
				<div class="about-feature-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" transform="translate(0 -3)" /><path stroke-linecap="round" stroke-linejoin="round" d="M4 20h16" /></svg>
					<strong><?php esc_html_e( 'Indywidualne doradztwo', 'winnica-lumen' ); ?></strong>
					<span><?php esc_html_e( 'dopasowane do budżetu', 'winnica-lumen' ); ?></span>
				</div>
			</div>

			<a class="btn btn-gold" href="#kontakt" style="margin-top:32px;"><?php esc_html_e( 'Napisz do nas', 'winnica-lumen' ); ?></a>
		</div>

		<div class="reveal about-photo-frame">
			<div class="about-photo">
				<img
					src="<?php echo esc_url( winnica_lumen_photo_url( 'about', 900 ) ); ?>"
					alt="<?php echo esc_attr( winnica_lumen_photo_alt( 'about' ) ); ?>"
					loading="lazy"
				/>
			</div>
			<p class="about-photo-caption"><?php esc_html_e( 'Z naszej winnicy, tuż przed zbiorami', 'winnica-lumen' ); ?></p>
		</div>
	</div>
</section>

<section id="proces" class="section">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow"><?php esc_html_e( 'Jak to działa', 'winnica-lumen' ); ?></p>
			<h2><?php esc_html_e( 'Od pierwszej wiadomości do kieliszka w ręku', 'winnica-lumen' ); ?></h2>
		</div>

		<div class="process-strip reveal-group">
			<div class="process-card reveal">
				<span class="process-ghost-num">01</span>
				<h3><?php esc_html_e( 'Napisz, czego szukasz', 'winnica-lumen' ); ?></h3>
				<p><?php esc_html_e( 'Okazja, liczba osób, budżet, preferencje smakowe - im więcej szczegółów, tym trafniejsza propozycja.', 'winnica-lumen' ); ?></p>
			</div>

			<div class="process-card reveal">
				<span class="process-ghost-num">02</span>
				<h3><?php esc_html_e( 'Dostajesz propozycję', 'winnica-lumen' ); ?></h3>
				<p><?php esc_html_e( 'Zwykle w ciągu jednego dnia roboczego przygotowujemy 2-3 propozycje win.', 'winnica-lumen' ); ?></p>
			</div>

			<div class="process-card reveal">
				<span class="process-ghost-num">03</span>
				<h3><?php esc_html_e( 'Degustacja albo dostawa', 'winnica-lumen' ); ?></h3>
				<p><?php esc_html_e( 'Na miejscu w Opolu albo kurierem w całej Polsce - jak Ci wygodniej.', 'winnica-lumen' ); ?></p>
			</div>

			<div class="process-card reveal">
				<span class="process-ghost-num">04</span>
				<h3><?php esc_html_e( 'Zostajemy w kontakcie', 'winnica-lumen' ); ?></h3>
				<p><?php esc_html_e( 'Stali klienci pierwsi dowiadują się o nowych rocznikach i limitowanych partiach.', 'winnica-lumen' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section id="galeria" class="section">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow"><?php esc_html_e( 'Galeria', 'winnica-lumen' ); ?></p>
			<h2><?php esc_html_e( 'Kilka kadrów z winnicy', 'winnica-lumen' ); ?></h2>
		</div>

		<div class="gallery-grid reveal-group">
			<div class="gallery-frame reveal">
				<img
					src="<?php echo esc_url( winnica_lumen_photo_url( 'gallery-barrels', 900 ) ); ?>"
					alt="<?php echo esc_attr( winnica_lumen_photo_alt( 'gallery-barrels' ) ); ?>"
					loading="lazy"
				/>
				<span class="gallery-caption"><?php esc_html_e( 'Piwnica z beczkami dębowymi', 'winnica-lumen' ); ?></span>
			</div>
			<div class="gallery-frame reveal">
				<img
					src="<?php echo esc_url( winnica_lumen_photo_url( 'gallery-toast', 900 ) ); ?>"
					alt="<?php echo esc_attr( winnica_lumen_photo_alt( 'gallery-toast' ) ); ?>"
					loading="lazy"
				/>
				<span class="gallery-caption"><?php esc_html_e( 'Degustacja w gronie znajomych', 'winnica-lumen' ); ?></span>
			</div>
			<div class="gallery-frame reveal">
				<img
					src="<?php echo esc_url( winnica_lumen_photo_url( 'gallery-pour', 900 ) ); ?>"
					alt="<?php echo esc_attr( winnica_lumen_photo_alt( 'gallery-pour' ) ); ?>"
					loading="lazy"
				/>
				<span class="gallery-caption"><?php esc_html_e( 'Prosto z butelki do kieliszka', 'winnica-lumen' ); ?></span>
			</div>
		</div>
	</div>
</section>

<section id="opinie" class="section">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow"><?php esc_html_e( 'Opinie', 'winnica-lumen' ); ?></p>
			<h2><?php esc_html_e( 'Co mówią nasi goście', 'winnica-lumen' ); ?></h2>
		</div>

		<div class="testimonial-grid reveal-group">
			<div class="testimonial-card reveal">
				<p class="testimonial-quote"><?php esc_html_e( 'Degustacja urodzinowa u Winnicy Lumen była strzałem w dziesiątkę - dobrano wina idealnie pod nasze gusta, bez zadzierania nosa.', 'winnica-lumen' ); ?></p>
				<div class="testimonial-author">
					<span class="avatar-initials" style="background: var(--color-wine);">MK</span>
					<div>
						<div class="testimonial-author-name">Marta K.</div>
						<div class="testimonial-author-role"><?php esc_html_e( 'gość degustacji', 'winnica-lumen' ); ?></div>
					</div>
				</div>
			</div>
			<div class="testimonial-card reveal">
				<p class="testimonial-quote"><?php esc_html_e( 'Zamawiam tu wina na firmowe spotkania od dwóch lat. Zawsze szybka odpowiedź i trafne rekomendacje do budżetu.', 'winnica-lumen' ); ?></p>
				<div class="testimonial-author">
					<span class="avatar-initials" style="background: var(--color-gold); color: var(--color-wine-dark);">PS</span>
					<div>
						<div class="testimonial-author-name">Piotr S.</div>
						<div class="testimonial-author-role"><?php esc_html_e( 'stały klient', 'winnica-lumen' ); ?></div>
					</div>
				</div>
			</div>
			<div class="testimonial-card reveal">
				<p class="testimonial-quote"><?php esc_html_e( 'Świetna selekcja win musujących na wesele. Obsługa doradziła też, jak dobrać wina do menu - bardzo profesjonalnie.', 'winnica-lumen' ); ?></p>
				<div class="testimonial-author">
					<span class="avatar-initials" style="background: var(--color-wine-light);">AN</span>
					<div>
						<div class="testimonial-author-name">Anna N.</div>
						<div class="testimonial-author-role"><?php esc_html_e( 'panna młoda', 'winnica-lumen' ); ?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="faq" class="section">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow">FAQ</p>
			<h2><?php esc_html_e( 'Najczęstsze pytania', 'winnica-lumen' ); ?></h2>
		</div>

		<div class="faq-list reveal-group">
			<details class="faq-item reveal">
				<summary>
					<?php esc_html_e( 'Czy dostarczacie wino kurierem?', 'winnica-lumen' ); ?>
					<svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
				</summary>
				<div class="faq-answer">
					<p><?php esc_html_e( 'Tak, wysyłamy w całej Polsce kurierem, z odpowiednim zabezpieczeniem na transport. Przy większych zamówieniach możliwy jest też odbiór osobisty w Opolu.', 'winnica-lumen' ); ?></p>
				</div>
			</details>
			<details class="faq-item reveal">
				<summary>
					<?php esc_html_e( 'Czy można umówić degustację dla firmy?', 'winnica-lumen' ); ?>
					<svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
				</summary>
				<div class="faq-answer">
					<p><?php esc_html_e( 'Jak najbardziej - degustacje firmowe organizujemy zarówno u nas, jak i wyjazdowo, dla grup do około 20 osób.', 'winnica-lumen' ); ?></p>
				</div>
			</details>
			<details class="faq-item reveal">
				<summary>
					<?php esc_html_e( 'Jak szybko odpowiadacie na zapytania?', 'winnica-lumen' ); ?>
					<svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
				</summary>
				<div class="faq-answer">
					<p><?php esc_html_e( 'Zwykle w ciągu jednego dnia roboczego, a w pilnych sprawach staramy się odpisać jeszcze tego samego dnia.', 'winnica-lumen' ); ?></p>
				</div>
			</details>
			<details class="faq-item reveal">
				<summary>
					<?php esc_html_e( 'Czy macie sklep stacjonarny?', 'winnica-lumen' ); ?>
					<svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
				</summary>
				<div class="faq-answer">
					<p><?php esc_html_e( 'Tak, zapraszamy do Opola pod adres podany w sekcji kontakt - najlepiej po wcześniejszym umówieniu wizyty.', 'winnica-lumen' ); ?></p>
				</div>
			</details>
		</div>
	</div>
</section>

<section id="kontakt" class="section">
	<div class="container">
		<div class="contact-panel reveal">
			<div>
				<p class="eyebrow" style="color: var(--color-gold-light);"><?php esc_html_e( 'Kontakt', 'winnica-lumen' ); ?></p>
				<h2><?php esc_html_e( 'Zaplanujmy Twoją degustację', 'winnica-lumen' ); ?></h2>
				<p><?php esc_html_e( 'Napisz, co chcesz zorganizować - odezwiemy się z propozycją dopasowaną do okazji i budżetu.', 'winnica-lumen' ); ?></p>

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
						<?php esc_html_e( 'Dziękujemy! Wiadomość została wysłana - odezwiemy się wkrótce.', 'winnica-lumen' ); ?>
					</p>
				<?php elseif ( $contact_result['submitted'] && ! empty( $errors['form'] ) ) : ?>
					<p class="form-notice is-error"><?php echo esc_html( $errors['form'] ); ?></p>
				<?php elseif ( $contact_result['submitted'] && ! empty( $errors ) ) : ?>
					<p class="form-notice is-error">
						<?php esc_html_e( 'Popraw zaznaczone pola i spróbuj wysłać formularz ponownie.', 'winnica-lumen' ); ?>
					</p>
				<?php endif; ?>

				<form method="post" action="#kontakt" data-contact-form novalidate>
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

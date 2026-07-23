<?php
/**
 * Szablon strony głównej (Template Hierarchy: front-page.php).
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="hero">
	<span class="hero-blob hero-blob--one" aria-hidden="true"></span>
	<span class="hero-blob hero-blob--two" aria-hidden="true"></span>

	<div class="container hero-inner">
		<p class="hero-eyebrow"><?php esc_html_e( 'Winnica rodzinna od 2011 roku', 'winnica-lumen' ); ?></p>
		<h1><?php esc_html_e( 'Wina, które opowiadają', 'winnica-lumen' ); ?> <em><?php esc_html_e( 'historię miejsca', 'winnica-lumen' ); ?></em></h1>
		<p class="lead">
			<?php esc_html_e( 'Winnica Lumen to niewielka, kameralna winiarnia i sklep z winami — selekcjonujemy roczniki, które lubimy pić sami, i chętnie pomożemy Ci znaleźć butelkę na każdą okazję.', 'winnica-lumen' ); ?>
		</p>

		<div class="hero-actions">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/wina/' ) ); ?>">
				<?php esc_html_e( 'Zobacz wina', 'winnica-lumen' ); ?>
			</a>
			<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
				<?php esc_html_e( 'Umów degustację', 'winnica-lumen' ); ?>
			</a>
		</div>

		<div class="hero-stats">
			<div>
				<strong>120+</strong>
				<span><?php esc_html_e( 'etykiet w ofercie', 'winnica-lumen' ); ?></span>
			</div>
			<div>
				<strong>14</strong>
				<span><?php esc_html_e( 'lat doświadczenia', 'winnica-lumen' ); ?></span>
			</div>
			<div>
				<strong>5</strong>
				<span><?php esc_html_e( 'regionów winiarskich', 'winnica-lumen' ); ?></span>
			</div>
		</div>
	</div>
</section>

<section id="oferta" class="section">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow"><?php esc_html_e( 'Oferta', 'winnica-lumen' ); ?></p>
			<h2><?php esc_html_e( 'Wybrane wina z naszej piwnicy', 'winnica-lumen' ); ?></h2>
			<p><?php esc_html_e( 'Kilka etykiet, które ostatnio szczególnie polecamy. Pełny katalog znajdziesz w zakładce Wina.', 'winnica-lumen' ); ?></p>
		</div>

		<?php
		$featured_wina = new WP_Query(
			array(
				'post_type'      => 'wino',
				'posts_per_page' => 3,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'no_found_rows'  => true,
			)
		);
		?>

		<?php if ( $featured_wina->have_posts() ) : ?>
			<div class="wine-grid reveal-group">
				<?php
				while ( $featured_wina->have_posts() ) :
					$featured_wina->the_post();
					get_template_part( 'template-parts/content', 'wino' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'Katalog win pojawi się tutaj, gdy tylko dodasz pierwsze wpisy typu „Wino” w panelu WordPressa.', 'winnica-lumen' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section id="o-nas" class="section">
	<div class="container split">
		<div class="reveal">
			<p class="eyebrow"><?php esc_html_e( 'O nas', 'winnica-lumen' ); ?></p>
			<h2><?php esc_html_e( 'Mała winnica, duża pasja', 'winnica-lumen' ); ?></h2>
			<p>
				<?php esc_html_e( 'Zaczynaliśmy od kilkunastu win na własne potrzeby. Dziś prowadzimy sklep stacjonarny i internetowy, organizujemy degustacje i pomagamy dobrać wino do wydarzeń — od kameralnej kolacji po firmowe spotkania.', 'winnica-lumen' ); ?>
			</p>
			<a class="btn btn-gold" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
				<?php esc_html_e( 'Napisz do nas', 'winnica-lumen' ); ?>
			</a>
		</div>

		<div class="reveal">
			<ul class="feature-list">
				<li>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" /></svg>
					<div>
						<strong><?php esc_html_e( 'Selekcja od lokalnych i zagranicznych producentów', 'winnica-lumen' ); ?></strong>
					</div>
				</li>
				<li>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" /></svg>
					<div>
						<strong><?php esc_html_e( 'Degustacje prowadzone przez doświadczony zespół', 'winnica-lumen' ); ?></strong>
					</div>
				</li>
				<li>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m5 13 4 4L19 7" /></svg>
					<div>
						<strong><?php esc_html_e( 'Doradztwo w doborze wina do okazji i budżetu', 'winnica-lumen' ); ?></strong>
					</div>
				</li>
			</ul>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="contact-panel reveal">
			<div>
				<h2><?php esc_html_e( 'Zaplanujmy Twoją degustację', 'winnica-lumen' ); ?></h2>
				<p><?php esc_html_e( 'Napisz kilka słów o okazji, a zaproponujemy wina dopasowane do Twoich gości i budżetu.', 'winnica-lumen' ); ?></p>
				<a class="btn btn-gold" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
					<?php esc_html_e( 'Przejdź do formularza kontaktowego', 'winnica-lumen' ); ?>
				</a>
			</div>
			<div>
				<div class="contact-info-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-6.5-5.44-6.5-10.5a6.5 6.5 0 1 1 13 0C18.5 15.56 12 21 12 21Z" /></svg>
					<span><?php esc_html_e( 'ul. Winna 12, 45-000 Opole', 'winnica-lumen' ); ?></span>
				</div>
				<div class="contact-info-item">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Z" /></svg>
					<span>kontakt@winnicalumen.example</span>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>

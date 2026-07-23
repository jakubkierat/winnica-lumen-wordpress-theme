<?php
/**
 * Widok pojedynczego wina (Template Hierarchy: single-{post_type}.php).
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$wino_types = get_the_terms( get_the_ID(), 'typ-wina' );
	$wino_type  = ( $wino_types && ! is_wp_error( $wino_types ) ) ? $wino_types[0]->name : __( 'Wino', 'winnica-lumen' );
	$wino_slug  = ( $wino_types && ! is_wp_error( $wino_types ) ) ? $wino_types[0]->slug : 'czerwone';
	$rocznik    = get_post_meta( get_the_ID(), '_wino_rocznik', true );
	$region     = get_post_meta( get_the_ID(), '_wino_region', true );
	$alkohol    = get_post_meta( get_the_ID(), '_wino_alkohol', true );
	?>

	<section class="section" style="margin-top:40px;">
		<div class="container split">
			<div class="reveal">
				<div class="wine-card-visual" style="border-radius: var(--radius); aspect-ratio: 3/4;">
					<?php if ( has_post_thumbnail() ) : ?>
						<?php the_post_thumbnail( 'large' ); ?>
					<?php else : ?>
						<?php $bottle_key = winnica_lumen_bottle_photo_key( $wino_slug ); ?>
						<img
							src="<?php echo esc_url( winnica_lumen_photo_url( $bottle_key, 900 ) ); ?>"
							alt="<?php echo esc_attr( winnica_lumen_photo_alt( $bottle_key ) ); ?>"
							loading="lazy"
						/>
					<?php endif; ?>
				</div>
			</div>

			<div class="reveal">
				<span class="wine-type"><?php echo esc_html( $wino_type ); ?></span>
				<h1><?php the_title(); ?></h1>

				<ul class="feature-list" style="margin: 20px 0;">
					<?php if ( $region ) : ?>
						<li><strong><?php esc_html_e( 'Region:', 'winnica-lumen' ); ?></strong>&nbsp;<?php echo esc_html( $region ); ?></li>
					<?php endif; ?>
					<?php if ( $rocznik ) : ?>
						<li><strong><?php esc_html_e( 'Rocznik:', 'winnica-lumen' ); ?></strong>&nbsp;<?php echo esc_html( $rocznik ); ?></li>
					<?php endif; ?>
					<?php if ( $alkohol ) : ?>
						<li><strong><?php esc_html_e( 'Alkohol:', 'winnica-lumen' ); ?></strong>&nbsp;<?php echo esc_html( $alkohol ); ?>%</li>
					<?php endif; ?>
				</ul>

				<p class="wine-price" style="font-size:1.4rem;">
					<?php echo esc_html( winnica_lumen_get_wino_price( get_the_ID() ) ); ?>
				</p>

				<div style="margin: 20px 0;">
					<?php the_content(); ?>
				</div>

				<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/#kontakt' ) ); ?>">
					<?php esc_html_e( 'Zapytaj o dostępność', 'winnica-lumen' ); ?>
				</a>
			</div>
		</div>
	</section>

	<?php
endwhile;

get_footer();

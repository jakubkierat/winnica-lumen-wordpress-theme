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
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" style="width:96px;height:96px;" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M9 2h6l-1 8.5a4 4 0 0 1-4 3.5 4 4 0 0 1-4-3.5L9 2Z" />
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 14v8M8 22h8" />
						</svg>
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

				<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>">
					<?php esc_html_e( 'Zapytaj o dostępność', 'winnica-lumen' ); ?>
				</a>
			</div>
		</div>
	</section>

	<?php
endwhile;

get_footer();

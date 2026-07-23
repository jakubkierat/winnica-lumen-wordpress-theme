<?php
/**
 * Karta pojedynczego wina — używana w pętli na stronie głównej i w archiwum.
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$wino_types = get_the_terms( get_the_ID(), 'typ-wina' );
$wino_type  = ( $wino_types && ! is_wp_error( $wino_types ) ) ? $wino_types[0]->name : __( 'Wino', 'winnica-lumen' );
$rocznik    = get_post_meta( get_the_ID(), '_wino_rocznik', true );
$region     = get_post_meta( get_the_ID(), '_wino_region', true );
?>
<article <?php post_class( 'wine-card reveal' ); ?>>
	<a class="wine-card-visual" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium' ); ?>
		<?php else : ?>
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" d="M9 2h6l-1 8.5a4 4 0 0 1-4 3.5 4 4 0 0 1-4-3.5L9 2Z" />
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 14v8M8 22h8" />
			</svg>
		<?php endif; ?>
	</a>

	<div class="wine-card-body">
		<span class="wine-type"><?php echo esc_html( $wino_type ); ?></span>
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		<p class="wine-meta">
			<?php
			$meta_parts = array_filter( array( $region, $rocznik ) );
			echo esc_html( implode( ' · ', $meta_parts ) );
			?>
		</p>

		<p class="wine-price"><?php echo esc_html( winnica_lumen_get_wino_price( get_the_ID() ) ); ?></p>
	</div>
</article>

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
$wino_slug  = ( $wino_types && ! is_wp_error( $wino_types ) ) ? $wino_types[0]->slug : 'czerwone';
$rocznik    = get_post_meta( get_the_ID(), '_wino_rocznik', true );
$region     = get_post_meta( get_the_ID(), '_wino_region', true );
?>
<article <?php post_class( 'wine-card reveal' ); ?>>
	<a class="wine-card-visual" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'medium' ); ?>
		<?php else : ?>
			<?php $bottle_key = winnica_lumen_bottle_photo_key( $wino_slug ); ?>
			<img
				src="<?php echo esc_url( winnica_lumen_photo_url( $bottle_key, 600 ) ); ?>"
				alt="<?php echo esc_attr( winnica_lumen_photo_alt( $bottle_key ) ); ?>"
				loading="lazy"
			/>
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

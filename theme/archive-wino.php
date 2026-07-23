<?php
/**
 * Archiwum CPT "wino" (Template Hierarchy: archive-{post_type}.php).
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$active_term = get_queried_object();
$types       = get_terms(
	array(
		'taxonomy'   => 'typ-wina',
		'hide_empty' => false,
	)
);
?>

<section class="section" style="margin-top:40px;">
	<div class="container">
		<div class="section-head reveal">
			<p class="eyebrow"><?php esc_html_e( 'Katalog', 'winnica-lumen' ); ?></p>
			<h1><?php esc_html_e( 'Wina', 'winnica-lumen' ); ?></h1>
			<p><?php esc_html_e( 'Przeglądaj naszą aktualną ofertę. Wybierz typ wina, żeby zawęzić listę.', 'winnica-lumen' ); ?></p>
		</div>

		<?php if ( ! is_wp_error( $types ) && ! empty( $types ) ) : ?>
			<ul style="display:flex;flex-wrap:wrap;gap:10px;margin-bottom:36px;">
				<li>
					<a
						class="btn btn-outline btn-sm"
						href="<?php echo esc_url( get_post_type_archive_link( 'wino' ) ); ?>"
						<?php echo ! is_tax( 'typ-wina' ) ? 'style="background:var(--color-wine);color:#fff;border-color:var(--color-wine);"' : ''; ?>
					>
						<?php esc_html_e( 'Wszystkie', 'winnica-lumen' ); ?>
					</a>
				</li>
				<?php foreach ( $types as $type ) : ?>
					<li>
						<a
							class="btn btn-outline btn-sm"
							href="<?php echo esc_url( get_term_link( $type ) ); ?>"
							<?php echo ( is_tax( 'typ-wina', $type->slug ) ) ? 'style="background:var(--color-wine);color:#fff;border-color:var(--color-wine);"' : ''; ?>
						>
							<?php echo esc_html( $type->name ); ?>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<div class="wine-grid reveal-group">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content', 'wino' );
				endwhile;
				?>
			</div>

			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Brak win w tej kategorii.', 'winnica-lumen' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

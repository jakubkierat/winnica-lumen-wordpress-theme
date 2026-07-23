<?php
/**
 * Domyślny szablon zapasowy (Template Hierarchy: index.php).
 * WordPress wymaga obecności tego pliku w każdym motywie.
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="wine-grid reveal-group">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'wine-card reveal' ); ?>>
						<div class="wine-card-body">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="wine-meta"><?php the_excerpt(); ?></div>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Nie znaleziono żadnych treści.', 'winnica-lumen' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>

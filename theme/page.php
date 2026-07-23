<?php
/**
 * Domyślny szablon zwykłej podstrony (Template Hierarchy: page.php).
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="section" style="margin-top:40px;">
	<div class="container">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<div class="section-head reveal">
				<h1><?php the_title(); ?></h1>
			</div>
			<div class="reveal">
				<?php the_content(); ?>
			</div>
			<?php
		endwhile;
		?>
	</div>
</section>

<?php get_footer(); ?>

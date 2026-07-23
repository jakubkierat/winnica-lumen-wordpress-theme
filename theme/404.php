<?php
/**
 * Szablon strony błędu 404 (Template Hierarchy: 404.php).
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<section class="section text-center" style="margin-top:40px; max-width:560px;">
	<div class="container">
		<p class="eyebrow"><?php esc_html_e( 'Błąd 404', 'winnica-lumen' ); ?></p>
		<h1><?php esc_html_e( 'Ta strona nie istnieje', 'winnica-lumen' ); ?></h1>
		<p><?php esc_html_e( 'Być może link był nieaktualny, albo strona została przeniesiona. Wróć na stronę główną lub przejrzyj nasz katalog win.', 'winnica-lumen' ); ?></p>
		<div class="hero-actions" style="justify-content:center;">
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Strona główna', 'winnica-lumen' ); ?></a>
			<a class="btn btn-outline" href="<?php echo esc_url( home_url( '/wina/' ) ); ?>"><?php esc_html_e( 'Katalog win', 'winnica-lumen' ); ?></a>
		</div>
	</div>
</section>

<?php get_footer(); ?>

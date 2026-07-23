<?php
/**
 * Stopka motywu (Template Hierarchy: dołączany przez get_footer()).
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
</main>

<footer class="site-footer">
	<div class="container footer-inner">
		<p>
			&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
			<?php esc_html_e( 'Wszystkie prawa zastrzeżone.', 'winnica-lumen' ); ?>
		</p>

		<?php
		if ( has_nav_menu( 'footer' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'footer',
					'container'      => false,
					'menu_class'     => 'footer-menu',
					'fallback_cb'    => false,
					'depth'          => 1,
				)
			);
		}
		?>

		<p><?php esc_html_e( 'Motyw demo: Winnica Lumen', 'winnica-lumen' ); ?></p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

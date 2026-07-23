<?php
/**
 * Nagłówek motywu (Template Hierarchy: dołączany przez get_header()).
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main-content"><?php esc_html_e( 'Przejdź do treści', 'winnica-lumen' ); ?></a>

<header class="site-header">
	<div class="container header-inner">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" d="M8 2h8l-1 7a3 3 0 0 1-6 0L8 2Z" />
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 13v6M9 21h6" />
			</svg>
			<?php bloginfo( 'name' ); ?>
		</a>

		<nav class="main-nav" aria-label="<?php esc_attr_e( 'Menu główne', 'winnica-lumen' ); ?>">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'container'      => false,
						'menu_class'     => '',
						'fallback_cb'    => false,
					)
				);
			} else {
				?>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#oferta"><?php esc_html_e( 'Oferta', 'winnica-lumen' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#o-nas"><?php esc_html_e( 'O nas', 'winnica-lumen' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#galeria"><?php esc_html_e( 'Galeria', 'winnica-lumen' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#faq">FAQ</a></li>
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>#kontakt"><?php esc_html_e( 'Kontakt', 'winnica-lumen' ); ?></a></li>
				</ul>
				<?php
			}
			?>
		</nav>

		<div class="header-actions">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>#kontakt" class="btn btn-primary btn-sm">
				<?php esc_html_e( 'Umów degustację', 'winnica-lumen' ); ?>
			</a>
			<button class="nav-toggle" type="button" aria-label="<?php esc_attr_e( 'Otwórz menu', 'winnica-lumen' ); ?>" aria-expanded="false">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
				</svg>
			</button>
		</div>
	</div>
</header>

<main id="main-content">

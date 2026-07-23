<?php
/**
 * Winnica Lumen — funkcje motywu.
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Brak bezpośredniego dostępu do pliku.
}

define( 'WINNICA_LUMEN_VERSION', '1.0.0' );

/**
 * Podstawowa konfiguracja motywu: obsługiwane funkcje, menu, obrazki wyróżniające.
 */
function winnica_lumen_setup() {
	load_theme_textdomain( 'winnica-lumen', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
	);
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'automatic-feed-links' );

	register_nav_menus(
		array(
			'primary' => __( 'Menu główne', 'winnica-lumen' ),
			'footer'  => __( 'Menu w stopce', 'winnica-lumen' ),
		)
	);
}
add_action( 'after_setup_theme', 'winnica_lumen_setup' );

/**
 * Podłączenie stylów i skryptów front-endu.
 */
function winnica_lumen_scripts() {
	wp_enqueue_style( 'winnica-lumen-style', get_stylesheet_uri(), array(), WINNICA_LUMEN_VERSION );

	wp_enqueue_style(
		'winnica-lumen-main',
		get_theme_file_uri( '/assets/css/main.css' ),
		array( 'winnica-lumen-style' ),
		WINNICA_LUMEN_VERSION
	);

	wp_enqueue_script(
		'winnica-lumen-main',
		get_theme_file_uri( '/assets/js/main.js' ),
		array(),
		WINNICA_LUMEN_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'winnica_lumen_scripts' );

/**
 * Skrócony wstęp (excerpt) dopasowany do kart w siatce treści.
 */
function winnica_lumen_excerpt_length() {
	return 22;
}
add_filter( 'excerpt_length', 'winnica_lumen_excerpt_length' );

// Custom Post Type + taksonomia dla win.
require get_template_directory() . '/inc/custom-post-types.php';

// Obsługa formularza kontaktowego (walidacja po stronie PHP + wp_mail).
require get_template_directory() . '/inc/contact-form.php';

// Zdjęcia z Unsplash użyte jako przykładowa treść wizualna.
require get_template_directory() . '/inc/photos.php';

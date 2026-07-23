<?php
/**
 * Custom Post Type "Wino" + taksonomia "Typ wina" + metabox z danymi wina.
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rejestracja CPT "wino" (katalog produktów winiarni).
 */
function winnica_lumen_register_wino_cpt() {
	$labels = array(
		'name'          => __( 'Wina', 'winnica-lumen' ),
		'singular_name' => __( 'Wino', 'winnica-lumen' ),
		'add_new_item'  => __( 'Dodaj nowe wino', 'winnica-lumen' ),
		'edit_item'     => __( 'Edytuj wino', 'winnica-lumen' ),
		'all_items'     => __( 'Wszystkie wina', 'winnica-lumen' ),
		'search_items'  => __( 'Szukaj win', 'winnica-lumen' ),
		'not_found'     => __( 'Nie znaleziono win.', 'winnica-lumen' ),
		'menu_name'     => __( 'Wina', 'winnica-lumen' ),
	);

	register_post_type(
		'wino',
		array(
			'labels'        => $labels,
			'public'        => true,
			'has_archive'   => true,
			'rewrite'       => array( 'slug' => 'wina' ),
			'menu_icon'     => 'dashicons-carrot',
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'  => true,
			'template'      => array(),
		)
	);
}
add_action( 'init', 'winnica_lumen_register_wino_cpt' );

/**
 * Taksonomia "typ wina" (czerwone / białe / różowe / musujące).
 */
function winnica_lumen_register_wino_taxonomy() {
	register_taxonomy(
		'typ-wina',
		'wino',
		array(
			'labels'       => array(
				'name'          => __( 'Typy wina', 'winnica-lumen' ),
				'singular_name' => __( 'Typ wina', 'winnica-lumen' ),
			),
			'hierarchical' => true,
			'public'       => true,
			'show_in_rest' => true,
			'rewrite'      => array( 'slug' => 'typ-wina' ),
		)
	);
}
add_action( 'init', 'winnica_lumen_register_wino_taxonomy' );

/**
 * Metabox z dodatkowymi danymi wina: rocznik, region, zawartość alkoholu, cena.
 */
function winnica_lumen_add_wino_metabox() {
	add_meta_box(
		'winnica_lumen_wino_details',
		__( 'Szczegóły wina', 'winnica-lumen' ),
		'winnica_lumen_render_wino_metabox',
		'wino',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'winnica_lumen_add_wino_metabox' );

/**
 * Render pól metaboksa.
 *
 * @param WP_Post $post Bieżący post.
 */
function winnica_lumen_render_wino_metabox( $post ) {
	wp_nonce_field( 'winnica_lumen_save_wino_details', 'winnica_lumen_wino_nonce' );

	$rocznik  = get_post_meta( $post->ID, '_wino_rocznik', true );
	$region   = get_post_meta( $post->ID, '_wino_region', true );
	$alkohol  = get_post_meta( $post->ID, '_wino_alkohol', true );
	$cena     = get_post_meta( $post->ID, '_wino_cena', true );
	?>
	<p>
		<label for="wino_rocznik"><strong><?php esc_html_e( 'Rocznik', 'winnica-lumen' ); ?></strong></label><br />
		<input type="text" id="wino_rocznik" name="wino_rocznik" value="<?php echo esc_attr( $rocznik ); ?>" placeholder="np. 2021" />
	</p>
	<p>
		<label for="wino_region"><strong><?php esc_html_e( 'Region', 'winnica-lumen' ); ?></strong></label><br />
		<input type="text" id="wino_region" name="wino_region" value="<?php echo esc_attr( $region ); ?>" placeholder="np. Toskania, Włochy" style="width:320px" />
	</p>
	<p>
		<label for="wino_alkohol"><strong><?php esc_html_e( 'Zawartość alkoholu (%)', 'winnica-lumen' ); ?></strong></label><br />
		<input type="number" step="0.1" min="0" max="25" id="wino_alkohol" name="wino_alkohol" value="<?php echo esc_attr( $alkohol ); ?>" />
	</p>
	<p>
		<label for="wino_cena"><strong><?php esc_html_e( 'Cena (PLN)', 'winnica-lumen' ); ?></strong></label><br />
		<input type="number" step="0.01" min="0" id="wino_cena" name="wino_cena" value="<?php echo esc_attr( $cena ); ?>" />
	</p>
	<?php
}

/**
 * Zapis pól metaboksa z pełną walidacją i nonce.
 *
 * @param int $post_id ID zapisywanego posta.
 */
function winnica_lumen_save_wino_details( $post_id ) {
	if ( ! isset( $_POST['winnica_lumen_wino_nonce'] ) ||
		! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['winnica_lumen_wino_nonce'] ) ), 'winnica_lumen_save_wino_details' )
	) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$fields = array(
		'wino_rocznik' => '_wino_rocznik',
		'wino_region'  => '_wino_region',
		'wino_alkohol' => '_wino_alkohol',
		'wino_cena'    => '_wino_cena',
	);

	foreach ( $fields as $input_name => $meta_key ) {
		if ( isset( $_POST[ $input_name ] ) ) {
			update_post_meta( $post_id, $meta_key, sanitize_text_field( wp_unslash( $_POST[ $input_name ] ) ) );
		}
	}
}
add_action( 'save_post_wino', 'winnica_lumen_save_wino_details' );

/**
 * Pomocnicza funkcja: sformatowana cena wina do wyświetlenia w szablonach.
 *
 * @param int $post_id ID wina.
 * @return string
 */
function winnica_lumen_get_wino_price( $post_id ) {
	$cena = get_post_meta( $post_id, '_wino_cena', true );

	if ( '' === $cena ) {
		return __( 'Cena na zapytanie', 'winnica-lumen' );
	}

	return number_format_i18n( (float) $cena, 2 ) . ' zł';
}

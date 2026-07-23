<?php
/**
 * Zdjęcia z Unsplash użyte jako przykładowa treść wizualna.
 *
 * Motyw demo nie ma dostępu do prawdziwej biblioteki mediów (nie ma za
 * nim działającej instalacji WordPressa z uploadami), więc zamiast pustych
 * ramek używamy prawdziwych, darmowych zdjęć z Unsplash - dokładnie tak,
 * jak w innym moim projekcie referencyjnym (nova-estate). Wszystkie są na
 * licencji Unsplash License (unsplash.com/license): darmowe w użyciu
 * komercyjnym i niekomercyjnym, bez wymogu podawania autora - mimo to
 * podajemy fotografów poniżej z uprzejmości.
 *
 * W prawdziwym wdrożeniu WordPress te miejsca zajęłyby zdjęcia z biblioteki
 * mediów (post thumbnails), wgrywane normalnie przez wp_enqueue/uploads.
 *
 * @package WinnicaLumen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Zwraca mapę zdjęć: klucz => [ url bazowy Unsplash, opis alt, autor ].
 *
 * @return array<string,array{id:string,alt:string,credit:string}>
 */
function winnica_lumen_photos() {
	return array(
		'hero'        => array(
			'id'     => 'photo-1763786470689-5ff88c985885',
			'alt'    => 'Rzędy winorośli o złotej godzinie, zachód słońca nad winnicą',
			'credit' => 'Spencer DeMera / Unsplash',
		),
		'about'       => array(
			'id'     => 'photo-1722352451045-daaf5ee7a2e3',
			'alt'    => 'Grono winogron na winorośli z bliska',
			'credit' => 'Robert Bye / Unsplash',
		),
		'gallery-barrels' => array(
			'id'     => 'photo-1674483142916-70e706d50bbb',
			'alt'    => 'Beczki dębowe ułożone w piwnicy winnej',
			'credit' => 'Jon Sailer / Unsplash',
		),
		'gallery-toast'   => array(
			'id'     => 'photo-1647905555465-0f9004fbdaed',
			'alt'    => 'Grupa gości wznosząca toast kieliszkami wina',
			'credit' => 'Unsplash',
		),
		'gallery-pour'    => array(
			'id'     => 'photo-1681314762442-b918401a8619',
			'alt'    => 'Nalewanie czerwonego wina do kieliszka',
			'credit' => 'Noelia Vega / Unsplash',
		),
		'bottle-czerwone'  => array(
			'id'     => 'photo-1597043851759-3b383a6d1c14',
			'alt'    => 'Butelka czerwonego wina',
			'credit' => 'Unsplash',
		),
		'bottle-biale'     => array(
			'id'     => 'photo-1611571940159-425a28706d6f',
			'alt'    => 'Butelka białego wina obok kieliszka',
			'credit' => 'Unsplash',
		),
		'bottle-musujace'  => array(
			'id'     => 'photo-1514242879996-d7b3bb2dd531',
			'alt'    => 'Butelka wina musującego w kubełku z lodem',
			'credit' => 'Unsplash',
		),
	);
}

/**
 * Buduje pełny URL do zdjęcia z Unsplash CDN z zadaną szerokością.
 *
 * @param string $key   Klucz zdjęcia z winnica_lumen_photos().
 * @param int    $width Docelowa szerokość (Unsplash dociąga i kompresuje po swojej stronie).
 * @return string
 */
function winnica_lumen_photo_url( $key, $width = 1600 ) {
	$photos = winnica_lumen_photos();

	if ( ! isset( $photos[ $key ] ) ) {
		return '';
	}

	return sprintf(
		'https://images.unsplash.com/%s?q=80&w=%d&auto=format&fit=crop',
		$photos[ $key ]['id'],
		absint( $width )
	);
}

/**
 * Mapuje slug taksonomii "typ-wina" na klucz zdjęcia butelki.
 * Dla typów bez dedykowanego zdjęcia (np. różowe) używamy czerwonego jako
 * najbliższego wizualnie zamiennika.
 *
 * @param string $taxonomy_slug Slug terminu taksonomii typ-wina.
 * @return string
 */
function winnica_lumen_bottle_photo_key( $taxonomy_slug ) {
	$map = array(
		'czerwone' => 'bottle-czerwone',
		'biale'    => 'bottle-biale',
		'musujace' => 'bottle-musujace',
	);

	return isset( $map[ $taxonomy_slug ] ) ? $map[ $taxonomy_slug ] : 'bottle-czerwone';
}

/**
 * Zwraca opis alternatywny zdjęcia.
 *
 * @param string $key Klucz zdjęcia.
 * @return string
 */
function winnica_lumen_photo_alt( $key ) {
	$photos = winnica_lumen_photos();
	return isset( $photos[ $key ] ) ? $photos[ $key ]['alt'] : '';
}

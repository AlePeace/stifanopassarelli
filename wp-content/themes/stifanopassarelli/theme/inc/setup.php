<?php
/**
 * Setup all'attivazione del tema: pagine "Home" (homepage statica, template
 * page-home.php per slug) e "Impostazioni globali", collezioni Ordinarium e
 * Antologia. Crea solo ciò che manca e non tocca una homepage già impostata.
 *
 * @package stifanopassarelli
 */

/**
 * Crea pagine e termini mancanti, poi rigenera i permalink (CPT `opera`).
 */
function stifanopassarelli_after_switch_theme() {
	$pages = array(
		'home'                 => __( 'Home', 'stifanopassarelli' ),
		'impostazioni-globali' => __( 'Impostazioni globali', 'stifanopassarelli' ),
	);

	foreach ( $pages as $slug => $title ) {
		if ( ! get_page_by_path( $slug ) ) {
			wp_insert_post(
				array(
					'post_type'   => 'page',
					'post_status' => 'publish',
					'post_name'   => $slug,
					'post_title'  => $title,
				)
			);
		}
	}

	$home = get_page_by_path( 'home' );
	if ( $home && 'posts' === get_option( 'show_on_front' ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $home->ID );
	}

	stifanopassarelli_register_opere();
	foreach ( stifanopassarelli_collezioni() as $slug => $collezione ) {
		if ( ! term_exists( $slug, 'collezione' ) ) {
			wp_insert_term( $collezione['name'], 'collezione', array( 'slug' => $slug ) );
		}
	}

	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'stifanopassarelli_after_switch_theme' );

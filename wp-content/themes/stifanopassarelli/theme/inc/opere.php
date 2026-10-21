<?php
/**
 * CPT "Opere" + tassonomia "Collezioni" (Ordinarium, Antologia).
 *
 * In homepage le opere riempiono i pannelli di Ordinarium, il carosello
 * dell'Antologia e l'indice. Finché nel CMS non c'è nessuna opera di una
 * collezione si vedono le opere della bozza (stifanopassarelli_opere_bozza()).
 *
 * @package stifanopassarelli
 */

/**
 * Registra il CPT `opera` e la tassonomia `collezione`.
 */
function stifanopassarelli_register_opere() {
	register_post_type(
		'opera',
		array(
			'labels'        => array(
				'name'               => __( 'Opere', 'stifanopassarelli' ),
				'singular_name'      => __( 'Opera', 'stifanopassarelli' ),
				'add_new'            => __( 'Aggiungi opera', 'stifanopassarelli' ),
				'add_new_item'       => __( 'Aggiungi nuova opera', 'stifanopassarelli' ),
				'edit_item'          => __( 'Modifica opera', 'stifanopassarelli' ),
				'new_item'           => __( 'Nuova opera', 'stifanopassarelli' ),
				'view_item'          => __( 'Vedi opera', 'stifanopassarelli' ),
				'search_items'       => __( 'Cerca opere', 'stifanopassarelli' ),
				'not_found'          => __( 'Nessuna opera trovata', 'stifanopassarelli' ),
				'not_found_in_trash' => __( 'Nessuna opera nel cestino', 'stifanopassarelli' ),
				'all_items'          => __( 'Tutte le opere', 'stifanopassarelli' ),
				'featured_image'     => __( "Immagine dell'opera", 'stifanopassarelli' ),
				'set_featured_image' => __( "Imposta immagine dell'opera", 'stifanopassarelli' ),
			),
			'public'        => true,
			'has_archive'   => 'opere',
			'rewrite'       => array( 'slug' => 'opere' ),
			'menu_icon'     => 'dashicons-art',
			'menu_position' => 20,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
			'show_in_rest'  => false,
		)
	);

	register_taxonomy(
		'collezione',
		'opera',
		array(
			'labels'            => array(
				'name'          => __( 'Collezioni', 'stifanopassarelli' ),
				'singular_name' => __( 'Collezione', 'stifanopassarelli' ),
				'all_items'     => __( 'Tutte le collezioni', 'stifanopassarelli' ),
				'edit_item'     => __( 'Modifica collezione', 'stifanopassarelli' ),
				'add_new_item'  => __( 'Aggiungi collezione', 'stifanopassarelli' ),
			),
			'hierarchical'      => true,
			'show_admin_column' => true,
			'rewrite'           => array( 'slug' => 'collezione' ),
			'show_in_rest'      => false,
		)
	);
}
add_action( 'init', 'stifanopassarelli_register_opere' );

/**
 * Le collezioni della homepage: slug => nome e sezione di destinazione.
 *
 * @return array[]
 */
function stifanopassarelli_collezioni() {
	return array(
		'ordinarium' => array(
			'name'   => __( 'Ordinarium', 'stifanopassarelli' ),
			'anchor' => 'ordinarium',
		),
		'antologia'  => array(
			'name'   => __( 'Antologia', 'stifanopassarelli' ),
			'anchor' => 'antologia',
		),
	);
}

/**
 * Campi ACF dell'opera.
 */
function stifanopassarelli_register_opera_fields() {
	acf_add_local_field_group(
		array(
			'key'      => 'group_stifanopassarelli_opera',
			'title'    => __( 'Opera', 'stifanopassarelli' ),
			'location' => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'opera',
					),
				),
			),
			'position' => 'acf_after_title',
			'fields'   => array(
				stifanopassarelli_acf( 'opera_sottotitolo', __( 'Sottotitolo (Ordinarium)', 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Es. "La Moka — La liturgia del risveglio."', 'stifanopassarelli' ) ) ),
				stifanopassarelli_acf( 'opera_descrizione', __( 'Descrizione breve (Ordinarium)', 'stifanopassarelli' ), 'textarea' ),
				stifanopassarelli_acf( 'opera_nota', __( 'Nota (Antologia)', 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Riga sotto il titolo nel carosello, es. "Agosto 2025 — l\'Atto Zero".', 'stifanopassarelli' ) ) ),
				array(
					'key'           => 'field_opera_in_indice',
					'name'          => 'opera_in_indice',
					'label'         => __( "Mostra nell'indice delle opere", 'stifanopassarelli' ),
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 1,
				),
				stifanopassarelli_acf( 'opera_indice_etichetta', __( "Etichetta nell'indice", 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Vuoto = "Collezione · anno di pubblicazione", es. "Ordinarium · 2025".', 'stifanopassarelli' ) ) ),
			),
		)
	);
}
add_action( 'acf/init', 'stifanopassarelli_register_opera_fields' );

/**
 * Opere di una collezione, normalizzate per i template. Senza opere nel CMS
 * ritorna quelle della bozza.
 *
 * @param string $collezione Slug della collezione.
 *
 * @return array[] Ogni opera ha `title`, `image_id`, `image_src`, `alt`,
 *                 `sottotitolo`, `descrizione`, `nota`, `in_indice`,
 *                 `etichetta`, `anchor`.
 */
function stifanopassarelli_opere( $collezione ) {
	$query = new WP_Query(
		array(
			'post_type'      => 'opera',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'ASC',
			),
			'no_found_rows'  => true,
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_query_tax_query
				array(
					'taxonomy' => 'collezione',
					'field'    => 'slug',
					'terms'    => $collezione,
				),
			),
		)
	);

	if ( ! $query->posts ) {
		return stifanopassarelli_opere_bozza( $collezione );
	}

	$collezioni = stifanopassarelli_collezioni();
	$name       = isset( $collezioni[ $collezione ] ) ? $collezioni[ $collezione ]['name'] : '';
	$anchor     = isset( $collezioni[ $collezione ] ) ? $collezioni[ $collezione ]['anchor'] : $collezione;

	return array_map(
		function ( $post ) use ( $name, $anchor ) {
			$image_id  = (int) get_post_thumbnail_id( $post );
			$in_indice = function_exists( 'get_field' ) ? get_field( 'opera_in_indice', $post->ID ) : true;

			return array(
				'title'       => get_the_title( $post ),
				'image_id'    => $image_id,
				'image_src'   => '',
				'alt'         => $image_id ? (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : '',
				'sottotitolo' => stifanopassarelli_field( 'opera_sottotitolo', '', $post->ID ),
				'descrizione' => stifanopassarelli_field( 'opera_descrizione', '', $post->ID ),
				'nota'        => stifanopassarelli_field( 'opera_nota', '', $post->ID ),
				'in_indice'   => null === $in_indice || (bool) $in_indice,
				'etichetta'   => stifanopassarelli_field( 'opera_indice_etichetta', $name . ' · ' . get_the_date( 'Y', $post ), $post->ID ),
				'anchor'      => $anchor,
			);
		},
		$query->posts
	);
}

/**
 * Opere dell'indice: prima Ordinarium, poi Antologia, solo quelle con
 * "Mostra nell'indice".
 *
 * @return array[]
 */
function stifanopassarelli_opere_indice() {
	$opere = array();
	foreach ( array_keys( stifanopassarelli_collezioni() ) as $collezione ) {
		$opere = array_merge( $opere, stifanopassarelli_opere( $collezione ) );
	}

	return array_values(
		array_filter(
			$opere,
			function ( $opera ) {
				return $opera['in_indice'];
			}
		)
	);
}

/**
 * Stampa l'immagine di un'opera: da media library (con srcset) o il file
 * della bozza in assets/.
 *
 * @param array  $opera Opera normalizzata.
 * @param string $class Classi.
 * @param string $alt   Alt (default: quello dell'opera).
 */
function stifanopassarelli_opera_img( $opera, $class = '', $alt = null ) {
	$alt = null === $alt ? $opera['alt'] : $alt;

	if ( $opera['image_id'] ) {
		echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$opera['image_id'],
			'full',
			false,
			array(
				'class' => $class,
				'alt'   => $alt,
			)
		);
		return;
	}

	if ( $opera['image_src'] ) {
		echo '<img' . stifanopassarelli_html_attrs( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			array(
				'src'   => stifanopassarelli_asset_url( $opera['image_src'] ),
				'alt'   => $alt,
				'class' => $class,
			)
		) . ' />';
	}
}

/**
 * Opere della bozza (copy e foto di index.html), usate come fallback.
 *
 * @param string $collezione Slug della collezione.
 *
 * @return array[]
 */
function stifanopassarelli_opere_bozza( $collezione ) {
	$opera = function ( $title, $image_src, $alt, $extra ) use ( $collezione ) {
		return array_merge(
			array(
				'title'       => $title,
				'image_id'    => 0,
				'image_src'   => $image_src,
				'alt'         => $alt,
				'sottotitolo' => '',
				'descrizione' => '',
				'nota'        => '',
				'in_indice'   => false,
				'etichetta'   => '',
				'anchor'      => $collezione,
			),
			$extra
		);
	};

	if ( 'ordinarium' === $collezione ) {
		$etichetta = __( 'Ordinarium · 2025', 'stifanopassarelli' );

		return array(
			$opera(
				__( 'Aedicula', 'stifanopassarelli' ),
				'img/works/pos-03.jpg',
				__( 'Aedicula — La Moka', 'stifanopassarelli' ),
				array(
					'sottotitolo' => __( 'La Moka — La liturgia del risveglio.', 'stifanopassarelli' ),
					'descrizione' => __( 'Il gesto quotidiano si fa nicchia votiva: il risveglio come primo rito del giorno.', 'stifanopassarelli' ),
					'in_indice'   => true,
					'etichetta'   => $etichetta,
				)
			),
			$opera(
				__( 'Sacellum', 'stifanopassarelli' ),
				'img/works/pos-10.jpg',
				__( 'Sacellum — Il Limone', 'stifanopassarelli' ),
				array(
					'sottotitolo' => __( 'Il Limone — La natura che si fa reliquia.', 'stifanopassarelli' ),
					'descrizione' => __( "Il frutto effimero cristallizzato nell'oro del mosaico, custodito come una reliquia.", 'stifanopassarelli' ),
					'in_indice'   => true,
					'etichetta'   => $etichetta,
				)
			),
			$opera(
				__( 'Fenesta', 'stifanopassarelli' ),
				'img/works/pos-08.jpg',
				__( 'Fenesta — Il Panno', 'stifanopassarelli' ),
				array(
					'sottotitolo' => __( "Il Panno — L'effimero diventa monumento.", 'stifanopassarelli' ),
					'descrizione' => __( 'Il tessuto domestico, sospeso e pietrificato, diventa finestra e monumento.', 'stifanopassarelli' ),
					'in_indice'   => true,
					'etichetta'   => $etichetta,
				)
			),
			$opera(
				__( 'Centriello', 'stifanopassarelli' ),
				'img/works/pos-16.jpg',
				__( 'Centriello — Il Centrino', 'stifanopassarelli' ),
				array(
					'sottotitolo' => __( 'Il Centrino — La trama della memoria.', 'stifanopassarelli' ),
					'descrizione' => __( 'La trama tessuta dalle mani di casa, tradotta in tessere: la memoria che diventa pietra.', 'stifanopassarelli' ),
					'in_indice'   => true,
					'etichetta'   => $etichetta,
				)
			),
		);
	}

	if ( 'antologia' === $collezione ) {
		return array(
			$opera(
				__( 'Bacco', 'stifanopassarelli' ),
				'img/antologia/bacco.jpg',
				__( 'Bacco', 'stifanopassarelli' ),
				array(
					'nota'      => __( "Agosto 2025 — l'Atto Zero", 'stifanopassarelli' ),
					'in_indice' => true,
					'etichetta' => __( 'Antologia · 2025', 'stifanopassarelli' ),
				)
			),
			$opera(
				__( 'San Bartolomeo', 'stifanopassarelli' ),
				'img/antologia/san_bartolomeo.jpg',
				__( 'San Bartolomeo', 'stifanopassarelli' ),
				array(
					'nota'      => __( 'Pellare — la lotta con il marmo', 'stifanopassarelli' ),
					'in_indice' => true,
					'etichetta' => __( 'Antologia · Pellare', 'stifanopassarelli' ),
				)
			),
			$opera(
				__( 'Oltre il Minerale', 'stifanopassarelli' ),
				'img/antologia/oltre_minerale.jpg',
				__( 'Oltre il minerale', 'stifanopassarelli' ),
				array( 'nota' => __( 'Frammento monumentale', 'stifanopassarelli' ) )
			),
			$opera(
				__( 'Il Rito della Forma', 'stifanopassarelli' ),
				'img/antologia/il_rito_della_forma.jpg',
				__( 'Il rito della forma', 'stifanopassarelli' ),
				array( 'nota' => __( 'Studio · processo', 'stifanopassarelli' ) )
			),
		);
	}

	return array();
}

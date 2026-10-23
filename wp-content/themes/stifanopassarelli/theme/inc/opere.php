<?php
/**
 * CPT "Opere" + tassonomia "Collezioni" (Marmo, Mosaico, Antologia).
 *
 * In homepage le opere riempiono i pannelli del Marmo, le colonne del Mosaico,
 * il carosello dell'Antologia e l'indice. Finché nel CMS non c'è nessuna opera
 * dell'Antologia si vedono le opere della bozza (stifanopassarelli_opere_bozza());
 * Marmo e Mosaico non hanno fallback: senza opere la sezione non compare.
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
		'marmo'     => array(
			'name'   => __( 'Marmo', 'stifanopassarelli' ),
			'anchor' => 'marmo',
		),
		'mosaico'   => array(
			'name'   => __( 'Mosaico', 'stifanopassarelli' ),
			'anchor' => 'mosaico',
		),
		'antologia' => array(
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
				stifanopassarelli_acf( 'opera_sottotitolo', __( 'Sottotitolo (Marmo, Mosaico)', 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Es. "L\'immensità del vuoto scolpita nella pietra."', 'stifanopassarelli' ) ) ),
				stifanopassarelli_acf( 'opera_descrizione', __( 'Descrizione breve (Marmo)', 'stifanopassarelli' ), 'textarea' ),
				stifanopassarelli_acf( 'opera_tecnica', __( 'Tecnica e materiali (Marmo, Mosaico)', 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Es. "Marmo statuario di Carrara".', 'stifanopassarelli' ) ) ),
				stifanopassarelli_acf( 'opera_anno_luogo', __( 'Anno / collocazione (Marmo, Mosaico)', 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Es. "2020 — Collezione privata, Milano".', 'stifanopassarelli' ) ) ),
				stifanopassarelli_acf(
					'opera_inquadratura',
					__( 'Inquadratura della foto', 'stifanopassarelli' ),
					'select',
					'center',
					array(
						'instructions' => __( 'Quale parte della foto resta visibile quando viene ritagliata (es. foto orizzontale in un riquadro verticale).', 'stifanopassarelli' ),
						'choices'      => array(
							'center' => __( 'Centro', 'stifanopassarelli' ),
							'left'   => __( 'Sinistra', 'stifanopassarelli' ),
							'right'  => __( 'Destra', 'stifanopassarelli' ),
							'top'    => __( 'Alto', 'stifanopassarelli' ),
							'bottom' => __( 'Basso', 'stifanopassarelli' ),
						),
					)
				),
				stifanopassarelli_acf( 'opera_nota', __( 'Nota (Antologia)', 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Riga sotto il titolo nel carosello, es. "Agosto 2025 — l\'Atto Zero".', 'stifanopassarelli' ) ) ),
				array(
					'key'           => 'field_opera_in_indice',
					'name'          => 'opera_in_indice',
					'label'         => __( "Mostra nell'indice delle opere", 'stifanopassarelli' ),
					'type'          => 'true_false',
					'ui'            => 1,
					'default_value' => 1,
				),
				stifanopassarelli_acf( 'opera_indice_etichetta', __( "Etichetta nell'indice", 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Vuoto = "Collezione · anno di pubblicazione", es. "Marmo · 2023".', 'stifanopassarelli' ) ) ),
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
 *                 `sottotitolo`, `descrizione`, `tecnica`, `anno_luogo`,
 *                 `nota`, `in_indice`, `etichetta`, `anchor`.
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
				'title'        => get_the_title( $post ),
				'image_id'     => $image_id,
				'image_src'    => '',
				'alt'          => $image_id ? (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : '',
				'sottotitolo'  => stifanopassarelli_field( 'opera_sottotitolo', '', $post->ID ),
				'descrizione'  => stifanopassarelli_field( 'opera_descrizione', '', $post->ID ),
				'tecnica'      => stifanopassarelli_field( 'opera_tecnica', '', $post->ID ),
				'anno_luogo'   => stifanopassarelli_field( 'opera_anno_luogo', '', $post->ID ),
				'nota'         => stifanopassarelli_field( 'opera_nota', '', $post->ID ),
				'inquadratura' => stifanopassarelli_field( 'opera_inquadratura', 'center', $post->ID ),
				'in_indice'    => null === $in_indice || (bool) $in_indice,
				'etichetta'    => stifanopassarelli_field( 'opera_indice_etichetta', $name . ' · ' . get_the_date( 'Y', $post ), $post->ID ),
				'anchor'       => $anchor,
			);
		},
		$query->posts
	);
}

/**
 * Opere dell'indice: Marmo, Mosaico e Antologia, solo quelle con
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
	$alt   = null === $alt ? $opera['alt'] : $alt;
	$style = ! empty( $opera['inquadratura'] ) && 'center' !== $opera['inquadratura'] ? 'object-position: ' . $opera['inquadratura'] : '';

	if ( $opera['image_id'] ) {
		$attrs = array(
			'class' => $class,
			'alt'   => $alt,
		);
		if ( $style ) {
			$attrs['style'] = $style;
		}
		echo wp_get_attachment_image( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			$opera['image_id'],
			'full',
			false,
			$attrs
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
				'title'        => $title,
				'image_id'     => 0,
				'image_src'    => $image_src,
				'alt'          => $alt,
				'sottotitolo'  => '',
				'descrizione'  => '',
				'tecnica'      => '',
				'anno_luogo'   => '',
				'nota'         => '',
				'inquadratura' => '',
				'in_indice'    => false,
				'etichetta'    => '',
				'anchor'       => $collezione,
			),
			$extra
		);
	};

	if ( 'antologia' !== $collezione ) {
		return array();
	}

	// In coda Aedicula, dall'Ordinarium della bozza (Sacellum, Fenesta e
	// Centriello tolti su richiesta del cliente).
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
		$opera(
			__( 'Aedicula', 'stifanopassarelli' ),
			'img/works/pos-03.jpg',
			__( 'Aedicula — La Moka', 'stifanopassarelli' ),
			array(
				'nota'      => __( 'La Moka — La liturgia del risveglio.', 'stifanopassarelli' ),
				'in_indice' => true,
				'etichetta' => __( 'Ordinarium · 2025', 'stifanopassarelli' ),
			)
		),
	);
}

<?php
/**
 * Field group ACF registrati via codice (hook acf/init). I default sono la
 * copy della bozza, identica ai fallback nei template.
 *
 * @package stifanopassarelli
 */

/**
 * Campo ACF testuale (text, textarea), marcato "da tradurre" per WPML/ACFML.
 *
 * @param string $name    Nome del campo.
 * @param string $label   Etichetta in admin.
 * @param string $type    Tipo ACF.
 * @param string $default Valore di default.
 * @param array  $extra   Impostazioni aggiuntive.
 *
 * @return array
 */
function stifanopassarelli_acf( $name, $label, $type = 'text', $default = '', $extra = array() ) {
	$field = array(
		'key'           => 'field_' . $name,
		'name'          => $name,
		'label'         => $label,
		'type'          => $type,
		'default_value' => $default,
	);

	if ( 'textarea' === $type ) {
		$field['rows']      = 3;
		$field['new_lines'] = '';
	}

	if ( defined( 'WPML_TRANSLATE_CUSTOM_FIELD' ) ) {
		$field['wpml_cf_preferences'] = WPML_TRANSLATE_CUSTOM_FIELD;
	}

	return array_merge( $field, $extra );
}

/**
 * Campo ACF immagine o video (file mp4), return format url, marcato "da copiare" per WPML/ACFML.
 *
 * @param string $name  Nome del campo.
 * @param string $label Etichetta in admin.
 * @param string $type  'image' o 'file'.
 *
 * @return array
 */
function stifanopassarelli_acf_media( $name, $label, $type = 'image' ) {
	$field = array(
		'key'           => 'field_' . $name,
		'name'          => $name,
		'label'         => $label,
		'type'          => $type,
		'return_format' => 'url',
	);

	if ( 'image' === $type ) {
		$field['preview_size'] = 'medium';
	} else {
		$field['mime_types'] = 'mp4';
	}

	if ( defined( 'WPML_COPY_CUSTOM_FIELD' ) ) {
		$field['wpml_cf_preferences'] = WPML_COPY_CUSTOM_FIELD;
	}

	return $field;
}

/**
 * Tab ACF.
 *
 * @param string $slug  Slug univoco del tab.
 * @param string $label Etichetta.
 *
 * @return array
 */
function stifanopassarelli_acf_tab( $slug, $label ) {
	return array(
		'key'       => 'field_tab_' . $slug,
		'label'     => $label,
		'type'      => 'tab',
		'placement' => 'top',
	);
}

/**
 * Location "homepage": page-home.php è scelto per slug, quindi ACF non lo vede
 * come page template; front_page segue anche le traduzioni WPML.
 *
 * @return array
 */
function stifanopassarelli_acf_location_front_page() {
	return array(
		array(
			array(
				'param'    => 'page_type',
				'operator' => '==',
				'value'    => 'front_page',
			),
		),
	);
}

/**
 * Location della pagina "impostazioni-globali" e delle sue traduzioni WPML.
 *
 * @return array Vuoto se la pagina non esiste.
 */
function stifanopassarelli_acf_location_settings_page() {
	$page = get_page_by_path( 'impostazioni-globali' );
	if ( ! $page ) {
		return array();
	}

	$ids = array( $page->ID );
	foreach ( array_keys( (array) apply_filters( 'wpml_active_languages', null ) ) as $language ) {
		$ids[] = (int) apply_filters( 'wpml_object_id', $page->ID, 'page', false, $language );
	}

	$location = array();
	foreach ( array_unique( array_filter( $ids ) ) as $id ) {
		$location[] = array(
			array(
				'param'    => 'page',
				'operator' => '==',
				'value'    => (string) $id,
			),
		);
	}

	return $location;
}

/**
 * Le 4 colonne (binari) del Work in progress: posizione, velocità, verso e le
 * 4 foto di default di ciascuna (come nella bozza). Usate sia dai campi ACF
 * sia dal template.
 *
 * @return array[]
 */
function stifanopassarelli_wip_columns() {
	return array(
		array(
			'class' => 'left-[2%]',
			'speed' => '1.35',
			'dir'   => '-1',
			'foto'  => array( 'img/manifesto/apr-05.jpg', 'img/works/pos-03.jpg', 'img/rito/rito-11.jpg', 'img/artists/giu-04.jpg' ),
		),
		array(
			'class' => 'left-[23%]',
			'speed' => '0.75',
			'dir'   => '1',
			'foto'  => array( 'img/artists/giu-05.jpg', 'img/manifesto/apr-03.jpg', 'img/works/pos-10.jpg', 'img/rito/rito-07.jpg' ),
		),
		array(
			'class' => 'right-[23%]',
			'speed' => '1.05',
			'dir'   => '-1',
			'foto'  => array( 'img/works/pos-16.jpg', 'img/rito/rito-05.jpg', 'img/manifesto/apr-13.jpg', 'img/artists/giu-12.jpg' ),
		),
		array(
			'class' => 'right-[2%]',
			'speed' => '0.6',
			'dir'   => '1',
			'foto'  => array( 'img/works/pos-08.jpg', 'img/artists/giu-08.jpg', 'img/rito/rito-13.jpg', 'img/manifesto/apr-16.jpg' ),
		),
	);
}

/**
 * Field group della homepage: un tab per sezione. Le opere di Marmo, Mosaico,
 * Antologia e dell'indice arrivano dal CPT "Opere" (inc/opere.php).
 */
function stifanopassarelli_register_home_fields() {
	$wip_fields = array();
	foreach ( stifanopassarelli_wip_columns() as $col => $column ) {
		foreach ( array_keys( $column['foto'] ) as $foto ) {
			$wip_fields[] = stifanopassarelli_acf_media(
				sprintf( 'home_wip_col_%d_foto_%d', $col + 1, $foto + 1 ),
				/* translators: 1: colonna, 2: foto */
				sprintf( __( 'Colonna %1$d · Foto %2$d', 'stifanopassarelli' ), $col + 1, $foto + 1 )
			);
		}
	}

	acf_add_local_field_group(
		array(
			'key'            => 'group_stifanopassarelli_home',
			'title'          => __( 'Homepage', 'stifanopassarelli' ),
			'location'       => stifanopassarelli_acf_location_front_page(),
			'hide_on_screen' => array( 'the_content' ),
			'fields'         => array_merge(
				array(
					stifanopassarelli_acf_tab( 'home_hero', __( 'Hero', 'stifanopassarelli' ) ),
					stifanopassarelli_acf_media( 'home_hero_video', __( 'Video (mp4)', 'stifanopassarelli' ), 'file' ),
					stifanopassarelli_acf_media( 'home_hero_poster', __( 'Poster del video', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_hero_cue', __( 'Invito allo scroll', 'stifanopassarelli' ), 'text', __( 'Entra nel segno', 'stifanopassarelli' ) ),

					stifanopassarelli_acf_tab( 'home_manifesto', __( 'Il Manifesto', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_manifesto_label', __( 'Label', 'stifanopassarelli' ), 'text', __( 'Il Patto del Segno', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_manifesto_eyebrow', __( 'Eyebrow', 'stifanopassarelli' ), 'text', __( '01 — Il Manifesto', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_manifesto_testo', __( 'Testo (si svela parola per parola)', 'stifanopassarelli' ), 'textarea', __( 'Due anime, due linguaggi che vibrano alla stessa frequenza prima ancora di toccare la materia.', 'stifanopassarelli' ) ),
					stifanopassarelli_acf_media( 'home_manifesto_immagine', __( 'Immagine (4:5)', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_manifesto_didascalia', __( 'Didascalia (ammette <em>)', 'stifanopassarelli' ), 'textarea', __( "La <em>Sintonizzazione</em> è l'Atto Zero. La <em>Risonanza</em> è l'opera che diventa specchio emozionale per chi la osserva.", 'stifanopassarelli' ) ),

					stifanopassarelli_acf_tab( 'home_wip', __( 'Work in progress', 'stifanopassarelli' ) ),
					array(
						'key'     => 'field_home_wip_note',
						'label'   => __( 'Foto dei binari', 'stifanopassarelli' ),
						'name'    => '',
						'type'    => 'message',
						'message' => __( '4 colonne da 4 foto (formato 3:4, in bianco e nero sul sito). Le colonne 2 e 3 non compaiono su mobile. A fine scroll alcune foto si dispongono a collage attorno al monogramma. Un campo vuoto usa la foto della bozza.', 'stifanopassarelli' ),
					),
				),
				$wip_fields,
				array(
					stifanopassarelli_acf_tab( 'home_rito', __( 'Il Rito', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_rito_label', __( 'Label', 'stifanopassarelli' ), 'text', __( 'La Doppia Pelle', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_rito_eyebrow', __( 'Eyebrow', 'stifanopassarelli' ), 'text', __( '02 — Il Rito · Sottrazione vs Dedizione', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_rito_1_num', __( 'Sinistra · Numero', 'stifanopassarelli' ), 'text', __( '/ 01 · Emanuele', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_rito_1_titolo', __( 'Sinistra · Titolo', 'stifanopassarelli' ), 'text', __( 'La Sottrazione', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_rito_1_testo', __( 'Sinistra · Testo', 'stifanopassarelli' ), 'textarea', __( 'Il gesto crudo che scava il marmo e il bronzo alla ricerca della carne e della libertà anatomica.', 'stifanopassarelli' ) ),
					stifanopassarelli_acf_media( 'home_rito_1_immagine', __( 'Sinistra · Immagine', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_rito_2_num', __( 'Destra · Numero', 'stifanopassarelli' ), 'text', __( '/ 02 · Carla', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_rito_2_titolo', __( 'Destra · Titolo', 'stifanopassarelli' ), 'text', __( 'La Dedizione', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_rito_2_testo', __( 'Destra · Testo', 'stifanopassarelli' ), 'textarea', __( "Il ritmo lento che ricompone la luce e l'infinito, tessera dopo tessera, avvolgendo la forma.", 'stifanopassarelli' ) ),
					stifanopassarelli_acf_media( 'home_rito_2_immagine', __( 'Destra · Immagine (senza overlay: meglio una foto non troppo chiara in basso)', 'stifanopassarelli' ) ),

					stifanopassarelli_acf_tab( 'home_negativo', __( 'Negativo', 'stifanopassarelli' ) ),
					stifanopassarelli_acf_media( 'home_negativo_immagine', __( 'Immagine', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_negativo_testo', __( 'Testo', 'stifanopassarelli' ), 'text', __( 'La materia rivela il suo doppio.', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_negativo_hint_desktop', __( 'Indicazione desktop', 'stifanopassarelli' ), 'text', __( 'muovi — svela il negativo', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_negativo_hint_touch', __( 'Indicazione touch', 'stifanopassarelli' ), 'text', __( 'tocca — svela il negativo', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_negativo_lente', __( 'Etichetta nella lente (touch)', 'stifanopassarelli' ), 'text', __( 'Click', 'stifanopassarelli' ) ),

					stifanopassarelli_acf_tab( 'home_marmo', __( 'Il Marmo', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_marmo_label', __( 'Label', 'stifanopassarelli' ), 'text', __( 'La materia bianca: il marmo', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_marmo_titolo', __( 'Titolo', 'stifanopassarelli' ), 'textarea', __( "Il marmo,\nsottrazione e luce", 'stifanopassarelli' ), array( 'new_lines' => 'br' ) ),
					stifanopassarelli_acf( 'home_marmo_eyebrow', __( 'Eyebrow', 'stifanopassarelli' ), 'text', __( '03 — Il Marmo', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_marmo_testo', __( 'Testo', 'stifanopassarelli' ), 'textarea', __( "La pietra di Carrara come foglio bianco su cui scavare il silenzio. La Sottrazione incontra la forma pura. La carne, l'anima e il pensiero emergono dal blocco attraverso il gesto crudo dello scalpello.", 'stifanopassarelli' ) ),
					array(
						'key'     => 'field_home_marmo_note',
						'label'   => __( 'Opere', 'stifanopassarelli' ),
						'name'    => '',
						'type'    => 'message',
						'message' => __( 'I pannelli sono le Opere della collezione "Marmo" (menu Opere), in ordine di "Ordine" negli attributi. Senza opere la sezione non compare.', 'stifanopassarelli' ),
					),

					stifanopassarelli_acf_tab( 'home_mosaico', __( 'Il Mosaico', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_mosaico_label', __( 'Label', 'stifanopassarelli' ), 'text', __( 'La dedizione: il mosaico', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_mosaico_eyebrow', __( 'Eyebrow', 'stifanopassarelli' ), 'text', __( '04 — Il Mosaico', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_mosaico_titolo', __( 'Titolo verticale (ammette <em>, in oro)', 'stifanopassarelli' ), 'textarea', __( "Carla Passarelli,\nil rito della <em>tessera</em>", 'stifanopassarelli' ), array( 'new_lines' => 'br' ) ),
					stifanopassarelli_acf( 'home_mosaico_testo', __( 'Testo', 'stifanopassarelli' ), 'textarea', __( 'Dalla rigida disciplina bizantina appresa a Ravenna alla libertà espressiva nel laboratorio di Acquavella. Un rito lento di ricomposizione del mondo.', 'stifanopassarelli' ) ),
					array(
						'key'     => 'field_home_mosaico_note',
						'label'   => __( 'Opere', 'stifanopassarelli' ),
						'name'    => '',
						'type'    => 'message',
						'message' => __( 'Le colonne sono le Opere della collezione "Mosaico" (menu Opere), in ordine di "Ordine" negli attributi: le foto sono ritagliate in 4:5 (meglio verticali). Senza opere la sezione non compare.', 'stifanopassarelli' ),
					),

					stifanopassarelli_acf_tab( 'home_antologia', __( 'Antologia', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_antologia_label', __( 'Label', 'stifanopassarelli' ), 'text', __( 'Memoria e Frammenti', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_antologia_eyebrow', __( 'Eyebrow', 'stifanopassarelli' ), 'text', __( '05 — Antologia · le altre opere', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_antologia_indice_label', __( "Label dell'indice", 'stifanopassarelli' ), 'text', __( 'Indice delle opere', 'stifanopassarelli' ) ),
					array(
						'key'     => 'field_home_antologia_note',
						'label'   => __( 'Opere', 'stifanopassarelli' ),
						'name'    => '',
						'type'    => 'message',
						'message' => __( 'Il carosello mostra le Opere della collezione "Antologia"; l\'indice tutte le Opere con "Mostra nell\'indice" attivo (Marmo, Mosaico, poi Antologia).', 'stifanopassarelli' ),
					),

					stifanopassarelli_acf_tab( 'home_artisti', __( 'Gli Artisti', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_artisti_label', __( 'Label', 'stifanopassarelli' ), 'text', __( 'Emanuele & Carla', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_artisti_eyebrow', __( 'Eyebrow', 'stifanopassarelli' ), 'text', __( '06 — Gli Artisti', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_artisti_1_ruolo', __( 'Emanuele · Ruolo', 'stifanopassarelli' ), 'text', __( 'Sottrazione — marmo & bronzo', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_artisti_1_nome', __( 'Emanuele · Nome', 'stifanopassarelli' ), 'text', __( 'Emanuele Stifano', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_artisti_1_bio', __( 'Emanuele · Bio', 'stifanopassarelli' ), 'textarea', __( 'Radici a Pellare, maturazione tra Carrara, Pietrasanta e la carne del marmo. La scultura come atto di liberazione della forma.', 'stifanopassarelli' ) ),
					stifanopassarelli_acf_media( 'home_artisti_1_immagine', __( 'Emanuele · Ritratto', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_artisti_2_ruolo', __( 'Carla · Ruolo', 'stifanopassarelli' ), 'text', __( 'Dedizione — mosaico & luce', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_artisti_2_nome', __( 'Carla · Nome', 'stifanopassarelli' ), 'text', __( 'Carla Passarelli', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_artisti_2_bio', __( 'Carla · Bio', 'stifanopassarelli' ), 'textarea', __( "Da Acquavella a Ravenna, la disciplina della tessera. Ricompone la luce con la pazienza dell'infinito, tassello dopo tassello.", 'stifanopassarelli' ) ),
					stifanopassarelli_acf_media( 'home_artisti_2_immagine', __( 'Carla · Ritratto', 'stifanopassarelli' ) ),

					stifanopassarelli_acf_tab( 'home_discover', __( 'Discover', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_discover_label', __( 'Label', 'stifanopassarelli' ), 'text', __( 'Discover', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_discover_eyebrow', __( 'Eyebrow', 'stifanopassarelli' ), 'text', __( '07 — Le opere nel mondo', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_discover_luoghi', __( 'Luoghi (uno per riga)', 'stifanopassarelli' ), 'textarea', __( "Positano\nPellare (SA)\nCarrara\nRavenna\nPietrasanta\nPadova\nMoio della Civitella (SA)\nCardile (SA)\nCaselle in Pittari (SA)\nMilano\nSan Mauro Pascoli (FC)", 'stifanopassarelli' ), array( 'rows' => 11 ) ),
				),
				stifanopassarelli_accademia_fields(),
				array(
					stifanopassarelli_acf_tab( 'home_contatti', __( 'Contatti', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_contatti_label', __( 'Label', 'stifanopassarelli' ), 'text', __( 'Risonanze', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_contatti_eyebrow', __( 'Eyebrow', 'stifanopassarelli' ), 'text', __( '09 — Contatti & Gallerie', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_contatti_form', __( 'Shortcode del form (es. Contact Form 7)', 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Vuoto = il form della bozza, che non invia nulla.', 'stifanopassarelli' ) ) ),
					stifanopassarelli_acf( 'home_contatti_laboratorio_label', __( 'Laboratorio · Label', 'stifanopassarelli' ), 'text', __( 'Il laboratorio', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_contatti_laboratorio', __( 'Laboratorio · Luogo', 'stifanopassarelli' ), 'text', __( 'Pellare (SA)', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_contatti_galleria_label', __( 'Galleria · Label', 'stifanopassarelli' ), 'text', __( 'Galleria espositiva', 'stifanopassarelli' ) ),
					stifanopassarelli_acf( 'home_contatti_galleria', __( 'Galleria · Luogo', 'stifanopassarelli' ), 'text', __( 'Positano', 'stifanopassarelli' ) ),
				)
			),
		)
	);
}
add_action( 'acf/init', 'stifanopassarelli_register_home_fields' );

/**
 * Campi del tab Accademia, con i default di stifanopassarelli_accademia().
 *
 * @return array[]
 */
function stifanopassarelli_accademia_fields() {
	$acc = stifanopassarelli_accademia();

	$fields = array(
		stifanopassarelli_acf_tab( 'home_accademia', __( 'Accademia', 'stifanopassarelli' ) ),
		stifanopassarelli_acf( 'home_accademia_label', __( 'Label', 'stifanopassarelli' ), 'text', $acc['label'] ),
		stifanopassarelli_acf( 'home_accademia_eyebrow', __( 'Eyebrow', 'stifanopassarelli' ), 'text', $acc['eyebrow'] ),
		stifanopassarelli_acf( 'home_accademia_titolo', __( 'Titolo', 'stifanopassarelli' ), 'textarea', $acc['titolo'], array( 'new_lines' => 'br' ) ),
		stifanopassarelli_acf( 'home_accademia_sottotitolo', __( 'Sottotitolo', 'stifanopassarelli' ), 'textarea', $acc['sottotitolo'] ),
		stifanopassarelli_acf( 'home_accademia_intro', __( 'Introduzione (un paragrafo per riga)', 'stifanopassarelli' ), 'textarea', $acc['intro'], array( 'rows' => 6 ) ),
		stifanopassarelli_acf( 'home_accademia_corsi_label', __( 'Corsi · Label', 'stifanopassarelli' ), 'text', $acc['corsi_label'] ),
	);

	foreach ( $acc['corsi'] as $n => $corso ) {
		/* translators: %d: numero del corso */
		$prefix   = sprintf( __( 'Corso %d', 'stifanopassarelli' ), $n ) . ' · ';
		$fields[] = stifanopassarelli_acf( "home_accademia_corsi_{$n}_titolo", $prefix . __( 'Titolo', 'stifanopassarelli' ), 'text', $corso['titolo'] );
		$fields[] = stifanopassarelli_acf( "home_accademia_corsi_{$n}_docente", $prefix . __( 'Docente', 'stifanopassarelli' ), 'text', $corso['docente'] );
		$fields[] = stifanopassarelli_acf( "home_accademia_corsi_{$n}_impara", $prefix . __( 'Cosa imparerai', 'stifanopassarelli' ), 'textarea', $corso['impara'] );
		$fields[] = stifanopassarelli_acf( "home_accademia_corsi_{$n}_rivolto", $prefix . __( 'A chi è rivolto', 'stifanopassarelli' ), 'textarea', $corso['rivolto'] );
		$fields[] = stifanopassarelli_acf_media( "home_accademia_corsi_{$n}_immagine", $prefix . __( 'Immagine (4:3)', 'stifanopassarelli' ) );
	}

	$fields[] = stifanopassarelli_acf( 'home_accademia_destinatari_label', __( 'Destinatari · Label', 'stifanopassarelli' ), 'text', $acc['destinatari_label'] );
	$fields[] = stifanopassarelli_acf( 'home_accademia_destinatari_testo', __( 'Destinatari · Testo', 'stifanopassarelli' ), 'textarea', $acc['destinatari_testo'] );
	foreach ( $acc['destinatari'] as $n => $voce ) {
		/* translators: %d: numero della voce */
		$prefix   = sprintf( __( 'Destinatari %d', 'stifanopassarelli' ), $n ) . ' · ';
		$fields[] = stifanopassarelli_acf( "home_accademia_destinatari_{$n}_titolo", $prefix . __( 'Titolo', 'stifanopassarelli' ), 'text', $voce['titolo'] );
		$fields[] = stifanopassarelli_acf( "home_accademia_destinatari_{$n}_testo", $prefix . __( 'Testo', 'stifanopassarelli' ), 'text', $voce['testo'] );
	}

	$fields[] = stifanopassarelli_acf( 'home_accademia_sede_label', __( 'Sede · Label', 'stifanopassarelli' ), 'text', $acc['sede_label'] );
	$fields[] = stifanopassarelli_acf( 'home_accademia_sede_titolo', __( 'Sede · Titolo', 'stifanopassarelli' ), 'text', $acc['sede_titolo'] );
	$fields[] = stifanopassarelli_acf( 'home_accademia_sede_testo', __( 'Sede · Testo', 'stifanopassarelli' ), 'textarea', $acc['sede_testo'] );
	foreach ( $acc['sede'] as $n => $voce ) {
		/* translators: %d: numero del punto */
		$prefix   = sprintf( __( 'Sede · Punto %d', 'stifanopassarelli' ), $n ) . ' · ';
		$fields[] = stifanopassarelli_acf( "home_accademia_sede_{$n}_titolo", $prefix . __( 'Titolo', 'stifanopassarelli' ), 'text', $voce['titolo'] );
		$fields[] = stifanopassarelli_acf( "home_accademia_sede_{$n}_testo", $prefix . __( 'Testo', 'stifanopassarelli' ), 'textarea', $voce['testo'] );
	}
	$fields[] = stifanopassarelli_acf( 'home_accademia_sede_mappa', __( 'Sede · Link alla mappa', 'stifanopassarelli' ), 'text', $acc['sede_mappa'] );

	$fields[] = stifanopassarelli_acf( 'home_accademia_form_titolo', __( 'Form · Titolo', 'stifanopassarelli' ), 'text', $acc['form_titolo'] );
	$fields[] = stifanopassarelli_acf( 'home_accademia_form_testo', __( 'Form · Testo', 'stifanopassarelli' ), 'textarea', $acc['form_testo'] );
	$fields[] = stifanopassarelli_acf( 'home_accademia_form', __( 'Form · Shortcode (Contact Form 7)', 'stifanopassarelli' ), 'text', '', array( 'instructions' => __( 'Vuoto = nessun form, restano titolo e testo.', 'stifanopassarelli' ) ) );

	$fields[] = stifanopassarelli_acf( 'home_accademia_faq_label', __( 'FAQ · Label', 'stifanopassarelli' ), 'text', $acc['faq_label'] );
	foreach ( $acc['faq'] as $n => $faq ) {
		/* translators: %d: numero della domanda */
		$prefix   = sprintf( __( 'FAQ %d', 'stifanopassarelli' ), $n ) . ' · ';
		$fields[] = stifanopassarelli_acf( "home_accademia_faq_{$n}_domanda", $prefix . __( 'Domanda', 'stifanopassarelli' ), 'text', $faq['domanda'] );
		$fields[] = stifanopassarelli_acf( "home_accademia_faq_{$n}_risposta", $prefix . __( 'Risposta', 'stifanopassarelli' ), 'textarea', $faq['risposta'] );
	}

	return $fields;
}

/**
 * Field group della pagina "impostazioni-globali": social e footer.
 */
function stifanopassarelli_register_global_fields() {
	$location = stifanopassarelli_acf_location_settings_page();
	if ( ! $location ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'            => 'group_stifanopassarelli_globale',
			'title'          => __( 'Impostazioni globali', 'stifanopassarelli' ),
			'location'       => $location,
			'hide_on_screen' => array( 'the_content' ),
			'fields'         => array(
				stifanopassarelli_acf_tab( 'globale_social', __( 'Social', 'stifanopassarelli' ) ),
				stifanopassarelli_acf( 'globale_social_1_label', __( 'Social 1 — testo', 'stifanopassarelli' ), 'text', __( 'Instagram', 'stifanopassarelli' ) ),
				stifanopassarelli_acf( 'globale_social_1_link', __( 'Social 1 — link', 'stifanopassarelli' ), 'text', 'https://www.instagram.com/stifanopassarelliart/' ),
				stifanopassarelli_acf( 'globale_social_2_label', __( 'Social 2 — testo', 'stifanopassarelli' ), 'text', __( 'Facebook', 'stifanopassarelli' ) ),
				stifanopassarelli_acf( 'globale_social_2_link', __( 'Social 2 — link', 'stifanopassarelli' ), 'text', 'https://www.facebook.com/stifanopassarelliart' ),
				stifanopassarelli_acf( 'globale_social_3_label', __( 'Social 3 — testo', 'stifanopassarelli' ), 'text', __( 'YouTube', 'stifanopassarelli' ) ),
				stifanopassarelli_acf( 'globale_social_3_link', __( 'Social 3 — link', 'stifanopassarelli' ), 'text', 'https://www.youtube.com/@emanuelestifano132' ),
				stifanopassarelli_acf_tab( 'globale_footer', __( 'Footer', 'stifanopassarelli' ) ),
				stifanopassarelli_acf( 'globale_footer_claim', __( 'Claim (ammette <em>)', 'stifanopassarelli' ), 'text', __( "Umana è <em>l'opera.</em>", 'stifanopassarelli' ) ),
				stifanopassarelli_acf( 'globale_footer_copyright', __( 'Copyright', 'stifanopassarelli' ), 'text', __( '© 2026 Stifano Passarelli — Sintonizzazione Scultorea e Musiva', 'stifanopassarelli' ) ),
				stifanopassarelli_acf( 'globale_footer_piva', __( 'P.IVA', 'stifanopassarelli' ), 'text', __( 'P.IVA 00000000000', 'stifanopassarelli' ) ),
				stifanopassarelli_acf( 'globale_footer_credits', __( 'Credits', 'stifanopassarelli' ), 'text', __( 'Credits · Bozza homepage', 'stifanopassarelli' ) ),
			),
		)
	);
}
add_action( 'acf/init', 'stifanopassarelli_register_global_fields' );

/**
 * Social (impostazioni globali), usati nei Contatti.
 *
 * @return array[] Ogni voce ha `href` e `label`.
 */
function stifanopassarelli_socials() {
	$defaults = array(
		1 => array( 'https://www.instagram.com/stifanopassarelliart/', __( 'Instagram', 'stifanopassarelli' ) ),
		2 => array( 'https://www.facebook.com/stifanopassarelliart', __( 'Facebook', 'stifanopassarelli' ) ),
		3 => array( 'https://www.youtube.com/@emanuelestifano132', __( 'YouTube', 'stifanopassarelli' ) ),
	);

	$socials = array();
	foreach ( $defaults as $n => $default ) {
		$href = stifanopassarelli_setting( "globale_social_{$n}_link", $default[0] );
		if ( $href ) {
			$socials[] = array(
				'href'  => $href,
				'label' => stifanopassarelli_setting( "globale_social_{$n}_label", $default[1] ),
			);
		}
	}

	return $socials;
}

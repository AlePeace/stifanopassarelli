<?php
/**
 * Opere delle modifiche del cliente di ottobre 2026, create da Opere >
 * Importa contenuti. In ordine di collezione: l'ordine qui è il "Ordine" della
 * collezione, l'anno diventa la data del post.
 *
 * Ogni opera: `slug`, `title`, `collezione`, `anno`, `image` (path in assets/),
 * `fields` (ACF).
 *
 * @package stifanopassarelli
 */

return array(
	// Il Marmo.
	array(
		'slug'       => 'oceano-di-silenzio',
		'title'      => 'Oceano di Silenzio',
		'collezione' => 'marmo',
		'anno'       => 2023,
		'image'      => 'img/opere/oceano-di-silenzio.jpg',
		'fields'     => array(
			'opera_sottotitolo' => "L'immensità del vuoto scolpita nella pietra.",
			'opera_tecnica'     => 'Marmo statuario di Carrara e mosaico in foglia oro 24k',
			'opera_anno_luogo'  => '2023',
		),
	),
	array(
		'slug'       => 'logos-verita',
		'title'      => 'Logos, Verità',
		'collezione' => 'marmo',
		'anno'       => 2020,
		'image'      => 'img/opere/logos-verita.jpg',
		'fields'     => array(
			'opera_sottotitolo' => 'Il verbo che si fa corpo.',
			'opera_tecnica'     => 'Marmo statuario di Carrara',
			'opera_anno_luogo'  => '2020 — Collezione privata, Milano',
		),
	),
	array(
		'slug'       => 'logos-natura',
		'title'      => 'Logos, Natura',
		'collezione' => 'marmo',
		'anno'       => 2023,
		'image'      => 'img/opere/logos-natura.jpg',
		'fields'     => array(
			'opera_sottotitolo' => 'La forza di trasformarsi e farsi respiro vitale.',
			'opera_tecnica'     => 'Marmo statuario di Carrara',
			'opera_anno_luogo'  => '2023 — Collezione privata, Milano',
		),
	),
	array(
		'slug'       => 'logos-anima',
		'title'      => 'Logos, Anima',
		'collezione' => 'marmo',
		'anno'       => 2022,
		'image'      => 'img/opere/logos-anima.jpg',
		'fields'     => array(
			'opera_sottotitolo' => 'Il nervo scoperto della scultura.',
			'opera_tecnica'     => 'Marmo statuario di Carrara',
			'opera_anno_luogo'  => '2022 — In esposizione presso RSM, Milano',
		),
	),
	array(
		'slug'       => 'echoes',
		'title'      => 'Echoes',
		'collezione' => 'marmo',
		'anno'       => 2023,
		'image'      => 'img/opere/echoes.jpg',
		'fields'     => array(
			'opera_sottotitolo' => 'Il riaffiorare della memoria attraverso la rifrazione della luce.',
			'opera_tecnica'     => 'Marmo statuario di Carrara e mosaico in foglia oro 24k',
			'opera_anno_luogo'  => '2023 — In esposizione presso Gold Fixing, Montegrotto Terme (Padova)',
		),
	),

	// Il Mosaico.
	array(
		'slug'       => 'fatima',
		'title'      => 'Fatima, donna cilentana',
		'collezione' => 'mosaico',
		'anno'       => 2014,
		'image'      => 'img/opere/fatima.jpg',
		'fields'     => array(
			'opera_sottotitolo' => 'I solchi del tempo scolpiti nella pietra.',
			'opera_tecnica'     => 'Mosaico in materiali lapidei e smalti',
			'opera_anno_luogo'  => '2014 — Collezione privata, Casa Natale di Giovanni Pascoli, San Mauro Pascoli (FC)',
		),
	),
	array(
		'slug'       => 'libreria',
		'title'      => 'Libreria',
		'collezione' => 'mosaico',
		'anno'       => 2023,
		'image'      => 'img/opere/libreria.jpg',
		'fields'     => array(
			'opera_sottotitolo'  => 'La trama della conoscenza fatta materia.',
			'opera_tecnica'      => 'Mosaico in materiali lapidei e smalti (realizzato per Jepis Bottega)',
			'opera_anno_luogo'   => '2023 — Caselle in Pittari (SA)',
			'opera_inquadratura' => 'left',
		),
	),
	array(
		'slug'       => 'trupiale',
		'title'      => 'Trupiale',
		'collezione' => 'mosaico',
		'anno'       => 2025,
		'image'      => 'img/opere/trupiale.jpg',
		'fields'     => array(
			'opera_sottotitolo' => "Il dettaglio vibrante dell'opera Bacco.",
			'opera_tecnica'     => "Mosaico in smalti (particolare dell'opera monumentale Bacco)",
			'opera_anno_luogo'  => '2025 — Pellare (SA)',
		),
	),
	array(
		'slug'       => 'cristo-pantocratore',
		'title'      => 'Cristo Pantocratore',
		'collezione' => 'mosaico',
		'anno'       => 2021,
		'image'      => 'img/opere/cristo-pantocratore.jpg',
		'fields'     => array(
			'opera_sottotitolo' => 'Il confronto diretto con la sacralità.',
			'opera_tecnica'     => 'Copia del mosaico del Duomo di Cefalù',
			'opera_anno_luogo'  => '2021 — Cardile (SA)',
		),
	),

	// Antologia: quelle della bozza ("Il Rito della Forma" diventa Anthea), la Spigolatrice e Aedicula (ex Ordinarium).
	array(
		'slug'       => 'bacco',
		'title'      => 'Bacco',
		'collezione' => 'antologia',
		'anno'       => 2025,
		'image'      => 'img/antologia/bacco.jpg',
		'fields'     => array(
			'opera_nota' => "Agosto 2025 — l'Atto Zero",
		),
	),
	array(
		'slug'       => 'san-bartolomeo',
		'title'      => 'San Bartolomeo',
		'collezione' => 'antologia',
		'anno'       => 2025,
		'image'      => 'img/antologia/san_bartolomeo.jpg',
		'fields'     => array(
			'opera_nota' => 'Pellare — la lotta con il marmo',
		),
	),
	array(
		'slug'       => 'oltre-il-minerale',
		'title'      => 'Oltre il Minerale',
		'collezione' => 'antologia',
		'anno'       => 2025,
		'image'      => 'img/antologia/oltre_minerale.jpg',
		'fields'     => array(
			'opera_nota' => 'Frammento monumentale',
		),
	),
	array(
		'slug'       => 'anthea',
		'title'      => 'Anthea',
		'collezione' => 'antologia',
		'anno'       => 2025,
		'image'      => 'img/opere/anthea.jpg',
		'fields'     => array(),
	),
	array(
		'slug'       => 'spigolatrice',
		'title'      => 'Spigolatrice',
		'collezione' => 'antologia',
		'anno'       => 2021,
		'image'      => 'img/opere/spigolatrice.jpg',
		'fields'     => array(
			'opera_nota' => '2021 — bronzo, Sapri',
		),
	),
	array(
		'slug'       => 'aedicula',
		'title'      => 'Aedicula',
		'collezione' => 'antologia',
		'anno'       => 2025,
		'image'      => 'img/works/pos-03.jpg',
		'fields'     => array(
			'opera_nota'        => 'La Moka — La liturgia del risveglio.',
			'opera_sottotitolo' => 'La Moka — La liturgia del risveglio.',
			'opera_descrizione' => 'Il gesto quotidiano si fa nicchia votiva: il risveglio come primo rito del giorno.',
		),
	),
);

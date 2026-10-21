<?php
/**
 * Accademia (Scuola d'arte): copy di default della sezione, condivisa da campi
 * ACF e template, e ritocchi a Contact Form 7 per il form di richiesta info.
 *
 * @package stifanopassarelli
 */

/**
 * Copy di default della sezione Accademia (documento del cliente). Le chiavi
 * corrispondono ai campi ACF `home_accademia_*`; i gruppi numerati (corsi,
 * destinatari, sede, faq) a `home_accademia_{gruppo}_{n}_{chiave}`.
 *
 * @return array
 */
function stifanopassarelli_accademia() {
	return array(
		'label'             => __( 'Formazione & laboratorio', 'stifanopassarelli' ),
		'eyebrow'           => __( '08 — Accademia', 'stifanopassarelli' ),
		'titolo'            => __( "Accademia\nStifano Passarelli", 'stifanopassarelli' ),
		'sottotitolo'       => __( "Plasmare la terra, ricomporre la luce. La maestrìa dell'argilla e del mosaico.", 'stifanopassarelli' ),
		'intro'             => __( "La Scuola d'Arte Stifano Passarelli è un laboratorio formativo dedicato all'insegnamento delle tecniche tradizionali e contemporanee della ceramica e del mosaico.\nI nostri corsi sono pensati per persone di qualsiasi età e livello di preparazione. Dai principianti che desiderano avvicinarsi per la prima volta alla lavorazione manuale, fino a chi vuole approfondire una passione o acquisire nuove competenze artistiche e artigianali.", 'stifanopassarelli' ),
		'corsi_label'       => __( 'I corsi didattici', 'stifanopassarelli' ),
		'corsi'             => array(
			1 => array(
				'titolo'  => __( 'Argilla e Ceramica', 'stifanopassarelli' ),
				'docente' => __( 'A cura di Emanuele Stifano', 'stifanopassarelli' ),
				'impara'  => __( "Lo studio dei volumi e delle forme attraverso la manipolazione dell'argilla. Dalle tecniche base di modellazione manuale alla rifinitura delle superfici, fino alle fasi di essiccazione e cottura.", 'stifanopassarelli' ),
				'rivolto' => __( "Aperto a tutti, senza limiti d'età o necessità di esperienza pregressa.", 'stifanopassarelli' ),
				'src'     => 'img/antologia/il_rito_della_forma.jpg',
			),
			2 => array(
				'titolo'  => __( 'Mosaico Contemporaneo', 'stifanopassarelli' ),
				'docente' => __( 'A cura di Carla Passarelli', 'stifanopassarelli' ),
				'impara'  => __( "Le basi dell'arte musiva, dall'uso degli strumenti da taglio alla scelta dei materiali (smalti e pietre), fino alla composizione delle tessere e all'accostamento dei colori.", 'stifanopassarelli' ),
				'rivolto' => __( 'Adatto a bambini, ragazzi, adulti e senior che vogliono sviluppare manualità, precisione e senso del colore.', 'stifanopassarelli' ),
				'src'     => 'img/artists/carla.jpg',
			),
		),
		'destinatari_label' => __( 'A chi si rivolgono i corsi', 'stifanopassarelli' ),
		'destinatari_testo' => __( 'Non servono requisiti di accesso o competenze artistiche di partenza. La didattica è personalizzata e segue i ritmi di ogni singolo allievo.', 'stifanopassarelli' ),
		'destinatari'       => array(
			1 => array(
				'titolo' => __( 'Principianti e Curiosi', 'stifanopassarelli' ),
				'testo'  => __( 'Per scoprire il piacere di creare con le proprie mani.', 'stifanopassarelli' ),
			),
			2 => array(
				'titolo' => __( 'Ragazzi e Adulti di ogni età', 'stifanopassarelli' ),
				'testo'  => __( "Per apprendere un'arte pratica e stimolante.", 'stifanopassarelli' ),
			),
			3 => array(
				'titolo' => __( 'Appassionati e Creativi', 'stifanopassarelli' ),
				'testo'  => __( 'Per perfezionare la propria tecnica con la guida di professionisti.', 'stifanopassarelli' ),
			),
		),
		'sede_label'        => __( 'La sede & connettività', 'stifanopassarelli' ),
		'sede_titolo'       => __( "Un polo d'arte nel cuore del Cilento", 'stifanopassarelli' ),
		'sede_testo'        => __( "L'Accademia ha sede presso gli spazi della Fondazione Alario ad Ascea Marina (SA), una struttura immersa nel verde e dedicata alla cultura e all'innovazione.", 'stifanopassarelli' ),
		'sede'              => array(
			1 => array(
				'titolo' => __( 'Comodi collegamenti in treno', 'stifanopassarelli' ),
				'testo'  => __( 'La struttura si trova a pochi minuti a piedi dalla Stazione Ferroviaria di Ascea, rendendo i corsi facilmente raggiungibili in giornata da Napoli, Salerno e da tutta la Campania.', 'stifanopassarelli' ),
			),
			2 => array(
				'titolo' => __( 'Flessibilità oraria', 'stifanopassarelli' ),
				'testo'  => __( 'Proponiamo corsi a frequenza settimanale e workshop intensivi concentrati nel fine settimana.', 'stifanopassarelli' ),
			),
		),
		'sede_mappa'        => 'https://www.google.com/maps/search/?api=1&query=Fondazione+Alario+Ascea+Marina',
		'form_titolo'       => __( 'Richiedi il programma dei corsi', 'stifanopassarelli' ),
		'form_testo'        => __( 'Compila il modulo per ricevere via email o telefono la brochure con il calendario delle lezioni, i dettagli sui costi e le modalità di iscrizione.', 'stifanopassarelli' ),
		'faq_label'         => __( 'Domande frequenti', 'stifanopassarelli' ),
		'faq'               => array(
			1 => array(
				'domanda'  => __( 'Bisogna avere già competenze di disegno o scultura?', 'stifanopassarelli' ),
				'risposta' => __( "No, i percorsi partono dalle basi e guidano l'allievo passo dopo passo.", 'stifanopassarelli' ),
			),
			2 => array(
				'domanda'  => __( 'I materiali e le attrezzature sono inclusi?', 'stifanopassarelli' ),
				'risposta' => __( 'Sì, tutto il materiale didattico, gli strumenti di lavoro e le cotture sono forniti direttamente dal laboratorio.', 'stifanopassarelli' ),
			),
			3 => array(
				'domanda'  => __( 'Le opere realizzate si possono portare a casa?', 'stifanopassarelli' ),
				'risposta' => __( "Sì, tutti i manufatti completati durante il corso rimangono di proprietà dell'allievo.", 'stifanopassarelli' ),
			),
		),
	);
}

/**
 * Contact Form 7: niente <p>/<br> automatici (il markup del form è già quello
 * del tema) e classe `sp-form` sul <form>, come il form dei Contatti.
 */
add_filter( 'wpcf7_autop_or_not', '__return_false' );

/**
 * Aggiunge `sp-form` alle classi del <form> di Contact Form 7.
 *
 * @param string $class Classi del form.
 *
 * @return string
 */
function stifanopassarelli_wpcf7_form_class( $class ) {
	return $class . ' sp-form';
}
add_filter( 'wpcf7_form_class_attr', 'stifanopassarelli_wpcf7_form_class' );

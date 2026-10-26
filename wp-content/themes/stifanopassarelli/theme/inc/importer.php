<?php
/**
 * Opere > Importa contenuti: crea le opere (`content/opere.php`) e il modulo
 * CF7 dell'Accademia (`content/accademia-form.php`) su un'installazione nuova,
 * senza migrare il database. Quello che esiste già non viene toccato.
 *
 * @package stifanopassarelli
 */

/**
 * Aggiunge la schermata "Importa contenuti" sotto Opere.
 */
function stifanopassarelli_importer_menu() {
	add_submenu_page(
		'edit.php?post_type=opera',
		__( 'Importa contenuti', 'stifanopassarelli' ),
		__( 'Importa contenuti', 'stifanopassarelli' ),
		'manage_options',
		'stifanopassarelli-importer',
		'stifanopassarelli_importer_screen'
	);
}
add_action( 'admin_menu', 'stifanopassarelli_importer_menu' );

/**
 * Esegue l'azione del bottone e torna alla schermata con l'esito.
 */
function stifanopassarelli_importer_handle() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Permessi insufficienti.', 'stifanopassarelli' ) );
	}

	check_admin_referer( 'stifanopassarelli_importer' );

	$action = isset( $_POST['stifanopassarelli_action'] ) ? sanitize_key( wp_unslash( $_POST['stifanopassarelli_action'] ) ) : '';

	if ( 'opere' === $action ) {
		$result = stifanopassarelli_import_opere();
	} elseif ( 'form' === $action ) {
		$result = stifanopassarelli_import_accademia_form();
	} else {
		$result = array( 'error' => 'azione' );
	}

	wp_safe_redirect(
		add_query_arg(
			array_merge( array( 'page' => 'stifanopassarelli-importer' ), $result ),
			admin_url( 'edit.php?post_type=opera' )
		)
	);
	exit;
}
add_action( 'admin_post_stifanopassarelli_importer', 'stifanopassarelli_importer_handle' );

/**
 * Crea le collezioni mancanti ("ordinarium" diventa "marmo") e le opere che
 * non esistono ancora (stesso slug), pubblicate, con campi, collezione e
 * immagine in evidenza.
 *
 * @return array Esito: `opere` (create), `skipped` (già presenti).
 */
function stifanopassarelli_import_opere() {
	$ordinarium = get_term_by( 'slug', 'ordinarium', 'collezione' );
	if ( $ordinarium && ! term_exists( 'marmo', 'collezione' ) ) {
		wp_update_term(
			$ordinarium->term_id,
			'collezione',
			array(
				'name' => __( 'Marmo', 'stifanopassarelli' ),
				'slug' => 'marmo',
			)
		);
	}

	foreach ( stifanopassarelli_collezioni() as $slug => $collezione ) {
		if ( ! term_exists( $slug, 'collezione' ) ) {
			wp_insert_term( $collezione['name'], 'collezione', array( 'slug' => $slug ) );
		}
	}

	$opere   = require get_template_directory() . '/content/opere.php';
	$order   = array();
	$created = 0;
	$skipped = 0;

	foreach ( $opere as $opera ) {
		$order[ $opera['collezione'] ] = isset( $order[ $opera['collezione'] ] ) ? $order[ $opera['collezione'] ] + 1 : 1;

		if ( get_page_by_path( $opera['slug'], OBJECT, 'opera' ) ) {
			++$skipped;
			continue;
		}

		$post_id = wp_insert_post(
			array(
				'post_type'   => 'opera',
				'post_status' => 'publish',
				'post_title'  => $opera['title'],
				'post_name'   => $opera['slug'],
				'menu_order'  => $order[ $opera['collezione'] ],
				'post_date'   => sprintf( '%d-01-01 12:00:00', $opera['anno'] ),
			)
		);

		if ( ! $post_id || is_wp_error( $post_id ) ) {
			continue;
		}

		wp_set_object_terms( $post_id, $opera['collezione'], 'collezione' );

		foreach ( $opera['fields'] as $name => $value ) {
			if ( function_exists( 'update_field' ) ) {
				update_field( $name, $value, $post_id );
			} else {
				update_post_meta( $post_id, $name, $value );
			}
		}

		$alt = isset( $opera['fields']['opera_tecnica'] ) ? $opera['title'] . ' — ' . $opera['fields']['opera_tecnica'] : $opera['title'];
		stifanopassarelli_attach_opera_image( $post_id, $opera['image'], $opera['slug'], $opera['title'], $alt );

		++$created;
	}

	return array(
		'opere'   => $created,
		'skipped' => $skipped,
	);
}

/**
 * Carica nella libreria media una foto del tema e la imposta come immagine in
 * evidenza dell'opera.
 *
 * @param int    $post_id ID dell'opera.
 * @param string $image   Path della foto in assets/.
 * @param string $slug    Slug dell'opera (nome del file caricato).
 * @param string $title   Titolo dell'allegato.
 * @param string $alt     Testo alternativo.
 */
function stifanopassarelli_attach_opera_image( $post_id, $image, $slug, $title, $alt ) {
	$source = get_template_directory() . '/assets/' . $image;

	if ( ! file_exists( $source ) ) {
		return;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	$name = $slug . '.' . pathinfo( $source, PATHINFO_EXTENSION );
	$tmp  = wp_tempnam( $name );
	if ( ! $tmp || ! copy( $source, $tmp ) ) {
		return;
	}

	$attachment_id = media_handle_sideload(
		array(
			'name'     => $name,
			'tmp_name' => $tmp,
		),
		$post_id,
		$title
	);

	if ( is_wp_error( $attachment_id ) ) {
		wp_delete_file( $tmp );
		return;
	}

	update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt );
	set_post_thumbnail( $post_id, $attachment_id );
}

/**
 * Crea (o riallinea) il modulo CF7 dell'Accademia e ne mette lo shortcode nel
 * campo `home_accademia_form` della Home. Destinatario: l'email
 * dell'amministratore (Impostazioni > Generali), poi modificabile dal modulo.
 *
 * @return array Esito: `form` (ID del modulo) o `error`.
 */
function stifanopassarelli_import_accademia_form() {
	if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
		return array( 'error' => 'cf7' );
	}

	$home = get_page_by_path( 'home' );
	if ( ! $home ) {
		return array( 'error' => 'home' );
	}

	$data     = require get_template_directory() . '/content/accademia-form.php';
	$existing = get_posts(
		array(
			'post_type'      => 'wpcf7_contact_form',
			'title'          => $data['title'],
			'posts_per_page' => 1,
		)
	);
	$form     = $existing ? wpcf7_contact_form( $existing[0]->ID ) : WPCF7_ContactForm::get_template(
		array(
			'title'  => $data['title'],
			'locale' => 'it_IT',
		)
	);

	$mail = $form->prop( 'mail' );
	if ( ! $existing ) {
		$mail['recipient'] = '[_site_admin_email]';
	}
	$mail['subject']            = $data['subject'];
	$mail['body']               = $data['body'];
	$mail['additional_headers'] = 'Reply-To: [email]';
	$mail['use_html']           = false;

	$form->set_properties(
		array(
			'form'     => $data['form'],
			'mail'     => $mail,
			'mail_2'   => array_merge( $form->prop( 'mail_2' ), array( 'active' => false ) ),
			'messages' => array_merge( $form->prop( 'messages' ), $data['messages'] ),
		)
	);
	$form->set_locale( 'it_IT' );
	$id = $form->save();

	// Lo shortcode si rilegge dopo il salvataggio: prima l'ID è vuoto.
	$form = wpcf7_contact_form( $id );
	if ( function_exists( 'update_field' ) ) {
		update_field( 'home_accademia_form', $form->shortcode(), $home->ID );
	} else {
		update_post_meta( $home->ID, 'home_accademia_form', $form->shortcode() );
	}

	// Il modulo di esempio creato all'attivazione di CF7 non serve.
	foreach ( get_posts( array( 'post_type' => 'wpcf7_contact_form', 'title' => 'Contact form 1', 'posts_per_page' => -1 ) ) as $demo ) {
		wp_delete_post( $demo->ID, true );
	}

	return array( 'form' => $id );
}

/**
 * Disegna la schermata.
 */
function stifanopassarelli_importer_screen() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- sola lettura dell'esito.
	$created = isset( $_GET['opere'] ) ? (int) $_GET['opere'] : null;
	$skipped = isset( $_GET['skipped'] ) ? (int) $_GET['skipped'] : 0;
	$form    = isset( $_GET['form'] ) ? (int) $_GET['form'] : null;
	$error   = isset( $_GET['error'] ) ? sanitize_key( wp_unslash( $_GET['error'] ) ) : '';
	// phpcs:enable
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Importa contenuti', 'stifanopassarelli' ); ?></h1>

		<?php if ( 'cf7' === $error ) : ?>
			<div class="notice notice-error"><p><?php esc_html_e( 'Contact Form 7 non è attivo: installalo e attivalo, poi riprova.', 'stifanopassarelli' ); ?></p></div>
		<?php elseif ( 'home' === $error ) : ?>
			<div class="notice notice-error"><p><?php esc_html_e( 'Manca la pagina "Home" (slug home): riattiva il tema per crearla.', 'stifanopassarelli' ); ?></p></div>
		<?php elseif ( $error ) : ?>
			<div class="notice notice-error"><p><?php esc_html_e( 'Azione non riconosciuta.', 'stifanopassarelli' ); ?></p></div>
		<?php elseif ( null !== $created ) : ?>
			<div class="notice notice-success"><p>
				<?php
				/* translators: 1: opere create, 2: opere già presenti. */
				printf( esc_html__( 'Opere create: %1$d, già presenti: %2$d.', 'stifanopassarelli' ), (int) $created, (int) $skipped );
				?>
			</p></div>
		<?php elseif ( null !== $form ) : ?>
			<div class="notice notice-success"><p>
				<?php
				printf(
					/* translators: %s: link al modulo. */
					esc_html__( 'Modulo dell\'Accademia pronto e collegato alla Home. Controlla il destinatario delle email nella scheda Mail del %s.', 'stifanopassarelli' ),
					'<a href="' . esc_url( admin_url( 'admin.php?page=wpcf7&post=' . $form . '&action=edit' ) ) . '">' . esc_html__( 'modulo', 'stifanopassarelli' ) . '</a>'
				);
				?>
			</p></div>
		<?php endif; ?>

		<h2><?php esc_html_e( 'Opere', 'stifanopassarelli' ); ?></h2>
		<p><?php esc_html_e( 'Crea le collezioni Marmo, Mosaico e Antologia e le opere con testi e foto (5 Marmo, 4 Mosaico, 6 Antologia). Le opere già presenti vengono saltate.', 'stifanopassarelli' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'stifanopassarelli_importer' ); ?>
			<input type="hidden" name="action" value="stifanopassarelli_importer">
			<input type="hidden" name="stifanopassarelli_action" value="opere">
			<?php submit_button( __( 'Crea opere', 'stifanopassarelli' ), 'primary', 'submit', false ); ?>
		</form>

		<h2><?php esc_html_e( 'Modulo Accademia', 'stifanopassarelli' ); ?></h2>
		<p><?php esc_html_e( 'Crea il modulo Contact Form 7 "Richiedi il programma dei corsi" e lo mette nella sezione Accademia della Home. Serve Contact Form 7 attivo. Se il modulo esiste già ne riallinea campi e testi, senza cambiare il destinatario.', 'stifanopassarelli' ); ?></p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'stifanopassarelli_importer' ); ?>
			<input type="hidden" name="action" value="stifanopassarelli_importer">
			<input type="hidden" name="stifanopassarelli_action" value="form">
			<?php submit_button( __( 'Crea modulo Accademia', 'stifanopassarelli' ), 'secondary', 'submit', false ); ?>
		</form>
	</div>
	<?php
}

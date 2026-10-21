<?php
/**
 * Helper di lettura dei campi ACF, a prova di plugin assente: senza ACF (o con
 * il campo vuoto) ritornano il fallback, cioè la copy del prototipo.
 *
 * @package stifanopassarelli
 */

/**
 * Valore RAW di un campo ACF, o il fallback se vuoto / ACF non attivo.
 *
 * @param string   $name     Nome del campo.
 * @param mixed    $fallback Valore se il campo è vuoto.
 * @param int|bool $post_id  Post da cui leggere (default: post corrente).
 *
 * @return mixed
 */
function stifanopassarelli_field( $name, $fallback = '', $post_id = false ) {
	if ( ! function_exists( 'get_field' ) ) {
		return $fallback;
	}

	$value = get_field( $name, $post_id );

	if ( null === $value || false === $value || '' === $value || array() === $value ) {
		return $fallback;
	}

	return $value;
}

/**
 * Stampa un campo ACF: esc_html di default, wp_kses_post se $allow_html.
 *
 * @param string   $name       Nome del campo.
 * @param string   $fallback   Valore se il campo è vuoto.
 * @param bool     $allow_html Ammette markup (br, strong).
 * @param int|bool $post_id    Post da cui leggere (default: post corrente).
 */
function stifanopassarelli_the_field( $name, $fallback = '', $allow_html = false, $post_id = false ) {
	$value = stifanopassarelli_field( $name, $fallback, $post_id );

	echo $allow_html ? wp_kses_post( $value ) : esc_html( $value ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * ID della pagina "impostazioni-globali" nella lingua corrente (WPML), o 0.
 *
 * @return int
 */
function stifanopassarelli_settings_page_id() {
	static $page_id = null;

	if ( null === $page_id ) {
		$page    = get_page_by_path( 'impostazioni-globali' );
		$page_id = $page ? (int) apply_filters( 'wpml_object_id', $page->ID, 'page', true ) : 0;
	}

	return $page_id;
}

/**
 * Valore RAW di un campo globale (pagina "impostazioni-globali"), o il fallback.
 *
 * @param string $name     Nome del campo.
 * @param mixed  $fallback Valore se il campo è vuoto o la pagina non esiste.
 *
 * @return mixed
 */
function stifanopassarelli_setting( $name, $fallback = '' ) {
	$page_id = stifanopassarelli_settings_page_id();

	return $page_id ? stifanopassarelli_field( $name, $fallback, $page_id ) : $fallback;
}

/**
 * Stampa un campo globale: esc_html di default, wp_kses_post se $allow_html.
 *
 * @param string $name       Nome del campo.
 * @param string $fallback   Valore se il campo è vuoto o la pagina non esiste.
 * @param bool   $allow_html Ammette markup (em, br).
 */
function stifanopassarelli_the_setting( $name, $fallback = '', $allow_html = false ) {
	$value = stifanopassarelli_setting( $name, $fallback );

	echo $allow_html ? wp_kses_post( $value ) : esc_html( $value ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * La pagina delle impostazioni globali serve solo da admin: dal front end
 * rimanda alla home.
 */
function stifanopassarelli_settings_page_redirect() {
	$page_id = stifanopassarelli_settings_page_id();

	if ( $page_id && is_page( $page_id ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'stifanopassarelli_settings_page_redirect' );

<?php
/**
 * 11 — Contatti (\\ RISONANZE): form.
 * Con lo shortcode del form vuoto resta il form della bozza, che non invia.
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_form = stifanopassarelli_field( 'home_contatti_form' );
?>
<section class="sp-section" id="contatti">
	<div class="sp-container relative z-[2]">
		<div class="sp-section__head">
			<span class="sp-label"><?php stifanopassarelli_the_field( 'home_contatti_label', __( 'Risonanze', 'stifanopassarelli' ) ); ?></span>
			<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_contatti_eyebrow', __( '09 — Contatti & Gallerie', 'stifanopassarelli' ) ); ?></span>
		</div>
		<div class="sp-contact">
			<?php if ( $stifanopassarelli_form ) : ?>
				<div class="sp-form"><?php echo do_shortcode( $stifanopassarelli_form ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
			<?php else : ?>
				<form class="sp-form" onsubmit="return false">
					<div class="sp-field"><label for="sp-nome"><?php esc_html_e( 'Nome', 'stifanopassarelli' ); ?></label><input id="sp-nome" type="text" placeholder="<?php esc_attr_e( 'Il tuo nome', 'stifanopassarelli' ); ?>" /></div>
					<div class="sp-field"><label for="sp-email"><?php esc_html_e( 'Email', 'stifanopassarelli' ); ?></label><input id="sp-email" type="email" placeholder="<?php esc_attr_e( 'La tua email', 'stifanopassarelli' ); ?>" /></div>
					<div class="sp-field"><label for="sp-messaggio"><?php esc_html_e( 'Messaggio', 'stifanopassarelli' ); ?></label><textarea id="sp-messaggio" rows="3" placeholder="<?php esc_attr_e( 'Per collezionisti e curatori', 'stifanopassarelli' ); ?>"></textarea></div>
					<button class="sp-btn" type="submit"><?php esc_html_e( 'Invia richiesta →', 'stifanopassarelli' ); ?></button>
				</form>
			<?php endif; ?>
		</div>
	</div>
</section>

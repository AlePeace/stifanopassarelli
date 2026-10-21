<?php
/**
 * 09 — Contatti (\\ RISONANZE): form + laboratorio, galleria e social.
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
			<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_contatti_eyebrow', __( '07 — Contatti & Gallerie', 'stifanopassarelli' ) ); ?></span>
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
			<div>
				<p class="font-mono text-[.8rem] leading-[2] tracking-[.06em]">
					<?php stifanopassarelli_the_field( 'home_contatti_laboratorio_label', __( 'Il laboratorio', 'stifanopassarelli' ) ); ?><br><strong><?php stifanopassarelli_the_field( 'home_contatti_laboratorio', __( 'Pellare (SA)', 'stifanopassarelli' ) ); ?></strong><br><br>
					<?php stifanopassarelli_the_field( 'home_contatti_galleria_label', __( 'Galleria espositiva', 'stifanopassarelli' ) ); ?><br><strong><?php stifanopassarelli_the_field( 'home_contatti_galleria', __( 'Positano', 'stifanopassarelli' ) ); ?></strong><br><br>
					<?php
					echo implode( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						' · ',
						array_map(
							function ( $social ) {
								return sprintf( '<a href="%s" class="underline" target="_blank" rel="noopener">%s</a>', esc_url( $social['href'] ), esc_html( $social['label'] ) );
							},
							stifanopassarelli_socials()
						)
					);
					?>
				</p>
			</div>
		</div>
	</div>
</section>

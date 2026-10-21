<?php
/**
 * 05 — Ordinarium (\\ IL SACRO ORDINARIO): pannelli espandibili (ref
 * normalisboring), accordion vero su mobile (initPanels). Le opere sono quelle
 * della collezione "ordinarium" (inc/opere.php).
 *
 * @package stifanopassarelli
 */

?>
<section class="sp-section sp-dark" id="ordinarium">
	<div class="sp-lines sp-lines--dark"></div>
	<div class="sp-container relative z-[2]">
		<div class="sp-section__head">
			<div>
				<span class="sp-label"><?php stifanopassarelli_the_field( 'home_ordinarium_label', __( 'Ordinarium: il Sacro Ordinario', 'stifanopassarelli' ) ); ?></span>
				<h2 class="sp-h2 mt-4"><?php stifanopassarelli_the_field( 'home_ordinarium_titolo', __( 'Il cortocircuito<br>materico', 'stifanopassarelli' ), true ); ?></h2>
			</div>
			<p class="sp-eyebrow max-w-[30ch] opacity-70"><?php stifanopassarelli_the_field( 'home_ordinarium_eyebrow', __( "03 — La Collezione · marmo, bronzo e mosaico che piegano la permanenza all'intimità quotidiana", 'stifanopassarelli' ) ); ?></p>
		</div>

		<div class="sp-panels">
			<?php foreach ( stifanopassarelli_opere( 'ordinarium' ) as $stifanopassarelli_i => $stifanopassarelli_opera ) : ?>
				<article class="sp-panel" data-cursor="view" data-cursor-label="<?php esc_attr_e( 'Apri', 'stifanopassarelli' ); ?>">
					<?php stifanopassarelli_opera_img( $stifanopassarelli_opera, '', $stifanopassarelli_opera['alt'] ? $stifanopassarelli_opera['alt'] : $stifanopassarelli_opera['title'] ); ?>
					<div class="sp-panel__meta">
						<span class="sp-panel__idx"><?php echo esc_html( sprintf( '%02d', $stifanopassarelli_i + 1 ) ); ?></span>
						<h3 class="sp-panel__name"><?php echo esc_html( $stifanopassarelli_opera['title'] ); ?></h3>
						<div class="sp-panel__body">
							<?php if ( $stifanopassarelli_opera['sottotitolo'] ) : ?>
								<p class="sp-panel__sub"><?php echo esc_html( $stifanopassarelli_opera['sottotitolo'] ); ?></p>
							<?php endif; ?>
							<?php if ( $stifanopassarelli_opera['descrizione'] ) : ?>
								<p class="text-[.9rem] opacity-80"><?php echo esc_html( $stifanopassarelli_opera['descrizione'] ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

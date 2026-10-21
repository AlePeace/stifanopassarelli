<?php
/**
 * 05 — Il Marmo (\\ LA MATERIA BIANCA), ex Ordinarium: pannelli espandibili
 * (ref normalisboring), accordion vero su mobile (initPanels). Le opere sono
 * quelle della collezione "marmo" (inc/opere.php).
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_opere = stifanopassarelli_opere( 'marmo' );
if ( ! $stifanopassarelli_opere ) {
	return;
}
?>
<section class="sp-section sp-dark" id="marmo">
	<div class="sp-lines sp-lines--dark"></div>
	<div class="sp-container relative z-[2]">
		<div class="sp-section__head">
			<div>
				<span class="sp-label"><?php stifanopassarelli_the_field( 'home_marmo_label', __( 'La materia bianca: il marmo', 'stifanopassarelli' ) ); ?></span>
				<h2 class="sp-h2 mt-4"><?php stifanopassarelli_the_field( 'home_marmo_titolo', __( 'Il marmo,<br>sottrazione e luce', 'stifanopassarelli' ), true ); ?></h2>
			</div>
			<div class="max-w-[42ch]">
				<p class="sp-eyebrow opacity-70"><?php stifanopassarelli_the_field( 'home_marmo_eyebrow', __( '03 — Il Marmo', 'stifanopassarelli' ) ); ?></p>
				<p class="mt-4 text-[.95rem] leading-[1.6] opacity-80" data-fade><?php stifanopassarelli_the_field( 'home_marmo_testo', __( "La pietra di Carrara come foglio bianco su cui scavare il silenzio. La Sottrazione incontra la forma pura. La carne, l'anima e il pensiero emergono dal blocco attraverso il gesto crudo dello scalpello.", 'stifanopassarelli' ) ); ?></p>
			</div>
		</div>

		<div class="sp-panels">
			<?php foreach ( $stifanopassarelli_opere as $stifanopassarelli_i => $stifanopassarelli_opera ) : ?>
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
							<?php if ( $stifanopassarelli_opera['tecnica'] || $stifanopassarelli_opera['anno_luogo'] ) : ?>
								<p class="mt-3 font-mono text-[.68rem] leading-[1.7] tracking-[.06em] opacity-75">
									<?php echo esc_html( $stifanopassarelli_opera['tecnica'] ); ?>
									<?php if ( $stifanopassarelli_opera['tecnica'] && $stifanopassarelli_opera['anno_luogo'] ) : ?>
										<br>
									<?php endif; ?>
									<?php echo esc_html( $stifanopassarelli_opera['anno_luogo'] ); ?>
								</p>
							<?php endif; ?>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

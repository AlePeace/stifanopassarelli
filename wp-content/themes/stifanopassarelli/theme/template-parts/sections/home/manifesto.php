<?php
/**
 * 02 — Il Manifesto (\\ IL PATTO DEL SEGNO): testo che si svela parola per
 * parola + slat reveal dell'immagine.
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_words = preg_split( '/\s+/', trim( stifanopassarelli_field( 'home_manifesto_testo', __( 'Due anime, due linguaggi che vibrano alla stessa frequenza prima ancora di toccare la materia.', 'stifanopassarelli' ) ) ) );
?>
<section class="sp-section sp-vrule" id="sintonizzazione">
	<div class="sp-lines"></div>
	<div class="sp-container relative z-[2]">
		<div class="sp-section__head">
			<span class="sp-label"><?php stifanopassarelli_the_field( 'home_manifesto_label', __( 'Il Patto del Segno', 'stifanopassarelli' ) ); ?></span>
			<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_manifesto_eyebrow', __( '01 — Il Manifesto', 'stifanopassarelli' ) ); ?></span>
		</div>
		<div class="grid items-center gap-16 md:grid-cols-2">
			<p class="sp-manifesto__text" data-reveal-words>
				<?php foreach ( $stifanopassarelli_words as $stifanopassarelli_word ) : ?>
					<span class="sp-reveal-word"><span><?php echo esc_html( $stifanopassarelli_word ); ?></span></span>
				<?php endforeach; ?>
			</p>
			<div>
				<div class="sp-slats aspect-[4/5]" data-slats="9">
					<?php
					stifanopassarelli_img(
						array(
							'src'   => 'img/manifesto/manifesto.jpg',
							'field' => 'home_manifesto_immagine',
							'alt'   => __( 'Il duo nel vuoto del laboratorio', 'stifanopassarelli' ),
							'class' => 'sp-slats__img',
						)
					);
					?>
					<div class="sp-slats__overlay"></div>
				</div>
				<p class="mt-6 max-w-[46ch] font-mono text-[.8rem] tracking-[.06em] opacity-75" data-fade>
					<?php stifanopassarelli_the_field( 'home_manifesto_didascalia', __( "La <em>Sintonizzazione</em> è l'Atto Zero. La <em>Risonanza</em> è l'opera che diventa specchio emozionale per chi la osserva.", 'stifanopassarelli' ), true ); ?>
				</p>
			</div>
		</div>
	</div>
</section>

<?php
/**
 * 04 — Il Rito (\\ LA DOPPIA PELLE): split screen Sottrazione (Emanuele) /
 * Dedizione (Carla). Su "La Dedizione" nessun overlay: il testo passa al
 * chiaro con text-shadow (components/split.css).
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_panels = array(
	1 => array(
		'side'   => 'left',
		'num'    => __( '/ 01 · Emanuele', 'stifanopassarelli' ),
		'titolo' => __( 'La Sottrazione', 'stifanopassarelli' ),
		'testo'  => __( 'Il gesto crudo che scava il marmo e il bronzo alla ricerca della carne e della libertà anatomica.', 'stifanopassarelli' ),
		'src'    => 'img/rito/rito-05.jpg',
		'alt'    => __( 'Emanuele scava il marmo', 'stifanopassarelli' ),
	),
	2 => array(
		'side'   => 'right',
		'num'    => __( '/ 02 · Carla', 'stifanopassarelli' ),
		'titolo' => __( 'La Dedizione', 'stifanopassarelli' ),
		'testo'  => __( "Il ritmo lento che ricompone la luce e l'infinito, tessera dopo tessera, avvolgendo la forma.", 'stifanopassarelli' ),
		'src'    => 'img/artists/carla.jpg',
		'alt'    => __( 'Carla ricompone il mosaico', 'stifanopassarelli' ),
	),
);
?>
<section id="il-rito">
	<div class="sp-section__head px-(--sp-gutter) pt-20">
		<span class="sp-label"><?php stifanopassarelli_the_field( 'home_rito_label', __( 'La Doppia Pelle', 'stifanopassarelli' ) ); ?></span>
		<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_rito_eyebrow', __( '02 — Il Rito · Sottrazione vs Dedizione', 'stifanopassarelli' ) ); ?></span>
	</div>
	<div class="sp-split">
		<?php foreach ( $stifanopassarelli_panels as $stifanopassarelli_n => $stifanopassarelli_panel ) : ?>
			<div class="sp-split__panel sp-split__panel--<?php echo esc_attr( $stifanopassarelli_panel['side'] ); ?>">
				<div class="sp-split__bg">
					<?php
					stifanopassarelli_img(
						array(
							'src'   => $stifanopassarelli_panel['src'],
							'field' => "home_rito_{$stifanopassarelli_n}_immagine",
							'alt'   => $stifanopassarelli_panel['alt'],
						)
					);
					?>
				</div>
				<div class="sp-split__content">
					<span class="sp-split__num"><?php stifanopassarelli_the_field( "home_rito_{$stifanopassarelli_n}_num", $stifanopassarelli_panel['num'] ); ?></span>
					<h3 class="sp-split__title"><?php stifanopassarelli_the_field( "home_rito_{$stifanopassarelli_n}_titolo", $stifanopassarelli_panel['titolo'] ); ?></h3>
					<p class="max-w-[34ch] opacity-85"><?php stifanopassarelli_the_field( "home_rito_{$stifanopassarelli_n}_testo", $stifanopassarelli_panel['testo'] ); ?></p>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

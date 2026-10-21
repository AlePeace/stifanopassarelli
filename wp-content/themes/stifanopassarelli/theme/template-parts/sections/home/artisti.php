<?php
/**
 * 08 — Gli Artisti (\\ EMANUELE & CARLA).
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_artisti = array(
	1 => array(
		'ruolo' => __( 'Sottrazione — marmo & bronzo', 'stifanopassarelli' ),
		'nome'  => __( 'Emanuele Stifano', 'stifanopassarelli' ),
		'bio'   => __( 'Radici a Pellare, maturazione tra Carrara, Pietrasanta e la carne del marmo. La scultura come atto di liberazione della forma.', 'stifanopassarelli' ),
		'src'   => 'img/artists/emanuele.jpg',
		'class' => '',
	),
	2 => array(
		'ruolo' => __( 'Dedizione — mosaico & luce', 'stifanopassarelli' ),
		'nome'  => __( 'Carla Passarelli', 'stifanopassarelli' ),
		'bio'   => __( "Da Acquavella a Ravenna, la disciplina della tessera. Ricompone la luce con la pazienza dell'infinito, tassello dopo tassello.", 'stifanopassarelli' ),
		'src'   => 'img/artists/carla-ritratto.jpg',
		'class' => 'object-[64%_center]',
	),
);
?>
<section id="artisti">
	<div class="sp-section__head px-(--sp-gutter) pt-20">
		<span class="sp-label"><?php stifanopassarelli_the_field( 'home_artisti_label', __( 'Emanuele & Carla', 'stifanopassarelli' ) ); ?></span>
		<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_artisti_eyebrow', __( '06 — Gli Artisti', 'stifanopassarelli' ) ); ?></span>
	</div>
	<div class="sp-artists">
		<?php foreach ( $stifanopassarelli_artisti as $stifanopassarelli_n => $stifanopassarelli_artista ) : ?>
			<?php $stifanopassarelli_nome = stifanopassarelli_field( "home_artisti_{$stifanopassarelli_n}_nome", $stifanopassarelli_artista['nome'] ); ?>
			<article class="sp-artist">
				<div class="sp-artist__bg">
					<?php
					stifanopassarelli_img(
						array(
							'src'   => $stifanopassarelli_artista['src'],
							'field' => "home_artisti_{$stifanopassarelli_n}_immagine",
							'alt'   => $stifanopassarelli_nome,
							'class' => $stifanopassarelli_artista['class'],
						)
					);
					?>
				</div>
				<div class="sp-artist__content">
					<p class="sp-artist__role"><?php stifanopassarelli_the_field( "home_artisti_{$stifanopassarelli_n}_ruolo", $stifanopassarelli_artista['ruolo'] ); ?></p>
					<h3 class="sp-artist__name"><?php echo esc_html( $stifanopassarelli_nome ); ?></h3>
					<p class="mt-4 opacity-85"><?php stifanopassarelli_the_field( "home_artisti_{$stifanopassarelli_n}_bio", $stifanopassarelli_artista['bio'] ); ?></p>
				</div>
			</article>
		<?php endforeach; ?>
	</div>
</section>

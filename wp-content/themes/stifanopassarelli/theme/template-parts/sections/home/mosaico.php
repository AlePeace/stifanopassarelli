<?php
/**
 * 06 — Il Mosaico (\\ LA DEDIZIONE): titolo verticale e colonne sfalsate con
 * numerazione grande (ref editoriale Pinterest del cliente), slat reveal sulle
 * foto. Su mobile le colonne diventano una riga a scorrimento orizzontale con
 * le frecce dell'Antologia (initScrollers). Le opere sono quelle della
 * collezione "mosaico" (inc/opere.php).
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_opere = stifanopassarelli_opere( 'mosaico' );
if ( ! $stifanopassarelli_opere ) {
	return;
}
?>
<section class="sp-section sp-mosaic" id="mosaico">
	<div class="sp-lines"></div>
	<div class="sp-container relative z-[2]">
		<div class="sp-section__head">
			<span class="sp-label"><?php stifanopassarelli_the_field( 'home_mosaico_label', __( 'La dedizione: il mosaico', 'stifanopassarelli' ) ); ?></span>
			<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_mosaico_eyebrow', __( '04 — Il Mosaico', 'stifanopassarelli' ) ); ?></span>
		</div>

		<div class="sp-mosaic__grid">
			<div class="sp-mosaic__aside">
				<h2 class="sp-mosaic__title"><?php stifanopassarelli_the_field( 'home_mosaico_titolo', __( 'Carla Passarelli,<br>il rito della <em>tessera</em>', 'stifanopassarelli' ), true ); ?></h2>
				<p class="sp-mosaic__intro" data-fade><?php stifanopassarelli_the_field( 'home_mosaico_testo', __( 'Dalla rigida disciplina bizantina appresa a Ravenna alla libertà espressiva nel laboratorio di Acquavella. Un rito lento di ricomposizione del mondo.', 'stifanopassarelli' ) ); ?></p>
			</div>

			<div class="sp-mosaic__works" data-scroller>
				<?php foreach ( $stifanopassarelli_opere as $stifanopassarelli_i => $stifanopassarelli_opera ) : ?>
					<article class="sp-mosaic__work">
						<span class="sp-mosaic__num"><?php echo esc_html( sprintf( '%02d', $stifanopassarelli_i + 1 ) ); ?></span>
						<div class="sp-slats aspect-[4/5]" data-slats="5">
							<?php stifanopassarelli_opera_img( $stifanopassarelli_opera, 'sp-slats__img', $stifanopassarelli_opera['alt'] ? $stifanopassarelli_opera['alt'] : $stifanopassarelli_opera['title'] ); ?>
							<div class="sp-slats__overlay"></div>
						</div>
						<h3 class="sp-mosaic__name"><?php echo esc_html( $stifanopassarelli_opera['title'] ); ?></h3>
						<?php if ( $stifanopassarelli_opera['sottotitolo'] ) : ?>
							<p class="sp-mosaic__sub"><?php echo esc_html( $stifanopassarelli_opera['sottotitolo'] ); ?></p>
						<?php endif; ?>
						<?php if ( $stifanopassarelli_opera['tecnica'] || $stifanopassarelli_opera['anno_luogo'] ) : ?>
							<p class="sp-mosaic__meta">
								<?php echo esc_html( $stifanopassarelli_opera['tecnica'] ); ?>
								<?php if ( $stifanopassarelli_opera['tecnica'] && $stifanopassarelli_opera['anno_luogo'] ) : ?>
									<br>
								<?php endif; ?>
								<?php echo esc_html( $stifanopassarelli_opera['anno_luogo'] ); ?>
							</p>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</div>

			<!-- frecce solo su mobile (riga a scorrimento): come quelle dell'Antologia -->
			<div class="sp-swiper-nav sp-mosaic__nav">
				<button class="sp-swiper-btn sp-swiper-btn--prev" type="button" aria-label="<?php esc_attr_e( 'Opera precedente', 'stifanopassarelli' ); ?>">
					<svg viewBox="0 0 40 12" fill="none" aria-hidden="true"><path d="M40 6H1M1 6l6-5M1 6l6 5" stroke="currentColor" stroke-width="1"/></svg>
				</button>
				<button class="sp-swiper-btn sp-swiper-btn--next" type="button" aria-label="<?php esc_attr_e( 'Opera successiva', 'stifanopassarelli' ); ?>">
					<svg viewBox="0 0 40 12" fill="none" aria-hidden="true"><path d="M0 6h39M39 6l-6-5M39 6l-6 5" stroke="currentColor" stroke-width="1"/></svg>
				</button>
			</div>
		</div>
	</div>
</section>

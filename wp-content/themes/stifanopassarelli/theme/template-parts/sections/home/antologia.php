<?php
/**
 * 07 — Antologia (\\ MEMORIA E FRAMMENTI): carosello Swiper con slat reveal.
 *
 * @package stifanopassarelli
 */

?>
<section class="sp-section" id="antologia">
	<div class="sp-container">
		<div class="sp-section__head">
			<span class="sp-label"><?php stifanopassarelli_the_field( 'home_antologia_label', __( 'Memoria e Frammenti', 'stifanopassarelli' ) ); ?></span>
			<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_antologia_eyebrow', __( '05 — Antologia · le altre opere', 'stifanopassarelli' ) ); ?></span>
		</div>
	</div>
	<div class="sp-swiper">
		<?php // `!`: il CSS base di Swiper (`.swiper { padding: 0 }`) viene dopo le utility. ?>
		<div class="swiper px-(--sp-gutter)!" data-swiper>
			<div class="swiper-wrapper">
				<?php foreach ( stifanopassarelli_opere( 'antologia' ) as $stifanopassarelli_opera ) : ?>
					<div class="swiper-slide">
						<div class="sp-slats aspect-[3/4]" data-slats="7">
							<?php stifanopassarelli_opera_img( $stifanopassarelli_opera, 'sp-slats__img', $stifanopassarelli_opera['alt'] ? $stifanopassarelli_opera['alt'] : $stifanopassarelli_opera['title'] ); ?>
							<div class="sp-slats__overlay"></div>
						</div>
						<div class="mt-4">
							<h3 class="font-serif text-[1.6rem]"><?php echo esc_html( $stifanopassarelli_opera['title'] ); ?></h3>
							<?php if ( $stifanopassarelli_opera['nota'] ) : ?>
								<span class="font-mono text-[.72rem] opacity-60"><?php echo esc_html( $stifanopassarelli_opera['nota'] ); ?></span>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<!-- frecce: quella non utilizzabile viene nascosta (vedi .swiper-button-disabled) -->
		<div class="sp-swiper-nav">
			<button class="sp-swiper-btn sp-swiper-btn--prev" type="button" aria-label="<?php esc_attr_e( 'Slide precedente', 'stifanopassarelli' ); ?>">
				<svg viewBox="0 0 40 12" fill="none" aria-hidden="true"><path d="M40 6H1M1 6l6-5M1 6l6 5" stroke="currentColor" stroke-width="1"/></svg>
			</button>
			<button class="sp-swiper-btn sp-swiper-btn--next" type="button" aria-label="<?php esc_attr_e( 'Slide successiva', 'stifanopassarelli' ); ?>">
				<svg viewBox="0 0 40 12" fill="none" aria-hidden="true"><path d="M0 6h39M39 6l-6-5M39 6l-6 5" stroke="currentColor" stroke-width="1"/></svg>
			</button>
		</div>
	</div>
</section>

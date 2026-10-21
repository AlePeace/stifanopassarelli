<?php
/**
 * 01 — Hero / L'Incipit: video B/N a tutto schermo con parallasse
 * (initHero in utils/animations.js).
 *
 * @package stifanopassarelli
 */

?>
<section class="sp-hero" id="hero">
	<div class="sp-hero__media">
		<video autoplay muted loop playsinline poster="<?php echo esc_url( stifanopassarelli_field( 'home_hero_poster', stifanopassarelli_asset_url( 'img/hero/hero-poster.jpg' ) ) ); ?>">
			<source src="<?php echo esc_url( stifanopassarelli_field( 'home_hero_video', stifanopassarelli_asset_url( 'video/hero.mp4' ) ) ); ?>" type="video/mp4" />
		</video>
	</div>
	<div class="sp-hero__scrim"></div>
	<div class="sp-scrollcue">
		<span><?php stifanopassarelli_the_field( 'home_hero_cue', __( 'Entra nel segno', 'stifanopassarelli' ) ); ?></span>
		<span class="sp-scrollcue__line"></span>
	</div>
</section>

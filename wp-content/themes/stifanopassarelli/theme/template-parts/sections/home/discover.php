<?php
/**
 * 08 — Discover (le opere nel mondo): marquee infinito (initMarquee).
 *
 * @package stifanopassarelli
 */

?>
<section class="sp-section" id="discover">
	<div class="sp-container">
		<div class="sp-section__head">
			<span class="sp-label"><?php stifanopassarelli_the_field( 'home_discover_label', __( 'Discover', 'stifanopassarelli' ) ); ?></span>
			<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_discover_eyebrow', __( '06 — Le opere nel mondo', 'stifanopassarelli' ) ); ?></span>
		</div>
	</div>
	<div class="sp-marquee">
		<div class="sp-marquee__track">
			<?php foreach ( stifanopassarelli_lines( stifanopassarelli_field( 'home_discover_luoghi', __( "Positano\nPellare (SA)\nCarrara\nRavenna\nPietrasanta", 'stifanopassarelli' ) ) ) as $stifanopassarelli_luogo ) : ?>
				<span><?php echo esc_html( $stifanopassarelli_luogo ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>
</section>

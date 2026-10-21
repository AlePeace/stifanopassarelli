<?php
/**
 * Footer — "Umana è l'opera." (reveal righe in utils/footer.js).
 *
 * @package stifanopassarelli
 */

?>
<footer class="sp-footer">
	<div class="relative z-[2]">
		<p class="sp-footer__big" data-reveal-lines>
			<span class="line-mask"><span class="line-inner"><?php stifanopassarelli_the_setting( 'globale_footer_claim', __( "Umana è <em>l'opera.</em>", 'stifanopassarelli' ), true ); ?></span></span>
		</p>
		<div class="sp-footer__meta">
			<span><?php stifanopassarelli_the_setting( 'globale_footer_copyright', __( '© 2026 Stifano Passarelli — Sintonizzazione Scultorea e Musiva', 'stifanopassarelli' ) ); ?></span>
			<span><?php stifanopassarelli_the_setting( 'globale_footer_piva', __( 'P.IVA 00000000000', 'stifanopassarelli' ) ); ?></span>
			<span><?php stifanopassarelli_the_setting( 'globale_footer_credits', __( 'Credits · Bozza homepage', 'stifanopassarelli' ) ); ?></span>
		</div>
	</div>
</footer>

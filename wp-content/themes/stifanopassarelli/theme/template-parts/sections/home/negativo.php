<?php
/**
 * Negativo / materia (ref normalisboring): lente invertita che segue il
 * cursore; su touch si sposta al tap con l'etichetta "Click" (initNegative).
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_negativo = array(
	'src'   => 'img/manifesto/apr-03.jpg',
	'field' => 'home_negativo_immagine',
);
?>
<section class="sp-negative" aria-label="<?php esc_attr_e( 'La materia in negativo', 'stifanopassarelli' ); ?>">
	<?php stifanopassarelli_img( $stifanopassarelli_negativo + array( 'class' => 'sp-negative__img' ) ); ?>
	<?php stifanopassarelli_img( $stifanopassarelli_negativo + array( 'class' => 'sp-negative__inv' ) ); ?>
	<span class="sp-negative__hint" aria-hidden="true"><?php stifanopassarelli_the_field( 'home_negativo_lente', __( 'Click', 'stifanopassarelli' ) ); ?></span>
	<p class="sp-negative__cap font-serif text-[length:clamp(1.4rem,3vw,2.4rem)]">
		<?php stifanopassarelli_the_field( 'home_negativo_testo', __( 'La materia rivela il suo doppio.', 'stifanopassarelli' ) ); ?><br><span class="font-mono text-[.72rem] tracking-[.14em]"><span class="sp-only-desktop"><?php stifanopassarelli_the_field( 'home_negativo_hint_desktop', __( 'muovi — svela il negativo', 'stifanopassarelli' ) ); ?></span><span class="sp-only-touch"><?php stifanopassarelli_the_field( 'home_negativo_hint_touch', __( 'tocca — svela il negativo', 'stifanopassarelli' ) ); ?></span></span>
	</p>
</section>

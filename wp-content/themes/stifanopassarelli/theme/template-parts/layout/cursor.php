<?php
/**
 * Cursore custom: il pallino è il monogramma (solo desktop, vedi utils/cursor.js).
 *
 * @package stifanopassarelli
 */

?>
<div class="sp-cursor" aria-hidden="true">
	<?php get_template_part( 'template-parts/components/monogram', null, array( 'class' => 'sp-cursor__mono' ) ); ?>
	<span class="sp-cursor__label"><?php esc_html_e( 'Vedi', 'stifanopassarelli' ); ?></span>
</div>

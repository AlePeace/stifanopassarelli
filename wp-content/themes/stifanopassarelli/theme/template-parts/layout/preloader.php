<?php
/**
 * Preloader identità: la O (Emanuele) entra da sinistra, le tre tessere della
 * e (Carla) da destra e compongono il monogramma (utils/preloader.js).
 *
 * @package stifanopassarelli
 */

?>
<div class="sp-preloader">
	<div class="sp-preloader__stage">
		<div class="mono-merge">
			<?php
			get_template_part(
				'template-parts/components/monogram',
				null,
				array(
					'parts' => 'o',
					'class' => 'm-part m-o',
				)
			);
			get_template_part(
				'template-parts/components/monogram',
				null,
				array(
					'parts' => 'e',
					'class' => 'm-part m-e',
				)
			);
			?>
		</div>
	</div>
	<div class="sp-preloader__count">000</div>
</div>

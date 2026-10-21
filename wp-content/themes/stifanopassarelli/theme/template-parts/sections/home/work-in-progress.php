<?php
/**
 * 03 — Work in progress (svelamento, ref septiembre): binari infiniti di foto
 * dentro la sezione sticky, monogramma fisso al centro; a fine scroll alcune
 * foto dei binari compongono il collage (initVeil in utils/animations.js).
 *
 * `data-set` = cartella dello shooting della foto di default: initVeil la usa
 * per variare il collage.
 *
 * @package stifanopassarelli
 */

?>
<section class="sp-veil" id="work-in-progress">
	<div class="sp-veil__sticky">
		<div class="sp-veil__track" aria-hidden="true">
			<?php foreach ( stifanopassarelli_wip_columns() as $stifanopassarelli_col => $stifanopassarelli_column ) : ?>
				<div class="sp-veil__col <?php echo esc_attr( $stifanopassarelli_column['class'] ); ?>" data-speed="<?php echo esc_attr( $stifanopassarelli_column['speed'] ); ?>" data-dir="<?php echo esc_attr( $stifanopassarelli_column['dir'] ); ?>">
					<?php foreach ( $stifanopassarelli_column['foto'] as $stifanopassarelli_n => $stifanopassarelli_default ) : ?>
						<?php
						stifanopassarelli_img(
							array(
								'src'   => $stifanopassarelli_default,
								'field' => sprintf( 'home_wip_col_%d_foto_%d', $stifanopassarelli_col + 1, $stifanopassarelli_n + 1 ),
								'attrs' => array( 'data-set' => basename( dirname( $stifanopassarelli_default ) ) ),
							)
						);
						?>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="sp-veil__logo">
			<?php get_template_part( 'template-parts/components/monogram' ); ?>
		</div>
	</div>
</section>

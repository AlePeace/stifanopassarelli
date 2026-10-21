<?php
/**
 * 10 — Accademia (\\ FORMAZIONE & LABORATORIO): la scuola d'arte su fondo
 * chiaro, staccata dal resto del sito. Corsi, destinatari, sede, form di
 * richiesta info (Contact Form 7, shortcode nel campo `home_accademia_form`)
 * e FAQ. Copy di default in stifanopassarelli_accademia().
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_acc  = stifanopassarelli_accademia();
$stifanopassarelli_form = stifanopassarelli_field( 'home_accademia_form' );
?>
<section class="sp-section sp-academy" id="accademia">
	<div class="sp-container">
		<div class="sp-section__head">
			<span class="sp-label"><?php stifanopassarelli_the_field( 'home_accademia_label', $stifanopassarelli_acc['label'] ); ?></span>
			<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_accademia_eyebrow', $stifanopassarelli_acc['eyebrow'] ); ?></span>
		</div>

		<div class="sp-academy__intro">
			<div>
				<h2 class="sp-h2"><?php stifanopassarelli_the_field( 'home_accademia_titolo', nl2br( esc_html( $stifanopassarelli_acc['titolo'] ) ), true ); ?></h2>
				<p class="sp-academy__sub"><?php stifanopassarelli_the_field( 'home_accademia_sottotitolo', $stifanopassarelli_acc['sottotitolo'] ); ?></p>
			</div>
			<div class="sp-academy__text" data-fade>
				<?php foreach ( stifanopassarelli_lines( stifanopassarelli_field( 'home_accademia_intro', $stifanopassarelli_acc['intro'] ) ) as $stifanopassarelli_paragrafo ) : ?>
					<p><?php echo esc_html( $stifanopassarelli_paragrafo ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>

		<span class="sp-label sp-academy__block-label"><?php stifanopassarelli_the_field( 'home_accademia_corsi_label', $stifanopassarelli_acc['corsi_label'] ); ?></span>
		<div class="sp-academy__courses">
			<?php foreach ( $stifanopassarelli_acc['corsi'] as $stifanopassarelli_n => $stifanopassarelli_corso ) : ?>
				<?php $stifanopassarelli_titolo = stifanopassarelli_field( "home_accademia_corsi_{$stifanopassarelli_n}_titolo", $stifanopassarelli_corso['titolo'] ); ?>
				<article class="sp-academy__course">
					<div class="sp-slats aspect-[4/3]" data-slats="6">
						<?php
						stifanopassarelli_img(
							array(
								'src'   => $stifanopassarelli_corso['src'],
								'field' => "home_accademia_corsi_{$stifanopassarelli_n}_immagine",
								'alt'   => $stifanopassarelli_titolo,
								'class' => 'sp-slats__img',
								'attrs' => array( 'loading' => 'lazy' ),
							)
						);
						?>
						<div class="sp-slats__overlay"></div>
					</div>
					<span class="sp-academy__num"><?php echo esc_html( sprintf( '%02d', $stifanopassarelli_n ) ); ?></span>
					<h3 class="sp-academy__course-title"><?php echo esc_html( $stifanopassarelli_titolo ); ?></h3>
					<p class="sp-academy__teacher"><?php stifanopassarelli_the_field( "home_accademia_corsi_{$stifanopassarelli_n}_docente", $stifanopassarelli_corso['docente'] ); ?></p>
					<dl class="sp-academy__dl">
						<dt><?php esc_html_e( 'Cosa imparerai', 'stifanopassarelli' ); ?></dt>
						<dd><?php stifanopassarelli_the_field( "home_accademia_corsi_{$stifanopassarelli_n}_impara", $stifanopassarelli_corso['impara'] ); ?></dd>
						<dt><?php esc_html_e( 'A chi è rivolto', 'stifanopassarelli' ); ?></dt>
						<dd><?php stifanopassarelli_the_field( "home_accademia_corsi_{$stifanopassarelli_n}_rivolto", $stifanopassarelli_corso['rivolto'] ); ?></dd>
					</dl>
				</article>
			<?php endforeach; ?>
		</div>

		<div class="sp-academy__audience">
			<div>
				<span class="sp-label"><?php stifanopassarelli_the_field( 'home_accademia_destinatari_label', $stifanopassarelli_acc['destinatari_label'] ); ?></span>
				<p class="sp-academy__lead"><?php stifanopassarelli_the_field( 'home_accademia_destinatari_testo', $stifanopassarelli_acc['destinatari_testo'] ); ?></p>
			</div>
			<ul class="sp-academy__list">
				<?php foreach ( $stifanopassarelli_acc['destinatari'] as $stifanopassarelli_n => $stifanopassarelli_voce ) : ?>
					<li>
						<span class="sp-academy__list-title"><?php stifanopassarelli_the_field( "home_accademia_destinatari_{$stifanopassarelli_n}_titolo", $stifanopassarelli_voce['titolo'] ); ?></span>
						<span class="sp-academy__list-text"><?php stifanopassarelli_the_field( "home_accademia_destinatari_{$stifanopassarelli_n}_testo", $stifanopassarelli_voce['testo'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="sp-academy__contact">
			<div class="sp-academy__place">
				<span class="sp-label"><?php stifanopassarelli_the_field( 'home_accademia_sede_label', $stifanopassarelli_acc['sede_label'] ); ?></span>
				<h3 class="sp-academy__h3"><?php stifanopassarelli_the_field( 'home_accademia_sede_titolo', $stifanopassarelli_acc['sede_titolo'] ); ?></h3>
				<p class="sp-academy__lead"><?php stifanopassarelli_the_field( 'home_accademia_sede_testo', $stifanopassarelli_acc['sede_testo'] ); ?></p>
				<ul class="sp-academy__list">
					<?php foreach ( $stifanopassarelli_acc['sede'] as $stifanopassarelli_n => $stifanopassarelli_voce ) : ?>
						<li>
							<span class="sp-academy__list-title"><?php stifanopassarelli_the_field( "home_accademia_sede_{$stifanopassarelli_n}_titolo", $stifanopassarelli_voce['titolo'] ); ?></span>
							<span class="sp-academy__list-text"><?php stifanopassarelli_the_field( "home_accademia_sede_{$stifanopassarelli_n}_testo", $stifanopassarelli_voce['testo'] ); ?></span>
						</li>
					<?php endforeach; ?>
				</ul>
				<p class="sp-academy__links">
					<a href="<?php echo esc_url( stifanopassarelli_field( 'home_accademia_sede_mappa', $stifanopassarelli_acc['sede_mappa'] ) ); ?>" class="underline" target="_blank" rel="noopener"><?php esc_html_e( 'Apri la mappa', 'stifanopassarelli' ); ?></a>
					<?php foreach ( stifanopassarelli_socials() as $stifanopassarelli_social ) : ?>
						· <a href="<?php echo esc_url( $stifanopassarelli_social['href'] ); ?>" class="underline" target="_blank" rel="noopener"><?php echo esc_html( $stifanopassarelli_social['label'] ); ?></a>
					<?php endforeach; ?>
				</p>
			</div>

			<div class="sp-academy__form">
				<h3 class="sp-academy__h3"><?php stifanopassarelli_the_field( 'home_accademia_form_titolo', $stifanopassarelli_acc['form_titolo'] ); ?></h3>
				<p class="sp-academy__lead"><?php stifanopassarelli_the_field( 'home_accademia_form_testo', $stifanopassarelli_acc['form_testo'] ); ?></p>
				<?php
				if ( $stifanopassarelli_form ) {
					echo do_shortcode( $stifanopassarelli_form ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				?>
			</div>
		</div>

		<div class="sp-academy__faq">
			<span class="sp-label sp-academy__block-label"><?php stifanopassarelli_the_field( 'home_accademia_faq_label', $stifanopassarelli_acc['faq_label'] ); ?></span>
			<?php foreach ( $stifanopassarelli_acc['faq'] as $stifanopassarelli_n => $stifanopassarelli_faq ) : ?>
				<details class="sp-academy__qa">
					<summary><?php stifanopassarelli_the_field( "home_accademia_faq_{$stifanopassarelli_n}_domanda", $stifanopassarelli_faq['domanda'] ); ?></summary>
					<p><?php stifanopassarelli_the_field( "home_accademia_faq_{$stifanopassarelli_n}_risposta", $stifanopassarelli_faq['risposta'] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>

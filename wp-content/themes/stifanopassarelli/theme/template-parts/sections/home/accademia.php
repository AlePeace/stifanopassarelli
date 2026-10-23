<?php
/**
 * 10 — Accademia (\\ FORMAZIONE & LABORATORIO): la scuola d'arte su fondo
 * chiaro, staccata dal resto del sito. Sottotitolo che si svela parola per
 * parola, corsi in pannelli espandibili (come il Marmo, initPanels), marquee
 * dei punti chiave, destinatari a righe grandi, sede con le info pratiche in
 * accordion, form di richiesta info (Contact Form 7, shortcode nel campo
 * `home_accademia_form`) e FAQ. Copy di default in stifanopassarelli_accademia().
 *
 * @package stifanopassarelli
 */

$stifanopassarelli_acc   = stifanopassarelli_accademia();
$stifanopassarelli_form  = stifanopassarelli_field( 'home_accademia_form' );
$stifanopassarelli_words = preg_split( '/\s+/', trim( stifanopassarelli_field( 'home_accademia_sottotitolo', $stifanopassarelli_acc['sottotitolo'] ) ) );
?>
<section class="sp-section sp-academy" id="accademia">
	<div class="sp-container">
		<div class="sp-section__head">
			<span class="sp-label"><?php stifanopassarelli_the_field( 'home_accademia_label', $stifanopassarelli_acc['label'] ); ?></span>
			<span class="sp-eyebrow"><?php stifanopassarelli_the_field( 'home_accademia_eyebrow', $stifanopassarelli_acc['eyebrow'] ); ?></span>
		</div>

		<div class="sp-academy__intro">
			<h2 class="sp-h2"><?php stifanopassarelli_the_field( 'home_accademia_titolo', nl2br( esc_html( $stifanopassarelli_acc['titolo'] ) ), true ); ?></h2>
			<div>
				<p class="sp-academy__sub" data-reveal-words>
					<?php foreach ( $stifanopassarelli_words as $stifanopassarelli_word ) : ?>
						<span class="sp-reveal-word"><span><?php echo esc_html( $stifanopassarelli_word ); ?></span></span>
					<?php endforeach; ?>
				</p>
				<div class="sp-academy__text" data-fade>
					<?php foreach ( stifanopassarelli_lines( stifanopassarelli_field( 'home_accademia_intro', $stifanopassarelli_acc['intro'] ) ) as $stifanopassarelli_paragrafo ) : ?>
						<p><?php echo esc_html( $stifanopassarelli_paragrafo ); ?></p>
					<?php endforeach; ?>
				</div>
			</div>
		</div>

		<span class="sp-label sp-academy__block-label"><?php stifanopassarelli_the_field( 'home_accademia_corsi_label', $stifanopassarelli_acc['corsi_label'] ); ?></span>
		<div class="sp-panels sp-academy__courses">
			<?php foreach ( $stifanopassarelli_acc['corsi'] as $stifanopassarelli_n => $stifanopassarelli_corso ) : ?>
				<?php $stifanopassarelli_titolo = stifanopassarelli_field( "home_accademia_corsi_{$stifanopassarelli_n}_titolo", $stifanopassarelli_corso['titolo'] ); ?>
				<article class="sp-panel" data-cursor="view" data-cursor-label="<?php esc_attr_e( 'Apri', 'stifanopassarelli' ); ?>">
					<?php
					stifanopassarelli_img(
						array(
							'src'   => $stifanopassarelli_corso['src'],
							'field' => "home_accademia_corsi_{$stifanopassarelli_n}_immagine",
							'alt'   => $stifanopassarelli_titolo,
							'attrs' => array( 'loading' => 'lazy' ),
						)
					);
					?>
					<div class="sp-panel__meta">
						<span class="sp-panel__idx"><?php echo esc_html( sprintf( '%02d', $stifanopassarelli_n ) ); ?></span>
						<h3 class="sp-panel__name"><?php echo esc_html( $stifanopassarelli_titolo ); ?></h3>
						<div class="sp-panel__body">
							<p class="sp-academy__teacher"><?php stifanopassarelli_the_field( "home_accademia_corsi_{$stifanopassarelli_n}_docente", $stifanopassarelli_corso['docente'] ); ?></p>
							<p class="text-[.9rem] opacity-80"><?php stifanopassarelli_the_field( "home_accademia_corsi_{$stifanopassarelli_n}_impara", $stifanopassarelli_corso['impara'] ); ?></p>
							<p class="mt-3 font-mono text-[.68rem] leading-[1.7] tracking-[.06em] opacity-75"><?php stifanopassarelli_the_field( "home_accademia_corsi_{$stifanopassarelli_n}_rivolto", $stifanopassarelli_corso['rivolto'] ); ?></p>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="sp-marquee sp-academy__marquee">
		<div class="sp-marquee__track">
			<?php foreach ( stifanopassarelli_lines( stifanopassarelli_field( 'home_accademia_marquee', $stifanopassarelli_acc['marquee'] ) ) as $stifanopassarelli_punto ) : ?>
				<span><?php echo esc_html( $stifanopassarelli_punto ); ?></span>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="sp-container">
		<div class="sp-academy__audience">
			<div class="sp-academy__audience-head">
				<span class="sp-label"><?php stifanopassarelli_the_field( 'home_accademia_destinatari_label', $stifanopassarelli_acc['destinatari_label'] ); ?></span>
				<p class="sp-academy__lead"><?php stifanopassarelli_the_field( 'home_accademia_destinatari_testo', $stifanopassarelli_acc['destinatari_testo'] ); ?></p>
			</div>
			<ol class="sp-academy__who" data-fade>
				<?php foreach ( $stifanopassarelli_acc['destinatari'] as $stifanopassarelli_n => $stifanopassarelli_voce ) : ?>
					<li class="sp-academy__who-item">
						<span class="sp-academy__num"><?php echo esc_html( sprintf( '%02d', $stifanopassarelli_n ) ); ?></span>
						<span class="sp-academy__who-title"><?php stifanopassarelli_the_field( "home_accademia_destinatari_{$stifanopassarelli_n}_titolo", $stifanopassarelli_voce['titolo'] ); ?></span>
						<span class="sp-academy__who-text"><?php stifanopassarelli_the_field( "home_accademia_destinatari_{$stifanopassarelli_n}_testo", $stifanopassarelli_voce['testo'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>

		<div class="sp-academy__contact">
			<div class="sp-academy__place">
				<span class="sp-label"><?php stifanopassarelli_the_field( 'home_accademia_sede_label', $stifanopassarelli_acc['sede_label'] ); ?></span>
				<h3 class="sp-academy__h3"><?php stifanopassarelli_the_field( 'home_accademia_sede_titolo', $stifanopassarelli_acc['sede_titolo'] ); ?></h3>
				<p class="sp-academy__lead"><?php stifanopassarelli_the_field( 'home_accademia_sede_testo', $stifanopassarelli_acc['sede_testo'] ); ?></p>
				<div class="sp-academy__facts">
					<?php foreach ( $stifanopassarelli_acc['sede'] as $stifanopassarelli_n => $stifanopassarelli_voce ) : ?>
						<details class="sp-academy__qa sp-academy__qa--small">
							<summary><?php stifanopassarelli_the_field( "home_accademia_sede_{$stifanopassarelli_n}_titolo", $stifanopassarelli_voce['titolo'] ); ?></summary>
							<p><?php stifanopassarelli_the_field( "home_accademia_sede_{$stifanopassarelli_n}_testo", $stifanopassarelli_voce['testo'] ); ?></p>
						</details>
					<?php endforeach; ?>
				</div>
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

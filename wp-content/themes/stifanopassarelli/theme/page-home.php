<?php
/**
 * Template della homepage (pagina con slug `home`).
 *
 * Ordine delle sezioni come nel documento "Struttura One-Page".
 *
 * @package stifanopassarelli
 */

get_header();

$stifanopassarelli_home_sections = array(
	'hero',
	'manifesto',
	'work-in-progress',
	'il-rito',
	'negativo',
	'ordinarium',
	'antologia',
	'artisti',
	'discover',
	'contatti',
);
?>

	<main id="main" data-barba="container" data-barba-namespace="home">
		<?php
		foreach ( $stifanopassarelli_home_sections as $stifanopassarelli_section ) {
			get_template_part( 'template-parts/sections/home/' . $stifanopassarelli_section );
		}
		?>
	</main><!-- #main -->

<?php
get_footer();

<?php
/**
 * The template for displaying the footer
 *
 * Il footer resta fuori dal container Barba (globale), poi chiude il wrapper
 * `#page` aperto in header.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package stifanopassarelli
 */

?>

	<?php get_template_part( 'template-parts/layout/footer', 'content' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

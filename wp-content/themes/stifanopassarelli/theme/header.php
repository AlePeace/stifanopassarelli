<?php
/**
 * The header for our theme
 *
 * Elementi persistenti fuori dal container Barba: cursore custom, preloader
 * identità e header. Apre il wrapper Barba `#page`.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package stifanopassarelli
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<?php get_template_part( 'template-parts/layout/cursor' ); ?>

<?php get_template_part( 'template-parts/layout/preloader' ); ?>

<div id="page" data-barba="wrapper">
	<a href="#main" class="sr-only"><?php esc_html_e( 'Skip to content', 'stifanopassarelli' ); ?></a>

	<?php get_template_part( 'template-parts/layout/header', 'content' ); ?>

<?php
/**
 * stifanopassarelli functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package stifanopassarelli
 */

if ( ! defined( 'STIFANOPASSARELLI_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'STIFANOPASSARELLI_VERSION', '0.1.3' );
}

if ( ! defined( 'STIFANOPASSARELLI_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `stifanopassarelli_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'STIFANOPASSARELLI_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-ink'
	);
}

if ( ! function_exists( 'stifanopassarelli_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function stifanopassarelli_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on stifanopassarelli, use a find and replace
		 * to change 'stifanopassarelli' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'stifanopassarelli', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// Nav dell'header (voci lette da stifanopassarelli_nav_items()).
		register_nav_menus(
			array(
				'menu-1' => __( 'Header', 'stifanopassarelli' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'stifanopassarelli_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function stifanopassarelli_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'stifanopassarelli' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'stifanopassarelli' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'stifanopassarelli_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function stifanopassarelli_scripts() {
	wp_enqueue_style( 'stifanopassarelli-style', get_stylesheet_uri(), array(), STIFANOPASSARELLI_VERSION );
	wp_enqueue_script( 'stifanopassarelli-script', get_template_directory_uri() . '/js/script.min.js', array(), STIFANOPASSARELLI_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'stifanopassarelli_scripts' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function stifanopassarelli_tinymce_add_class( $settings ) {
	$settings['body_class'] = STIFANOPASSARELLI_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'stifanopassarelli_tinymce_add_class' );

/**
 * Tema classico: niente block editor per post e pagine.
 */
add_filter( 'use_block_editor_for_post', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

/**
 * Rimuove gli stili di Gutenberg e di theme.json dal front end, così la resa
 * resta identica al prototipo (es. `global-styles` sottolinea i link).
 */
function stifanopassarelli_dequeue_block_styles() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
}
add_action( 'wp_enqueue_scripts', 'stifanopassarelli_dequeue_block_styles', 100 );
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );

/**
 * Niente admin bar sul front end: sposterebbe l'header fixed e la sezione
 * sticky del Work in progress.
 */
add_filter( 'show_admin_bar', '__return_false' );

/**
 * Stampa un <img> del tema. Se il campo ACF immagine `field` (return format
 * url) è valorizzato sostituisce `src`, e da media library prende anche
 * width/height e alt; altrimenti resta il file in assets/.
 *
 * @param array $args {
 *     @type string $src     File in assets/ (fallback), es. `img/rito/rito-05.jpg`.
 *     @type string $field   Nome del campo ACF immagine.
 *     @type bool   $setting Legge `field` dalle impostazioni globali.
 *     @type string $alt     Alt di fallback.
 *     @type string $class   Classi.
 *     @type array  $attrs   Attributi extra; `true` = attributo senza valore.
 * }
 */
function stifanopassarelli_img( $args ) {
	$args = wp_parse_args(
		$args,
		array(
			'src'     => '',
			'field'   => '',
			'setting' => false,
			'alt'     => '',
			'class'   => '',
			'attrs'   => array(),
		)
	);

	$url    = $args['src'] ? stifanopassarelli_asset_url( $args['src'] ) : '';
	$alt    = $args['alt'];
	$width  = '';
	$height = '';

	if ( $args['field'] ) {
		$value = $args['setting'] ? stifanopassarelli_setting( $args['field'] ) : stifanopassarelli_field( $args['field'] );

		if ( $value ) {
			$url           = $value;
			$attachment_id = attachment_url_to_postid( $value );

			if ( $attachment_id ) {
				$image = wp_get_attachment_image_src( $attachment_id, 'full' );
				if ( $image ) {
					$width  = $image[1];
					$height = $image[2];
				}

				$media_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
				if ( $media_alt ) {
					$alt = $media_alt;
				}
			}
		}
	}

	$attributes = $args['attrs'] + array(
		'src'    => $url,
		'alt'    => $alt,
		'width'  => $width,
		'height' => $height,
		'class'  => $args['class'],
	);

	echo '<img' . stifanopassarelli_html_attrs( $attributes ) . ' />'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/**
 * Attributi HTML escapati. `true` = attributo senza valore, '' = omesso
 * (tranne `alt`, che resta anche vuoto).
 *
 * @param array $attributes Nome => valore.
 *
 * @return string
 */
function stifanopassarelli_html_attrs( $attributes ) {
	$html = '';
	foreach ( $attributes as $name => $value ) {
		if ( true === $value ) {
			$html .= ' ' . esc_attr( $name );
		} elseif ( 'alt' === $name || '' !== (string) $value ) {
			$html .= sprintf( ' %s="%s"', esc_attr( $name ), 'src' === $name ? esc_url( $value ) : esc_attr( $value ) );
		}
	}

	return $html;
}

/**
 * Campi ACF: helper di lettura e field group registrati via codice.
 */
require get_template_directory() . '/inc/acf-helpers.php';
require get_template_directory() . '/inc/acf-fields.php';

/**
 * CPT "Opere" + tassonomia "Collezioni" (Marmo, Mosaico, Antologia) e lettura
 * delle opere per la homepage, con la copy della bozza come fallback.
 */
require get_template_directory() . '/inc/opere.php';

/**
 * Accademia: copy di default della sezione e ritocchi a Contact Form 7.
 */
require get_template_directory() . '/inc/accademia.php';

/**
 * Pagine "Home" e "Impostazioni globali" create all'attivazione del tema.
 */
require get_template_directory() . '/inc/setup.php';

/**
 * Opere > Importa contenuti: opere e modulo dell'Accademia su un sito nuovo.
 */
if ( is_admin() ) {
	require get_template_directory() . '/inc/importer.php';
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

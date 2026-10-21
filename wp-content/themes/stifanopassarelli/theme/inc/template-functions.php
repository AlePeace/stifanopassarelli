<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package stifanopassarelli
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function stifanopassarelli_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'stifanopassarelli_pingback_header' );

/**
 * Changes comment form default fields.
 *
 * @param array $defaults The default comment form arguments.
 *
 * @return array Returns the modified fields.
 */
function stifanopassarelli_comment_form_defaults( $defaults ) {
	$comment_field = $defaults['comment_field'];

	// Adjust height of comment form.
	$defaults['comment_field'] = preg_replace( '/rows="\d+"/', 'rows="5"', $comment_field );

	return $defaults;
}
add_filter( 'comment_form_defaults', 'stifanopassarelli_comment_form_defaults' );

/**
 * Filters the default archive titles.
 */
function stifanopassarelli_get_the_archive_title() {
	if ( is_category() ) {
		$title = __( 'Category Archives: ', 'stifanopassarelli' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_tag() ) {
		$title = __( 'Tag Archives: ', 'stifanopassarelli' ) . '<span>' . single_term_title( '', false ) . '</span>';
	} elseif ( is_author() ) {
		$title = __( 'Author Archives: ', 'stifanopassarelli' ) . '<span>' . get_the_author_meta( 'display_name' ) . '</span>';
	} elseif ( is_year() ) {
		$title = __( 'Yearly Archives: ', 'stifanopassarelli' ) . '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'stifanopassarelli' ) ) . '</span>';
	} elseif ( is_month() ) {
		$title = __( 'Monthly Archives: ', 'stifanopassarelli' ) . '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'stifanopassarelli' ) ) . '</span>';
	} elseif ( is_day() ) {
		$title = __( 'Daily Archives: ', 'stifanopassarelli' ) . '<span>' . get_the_date() . '</span>';
	} elseif ( is_post_type_archive() ) {
		$cpt   = get_post_type_object( get_queried_object()->name );
		$title = sprintf(
			/* translators: %s: Post type singular name */
			esc_html__( '%s Archives', 'stifanopassarelli' ),
			$cpt->labels->singular_name
		);
	} elseif ( is_tax() ) {
		$tax   = get_taxonomy( get_queried_object()->taxonomy );
		$title = sprintf(
			/* translators: %s: Taxonomy singular name */
			esc_html__( '%s Archives', 'stifanopassarelli' ),
			$tax->labels->singular_name
		);
	} else {
		$title = __( 'Archives:', 'stifanopassarelli' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'stifanopassarelli_get_the_archive_title' );

/**
 * Determines whether the post thumbnail can be displayed.
 */
function stifanopassarelli_can_show_post_thumbnail() {
	return apply_filters( 'stifanopassarelli_can_show_post_thumbnail', ! post_password_required() && ! is_attachment() && has_post_thumbnail() );
}

/**
 * Returns the size for avatars used in the theme.
 */
function stifanopassarelli_get_avatar_size() {
	return 60;
}

/**
 * Create the continue reading link
 *
 * @param string $more_string The string shown within the more link.
 */
function stifanopassarelli_continue_reading_link( $more_string ) {

	if ( ! is_admin() ) {
		$continue_reading = sprintf(
			/* translators: %s: Name of current post. */
			wp_kses( __( 'Continue reading %s', 'stifanopassarelli' ), array( 'span' => array( 'class' => array() ) ) ),
			the_title( '<span class="sr-only">"', '"</span>', false )
		);

		$more_string = '<a href="' . esc_url( get_permalink() ) . '">' . $continue_reading . '</a>';
	}

	return $more_string;
}

// Filter the excerpt more link.
add_filter( 'excerpt_more', 'stifanopassarelli_continue_reading_link' );

// Filter the content more link.
add_filter( 'the_content_more_link', 'stifanopassarelli_continue_reading_link' );

/**
 * Outputs a comment in the HTML5 format.
 *
 * This function overrides the default WordPress comment output in HTML5
 * format, adding the required class for Tailwind Typography. Based on the
 * `html5_comment()` function from WordPress core.
 *
 * @param WP_Comment $comment Comment to display.
 * @param array      $args    An array of arguments.
 * @param int        $depth   Depth of the current comment.
 */
function stifanopassarelli_html5_comment( $comment, $args, $depth ) {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';

	$commenter          = wp_get_current_commenter();
	$show_pending_links = ! empty( $commenter['comment_author'] );

	if ( $commenter['comment_author_email'] ) {
		$moderation_note = __( 'Your comment is awaiting moderation.', 'stifanopassarelli' );
	} else {
		$moderation_note = __( 'Your comment is awaiting moderation. This is a preview; your comment will be visible after it has been approved.', 'stifanopassarelli' );
	}
	?>
	<<?php echo esc_attr( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( $comment->has_children ? 'parent' : '', $comment ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
					if ( 0 !== $args['avatar_size'] ) {
						echo get_avatar( $comment, $args['avatar_size'] );
					}
					?>
					<?php
					$comment_author = get_comment_author_link( $comment );

					if ( '0' === $comment->comment_approved && ! $show_pending_links ) {
						$comment_author = get_comment_author( $comment );
					}

					printf(
						/* translators: %s: Comment author link. */
						wp_kses_post( __( '%s <span class="says">says:</span>', 'stifanopassarelli' ) ),
						sprintf( '<b class="fn">%s</b>', wp_kses_post( $comment_author ) )
					);
					?>
				</div><!-- .comment-author -->

				<div class="comment-metadata">
					<?php
					printf(
						'<a href="%s"><time datetime="%s">%s</time></a>',
						esc_url( get_comment_link( $comment, $args ) ),
						esc_attr( get_comment_time( 'c' ) ),
						esc_html(
							sprintf(
							/* translators: 1: Comment date, 2: Comment time. */
								__( '%1$s at %2$s', 'stifanopassarelli' ),
								get_comment_date( '', $comment ),
								get_comment_time()
							)
						)
					);

					edit_comment_link( __( 'Edit', 'stifanopassarelli' ), ' <span class="edit-link">', '</span>' );
					?>
				</div><!-- .comment-metadata -->

				<?php if ( '0' === $comment->comment_approved ) : ?>
				<em class="comment-awaiting-moderation"><?php echo esc_html( $moderation_note ); ?></em>
				<?php endif; ?>
			</footer><!-- .comment-meta -->

			<div <?php stifanopassarelli_content_class( 'comment-content' ); ?>>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<?php
			if ( '1' === $comment->comment_approved || $show_pending_links ) {
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						)
					)
				);
			}
			?>
		</article><!-- .comment-body -->
	<?php
}


/**
 * URL di un file del tema in `assets/` (es. `img/rito/rito-05.jpg`).
 *
 * @param string $file Path relativo ad assets/.
 *
 * @return string
 */
function stifanopassarelli_asset_url( $file ) {
	return get_template_directory_uri() . '/assets/' . $file;
}

/**
 * Link a una sezione della homepage: `#id` sulla home (lo gestisce Lenis),
 * URL della home + `#id` dalle altre pagine.
 *
 * @param string $id Id della sezione, senza `#`.
 *
 * @return string
 */
function stifanopassarelli_home_anchor( $id ) {
	return ( is_front_page() ? '' : home_url( '/' ) ) . '#' . $id;
}

/**
 * Voci della nav dell'header: dal menu assegnato alla posizione "Header" se
 * c'è, altrimenti le ancore della bozza.
 *
 * @return array[] Ogni voce ha `href` e `label`.
 */
function stifanopassarelli_nav_items() {
	$locations = get_nav_menu_locations();

	if ( ! empty( $locations['menu-1'] ) ) {
		$menu_items = wp_get_nav_menu_items( $locations['menu-1'] );

		if ( $menu_items ) {
			return array_map(
				function ( $item ) {
					return array(
						'href'  => $item->url,
						'label' => $item->title,
					);
				},
				array_filter(
					$menu_items,
					function ( $item ) {
						return ! $item->menu_item_parent;
					}
				)
			);
		}
	}

	return array(
		array(
			'href'  => stifanopassarelli_home_anchor( 'sintonizzazione' ),
			'label' => __( 'Sintonizzazione', 'stifanopassarelli' ),
		),
		array(
			'href'  => stifanopassarelli_home_anchor( 'work-in-progress' ),
			'label' => __( 'Work in progress', 'stifanopassarelli' ),
		),
		array(
			'href'  => stifanopassarelli_home_anchor( 'marmo' ),
			'label' => __( 'Catalogo', 'stifanopassarelli' ),
		),
		array(
			'href'  => stifanopassarelli_home_anchor( 'artisti' ),
			'label' => __( 'Emanuele & Carla', 'stifanopassarelli' ),
		),
		array(
			'href'  => stifanopassarelli_home_anchor( 'accademia' ),
			'label' => __( 'Accademia', 'stifanopassarelli' ),
		),
		array(
			'href'  => stifanopassarelli_home_anchor( 'contatti' ),
			'label' => __( 'Contatti', 'stifanopassarelli' ),
		),
	);
}

/**
 * Righe non vuote di un campo textarea (una voce per riga).
 *
 * @param string $text Testo.
 *
 * @return string[]
 */
function stifanopassarelli_lines( $text ) {
	return array_values( array_filter( array_map( 'trim', preg_split( '/\R/', (string) $text ) ) ) );
}

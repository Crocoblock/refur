<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package refur
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function refur_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'refur_body_classes' );

/**
 * Get allowed socials data (to add options into customizer and output on front)
 */
function refur_allowed_socials() {

	return apply_filters(
		'refur_allowed_socials',
		array(
			'facebook' => array(
				'label'   => __( 'Facebook', 'refur' ),
				'icon'    => 'fa fa-facebook',
				'default' => 'https://www.facebook.com/',
			),
			'twitter' => array(
				'label'   => __( 'Twitter', 'refur' ),
				'icon'    => 'fa fa-twitter',
				'default' => 'https://twitter.com/',
			),
			'google-plus' => array(
				'label'   => __( 'Google +', 'refur' ),
				'icon'    => 'fa fa-google-plus',
				'default' => 'https://plus.google.com/',
			),
			'instagram' => array(
				'label'   => __( 'Instagram', 'refur' ),
				'icon'    => 'fa fa-instagram',
				'default' => 'https://instagram.com/',
			),
			'pinterest' => array(
				'label'   => __( 'Pinterest', 'refur' ),
				'icon'    => 'fa fa-pinterest',
				'default' => 'https://www.pinterest.com/',
			),
			'dribbble' => array(
				'label'   => __( 'Dribbble', 'refur' ),
				'icon'    => 'fa fa-dribbble',
				'default' => 'https://dribbble.com/',
			)
		)
	);

}

/**
 * Define defaul featured content settings
 *
 * @return array
 */
function refur_featured_sections() {

	return apply_filters(
		'refur_default_featured_sections',
		array(
			'section_1' => array(
				'title'   => __( 'Translation Ready', 'refur' ),
				'icon'    => 'globe',
				'content' => __( 'All theme strings are ready to be translated. You can add your personal translation in several minutes.', 'refur' ),
			),
			'section_2' => array(
				'title'   => __( 'Custom Settings', 'refur' ),
				'icon'    => 'cogs',
				'content' => __( 'All theme settings are implemented into the native WordPress customizer - all you need is here, in one place.', 'refur' ),
			),
			'section_3' => array(
				'title'   => __( 'Great Support', 'refur' ),
				'icon'    => 'life-ring',
				'content' => __( 'We\'ll help you to resolve any issue you may face with while working with the theme.', 'refur' ),
			),
		)
	);

}

/**
 * Add featured content box to home page
 */
add_action( 'refur_featured_content', 'refur_featured_content_box' );
function refur_featured_content_box() {

	if ( ! is_front_page() || ! is_page_template( 'home-page.php' ) ) {
		return;
	}

	if ( is_home() ) {
		return;
	}

	$featured_content = refur_get_option( 'featured_content' );
	$content          = '';
	$active_sections  = 0;

	foreach ( refur_featured_sections() as $section => $data ) {

		$curr_section = '';

		if ( ! isset( $featured_content[ $section ] ) ) {
			$curr_section .= refur_prepare_section_content( $data );
		} else {
			$user_data     = array_merge( $data, $featured_content[ $section ] );
			$curr_section .= refur_prepare_section_content( $user_data );
		}

		if ( empty( $curr_section ) ) {
			continue;
		}

		$content .= '<div class="%1$s col-xs-12"><div class="featured-box">' . $curr_section . '</div></div>';
		$active_sections++;

	}

	if ( 0 === $active_sections ) {
		return;
	}

	$columns   = ceil( 12 / $active_sections );
	$col_class = 'col-md-' . $columns . ' col-sm-' . $columns;

	printf(
		'<div class="featured-content-box"><div class="container"><div class="row">'.$content.'</div></div></div>',
		esc_attr( $col_class )
	);

}

/**
 * Reurn prepare current section HTML content by passed data
 *
 * @param  array $data input data.
 * @return string
 */
function refur_prepare_section_content( $data ) {

	$content = '';

	if ( ! empty( $data['icon'] ) ) {

		if ( false === strpos( $data['icon'], 'fa-') ) {
			$data['icon'] = 'fa-' . $data['icon'];
		}

		$content .= sprintf(
			'<div class="featured-box-icon"><i class="fa %s"></i></div>',
			esc_attr( $data['icon'] )
		);
	}

	if ( ! empty( $data['title'] ) ) {
		$content .= sprintf(
			'<h3 class="featured-box-title">%s</h3>',
			esc_textarea( $data['title'] )
		);
	}

	if ( ! empty( $data['content'] ) ) {
		$content .= sprintf(
			'<div class="featured-box-content">%s</div>',
			wp_kses_post( $data['content'] )
		);
	}

	return $content;

}

/**
 * Custom comment output
 */
function refur_comment( $comment, $args, $depth ) {

	if ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<div class="comment-body">
			<?php _e( 'Pingback:', 'refur' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'refur' ), '<span class="edit-link">', '</span>' ); ?>
		</div>

	<?php else : ?>

	<li id="comment-<?php comment_ID(); ?>" <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?>>
		<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
			<div class="comment-meta">
				<div class="comment-author-thumb">
					<?php echo get_avatar( $comment, 40 ); ?>
				</div><!-- .comment-author -->
				<?php printf( '<div class="comment-author">%s</div>', get_comment_author_link() ); ?>
				<time datetime="<?php comment_time( 'c' ); ?>">
					<?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' ' . __( 'ago', 'refur' ); ?>
				</time>
				<?php
					comment_reply_link(
						array_merge( $args, array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
						) ),
						$comment
					);
				?>
			</div>
			<div class="comment-content">
				<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'refur' ); ?></p>
				<?php endif; ?>
				<?php comment_text(); ?>
			</div><!-- .comment-content -->
		</article><!-- .comment-body -->

	<?php
	endif;

}

/**
 * Modify comment form default fields
 */
add_filter( 'comment_form_default_fields', 'refur_comment_form_fields' );
function refur_comment_form_fields( $fields ) {

	$req       = get_option( 'require_name_email' );
	$html5     = 'html5';
	$commenter = wp_get_current_commenter();
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	$fields = array(
		'author' => '<p class="comment-form-author"><input class="comment-form-input" id="author" name="author" type="text" placeholder="' . __( 'Name', 'refur' ) . ( $req ? '*' : '' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
		'email'  => '<p class="comment-form-email"><input class="comment-form-input" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' placeholder="' . __( 'Email', 'refur' ) . ( $req ? '*' : '' ) . '" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
		'url'    => '<p class="comment-form-url"><input class="comment-form-input" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' placeholder="' . __( 'Website', 'refur' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>'
	);

	return $fields;
}

/**
 * Add sticky class to sticky post on Posts With Featured Content page template
 */
add_filter( 'post_class', 'refur_add_sticky_class' );
function refur_add_sticky_class( $classes ) {

	if ( is_sticky() && is_page_template( 'home-page.php' ) ) {
		$classes[] = 'sticky';
	}

	return $classes;
}

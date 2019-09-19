<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package refur
 */

if ( ! function_exists( 'refur_logo' ) ) :
/**
 * Print site logo
 */
function refur_logo() {

	$logo_img = refur_get_option( 'logo_img' );
	$link     = esc_url( home_url( '/' ) );

	if ( ! $logo_img ) {
		$class   = 'text-logo';
		$content = get_bloginfo( 'name' );
	} else {
		$class = 'image-logo';
		$content = sprintf( '<img src="%s" alt="%s">', esc_url( $logo_img ), esc_attr( get_bloginfo( 'name' ) ) );
	}

	if ( is_home() || is_front_page() ) {
		$tag = 'h1';
	} else {
		$tag = 'h2';
	}

	printf(
		'<%1$s class="site-title"><a href="%2$s" class="%3$s" rel="home">%4$s</a></%1$s>',
		$tag, esc_url( $link ), $class, $content
	);
}
endif;

/**
 * Show post author
 */
function refur_post_author() {

	$id = get_the_author_meta( 'ID' );

	$author = sprintf(
		'<span class="author"><a href="%1$s">%2$s</a></span>',
		esc_url( get_author_posts_url( $id ) ),
		esc_html( get_the_author() )
	);

	echo '<span class="entry-meta-item author">' . $author . '</span>';
}

/**
 * Prints HTML with meta information for the current post-date.
 */
function refur_post_date() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	echo '<span class="entry-meta-item posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}

/**
 * Prints HTML with meta information for the current post-date.
 */
function refur_post_comments() {

	if ( post_password_required() || ! comments_open() ) {
		return;
	}

	echo '<span class="entry-meta-item comments">';
	comments_popup_link( esc_html__( 'Leave a comment', 'refur' ), esc_html__( '1 Comment', 'refur' ), esc_html__( '% Comments', 'refur' ) );
	echo '</span>';

}

function refur_post_categories() {

	// Hide category and tag text for pages.
	if ( 'post' != get_post_type() ) {
		return;
	}

	$categories_list = get_the_category_list( esc_html__( ', ', 'refur' ) );
	if ( $categories_list && refur_categorized_blog() ) {
		printf( '<span class="entry-meta-item cat-links"><i class="fa fa-folder-open"></i> ' . esc_html__( 'Posted in %1$s', 'refur' ) . '</span>', $categories_list ); // WPCS: XSS OK.
	}

}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function refur_post_tags() {
	// Hide category and tag text for pages.
	if ( 'post' != get_post_type() ) {
		return;
	}

	$tags_list = get_the_tag_list( '', esc_html__( ', ', 'refur' ) );
	if ( $tags_list ) {
		printf( '<span class="entry-meta-item tags-links"><i class="fa fa-tags"></i> ' . esc_html__( 'Tagged %1$s', 'refur' ) . '</span>', $tags_list ); // WPCS: XSS OK.
	}

}

if ( ! function_exists( 'refur_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function refur_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'refur' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'refur' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'refur_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function refur_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'refur' ) );
		if ( $categories_list && refur_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'refur' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'refur' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'refur' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'refur' ), esc_html__( '1 Comment', 'refur' ), esc_html__( '% Comments', 'refur' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'refur' ), '<span class="edit-link">', '</span>' );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function refur_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'refur_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'refur_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so refur_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so refur_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in refur_categorized_blog.
 */
function refur_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'refur_categories' );
}
add_action( 'edit_category', 'refur_category_transient_flusher' );
add_action( 'save_post',     'refur_category_transient_flusher' );

/**
 * Print social follow list
 */
function refur_follow_list() {

	$socials = refur_allowed_socials();

	if ( ! is_array( $socials ) ) {
		return;
	}

	$social_list = '';
	$item_format = '<div class="follow-list_item"><a href="%1$s" class="item-%3$s"><i class="%2$s"></i></a></div>';

	foreach ( $socials as $net => $data ) {

		$data = wp_parse_args( $data, array( 'label' => '', 'icon' => '', 'default' => '' ) );
		$url  = refur_get_option( 'follow_' . $net, $data['default'] );

		if ( ! $url ) {
			continue;
		}

		$social_list .= sprintf( $item_format, esc_url( $url ), esc_attr( $data['icon'] ), esc_attr( $net ) );

	}

	if ( empty( $social_list ) ) {
		return;
	}

	printf( '<div class="follow-list">%s</div>', $social_list );
}

/**
 * Show post featured image
 * @param  boolean $is_linked liked image or not
 */
function refur_post_thumbnail( $is_linked = true ) {

	if ( ! has_post_thumbnail() ) {
		return;
	}

	$is_enabled = true;

	if ( is_single() ) {
		$is_enabled = refur_get_option( 'blog_single_image', true );
	} else {
		$is_enabled = refur_get_option( 'blog_loop_image', true );
	}

	$is_enabled = (bool)$is_enabled;

	if ( ! $is_enabled ) {
		return;
	}

	if ( $is_linked ) {
		$format = '<figure class="entry-thumbnail"><a href="%2$s">%1$s<span class="link-marker"></span></a></figure>';
		$link   = get_permalink();
	} else {
		$format = '<figure class="entry-thumbnail">%1$s</figure>';
		$link   = false;
	}

	$size = 'post-thumbnail';

	if ( ( is_sticky() && ! is_paged() ) || is_single() ) {
		$size = 'refur-sticky';
	}

	$image = get_the_post_thumbnail( get_the_id(), $size, array( 'alt' => get_the_title() ) );

	printf( $format, $image, $link );

}

/**
 * Show posts listing content depending from options
 */
function refur_blog_content() {

	if ( has_excerpt() ) {
		the_excerpt();
		return;
	}

	$text = get_the_content();
	$text = strip_shortcodes( $text );
	$text = apply_filters( 'the_content', $text );
	$text = str_replace(']]>', ']]&gt;', $text);

	$excerpt_length = 20;

	if ( ! has_post_thumbnail() ) {
		$loop_image = refur_get_option( 'blog_loop_image', '1' );
		$excerpt_length = ( ! $loop_image ) ? 20 : 100;
	}

	echo wp_trim_words( $text, $excerpt_length, '...' );

}

/**
 * Show post meta data
 *
 * @param string $page     page, meta called from
 * @param string $position position, meta called from
 * @param string $disable  disabled meta keys array
 */
function refur_post_meta( $page = 'loop', $position = 'header', $disable = array() ) {

	$default_meta = array(
		'author' => array(
			'page'     => $page,
			'position' => 'header',
			'callback' => 'refur_post_author',
			'priority' => 1,
		),
		'date' => array(
			'page'     => $page,
			'position' => 'header',
			'callback' => 'refur_post_date',
			'priority' => 5,
		),
		'comments' => array(
			'page'     => $page,
			'position' => 'header',
			'callback' => 'refur_post_comments',
			'priority' => 5,
		),
		'categories' => array(
			'page'     => 'single',
			'position' => 'footer',
			'callback' => 'refur_post_categories',
			'priority' => 1,
		),
		'tags' => array(
			'page'     => 'single',
			'position' => 'footer',
			'callback' => 'refur_post_tags',
			'priority' => 5,
		)
	);

	/**
	 * Get 3rd party meta items to show in meta block (or disable default from child theme)
	 */
	$meta_items = apply_filters( 'refur_meta_items_data', $default_meta, $page, $position );
	$disable    = apply_filters( 'refur_disabled_meta', $disable );

	foreach ( $meta_items as $meta_key => $data ) {

		if ( is_array( $disable ) && in_array( $meta_key, $disable ) ) {
			continue;
		}
		if ( empty( $data['page'] ) || $page != $data['page'] ) {
			continue;
		}
		if ( empty( $data['position'] ) || $position != $data['position'] ) {
			continue;
		}
		if ( empty( $data['callback'] ) || ! function_exists( $data['callback'] ) ) {
			continue;
		}

		$priority = ( ! empty( $data['priority'] ) ) ? absint( $data['priority'] ) : 10;

		add_action( 'refur_post_meta_' . $page . '_' . $position, $data['callback'], $priority );
	}

	do_action( 'refur_post_meta_' . $page . '_' . $position );

}

/**
 * Show read more button if enabled
 */
function refur_read_more() {

	if ( post_password_required() ) {
		return;
	}

	$is_enabled = refur_get_option( 'blog_more', true );

	$is_enabled = (bool)$is_enabled;

	if ( ! $is_enabled ) {
		return;
	}

	$text = refur_get_option( 'blog_more_text', __( 'Read More', 'refur' ) );

	printf( '<div class="etry-more-btn"><a href="%1$s" class="read-more">%2$s</a></div>', esc_url( get_permalink() ), esc_textarea( $text ) );

}

/**
 * Custom posts navigation function
 */
function refur_posts_navigation( $args ) {

	$format     = '<span class="nav-links-label">%s</span>';
	$prev_label = sprintf( $format, __( 'Prev', 'refur' ) );
	$next_label = sprintf( $format, __( 'Next', 'refur' ) );

	$args = wp_parse_args( $args, array(
		'prev_text'          => $prev_label . '<span class="nav-links-title">%title</span>',
		'next_text'          => $next_label . '<span class="nav-links-title">%title</span>',
		'screen_reader_text' => __( 'Post navigation', 'refur' ),
	) );

	$navigation = '';
	$previous   = get_previous_post_link( '%link', $args['prev_text'] );
	$next       = get_next_post_link( '%link', $args['next_text'] );

	// Only add markup if there's somewhere to navigate to.
	if ( ! $previous && ! $next ) {
		return;
	}

	$navigation = _navigation_markup( $previous . $next, 'post-navigation', $args['screen_reader_text'] );

	echo $navigation;
}

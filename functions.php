<?php
/**
 * refur functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package refur
 */

if ( ! function_exists( 'refur_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function refur_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on refur, use a find and replace
	 * to change 'refur' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'refur', get_template_directory() . '/languages' );

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

	set_post_thumbnail_size( 340, 210, true );

	add_image_size( 'refur-sticky', 710, 210, true );
	add_image_size( 'refur-showcase', 2000, 750, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'refur' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'gallery',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'refur_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

}
endif; // refur_setup
add_action( 'after_setup_theme', 'refur_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function refur_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'refur_content_width', 640 );
}
add_action( 'after_setup_theme', 'refur_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function refur_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Main', 'refur' ),
		'id'            => 'sidebar-main',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Footer', 'refur' ),
		'id'            => 'sidebar-footer',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget col-sm-12 col-xs-12 col-md-4 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'refur_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function refur_scripts() {

	$base_url = get_template_directory_uri();

	wp_enqueue_style( 'refur-fonts', refur_fonts_url() );
	wp_enqueue_style( 'refur-font-awesome', $base_url . '/css/font-awesome.min.css', false, '4.4.0' );
	wp_enqueue_style( 'refur-style', get_stylesheet_uri() );

	wp_enqueue_script( 'refur-slick-slider', $base_url . '/js/slick.js', array( 'jquery' ), '1.5.0', true );
	wp_enqueue_script( 'refur-magnific-popup', $base_url . '/js/magnific-popup.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'refur-scripts', $base_url . '/js/script.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'refur-skip-link-focus-fix', $base_url . '/js/skip-link-focus-fix.js', array(), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'refur_scripts' );

/**
 * Get necessary Google fonts URL
 */
function refur_fonts_url() {

	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Poppins, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$poppins = _x( 'on', 'Poppins font: on or off', 'refur' );

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Roboto, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto = _x( 'on', 'Roboto font: on or off', 'refur' );

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Roboto, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$lora = _x( 'on', 'Lora font: on or off', 'refur' );

	/**
	 * Translators: Set Roboto and Lora subset for your language.
	 */
	$subset = _x( 'latin,latin-ext', 'Set subset for you language more info here - https://www.google.com/fonts/', 'refur' );

	if ( false == strpos( $subset , 'latin' ) ) {
		$subset = 'latin,' . $subset;
	}

	if ( 'off' == $poppins && 'off' == $roboto && 'off' == $lora ) {
		return $fonts_url;
	}

	$font_families = array();

	if ( 'off' !== $poppins ) {
		$font_families[] = 'Poppins:400,700';
	}

	if ( 'off' !== $roboto ) {
		$font_families[] = 'Roboto:300,400';
	}

	if ( 'off' !== $lora ) {
		$font_families[] = 'Lora:400,400italic,700,700italic';
	}

	$query_args = array(
		'family' => urlencode( implode( '|', $font_families ) ),
		'subset' => urlencode( $subset ),
	);

	$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );

	return $fonts_url;
}

/**
 * Get theme option by name
 *
 * @param  string $name    option name
 * @param  mixed  $default default option value
 */
function refur_get_option( $name, $default = false ) {

	$all_options = get_theme_mod( 'refur' );

	if ( is_array( $all_options ) && isset( $all_options[ $name ] ) ) {
		return $all_options[ $name ];
	}

	return $default;

}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Post format specific template tags
 */
require get_template_directory() . '/inc/template-post-formats.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

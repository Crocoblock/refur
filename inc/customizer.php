<?php
/**
 * Refur Theme Customizer.
 *
 * @package Refur
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function refur_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'refur_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function refur_customize_preview_js() {
	wp_enqueue_script( 'refur_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'refur_customize_preview_js' );

/**
 * Adds Refur-related customizer elements
 *
 * WordPress 3.4 Required
 */
add_action( 'customize_register', 'refur_add_customizer' );

if ( ! function_exists( 'refur_add_customizer' ) ) {

	/**
	 * Add customizer controls for Refur theme
	 *
	 * @param  object $wp_customize customizer object instance
	 */
	function refur_add_customizer( $wp_customize ) {

		/* Header Logo section
		---------------------------------------------------------*/
		$wp_customize->add_section( 'refur_header_logo' , array(
			'title'      => __('Header Logo','refur'),
			'priority'   => 40,
		) );

		/* Logo image */
		$wp_customize->add_setting( 'refur[logo_img]', array(
				'default'           => '',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'refur_sanitize_image',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'refur_logo_img', array(
			'label'    => __( 'Logo Image', 'refur' ),
			'section'  => 'refur_header_logo',
			'settings' => 'refur[logo_img]',
			'priority' => 1,
		) ) );

		/* Fetured content section
		---------------------------------------------------------*/
		$wp_customize->add_section( 'refur_featured_content' , array(
			'title'      => __('Featured Content','refur'),
			'priority'   => 41,
		) );

		$fa_descr_format = __( 'Set icon from FontAwesome icons (pass only icon slug, e.q. cogs or fa-cogs, avaliabe icons you can find %s)', 'refur' );
		$fa_link         = sprintf( '<a href="%1$s">%2$s</a>', 'https://fortawesome.github.io/Font-Awesome/icons/', __( 'here', 'refur' ) );
		$fa_descr        = sprintf( $fa_descr_format, $fa_link );
		$count           = 0;

		foreach ( refur_featured_sections() as $section => $data ) {

			$count++;

			$title_setting   = 'refur[featured_content][' . $section . '][title]';
			$icon_setting    = 'refur[featured_content][' . $section . '][icon]';
			$content_setting = 'refur[featured_content][' . $section . '][content]';

			// Title
			$wp_customize->add_setting( $title_setting, array(
					'default'           => $data['title'],
					'type'              => 'theme_mod',
					'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( refur_control_id_from_settings( $title_setting ), array(
					'label'       => sprintf( __( 'Section %s title', 'refur' ), $count ),
					'section'     => 'refur_featured_content',
					'settings'    => $title_setting,
					'type'        => 'text',
			) );

			// Icon
			$wp_customize->add_setting( $icon_setting, array(
					'default'           => $data['icon'],
					'type'              => 'theme_mod',
					'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( refur_control_id_from_settings( $icon_setting ), array(
					'label'       => sprintf( __( 'Section %s icon', 'refur' ), $count ),
					'description' => $fa_descr,
					'section'     => 'refur_featured_content',
					'settings'    => $icon_setting,
					'type'        => 'text',
			) );

			// Content
			$wp_customize->add_setting( $content_setting, array(
					'default'           => $data['content'],
					'type'              => 'theme_mod',
					'sanitize_callback' => 'wp_kses_post',
			) );
			$wp_customize->add_control( refur_control_id_from_settings( $content_setting ), array(
					'label'       => sprintf( __( 'Section %s content', 'refur' ), $count ),
					'section'     => 'refur_featured_content',
					'settings'    => $content_setting,
					'type'        => 'textarea',
			) );

		}

		/* Blog section
		----------------------------------------------------*/
		$wp_customize->add_section( 'refur_blog' , array(
			'title'      => __('Blog','refur'),
			'priority'   => 62,
		) );

		/* Loop featured image */
		$wp_customize->add_setting( 'refur[blog_loop_image]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'refur_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'refur_blog_loop_image', array(
				'label'    => __( 'Loop page: show featured image', 'refur' ),
				'section'  => 'refur_blog',
				'settings' => 'refur[blog_loop_image]',
				'type'     => 'checkbox',
				'priority' => 2,
		) );

		/* Single featured image */
		$wp_customize->add_setting( 'refur[blog_single_image]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'refur_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'refur_blog_single_image', array(
				'label'    => __( 'Single page: show featured image', 'refur' ),
				'section'  => 'refur_blog',
				'settings' => 'refur[blog_single_image]',
				'type'     => 'checkbox',
				'priority' => 3,
		) );

		/* Loop show button */
		$wp_customize->add_setting( 'refur[blog_more]', array(
				'default'           => '1',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'refur_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'refur_blog_more', array(
				'label'    => __( 'Loop page: show read more button', 'refur' ),
				'section'  => 'refur_blog',
				'settings' => 'refur[blog_more]',
				'type'     => 'checkbox',
				'priority' => 4,
		) );

		/* Read button text */
		$wp_customize->add_setting( 'refur[blog_more_text]', array(
				'default'           => __( 'Read More', 'refur' ),
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'refur_blog_more_text', array(
				'label'       => __( 'Loop page: read more button text', 'refur' ),
				'section'     => 'refur_blog',
				'settings'    => 'refur[blog_more_text]',
				'type'        => 'text',
				'priority'    => 5,
		) );

		/* Footer section
		----------------------------------------------------*/
		$wp_customize->add_section( 'refur_footer' , array(
			'title'      => __('Footer','refur'),
			'priority'   => 63,
		) );

		/* Custom copyright */
		$wp_customize->add_setting( 'refur[footer_copyright]', array(
				'default'           => '',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'esc_textarea',
		) );
		$wp_customize->add_control( 'refur_footer_copyright', array(
				'label'       => __( 'Set custom copyright text', 'refur' ),
				'section'     => 'refur_footer',
				'settings'    => 'refur[footer_copyright]',
				'type'        => 'textarea',
				'priority'    => 1,
		) );

		/* Follow section
		----------------------------------------------------*/
		$wp_customize->add_section( 'refur_follow' , array(
			'title'      => __( 'Header Socials','refur' ),
			'priority'   => 59,
		) );

		/* Social links */
		$socials = refur_allowed_socials();

		// prevent error from wrong filters applied
		if ( is_array( $socials ) ) {
			// add allowed nets to customizer
			foreach ( $socials as $net => $data ) {

				$data = wp_parse_args( $data, array( 'label' => '', 'icon' => '', 'default' => '' ) );

				$wp_customize->add_setting( 'refur[follow_' . $net . ']', array(
						'default'           => $data['default'],
						'type'              => 'theme_mod',
						'sanitize_callback' => 'refur_sanitize_url',
				) );
				$wp_customize->add_control( 'refur_follow_' . $net, array(
						'label'       => sprintf( __( 'Link to %s account:', 'refur' ), $data['label'] ),
						'section'     => 'refur_follow',
						'settings'    => 'refur[follow_' . $net . ']',
						'type'        => 'text',
						'priority'    => 3,
				) );

			}
		}

	}

}

/**
 * Sanitize URL function for customizer
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function refur_sanitize_url( $url ) {
	return esc_url_raw( $url );
}

/**
 * Sanitize image URL
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function refur_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif'          => 'image/gif',
		'png'          => 'image/png',
		'bmp'          => 'image/bmp',
		'tif|tiff'     => 'image/tiff',
		'ico'          => 'image/x-icon',
	);
	// Return an array with file extension and mime_type.
	$file = wp_check_filetype( $image, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
	return ( $file['ext'] ? $image : $setting->default );
}

/**
 * Sanitize checkbox for customizer
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function refur_sanitize_checkbox( $checked ) {
	return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

/**
 * Sanitize callback select input
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function refur_sanitize_select( $input, $setting ) {

	// Ensure input is a slug.
	$input = sanitize_key( $input );

	$control = refur_control_id_from_settings( $setting->id );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $control )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/**
 * Sanitize numeric value
 *
 * @copyright Copyright (c) 2015, WordPress Theme Review Team
 */
function refur_sanitize_num( $number ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );

	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}

/**
 * Get typical ID for control from related setting name
 *
 * @param  string $settings settings name.
 * @return string
 */
function refur_control_id_from_settings( $settings ) {
	$name = trim( $settings, ']' );
	return preg_replace( '/[\[\]]/', '_', $name );
}

<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * @link http://codex.wordpress.org/Custom_Headers
 *
 * @package refur
 */

class refur_custom_header {

	/**
	 * A reference to an instance of this class.
	 *
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Default header settings array
	 *
	 * @var array
	 */
	public $default_settings = array();

	/**
	 * Holder for active showcase trigger
	 *
	 * @var bool
	 */
	public $is_showcase = null;

	function __construct() {
		add_filter( 'body_class', array( $this, 'add_body_classes' ) );
		add_action( 'after_setup_theme', array( $this, 'custom_header_setup' ) );
		add_action( 'refur_header_showcase', array( $this, 'public_callback' ) );
		add_action( 'customize_register', array( $this, 'header_settings' ) );

		$this->default_settings = array(
			'header_mask_color'   => '#000000',
			'header_mask_fill'    => 50,
			'header_slogan_title' => __( 'Your Awesome Blog', 'refur' ),
			'header_slogan_text'  => __( 'Just a few words why you blog is so awesome', 'refur' ),
			'header_button_text'  => __( 'Call to action', 'refur' ),
			'header_button_url'   => '#'
		);
	}

	/**
	 * Set up the WordPress core custom header feature.
	 *
	 * @uses refur_header_style()
	 * @uses refur_admin_header_style()
	 * @uses refur_admin_header_image()
	 */
	function custom_header_setup() {
		add_theme_support( 'custom-header', apply_filters( 'refur_custom_header_args', array(
			'default-image'          => get_template_directory_uri() . '/images/header-image.png',
			'default-text-color'     => 'ffffff',
			'width'                  => 2000,
			'height'                 => 765,
			'flex-height'            => true,
			'wp-head-callback'       => array( $this, 'header_style' ),
			'admin-head-callback'    => array( $this, 'admin_header_style' ),
			'admin-preview-callback' => array( $this, 'admin_header_image' ),
		) ) );
	}

	/**
	 * Register additional setting for header section
	 *
	 * @param  object $wp_customize customizer object
	 * @return void
	 */
	function header_settings( $wp_customize ) {

		$wp_customize->add_setting('refur[header_mask_color]', array(
				'default'           => $this->default_settings['header_mask_color'],
				'capability'        => 'edit_theme_options',
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_hex_color',
		));

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'refur_header_mask_color', array(
				'label'    => __( 'Image Mask Color', 'refur' ),
				'section'  => 'header_image',
				'settings' => 'refur[header_mask_color]',
		)));

		$wp_customize->add_setting( 'refur[header_mask_fill]', array(
				'default'           => $this->default_settings['header_mask_fill'],
				'type'              => 'theme_mod',
				'sanitize_callback' => 'refur_sanitize_num',
		) );

		$wp_customize->add_control( 'refur_header_mask_fill', array(
				'label'       => __( 'Image mask fill level', 'refur' ),
				'section'     => 'header_image',
				'settings'    => 'refur[header_mask_fill]',
				'type'        => 'number',
				'input_attrs' => array(
					'min'  => 0,
					'max'  => 100,
					'step' => 1,
				),
		) );

		$wp_customize->add_setting( 'refur[header_slogan_title]', array(
				'default'           => $this->default_settings['header_slogan_title'],
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'refur_header_slogan_title', array(
				'label'       => __( 'Header slogan title', 'refur' ),
				'section'     => 'header_image',
				'settings'    => 'refur[header_slogan_title]',
				'type'        => 'text',
		) );

		$wp_customize->add_setting( 'refur[header_slogan_text]', array(
				'default'           => $this->default_settings['header_slogan_text'],
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'refur_header_slogan_text', array(
				'label'       => __( 'Header slogan description', 'refur' ),
				'section'     => 'header_image',
				'settings'    => 'refur[header_slogan_text]',
				'type'        => 'text',
		) );

		$wp_customize->add_setting( 'refur[header_button_text]', array(
				'default'           => $this->default_settings['header_button_text'],
				'type'              => 'theme_mod',
				'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'refur_header_button_text', array(
				'label'       => __( 'Header button text (leave empty to remove button)', 'refur' ),
				'section'     => 'header_image',
				'settings'    => 'refur[header_button_text]',
				'type'        => 'text',
		) );

		$wp_customize->add_setting( 'refur[header_button_url]', array(
				'default'           => $this->default_settings['header_button_url'],
				'type'              => 'theme_mod',
				'sanitize_callback' => 'refur_sanitize_url',
		) );
		$wp_customize->add_control( 'refur_header_button_url', array(
				'label'       => __( 'Header button URL', 'refur' ),
				'section'     => 'header_image',
				'settings'    => 'refur[header_button_url]',
				'type'        => 'text',
		) );
	}

	/**
	 * Custom header image markup displayed on the Appearance > Header admin panel.
	 *
	 * @see custom_header_setup().
	 */
	function admin_header_image() {
	?>
		<div id="headimg">
			<h1 class="displaying-header-text">
				<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
			</h1>
			<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>"><?php bloginfo( 'description' ); ?></div>
			<?php if ( get_header_image() ) : ?>
			<img src="<?php header_image(); ?>" alt="">
			<?php endif; ?>
		</div>
	<?php
	}

	/**
	 * Public output for header image
	 *
	 * @return  void
	 */
	public function public_callback() {

		$custom_callback = apply_filters( 'refur_custom_header_showcase_callback', false );

		if ( false !== $custom_callback ) {
			echo $custom_callback;
			return true;
		}

		$this->open_image_wrap();
		$this->show_image();
		$this->show_slogan();
		$this->close_image_wrap();

	}

	/**
	 * Open HTML wrapper for header image block
	 *
	 * @return void
	 */
	public function open_image_wrap() {

		$subpage = '';

		if ( ! $this->is_showcase() ) {
			$subpage = ' is-subpage';
		}

		echo '<div class="header-showcase' . $subpage . '">';
	}

	public function show_image() {
		$image = get_header_image();
		$data  = get_custom_header();
		$alt   = get_bloginfo( 'name' );

		if ( ! $image ) {
			return;
		}

		printf(
			'<img src="%s" class="header-showcase_img" alt="%s" width="%s" height="%s">',
			$image, $alt, $data->width, $data->height
		);
	}

	/**
	 * Show header showcase content
	 *
	 * @return void
	 */
	public function show_slogan() {

		if ( ! $this->is_showcase() ) {
			return;
		}

		$title = refur_get_option( 'header_slogan_title', $this->default_settings['header_slogan_title'] );
		$text  = refur_get_option( 'header_slogan_text', $this->default_settings['header_slogan_text'] );
		?>
		<div class="header-showcase_content">
			<div class="container">
				<?php if ( $title || $text ) : ?>
				<div class="header-showcase_slogan">
					<?php if ( $title ) : ?>
					<div class="header-showcase_title"><?php
						echo wp_kses( $title, wp_kses_allowed_html( 'post' ) );
					?></div>
					<?php endif; ?>
					<?php if ( $text ) : ?>
					<div class="header-showcase_text"><?php
						echo wp_kses( $text, wp_kses_allowed_html( 'post' ) );
					?></div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<?php $this->show_button(); ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Show header showcase call to action button
	 *
	 * @return void
	 */
	public function show_button() {

		$text = refur_get_option( 'header_button_text', $this->default_settings['header_button_text'] );
		$url  = refur_get_option( 'header_button_url', $this->default_settings['header_button_url'] );

		if ( ! $text ) {
			return;
		}

		printf( '<a href="%2$s" class="header-showcase_btn">%1$s</a>', esc_textarea( $text ), esc_url( $url ) );

	}

	/**
	 * Close HTML wrapper for header image block
	 *
	 * @return void
	 */
	public function close_image_wrap() {
		echo '</div>';
	}

	/**
	 * Is showcase area visible on current page
	 *
	 * @return boolean
	 */
	public function is_showcase() {

		if ( null !== $this->is_showcase ) {
			return $this->is_showcase;
		}
		$this->is_showcase = ( is_front_page() && ! is_paged() ) ? true : false;
		return $this->is_showcase;
	}

	/**
	 * Styles the header image and text displayed on the blog
	 *
	 * @see custom_header_setup().
	 */
	function header_style() {

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php
			$mask_bg      = refur_get_option( 'header_mask_color', $this->default_settings['header_mask_color'] );
			$mask_opacity = refur_get_option( 'header_mask_fill', $this->default_settings['header_mask_fill'] );
			$mask_opacity = absint( esc_attr( $mask_opacity ) ) / 100;
		?>
		.header-showcase:after {
			background: <?php echo esc_attr( $mask_bg ); ?>;
			opacity: <?php echo $mask_opacity; ?>;
		}
		</style>
		<?php
	}

	/**
	 * Styles the header image displayed on the Appearance > Header admin panel.
	 *
	 * @see custom_header_setup().
	 */
	function admin_header_style() {
	?>
		<style type="text/css">
			.appearance_page_custom-header #headimg {
				border: none;
			}
			#headimg h1,
			#desc {
			}
			#headimg h1 {
			}
			#headimg h1 a {
			}
			#desc {
			}
			#headimg img {
			}
		</style>
	<?php
	}

	/**
	 * Header-related body classes
	 *
	 * @param array $classes
	 */
	public function add_body_classes( $classes ) {

		if ( ! get_header_image() ) {
			$classes[] = 'static-header';
		}

		if ( $this->is_showcase() ) {
			$classes[] = 'showcase-active';
		}

		return $classes;

	}

	/**
	 * Returns the instance.
	 *
	 * @return object
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance )
			self::$instance = new self;
		return self::$instance;
	}

}

refur_custom_header::get_instance();

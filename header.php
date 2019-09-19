<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package refur
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'refur_page_before' ); ?>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'refur' ); ?></a>
	<div class="page-header-wrap">
		<header id="masthead" class="site-header" role="banner">
			<div class="header-meta">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12 pull-right">
							<?php refur_follow_list(); ?>
							<?php do_action( 'refur_header_meta' ); ?>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="site-description">
								<?php bloginfo( 'description' ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-12 col-xs-12">
						<div class="site-branding">
							<?php refur_logo(); ?>
						</div><!-- .site-branding -->
					</div>
					<div class="col-md-9 col-sm-12 col-xs-12">
						<nav id="site-navigation" class="main-navigation" role="navigation">
							<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
								<?php esc_html_e( 'Primary Menu', 'refur' ); ?>
							</button>
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'primary',
										'menu_id'        => 'primary-menu',
									)
								);
							?>
						</nav><!-- #site-navigation -->
					</div>
				</div>
			</div>
		</header><!-- #masthead -->
		<?php do_action( 'refur_header_showcase' ); ?>
	</div>

	<?php do_action( 'refur_featured_content' ); ?>

	<div id="content" class="site-content">
		<div class="container">
			<div class="row">
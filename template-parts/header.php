<?php
/**
 * The template for displaying the header.
 *
 * @package refur
 */
?>
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

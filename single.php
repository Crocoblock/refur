<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package refur
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-8 col-sm-12 col-xs-12">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'template-parts/content', 'single' ); ?>

			<?php
				refur_posts_navigation(
					array(
						'<span>' . __( 'Prev', 'refur' ) . '</span>%title',
						'<span>' . __( 'Next', 'refur' ) . '</span>%title',
					)
				);
			?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

<?php
/**
 * Template Name: Posts With Featured Content
 *
 * @package refur
 */

get_header(); ?>

	<div id="primary" class="content-area col-xs-12">
		<main id="main" class="site-main" role="main">

		<?php

			$paged = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;

			$latest_blog_posts = new WP_Query(
				array(
					'posts_per_page' => get_option( 'posts_per_page', 10 ),
					'paged'          => $paged,
				)
			);

			// Temporary replace main query with custom to use the_posts_pagination() function
			$temp_query = $wp_query;
			$wp_query   = NULL;
			$wp_query   = $latest_blog_posts;

			if ( $latest_blog_posts->have_posts() ) :
		?>

			<?php /* Start the Loop */ ?>
			<div class="posts-listing">
			<?php while ( $latest_blog_posts->have_posts() ) : $latest_blog_posts->the_post(); ?>

				<?php
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				?>

			<?php endwhile; ?>
			</div>
			<?php
				the_posts_pagination(
					array(
						'prev_text' => '<i class="fa fa-angle-double-left"></i>',
						'next_text' => '<i class="fa fa-angle-double-right"></i>',
					)
				);

				// Reset main query object
				$wp_query = NULL;
				$wp_query = $temp_query;
			?>

		<?php else : ?>

			<?php get_template_part( 'template-parts/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>

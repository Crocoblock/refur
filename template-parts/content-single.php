<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package refur
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php refur_post_thumbnail( false ); ?>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php refur_post_meta( 'single' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'refur' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php refur_post_meta( 'single', 'footer' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->


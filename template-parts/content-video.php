<?php
/**
 * Template part for displaying posts.
 *
 * @package Refur
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'is-loop' ); ?>>

	<?php refur_post_video(); ?>
	<header class="entry-header">
		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php refur_post_meta(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<footer class="entry-footer">
		<?php
			refur_post_meta( 'loop', 'footer' );
			refur_read_more();
		?>
	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

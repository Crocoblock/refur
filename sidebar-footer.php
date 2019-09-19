<?php
/**
 * The sidebar containing the footer widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package refur
 */

if ( ! is_active_sidebar( 'sidebar-footer' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area footer-widget-area" role="complementary">
	<div class="container">
		<div class="row">
			<?php dynamic_sidebar( 'sidebar-footer' ); ?>
		</div>
	</div>
</div><!-- #secondary -->

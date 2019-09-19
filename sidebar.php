<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package refur
 */

if ( ! is_active_sidebar( 'sidebar-main' ) ) {
	return;
}
?>

<div id="secondary" class="widget-area col-md-4 col-sm-12 col-xs-12" role="complementary">
	<?php dynamic_sidebar( 'sidebar-main' ); ?>
</div><!-- #secondary -->

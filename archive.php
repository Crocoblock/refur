<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package refur
 */

get_header();

refur_do_location( 'archive', 'template-parts/archive' );

get_footer();

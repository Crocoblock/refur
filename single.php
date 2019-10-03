<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package refur
 */

get_header();

refur_do_location( 'single', 'template-parts/single' );

get_footer();

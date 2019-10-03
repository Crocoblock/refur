<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package refur
 */

get_header();

refur_do_location( 'single', 'template-parts/404' );

get_footer();

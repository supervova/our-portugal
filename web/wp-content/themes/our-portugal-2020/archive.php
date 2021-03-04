<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package Our_Portugal
 */

// global $paged; .
global $wp_query;
$context   = Timber::context();
$templates = array( 'archive.twig', 'index.twig' );

$context['title'] = 'Archive';
if ( is_day() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'D M Y' );
} elseif ( is_month() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'M Y' );
} elseif ( is_year() ) {
	$context['title'] = 'Archive: ' . get_the_date( 'Y' );
} elseif ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} elseif ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} elseif ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}

/*
if ( is_post_type_archive( 'real-estate' ) ) {
	$context['posts'] = Timber::get_posts(
		array(
			'post_type' => 'real-estate',
			'posts_per_page' => 9,
			'paged'          => $paged,
		)
	);
} else {
	$context['posts'] = new Timber\PostQuery();
}
*/

/*
$args = array(
	'numberposts' => -1,
	'post_type'   => 'post',
	'meta_key'    => 'color',
	'meta_value'  => 'red',
);

$context['posts'] = new Timber\PostQuery($args);
*/

$context['posts'] = new Timber\PostQuery();
$context['posts_count'] = $wp_query->found_posts;

Timber::render( $templates, $context );

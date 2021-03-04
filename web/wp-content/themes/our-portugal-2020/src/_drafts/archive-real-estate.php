<?php
/**
 * The Property section page template.
 *
 * @package Our_Portugal
 */

$context = Timber::get_context();

$args = array(
	// Get CPT posts.
	'post_type'      => 'real-estate',
	// Get all posts.
	'posts_per_page' => -1,
	// Get post by "graphic" category.
	'meta_query'     => array(
		array(
			'key'     => 'project_category',
			'value'   => 'graphic',
			'compare' => 'LIKE',
		),
	),
	// Order by post date.
	'orderby' => array(
		'date' => 'DESC',
	),
);

$context['real-estate'] = Timber::get_posts( $args );

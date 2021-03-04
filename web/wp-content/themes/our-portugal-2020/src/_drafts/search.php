<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package Our_Portugal
 */

$context          = Timber::context();
$context['title'] = __( 'Результаты поиска: ', 'our-portugal' ) . get_search_query();
$context['posts'] = new Timber\PostQuery();
$text_search      = get_search_query();

if ( is_singular( 'real-estate' ) || is_post_type_archive( 'real-estate' ) ) {
	$args = array(
		'post_type'      => array( 'real-estate' ),
		'posts_per_page' => 9,
		's'              => $text_search,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'post_status'    => 'publish',
		// 'paged'          => $paged .
	);

	// } elseif ( is_wpforo_page() ) { // Mb wpForo has search already .

} else { // if ( is_home() || is_single() || is_author() || is_category() || is_tag() && 'post' ) .
	$args = array(
		'post_type'      => array( 'post' ),
		'posts_per_page' => 9,
		's'              => $text_search,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'post_status'    => 'publish',
	);
}

$context['pagination'] = Timber::get_pagination();
$context['posts']      = new Timber\PostQuery( $args );
$context['count']      = new WP_Query( $args );

Timber::render(
	array(
		'search-' . $timber_post->post_type . '.twig',
		'index.twig',
	),
	$context
);

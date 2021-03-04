<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @package Our_Portugal
 */

$context = Timber::context();

$context['title'] = pll__( 'Архив' );

if ( is_home() ) {
	$context['title'] = pll__( 'Блог: всё о Португалии' );
} elseif ( is_search() ) {
	$context['title'] = pll__( 'Результаты поиска: ' ) . get_search_query();
} elseif ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
} elseif ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
}

if ( is_home() ) {
	Timber::render( 'blog.twig', $context );
} else {
	Timber::render( 'index.twig', $context );
}

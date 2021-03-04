<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package Our_Portugal
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;
$context['posts'] = Timber::get_posts(
  array( 'posts_per_page' => 3 )
);

Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );

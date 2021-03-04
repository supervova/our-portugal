<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package Our_Portugal
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;

if ( is_front_page() ) {
	// The blog latest three posts.
	$context['posts'] = Timber::get_posts(
		array( 'posts_per_page' => 3 )
	);

	// The real estate latest posts.
	$context['realty_teaser'] = Timber::get_posts(
		array(
			'post_type'      => 'realty',
			'posts_per_page' => 3,
		)
	);

	Timber::render( 'front-page.twig', $context );

} elseif ( is_page( array( 'login', 'autorizacao' ) ) ) {
	Timber::render( 'page-login.twig', $context );

} else {
	Timber::render(
		array(
			'page-' . $timber_post->post_name . '.twig',
			'page.twig',
		),
		$context
	);
}

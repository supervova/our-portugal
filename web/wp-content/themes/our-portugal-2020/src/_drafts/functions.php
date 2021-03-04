<?php
/**
 * -----------------------------------------------------------------------------
 * STOREFRONT CUSTOMIZATION
 * -----------------------------------------------------------------------------
 */
function our_portugal_storefront_customization() {
	// Remove <header class="entry-header"> from page.php template.
	remove_action( 'storefront_page', 'storefront_page_header', 10 );
}

add_action( 'wp', 'our_portugal_storefront_customization' );

/**
 *  Pluggable function - Display the post content
 */
function storefront_page_content() {
	?>
	<article class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages(
				array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
					'after'  => '</div>',
				)
			);
		?>
	</article>
	<?php
}

/**
 * CONTACT FORM 7 CUSTOM AJAX LOADER
 */
function our_portugal_ajax_loader() {
 return get_bloginfo( 'stylesheet_directory' ) . '/img/indicator/spinner.gif';
}

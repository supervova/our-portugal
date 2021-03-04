<?php
/**
 * THEME FUNCTIONS
 *
 * Our Portugal website theme is based on the Timber starter theme
 * https://github.com/timber/starter-theme
 *
 * @package Our_Portugal
 *
 * TIMBER CHECK
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */

if ( ! class_exists( 'Timber' ) ) {

	add_action(
		'admin_notices',
		function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		}
	);

	add_filter(
		'template_include',
		function( $template ) {
			return get_stylesheet_directory() . '/no-timber.html';
		}
	);
	return;
}

/**
 * TWIG FOLDERS
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * AUTOESCAPE
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * THE SITE CLASS
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class OurPortugalSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		// add_action( 'init', array( $this, 'register_taxonomies' ) ); .
		parent::__construct();
	}

	/** Register custom post types. */
	public function register_post_types() {
		$realty_labels = array(
			'name'          => _x( 'Недвижимость', 'Post Type General Name', 'our-portugal' ),
			'singular_name' => _x( 'Объект', 'Post Type Singular Name', 'our-portugal' ),
			'menu_name'     => __( 'A propriedade (Недвижимость)', 'our-portugal' ),
			'all_items'     => __( 'Todos os anúncios (Все объявления)', 'our-portugal' ),
			'search_items'  => __( 'Искать недвижимость', 'our-portugal' ),
			'add_new'       => __( 'Adicionar (Добавить)', 'our-portugal' ),
			'add_new_item'  => __( 'Para adicionar um anúncio (Добавить объявление)', 'our-portugal' ),
			// 'view_item'          => __( 'Посмотреть', 'our-portugal' ),
			// 'edit_item'          => __( 'Редактировать', 'our-portugal' ),
			// 'update_item'        => __( 'Обновить', 'our-portugal' ),
			// 'not_found'          => __( 'Not Found', 'our-portugal' ),
			// 'not_found_in_trash' => __( 'Not found in Trash', 'our-portugal' ),
		);

		$realty_args = array(
			'labels'            => $realty_labels,
			'supports'          => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields' ),
			'public'            => true,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_nav_menus' => false,
			'show_in_admin_bar' => false,
			'has_archive'       => true,
			'show_in_rest'      => false,
			'menu_icon'         => 'dashicons-admin-home',
			// 'taxonomies'        => array( 'genres' ),
			// 'capability_type'   => 'post',
		);

		register_post_type( 'realty', $realty_args );
	}

	/** This is where you can register custom taxonomies. */
	/* public function register_taxonomies() {} */

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['global']['short_name']           = 'Наша Португалия';
		$context['global']['logo']                 = '';
		$context['global']['image']                = '';
		$context['global']['icons']['apple_touch'] = '/wp-content/themes/our-portugal-2020/img/base/graphics/icon.png';
		$context['global']['icons']['svg']         = '/wp-content/themes/our-portugal-2020/img/base/graphics/icon.svg"';
		$context['global']['colors']['primary']    = '#4a90e2';
		$context['global']['colors']['browser']    = '#f2f5f8';
		$context['global']['street']               = '';
		$context['global']['postal_code']          = '';
		$context['global']['country']              = '';
		$context['global']['locality']             = 'город';
		$context['global']['region']               = 'область, община';
		$context['global']['phone']                = '+351 21 034 3300';
		$context['global']['telegram']             = 'our-portugal';
		$context['global']['facebook']             = 'our-portugal';
		$context['global']['email']                = '';
		$context['global']['area_served']          = 'RU';
		$context['global']['fonts']['google']      = 'Inter:wght@300;400;600';
		$context['global']['fonts']['local']       = 'SFPD-Semibold';
		$context['global']['gtm']                  = 'GTM-NZRRGGX';
		$context['global']['facebook_admins']      = false;
		$context['global']['facebook_app_id']      = false;
		$context['global']['facebook_cta_like']    = false;
		$context['global']['vk_api']               = false;
		$context['global']['author']['summary']    = 'Vladimir Nikishin, www.super-mark.ru';
		$context['global']['author']['summary']    = '@supervova';

		$context['global']['main_menu']   = new \Timber\Menu( 'Main Menu' );
		$context['global']['footer_menu'] = new \Timber\Menu( 'Footer Menu' );

		$context['global']['term']['portugal'] = new Timber\Term( 'portugal' );
		$context['global']['term']['vacation'] = new Timber\Term( 'vacation' );
		$context['global']['term']['life']     = new Timber\Term( 'life' );

		$context['maps_api'] = MAPS_KEY;

		$context['site'] = $this;

		return $context;
	}

	/**
	 * ---------------------------------------------------------------------------
	 * THEME SUPPORT
	 * ---------------------------------------------------------------------------
	 */
	public function theme_supports() {
		// WP_HEAD: RSS FEEDS.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * WP_HEAD: TITLE
		 * This theme does not use a hard-coded <title> tag in the document head.
		 * Let WordPress manage it.
		 */
		add_theme_support( 'title-tag' );

		// POST THUMBNAILS.
		add_theme_support( 'post-thumbnails' );

		/**
		 * HTML5
		 * Switch default to valid output
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/**
		 * HEADLESS POST FORMATS
		 * http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/**
	 * CUSTOM FUNCTIONS FOR {{ TWIG.USE }}
	 *
	 * First, we declare the function...
	 * public function myfoo( $myparam ) {
	 *    // code
	 * }
	 *
	 * ...then add it to the file
	 *
	 * @param object $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig\Extension\StringLoaderExtension() );
		// $twig->addFilter( new Twig\TwigFilter( 'myfoo', array( $this, 'myfoo' ) ) ); .
		return $twig;
	}
}

new OurPortugalSite();

/* #endregion */

/**
 * ---------------------------------------------------------------------------
 * STANDARD WP STUFF
 * ---------------------------------------------------------------------------
 *
 * REGISTER MENUS
 */
add_action(
	'after_setup_theme',
	function () {
		register_nav_menus(
			array(
				'main-menu'   => 'Main Menu',
				'footer-menu' => 'Footer Menu',
			)
		);
	}
);

/**
 * SIDEBARS
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function our_portugal_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'our-portugal' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'our-portugal' ),
			'before_widget' => '<aside class="sidebar %2$s" id="%1$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="sidebar__title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'our_portugal_widgets_init' );

/**
 * RUSSIAN DATE
 */
function our_portugal_ru_date() {
	$date = explode( '.', gmdate( 'd.m.Y' ) );
	switch ( $date[1] ) {

		// If second element (month) of array $date (current date) equals 1,
		// set variable $m to 'янв' and so on.
		case 1:
			$m = 'янв';
			break;
		case 2:
			$m = 'фев';
			break;
		case 3:
			$m = 'мар';
			break;
		case 4:
			$m = 'апр';
			break;
		case 5:
			$m = 'мая';
			break;
		case 6:
			$m = 'июн';
			break;
		case 7:
			$m = 'июл';
			break;
		case 8:
			$m = 'авг';
			break;
		case 9:
			$m = 'сен';
			break;
		case 10:
			$m = 'окт';
			break;
		case 11:
			$m = 'ноя';
			break;
		case 12:
			$m = 'дек';
			break;
	}
	echo esc_html( $date[0] ) . '&nbsp;' . esc_html( $m ) . '&nbsp;' . esc_html( $date[2] );
}

/**
 * -----------------------------------------------------------------------------
 * CLEAN UP
 * -----------------------------------------------------------------------------
 */
function our_portugal_cleanup() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_head', 'rel_canonical' );
	remove_action( 'wp_head', 'rel_alternate' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );

	// Remove DNS prefetch — to decide test it with Lighthouse.
	remove_action( 'wp_head', 'wp_resource_hints', 2 );

	remove_action( 'rest_api_init', 'wp_oembed_register_route' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );
	remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );

	add_filter( 'embed_oembed_discover', '__return_false' );
	// add_filter( 'show_admin_bar', '__return_false' );
}

add_action( 'after_setup_theme', 'our_portugal_cleanup' );

/**
 * CLEAN UP MENU CLASSES
 *
 * @param [array] $var classes.
 */
function our_portugal_nav_class_filter( $var ) {
	return is_array( $var ) ? array_intersect( $var, array( 'is-blog', 'is-visa', 'is-real-estate', 'is-forum' ) ) : '';
}
add_filter( 'nav_menu_css_class', 'our_portugal_nav_class_filter', 100, 1 );

/**
 * REMOVE SCRIPT AND STYLE TYPE ATTRIBUTE
 *
 * @param [object] $tag script or style tag.
 * @return [object] tag w/o type attribute.
 */
function our_portugal_remove_type_attr( $tag ) {
	return preg_replace( "/type=['\"]text\/(javascript|css)['\"]/", '', $tag );
}

add_filter( 'style_loader_tag', 'our_portugal_remove_type_attr', 10, 2 );
add_filter( 'script_loader_tag', 'our_portugal_remove_type_attr', 10, 2 );
add_filter( 'autoptimize_html_after_minify', 'our_portugal_remove_type_attr', 10, 2 );


/**
 * REMOVE ADMIN TOOLBARS ITEMS
 * To find out the names of the menu items, look at their HTML id with. Then
 * remove wp-admin-bar- from the beginning to get the right id.
 * ☝️🧐 For some reason assetcleanup-parent and updraft_admin_node are not removed.
 *
 * @param [object] $wp_adminbar top bar object.
 */
function our_portugal_remove_toolbar_items( $wp_adminbar ) {
	$wp_adminbar->remove_node( 'languages' );
	$wp_adminbar->remove_node( 'wpseo-menu' );
	$wp_adminbar->remove_node( 'autoptimize' );
	$wp_adminbar->remove_node( 'ct_parent_node' );
	$wp_adminbar->remove_node( 'updraft_admin_node' );
}

add_action( 'admin_bar_menu', 'our_portugal_remove_toolbar_items', 999 );

/**
 * -----------------------------------------------------------------------------
 * SCRIPTS AND STYLES
 * -----------------------------------------------------------------------------
 */
function our_portugal_assets() {
	// Create time based version.
	$ver = filemtime( get_template_directory() . '/style.css' );

	// Remove Gutenberg CSS.
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );

	// Add Google fonts and main styles.
	wp_enqueue_style(
		'our-portugal-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap',
		array(),
		$ver
	);
	wp_enqueue_style( 'our-portugal-style', get_stylesheet_uri(), array(), $ver );

	// Move all plugins scripts to footer.
	remove_action( 'wp_head', 'wp_print_scripts' );
	remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
	remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );

	add_action( 'wp_footer', 'wp_print_scripts', 5 );
	add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
	add_action( 'wp_footer', 'wp_print_head_scripts', 5 );

	// Main script.
	wp_enqueue_script( 'our-portugal-scripts', get_template_directory_uri() . '/js/main.js', array(), $ver, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'our_portugal_assets', PHP_INT_MAX );

/**
 * CUSTOM FIELD BODY CLASSES
 * It accepts values from a per-page custom field, and only outputs when viewing a singular static Page.
 *
 * @param array $classes Existing body classes.
 * @return array Amended body classes.
 */
function our_portugal_body_classes( array $classes ) {
	$new_class = is_page() ? get_post_meta( get_the_ID(), 'body_classes', true ) : null;

	if ( $new_class ) {
		$classes[] = $new_class;
	}

	return $classes;
}

add_filter( 'body_class', 'our_portugal_body_classes' );


/**
 * -----------------------------------------------------------------------------
 * MISC
 * -----------------------------------------------------------------------------
 *
 * EXCERPT MORE LINK
 */
function our_portugal_excerpt_more() {
	return ' &hellip; <a href="' . get_permalink() . '">' . __( 'Continued', 'our-portugal' ) . '</a>';
}

add_filter( 'excerpt_more', 'our_portugal_excerpt_more' );

/**
 * HTML TAGS IN THE TITLES
 *
 * Usage: Lorem [anchor url="https://domain.com/"]ipsum[/anchor] dolor
 * Lorem[br class="d-none d-lg-block"] ipsum dolor
 *
 * @param [array] $attr shortcode of an attribute.
 */
function our_portugal_shortcode_br( $attr ) {
	if ( isset( $attr['class'] ) ) {
		return '<br class="' . $attr['class'] . '">';
	} else {
		return '<br>';
	}
}

/**
 * Replace [span]
 *
 * @param [array]  $attr shortcode of an attribute.
 * @param [string] $content of tag.
 */
function our_portugal_shortcode_span( $attr, $content ) {
	return '<span>' . $content . '</span>';
}

/**
 * Replace [small]
 *
 * @param [array]  $attr shortcode of an attribute.
 * @param [string] $content of tag.
 */
function our_portugal_shortcode_small( $attr, $content ) {
	return '<small>' . $content . '</small>';
}

/**
 * Replace [a]
 *
 * @param [array]  $attr shortcode of an attribute.
 * @param [string] $content of tag.
 */
function our_portugal_shortcode_anchor( $attr, $content ) {
	return '<a href="' . ( isset( $attr['url'] ) ? $attr['url'] : '' ) . '">' . $content . '</a>';
}

add_shortcode( 'br', 'our_portugal_shortcode_br' );
add_shortcode( 'span', 'our_portugal_shortcode_span' );
add_shortcode( 'small', 'our_portugal_shortcode_small' );
add_shortcode( 'anchor', 'our_portugal_shortcode_anchor' );
add_filter( 'widget_title', 'do_shortcode' );
add_filter( 'the_title', 'do_shortcode' );

/**
 * Filter the HTML tag back out so that it doesn’t show up in url’s or any other
 * place for that matter
 *
 * @param [string] $title document title.
 */
function our_portugal_wp_title( $title ) {
	$pattern = '|[[\/\!]*?[^\[\]]*?]|si';
	$replace = '';
	return esc_html( preg_replace( $pattern, $replace, $title ) );
}

add_filter( 'wp_title', 'our_portugal_wp_title', 98 );

/**
 * Wrap the inserted image html with <figure>
 *
 * @param mixed $content image code.
 */
function our_portugal_img( $content ) {
	$content = sprintf( '<figure class="border">%s</figure>', $content );
	return $content;
}
add_filter( 'image_send_to_editor', 'our_portugal_img', 99 );

/**
 * Remove WP image classes
 *
 * @param string $class image classes.
 */
function our_portugal_img_class( $class ) {
	$class = 'img';
	return $class;
}

add_filter( 'get_image_tag_class', 'our_portugal_img_class' );

/**
 * HTML Forms tweaks
 */
add_filter(
	'hf_form_element_class_attr',
	function( $class_attr ) {
		return $class_attr . 'is-should-be-validated';
	}
);

add_filter(
	'hf_form_html',
	function( $html ) {
		$html = str_replace( '<form ', '<form novalidate ', $html );
		return $html;
	}
);



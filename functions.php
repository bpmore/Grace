<?php
//* Ladies and Gentlemen...Start your engines
include_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Grace' );
define( 'CHILD_THEME_URL', 'http://bpmo.re/grace' );
define( 'CHILD_THEME_VERSION', '1.0' );

//* Add HTML5 markup structure
add_theme_support( 'html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

/** Custom image sizes */
add_image_size( 'featured-image', 1140, 400, true );
add_image_size( 'single-post-thumbnail', 380, 133, true );
add_image_size( 'Square Image', 500, 500, true );
add_image_size( 'Square Thumbnail', 200, 200, true );
add_image_size( 'Portfolio', 230, 230, TRUE );

//* Reposition the primary navigation menu
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_before_header', 'genesis_do_nav' );

//* Add Featured Image to Page and Post Above Title
add_action ( 'genesis_entry_header', 'grace_featured_image_title_singular', 9 );
function grace_featured_image_title_singular() {

	if ( !is_singular() || !has_post_thumbnail() )
		return;

	echo '<div class="singular-thumbnail">';
	genesis_image( array( 'size' => 'singular' ) );
	echo '</div>';

}

//* Add Previous and Next Navigation to Post
add_action('genesis_entry_footer', 'grace_custom_pagination_links', 15 );
function grace_custom_pagination_links() {
if( !is_single() )
      return;

    previous_post_link('<div class="single-post-nav">&#10092; %link', ' ' . get_previous_post_link('%title') , FALSE);
    echo ' &mdash; ';
    next_post_link('%link &#10093;</div>', get_next_post_link('%title') . ' ' , FALSE);
}

//add_action('genesis_after_comments', 'custom_post_navigation');

//* Enqueue Josefin Slab and Old Standard TT Google fonts
add_action( 'wp_enqueue_scripts', 'grace_google_fonts' );
function grace_google_fonts() {

	wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Montserrat:400|700', array(), CHILD_THEME_VERSION );

}


//* Add support for post format images
//add_theme_support( 'genesis-post-format-images' );

//* Add support for post formats
//add_theme_support( 'post-formats', array(
//	'aside',
//	'audio',
//	'chat',
//	'gallery',
//	'image',
//	'link',
//	'quote',
//	'status',
//	'video'
//) );

//* Enable shortcodes in widgets
add_filter('widget_text', 'do_shortcode');

//* If you want to have the front page of your site display a static page named "home", this function will remove the page title
add_action( 'get_header', 'child_remove_page_titles' );
function child_remove_page_titles() {
if (is_page('home')) {
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
}
}

//* Unregister navigation menus
//remove_theme_support( 'genesis-menus' );

//* Unregister layout settings
genesis_unregister_layout( 'content-sidebar' );
genesis_unregister_layout( 'sidebar-content' );
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Unregister secondary navigation menu
add_theme_support( 'genesis-menus', array( 'primary' => __( 'Primary Navigation Menu', 'genesis' ) ) );

//* Remove the entry header markup
//remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
//remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
//remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//* Modify the WordPress read more link
add_filter( 'the_content_more_link', 'grace_read_more' );
function grace_read_more() {

	return '<a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';

}

//* Customize the entry meta in the entry footer
add_filter( 'genesis_post_meta', 'unfiltered_post_meta_filter' );
function unfiltered_post_meta_filter($post_meta) {
	$post_meta = '[post_categories before="" after=""] [post_tags before=""]';
	return $post_meta;
}

//Enqueue the Dashicons script
add_action( 'wp_enqueue_scripts', 'amethyst_enqueue_dashicons' );
function amethyst_enqueue_dashicons() {
	wp_enqueue_style( 'amethyst-dashicons-style', get_stylesheet_directory_uri(), array('dashicons'), '1.0' );
}

//* Remove the header right widget area
//unregister_sidebar( 'header-right' );

//* Unregister secondary sidebar
unregister_sidebar( 'sidebar-alt' );
unregister_sidebar( 'sidebar' );

//* Customize entry meta in the entry header
add_filter( 'genesis_post_info', 'grace_post_info_filter' );
function grace_post_info_filter($post_info) {
	$post_info = '[post_date] [post_edit]';
	return $post_info;
}


//* Remove the breadcrumb
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );

//* Change the footer text
add_filter('genesis_footer_creds_text', 'grace_footer_creds_filter');
function grace_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] &middot; <a href="http://brentpassmore.com">Brent Passmore</a>';
	return $creds;
}

/** Remove unused theme settings - Thank you Bill Erickson */
add_action( 'genesis_theme_settings_metaboxes', 'child_remove_metaboxes' );
function child_remove_metaboxes( $_genesis_theme_settings_pagehook ) {
    remove_meta_box( 'genesis-theme-settings-header', $_genesis_theme_settings_pagehook, 'main' );
    remove_meta_box( 'genesis-theme-settings-nav', $_genesis_theme_settings_pagehook, 'main' );
//    remove_meta_box( 'genesis-theme-settings-layout', $_genesis_theme_settings_pagehook, 'main' );
    remove_meta_box( 'genesis-theme-settings-breadcrumb', $_genesis_theme_settings_pagehook, 'main' );
//  remove_meta_box( 'genesis-theme-settings-comments', $_genesis_theme_settings_pagehook, 'main' );
//  remove_meta_box( 'genesis-theme-settings-blogpage', $_genesis_theme_settings_pagehook, 'main' );
}

//* Featured Image in Single Posts *//
//add_action( 'genesis_entry_content', 'sk_show_featured_image_single_posts', 9 );
/**
 * Display Featured Image floated to the right in single Posts.
 *
 * @author Sridhar Katakam
 * @link   http://sridharkatakam.com/how-to-display-featured-image-in-single-posts-in-genesis/
 */
//function sk_show_featured_image_single_posts() {
//	if ( ! is_singular( 'post' ) ) {
//		return;
//	}
//
//	$image_args = array(
//		'size' => 'medium',
//		'attr' => array(
//			'class' => 'alignright',
//		),
//	);
//
//	genesis_image( $image_args );
//}

/* Include Portfolio CPT in Search Results */
add_filter( 'pre_get_posts', 'tgm_cpt_search' );
/**
 * This function modifies the main WordPress query to include an array of post types instead of the default 'post' post type.
 *
 * @param mixed $query The original query
 * @return $query The amended query
 */
function tgm_cpt_search( $query ) {
    if ( $query->is_search )
		$query->set( 'post_type', array( 'post', 'portfolio' ) );
    return $query;
};
/**
* Customize the default text inside of search box
*
* @author Rick R. Duncan
* @link http://www.rickrduncan.com
*/
function b3m_search_box_text( $text ) {
return esc_attr( 'Search' );

}
add_filter( 'genesis_search_text', 'b3m_search_box_text' );

add_filter( 'wp_nav_menu_items', 'genesis_search_primary_nav_menu', 10, 2 );
/**
* @author Brad Dalton
* @example http://wpsites.net/web-design/add-search-form-to-any-genesis-nav-menu/
* @copyright 2014 WP Sites
*/
function genesis_search_primary_nav_menu( $menu, stdClass $args ){
if ( 'primary' != $args->theme_location )
return $menu;
if( genesis_get_option( 'nav_extras' ) )
return $menu;
$menu .= sprintf( '<li class="custom-search">%s</li>', __( genesis_search_form( $echo ) ) );
return $menu;
}

//* Create portfolio custom post type
add_action( 'init', 'grace_portfolio_post_type' );
function grace_portfolio_post_type() {

	register_post_type( 'portfolio',
		array(
			'labels' => array(
				'name'          => __( 'Portfolio', 'grace' ),
				'singular_name' => __( 'Portfolio', 'grace' ),
			),
			'exclude_from_search' => true,
			'has_archive'         => true,
			'hierarchical'        => true,
			'menu_icon'           => 'dashicons-admin-page',
			'public'              => true,
			'rewrite'             => array( 'slug' => 'portfolio', 'with_front' => false ),
			'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'trackbacks', 'custom-fields', 'revisions', 'page-attributes', 'genesis-seo' ),
		)
	);

}

//* Change the number of portfolio items to be displayed (props Bill Erickson)
add_action( 'pre_get_posts', 'grace_portfolio_items' );
function grace_portfolio_items( $query ) {

	if ( $query->is_main_query() && !is_admin() && is_post_type_archive( 'portfolio' ) ) {
		$query->set( 'posts_per_page', '6' );
	}

}

add_action( 'init', 'cd_add_editor_styles' );
/**
* Apply theme's stylesheet to the visual editor.
*
* @uses add_editor_style() Links a stylesheet to visual editor
* @uses get_stylesheet_uri() Returns URI of theme stylesheet
*/
function cd_add_editor_styles() {
 
add_editor_style( get_stylesheet_uri() );
 
}

<?php //remove this entire line

/**
* Template Name: Office Hours Template
* Description: Used as a page template to show page contents, followed by a loop
* through the "Genesis Office Hours" category
*/

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'prefix_do_loop' );
/**
 * Outputs a custom loop
 *
 * @global mixed $paged current page number if paginated
 * @return void
 */
function prefix_do_loop() {

	global $paged;

	// accepts any wp_query args
	$args = (array(
		'post_type'      => '',
		'category_name'  => 'blog', // use category slug
		'order'          => 'ASC',
		'orderby'       => 'title',
	 	'paged'          => $paged,
	 	'posts_per_page' => 2
	));

	genesis_custom_loop( $args );
}

genesis();

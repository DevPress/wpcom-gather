<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Gather
 */

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function gather_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'gather_setup_author' );

/**
 * Returns class to be used for footer
 *
 * @return string footer class
 */
function gather_footer_class() {

	$count = gather_count_widgets( 'footer' );

	// If there's two widgets or less
	if ( $count <= 2) {
		return 'columns-' . $count;
	}

	// Otherwise we'll have 3 columns
	return 'columns-3';

}

/**
 * Counts number of widgets in a sidebar
 *
 * @param string $sidebar_id
 * @return int $widget_count
 */
function gather_count_widgets( $sidebar_id ) {

	// If loading from front page, consult $_wp_sidebars_widgets rather than options
	// to see if wp_convert_widget_settings() has made manipulations in memory.
	global $_wp_sidebars_widgets;
	if ( empty( $_wp_sidebars_widgets ) ) :
		$_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
	endif;

	$sidebars_widgets_count = $_wp_sidebars_widgets;

	if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) :
		$widget_count = count( $sidebars_widgets_count[ $sidebar_id ] );
		return $widget_count;
	endif;

}

/**
 * Get menu name by location
 *
 * @param string $location
 * @return object $menu_obj
 */
function gather_get_menu_name( $location ) {

    $locations = get_nav_menu_locations();
    $menu_obj = get_term( $locations[$location], 'nav_menu' );

    return $menu_obj->name;
}

/**
 * Determine which template part to load
 *
 * @return string template part
 */
function gather_template_part() {
	$template = '';
	$type = get_post_type();
	if ( gather_load_masonry() ) {
		$template = 'masonry';
	}
	if ( 'download' == $type && gather_load_masonry() ) {
		$template = 'masonry-download';
	}
	return $template;
}
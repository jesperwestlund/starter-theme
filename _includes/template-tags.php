<?php

if ( ! function_exists('starter_menu') ) :
/**
 * Menu
 *
 * Display main menu. 
 *
 * @since 1.0.0
 *
 * @see wp_nav_menu
 * @link http://codex.wordpress.org/Function_Reference/wp_nav_menu
 */
function starter_menu() {
	$args = array(
		'theme_location'  => 'primary',
  		'container'       => 'nav', 
  		'container_class' => 'sixteen columns',
		'container_id'    => 'menu',
  		'menu_class'      => 'menu',
		'fallback_cb'     => 'starter_no_menu',
  		'echo'            => true,
  		'items_wrap'      => '<ul id="%1$s" class="%2$s" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">%3$s</ul>',
  		'depth'           => 3
	);
	$args = apply_filters( 'starter_primary_menu_args', $args );
	wp_nav_menu( $args );
}
endif;

function starter_no_menu() {
	echo "\n<nav class=\"sixteen columns\" id=\"menu-blank\">\n";
	echo "\t<div id=\"menu\">\n";
	echo "\t\t<p>" . __( 'No menu has been assigned to this area yet.', 'starter' ) . " <a href=\"".admin_url()."nav-menus.php\">" . __( 'Add menu', 'starter' ) . "</a></p>\n";
	echo "\t</div><!-- #menu -->\n";
	echo "</nav><!-- #empty-menu -->\n";
}

if ( ! function_exists( 'starter_pagination' ) ) :
/**
 * Pagination
 *
 * Display loop pagination. 
 *
 * @since 1.0.0
 *
 * @see paginate_links
 * @link http://codex.wordpress.org/Function_Reference/paginate_links
 *
 * @global object $wp_query
 *
 * @param object $query
 */
function starter_pagination( $query = '' ) {

	global $wp_query;

	$the_query = ( $query == '' ) ? $wp_query : $query;

	$current = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

	// Detect the permalink structure currently being used.
	if ( get_option( 'permalink_structure' ) ) {
		$format = 'page/%#%';
	} else {
		$format = '?paged=%#%';
		if ( ! is_home() ) {
			$format = '&paged=%#%';
		}
	}

	if ( $the_query->max_num_pages > 1 ) {

		$big = 999999;

		$defaults = array(
			'base'         => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'       => $format,
			'total'        => $the_query->max_num_pages,
			'current'      => max( 1, get_query_var('paged') ),
			'show_all'     => false,
			'end_size'     => 1,
			'mid_size'     => 1,
			'prev_next'    => true,
			'prev_text'    => __( '&laquo; Newer', 'starter' ),
			'next_text'    => __( 'Older &raquo;', 'starter' ),
			'type'         => 'plain',
			'add_args'     => false,
			'add_fragment' => ''
		);

		$args = array();
		$args = wp_parse_args( $args, apply_filters( 'starter_paginate_links', $defaults ) );
        echo paginate_links( $args );
	}
}
endif;

if ( ! function_exists( 'starter_get_word_count' ) ) :
/**
 * Word Count
 *
 * Return post word count. 
 *
 * @since 1.0.0
 *
 * @return integer
 */
function starter_get_word_count() {
	global $post;
	$wccontent = get_post_field( 'post_content', $post->ID );
    $word_count = str_word_count( strip_tags( $wccontent ) );
    return $word_count;
}
endif;

/**
 * Determine layout class
 *
 * @since Starter 1.0
 * @return string
 */
function starter_layout_class() {
	
	$options = get_option( 'starter_display_options' );
	$class = 'sixteen columns';

	switch ( $options['layout'] ):
		case 1:
			if (  is_active_sidebar('sidebar-right') ) {
				$class = 'eleven columns';
			} else {
				$class = 'sixteen columns';
			}
		break;
		case 2:
			$class = 'sixteen columns';
		break;
		case 3:
			if (  is_active_sidebar('sidebar-left') ) {
				$class = 'eleven columns';
			} else {
				$class = 'sixteen columns';
			}
		break;
		default:
			$class = 'sixteen columns';
		break;
	endswitch;
	
	echo $class;
}
<?php

/**
 * Define theme constants.
 *
 */

if ( ! defined( 'STARTER_URI' ) )
	define( 'STARTER_URI', get_template_directory_uri() );

if ( ! defined( 'STARTER_DIR' ) )
	define( 'STARTER_DIR', get_template_directory() );

if ( ! defined( 'STARTER_THEME' ) )
	define( 'STARTER_THEME', wp_get_theme() );

if ( ! isset( $content_width ) )
	$content_width = 940;

if ( ! function_exists( 'is_version' ) ) :
/**
 * You can't assume everyone is running the latest version of WordPress, by using conditional
 * checks throughout the theme some functions is beeing excluded when an older version of
 * WordPress is detected.
 *
 * @since 1.0
 * @global string $wp_version
 * @param string $version 
 * @return boolean
 */
function is_version( $version = '3.9.2' ) {
	global $wp_version;

	if ( version_compare( $wp_version, $version, '<' ) ) {
		return false;
	}
	return true;
}
endif;

if ( ! function_exists( 'starter_force_ie_edge' ) ) :
/**
 * Force IE Edge
 *
 * @since 1.0
 * @uses hook wp_headers
 * @param array $wp_headers
 * @return array
 */
function starter_force_ie_edge( $wp_headers ) {
	if ( isset( $_SERVER['HTTP_USER_AGENT'] ) && ( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE' ) !== false ) ) {
		$wp_headers['X-UA-Compatible'] = 'IE=edge,chrome=1';
	}
	return $wp_headers;
}
add_action( 'wp_headers', 'starter_force_ie_edge' );
endif;

if ( ! function_exists( 'starter_remove_query_strings' ) ) :
/**
 * Resources with a ? or & in the URL are not cached by some proxy caching servers, and moving the
 * query string and encode the parameters into the URL will increase your WordPress site
 * performance grade significant. This function removes query strings from static resources.
 *
 * @since 1.0
 * @uses filter style_loader_src
 * @uses filter script_loader_src
 * @param string $src
 * @return string
 */
function starter_remove_query_strings( $src ) {
	if( strpos( $src, '?ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
    return $src;
}
add_filter( 'style_loader_src', 'starter_remove_query_strings', 10, 2 );
add_filter( 'script_loader_src', 'starter_remove_query_strings', 10, 2 );
endif;

if ( ! function_exists( 'starter_setup' ) ) :
/**
 * Starter theme setup
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since 1.0
 * @uses hook after_setup_theme
 * @return void
 */
function starter_setup() {

	// Remove junk from the WordPress header.
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'index_rel_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 );

	/*
	 * Make Starter available for translation.
	 *
	 * Translations can be added to the /_languages/ directory.
	 * If you're building a theme based on Starter, use a find and
	 * replace to change 'starter' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'starter', get_template_directory() . '/_languages' );

	/**
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 150, 150, true );

	// Customized CSS for the TinyMCE editor
	add_editor_style( '_css/editor.css' );

	// This theme uses wp_nav_menu()
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'starter' )
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'starter_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Hide admin bar from frontend of your website
	show_admin_bar( false );

}
add_action( 'after_setup_theme', 'starter_setup' );
endif;

global $starter_display_options;
global $starter_social_options;
global $starter_theme_data;

$starter_display_options = get_option( 'starter_display_options' );
$starter_social_options = get_option( 'starter_social_options' );
$starter_theme_data = wp_get_theme();

function starter_footer_copyright() {

	global $starter_theme_data;

	printf(
		'<div id="credits"><p>&copy; %1$s <a href="%2$s" target="_blank" itemprop="copyrightHolder">%3$s</a> <span itemprop="copyrightYear">%4$s<span> - <span>%5$s</span></p></div>',
		__("Copyright", 'starter'),
		$starter_theme_data->get( 'AuthorURI' ),
		$starter_theme_data->get( 'Author' ),
		date('Y'),
		__( 'All Rights Reserved', 'starter' )
	);
}
add_action('wp_footer', 'starter_footer_copyright');

// Include other theme function files.
include_once( STARTER_DIR . '/_includes/admin.php' );
include_once( STARTER_DIR . '/_includes/comments.php' );
include_once( STARTER_DIR . '/_includes/css.php' );
include_once( STARTER_DIR . '/_includes/js.php' );
include_once( STARTER_DIR . '/_includes/search.php' );
include_once( STARTER_DIR . '/_includes/shortcodes.php' );
include_once( STARTER_DIR . '/_includes/template-tags.php' );
include_once( STARTER_DIR . '/_includes/theme-options.php' );
include_once( STARTER_DIR . '/_includes/options/general.php' );
include_once( STARTER_DIR . '/_includes/options/social.php' );
include_once( STARTER_DIR . '/_includes/user.php' );
include_once( STARTER_DIR . '/_includes/widgets.php' );
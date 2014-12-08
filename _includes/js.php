<?php

/**
 * Defer parsing of JavaScript
 *
 * @since 1.0
 * @param string $url 
 * @return string
 */
function starter_defer_js( $url ) {
	if ( false === strpos( $url, '.js?defer' ) ) {
		return $url;
	}
	return "$url' async defer='defer";
}
add_filter( 'clean_url', 'starter_defer_js' );

/**
 * Register and enqueue JavaScript
 *
 * @since 1.0
 * @return void
 */
function starter_load_js() {

	// Load jQuery
	wp_enqueue_script('jquery');

	// Register scripts
	wp_register_script( 'starter-superfish', STARTER_URI . '/_js/superfish.js?defer', array( 'jquery' ), null, true );
	wp_register_script( 'starter-supersubs', STARTER_URI . '/_js/supersubs.js?defer', array( 'jquery', 'starter-superfish' ), null, true );
	wp_register_script( 'starter-hoverintent', STARTER_URI . '/_js/hoverintent.js?defer', array( 'jquery' ), null, true );
	wp_register_script( 'starter-theme', STARTER_URI . '/_js/theme.js?defer', array( 'jquery', 'starter-supersubs', 'starter-superfish' ), null, true );

	// Enqueue Scripts
	wp_enqueue_script( 'starter-hoverintent' );
	wp_enqueue_script( 'starter-superfish' );
	wp_enqueue_script( 'starter-supersubs' );
	wp_enqueue_script( 'starter-theme' );

	// Localized scripts
	wp_localize_script( 'starter-theme', 'starter_localize', starter_localize_theme_js() );

	// Smart inclusion of the "comment-reply" script
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
}
add_action( 'wp_enqueue_scripts', 'starter_load_js' );

/**
 * Localize JavaScript variables
 *
 * @since 1.0
 * @return array
 */
function starter_localize_theme_js() {
	return array( 
		'MenuItemGoto' => _x( 'Go to...', 'The "Go to" text applied when menu is displayed in mobile devices.', 'starter' )
	);
}
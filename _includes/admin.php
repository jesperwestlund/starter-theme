<?php

if ( ! function_exists( 'starter_add_admin_separator' ) ) :
/**
 * Add admin menu separators
 *
 * @since 1.0
 * @global $menu 
 * @param integer $position
 * @return void
 */
function starter_add_admin_separator( $position ) {
	global $menu;
	$index = 0;
	foreach( $menu as $offset => $section ) {
		if ( substr( $section[2], 0, 9 ) == 'separator' ) {
			$index++;
		}
		if ( $offset >= $position ) {
			$menu[ $position ] = array( '', 'read', "separator{$index}", '', 'wp-menu-separator' );
			break;
		}
	}
	ksort( $menu );
}
endif;
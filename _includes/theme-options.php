<?php

function starter_add_theme_options_menu() {

	add_theme_page(
		__( 'Starter Theme Options', 'starter' ), // The title to be displayed in the browser window for this page.
		__( 'Starter Theme', 'starter' ), // The text to be displayed for this menu item
		'manage_options',                 // Which capability is required to see this menu item
		'starter_theme_options',          // The unique ID - that is, the slug - for this menu item
		'starter_render_theme_options',   // The name of the function to call when rendering this menu's page
		'dashicons-admin-settings',
		61
	);

}
add_action('admin_menu', 'starter_add_theme_options_menu');

function starter_render_theme_options() {

	echo "\n<div class=\"wrap\">\n";
	screen_icon();
	echo "\t<h2>" . __( 'Starter Theme Options', 'starter' ) . "</h2>\n";
	
	$tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'display_options';
	
	echo "\t<h2 class=\"nav-tab-wrapper starter-admin-settings\">\n";
	echo "\t\t<a href=\"?page=starter_theme_options&tab=display_options\" class=\"nav-tab  " . ( $tab == 'display_options'  ? 'nav-tab-active' : '' ) . "\">" . __( 'General', 'starter' ) . "</a>\n";
	echo "\t\t<a href=\"?page=starter_theme_options&tab=social_options\" class=\"nav-tab   " . ( $tab == 'social_options'   ? 'nav-tab-active' : '' ) . "\">" . __( 'Social', 'starter' ) . "</a>\n";
	echo "\t</h2>\n";

	settings_errors();

	echo "\t<form class=\"starter-form\" method=\"post\" action=\"options.php\">\n";

	if ( $tab == 'social_options' ) {
		settings_fields( 'starter_social_section' );
		do_settings_sections( 'starter_social_section' );
	} elseif( $tab == 'advanced_options' ) {
		settings_fields( 'starter_advanced_section' );
		do_settings_sections( 'starter_advanced_section' );
	} else {
		settings_fields( 'starter_display_section' );
		do_settings_sections( 'starter_display_section' );
	}

	submit_button();

	echo "\n\t</form>\n";
	echo "</div><!-- .wrap -->\n";
}
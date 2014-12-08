<?php

function starter_load_css() {

	$theme = wp_get_theme();

	wp_register_style( 'starter-grid',  STARTER_URI . '/_css/grid.css', array(), $theme->get('Version') );
	wp_register_style( 'starter-style', get_stylesheet_uri(), array( 'starter-grid' ), $theme->get('Version') );
	wp_register_style( 'starter-menu',  STARTER_URI . '/_css/menu.css', array( 'starter-grid', 'starter-style' ), $theme->get('Version') );

	wp_enqueue_style( 'starter-grid' );
	wp_enqueue_style( 'starter-style' );
	wp_enqueue_style( 'starter-menu' );
}
add_action( 'wp_enqueue_scripts', 'starter_load_css' );

function starter_load_admin_css() {
	wp_register_style( 'starter-admin', get_template_directory_uri() . '/_css/admin.css' );
	wp_enqueue_style( 'starter-admin');
}
add_action( 'admin_init', 'starter_load_admin_css');

function starter_load_fonts() {

	/* font-family: 'Lato', sans-serif; */
	wp_register_style( 'font-lato', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' );
	wp_enqueue_style( 'font-lato' );

	wp_enqueue_style( 'dashicons');
}
add_action( 'wp_enqueue_scripts', 'starter_load_fonts' );
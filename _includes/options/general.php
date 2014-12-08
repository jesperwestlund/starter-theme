<?php

function starter_init_display_options() {

	if ( false == get_option( 'starter_display_options' ) ) {
		add_option( 'starter_display_options', apply_filters( 'starter_default_display_options', starter_default_display_options() ) );
	}

	add_settings_section(
		'display_settings_page',
		__( 'Display Settings', 'starter' ),
		'starter_display_section_cb',
		'starter_display_section'
	);

	add_settings_field(
		'layout',
		__( 'Default Layout<p class="description"><em>Pages using a custom page template is not always affected by this setting, please read the manual included with the theme for more information. Also note that sidebar areas without active widgets will be ignored.</em></p>', 'starter' ),
		'starter_layout_cb',
		'starter_display_section',
		'display_settings_page'
	);

	add_settings_field(
		'show_credits',
		__( 'Credits', 'starter' ),
		'starter_toggle_credits_cb',
		'starter_display_section',
		'display_settings_page',
		array( __( 'Display credits in footer.', 'starter' ) )
	);

	register_setting( 'starter_display_section', 'starter_display_options' );
}
add_action( 'admin_init', 'starter_init_display_options' );

function starter_layout_cb() {
	$options = get_option( 'starter_display_options' );
	$html = '<div class="image-radio-option">';
	$html .= '<label for="layout_one"><input type="radio" id="layout_one" name="starter_display_options[layout]" value="1"' . checked( 1, $options['layout'], false ) . '/>';
	$html .= '<span><img src="'.get_template_directory_uri() . '/_images/admin/content-sidebar.png" width="136" height="122" alt="" />';
	$html .= ''. __( 'Sidebar Right', 'starter' ) .'</span></label>';
	$html .= '<label for="layout_two"><input type="radio" id="layout_two" name="starter_display_options[layout]" value="2"' . checked( 2, $options['layout'], false ) . '/>';
	$html .= '<span><img src="'.get_template_directory_uri() . '/_images/admin/content.png" width="136" height="122" alt="" />';
	$html .= ''. __( 'No Sidebar', 'starter' ) .'</span></label>';
	$html .= '<label for="layout_three"><input type="radio" id="layout_three" name="starter_display_options[layout]" value="3"' . checked( 3, $options['layout'], false ) . '/>';
	$html .= '<span><img src="'.get_template_directory_uri() . '/_images/admin/sidebar-content.png" width="136" height="122" alt="" />';
	$html .= ''. __( 'Sidebar Left', 'starter' ) .'</span></label>';
	$html .= '</div>';
	echo $html;
}

function starter_display_section_cb() {
	echo '<p class="starter-options-container">' . __( 'On this page you determine how your website will be displayed and what features will be visible.', 'starter' ) . '</p>';
}

function starter_default_display_options() {
	$defaults = array(
		'layout'                    => 1,
		'show_credits'              => 1
	);
	return apply_filters( 'starter_default_display_options', $defaults );
}

function starter_toggle_credits_cb( $args ) {
	$options = get_option( 'starter_display_options' );
	$html = '<input type="checkbox" id="show_credits" name="starter_display_options[show_credits]" value="1" ' . checked( 1, isset( $options['show_credits'] ) ? $options['show_credits'] : 0, false ) . '/>'; 
	$html .= '<label for="show_credits">&nbsp;'  . $args[0] . '</label>'; 
	echo $html;
}
<?php

function starter_init_social_options() {

	if ( false == get_option( 'starter_social_options' ) ) {
		add_option( 'starter_social_options', apply_filters( 'starter_default_social_options', starter_default_social_options() ) );
	}

	add_settings_section(
		'social_settings_page',
		__( 'Setup Your Social Networks', 'starter' ),
		'starter_social_section_cb',
		'starter_social_section'
	);

	add_settings_field(
		'publisher',
		__( 'Google Publisher<p class="description"><em>This will Add the rel="publisher" tag to the head of your site, with the URL of you Google+ Business page. <strong>BE CAREFUL</strong> - it <strong>MUST</strong> be a "business page" not a "user page".</em></p>', 'starter' ),
		'starter_publisher_cb',
		'starter_social_section',
		'social_settings_page',
		array( __( 'Google Publisher URL', 'starter' ) )
	);

	register_setting( 'starter_social_section', 'starter_social_options' );
}
add_action( 'admin_init', 'starter_init_social_options' );

function starter_social_section_cb() {
	echo '<p class="starter-options-container">' . __( 'On this page you specify the social identity for your company or brand. Link to relevant pages on the social networks you actively use. These settings is not intended to be used for your personal social network. To setup your personal social networks, please use your profile settings.', 'starter' ) . '</p>';
}

function starter_default_social_options() {
	$defaults = array(
		'publisher' => 1
	);
	return apply_filters( 'starter_default_social_options', $defaults );
}

function starter_publisher_cb( $args ) {
	$options = get_option( 'starter_social_options' );
	$html = '<label for="publisher">&nbsp;'  . $args[0] . '</label>';

	// https://plus.google.com/b/107488134972818982462
	$publisher_link = isset( $options['publisher'] ) ? $options['publisher'] : '';
	
	$html .= '<p><input class="full-width" type="text" id="publisher" name="starter_social_options[publisher]" value="'. $publisher_link .'" /></p>'; 
	
	echo $html;
}
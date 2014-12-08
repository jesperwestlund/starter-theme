<?php

if ( ! function_exists( 'starter_commentlist' ) ) :
/**
 * Callback for wp_list_comments.
 *
 * @param string $comment
 * @param array $args
 * @param integer $depth
 * @return void
 */
function starter_commentlist_cb( $comment, $args, $depth ) {
	global $post;

	extract( $args, EXTR_SKIP );

	echo "\n\t<li ";
	comment_class();
	echo " id=\"comment-" . get_comment_ID() . "\" itemscope itemtype=\"http://schema.org/Comment\">\n";
	echo "\t\t<div class=\"comment-body\">\n";
	echo "\t\t\t<div class=\"comment-text\">\n";

	if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] );

	echo "\t\t<div class=\"comment-meta\">\n";
	echo "\t\t\t<h1 itemprop=\"name\" class=\"author\">" . sprintf( __( '%s', 'starter' ), get_comment_author_link() ) . "</h1>";
	echo "<p><a class=\"comment-permalink\" href=\"". htmlspecialchars ( get_comment_link( $comment->comment_ID ) ) . "\">";
	echo "<span itemprop=\"datePublished\" content=\"" . get_comment_date( 'c' ) . "\">";
	printf( __( '%2$s', 'starter' ), $comment->comment_ID, get_comment_date(), get_comment_time() );
	echo "</a></p>\n";
	echo "\t\t</div><!-- end .comment-meta -->\n";
	echo '<span itemprop="comment">';
	comment_text();	
	echo '</span>';
	comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );

	// Get User Data from Comment User ID
	$user = new WP_User( $comment->user_id );
	$post_author_email = get_user_meta( 'user_email', $post->post_author, true );
	$output = '';
	
	// Render Comment Corner Ribbon if Applicable
	if ( ! empty( $user->roles[0] ) ) {
		
		if ( 'administrator' == $user->roles[0] )
		
			$output = '<div class="ribbon"><div class="ribbon-color-admin"><div class="ribbon-admin">'. __('ADMIN','starter') .'</div></div></div>';
			
			//echo '<div><span class="comment-admin-ribbon"><a href="#">ADMIN</a></span></div>';

		if ( 'author' == $user->roles[0] || 'editor' == $user->roles[0] )

			$output = '<div class="ribbon"><div class="ribbon-color-staff"><div class="ribbon-staff">'. __('STAFF','starter') .'</div></div></div>';
			
			
			// echo '<div class="comment-staff-ribbon"></div>';
			
		if( $comment->user_id == $post->post_author )
			$output = '<div class="ribbon"><div class="ribbon-color-author"><div class="ribbon-author">'. __('AUTHOR','starter') .'</div></div></div>';
			
			//echo '<div class="comment-author-ribbon"></div>';	
	}
	echo $output;
	
	echo "\t\t\t</div><!-- end .comment-text -->\n";	
	echo "\t\t</div><!-- end .comment-body -->\n";
}
endif;

if ( ! function_exists( 'starter_get_comment_args' ) ) :
/**
 * Theme default settings applied to the comment_form function.
 *
 * @see comments.php
 * @return array
 */
function starter_get_comment_args() {

	// Current commenter
	$commenter            = wp_get_current_commenter();
	$required             = get_option( 'require_name_email' );
	$aria_required        = ( $required ? " aria-required='true'" : '' );

	// Comment form field author
	$comment_form_author  = "<p class=\"comment-form-author\">\n";
	$comment_form_author .= "<label for=\"author\">" . __( 'Name', 'starter' )  . ( $required ?  "<span class=\"required\">*</span>" : '' ) . " </label>\n";
	$comment_form_author .= "<input id=\"author\" name=\"author\" type=\"text\" value=\"\" size=\"30\"" . $aria_required . " /></p>\n";

	// Comment form field email
	$comment_form_email  = "<p class=\"comment-form-email\">\n";
	$comment_form_email .= "<label for=\"email\">" . __( 'E-mail', 'starter' )  . ( $required ?  "<span class=\"required\">*</span>" : '' ) . " </label>\n";
	$comment_form_email .= "<input id=\"email\" name=\"email\" type=\"text\" value=\"" . esc_attr(  $commenter['comment_author_email'] ) ."\" size=\"30\"" . $aria_required . " /></p>\n";

	// Comment form field website
	$comment_form_url  = "<p class=\"comment-form-url\">\n";
	$comment_form_url .= "<label for=\"url\">" . __( 'Website', 'starter' ) . "</label>\n";
	$comment_form_url .= "<input id=\"url\" name=\"url\" type=\"text\" value=\"\" size=\"30\" /></p>\n";

	// Comment form fields
	$comment_form_fields = array(
		'author' => $comment_form_author,
		'email'  => $comment_form_email,
		'url'    => $comment_form_url
	);

	// Comment form arguments
	$comment_form_args = array(
		'fields'        => $comment_form_fields,
		'title_reply'   => __( 'Add Your Comment', 'starter' ),
		'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Your Comment', 'noun', 'starter' ) . '</label><div class="textarea-wrapper"><textarea class="box-sizing" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></div></p>',
	);
	return apply_filters( 'starter_comment_args', $comment_form_args );
}
endif;

if ( ! function_exists( 'starter_comments_password_protected' ) ) :
/**
 * Comments output when the current post is password protected.
 *
 * @return string
 */
function starter_comments_password_protected() {
	$output = '';
	$output .= "<ul class=\"commentlist\">\n";
	$output .= "\t<li><p class=\"nopassword\">" . __( 'This post is password protected. Enter the password to view any comments.', 'starter' ) . "</p></li>\n";
	$output .= "</ul>\n";
	return $output;
}
endif;

if ( ! function_exists( 'starter_get_paginate_comments_args' ) ) :
/**
 * Custom paginate comments arguments.
 *
 * @see comments.php
 * @return array
 */
function starter_get_paginate_comments_args() {
	$starter_paginate_comments_args = array(
	    'show_all'     => false,
	    'end_size'     => 1,
	    'mid_size'     => 2,
	    'prev_next'    => true,
	    'prev_text'    => __( '&laquo; Prev', 'starter' ),
	    'next_text'    => __( 'Next &raquo;', 'starter' ),
	    'type'         => 'list',
	    'add_fragment' => ''
	);
	return apply_filters( 'starter_paginate_comments_args', $starter_paginate_comments_args );
}
endif;

if ( ! function_exists( 'starter_comments_canonical' ) ) :
/**
 * Avoid duplicate content by adding a canonical attribute to paged comment listing.
 *
 * @return void
 */
function starter_comments_canonical() {
	global $cpage, $post;
	if ( $cpage > 1 ) {
		echo "\n<link rel=\"canonical\" href=\"" . get_permalink( $post->ID ) . "\">";
	}
}
add_action( 'wp_head', 'starter_comments_canonical' );
endif;
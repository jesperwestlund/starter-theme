<?php
register_sidebar(
	array(
		'name'         => __( 'Sidebar Left', 'starter' ),
		'id'           => 'sidebar-left',
		'description'  => __( 'Widgets in this area will be shown on the left-hand side.', 'starter' ),
		'before_title' => '<h3>',
		'after_title'  => '</h3>'
	)
);
register_sidebar(
	array(
		'name'         => __( 'Sidebar Right', 'starter' ),
		'id'           => 'sidebar-right',
		'description'  => __( 'Widgets in this area will be shown on the right-hand side.', 'starter' ),
		'before_title' => '<h3>',
		'after_title'  => '</h3>'
	)
);
register_sidebar(
	array(
		'name'         => __( 'Sidebar Bottom Left', 'starter' ),
		'id'           => 'sidebar-bottom-left',
		'description'  => __( 'Widgets in this area will be shown oi the footer left-hand side.', 'starter' ),
		'before_title' => '<h3>',
		'after_title'  => '</h3>'
	)
);
register_sidebar(
	array(
		'name'         => __( 'Sidebar Bottom Middle', 'starter' ),
		'id'           => 'sidebar-bottom-middle',
		'description'  => __( 'Widgets in this area will be shown in the footer middle.', 'starter' ),
		'before_title' => '<h3>',
		'after_title'  => '</h3>'
	)
);
register_sidebar(
	array(
		'name'         => __( 'Sidebar Bottom Right', 'starter' ),
		'id'           => 'sidebar-bottom-right',
		'description'  => __( 'Widgets in this area will be shown in the footer right-hand side.', 'starter' ),
		'before_title' => '<h3>',
		'after_title'  => '</h3>'
	)
);
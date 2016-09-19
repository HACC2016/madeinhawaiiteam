<?php

function legacy_user_init() {
	register_post_type( 'legacy-user', array(
		'labels'            => array(
			'name'                => __( 'Legacy users', 'madeinhawaii' ),
			'singular_name'       => __( 'Legacy user', 'madeinhawaii' ),
			'all_items'           => __( 'All Legacy users', 'madeinhawaii' ),
			'new_item'            => __( 'New legacy user', 'madeinhawaii' ),
			'add_new'             => __( 'Add New', 'madeinhawaii' ),
			'add_new_item'        => __( 'Add New legacy user', 'madeinhawaii' ),
			'edit_item'           => __( 'Edit legacy user', 'madeinhawaii' ),
			'view_item'           => __( 'View legacy user', 'madeinhawaii' ),
			'search_items'        => __( 'Search legacy users', 'madeinhawaii' ),
			'not_found'           => __( 'No legacy users found', 'madeinhawaii' ),
			'not_found_in_trash'  => __( 'No legacy users found in trash', 'madeinhawaii' ),
			'parent_item_colon'   => __( 'Parent legacy user', 'madeinhawaii' ),
			'menu_name'           => __( 'Legacy users', 'madeinhawaii' ),
		),
		'public'            => false,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_in_nav_menus' => false,
		'supports'          => array( 'title', 'editor' ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-admin-post',
		'show_in_rest'      => true,
		'rest_base'         => 'legacy-user',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'legacy_user_init' );

function legacy_user_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['legacy-user'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Legacy user updated. <a target="_blank" href="%s">View legacy user</a>', 'madeinhawaii'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'madeinhawaii'),
		3 => __('Custom field deleted.', 'madeinhawaii'),
		4 => __('Legacy user updated.', 'madeinhawaii'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Legacy user restored to revision from %s', 'madeinhawaii'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Legacy user published. <a href="%s">View legacy user</a>', 'madeinhawaii'), esc_url( $permalink ) ),
		7 => __('Legacy user saved.', 'madeinhawaii'),
		8 => sprintf( __('Legacy user submitted. <a target="_blank" href="%s">Preview legacy user</a>', 'madeinhawaii'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Legacy user scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview legacy user</a>', 'madeinhawaii'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Legacy user draft updated. <a target="_blank" href="%s">Preview legacy user</a>', 'madeinhawaii'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'legacy_user_updated_messages' );

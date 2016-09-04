<?php

function product_init() {
	register_post_type( 'product', array(
		'labels'            => array(
			'name'                => __( 'Products', 'en' ),
			'singular_name'       => __( 'Product', 'en' ),
			'all_items'           => __( 'All Products', 'en' ),
			'new_item'            => __( 'New Product', 'en' ),
			'add_new'             => __( 'Add New', 'en' ),
			'add_new_item'        => __( 'Add New Product', 'en' ),
			'edit_item'           => __( 'Edit Product', 'en' ),
			'view_item'           => __( 'View Product', 'en' ),
			'search_items'        => __( 'Search Products', 'en' ),
			'not_found'           => __( 'No Products found', 'en' ),
			'not_found_in_trash'  => __( 'No Products found in trash', 'en' ),
			'parent_item_colon'   => __( 'Parent Product', 'en' ),
			'menu_name'           => __( 'Products', 'en' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'taxonomies'				=> array('category', 'post_tag'),
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'supports'          => array( 'title', 'editor' ),
		'has_archive'       => true,
		'rewrite'           => true,
		'query_var'         => true,
		'menu_icon'         => 'dashicons-carrot',
		'show_in_rest'      => true,
		'rest_base'         => 'product',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
	) );

}
add_action( 'init', 'product_init' );

function product_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['product'] = array(
		0 => '', // Unused. Messages start at index 1.
		1 => sprintf( __('Product updated. <a target="_blank" href="%s">View Product</a>', 'en'), esc_url( $permalink ) ),
		2 => __('Custom field updated.', 'en'),
		3 => __('Custom field deleted.', 'en'),
		4 => __('Product updated.', 'en'),
		/* translators: %s: date and time of the revision */
		5 => isset($_GET['revision']) ? sprintf( __('Product restored to revision from %s', 'en'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Product published. <a href="%s">View Product</a>', 'en'), esc_url( $permalink ) ),
		7 => __('Product saved.', 'en'),
		8 => sprintf( __('Product submitted. <a target="_blank" href="%s">Preview Product</a>', 'en'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		9 => sprintf( __('Product scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Product</a>', 'en'),
		// translators: Publish box date format, see http://php.net/date
		date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		10 => sprintf( __('Product draft updated. <a target="_blank" href="%s">Preview Product</a>', 'en'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	);

	return $messages;
}
add_filter( 'post_updated_messages', 'product_updated_messages' );

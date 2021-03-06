<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

$templates = array( 'archive.twig', 'index.twig' );
global $wp_query;

$context = Timber::get_context();

$context['title'] = 'Archive';
if ( is_tag() ) {
	$context['title'] = single_tag_title( '', false );
} else if ( is_category() ) {
	$context['title'] = single_cat_title( '', false );
	array_unshift( $templates, 'archive-' . get_query_var( 'cat' ) . '.twig' );
} else if ( is_post_type_archive() ) {
	$context['title'] = post_type_archive_title( '', false );
	array_unshift( $templates, 'archive-' . get_post_type() . '.twig' );
}

$context['defaults'] = [
		'child_of'            => 0,
		'current_category'    => 0,
		'depth'               => 0,
		'echo'                => 1,
		'exclude'             => '',
		'exclude_tree'        => '',
		'feed'                => '',
		'feed_image'          => '',
		'feed_type'           => '',
		'hide_empty'          => 1,
		'hide_title_if_empty' => false,
		'hierarchical'        => true,
		'order'               => 'ASC',
		'orderby'             => 'name',
		'separator'           => '<br />',
		'show_count'          => 0,
		'show_option_all'     => '',
		'show_option_none'    => __( 'No categories' ),
		'style'               => 'list',
		'taxonomy'            => 'category',
		'title_li'            => __( 'Categories' ),
		'use_desc_for_title'  => 1,
];

$user_ids = [];
if (isset($_GET['islands'])) {
	$islands = explode(',', $_GET['islands']);
	$context['islands'] = $islands;

	$user_ids = get_users([
		'meta_query' => [
			[
				'key' => 'island',
				'value' => $islands
			]
		],
		'fields' => 'ID'
	]);

} else {
	$user_ids = get_users([
		'role' => 'Subscriber',
		'fields' => 'ID'
	]);
}

$wp_query->query_vars['meta_query'] =
	[
		[
			'key' => 'user',
			'value' => $user_ids,
			'compare' => 'IN'
		]
	];

$context['page'] = get_query_var('paged');
$context['posts'] = Timber::get_posts($wp_query->query_vars);
query_posts($wp_query->query_vars);
$context['pagination'] = Timber::get_pagination();
Timber::render( $templates, $context );

<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */
 global $wpdb;
 global $wp_query;
 use Qaribou\Collection\ImmArray;

$templates = array( 'search.twig', 'archive.twig', 'index.twig' );
$context = Timber::get_context();

$search = $_GET['s'];
$context['search'] = $search;
$context['title'] = 'Search results for &quot;'. get_search_query() . "&quot;";

$vendor_users = get_users([
  'role' => 'Subscriber'
]);

$queried_posts = get_posts([
  'fields' => 'ids',
  'posts_per_page' => -1,
  'meta_key' => 'user',
  'meta_value' => $vendor_users,
  'meta_compare' => 'IN',
  's' => $search
]);

$island_posts = [];
if (isset($_GET['islands'])) {
	$islands = explode(',', $_GET['islands']);
	$context['islands'] = $islands;

	$user_ids = get_users([
		'meta_query' => [
			[
				'key' => 'island',
				'value' => $islands,
        'compare' => 'IN'
			]
		],
		'fields' => 'ID'
	]);

  $user_ids = array_map(function($id) {
    return intval($id);
  }, $user_ids);

	$island_posts = get_posts([
    'fields' => 'ids',
    'post_type' => 'product',
    'posts_per_page' => '-1',
    'meta_query' => [
			[
				'key' => 'user',
				'value' => $user_ids,
				'compare' => 'IN'
			]
    ]
  ]);
}
$wp_query->query_vars['post__in'] = array_merge([], $queried_posts, $island_posts);
$products = Timber::get_posts($wp_query->query_vars);
query_posts($wp_query->query_vars);
$pagination = Timber::get_pagination();

$context['pagination'] = $pagination;
$context['products'] = $products;

$users =
  ImmArray::fromArray($wpdb->get_results("SELECT ID from $wpdb->users WHERE display_name LIKE \"%{$search}%\";"));

$context['users'] =
	$users->map(function($user) {
		return new TimberUser(intval($user->ID));
	});

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

$context['categories'] = get_terms('category', [
	'hide_empty' => false,
	'child_of' => 1
]);

Timber::render( $templates, $context );

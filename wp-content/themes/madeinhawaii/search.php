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

$templates = array( 'search.twig', 'archive.twig', 'index.twig' );
$context = Timber::get_context();

$search = $_GET['s'];
$context['title'] = 'Search results for &quot;'. get_search_query() . "&quot;";
$products =
  Timber::get_posts(
    ['post_type' => 'product', 's' => $search]
  );

$context['products'] = $products;

$users = $wpdb->get_results("SELECT * from $wpdb->users WHERE display_name LIKE \"%{$search}%\";");
$context['users'] = $users;

Timber::render( $templates, $context );

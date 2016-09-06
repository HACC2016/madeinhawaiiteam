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

$templates = array( 'search.twig', 'archive.twig', 'index.twig' );
$context = Timber::get_context();

$context['title'] = 'Search results for &quot;'. get_search_query() . "&quot;";
$products =
  Timber::get_posts(
    ['post_type' => 'product', 's' => $_GET['s']]
  );

$context['products'] = $products;

Timber::render( $templates, $context );

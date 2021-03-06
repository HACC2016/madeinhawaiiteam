<?php
/**
 * The template for displaying Author Archive pages
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */
global $wp_query;

$context = Timber::get_context();
if ( isset( $wp_query->query_vars['author'] ) ) {
	$author = new TimberUser( $wp_query->query_vars['author'] );
	$context['author'] = $author;
	$context['posts'] = Timber::get_posts(['meta_key' => 'user', 'meta_value' => $author->ID, 'post_per_page' => -1, 'post_type' => 'product']);
}
Timber::render( array( 'author.twig', 'archive.twig' ), $context );

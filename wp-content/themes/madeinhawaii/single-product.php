<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */


use Qaribou\Collection\ImmArray;

$context = Timber::get_context();
$product = Timber::query_post();

$context['post'] = $product;

$related_queries =
	ImmArray::fromArray($product->terms())
		->map(function($term) {
			return $term->term_id;
		});

$related = Timber::get_posts([
	'post_type' => 'product',
	'orderby' => 'rand',
	'tax_query' => [
		[
			'taxonomy' => 'category',
			'field' => 'term_id',
			'terms' => json_decode(json_encode($related_queries))
		]
	]
]);

$context['related'] = $related;

if ( post_password_required( $product->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}

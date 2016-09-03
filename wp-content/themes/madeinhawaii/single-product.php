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

$context = Timber::get_context();
$product = Timber::query_post();
$context['post'] = $product;
$users = get_users([
	'meta_key' => 'products',
	'meta_value' => "i:{$post->ID};",
	'meta_compare' => 'LIKE'
]);
$context['users'] = $users;

if ( post_password_required( $product->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}

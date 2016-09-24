<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */


use Qaribou\Collection\ImmArray;

$context = Timber::get_context();

if(!$context['current_user']->ID) {
  wp_redirect('/');
}

$leaves = ImmArray::fromArray(get_terms([ 'hide_empty' => false ]));

$products =
  $leaves->reduce(function($arr, $leaf) {
    return array_merge($arr, [$leaf->name]);
  }, []);

$context['products'] = $products;

$user_products =
  Timber::get_posts([
    'posts_per_page' => -1,
    'meta_key' => 'user',
    'meta_value' => $context['current_user']->ID
  ]);

$context['user_products'] = $user_products;

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );

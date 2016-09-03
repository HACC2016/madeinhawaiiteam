<?php

use Qaribou\Collection\ImmArray;

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

$context = Timber::get_context();
$page = $_GET['page'] ?? 1;
$context['page'] = $page;
$users =
	ImmArray::fromArray(
		get_users([
			'fields' => 'ID',
			'number' => 10,
			'role__not_in' => ['Administrator'],
			'paged' => $page
		])
	);

$context['users'] =
	$users->map(function($user) {
		return new TimberUser(intval($user));
	});

Timber::render( array( 'page-' . $post->post_name . '.twig', 'page.twig' ), $context );

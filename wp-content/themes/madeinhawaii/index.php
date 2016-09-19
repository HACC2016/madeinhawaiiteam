<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

use Qaribou\Collection\ImmArray;

if ( ! class_exists( 'Timber' ) ) {
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}
$context = Timber::get_context();
$users =
	ImmArray::fromArray(
		get_users([
			'fields' => 'ID',
			'number' => 10,
			'role__not_in' => ['Administrator'],
		])
	);

$context['users'] =
	$users->map(function($user) {
		return new TimberUser(intval($user));
	});

$templates = array( 'index.twig' );
Timber::render( $templates, $context, 10600, TimberLoader::CACHE_OBJECT);

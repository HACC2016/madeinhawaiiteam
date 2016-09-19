<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

use Qaribou\Collection\ImmArray;

require('routes/index.php');
require('post-types/product.php');

Timber::$dirname = array('templates', 'components', 'modules');

class MadeInHawaii extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'admin_menu', [$this, 'remove_menus']);
		add_theme_support( 'admin-bar', array( 'callback' => '__return_false') );

		add_image_size('thumb', 600, 300, true);

		parent::__construct();
	}


	function remove_menus() {
		remove_menu_page('edit.php');
		remove_menu_page('edit-comments.php');
		remove_menu_page('upload.php');
		// remove_menu_page( 'themes.php' );
	}

	function register_post_types() {
		//this is where you can register custom post types
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */

		$twig->addFunction(
			new Twig_SimpleFunction('register_form', function() {
				acf_form([
					'post_id' => 'new',
					'field_groups' => [30]
				]);
			})
		);

		$twig->addFunction(
			new Twig_SimpleFunction('product_image', function($product) {
				if(!empty($product->image)) {
					return new TimberImage($product->image);
				}
				$terms = ImmArray::fromArray($product->terms('category'));
				$images =
					$terms
						->filter(function($term) {
							return $term->image;
						})
						->sort(function($one, $two) {
							$first_ancestors = count(get_ancestors($one->term_id, 'category'));
							$second_ancestors = count(get_ancestors($two->term_id, 'category'));
							if($first_ancestors < $second_ancestors) {
								return -1;
							}

							if($first_ancestors >  $second_ancestors) {
								return 1;
							}
							return 0;
						});

				error_log(print_r(count($images), true));

				if(count($images)) {
				  $img = new TimberImage($images[count($images) - 1]->image['id']);
					return $img;
				}
				return new TimberImage('https://placehold.it/600x300');
			})
		);

		$twig->addExtension( new Twig_Extension_StringLoader() );
		return $twig;
	}

}

new MadeInHawaii();

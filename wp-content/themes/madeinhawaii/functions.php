<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

use Qaribou\Collection\ImmArray;

require('routes/index.php');
require('fields/user_fields.php');
require('fields/product.php');
require('post-types/product.php');
require('post-types/legacy-user.php');

Timber::$dirname = array('templates', 'components');

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
		add_image_size('product', 748, 0, false);

    add_action( 'pre_get_posts', [$this, 'my_home_query'] );

		if(class_exists('Jigsaw')) {
			Jigsaw::add_column('product', 'User', function($pid) {
				$user_id = get_post_meta($pid, 'user', true);
				$user = new TimberUser($user_id);
				echo $user->display_name;
			});
		}

		parent::__construct();
	}

		function my_home_query( $query ) {
      if ($query->is_category && !is_admin() ) {
        $query->set( 'post_type', ['product'] );
      }
    }

	function remove_menus() {
		remove_menu_page('edit.php');
		remove_menu_page('edit-comments.php');
		// remove_menu_page('upload.php');
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
		$context['current_user'] = wp_get_current_user();
		return $context;
	}

function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */

		$twig->addFunction(
			new Twig_SimpleFunction('register_form', function() {
				acf_form([
					'post_id' => 'new',
					'field_groups' => ['acf_user-fields'],
					'form' => false
				]);
			})
		);

		$twig->addFunction(
			new Twig_SimpleFunction('product_image', function($product) {
				$found = true;
				if(!empty($product->image)) {
					return [
						'found' => $found,
						'img' => new TimberImage($product->image)
					];
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

				if(count($images)) {
				  $img = new TimberImage($images[count($images) - 1]->image['id']);

					return [
						'found' => $found,
						'img' => $img
					];
					return $img;
				}
				return [
					'found' => false,
					'img' => new TimberImage('https://placehold.it/600x300')
				];
			})
		);

		$twig->addFunction(
			new Twig_SimpleFunction('dropdown', function() {
				wp_dropdown_categories([
					'show_option_all' => 'All Products'
				]);
			})
		);

		$twig->addFunction(new Twig_SimpleFunction('admin_button', function($post) {
	    return get_edit_post_link($post->ID, 'Edit');
	  }));

		$twig->addExtension( new Twig_Extension_StringLoader() );
		return $twig;
	}

}

new MadeInHawaii();

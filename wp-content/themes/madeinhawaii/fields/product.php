<?php if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_product',
		'title' => 'Product',
		'fields' => array (
			array (
				'key' => 'field_57cde35560546',
				'label' => 'User',
				'name' => 'user',
				'type' => 'user',
				'role' => array (
					0 => 'subscriber',
				),
				'field_type' => 'select',
				'allow_null' => 0,
			),
			array (
				'key' => 'field_57cde382d6120',
				'label' => 'Categories',
				'name' => 'categories',
				'type' => 'taxonomy',
				'taxonomy' => 'category',
				'field_type' => 'checkbox',
				'allow_null' => 0,
				'load_save_terms' => 0,
				'return_format' => 'id',
				'multiple' => 0,
			),
			array (
				'key' => 'field_57ce67ca9911d',
				'label' => 'Status',
				'name' => 'status',
				'type' => 'radio',
				'choices' => array (
					'available_now' => 'Available Now',
					'hide' => 'Hide On Searches',
					'coming_soon' => 'Coming Soon',
				),
				'other_choice' => 0,
				'save_other_choice' => 0,
				'default_value' => 'available_now',
				'layout' => 'vertical',
			),
			array (
				'key' => 'field_57cde420d5298',
				'label' => 'Image',
				'name' => 'image',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'all',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
				0 => 'the_content',
				1 => 'excerpt',
				2 => 'custom_fields',
				3 => 'discussion',
				4 => 'comments',
				5 => 'revisions',
				6 => 'slug',
				7 => 'format',
				8 => 'featured_image',
				9 => 'categories',
				10 => 'tags',
				11 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
}
 ?>

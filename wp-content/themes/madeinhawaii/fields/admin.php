<?php if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_admin',
		'title' => 'Admin',
		'fields' => array (
			array (
				'key' => 'field_57e60f2a9625a',
				'label' => 'Valid Company',
				'name' => 'valid_company',
				'type' => 'true_false',
				'message' => 'Uncheck to remove company from list of companies.',
				'default_value' => 1,
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
				array (
					'param' => 'ef_user',
					'operator' => '==',
					'value' => 'administrator',
					'order_no' => 1,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
 ?>

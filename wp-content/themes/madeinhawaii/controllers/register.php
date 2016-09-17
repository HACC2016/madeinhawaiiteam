<?php

  /**
   *  Registers user
   */
  if(!isset($_POST['email'])) {
    wp_redirect('/register');
  }


  $user_login = sanitize_title($_POST['email']);

  $args = [
    'user_login' => $user_login,
    'user_email' => $_POST['email'],
    'user_pass' => $_POST['password']
  ];
  $user_id = wp_insert_user($args);

  if(! is_wp_error($user_id)) {
    $fields = acf_field_group::get_fields(null, 30);

    foreach($_POST['fields'] as $key => $val) {
      $field = array_shift(array_filter($fields, function($field) use($key) {
        return $field['key'] == $key;
      }));
      $name = $field['name'];
      update_user_meta($user_id, $name, $val);
      update_user_meta($user_id, "_{$name}", $key);
    }

    wp_redirect('/signup-success');
  } else {
    wp_redirect('/register');
  }

?>

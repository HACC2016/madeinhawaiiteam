<?php
  if(! class_exists('Routes')) {
    die('Upstatement router needed');
  }

  Routes::map('/import-users', function() {
    Routes::load('/controllers/import_users.php');
  });

  Routes::map('/import-products', function() {
    Routes::load('/controllers/import_products.php');
  });

  Routes::map('/categories', function() {
    Routes::load('/controllers/categories.php');
  });

  Routes::map('/signup', function() {
    Routes::load('/controllers/register.php');
  });
?>

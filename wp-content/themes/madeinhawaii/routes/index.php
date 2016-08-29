<?php
  if(! class_exists('Routes')) {
    die('Upstatment router needed');
  }

  Routes::map('/import-users', function() {
    Routes::load('/controllers/import_users.php');
  });
?>

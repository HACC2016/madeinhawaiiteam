<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>


<?php
  wp_list_categories([
    'hide_empty' => false
  ]);
  // $cats = get_categories(['hide_empty' => FALSE, 'parent' => NULL]);
  // foreach($cats as $cat) {
  //   echo $cat->name . '<br/>';
  // }
?>

  </body>
</html>

<?php
use League\Csv\Reader;
use Qaribou\Collection\ImmArray;

$reader = Reader::createFromPath('_doc/products-2.csv');
$results = ImmArray::fromArray($reader->fetchAll());
$results->map(function($row){
  $parts = preg_split('/_/', $row[0]);
  $name = $parts[1];
  $cat = $parts[0];
  $id = wp_insert_post([
    'post_type' => 'product',
    'post_status' => 'publish',
    'post_title' => $parts[1]
  ]);
  $cat_obj = get_category_by_slug($cat);
  wp_set_post_categories($id, [$cat_obj->term_id]);
});

?>

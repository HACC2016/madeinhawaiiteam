<?php
use League\Csv\Reader;
use Qaribou\Collection\ImmArray;

$reader = Reader::createFromPath('_doc/vendors.csv');
$results = ImmArray::fromArray($reader->fetchAll());


foreach($results as $row) {
  $id = intval($row[0]);
  update_user_meta($id, "wp_capabilities", ['subscriber']);
  update_user_meta($id, "wp_user_level",  0);
}
?>

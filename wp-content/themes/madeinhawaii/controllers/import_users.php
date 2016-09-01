<?php
use League\Csv\Reader;
use Qaribou\Collection\ImmArray;

$reader = Reader::createFromPath('_doc/vendors.csv');
$results = ImmArray::fromArray($reader->fetchAll());
$beginning_index = 62;

$mapping = [
  "ffruit_bananas",
  "ffruit_citrus",
  "ffruit_papaya",
  "ffruit_avocado",
  "ffruit_exotictrop",
  "ffruit_pineapple",
  "ffruit_other",
  "ffruit_other",
  "fruitpuree_papaya",
  "fruitpuree_guava",
  "fruitpuree_other",
  "fruitpuree_otherdesc",
  "fveg_cabbages",
  "fveg_otherleafy",
  "fveg_ginger",
  "fveg_onions",
  "fveg_taro",
  "fveg_otherroot",
  "fveg_herbs",
  "fveg_other",
  "fveg_otherdesc",
  "macnut_plainroasted",
  "macnut_candiedchoco",
  "macnut_other",
  "macnut_otherdesc",
  "bsfood_cookies",
  "bsfood_crackers",
  "bsfood_candies",
  "bsfood_chips",
  "bsfood_driedfruits",
  "bsfood_crackseed",
  "bsfood_other",
  "bsfood_otherdesc",
  "cond_sauces",
  "cond_syrups",
  "cond_spreads",
  "cond_jamsjellies",
  "cond_dressing",
  "cond_seasonmix",
  "cond_soups",
  "cond_presfruits",
  "cond_pickveg",
  "cond_other",
  "cond_otherdesc",
  "coffee_bigislandexkona",
  "coffee_kona",
  "coffee_molokai",
  "coffee_maui",
  "coffee_kauai",
  "coffee_oahu",
  "bev_tea",
  "bev_drinkmix",
  "bev_concentrates",
  "bev_juices",
  "bev_alcoholic",
  "bev_other",
  "bev_otherdesc",
  "meat_beef",
  "meat_pork",
  "meat_poultry",
  "meat_driedsmoke",
  "meat_other",
  "meat_otherdesc",
  "dairy_icecream",
  "dairy",
  "milk",
  "dairy_other",
  "dairy_otherdesc",
  "oseafood_fresh",
  "oseafood_frozen",
  "oseafood_processed",
  "oseafood_other",
  "oseafood_other",
  "aqua_fresh",
  "aqua_frozen",
  "aqua_processed",
  "aqua_other",
  "aqua_otherdesc",
  "health_prod",
  "health_proddesc",
  "mfg_other",
  "mfg_otherdesc",
  "floral_anthuriums",
  "floral_anthuriumsdesc",
  "floral_other",
  "floral_otherdesc",
  "floral_foliage",
  "floral_foliagedesc",
  "floral_leis",
  "floral_leisdesc",
  "orch_dendrobiums",
  "orch_oncidium",
  "orch_vandas",
  "orch_phalaenopsis",
  "orch_cymbidium",
  "orch_other",
  "orch_otherdesc",
  "trop_heloncias",
  "trop_birdparadise",
  "trop_gingers",
  "trop_other",
  "trop_otherdesc",
  "protea_kings",
  "protea_queens",
  "protea_banksia",
  "protea_minks",
  "protea_pincushions",
  "protea_duchess",
  "protea_other",
  "protea_otherdesc",
  "potplant_dracaena",
  "potplant_palms",
  "potplant_bromeliads",
  "potplant_ferns",
  "potplant_ﬁcus",
  "potplant_succulents",
  "potplant_bonsai",
  "potplant_other",
  "potplant_otherdesc",
  "potorch_denbrobiums",
  "potorch_phalaenopsis",
  "potorch_cattleya",
  "potorch_oncidium",
  "potorch_hybrids",
  "potorch_species",
  "potorch_other",
  "potorch_otherdesc",
  "potflower_chrysanthemums",
  "potflower_poiniettias",
  "potflower_gesneriads",
  "potflower_bulbs",
  "potflower_anthuriums",
  "potflower_hibiscus",
  "potflower_bromeliads",
  "potflower_other",
  "potflower_otherdesc",
  "landplants_palms",
  "landplants_shrubs",
  "landplants_bedding",
  "landplants_groundcover",
  "landplants_specimentree",
  "landplants_vines",
  "landplants_lowerplants",
  "Iandplants_lowertrees",
  "landplants_other",
  "landplants_otherdesc",
  "propag_seeds",
  "propag_cuttings",
  "propag_liners",
  "propag_plugs",
  "propag_micropropagative",
  "propag_other",
  "propag_otherdesc",
];

foreach($results as $row) {
  $id = intval($row[0]);
  $products = [];
  for ($i=0; $i < 152; $i++) {
    $has_product = boolval($row[62 + $i]);
    if($has_product === TRUE) {
      $prod = $mapping[$i];
      $parts = preg_split('/_/', $prod);
      if($parts[1] == 'otherdesc') {
        continue;
      }
      $single_products = get_posts([
        'post_type' => 'product',
        's' => $parts[1],
        'tax_query' => [
          [
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $parts[0]
          ]
        ]
      ]);
      $products = array_merge($products, $single_products);
    }

  }
  $product_ids = array_map(function($p) { return $p->ID; }, $products);
  echo $id;
  print_r($product_ids);
  echo "<br/><br/>";
  update_user_meta($id, "products", $product_ids);
  update_user_meta($id, "_products", "field_57c687c497a14");
}
?>

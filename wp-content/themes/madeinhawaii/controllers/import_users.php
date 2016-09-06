<?php
use League\Csv\Reader;
use Qaribou\Collection\ImmArray;

$reader = Reader::createFromPath('_doc/vendors.csv');
$results = ImmArray::fromArray($reader->fetchAll());


/**
 *  32 => tob_grower
 *
 */

$types = [
  32 => 'grower',
  33 => 'distributor',
  34 => 'wholesaler',
  35 => 'processor',
  36 => 'manufacturer',
  37 => 'retailer'
];

$services = [
  39 => 'mailorder',
  40 => 'delivery',
  41 => 'packing',
  42 => 'growing',
  43 => 'labeling',
  44 => 'bulk',
  45 => 'retail'
];

$markets = [
  48 => 'hawaii',
  49 => 'guam',
  50 => 'china',
  51 => 'australia',
  52 => 'usmain',
  53 => 'japan',
  54 => 'hongkong',
  55 => 'europe',
  56 => 'canada',
  57 => 'korea',
  58 => 'seasia'
];

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
  // die(var_dump($row));
  $id = intval($row[0]);
  $these_types = [];
  foreach ($types as $i => $value) {
    if(boolval($row[$i]) === TRUE) {
      $these_types[] = $value;
    }
  }
  update_user_meta($id, 'products', $these_types);
  update_user_meta($id, '_products', 'field_57c687c497a14');
  $these_services = [];
  foreach ($services as $i => $value) {
    if(boolval($row[$i]) === TRUE) {
      $these_services[] = $value;
    }
  }
  update_user_meta($id, 'services', $these_types);
  update_user_meta($id, '_services', 'field_57cdfc28f278b');


  $these_markets = [];
  foreach ($markets as $i => $value) {
    if(boolval($row[$i]) === TRUE) {
      $these_markets[] = $value;
    }
  }
  update_user_meta($id, 'services', $these_types);
  update_user_meta($id, '_services', 'field_57cdfc28f278b');

  for ($i=62 ; $i < 152 ; $i++) {
    $cats = [];
    $args = [
      'post_type' => 'product',
      'post_status' => 'publish',
      'post_author' => $id
    ];
    if(boolval($row[$i]) === TRUE) {
      $parts = preg_split('/_/', $mapping[$i - 62]);
      if(substr_count($parts[1], 'other')) {
        continue;
      }

      $parent = get_category_by_slug($parts[0]);
      if($parent) {
        $cats[] = (string) $parent->term_id;
      }

      $child = get_category_by_slug($parts[1]);
      if($child) {
        $cats[] = (string) $child->term_id;
        $args['post_title'] = $child->name;
      } else {
        $args['post_title'] = $parts[1];
      }

      $args['post_category'] = $cats;
      $args['meta_input'] = [
        'user' => $id,
        '_user' => 'field_57cde35560546',
        'categories' => $cats,
        '_categories' => 'field_57cde382d6120',
        'in_stock' => 0,
        '_in_stock' => 'field_57cde416d5297',
        'coming_soon' => 0,
        '_coming_soon' => 'field_57cdf4c89484e',
        'image' => '',
        '_image' => 'field_57cde420d5298'
      ];
      wp_insert_post($args);
    }
  }
}
?>

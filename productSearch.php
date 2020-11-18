<?php

$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path . '/wp-config.php');
global $wpdb;
$search_term = trim($_POST["search_term"]);
$catid = $_POST['catid'];
$brandid = $_POST['brand_id'];
$posts_per_page = $_POST['number_of_posts'];
$sort_by_select = $_POST['sort_by_select'];


if ($search_term) {
   $searchCheck = "  CONCAT(LOWER(title), sku,enum) LIKE LOWER('%" . $search_term . "%') AND";
}
if ($catid !== 'alla') {
    $taxquery = " LEFT JOIN {$wpdb->prefix}term_relationships cat ON({$wpdb->prefix}Product_Search.id = cat.object_id) ";
    $taxsql = 'cat.term_taxonomy_id = ' . $catid . ' AND ';
}

if ($brandid != 'alla') {
    $brandquery = " LEFT JOIN {$wpdb->prefix}term_relationships brand ON({$wpdb->prefix}Product_Search.id = brand.object_id)  ";
    $brandsql = ' brand.term_taxonomy_id  = ' . $brandid . ' AND ';
}
if ($sort_by_select == 0)
    $sortOrder = " ORDER BY {$wpdb->prefix}Product_Search.total_sales DESC ";
if ($posts_per_page != '-1')
    $postperPageCheck = " LIMIT " . $posts_per_page;
if ($sort_by_select == 1)
    $sortOrder = " ORDER BY {$wpdb->prefix}Product_Search.title ASC ";
if ($sort_by_select == 2)
    $sortOrder = " ORDER BY {$wpdb->prefix}Product_Search.title DESC ";
if ($sort_by_select == 3) {
//$star = " {$wpdb->prefix}Product_Search.regular_price > 0 AND ";
    $sortOrder = " ORDER BY {$wpdb->prefix}Product_Search.regular_price ASC ";
}
if ($sort_by_select == 4) {

//$star = " {$wpdb->prefix}Product_Search.price > 99999 AND ";
    $sortOrder = " ORDER BY {$wpdb->prefix}Product_Search.regular_price DESC ";
}
if ($sort_by_select == 5) {
if ($search_term) {
    $searchCheck = "  CONCAT(LOWER(title), sku,enum) LIKE LOWER('" . $search_term . "%') AND";
}
}

if ($_POST['only_related']) {
    $head_products = $_POST["head_products"];
    $crosssells = [];

    foreach ($head_products as $head_product) {
        $crosssells_for_head_product = get_post_meta($head_product, '_crosssell_ids', true);
        foreach ($crosssells_for_head_product as $newid) {
            array_push($crosssells, $newid);
        }
    }

    $related = "{$wpdb->prefix}Product_Search.id IN (" . implode(',', $crosssells) . ") AND ";
} else {
    $related = "{$wpdb->prefix}Product_Search.id NOT IN (SELECT object_id FROM {$wpdb->prefix}term_relationships WHERE term_taxonomy_id IN (9)) AND ";
}

 $newsql = "SELECT * FROM {$wpdb->prefix}Product_Search" . $brandquery . $taxquery . " WHERE  " . $related . $taxsql . $brandsql . $searchCheck . " 1=1 " . $sortOrder . " " . $postperPageCheck;
$result = $wpdb->get_results($newsql);

$j = 1;
$json_array = array();
foreach ($result as $page) {
    $id = $page->id;
		 $product_instance = wc_get_product($id);
    $product_short_description = $product_instance->get_short_description();
   // $product_description = $product_instance->get_description();

    $title = $page->title;
    $Rprice = $page->regular_price;
    $Sprice = $page->sale_price;
    $sku = $page->sku;
    if (!empty($Sprice)) {
        $fromDate = get_post_meta($id, '_sale_price_dates_from', true);
        $toDate = get_post_meta($id, '_sale_price_dates_to', true);
        if (empty($fromDate) && empty($toDate)) {
            $Rprice = $page->sale_price;
            /* $symbols = '<i class="fa fa-certificate" style="color:red"></i>';
              $orderprice = $page->regular_price*25/100;
              $totalorderprice = $orderprice+$page->regular_price; */
        } else {
            $_sale_price_dates_from = date('Y-m-d', $fromDate);
            if (!empty($_sale_price_dates_from)) {
                $Begin_date = date('Y-m-d', strtotime($_sale_price_dates_from . ' +1 day'));
            }
            $_sale_price_dates_to = date('Y-m-d', $toDate);
            if (!empty($_sale_price_dates_to)) {
                $End_date = date('Y-m-d', strtotime($_sale_price_dates_to . ' +1 day'));
            } else {
                if (!empty($_sale_price_dates_from)) {
                    $End_date = date('Y-m-d', strtotime("+1 day"));
                }
            }
            $today = date("Y-m-d");

            if ($Begin_date <= $today && $today <= $End_date) {
                $symbols = '<i class="fa fa-certificate" style="color:red"></i>';
                $orderprice = $page->regular_price * 25 / 100;
                $totalorderprice = $orderprice + $page->regular_price;
                $Rprice = $page->sale_price;
            } else {
                $Rprice = $page->regular_price;
            }
        }
    }

    $attachment_id = empty($page->product_image) ? 25982 : $page->product_image;
    $image = wp_get_attachment_image_src($attachment_id);
    $src = wp_get_attachment_image_src($attachment_id, 'full', false, '');
    $calReg = $Rprice * 25 / 100;
    $term = wc_get_product_term_ids($id, 'product_cat');
    $i = 0;
    $len = count($term);
    $catCont = '';
    foreach ($term as $term_s) {
        $cat = get_term_by('id', $term_s, 'product_cat');
        if ($cat->name != 'Uncategorized'):
            $catCont .= $cat->name;
            if ($i !== $len - 1) {
                $catCont .= '->';
            }
        endif;
        $i++;
    };
	$getBrand = get_the_terms($id,'item');
    $order_array = array(
        'id' => $id,
        'title' => $title,
        'ExMom' => $symbols . wc_price($Rprice),
        'InMom' => wc_price($Rprice + $calReg),
        'image' => $image[0],
        'sku' => $sku,
        'sale_price' => $Sprice,
		'brand'=>$getBrand[0]->name,
        'checksale' => ($totalorderprice) ? wc_price($totalorderprice) : '',
        'more_button' => json_encode(array('data-product-short-desc'=>wp_strip_all_tags($product_short_description),
		'data-weight'=>$product_instance->weight,'data-length'=>$product_instance->length,'data-height'=>$product_instance->height,'data-width'=>$product_instance->width,'data-regular-sale' => $totalorderprice, 'data-product-id' => $id, 'data-product-sku' => $page->sku, 'data-product-image-url' => $src[0], 'data-product-sale-price' =>
            $Sprice, 'data-product-regular-price' => $Rprice + $calReg . " kr", 'data-product-rea-price' => $Rprice, 'data-terms' => $catCont), JSON_PRETTY_PRINT)
    );
    array_push($json_array, $order_array);
    $j++;
    $title = $Rprice = $Sprice = $term = $attachment_id = $image = $calReg = $totalorderprice = $symbols = $product_description = $product_short_description ='';
}
echo json_encode($json_array, JSON_PRETTY_PRINT);

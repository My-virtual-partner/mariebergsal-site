<?php
/**
 * Some helper functions related to WooCommerce.
 */


function return_params_for_woocommerce_products( $product_categories = null, $head_products = null ) {
    $crosssells = [];

    foreach ( $head_products as $head_product ) {
        $crosssells_for_head_product = get_post_meta( $head_product, '_crosssell_ids', true );
        array_push( $crosssells, $crosssells_for_head_product );

    }

    $params = array(
        'posts_per_page' => 10,
        'post_type'      => 'product',
        'meta_key'=> 'total_sales',
        'orderby'   => 'meta_value_num',
        'order' => 'desc',
        'post__in'       => $crosssells[0],

    );

    if ( $product_categories ) {
        $params = array(
            'posts_per_page' => 10,
            'post_type'      => 'product',
            'meta_key'=> 'total_sales',
            'orderby'   => 'meta_value_num',
            'order' => 'desc',
            'post__in'       => $crosssells[0],
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id', //This is optional, as it defaults to 'term_id'
                    'terms'    => $product_categories,
                    'operator' => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
                )
            )
        );
    }

    return $params;

}

function get_categories_dropdown($all_categories, $taxonomy, $orderby, $hierarchical) {

    $newarray = [];

    echo "<select id='prod_id' name='prod_id' class='form-control js-sortable-select'>";



    echo '<option name="woo-cats" value="alla">' . __("Alla") . '</option>';


    foreach ($all_categories as $cat) {

       

        if ($cat->category_parent == 0) {
            $category_id = $cat->term_id;
           
            $selected_category = $_GET["product_categories"][0]->term_id;
          
            if ($category_id !== '1035') {
                if ($selected_category == $cat->term_id) {
                    $selecteddata = "selected";
                } else {
                    $selecteddata = "";
                }
                /*      if ($selected_category == $cat->term_id) {
                  echo '<option name="woo-cats" value="' . $selected_category . '" selected> ' . $cat->name . '</option>';
                  } else { */
                echo '<option name="woo-cats" value="' . $cat->term_id . '" ' . $selecteddata . '> ' . $cat->name . '</option>';
                $firstcat = $cat->name . ">";
                $newarray[] = $cat->term_id;
                $args2 = array(
                    'taxonomy' => $taxonomy,
                    'parent' => $cat->term_id,
                    'orderby' => $orderby,
                    'hierarchical' => $hierarchical,
                );
                $sub_cats = get_categories($args2);

                if ($sub_cats) {
                    foreach ($sub_cats as $sub_category) {
                        $newarray[] = $sub_category->term_id;
                        if ($selected_category == $sub_category->term_id) {
                            echo '<option name="woo-cats" value="' . $selected_category . '" selected> ' . $firstcat . $sub_category->name . '</option>';
                        } else {
                            echo '<option  name="woo-cats" value=" ' . $sub_category->term_id . '">  ' . $firstcat . $sub_category->name . '</option>';
                        }
                        $args3 = array(
                            'taxonomy' => $taxonomy,
                            'parent' => $sub_category->term_id,
                            'orderby' => $orderby,
                            'hierarchical' => $hierarchical,
                        );
                        $sub_cats_2 = get_categories($args3);
                        $secondcat = $firstcat . $sub_category->name . ">";
                        if ($sub_cats_2) {

                            foreach ($sub_cats_2 as $sub_category_2) {
                                $newarray[] = $sub_category_2->term_id;
                                echo '<option  name="woo-cats" value=" ' . $sub_category_2->term_id . '"> ' . $secondcat . $sub_category_2->name . '</option>';

                                $args4 = array(
                                    'taxonomy' => $taxonomy,
                                    'parent' => $sub_category_2->term_id,
                                    'orderby' => $orderby,
                                    'hierarchical' => $hierarchical,
                                );
                                $sub_cats_3 = get_categories($args4);
                                $thirdcat = $secondcat . $sub_category_2->name . ">";
                                if ($sub_cats_3) {
                                    foreach ($sub_cats_3 as $sub_category_3) {
                                        $newarray[] = $sub_category_3->term_id;
                                        echo '<option  name="woo-cats" value=" ' . $sub_category_3->term_id . '">  ' . $thirdcat . $sub_category_3->name . '</option>';
                                        $args5 = array(
                                            'taxonomy' => $taxonomy,
                                            'parent' => $sub_category_3->term_id,
                                            'orderby' => $orderby,
                                            'hierarchical' => $hierarchical,
                                        );
                                        $sub_cats_4 = get_categories($args5);
                                        $forthcat = $thirdcat . $sub_category_3->name . ">";
                                        if ($sub_cats_4) {
                                            foreach ($sub_cats_3 as $sub_category_4) {
                                                $newarray[] = $sub_category_4->term_id;
                                                echo '<option  name="woo-cats" value=" ' . $sub_category_4->term_id . '"> ' . $forthcat . $sub_category_4->name . '</option>';
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                // }
            }
        }
    }

    echo "</select>";
    return json_encode($newarray);
}

//
//function get_categories_dropdown( $all_categories, $taxonomy, $orderby, $hierarchical ) {
//$newarray = [];
//
//    echo "<select id='prod_id' name='prod_id' class='form-control js-sortable-select'>";
//
//
//
//        echo '<option name="woo-cats" value="alla">' . __("Alla") . '</option>';
//
//
//    foreach ( $all_categories as $cat ) {
//
//
//
//        if ($cat->category_parent == 0) {
//            $category_id = $cat->term_id;
//
//            $selected_category = $_GET["product_categories"][0];
//
//            if ($category_id !== '1035') {
//             if ($selected_category == $cat->term_id) { $selecteddata ="selected";}else{  $selecteddata ="";}
//       /*      if ($selected_category == $cat->term_id) {
//                echo '<option name="woo-cats" value="' . $selected_category . '" selected> ' . $cat->name . '</option>';
//            } else { */
//echo '<option name="woo-cats" value="' . $cat->term_id . '" '.$selecteddata.'> ' . $cat->name . '</option>';
//$firstcat = $cat->name.">";
//$newarray[] = $cat->term_id;
//                $args2 = array(
//                    'taxonomy' => $taxonomy,
//                    'parent' => $cat->term_id,
//                    'orderby' => $orderby,
//                    'hierarchical' => $hierarchical,
//
//                );
//                $sub_cats = get_categories($args2);
//
//                if ($sub_cats) {
//                    foreach ($sub_cats as $sub_category) {
//						$newarray[] = $sub_category->term_id;
//                        if ($selected_category == $sub_category->term_id) {
//                            echo '<option name="woo-cats" value="' . $selected_category . '" selected> ' . $firstcat.$sub_category->name . '</option>';
//                        }else {
//                            echo '<option  name="woo-cats" value=" ' . $sub_category->term_id . '">  ' . $firstcat.$sub_category->name . '</option>';
//                        }
//                        $args3 = array(
//                            'taxonomy' => $taxonomy,
//                            'parent' => $sub_category->term_id,
//                            'orderby' => $orderby,
//                            'hierarchical' => $hierarchical,
//
//                        );
//                        $sub_cats_2 = get_categories($args3);
//$secondcat = $firstcat.$sub_category->name.">";
//                        if ($sub_cats_2) {
//
//                            foreach ($sub_cats_2 as $sub_category_2) {
//								$newarray[] = $sub_category_2->term_id;
//                                echo '<option  name="woo-cats" value=" ' . $sub_category_2->term_id . '"> ' . $secondcat.$sub_category_2->name . '</option>';
//
//                                $args4 = array(
//                                    'taxonomy' => $taxonomy,
//                                    'parent' => $sub_category_2->term_id,
//                                    'orderby' => $orderby,
//                                    'hierarchical' => $hierarchical,
//
//                                );
//                                $sub_cats_3 = get_categories($args4);
//$thirdcat = $secondcat.$sub_category_2->name.">";
//                                if ($sub_cats_3) {
//                                    foreach ($sub_cats_3 as $sub_category_3) {
//										$newarray[] = $sub_category_3->term_id;
//                                        echo '<option  name="woo-cats" value=" ' . $sub_category_3->term_id . '">  ' . $thirdcat.$sub_category_3->name . '</option>';
//                                        $args5 = array(
//                                            'taxonomy' => $taxonomy,
//                                            'parent' => $sub_category_3->term_id,
//                                            'orderby' => $orderby,
//                                            'hierarchical' => $hierarchical,
//
//                                        );
//                                        $sub_cats_4 = get_categories($args5);
//$forthcat = $thirdcat.$sub_category_3->name.">";
//                                        if ($sub_cats_4) {
//                                            foreach ($sub_cats_3 as $sub_category_4) {
//												$newarray[] = $sub_category_4->term_id;
//                                                echo '<option  name="woo-cats" value=" ' . $sub_category_4->term_id . '"> ' . $forthcat.$sub_category_4->name . '</option>';
//                                            }
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }
//           // }
//        }
//        }
//    }
//
//    echo "</select>";
//	return json_encode($newarray);
//}

function get_brand_dropdown( $all_categories, $taxonomy, $orderby, $hierarchical ) {
$brandall = [];

    echo "<select id='brand_id' name='brand_id' class='form-control js-sortable-select'>";



        echo '<option name="woo-cats" value="alla">' . __("Alla") . '</option>';


    foreach ( $all_categories as $cat ) {
        if ($cat->category_parent == 0) {
            $category_id = $cat->term_id;
            $selected_category = $_GET["product_categories"][0];
            if ($category_id !== '1035') {

            if ($selected_category == $cat->term_id) {
                echo '<option name="woo-cats" value="' . $selected_category . '" selected> ' . $cat->name . '</option>';
            } else {
                echo '<option name="woo-cats" value="' . $cat->term_id . '"> ' . $cat->name . '</option>';


                }
				$brandall[] = $cat->term_id;
            }
        }
        }


    echo "</select>";
	return json_encode($brandall);
}

add_action( 'init', 'custom_taxonomy_Brand' );
function custom_taxonomy_Brand() {
    $labels = array(
        'name'                       => 'Brands',
        'singular_name'              => 'Brand',
        'menu_name'                  => 'Brand',
        'all_items'                  => 'All Brands',
        'parent_item'                => 'Parent Brand',
        'parent_item_colon'          => 'Parent Brand:',
        'new_item_name'              => 'New Brand Name',
        'add_new_item'               => 'Add New Brand',
        'edit_item'                  => 'Edit Brand',
        'update_item'                => 'Update Brand',
        'separate_items_with_commas' => 'Separate Brand with commas',
        'search_items'               => 'Search Brands',
        'add_or_remove_items'        => 'Add or remove Brands',
        'choose_from_most_used'      => 'Choose from the most used Brands',
    );
    $args   = array(
        'labels'            => $labels,
        'hierarchical'      => true,
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud'     => true,
    );
    register_taxonomy( 'item', 'product', $args );
    register_taxonomy_for_object_type( 'item', 'product' );
}
<?php
/**
 * Lead create form.
 * Simply creates a new lead when posted.
 */
include_once(plugin_dir_path(__FILE__) . 'head.php');
$params = array(
    'posts_per_page' => 10,
    'post_type' => 'product',

);

$brand = 'item';
$orderby = 'name';
$hierarchical = 1;      // 1 for yes, 0 for no

$args_brand = array(
    'taxonomy' => $brand,
    'orderby' => $orderby,
    'hierarchical' => $hierarchical,

);

$all_categories_brand = get_categories($args_brand);

$wc_query = new WP_Query($params);


?>

    <div class="row">
        <div class="container">


            <div class="col-md-2 col-sm-12">
                <label class="top-buffer-half" for="imm-sale-search"><?php echo __("Sökning") ?></label>
                <input value="" type="text" name="imm-sale-search" class="form-control" id="imm-sale-search"
                       placeholder="<?php echo __("Sök efter artikel..."); ?>">
            </div>
			
			<input type="hidden" id="grid_or_list" value="0">
			<input type="hidden" id="buttonnotshow" value="0">
            <div class="col-md-3 col-sm-12">
                <label class="top-buffer-half" for="imm-sale-search"><?php echo __("Artikelkategori") ?></label>
                <select id='prod_id' name='prod_id' class='form-control js-sortable-select'>
                    <option name="woo-cats" value="alla">Alla</option>
                    <?php
                    get_categories_select();
                    ?>
                </select>
            </div>
			<div class="col-md-3 col-sm-12">
			   <label class="top-buffer-half" ><?php echo __("Sortering") ?></label>
			<select  name="" class="form-control sort_by_select " style="" >
				 <option value="1"  selected="selected" data-select2-id="15">A-Ö</option>
                    <option value="0">Mest sålda</option>
                    <option value="2">Ö-A</option>
                    <option value="3">Lägsta pris</option>
                    <option   value="4">Högsta pris</option>
					<option value="5" >Exakt sökning</option>
                </select>
			</div>
            <div class="col-md-2 col-sm-12">
                <label class="top-buffer-half" for=""><?php echo __("Märke") ?></label>
                <?php
                get_brand_dropdown($all_categories_brand, $brand, $orderby, $hierarchical);
                ?>
            </div>

            <div class="col-md-2 col-sm-12">
                <?php get_number_of_posts_dropdown("number-of-products", null, "top-buffer-half"); ?>
            </div>


            <div class="col-lg-12 col-md-12 col-sm-12 top-buffer-half">

            <div class="row">
			<div id="gridviewproducts"></div>
<table class="table hideclass" onload="filter_and_return_products()">
<thead>
<tr><td>Bild</td><td>Artikelnr</td><td>Benämning</td><td>Varumärke</td><td>Pris exkl.moms</td><td>Pris inkl.moms</td><td></td></tr>
</thead>
<tbody id="getProductList">


</tbody></table>
                <?php
            /*     while ( $wc_query->have_posts() ) :
                    $wc_query->the_post();
                    include( 'single-product-card.php' );
                endwhile; */ ?>
            </div>


        </div>

        </div>
    </div>

<?php


function get_categories_select()
{

    $taxonomy = 'product_cat';
    $orderby = 'name';
    $hierarchical = 1;      // 1 for yes, 0 for no

    $args = array(
        'taxonomy' => $taxonomy,
        'orderby' => $orderby,
        'hierarchical' => $hierarchical,

    );

    $all_categories = get_categories($args);

    foreach ($all_categories as $cat) {
        if ($cat->category_parent == 0) {
            $category_id = $cat->term_id;
            echo '<option name="woo-cats" value="' . $cat->term_id . '"> ' . $cat->name . '</option>';
$firstcat = $cat->name.">";
            $args2 = array(
                'taxonomy' => $taxonomy,
                'parent' => $category_id,
                'orderby' => $orderby,
                'hierarchical' => $hierarchical,

            );
            $sub_cats = get_categories($args2);

            if ($sub_cats) {
                foreach ($sub_cats as $sub_category) {
                    echo '<option  name="woo-cats" value=" ' . $sub_category->term_id . '">  ' .$firstcat.$sub_category->name . '</option>';
$secondcat = $firstcat.$sub_category->name.">";
                    $args3 = array(
                        'taxonomy' => $taxonomy,
                        'parent' => $sub_category->term_id,
                        'orderby' => $orderby,
                        'hierarchical' => $hierarchical,

                    );
                    $sub_cats_2 = get_categories($args3);

                    if ($sub_cats_2) {
                        foreach ($sub_cats_2 as $sub_category_2) {
                            echo '<option  name="woo-cats" value=" ' . $sub_category_2->term_id . '">  '.$secondcat.$sub_category_2->name . '</option>';
$thirdcat =  $secondcat.$sub_category_2->name.">";
                            $args4 = array(
                                'taxonomy' => $taxonomy,
                                'parent' => $sub_category_2->term_id,
                                'orderby' => $orderby,
                                'hierarchical' => $hierarchical,

                            );
                            $sub_cats_3 = get_categories($args4);

                            if ($sub_cats_3) {
                                foreach ($sub_cats_3 as $sub_category_3) {
                                    echo '<option  name="woo-cats" value=" ' . $sub_category_3->term_id . '">'.$thirdcat.$sub_category_3->name . '</option>';
								$forthcat =	$thirdcat.$sub_category_3->name.">";
                                    $args5 = array(
                                        'taxonomy' => $taxonomy,
                                        'parent' => $sub_category_3->term_id,
                                        'orderby' => $orderby,
                                        'hierarchical' => $hierarchical,

                                    );
                                    $sub_cats_4 = get_categories($args5);

                                    if ($sub_cats_4) {
                                        foreach ($sub_cats_3 as $sub_category_4) {
                                            echo '<option  name="woo-cats" value=" ' . $sub_category_4->term_id . '"> ' . $forthcat.$sub_category_4->name . '</option>';
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


}

?>

<?php wp_footer(); ?>
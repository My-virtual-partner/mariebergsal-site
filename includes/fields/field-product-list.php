<?php

/**
 * Webshop view for the plugin.
 */

$product_categories = $_GET["product_categories"];

//print_r($product_categories);

$step_no = $_GET["step"];

$order = wc_get_order( $_GET["order-id"] );

$head_product = [];
foreach ( $order->get_items() as $order_item ) {
    if ( $order_item["HEAD_ITEM"] == 1 ) {
        array_push( $head_product, $order_item["product_id"] );
    }
}
$params = return_params_for_woocommerce_products( $product_categories[0]->term_id, $head_product );

$wc_query = new WP_Query( $params );

$taxonomy     = 'product_cat';
$brand     = 'item';
$orderby      = 'name';
$hierarchical = 1;      // 1 for yes, 0 for no

$args = array(
    'taxonomy'     => $taxonomy,
    'orderby'      => $orderby,
    'hierarchical' => $hierarchical,

);

$args_brand = array(
    'taxonomy'     => $brand,
    'orderby'      => $orderby,
    'hierarchical' => $hierarchical,

);

$all_categories = get_categories( $args );
//print_r($all_categories);
$all_categories_brand = get_categories( $args_brand );


?>
<div class="row">
<!--    <div class="col-md-12">
        <label class="top-buffer-half" for=""><?php /*echo __( "Artikelkategori" ) */?></label>
        <?php
/*        get_categories_dropdown1( $all_categories, $taxonomy, $orderby, $hierarchical );
        */?>
    </div>-->
    <div class="col-lg-12">

        <?php if ( $_GET["show_dropdown"] ) : ?>
            <div class="col-md-3 col-sm-12">
                <label class="top-buffer-half" for="imm-sale-search"><?php echo __( "Sökning" ) ?></label>
                <input value="" type="text" name="imm-sale-search" class="form-control" id="imm-sale-search"
                       placeholder="<?php echo __( "Sök efter artikel..." ); ?>">
            </div>
            <div class="col-md-7 col-sm-12">
                <label class="top-buffer-half" for=""><?php echo __( "Artikelkategori" ) ?></label>
                <?php
               $newvalue =  get_categories_dropdown( $all_categories, $taxonomy, $orderby, $hierarchical );
                ?>
				<input type="hidden" id="cateall" value="<?php echo  $newvalue;?>" />
            </div>
            <div class="col-md-2 col-sm-12">
                <label class="top-buffer-half" for=""><?php echo __( "Varumärke" ) ?></label>
                <?php
              $brandvalue =  get_brand_dropdown( $all_categories_brand, $brand, $orderby, $hierarchical );
                ?>
				<input type="hidden" id="brandall" value="<?php echo  $brandvalue;?>" />
            </div>

           

        <?php endif;?>

            <div class="col-md-8" style="<?php if($step_no === '0'){echo 'visibility: hidden';}?>">

                <div class="checkbox">
                    <label>
                        <?php
$current_user_role = get_user_role();

$project_type_id = get_field('order_project_type', $_GET["order-id"]);
$newvalue = modify_projectType($project_type_id);
$steps = get_field($newvalue, 'options');
$new_steps = in_array_r($project_type_id, $steps, true);
$fields_array=$new_steps["steps"];
$step = $_GET["step"];
$heading_name = $fields_array[$step]["step_heading"];
if ($heading_name == 'Lägg till monteringskostnader' || $heading_name == 'Välj taksäkerhet' || $heading_name == 'Etablering, frakter, avfall') {
    $checked='';
}else{
    $checked='checked';
}

                        if ($_GET["required"]) {

                            echo ' <input '.$checked.' id="get_products_related_to_head" name="get_products_related_to_head"
                           type="checkbox"
                           value=""> ' . __("Hämta endast produkter relaterade till huvudartikel");
                        } else {

                            echo ' <input  id="get_products_related_to_head" name="get_products_related_to_head"
                           type="checkbox"
                           value=""> ' . __("Hämta endast produkter relaterade till huvudartikel");

                        }

                        ?>


                    </label>
                </div>

            </div>


        <div class="col-md-12">
            <div class="col-md-3">

                <span class="order_product_list"><i class="fa fa-th-list fa-2x"></i></span>
                <span class="order_product_grid"><i class="fa fa-th-large fa-2x"></i></span>
            </div>
            <div class="col-md-3">

            </div>
            
            <div class="col-md-3 col-sm-12 custom-anal">
			<label class="top-buffer-half antal-label" for="">Sortering</label>
                <select name="" class='js-sortable-select form-control sort_by_select' style="float:right" >
				 <option value="1" selected>A-Ö</option>
                    <option value="0" >Mest sålda</option>
                    <option value="2">Ö-A</option>
                    <option value="3">Lägsta pris</option>
                    <option value="4" >Högsta pris</option>
					<option value="5" >Exakt sökning</option>
                </select>
            </div>
             <?php if ( $_GET["show_dropdown"] ) : ?>
            <div class="col-md-3 col-sm-12 custom-anal">
                <?php get_number_of_posts_dropdown( "number-of-products", null,"null", "top-buffer-half" ); ?>
            </div>
             <?php endif; ?>
        </div>
   

        <div class="col-lg-12 col-md-12 col-sm-12 top-buffer-half">

            <div class="row">
			<div id="gridviewproducts"></div>
<table class="table hideclass">
<thead>
<tr><td>Bild</td><td>Benämning</td><td>Varumärke</td><td>Pris exkl.moms</td><td>Pris inkl.moms</td><td id="checksaleon" style="display:none">Ord. pris</td></tr>
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
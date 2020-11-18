
<?php
/**
 * Single product card. Used to populate product grid in field-product-list.php
 */
$product = new WC_Product(get_the_ID());
$image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');

$image_url = $image[0];
if (!$image) {
    $image_url = get_field('product_placeholder', 'options');
}


$attributes = $product->get_attributes();

$attributes_for_json = array();

if ($attributes) {
    foreach ($attributes as $key => $value) {

        if ($value['is_taxonomy']) {
            $attribute_names = wc_get_product_terms($product->ID, $value['name'], array('fields' => 'names'));
        } else {
            $attribute_names = array_map('trim', explode(WC_DELIMITER, $value['value']));
        }
        $name = $value['name'];
        $title = wc_attribute_label($value["name"]);

        array_push($attributes_for_json, array(
            'title' => $title,
            'id' => $value["id"],
            'name' => $name,
            'options' => $attribute_names
        ));
    }
    $json_attributes = htmlspecialchars(json_encode($attributes_for_json, JSON_UNESCAPED_UNICODE));
}
?>
<tr>
    <td width="15%">

        <img class="img-product" src="<?php echo $image_url; ?>" alt="" style="width: auto;max-height: 40px;">

    </td>
    <td width="35%" style="text-align: left">
        <p style=""><?php echo $product->get_title(); ?></p>
    </td>

    <td width="10%">
          <!--<strong style="text-align: center;">-->
<?php
if ($product > 0) {

    if ($product->get_sale_price()) {
        $p_regular_price_decemal = ' <i class="fa fa-certificate" style="color:red"></i> ' . wc_price($product->get_sale_price());
    } else {

        $p_regular_price_decemal = wc_price($product->get_regular_price());
    }


    echo '<p
                                
                              
                                class=""
                                id="" style="text-align: left;">' . $p_regular_price_decemal . ' exkl moms
                            </p>';


//                        $p_regular_price_decemal = $product->get_regular_price();
//
//                        $p_price_null = '0';
//
//                        echo  '<p
//                                            
//                                          
//                                            class=""
//                                            id="" style="text-align: left;">'.round($p_regular_price_decemal).' kr exkl moms
//                                        </p>';
} else {
    echo '<p
                                            
                                          
                                            class="btn-brand btn-block top-buffer-half "
                                            id="" style="text-align: left;"> 0 kr
                                        </p>';
}

//                echo round($product->get_regular_price()) .' kr exkl moms '; 
?>
        <!--</strong>-->
    </td>

    <td  width="10%">
        <strong style="text-align: center;">
<?php
if ($product > 0) {
    $p_regular_price_decemal = $product->get_price_including_tax();

    $p_price_null = '0';

    echo '<p
                                            
                                          
                                            class=""
                                            id="" style="text-align: left;">' . $p_regular_price_decemal . ' kr inkl moms
                                        </p>';
} else {
    echo '<p
                                            
                                          
                                            class="btn-brand btn-block top-buffer-half "
                                            id="" style="text-align: left;"> 0 kr
                                        </p>';
}
?>
        </strong>
    </td>




    <td  width="15%">
        <button
            type="button"
            data-toggle="modal"
            data-target="#product_modal_art<?php the_ID(); ?>"
            class="btn btn-alpha btn-block top-buffer-half toggle-product-modal-art"
            id=""  style="width: 120px;float:right; "><?php echo __("Mer info"); ?>
        </button>

    </td>

</tr>


<div class="modal fade" id="product_modal_art<?php the_ID(); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLongTitle"><?php the_title(); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="col-lg-12 col-md-12 col-sm-12 text-center" style="    margin-bottom: 20px;">
                            <img id="" style="max-height: 200px;width: auto; " src="<?php echo $image_url; ?>">
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <ul class="list-unstyled">
                                <li>

                                    <h4 class="product-title"><?php the_title(); ?></h4>
                                    <p class="product_category">
<?php
$term = wc_get_product_term_ids($product->get_id(), 'product_cat');
$i = 0;
$len = count($term);

foreach ($term as $term_s) {
    $cat = get_term_by('id', $term_s, 'product_cat');
    if ($cat->name != 'Uncategorized'):
        echo $cat->name;
        if ($i !== $len - 1) {
            echo '->';
        }
    endif;
    $i++;
};
?>

                                        <?php if ($attributes) : ?>
                                            data-product-attributes="<?php echo addslashes($json_attributes); ?>"
                                        <?php endif; ?>

                                    </p>


                                </li>


                                <!--<li><a id="product-webshop-url" href="<?php //the_permalink();  ?>"-->
                                       <!--target="_blank"><?php // echo __('Visa artikel i webbshop');  ?></a></li>-->
<?php
$regular_price=$product->get_regular_price()*25/100;
                        $total_price=$product->get_regular_price()+$regular_price;
if ($product->is_on_sale()) {
    ?>
                                    <li class="productPrice"
                                        style="background-color:#ff5912;color:#fafafa;padding: 5px; text-decoration: line-through;">Ordinarie Pris : <?php 
    echo $total_price;
    ?> kr</li>
                                    <li class="ReaproductPrice"
                                        style="background-color:#ff5912;color:#fafafa;padding: 5px;">Nedsatt Pris : <?php echo wc_price($product->get_price_including_tax()); ?> inkl moms</li>
                                    


    <?php
} else {
    
    ?>
                                    <li class="productPrice"
                                        style="background-color:#ff5912;color:#fafafa;padding: 5px; text-decoration: none;">Ordinarie Pris : <?php 
    echo $total_price;
    ?> kr</li>
                                    

    <?php
}
?>
                            </ul>
                            <hr>
                            <div id="product-content"><?php echo $product->post->post_excerpt; ?></div>
                            <hr>
                            <ul class="list-unstyled">

                                <li><strong>Artikelnummer: </strong><?php echo $product->get_sku(); ?></li>
                                <li><strong>Exkl. moms: </strong><?php echo wc_price($product->get_regular_price()); ?></li>

                                <li><strong>Moms: </strong> <?php echo wc_price($product->get_price_including_tax() - $product->get_regular_price()); ?></li>
                                <li><strong>Totalt: </strong><?php echo wc_price($product->get_price_including_tax()); ?></li>
                            </ul>



                        </div>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-brand" data-dismiss="modal">Stäng</button>
            </div>
        </div>
    </div>
</div>
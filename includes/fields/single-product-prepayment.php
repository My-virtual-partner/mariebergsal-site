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
    <td width="25%" style="text-align: left">
        <p style=""><?php echo $product->get_title(); ?></p>
    </td>


    <td width="20%">
        <strong style="text-align: center;">
            <?php
            if ($product > 0) {
                if ($product->get_sale_price()) {
                    $p_regular_price_decemal = ' <i class="fa fa-certificate" style="color:red"></i>' . wc_price($product->get_sale_price());

                } else {

                    $p_regular_price_decemal = wc_price($product->get_regular_price());
                }

                $p_price_null = '0';

                echo '<p
                                            
                                          
                                            class=""
                                            id="" style="text-align: center;">' . $p_regular_price_decemal . ' 
                                        </p>';
            } else {
                echo '<p
                                            
                                          
                                            class="btn-brand btn-block top-buffer-half "
                                            id="" style="text-align: center;"> 0 kr
                                        </p>';
            }

            ?>
        </strong>

    </td>


    <td width="15%">
        <label for="">Antal:
            <input type="number" class="quantityPrepayment" value="1">
        </label>
    </td>
    <td width="25%" style="text-align: right;">
        <a href="#" class="laggtillPrepaymentProduct btn btn-brand" data-pid="<?php echo $product->get_id()?>">lägg till</a>
    </td>


</tr>

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


<div class="col-md-6 col-sm-12" style="height:570px">
    <div class="panel panel-default">
        <div class="panel-body">
            <img class="img-responsive img-product" src="<?php echo $image_url; ?>" alt="">
        </div>

        <div class="panel-footer">
            <p style="text-align: center;"><strong><?php echo $product->get_title(); ?></strong></p>

            <span>
                <strong style="text-align: center;">
                <?php
                if ($product > 0) {
                    if ($product->get_sale_price()) {
                        $p_regular_price_decemal = ' <i class="fa fa-certificate" style="color:red"></i> '. wc_price($product->get_sale_price());

                    } else {

                        $p_regular_price_decemal = wc_price($product->get_regular_price());
                    }



                    echo '<p
                                
                              
                                class=""
                                id="" style="padding-left: 5px;padding-right: 5px;">' . round($p_regular_price_decemal) . ' exkl moms
                            </p>';
                    echo '<p
                                
                              
                                class=""
                                id="" style="padding-left: 5px;padding-right: 5px;">' . round(wc_price($product->get_price_including_tax())) . ' exkl moms
                            </p>';
                } else {
                    echo '<p
                                
                              
                                class="btn-brand btn-block top-buffer-half "
                                id="" style="padding-left: 5px;padding-right: 5px;"> 0 kr
                            </p>';
                }

                ?>
                    </strong>
            </span>
            <ul class="list-inline text-center">

                <li>
                    <button
                            type="button"
                            data-toggle="modal"
                            data-product-sku="<?php echo $product->get_sku(); ?>"
                            data-product-id="<?php the_ID(); ?>"
                            data-product-image-url="<?php echo $image_url; ?>"
                            data-product-title="<?php the_title(); ?>"
                            data-product-webshop-url="<?php the_permalink(); ?>"
                            data-product-description="<?php the_content(); ?>"
                            data-product-sale-price="<?php $sale_price='1';if( $product->is_on_sale() ) { echo $sale_price;
                        }else{echo "";}?>"
                             <?php
                        $regular_price=$product->get_regular_price()*25/100;
                        $total_price=$product->get_regular_price()+$regular_price;
                        ?>
                        data-product-rea-price="<?php echo $total_price;?>"


                            data-product-regular-price="<?php 
                            echo $product->get_price_including_tax().' kr';
?>"
                            data-terms="<?php $term = wc_get_product_term_ids($product->get_id(), 'product_cat');
                            $i = 0;
                            $len = count($term);

                            foreach ($term as $term_s) {
                                $cat = get_term_by('id', $term_s, 'product_cat');
                                $cat_id = $cat->term_taxonomy_id;
                                $cat_name = $cat->name;
                                $cat_parent = $cat->parent;
                                if ($cat_parent === 0) {
                                    echo $cat_name;
                                }

                                /* if ($cat->name != 'Uncategorized'):
                                     echo $cat->name;
                                     if ($i !== $len - 1) {
                                         echo '->';
                                     }
                                 endif;
                                */
                                $i++;
                            }; ?>"


                        <?php if ($attributes) : ?>
                            data-product-attributes="<?php echo addslashes($json_attributes); ?>"
                        <?php endif; ?>
                            data-target="#product-modal"
                            class="btn btn-alpha btn-block top-buffer-half toggle-product-modal"
                            id=""><?php echo __("Mer info"); ?>
                    </button>
                </li>


                <?php


                if (!$attributes) : ?>


                    <li>
                        <button
                                type="button"
                                data-product-id="<?php the_ID(); ?>" data-head="false"
                                class="btn btn-brand btn-block top-buffer-half add-to-invoice-quick "
                                id=""><?php echo __("Lägg till"); ?>
                        </button>
                    </li>
                <?php endif; ?>

            </ul>

        </div>

    </div>
</div>

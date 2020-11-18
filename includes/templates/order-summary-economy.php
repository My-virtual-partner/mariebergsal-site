<?php
/**
 * Economy summary. Used to display articles and invoice data in a simple view for economy.
 */
wp_head();
$logotype_url = get_option('logotype_image_url');

$order_id = $_GET["order-id"];
$order_key = $_GET["order-key"];

$order = new WC_Order($order_id);
$order_data = return_array_from_json(get_field('orderdata_json', $order_id));
//$current_customer_id = $order->get_customer_id();
$order_accept_status = get_field('order_accept_status', $order->get_id());
$custom_order_number = get_post_meta($order->ID, 'custom_order_number')[0];
$projectid = get_post_meta($order->ID, 'imm-sale_project_connection')[0];
$current_customer_id = get_post_meta($projectid, 'invoice_customer_id')[0];
?>

<header class="clearfix">
    <nav class="navbar navbar-default ">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="<?php echo site_url(); ?>/system-dashboard">
                    <img class="sale-logo" src="<?php echo $logotype_url; ?>" alt="logotype">
                </a>
            </div>
        </div>
    </nav>

</header>

<div class="container">
    <h1><?php echo "#" . $custom_order_number; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <h3><?php echo __("Kunduppgifter"); ?></h3>
            <ul class="list-unstyled">
                <li><?php echo getCustomerName($current_customer_id); ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'customer_individual_organisation_number')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_company')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_address_1')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_address_2')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_postcode')[0] . " " . get_user_meta($current_customer_id, 'billing_city')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_phone')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_phone_2')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_email')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'customer_other')[0] ?></li>

            </ul>
        </div>
        <div class="col-lg-6">
            <h3><?php echo __("Leveransadress"); ?></h3>
            <ul class="list-unstyled">
                <li><?php echo get_user_meta($current_customer_id, 'shipping_first_name')[0] . " " . get_user_meta($current_customer_id, 'shipping_last_name')[0]; ?></li>
                <li><?php
                    if (get_user_meta($current_customer_id, 'shipping_address_1')[0]) {
                        echo get_user_meta($current_customer_id, 'shipping_address_1')[0]
                        ?></li>
                <?php } else { ?>
                    <li>Ingen seperat leveransadress</li>
<?php } ?>
                <li><?php echo get_user_meta($current_customer_id, 'shipping_address_2')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'shipping_contact_number')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'shipping_postcode')[0] . " " . get_user_meta($current_customer_id, 'shipping_city')[0] ?></li>

            </ul>
        </div>
    </div>
</div>
<hr>
<div class="container">
    <h3><?php echo __("Artikelinformation"); ?></h3>

    <div class="row">
        <div class="col-lg-12">

            <table class="table">
                <thead>
                    <tr>
                        <th><?php echo __("Artikelnummer"); ?></th>
                        <th><?php echo __("Benämning"); ?></th>
                        <th><?php echo __("Pris ex moms"); ?></th>
                        <th><?php echo __("Moms"); ?></th>
                        <th><?php echo __("Totalt"); ?></th>
                        <th><?php echo __("Inköpspris"); ?></th>
                        <th><?php echo __("TB"); ?></th>
                        <th><?php echo __("Antal"); ?></th>
                    </tr>
                </thead>
                <tbody> <?php
                    $sorting_wise = unserialize(get_post_meta($order_id, "head_sortorderitems", true));
                    $sortorderitems = unserialize(get_post_meta($order_id, 'sortorderitems', true));

                    $newvalue = array_merge($sorting_wise, $sortorderitems);
                    $newvalue = array_unique($newvalue);
                    if (!empty($newvalue)) {
                        foreach ($newvalue as $limeid) {
                            foreach ($order->get_items() as $key => $lineItem) :
                                $item_data = $lineItem->get_data();
                                if ($limeid == $item_data['id']) {
                                    $product = new WC_Product($lineItem['product_id']);
                                    $product_inc_mom = wc_price(wc_get_price_including_tax($product));
                                    $product_exc_mom = wc_get_price_excluding_tax($product); // price without VAT
                                    $product_inc_mom = wc_get_price_including_tax($product);  // price with VAT
                                    $tax_amount = $product_inc_mom - $product_exc_mom;
                                    if (!empty($lineItem['internal_cost'])) {
                                        $rrp_price = $lineItem['internal_cost'];
                                    } else {
                                        $rrp_price = str_replace(',', '', get_field('inkopspris_exkl_moms', $lineItem['product_id']));
//                                            echo $rrp_price;
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $product->get_sku(); ?></td>
                                        <td><?php echo $lineItem['name']; ?>
                                            <i><?php echo $lineItem["line_item_special_note"]; ?></i>
                                        </td>
                                        <td><?php echo wc_price($product_exc_mom); ?></td>
                                        <td><?php echo wc_price($tax_amount); ?></td>
                                        <td><?php echo wc_price($product_inc_mom); ?></td>
                                        <td><?php echo wc_price($rrp_price); ?></td>
                                        <td><?php echo wc_price($product_exc_mom - $rrp_price); ?></td>
                                        <td>
                                            <?php
                                            if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar') {

                                                echo $lineItem['quantity'];
                                            } else {
                                                echo 1;
                                            }
                                            ?></td>
                                    </tr>

                                <?php
                                } endforeach;
                        }
                    } else {
                        foreach ($order->get_items() as $key => $lineItem) :

                            $product = new WC_Product($lineItem['product_id']);
                            $product_inc_mom = wc_price(wc_get_price_including_tax($product));
                            $product_exc_mom = wc_get_price_excluding_tax($product); // price without VAT
                            $product_inc_mom = wc_get_price_including_tax($product);  // price with VAT
                            $tax_amount = $product_inc_mom - $product_exc_mom;
                            if (!empty($lineItem['internal_cost'])) {
                                $rrp_price = $lineItem['internal_cost'];
                            } else {
                                $rrp_price = str_replace(',', '', get_field('inkopspris_exkl_moms', $lineItem['product_id']));
//                                            echo $rrp_price;
                            }
                            ?>
                            <tr>
                                <td><?php echo $product->get_sku(); ?></td>
                                <td><?php echo $lineItem['name']; ?>
                                    <i><?php echo $lineItem["line_item_special_note"]; ?></i>
                                </td>
                                <td><?php echo wc_price($product_exc_mom); ?></td>
                                <td><?php echo wc_price($tax_amount); ?></td>
                                <td><?php echo wc_price($product_inc_mom); ?></td>
                                <td><?php echo wc_price($rrp_price); ?></td>
                                <td><?php echo wc_price($product_exc_mom - $rrp_price); ?></td>
                                <td>
                                    <?php
                                    if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar') {

                                        echo $lineItem['quantity'];
                                    } else {
                                        echo 1;
                                    }
                                    ?></td>
                            </tr>

    <?php
    endforeach;
}
?>


                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>

<div class="container">
    <h3><?php echo __("Projektdata"); ?></h3>

    <div class="row">

        <div class="col-lg-12">
            <ul class="list-unstyled">
                <?php
                foreach ($order_data as $data) :
                    if (strpos($data['label'], 'Uppskattad') === FALSE) {
                        if (strpos($data['label'], 'Arbetsorder') === FALSE) {
                            if (strpos($data['label'], 'kund') === FALSE) {
                                ?>
                                    <?php if ($data["label"] && $data["value"]) : ?>
                                    <li><?php
                                        if (strpos($data["value"], 'jpg') !== false || strpos($data["value"], 'png') || strpos($data["value"], 'jpeg') || strpos($data["value"], 'gif')) {
                                            echo $data["label"] . ": " . '<a href="' . $data["value"] . '" target="_blank" style="color: #1812ff;">' . $data["value"] . '</a>';
                                        } else {
                                            echo $data["label"] . ": " . $data["value"];
                                        }
                                        ?></li>
                                    <?php
                                endif;
                            }
                        }
                    }
                    ?>
<?php endforeach; ?>
            </ul>

        </div>
    </div>

</div> <!-- /container -->

<div class="container">
    <h3><?php echo __("Arbetsorder"); ?></h3>
    <ul class="list-unstyled">
        <?php
        foreach ($order_data as $data) :
            if (strpos($data['label'], 'kund') === FALSE) {
                if (strstr($data['label'], 'Uppskattad')) {
                    ?>
                    <li><?php echo $data["label"] . ": " . $data["value"] ?></li>
                <?php }
            }
            ?>
<?php endforeach; ?>
<?php
$arbetsorder = get_post_meta($_GET["order-id"], 'Arbetsorder', true);
if (!empty($arbetsorder)) {
    ?>
            <li><span style="float:left; padding-right:10px;">Arbetsorder:</span><textarea disabled class="addontxt" style="font-size:14px;padding: 0 10px; width:60%;
                                                                                           min-height: 100px;
                                                                                           max-height:900px;
                                                                                           height: auto ;
                                                                                           border:none !important; background-color:#fff !important;resize: none;" onkeydown="expandtext(this);" ><?php echo $arbetsorder; ?> </textarea></li>
                                                                                           <?php
                                                                                       } else {
                                                                                           foreach ($order_data as $data) :
                                                                                               if (strpos($data['label'], 'kund') === FALSE) {
                                                                                                   if (strstr($data['label'], 'Arbetsorder')) {
                                                                                                       ?>

                        <li>
                            <span style="float:left; padding-right:10px;">Arbetsorder:</span><textarea disabled class="addontxt" style="font-size:14px;padding: 0 10px; width:60%;
                                                                                                       min-height: 100px;
                                                                                                       max-height:900px;
                                                                                                       height: auto ;
                                                                                                       border:none !important; background-color:#fff !important;resize: none;" onkeydown="expandtext(this);" ><?php echo $data["value"]; ?> </textarea>
                        <?php // echo $data["label"] . ": " . $data["value"] ?></li>
                        <?php
                    }
                }
                ?>
    <?php
    endforeach;
}
?>
    </ul>
<?php if (get_post_meta($order->get_id(), 'project-estimated-hours', true) || get_post_meta($order->get_id(), 'project-work-order', true)) { ?>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <li><strong><?php echo __("Uppskattad arbetstid för montage"); ?>:</strong> <?php echo get_post_meta($order->get_id(), 'project-estimated-hours', true); ?></li>
                    <li><strong><?php echo __("Arbetsorder"); ?></strong><br> <?php echo get_post_meta($order->get_id(), 'project-work-order', true); ?></li>
                </ul>

            </div>
        </div>
        <?php } ?>
</div>

<div class="container"><h3><?php echo __("Kundinformation"); ?></h3>
    <ul class="list-unstyled">
<?php
$fran_kund = get_post_meta($_GET["order-id"], 'Information-frn-kund', true);
if (!empty($fran_kund)) {
    ?>
            <li><span style="float:left; padding-right:10px;">Information från kund:</span><textarea disabled class="addontxt" style="font-size:14px;padding: 0 10px; width:60%;
                                                                                                      min-height: 100px;
                                                                                                      max-height: 900px;
                                                                                                      height: auto ;
                                                                                                      border:none !important; background-color:#fff !important;resize: none;" onkeydown="expandtext(this);" ><?php echo $fran_kund; ?> </textarea></li>
<?php } else { ?>
    <?php
    foreach ($order_data as $data) :
        if (strstr($data['label'], 'Information från kund')) {
            ?>
                    <li>
                        <span style="float:left; padding-right:10px;">Information från kund:</span><textarea disabled class="addontxt" style="font-size:14px;padding: 0 10px; width:60%;
                                                                                                              min-height: 100px;
                                                                                                              max-height: 900px;
                                                                                                              height: auto ;
                                                                                                              border:none !important; background-color:#fff !important;resize: none;" onkeydown="expandtext(this);" ><?php echo $data["value"]; ?> </textarea>
            <?php // echo $data["label"] . ": " . $data["value"]  ?></li>
        <?php }
        ?>
        <?php endforeach; ?>
    <?php } ?>
    </ul>
</div>

<div class="container">
    <h3><?php echo __("Reservationer"); ?></h3>
    <?php
    $reservation_field = get_field('order_recervation_method', $_GET["order-id"]);
    $reservation_field1 = get_field('order_recervation_method_egen', $_GET["order-id"]);
 $order_recervation_method_id = get_field('order_recervation_method_id', $_GET['order-id']);
                           // $stripped_array = array();
$project_type_id = get_field('order_project_type', $_GET["order-id"]);
if(!empty($order_recervation_method_id)){
                            foreach ( getReservartion($order_recervation_method_id) as $method) {
                                $stripped = trim(preg_replace('!\s+!', ' ', $method->name));
								if(!empty($method->links)){
								 echo '<a href="'.$method->links.'" target="_blank">'.$stripped . '</a><br>';	
								}else{
									echo $stripped. '<br>';
								}
                             
}}
?>
    <span><?php echo $reservation_field1; ?></span>
</div>

<hr>
<?php
$order_id = $_GET['order-id'];
$order_json_data = get_post_meta($order_id, 'orderdata_json');
$json_data_as_array = json_decode($order_json_data[0], JSON_PRETTY_PRINT);
//    echo"<pre>";
//    print_r($json_data_as_array);
$image1 = $json_data_as_array['imm-sale-value_Huvudbild-fr-kostnadsfrslag']['value'];
?>
<div class="container"><div class="col-md-12 img-sec-port">
        <?php
        if ($image1) {
            $imagedesc1 = $json_data_as_array['imm-sale-value_Huvudbild-fr-kostnadsfrslag']['image_description'];
            ?>
            <div class="col-sm-4">
                <span><?php echo $imagedesc1; ?></span>
                <a href="<?php echo $image1; ?>" target="_blank"><img src="<?php echo $image1; ?>"></a>
            </div>
    <?php
}
$image2 = $json_data_as_array['imm-sale-value_Bildruta-1-Kostnadsfrslag']['value'];
if ($image2) {
    $imagedesc2 = $json_data_as_array['imm-sale-value_Bildruta-1-Kostnadsfrslag']['image_description'];
    ?>
            <div class="col-sm-4">
                <span><?php echo $imagedesc2; ?></span>
                <a href="<?php echo $image2; ?>" target="_blank"><img src="<?php echo $image2; ?>"></a>
            </div>
    <?php
}

$image3 = $json_data_as_array['imm-sale-value_Bildruta-2-Kostnadsfrslag']['value'];
if ($image3) {
    $imagedesc3 = $json_data_as_array['imm-sale-value_Bildruta-2-Kostnadsfrslag']['image_description'];
    ?>
            <div class="col-sm-4">
                <span><?php echo $imagedesc3; ?></span>
                <a href="<?php echo $image3; ?>" target="_blank"><img src="<?php echo $image3; ?>"></a>
            </div>
    <?php
}
$image4 = $json_data_as_array['imm-sale-value_Bildruta-3-Kostnadsfrslag']['value'];
if ($image4) {
    $imagedesc4 = $json_data_as_array['imm-sale-value_Bildruta-3-Kostnadsfrslag']['image_description'];
    ?>
            <div class="col-sm-4">
                <span><?php echo $imagedesc4; ?></span>
                <a href="<?php echo $image4; ?>" target="_blank"><img src="<?php echo $image4; ?>"></a>
            </div>
    <?php
}
$image5 = $json_data_as_array['imm-sale-value_Tillggsbild-fr-montage-1']['value'];
if ($image5) {
    $imagedesc5 = $json_data_as_array['imm-sale-value_Tillggsbild-fr-montage-1']['image_description'];
    ?>
            <div class="col-sm-4">
                <span><?php echo $imagedesc5; ?></span>
                <a href="<?php echo $image5; ?>" target="_blank"><img src="<?php echo $image5; ?>"></a>
            </div>
    <?php
}
$image6 = $json_data_as_array['imm-sale-value_Tillggsbild-fr-montage-2']['value'];
if ($image6) {
    $imagedesc6 = $json_data_as_array['imm-sale-value_Tillggsbild-fr-montage-2']['image_description'];
    ?>
            <div class="col-sm-4">
                <span><?php echo $imagedesc6; ?></span>
                <a href="<?php echo $image6; ?>" target="_blank"><img src="<?php echo $image6; ?>"></a>
            </div>
    <?php
}
$image7 = $json_data_as_array['imm-sale-value_Tillggsbild-fr-montage-3']['value'];
if ($image7) {
    $imagedesc7 = $json_data_as_array['imm-sale-value_Tillggsbild-fr-montage-3']['image_description'];
    ?>
            <div class="col-sm-4">
                <span><?php echo $imagedesc7; ?></span>
                <a href="<?php echo $image7; ?>" target="_blank"><img src="<?php echo $image7; ?>"></a>
            </div>
    <?php
}
$image8 = $json_data_as_array['imm-sale-value_Tillggsbild-fr-montage-4']['value'];
if ($image8) {
    $imagedesc8 = $json_data_as_array['imm-sale-value_Tillggsbild-fr-montage-4']['image_description'];
    ?>
            <div class="col-sm-4">
                <span><?php echo $imagedesc8; ?></span>
                <a href="<?php echo $image8; ?>" target="_blank"><img src="<?php echo $image8; ?>"></a>
            </div>
<?php }
?>
    </div>
</div>



<?php wp_footer(); ?>
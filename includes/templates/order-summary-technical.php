<?php
/**
 * Technical summary. Used to display articles and invoice data in a simple view.
 */
wp_head();
$logotype_url = get_option('logotype_image_url');

$order_id = $_GET["order-id"];
$order_key = $_GET["order-key"];

$order = new WC_Order($order_id);
$order_data = return_array_from_json(get_field('orderdata_json', $order_id));
$current_customer_id1 = $order->get_customer_id();
$order_accept_status = get_field('order_accept_status', $order->get_id());
$custom_order_number = get_post_meta($order->ID, 'custom_order_number')[0];
$projectid = get_post_meta($order->ID, 'imm-sale_project_connection')[0];
$current_customer_id = get_post_meta($projectid, 'invoice_customer_id')[0];
$order = new WC_Order($order_id);
$varOrderdate = $order->order_date;
$orderdate = date('d-m-Y', strtotime($varOrderdate));
$salesmanid = get_post_meta($projectid, 'assigned-technician-select')[0];
//echo $salesmanid;die;

//echo $firstname;
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

<div class="col-md-12">
        <div class="print_div_technical" style="float:right;margin: auto;padding: 20px;">
            <i class="fa fa-print fa-3x" aria-hidden="true"></i><br>
            <div class="print_text print_div_technical">Utskriftsversion</div>
        </div> 
    </div>

<?php include_once(plugin_dir_path(__FILE__) . 'technical_print.php'); ?>

<div class="container">
    <h1><?php echo "#" . $custom_order_number; ?></h1>
    <span>
        <h4><b>Order Skapad: </b><span style="padding-left:10px"><?php echo $orderdate; ?></span></h4>
    </span>
    <span><h4><b>Ansvarig person just nu: </b><span style="padding-left:10px"><?php echo getCustomerName($salesmanid);?></span></h4></span>
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
                    <li>Ingen separat leveransadress</li>
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
    <div class="row">
        <div class="col-lg-6">
            <h3><?php echo __("Din personliga säljare"); ?></h3>
            <?php
            $project_salesman_id = get_post_meta($order_id, "order_salesman_o")[0];
            $salesman = get_userdata($project_salesman_id);
            $firstPart = substr($salesman->personal_phone, 0, strrpos($salesman->personal_phone, '/'));
            $lastPart = substr($salesman->personal_phone, strrpos($salesman->personal_phone, '/') + 1);
            ?>
            <ul class="list-unstyled">
                <li><?php echo getCustomerName($project_salesman_id); ?></li>
                <li><?php echo $salesman->user_email; ?></li>
                <?php if ($firstPart): ?>
                    <li><?php echo $salesman->personal_phone;
                    ?></li>
                    <?php
                endif;
                if ($lastPart):
                    ?>
                    <li><?php echo $salesman->personal_phone;
                    ?></li>
                <?php endif;
                ?>
            </ul>
        </div>
    </div>
</div>
<div class="container">
    <h3><?php echo __("Artikelinformation"); ?></h3>

    <div class="row">
        <div class="col-lg-12">

            <table class="table">
                <thead>
                    <tr>
                       <!-- <th><?php //echo __("Artikelnummer"); ?></th>-->
                        <th><?php echo __("Benämning"); ?></th>
                        <th><?php echo __("Antal"); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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
                                    ?>
                                    <tr>
                                       <!-- <td><?php //echo $product->get_sku(); ?></td>-->
                                        <td><?php echo $lineItem['name']; ?>
                                            <i><?php
                                                if ($lineItem["line_item_special_note"])
                                                    echo $lineItem["line_item_special_note"];
                                                else
                                                    echo $lineItem["line_item_note"];
                                                ?></i>
                                        </td>
                                        <td>
                                            <?php
                                            if ($product->get_sku() != 'rabatt_produkt' && $product->get_sku() != 'arbetsorder' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar') {

                                                echo $lineItem['quantity'];
                                            } else {
                                                echo 1;
                                            }
                                            ?>


                                        </td>
                                    </tr>

                                    <?php
                                } endforeach;
                        }
                    } else {
                        foreach ($order->get_items() as $key => $lineItem) :

                            $product = new WC_Product($lineItem['product_id']);
                            ?>
                            <tr>
                               <!-- <td><?php// echo $product->get_sku(); ?></td>-->
                                <td><?php echo $lineItem['name']; ?>
                                    <i><?php
                                        if ($lineItem["line_item_special_note"])
                                            echo $lineItem["line_item_special_note"];
                                        else
                                            echo $lineItem["line_item_note"];
                                        ?></i>
                                </td>
                                <td>
                                    <?php
                                    if ($product->get_sku() != 'rabatt_produkt' && $product->get_sku() != 'arbetsorder' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar') {

                                        echo $lineItem['quantity'];
                                    } else {
                                        echo 1;
                                    }
                                    ?>


                                </td>
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

<?php
$typeservice = get_field('type_of_service', $_GET["order-id"]);
$beskrivning = get_field('beskrivning', $_GET["order-id"]);
if (!empty($typeservice) || $beskrivning) {
    ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12" id="inner_srvc">
                <div class="services_txt">
                    <h4>typ av service:</h4>
                    <?php echo $typeservice; ?></br>
                </div>
                <div class="services_txt">
                    <h4>Kundens beskrivning av problemet:</h4>
                    <?php echo $beskrivning; ?> </br>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
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
                                if (strpos($data['label'], 'Huvudbild för kostnadsförslag') === FALSE) {
                                    if (strpos($data['label'], 'Bildruta 1 Kostnadsförslag') === FALSE) {
                                        if (strpos($data['label'], 'Bildruta 2 Kostnadsförslag') === FALSE) {
                                            if (strpos($data['label'], 'Bildruta 3 Kostnadsförslag') === FALSE) {
                                                if (strpos($data['label'], 'Tilläggsbild för montage 1') === FALSE) {
                                                    if (strpos($data['label'], 'Tilläggsbild för montage 2') === FALSE) {
                                                        if (strpos($data['label'], 'Tilläggsbild för montage 3') === FALSE) {
                                                            if (strpos($data['label'], 'Tilläggsbild för montage 4') === FALSE) {
                                                                ?>
                                                                <?php if ($data["label"] && $data["value"]) : ?>
                                                                    <li><?php
//                                        if (strpos($data["value"], 'jpg') !== false || strpos($data["value"], 'png') || strpos($data["value"], 'jpeg') || strpos($data["value"], 'gif')) {
//                                            echo $data["label"] . ": " . '<a href="' . $data["value"] . '" target="_blank" style="color: #1812ff;">' . $data["value"] . '</a>';
//                                        } else {
                                                                        echo $data["label"] . ": " . $data["value"];
//                                        }
                                                                        ?></li>
                                                                    <?php
                                                                endif;
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
                <?php endforeach; ?>
            </ul>

        </div>
    </div>

</div> <!-- /container -->
<hr>

<div class="container">
    <h3><?php echo __("Arbetsorder"); ?></h3>
    <ul class="list-unstyled">
        <?php
        foreach ($order_data as $data) :
            if (strpos($data['label'], 'kund') === FALSE) {
                if (strstr($data['label'], 'Uppskattad')) {
                    ?>

                    <li><?php echo $data["label"] . ": " . $data["value"] ?></li>
                    <?php
                }
            }
            ?>
        <?php endforeach; ?>
        <?php
        $arbetsorder = get_post_meta($_GET["order-id"], 'Arbetsorder', true);
        if (!empty($arbetsorder)) {
            ?>
            <li><span style="float:left; padding-right:10px;">Arbetsorder:</span>
                <textarea name="arbets" class="arbets_desc" id="arbets_desc"><?php echo $arbetsorder; ?></textarea>
                <p>&nbsp;</p>
                <div class="arbet" ></div>
    <!--                <textarea disabled class="addontxt" style="font-size:14px;padding: 0 10px; width:60%;
                                                                                   min-height: 100px;
                                                                                   max-height: 900px;
                                                                                   height: auto ;
                                                                                   border:none !important; background-color:#fff !important;resize: none;" onkeydown="expandtext(this);" ><?php // echo $arbetsorder;  ?> </textarea></li>-->
                <?php
            } else {
                foreach ($order_data as $data) :
                    if (strpos($data['label'], 'kund') === FALSE) {
                        if (strstr($data['label'], 'Arbetsorder')) {
                            ?>
                        <li><span style="float:left; padding-right:10px;">Arbetsorder:</span>
                            <textarea name="arbets" class="arbets_desc" id="arbets_desc"><?php echo $data["value"]; ?></textarea>
                            <p>&nbsp;</p>
                            <div class="arbet" ></div>
                <!--                            <textarea disabled class="addontxt" style="font-size:14px;padding: 0 10px; width:60%;
                                                                                                           min-height: 100px;
                                                                                                           max-height: 900px;
                                                                                                           height: auto ;
                                                                                                           border:none !important; background-color:#fff !important;resize: none;" onkeydown="expandtext(this);" ><?php // echo $data["value"];  ?> </textarea></li>-->
                                        <!--<li><?php // echo $data["label"] . ": " . $data["value"]  ?></li>-->
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
</div> <!-- /container -->
<div class="container"><h3><?php echo __("Kundinformation"); ?></h3>
    <ul class="list-unstyled">
        <?php
        $fran_kund = get_post_meta($_GET["order-id"], 'Information-frn-kund', true);
        if (!empty($fran_kund)) {
            ?>
            <li><span style="float:left; padding-right:10px;">Information från kund:</span>
                <textarea name="kund" class="kund_desc" id="kund_desc"><?php echo $fran_kund; ?></textarea>
                <p>&nbsp;</p>
                <div class="kund" ></div>
    <!--                <textarea disabled class="addontxt" style="font-size:14px;padding: 0 10px; width:60%;
                                                                                              min-height: 100px;
                                                                                              max-height: 900px;
                                                                                              height: auto ;
                                                                                              border:none !important; background-color:#fff !important;resize: none;" onkeydown="expandtext(this);" ><?php // echo $fran_kund;  ?> </textarea></li>-->
            <?php } else { ?>
                <?php
                foreach ($order_data as $data) :
                    if (strstr($data['label'], 'Information från kund')) {
                        ?>
                    <li><span style="float:left; padding-right:10px;">Information från kund:</span>
                        <textarea name="kund" class="kund_desc" id="kund_desc"><?php echo $data["value"]; ?></textarea>
                        <p>&nbsp;</p>
                        <div class="kund" ></div>
            <!--                        <textarea disabled class="addontxt" style="font-size:14px;padding: 0 10px; width:60%;
                                                                                                              min-height: 100px;
                                                                                                              max-height: 900px;
                                                                                                              height: auto ;
                                                                                                              border:none !important; background-color:#fff !important;resize: none;" onkeydown="expandtext(this);" ><?php // echo $data["value"];  ?> </textarea></li>-->
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
<div class="container" style="margin-top:15px;">
    <table class="table">
        <?php
        $table_name = "todo-order_files";
        $order_id = $_GET['order-id'];
        ?>
        <thead>
            <tr>
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Namn"); ?></th>
                <th class="sortable"
                    onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Ladda ner"); ?></th>
                <th class="sortable"
                    onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Ta bort"); ?></th>

            </tr>
        </thead>
        <tbody id="<?php echo $table_name ?>">
            <?php
            $filedata = get_post_meta($order_id, 'file_order', true);

            $i = 1;
            foreach ($filedata as $val) {
                $namn = $val['namn'];
                $url = $val['url'];
                echo '<tr data_row="' . $i . '"><input type="hidden" id="order_id" name="order_id" value=' . $order_id . '><td>' . $namn . '</td><td><a href="' . $url . '" class="project_file_url" download>Ladda ner</a></td><td data_row="' . $i . '" class="tabort_arbet_repeater_row_offert" data_url="' . $url . '"><a href="#"  >Ta bort</a></td></tr>';
                $i++;
            }
            ?>
        </tbody>
    </table>

</div>
<script>jQuery(document).ready(function () {
        var arbets_desc = jQuery('textarea#arbets_desc').val();
        var kund_desc = jQuery('textarea#kund_desc').val();
        jQuery('.arbets_desc').hide();
        jQuery('.kund_desc').hide();
        jQuery('.arbet').html(arbets_desc.replace(/\r?\n/g, '<br/>'));
        jQuery('.kund').html(kund_desc.replace(/\r?\n/g, '<br/>'));
    });</script>
<?php wp_footer(); ?>
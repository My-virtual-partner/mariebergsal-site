<?php
$order_total_price = $order->get_total();
$order_id = $_GET['order-id'];

$order_number = get_post_meta($order_id, 'custom_order_number', true);

if (get_field('imm-sale-tax-deduction', $order->get_id())) {
    $rot_avdrag = get_post_meta($order->get_id(), "confirmed_rot_percentage", true);
    $display_price = $order_total_price - $rot_avdrag;
} else {
    $rot_avdrag = 0;
    $display_price = $order_total_price;
}

$project_id = get_field('imm-sale_project_connection', $order_id);
$userids = get_post_meta($project_id, 'invoice_customer_id', true);
$userdata = get_userdata($userids);
$useremail = $userdata->user_email;
$$firstnamephone = get_user_meta($userids, 'billing_phone', true);
$billing_address_1 = get_user_meta($userids, 'billing_address_1', true);
$billing_city = get_user_meta($userids, 'billing_city', true);
$billing_postcode = get_user_meta($userids, 'billing_postcode', true);
$affarsforslag = '#' . $project_id . '-' . $order_id;


//$custom_order_number = get_post_meta($order_id, 'custom_order_number', true);
?>

<div class="printable_area" style="display: none;margin:40px;">


    <div class="col-md-12">
        <img src="/wp-content/uploads/2018/07/Mariebergs-Logo-Svart-ny.png" alt="" class="center-block"
             style="margin-left:175px;margin-bottom: 20px;max-width: 350px;height:auto;">
        <br>

    </div>


    <!--    Here is a comment-->
    <div class="container top-buffer">
        <div class="row">
            <div class="col-lg-12">
                <div style="width:100%">
                    <?php if ($order_accept_status === "true") : ?>
                    <div class="row">
                            <div class="col-lg-12">
                                <h2 class="text-center" style="text-transform: none;text-align:center;">Orderbekräftelse</h2>
                                <p style="text-align:center;">Tack för förtroendet! Vi bekräftar härmed din accept och beställning enligt nedanstående affärsförslag till dig.</p>
                            </div>
                        </div>
                        <div class="text-center accept " style="width:49%; float:right">
                            <p style="font-family:Trebuchet MS;font-size:12px; line-height:26PX;color: #2f2f2f!important;text-align:center">
                                <span class=""><?php echo __('Affärsförslag #') . $order_number ?> </span><br>
                            </p>
                        </div>
                    <?php elseif ($order_accept_status === "false") : ?>
                        <div class=" text-center declined" style="width:49%; float:right">
                            <p style="font-family:Trebuchet MS;font-size:12px; line-height:26px;color: #2f2f2f!important;text-align:center;">
                                <span class=""><?php echo __('Affärsförslag #') . $order_number ?> </span><br></p>
                        </div>
                    <?php else : ?>
                        <div class="wait" style="width:49%; float:right">
                            <p style="font-family:Trebuchet MS;font-size:12px; line-height:26px;color: #2f2f2f!important;text-align:center">
                                <span class=""><?php echo __('Affärsförslag #') . $order_number ?> </span><br>
                            </p>
                        </div>
                    <?php endif; ?>
                    <div style="float:left; width:49%; padding:0; margin:0">
                        <?php if ($order->billing_company) : ?>
                        <p  style="font-family:Trebuchet MS;color: #2f2f2f!important; text-align:center; font-size:12px !important;line-height:40px; paddin:0 !important; margin:0;"><?php echo $order->billing_company; ?></p>

                                <?php
                            endif;
                        //if ($order->get_billing_first_name) : 
                        if ($billing_address_1)
                            $comma = ", ";
                            if ($phone)
                                $commaa = ", ";
                        if ($billing_postcode)
                            $comma1 = ", ";
                        ?>
                            <p  style="font-family:Trebuchet MS;font-size:12px; line-height:26px;color: #2f2f2f!important;text-align:center"><?php echo getCustomerName($userids) . ", "; ?><?php echo $useremail . ", " . $phone . $commaa . " " . $billing_address_1 . $comma . $billing_postcode . $comma1 . $billing_city ?></p>
                            <?php // endif;  ?>
                    </div>
                </div>
                <div style="float:left; width:100%; padding:0; margin:0 ">
                    <div class="col-lg-12">
                        <h2 class="text-center"
                            style="font-family:Trebuchet MS;font-size:16px;color: #2f2f2f!important;text-align:center;line-height:50px; margin:0; padding:0;"><?php echo $order_summary_heading; ?></h2>
                        <textarea name="mas" class="content" id="desc"><?php echo $order_summary_description; ?></textarea>
                        <p>&nbsp;</p>
                        <div class="mas" ></div>
                    </div>


                </div>


            </div>

        </div>

        <div class="row" style="clear:both" >
            <div class="col-lg-12">
                <h3 class=""
                    style=" font-family:Trebuchet MS;font-size:16px;color: #2f2f2f!important;text-align:center;line-height:50px; margin:0; padding:0;"><?php echo $order_summary_addon_heading; ?></h3>
                <textarea name="samman" class="samman_desc" id="samman_desc"><?php echo $order_summary_addon_description; ?></textarea>
                <p>&nbsp;</p>
                <div class="samman" ></div>
            </div>

        </div>
    </div>


    <div class="container top-buffer" style="page-break-before: always">
        <?php if ($compact === false) : ?>
        <div class="row">
                <div class="col-lg-12">
                    <h3 style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:16px; line-height: 0.3em"><?php echo __("Sammanfattning") ?></h3>

                        <?php
                        if ($show_price === true) {
                        $wid1 = '25%';
                        $wid2 = '15%';
                    } else {
                        $wid1 = '50%';
                        $wid2 = '50%';
                    }
                    ?>
                        <table class="table table-striped" style="margin-top: 25px;">
                            <thead>
                                <tr style="font-family:Trebuchet MS;font-size:12px;padding-bottom: 10px;color: #2f2f2f!important;">

                                    <th style="color: #2f2f2f!important;text-align: left;width:<?= $wid1 ?>"><?php echo __("Benämning"); ?></th>
                                    <?php if ($show_price === true) : ?>
                                        <th style="color: #2f2f2f!important;text-align: right;width:20%"><?php //echo __("Pris");       ?></th>
                                    <?php endif; ?>
                                    <th style="color: #2f2f2f!important;text-align: center;width:<?= $wid2 ?>"><?php echo __("Antal"); ?></th>
                                    <?php if ($show_price === true) : ?>
                                        <th style="color: #2f2f2f!important;text-align: center;width:20%"><?php //echo __("Moms");       ?></th>
                                        <th style="color: #2f2f2f!important;text-align: right;width:20%"><?php echo __("Summa"); ?></th>
                                        <?php endif; ?>


                                </tr>
                            </thead>
                            <tbody style="font-family:Trebuchet MS;font-size:12px;color: #2f2f2f!important;">
                                <?php
                                $moms_array = array();

                            $custom_price_adjust_product_id = get_field('custom_price_adjust_product_id', 'option');
                            $custom_price_adjust_negative_product_id = get_field('custom_price_adjust_negative_product_id', 'option');
                            $custom_price_adjust_arbetet_product_id = get_field('custom_price_adjust_arbetet_product_id', 'option');
                            $custom_price_adjust_material_product_id = get_field('custom_price_adjust_material_product_id', 'option');
                                $custom_discount_product = get_field('custom_discount_product', 'option');
                                $custom_adjust_price_array = array(
                                'custom_price_adjust_product_id' => $custom_price_adjust_product_id,
                                'custom_price_adjust_negative_product_id' => $custom_price_adjust_negative_product_id,
        'custom_price_adjust_arbetet_product_id' => $custom_price_adjust_arbetet_product_id,
                                'custom_price_adjust_material_product_id' => $custom_price_adjust_material_product_id,
                                'custom_discount_product' => $custom_discount_product
    );
                                $sorting_wise = unserialize(get_post_meta($order_id, "head_sortorderitems", true));
                            $sortorderitems = unserialize(get_post_meta($order_id, 'sortorderitems', true));

                            $newvalue = array_merge($sorting_wise, $sortorderitems);
                            $newvalue = array_unique($newvalue);
                            if (!empty($newvalue)) {
                                foreach ($newvalue as $limeid) {
                                    foreach ($order->get_items() as $key => $lineItem) :
                                        $item_data = $lineItem->get_data();
$item_total = wc_get_order_item_meta($key, '_line_total', true)+ wc_get_order_item_meta($key, '_line_tax', true);
                                        if ($limeid == $item_data['id']) {
                                            $product = new WC_Product($lineItem['product_id']);
                                            array_push($moms_array, abs($lineItem['subtotal_tax']));
                                            // $images = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');
                                            ?>
                            <tr style=''>

                                                                    <?php
                                                                    if (!in_array($lineItem['product_id'], $custom_adjust_price_array)) {
                                                    $title_benamning = $lineItem['name'];
                                                    $title_benamning_note = $lineItem["line_item_note"];
                                                } else {
                                                    $lineItemNote = $lineItem["line_item_note"];
                                                    if (strlen($lineItemNote) > 1) {
                                                        $title_benamning = $lineItem['line_item_note'];
                                                        $title_benamning_note = '';
                                                    } else {
                                                        $title_benamning = $lineItem['name'];
                                                        $title_benamning_note = '';
                                                    }
                                                }
                                                if (!empty($title_benamning_note))
                                                    $extratitle = $title_benamning_note;
                                                else
                                                    $extratitle = $lineItem["line_item_special_note"];

                                             
                                                ?>
                                                                    <td style="width: 25%; font-size: 12px;"><?php echo $title_benamning.saleFunction($product,$lineItem['product_id'],$item_total); ?>
                                                                        <i><?php echo $extratitle; ?></i>
                                                                    </td>
                                                                    <?php if ($show_price === true) : ?>
                                                                        <td style="text-align: right;width: 10%; font-size: 12px;" nowrap>
                                                                            <?php
                                                                            /*   if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabbat_produkt') {
                                                          //                                                $subtotal = $lineItem['subtotal'] / $lineItem['quantity'];
                                                          if ($lineItem['subtotal'] == 0 || $lineItem['quantity'] == 0) {
                                                          $subtotal = 0;
                                                          } else {
                                                          $subtotal = $lineItem['subtotal'] / $lineItem['quantity'];
                                                          }
                                                          echo wc_price($subtotal)
                                                          ;
                                                          } elseif ($product->get_sku() === 'prisjustering') {
                                                          echo(wc_price($lineItem['total']));
                                                          } else {
                                                          echo(wc_price($lineItem['total']));
                                                          } */
                                                        ?>
                                                                            </td>
                                                                        <?php endif; ?>
                                                                        <td style="text-align: center;width: 15%; font-size: 12px;" nowrap><?php
                                                                            if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabbat_produkt') {

                                                        echo $lineItem['quantity'];
                                                    } else {
                                                        echo 1;
                                                    }
                                                    ?></td>
                                                                    <?php if ($show_price === true) : ?>
                                                                        <td style="text-align: center;width: 30%;font-size: 12px;" nowrap><?php
                                                                            // echo wc_price($lineItem['subtotal_tax']);
                                                        ?></td>
                                                                            <td style="text-align: right;width: 25%;font-size: 12px;" nowrap><?php echo wc_price($lineItem['total'] + $lineItem['subtotal_tax']); ?>

                                                                            </td>
                                                                        <?php endif; ?>
                                                                </tr>

                                                                <?php
                                                            } endforeach;
                                }
                            } else {
                                foreach ($order->get_items() as $key => $lineItem) :
                                    $product = new WC_Product($lineItem['product_id']);
									$item_total = wc_get_order_item_meta($key, '_line_total', true)+ wc_get_order_item_meta($key, '_line_tax', true);
                                    array_push($moms_array, abs($lineItem['subtotal_tax']));
                                    // $images = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');
                                    ?>
                                            <tr style=''>

                                                    <?php
                                                    if (!in_array($lineItem['product_id'], $custom_adjust_price_array)) {
                                            $title_benamning = $lineItem['name'];
                                            $title_benamning_note = $lineItem["line_item_note"];
                                        } else {
                                            $lineItemNote = $lineItem["line_item_note"];
                                            if (strlen($lineItemNote) > 1) {
                                                $title_benamning = $lineItem['line_item_note'];
                                                $title_benamning_note = '';
                                            } else {
                                                $title_benamning = $lineItem['name'];
                                                $title_benamning_note = '';
                                            }
                                        }
                                        if (!empty($title_benamning_note))
                                            $extratitle = $title_benamning_note;
                                        else
                                            $extratitle = $lineItem["line_item_special_note"];

                                      
                                        ?>
       <td style="width: 25%; font-size: 12px;"><?php echo $title_benamning.saleFunction($product,$lineItem['product_id'],$item_total); ?>
                                                        <i><?php echo $extratitle; ?></i>
                                                    </td>
                                                    <?php if ($show_price === true) : ?>
                                                        <td style="text-align: right;width: 10%; font-size: 12px;" nowrap>
                                                            <?php
                                                            /*   if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabbat_produkt') {
                                                  //                                                $subtotal = $lineItem['subtotal'] / $lineItem['quantity'];
                                                  if ($lineItem['subtotal'] == 0 || $lineItem['quantity'] == 0) {
                                                  $subtotal = 0;
                                                  } else {
                                                  $subtotal = $lineItem['subtotal'] / $lineItem['quantity'];
                                                  }
                                                  echo wc_price($subtotal)
                                                  ;
                                                  } elseif ($product->get_sku() === 'prisjustering') {
                                                  echo(wc_price($lineItem['total']));
                                                  } else {
                                                  echo(wc_price($lineItem['total']));
                                                  } */
                                                ?>
                                                            </td>
                                                        <?php endif; ?>
                                                        <td style="text-align: center;width: 15%; font-size: 12px;" nowrap><?php
                                                            if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabbat_produkt') {

                                                echo $lineItem['quantity'];
                                            } else {
                                                echo 1;
                                            }
                                            ?></td>
                                                    <?php if ($show_price === true) : ?>
                                                        <td style="text-align: center;width: 30%;font-size: 12px;" nowrap><?php
                                                            // echo wc_price($lineItem['subtotal_tax']);
                                                ?></td>
                                                            <td style="text-align: right;width: 25%;font-size: 12px;" nowrap><?php echo wc_price($lineItem['total'] + $lineItem['subtotal_tax']); ?>

                                                            </td>
                                                        <?php endif; ?>
                                                </tr>

                                                <?php
                                            endforeach;
                            }
                            ?>
                                    <tr style="height: 40px;">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                </tr>
                                <?php
                                if ($show_price === true) :

                                if ($rot_avdrag > 0) :
                                    ?>

                            <tr>
                                            <!--  <td></td>-->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right;">
                                                <strong><?php echo __("Priset inkluderar uppgivet ROT avdrag på: "); ?></strong>
                                            </td>
                                            <td style="text-align: right;"><?php echo wc_price(0 - $rot_avdrag); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    endif;
                                ?>
                                    <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                            <td style="text-align: right;"><strong style="font-size: 12px;"><?php echo __("Totalsumma: "); ?></strong></td>
                                            <td style="text-align: right;" nowrap><strong class="add_fpmt"><?php echo wc_price($display_price); ?></strong>
                                            </td>
                                        </tr>
                                        <tr>
                <!--       <td></td>-->
                                            <td></td>
                                            <td></td>
                                            <td></td>

                                            <td style="text-align: right;"><strong><?php echo __("Varav moms: "); ?></strong></td>
                                            <td style="text-align: right;" nowrap><?php echo wc_price($order->get_total_tax()); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <!--  <td></td>-->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right;"><strong><?php echo __("Summa ex moms: "); ?></strong>
                                            </td>
                                            <td style="text-align: right;" nowrap><?php echo wc_price($order->get_total() - $order->get_total_tax()); ?>
                                            </td>
                                        </tr>



                                    <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>

    </div>
    <br>
    <!--    <div style="">
    <p><strong>Rot avdrag: </strong><?php /* echo number_format($rot_avdrag); */ ?></p>
    <p><strong>Totalt: </strong><?php /* echo  number_format($display_price); */ ?></p>
    </div>-->


    <?php
    if (have_rows('filer_order', $_GET['order-id'])):
        echo '<P><strong>Filer: </strong><br>';
        // loop through the rows of data
        while (have_rows('filer_order', $_GET['order-id'])) : the_row();
            // display a sub field value
            $namn = get_sub_field('namn');
            $url = get_sub_field('url');
            echo $url . '<br>';
        endwhile;


        echo '</P>';
    endif;
    ?>


    <!--    <div class="row" style="display:inline-block">
    <?php /*        $project_id = get_field('imm-sale_project_connection', $order->get_id());
      $project_salesman_id = get_field('order_salesman', $project_id);
      $salesman = get_userdata($project_salesman_id);
     */ ?>

        <div style="display:inline-block;float: left;margin-right: 120px;">
            <h5><?php /* echo __("Din personliga säljare") */ ?></h5>
        </div>
        <div style="display:inline-block;text-align: center;margin-right: 120px;">
            <h5><?php /* echo $salesman->first_name . " " . $salesman->last_name; */ ?></h5>

        </div>
        <div style="display:inline-block;float: right;">
            <h5 style="text-align: right"><?php /* echo __("E-mail: ") . $salesman->user_email */ ?></h5>
        </div>


    </div>-->


    <div class="page-break" style="page-break-before:always;"></div>

    <div class="col-md-12">
        <img src="/wp-content/uploads/2018/07/Mariebergs-Logo-Svart-ny.png" alt="" class="center-block"
             style="margin-left:175px;margin-bottom: 20px;max-width: 350px;height:auto;">
        <br>

    </div>


    <div>
        <?php
        $typeservice = get_field('type_of_service', $_GET["order-id"]);
        $beskrivning = get_field('beskrivning', $_GET["order-id"]);
        if (!empty($typeservice) || $beskrivning) {
            ?>
        <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px; line-height: 0.3em"><strong>typ av service: </strong></p>
            <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px;"><?php echo $typeservice; ?></p>
            <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px; line-height: 0.3em"><strong>Kundens beskrivning av problemet: </strong></p>
            <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px;"><?php echo $beskrivning; ?></p>
        <?php } ?>
        <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px; line-height: 0.3em"><strong>Betalningstyp: </strong>
        </p>
        <p><?php 
        $payment_type = get_post_meta($_GET['order-id'], 'order_status_betainingstyp1')[0];
            $paymenttypeSearch = paytemMethod();
        echo $paymenttypeSearch[$payment_type]; ?></p>
        <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px; line-height: 0.3em"><strong>Betalningsvillkor: </strong>
        </p>
        <P style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px;"><?php
            $betal_methord = get_field('order_payment_method', $_GET['order-id']);
            $val_1 = '0';
            $val_2 = '10';
            $val_3 = '15';
            $val_4 = '20';
            $val_5 = '30';
            $val_6 = 'AG';
            $val_7 = 'K';
            $val_8 = 'PF';

            $betal_array = array($val_1 => '0 dagar', $val_2 => '10 dagar', $val_3 => '15 dagar', $val_4 => '20 dagar', $val_5 => '30 dagar', $val_6 => 'Autogiro', $val_7 => 'Kontant', $val_8 => 'Postförskott');
            echo $betal_array[$betal_methord];
            ?></P>
        <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px; line-height: 0.3em"><strong>Reservationer: </strong>
        </p>
        <P style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px;"><?php
            $betal_methord = get_field('order_recervation_method', $_GET['order-id']);
            $reservation_egen = get_field('order_recervation_method_egen', $_GET['order-id']);
            $reservationegen = get_field('order_recervation_method_egen', $_GET['order-id']);
			$order_recervation_method_id = get_field('order_recervation_method_id', $_GET['order-id']);
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
            if ($reservation_egen) { ?>
                 <textarea name="reservation" class="content" id="desc"><?php echo $reservation_egen; ?></textarea>
                        
                        <div class="mas_reserv" ></div>
          
                                <textarea name="reserve" class="reserv_desc" id="reserv_desc"><?php echo $reservationegen; ?></textarea>
                       
                        <div class="reserve" ></div>
           <?php }
            ?></P>
        <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px; line-height: 0.3em">
            <strong>Garanti: </strong></p>
        <P style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px;"><?php
            $betal_methord = get_field('order_garanti_method', $_GET['order-id']);
            echo $betal_methord;
            ?></P>
        <?php $order_data = return_array_from_json(get_field('orderdata_json', $_GET['order-id'])); ?>
        <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px; line-height: 0.3em">
            <strong>Uppskattad tid för montage: </strong></p>
        <P style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px;"><?php
            foreach ($order_data as $data) :
                if (strpos($data['label'], 'kund') === FALSE) {
                    if (strstr($data['label'], 'Uppskattad')) {
                        echo $data["value"];
                    }
                }

            endforeach;
            ?></P>
        <?php /*
          <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px; line-height: 0.3em">
          </p>
          <?php
          $arbetsorder = get_field('Arbetsorder', $_GET['order-id']);
          ?>
          <div style="float:left; width:100%; padding:0; margin:0 ">
          <div class="col-lg-12">
          <textarea name="arbets" class="arbets_desc" id="arbets_desc"><?php echo $arbetsorder; ?></textarea>
          <p>&nbsp;</p><strong>Arbetsorder: </strong>
          <div class="arbet" ></div>
          </div>


          </div>
          <p style="color: #2f2f2f!important;font-family:Trebuchet MS;font-size:12px; line-height: 0.3em">
          </p>
          <?php
          $kund = get_field('Information-frn-kund', $_GET['order-id']);
          ?>
          <div style="float:left; width:100%; padding:0; margin:0 ">
          <div class="col-lg-12">
          <textarea name="kund" class="kund_desc" id="kund_desc"><?php echo $kund; ?></textarea>
          <p>&nbsp;</p>
          <strong>Information från kund: </strong>
          <div class="kund" ></div>
          </div>


          </div>
         * 
         */ ?>
    </div>
    <div class="divFooter" style=" display: grid; width: 100%;">

        <?php
        $project_id = get_field('imm-sale_project_connection', $order->get_id());
//        $project_salesman_id = get_field('order_salesman', $project_id);
        $project_salesman_id = get_post_meta($project_id, "order_salesman_o")[0];
        $salesman = get_userdata($project_salesman_id);
        ?>


        <div class="saler-info" style="margin-top:50px;">

            <?php
            // $project_id = get_field('imm-sale_project_connection', $order->get_id());
            $project_salesman_id = get_post_meta($order->get_id(), "order_salesman_o")[0];
            $salesman = get_userdata($project_salesman_id);

            $salemanemail = $salesman->user_email;
            $namesale = getCustomerName($project_salesman_id);
            ?>

            <div style="margin-left:50%;" id="saler-txt">

                <ul style="    list-style: none;">
                    <li><strong><?php echo __("Din personliga säljare") ?></strong>
                    </li>
                    <li style="font-size:12px; color: #000000!important;  font-family: Trebuchet MS;">
                        <strong><?php echo getCustomerName($project_salesman_id); ?></strong>
                    </li>
                    <li style="font-size:12px; color: #2f2f2f!important; font-family: Trebuchet MS;"><?php echo __("E-mail: ") ?><a
                            href="mailto:<?php echo $salesman->user_email ?>"
                            target="_blank"><?php echo $salesman->user_email ?></a></li>

                    <li style="font-size:12px; color: #2f2f2f!important; font-family: Trebuchet MS;">
                        <?php
                        $firstPart = substr($salesman->personal_phone, 0, strrpos($salesman->personal_phone, '/'));
                        $lastPart = substr($salesman->personal_phone, strrpos($salesman->personal_phone, '/') + 1);
                        ?>

                        Telefonnummer: 


                        <?php if ($firstPart): ?>
                            <a href="tel:<?php echo $salesman->personal_phone; ?>"><?php echo $salesman->personal_phone; ?></a>

                                <?php
                            endif;
                        if ($lastPart):
                            ?>
                                <a href="tel:<?php echo $salesman->personal_phone; ?>">  <?php echo $salesman->personal_phone; ?></a>
                                <?php
                            endif;
                        ?>


                    </li>


                </ul>
            </div>
        </div>

        <div class="container top-buffer">
            <div style="font-size: 20px;
                 text-align: center;
                 font-family: none;">
                <span>Mariebergs Brasvärme AB</span><br>
                <span>organisationsnummer 556259-7681</span>

            </div>
        </div>
    </div>

</div>
<script>jQuery(document).ready(function () {
        var value = jQuery('textarea#desc').val();
        var samman_desc = jQuery('textarea#samman_desc').val();
         var reserv_desc = jQuery('textarea#reserv_desc').val();
        //var arbets_desc = jQuery('textarea#arbets_desc').val();
        //var kund_desc = jQuery('textarea#kund_desc').val();
        jQuery('.content').hide();
        jQuery('.samman_desc').hide();
         jQuery('.reserv_desc').hide();
        //jQuery('.arbets_desc').hide();
        // jQuery('.kund_desc').hide();
        jQuery('.mas').html(value.replace(/\r?\n/g, '<br/>'));
        jQuery('.samman').html(samman_desc.replace(/\r?\n/g, '<br/>'));
         jQuery('.reserve').html(reserv_desc.replace(/\r?\n/g, '<br/>'));
        // jQuery('.arbet').html(arbets_desc.replace(/\r?\n/g, '<br/>'));
        //jQuery('.kund').html(kund_desc.replace(/\r?\n/g, '<br/>'));
        jQuery('.add_fpmt span').css('font-size', '20px');
    });</script>
<?php
/**
 * Invoice summary displayed for the customer.
 * Contains information regarding the invoice created. Will verify by order_key and display information/price according to key.
 */
wp_head();

$order_id = $_GET["order-id"];
$order_key = $_GET["order-key"];
$order = new WC_Order($order_id);
global $current_user;
$currnetuser = getCustomerName($current_user->ID);
$typeservice = get_field('type_of_service', $order_id);
$beskrivning = get_field('beskrivning', $order_id);

$order_data = return_array_from_json(get_field('orderdata_json', $order_id));
$show_price = false;
$compact = false;
if ($order_key === get_field('order_summary-key-w-price', $order->ID)) {
    $verification = true;
    $show_price = true;
} elseif ($order_key === get_field('order_summary-key-wo-price', $order->ID)) {
    $verification = true;
    $show_price = false;
} elseif ($order_key === get_field('order_summary-key-compact', $order->ID)) {
    $verification = true;
    $show_price = false;
    //$compact = true;
} else {
    $verification = false;
    $show_price = false;
}


$order_accept_status = get_field('order_accept_status', $order->ID);

$hero_image_url = get_field('hero', $order->ID);
if (!$hero_image_url) {
    global $wpdb;
    $tablename = $wpdb->prefix . 'estimate_image';
    $result = $wpdb->get_results("SELECT * FROM " . $tablename);
    $hero_image_url = $result[0]->image_url;
}
$b1_image_url = get_field('b1', $order->ID);
$b2_image_url = get_field('b2', $order->ID);
$b3_image_url = get_field('b3', $order->ID);

$b1_image_description = get_field('b1_image_description', $order->ID);
$b2_image_description = get_field('b2_image_description', $order->ID);
$b3_image_description = get_field('b3_image_description', $order->ID);

$order_summary_heading = get_field('order_summary_heading', $order->ID);
$order_summary_description = get_field('order_summary_description', $order->ID);

$order_summary_addon_heading = get_field('order_summary_addon_heading', $order->ID);
$order_summary_addon_description = get_field('order_summary_addon_description', $order->ID);

$affarsforslaget_gallertom = get_field('affarsforslaget_gallertom', $order->ID);

$custom_order_number = get_post_meta($order->ID, 'custom_order_number')[0];

$logotype_url = get_option('logotype_image_url');

$tax_deduction = get_field("imm-sale-tax-deduction", $order->ID);

$current_customer_id = $order->get_customer_id();
$project_id = get_field('imm-sale_project_connection', $order->get_id());
$userids = get_post_meta($project_id, 'invoice_customer_id', true);
$userdata = get_userdata($userids);
$useremail = $userdata->user_email;

$phone = get_user_meta($userids, 'billing_phone', true);
$company = get_user_meta($userids, 'billing_company', true);
$city = get_user_meta($userids, 'billing_city', true);
$address = get_user_meta($userids, 'billing_address_1', true) . " " . get_user_meta($userids, 'billing_address_2', true);

if (!$verification):
    ?>
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center"><?php echo __("Du har inte behörighet att visa denna sida."); ?></h1>
        </div>
    </div>

<?php else : ?>

    <div class="summary-hero col-md-12" style="background-image:url('<?php echo $hero_image_url; ?>');">
             <?php if ($order_accept_status === "Acceptavkund" || $order_accept_status === "true") : ?>
            <div class="summary-status text-center accept">
                <p class="summary-l"><?php echo __('Affärsförslag #') . $custom_order_number . __(' -  Orderbekräftelse ') ?></p>
            </div>
        <?php elseif ($order_accept_status === "false") : ?>
            <div class="summary-status text-center declined">
                <p class="summary-l"><?php echo __('Affärsförslag #') . $custom_order_number . __(' -  Har nekats av kund') ?></p>
            </div>

        <?php elseif ($order_accept_status === "Kundfråga") : ?>
            <div class="summary-status text-center declined">
                <p class="summary-l"><?php echo __('Affärsförslag #') . $custom_order_number . __(' -  Kund har frågor') ?></p>
            </div>
        <?php elseif ($order_accept_status === "archieved") : ?>
            <div class="summary-status text-center declined">
                <p class="summary-l"><?php echo ''; ?></p>
            </div>
        <?php else : ?>
            <div class="summary-status text-center wait">
                <p class="summary-l"><?php echo __('Affärsförslag #') . $custom_order_number . __(' -  Väntar på svar från kund') ?></p>
            </div>
        <?php endif; ?>
        <div class="summary-white-panel">
            <ul class="list-unstyled">

                <li>
                    <?php if ($address) : ?>

                        <h1 class="summary-lg"><?php echo getCustomerName($userids); ?></h1>
                        <h2 class="summary-l"><?php echo $useremail; ?></h2>
                        <h2 class="summary-l"><?php echo $address . ' ' . $city; ?></h2>
                        <h2 class="summary-l"><?php echo $phone; ?></h2>


                    <?php else : ?>

                        <h1 class="summary-lg"><?php echo getCustomerName($userids); ?></h1>
                        <h2 class="summary-l"><?php echo $useremail; ?></h2>
                        <h2 class="summary-l"><?php echo $city; ?></h2>
                        <h2 class="summary-l"><?php echo $phone; ?></h2>

                    <?php endif; ?>
                </li>
                <li>

                                                            <!--  <h2 class="summary-l"><?php //echo $order->billing_address_1 . ", " . $order->billing_city . " " . $order->billing_postcode                ?></h2> -->
                    <h2 style="text-transform: none;" class="summary-l"><?php echo $order_summary_heading; //$order_summary_addon_description;                ?></h2>

                </li>
            </ul>
        </div>
        <img class="watermark" src="<?php echo $logotype_url; ?>" alt="">

    </div>
    <div class="col-md-12">
        <?php if ($affarsforslaget_gallertom) { ?>


            <div class="col-md-6">
                <?php if ($order_accept_status == 'Kundfråga' || $order_accept_status == '') { ?>
                    <h4 class="summary-m" style="display: inline-block;padding-right: 5px;">Gäller t.o.m: </h4><h4
                        style="display: inline-block;"
                        class="summary-sm"> <?php echo $affarsforslaget_gallertom; ?></h4>

                <?php } ?>

            </div>
            <div class="col-md-6">
                <div class="print_div_icon" style="float:right;margin: auto;padding: 20px;">
                    <i class="fa fa-print fa-3x" aria-hidden="true"></i><br>
                    <div class="print_text print_div_icon">Utskriftsversion</div>
                </div>
            </div>

        <?php } else {
            ?>
            <div class="col-md-12">
                <div class="print_div_icon" style="float:right;margin: auto;padding: 20px;">
                    <i class="fa fa-print fa-3x" aria-hidden="true"></i><br>
                    <div class="print_text print_div_icon">Utskriftsversion</div>
                </div>
            </div>

            <?php
        }
        ?>

    </div>


    <?php
    include_once(plugin_dir_path(__FILE__) . 'order-summary-print_area.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/php-pdf/lib/TCPDF-master/tcpdf.php');
    ?>


    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <?php if ($b1_image_url) : ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 summary-image-card">
                        <img src="<?php echo $b1_image_url; ?>"
                             alt=""/>
                        <div class="summary-white-panel-sm">
                            <span class="summary-l"><?php echo $b1_image_description; ?></span>
                        </div>


                    </div>
                <?php endif; ?>
                <?php if ($b2_image_url) : ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 summary-image-card">
                        <img src="<?php echo $b2_image_url; ?>"
                             alt=""/>
                        <div class="summary-white-panel-sm">
                            <span class="summary-l"><?php echo $b2_image_description; ?></span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($b3_image_url): ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6 summary-image-card">
                        <img src="<?php echo $b3_image_url; ?>"
                             alt=""/>
                        <div class="summary-white-panel-sm">
                            <span class="summary-l"><?php echo $b3_image_description; ?></span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>



    <div class="container top-buffer">
        <?php if ($order_accept_status == 'true') { ?>
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="text-center" style="text-transform: none;">Orderbekräftelse</h1>
                    <p style="text-align:center;font-size: 16px">Tack för förtroendet! Vi bekräftar härmed din accept och beställning enligt nedanstående affärsförslag till dig.</p>
                </div>
            </div>

        <?php }
        ?>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center" style="text-transform: none;"><?php
                    echo $order_summary_heading;
                    ?></h1>
                <textarea name="mas" class="content" id="desc"><?php echo $order_summary_description; ?></textarea>
                <p>&nbsp;</p>
                <div class="mas" ></div>


            </div>
            <div class="col-lg-12">
                <h3 style="text-transform: none;" class=""><?php echo $order_summary_addon_heading; ?></h3>
                <textarea name="samman" class="samman_desc" id="samman_desc"><?php echo $order_summary_addon_description; ?></textarea>
                <p>&nbsp;</p>
                <div class="samman" ></div>
            </div>
        </div>
    </div>

    <div class="container top-buffer">
        <div class="row ">
            <?php
            $count = 1;
            $sorting_wise = unserialize(get_post_meta($order_id, "head_sortorderitems", true));

            $sorting_wise = array_unique($sorting_wise);
            /*
              if (empty($sorting_wise[1])) {

              foreach ($order->get_items() as $keys => $limeId) :
              if (wc_get_order_item_meta($keys, "HEAD_ITEM")){
              $sorting_wise[] = $keys;
              }
              endforeach;
              update_post_meta($order_id,'head_sortorderitems',serialize($sorting_wise));
              }
             */
            if (!empty($sorting_wise)) {
                foreach ($sorting_wise as $orderitemid) {
                    foreach ($order->get_items() as $key => $lineItem) :
                        $product = new WC_Product($lineItem['product_id']);

                        $item_data = $lineItem->get_data();

                        if ($orderitemid == $item_data['id']) {


                            if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'fakturaavgift' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabatt_produkt') {
                                if (wc_get_order_item_meta($key, "HEAD_ITEM") && empty($lineItem["line_item_note"])) :

                                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');
                                    //echo get_the_post_thumbnail( $product->get_id(), array( 212,300) );
                                    ?>
                                    <?php
                                    if ($count % 3 == 1) {

                                        echo '<div class="row">';
                                    }
                                    ?>
                                    <div class="col-lg-4 col-md-4 col-sm-6 product-list">

                                        <?php echo get_the_post_thumbnail($product->get_id(), array(300, 300)); ?>
                                        <h2 class=""><?php echo $product->get_title() ?></h2> <p><?php echo $product->post->post_excerpt; ?></p>
                                    </div>
                                    <?php
                                    if ($count % 3 == 0) {
                                        echo '</div>';
                                    }
                                    $count++;
                                    ?>


                                    <?php /*
                                      <a target="_blank"
                                      href="<?php the_permalink($product->get_id()); ?>"><?php echo __("Visa artikel"); ?></a>
                                     */ ?>



                                    <?php
                                endif;
                            }
                            ?>
                            <?php
                        } endforeach;
                }
            } else {
                foreach ($order->get_items() as $key => $lineItem) :
                    $product = new WC_Product($lineItem['product_id']);

                    if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'fakturaavgift' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabatt_produkt') {
                        if (wc_get_order_item_meta($key, "HEAD_ITEM") && empty($lineItem["line_item_note"])) :

                            $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');
                            //echo get_the_post_thumbnail( $product->get_id(), array( 212,300) ); 
                            ?>
                            <?php
                            if ($count % 3 == 1) {

                                echo '<div class="row">';
                            }
                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-6 product-list">

                                <?php echo get_the_post_thumbnail($product->get_id(), array(300, 300)); ?>
                                <h2 class=""><?php echo $product->get_title() ?></h2> <p><?php echo $product->post->post_excerpt; ?></p>
                            </div>
                            <?php
                            if ($count % 3 == 0) {
                                echo '</div>';
                            }
                            $count++;
                            ?>


                            <?php /*
                              <a target="_blank"
                              href="<?php the_permalink($product->get_id()); ?>"><?php echo __("Visa artikel"); ?></a>
                             */ ?>



                            <?php
                        endif;
                    }
                    ?>
                    <?php
                endforeach;
            }
            ?>


        </div>
    </div>


    <div class="container top-buffer new_case">
        <?php if ($compact == false) : ?>
            <div class="row">
                <?php
                $varOrderwithprice = get_field("order_summary-key-w-price", $_GET["order-id"]);
                $varOrderwithoutprice = get_field("order_summary-key-wo-price", $_GET["order-id"]);
                if ($varOrderwithprice == $_GET['order-key'] || $varOrderwithoutprice == $_GET['order-key']) {
                    ?>
                    <div class="col-lg-12 ">
                        <h3><?php echo __("Sammanfattning") ?></h3><br>

                        <table class="table">
                            <thead>
                                <tr>
                                    <!--    <th><?php /* echo __("Artikelnummer"); */ ?></th>-->
                                    <th  ><?php echo __("Benämning"); ?></th>
                                    <?php
                                    if ($varOrderwithprice == $_GET['order-key']) {

                                        if ($show_price === true) :
                                            echo $Pris = ' <th style="text-align: right;"></th>';
                                        endif;
                                    }
                                    echo $Antal = '<th style="text-align: right;">Antal</th>';
                                    if ($varOrderwithprice == $_GET['order-key']) {
                                        if ($show_price === true) :
                                            echo $Moms = ' <th style="text-align: right;width:20%;"></th>';
                                            echo $Summa = '<th style="text-align: right;">Summa</th>';
                                        endif;
                                    }
                                    ?>


                                </tr>
                            </thead>

                            <tbody>
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
                                        //         'custom_discount_product' => $custom_discount_product
                                );
                                ///$sorting_wise = unserialize(get_post_meta($order_id, "head_sortorderitems", true));
                                //	$sorting_wise = array_unique($sorting_wise);
                                //$sorting_wise = '';

                                if (!empty($sorting_wise)) {
                                    foreach ($sorting_wise as $orderitemid) {

                                        foreach ($order->get_items() as $key => $lineItem) :



                                            $product = new WC_Product($lineItem['product_id']);

                                            if (wc_get_order_item_meta($key, "HEAD_ITEM")) {
                                                $item_data = $lineItem->get_data();

                                                if ($orderitemid == $item_data['id']) {

                                                    $item_total = wc_get_order_item_meta($key, '_line_total', true) + wc_get_order_item_meta($key, '_line_tax', true);
                                                    array_push($moms_array, abs($lineItem['subtotal_tax']));
                                                    ?>
                                                    <tr>

                                                        <?php
                                                        if (!in_array($lineItem['product_id'], $custom_adjust_price_array)) {
                                                            $title_benamning = $lineItem['name'];

                                                            if (!empty($lineItem["line_item_note"])) {

                                                                if ($lineItem["line_item_note"] == 'Avgift') {
                                                                    $title_benamning_note = '';
                                                                } else {
                                                                    $title_benamning_note = '-' . $lineItem["line_item_note"];
                                                                }
                                                            } else {
                                                                $title_benamning_note = '';
                                                            }
                                                            //   $title_benamning_note = wc_get_order_item_meta($lineItem->get_id(), 'line_item_special_note', true);
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

                                                        <td><?php echo $title_benamning . saleFunction($product, $lineItem['product_id'], $item_total); ?>
                                                            <i><?php echo $extratitle; ?></i>
                                                        </td>
                                                        <?php //if ($show_price === true) :    ?>
                                                        <td style="text-align: right;">

                                                        </td>
                                                        <?php //endif;   ?>
                                                        <td style="text-align: right;"><?php
                                                        if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'fakturaavgift' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabatt_produkt') {
                                                            echo $lineItem['quantity'];
                                                        } else {
                                                            echo 1;
                                                        }
                                                        ?></td>
                                                            <?php if ($show_price === true) : ?>
                                                            <td style="text-align: right;"><?php
                                    // echo /* abs */
                                    //wc_price($lineItem['subtotal_tax']);
                                                                ?>
                                                            </td>
                                                            <td style="text-align: right;color:#000000!important;font-size: 18px;font-weight: bold"><?php echo wc_price($lineItem['total'] + $lineItem['subtotal_tax']); ?>
                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>

                                                    <?php
                                                }
                                            } endforeach;
                                    }
                                } else {
                                    foreach ($order->get_items() as $key => $lineItem) :
                                        $product = new WC_Product($lineItem['product_id']);
                                        if (wc_get_order_item_meta($key, "HEAD_ITEM")) {
                                            $item_total = wc_get_order_item_meta($key, '_line_total', true) + wc_get_order_item_meta($key, '_line_tax', true);
                                            array_push($moms_array, abs($lineItem['subtotal_tax']));
                                            ?>
                                            <tr>

                                                <?php
                                                if (!in_array($lineItem['product_id'], $custom_adjust_price_array)) {
                                                    $title_benamning = $lineItem['name'];
                                                    if (!empty($lineItem["line_item_note"])) {
                                                        if ($lineItem["line_item_note"] == 'Avgift') {
                                                            $title_benamning_note = '';
                                                        } else {
                                                            $title_benamning_note = '-' . $lineItem["line_item_note"];
                                                        }
                                                    } else {
                                                        $title_benamning_note = '';
                                                    }
                                                    //   $title_benamning_note = wc_get_order_item_meta($lineItem->get_id(), 'line_item_special_note', true);
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
                                                <td><?php echo $title_benamning . saleFunction($product, $lineItem['product_id'], $item_total); ?>
                                                    <i><?php echo $extratitle; ?></i>
                                                </td>
                                                <?php //if ($show_price === true) :   ?>
                                                <td style="text-align: right;">

                                                </td>
                                                <?php //endif;   ?>
                                                <td style="text-align: right;"><?php
                                                if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'fakturaavgift' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabatt_produkt') {

                                                    echo $lineItem['quantity'];
                                                } else {
                                                    echo 1;
                                                }
                                                ?></td>
                                                    <?php if ($show_price === true) : ?>
                                                    <td style="text-align: right;"><?php
                            // echo /* abs */
                            //wc_price($lineItem['subtotal_tax']);
                                                        ?>
                                                    </td>
                                                    <td style="text-align: right;color:#000000!important;font-size: 18px;font-weight: bold"><?php echo wc_price($lineItem['total'] + $lineItem['subtotal_tax']); ?>

                                                    </td>
                                                <?php endif; ?>
                                            </tr>  <?php
                                            } endforeach;
                                    }
                                    $sortorderitems = unserialize(get_post_meta($order->ID, 'sortorderitems', true));
                                    $sortorderitems = array_unique($sortorderitems);
                                    if (!empty($sortorderitems)) {
                                        foreach ($sortorderitems as $orderitemids) {
                                            foreach ($order->get_items() as $key => $lineItem) :
                                                $product = new WC_Product($lineItem['product_id']);
                                                if (!wc_get_order_item_meta($key, "HEAD_ITEM")) {
                                                    $item_data = $lineItem->get_data();

                                                    if ($orderitemids == $item_data['id']) {
                                                        $item_total = wc_get_order_item_meta($key, '_line_total', true) + wc_get_order_item_meta($key, '_line_tax', true);
                                                        array_push($moms_array, abs($lineItem['subtotal_tax']));
                                                        ?>
                                                    <tr>
                                                        <!--  <td><?php /* echo $product->get_sku(); */
                                ?></td>-->
                                                        <?php
                                                        if (!in_array($lineItem['product_id'], $custom_adjust_price_array)) {
                                                            $title_benamning = $lineItem['name'];

                                                            if (!empty($lineItem["line_item_note"])) {

                                                                if ($lineItem["line_item_note"] == 'Avgift') {
                                                                    $title_benamning_note = '';
                                                                } else {
                                                                    $title_benamning_note = '-' . $lineItem["line_item_note"];
                                                                }
                                                            } else {
                                                                $title_benamning_note = '';
                                                            }
                                                            //   $title_benamning_note = wc_get_order_item_meta($lineItem->get_id(), 'line_item_special_note', true);
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
                                                        <td><?php echo $title_benamning . saleFunction($product, $lineItem['product_id'], $item_total); ?>
                                                            <i><?php echo $extratitle; ?></i>
                                                        </td>
                                                        <?php //if ($show_price === true) :   ?>
                                                        <td style="text-align: right;">

                                                        </td>
                                                        <?php //endif;   ?>
                                                        <td style="text-align: right;"><?php
                                                        if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'fakturaavgift' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabatt_produkt') {

                                                            echo $lineItem['quantity'];
                                                        } else {
                                                            echo 1;
                                                        }
                                                        ?></td>
                                                            <?php if ($show_price === true) : ?>
                                                            <td style="text-align: right;"><?php
                                    // echo /* abs */
                                    //wc_price($lineItem['subtotal_tax']);
                                                                ?>
                                                            </td>
                                                            <td style="text-align: right;color:#000000!important;font-size: 18px;font-weight: bold"><?php echo wc_price($lineItem['total'] + $lineItem['subtotal_tax']); ?>

                                                            </td>
                                                        <?php endif; ?>
                                                    </tr>

                                                    <?php
                                                }
                                            } endforeach;
                                    }
                                } else {

                                    foreach ($order->get_items() as $key => $lineItem) :
                                        $product = new WC_Product($lineItem['product_id']);
                                        if (!wc_get_order_item_meta($key, "HEAD_ITEM")) {
                                            $item_total = wc_get_order_item_meta($key, '_line_total', true) + wc_get_order_item_meta($key, '_line_tax', true);
                                            array_push($moms_array, abs($lineItem['subtotal_tax']));
                                            ?>
                                            <tr>
                                                <!--  <td><?php /* echo $product->get_sku(); */
                        ?></td>-->
                                                <?php
                                                if (!in_array($lineItem['product_id'], $custom_adjust_price_array)) {
                                                    $title_benamning = $lineItem['name'];

                                                    if (!empty($lineItem["line_item_note"])) {

                                                        if ($lineItem["line_item_note"] == 'Avgift') {
                                                            $title_benamning_note = '';
                                                        } else {
                                                            $title_benamning_note = '-' . $lineItem["line_item_note"];
                                                        }
                                                    } else {
                                                        $title_benamning_note = '';
                                                    }
                                                    //   $title_benamning_note = wc_get_order_item_meta($lineItem->get_id(), 'line_item_special_note', true);
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
                                                <td><?php echo $title_benamning . saleFunction($product, $lineItem['product_id'], $item_total); ?>
                                                    <i><?php echo $extratitle; ?></i>
                                                </td>
                                                <?php //if ($show_price === true) :   ?>
                                                <td style="text-align: right;">

                                                </td>
                                                <?php //endif;   ?>
                                                <td style="text-align: right;"><?php
                                                if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'fakturaavgift' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabatt_produkt') {

                                                    echo $lineItem['quantity'];
                                                } else {
                                                    echo 1;
                                                }
                                                ?></td>
                                                    <?php if ($show_price === true) : ?>
                                                    <td style="text-align: right;"><?php
                            // echo /* abs */
                            //wc_price($lineItem['subtotal_tax']);
                                                        ?>
                                                    </td>
                                                    <td style="text-align: right;color:#000000!important;font-size: 18px;font-weight: bold"><?php echo wc_price($lineItem['total'] + $lineItem['subtotal_tax']); ?>

                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                            <?php
                                        } endforeach;
                                }
                                ?>
                                <?php
                                if ($show_price === true) :

                                    $order_total_price = $order->get_total();

                                    if (get_field('imm-sale-tax-deduction', $order->get_id()) || get_post_meta($order->get_id(), "confirmed_rot_percentage", true)) {
                                        $rot_avdrag = get_post_meta($order->get_id(), "confirmed_rot_percentage", true);
                                        $display_price = $order_total_price - $rot_avdrag;
                                    } else {
                                        $rot_avdrag = 0;
                                        $display_price = $order_total_price;
                                    }

                                    if ($rot_avdrag > 0) :
                                        ?>
                                        <tr>
                    <!--         <td></td>-->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td id="totalsum" style="text-align: right;"><strong><?php echo __("Summa: "); ?></strong></td>
                                            <td style="text-align: right;"><?php
                    $rotprice = (0 - $rot_avdrag);
                    ;
                    $sum = $display_price - (0 - $rot_avdrag);
                    echo wc_price($sum);
                                        ?>
                                            </td>
                                        </tr>

                                        <tr>
                                                                                    <!--  <td></td>-->
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right;">
                                                <strong><?php echo __("Avgår ROT-avdrag: "); ?></strong>
                                            </td>
                                            <td style="text-align: right;"><?php echo wc_price(0 - $rot_avdrag); ?>
                                            </td>
                                        </tr>

                <?php endif; ?>
                                    <tr>
                <!--         <td></td>-->
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td id="totalsum" style="text-align: right;"><strong><?php echo __("Summa att betala: "); ?></strong></td>
                                        <td id="totalsum" style="text-align: right; width:20%"><?php echo wc_price($display_price); ?>
                                        </td>
                                    </tr>

                                    <tr>
                                        <!--       <td></td>-->
                                        <td></td>
                                        <td></td>
                                        <td></td>

                                        <td style="text-align: right;"><strong><?php echo __("Moms ingår med: "); ?></strong></td>
                                        <td style="text-align: right;color:#000000!important;font-size: 18px;font-weight: bold"><?php
                                            /* echo array_sum($moms_array).' kr'; */
                                            echo wc_price($order->get_total_tax());
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                       <!--  <td></td>-->
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="text-align: right;"><strong><?php echo __("Summa ex moms: "); ?></strong>
                                        </td>
                                        <td style="text-align: right;font-size: 18px"><?php echo wc_price($order->get_total() - $order->get_total_tax()); ?>
                                        </td>
                                    </tr>
            <?php endif; ?>

                            </tbody>
                        </table>

                        <?php
                        $project_type = get_field('order_project_type', $_GET['order-id']);

                        $project_type1 = $project_type;

                        if ($project_type1 == 'service') {
                            if (!empty($typeservice) || $beskrivning) {
                                ?>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12" id="inner_srvc">
                                            <div class="services_txt">
                                                <h4>typ av service:</h4>
                    <?php echo $typeservice; ?></br>
                                            </div>
                                            <div class="services_txt">
                                                <h4>Kundens beskrivning av problemet:</h4>
                    <?php echo $beskrivning; ?> </br>
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div>
                                <?php
                            }
                        }
                        ?>
                        </style>
                    <?php }
                    ?>
                    <p>
                        <strong>Betalningstyp: </strong>  </p>
                    <p> <?php echo get_field('order_status_betainingstyp', $_GET['order-id']); ?>
                    </p>
                    <p>
                        <strong>Betalningsvillkor: </strong></p>

                    <?php
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
                    echo "<p>" . $betal_array[$betal_methord] . "</p>";
                    ?>
                    <p><strong>Reservationer: </strong></p>
                    <P>
                        <?php
                        $betal_methord = get_field('order_recervation_method', $_GET['order-id']);
                        $reservation_egen = get_field('order_recervation_method_egen', $_GET['order-id']);
                        $reservationegen = get_field('order_recervation_method_egen', $_GET['order-id']);
                        $order_recervation_method_id = get_field('order_recervation_method_id', $_GET['order-id']);
                        // $stripped_array = array();
                        $project_type_id = get_field('order_project_type', $_GET["order-id"]);
                        if (!empty($order_recervation_method_id)) {
                            foreach (getReservartion($order_recervation_method_id) as $method) {
                                $stripped = trim(preg_replace('!\s+!', ' ', $method->name));
                                if (!empty($method->links)) {
                                    echo '<a href="' . $method->links . '" target="_blank">' . $stripped . '</a><br>';
                                } else {
                                    echo $stripped . '<br>';
                                }
                            }
                        }
                        if ($reservation_egen) {
                            ?>
                            <textarea name="reservation" class="content" id="desc"><?php echo $reservation_egen; ?></textarea>

                        <div class="mas_reserv" ></div>

                        <textarea name="reserve" class="reserv_desc" id="reserv_desc"><?php echo $reservationegen; ?></textarea>

                        <div class="reserve" ></div>
                        </P>

                        <P>
                            <strong>Garanti: </strong></p><p><?php
                            $betal_methord = get_field('order_garanti_method', $_GET['order-id']);
                            echo str_replace('fackmässigt', 'fackmannamässigt', $betal_methord);
                            // echo $betal_methord;
                            ?></P>

                    </div>
            <?php } ?>
            </div>
        <?php endif; ?>
        <?php
        if (have_rows('filer_order', $_GET['order-id'])):
            echo '<P><strong>Filer: </strong><br>';
            // loop through the rows of data
            while (have_rows('filer_order', $_GET['order-id'])) : the_row();
                // display a sub field value
                $namn = get_sub_field('namn');
                $url = get_sub_field('url');
                echo '<a target="_blank" href="' . $url . '" download>' . $namn . '</a><br>';
            endwhile;


            echo '</P>';
        endif;
        ?>
        <form action="" method="POST" id="formsubmission">
            <input type="hidden" name="accept" value="true">
            <?php
            /*        if ($order_accept_status) {
              echo ' <label for="">
              <a data-toggle="modal" data-target="#payment-terms-modal" href="#">
              Mariebergs villkor för betalning och personuppgifter.</a>
              </label>';
              } */
            ?>

            <div class="row top-buffer">
    <?php if (!$order_accept_status || $order_accept_status == 'Kundfråga') : ?>
                    <div id="acceptance_div" >
                        <input type="checkbox" id="accept_order_checkbox">
                        <label for="">
                            <a data-toggle="modal" data-target="#payment-terms-modal" href="#">
        <?php echo __("Jag accepterar Mariebergs villkor för betalning och personuppgifter."); ?></a>
                        </label>
                        <span class="tooltiptext1"><strong>Du måste godkänna villkoren</strong></span>

                    </div>
    <?php endif; ?>
                <div class="col-lg-6"  ><?php if (!$order_accept_status || $order_accept_status == 'Kundfråga') : ?>

                        <div class="newitem">
                            <button type="button" 
                                    id="accept_order_btn1"  class="accept-panel text-center summary-lg"  style="color:#000000; margin:0; width: 100%;">
        <?php echo __("Godkänn vårt affärsförslag") ?>

                            </button>
                            <button type="submit" style="display:none;color:#000000; margin:0; width: 100%;"
                                    id="accept_order_btn"  class="accept-panel text-center summary-lg"  disabled>
        <?php echo __("Godkänn vårt affärsförslag") ?>

                            </button></div>

                        <!--<br><br><br><br><br>-->
                        <div class="customer-qustn">
                            <span style="float: right; width: 49.5%; font-weight: bold; margin: 1px;" class="col-container1">
                                <a class="text-lg"
                                   href="<?php echo $_SERVER['REQUEST_URI'] . "&accept=declined" ?>"><?php echo __("Neka affärsförslaget"); ?></a>

                            </span>
                            <span style="float: left; width: 49.5%; font-weight: bold; margin: 1px;" class="col-container2"><a class="text-lg"
                                                                                                                               href="<?php echo $_SERVER['REQUEST_URI'] . "&accept=Kundfråga" ?>"><?php echo __("Frågor? Klicka här"); ?></a>
                            </span>

                        </div>

    <?php endif; ?>
                </div>

                <div class="col-lg-6">
                    <div class="price-panel summary-panel text-center all-product" >
                        <?php
                        $varOrderwithprice = get_field("order_summary-key-w-price", $_GET["order-id"]);
                        $varOrderwithoutprice = get_field("order_summary-key-wo-price", $_GET["order-id"]);
                        $order = new WC_Order($order->get_id());
                        if ($varOrderwithoutprice == $_GET['order-key']) {
//    echo'yes1';
                        } elseif ($varOrderwithprices == $_GET['order-key']) {
                            ?>
                            <table class="table" >
                                <?php
                                foreach ($order->get_items() as $key => $lineItem) :

                                    if (!in_array($lineItem['product_id'], $custom_adjust_price_array)) {
                                        $title_benamning = $lineItem['name'];

                                        if ($lineItem["line_item_note"]) {
                                            $title_benamning_note = '-' . $lineItem["line_item_note"];
                                        }
//                                        $title_benamning_note = wc_get_order_item_meta($lineItem->get_id(), 'line_item_special_note', true);
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

                                    $price = wc_price($lineItem['total'] + $lineItem['subtotal_tax']);
//                            echo $title_benamning.'-'.$title_benamning_note.'-'.$price; 
                                    ?>
                                    <tr><td><?php echo $title_benamning . '' . $title_benamning_note; ?></td><td><?php echo $price; ?></td></tr>

                            <?php endforeach; ?>
                            </table>
                            <?php
                        }
                        if ($rot_avdrag) {
                            $varrotavdrag = round($rot_avdrag) . ' kr';
                        } else {
                            $varrotavdrag = '0 kr';
                        }
                        ?>
                        <span class="summary-lg"
                              style="color: #8acd6c;"><?php echo wc_price($display_price); ?></span>
                        <span class="price-pan-content"
                              style="color:#000000;font-size: 17px !important;font-weight: normal !important;display: block;margin: 5px 0 0 0;" ><?php echo __("Avgår ROT-avdrag: ") . $varrotavdrag; ?></span>
                    </div>

                </div>
            </div>
        </form>
    </div>


    <hr>
    <div class="container top-buffer">
        <div class="row">
            <?php
            // $project_id = get_field('imm-sale_project_connection', $order->get_id());
            $project_salesman_id = get_post_meta($order->get_id(), "order_salesman_o")[0];
            $salesman = get_userdata($project_salesman_id);

            $salemanemail = $salesman->user_email;
            $namesale = $salesman->first_name . " " . $salesman->last_name;
            ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <?php echo get_avatar($salesman->user_email, 400); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

                <ul class="list-unstyled">
                    <li><p class=""><strong style="font-size: 28px"><?php echo __("Din personliga säljare") ?></strong>
                        </p></li>
                    <li><?php echo getCustomerName($project_salesman_id); ?>
                    </li>
                    <li><strong><?php echo __("E-mail: ") ?></strong><a
                            href="mailto:<?php echo $salesman->user_email ?>"
                            target="_blank"><?php echo $salesman->user_email ?></a></li>

                    <li>
                        <?php
                        $firstPart = substr($salesman->personal_phone, 0, strrpos($salesman->personal_phone, '/'));
                        $lastPart = substr($salesman->personal_phone, strrpos($salesman->personal_phone, '/') + 1);
                        ?>

                        <strong>Telefonnummer: </strong>


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
    </div>
<?php endif; ?>

<div class="container top-buffer">
    <div class="footer-text">
        <span>Mariebergs Brasvärme AB</span><br>
        <span>organisationsnummer 556259-7681</span>

    </div>
</div>


<div id="payment-terms-modal" tabindex="-1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo __("Villkor"); ?></h4>
            </div>
            <div class="modal-body setting-modal-body">
                <?php
                $post = get_post(82469);

                echo wpautop($post->post_content);
                ?>
            </div>
            <div class="modal-footer">
<?php bloginfo(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('mariebergsalset');
$pdf->SetTitle('Orderbekräftelse');
$pdf->SetSubject('Here is the order confirmation of your order or similar standard text');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
//$pdf->setFooterData(array(0,64,0), array(0,64,128));
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

// Set some content to print

$tbl = '<img src="/wp-content/uploads/2018/07/Mariebergs-Logo-Svart-ny.png" alt="" class="center-block"
             style="margin-left:250px;margin-bottom: 10px;max-width: 100px;height:100px;">';
$tbl .= '<h1>orderbekräftelse  ' . $custom_order_number . ' </h1>';

$summary = $order_summary_description;


$summary = str_replace("affärsförlag", "orderbekräftelse", $summary);
$summary = str_replace("Offerten", "orderbekräftelsen", $summary);


//$tbl.='<p>'.$order_summary_heading.'</p>';

$tbl .= '<p>Tack för din order.</p>';

$tbl .= '<p>' . $summary . '</p>';

$tbl .= ' <p>Sammanfattning</p>';

$tbl .= '<table cellspacing="0" cellpadding="1" border="1">
    <tr>
        <th >Benämning</th>' . $Pris . $Antal . $Moms . $Summa . '
       
    </tr>';
foreach ($order->get_items() as $key => $lineItem) :
    $product = new WC_Product($lineItem['product_id']);
    array_push($moms_array, abs($lineItem['subtotal_tax']));

    $tbl .= '<tr>';
    ?> <!--  <td><?php /* echo $product->get_sku(); */
    ?></td>-->
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

    $tbl .= '<td>' . $title_benamning . '<i>' . $title_benamning_note . '</i></td>';
    ?>
    <?php
    if ($show_price === true) :
        $tbl .= '<td>';

        if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'fakturaavgift' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabbat_produkt') {
            if ($lineItem['subtotal'] == 0 || $lineItem['quantity'] == 0) {
                $subtotal = 0;
            } else {
                $subtotal = $lineItem['subtotal'] / $lineItem['quantity'];
            }
            //echo /*wc_price(*/
            $tbl .= wc_price($subtotal) /* ) */
            ;
        } elseif ($product->get_sku() === 'prisjustering') {
            $tbl .= wc_price($lineItem['total']);
        } else {
            $tbl .= wc_price($lineItem['total']);
        }

        $tbl .= '</td>';
    endif;
    $tbl .= '<td>';
    if ($product->get_sku() != 'arbetsorder' && $product->get_sku() != 'prisjustering-tillagg-1' && $product->get_sku() != 'arbetsorder-1' && $product->get_sku() != 'materialkostnad' && $product->get_sku() != 'fakturaavgift' && $product->get_sku() != 'prisjustering' && $product->get_sku() != 'prisjustering-tillagg' && $product->get_sku() != 'forskottsfaktura-avgar' && $product->get_sku() != 'rabbat_produkt') {

        $tbl .= $lineItem['quantity'];
    } else {
        $tbl .= 1;
    }
    $tbl .= '</td>';
    if ($show_price === true) :
        $tbl .= '<td>';
        //echo /*abs*/
        $tbl .= wc_price($lineItem['subtotal_tax']);

        $tbl .= '</td>';
        $tbl .= '<td>';
        $tbl .= wc_price($lineItem['total'] + $lineItem['subtotal_tax']);


        $tbl .= '</td>';
    endif;
    $tbl .= '</tr>';

endforeach;

if ($show_price === true) {

    $order_total_price = $order->get_total();

    if (get_field('imm-sale-tax-deduction', $order->get_id()) || get_post_meta($order->get_id(), "confirmed_rot_percentage", true)) {
        $rot_avdrag = get_post_meta($order->get_id(), "confirmed_rot_percentage", true);
        $display_price = $order_total_price - $rot_avdrag;
    } else {
        $rot_avdrag = 0;
        $display_price = $order_total_price;
    }
    if ($rot_avdrag > 0) :

        $tbl .= '<tr>
                                
                                <td></td>
                                <td></td>
                                <td></td>
                                <td Avgår ROT-avdrag:
                                </td>
                                <td style="text-align: right;">' . wc_price(0 - $rot_avdrag) . '
                                </td>
                            </tr>';

    endif;
    $tbl .= '<tr>
                               
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Summa ex moms: 
                                </td>
                                <td >' . wc_price($order->get_total() - $order->get_total_tax()) . '
                                </td>
                            </tr>
                            <tr>
                            
                                <td></td>
                                <td></td>
                                <td></td>

                                <td>Moms: </td>
                                <td>
                                    ' . $order->get_total_tax() . ' 
                                </td>
                            </tr>
                            <tr>';

    $tbl .= '<td></td>
                                <td></td>
                                <td></td>
                                <td >Totalsumma:</td>
                                <td >' . wc_price($display_price) . '
                                </td>
                            </tr>';
}

$project_type = get_field('order_project_type', $_GET['order-id']);

$project_type1 = $project_type;

$tbl .= '</tbody></table>';
if ($project_type1 == 'service') {

    $tbl .= '<div class="container">
		<div class="row">
		 <div class="col-md-12" id="inner_srvc">
		 <div class="services_txt">
			<h4>typ av service:</h4>' . $typeservice . '
			</div>
			 <div class="services_txt">
			<h4>beskrivning:</h4>' . $beskrivning . ' 
		</div>
		</div>
		</div><!--row-->
		</div>';
}
?>


<?php wp_footer(); ?>
<script>jQuery(document).ready(function () {
        var value = jQuery('textarea#desc').val();
        var samman_desc = jQuery('textarea#samman_desc').val();
        var reserv_desc = jQuery('textarea#reserv_desc').val();
        jQuery('.content').hide();
        jQuery('.samman_desc').hide();
        jQuery('.reserv_desc').hide();
        jQuery('.mas').html(value.replace(/\r?\n/g, '<br/>'));
        jQuery('.reserve').html(reserv_desc.replace(/\r?\n/g, '<br/>'));
        jQuery('.samman').html(samman_desc.replace(/\r?\n/g, '<br/>'));
    });</script>
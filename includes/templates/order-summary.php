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
$userref= get_user_meta($userids, 'reference_name', true);

$phone = get_user_meta($userids, 'billing_phone', true);
$company = get_user_meta($userids, 'billing_company', true);
$city = get_user_meta($userids, 'billing_city', true);
$address = get_user_meta($userids, 'billing_address_1', true) . " " . get_user_meta($userids, 'billing_address_2', true);
$estimateStatus = array("Acceptavkund" => array("accept", "Orderbekräftelse"), "true" => array("accept", "Orderbekräftelse"), "false" => array("accept", "Har nekats av kund"), "Kundfråga" => array("declined", "Kund har frågor"), "archieved" => array("declined", "Väntar på svar från kund"));
?>
<link rel="stylesheet" href="https://mariebergsalset.com/wp-content/plugins/imm-sale-system/css/order_summary.css" type="text/css" media="all">

<section class="container-fluid newWidthCheck" style="position:relative"> 
    <div class="bgimage"  style="background: url('<?php echo $hero_image_url; ?>');">
	
        <div class="row">
            <nav class="navbar navbar-expand-md navbar-light bg-light">
                <?php
                foreach ($estimateStatus as $keys => $values) {

                    if ($order_accept_status == $keys) {
                        echo '<p class="top-content ' . $values[0] . '">' . __('Affärsförslag #') . $custom_order_number . __(' - ' . $values[1] . ' ') . "</p>";
                    }
                    if (empty($order_accept_status)) {
                        echo '<p class="top-content wait">' . __('Affärsförslag #') . $custom_order_number . __(' - Väntar på svar från kund ') . "</p>";
                        break;
                    }
                }
                ?>
            </nav>
			 <div class="logo_estimate">
            <img  src="https://mariebergsalset.com/wp-content/uploads/2017/11/logo-white.png" alt="">
        </div>
        </div>

    </div>

    <div class=" newaddress col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <div class="specailaddress">
            <ul>
                <li ><?= getCustomerName($userids) ?></li>
                <li >Referens: <?= $userref ?></li>
                <li ><?= $useremail ?></li>
                <li ><?= ($address) ? $address . ' ' . $city : $city; ?></li>
                <li ><?= $phone ?></li>
                <li><?= $order_summary_heading ?></li>

            </ul>

        </div>
       		</div>		

</section>
<div class="container-fluid top-buffer">
    <div class="row">
        <?php if ($affarsforslaget_gallertom) {
            $classPrint = "col-md-6";
            ?>


            <div class="col-xs-12 col-sm-6  col-md-6 newCenterIN">
    <?php if ($order_accept_status == 'Kundfråga' || $order_accept_status == '') { ?>
                    <h4 class="summary-m" style="display: inline-block;padding-right: 5px;">Gäller t.o.m: </h4><h4
                        style="display: inline-block;"
                        class="summary-sm"> <?php echo $affarsforslaget_gallertom; ?></h4>

    <?php } ?>

            </div>


        <?php }
        ?>
        <div class="col-xs-12 col-sm-6  <?= ($classPrint) ? $classPrint : "col-md-12" ?> text-right newCenterIN">
            <div class="print_div_icon">
                <i class="fa fa-print fa-3x" aria-hidden="true"></i><br>
                <div class="print_text print_div_icon">Utskriftsversion</div>
            </div>
        </div>

    </div>

</div>
<?php
include_once(plugin_dir_path(__FILE__) . 'order-summary-print_area.php');
// include_once($_SERVER['DOCUMENT_ROOT'] . '/php-pdf/lib/TCPDF-master/tcpdf.php');
?>
<div class="container-fluid top-buffer">
    <?php
    for ($z = 1; $z <= 3; $z++) {
        $getimages = get_field('b' . $z, $order->ID);
        if ($getimages) :
            ?>
            <div class="col-xs-12 col-sm-6  col-md-4 col-lg-4 summary-image-card">
                <img src="<?= $getimages ?>"
                     alt=""/>
                <div class="summary-white-panel-sm">
                    <span class="summary-l"><?= get_field('b' . $z . '_image_description', $order->ID) ?></span>
                </div>


            </div>

        <?php endif;
    }
    ?>
</div>

<div class="container card-text"> <div class="row">
        <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12 newcenter">
<?php if ($order_accept_status == 'true') { ?>


                <h1 class="text-center" style="text-transform: none;">Orderbekräftelse</h1>
                <p style="text-align:center;font-size: 16px">Tack för förtroendet! Vi bekräftar härmed din accept och beställning enligt nedanstående affärsförslag till dig.</p>


<?php } ?>

            <div class="clearfix visible-xs-block"></div>

            <h1 class="text-center" style="text-transform: none;"><?php
echo $order_summary_heading;
?></h1>
            <textarea name="mas" class="content" id="desc"><?php echo $order_summary_description; ?></textarea>

            <div class="mas" ></div>

            <div class="clearfix visible-xs-block"></div>

            <h3 style="text-transform: none;" class=""><?php echo $order_summary_addon_heading; ?></h3>
            <textarea name="samman" class="samman_desc" id="samman_desc"><?php echo $order_summary_addon_description; ?></textarea>

            <div class="samman" ></div>
        </div>

    </div>
</div>
<div class="container card-text">

    <?php
	  foreach ($order->get_items() as $key => $lineItem) {
		  if(wc_get_order_item_meta($key, 'HEAD_ITEM', true)){
			  $headsid[] = $key;
		  }else{
			  $withouthead[] = $key;
		  }
	  }
    $notIncludeProduct = array('arbetsorder', 'prisjustering-tillagg-1', 'arbetsorder-1', 'materialkostnad', 'fakturaavgift', 'prisjustering', 'prisjustering-tillagg', 'forskottsfaktura-avgar', 'rabatt_produkt');


    $count = 1;
    $sorting_wise = unserialize(get_post_meta($order_id, "head_sortorderitems", true));

    $sorting_wise = array_unique($sorting_wise);

    function getProductFromOrder($item, $count, $notIncludeProduct) {
        if ($item['HEAD_ITEM'] && empty($item['line_item_note'])) :
            $product = new WC_Product($item['product_id']);
            if (!in_array($product->get_sku(), $notIncludeProduct)) {

                $image = wp_get_attachment_image_src(get_post_thumbnail_id($product->get_id()), 'single-post-thumbnail');

                if ($count % 3 == 1) {

                    echo '<div class="row">';
                }
                ?>
                <div class="col-lg-4 col-md-4 col-sm-6 product-list">

                <?php echo get_the_post_thumbnail($product->get_id(), array(300, 300)); ?>
                    <h2><?php echo $product->get_title() ?></h2> <p><?php echo $product->post->post_excerpt; ?></p>
                </div>
                <?php
                if ($count % 3 == 0) {
                    echo '</div>';
                }
            }
        endif;
    }
	$headsortValues = array_intersect($sorting_wise,$headsid);

if (!empty($sorting_wise) && count($headsid) == count($sorting_wise) && count($headsortValues) == count($sorting_wise)){

        foreach ($headsortValues as $orderitemid) {

            $item = new WC_Order_Item_Product($orderitemid); 
            getProductFromOrder($item, $count, $notIncludeProduct);
            $count++;

        }
    } else {
        foreach ($order->get_items() as $key => $lineItem) {
            getProductFromOrder($lineItem, $count, $notIncludeProduct);
            $count++;
        }
    }
    ?>


</div>
<div class="container top-buffer new_case card-text">
        <?php if ($compact == false) : ?>
        <div class="row">
            <?php

            function newCase($lineItem, $moms_array, $notIncludeProduct, $show_price, $custom_adjust_price_array) {

                $product = new WC_Product($lineItem['product_id']);


                $item_total = $lineItem['total'] + $lineItem['total_tax'];
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

                    <td id="newwidth"> <?php echo $title_benamning . saleFunction($product, $lineItem['product_id'], $item_total); ?>
                        <i><?php echo $extratitle; ?></i>
                    </td>

                    <td style="text-align: right;">

                    </td>

                    <td style="text-align: right;"><?php
                        if (!in_array($product->get_sku(), $notIncludeProduct)) {
                            echo $lineItem['quantity'];
                        } else {
                            echo 1;
                        }
                        ?></td>
        <?php if ($show_price === true) : ?>
                        <td style="text-align: right;">         </td>
                        <td style="text-align: right;color:#000000!important;font-size: 18px;font-weight: bold"><?php echo wc_price($lineItem['subtotal'] + $lineItem['subtotal_tax']); ?>
                        </td>
                <?php endif; ?>
                </tr>

                <?php
            }

            $varOrderwithprice = get_field("order_summary-key-w-price", $_GET["order-id"]);
            $varOrderwithoutprice = get_field("order_summary-key-wo-price", $_GET["order-id"]);
            if ($varOrderwithprice == $_GET['order-key'] || $varOrderwithoutprice == $_GET['order-key']) {
                ?>

                <h3><?php echo __("Sammanfattning") ?></h3><br>

                <table class="table" style="    word-break: break-all;">
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
                        $custom_adjust_price_array = array($custom_price_adjust_product_id, $custom_price_adjust_negative_product_id, $custom_price_adjust_arbetet_product_id, $custom_price_adjust_material_product_id);


if (!empty($sorting_wise) && count($headsid) == count($sorting_wise) && count($headsortValues) == count($sorting_wise)){
                            foreach ($headsortValues as $orderitemid) {
                                $item = new WC_Order_Item_Product($orderitemid);
                                newCase($item, $moms_array, $notIncludeProduct, $show_price, $custom_adjust_price_array);
                            }
                        } else {
                            foreach ($order->get_items() as $key => $lineItem) :

                                if (wc_get_order_item_meta($key, "HEAD_ITEM")) {
                                    $item = new WC_Order_Item_Product($key);
                                    newCase($item, $moms_array, $notIncludeProduct, $show_price, $custom_adjust_price_array);
                                }
                            endforeach;
                        }
                        $sortorderitems = unserialize(get_post_meta($order->ID, 'sortorderitems', true));
                        $sortorderitems = array_unique($sortorderitems);
                        if (!empty($sortorderitems)) {
                            foreach ($sortorderitems as $orderitemids) {
if(in_array($orderitemids,$withouthead)){
                                $item = new WC_Order_Item_Product($orderitemids);
                                newCase($item, $moms_array, $notIncludeProduct, $show_price, $custom_adjust_price_array);
								}
                            }
                        } else {

                            foreach ($order->get_items() as $key => $lineItem) :

                                if (!wc_get_order_item_meta($key, "HEAD_ITEM")) {

                                    $item = new WC_Order_Item_Product($key);
                                    newCase($item, $moms_array, $notIncludeProduct, $show_price, $custom_adjust_price_array);
                                } endforeach;
                        }
                        ?>
                    </tbody>
                </table>
                <div class="col-lg-12 col-md-12">
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
                            <div class="showboxes">
                                <ul><li><?php echo __("Summa: "); ?></li>
                                    <li > <?php
                                        $rotprice = (0 - $rot_avdrag);
                                        ;
                                        $sum = $display_price - (0 - $rot_avdrag);
                                        echo wc_price($sum);
                                        ?>
                                    </li></ul>
                            </div>
                            <div class="showboxes">
                                <ul><li><?php echo __("Avgår ROT-avdrag: "); ?></li>
                                    <li > 
                            <?php echo wc_price(0 - $rot_avdrag); ?>
                                    </li></ul>
                            </div>
            <?php endif; ?>
                        <div class="showboxes">
                            <ul><li ><?php echo __("Summa att betala: "); ?></li>
                                <li class="bigsize"> 
            <?php echo wc_price($display_price); ?>
                                </li></ul>
                        </div>
                        <div class="showboxes">
                            <ul><li><?php echo __("Moms ingår med: "); ?></li><li><?php
                            echo wc_price($order->get_total_tax());
                            ?> </li></ul>
                        </div>
                        <div class="showboxes">
                            <ul><li><?php echo __("Summa ex moms: "); ?></li>
                                <li class="showboxprice">  <?php echo wc_price($order->get_total() - $order->get_total_tax()); ?></li></ul> 
                        </div>
                <?php endif; ?>
                </div>
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
                <?php
            }
            $payment_type = get_post_meta($_GET['order-id'], 'order_status_betainingstyp1')[0];
            $paymenttypeSearch = paytemMethod();
            ?>
            <p>
                <strong>Betalningstyp: </strong>  </p>

            <p> <?php echo $paymenttypeSearch[$payment_type]; ?>

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


    <?php } ?>
        </div>

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
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 ">
    <?php if (!$order_accept_status || $order_accept_status == 'Kundfråga') : ?>

                        <div class="newitem">                        
                            <button type="button" id="accept_order_btn1"  class="accept-panel text-center summary-lg"  style="color:#000000; margin:0; width: 100%;">
        <?php echo __("Godkänn vårt affärsförslag") ?>
                            </button>
                            <button type="submit" style="display:none;color:#000000; margin:0; width: 100%;"
                                    id="accept_order_btn"  class="accept-panel text-center summary-lg"  disabled>
        <?php echo __("Godkänn vårt affärsförslag") ?>

                            </button>
                        </div>


                        <div class="customer-qustn">
                            <span style="float: right; width: 48.5%; font-weight: bold; margin: 1px;" class="col-container1">
                                <a class="text-lg"
                                   href="<?php echo $_SERVER['REQUEST_URI'] . "&accept=declined" ?>"><?php echo __("Neka affärsförslaget"); ?></a>

                            </span>
                            <span style="float: left; width: 48.5%; font-weight: bold; margin: 1px;" class="col-container2">
                                <a class="text-lg" href="<?php echo $_SERVER['REQUEST_URI'] . "&accept=Kundfråga" ?>"><?php echo __("Frågor? Klicka här"); ?></a>
                            </span>

                        </div>

    <?php endif; ?>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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
                     <!--   <span class="price-pan-content"
                              style="color:#000000;font-size: 17px !important;font-weight: normal !important;display: block;margin: 5px 0 0 0;" ><?php //echo __("Avgår ROT-avdrag: ") . $varrotavdrag; ?></span>-->
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
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?php echo get_avatar($salesman->user_email, 400); ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

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
<?php
/**
 * Container for the project summary part of the steps in project creation.
 */
 $remove_vats_number = get_post_meta($_GET['order-id'],'remove_vats_number',true);
$remove_vats = get_post_meta($_GET['order-id'],'remove_vats',true);

?>
<div class="row">
  
		<div class="col-lg-3">
            <label for="vat_number"><strong><?php echo __("VAT nummer vid omvänd byggmoms"); ?></strong></label>
 <input id="vat_number"  type="text" value="<?=$remove_vats_number?>" name="vat_number" placeholder="<?php if(empty($remove_vats_number) && !empty($remove_vats )){	  ?>
Kom ihåg att fylla i VAT nr<?php }?>"/>
		   
        </div>
		
		  <div class="col-lg-3">
          	  <div class="newvatadd"> <input type="checkbox" id="vatremove" <?php if($remove_vats){ echo 'checked'; } ?>  value="<?php echo $_GET['order-id']; ?>" name="checked_vat" /><label for="checked_vat"><strong><?php echo __("Omvänd byggmoms"); ?></strong></label></div>
        </div>
</div>
<input type="hidden" id="order_id" name="order_id" value="<?php echo $_GET["order-id"]; ?>">
<div class="row" style="margin-top: 30px;">
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
		$betal_key = array($val_1 , $val_2, $val_3, $val_4, $val_5 , $val_6 , $val_7 , $val_8 );
		$projecttypes  = get_field('order_project_type', $_GET['order-id']);
		$newvaue = get_option( 'for_pi_'.$projecttypes); 
        $beta = array('Kortbetalning', 'Delbetalas med kort i kassan', 'Swish', 'Faktura', 'Förskottsfaktura på 35% av beloppet skickas efter godkänt affärsförslag. Resterande belopp faktureras efter slutförd leverans. Betalningsvillkor på fakturorna framgår nedan', 'Ecster privatlån','Betalas vid hämtning');
		if(empty($newvaue['paytype'])){
			$brrrr = $betal_key;
		}
		else{
		$brrrr = array_intersect_key($newvaue['paytype'],$betal_key); 
		}
		if(empty($betal_methord)){
		$ostandard =	$newvaue['standard'];
		} else{
			$ostandard = $betal_methord;
		}
		
        $beta_match = get_post_meta($_GET['order-id'],'order_status_betainingstyp1', true);
	
	$datnewvaue = get_option( 'day_for_pi_'.$projecttypes); 

	if(empty($datnewvaue['days_paytype'])){ 
	$days_paytype = $beta;
	}else{
	$days_paytype = array_intersect($datnewvaue['days_paytype'],$beta);
	}
			if(empty($beta_match)){
		$bstandard =	$datnewvaue['days_standard'];
		} else{
			$bstandard = $beta_match;
		}
        ?>
     <div class="col-lg-3">


            <label for="payment_type"><strong><?php echo __("Välj betalningsvillkor"); ?></strong></label>

            <select id="payment_type" name="payment_type" class="form-control js-sortable-select">
                <?php foreach ($brrrr as $getKey ) { ?>
                    <option value="<?php echo $getKey; ?>" <?php if($ostandard == trim($getKey)){ echo "selected"; }  ?>><?php echo $betal_array[$getKey]; ?></option>
                <?php } ?>
            </select>


        </div>
    
    <?php 
    
     
  
$paymenttypeSearch = paytemMethod();
?>
        <div class="col-lg-3">
            <label for="payment_type"><strong><?php echo __("Betalningstyp"); ?></strong></label>

            <select id="order_status_betainingstyp" name="order_status_betainingstyp" class="form-control js-sortable-select <?=$bstandard?>">
                <?php  foreach ($paymenttypeSearch as $key=>$vali) { ?>
                    <option value="<?php echo $key; ?>" <?php if($key == $bstandard){ echo "selected"; } ?>><?php echo $vali; ?></option>
                <?php } ?>



            </select>
        </div>
    </div>

<div class="col-md-7 col-sm-7">
    <h3><?php echo __('Projektinformation'); ?></h3>


    <?php include('project-summary-part.php'); ?>

    <?php
    $option_name = 'users_key_' . $_GET["order-id"] . '';
    if (get_option($option_name)):
        ?>

        <div class="row top-buffer text-center affarsforslaget_pi">
            <div class="col-lg-4" style="display: inline-block">
                <ul class="list-unstyled list-spaced">
                    <li>
                        <img class="img-prev"
                             src="<?php echo site_url() ?>/wp-content/plugins/imm-sale-system/images/spec-med-pris.png"
                             alt="">
                    </li>
                    <li>
                        <strong>
                            <a class="btn btn-brand btn-sm" target="_blank"
                               href="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-w-price", $order->get_id()) ?>">
                                   <?php echo __("Affärsförslag - Spec med pris"); ?>
                            </a>
                        </strong>
                    </li>
                    <button type="button" data-order-id="<?php echo $order->get_id(); ?>"
                            data-url="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-w-price", $order->get_id()) ?>"

                            class="btn btn-xs btn-alpha"
                            id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
                            class="fa fa-angle-double-right"
                            aria-hidden="true"></i>
                    </button>
                    <li style="margin-top: 5px;">
                        <?php
                        $order_data = $order->get_data();
						$getCode = substr(trim($order_data['billing']['phone']), 0, 3);
                      $order_billing_phone = ($getCode == '+46')? $order_data['billing']['phone']:'+46'.$order_data['billing']['phone'];
						 // $order_billing_phone ='+46'.$order_data['billing']['phone'];
                        // $sms_message = get_field('sms_meddelande', 'option');
                        if (get_post_meta($order->get_id(), 'order_accept_status', true) === 'true') {
                            $sms_message = 'Hej! Orderbekräftelse från Mariebergs:';
                        } else {
                            $sms_message = 'Hej! Affärsförslag från Mariebergs:';
                        }
                        $order_link = site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-w-price", $order->get_id());
                        echo '<a  class="btn btn-brand btn-sm send_sms"  data_tel="' . $order_billing_phone . '" data_msg ="' . $sms_message . '" data_lank ="' . $order_link . '" >Skicka sms</a>'
                        ?>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4" style="display: inline-block <?=$getCode?>">
                <ul class="list-unstyled list-spaced">

                    <li>
                        <img class="img-prev"
                             src="<?php echo site_url() ?>/wp-content/plugins/imm-sale-system/images/spec-utan-pris.png"
                             alt="">
                    </li>
                    <li>
                        <strong>
                            <a class="btn btn-brand btn-sm" target="_blank"
                               href="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-wo-price", $order->get_id()) ?>">
                                   <?php echo __("Affärsförslag - Spec utan pris"); ?>
                            </a>
                        </strong>
                    </li>
                    <button type="button" data-order-id="<?php echo $order->get_id(); ?>"
                            data-url="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-wo-price", $order->get_id()) ?>"

                            class="btn btn-xs btn-alpha"
                            id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
                            class="fa fa-angle-double-right"
                            aria-hidden="true"></i>
                    </button>
                    <li style="margin-top: 5px;">
                        <?php
                      //  $order_data = $order->get_data();
                       // $order_billing_phone = '+46' . $order_data['billing']['phone'];
                        // $sms_message = get_field('sms_meddelande', 'option');
                        $order_link = site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-wo-price", $order->get_id());
                        echo '<a  class="btn btn-brand btn-sm send_sms"  data_tel="' . $order_billing_phone . '" data_msg ="' . $sms_message . '" data_lank ="' . $order_link . '" >Skicka sms</a>'
                        ?>
                    </li>


                </ul>
            </div>
            <div class="col-lg-4" style="display: inline-block">
                <ul class="list-unstyled list-spaced">

                    <li>
                        <img class="img-prev"
                             src="<?php echo site_url() ?>/wp-content/plugins/imm-sale-system/images/ospecat-med-pris.png"
                             alt="">
                    </li>
                    <li>
                        <strong>
                            <a class="btn btn-brand btn-sm" target="_blank"
                               href="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-compact", $order->get_id()) ?>">
                                   <?php echo __("Affärsförslag - Ospecat med pris"); ?>
                            </a>
                        </strong>
                    </li>
                    <button type="button" data-order-id="<?php echo $order->get_id(); ?>"
                            data-url="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-compact", $order->get_id()) ?>"

                            class="btn btn-xs btn-alpha"
                            id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
                            class="fa fa-angle-double-right"
                            aria-hidden="true"></i>
                    </button>
                    <li style="margin-top: 5px;">
                        <?php
                       // $order_data = $order->get_data();
                      //  $order_billing_phone = '+46' . $order_data['billing']['phone'];
                        // $sms_message = get_field('sms_meddelande', 'option');
                        $order_link = site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-compact", $order->get_id());
                        echo '<a  class="btn btn-brand btn-sm send_sms"  data_tel="' . $order_billing_phone . '" data_msg ="' . $sms_message . '" data_lank ="' . $order_link . '" >Skicka sms</a>'
                        ?>
                    </li>
                </ul>
            </div>


        </div>
        <div class="row text-center">

            <div class="col-lg-4">
                <ul class="list-unstyled list-spaced">
                    <li>
                        <img class="img-prev"
                             src="/wp-content/plugins/imm-sale-system/images/teknisk-sammanfattning.png"
                             alt="">
                    </li>
                    <li>
                        <a class="btn btn-brand btn-sm" target="_blank"
                           href="<?php echo site_url() . "/order-summary-technical?order-id=" . $order->get_id(); ?>"><?php echo __("Teknisk
                                        sammanfattning"); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <ul class="list-unstyled list-spaced">
                    <li>
                        <img class="img-prev"
                             src="/wp-content/plugins/imm-sale-system/images/ekonomisk-sammanfattning.png"
                             alt="">
                    </li>
                    <li>
                        <a class="btn btn-brand btn-sm" target="_blank"
                           href="<?php echo site_url() . "/order-summary-economy?order-id=" . $order->get_id(); ?>"><?php echo __("Ekonomisk
                                        sammanfattning"); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <ul class="list-unstyled list-spaced">
                    <li>
                        <img class="img-prev"
                             src="/wp-content/plugins/imm-sale-system/images/visa-bestallningsunderlag.png"
                             alt="">
                    </li>
                    <li>
                        <div class="print_order_icon btn btn-brand btn-sm" style="margin: auto;padding: 20px;"><?php echo __("Kassakvitto"); ?></div>
                        <input type="hidden" name="order_id" id="order_id" value="<?php echo $order->get_id();?>">
                    </li>
                    <button type="button" data-print='1' data-order-id="<?php echo $order->get_id(); ?>"
                            data-url="<?php echo site_url() . "/wp-content/plugins/imm-sale-system/includes/templates/kassakvitto_view.php?order-id=" . $order->get_id();?>"

                            class="btn btn-xs btn-alpha"
                            id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
                            class="fa fa-angle-double-right"
                            aria-hidden="true"></i>
                    </button>
                    <li style="margin-top: 5px;">
                        <?php
                        //$order_data = $order->get_data();
                      //  $order_billing_phone = '+46' . $order_data['billing']['phone'];
                        // $sms_message = get_field('sms_meddelande', 'option');
                        $order_link = site_url() . "/wp-content/plugins/imm-sale-system/includes/templates/kassakvitto_view.php?order-id=" . $order->get_id();
                        echo '<a  class="btn btn-brand btn-sm send_sms"  data_tel="' . $order_billing_phone . '" data_msg ="Här kommer ditt kassakvitto från Mariebergs" data_lank ="' . $order_link . '" >Skicka sms</a>'
                        ?>
                    </li>
                    
                </ul>
            </div>
        </div>

        <?php
    endif;
    ?>
    <div class="order_printable_area" style="display: none;margin:40px;">
        <div class="col-md-12">
            <img src="/wp-content/uploads/2018/07/Mariebergs-Logo-Svart-ny.png" alt="" class="center-block"
                 style="margin:auto;margin-bottom: 20px;max-width: 370px;height:auto; display:block;">
            <br>

        </div>

      
        <table class="table table-striped" style="margin-top: 25px;width: 100%;max-width: 100%;margin-bottom: 20px;">
            <div class="date"><strong>Datum: </strong> <span class="ajax_date"></span></span> </div>
                <div> <span style="float:right"><strong>Kassakvittonummer: </strong><span class="cash_recipt" style="float:right"></span> </span></div>
            <div><strong>Tid: </strong><span class="ajatime"></span> </div>


            <tr class="tbl_hdng" style="background-color: #f9f9f9;">
                <th style="text-align:left; float:left;">Produkt</th>
                <th style="text-align:right;">Pris</th>
            </tr>
       
               

    
            <tr>
                <td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Momssats: "); ?></strong>
                </td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;">25%
                </td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Summa ex moms: "); ?></strong>
                </td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;" class="minustotal_taxs">
                </td>
            </tr>
            <tr><td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Moms: "); ?></strong></td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;" class="total_taxs"></tr>
            <tr style="background-color: #f9f9f9;"><td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Totalsumma: "); ?></strong></td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;" class="rot"></td></tr>
        </table>

        <div class="col-md-12">
            <h4 style="margin-left: 265px;line-height:14px">Mariebergs Brasvärme AB</h4>


        </div>
        <div class="address" style="text-align: center;">
       
            <h4 style="margin:0;line-height:18px"><strong>Org. nr: </strong><span class="organisationajax"></span></h4>
            <span class="organ_content"></span><br>
        </div>
        <div class="footer_txt" style="text-align: center;">
            <h4 style="line-height:18px;font-size:15px"><strong>Tack För ditt köp!</strong></h4>
            <h4 style="line-height:18px;font-size:15px"><strong>Välkommen åter!</strong></h4>
        </div>
    </div>

    <!--    <div class='row' style="margin-bottom: 40px;margin-top: 40px;">
            <div class="col-lg-12">
                <label for=""><strong>Rabattera produkt</strong></label>
            </div>
    
    
            <div class="col-lg-4">
    
                <select name="imm_sale_product_descount" id="imm_sale_product_descount" class="js-sortable-select">
                    <option value="none" selected disabled>Välj produkt</option>
    <?php /*                foreach ($order->get_items() as $order_item_id => $item) {

      $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
      if ($product_id === 0) {
      $title = $item["name"];

      } else {
      $title = null;

      }


      echo return_product_information_for_list_pi($product_id, $item, $item->get_quantity(), $title);



      };

     */ ?>
                </select>
    
            </div>
            <div class="col-lg-4">
                <input type="number" id="imm_sale_product_descount_value" name="imm_sale_product_descount_value" placeholder="Ange procent rabatt">
            </div>
            <div class="col-lg-4">
                <input type="button" value="Bekräfta" class="btn-brand submit_discount">
            </div>
    
    
        </div>-->

    <div class="row">
        <div class="col-lg-12" style="margin-top:20px;margin-bottom: 20px;">
            <?php include('reservationer.php'); ?>
        </div>

        <div class="col-lg-12" style="margin-top: 20px;margin-bottom: 20px;">
            <?php include('garanti_method.php'); ?>
        </div>
        <div class="col-lg-12" style="margin-top: 20px;margin-bottom: 20px;">
            <?php include('project_summary_files_upload.php'); ?>
        </div>


        <div class="col-lg-12">
            <label for="imm-sale-tax-deduction"><strong>Maximalt ROT-avdrag</strong></label>
            <i>Fyll i det ROT avdrag kund uppger för att beräkna pris i affärsförslag</i>
      <?php
           echo $tax_deduction = get_field("imm-sale-tax-deduction", $order->ID);
			
		
           
         if (empty($tax_deduction) || $tax_deduction === 0) {
                $storedata = 50000;
            } else {
                $storedata = $tax_deduction;
            }
			
$money = explode(',',number_format($storedata, 2, ',', ' '));
		echo "<p class='myprice' >".$money[0].'</p>';
?>
            <input  value="<?php echo $storedata; ?>" type="hidden" name="imm-sale-tax-deduction" class="form-control" id="imm-sale-tax-deduction" >
        </div>
		    <div class="col-lg-12" id="household_vat">
<label class="top-buffer-half" for=""><strong><?php echo __('ROT personer'); ?></strong></label>
        <?php
			  $count = 0;
    $order_id = $_GET["order-id"];
    $customer_id = $order->get_customer_id();
    $user_info = get_userdata($customer_id);
    $customer_personnummer = get_user_meta($customer_id, 'customer_individual_organisation_number', true);
    $customer_namn = getCustomerName($customer_id);
    $household_vat_discount_json2 = get_post_meta($_GET["order-id"], "household_vat_discount_json")[0];
    $household_vat_discount2 = return_array_from_json($household_vat_discount_json2);
        /* $household_vat_discount_json = get_post_meta($_GET["order-id"], "household_vat_discount_json")[0];

        $household_vat_discount = return_array_from_json($household_vat_discount_json2);
 */
        $k = 1;

/* if(get_current_user_id() == '328'){
	print_r($household_vat_discount2); 
} */
        foreach ($household_vat_discount2 as $key => $item):
           // if ($item["customer_household_vat_discount_name"] !== $customer_namn) {
				
                ?>
                <div class="dis_row ">
                    <div class="col-lg-6 top-buffer-half"><label
                            class='top-buffer-half'><?php echo __('Namn'); ?></label>
                        <input type="text"
                               value="<?php echo $item["customer_household_vat_discount_name"] ?>"
                               class="form-control"
                               name="customer_household_vat_discount_name[<?php echo $k; ?>]"
                               id="customer_household_vat_discount_name[<?php echo $k; ?>]">
                    </div>
                    <div class="col-lg-3 top-buffer-half">
                        <label
                            class='top-buffer-half'><?php echo __('Personnummer'); ?></label>
                        <input

                            type="text"
                            value="<?php echo $item["customer_household_vat_discount_id_number"] ?>"
                            class="form-control"
                            name="customer_household_vat_discount_id_number[<?php echo $k; ?>]"
                            id="customer_household_vat_discount_id_number[<?php echo $k; ?>]">
                    </div>

                    <div class="col-lg-3 top-buffer-half">


                        <label
                            class='top-buffer-half'><?php echo __('Fastighetsbeteckning'); ?></label>
                        <input type="text"
                               value="<?php echo $item["customer_household_vat_discount_real_estate_name"] ?>"
                               class="form-control"
                               name="customer_household_vat_discount_real_estate_name[<?php echo $k; ?>]"
                               id="customer_household_vat_discount_real_estate_name[<?php echo $k; ?>]">

                    </div>
                    <div class="col-lg-6 top-buffer-half">


                        <label
                            class='top-buffer-half'><?php echo __('BRF org nummer'); ?></label>
                        <input type="text"
                               value="<?php echo $item["customer_household_org_number"] ?>"
                               class="form-control"
                               name="customer_household_org_number[<?php echo $k; ?>]"
                               id="customer_household_org_number[<?php echo $k; ?>]">

                    </div>

                    <div class="col-lg-6 top-buffer-half">


                        <label
                            class='top-buffer-half'><?php echo __('Lägenhetsnummer'); ?></label>
                        <input type="text"
                               value="<?php echo $item["customer_household_lagenhets_number"] ?>"
                               class="form-control"
                               name="customer_household_lagenhets_number[<?php echo $k; ?>]"
                               id="customer_household_lagenhets_number[<?php echo $k; ?>]">
                        <a
                            href="#"
                            class="text-right btn btn-beta top-buffer-half"
                            id="remove-line">Ta bort</a>
                    </div>

                </div>
                <?php
                $k++;
           // }
        endforeach;

     if($k == 1){   ?>
	 <div class="dis_row"><div class="col-lg-6"><label class="top-buffer-half">Namn</label><input type="text" value="" class="form-control" name="customer_household_vat_discount_name[1]" id="customer_household_vat_discount_name[1]"></div><div class="col-lg-3"><label class="top-buffer-half">Personnummer</label><input type="text" value="" class="form-control" name="customer_household_vat_discount_id_number[1]" id="customer_household_vat_discount_id_number[1]"></div><div class="col-lg-3"><label class="top-buffer-half">Fastighetsbeteckning</label><input type="text" value="" class="form-control" name="customer_household_vat_discount_real_estate_name[1]" id="customer_household_vat_discount_real_estate_name[1]"></div><div class="col-lg-6"><label class="top-buffer-half">BRF org nummer</label><input type="text" value="" class="form-control" name="customer_household_org_number[1]" id="customer_household_org_number[1]"></div><div class="col-lg-6"><label class="top-buffer-half">Lägenhetsnummer</label><input type="text" value="" class="form-control" name="customer_household_lagenhets_number[1]" id="customer_household_lagenhets_number[1]"><a href="#" class="text-right btn btn-beta top-buffer-half" id="remove-line">Ta bort</a></div></div> <?php } ?>
    </div>
       <a style="margin-top:15px" class="col-lg-6 col-md-6 col-sm-3  btn btn-alpha " href="#" id="add-line"><?php echo __("Lägg till ROT-personer"); ?></a>
    </div>
    <hr>
    <?php

	
    foreach ($household_vat_discount2 as $item) {
        if ($item["customer_household_vat_discount_name"] === $customer_namn) {
            $fastiganteckning = $item["customer_household_vat_discount_real_estate_name"];
            $brgorNummber = $item["customer_household_org_number"];
            $lagenhetsNummer = $item["customer_household_lagenhets_number"];
        }
    }
    ?>
   

</div>
<input type="hidden" id="orderidSort" value="<?php echo $_GET['order-id']; ?>" /> 
    <?php
    $firstSort = get_post_meta($_GET['order-id'],'firstSort', true);
	if($firstSort){ ?>
	    <script>
            jQuery(document).ready(function () {
				var orderId = jQuery('#orderidSort').val();
			
				    function newupdatesortOrder(data, orderid, head = false) {

        jQuery.ajax({
        url: '/wp-content/plugins/imm-sale-system/ajax/sortorderitems.php',
                type: 'POST',
                data: {position: data, orderid: orderid, head, head},
                success: function (result) {
                }
        })
        }
				 var headData = new Array();
              jQuery('ul#product-list_head .sortingorder').each(function () {
                headData.push(jQuery(this).attr("data-attribute-line-item-ids"));
				
                });
				var sortData = new Array();
				jQuery('ul#product-list .sortingorder').each(function () {
                sortData.push(jQuery(this).attr("data-attribute-line-item-ids"));
                });
				
                        newupdatesortOrder(headData, orderId,'head');
						newupdatesortOrder(sortData, orderId);
      
            });
        </script>
	<?php }
	update_post_meta($_GET['order-id'], 'firstSort',''); ?>
   

<div class='col-md-5 col-sm-5'>
    <?php
    $order_json_data = get_post_meta($order->ID, 'orderdata_json');
    $json_data_as_array = json_decode($order_json_data[0], JSON_PRETTY_PRINT);
	  if(!empty($remove_vats)){	 
	removeVat($_GET['order-id'],1);
	$order = new WC_Order($_GET['order-id']);
	} 


    get_order_information_list($order, $json_data_as_array);
 $gethousehold = get_post_meta($order->ID, 'household_vat_discount_json', true);

    $counthouse = json_decode($gethousehold, true);
    $count = 0;
    foreach ($counthouse as $key => $value) {
	
        if (!empty($value)) {

            $count++;
        }
    }  



    //$tax_deduction = get_post_meta($order->ID, "imm-sale-tax-deduction", true);
    $conf_deduction = get_post_meta($order->ID, "confirmed_rot_percentage", true);

    if (empty($tax_deduction) || $tax_deduction == 0 || $count == 0) {
		//echo $count."---".$tax-deduction;
        delete_post_meta($order->ID, "confirmed_rot_percentage", $conf_deduction);
        ?>
        <script>
            jQuery(document).ready(function () {
          //      jQuery('a#product-list-12870').trigger('click');
            });
        </script>

        <?php
    }
    ?>
  <script>
            jQuery(document).ready(function () {
				jQuery('p.myprice').click(function(){
                jQuery(this).hide();
				jQuery('input#imm-sale-tax-deduction').attr('type','number');
				  });
            });
        </script>
</div>
<?php     $projectid = get_post_meta($_GET['order-id'], 'imm-sale_project_connection', true);
    $customer_id = get_post_meta($projectid, 'invoice_customer_id', true);
    $salemanid = get_post_meta($projectid, 'order_salesman', true);
	
	?>
		<div id="custom_mypop">
	<input type="hidden" value="<?=$_GET['order-id']?>" id="order_id" />
	<input type="hidden" value="<?=$_GET['order-id']?>" id="quickorder" />
	
<input type="hidden" value="<?=$customer_id?>" id="useridPI" />
<input type="hidden" value="<?=$salemanid ?>" id="salesmanidPI"  />
</div>
<?php include( "dashboard/estimate_editable.php" );
include( "dashboard/sms_editable.php" );
 ?>
<?php
$projectValues = get_post_meta($project_id);

$userid = $projectValues['invoice_customer_id'][0];
$getCode = substr(trim($customer_phone), 0, 3);
$order_billing_phone = ($getCode == '+46')? $customer_phone:'+46'.$customer_phone;
$nameofcustomer = get_user_meta($userid, 'fullname')[0];
$args = [
'post_type' => 'imm-sale-office',
'posts_per_page' => -1,
];
$offices = new WP_Query($args);
$currntRole  = get_user_role();
?>

 <div id="custom_mypop" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
<form method="post" enctype="multipart/form-data">		
			<div class="modal-loader"></div> 
			<input type="hidden" name="quick-order-handle" value="true">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title"><?php echo __( "Verktyg" ); ?></h4>
			</div>
			<div class="modal-body setting-modal-body">
			<div class="container-fluid">
		
			<input type="hidden" value="<?=$userid?>" id="useridPI" />
			<input type="hidden" value="<?=$order_billing_phone?>" id="userPhone" />
			<input type="hidden" value="<?=$projectValues['order_salesman'][0]?>" id="salesmanidPI"  />
			<input type="hidden" id="quickorder" name="quick-order-id" value="">
			<input type="hidden" id="currentuser_role" value=<?=$currntRole?> />
			<input type="hidden" name="imm-sale-order-department" value="<?=$projectValues['order_current_department'][0]?>">
			<meta charset="UTF-8"> 
			<h2><?=$projectValues['invoice_customer_id'][0]."-".$project_id."-"?><span id="orderidadd"></span></h2>
			<?php 
			if($currntRole == 'sale-sub-contractor'){
			?>
	           <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced" style="text-align:center">
								<li>
								<img class="img-prev"
								src="wp-content/plugins/imm-sale-system/images/teknisk-sammanfattning.png" alt="">
								</li>
								<li>
								<a id="techincal_summary" class="btn btn-brand btn-sm" target="_blank"
								href=""><?php echo __("Teknisk
								sammanfattning"); ?>
								</a>
								</li>
                            </ul>
                        </div>
						<?php } else { ?>
			<input type="hidden" id="orderformat" value="" />
			<div id="editnote" class="alert alert-danger" style="display:none" role="alert"> 
  Ordern redigeras av frontaccess.Försök igen om ett par minuter eller <a href="#" class="edit_by" data_orderID="" data_current_user="<?=$userid?>">redigera nu</a>
</div>

			<div class="row">
				<div class="col-md-12">
					<ul class="list-inline">
				        <li class="redigera_offert_verktyg">
                          <a href="#" class="btn btn-alpha btn-block"><?php echo __("Redigera") ?></a>
						</li>
						<li>
                        <a id="duplicateurl" href="<?php echo site_url() ?>?duplicate=true&project_id="
                         class="btn btn-alpha btn-block top-buffer-half"><?php echo __("Duplicera") . " " . strtolower($invoice_or_order); ?></a>
						</li>
                    <li>
                        <a href="#" class="btn btn-alpha btn-block top-buffer-half"
                           id="valj_duplicated_project"><?php echo __("Duplicera till ny kund"); ?></a>
                    </li>

                    <?php // endif;      ?>

                    <li>
                        <button type="submit" onclick="closeModalAndSendForm();"
                                class="btn btn-brand btn-block top-buffer-half">
                                    <?php echo __("Spara och uppdatera") . " " . strtolower($invoice_or_order); ?>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
		 <div class="row">
            <div class="col-md-12" id="valt_duplicated_project" style="display: none;">
                <input type="hidden" id="project_id_inoffert">
                <input type="hidden" id="order_id_inoffert" value="<?php echo $order->ID; ?>">
                <label class="top-buffer-half"
                       for=""><?php echo __("Välj kund"); ?> </label>
                       <?php $allcustomers = get_users('orderby=nicename');    ?>

                <select class="form-control js-sortable-select" name="duplicate_offert_inside_project_new_customer"
                        id="duplicate_offert_inside_project_new_customer">
                            <?php
								foreach ($allcustomers as $customer) {
								$data=get_user_meta($customer->ID); //print_r($customer);

								if($customer->user_email)
								$emails = $customer->user_email;
								else
								$emails = $data->billing_email[0];

								echo "<option value='" . $customer->ID . "' data_customerId=" . $customer->ID . ">" . $customer->ID.', '.showName($customer->ID) . ', '.$emails. ' '.$data->billing_address_1[0]. " " . $data->billing_address_2[0]. "</option>";

								}
                            wp_reset_query();
                            ?>
                </select>

                <a id='duplicate_offert_href' href=""
                   class="btn btn-alpha btn-block top-buffer-half"><?php echo __("Duplicera offert till ny kund") ?></a>

            </div>
            <div class="col-md-12">

                     <hr>
          

                <div class="row">

                    <div class="col-md-12">
                        <div class="col-md-4">
					
						<select id="order-customer-status" class='form-control js-sortable-select' name="order-customer-status">
						<option value="" >Väntar svar</option>
						<option value="true" >Order bekräftad</option>
						<option value="false" >Nekad av kund</option>
						<option value="Kundfråga" >Kund har frågor</option>
						<option value="archieved" >Arkiverad kopia</option>
						<option value="Acceptavkund" >Accepterad av kund</option>
						</select>

                        </div>
				<div class="col-md-4">
                                    <input type="checkbox" name="notemail" value="1" <?php
                                               if (in_array($order_accept_status, array("Kundfråga", "false", "true", "Acceptavkund"))) {
                                                   echo "checked";
                                } ?> />	Skicka inte orderbekräftelse </div>
								<div class="col-md-4">	
				<select name="order-by-this-project-status" class="js-sortable-select form-control" id="order-by-this-project-status" data-select2-id="order-by-this-project-status" tabindex="0" aria-hidden="false">
				<option value="project-ongoing" >Pågående</option>
				<option value="project-archived" >Avslutat</option>
				</select>
						</div>
						
                <div class="form-group">
                    <div class="row text-center appendlist">
                        <div class="col-lg-4">
							<ul class="list-unstyled list-spaced ">
							<li>
							<img class="img-prev"
							src="wp-content/plugins/imm-sale-system/images/spec-med-pris.png"
							alt="">
							</li>
							<li>
							<strong>
							<a class="btn btn-brand btn-sm add1_url" target="_blank"
							href="">
							<?php echo __("Affärsförslag - Spec med pris"); ?>
							</a>
							</strong>
							</li>
							<li>
							<button type="button"
							data-url=""
							class="btn btn-xs btn-alpha add_orderid first_url"
							id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
							class="fa fa-angle-double-right"
							aria-hidden="true"></i>
							</button>
							</li>
							<li>
							<button  class="btn btn-brand btn-sm send_sms first_url"  data_msg ="" data-url ="" >Skicka sms</button>

							</li>

                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced ">
								<li>
								<img class="img-prev"
								src="wp-content/plugins/imm-sale-system/images/spec-utan-pris.png" alt="">
								</li>
								<li>
								<strong>
								<a class="btn btn-brand btn-sm add2_url" target="_blank" href="">
								<?php echo __("Affärsförslag - Spec utan pris"); ?>
								</a>
								</strong>
								</li>
								<li>
								<button type="button" data-url="" class="btn btn-xs btn-alpha add_orderid second_url"
								id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
								class="fa fa-angle-double-right" aria-hidden="true"></i>
								</button>
								</li>
								<li>
								<button  class="btn btn-brand btn-sm send_sms second_url"  data_msg ="" data-url ="" >Skicka sms</button> 
								</li>

                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced ">
								<li>
								<img class="img-prev" src="wp-content/plugins/imm-sale-system/images/ospecat-med-pris.png" alt="">
								</li>
								<li>
								<strong>
								<a class="btn btn-brand btn-sm add3_url" target="_blank" href="">
								<?php echo __("Affärsförslag - Ospecat med pris"); ?>
								</a>
								</strong>
								</li>
								<li>
								<button type="button"  data-url="" class="third_url btn btn-xs btn-alpha add_orderid"
								id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i class="fa fa-angle-double-right"
								aria-hidden="true"></i>
								</button>
								</li>
								<li>
								<button  class="btn btn-brand btn-sm send_sms third_url"  data_msg ="" data-url ="" >Skicka sms</button>
								</li>

                            </ul>
                        </div>
                    </div>
                    <hr>

                    <div class="row text-center">

                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">
								<li>
								<img class="img-prev"
								src="wp-content/plugins/imm-sale-system/images/teknisk-sammanfattning.png" alt="">
								</li>
								<li>
								<a id="techincal_summary" class="btn btn-brand btn-sm" target="_blank"
								href=""><?php echo __("Teknisk
								sammanfattning"); ?>
								</a>
								</li>
                            </ul>
                        </div>
              
                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">
                                <li>
                                    <img class="img-prev"
                                         src="wp-content/plugins/imm-sale-system/images/ekonomisk-sammanfattning.png"
                                         alt="">
                                </li>
                                <li>
                                    <a id="econmical_summary" class="btn btn-brand btn-sm" target="_blank"
                                       href=""><?php echo __("Ekonomisk
                                        sammanfattning"); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">
                                <li>
                                    <img class="img-prev"
                                         src="wp-content/plugins/imm-sale-system/images/visa-bestallningsunderlag.png"
                                         alt="">
                                </li>
                                <li>
                                    <a class="btn btn-brand btn-sm" href="#"
                                       id="toggle-order_documents"><?php echo __("Visa beställningsunderlag"); ?></a>
									   <p id="getanother" style="display:none">click here</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>

                    <div class="row text-center">

                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">
                                <li>
                                    <img class="img-prev"
                                         src="/wp-content/plugins/imm-sale-system/images/visa-bestallningsunderlag.png"
                                         alt="">
                                </li>
                                <li>
                                    <div class="print_order_icon btn btn-brand btn-sm" style="margin: auto;padding: 20px;"><?php echo __("Kassakvitto"); ?></div>
                                    
                                </li>
                                <button type="button" data-print='1' 
                                        data-url=""
                                        class="btn btn-xs btn-alpha data_print add_orderid fouth_url"
                                        id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
                                        class="fa fa-angle-double-right"
                                        aria-hidden="true"></i>
                                </button>
                                <li style="margin-top: 5px;">
                                    <a class="btn btn-brand btn-sm send_sms fouth_url"  data_msg="Här kommer ditt kassakvitto från Mariebergs" data_lank="">Skicka sms</a>                                </li>
                            </ul>
                        </div>
                    </div>
            
                </div>	
                    </div>

                </div>
				</div>
</div>	
<div id="laode">
<div class="loading_overlay" style="background-color: rgba(255, 255, 255, 0.8); display: block; z-index: 9999;background-image: url(&quot;/wp-content/plugins/imm-sale-system/js/loading.gif&quot;);background-position: center center;background-repeat: no-repeat;top: 0px;left: 0px;width: 100%;height: 28%;background-size: 100px;"></div><span>Laddar...</span>
</div>
<div class="top-buffer-half" id="order_documents" style="display: none">
	<div class="form-group">
				<h4 style="font-weight: bold;"><?php echo __("Skorstensinfo"); ?></h4>
				<ul class="list-inline headingshows"></ul>
				<strong><?php echo __("Genererat beställningsunderlag för leverantör"); ?></strong>
				<div class="top-buffer-half" id="generated_order_notes"></div>
				<div class="col-lg-12" style="padding-left:0"	>
				<div class="col-lg-4" style="padding-left:0">
				<h3>Leverans till:</h3>
				<select name='customer_address' class='js-sortable-select form-control' id='customer_address'>
				<option value="">Välj leveransadress</option>
				<option value="<?= "ram-".$userid ?>" ><?=$nameofcustomer?></option>
				<?php    while ($offices->have_posts()) {
				$offices->the_post(); ?> 
				<option value="<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></option>
				<?php  }  wp_reset_query();  ?>
				</select>
				</div>

				</div>
				<div class="another_items">
				
				</div>
					</div>	
						<?php } ?>
</div>				
                </div>
                <div class="modal-footer">
					<?php bloginfo(); ?>
                </div>
        
        </div>
		</form>
    </div>
</div> 
      
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
   <script>

jQuery(document).on('click','.custom_mypop', function (e) {
	e.preventDefault();
	 var order_id = jQuery(this).attr('href');
	 		var project_status = jQuery(this).attr('data-pstatus');
			var accept = jQuery(this).attr('data-accept');
		jQuery.ajax({
		url: '/wp-content/plugins/imm-sale-system/ajax/single_project_popup.php',
		type: 'POST',
		data: {
		order_id: order_id,
		accept:accept,
		currentuser_role:jQuery("#custom_mypop #currentuser_role").val()
		},
		beforeSend: function () {
		
			jQuery('#duplicateurl').attr('href','?duplicate=true&project_id='+order_id);
			jQuery('#techincal_summary').attr('href','/order-summary-technical?order-id='+order_id);
			jQuery('#econmical_summary').attr('href','/order-summary-economy?order-id='+order_id);
			jQuery('.data_print,.data_print .send_sms').attr('data-url',"https://speed.mariebergsalset.com/wp-content/plugins/imm-sale-system/includes/templates/kassakvitto_view.php?order-id="+order_id);
			jQuery('#editnote').hide();
			jQuery('#orderidadd').html(order_id);
			jQuery('#quickorder').val(order_id);
			jQuery('.redigera_offert_verktyg').show();
			if(accept == 'true'){
			var sms_message = 'Hej! Orderbekräftelse från Mariebergs:';
			} 
			else {
			var sms_message = 'Hej! Affärsförslag från Mariebergs:';
			}
			jQuery('.send_sms').attr('data_msg',sms_message);
			
			jQuery('#custom_mypop #order-customer-status').val(accept).trigger('change');
			jQuery('#custom_mypop #order-by-this-project-status').val(project_status).trigger('change');
			jQuery('#editnote').hide();

	  },
		success: function (results) {
	jQuery("#custom_mypop").modal('show');
			var data = jQuery.parseJSON(results);			
			jQuery.each(jQuery(data), function (i, ob) {
			if(ob['emptyEdit'] != '1'){
			jQuery('.redigera_offert_verktyg').hide();
			}
			if(ob['edit_content'] == '1'){
			jQuery('#editnote').show();
			}
			if(ob['disabled'] === 1){
				jQuery('#custom_mypop #order-customer-status').attr('disabled','disabled');
			}else{
					jQuery('#custom_mypop #order-customer-status').removeAttr('disabled');
			}
			
			jQuery('.first_url').attr('data-url',ob['first_url']);
			jQuery('.add1_url').attr('href',ob['first_url']);
			jQuery('.second_url').attr('data-url',ob['second_url']);
			jQuery('.add2_url').attr('href',ob['second_url']);
			jQuery('.third_url').attr('data-url',ob['third_url']);
			jQuery('.add3_url').attr('href',ob['third_url']);
			});
			jQuery('#toggle-order_documents').attr('href',order_id);
			jQuery('#getanother').trigger('click');
		}
	});
});
jQuery(document).on('click','#getanother', function (e) {
	e.preventDefault();
	 var order_id = jQuery('#toggle-order_documents').attr('href');
	 jQuery('.another_items,ul.headingshows').empty();
		jQuery.ajax({
		url: '/wp-content/plugins/imm-sale-system/ajax/single_order/second_project_popup.php',
		type: 'POST',
		data: {
		order_id: order_id
		},
		beforeSend: function () {
		 jQuery("#laode").show();

		},
	                                  
		success: function (results) {
		jQuery("#laode").hide();
			var data = jQuery.parseJSON(results);
		//	console.log(data);
			jQuery.each(jQuery(data), function (i, ob){
				jQuery.each(jQuery(ob['filterdata']), function (i, filters){
				jQuery('ul.headingshows').append('<li><strong>'+filters['label']+':</strong>'+filters['value']+'</li>');
				});
			 	jQuery.each(jQuery(ob['brand_items']), function (i, items){
					//console.log(items['brand_name']);
					var r_name = items['r_name'].split('-ram')[0];
					var myHtml = "";
				jQuery.each(jQuery(items['allstored']), function (r, rum){
myHtml += '<tr id="'+rum['orderitem']+'" class="line_item_row" ><td><a href="#" data-toggle-id="checkbox_row_'+rum['orderitem']+'" id="" class="toggles"><i class="fa fa-angle-double-down" aria-hidden="true"></i>Visa</a></td><td id="qty_'+rum['product_id']+'" class="qty">'+rum['item_quantity']+'</td><td id="sku_'+rum['product_id']+'" class="sku">'+rum['product_sku']+'</td><td id="name_'+rum['product_id']+'" class="name">'+rum['product_name']+'</td><td><input class="Noteringval_'+rum['product_id']+'" id="Noteringval" type="text" name="line_item_note['+rum['orderitem']+']"value="'+rum['line_item_note']+'"></td></tr>';
				});
				jQuery('.another_items').append('<h3 class="">'+items['brand_name']+'</h3><a data-brands="'+r_name+'" data-id="'+items['termid']+'" class="generate_external_order_notes" href="#">Generera underlag för beställning</a><h4 class="">Kundnummer:'+items['office_customer_number']+'</h4><table class="table" id="'+r_name+'" data-brand="'+r_name+'"><thead><tr><th>Checkboxar</th><th>Antal</th><th>Art.nr</th><th>Produktnamn</th><th>Notering</th>     </tr></thead><tbody class="tbody">'+myHtml+'</tbody></table>');
				}); 
				
			});
		}
	});
});
</script>

<?php
/**
 * Template used to display a customer register.
 * URL PATH: $_SERVER['REQUEST_URI'], '/customer-register'
 */
include_once( plugin_dir_path(__FILE__) . 'head.php' );



?>

<div class="container-db top-buffer-half">

    <div class="col-lg-12">
     <div class="col-md-4">   <a href="<?php echo get_site_url(); ?>/customer-edit" type="button"
           class="btn btn-alpha btn-block"><i class="fa fa-address-book" aria-hidden="true"></i>
<?php echo __("Skapa ny kund"); ?> </a>
    </div>
	 </div>

 <div class="col-lg-12" style= "margin: 16px 1px;">
     <div class="col-md-4">
	<label class="	" for="col8_filter">Sök</label>
	<input type="text" id="customersearch" />
	</div>
	<div class="col-md-4">   

            <label for="imm-sale-order-date_from" class="top-buffer-half"> Från</label>
            <input type="date" class="column_filter cstm_date_picker imm-sale-order-date_from "  placeholder="yyyy-mm-dd" >
    </div>
	<div class="col-md-4">
            <label for="imm-sale-order-date_to" class="top-buffer-half"> Till</label>
            <input type="date" class="column_filter cstm_date_picker imm-sale-order-date_to "  placeholder="yyyy-mm-dd" >
        </div>



    <div class="col-md-3">
	<label class="	" for="col8_filter">Säljare</label>
       	<?php
get_my_or_all_dropdown("col8_filter", '', '', '', "top-buffer-half column_filter");
?>
    </div>
	<div class="col-md-3">
<?=get_status_orderValue('customerRegister_filter column_filter')?>
</div>


            <div class="col-lg-3 col-md-3 col-sm-3">
                <label class="top-buffer-half" for="project_type"><?php echo __("Typ av projekt") ?></label>

                <select id="project_type" name="project_type" class="form-control js-sortable-select column_filter" data-table_name="all-table">
                    <option value='alla'><?php echo __("Alla"); ?></option>
                    <?php
                    $current_user_role = get_user_role();

                    $project_roles_steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);
                    $projectype_search = array(1 => "Hembesök", 2 => "Eldstad inklusive montage", 3 => "Service och reservdelar", 4 => "Kassa ", 5 => "ÄTA", 6 => "Självbyggare", 7 => 'Specialoffert', 8 => 'Solcellspaket');
                    foreach ($projectype_search as $project_typekey => $project_typevalue) :
                        ?>


                        <option value="<?php echo $project_typekey; ?>"><?php echo $project_typevalue; ?></option>


    <?php endforeach; ?>


                </select>
            </div>
  <div class="col-lg-2 col-md-3 col-sm-6"><?php get_number_of_posts_dropdown("number-of-posts_" . $project_status, $table_name, "top-buffer-half", 'column_filter customerlimit '); ?>
        </div>
		</div>
        <table id="example" class="table table-striped table-bordered" style="    margin: 0px 2em !important;">
            <thead>
                <tr>
                    <th><?php echo __("Kundnummer"); ?></th>
                    <th><?php echo __("Fullständigt namn"); ?></th>
                    <th><?php echo __('E - post'); ?></th>
                    <th><?php echo __('Telefonummer'); ?></th>
                    <th><?php echo __('Postnummer'); ?></th>
                    <th><?php echo __('Postort'); ?></th>
                  
                    <th><?php echo __('Address'); ?></th>
                    <th><?php echo __('Säljare'); ?></th>
                    <th><?php // echo __('Address');  ?></th>
                </tr>
            </thead>
			
<tbody id="userlist">
</tbody>
		
        </table>
		<div class="newby" ></div>

      <div class="col-md-3 top-buffer-half">

             <form method='post' action=''>
                <label for="" style="visibility: hidden">Sök</label>
                <input type="hidden" value="exportuserlist" name="exportuserlist" />
                <textarea id="exportuserdata" name='exportuserdata' style='display: none;'></textarea>
                <input type="submit" value="Exportera till Excel"  class="btn btn-beta btn-block btn-menu userexportdata">
            </form>
        </div>
    </div>







</div>
<script>
jQuery(document).ready(function(){
	 jQuery(".cstm_date_picker").datepicker();
function customerlist(){	
 
jQuery.ajax({
	 url: '/wp-content/plugins/imm-sale-system/ajax/userlist.php',
            type: 'POST',
			data:{
				searchText:jQuery("input#customersearch").val(),
				salesman:jQuery("select#col8_filter option:selected").val(),
				status : jQuery("select.customerRegister_filter option:selected").val(),
				limit : jQuery("select.customerlimit option:selected").val(),
				from_date:jQuery('.imm-sale-order-date_from').val(),
				to_date:jQuery('.imm-sale-order-date_to').val(),
				project_type:jQuery('#project_type').val()
				
			},                beforeSend: function () {
                jqueryshow_loader("show");
                },
            success: function(result) {
				jQuery("#userlist").empty();
				   var data = jQuery.parseJSON(result);
		
				    jQuery('textarea#exportuserdata').html(result);
                    jQuery.each(jQuery(data['data']), function(i, ob) {
						var userid = ob['id'];
                        var name = ob['customer_name'];
                        var email = ob['email'];
                        var phone = ob['phone'];
                        var postcode = (ob['postcode']) ? ob['postcode'] : "";
                        var city = (ob['city']) ? ob['city'] : "";
						var address = ob['address'];
                        var salesman = (ob['salesman']) ? ob['salesman'] : "";
						var editLink = ob[0];
        jQuery("#userlist").append('<tr class="clickable"><td>' + userid + '</td><td class="custmnewtab" nowrap>' + name + '</td><td>' + email + '</td><td>' + phone + '</td><td>' + postcode + '</td><td>' + city + '</td><td>' + address + '<td>' + salesman + '</td><td>' + editLink + '</td></tr>');
         });
		 jqueryshow_loader("hide");
		}
})	
}
customerlist();
function throttle(f, delay){
    var timer = null;
    return function(){
        var context = this, args = arguments;
        clearTimeout(timer);
        timer = window.setTimeout(function(){
            f.apply(context, args);
        },
        delay || 1000);
    };
}
jQuery(".column_filter").change(function(){
	customerlist();
});
  jQuery("input#customersearch").keyup(throttle(function(){
customerlist();
  }));
});
</script>
<?php wp_footer(); ?>
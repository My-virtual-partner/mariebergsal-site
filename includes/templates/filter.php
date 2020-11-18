<?php
/**
 * Template used to create a filter project.
 * URL PATH: $_SERVER['REQUEST_URI'], '/filter-project'
 */
include_once( plugin_dir_path( __FILE__ ) . 'head.php' );
$current_user_role = get_user_role();
?>
<div id="projects" class="tab-pane fade">
	<?php
	$table_name     = "all-table";
	$project_status = "project-ongoing";
	?>

    <?php
    if(!current_user_can('sale-sub-contractor')):
    ?>
    <div class="row top-buffer-half">
	
        <div class="col-lg-6 col-md-6 col-sm-12">
            <label class="top-buffer-half"
                   for="imm-sale-search-project"> <?php echo __( "Sök efter projekt" ); ?></label>
            <input value="" type="text" onkeypress="return event.keyCode != 13;" name="imm-sale-search-project"
                   data-table_name="<?php echo $table_name; ?>"
                   data-current_department="<?php echo $current_user_role; ?>"
                   data-project_status="<?php echo $project_status ?>"
                   class="form-control imm-sale-search-project imm-sale-search-project_ongoing"
                   id="imm-sale-search-project_<?php echo $table_name; ?>"
                   placeholder="<?php echo __( "Sök efter projekt..." ); ?>">

        </div>
		
	
        <div class="col-lg-3 col-md-3 col-sm-6"><?php get_project_status_dropdown( "order-by-this-project-status_" . $project_status, $table_name, "top-buffer-half" ,'filter_project_tab'); ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6"><?php get_departments_dropdown( "order-department_" . $project_status, $table_name, null, true, $project_status, "top-buffer-half",'filter_project_tab' ); ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6"><?php get_my_or_all_dropdown( "order-by-mine-or-all",get_current_user_id(), $table_name, "top-buffer-half" ,'filter_project_tab');
		?>
        </div>
  <!--      <div class="col-lg-3 col-md-3 col-sm-6"><?php /*get_internal_project_status_dropdown( $current_user_role, "internal_project_status_dropdown", $table_name, "top-buffer-half" ); */?>

        </div>-->
        <div class="col-lg-3 col-md-3 col-sm-6"><?php get_office_dropdown( "order-by-office_" . $project_status, $table_name, null, "top-buffer-half",'filter_project_tab' ); ?>
        </div>
       
    <div class="col-lg-3 col-md-3 col-sm-3">
            <label for="imm-sale-order-date_from" class="top-buffer-half"> <?php echo __("Från"); ?></label>
            <input type="date" id="imm-sale-order-date_from" class="filter_project_tab" data-table_name="all-table" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <label for="imm-sale-order-date_to" class="top-buffer-half"> <?php echo __("Till"); ?></label>
            <input type="date" id="imm-sale-order-date_to" class="filter_project_tab" data-table_name="all-table" placeholder="yyyy-mm-dd">
        </div>
		 <div class="col-lg-3 col-md-3 col-sm-6"><?php get_number_of_posts_dropdown( "number-of-posts_" . $project_status, $table_name, "top-buffer-half",'filter_project_tab' ); ?>
        </div>
  <div class="col-lg-3 col-md-3 col-sm-3" id="get_internal_status">
  
		<?php get_internal_project_status_dropdown( 'alla', "internal_project_status_user", $table_name , "top-buffer-half", $internal_status,'', 'filter_project_tab' ); ?>
    </div>
	
	
 
  <div class="col-lg-3 col-md-3 col-sm-3">
  <label class="top-buffer-half" for="project_type"><?php echo __("Typ av projekt") ?></label>

                                <select id="project_type" name="project_type" class="form-control js-sortable-select filter_project_tab" data-table_name="all-table">
                                     <option value='Alla'><?php echo __("Alla"); ?></option>
                                    <?php

                                    $current_user_role = get_user_role();
//                                    $project_type_id = get_field('order_project_type', $_GET["order-id"]);

                                    $project_roles_steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);
                                    foreach ($project_roles_steps as $project_type) : ?>


                                        <option <?php
//                                        if ($project_type_id == $project_type["project_type_id"]) {
//                                            echo " selected ";
//                                        }
                                        ?>
                                                value="<?php echo $project_type["project_type_id"]; ?>"><?php echo $project_type["project_type_name"]; ?>
                                        </option>


                                    <?php endforeach; ?>


                                </select>
    </div>
<div class="col-lg-3 col-md-3 col-sm-3">
  
		<?php  get_status_order(); ?>
    </div>
    </div>

    <?php
    endif;
    ?>
    <table class="table top-buffer-half">
        <thead>

        <tr>
            <th class="sortable"
                onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"></th>
            <th class="sortable"
                onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Projekt ID" ); ?></th>
               <!-- <th class="sortable"
                onclick="sortTable(4,  <?php ///echo "'" . $table_name . "'"; ?>)"><?php //echo __( "Order" ) ?></th> --->
            <th class="sortable"
                onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Skapat" ); ?></th>
            <th class="sortable"
                onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Avdelning" ) ?></th>
            <th class="sortable"
                onclick="sortTable(2,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Projektstatus" ); ?></th>
            <th class="sortable"
                onclick="sortTable(2,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Butik" ); ?></th>
            <th class="sortable"
                onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Kund" ) ?></th>
            <th class="sortable"
                onclick="sortTable(4,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Säljare" ) ?></th>

			<!--<th class="sortable"
                onclick="sortTable(1,  <?php //echo "'" . $table_name . "'"; ?>)"><?php// echo __("Exkl. moms "); ?></th>
            <th class="sortable"
                onclick="sortTable(3,  <?php //echo "'" . $table_name . "'"; ?>)"><?php //echo __("Moms"); ?></th> -->
            <th class="sortable"
                onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Ordervärde ink moms"); ?></th>
				<th class="sortable"
                onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Intern Projektstatus"); ?></th> 
            <th class="sortable"
                onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Status"); ?></th> 
            <th class="sortable"
                onclick="sortTable(3,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Projekttyp"); ?></th> 

        </tr>
        </thead>
        <tbody id="<?php echo $table_name ?>">
		<?php
	/* 	if ( $current_user_role == 'sale-sub-contractor' ) {
			$meta = array(
				'relation' => 'AND',
				array(
					'key'   => 'order_current_department',
					'value' => $current_user_role,
				),
				array(
					'key'   => 'imm-sale-project',
					'value' => $project_status,
				),
				array(
					'key'   => 'order_salesman',
					'value' => get_current_user_id(),
				),
			);

		} else {
			$meta = array(
				'relation' => 'AND',
				 array(
					'key'   => 'order_current_department',
					'value' => $current_user_role,
				), 
				array(
					'key'   => 'imm-sale-project',
					'value' => $project_status,
				),
				array(
					'key'   => 'order_salesman',
					'value' => get_current_user_id(),
				),
				
			);
		}
		$args = [
			'posts_per_page' => 100,
			'orderby'        => 'DATE',
			'order'			 => 'DESC',
           // 'author' =>        get_current_user_id(),
			'post_type'      => 'imm-sale-project',
			'meta_query'     => $meta

		];  */
            //  $products = new WP_Query($args);
		//echo "<pre>";print_r($products); echo "</pre>";
		//search_and_display_projects()
		//return_projects_table( $args, $current_user_role);
		//wp_reset_query();

		?>
        </tbody>
    </table>
</div>
<script>
jQuery(document).ready(function($){
var dataAttributeTableName = '<?php echo $table_name; ?>';
$.ajax({
            //url: ajaxUrl,
            url: '/wp-content/plugins/imm-sale-system/ajaxs.php',
            type: 'POST',
            data: {
				action: 'search_and_display_projects',
                mine_or_all: '<?php echo get_current_user_id(); ?>',
                project_status: '<?php echo $project_status; ?>',
                table_name: '<?php echo $table_name; ?>',
                current_department: 'alla',
				statusorder:'Alla',
				selected_office:'order-by-office_project-ongoing',
				posts_per_page:10,
				current_status:'Alla',
				project_type: 'Alla',
				from_date:'',
				to_date:''
				
            },
            beforeSend: function () {
               // $.LoadingOverlay("show");
            },
            success: function (result) { 
             console.log(result);
               // $.LoadingOverlay("hide");
                $("#" + dataAttributeTableName).empty();
                if (result == '1') {

                    $("#" + dataAttributeTableName).append('<tr><td>Inga resultat hittades</td></tr>');
                } else {
                    var data = $.parseJSON(result);

                    $.each($(data), function (i, ob) {
                        var project_id = ob["project_id"];
						
                        var prjnumber = ob["custom_project_number"];
                        var time = ob["time"];
                        var statuss = ob["status"];
                        var prjstatus = ob["project_status"];
                        var cusid = ob["cusid"];
                        var custname = ob["custname"];
                        var store = ob['store'];
                        var salememail = ob["sale_email"];
                        var salesman = ob["salesman"];
                        var total = ob["total"];
                        var internal = (ob["internal_status"]!='Alla')?ob["internal_status"]:"";
                        var orderacc = ob["orderaccpet"];
                        var prjtype = (ob["project_types"])?ob["project_types"]:"";
                        $("#" + dataAttributeTableName).append('<tr class="clickable"><td>' + ob['i'] + '</td><td class="custmnewtab" nowrap><a target="_new" href="/project?pid=' + project_id + '">' + prjnumber + '</a></td><td>' + time + '</td><td>' + statuss + '</td><td>' + prjstatus + '</td><td>' + store + '</td><td><a href="/project?pid=' + project_id + '">' + custname + '</td><td>' + salesman + '</td><td>' + total + '</td><td>' + internal + '</td><td>' + orderacc + '</td><td>' + prjtype + '</td></tr>');
                    });

                }
            }
        });
		
	 /* $.ajax({
            //url: ajaxUrl,
            url: '/wp-content/plugins/imm-sale-system/test.php',
            type: 'POST',
            data: {
				action: 'search_and_display_projects',
                mine_or_all: '<?php echo get_current_user_id(); ?>',
                project_status: '<?php echo $project_status; ?>',
                table_name: '<?php echo $table_name; ?>',
                current_department: 'alla',
				statusorder:'Alla',
				selected_office:'order-by-office_project-ongoing',
				posts_per_page:10,
				current_status:'Alla',
				project_type: 'Alla',
				from_date:'',
				to_date:''
				
            },
            beforeSend: function () {
               // $.LoadingOverlay("show");
            },
            success: function (results) { 
             console.log(results);
             
          
         
            }
        });  */
		});
</script>
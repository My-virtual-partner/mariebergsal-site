<?php
/**
 * Projects tab in System Dashboard. Filters default based on the user role.
 */
$current_user_role = get_user_role();
global $current_user;
?>

<div id="projects" class="tab-pane fade newproject">
    <?php
    $table_name = "all-table";
    $project_status = "project-ongoing";
    ?>

    <?php
    $current_user_role = get_user_role();
    if (!current_user_can('sale-sub-contractor')):
        ?>
        <div class="row top-buffer-half">

            <div class="col-lg-3 col-md-3 col-sm-6">
                <label class="top-buffer-half"
                       for="imm-sale-search-project"> <?php echo __("Sök efter projekt"); ?></label>
                <input value="" type="text" onkeypress="return event.keyCode != 13;" name="imm-sale-search-project"
                       data-table_name="<?php echo $table_name; ?>"
                       data-current_department="all"
                       data-project_status="<?php echo $project_status ?>"
                       class="form-control imm-sale-search-project imm-sale-search-project_ongoing"
                       id="imm-sale-search-project_<?php echo $table_name; ?>"
                       placeholder="<?php echo __("Sök efter projekt..."); ?>">

            </div>
	 <div class="col-lg-3 col-md-3 col-sm-6">
                <label class="top-buffer-half"
                       for="search_product"> <?php echo __("Sök Huvudprodukt"); ?></label>
                <input value="" type="text" onkeypress="return event.keyCode != 13;" name="search_product"
                       data-table_name="<?php echo $table_name; ?>"
                       data-current_department="all"
                       data-project_status="<?php echo $project_status ?>"
                       class="form-control search_product imm-sale-search-project"
                       id="search_product_<?php echo $table_name; ?>"
                       placeholder="<?php echo __("Sök Huvudprodukt..."); ?>">

            </div>
<div class="col-lg-3 col-md-3 col-sm-6"><?php get_my_or_all_dropdown("order-by-mine-or-all", get_current_user_id(), $table_name, "top-buffer-half", 'filter_project_tab1');
    ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6"><?php get_office_dropdown("order-by-office_" . $project_status, $table_name, null, "top-buffer-half", 'filter_project_tab1'); ?>
            </div>
			<div class="col-lg-3 col-md-3 col-sm-6"><?php get_departments_dropdownValue("order-department_" . $project_status, $table_name, $current_user_role, true, $project_status, "top-buffer-half", 'filter_project_tab1'); ?>
            </div>
            <?php endif; ?>
            
                  <div class="col-lg-3 col-md-3 col-sm-6" ><?php
        if ($current_user_role == 'sale-sub-contractor') {
            $args = array('role__in' => array('sale-sub-contractor'));
        } else {
            $args = array('role__in' => array('sale-administrator', 'sale-salesman', 'sale-economy', 'sale-technician', 'sale-project-management', 'sale-sub-contractor'));
        }

        $users = get_users($args);
        ?>
            <label class="top-buffer-half"
                   for="assigned-technician-select"><?php echo __("Ansvarig användare just nu") ?></label>
            <select name="responsible_department" class="form-control js-sortable-select filter_project_tab1" data-table_name="all-table" id="assigned-technician-project"
                    >
                <option value="alla"><?php echo __("Ingen användare vald"); ?></option>
<?php
foreach ($users as $user) :
    $current_user_company_name = get_user_meta($current_user->ID, 'sale-sub-contractor_company', true);
    $comapny_name = get_user_meta($user->ID, 'sale-sub-contractor_company', true);
    if ($current_user_role == 'sale-sub-contractor') {
        if ($current_user_company_name == $comapny_name) {

            if (get_current_user_id() == $user->ID) {
                $selected = " selected ";
            } else {
                $selected = '';
            }
            ?>

                            <option  value="<?php echo $user->ID ?>" <?php echo $selected; ?> data_roll="<?php $rolles = get_userdata($user->ID);
                echo implode(', ', $rolles->roles) ?>" ><?php echo showName($user->ID); ?></option>

                        <?php }
                    } else {
                        ?><option  value="<?php echo $user->ID ?>" data_roll="<?php $rolles = get_userdata($user->ID);
                echo implode(', ', $rolles->roles) ?>" ><?php echo showName($user->ID); ?></option>
    <?php } endforeach; ?>
            </select>
        </div>
            
            <div class="col-lg-3 col-md-3 col-sm-3">
            <label for="imm-sale-order-date_from" class="top-buffer-half"> <?php echo __("Från"); ?></label>
            <input type="text" class="filter_project_tab1 cstm_date_picker imm-sale-order-date_from" data-table_name="all-table" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
            <label for="imm-sale-order-date_to" class="top-buffer-half"> <?php echo __("Till"); ?></label>
            <input type="text" class="filter_project_tab1 cstm_date_picker imm-sale-order-date_to" data-table_name="all-table" placeholder="yyyy-mm-dd">
        </div>
            
            <div class="col-lg-3 col-md-3 col-sm-6"><?php get_number_of_posts_dropdown("number-of-posts_" . $project_status, $table_name, "top-buffer-half", 'filter_project_tab1'); ?>
        </div>
            <?php if (!current_user_can('sale-sub-contractor')): ?> 
      <div class="col-lg-3 col-md-3 col-sm-3">

    <?php get_status_orderValue('filter_project_tab1'); ?>
            </div>
			  <div class="col-lg-3 col-md-3 col-sm-6"><?php get_project_status_dropdownValue("order-by-this-project-status_" . $project_status, $table_name, "top-buffer-half", 'filter_project_tab1', "Alla"); ?>
            </div>
        



  
       
	   
	   
            <div class="col-lg-3 col-md-3 col-sm-3" id="get_internal_status">

    <?php get_internal_project_status_dropdownValue($current_user_role, "internal_project_status_user", $table_name, "top-buffer-half", $internal_status, '', 'filter_project_tab1'); ?>
            </div>



            <div class="col-lg-3 col-md-3 col-sm-3">
                <label class="top-buffer-half" for="project_type"><?php echo __("Typ av projekt") ?></label>

                <select id="project_type" name="project_type" class="form-control js-sortable-select filter_project_tab1" data-table_name="all-table">
                    <option value='Alla'><?php echo __("Alla"); ?></option>
                    <?php
                    $current_user_role = get_user_role();
//                                    $project_type_id = get_field('order_project_type', $_GET["order-id"]);

                    $project_roles_steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);
                    $projectype_search = array(1 => "Hembesök", 2 => "Eldstad inklusive montage", 3 => "Service och reservdelar", 4 => "Kassa ", 5 => "ÄTA", 6 => "Självbyggare", 7 => 'Specialoffert', 8 => 'Solcellspaket');
                    foreach ($projectype_search as $project_typekey => $project_typevalue) :
                        ?>


                        <option <?php
//                                        if ($project_type_id == $project_type["project_type_id"]) {
//                                            echo " selected ";
//                                        }
                        ?>
                            value="<?php echo $project_typekey; ?>"><?php echo $project_typevalue; ?>
                        </option>


    <?php endforeach; ?>

                </select>
            </div>
          
			 
        </div>
        <?php
    endif;
    if (current_user_can('sale-sub-contractor')) {
        ?>
        <input value='1' type="hidden" id='sale-sub-contractor' class="form-control filter_project_tab1">

    <?php } else {
        ?>	 <input value='2' type="hidden" id='sale-sub-contractor' class="form-control filter_project_tab1">
<?php } ?>

    <table class="table top-buffer-half">
        <thead>
            <tr>
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"></th>
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Affärsförslag ID"); ?></th>
                   <!-- <th class="sortable"
                    onclick="sortTable(4,  <?php ///echo "'" . $table_name . "'";  ?>)"><?php //echo __( "Order" )  ?></th> --->
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Skapat"); ?></th>
                <th class="sortable"
                    onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Avdelning") ?></th>
                <th class="sortable"
                    onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Projektstatus"); ?></th>
                <th class="sortable"
                    onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Butik"); ?></th>
                 <?php if (!current_user_can('sale-sub-contractor')): ?>
					   <th class="sortable"
                    onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Huvudprodukt"); ?></th>
                                           <?php endif; ?>
                <th class="sortable"
                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Kund") ?></th>
                <th class="sortable"
                    onclick="sortTable(4, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Säljare") ?></th>

                        <!--<th class="sortable"
                onclick="sortTable(1,  <?php //echo "'" . $table_name . "'";  ?>)"><?php // echo __("Exkl. moms ");  ?></th>
            <th class="sortable"
                onclick="sortTable(3,  <?php //echo "'" . $table_name . "'";  ?>)"><?php //echo __("Moms");  ?></th> -->
                    <?php if (!current_user_can('sale-sub-contractor')): ?>
                    <th class="sortable"
                        onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Ordervärde ink moms"); ?></th>
<?php endif; ?>
                <th class="sortable"
                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Intern Projektstatus"); ?></th> 
                <th class="sortable"
                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Status"); ?></th> 
                <th class="sortable"
                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Projekttyp"); ?></th> 

            </tr>
        </thead>
        <tbody id="<?php echo $table_name ?>">

        </tbody>
    </table>
</div>
<script>
    function get_departments(department, class_name, table_name = false, classes) {
        var department = department;

        jQuery.ajax({
            url: ajaxUrl,
            type: 'post',
            data: {
                action: 'getDepartmentValue',
                department: department,
                table_name: table_name,
                classes: classes
            },
            success: function(result) {

                jQuery('#' + class_name).html(result);
                jQuery('.js-sortable-select').select2(
                        {
                            theme: "bootstrap",
                            width: '100%'
                        });
            }
        });
    }

    jQuery(document).ready(function($) {
<?php if ($current_user_role != 'sale-sub-contractor') { ?>
            var conv = JSON.parse(readCookie('projects'));
            $.each(conv, function(key, value) {
                first = value.split('##');
                $("#projects select[name= '" + first[0] + "']").val(first[1]);
                var get = $("#projects select[name= '" + first[0] + "'] :selected").text();
                if (first[0] == 'order-department_project-ongoing' && first[1] == 'alla') {

                    get_departments('alla', 'get_internal_status', 'all-table', 'filter_project_tab');
                }
                $('#projects span#select2-' + first[0] + '-container').text(get);
                $('#projects span#select2-' + first[0] + '-container').prop('title', get);
            });
<?php } ?>
        var assign_project = $("#projects #assigned-technician-project option:selected").val();
        var mine_or_all = $("#projects #order-by-mine-or-all option:selected").val();
        var dept = $('#imm-sale-search-project_all-table').attr('data-current_department option:selected');
        var dataAttributeTableName = '<?php echo $table_name; ?>';


        var currentdepartment = $("#projects #order-department_project-ongoing option:selected").val();

        if (currentdepartment == 'alla') {
            var current_department = '<?php echo get_user_role(); ?>';
        } else {
            var current_department = $("#projects #order-department_project-ongoing option:selected").val();
        }
        var current_department = $("#projects #order-department_project-ongoing option:selected").val();
        var project_wise = $("#projects #project_wise").val();
        var statusorder = $("#projects #order_statusid").val();
        var selectedOffice = $("#projects #order-by-office_project-ongoing option:selected").val();
        var mine_or_all = $("#projects #order-by-mine-or-all").val();
        var assign_project = $("#projects #assigned-technician-project option:selected").val();
        var from_date = $("#projects .imm-sale-order-date_from").val();
        var to_date = $("#projects .imm-sale-order-date_to").val();
        var project_type = $("#projects #project_type option:selected").val();


        // var role_status = $('#projects select#internal_project_status_user option:selected').val().split('#');
        var role_status = $('#projects select#internal_project_status_user').val();

        if (role_status != 'Alla') {
            if ($('#projects select#internal_project_status_user').val()) {
                var dividerole = role_status.split('#');

                var internal_project_status = dividerole[0];
                var current_department = dividerole[1];
            }
        } else {
            if (current_department == 'alla') {
                current_department = '';
            }
            var internal_project_status = '';
        }

        current_status = '';
        roles = '';
        var dataAttributeProjectStatus = $("#order-by-this-project-status_project-ongoing option:selected").val();
        var search_term = $('#projects #imm-sale-search-project_' + dataAttributeTableName).val();
        //  var search_order = $('#projects #imm-sale-search-order_' + dataAttributeTableName).val();


        //var internal_project_status = $("#projects #internal_project_status_dropdown option:selected").val();
        var posts_per_page = $("#projects #number-of-posts_project-ongoing").val();

        $.ajax({
            //url: ajaxUrl,
            url: '/wp-content/plugins/imm-sale-system/sampleajax.php',
            type: 'POST',
            data: {
                action: 'search_and_display_projects',
                mine_or_all: mine_or_all,
                project_status: dataAttributeProjectStatus,
                table_name: '<?php echo $table_name; ?>',
                current_department: current_department,
                statusorder: statusorder,
                selected_office: selectedOffice,
                assign_project: assign_project,
                posts_per_page: posts_per_page,
                current_status: current_status,
                project_type: project_type,
                from_date: from_date,
                to_date: to_date,
                search_term: search_term

            },
            beforeSend: function() {
                // $.LoadingOverlay("show");
            },
            success: function(result) { //$("#" + dataAttributeTableName).empty();
                //$("#" + dataAttributeTableName).append(result);
                //console.log(result);


                $("#" + dataAttributeTableName).empty();
                if (result == '1') {

                    $("#" + dataAttributeTableName).append('<tr><td>Inga resultat hittades</td></tr>');
                } else {

                    var data = $.parseJSON(result);

                    $.each($(data), function(i, ob) {


                        var current_user_role = '<?php echo get_user_role(); ?>';
                        var project_id = ob["id"];

                        var prjnumber = ob["custom_project_number"];
                        var time = ob["time"];
                        var statuss = ob["status"];
                        var prjstatus = ob["project_status"];
						var main_product = (ob['main_product'])?ob['main_product']:'';
                        var custname = ob["custname"];
                        var store = (ob["store"]) ? ob["store"] : "";
                        var salesman = ob["salesman"];
                        var total = ob["total"];
                        var internal = (ob["internal_status"] != 'Alla') ? ob["internal_status"] : "";
                        var orderacc = (ob["orderaccpet"]) ? ob["orderaccpet"] : "Väntar svar";
                        var prjtype = (ob["project_types"]) ? ob["project_types"] : "";
                        if (current_user_role == 'sale-sub-contractor') {
                            $("#" + dataAttributeTableName).append('<tr class="clickable"><td>' + ob['i'] + '</td><td class="custmnewtab" nowrap><a target="_new" href="/project?pid=' + project_id + '">' + prjnumber + '</a></td><td>' + time + '</td><td>' + statuss + '</td><td>' + prjstatus + '</td><td>' + store + '</td><td><a href="/project?pid=' + project_id + '">' + custname + '</td><td>' + salesman + '</td><td>' + internal + '</td><td>' + orderacc + '</td><td>' + prjtype + '</td></tr>');
                        } else {
                            $("#" + dataAttributeTableName).append('<tr class="clickable"><td>' + ob['i'] + '</td><td class="custmnewtab" nowrap><a target="_new" href="/project?pid=' + project_id + '">' + prjnumber + '</a></td><td>' + time + '</td><td>' + statuss + '</td><td>' + prjstatus + '</td><td>' + store + '</td><td>'+main_product+'</td><td><a href="/project?pid=' + project_id + '">' + custname + '</td><td>' + salesman + '</td><td>' + total + '</td><td>' + internal + '</td><td>' + orderacc + '</td><td>' + prjtype + '</td></tr>');

                        }
                    });
                }
            }
        });



        jQuery(".cstm_date_picker").datepicker();

    });
</script>
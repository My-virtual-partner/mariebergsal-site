<?php
/**
 * Template used to edit project information
 * URL PATH: $_SERVER['REQUEST_URI'], '/project'
 */
include_once( plugin_dir_path(__FILE__) . 'head.php' );

$project_id = $_GET["pid"];
?>

<div class="container-db">
    <div class="front-loader"></div>
    <div class="row">
	<?php 
	if($excelError){
		echo $excelError;
	}
	?>
        <div class="col-lg-12">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="quick-project-handle" value="true">
                <?php
                $project = get_post($project_id);
                global $current_user;

                $current_user_role = get_user_role();
                $current_department = get_field('order_current_department', $project_id);

                $args = array(
                    'orderby' => 'ID',
                    'post_type' => wc_get_order_types(),
                    'post_status' => array('wc-processing', 'wc-pending', 'wc-on-hold', 'wc-completed', 'wc-refunded', 'wc-cancelled'),
                    'posts_per_page' => - 1,
                    'meta_query' => array(
                        array(
                            'key' => 'imm-sale_project_connection',
                            'value' => $project_id,
                            'compare' => '='
                        ),
                        array(
                            'key' => 'imm-sale_prepayment_invoice',
                            'compare' => 'NOT EXISTS'
                        ),
                    )
                );

                $orders = new WP_Query($args);
//echo "<pre>"; print_r($orders);
                while ($orders->have_posts()) :
                    $orders->the_post();
                    $orderidIN = get_the_ID();
                    $order = new WC_Order($orderidIN);
                    $order_AccptDate = get_post_meta($orderidIN, 'order_accept_date', true);
					$customer_phone = get_post_meta($orderidIN, '_billing_phone', true);
                    updateSearchMeta($orderidIN, 'date', $order_AccptDate);
                    $post_date = get_post_meta($orderidIN, 'postdate', true);
                    updateSearchMeta($orderidIN, 'create_date', $post_date);
                    $orderaccept = get_post_meta($order->ID, 'order_accept_status', true);
                    $custom_project_number = get_post_meta($project_id, 'custom_project_number', true);
					     $customer_id = get_post_meta($project_id, "invoice_customer_id")[0];
                    if (empty($custom_project_number)) {
                   
                        $custom_project_number = $customer_id . '-' . $project_id;
                    }
                    $order_total_price = $order->get_total();
					
                    if (get_field('imm-sale-tax-deduction', $order->get_id()) || get_post_meta($order->get_id(), "confirmed_rot_percentage", true)) {
                        $rot_avdrag = get_post_meta($order->get_id(), "confirmed_rot_percentage", true);
                        $display_price = $order_total_price - $rot_avdrag;
                    } else {
                        $rot_avdrag = 0;
                        $display_price = $order_total_price;
                    }
				
                endwhile;





//                $custom_project_number = get_post_meta($project_id, 'custom_project_number')[0];
                ?>
                <input type="hidden" name="quick-project-id" value="<?php echo $project->ID; ?>">
                <input type="hidden" name="imm-sale-order-department" value="<?php echo $current_department; ?>">
                <!--<input type="hidden" name="sale-order-department" id="sale-order-department" value="">-->
                <meta charset="UTF-8">
                <h2><?php echo "Projekt #" . $custom_project_number; ?></h2>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="list-inline margin-zero">
                            <?php if ($current_user_role != 'sale-sub-contractor') : ?>
                                <li>
                                    <a href="#" id="toggle-invoices"
                                       class="btn btn-alpha btn-block top-buffer-half btn-toggle-hover"><i class="fa fa-angle-double-down"
                                                                                                        aria-hidden="true"></i> <?php echo __("Försäljning"); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" id="toggle-prepayment-invoices"
                                       class="btn btn-alpha btn-block top-buffer-half btn-toggle-hover"><i class="fa fa-angle-double-down"
                                                                                                        aria-hidden="true"></i> <?php echo __("Ekonomi"); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" id="toggle-dates"
                                       class="btn btn-alpha btn-block top-buffer-half btn-toggle-hover"><i class="fa fa-angle-double-down"
                                                                                                        aria-hidden="true"></i> <?php echo __("Planering"); ?>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <li>
                                <a href="#" id="toggle-checklists"
                                   class="btn btn-alpha btn-block top-buffer-half btn-toggle-hover"><i class="fa fa-angle-double-down"
                                                                                                    aria-hidden="true"></i> <?php echo __("Uppgifter"); ?>
                                </a>
                            </li>
                            <li>
                                <a href="#" id="toggle_uploaded_files_project"
                                   class="btn btn-alpha btn-block top-buffer-half btn-toggle-hover"><i class="fa fa-upload"
                                                                                                    aria-hidden="true"></i> <?php echo __("Fil uppladdning"); ?>

                                </a>
                            </li>
                            <li>
                                <button type="button"
                                        class="btn btn-alpha btn-block top-buffer-half toggle-todo-modal"
                                        data-project-id="<?php echo $project_id ?>"><i class="fa fa-list-ol" aria-hidden="true"></i> <?php echo __("Skapa uppgift"); ?>
                                </button>
                            </li>
                            <?php if ($current_user_role != 'sale-sub-contractor') : ?>
                                <li>
                                    <a href="<?php echo site_url() . "/select-invoice-type?project-id=" . $project_id ?>"
                                       class="btn btn-alpha btn-block top-buffer-half"><i class="fa fa-cube" aria-hidden="true"></i> <?php echo __("Skapa offert"); ?>
                                    </a>
                                </li>
                            <?php endif; ?>





                            <!--                            <li>
                                                            <a href="#work-planning-project-calendar" id="project-calendar-tab" data-toggle="tab"
                                                               class="btn btn-alpha btn-block top-buffer-half btn-toggle-hover"><i class="fa fa-calendar"
                                                                                                                                aria-hidden="true"></i> <?php //echo __("Kalender");   ?>
                            
                                                            </a>
                                                        </li>-->

                            <li>
                                <button type="submit"
                                        class="btn btn-brand btn-block top-buffer-half">
                                            <?php echo __("Spara och uppdatera projekt"); ?>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <!--<div id="work-planning-project-calendar" style="display: none;" class="top-buffer-half">

    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12">
                <?php //get_tech_sub_dropdown( "order_calendar_by_user" );  ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12">
                <?php //get_office_dropdown( "order_calendar_by_office" );  ?>
        </div>

    </div>
    <div class="top-buffer" id='work-planning-calendar-cal'></div>
</div>
!-->
                <hr>
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        $internal_status = get_post_meta($project->ID, 'internal_project_status_' . $current_user_role)[0];
                        $current_customer_id = get_post_meta($project->ID, 'invoice_customer_id')[0];
                        $fullname = showName($current_customer_id);
                        $address1 = get_user_meta($current_customer_id, 'billing_address_1')[0];
                        $address2 = get_user_meta($current_customer_id, 'billing_address_2')[0];
                        $billing_postcode = get_user_meta($current_customer_id, 'billing_postcode')[0];
                        $billing_city = get_user_meta($current_customer_id, 'billing_city')[0];
                        $billingphone = get_user_meta($current_customer_id, 'billing_phone')[0];
                        $billingphone1 = get_user_meta($current_customer_id, 'billing_phone_2')[0];
                        $newaddress = ($billingphone) ? $billingphone : $billingphone1;
                        ?>

                        <ul class="list-inline">
                            <li><?php echo $fullname; ?></li>
                            <li><?php echo get_user_meta($current_customer_id, 'billing_phone')[0] ?></li>
                            <li><?php echo get_user_meta($current_customer_id, 'billing_phone_2')[0] ?></li>
                            <li><?php echo $address1; ?></li>
                            <li><?php echo $address2; ?></li>
                            <li><?php echo $billing_postcode . " " . $billing_city ?> </li>
                            <li><?php echo get_user_meta($current_customer_id, 'billing_email')[0]; ?></li>
                            <?php if ($current_user_role != 'sale-sub-contractor') : ?>
                                <li>
                                    <a href="<?php echo "/customer-edit?customer-id=" . $current_customer_id . "&projectid=" . $_GET['pid'] ?>"><?php echo __("Redigera kunduppgifter") ?></a>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <div>
						<ul class="list-inline">
						             <?php 
									  $tax_deduction = get_field("imm-sale-tax-deduction", $order_id);
									 
									 if ($current_user_role != 'sale-sub-contractor') : ?>
									  <?php if ($tax_deduction > 0) : ?>
                                        <li><label><?php echo __('ROT avdrag'); ?>:</label><?php echo ' ' . $tax_deduction . ' Kr'; ?></li>
                                        <?php  endif;
										if ($rot_avdrag > 0) : ?>
                                            <li><label><?php echo __('Beräknad ROT '); ?>:</label><?php echo ' ' . wc_price(0 - $rot_avdrag); ?></li>
                                            <?php
                                        endif;
                                    endif; ?>
						</ul>
                            
                                <?php
                                global $wpdb;

                                $sql = "SELECT SQL_CALC_FOUND_ROWS  VQbs2_postmeta.* FROM VQbs2_postmeta  WHERE meta_key='imm-sale_project_connection' and meta_value='$project->ID' order by post_id asc";
                                $qryOrderData = $wpdb->get_results($sql);
foreach($qryOrderData as $gethousehold){
	?>
	
	<?php
                                $order_id = $gethousehold->post_id;
                                $household_vat_discount_json = get_post_meta($order_id, "household_vat_discount_json")[0];
                                $household_vat_discount = return_array_from_json($household_vat_discount_json);
//                                         

//print_r($household_vat_discount_json);
                               foreach($household_vat_discount as $household_vat_discountValue){
                                $Namn = $household_vat_discountValue['customer_household_vat_discount_name'];
                                $Personnummer = $household_vat_discountValue["customer_household_vat_discount_id_number"];
                                $fastiganteckning = $household_vat_discountValue["customer_household_vat_discount_real_estate_name"];
                                $brgorNummber = $household_vat_discountValue["customer_household_org_number"];
                                $lagenhetsNummer = $household_vat_discountValue["customer_household_lagenhets_number"];
								
                                if (!empty($Namn) || !empty($Personnummer) || !empty($fastiganteckning) || !empty($brgorNummber) || !empty($lagenhetsNummer)) {
									if(!in_array($Namn,$rotName)){
                                    ?>
                                    <ul class="list-inline"><li><label><?php echo __('Namn'); ?>:</label><?php echo ' ' . $Namn ?></li>
                                    <li><label><?php echo __('Personnummer'); ?>:</label><?php echo ' ' . $Personnummer ?></li>
                                    <li><label><?php echo __('Fastighetsbeteckning'); ?>:</label><?php echo ' ' . $fastiganteckning ?></li><br>
                                    <li><label><?php echo __('BRF org nummer'); ?>:</label><?php echo ' ' . $brgorNummber; ?></li>
                                    <li><label><?php echo __('Lägenhetsnummer'); ?>:</label><?php echo ' ' . $lagenhetsNummer; ?></li>
									</ul>
									<?php }	}
									$rotName[] = $Namn;
								$Namn =  $Personnummer = $fastiganteckning =  $brgorNummber =  $lagenhetsNummer = $order_id = $household_vat_discount_json = $household_vat_discount = '';
                                }
								
                                ?>


                            
<?php } ?>
                        </div>
                    </div>

                </div>
                <hr>



                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <?php include( 'template-parts/project-economy-summary.php' ); ?>


                        <?php
                        $project_status = get_post_meta($project->ID, 'imm-sale-project')[0];



                        $office_connection = get_post_meta($project->ID, 'office_connection')[0];
                        echo '<select id="order_salesman_hiden_Select" style="display: none;"></select>';
                        get_departments_dropdown("imm-sale-order-department", null, $current_department, false, null, "top-buffer-half");
                        ?>

                        
                            <label class="top-buffer-half"
                                   for="assigned-technician-select"><?php echo __("Ansvarig användare just nu") ?></label>
                                   <?php
                                   $args = array(
                                       'role__in' => array(
                                           'sale-administrator',
                                           'sale-salesman',
                                           'sale-economy',
                                           'sale-technician',
                                           'sale-project-management',
                                           'sale-sub-contractor'
                                       )
                                   );
                                   $users = get_users($args);
                                   $current_assigned_technician = get_post_meta($project->ID, "assigned-technician-select")[0];
                                   ?>

                        
                        <select class="form-control js-sortable-select" id="assigned-technician-select"
                                    name="assigned-technician-select">
                                <option value="alla"><?php echo __("Ingen användare vald"); ?></option>
                                <?php foreach ($users as $user) : 
								$current_user_company_name = get_user_meta($current_user->ID, 'sale-sub-contractor_company', true);
								$comapny_name = get_user_meta($user->ID, 'sale-sub-contractor_company', true);
								  $rolles = get_userdata($user->ID);
                                        $roles =  implode(', ', $rolles->roles);
								if($roles == 'sale-sub-contractor' && $current_user_role =='sale-sub-contractor'){
								if($current_user_company_name == $comapny_name){
									?>
                                    <option <?php
                                    if ($current_assigned_technician == $user->ID) {

                                        echo " selected ";
                                    }
                                    ?> value="<?php echo $user->ID ?>" data_roll="<?=$roles?>" ><?php echo showName($user->ID) . " " . get_user_meta($user->ID, 'sale-sub-contractor_company', true) ?></option>

                                <?php 
								}}else{
							
								?>
                                    <option <?php
                                    if ($current_assigned_technician == $user->ID) {

                                        echo " selected ";
                                    }
                                    ?> value="<?php echo $user->ID ?>" data_roll="<?=$roles?>" ><?php echo showName($user->ID) . " " . get_user_meta($user->ID, 'sale-sub-contractor_company', true) ?></option>

                                <?php 
										
								}
								endforeach; ?>
                            </select>
                        

                            <?php
                            get_salesman_dropdown($project->ID, "order_salesman", null, "top-buffer-half");?>
                           <?php
                             if ($current_user_role != 'sale-sub-contractor') : 
                           
                           get_office_dropdown("office_connection", null, $office_connection, "top-buffer-half");
                            ?>
                            <input type="hidden" class="showdata" value="">

                            <label for="imm-sale-project "
                                   class="top-buffer-half"><?php echo __("Projektstatus"); ?></label>
                            <select name="imm-sale-project" class="form-control js-sortable-select"
                                    id="imm-sale-project">
                                <option <?php
                                if ($project_status == "project-ongoing") {
                                    echo " selected";
                                }
                                ?> value="project-ongoing"><?php echo __("Pågående"); ?></option>
                                <option <?php
                                if ($project_status == "project-archived") {
                                    echo " selected";
                                }
                                ?> value="project-archived"><?php echo __("Avslutat"); ?></option>
                            </select>

                        <?php endif;
                        $current_value = get_post_meta($project->ID, "internal_project_status_" . $current_department)[0];

                        get_internal_project_status_dropdown($current_department, "internal_project_status_" . $current_department, null, "top-buffer-half", $current_value, true);
                        ?>


                        <?php 
                        /*
                        if ($current_user_role != 'sale-sub-contractor') : ?>
                            <div class="form-group top-buffer-half">
                                <label for="project-notes"><?php echo __("Anteckningar för projekt"); ?></label>
                                <textarea class="form-control" rows="5" name="project-notes"
                                          id="project-notes"><?php echo get_post_meta($project->ID, "project-notes")[0]; ?></textarea>
                            </div>
                            <?php endif; */?>
                             <?php
/*                             
// if ($current_user_role == 'sale-sub-contractor') : ?>
                            <div class="form-group top-buffer-half">
                                <label for="project-notes"><?php echo __("UE kommentar"); ?></label>
                                <textarea class="form-control" rows="5"
                                          id="add_comment" name="add_comment"><?php echo get_post_meta($project->ID, "add_ue_comment")[0]; ?></textarea>
                            </div>
                            */?>
                            <hr>
                            <?php include_once('note-comment.php');
                        ?>
                        
                            <?php
                            global $wpdb;
                            $results = $wpdb->get_results("select * from $wpdb->postmeta where meta_key = 'imm-sale_project_connection' and meta_value = '$project->ID'");
                            foreach ($results as $val) {
                                $order_status[] = get_post_meta($val->post_id, 'order_accept_status', true);
                            }
                            $checkStauts = array('true', 'Acceptavkund');
                            if (!array_intersect($checkStauts, $order_status)) {
                                ?>
                                <div class="col-md-12 text-project">

                                    <a href="#" id="delete-project-estimate" data-project-id="<?php echo $_GET['pid']; ?>"
                                       class=""><?php echo __("Ta bort hela projektet och dess innehåll"); ?></a>


                                </div>

                                <?php
                            }
//                            }
//                        endif;
                        ?>
                       
                    </div>
                    <div class="col-lg-8 col-sm-12">
                        <?php if ($current_user_role != 'sale-sub-contractor') : ?>
                            <div class="top-buffer-half">
                                <?php
//TODO: Make better.....
                                global $roles_order_status;

                                $salesman_done_percentage = 0;
                                $internal_project_status_sale_salesman = get_post_meta($project_id, 'internal_project_status_sale-salesman')[0];
                                foreach ($roles_order_status["sale-salesman"] as $key => $value) {
                                    if ($value["internal_status"] == $internal_project_status_sale_salesman) {
                                        $salesman_done_percentage = $value["done"];
                                    }
                                }

                                $economy_done_percentage = 0;
                                $internal_project_status_sale_economy = get_post_meta($project_id, 'internal_project_status_sale-economy')[0];
                                foreach ($roles_order_status["sale-economy"] as $key => $value) {
                                    if ($value["internal_status"] == $internal_project_status_sale_economy) {
                                        $economy_done_percentage = $value["done"];
                                    }
                                }
                                $planning_type = get_post_meta($project->ID, 'planning-type')[0];


                                $project_management_done_percentage = 0;
                                $internal_project_status_sale_project_management = get_post_meta($project_id, 'internal_project_status_sale-project-management')[0];
                                foreach ($roles_order_status["sale-project-management"] as $key => $value) {
                                    if (in_array($planning_type, array("blue", "orange", "green"))) {
                                        if ($value["color"] == $planning_type) {
                                            $project_management_done_percentage = $value["done"];
                                            $internal_project_status_sale_project_management = $value["internal_status"];
                                            $color = $value["color"];
                                        }
                                    } else {
                                        if ($value["internal_status"] == $internal_project_status_sale_project_management) {
                                            $project_management_done_percentage = $value["done"];
                                            $color = $value["color"];
                                        }
                                    }
                                }

                                $technician_done_percentage = 0;
                                $internal_project_status_sale_technician = get_post_meta($project_id, 'internal_project_status_sale-technician')[0];
                                foreach ($roles_order_status["sale-technician"] as $key => $value) {
                                    if ($value["internal_status"] == $internal_project_status_sale_technician) {
                                        $technician_done_percentage = $value["done"];
                                    }
                                }

                                $sub_contractor_done_percentage = 0;
                                $internal_project_status_sale_sub_contractor = get_post_meta($project_id, 'internal_project_status_sub-contractor')[0];
                                foreach ($roles_order_status["sale-sub-contractor"] as $key => $value) {
                                    if ($value["internal_status"] == $internal_project_status_sale_sub_contractor) {
                                        $sub_contractor_done_percentage = $value["done"];
                                    }
                                }
                                ?>

                                <div class="progress">
                                    <div class="progress-bar<?php
                                    if ($current_department == 'sale-salesman') {
                                        echo " progress-bar-active ";
                                    }
                                    ?>" role="progressbar" style="width: <?php echo $salesman_done_percentage; ?>%"
                                         aria-valuenow="<?php echo $salesman_done_percentage; ?>"
                                         aria-valuemin="0" aria-valuemax="100">
                                        <strong><?php echo __("Sälj") ?> - </strong>
                                        <?php echo $internal_project_status_sale_salesman; ?>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar<?php
                                    if ($current_department == 'sale-economy') {
                                        echo " progress-bar-active ";
                                    }
                                    ?>" role="progressbar" style="width: <?php echo $economy_done_percentage; ?>%" aria-valuenow="<?php echo $economy_done_percentage; ?>"
                                         aria-valuemin="0" aria-valuemax="100">
                                        <strong><?php echo __("Ekonomi"); ?> - </strong>
                                        <?php echo $internal_project_status_sale_economy; ?>
                                    </div>
                                </div>

                                <div class="progress">
                                    <div class="progress-bar<?php
                                    if ($current_department == 'sale-project-management') {
                                        echo " progress-bar-active ";
                                    }
                                    ?>" role="progressbar" style="<?php if ($project_management_done_percentage == 33) echo "line-height:12px;"; ?> background-color:<?php echo $color; ?> !important; width: <?php echo $project_management_done_percentage; ?>%" aria-valuenow="<?php echo $project_management_done_percentage; ?>"
                                         aria-valuemin="0" aria-valuemax="100">
                                        <strong><?php echo __("Projektplanering"); ?> - 									<?php echo $internal_project_status_sale_project_management; ?></strong>

                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar<?php
                                    if ($current_department == 'sale-technician') {
                                        echo " progress-bar-active ";
                                    }
                                    ?>" role="progressbar" style="width: <?php echo $technician_done_percentage; ?>%" aria-valuenow="<?php echo $technician_done_percentage; ?>"
                                         aria-valuemin="0" aria-valuemax="100">
                                        <strong><?php echo __("Tekniker"); ?> - </strong>
                                        <?php echo $internal_project_status_sale_technician; ?>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar<?php
                                    if ($current_department == 'sale-sub-contractor') {
                                        echo " progress-bar-active ";
                                    }
                                    ?>" role="progressbar" style="width: <?php echo $sub_contractor_done_percentage; ?>%" aria-valuenow="<?php echo $sub_contractor_done_percentage; ?>"
                                         aria-valuemin="0" aria-valuemax="100">
                                        <strong><?php echo __("Underentreprenör"); ?> - </strong>
                                        <?php echo $internal_project_status_sale_sub_contractor; ?>
                                    </div>
                                </div>

                                <hr>
                            </div>
                        <?php endif; ?>

                        <div class="top-buffer-half" id="invoices">
                            <?php
                            if ($current_user_role != 'sale-sub-contractor') {
                                include( 'template-parts/project-single-invoices.php' );
                            }
                            ?>

<?php include( 'template-parts/project-single-orders.php' ); ?>
                            <hr>
                        </div>
                        <!--<div class="top-buffer-half" id="orders">
<?php //include( 'template-parts/project-single-orders.php' );  ?>
                                                
                            <hr>
                        </div>!-->
                            <?php if ($current_user_role != 'sale-sub-contractor') : ?>
                            <div class="top-buffer-half"  id="prepayment-invoices">
                                <?php include( 'template-parts/project-single-prepayment_invoices.php' ); ?>
    <?php include( 'template-parts/project-external-invoices.php' ); ?>
                                <hr>
                            </div>
<?php endif; ?>

                        <!--<div class="top-buffer-half" style="display: none;" id="external-invoices">
<?php //include( 'template-parts/project-external-invoices.php' );  ?>
                            <hr>
                        </div>!-->
                        <div class="top-buffer-half" id="dates">
                            <h4><strong>Planering</strong></h4>
                            <div class="col-md-12">
                                <label class="top-buffer-half"
                                       for="assigned-subcontractor-select"><?php echo __("Välj underentreprenör för planering") ?></label>
                                       <?php
                                       $args = array(
                                           'role__in' => array(
                                               'sale-sub-contractor',
                                           )
                                       );
                                       $users = get_users($args);
                                       $current_assigned_subcontractor = get_post_meta($project->ID, "assigned-subcontractor-select")[0];
                                       ?>

                                <select class="form-control js-sortable-select" id="assigned-subcontractor-select"
                                        name="assigned-subcontractor-select">
                                    <option value=""><?php echo __("Ingen användare vald"); ?></option>
                                    <?php
                                    foreach ($users as $user) :
                                        $curren_user_id = get_current_user_id();
                                        $current_user_company_name = get_user_meta($curren_user_id, 'sale-sub-contractor_company', true);
                                        $comapny_name = get_user_meta($user->ID, 'sale-sub-contractor_company', true);
                                        if ($current_user_role == 'sale-sub-contractor') {
                                            if ($current_user_company_name == $comapny_name) {
                                                ?>
                                                <option value="<?php echo $user->ID ?>"><?php echo showName($user->ID) . " " . get_user_meta($user->ID, 'sale-sub-contractor_shortname', true) ?></option>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <option value="<?php echo $user->ID ?>"><?php echo showName($user->ID) . " " . get_user_meta($user->ID, 'sale-sub-contractor_shortname', true) ?></option> 
    <?php }
    ?>


<?php endforeach; ?>
                                </select>


                                <?php
                                $checkbox_value = get_field('assigned-subcontractor-checkbox', $project->ID);
                                if ($checkbox_value === '1') {
                                    echo '<input type="checkbox" name="assigned-subcontractor-checkbox" id="assigned-subcontractor-checkbox" checked>';
                                } else {
                                    echo '<input type="checkbox" name="assigned-subcontractor-checkbox" id="assigned-subcontractor-checkbox" checked> ';
                                }
                                ?>


                                <label class="top-buffer-half"
                                       for="assigned-subcontractor-checkbox"><?php echo __("Synlig till underentreprenör") ?></label>
                            </div>    



                            <div class="col-md-4 top-buffer-half">
                                <label for="work-date-from"><?php echo __("Välj planeringstyp"); ?></label>
                                <select class="form-control js-sortable-select" id="planning-type"
                                        name="planning-type">
                                    <option value="">Välj typ</option>
                                    <option value="orange">Preliminär
                                    </option>                               
                                    <option value="blue">Grov
                                    </option>

                                    <option value="green">Definitiv
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label class="top-buffer-half"
                                       for="planning_note"><?php echo __("Kommentar") ?></label>
                                <textarea class="planning_note_calender" id="planning_note" name="planning_note"></textarea>
                            </div>
                            <div style="margin-top:15px">
                                <div class="col-md-6">
                                    <label class="top-buffer-half"
                                           for="work-date-from"><?php echo __("Välj aktivitetsdatum fr.o.m") ?></label>
                                    <input name="work-date-from" id="work-date-from" type='date' class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    <label class="top-buffer-half"
                                           for="work-date-to"><?php echo __("T.o.m") ?></label>
                                    <input type='date' name="work-date-to" id="work-date-to" class="form-control"/>
                                </div>
                            </div>

                            <div class="col-md-12">

                                <input type="submit" value="<?php echo __("Spara och uppdatera projekt");   ?>" class="btn-brand top-buffer-half">
                            </div>			   


                                <table class="table" style="float:left;margin-top:15px">
                                    <thead>
                                        <tr>
                                            <th><?php echo __("Planeringstyp"); ?></th>
                                            <th><?php echo __("Datum"); ?></th>
                                            <th><?php echo __("Användare"); ?></th>
                                            <th><?php echo __("Kommentar"); ?></th>
                                            <th></th>
                                            <th></th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        global $wpdb;
                                        $table = $wpdb->prefix . 'project_calender';
                                        $projectQuery = $wpdb->get_results("select * from $table where project_id = $project->ID");
                                        foreach ($projectQuery as $valProject) {
                                            global $current_user;

//                                                                          echo"<pre>";
//                                                                          print_r($valProject->work_date_from);die;

                                            $calender_id = $valProject->id;
                                            $date_from = $valProject->work_date_from;
                                            $date_to = $valProject->work_date_to;
                                            //$date_to = date('Y-m-d ', strtotime($valProject->work_date_to . ' +1 day'));
                                            $planning_note = $valProject->planning_note;
                                            $assignedsubcontractorselect = $valProject->assigned_subcontractor_select;
                                            $customer_name = showName($assignedsubcontractorselect);
                                            $planning_type = $valProject->planning_type;
                                            $current_user_company_name = get_user_meta($current_user->ID, 'sale-sub-contractor_company', true);
                                            $comapny_name = get_user_meta($assignedsubcontractorselect, 'sale-sub-contractor_company', true);
                                            if ($planning_type == 'orange') {
                                                $varPlanningtype = 'Preliminär';
                                                $background_color = '#ffbb3f';
                                            } elseif ($planning_type == 'blue') {
                                                $varPlanningtype = 'Grov';
                                                $background_color = '#3f3fff';
                                            } else {
                                                $varPlanningtype = 'Definitiv';
                                                $background_color = '#3fa03f';
                                            }
                                            if ($current_user_role == 'sale-sub-contractor') {
                                                if ($current_user_company_name == $comapny_name) {
                                                    if (!empty($planning_type)) {
                                                        ?>
                                                        <tr id="<?php echo $calender_id; ?>">
                                                            <td><span class="plan-color" style="background-color:<?php echo $background_color?>;color:aliceblue;padding:4px;"><?php echo $varPlanningtype; ?></span></td>
                                                            <td><?php echo $date_from . ' - ' . $date_to; ?></td>
                                                            <td><?php echo $customer_name ?></td>
                                                            <td><?php echo $planning_note; ?></td>
                                                            <td>

                                                                <a class="b-settings toggle-calender-modal" data-calender-id="<?php echo $calender_id; ?>" href="#"  ><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                            </td>
                                                            <td>
                                                                <a href="#" data-calender-id="<?php echo $calender_id; ?>"  id="removecalender" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>



                                                    <?php
                                                    }
                                                }
                                            } else {
                                                if (!empty($planning_type)) {
                                                    ?>
                                                    <tr id="<?php echo $calender_id; ?>">
                                                        <td><span class="plan-color" style="background-color:<?php echo $background_color?>;color:aliceblue;padding:4px;"><?php echo $varPlanningtype; ?></span></td>
                                                        <td><?php echo $date_from . ' - ' . $date_to; ?></td>
                                                        <td><?php echo $customer_name; ?></td>
                                                        <td><?php echo $planning_note; ?></td>
                                                        <td>

                                                            <a class="b-settings toggle-calender-modal" data-calender-id="<?php echo $calender_id; ?>" href="#"  ><i class="fa fa-edit" aria-hidden="true"></i></a>
                                                        </td>
                                                        <td>
                                                            <a href="#" data-calender-id="<?php echo $calender_id; ?>"  id="removecalender" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>

                            <div class="col-md-12">
                                <h4><strong>Aktuell planeringskalender</strong></h4>
                            </div>

                            <div id="work-planning-project-calendar" class="top-buffer-half">

                                <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-12">
<?php get_tech_sub_dropdown("order_calendar_by_user"); ?>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-12">
<?php get_office_dropdown("order_calendar_by_office"); ?>
                                    </div>

                                </div>
                                <div class="top-buffer project-cal" id='work-planning-calendar-cal' ></div>
                            </div>


                        </div>
                        <div class="top-buffer-half" id="checklists">
                            <input type="checkbox" id="show_Completetodo"  /><?php echo __("Visa åtgärdade uppgifter"); ?>
                            <table class="table">
<?php $table_name = "todo-modal"; ?>
                                <thead>
                                    <tr>
                                        <th class="sortable"
                                            onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Åtgärdsdatum"); ?></th>
                                        <th class="sortable"
                                            onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Status"); ?></th>

                                        <th class="sortable"
                                            onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Avdelning") ?></th>
                                        <th class="sortable"
                                            onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Notering") ?></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="<?php echo $table_name ?>">
                                    <?php
                                    if ($current_user_role == 'sale-sub-contractor') {
                                        $args = [
                                            'posts_per_page' => - 1,
                                            'meta_key' => 'todo_action_date',
                                            'orderby' => 'ID',
                                            'order' => 'desc',
                                            'post_type' => 'imm-sale-todo',
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'todo_project_connection',
                                                    'value' => $project->ID,
                                                    'compare' => '=',
                                                ),
                                                array('key' => 'todo_assigned_department',
                                                    'value' => 'sale-sub-contractor',
                                                    'compare' => '=')
                                            )
                                        ];
                                    } else {
                                        $args = [
                                            'posts_per_page' => - 1,
                                            'meta_key' => 'todo_action_date',
                                            'orderby' => 'ID',
                                            'order' => 'desc',
                                            'post_type' => 'imm-sale-todo',
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'todo_project_connection',
                                                    'value' => $project->ID,
                                                    'compare' => '=',
                                                )
                                            )
                                        ];
                                    }

                                    return_todo_table($args, false, 'edit_project');
                                    ?>
                                </tbody>
                            </table>
                            <hr>
                        </div>
                        <div class="top-buffer-half" id="all_files_project" style="display: block;">

                            <h3>Ladda upp dokument För internt bruk</h3>
                            <div class = "col-md-6 upload-form-project-files">
                                <div class= "upload-response"></div>
                                <div class = "form-group">
                                    <label><?php __('Välj filer:', 'cvf-upload'); ?></label>
                                    <input type = "file" name = "files[]" accept = "" class = "files-data form-control" multiple />
                                </div>
                                <div class = "form-group">
                                    <input type = "submit" value = "Ladda upp" class = "btn btn-brand btn-block top-buffer-half btn-upload" disabled/>
                                </div>
                            </div>

                            <table class="table">
<?php $table_name = "todo-project_files"; ?>
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
                                    $i = 1;
                                    if (have_rows('filer_project', $project->ID)):

                                        // loop through the rows of data
                                        while (have_rows('filer_project', $project->ID)) : the_row();

                                            // display a sub field value
                                            $namn = get_sub_field('namn');
                                            $url = get_sub_field('url');
                                            echo '<tr data_row="' . $i . '"><td>' . $namn . '</td><td><a href="' . $url . '" class="project_file_url" download>Ladda ner</a></td><td data_row="' . $i . '" class="tabort_repeater_row" data_url="' . $url . '"><a href="#"  >Ta bort</a></td></tr>';
                                            $i++;
                                        endwhile;



                                    endif;
                                    ?>
                                </tbody>
                            </table>
                            <hr>


                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    include( "dashboard/dashboard-modal.php" );
    include( "dashboard/dashboard-mail-project.php" );
    include( "dashboard/dashboard-calender-modal.php" );
    include( "dashboard/prepayment-invoice-modal.php" );
    include( "dashboard/dashboard-mail-project_preview.php" );
	include( "dashboard/estimate_editable.php" );	
	include( "dashboard/importExcel.php" ); 
	include( "dashboard/sms_editable.php" ); 
    ?>
    <script>
        jQuery(function() {
            var work_date_from = jQuery('#work-date-from').val();
            var work_date_to = jQuery('#work-date-to').val();
            jQuery("#work-date-from").datepicker();
            jQuery("#work-date-to").datepicker();
            jQuery("#work-date-from").on('change', function() {
                if (work_date_from != '') {
                    alert('Användaren har redan planerade aktiviteter detta datum.');
                }

            });
            jQuery("#work-date-to").on('change', function() {
                if (work_date_to != '') {
                    alert('Användaren har redan planerade aktiviteter detta datum.');
                }
            });
        });

    </script>
<?php 
include_once('popup.php');
wp_footer(); ?>
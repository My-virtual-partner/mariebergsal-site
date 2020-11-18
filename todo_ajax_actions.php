<?php

function get_todo_status_dropdown($dropdown_id, $data_table = null, $label_class = null) {


    $html = "";
    $html .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Ej avklarade / Avklarade") . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control filter_todo_tab'
                      id='" . $dropdown_id . "'>";
//    if (current_user_can('sale-economy')) {
//
//        $html .= "
//        <option value='1' selectd>" . __("Avklarade") . "</option>
//        <option  value='0' >" . __("Ej avklarade") . "</option>
//      
//        ";
//    } else {

    $html .= "
        <option  value='0' selectd>" . __("Ej avklarade") . "</option>
        <option value='1'>" . __("Avklarade") . "</option>
        ";
//    }





    $html .= "</select>";
    echo $html;
}

function filter_and_return_todos() {
    global $current_user;
    global $roles_order_status;
    $current_user_role = get_user_role();
    $todo_status = $_POST["todo_status"];
    $number_of_posts = $_POST["number_of_posts"];
    $crntstatus = $_POST['crntstatus'];
//    $from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["from_date"]))));
//    $from_date = date('Y-m-d', strtotime($_POST["from_date"]));
//    $to_date = date('Y-m-d', strtotime($_POST["to_date"]));
//    echo $from_date;
    $from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["from_date"]))));
    $to_dates = DateTime::createFromFormat('Y-m-d', $_POST["to_date"]);

    if ($to_dates !== FALSE) {
        $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["to_date"]))));
    } else {
        $to_date = date("Y-m-d", strtotime("tomorrow"));
    }

    $roles = $_POST['roles'];

//    $to_dates = DateTime::createFromFormat('Y-m-d', $_POST["to_date"]);
//
//    if ($to_dates !== FALSE) {
//        $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["to_date"]))));
//    } else {
//        $to_date = date("Y-m-d", strtotime("tomorrow"));
//    }

    $today = date('Y-m-d');

    $mine_all = $_POST['mine_all'];
    $user_mottagare = $_POST['user_mottagare'];
    $department = $_POST['department'];
    if ($mine_all == 'alla') {
       if ($current_user_role != 'sale-sub-contractor') {
            $mine_all_array = return_users_id_as_array('sale-salesman', 'sale-administrator', 'sale-economy', 'sale-technician', 'sale-project-management', 'sale-sub-contractor');
        } else {
            $mine_all_array = return_users_id_as_array('sale-sub-contractor');
        }
        $none_users = array(intval(0));
        $mine_all_value = array_merge($mine_all_array, $none_users);
    } else {
        $mine_all_value = $mine_all;
    }


    if ($user_mottagare == 'alla') {
         if ($current_user_role != 'sale-sub-contractor') {
            $user_mottagare_array = return_users_id_as_array('sale-salesman', 'sale-administrator', 'sale-economy', 'sale-technician', 'sale-project-management', 'sale-sub-contractor');
        } else {
//            $user_mottagare_array = return_users_id_as_array('sale-sub-contractor');
            
            $curren_user_id = get_current_user_id();
            $all_user_mottagare_array = return_users_id_as_array('sale-sub-contractor');
            
             foreach ($all_user_mottagare_array as $user) {
                $current_user_company_name = get_user_meta($curren_user_id, 'sale-sub-contractor_company', true);
                $comapny_name = get_user_meta($user, 'sale-sub-contractor_company', true);
                if ($current_user_company_name == $comapny_name) {

                    $user_mottagare_array[]= $user;
                }
             }
            
            
        }
        $no_users = array(intval(0));
        $user_mottagare_all_value = array_merge($user_mottagare_array, $no_users);
    } else {
        $user_mottagare_all_value = $user_mottagare;
    }


//print_r($user_mottagare_all_value);die;
    $internal_status_array = array();

    if ($department === 'alla') {
       if ($current_user_role != 'sale-sub-contractor') {
            $current_department_value = array(
                'sale-salesman', 'sale-economy', 'sale-project-management', 'sale-sub-contractor', 'sale-administrator', ''
            );
        } else {
            $current_department_value = array(
                'sale-sub-contractor', ''
            );
        }
        $departments = $roles;
    } else {
        $current_department_value = $department;
    }

    $loggedin_id = get_current_user_id();
//    echo $loggedin_id;


    $args = [
        'posts_per_page' => $number_of_posts,
        'orderby' => 'date',
        'meta_key' => 'todo_action_date',
        'order' => 'DESC',
        'post_type' => 'imm-sale-todo',
        'meta_query' => array(
            array(
                'key' => 'todo_status',
                'value' => $todo_status,
            ),
//            array(
//                'key' => 'todo_received_user',
//                'value' => $user_mottagare_all_value,
//                'compare' => 'IN',
//            ),
//             array(
//                        'key' => 'todo_assigned_user',
//                        'value' => $mine_all_value,
//                        'compare' => 'IN',
//                    ),
            array(
                'key' => 'todo_assigned_department',
                'value' => $current_department_value,
            ),
            array(
                'key' => 'todo_action_date',
                'value' => $from_date,
                'compare' => '>=',
            ),
            array(
                'key' => 'todo_action_date',
                'value' => $to_date,
                'compare' => '<=',
            )
        ),
//        'date_query' => array(
//            array(
//                'after' => $from_date,
//                'before' => $to_date,
//            ),
//        ),
    ];
//    if ($loggedin_id == $mine_all_value) {
//        //echo'yes';
//        $args['meta_query'] = array(
//            'key' => 'todo_received_user',
//            'value' => $loggedin_id,
//            'compare' => '=',
//        );
//    }

    /*  */
    if (!empty($crntstatus)) {
        if ($department == 'alla') {
            if ($crntstatus != 'Alla') {
                array_push($args['meta_query'], array(
                    "key" => "internal_project_status_" . $departments,
                    "value" => $crntstatus,
                ));
            }
        } elseif ($crntstatus != 'Alla') {
            array_push($args['meta_query'], array(
                "key" => "internal_project_status_" . $current_department_value,
                "value" => $crntstatus,
            ));
        }
    }


    if ($mine_all != 'alla') {
        array_push($args['meta_query'], array(
            "key" => "todo_assigned_user",
            "value" => $mine_all_value,
            'compare' => 'IN',
        ));
    }
 if ($user_mottagare != 'alla') {
        array_push($args['meta_query'], array(
            "key" => "todo_received_user",
            "value" => $user_mottagare_all_value,
            'compare' => 'IN',
        ));
    }
    else{
        if ($current_user_role == 'sale-sub-contractor') {
            array_push($args['meta_query'], array(
            "key" => "todo_received_user",
           "value" => $user_mottagare_all_value,
            'compare' => 'IN',
        ));
        }
    }
//         $products = new WP_Query($args);

// echo "<pre>";print_r($products); die;
    return_todo_table($args, 'todo_table', '', $current_department_value);

    wp_reset_query();


    die();
}
function return_todo_modal_content() {
    $todo_id = $_POST["todo_id"];
    $todo_action_date = get_field('todo_action_date', $todo_id);
    $todo_status = get_field('todo_status', $todo_id);
    $todo_project_connection = get_field('todo_project_connection', $todo_id);
    $todo_entry = get_post_meta($todo_id, 'post_content', true);
    $todo_assigned_department = get_field('todo_assigned_department', $todo_id);
    $todo_assigned_user = get_field('todo_assigned_user', $todo_id);
    $todo_assigned_user_mottagare = get_field('todo_received_user', $todo_id);
    if (isset($_POST["project_id"])) {
        $todo_project_connection = $_POST["project_id"];
    }

    $args = [
        'posts_per_page' => -1,
        'post_type' => 'imm-sale-project',
    ];
    $projects = new WP_Query($args);

     $order_args = array(
            'orderby' => 'ID',
            'post_type' => wc_get_order_types(),
            'post_status' => array('wc-processing', 'wc-pending', 'wc-on-hold', 'wc-completed', 'wc-refunded', 'wc-cancelled'),
            'posts_per_page' => - 1,
        );
     
      $orders = new WP_Query($order_args);
      
    
    global $current_user;
    
    $current_user_role = get_user_role();
//    if ($current_user_role == 'sale-sub-contractor') {
//        $args = array(
//            'role__in' => array(
//                'sale-sub-contractor'
//            )
//        );
//    } else {
        $args = array(
            'role__in' => array(
                'sale-salesman',
                'sale-administrator',
                'sale-economy',
                'sale-technician',
                'sale-project-management',
                'sale-sub-contractor'
            )
        );
//    }

    $users = get_users($args);
    $checked_departmnt = array($todo_assigned_department, $current_user->roles[0]);
    ?>
    <div class="row">
        <form action="" method="post">
            <input type="hidden" value="<?php echo $todo_id ?>" name="todo_id">
            <input type="hidden" value="true" name="todo_handle">
            <input type="hidden" value="" name="department_val">
            <input type="hidden" value="" id="selected_user_value">

            <div class=" col-lg-6 col-md-6">
                <label class="top-buffer-half"
                       for="todo_action_date"><?php echo __("Åtgärdsdatum"); ?> </label>
                <input type="date" value="<?php if (!empty($todo_action_date)) {
        echo $todo_action_date;
    } else {
        echo date('Y-m-d');
    } ?>" class="form-control"
                       name="todo_action_date" id="todo_action_date">
            </div>

            <div class=" col-lg-6 col-md-6">
                <label class="top-buffer-half" for="todo_status"><?php echo __("Status"); ?> </label>

                <select class="form-control js-sortable-select" name="todo_status" id="todo_status">
                    <option value="1" <?php
                if ($todo_status) {
                    echo " selected ";
                }
    ?>><?php echo __("Avklarad"); ?></option>
                    <option value="0"<?php
                if (!$todo_status) {
                    echo " selected ";
                }
                ?>><?php echo __("Ej avklarad"); ?></option>

                </select>
            </div>

            <div class=" col-lg-6 col-md-6">
                <label class="top-buffer-half"
                       for="todo_assigned_department"><?php echo __("Avdelning"); ?> </label>
                <select class="form-control js-sortable-select todo-assigned-department" name="todo_assigned_department"
                        id="todo_assigned_department">
                    <?php // if ($current_user_role != 'sale-sub-contractor') {?>
                    <option value="alla"><?php echo __("Alla"); ?></option>
                    
                    <option <?php
                    if ($todo_assigned_department == "sale-administrator") {
                        echo " selected ";
                    }
//                elseif ($current_user->roles[0] == "sale-administrator") {
//                    echo " selected ";
//                }
                    ?> value="sale-administrator"><?php echo __("Administratör"); ?></option>

                    <option <?php
                    if ($todo_assigned_department == "sale-salesman") {
                        echo " selected ";
                    }
//                elseif ($current_user->roles[0] == "sale-salesman") {
//                    echo " selected ";
//                }
                    ?> value="sale-salesman"><?php echo __("Sälj"); ?></option>

                    <option <?php
                    if ($todo_assigned_department == "sale-economy") {
                        echo " selected ";
                    }
//                elseif ($current_user->roles[0] == "sale-economy") {
//                    echo " selected ";
//                }
                    ?> value="sale-economy"><?php echo __("Ekonomi"); ?></option>

                    <option <?php
                    if ($todo_assigned_department == "sale-technician") {
                        echo " selected ";
                    }
//                elseif ($current_user->roles[0] == "sale-technician") {
//                    echo " selected ";
//                }
                    ?> value="sale-technician"><?php echo __("Tekniker"); ?></option>

                    <option <?php
                    if ($todo_assigned_department == "sale-project-management") {
                        echo " selected ";
                    }
//                elseif ($current_user->roles[0] == "sale-project-management") {
//                    echo " selected ";
//                }
                    ?> value="sale-project-management"><?php echo __("Projektplanering"); ?></option>

                    <option <?php
                    if ($todo_assigned_department == "sale-sub-contractor") {
                        echo " selected ";
                    }
//                elseif ($current_user->roles[0] == "sale-sub-contractor") {
//                    echo " selected ";
//                }
                    ?> value="sale-sub-contractor"><?php echo __("Underentreprenör"); ?></option>
                    <?php /*}else{ ?>
<option <?php
                    if ($todo_assigned_department == "sale-sub-contractor") {
                        echo " selected ";
                    }
//                elseif ($current_user->roles[0] == "sale-sub-contractor") {
//                    echo " selected ";
//                }
                    ?> value="sale-sub-contractor"><?php echo __("Underentreprenör"); ?></option>
                    <?php }*/ ?>
                </select>

            </div>
    
            <?php
            if ($current_user->ID != $todo_assigned_user && !empty($todo_assigned_user)) {
                $disabled = 'disabled';
            }
            ?>
            <div class=" col-lg-6 col-md-6 ">
                <label class="top-buffer-half"
                       for="todo_assigned_user"><?php echo __("Avsändare"); ?> </label>

                <select class="form-control js-sortable-select" name="todo_assigned_user"
                        id="todo_assigned_user" <?php echo $disabled; ?>>
                    <option value="alla"><?php echo __("Alla"); ?></option>



                    <?php
                    foreach ($users as $user) :
                        $current_user_company_name = get_user_meta($current_user->ID, 'sale-sub-contractor_company', true);
                        $comapny_name = get_user_meta($user->ID, 'sale-sub-contractor_company', true);?>
                        <?php /*if ($current_user_role == 'sale-sub-contractor') {
//                            if ($current_user_company_name == $comapny_name) {
                                ?>
                                <option <?php
//                        echo $todo_assigned_user;die;
                                if ($todo_assigned_user == $user->ID && !empty($todo_assigned_user)) {

                                    echo " selected ";
                                } elseif ($current_user->ID == $user->ID && empty($todo_assigned_user)) {
                                    echo " selected ";
                                }
//                        
                                ?> value="<?php echo $user->ID ?>" data_roll='<?php
                                    $user_info = get_userdata($user->ID);
                                    echo implode(', ', $user_info->roles)
                                    ?>'><?php echo showName($user->ID); ?></option>

                            <?php // }
                        } else {
                            */?> 
                         <option <?php
                         
//                        echo $todo_assigned_user;die;
                            if ($todo_assigned_user == $user->ID && !empty($todo_assigned_user)) {

                                echo " selected ";
                            } elseif ($current_user->ID == $user->ID && empty($todo_assigned_user)) {
                                echo " selected ";
                            }
//                        
                            ?> value="<?php echo $user->ID ?>" data_roll='<?php
                    $user_info = get_userdata($user->ID);
                    echo implode(', ', $user_info->roles)
                    ?>'><?php echo showName($user->ID); ?></option> <?php // } 
                    endforeach; ?>
                </select>

            </div>


            <?php $received_user = get_post_meta($todo_project_connection, "assigned-technician-select")[0];
    ?>
            <div class=" col-lg-6 col-md-6 ">
                <label class="top-buffer-half"
                       for="todo_assigned_user"><?php echo __("Mottagare"); ?> </label>

                <select class="" name="todo_assigned__user_hidden"
                        id="todo_assigned__user_hidden" style="display: none">


                    <option value="alla"><?php echo __("Alla"); ?></option>



                    <?php
                    foreach ($users as $user) :

                        $current_user_company_name = get_user_meta($current_user->ID, 'sale-sub-contractor_company', true);
                        $comapny_name = get_user_meta($user->ID, 'sale-sub-contractor_company', true);?>
                       <?php/* if ($current_user_role == 'sale-sub-contractor') {
//                            if ($current_user_company_name == $comapny_name) {
                                ?>

                                <option <?php
                                if ($todo_assigned_user_mottagare == $user->ID) {
                                    echo " selected ";
                                }
//                        elseif ($received_user == $user->ID) {
////                            echo'yes1';
//                         echo " selected";
//                         }
                                ?> value="<?php echo $user->ID ?>" data_roll='<?php
                                    $user_info = get_userdata($user->ID);
                                    echo implode(', ', $user_info->roles)
                                    ?>'><?php echo showName($user->ID); ?></option>
                                <?php 
//                                }
                            } else {
                                */?>




                            <option <?php
                            if ($todo_assigned_user_mottagare == $user->ID) {
                                echo " selected ";
                            }
//                        elseif ($received_user == $user->ID) {
////                            echo'yes1';
//                         echo " selected";
//                         }
                            ?> value="<?php echo $user->ID ?>" data_roll='<?php
                                $user_info = get_userdata($user->ID);
                                echo implode(', ', $user_info->roles)
                                ?>'><?php echo showName($user->ID); ?></option>

        <?php // }
        endforeach; ?>
                </select>


                <select class="form-control js-sortable-select todo_assigned_user_mottagare" name="todo_assigned_user_mottagare"
                        id="todo_assigned__user">
                    <option value="alla"><?php echo __("Alla"); ?></option>



                    <?php
                    foreach ($users as $user) :
                        $current_user_company_name = get_user_meta($current_user->ID, 'sale-sub-contractor_company', true);
                        $comapny_name = get_user_meta($user->ID, 'sale-sub-contractor_company', true);?>
                    
                    <?php/*    if ($current_user_role == 'sale-sub-contractor') {
//                            if ($current_user_company_name == $comapny_name) {
                                ?>
                                <option <?php
                                if ($todo_assigned_user_mottagare == $user->ID) {
                                    echo " selected ";
                                }
//                        elseif ($received_user == $user->ID) {
////                            echo'yes1';
//                         echo " selected";
//                         }
                                ?> value="<?php echo $user->ID ?>" data_roll='<?php
                                    $user_info = get_userdata($user->ID);
                                    echo implode(', ', $user_info->roles)
                                    ?>'><?php echo showName($user->ID); ?></option>

                            <?php // }
                        } else {
                            */?> 
                     <option <?php
                     
                            if ($todo_assigned_user_mottagare == $user->ID) {
                                echo " selected ";
                            }
//                        elseif ($received_user == $user->ID) {
////                            echo'yes1';
//                         echo " selected";
//                         }
                            ?> value="<?php echo $user->ID ?>" data_roll='<?php
                                $user_info = get_userdata($user->ID);
                                echo implode(', ', $user_info->roles)
                                ?>'><?php echo showName($user->ID); ?></option>
        <?php // }
        endforeach; ?>
                </select>

            </div>

            <div class=" col-lg-6 col-md-6">
                <label class="top-buffer-half"
                       for="todo_project_connection"><?php echo __("Projekt"); ?> </label>
                       <?php
                       if ($current_user_role == 'sale-sub-contractor') {
                           $get_custid = get_field('invoice_customer_id', $todo_project_connection);
                           if ($todo_assigned_department == 'sale-sub-contractor') {
                               ?>
                        <input type="hidden" name="todo_project_connection" id="todo_project_connection" value="<?php echo $todo_project_connection ?>">
                        <br><a href="/project?pid=<?php echo $todo_project_connection; ?>" target="_blank"><?php echo $todo_project_connection . ' ' . showName($get_custid); ?></a>
        <?php } else { ?>


                        <select class="form-control js-sortable-select" name="todo_project_connection"
                                id="todo_project_connection">
                            <option value=""><?php echo __("Inget värde valt"); ?></option>
                            <?php
							 $comapny_name = get_user_meta($current_user->ID, 'sale-sub-contractor_company', true);
						global $wpdb;
							$available_drivers = get_users(
            array(
                'role' => 'sale-sub-contractor',
                'meta_query' => array(
                    array(
                        'key' => 'sale-sub-contractor_company',
                        'value' => $comapny_name,
                        'compare' => '=='
                    )
                   
                )
            )
        );
						 
                                            foreach ($available_drivers as $user){
                           	 $sql = "select * from {$wpdb->prefix}Projects_Search where responsible_salesman = '".$user->ID."' AND order_accept = 1"; 
							$newdata = $wpdb->get_results($sql);
							 foreach($newdata as $getData){
                                                             $customer_name=showName($getData->responsible_salesman);
								 $number = explode('-',$getData->customer_number);
								 ?>

                            <option <?php

                            ?> value="<?php echo $number[1]; ?>"><?php echo $user->ID."-".$number[1] . '-' . $customer_name; ?></option>
<?php
                                                         }
                            ?>

                         

                            <?php
                             



							 } 
                            
                            ?>

                        </select>
                        <?php
                    }
                } else {

                    if (!empty($todo_project_connection)) {
                        $get_custid = get_field('invoice_customer_id', $todo_project_connection);
                        ?>
                        <input type="hidden" name="todo_project_connection" id="todo_project_connection" value="<?php echo $todo_project_connection ?>">
                        <br><a href="/project?pid=<?php echo $todo_project_connection; ?>" target="_blank"><?php echo $todo_project_connection . ' ' . showName($get_custid); ?></a>
        <?php } else { ?>
                        <select class="form-control js-sortable-select" name="todo_project_connection"
                                id="todo_project_connection">
                            <option value=""><?php echo __("Inget värde valt"); ?></option>
                            <?php
                            while ($projects->have_posts()) : $projects->the_post();

                                $project_id = get_the_ID();
                                $get_custid = get_field('invoice_customer_id', $todo_project_connection);
                                $custom_project_number = get_post_meta($project_id, 'custom_project_number')[0];
                                ?>

                                <option <?php
                                if ($project_id == $todo_project_connection) {
                                    echo " selected ";
                                }
                                ?> value="<?php echo $project_id; ?>"><?php echo $custom_project_number . '-' . showName($get_custid); ?></option>

                                <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>

                        </select>
        <?php }
    }
    ?>

            </div>

<!--            <div class=" col-lg-6 col-md-6 top-buffer-half">
                <a class="till_project_link_class" href="" target="_blank"
                   style="color:#333333; display: none;"><?php // echo __("Till projektet  >>"); ?></a>

            </div>-->


            <div class=" col-lg-12 col-md-12">
                <label class="top-buffer-half"
                       for="todo_entry"><?php echo __("Notering"); ?> </label>

                <textarea class="form-control" rows="5" name="todo_entry"
                          id="todo_entry"><?php echo $todo_entry; ?></textarea>
            </div>
            <div class=" col-lg-12 col-md-12">
                <button type="submit" onclick="closeModalAndSendFormUsers();"

                        class="btn btn-brand btn-block top-buffer">
    <?php echo __("Spara") ?>
                </button>
            </div>

        </form>
    </div>
    <div class="row" style="position:absolute; bottom:0px;">
        <div class=" col-lg-12 col-md-12 " style="text-align:left" >
            <input type="checkbox" id="completed_task" <?php if ($todo_status == '1') echo "checked"; ?>  /> <?php echo __("Avklarad"); ?> </div>
    </div>
    <?php
    die;
}

function return_todo_table($args, $compact_table = false, $edit_project = false, $depart = false) {
//    echo $compact_table;
    $order_accept_status = get_field('order_accept_status');
    global $roles_order_status;

    $todos = new WP_Query($args);
    // echo "<pre>"; print_r( $todos);
    $i = 1;
    while ($todos->have_posts()) : $todos->the_post();

        $todo_id = get_the_ID();
        $todo_action_date = get_field('todo_action_date');
        $todo_status = get_field('todo_status');
        $todo_project_connection = get_post_meta($todo_id,'todo_project_connection',true);
		$newProjectId = $todo_project_connection;
        $todo_entry = get_post_meta(get_the_ID(), 'post_content', true);
        $todo_assigned_department = get_field('todo_assigned_department');
        $todo_assigned_user = get_field('todo_assigned_user');
        $todo_received_user = get_field('todo_received_user');
        $note_status = get_field('note_status');
        $get_custid = get_field('invoice_customer_id', $todo_project_connection);
//        echo $get_custid;
//        echo $todo_assigned_department;
//        echo $note_status;

        $userid = get_post_meta($todo_project_connection, 'assigned-technician-select', true);
        $salesman = get_userdata($todo_received_user);
        $sender = get_userdata($todo_assigned_user);

        $style = "";
        $days_since = "";

        if ($todo_status == false && $todo_action_date < date('Y-m-d')) {
            $style = "color: red;";

            $date1 = new DateTime($todo_action_date);
            $date2 = new DateTime(date('Y-m-d'));

            $diff = $date2->diff($date1)->format("%a");
//            echo $diff;
            if ($diff == 1) {
                $days_since = " [ " . $diff . __(" dag försenad") . " ] ";
            } else {
                $days_since = " [ " . $diff . __(" dagar försenad") . " ] ";
            }
        }
        $argss = array(
            'orderby' => 'ID',
            'post_type' => wc_get_order_types(),
            'post_status' => array('wc-processing', 'wc-pending', 'wc-on-hold', 'wc-completed', 'wc-refunded', 'wc-cancelled'),
            'posts_per_page' => - 1,
            'meta_query' => array(
                array(
                    'key' => 'imm-sale_project_connection',
                    'value' => $todo_project_connection,
                    'compare' => '='
                ),
                array(
                    'key' => 'imm-sale_prepayment_invoice',
                    'compare' => 'NOT EXISTS'
                ),
            )
        );

        $orders = new WP_Query($argss);
//echo "<pre>"; print_r($orders);
        while ($orders->have_posts()) :
            $orders->the_post();
            $ordering = new WC_Order(get_the_ID());
            $custom_project_number = get_post_meta($todo_project_connection, 'custom_project_number', true) . '-' . $ordering->ID;
           /*  if(get_current_user_id() == '328'){
				echo $custom_project_number."<br>"; 
			} */
			
            if (empty($custom_project_number)) {
                $customer_id = get_post_meta($todo_project_connection, "invoice_customer_id")[0];
                $custom_project_number = $customer_id . '-' . $todo_project_connection . '-' . $ordering->ID;
            }
        endwhile;
        wp_reset_postdata();
	/* 	if(get_current_user_id() == '328'){
			die;	
		} */
//        $custom_project_number = get_post_meta($todo_project_connection, 'custom_project_number', true);
//        if(empty($custom_project_number)){
//            $customer_id = get_post_meta($todo_project_connection, "invoice_customer_id")[0];
//            $custom_project_number=$customer_id.'-'.$todo_project_connection;
//        }


        $internal_sts = get_post_meta($todo_project_connection, 'internal_project_status_' . $depart, true);

        // $ma='internal_project_status_'.$todo_assigned_department;

        $date1 = new DateTime($todo_action_date);
        $date2 = new DateTime(date('Y-m-d'));

        $datediff = $date2->diff($date1)->format("%a");
        ?>
        <tr data-string="<?=$todo_status?>" id="<?php echo $todo_id; ?>" <?php if ($todo_status && !empty($_GET['pid'])) { ?>
                style="display:none;" class="showtodo"
            <?php } ?>>
            <?php if ($edit_project != 'edit_project') { ?>		   <td><?php echo $i; ?></td><?php } ?>

            <td style="<?php echo $style; ?>"><?php echo $todo_action_date . $days_since; ?></td>
            <?php if ($compact_table) :
                
                if($todo_project_connection){ ?>
            <td>
                    <a target="_blank"
                    href="/project?pid=<?php echo $todo_project_connection; ?>"><?php echo $custom_project_number; ?></a></td>
                <?php }else{?>
                <td>
                    </td><?php } endif; ?>
                            <td><?php
                if ($todo_status) {
                    echo __("Avklarad");
                } else {
                    echo __("Ej avklarad");
                }
                ?></td> 
<?php
            if ($edit_project != 'edit_project') {
                echo "<td>" . showName($sender->ID) . "</td>";
            }
            ?>
			 <?php
            if ($edit_project != 'edit_project') {
                echo "<td>" . showName($salesman->ID) . "</td>";
            }
            ?>
            <?php if ($compact_table) :
                ?>
                <td><a target="_blank"
                       href="/project?pid=<?php echo $todo_project_connection; ?>"><?php echo showName($get_custid); ?></a></td>
                <?php endif; ?>
            <td>

                <?php
                if ($todo_assigned_department == "sale-salesman") {
                    echo __("Sälj");
                } elseif ($todo_assigned_department == "sale-economy") {
                    echo __("Ekonomi");
                } elseif ($todo_assigned_department == "sale-technician") {
                    echo __("Tekniker");
                } elseif ($todo_assigned_department == "sale-sub-contractor") {
                    echo __("Underentreprenör");
                } elseif ($todo_assigned_department == "sale-project-management") {
                    echo __("Projektplanering");
                } elseif ($todo_assigned_department == "sale-administrator") {
                    echo __("Administratör");
                }
                ?>
            </td>

            <td><?php echo $todo_entry; ?></td>


            <?php // if (!$compact_table) :   ?>
            <td class="text-center">

                <a href="#" type="button" class="btn-settings toggle-todo-modal"
                   data-todo-id="<?php echo $todo_id; ?>"><?php echo __("Öppna"); ?>
                </a>

            </td>
            <?php if ($compact_table) :
                ?>
            <td class="text-center" style="display:flex">
 <a class="btn-settings" data-todo-status=<?php echo get_post_meta($todo_id, 'todo_status', true); ?>  data-checkfinish = "1" style="padding: 0px 11px !Important; " href="javascript:;" data-order-id="<?php echo $todo_id; ?>" id="completed_task"><i  class="fa fa-check" aria-hidden="true"></i></a>
			
			
<a class="btn-settings" href="javascript:;" data-order-id="<?php echo $todo_id; ?>" id="remove-todo"><i class="fa fa-trash" aria-hidden="true"></i></a>

                <div id="confirmBox">
                      
                    <div class="confrmmsg">
                      <div class="message"></div>
                        <div class="newbox">
    <span class="yes btn btn-beta btn-block btn-menu">OK</span>
    <span class="no btn btn-beta btn-block btn-menu">Avbryt</span>
</div></div>
</div>

            </td>
            <?php  endif;   ?>
        </tr>
        <?php
//        }


        $i++;
    endwhile;
    ?>
    <?php
}

function completed_upgift() {
    $todo_id = $_POST['todo_id'];
    if ($_POST['checkquick'] != '1') {
        $todoactiondate = $_POST["todo_action_date"];
        $todo_action_date = date('Y-m-d', strtotime($todoactiondate));
        $todo_assigned_department = $_POST['todo_assigned_department'];
        $todo_assigned_user = $_POST['todo_assigned_user_hidden'];
        $todo_entry = $_POST['todo_entry'];
        $todo_assigned_user_mottagare = $_POST['todo_assigned_user_mottagare'];

        update_post_meta($todo_id, 'post_content', $todo_entry);
        update_post_meta($todo_id, "todo_action_date", $todo_action_date);

        update_post_meta($todo_id, "todo_assigned_department", $todo_assigned_department);
        update_post_meta($todo_id, "todo_assigned_user", $todo_assigned_user);
        update_post_meta($todo_id, "todo_received_user", $todo_assigned_user_mottagare);
    }

    if ($_POST['value'] == '1')
        update_post_meta($todo_id, 'todo_status', '1');
    else
        update_post_meta($todo_id, 'todo_status', '0');
}
?>
<?php

$current_user_department = get_user_role();

$project = get_post($_POST["quick-project-id"]);
$current_department = get_post_meta($project->ID, 'order_current_department')[0];
$changeDepartment = $_POST["imm-sale-order-department"];
$responsible_salesmanid = $_POST['assigned-technician-select'];
$current_responsible = get_post_meta($project->ID, 'assigned-technician-select')[0];
$office_connection = get_post_meta($project->ID, 'office_connection')[0];
$officeConnection = $_POST["office_connection"];
$order_salesman = get_post_meta($project->ID, 'order_salesman')[0];
$inv_customer_id = get_post_meta($project->ID, 'invoice_customer_id')[0];
$billing_phone = get_user_meta($inv_customer_id, 'billing_phone')[0];
$customers = get_userdata($inv_customer_id);
$email_communication = get_user_meta($inv_customer_id, 'customer_email_communication')[0];

if (empty($email_communication)) {
    $email = $customers->user_email;
} else {
    $email = $email_communication;
}

$parentid = get_post_meta($project->ID, 'parent_order_id_project', true);


if ($current_department != $changeDepartment) {
    $sender_id = $_POST['order_salesman'];
    $receiver_id = $_POST['assigned-technician-select'];
//    echo $receiver_id;die;
    change_department_and_create_todos($project->ID, $current_department, $_POST["imm-sale-order-department"], $sender_id, $receiver_id);
    $useractivity = 'Todo created for project ' . $project->ID . ' by changing department from ' . $current_department . ' to ' . $changeDepartment . ' and resposible person is ' . getCustomerName($receiver_id) . '';
    custom_userActivity($project->ID, $useractivity);
}

//if ($current_department != $changeDepartment) {
//    $useractivity = 'Changing in department from ' . $current_department . ' to ' . $changeDepartment;
//    custom_userActivity($project->ID, $useractivity);
//}

if ($current_responsible != $responsible_salesmanid) {
    $useractivity = 'Changing in responsible salesman from ' . getCustomerName($current_responsible) . ' to ' . getCustomerName($responsible_salesmanid);
    custom_userActivity($project->ID, $useractivity);
}

if ($office_connection != $officeConnection) {
    $useractivity = 'Changing in Store from ' . $office_connection . ' to ' . $officeConnection;
    custom_userActivity($project->ID, $useractivity);
}

//        else{
////    echo'yes1';die;
//    $sender_id=$_POST['order_salesman'];
//    $receiver_id=$_POST['assigned-technician-select'];
//    $args = [
//        'posts_per_page' => -1,
//        'meta_key' => 'todo_action_date',
//        'orderby' => 'meta_value',
//        'order' => 'asc',
//        'post_type' => 'imm-sale-todo',
//        'meta_query' => array(
//            array(
//                'key' => 'todo_project_connection',
//                'value' => $project->ID,
//                'compare' => '=',
//            ),
//            array(
//                'key' => 'todo_assigned_user',
//                'value' => $sender_id,
//                'compare' => '=',
//            ),
//            array(
//                'key' => 'todo_received_user',
//                'value' => $receiver_id,
//                'compare' => '=',
//            ),
//            
//        )
//    ];
//    $todo_post = new WP_Query($args);
//    $count = $todo_post->post_count;
//    if ($count >= 1) {
//    }else{
//    change_department_and_create_todos($project->ID, $current_department, $_POST["imm-sale-order-department"], $sender_id, $receiver_id);
//}
//}
orderrecordupdate($project->ID, 'order_department_o', $_POST["imm-sale-order-department"]);
departmentSearch($project->ID, 'department', $_POST["imm-sale-order-department"]);
$today = date("Y-m-d");
$todo_action_date = date("Y-m-d", strtotime($today));
$todo_status = "0";
$todo_project_connection = $project->ID;
$customer_id = get_current_user_id();
$old_salesman = get_post_meta($project->ID, 'order_salesman')[0];


$customer_name = get_userdata($customer_id);
$varCustomerName = getCustomerName($customer_id);


if ($old_salesman != $_POST["order_salesman"]) {
    $new_salesman = get_userdata($_POST["order_salesman"]);
    $new_salesman_name = getCustomerName($_POST["order_salesman"]);
    $todo_content = $varCustomerName . ' på avdelningen' . ' ' . 'Ekonomi flyttade  över projekt' . ' ' . $todo_project_connection . ' to Projekt planering' . ' ' . $new_salesman_name;
} else {
    $todo_content = $varCustomerName . ' på avdelningen' . ' ' . 'Ekonomi flyttade  över projekt' . ' ' . $todo_project_connection . ' to Projekt planering';
}

if ($current_department == 'sale-economy' && $_POST["imm-sale-order-department"] == 'sale-project-management') {
    create_todo_item($todo_action_date, '0', $todo_project_connection, $todo_content, $_POST["imm-sale-order-department"], $_POST["order_salesman"], '');
}

update_field('add_ue_comment', $_POST["add_comment"], $project->ID);
update_field('imm-sale-project', $_POST["imm-sale-project"], $project->ID);
projectStatusSearch($project->ID, 'project_status', $_POST["imm-sale-project"]);
orderrecordupdate($project->ID, 'order_project_status_o', $_POST["imm-sale-project"]);

if ($_POST["imm-sale-order-department"] == 'sale-project-management') {
    $planing_status = array("blue" => "Grovplanerad", "orange" => "Preliminärplanerad", "green" => "Detaljplanerad");
    
    foreach ($planing_status as $x => $x_value) {

        if ($_POST["planning-type"] == $x && empty(get_post_meta($parentid, $x_value, true))) {
            update_field('internal_project_status_sale-project-management', $x_value, $project->ID);
            update_field($x_value, date('Ymd'), $parentid);
        }
    }
}



if ($_POST["imm-sale-project"] == 'project-archived') {
    $dcomoket = get_post_meta($project->ID, 'projectCompleted', true);
    if (empty($dcomoket)) {
        update_post_meta($project->ID, 'projectCompleted', date('Y-m-d'));
        $useractivity = "Project Completed by salesman on date " . date('Y-m-d H:i:s');
        custom_userActivity($project->ID, $useractivity);

        updateSearchMeta($project->ID, 'projectCompleted', date('Y-m-d'));
    }
    update_field('imm-project_order-completed', date('Ymd'), $parentid);
    
}
if (!empty($_POST["assigned-technician-select"])) {
    update_field('assigned-technician-select', $_POST["assigned-technician-select"], $project->ID);
    updateSearchMeta($project->ID, 'responsible_salesman', $_POST["assigned-technician-select"]);
    orderrecordupdate($project->ID, 'order_assigneduser_o', $_POST["assigned-technician-select"]);
}

global $wpdb;
$table = $wpdb->prefix . 'project_calender';

$comment_table = $wpdb->prefix . 'user_note';

$project_department = $_POST['project_department'];
$user_comment = nl2br($_POST['user_comment']);
$current_user_id = get_current_user_id();
$current_date = date('Y-m-d H:i:s');
$current_user_role = get_user_role();
if ($current_user_role == 'sale-sub-contractor') {
    $salesman_id = $order_salesman;
} else {
    $salesman_id = $_POST['order_salesman'];
}

if ($_POST["send_sms"]) {
    $send_sms = '1';
} else {
    $send_sms = '0';
}

if ($_POST["send_email"]) {
    $send_email = '1';
} else {
    $send_email = '0';
}

if (!empty($user_comment)) {
//    print_r($_POST);die;
    $user_data = array('project_id' => $_POST["quick-project-id"],
        'comment' => $user_comment,
        'department' => $project_department,
        'salesman_id' => $salesman_id,
        'added_user_id' => $current_user_id,
        'send_sms' => $send_sms,
        'send_email' => $send_email,
        'ue_comment' => '2',
        'created_date' => $current_date);
//    print_r($user_data);die;
    $save_format = array('%d', '%s', '%s', '%d', '%d', '%s', '%s', '%s','%s');
    $wpdb->insert($comment_table, $user_data, $save_format);

    if ($_POST["send_sms"] || $_POST["send_email"]) {
        SendSmsToUser($user_data['comment'], $billing_phone);
        SendEmailToUser($user_data['comment'], $email);
    }
}


if ($_POST["assigned-subcontractor-checkbox"]) {
    $assighned_subcontractor_checkbox = '1';
    $assigned_subcontractor_select_calender = $_POST["assigned-subcontractor-select"];
} else {
    $assighned_subcontractor_checkbox = '0';
    $assigned_subcontractor_select_calender = '0';
}

$data = array('project_id' => $project->ID,
    'work_date_from' => ($_POST["work-date-from"]) ? $_POST["work-date-from"] : '',
    'work_date_to' => ($_POST["work-date-to"]) ? $_POST["work-date-to"] : '',
    'planning_type' => ($_POST["planning-type"]) ? $_POST["planning-type"] : '',
    'assigned_subcontractor_select' => ($_POST["assigned-subcontractor-select"]) ? $_POST["assigned-subcontractor-select"] : '',
    'assigned_subcontractor_checkbox' => $assighned_subcontractor_checkbox,
    'assigned_subcontractor_select_calender' => $assigned_subcontractor_select_calender,
    'planning_note' => ($_POST["planning_note"]) ? $_POST["planning_note"] : '',
);

$format = array('%d', '%s', '%s', '%s', '%d', '%d', '%d', '%s');
if (!empty($_POST["planning-type"])) {
    $wpdb->insert($table, $data, $format);
    $useractivity = 'Calender planning is created on project ' . $project->ID . ' and assigned to sub contractor ' . getCustomerName($_POST["assigned-subcontractor-select"]) . '';
    custom_userActivity($project->ID, $useractivity);
}

if ($_POST["assigned-subcontractor-checkbox"] && $_POST["assigned-subcontractor-select"] != '') {
    $args = [
        'posts_per_page' => -1,
        'meta_key' => 'todo_action_date',
        'orderby' => 'meta_value',
        'order' => 'asc',
        'post_type' => 'imm-sale-todo',
        'meta_query' => array(
            array(
                'key' => 'todo_project_connection',
                'value' => $project->ID,
                'compare' => '=',
            ),
            array(
                'key' => 'todo_action_date',
                'value' => $_POST["work-date-from"],
                'compare' => '=',
            )
        )
    ];
    $todo_post = new WP_Query($args);
    $count = $todo_post->post_count;
    if ($count >= 1) {
        
    } else {
        create_todo_item($_POST["work-date-from"], '0', $_GET['pid'], 'Ny planering från ' . $_POST["work-date-from"] . ' till ' . $_POST["work-date-to"], 'sale-sub-contractor', '', '', $_POST["assigned-subcontractor-select"]);
//        $useractivity = 'Todo created for new Calender planning on project '.$project->ID.' and assigned to sub contractor '.$_POST["assigned-subcontractor-select"].'';
//custom_userActivity($project->ID,$useractivity);
    }
}


if (!empty($_POST["order_salesman"]) && $order_salesman != $_POST["order_salesman"]) {
    update_field('order_salesman', $_POST["order_salesman"], $project->ID);
    orderrecordupdate($project->ID, 'order_salesman_o', $_POST["order_salesman"]);
    updateSearchMeta($project->ID, 'salesman_id', $_POST["order_salesman"]);
} else {
    updateSearchMeta($project->ID, 'salesman_id', $order_salesman);
}

if (!empty($_POST["office_connection"]) && $office_connection != $_POST["office_connection"]) {
    update_post_meta($project->ID, 'office_connection', $_POST["office_connection"]);
    orderrecordupdate($project->ID, 'order_office_connection_o', $_POST["office_connection"]);
    orderrecordupdate($project->ID, 'order_office_connection', $_POST["office_connection"]);
    updateSearchMeta($project->ID, 'store_id', $_POST["office_connection"]);
}

$newdept = $_POST["imm-sale-order-department"];
$newInternal = $_POST["internal_project_status_" . $newdept];

if($newInternal=='Klart montage med avvikelse/ÄTA' || $newInternal=='Klart montage OK enligt order' || $newInternal=='Restmontage'){
	update_field('imm-sale_subcontractor', date('Ymd'), $parentid);
}

if (empty($newInternal) || $newInternal === 'Alla') {
    
} else {

    update_post_meta($project->ID, 'internal_project_status_' . $_POST["imm-sale-order-department"], $_POST["internal_project_status_" . $newdept]);
    updateSearchMetaInternal($project->ID, 'internal_project_status_' . $_POST["imm-sale-order-department"], $_POST["internal_project_status_" . $newdept]);

    if ($current_department == 'sale-project-management' && $_POST["imm-sale-order-department"] == 'sale-economy') {
        update_post_meta($todo_project_connection, 'internal_project_status_sale-economy', 'Att fakturera');
        updateSearchMetaInternal($todo_project_connection, 'internal_project_status_sale-economy', 'Att fakturera');
        create_todo_item($todo_action_date, '0', $todo_project_connection, $todo_content, $_POST["imm-sale-order-department"], $_POST["order_salesman"], '');
    }
    if (!empty($_POST['assigned-subcontractor-select'])) {
        update_field('internal_project_status_sub-contractor', 'Avslutat', $project->ID);
        updateSearchMetaInternal($project->ID, 'internal_project_status_sub-contractor', 'Avslutat');
        orderrecordupdate($project->ID, 'internal_project_status_sub-contractor', 'Avslutat');
        update_field('imm-sale_subcontractor', date('Ymd'), $parentid);
    }
}
orderrecordupdate($project->ID, 'internal_project_status_' . $_POST["imm-sale-order-department"], $_POST["internal_project_status_" . $newdept]);
$postdate = get_the_time('Y-m-d', $project->ID);
orderrecordupdate($project->ID, 'postdate', $postdate);
updateSearchMeta($project->ID, 'date', $postdate);
$project_note = get_post_meta($project->ID, 'project-note', true);
if (!empty($_POST["project-notes"])) {
    update_field('project-notes', $_POST["project-notes"], $project->ID);
}

update_field('internal_project_status', $_POST["internal_project_status_dropdown_modal"], $project->ID);

$external_invoices = $_POST["external_invoice"];
foreach ($external_invoices as $external_invoice) :
    if (!empty($external_invoice["invoice_number"]) || !empty($external_invoice["invoice_description"]) || !empty($external_invoice['invoice_price'])) {
        $date = date_create($external_invoice['invoice_date']);
        $newdate = date_format($date, "Y-m-d");
        $newdataupload = array('invoice_number' => $external_invoice["invoice_number"], 'invoice_description' => $external_invoice["invoice_description"], 'invoice_price' => $external_invoice["invoice_price"], 'invoice_date' => $newdate);


        $result = $wpdb->get_results('SELECT * FROM VQbs2_external_invoice WHERE invoice_number = "' . $external_invoice['invoice_number'] . '" AND project_id = "' . $project->ID . '"', OBJECT);

        if (count($result) == '0') {

            $wpdb->insert('VQbs2_external_invoice', array('project_id' => $project->ID, 'invoice_number' => $external_invoice['invoice_number']), array('%d', '%s'));
        }
        $wpdb->update('VQbs2_external_invoice', $newdataupload, array('invoice_number' => $external_invoice['invoice_number'], 'project_id' => $project->ID));
        $newdataupload = $result = $newdate = '';
    }
endforeach;
//$external_invoices_json = json_encode($newdataupload, JSON_UNESCAPED_UNICODE);
//update_post_meta($project->ID, 'external_invoices_json', $external_invoices_json);
// create to do
$todo_assigned_department_roll = get_userdata($_POST["assigned-technician-select"]);
$todo_entry = $_POST["project-notes"];
$todo_assigned_department = $todo_assigned_department_roll->roles[0];


$todo_assigned_user = $_POST["assigned-technician-select"];
$todo_id = '';

$parentid = get_post_meta($project->ID, 'parent_order_id_project', true);
$paymenttetm = get_post_meta($parentid, 'order_status_betainingstyp', true);
$getprder = get_post_meta($parentid, 'order_payment_method', true);
$betal_array = get_payment_term($getprder);

$salesman = get_userdata($_POST["order_salesman"]);
$salesman_name = getCustomerName($_POST["order_salesman"]);
if ($_POST["imm-sale-order-department"] == 'sale-economy' && $current_user_department == 'sale-salesman') {
    $project_author = get_post_field('post_author', $todo_project_connection);

    $args = [
        'posts_per_page' => -1,
        'meta_key' => 'todo_action_date',
        'orderby' => 'meta_value',
        'order' => 'asc',
        'post_type' => 'imm-sale-todo',
        'meta_query' => array(
            array(
                'key' => 'todo_project_connection',
                'value' => $todo_project_connection,
                'compare' => '=',
            ),
        )
    ];
    $todo_post = new WP_Query($args);
    $count = $todo_post->post_count;
    if ($count >= 1) {
        
    } else {
        create_todo_item($todo_action_date, '0', $todo_project_connection, __("Affärsförslaget accepterat. Skapa förskotts faktura ") . $todo_project_connection, 'sale-economy', '', '');
        create_todo_item($todo_action_date, '0', $todo_project_connection, __("Affärsförslaget accepterat. Skickad till ekonomi för förskotts faktura. ") . $todo_project_connection, 'sale-economy', $project_author, '');
    }


//            create_todo_item($todo_action_date, $todo_status, $todo_project_connection, '' . $salesman_name . ' på avdelningen Säljadmin flyttade över projektet ' . $project->ID . '  till Ekonomi förhantering (Betalningstyp ' . $paymenttetm . ' & Betalningsvillkor ' . $betal_array . ')', $_POST["imm-sale-order-department"], $_POST["order_salesman"], $todo_id);
}

header('Location:' . $_SERVER['REQUEST_URI']);
exit;
?>
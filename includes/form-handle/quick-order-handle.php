<?php

//print_r($_POST);die;
$project = new WC_Order($_POST["quick-order-id"]);
$current_department = get_post_meta($project->ID, 'order_current_department')[0];

if ($current_department != $_POST["imm-sale-order-department"]) {
    departmentSearch($project->ID, 'department', $_POST["imm-sale-order-department"]);
//    change_department_and_create_todos($project->ID, $current_department, $_POST["imm-sale-order-department"]);
    update_post_meta($project->ID, 'order_department_o', $_POST["imm-sale-order-department"]);
}
$today = date("Y-m-d");
$todo_action_date = date("Y-m-d", strtotime($today));
$todo_status = "0";
$todo_project_connection = get_field('imm-sale_project_connection', $_POST["quick-order-id"]);
if (!empty($_POST['order-by-this-project-status'])) {
    update_post_meta($todo_project_connection, 'imm-sale-project', $_POST['order-by-this-project-status']);
    update_post_meta($project->ID, 'order_project_status_o', $_POST['order-by-this-project-status']);
    projectStatusSearch($project_id, 'project_status', $_POST['order-by-this-project-status']);
}
$postdate = get_the_time('Y-m-d', $todo_project_connection);
update_post_meta($project->ID, "postdate", $postdate);
$linked_projectt = get_post_meta($_POST["quick-order-id"], "imm-sale_project_connection")[0];
$project_author = getuserid($_POST["quick-order-id"], $todo_project_connection, 'saljare_id', 'order_salesman');
$project_author_meta = get_userdata($project_author);
global $current_user;
foreach ($current_user->roles as $role_user)
    $role_user = $role_user;
$project_author_roles = empty($role_user) ? $current_user->roles[0] : $role_user;
//        $project_author_roles = $project_author_meta->roles[0];
$todo_id = '';
$salesman_id = getuserid($_GET["order-id"], $todo_project_connection, 'saljare_id', 'order_salesman');
$salesman_name = getCustomerName($salesman_id);
$orderaccept = get_post_meta($_POST["quick-order-id"], 'order_accept_status', true);
if ($orderaccept != $_POST['order-customer-status']) {
    if ($_POST['order-customer-status'] === 'true') {

        $order_id = $_POST["quick-order-id"];
        orderstatusSearch($order_id, 'order_accept', 'true');
        if ($_POST['notemail'] != '1') {
            include_once('order-accept/accept-true.php');
            $payment_type = '';
            order_accept($order_id, $payment_type, $send_redirect = false, '');
        }
        if (empty(get_post_meta($order_id, "kund_accepterat_logs", true))) {
            update_post_meta($order_id, 'kund_accepterat_logs', date('Ymd'));
        }
        $order_accept_date = get_post_meta($order_id, "order_accept_date")[0];
        if (empty($order_accept_date)) {
            $today = date("Y-m-d");
            update_post_meta($order_id, 'order_accept_date', $today);
            update_post_meta($order_id, 'custom_accept_date_order', $today);
            updateSearchMeta($order_id, 'date', $today);
        }

//        create_log_entry(__("Order accepterat av kund through salesman on Single Project through salesman " .$salesman_name), $order_id);
        update_post_meta($project->ID, 'order_accept_status', $_POST['order-customer-status']);
        update_post_meta($project->ID, 'imm-sale_converted_to_order', '1');

        $useractivity = "Order accepterat av kund through salesman on Single Project through salesman " . $salesman_name;
        custom_userActivity($todo_project_connection, $useractivity);
    } elseif ($_POST['order-customer-status'] === 'Kundfråga') {
        $order_id = $_POST["quick-order-id"];
        if ($_POST['notemail'] != '1') {
            include_once('order-accept/accept-question.php');

            $todo_entry = 'Tack för förslaget. Kontakta mig, jag har frågor.';

//            create_todo_item($todo_action_date, '0', $todo_project_connection, $todo_entry, $project_author_roles, '', '', $project_author);
        }
        orderstatusSearch($order_id, 'order_accept', 'Kundfråga');
        if (empty(get_post_meta($order_id, "kund_har_fragor_logs", true))) {
            update_post_meta($order_id, 'kund_har_fragor_logs', date('Ymd'));
        }
//        create_log_entry(__("Order Kundfråga on Single Project through salesman " .$salesman_name), $order_id);
        update_post_meta($project->ID, 'order_accept_status', $_POST['order-customer-status']);
        delete_post_meta($project->ID, 'imm-sale_converted_to_order', '1');

        $useractivity = "Order Kundfråga on Single Project through salesman " . $salesman_name;
        custom_userActivity($todo_project_connection, $useractivity);
    } elseif ($_POST['order-customer-status'] == '' || empty($_POST['order-customer-status'])) {
        $order_id = $_POST["quick-order-id"];
        if ($_POST['notemail'] != '1') {
            $todo_entry = 'Väntar svar.';
//            create_todo_item($todo_action_date, '0', $todo_project_connection, $todo_entry, $project_author_roles, '', '', $project_author);
        }
        orderstatusSearch($order_id, 'order_accept', '');
//        create_log_entry(__("Order har Väntar svar on Single Project through salesman " .$salesman_name), $order_id);
        update_post_meta($project->ID, 'order_accept_status', '');
        delete_post_meta($project->ID, 'imm-sale_converted_to_order', '1');
        $useractivity = "Order har Väntar svar on Single Project through salesman " . $salesman_name;
        custom_userActivity($todo_project_connection, $useractivity);
    } elseif ($_POST['order-customer-status'] == 'archieved') {
        $order_id = $_POST["quick-order-id"];
        orderstatusSearch($order_id, 'order_accept', 'archieved');
//        create_log_entry(__("Archieved the order on Single project through salesman " .$salesman_name), $order_id);
        update_post_meta($order_id, 'order_accept_status', "archieved");

        if (empty(get_post_meta($order_id, "archieved_logs", true))) {
            update_post_meta($order_id, 'archieved_logs', date('Ymd'));
        }
        delete_post_meta($order_id, 'imm-sale_converted_to_order', true);
        $useractivity = "Archieved the order on Single project through salesman " . $salesman_name;
        custom_userActivity($todo_project_connection, $useractivity);
    } elseif ($_POST['order-customer-status'] == 'Acceptavkund') {
        $order_id = $_POST["quick-order-id"];
        $payment_type = '';
        orderstatusSearch($order_id, 'order_accept', 'Acceptavkund');
        $notemail = $_POST['notemail'];
        order_accept_by_customer($order_id, $payment_type, 0, $notemail, '');
    } else {
        $order_id = $_POST["quick-order-id"];

        orderstatusSearch($order_id, 'order_accept', 'false');
        if ($_POST['notemail'] != '1') {
            include_once('order-accept/accept-decline.php');
            $todo_entry = 'Affärsförslaget Nekad av kund.';



//            create_todo_item($todo_action_date, '0', $todo_project_connection, $todo_entry, $project_author_roles, '', '', $project_author);
        }
        if (empty(get_post_meta($order_id, "kund_nekat_logs", true))) {
            update_post_meta($order_id, 'kund_nekat_logs', date('Ymd'));
        }
        create_log_entry(__("Order har nekats av kund on Single Project through salesman " . $salesman_name), $order_id);
        update_post_meta($project->ID, 'order_accept_status', $_POST['order-customer-status']);
        delete_post_meta($project->ID, 'imm-sale_converted_to_order', '1');
        $useractivity = "Order har nekats av kund on Single Project through salesman " . $salesman_name;
        custom_userActivity($todo_project_connection, $useractivity);
    }
}
// update_post_meta($project->ID, 'order_project_status_o', $_POST["imm-sale-project"]);

projectStatusSearch($project->ID, 'project_status', $_POST["order-by-this-project-status"]);
update_field('imm-sale-project', $_POST["imm-sale-project"], $project->ID);
update_post_meta($project->ID, 'project_status_o', $_POST["imm-sale-project"]);

update_field('work-date-from', $_POST["work-date-from"], $project->ID);
update_field('work-date-to', $_POST["work-date-to"], $project->ID);

update_field('planning-type', $_POST["planning-type"], $project->ID);

update_field('assigned-technician-select', $_POST["assigned-technician-select"], $project->ID);
update_field('order_salesman', $_POST["order_salesman"], $project->ID);
update_post_meta($project->ID, 'office_connection', $_POST["office_connection"]);
update_post_meta($project->ID, 'order_assigneduser_o', $_POST["assigned-technician-select"]);
update_field('project-notes', $_POST["project-notes"], $project->ID);
update_field('project-estimated-hours', $_POST["project-estimated-hours"], $project->ID);
update_field('project-work-order', $_POST["project-work-order"], $project->ID);

update_field('internal_project_status', $_POST["internal_project_status_dropdown_modal"], $project->ID);

$line_items = $_POST["line_item"];

$line_item_notes = $_POST["line_item_note"];
$line_item_is_ordered = $_POST["line_item_is_ordered"];
$line_item_is_ordered_date = $_POST["line_item_is_ordered_date"];

$line_item_order_recognition_received = $_POST["line_item_order_recognition_received"];
$line_item_order_recognition_received_date = $_POST["line_item_order_recognition_received_date"];
$line_item_order_goods_at_home = $_POST["line_item_order_goods_at_home"];
$line_item_order_goods_at_home_date = $_POST["line_item_order_goods_at_home_date"];
$line_item_order_delivered = $_POST["line_item_order_delivered"];
$line_item_order_delivered_date = $_POST["line_item_order_delivered_date"];
$line_item_order_rest = $_POST["line_item_order_rest"];
$line_item_order_rest_date = $_POST["line_item_order_rest_date"];


if (isset($line_item_is_ordered) && empty(get_post_meta($project->ID, 'material_order', true)))
    update_field('material_order', date('Ymd'), $project->ID);

if (isset($line_item_order_recognition_received) && empty(get_post_meta($project->ID, 'order_approval', true)))
    update_field('order_approval', date('Ymd'), $project->ID);

if (isset($line_item_order_goods_at_home) && empty(get_post_meta($project->ID, 'good_received', true)))
    update_field('good_received', date('Ymd'), $project->ID);

if (isset($line_item_order_delivered) && empty(get_post_meta($project->ID, 'goods_delivered', true)))
    update_field('goods_delivered', date('Ymd'), $project->ID);

if (isset($line_item_order_rest) && empty(get_post_meta($project->ID, 'good_rest_noted', true)))
    update_field('good_rest_noted', date('Ymd'), $project->ID);

$product_brands = return_sorted_product_list_based_on_brand123($project->ID);




$project_id = get_post_meta($project->ID, 'imm-sale_project_connection', true);

$office_connection = get_post_meta($project_id, 'office_connection')[0];

foreach ($product_brands as $key => $value) :
    if ($value) :


        foreach ($project->get_items() as $order_item_id => $item) {
//        echo $order_item_id;die;
            if (in_array($item['product_id'], $value)) {
                if (!empty($line_item_notes[$order_item_id])) {
                    wc_update_order_item_meta($order_item_id, "line_item_note_internal", $line_item_notes[$order_item_id]);
                }
                if (in_array($order_item_id, $line_items)) {
                    wc_update_order_item_meta($order_item_id, "is_ordered_from_reseller", true);
                } else {
                    wc_update_order_item_meta($order_item_id, "is_ordered_from_reseller", false);
                }


                wc_update_order_item_meta($order_item_id, "line_item_is_ordered", $line_item_is_ordered[$order_item_id]);
                wc_update_order_item_meta($order_item_id, "line_item_is_ordered_date", $line_item_is_ordered_date[$order_item_id]);
                wc_update_order_item_meta($order_item_id, "line_item_order_recognition_received", $line_item_order_recognition_received[$order_item_id]);
                wc_update_order_item_meta($order_item_id, "line_item_order_recognition_received_date", $line_item_order_recognition_received_date[$order_item_id]);
                wc_update_order_item_meta($order_item_id, "line_item_order_goods_at_home", $line_item_order_goods_at_home[$order_item_id]);
                wc_update_order_item_meta($order_item_id, "line_item_order_goods_at_home_date", $line_item_order_goods_at_home_date[$order_item_id]);
                wc_update_order_item_meta($order_item_id, "line_item_order_delivered", $line_item_order_delivered[$order_item_id]);
                wc_update_order_item_meta($order_item_id, "line_item_order_delivered_date", $line_item_order_delivered_date[$order_item_id]);
                wc_update_order_item_meta($order_item_id, "line_item_order_rest", $line_item_order_rest[$order_item_id]);
                wc_update_order_item_meta($order_item_id, "line_item_order_rest_date", $line_item_order_rest_date[$order_item_id]);

                $order_id = $_POST["quick-order-id"];
                if (empty(get_post_meta($order_id, "ordered_date", true))) {
                    update_post_meta($order_id, 'ordered_date', date('Ymd'));
                }
                if (empty(get_post_meta($order_id, "ordered_confirmed_date", true))) {
                    update_post_meta($order_id, 'ordered_confirmed_date', date('Ymd'));
                }
                if (empty(get_post_meta($order_id, "ordered_delivered_date", true))) {
                    update_post_meta($order_id, 'ordered_delivered_date', date('Ymd'));
                }
                //time stamp for material order
            }
        }

    endif;
endforeach;

$project->set_status($_POST["order-status"], '', true);
$project->save();


header('Location:' . $_SERVER['REQUEST_URI']);
exit;
?>
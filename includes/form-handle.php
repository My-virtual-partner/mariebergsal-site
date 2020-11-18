<?php

/**
 * Handles all the posted forms.
 */
ob_start();
require_once(ABSPATH . "wp-includes/pluggable.php");

add_action('init', 'init_loaded');

function init_loaded() {
	    /**
     * Handle the to-do create form. Simply create a new CPT to-do when posted.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['todo_handle'] === 'true') {
        include_once('form-handle/todo_handle.php');
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['todo_handle_popup'] === 'true') {
        include_once('form-handle/todo_handle_popup.php');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['exportreportdata'] === 'exportreportdata') {
        include_once('form-handle/exportreport.php');
    }
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['exportreportdata_tb'] === 'exportreportdata_tb') {
        include_once('form-handle/exportreport_tbcost.php');
    }
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['kasa_exportreportdata'] === 'kasa_exportreportdata') {
        include_once('form-handle/exportkasa_report.php');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['exportuserlist'] === 'exportuserlist') {
        include_once('form-handle/exportcustomer.php');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['importExcel'] == 'Importera') {
        include_once('form-handle/importExcel.php');
    }
    /**
     * Handle a posted invoice and make updates.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['order-handle'] === 'true') {
        include_once('form-handle/order-handle.php');
    }
    /**
     * Handle the post when a new project is created. Create a new customer and add a customer meta connection to the project.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['create_new_project'] === 'true') {
        include_once('form-handle/create_new_project.php');
    }

    /**
     * Handle the quick invoice post from the tools window.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['quick-order-handle'] === 'true') {
        include_once('form-handle/quick-order-handle.php');
    }

    /**
     * Handle the quick project post from the tools window.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['quick-project-handle'] === 'true') {

        include_once('form-handle/quick-project-handle.php');
    }

    /**
     * Handle the duplicate post when using the 'Duplicate' functionality for an invoice
     * TODO: Make sure that the correct item is duplicatied.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['duplicate'] === 'true') {
        include_once('form-handle/duplicate.php');
    }
    /**
     * Duplicate offert to new customer */
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['duplicate_to_new'] === 'true') {

        include_once('form-handle/duplicate_to_new.php');
    }

    /**
     * Handle the prepayment invoice creation
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['prepayment-invoice'] === 'true') {
        include_once('form-handle/prepayment-invoice.php');
    }

    /**
     * Handle the Accept/Decline post for the cost-suggestion sent to customer. Set status and add log entry/to-do item.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accept'] === 'true') {
//        echo'yes1';die;
        $payment_type = '';
        $order_id = $_GET["order-id"];
        $order_accept_status = get_post_meta($order_id, "order_accept_status", true);
//        echo $order_accept_status;die;
        if ($order_accept_status == 'Acceptavkund' || $order_accept_status == 'true') {
        } else {
            order_accept_by_customer($order_id, $payment_type, 0, 0, 1);
        }
        header('Location:' . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "accept") - 1));
        exit;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['accept'] === 'declined') {

        $order_accept_status = get_post_meta($_GET["order-id"], "order_accept_status", true);
        if ($order_accept_status == 'false') {
            
        } else {
            update_post_meta($_GET["order-id"], 'order_accept_status', "false");
            orderstatusSearch($_GET["order-id"], 'order_accept', 'false');
            create_log_entry(__("Affärsförslag nr har nekats av kund from order estimate page on date " . date('Y-m-d')), $_GET["order-id"]);
            if (empty(get_post_meta($_GET["order-id"], "kund_nekat_logs", true))) {
                update_post_meta($_GET["order-id"], 'kund_nekat_logs', date('Ymd'));
            }
//            update_field('kund_nekat_logs', date('Ymd'), $_GET["order-id"]);
            $today = date('Y-m-d');
            $todo_action_date = date('Y-m-d', strtotime($today));
            $linked_projectt = get_post_meta($_GET["order-id"], "imm-sale_project_connection")[0];
            $project_author = getuserid($_GET["order-id"], $linked_projectt, 'saljare_id', 'order_salesman');
            $salesman = get_userdata($project_author);
            $salemanemail = $salesman->user_email;
            $project_author_meta = get_userdata($project_author);

            global $current_user;
            foreach ($current_user->roles as $role_user)
                $role_user = $role_user;
            $project_author_roles = empty($role_user) ? $project_author_meta->roles[0] : $role_user;

//        $project_author_roles = $project_author_meta->roles[0];
            $customer_id = get_post_meta($linked_projectt, "invoice_customer_id")[0];
            $customer_name = get_userdata($customer_id);
            $varCustomerName = getCustomerName($customer_id);
            $order_id = $_GET["order-id"];
            include_once('order-accept/accept-decline.php');

            create_todo_item($todo_action_date, '0', $linked_projectt, __("Affärsförslag nr" . ' ' . $_GET["order-id"] . " nekades av kund " . $varCustomerName), $project_author_roles, '', '', $project_author);
        }

        header('Location:' . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "accept") - 1));
        exit;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['accept'] === 'Kundfråga') {

        $order_accept_status = get_post_meta($_GET["order-id"], "order_accept_status", true);
        if ($order_accept_status == 'Kundfråga') {
            
        } else {
            update_post_meta($_GET["order-id"], 'order_accept_status', "Kundfråga");
            orderstatusSearch($_GET["order-id"], 'order_accept', 'Kundfråga');
//            update_field('kund_har_fragor_logs', date('Ymd'), $_GET["order-id"]);
            
            if (empty(get_post_meta($_GET["order-id"], "kund_har_fragor_logs", true))) {
                update_post_meta($_GET["order-id"], 'kund_har_fragor_logs', date('Ymd'));
            }
            
            create_log_entry(__("Affärsförslag Väntar på svar från kund from order estimate page on date " . date('Y-m-d')), $_GET["order-id"]);
            $today = date('Y-m-d');
            $todo_action_date = date('Y-m-d', strtotime($today));
            $linked_projectt = get_post_meta($_GET["order-id"], "imm-sale_project_connection")[0];
            $project_author = getuserid($_GET["order-id"], $linked_projectt, 'saljare_id', 'order_salesman');
//        echo $project_author;die;
            $project_author_meta = get_userdata($project_author);
            global $current_user;
            foreach ($current_user->roles as $role_user)
                $role_user = $role_user;
            $project_author_roles = empty($role_user) ? $project_author_meta->roles[0] : $role_user;
//        $project_author_roles = $project_author_meta->roles[0];
            $order_id = $_GET["order-id"];
            include_once('order-accept/accept-question.php');
            create_todo_item($todo_action_date, '0', $linked_projectt, __("Tack för förslaget. Kontakta mig, jag har frågor."), $project_author_roles, '', '', $project_author);
        }


        header('Location:' . substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], "accept") - 1));
        exit;
    }

    /**
     * Handle the lead create form. Simply create a new CPT lead when posted.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['create_lead'] === 'true') {

        include_once('form-handle/create_lead.php');
    }






    /**
     * Handle the external lead create form. Simply create a new CPT lead when posted.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['create_external_lead'] === 'true') {
        include_once('form-handle/create_external_lead.php');
    }



    /**
     * Handle the customer edit form. Update customer details.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['customer-edit'] === 'true') {
        include_once('form-handle/customer-edit.php');
    }

    /**
     * Handle the create new invoice posted form.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['create_invoice'] === 'true') {
        include_once('form-handle/create_invoice.php');
    }

    /**
     * Handle the update calender form.
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['calender_handle'] === 'true') {
        $calender_id = $_POST['calender_id'];
        $planning_type = $_POST['planning-type'];
        $work_date_from = $_POST['work_date_from'];
        $work_date_to = $_POST['work_date_to'];
        $planning_note = $_POST['planning_note'];
        $subcontractor_select = $_POST['assigned-subcontractor-select'];
        global $wpdb;
        $table = $wpdb->prefix . 'project_calender';
        $wpdb->update($table, array('work_date_from' => $work_date_from, 'work_date_to' => $work_date_to, 'planning_note' => $planning_note, 'planning_type' => $planning_type, 'assigned_subcontractor_select' => $subcontractor_select, 'assigned_subcontractor_select_calender' => $subcontractor_select), array('id' => $calender_id));
        header('Location:' . $_SERVER['REQUEST_URI']);
        exit();
    }
}

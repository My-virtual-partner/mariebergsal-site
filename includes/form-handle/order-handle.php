<?php

//print_r($_POST);die;
if ($_POST['arbet_file'] == '1' && $_POST['forward_step']) {
    include_once('order_log.php');
    $getMsg = arbet_order_files_upload($_GET["order-id"], $_FILES);
	update_post_meta($_GET["order-id"],'new_error',$getMsg);
     $step = $_GET['step'];
     header('Location:' . "/order-steps?order-id=" . $_GET["order-id"] . "&step=" . $step);
    exit;
}
$stp = get_post_meta($_GET["order-id"], 'order_project_type', true);

$project_json_data = get_post_meta($_GET["order-id"], 'orderdata_json');
$json_data_as_array = json_decode($project_json_data[0], JSON_PRETTY_PRINT);

$date = $json_data_as_array['imm-sale-value_Datum-Fr-hembesk']['value'];
$time = $json_data_as_array['imm-sale-value_Tid']['value'];
$salesman_id = $_POST['sales_names'];
$salesman = get_userdata($salesman_id);
$salesman_name = getCustomerName($salesman_id);
$today = date("Y-m-d");
$todo_action_date = date("Y-m-d", strtotime($today));
$todo_status = "0";
$todo_project_connection = get_field('imm-sale_project_connection', $_GET["order-id"]);

 updateSearchMeta($_GET["order-id"], 'salesman_id', $_POST['sales_names']);


$affarsforslaget_gallertom = get_field('affarsforslaget_gallertom', $_GET["order-id"]);
$gallertom_date = date('Y-m-d', strtotime('-3 days', strtotime($affarsforslaget_gallertom)));
$order_accept = get_post_meta($_GET["order-id"], "order_accept_status")[0];
global $current_user;
foreach ($current_user->roles as $role_user)
    $role_user = $role_user;
$project_author_roles = empty($role_user) ? $current_user->roles[0] : $role_user;

$postdate = get_the_time('Y-m-d', $todo_project_connection);
update_post_meta($_GET["order-id"], "postdate", $postdate);
if (!empty($_POST['imm-sale-value_Datum-Fr-hembesk']) && $_POST['imm-sale-value_Datum-Fr-hembesk'] != $date) {
    $to_date = $_POST['imm-sale-value_Datum-Fr-hembesk'];
    $to_time = $_POST['imm-sale-value_Tid'];
    $todo_entry = " Ett hembesök har bokats den $to_date,  klockan $to_time  på säljare: $salesman_name";
    $todo_id = '';
    create_todo_item($todo_action_date, $todo_status, $todo_project_connection, $todo_entry, $project_author_roles, '', $todo_id, $salesman_id);
}
if ($stp != $_POST['project_type']) {
	
    projectTypeSearch($_GET["order-id"], 'type_of_project',$_POST['project_type']);
	

}
	

$payment_type = $_POST["payment_type"];


if (!empty($_POST["typeservice"])) {
    update_post_meta($_GET["order-id"], 'type_of_service', $_POST["typeservice"]);
}
if (!empty($_POST["beskrivning"])) {
    update_post_meta($_GET["order-id"], 'beskrivning', $_POST["beskrivning"]);
}
$project_id = get_post_meta($_GET["order-id"], 'imm-sale_project_connection', true);
$project_status = get_post_meta($project_id, 'imm-sale-project', true);
update_post_meta($_GET["order-id"], 'order_project_status_o', $project_status);
$salesid = get_post_meta($project_id, 'order_salesman', true);
if ($salesid != $_POST['sales_names']) {
//    echo'yes1';die;
    update_post_meta($_GET["order-id"], 'saljare_id', $_POST['sales_names']);
    update_post_meta($project_id, 'order_salesman', $_POST['sales_names']);
//    update_post_meta($project_id, 'assigned-technician-select', $_POST['sales_names']);
    update_post_meta($_GET["order-id"], 'order_salesman_o', $_POST['sales_names']);
    updateSearchMeta($_GET["order-id"], 'salesman_id', $_POST['sales_names']);
}
if (isset($payment_type)) {

    update_post_meta($_GET["order-id"], 'order_payment_method', $payment_type);
}
if ($_POST['order_status_betainingstyp']) {
//    update_post_meta($_GET["order-id"], 'order_status_betainingstyp', $_POST['order_status_betainingstyp']);
    update_post_meta($_GET["order-id"], 'order_status_betainingstyp1', $_POST['order_status_betainingstyp']);
    paymenttypeSearch($_GET["order-id"], 'payment_type', $_POST['order_status_betainingstyp']);
}
$garanti_type = $_POST["garanti_type"];
if ($garanti_type) {
    update_post_meta($_GET["order-id"], 'order_garanti_method', $garanti_type);
}

if ($_POST['forward-step'] == 'Spara' || $_POST["save-back-button"] === "true") {

    $recervation_type = $_POST["reservationer_type"];
    $egen_recervation_type = $_POST["reservation_egen_text"];
 update_post_meta($_GET["order-id"], 'remove_vats_number', $_POST['vat_number']);
    update_field('order_recervation_method_egen', $egen_recervation_type, $_GET["order-id"]);
    $recervation_type_array = array();
    foreach ($recervation_type as $type) {
        $type_array = array($type);
        array_push($recervation_type_array, $type_array);
    }
    /*    update_post_meta($_GET["order-id"], 'order_recervation_method', $recervation_type); */

    update_field('order_recervation_method', $recervation_type, $_GET["order-id"]);
	update_field('order_recervation_method_id', $recervation_type, $_GET["order-id"]);
    if (!empty($_POST['order-by-this-project-status'])) {
        update_post_meta($project_id, 'imm-sale-project', $_POST['order-by-this-project-status']);
        update_post_meta($_GET["order-id"], 'order_project_status_o', $_POST['order-by-this-project-status']);
        projectStatusSearch($_GET["order-id"], 'project_status', trim($_POST['order-by-this-project-status']));
    }


    $order_id = $_GET["order-id"];
    $project_author = getuserid($order_id, $todo_project_connection, 'saljare_id', 'order_salesman');
    $project_author_meta = get_userdata($project_author);
    global $current_user;
    foreach ($current_user->roles as $role_user)
        $role_user = $role_user;
    $project_author_roles = empty($role_user) ? $current_user->roles[0] : $role_user;
//        $project_author_roles = $project_author_meta->roles[0];
    $todo_id = '';
    $salesman_id = getuserid($_GET["order-id"], $todo_project_connection, 'saljare_id', 'order_salesman');
    if ($order_accept != $_POST['order-customer-status']) {
        if ($_POST['order-customer-status'] === 'true') {

            orderstatusSearch($order_id, 'order_accept', 'true');
            if ($_POST['notemail'] != 1) {
                include_once('order-accept/accept-true.php');

                $payment_type = '';
                order_accept($order_id, $payment_type, 0, 'order_handle');
            }
            $order_accept_date = get_post_meta($order_id, "order_accept_date")[0];

            if (empty($order_accept_date)) {
                $today = date("Y-m-d");
                update_post_meta($order_id, 'order_accept_date', $today);
                update_post_meta($order_id, 'custom_accept_date_order', $today);
				updateSearchMeta($order_id, 'date', $today);
            }
          
            create_log_entry(__("Affärsförslag accepterat av kund through Order Steps"), $order_id);
            update_post_meta($order_id, 'order_accept_status', $_POST['order-customer-status']);
            update_post_meta($order_id, 'imm-sale_converted_to_order', '1');
        } elseif ($_POST['order-customer-status'] === 'Kundfråga') {
            if ($_POST['notemail'] != 1) {
                include_once('order-accept/accept-question.php');

                $todo_entry = 'Tack för förslaget. Kontakta mig, jag har frågor.';

//            create_todo_item($todo_action_date, '0', $todo_project_connection, $todo_entry, $project_author_roles, '', '', $project_author);
            }
            orderstatusSearch($order_id, 'order_accept', 'Kundfråga');
            create_log_entry(__("Order Kund har frågor through Order Steps"), $order_id);
            update_post_meta($order_id, 'order_accept_status', $_POST['order-customer-status']);
            delete_post_meta($order_id, 'imm-sale_converted_to_order', '1');
        } elseif ($_POST['order-customer-status'] == '') {
            orderstatusSearch($order_id, 'order_accept', '');
            create_log_entry(__("Affärsförslag har Väntar svar through Order Steps"), $order_id);
            update_post_meta($order_id, 'order_accept_status', '');
            delete_post_meta($order_id, 'imm-sale_converted_to_order', '1');
        } elseif ($_POST['order-customer-status'] == 'archieved') {
            orderstatusSearch($order_id, 'order_accept', 'archieved');
            create_log_entry(__("Archieved the order through Order Steps"), $order_id);
            update_post_meta($order_id, 'order_accept_status', "archieved");
            delete_post_meta($order_id, 'imm-sale_converted_to_order', true);
        } elseif ($_POST['order-customer-status'] == 'Acceptavkund') {
            $payment_type = '';
            $notemail = $_POST['notemail'];
            orderstatusSearch($order_id, 'order_accept', 'Acceptavkund');
            order_accept_by_customer($order_id, $payment_type, 0, $notemail,0);
        } else {
            if ($_POST['notemail'] != 1) {

                include_once('order-accept/accept-decline.php');

                $todo_entry = 'Affärsförslaget Nekad av kund.';
//                create_todo_item($todo_action_date, '0', $todo_project_connection, $todo_entry, $project_author_roles, '', '', $project_author);
            }
            orderstatusSearch($order_id, 'order_accept', 'false');
            create_log_entry(__("Affärsförslag har nekats av kund through Order Steps"), $order_id);
            update_post_meta($order_id, 'order_accept_status', $_POST['order-customer-status']);
            delete_post_meta($order_id, 'imm-sale_converted_to_order', '1');
        }
    }
    $household_vat_discount = [];

    foreach ($_POST["customer_household_vat_discount_name"] as $key => $value) {

        if (!empty(trim($_POST["customer_household_vat_discount_name"][$key])) || !empty(trim($_POST["customer_household_vat_discount_id_number"][$key])) || !empty(trim($_POST["customer_household_vat_discount_real_estate_name"][$key])) || !empty(trim($_POST["customer_household_lagenhets_number"][$key])) || !empty(trim($_POST["customer_household_org_number"][$key]))) {
            array_push($household_vat_discount, [
                'customer_household_vat_discount_name' => trim($_POST["customer_household_vat_discount_name"][$key]),
                'customer_household_vat_discount_id_number' => trim($_POST["customer_household_vat_discount_id_number"][$key]),
                'customer_household_vat_discount_real_estate_name' => trim($_POST["customer_household_vat_discount_real_estate_name"][$key]),
                'customer_household_org_number' => trim($_POST["customer_household_org_number"][$key]),
                'customer_household_lagenhets_number' => trim($_POST["customer_household_lagenhets_number"][$key])
            ]);
        }
    }
    $household_vat_discount_json = return_form_as_json($household_vat_discount);


    if ($household_vat_discount_json) {
        update_post_meta($_GET["order-id"], "household_vat_discount_json", $household_vat_discount_json);
    }
}
$order_id = $_GET["order-id"];
$today = date("Y-m-d");
$todo_action_date = date("Y-m-d", strtotime($today));
$todo_status = "0";
$todo_project_connection = get_field('imm-sale_project_connection', $order_id);

$postdate = get_the_time('Y-m-d', $todo_project_connection);
update_post_meta($order_id, "postdate", $postdate);
updateSearchMeta($order_id,'create_date',$postdate);
$project_author = getuserid($order_id, $todo_project_connection, 'saljare_id', 'order_salesman');
$project_author_meta = get_userdata($project_author);
global $current_user;
foreach ($current_user->roles as $role_user)
    $role_user = $role_user;
$project_author_roles = empty($role_user) ? $current_user->roles[0] : $role_user;
//        $project_author_roles = $project_author_meta->roles[0];
$todo_id = '';
$salesman_id = getuserid($_GET["order-id"], $todo_project_connection, 'saljare_id', 'order_salesman');

$order = new WC_Order($_GET["order-id"]);
//echo count( $order->get_items()); die; 

$internalstatuss = get_post_meta($project_id, 'internal_project_status_sale-administrator', true);
if (count($order->get_items()) != 0 && $internalstatuss == 'Nytt' || empty($internalstatuss)) {
    update_post_meta($project_id, 'internal_project_status_sale-administrator', 'Offertarbete pågår');
    update_post_meta($_GET["order-id"], 'internal_project_status_sale-administrator', 'Offertarbete pågår');
    updateSearchMetaInternal($_GET["order-id"], 'internal_project_status_sale-administrator', 'Offertarbete pågår');
} elseif (count($order->get_items()) == 0) {
    update_post_meta($project_id, 'internal_project_status_sale-administrator', 'Nytt');
    update_post_meta($_GET["order-id"], 'internal_project_status_sale-administrator', 'Nytt');
    updateSearchMetaInternal($_GET["order-id"], 'internal_project_status_sale-administrator', 'Nytt');
}
if ($_POST['handle-project-price-adjustments'] === 'true' && !empty(trim($_POST["price_adjust"]["price_adjust_code"])) && ($_POST["price_adjust"]["price_adjust_amount"] || $_POST["price_adjust"]["price_adjust_inkopprice"])) {

    $discount_calculation_qty = ($_POST["price_adjust"]["price_adjust_amount"]) * .8;


    $custom_price_adjust_product_id = $_POST["price_adjust"]["price_adjust_product_id"];
    $custom_price_adjust_product = new WC_Product($custom_price_adjust_product_id);
    $lineid = create_custom_line_item($order, $custom_price_adjust_product, $discount_calculation_qty, $_POST["price_adjust"]["price_adjust_code"], '', $_POST["price_adjust"]["price_adjust_inkopprice"]);
/*     if (empty(wc_get_order_item_meta($lineid, "HEAD_ITEM"))) {
        $data = unserialize(get_post_meta($_GET["order-id"], 'sortorderitems', true));
        array_push($data, $lineid);
        update_post_meta($_GET["order-id"], 'sortorderitems', serialize($data));
    } else {
        $data = unserialize(get_post_meta($_GET["order-id"], 'head_sortorderitems', true));
        array_push($data, $lineid);
        update_post_meta($_GET["order-id"], 'head_sortorderitems', serialize($data));
    } */
	update_post_meta($_GET['order-id'], 'firstSort',true);

    $order->calculate_totals();
    $order->save();



    header('Location:' . $_SERVER['REQUEST_URI']);
    exit;
}

$step = $_GET["step"];
$step_heading = $_POST["step-heading"];
$show_summary_url = "order-summary?order-id=" . $_GET["order-id"] . "&order-key=" . get_field("order_summary-key-w-price", $_GET["order-id"]);

if (isset($_POST["project_heading"])) {
    update_order_summary_heading_and_description($_GET["order-id"], $_POST["project_heading"], $_POST["project_description"], $_POST["order_summary_addon_heading"], $_POST["order_summary_addon_description"], $_POST['affarsforslaget_gallertom'], $_POST['demo_test']);
}

if (!isset($_GET["step"])) {
    $step = -1;
}
$post_files_combined = get_file_post_data();

$posted_form_filtered = return_only_imm_sales_input_fields_from_form($post_files_combined);
$posted_form_processed = return_processed_form($posted_form_filtered);
$json_data = return_form_as_json($posted_form_processed);
include_once('order_log.php');
$project_id = update_order($json_data, $_GET["order-id"], $_POST["order-status"], $_POST);
if ($_POST['forward-step'] == 'Spara' || $_POST["save-back-button"] === "true") {
    if (!empty($_POST["customer_household_vat_discount_name"][1]) || !empty($_POST["customer_household_vat_discount_id_number"][1]) || !empty($_POST["customer_household_vat_discount_real_estate_name"][1]) || !empty($_POST["customer_household_org_number"][1]) || !empty($_POST["customer_household_lagenhets_number"][1])) {
        $tax_deduction = preg_replace("/\D/", "", $_POST["imm-sale-tax-deduction"]);
    } else {
        $tax_deduction = 0;
    }

    $gethousehold = get_post_meta($order->ID, 'household_vat_discount_json', true);

    $counthouse = json_decode($gethousehold, true);
    $count = 0;
    foreach ($counthouse as $key => $value) {
        foreach ($value as $keval) {
            if (!empty(trim($keval))) {
                $count++;
            }
        }
    }


    if (empty($tax_deduction) || $tax_deduction == 0 || $count == 0) {
        $taxvalue = get_post_meta($_GET["order-id"], "imm-sale-tax-deduction", true);
        delete_post_meta($_GET["order-id"], "imm-sale-tax-deduction", $taxvalue);
        $orders = new WC_Order($_GET["order-id"]);

        foreach ($orders->get_items() as $itemss) {
            $item_datas = $itemss->get_data();
            $product_id = $itemss['product_id'];
            if ($product_id == '12870')
                wc_delete_order_item($item_datas['id']);
        }
    } else {
        update_post_meta($_GET["order-id"], "imm-sale-tax-deduction", $tax_deduction);
        $tax_deduction = get_post_meta($_GET["order-id"], "imm-sale-tax-deduction", true);
    }



    $order = new WC_Order($_GET["order-id"]);
    $items = $order->get_items();


    if ($tax_deduction > 0) {
        $items_ids = array();
        foreach ($items as $item) {
            $item_data = $item->get_data();
            $product_id = $item['product_id'];
            array_push($items_ids, $product_id);
        }
        $custom_price_adjust_product_id_rot = get_field('custom_price_adjust_root_product_id', 'options');


        if (!in_array($custom_price_adjust_product_id_rot, $items_ids)) {
            $custom_price_adjust_product_rot = new WC_Product($custom_price_adjust_product_id_rot);
            create_custom_line_item($order, $custom_price_adjust_product_rot, 1, 'Avgift');
        }

        $order->calculate_totals();
        $order->save();

        $selected_cat_sum = false;
        $selected_product_category_for_price_adjustment = get_field('selected_product_category_for_price_adjustment', 'options'); //choosen category from admon panel
        foreach ($order->get_items() as $order_item_id => $item) {
            $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();

            $terms = get_the_terms($product_id, 'product_cat');
            foreach ($terms as $term) {

                if (in_array($term->term_id, $selected_product_category_for_price_adjustment)) {
                    $selected_cat_sum = $selected_cat_sum + ($item->get_total() + $item->get_total_tax());
                }
            }
        };

        $orders = new WC_Order($_GET["order-id"]);

        foreach ($orders->get_items() as $itemss) {
            $item_datas = $itemss->get_data();

            $product_id = $itemss['product_id'];
            if ($product_id == '12870') {
                $deleteROt = $item_datas['id'];
            }
        }


        $data = unserialize(get_post_meta($_GET["order-id"], 'sortorderitems', true));
        if (!empty($deleteROt))
            $data = array_merge($data, array($deleteROt));

        update_post_meta($_GET["order-id"], 'sortorderitems', serialize($data));
        $selected_cat_sum_percented = (($selected_cat_sum * 30) / 100);

        if ($tax_deduction < $selected_cat_sum_percented) {
            $confirmed_rot_value = $tax_deduction;
        } elseif ($tax_deduction > $selected_cat_sum_percented) {
            $confirmed_rot_value = $selected_cat_sum_percented;
        }

        if ($selected_cat_sum_percented) {
            update_post_meta($project_id, "rot_percentage", $selected_cat_sum_percented);
        }

        if ($confirmed_rot_value) {
            update_post_meta($project_id, "confirmed_rot_percentage", $confirmed_rot_value);
			$remove_vats = get_post_meta($_GET['order-id'], 'remove_vats', true);

        }
    }
}


if (!empty($_POST['imm-sale-value_Information-frn-kund']) || !empty($_POST['imm-sale-value_Arbetsorder'])) {


    update_post_meta($_GET["order-id"], 'Information-frn-kund', $_POST['imm-sale-value_Information-frn-kund']);

    update_post_meta($_GET["order-id"], 'Arbetsorder', $_POST['imm-sale-value_Arbetsorder']);
}
if ($_POST['save_order'] == '1') {
	  $remove_vats = get_post_meta($_GET['order-id'], 'remove_vats', true);
    if (!empty($remove_vats)) {
        removeVat($_GET['order-id'], 1);
    }
    header('Location:' . site_url() . "/project?pid=" . $todo_project_connection);
    exit;
}
if (isset($_POST['back-step'])) {
    $step--;
} else {
    $step++;
}
if ($_POST["complete-project"] === "true" && !isset($_POST['back-step'])) {
    $order_accept = get_post_meta($_GET["order-id"], "order_accept_status")[0];

    $todo_project_connection = get_field('imm-sale_project_connection', $_GET["order-id"]);

    $salesman_id = getuserid($_GET["order-id"], $todo_project_connection, 'saljare_id', 'order_salesman');

    $today = date("Y-m-d");
    $todo_action_date = date("Y-m-d", strtotime($today));
    $todo_status = "0";



    update_field('editing_status_mb', '', $_GET["order-id"]);
    update_field('edited_by_mb', '', $_GET["order-id"]);
    update_field('editing_time_mb', '', $_GET["order-id"]);

    $option_name = 'users_key_' . $_GET["order-id"] . '';

    //this options are used to set a value in options if it is exist this the class  affarsforslaget_pi will be shown otherwise it will be hidden.
    if (get_option($option_name)) {
        update_option($option_name, 1);
    } else {

        add_option($option_name, 1);
    }


    if ($_POST["forward-step"] == "go_to_cost") {
        header('Location:' . site_url() . "/order-summary?order-id=" . $project_id . "&order-key=" . get_field("order_summary-key-w-price", $project_id));
        exit;
    } else {
        if ($stp != $_POST['project_type']) {
            $step = 0;
            header('Location:' . "/order-steps?order-id=" . $project_id . "&step=" . $step);
        } else {

            header('Location:' . $_SERVER['REQUEST_URI']);
        }
        exit;
    }
} elseif ($_POST["no"] === "true") {

    header('Location:' . $_SERVER['REQUEST_URI']);
    exit;
} else {
    /* if ($_POST['step-heading'] == 'Arbetsorder' && !empty($_POST['next_stepgo'])) {
      header('Location:' . "/order-steps?order-id=" . $project_id . "&step=" . $_GET['step']);
      exit;
      } */
    if ($stp != $_POST['project_type']) {
        $step = 0;
    }
//    if ($_POST['image_file'] == 'get_image') {
//        $step = $_GET['step'];
//    }
    create_log_entry(__("Projektinformation uppdaterat för ") . $step_heading, $_GET["order-id"]);

    header('Location:' . "/order-steps?order-id=" . $project_id . "&step=" . $step);
    exit;
}
?>
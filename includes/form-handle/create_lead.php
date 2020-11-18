<?php
$lead_id = $_GET["lead-id"];
$lead_first_name = $_POST["customer_first_name"];
//$lead_last_name = $_POST["customer_last_name"];
$lead_email = $_POST["customer_email"];
$lead_phone = $_POST["customer_phone"];
$lead_city = $_POST["customer_city"];
$lead_postnummer = $_POST["customer_postnummer"];
$lead_typavlead = $_POST["customer_typavlead"];
$lead_other = $_POST["customer_other"];
$lead_customer_levernadress = $_POST["customer_levernadress"];
$lead_customer_homenummer = $_POST["customer_homenummer"];
$lead_salesman = $_POST["user_kontakt_person"];
$user_meta = get_userdata($lead_salesman);

$salesman_department = $user_meta->roles;

$meta_query = array(array('key' => 'lead_email', 'value' => $lead_email, 'compare' => '='));
$args = array(
    'post_type' => 'imm-sale-leads',
    'post_status' => 'publish',
    'meta_query' => $meta_query);
$products = new WP_Query($args);
if ($products->have_posts()) {
    $customers = get_users();
    foreach ($customers as $customer) :
        $email = $customer->user_email;
        if ($email == $lead_email) {
            $customer_id = $customer->ID;
        }
    endforeach;
//            
    $current_user_department = get_user_role();
    $salesman_id = get_current_user_id();
    
     foreach ($_POST['lead_checkbox'] as $metaValue) {
//        print_r($metaValue);
    if (!empty($metaValue)) {
        update_post_meta($lead_id, $metaValue, $metaValue);
    }
}

    update_post_meta($lead_id, "lead_first_name", $lead_first_name);
//    update_post_meta($lead_id, "lead_last_name", $lead_last_name);
    update_post_meta($lead_id, "lead_email", $lead_email);
    update_post_meta($lead_id, "lead_phone", $lead_phone);
    update_post_meta($lead_id, "lead_city", $lead_city);
    update_post_meta($lead_id, "lead_postnummer", $lead_postnummer);
    update_post_meta($lead_id, "lead_typavlead", $lead_typavlead);
    update_post_meta($lead_id, "lead_other", $lead_other);
    update_post_meta($lead_id, "lead_customer_levernadress", $lead_customer_levernadress);
    update_post_meta($lead_id, "lead_customer_homenummer", $lead_customer_homenummer);
    update_post_meta($lead_id, "leads_skapat_lead", date('Ymd'));
    update_post_meta($lead_id, "lead_salesman", $lead_salesman);
    update_post_meta($lead_id, "takhojdbv_cb", $_POST['takhojdbv_cb']);
    update_post_meta($lead_id, "byggar_cb", $_POST['byggar_cb']);
    update_post_meta($lead_id, "antal_kanaler_cb", $_POST['antal_kanaler_cb']);
    update_post_meta($lead_id, "ca_meter_cb", $_POST['ca_meter_cb']);
    update_post_meta($lead_id, "annat_yttertak_cb", $_POST['annat_yttertak_cb']);
    
    header('Location:' . site_url() . "/system-dashboard#leads");

//    $project_id = create_new_project($lead_salesman, $customer_id, $current_user_department, '', $lead_salesman);
//    header('Location:' . site_url() . '/select-invoice-type?project-id=' . $project_id);
    exit;
} else {
    if (!$lead_id) {
        $lead_id = wp_insert_post(array(
            'post_title' => $lead_first_name,
            'post_type' => 'imm-sale-leads',
            'post_content' => '',
            'post_status' => 'publish'
        ));
    }
}
update_post_meta($lead_id, "lead_first_name", $lead_first_name);
//update_post_meta($lead_id, "lead_last_name", $lead_last_name);
update_post_meta($lead_id, "lead_email", $lead_email);
update_post_meta($lead_id, "lead_phone", $lead_phone);
update_post_meta($lead_id, "lead_city", $lead_city);
update_post_meta($lead_id, "lead_postnummer", $lead_postnummer);
update_post_meta($lead_id, "lead_typavlead", $lead_typavlead);
update_post_meta($lead_id, "lead_other", $lead_other);
update_post_meta($lead_id, "lead_customer_levernadress", $lead_customer_levernadress);
update_post_meta($lead_id, "lead_customer_homenummer", $lead_customer_homenummer);
update_post_meta($lead_id, "leads_skapat_lead", date('Ymd'));
update_post_meta($lead_id, "lead_salesman", $lead_salesman);
//checkbox value save

foreach ($_POST['lead_checkbox'] as $metaValue) {
    if (!empty($metaValue)) {
        update_post_meta($lead_id, $metaValue, $metaValue);
    }
}
update_post_meta($lead_id, "takhojdbv_cb", $_POST['takhojdbv_cb']);
update_post_meta($lead_id, "byggar_cb", $_POST['byggar_cb']);
update_post_meta($lead_id, "antal_kanaler_cb", $_POST['antal_kanaler_cb']);
update_post_meta($lead_id, "ca_meter_cb", $_POST['ca_meter_cb']);
update_post_meta($lead_id, "annat_yttertak_cb", $_POST['annat_yttertak_cb']);
$today = date('Y-m-d');
$todo_action_date = date('Y-m-d', strtotime($today));

if ($lead_salesman != 'ingen') {
    $sender_id=get_current_user_id();
    create_todo_item($todo_action_date, 0, null, __("Ett nytt leads har inkommit på dig med  namn ") . $lead_first_name, $salesman_department[0], $sender_id, '', $lead_salesman);
}


header('Location:' . site_url() . "/system-dashboard#leads");


exit;
?>
<?php
  $lead_first_name = $_POST["customer_first_name"];
        $lead_last_name = $_POST["customer_last_name"];
        $lead_email = $_POST["customer_email"];
        $lead_phone = $_POST["customer_phone"];
        $lead_city = $_POST["customer_city"];
        $lead_other = $_POST["customer_other"];
        $return_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $lead_id = wp_insert_post(array(
            'post_title' => $lead_first_name . " " . $lead_last_name,
            'post_type' => 'imm-sale-leads',
            'post_content' => '',
            'post_status' => 'publish'
        ));


        update_post_meta($lead_id, "lead_first_name", $lead_first_name);
        update_post_meta($lead_id, "lead_last_name", $lead_last_name);
        update_post_meta($lead_id, "lead_email", $lead_email);
        update_post_meta($lead_id, "lead_phone", $lead_phone);
        update_post_meta($lead_id, "lead_city", $lead_city);
        update_post_meta($lead_id, "lead_other", $lead_other);

        header('Location:' . $return_url . "?lead-id=" . $lead_id . "#lead_form");
        exit;
?>
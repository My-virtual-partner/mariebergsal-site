<?php
        $order = wc_create_order();
        $project_id = $_GET["project-id"];
        $lead_id = get_field('orgin_lead_id', $project_id);


        $lead_published_date = get_the_modified_date('Ymd', $lead_id);
        $project_published_date = get_the_modified_date('Ymd', $project_id);
		/// for search table data
		$neworderid = $order->get_id();
		global $wpdb;
		$table = array('VQbs2_Projects_Search','VQbs2_Project_Search_Meta');
		foreach($table as $value){
		$data =	 array ('id' => $neworderid);
		$format = array('%d');
		$wpdb->insert($value,$data,$format);
		}

        if ($lead_id) {
            update_field('leads_skapat_logs', $lead_published_date, $order->get_id());
        } else {
            update_field('leads_skapat_logs', date('Ymd'), $order->get_id());
        }
        create_log_entry(__("Lead skapat"), $order->get_id());
        update_field('lead_to_prject_logs', $project_published_date, $order->get_id());
        create_log_entry(__("Lead skapat projekt"), $order->get_id());
        // update_field('saljare_leads_konverterat_till_projekt_p', $project_published_date, $project_id);
        /*        update_field('saljare_skapat_offert_logs',date('Ymd'),$order->get_id()); */


        $customer_id = get_post_meta($project_id, "invoice_customer_id")[0];
        $order_id = $order->get_id();
        $postdate = get_the_time('Y-m-d', $project_id);
        update_post_meta($order_id, 'postdate', $postdate);
        update_post_meta($order_id, 'order_accept_status', '');
        $invoice_type = $_POST["select_invoice_type"];
        $order_current_department = get_post_meta($project_id, "order_current_department")[0];
        $project_status = get_post_meta($project_id, "imm-sale-project")[0];
        $office_connection_id = get_field('office_connection', $project_id);
        update_post_meta($order_id, 'order_office_connection', $office_connection_id);
        update_post_meta($order_id, 'order_office_connection_o', $office_connection_id);
        update_post_meta($order_id, 'saljare_id', get_current_user_id());
        update_post_meta($order_id, 'order_salesman_o', get_current_user_id());
        update_post_meta($project_id, 'parent_order_id_project', $order_id); //save parent order id in project id
        update_post_meta($order_id, 'custom_order_number', $customer_id . "-" . $project_id . "-" . $order_id);
        update_post_meta($order_id, 'order_project_type', $invoice_type);
        update_post_meta($order_id, 'imm-sale_project_connection', $project_id);
        update_post_meta($order_id, 'order_department_o', $order_current_department);
        update_post_meta($order_id, 'order_project_status_o', $project_status);

        update_post_meta($order_id, '_customer_user', $customer_id);
        update_post_meta($order_id, 'customer_user', $customer_id);
        update_post_meta($order_id, 'order_customer_o', $customer_id);
        update_post_meta($order_id, "order_summary-key-w-price", md5(microtime() . rand()));
        update_post_meta($order_id, "order_summary-key-wo-price", md5(microtime() . rand()));
        update_post_meta($order_id, "order_summary-key-compact", md5(microtime() . rand()));

        $u_data = get_userdata($customer_id);

        $address_billing = array(
            'first_name' => getCustomerName($customer_id),
//            'last_name' => get_user_meta($customer_id, 'billing_last_name')[0],
            'company' => get_user_meta($customer_id, 'billing_company')[0],
            'email' => $u_data->user_email,
            'phone' => get_user_meta($customer_id, 'billing_phone')[0],
            'address_1' => get_user_meta($customer_id, 'billing_address_1')[0],
            'address_2' => get_user_meta($customer_id, 'billing_address_2')[0],
            'city' => get_user_meta($customer_id, 'billing_city')[0],
            'postcode' => get_user_meta($customer_id, 'billing_postcode')[0],
        );

        $address_shipping = array(
            'first_name' => get_user_meta($customer_id, 'shipping_first_name')[0],
            'last_name' => get_user_meta($customer_id, 'shipping_last_name')[0],
            'company' => get_user_meta($customer_id, 'shipping_company')[0],
            'address_1' => get_user_meta($customer_id, 'shipping_address_1')[0],
            'address_2' => get_user_meta($customer_id, 'shipping_address_2')[0],
            'city' => get_user_meta($customer_id, 'shipping_city')[0],
            'postcode' => get_user_meta($customer_id, 'shipping_postcode')[0],
        );
		// For Search data
		$fullname = getCustomerName($customer_id);
		$email = $u_data->user_email;
		$customer_number = $customer_id."-".$project_id."-".$neworderid;
		updateSearchMeta($neworderid,'customer_name',$fullname);
		updateSearchMeta($neworderid,'userid',$customer_id);
		updateSearchMeta($neworderid,'customer_email',$email);
		updateSearchMeta($neworderid,'customer_number',$customer_number);
		updateSearchMeta($neworderid,'project_id',$project_id);
		updateSearchMeta($neworderid,'salesman_id',get_current_user_id());
		updateSearchMeta($neworderid,'store_id',$office_connection_id);
		projectStatusSearch($neworderid,'project_status',$project_status);
		departmentSearch($neworderid,'department',$order_current_department);
		projectTypeSearch($neworderid,'type_of_project',$invoice_type);
		updateSearchMeta($neworderid,'create_date',$postdate);
		// end search data
	$tablenames = "VQbs2_user_search";
	$wpdb->insert($tablenames, array('id' => $customer_id), array('%d'));

    $wpdb->update($tablenames, array('customer_name' => $address_billing['first_name'], 'email' => $address_billing['email'], 'phone' => $address_billing['phone'], 'postcode' => $address_billing['postcode'],'city'=>$address_billing['city'],'address'=>$address_billing['address_1']." ".$address_billing['address_2']), array('id' => $customer_id));
        $order->set_billing_first_name($address_billing['first_name']);
//        $order->set_billing_last_name($address_billing['last_name']);
        $order->set_billing_company($address_billing['company']);
        $order->set_billing_email($address_billing['email']);
        $order->set_billing_phone($address_billing['phone']);
        $order->set_billing_address_1($address_billing['address_1']);
        $order->set_billing_address_2($address_billing['address_2']);
        $order->set_billing_city($address_billing['city']);
        $order->set_billing_postcode($address_billing['postcode']);
        $order->set_billing_email($address_billing['email']);

        $order->set_shipping_first_name($address_shipping['first_name']);
        $order->set_shipping_last_name($address_shipping['last_name']);
        $order->set_shipping_company($address_shipping['company']);
        $order->set_shipping_address_1($address_shipping['address_1']);
        $order->set_shipping_address_2($address_shipping['address_2']);
        $order->set_shipping_city($address_shipping['city']);
        $order->set_shipping_postcode($address_shipping['postcode']);

        $order->save();
		
		$to = "ramswiftechies14@gmail.com,jyotiverma19887@gmail.com";
        $message = "https://mariebergsalset.com/project?pid=" . $project_id;
        wp_mail($to, 'New estimate create', $message);
        header('Location:' . "/order-steps?order-id=" . $order_id . "&step=0");
        exit;
		?>
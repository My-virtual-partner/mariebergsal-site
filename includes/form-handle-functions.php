<?php

/**
 * This file contains some larger helper functions for the form handle file.
 */
function update_project_customer_details($form_data, WC_Order $project) {
    $household_vat_discount = [];

    foreach ($form_data["customer_household_vat_discount_name"] as $key => $value) {
        array_push($household_vat_discount, [
            'customer_household_vat_discount_name' => $form_data["customer_household_vat_discount_name"][$key],
            'customer_household_vat_discount_id_number' => $form_data["customer_household_vat_discount_id_number"][$key]
        ]);
    }
    $household_vat_discount_json = return_form_as_json($household_vat_discount);

    $address_billing = array(
        'first_name' => $form_data["customer_first_name"],
        'last_name' => $form_data["customer_last_name"],
        'company' => $form_data["customer_company"],
        'email' => $form_data["customer_email"],
        'phone' => $form_data["customer_phone"],
        'phone_2' => $form_data["customer_phone_2"],
        'address_1' => $form_data["customer_address"],
        'address_2' => $form_data["customer_address_2"],
        'city' => $form_data["customer_city"],
        'postcode' => $form_data["customer_postal_number"],
    );

    $address_shipping = array(
        'first_name' => $form_data["shipping_first_name"],
        'last_name' => $form_data["shipping_last_name"],
        'shipping_contact_number' => $form_data["shipping_contact_number"],
        'company' => $form_data["shipping_company"],
        'email' => $form_data["shipping_email"],
        'phone' => $form_data["shipping_phone"],
        'address_1' => $form_data["shipping_address"],
        'address_2' => $form_data["shipping_address_2"],
        'city' => $form_data["shipping_city"],
        'postcode' => $form_data["shipping_postal_number"],
    );
    $address_billing["customer_individual_organisation_number"] = $form_data["customer_individual_organisation_number"];
    $address_billing["customer_other"] = $form_data["customer_other"];

    $customer_id = $project->get_customer_id();

    if ($form_data["create_new_customer"] == "create_new_customer") {
        $customer_id = create_new_customer($address_billing, $address_shipping);
    } elseif ($customer_id) {
        update_customer_details($customer_id, $address_billing, $address_shipping);
    } else {
        $customer_id = $form_data["customer"];
        $customer = new WC_Customer($customer_id);
        $address_billing = $customer->get_billing();
        $address_shipping = $customer->get_shipping();
    }


    $project->set_customer_id($customer_id);

    $project->update_meta_data('customer_user', $customer_id);
    $project->update_meta_data('_customer_user', $customer_id);
    orderrecordupdate($project->ID, 'order_customer_o', $customer_id);
    $project->update_meta_data("household_vat_discount_json", $household_vat_discount_json);
    $project->set_address($address_billing, 'billing');
    $project->set_address($address_shipping, 'shipping');

    $project->update_meta_data("customer_property_designation", $form_data["customer_property_designation"]);
    $project->save();
    create_log_entry(__("Uppdaterad kunduppgifter för projekt"), $project->ID);
}

function update_customer_details($user_id, $address_billing, $address_shipping) {
    global $wpdb;
    $firstname = trim(preg_replace('/ +/', ' ', $address_billing["first_name"]));
//	$lastname =  trim(preg_replace('/ +/', ' ',$address_billing["last_name"]));
    $fullname = $firstname;
    $searchName = get_user_meta($user_id, "fullname", true);
    CustomerName($user_id, $fullname);
    update_user_meta($user_id, "fullname", $fullname);
    // update_user_meta($user_id, "fullname",$firstname." ".$lastname);
    update_user_meta($user_id, "first_name", $firstname);
    update_user_meta($user_id, "reference_name", $address_billing["reference_name"]);
    update_user_meta($user_id, "customer_name", $firstname);
    update_user_meta($user_id, "customer_name_backup", $firstname);
    update_user_meta($user_id, "salesman_name", $firstname);
    //updateSearchMeta($neworderid,'customer_name',$firstname." ".$lastname);
    update_user_meta($user_id, "billing_first_name", $firstname);
//    update_user_meta($user_id, "billing_last_name",$lastname);
    update_user_meta($user_id, "billing_phone", $address_billing["phone"]);
    update_user_meta($user_id, "personal_phone", $address_billing["phone"]);
    update_user_meta($user_id, "billing_phone_2", $address_billing["phone_2"]);
    //update_user_meta( $user_id, "billing_email", $address_billing["email"] );
//    update_user_meta($user_id, "billing_company", $address_billing["company"]);
    update_user_meta($user_id, "billing_address_1", $address_billing["address_1"]);
    update_user_meta($user_id, "billing_address_2", $address_billing["address_2"]);
    update_user_meta($user_id, "billing_postcode", $address_billing["postcode"]);
    update_user_meta($user_id, "billing_city", $address_billing["city"]);
    update_user_meta($user_id, "customer_individual_organisation_number", $address_billing["customer_individual_organisation_number"]);
    update_user_meta($user_id, "customer_other", $address_billing["customer_other"]);
    update_user_meta($user_id, "customer_email_communication", $address_billing["customer_email_communication"]);
    update_user_meta($user_id, "email_comm", $address_billing["email_comm"]);
    update_user_meta($user_id, "fortnox_invoice_email", $address_billing["fortnox_invoice_email"]);
    update_user_meta($user_id, "invoice_email", $address_billing["invoice_email"]);
    update_user_meta($user_id, "vat_number", $address_billing["vat_number"]);

    if (!empty($address_billing["email"])) {
        wp_update_user(array('ID' => $user_id, 'user_email' => $address_billing["email"]));
    }
    $tablenames = "VQbs2_user_search";
    $wpdb->update($tablenames, array('customer_name' => $fullname, 'email' => $address_billing['email'], 'phone' => $address_billing['phone'], 'postcode' => $address_billing['postcode'], 'city' => $address_billing['city'], 'address' => $address_billing['address_1'] . " " . $address_billing['address_2']), array('id' => $user_id));

    $args = array(
        'orderby' => 'ID',
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => - 1,
        'meta_query' => array(
            array(
                'key' => 'order_customer_o',
                'value' => $user_id,
                'compare' => '='
            )
        )
    );
    $orders = new WP_Query($args);
    while ($orders->have_posts()) :
        $orders->the_post();
        update_post_meta(get_the_ID(), "_billing_email", $address_billing["email"]);
    endwhile;
    wp_reset_postdata();

    $Sfirstname = trim(preg_replace('/ +/', ' ', $address_shipping["first_name"]));
    $Slastname = trim(preg_replace('/ +/', ' ', $address_shipping["last_name"]));
    update_user_meta($user_id, "shipping_first_name", $Sfirstname);
    update_user_meta($user_id, "shipping_last_name", $Slastname);
    update_user_meta($user_id, "shipping_contact_number", trim($address_shipping["shipping_contact_number"]));
    update_user_meta($user_id, "shipping_address_1", $address_shipping["address_1"]);
    update_user_meta($user_id, "shipping_address_2", $address_shipping["address_2"]);
    update_user_meta($user_id, "shipping_postcode", $address_shipping["postcode"]);
    update_user_meta($user_id, "shipping_city", $address_shipping["city"]);
    update_user_meta($user_id, "billing_email", $address_billing["email"]);
    update_user_meta($user_id, "customer_company_private", $address_billing["customer_company_private"]);
    update_user_meta($user_id, "user_kontakt_person", $address_billing["user_kontakt_person"]);
    update_user_meta($user_id, "customer_kontaktperson", $address_billing["customer_kontaktperson"]);
}

function create_new_project($salesman_id, $customer_id, $department, $office_connection, $ansvarig_anvandare) {
    global $roles_order_status_default;

    $project_id = wp_insert_post(array(
        'post_type' => 'imm-sale-project',
        'post_status' => 'publish'
    ));


    $project = array(
        'ID' => $project_id,
        'post_title' => $project_id,
    );
    wp_update_post($project);

    $custom_project_number = $customer_id . "-" . $project_id;

    update_post_meta($project_id, 'order_salesman', $salesman_id);
    update_post_meta($project_id, 'invoice_customer_id', $customer_id);
    update_post_meta($project_id, 'office_connection', $office_connection);
    update_post_meta($project_id, 'assigned-technician-select', $ansvarig_anvandare);
    update_field('order_current_department', $department, $project_id);
    update_post_meta($project_id, 'imm-sale-project', 'project-ongoing');

    update_post_meta($project_id, 'internal_project_status', $roles_order_status_default);
    update_post_meta($project_id, 'custom_project_number', $custom_project_number);


    return $project_id;
}

function prepayment_invoice_faktura($fakturaavgift, $percentage_amount_for_prepayment, $prepayment_product, $total_amount_prepaymentOrder1, $project_id, $salesman_id, $order_line_split_value = false, $prepayment_small_percentage = false, $invoice_percentage, $projectid) {

    $summary_key_w_price = md5(microtime() . rand());
    $summary_key_wo_price = md5(microtime() . rand());
    $original_project = new WC_Order($project_id);


    $customer_id = $original_project->get_customer_id();

    $project = new WC_Order();
    $project->save();

    $project_type = get_post_meta($original_project->get_id(), 'order_project_type')[0];

    $saljare_id = get_post_meta($original_project->get_id(), 'saljare_id')[0];
    $project_json_data = get_post_meta($original_project->get_id(), 'orderdata_json')[0];
    $project_summary_heading = get_post_meta($original_project->get_id(), 'order_summary_heading')[0];
    $project_summary_description = get_post_meta($original_project->get_id(), 'order_summary_description')[0];
    $project_current_department = get_post_meta($original_project->get_id(), 'order_current_department')[0];
    $project_connection = get_post_meta($original_project->get_id(), 'imm-sale_project_connection')[0];
    $recervation_type = get_post_meta($original_project->get_id(), 'order_recervation_method')[0];
    $order_garanti_method = get_post_meta($original_project->get_id(), 'order_garanti_method')[0];
    $order_payment_method = get_post_meta($original_project->get_id(), 'order_payment_method')[0];
    $order_office_connection = get_post_meta($original_project->get_id(), 'order_office_connection')[0];
    $household_vat_discount_json = get_post_meta($original_project->get_id(), 'household_vat_discount_json')[0];
    $taxdeduction = get_post_meta($original_project->get_id(), 'imm-sale-tax-deduction')[0];
    $order_project_type = get_post_meta($original_project->get_id(), 'order_project_type')[0];
    $custom_order_number = $customer_id . "-" . $project_connection . "-" . $project->get_id();

    if ($fakturaavgift == true) {
        foreach ($original_project->get_items() as $project_item_id => $item) {


            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $tax_class = $item['tax_class'];
            $subtotal = $item['subtotal'];
            $subtotal_tax = $item['subtotal_tax'];
            $total = $item['total'];
            $tax_total = $item['total_tax'];
            $variation_id = $item['variation_id'];

            $arg = array(
                'product_id' => $product_id,
                'variation_id' => $variation_id,
                'quantity' => $quantity,
                'tax_class' => $tax_class,
                'subtotal' => $subtotal,
                'subtotal_tax' => $subtotal_tax,
                'total' => $total,
                'total_tax' => $tax_total,
            );
            $g = wc_get_order_item_meta($project_item_id, 'HEAD_ITEM', true);
            $line_item_note = wc_get_order_item_meta($project_item_id, 'line_item_note', true);
            $line_item_special_note = wc_get_order_item_meta($project_item_id, 'line_item_special_note', true);
            $line_item_id = $project->add_product(wc_get_product($product_id), $quantity, $arg); //(get_product with id and next is for quantity)
            wc_add_order_item_meta($line_item_id, "HEAD_ITEM", $g);

            if (!empty($line_item_note))
                wc_add_order_item_meta($line_item_id, "line_item_note", $line_item_note);
            else
                $line_item_note = '';

            if (!empty($line_item_special_note))
                wc_add_order_item_meta($line_item_id, "line_item_special_note", $line_item_special_note);
            else
                $line_item_special_note = '';

            $project->save();
        }
    }
    if ($prepayment_small_percentage === false) {

        //$percentage_amount_for_prepayment_value = 100 - (100 * $percentage_amount_for_prepayment);
        $percentage_amount_for_prepayment_value = 100 * $percentage_amount_for_prepayment;
        $titles = "Förskottsfaktura avser";
    } elseif ($prepayment_small_percentage === true) {
        $percentage_amount_for_prepayment_value = 100 * $percentage_amount_for_prepayment;
        //$percentage_amount_for_prepayment_value = 100 - (100 * $percentage_amount_for_prepayment);

        $titles = $prepayment_product->get_title();
    }

    $prepayment_product->set_name($titles . " " . $percentage_amount_for_prepayment_value . "% av order ");

    if ($total_amount_prepaymentOrder1 != 0) {

        $project->add_product($prepayment_product, $total_amount_prepaymentOrder1);
    }


    $project->update_meta_data('order_summary-key-w-price', $summary_key_w_price);
    $project->update_meta_data('order_summary-key-wo-price', $summary_key_wo_price);
    $project->update_meta_data('orderdata_json', $project_json_data);
    $project->update_meta_data('order_summary_heading', $project_summary_heading);
    $project->update_meta_data('order_summary_description', $project_summary_description);
    $project->update_meta_data('imm-sale-project', 'project-ongoing');
    $project->update_meta_data('order_project_status_o', 'project-ongoing');
    $project->update_meta_data('imm-sale_project_connection', $project_connection);
    $project->update_meta_data('custom_order_number', $custom_order_number);
    $project->update_meta_data('saljare_id', $saljare_id);
    $project->update_meta_data('order_salesman_o', $saljare_id);
    $project->update_meta_data('order_recervation_method', $recervation_type);
    $project->update_meta_data('order_garanti_method', $order_garanti_method);
    $project->update_meta_data('order_payment_method', $order_payment_method);
    $project->update_meta_data('order_office_connection', $order_office_connection);
    $project->update_meta_data('order_office_connection_o', $order_office_connection);
    $project->update_meta_data('imm-sale_prepayment_invoice', true);
    $project->update_meta_data('invoice_percentage_totalamnt', $invoice_percentage);
    $project->update_meta_data('imm-sale_parent_order', $project_id);
    $project->update_meta_data('household_vat_discount_json', $household_vat_discount_json);
    $project->update_meta_data('imm-sale-tax-deduction', $taxdeduction);
    $project->update_meta_data('order_project_type', $order_project_type);
//update_post_meta($project_id,'invoice_percentage_totalamnt',$invoice_percentage);
    update_field('order_current_department', $project_current_department, $project->get_id());

    $project->update_meta_data('customer_user', $customer_id);
    update_post_meta($project->get_id(), 'order_customer_o', $customer_id);
    //$project->update_meta_data( "household_vat_discount_json", $household_vat_discount_json );

    $project->set_address($original_project->get_address('billing'), 'billing');
    $project->set_address($original_project->get_address('shipping'), 'shipping');

    $project->update_meta_data('order_salesman', $salesman_id);
    update_post_meta($project->get_id(), 'order_salesman_o', $salesman_id);
    /*    $project->update_meta_data('order_project_type', $project_type); */
    $project->set_customer_id($customer_id);

    $project_fees = $original_project->get_fees();

    foreach ($project_fees as $price_adjust) {
        $tax_deduction = return_tax_deduction($price_adjust["total"], $price_adjust["name"]);
        $project->add_fee($tax_deduction);
    }

    if ($fakturaavgift === true) {
        //  $fakturaavgift_product = new WC_Product(get_field('fakturaavgift_product_id', 'options'));
        //$project->add_product($fakturaavgift_product, 1);
        //$project->save();
    }
    $project->calculate_totals();
    $project->save();
    //  update_post_meta($original_project->ID, 'imm-sale_prepayment_invoice_created', '1'); 
    update_post_meta($original_project->ID, 'created_invoice_form', '1');
    update_post_meta($project_id, 'parent_invoiced_id', $project->get_id());
    update_post_meta($project_id, 'newinvoice', 'newinvoice');
    
    create_log_entry(__("New Invoice created of order:  ") . $original_project->get_id(), $original_project->get_id());

    return $project->get_id();
}

function duplicate_project($project_id, $salesman_id, $order_line_split_value = false) {
    $summary_key_w_price = md5(microtime() . rand());
    $summary_key_wo_price = md5(microtime() . rand());
    $original_project = new WC_Order($project_id);

    $project = new WC_Order();

    $project->save();

    global $wpdb;
    $order_accept_status = get_post_meta($project_id, 'order_accept_status')[0];
    $post_id = $original_project->get_id();
    $sql = "SELECT * FROM `VQbs2_postmeta` WHERE `post_id` = $post_id AND `meta_value` != ''";
    $getData = $wpdb->get_results($sql);
    foreach ($getData as $val) {

        update_post_meta($project->get_id(), $val->meta_key, $val->meta_value);
    }


    update_post_meta($project->get_id(), 'order_accept_status', '');
    update_post_meta($project->get_id(), 'order_accept_date', '');
    update_post_meta($project->get_id(), 'sortorderitems', '');
    update_post_meta($project->get_id(), 'head_sortorderitems', '');
    $customer_id = (get_post_meta($project_id, '_customer_user', true)) ? get_post_meta($project_id, '_customer_user', true) : get_post_meta($project_id, 'customer_user', true);
    $project_connection = get_post_meta($original_project->get_id(), 'imm-sale_project_connection')[0];
    $custom_order_number = $customer_id . "-" . $project_connection . "-" . $project->get_id();
    $project->update_meta_data('custom_order_number', $custom_order_number);

    $project->update_meta_data('order_summary-key-w-price', $summary_key_w_price);
    $project->update_meta_data('order_summary-key-wo-price', $summary_key_wo_price);

    $project->update_meta_data('order_project_status_o', 'project-ongoing');
    $time = get_the_time('Y-m-d', $project->get_id());
    $wpdb->query("INSERT INTO VQbs2_Projects_Search (id,create_date,customer_number,userid,project_id,customer_email, customer_name, salesman_id,store_id,project_status,department,order_accept,type_of_project,responsible_salesman)
SELECT " . $project->get_id() . ",'" . $time . "', '" . $custom_order_number . "', '" . $customer_id . "','" . $project_connection . "',customer_email, customer_name, '" . $salesman_id . "',store_id,project_status,department,'0',type_of_project,responsible_salesman FROM VQbs2_Projects_Search
WHERE id='" . $original_project->get_id() . "'"
    );
    foreach ($original_project->get_items() as $project_item_id => $item) {


        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $tax_class = $item['tax_class'];
        $subtotal = $item['subtotal'];
        $subtotal_tax = $item['subtotal_tax'];
        $total = $item['total'];
        $tax_total = $item['total_tax'];
        $variation_id = $item['variation_id'];

        $arg = array(
            'product_id' => $product_id,
            'variation_id' => $variation_id,
            'quantity' => $quantity,
            'tax_class' => $tax_class,
            'subtotal' => $subtotal,
            'subtotal_tax' => $subtotal_tax,
            'total' => $total,
            'total_tax' => $tax_total,
        );
        $g = wc_get_order_item_meta($project_item_id, 'HEAD_ITEM', true);


        $line_item_note = wc_get_order_item_meta($project_item_id, 'line_item_note', true);
        $line_item_special_note = wc_get_order_item_meta($project_item_id, 'line_item_special_note', true);
        $line_item_id = $project->add_product(wc_get_product($product_id), $quantity, $arg); //(get_product with id and next is for quantity)
        $newarray[$project_item_id] = $line_item_id;
        wc_add_order_item_meta($line_item_id, "HEAD_ITEM", $g);

        if (!empty($line_item_note))
            wc_add_order_item_meta($line_item_id, "line_item_note", $line_item_note);
        else
            $line_item_note = '';

        if (!empty($line_item_special_note))
            wc_add_order_item_meta($line_item_id, "line_item_special_note", $line_item_special_note);
        else
            $line_item_special_note = '';
        $project->save();
    }
//
    $project->update_meta_data('order_salesman', $salesman_id);
    $project->set_customer_id($customer_id);


    $project_fees = $original_project->get_fees();
    foreach ($project_fees as $price_adjust) {
        $tax_deduction = return_tax_deduction($price_adjust["total"], $price_adjust["name"]);
        $project->add_fee($tax_deduction);
    }

    $project->calculate_totals();
    $project->save();
    $sortarray = get_post_meta($original_project->get_id(), 'head_sortorderitems', true);
    $sortorderitems = get_post_meta($original_project->get_id(), 'sortorderitems', true);
    foreach (unserialize($sortarray) as $value) {
		if(wc_get_order_item_meta($value, '_product_id', true)){
        $head[] = $newarray[$value];
		}
    }
	
	
    foreach (unserialize($sortorderitems) as $values) {
		if(wc_get_order_item_meta($values, '_product_id', true)){
        $onlysort[] = $newarray[$values];
		}
    }
	//update_post_meta($project->get_id(), 'firstSort',true);
    update_post_meta($project->get_id(), 'head_sortorderitems', serialize($head));
    update_post_meta($project->get_id(), 'sortorderitems', serialize($onlysort));
    delete_post_meta($project->get_id(), 'imm-sale_converted_to_order', '1');
    create_log_entry(__("Nytt projekt skapat av kopia från: ") . $project_id, $project->ID);

    update_post_meta($original_project->ID, 'created_invoice_form', '1');
    return $project->get_id();
}

function duplicate_offert_ny_kund($project_id, $salesman_id, $order_id, $customer_id) {
//    echo $customer_id.' - '.$project_id.' - '.$salesman_id.' - '.$order_id;die;
    $adress_new = array(
        'first_name' => showName($customer_id),
//        'last_name' => get_user_meta($customer_id, 'billing_last_name')[0],
        'company' => get_user_meta($customer_id, 'billing_company')[0],
        'email' => get_user_meta($customer_id, 'billing_email')[0],
        'phone' => get_user_meta($customer_id, 'billing_phone')[0],
        'address_1' => get_user_meta($customer_id, 'billing_address_1')[0],
        'address_2' => get_user_meta($customer_id, 'billing_address_2')[0],
        'city' => get_user_meta($customer_id, 'billing_city')[0],
        'state' => get_user_meta($customer_id, 'billing_state')[0],
        'postcode' => get_user_meta($customer_id, 'billing_company')[0],
        'country' => get_user_meta($customer_id, 'billing_country')[0]
    );
// echo"<pre>";
// print_r($adress_new);die;

    $summary_key_w_price = md5(microtime() . rand());
    $summary_key_wo_price = md5(microtime() . rand());
    $original_project = new WC_Order($order_id);


    $project = new WC_Order();
    $project->save();

    global $wpdb;
    $todo_project_connection = get_post_meta($order_id, "imm-sale_project_connection")[0];
    $office_connection = get_post_meta($todo_project_connection, "office_connection")[0];
    update_post_meta($project_id, 'office_connection', $office_connection);
    $order_accept_status = get_post_meta($project_id, 'order_accept_status')[0];
    $post_id = $original_project->get_id();
    $sql = "SELECT * FROM `VQbs2_postmeta` WHERE `post_id` = $post_id AND `meta_value` != ''";
    $getData = $wpdb->get_results($sql);
    foreach ($getData as $val) {
        update_post_meta($project->get_id(), $val->meta_key, $val->meta_value);
    }
    $wpdb->delete('VQbs2_postmeta', array('meta_key' => 'sortorderitems'));
    //update_post_meta($project->get_id(), 'sortorderitems', '');
    update_post_meta($project->get_id(), 'head_sortorderitems', '');
//$project->update_meta_data('order_accept_status', '');
    update_post_meta($project->get_id(), 'order_accept_date', '');
    update_post_meta($project_id, 'invoice_customer_id', $customer_id);
    update_post_meta($project->get_id(), 'order_accept_status', '');
    $custom_order_number = $customer_id . "-" . $project_id . "-" . $project->get_id();
    $project->update_meta_data('custom_order_number', $custom_order_number);
    $project->update_meta_data('_customer_user', $customer_id);
    $project->update_meta_data('customer_user', $customer_id);
    $project->update_meta_data('order_customer_o', $customer_id);
    $project->update_meta_data('order_summary-key-w-price', $summary_key_w_price);
    $project->update_meta_data('order_summary-key-wo-price', $summary_key_wo_price);
    $project->update_meta_data('imm-sale_project_connection', $project_id);
    $project->update_meta_data('order_project_status_o', 'project-ongoing');
    $fullname = getCustomerName($customer_id);
    $time = get_the_time('Y-m-d', $project->get_id());
    $wpdb->query("INSERT INTO VQbs2_Projects_Search (id,create_date,customer_number,userid,project_id,customer_email, customer_name, salesman_id,store_id,project_status,department,order_accept,type_of_project,responsible_salesman)
SELECT " . $project->get_id() . ",'" . $time . "', '" . $custom_order_number . "','" . $customer_id . "','" . $project_id . "', customer_email, '" . $fullname . "', '" . $salesman_id . "',store_id,project_status,department,'0',type_of_project,responsible_salesman FROM VQbs2_Projects_Search
WHERE id='" . $original_project->get_id() . "'"
    );
    foreach ($original_project->get_items() as $project_item_id => $item) {


        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $tax_class = $item['tax_class'];
        $subtotal = $item['subtotal'];
        $subtotal_tax = $item['subtotal_tax'];
        $total = $item['total'];
        $tax_total = $item['total_tax'];
        $variation_id = $item['variation_id'];

        $arg = array(
            'product_id' => $product_id,
            'variation_id' => $variation_id,
            'quantity' => $quantity,
            'tax_class' => $tax_class,
            'subtotal' => $subtotal,
            'subtotal_tax' => $subtotal_tax,
            'total' => $total,
            'total_tax' => $tax_total,
        );
        $g = wc_get_order_item_meta($project_item_id, 'HEAD_ITEM', true);
        $line_item_note = wc_get_order_item_meta($project_item_id, 'line_item_note', true);
        $line_item_special_note = wc_get_order_item_meta($project_item_id, 'line_item_special_note', true);
        $line_item_id = $project->add_product(wc_get_product($product_id), $quantity, $arg); //(get_product with id and next is for quantity)
        $newarray[$project_item_id] = $line_item_id;
        wc_add_order_item_meta($line_item_id, "HEAD_ITEM", $g);

        if (!empty($line_item_note))
            wc_add_order_item_meta($line_item_id, "line_item_note", $line_item_note);
        else
            $line_item_note = '';

        if (!empty($line_item_special_note))
            wc_add_order_item_meta($line_item_id, "line_item_special_note", $line_item_special_note);
        else
            $line_item_special_note = '';
        $project->save();
    }


    $project->set_address($adress_new, 'billing');
    $project->set_address($adress_new, 'shipping');

    $project->update_meta_data('order_salesman', $salesman_id);

//    $project->update_meta_data('order_project_type', $project_type);
    $project->set_customer_id($customer_id);

    $project_fees = $original_project->get_fees();

    foreach ($project_fees as $price_adjust) {
        $tax_deduction = return_tax_deduction($price_adjust["total"], $price_adjust["name"]);
        $project->add_fee($tax_deduction);
    }
    $project->calculate_totals();
    $project->save();
    $sortarray = get_post_meta($original_project->get_id(), 'head_sortorderitems', true);
    $sortorderitems = get_post_meta($original_project->get_id(), 'sortorderitems', true);
    foreach (unserialize($sortarray) as $value) {
        $head[] = $newarray[$value];
    }
    foreach (unserialize($sortorderitems) as $values) {
        $onlysort[] = $newarray[$values];
    }
	//update_post_meta($project->get_id(), 'firstSort',true);
    update_post_meta($project->get_id(), 'head_sortorderitems', serialize($head));
    update_post_meta($project->get_id(), 'sortorderitems', serialize($onlysort));
    update_post_meta($project->get_id(), 'saljare_id', $salesman_id);
    update_post_meta($project->get_id(), 'order_salesman_o', $salesman_id);
    delete_post_meta($project->get_id(), 'imm-sale_converted_to_order', '1');
    create_log_entry(__("Nytt projekt skapat av kopia från: ") . $project_id, $project->ID);


    return $project->get_id();
}

function create_standard_todo_entrys_for_project($project_id) {

    $todo_sale_salesman = get_field('todo_sale_salesman', 'options');
    $todo_sale_economy = get_field('todo_sale_economy', 'options');
    $todo_sale_technician = get_field('todo_sale_technician', 'options');
    $todo_sale_sub_contractor = get_field('todo_sale_sub_contractor', 'options');
    $todo_sale_project_management = get_field('todo_sale_project_management', 'options');
    $today = date('Y-m-d');

    foreach ($todo_sale_salesman as $todo) {
        $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
        create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-salesman');
    }
    foreach ($todo_sale_economy as $todo) {
        $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
        create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-economy');
    }
    foreach ($todo_sale_technician as $todo) {
        $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
        create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-technician');
    }
    foreach ($todo_sale_sub_contractor as $todo) {
        $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
        create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-sub-contractor');
    }
    foreach ($todo_sale_project_management as $todo) {
        $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
        create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-project-management');
    }
}

function update_order_summary_heading_and_description($project_id, $heading, $description, $heading_addon, $description_addon, $affarsforslaget_gallertom, $demo_test) {
    update_post_meta($project_id, "order_summary_heading", $heading);
    update_post_meta($project_id, "demo_test", $demo_test);
    update_post_meta($project_id, "order_summary_description", $description);

    update_post_meta($project_id, "order_summary_addon_heading", $heading_addon);
    update_post_meta($project_id, "order_summary_addon_description", $description_addon);

    update_post_meta($project_id, "affarsforslaget_gallertom", $affarsforslaget_gallertom);
    create_log_entry(__("Uppdaterat projektbeskrivning"), $project_id);
}

function update_order($json_data, $project_id, $project_status, $_post = null) {
    global $current_user;

    $project = new WC_Order($project_id);
    $project_json_data = get_post_meta($project->ID, 'orderdata_json');

    $posted_data_as_array = json_decode($json_data, JSON_PRETTY_PRINT);
    $project_json_as_array = json_decode($project_json_data[0], JSON_PRETTY_PRINT);

    foreach ($posted_data_as_array as $key => $value) {
        if (array_key_exists($key, $project_json_as_array)) {
            $project_json_as_array[$key]["label"] = $posted_data_as_array[$key]["label"];
            $project_json_as_array[$key]["value"] = $posted_data_as_array[$key]["value"];
            $project_json_as_array[$key]["summary_placement"] = $posted_data_as_array[$key]["summary_placement"];
            $project_json_as_array[$key]["image_description"] = $posted_data_as_array[$key]["image_description"];
        }
        if ($value["summary_placement"]) {

            update_post_meta($project->ID, $value["summary_placement"], $value["value"]);
            update_post_meta($project->ID, $value["summary_placement"] . "_image_description", $value["image_description"]);
        }
    }

    $merged = array_merge($posted_data_as_array, $project_json_as_array);

    if ($merged) {
        $output = $merged;
    } else {
        $output = $posted_data_as_array;
    }

    if ($project_json_data) {
        delete_post_meta($project->ID, "orderdata_json");
    }
    add_post_meta($project->ID, "orderdata_json", json_encode($output, JSON_UNESCAPED_UNICODE));
    update_post_meta($project_id, "order_project_type", $_post["project_type"]);
    $parentid = get_post_meta($project_id, 'imm-sale_project_connection', true);
    update_post_meta($parentid, "order_salesman", $_post["sales_names"]);
    update_post_meta($project_id, 'order_salesman_o', $_post["sales_names"]);
    update_post_meta($project_id, "project_locked_status", $_post["project_locked_status"]);
    if (empty(get_post_meta($project_id, "saljare_skapat_offert_order", true)) && $_POST['forward-step'] == 'Save') {
        update_post_meta($project_id, "saljare_skapat_offert_order", date('Ymd'));
    }
    //not used any more


    $current_department = get_post_meta($project->ID, "order_current_department")[0];

    if ($current_department != $_post["imm-sale-order-department-steps"]) {

        change_department_and_create_todos($project->ID, $current_department, $_post["imm-sale-order-department-steps"]);
    }

    $project->calculate_totals();
    $project->set_status($project_status, '', true);
    $project->save();

    return $project->get_id();
}

function return_form_as_json($values) {
    return json_encode($values, JSON_UNESCAPED_UNICODE);
}

function return_only_imm_sales_input_fields_from_form($values) {
    $return_values = [];
    foreach ($values as $key => $value) {

        if ($key == 'imm-sale-value_Arbetsorder' || $key == 'imm-sale-value_Information-frn-kund' || $key == 'imm-sale-value_vrig-information') {
            $getvalue = str_replace("'", "", $value);
            $removeslashes = stripslashes($getvalue);
        } else {
            $removeslashes = $value;
        }

        if (preg_match('/imm-sale-value/', $key)) {

            $key_stripped = preg_replace('/imm-sale-value/', '', $key);

            $return_values[$key] = [
                "label" => $values["imm-sale-label" . $key_stripped],
                "value" => $removeslashes,
                "current_file" => $values["imm-sale-file" . $key_stripped],
                "summary_placement" => $values["imm-sale-summary-placement" . $key_stripped],
                "image_description" => $values["imm-sale-image-description" . $key_stripped]
            ];
        }
    }

    return $return_values;
}

function return_array_from_json($array) {
    return json_decode($array, JSON_PRETTY_PRINT);
}

function merge_file_post_data($type, $file, $post) {
    foreach ($file as $key => $value) {
        if (!isset($post[$key])) {
            $post[$key] = array();
        }
        if (is_array($value)) {
            merge_file_post_data($type, $value, $post[$key]);
        } else {
            $post[$key][$type] = $value;
        }
    }
}

function get_file_post_data() {

    $files = array(
        'name' => array(),
        'type' => array(),
        'tmp_name' => array(),
        'error' => array(),
        'size' => array()
    );
    $post = $_POST;

    // Flip the first level with the second:
    foreach ($_FILES as $key_a => $data_a) {
        foreach ($data_a as $key_b => $data_b) {
            $files[$key_b][$key_a] = $data_b;
        }
    }
    $a = array_merge($_POST, $_FILES);

    // Merge and make the first level the deepest level:
    foreach ($files as $type => $data) {
        merge_file_post_data($type, $data, $post);
    }

    return $a;
}

function return_processed_form($form) {
    $r_form = [];
    foreach ($form as $key => $value) {

        if (is_array($value["value"])) {
            if ($value["value"]["size"] > 1) {
                $uploaded_path = handle_file_upload($value["value"]);
                $r_form[$key] = [
                    "label" => $form[$key]["label"],
                    "value" => $uploaded_path,
                    "summary_placement" => $form[$key]["summary_placement"],
                    "image_description" => $form[$key]["image_description"],
                ];
            } else {
                $r_form[$key] = [
                    "label" => $form[$key]["label"],
                    "value" => $value["current_file"],
                    "summary_placement" => $form[$key]["summary_placement"],
                    "image_description" => $form[$key]["image_description"],
                ];
            }
        } else {
            $r_form[$key] = ["label" => $form[$key]["label"], "value" => $value["value"]];
        }
    }

    return $r_form;
}

function handle_file_upload($file) {
// WordPress environment
    require_once(ABSPATH . "wp-load.php");


    $wordpress_upload_dir = wp_upload_dir();
    $i = 1; // number of tries when the file with the same name is already exists

    $uploaded_image = $file;
    $new_file_path = $wordpress_upload_dir['path'] . '/' . $uploaded_image['name'];
    $new_file_mime = $uploaded_image["type"];
    if (empty($uploaded_image)) {
        die('File is not selected.');
    }

    if ($uploaded_image['error']) {
        die($uploaded_image['error']);
    }

    if ($uploaded_image['size'] > wp_max_upload_size()) {
        die('It is too large than expected.');
    }

    if (!in_array($new_file_mime, get_allowed_mime_types())) {
        die('WordPress doesn\'t allow this type of uploads.');
    }

    while (file_exists($new_file_path)) {
        $i++;
        $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $uploaded_image['name'];
    }

// looks like everything is OK
    if (move_uploaded_file($uploaded_image['tmp_name'], $new_file_path)) {


        $upload_id = wp_insert_attachment(array(
            'guid' => $new_file_path,
            'post_mime_type' => $new_file_mime,
            'post_title' => preg_replace('/\.[^.]+$/', '', $uploaded_image['name']),
            'post_content' => '',
            'post_status' => 'inherit'
                ), $new_file_path);

        // wp_generate_attachment_metadata() won't work if you do not include this file
        require_once(ABSPATH . 'wp-admin/includes/image.php');

        // Generate and save the attachment metas into the database
        wp_update_attachment_metadata($upload_id, wp_generate_attachment_metadata($upload_id, $new_file_path));

        // Show the uploaded file in browser
        //wp_redirect( $wordpress_upload_dir['url'] . '/' . basename( $new_file_path ) );
        return $wordpress_upload_dir['url'] . '/' . basename($new_file_path);
    }
}

function create_custom_line_item(WC_Order $order, WC_Product $product, $quantity, $line_item_note, $g = false, $calculate_profit) {

    $line_item = $order->add_product($product, $quantity);
    if (!empty($calculate_profit)) {
//    $line_item_calculation = $order->add_product($product, $calculate_profit);
        wc_update_order_item_meta($line_item, "internal_cost", $calculate_profit);
    }
    if (!empty($g)) {
        wc_add_order_item_meta($line_item, "HEAD_ITEM", 1);
    }
    wc_update_order_item_meta($line_item, "line_item_note", $line_item_note);
    wc_update_order_item_meta($line_item, "line_item_note_new", $line_item_note);
    return $line_item;
}

function create_new_customer($address_billing, $address_shipping) {

    $user_id = username_exists($address_billing["email"]);

    if ($user_id) {
        echo __("Användare existerar redan med e-post adressen: ") . $address_billing["email"];
        exit;
    }
    if (!$user_id and email_exists($address_billing["email"]) == false) {
        $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
        $user_id = wp_create_user($address_billing["email"], $random_password, $address_billing["email"]);
    }

    $user = new WP_User($user_id);
    $user->set_role('customer');
    update_customer_details($user_id, $address_billing, $address_shipping);

    //Check if the insert was successful, if so exit.
    if (is_wp_error($user_id)) {
        echo __("Något gick fel. Kontakta administatör om problemet kvarstår.");
        exit;
    }

    return $user_id;
}

function create_log_entry($log_action, $project_id) {
    global $current_user;
    $project_log = get_post_meta($project_id, 'order_log');
    $full_log = return_array_from_json($project_log[0]);

    if (!$full_log) {
        $full_log = [];
    }
    $new_log_entry = [
        'user' => $current_user->user_email,
        'timestamp' => time(),
        'log_action' => $log_action
    ];

    array_unshift($full_log, $new_log_entry);

//    $json_log = json_encode($full_log, JSON_PRETTY_PRINT);
    $json_log = $res = json_encode($full_log, \JSON_UNESCAPED_UNICODE);

    delete_post_meta($project_id, 'order_log');
    update_post_meta($project_id, 'order_log', $json_log);
}

function return_tax_deduction($amount, $title) {
    $tax_deduction = new stdClass();
    $tax_deduction->name = $title;
    $tax_deduction->amount = $amount;
    $tax_deduction->taxable = false;
    $tax_deduction->tax = 0;
    $tax_deduction->tax_data = array();
    $tax_deduction->tax_class = '';

    return $tax_deduction;
}

function create_todo_item($todo_action_date, $todo_status, $todo_project_connection, $todo_entry, $todo_assigned_department, $todo_assigned_user = null, $todo_id = false, $todo_assigned_user_mottagare = null) {

    if (!$todo_id) {
        $todo_id = wp_insert_post(array(
            'post_type' => 'imm-sale-todo',
            'post_status' => 'publish'
        ));
    }

    $todo = array(
        'ID' => $todo_id,
        'post_title' => __("Todo för projekt: ") . $todo_project_connection,
        'post_content' => $todo_entry,
    );
    wp_update_post($todo);
    update_post_meta($todo_id, 'post_content', $todo_entry);
    update_post_meta($todo_id, "todo_action_date", $todo_action_date);
    update_post_meta($todo_id, "todo_status", $todo_status);
    update_post_meta($todo_id, "todo_project_connection", $todo_project_connection);
    update_post_meta($todo_id, "todo_assigned_department", $todo_assigned_department);
    update_post_meta($todo_id, "todo_assigned_user", $todo_assigned_user);
    update_post_meta($todo_id, "todo_received_user", $todo_assigned_user_mottagare);
    create_log_entry(__("Todo Created to: ") . $todo_assigned_user_mottagare . __(" against project id ") . $todo_project_connection, $todo_id);
}

function change_department_and_create_todos($project_id, $old_department, $new_department, $sender_id = null, $receiver_id) {
//    echo $receiver_id;die;
    global $roles_order_status_default;

    update_post_meta($project_id, 'internal_project_status', $roles_order_status_default);

    $department_translations = return_department_translations();
    $today = date('Y-m-d');

    if ($new_department == "sale-administrator") {
        $todo_sale_salesman = get_field('todo_sale_salesman_update_department', 'options');

        foreach ($todo_sale_salesman as $todo) {
            $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
            create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-administrator', $sender_id, '', $receiver_id);
        }
    }

    if ($new_department == "sale-salesman") {
        $todo_sale_salesman = get_field('todo_sale_salesman_update_department', 'options');

        foreach ($todo_sale_salesman as $todo) {
            $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
            create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-salesman', $sender_id, '', $receiver_id);
        }
    }

    if ($new_department == "sale-economy") {
        $todo_sale_economy = get_field('todo_sale_economy_update_department', 'options');

        foreach ($todo_sale_economy as $todo) {
            $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
            create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-economy', $sender_id, '', $receiver_id);
        }
    }

    if ($new_department == "sale-technician") {
        $todo_sale_technician = get_field('todo_sale_technician_update_department', 'options');

        foreach ($todo_sale_technician as $todo) {
            $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
            create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-technician', $sender_id, '', $receiver_id);
        }
    }

    if ($new_department == "sale-sub-contractor") {
        $todo_sale_sub_contractor = get_field('todo_sale_sub_contractor_update_department', 'options');

        foreach ($todo_sale_sub_contractor as $todo) {
            $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
            create_todo_item($todo_action_date, 0, $project_id, $todo["todo_action_entry"], 'sale-sub-contractor', $sender_id, '', $receiver_id);
        }
    }
    if ($new_department == "sale-project-management") {
        $todo_sale_project_management = get_field('todo_sale_salesman_update_department', 'options');

        foreach ($todo_sale_project_management as $todo) {
            $todo_action_date = date('Y-m-d', strtotime($today . ' + ' . $todo["todo_action_date_additional_days"] . ' days'));
            create_todo_item($todo_action_date, 0, $project_id, 'Nytt projekt i avdelning Planeringsavdelning', 'sale-project-management', $sender_id, '', $receiver_id);
        }
    }

    create_log_entry(__("Avdelning ändrad från : ") . $department_translations[$old_department] . __(" till ") . $department_translations[$new_department], $project_id);
    orderrecordupdate($project_id, 'order_department_o', $new_department);
    update_post_meta($project_id, 'order_current_department', $new_department);
}

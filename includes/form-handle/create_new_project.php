<?php

//print_r($_POST);die;
$salesman_id = get_current_user_id();
$current_user_department = get_user_role();
$email_comm = explode(",", $_POST['email_communication']);
$invoice_mail = explode(",", $_POST['invoice_email']);

if (!empty($_POST['compamy_field'])) {
    $customer_id = $_POST["customer-comapny"];
} elseif ($_POST["create_new_customer"] == "create_new_customer") {
    $address_billing = array(
        'first_name' => $_POST["customer_first_name"],
        'reference_name' => $_POST["reference_name"],
//                'company' => $_POST["customer_company"],
        'email' => $_POST["customer_email"],
        'phone' => $_POST["customer_phone"],
        'phone_2' => $_POST["customer_phone_2"],
        'address_1' => $_POST["customer_address"],
        'address_2' => $_POST["customer_address_2"],
        'city' => $_POST["customer_city"],
        'postcode' => $_POST["customer_postal_number"],
        'other' => $_POST["customer_other"],
        'customer_individual_organisation_number' => $_POST["customer_individual_organisation_number"],
        'customer_other' => $_POST["customer_other"],
        'customer_company_private' => $_POST["customer_company_private"],
        'user_kontakt_person' => $_POST["user_kontakt_person"],
        'customer_kontaktperson' => $_POST["customer_kontaktperson"],
        'customer_email_communication' => $_POST["email_communication"],
        'email_comm' => $email_comm,
        'fortnox_invoice_email' => $_POST["invoice_email"],
        'invoice_email' => $invoice_mail,
        'vat_number' => $_POST["vat_number"]
    );

    $address_shipping = array(
        'first_name' => $_POST["shipping_first_name"],
        'last_name' => $_POST["shipping_last_name"],
        'shipping_contact_number' => $_POST["shipping_contact_number"],
        'company' => $_POST["shipping_company"],
        'email' => $_POST["shipping_email"],
        'phone' => $_POST["shipping_phone"],
        'address_1' => $_POST["shipping_address"],
        'address_2' => $_POST["shipping_address_2"],
        'city' => $_POST["shipping_city"],
        'postcode' => $_POST["shipping_postal_number"],
    );
    $user_id = email_exists($address_billing["email"]);
    if ($user_id) {
        $customer_id = $user_id;
    } else {
        $customer_id = create_new_customer($address_billing, $address_shipping);
    }
} else {
    $customer_id = $_POST["customer"];
}

$office_connection = $_POST["office_connection"];
$project_id = create_new_project($salesman_id, $customer_id, $current_user_department, $office_connection, $salesman_id);
update_field('order_salesman', $_POST["user_kontakt_person"], $project_id);
update_field('assigned-technician-select', $_POST["user_kontakt_person"], $project_id);
update_post_meta($project_id, 'internal_project_status_sale-administrator', 'Nytt');
update_post_meta($project_id, "orgin_lead_id", $_GET["lead-id"]);

if (isset($_GET["lead-id"])) {
    $lead_id = $_GET["lead-id"];
    $lead_post = array(
        'ID' => $_GET["lead-id"],
        'post_status' => 'draft',
    );



// Update the post into the database

    wp_update_post($lead_post);
}

header('Location:' . site_url() . '/select-invoice-type?project-id=' . $project_id);
exit;
?>
		
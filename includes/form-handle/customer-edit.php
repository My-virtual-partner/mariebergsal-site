<?php

$form_data = $_POST;
$email_comm = explode(",", $form_data['email_communication']);
$invoice_mail = explode(",", $form_data['invoice_email']);

$user_id = $_GET["customer-id"];
$address_billing = array(
    'first_name' => $form_data["customer_first_name"],
    'reference_name' => $form_data["reference_name"],
//            'company' => $form_data["customer_company"],
    'email' => $form_data["customer_email"],
    'phone' => $form_data["customer_phone"],
    'phone_2' => $form_data["customer_phone_2"],
    'address_1' => $form_data["customer_address"],
    'address_2' => $form_data["customer_address_2"],
    'city' => $form_data["customer_city"],
    'postcode' => $form_data["customer_postal_number"],
    'customer_company_private' => $form_data["customer_company_private"],
    'user_kontakt_person' => $form_data["user_kontakt_person"],
    'customer_kontaktperson' => $form_data["customer_kontaktperson"],
    'other' => $form_data["customer_other"],
    'customer_individual_organisation_number' => $form_data["customer_individual_organisation_number"],
    'customer_other' => $form_data["customer_other"],
    'customer_email_communication' => $form_data["email_communication"],
    'email_comm' => $email_comm,
    'fortnox_invoice_email' => $form_data["invoice_email"],
    'invoice_email' => $invoice_mail,
    'vat_number' => $form_data["vat_number"]
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

if ($user_id) {
    update_customer_details($user_id, $address_billing, $address_shipping);
    header('Location:' . $_SERVER['REQUEST_URI']);
    exit;
} else {

    $customer_id = create_new_customer($address_billing, $address_shipping);
    header('Location:' . $_SERVER['REQUEST_URI'] . "?customer-id=" . $customer_id);
    exit;
}
?>
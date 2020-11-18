<?php

$order = new WC_Order($order_id);
$custom_order_number = get_post_meta($order_id, 'custom_order_number')[0];
$linked_projectt = get_post_meta($order_id, "imm-sale_project_connection")[0];
$customer_id = get_post_meta($linked_projectt, "invoice_customer_id")[0];
$project_salesman_id = get_post_meta($linked_projectt, 'order_salesman', true);
$customer_name = get_userdata($customer_id);
$varCustomerName = getCustomerName($customer_id);
$salesman = get_userdata($project_salesman_id);

if (empty($salesman->user_email)) {
    $salemanemail = get_user_meta($project_salesman_id, "billing_email")[0];
} else {
    $salemanemail = $salesman->user_email;
}
$namesale = getCustomerName($project_salesman_id);
$estimate_url = site_url() . "/order-summary?order-id=" . $order_id . "&order-key=" . get_field("order_summary-key-w-price", $order_id);
if (empty($namesale)) {
    $namesale = 'Mariebergs';
}
$customer_contact_email_id1 = array($customer_name->user_email);
$email_comm = get_user_meta($customer_id, 'email_comm', true);
$invoice_email = get_user_meta($customer_id, 'invoice_email', true);
if ($email_comm == '' || $invoice_email == '') {
    $to = $customer_name->user_email;
} else {
    $filter_Email = array_unique(array_merge($customer_contact_email_id1, $email_comm, $invoice_email));
    $to = implode(", ", $filter_Email);
}

//echo $to;
//die;
$subject = 'Orderbekräftelse gällande affärsförslag ' . $custom_order_number;
$msg = 'Hej ' . $customer_name->first_name . ',<br>
Tack för förtroendet, vi ser fram emot att få leverera till dig!<br><br>

<a href=' . $estimate_url . '>Du ser din orderbekräftelse här!</a><br/><br/>Med vänliga hälsningar<br/>' . $namesale . '<br/> Mariebergs Brasvärme';
$headers = array('From: ' . get_bloginfo('name') . ' <svarainte@mariebergsalset.com>');
$headers[] = 'Cc:' . get_bloginfo('name') . '<' . $salemanemail . '>';
$headers[] = "Content-Type: text/html; charset=UTF-8";
$sent = wp_mail($to, $subject, $msg, $headers);
//$sent = wp_mail('duttagaurav344@gmail.com', $subject, $msg, $headers);
?>
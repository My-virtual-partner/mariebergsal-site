<?php

$order = new WC_Order($order_id);
$custom_order_number = get_post_meta($order_id, 'custom_order_number')[0];
$linked_projectt = get_post_meta($order_id, "imm-sale_project_connection")[0];
$customer_id = get_post_meta($linked_projectt, "invoice_customer_id")[0];
$customer_name = get_userdata($customer_id);
$varCustomerName = $customer_name->first_name . " " . $customer_name->last_name;

$project_salesman_id = get_post_meta($linked_projectt, 'order_salesman', true);
$salesman = get_userdata($project_salesman_id);
$salemanemail = $salesman->user_email;
$namesale = $salesman->first_name . " " . $salesman->last_name;
if (empty($namesale)) {
    $namesale = 'Mariebergs';
}
if (empty($salemanemail)) {
    $salemanemail = 'svarainte@mariebergsalset.com';
}
$estimate_url = site_url() . "/order-summary?order-id=" . $order_id . "&order-key=" . get_field("order_summary-key-w-price", $order_id);
$to = $order->billing_email;
//echo $to.'-'.$salemanemail;die;
$subject = 'Nekades av kund ' . $custom_order_number;
$msg = "Affärsförslag nr" . ' ' . $order_id . " nekades av kund " . $varCustomerName.'<br><br><a href=' . $estimate_url . '>Se affärsförslaget här</a><br/><br/>Med vänliga hälsningar<br/>' . $namesale . '<br/> Mariebergs Brasvärme';
$headers = array('From: ' . get_bloginfo('name') . ' <svarainte@mariebergsalset.com>');

//$headers[] = 'Cc:' . get_bloginfo('name') . '<' . $salemanemail . '>';

$headers[] = "Content-Type: text/html; charset=UTF-8";
$sent = wp_mail($salemanemail, $subject, $msg, $headers);
?>
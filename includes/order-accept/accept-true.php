<?php 
$order = new WC_Order($order_id);
$custom_order_number = get_post_meta($order_id, 'custom_order_number')[0];
       $linked_projectt = get_post_meta($order_id, "imm-sale_project_connection")[0];
         $customer_id = get_post_meta($linked_projectt, "invoice_customer_id")[0];
        $project_salesman_id = get_post_meta($linked_projectt, 'order_salesman', true);
         $customer_name = get_userdata($customer_id);
        $varCustomerName = $customer_name->first_name . " " . $customer_name->last_name;
        $salesman = get_userdata($project_salesman_id);
        
        if(empty($salesman->user_email)){
            $salemanemail=get_user_meta($project_salesman_id, "billing_email")[0];
        }else{
            $salemanemail = $salesman->user_email;
        }
        $namesale = $salesman->first_name . " " . $salesman->last_name;
        $estimate_url = site_url() . "/order-summary?order-id=" . $order_id . "&order-key=" . get_field("order_summary-key-w-price", $order_id);
        if (empty($namesale)) {
            $namesale = 'Mariebergs';
        }
//        if (empty($salemanemail)) {
//            $salemanemail = 'svarainte@mariebergsalset.com';
//        }
       if(empty($customer_name->user_email)){
             $to = get_user_meta($customer_id, "billing_email")[0];
  
       }else{
                $to = $customer_name->user_email;
       }
        $subject = 'Orderbekräftelse gällande affärsförslag ' . $custom_order_number;
        $msg = 'Hej ' . $customer_name->first_name . ',<br>
Tack för förtroendet, vi ser fram emot att få leverera till dig!<br><br>

<a href=' . $estimate_url . '>Du ser din orderbekräftelse här!</a><br/><br/>Med vänliga hälsningar<br/>' . $namesale . '<br/> Mariebergs Brasvärme';
        $headers = array('From: ' . get_bloginfo('name') . ' <svarainte@mariebergsalset.com>');

        //      $headers[] = 'Cc:' . get_bloginfo('name') . '<' . $salemanemail . '>';
        $headers[] = 'Cc:' . get_bloginfo('name') . '<' . 'duttagaurav344@gmail.com' . '>';

$headers[] = "Content-Type: text/html; charset=UTF-8";
        //        $sent = wp_mail($to, $subject, $msg, $headers);
        $sent = wp_mail('duttagaurav344@gmail.com', $subject, $msg, $headers);
?>
<?php
    update_post_meta('ekonomi_forskottsfaktura_logs', date('Ymd'), $_POST["prepayment-invoice-order_id"]);


        $percentage_amount_for_prepayment = sprintf('.%d', (int) $_POST["prepayment-invoice_percentage"]);

        $percentage_invoice_type1 = (int) $_POST["prepayment-invoice_percentage"] . "% Förskottsfaktura";
        if (100 == (int) $_POST["prepayment-invoice_percentage"])
            $leftamount = (int) $_POST["prepayment-invoice_percentage"];
        else
            $leftamount = 100 - (int) $_POST["prepayment-invoice_percentage"];

        $percentage_invoice_type2 = (int) $leftamount . "% slutfaktura";

        $prepayment_product = new WC_Product(get_field('prepayment_deduction_invoice_product_id', 'options'));
        $prepayment_product_2 = new WC_Product(get_field('prepayment_deduction_invoice_product_id', 'options'));
        $fakturaavgift_product = new WC_Product(get_field('customprice_product_id', 'options'));
        $float_percentage_amount_for_prepayment = (float) $percentage_amount_for_prepayment;
        //	update_post_meta($_POST["prepayment-invoice-order_id"],'invoice_percentage_total',(int)$_POST["prepayment-invoice_percentage"]);


        $salesman_id = get_field('saljare_id', $_POST["prepayment-invoice-order_id"]);

        $order = new WC_Order($_POST["prepayment-invoice-order_id"]);
        $totalamountcheck = $order->get_total();
        $amount_for_prepayment_order = ($order->get_total() - $order->get_total_tax()) * $float_percentage_amount_for_prepayment;

        $total_amount_prepaymentOrder1 = $order->get_total() - $order->get_total_tax() - $amount_for_prepayment_order;
        /* echo $total_amount_prepaymentOrder1."---".$amount_for_prepayment_order;
          die; */
        $project_id = $_POST["prepayment-invoice-order_id"];
global $wpdb;
        if ($percentage_amount_for_prepayment !== '.100') {

            /*           create order with the percentage value */

            $firstorder = prepayment_invoice_faktura($fakturaavgift = false, $percentage_amount_for_prepayment, $fakturaavgift_product, $amount_for_prepayment_order, $project_id, $salesman_id, $order_line_split_value = false, $prepayment_small_percentage = false, $percentage_invoice_type1, $_POST["prepayment-invoice-project_id"]);
    /*           create order with the total - percentage value */
            $secondorder = prepayment_invoice_faktura($fakturaavgift = true, $percentage_amount_for_prepayment, $prepayment_product_2, $amount_for_prepayment_order, $project_id, $salesman_id, $order_line_split_value = true, $prepayment_small_percentage = true, $percentage_invoice_type2, $_POST["prepayment-invoice-project_id"]);
			$invoice_id = $firstorder.",".$secondorder;
			 $first_total = get_post_meta($firstorder, '_order_total', true);
			  $second_total = get_post_meta($secondorder, '_order_total', true);
			 $totalpay =  array('advacned'=>$first_total,'final'=>$second_total);
			  $wpdb->update('VQbs2_Projects_Search', array('final_payment' => 'false','advanced_payment'=>'false'), array('id' => $project_id));
} else {
           $invoice_id = prepayment_invoice_faktura($fakturaavgift = true, $percentage_amount_for_prepayment, $prepayment_product, 0, $project_id, $salesman_id, $order_line_split_value = false, $prepayment_small_percentage = false, $percentage_invoice_type2, $_POST["prepayment-invoice-project_id"]);
			 $first_total = get_post_meta($invoice_id, '_order_total', true);
		$totalpay =	 array('advacned'=>$first_total);
		 $wpdb->update('VQbs2_Projects_Search', array('advanced_payment'=>'false'), array('id' => $project_id));
}

update_post_meta($project_id, 'save_invoice_id', $invoice_id);
updateSearchMeta($project_id,'invoice_id',$invoice_id);
  updateSearchMeta($project_id,'items',json_encode($totalpay)); 
        $linked_project = $_GET['pid'];
        $project_author = get_post_field('post_author', $linked_project);
        $project_author_meta = get_userdata($project_author);
        $project_author_roles = $project_author_meta->roles[0];
        $today = date('Y-m-d');
        $todo_action_date = date('Y-m-d', strtotime($today));

        create_todo_item($todo_action_date, '1', $linked_project, __("Förskotts faktura skapad.Hantera och planera prdern.") . $linked_project, 'sale-project-management', $project_author, '');
		$to = "ramswiftechies14@gmail.com,jyotiverma1987@gmail.com";
		$p_id = get_field('imm-sale_project_connection', $project_id);
        $message = "https://mariebergsalset.com/project?pid=" . $p_id;
        wp_mail($to, 'split invoice', $message);

        header('Location:' . $_SERVER['REQUEST_URI']);
        exit;
?>
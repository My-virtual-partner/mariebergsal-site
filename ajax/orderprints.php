<?php 
if($_POST['action'] != 'kassakvito_print_data')
	die;

 $wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/wp-config.php');
 $orderid = $_POST['order_id'];
$order = new WC_Order($orderid);
   $project_id = get_post_meta($orderid, 'imm-sale_project_connection', true);
        $order_data = $order->get_data();
        $order_total_price = $order->get_total();
        if (get_field('imm-sale-tax-deduction', $order->get_id())) {
            $rot_avdrag = get_post_meta($order->get_id(), "confirmed_rot_percentage", true);
            $display_price = $order_total_price - $rot_avdrag;
        } else {
            $rot_avdrag = 0;
            $display_price = $order_total_price;
        }
		$summa=($order->get_total() - $order->get_total_tax());
		$moms=($order->get_total_tax());
		
		$office_connection = get_post_meta($project_id, 'office_connection')[0];
//            print_r($office_connection);
            $organization = get_field('organisation_no', $office_connection);
            $content_post = get_post($office_connection);
            $content = $content_post->post_content;
        
        $order_date = $order->order_date;
        $date = date("Y-m-d", strtotime($order_date));
        $time = date("H:i:s", strtotime($order_date));
        $kassavitto_date = new DateTime($date);
        $result = $kassavitto_date->format('Ymd');
        $Kassakvittonummer = $result . '-' . $project_id . '-' . $orderid;
		$json_format = array();
	$sorting_wise = unserialize(get_post_meta($orderid, "head_sortorderitems", true)); 
					$sortorderitems = unserialize(get_post_meta($orderid,'sortorderitems',true)); 
				
$newvalue = array_merge ($sorting_wise,$sortorderitems);
//$newvalue = '';	
if(!empty($newvalue )){
	foreach($newvalue as $limeid){
			foreach( $order->get_items() as $item_id => $order_item ) {
					 $item_data = $order_item->get_data();
					 if($limeid ==  $item_data['id']){ 
 $product_id = version_compare(WC_VERSION, '3.0', '<') ? $order_item['product_id'] : $order_item->get_product_id();
    
            if($order_item["line_item_note"]){
				$titles = $order_item->get_name()."-".$order_item["line_item_special_note"];
				if($order_item["line_item_special_note"]){
					$titles = $order_item->get_name()."-".$order_item["line_item_special_note"];
				}else{
$titles = $order_item->get_name()."-".$order_item["line_item_note"];
				}

            }else{
           $titles =      $order_item->get_name();
            }
$sumoforder = 	$order_item->get_total() + $order_item->get_total_tax();
   array_push($json_format,array('product_name' => $titles,'subtotal' =>  wc_price($sumoforder)));
	
			}
}}}else{
		foreach( $order->get_items() as $item_id => $order_item ) {
					 $item_data = $order_item->get_data();
					//echo $item_data['id']."<br.";
 $product_id = version_compare(WC_VERSION, '3.0', '<') ? $order_item['product_id'] : $order_item->get_product_id();
        if ($product_id != '27944') {
            if($order_item["line_item_note"]){
$titles = $order_item->get_name()."-".$order_item["line_item_note"];
            }else{
           $titles =      $order_item->get_name();
            }
$sumoforder = 	$order_item->get_total() + $order_item->get_total_tax();
   array_push($json_format,array('product_name' => $titles,'subtotal' =>  wc_price($sumoforder)));
		 }
		
}
}
	
		$data=array('productlist' => $json_format,'date'=>$date,'time'=>$time,'Kassakvittonummer'=>$Kassakvittonummer,'Momssata'=>'25','summa'=>wc_price($summa),'moms'=>wc_price($moms),'total'=>wc_price($display_price),'organisation'=>$organization,'content'=>$content);
		echo json_encode($data);
		
		
		
?>
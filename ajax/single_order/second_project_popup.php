 <?php
  $wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/wp-config.php');
						$order_id = $_POST['order_id'];
						$product_brands = return_sorted_product_list_based_on_brand($order_id);
						 $order = wc_get_order( $order_id );
						 $stored_item=[];
			foreach ($order->get_items() as $item_key => $item_data){
				$line_item_note_internal = $item_data->get_meta("line_item_note_internal");
				$product = $item_data->get_product();
				$stored_item[$item_key] = array(
				'product_id' => $item_data['product_id'],
				'product_name' => $item_data['name'],
				'product_sku' => $product->get_sku(),
				'item_quantity' => $item_data['quantity'],
				'line_item_note' => $line_item_note_internal
				);
}			
//print_r($stored_item);
			
                        //Add more label fields if something is missing.
                        $haystack = ["H1", "H2", "H3", "H4", "H5", "H6"];

                        $order_data = return_array_from_json(get_field('orderdata_json',$order_id));
                        $filtered_data = [];

                        foreach ($order_data as $data) {
                            if (strpos_arr($data["label"], $haystack) !== false) {
                                array_push($filtered_data, $data);
                            }
                        }
						
                       




global $wpdb;
$project_id = get_post_meta($order_id, 'imm-sale_project_connection', true);
$office_connection = get_post_meta($project_id, 'office_connection')[0];
$i = 0;
foreach ($product_brands as $keys => $value) :
$getTermid = $wpdb->get_results("SELECT term_id FROM {$wpdb->prefix}termmeta WHERE `meta_key` = 'order_emailid' AND `meta_value` = '".$keys."'"); 

$id = $getTermid[0]->term_id;
$newbrandname=[];
foreach($getTermid as $valu){
	 $get_cat_name = get_term_by('id',$valu->term_id,'item');
	 $newbrandname[] = $get_cat_name->name;
}

if ($value) :
$cat_id = get_term_by('id', $id, 'item');
$key= $cat_id->name;
$office_resellers = get_field('office_resellers', $office_connection);

foreach ($office_resellers as $reseller) {
if (strtolower($reseller["single_reseller"]) == strtolower($key)) {
$office_customer_number = $reseller["customer_number"];
} else {
$office_customer_number = "";
}
}
$rbrand = str_replace(' ', '', $key);
$jsonArrray[$i] = array('brand_name'=> implode(',',$newbrandname),
										'r_name'=>$rbrand."-ram",
										'termid'=>$cat_id->term_id,
										'office_customer_number'=>($office_customer_number)?$office_customer_number:'',
										'key'=>$key,
										'product_id'=>$value,
										'allstored' =>array()
			
										);
										
foreach($stored_item as $va => $vaa){

	if(in_array($vaa['product_id'],$value)){
		 
$newarray = array(
				'orderitem'=>$va,
				'product_id' => $vaa['product_id'],
				'product_name' => $vaa['product_name'],
				'product_sku' => $vaa['product_sku'],
				'item_quantity' => $vaa['item_quantity'],
				'line_item_note' => $vaa['line_item_note']
				);
				array_push($jsonArrray[$i]['allstored'],$newarray);			
}         
} 

                           	$i++;
							endif;
						
                        endforeach;
						
						echo json_encode(array('brand_items'=>$jsonArrray,'filterdata'=>$filtered_data));
						
						die;
                        ?>

                   
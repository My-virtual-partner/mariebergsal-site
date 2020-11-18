<?php


 $wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/wp-config.php');
include_once('fortnox-request.php');

  $parentorder_id = $_POST["parent_orderid"]; 
  $order_number = $_POST["order_id"]; 
  function checkempty($data){
	  return ! empty($data) ? $data : "";
  }
  	$orders = new WC_Order($order_number); 
	$order_accept_date = get_post_meta($parentorder_id,'order_accept_date',true); 	
   	$order_project = get_field('imm-sale_project_connection', $parentorder_id);
	$office_connection = get_post_meta($order_project,'office_connection',true);
	$cost_centers = getStore($office_connection);
        $order_salesman = get_post_meta($order_project, 'order_salesman', true);
		$salesmanname=getName($order_salesman); 
		$order = new WC_Order($parentorder_id);  	
		$userid =	getInvoicedCustomerid($_POST["parent_orderid"]); 
		$name = getCustomerName($userid);
		$referenceName = get_user_meta($userid,'reference_name',true);
		$billing_address1=get_user_meta($userid,'billing_address_1',true); 
		$billing_address_2=get_user_meta($userid,'billing_address_2',true);
		$myStr1=get_user_meta($userid,'billing_postcode',true);
         $billing_postcode = substr($myStr1, 0, 9);
		$billing_phone=get_user_meta($userid,'billing_phone',true);
		$billing_city=get_user_meta($userid,'billing_city',true);
		
		$s_name = get_user_meta($userid,'shipping_first_name',true).' '.get_user_meta($userid,'shipping_last_name',true);
		$ship_name = ! empty(checkempty($s_name)) ? $s_name : checkempty($name);
		$s_city = get_user_meta($userid,'shipping_city',true);
		$shipping_city = ! empty(checkempty($s_city)) ? $s_city : checkempty($billing_city);
		$s_address_1=get_user_meta($userid,'shipping_address_1',true);
			$shipping_address_1 = ! empty(checkempty($s_address_1)) ? $s_address_1 : checkempty($billing_address1);
		$s_address2=get_user_meta($userid,'shipping_address_2',true);
          $shipping_address2 = ! empty(checkempty($s_address2)) ? $s_address2 : checkempty($billing_address_2); 
		$myStr	= get_user_meta($userid,'shipping_postcode',true);
		
        $s_postcode = substr($myStr, 0, 9);
		$shipping_postcode = ! empty(checkempty($s_postcode)) ? $s_postcode : checkempty($billing_postcode);
		$billing_phone=get_user_meta($userid,'billing_phone',true);
		$shipping_contact_number=get_user_meta($userid,'shipping_contact_number',true);
		$user_info = get_userdata( $userid );
		$email = $user_info->user_email;
		$billing_company= get_user_meta($userid, "billing_company",true);
				$invoice_email= get_user_meta($userid, "invoice_email",true);
				
		$customer =  array(
			'Email'                 => $email,
            'EmailInvoice'          => $invoice_email[0]?$invoice_email[0]:$email,
            'Name'                  => $name,
            'Type'                  => ( ! empty( $billing_company ) ? "COMPANY" : "PRIVATE" ),
          // 'OrganisationNumber'    => $OrganisationNumber,
           'Address1'              => ! empty($billing_address1) ? $billing_address1 : "" ,
			'Address2'              =>  ! empty($billing_address_2) ? $billing_address_2 : "" ,
            'ZipCode'               =>  ! empty($billing_postcode) ? $billing_postcode : "" ,
            'City'                  =>  ! empty($billing_city) ? $billing_city : "" ,
            'CountryCode'           => "SE",
            'DeliveryAddress1'      => $shipping_address_1,
            'DeliveryAddress2'      => $shipping_address2,
            'DeliveryCity'          => $shipping_city,
            'Currency'              => "SEK",
            'DeliveryCountryCode'   => "SE",
            'DeliveryName'          =>$ship_name,
            'DeliveryZipCode'       => ! empty($shipping_postcode) ? $shipping_postcode : "",
            'Phone1'                => ! empty($billing_phone) ? $billing_phone : "",
       //     'ShowPriceVATIncluded'  => false, 
			'VATType' =>  "SEVAT",
		
		); 
$customer = str_replace(array('Ö','ä','Ä','ö'),array('ä','Ö','Ä','ö'),$customer);

try {
			$existing_customer = get( $customer['Email'] );
			if( empty( $existing_customer ) ) {
				$response = make( "POST", "/customers", [ 'Customer' => $customer ] );
				$customer_number = $response->Customer->CustomerNumber;
			}
			elseif( ! empty( $existing_customer ) ) { 
				$customer_number = $existing_customer->CustomerNumber;
				$response = make( "PUT", "/customers/" . $customer_number, [
					'Customer' => $customer
				] ); 
			}
		}
		catch( Exception $error ) {
			throw new Exception( $error->getMessage() );
		}		

		    $fortnox_orders = array( 'CustomerNumber' => $customer_number,
                'DocumentNumber'            => preg_replace('/\D/', '', $order_number),
                 'YourOrderNumber'           => $parentorder_id."-".$order_number,
                 'YourReference'				=>$referenceName,		
				'OurReference'				=> $salesmanname,
				'TermsOfPayment'			=> get_post_meta($parentorder_id, 'order_payment_method', true),
                'ExternalInvoiceReference1' => $order_number,
                'OrderDate'                 =>!empty($order_accept_date) ? $order_accept_date : substr( $order->get_date_created(), 0, 10 ),
             //   'VATIncluded'               => apply_filters( 'wetail_fortnox_sync_order_vat_included', false),
                'Currency'                  => "SEK",
				'DeliveryCity' 			=> $shipping_city,
				'DeliveryAddress1'      => $shipping_address_1,
				'DeliveryAddress2'      => $shipping_address2,
				'DeliveryName'          => $shippingname,
				'DeliveryZipCode'       =>$shipping_postcode,
				'CustomerName'			=> $name,
				'Address1'			=> ! empty($billing_address1) ? $billing_address1 : "",
				'Address2'              =>  ! empty($billing_address_2) ? $billing_address_2 : "" ,
				'Phone1'			=> $billing_phone,
				'ZipCode' =>  $billing_postcode,
				'City'   => $billing_city,
				'Country'           => "Sverige",
				'DeliveryCountry'           => "Sverige",			
				);
			
$fortnox_orders['CostCenter'] = ($cost_centers) ? $cost_centers: '';
function calculate_item_discount( $subtotal, $total, $quantity ){
        if ($subtotal != $total) {
            $item_discount = $subtotal - $total;
            if ($quantity > 1)
           $item_discount = $item_discount * $quantity;
            return $item_discount;
        }
        return 0.0;
}

function sanitized_sku( $sku ) {
		$skus=preg_replace('/[^A-Za-z0-9-+_\.]/', '', $sku );
            return preg_replace('/\s+/', '', $skus);
}
function exists_in_fortnox( $sku ) { 
	$response = make("GET", "/articles?articlenumber=" . str_replace(' ', '_', $sku)); 
	return $article_response->ArticleNumber; 
}
function product_sync($product){
 $product_title = str_replace('"', "'", $product->name);
 $sku = sanitized_sku($product->sku); 
$productstitle =  mb_substr($product_title,0,50,"utf-8");
 $article = array('ArticleNumber' => $sku,'Description' =>$productstitle ); 
 $newsku = str_replace(' ', '_', $sku);
	if ( exists_in_fortnox( $sku ) != $newsku) {
			try {
				$article_response = make( "POST", "/articles", [ 'Article' => $article ] );  
			} catch ( Exception $e ) {
				error_log( "Error when syncing article to Fortnox. SKU: " . $sku );
			}
		}
		else {
			try {
				$article_response = make( "PUT", "/articles/{$sku}", [ 'Article' => $article ] );
				
			}
			catch( Exception $error ) {
				if( 2000513 == $error->getCode() ) {
					$article_response = make( "POST", "/articles", [ 'Article' => $article ] );
				}
			}
			
		} 

		return $article_response; 
}
	
$i = 0;
foreach( $orders->get_items() as $order_item_id => $item ) {
			$product =	$item->get_product();
//	if(!in_array($product->get_sku(),array('asdasdasdas'))){
	//print_r($fortnox_orders);die;
			$productid = $item->get_product_id(); 
			
			$article_response = product_sync($product);
			$product_name = $item->get_name();
 			$total = $orders->get_item_total( $item, false, false ); 
        $array_negativ = array('forskottsfaktura-avgar','rabbat_produkt','prisjustering','prisjustering-tillagg-1','prisjustering-tillagg');
        $array_positive = array('arbetsorder','arbetsorder-1','materialkostnad','fakturaavgift');
        $array_all = array_merge($array_positive,$array_negativ);

        if (!in_array($product->get_sku(),$array_all)){
            $quantity = $item->get_quantity();
            $subtotal = $orders->get_item_subtotal( $item, false, false );
            $discount = 0;

        }elseif(in_array($product->get_sku(),$array_negativ)){
            $quantity = 1;
            $subtotal = -($item->get_quantity());
            $discount = 0;
        }elseif(in_array($product->get_sku(),$array_positive)){
            $quantity = 1;
            $subtotal = $item->get_quantity();
            $discount = 0;
        }	  
	$line_item_name = wc_get_order_item_meta($order_item_id, 'line_item_note', true );
         if(!empty($line_item_name))
         {
			
             $product_name = str_replace(array('Ö','ä','Ä','ö'), array('ä','Ö','Ä','ö'),$line_item_name);
			
       }
	   $line_item_special_note = wc_get_order_item_meta($order_item_id, 'line_item_special_note', true );
         if(!empty($line_item_special_note))
         {
             $product_name =  $product_name."-".str_replace(array('Ö','ä','Ä','ö'), array('ä','Ö','Ä','ö'),$line_item_special_note);
       }		

 $product_name = mb_substr($product_name,0,50,"utf-8");
	$product_name = trim(preg_replace('/ +/', ' ',str_replace("×","x",$product_name)));

$sku =sanitized_sku( $product->get_sku()); 

			$order_rows[] = array('ArticleNumber'     => $sku,
            'Description'       => trim($product_name),
            'DeliveredQuantity' => $quantity,
            'OrderedQuantity'   => $quantity,
            'Unit'              => "st",
            'Price'             => $subtotal,
            'Discount'          => $discount,
            'DiscountType'      => "AMOUNT",
            'VAT'               => 25,
        //    'HouseWork' => $houseWork,
			);
		  $order_row['AccountNumber'] = 3011;			  
				if($productid == '42621'){
	$order_rows[$i]['Price'] = 1;
}	  
$i++;
//}
}

$fortnox_orders  = array_filter($fortnox_orders);
$fortnox_orders = str_replace(array('Ö','ä','Ä','ö'),array('ä','Ö','Ä','ö'),$fortnox_orders);
$fortnox_orders['OrderRows'] = $order_rows;

 
function apiCalls($requestMethod) { 

 $curl = curl_init();
 $options = array(
'Access-Token: b74bf1c5-8ad4-43ef-8a5a-631a9fbd5a40',
				'Client-Secret: 3zfQr9S51A',
				'Content-Type: application/json',
				'Accept: application/json',
 );
 
curl_setopt( $curl, CURLOPT_URL, "https://api.fortnox.se/3/orders/".$requestMethod);
 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
 curl_setopt($curl, CURLOPT_HTTPHEADER, $options);
 curl_setopt($curl, CURLOPT_CUSTOMREQUEST,'GET');
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
 $curlResponse = curl_exec($curl);
 curl_close($curl);
  $re =  json_decode( $curlResponse );
//print_r($re);
  return $re->Order->DocumentNumber;
} 
 $invoicid = apiCalls($order_number); 
if (trim($invoicid) == trim($order_number)) { 
$response = make( "PUT", "/orders/{$order_number}", ['Order' => $fortnox_orders] ); 
//echo "mmmmmmm";

update_post_meta($order_number, 'order_syn_fortnox', true);

      }
 else { 
$response =  make( "POST", "/orders", ['Order' => $fortnox_orders] );  //echo "sssssssssss";
		  
      }
//print_r($response);
global $wpdb;
// $lastvalue = order_exists($order_number); 
$check_fort = explode(' ', get_post_meta($parentorder_id, 'invoice_percentage_totalamnt', true));
$order_id = $parentorder_id;
$project_id = get_field('imm-sale_project_connection', $order_id);

    if (trim($invoicid) == trim($order_number)) { 
	
		$getInvoicedate = get_post_meta($order_number,'send_date',true);
		if(empty($getInvoicedate)){
					update_post_meta($order_number,'send_date',date("Y-m-d h:i:sa"));
		}
		 $check_fort = explode(' ', get_post_meta($order_number, 'invoice_percentage_totalamnt', true));
		 if ($check_fort[1] != 'Förskottsfaktura') {
   	$wpdb->update('VQbs2_Projects_Search', array('final_payment' => 'true','advanced_payment' => 'true'), array('id' => $order_id));     
		 }else{
			  $wpdb->update('VQbs2_Projects_Search', array('advanced_payment' => 'true'), array('id' => $order_id));


		 }
        $current_department = get_field('order_current_department', $project_id);
        $current_value = get_post_meta($project_id, "internal_project_status_" . $current_department)[0];

        if ($current_value == 'Att fakturera') {
            $today = date("Y-m-d");
            $todo_action_date = date("Y-m-d", strtotime($today));
            $todo_status = "0";
            $todo_id = '';
            $salesman_id = getuserid($order_id, $project_id, 'saljare_id', 'order_salesman');
            $salesman = get_userdata($salesman_id);
            $salesman_name = getCustomerName($salesman_id);
            create_todo_item($todo_action_date, 0, $project_id, '' . $salesman_name . ' på
avdelningen {earlier_department} flyttade över projekt (' . $project_id . ')', '', $salesman_id, $todo_id);
        }


        if ($check_fort[1] == 'Förskottsfaktura') {
            update_post_meta($_POST["parent_orderid"], 'imm-sale_invoice_create_forts', date("Ymd"));
        } else {
            update_post_meta($_POST["parent_orderid"], 'imm-sale_invoice_create_slutfaktura',date("Ymd"));
        }

			update_post_meta($order_number, 'order_syn_fortnox',true);
			update_post_meta($order_number, '_fortnox_order_synced', true);
            if ($check_fort[1] == 'Förskottsfaktura') {
                update_post_meta($_POST["parent_orderid"], 'advance_payment', true);
            } else {
				update_post_meta($_POST["parent_orderid"], 'advance_payment', true);
                update_post_meta($_POST["parent_orderid"], 'final_payment', true);
            }
            $useractivity = "Invoice ID ".$order_number." synced to fortnox on date ". date('Y-m-d H:i:s');
            custom_userActivity($project_id, $useractivity);

                $to = "ramswiftechies14@gmail.com";
                $message = "https://mariebergsalset.com/project?pid=" . $project_id;
                wp_mail($to, 'fortnox  sync ho gya ' . $order_number, $message);

    }else{
		
				$to = "ramswiftechies14@gmail.com";
                $message = "https://mariebergsalset.com/project?pid=" . $project_id;
             wp_mail($to, 'fortnox sync nhi hoya ' . $order_number, $message);
				delete_post_meta($order_number, '_fortnox_order_synced', 1);
	}
die; 	
?>
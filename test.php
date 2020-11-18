<?php  
if($_POST['action'] != 'search_and_display_projects')
	die;

 $wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/wp-config.php');

 global $wpdb;
    global $current_user_role;
    global $roles_order_status;
    //$search_term = trim($_POST["search_term"]);
	  $search_term ='developer';
   // $search_order = $_POST["search_order"];
    $current_department = $_POST["current_department"];
    $mine_or_all = $_POST["mine_or_all"];
    $project_status = $_POST["project_status"];
    $billing_city = $_POST["billing_city"];
    $internal_project_status = $_POST["internal_project_status"];
    $selected_office = $_POST["selected_office"];
    $posts_per_page = $_POST["posts_per_page"];
    $curntStatus = $_POST['current_status'];
    $projectType = $_POST['project_type'];
    $statusorder = $_POST['statusorder'];

   
    $from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["from_date"]))));
    $to_dates = DateTime::createFromFormat('Y-m-d', $_POST["to_date"]);

    if ($to_dates !== FALSE) {
        $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["to_date"]))));
    } else {
        $to_date = date("Y-m-d", strtotime("tomorrow"));
    }


    if ($search_term) {
        $posts_per_page = -1;
    }
    if ($current_department === 'alla') {
        $current_department_value = array(
            'sale-salesman', 'sale-economy', 'sale-project-management', 'sale-sub-contractor', 'sale-administrator'
        );

        $current_department = $_POST['roles'];
    } else {
        $current_department_value = $current_department;
    }
    $users_id_array = array();
    $blogusers = get_users('blog_id=1&orderby=nicename');
// Array of WP_User objects.
    foreach ($blogusers as $user) {
        array_push($users_id_array, $user->id);
    }

    if ($mine_or_all === 'alla') {
        $mine_or_all_value = $users_id_array;
    } else {
        $mine_or_all_value = $mine_or_all;
    }

    $args_offices = [
        'post_type' => 'imm-sale-office',
        'posts_per_page' => $posts_per_page,
    ];
    $offices = new WP_Query($args_offices);
    $ids_offices = array();
    while ($offices->have_posts()) {
        $offices->the_post();

        $office_connection = get_the_ID();
        array_push($ids_offices, $office_connection);
    }


    if ($selected_office === 'order-by-office_project-ongoing') {
        $selected_office_value = $ids_offices;
    } else {
        $selected_office_value = $selected_office;
    }


function getsearch($order_term=false,$search_term){

			if($order_term)
				$search_term1 = $order_term;	
			else
				$search_term1 = $search_term;
		
		$postype=array('shop_order','imm-sale-project');
		
       if (in_array(get_post_type( $search_term ),$postype) ) {
		 return $search_term1;
			

		} else{
				return array( array( 'relation' => 'OR', array(
                    'key' =>  'custom_order_number',
                    'value' => $search_term1,
                    'compare' => 'LIKE'    
            ),array(
                    'key' =>'custom_project_number',
                    'value' => $search_term1,
                    'compare' => 'LIKE'    
            ) ));
		}
		
		
		
		
}

//$order_term = get_post_meta($search_term, 'imm-sale_project_connection', true);
if (get_post_type( $search_term ) == 'shop_order' ) {
	$order_term = $search_term;
        $search_term1 = $search_term;
				$publishtype = "AND VQbs2_posts.post_type = 'shop_order' AND ((VQbs2_posts.post_status = 'wc-pending' OR VQbs2_posts.post_status = 'wc-processing' OR VQbs2_posts.post_status = 'wc-on-hold' OR VQbs2_posts.post_status = 'wc-completed' OR VQbs2_posts.post_status = 'wc-cancelled' OR VQbs2_posts.post_status = 'wc-refunded'))";
			}
			else{
				$search_term1 = $search_term;
$publishtype = "AND VQbs2_posts.post_type = 'shop_order' AND ((VQbs2_posts.post_status IN('wc-pending','wc-processing','wc-on-hold','wc-completed','wc-cancelled','wc-refunded')))";
			}

if($search_term){
	 $meta = array();
 $pos = strpos($search_term, '-');
if(!is_numeric($search_term) && false === $pos){
	$search_term = trim($search_term);	

	
    $sql= "SELECT DISTINCT SQL_CALC_FOUND_ROWS VQbs2_users.ID FROM VQbs2_users INNER JOIN VQbs2_usermeta ON ( VQbs2_users.ID = VQbs2_usermeta.user_id ) WHERE 1=1 AND (
  ( VQbs2_users.display_name LIKE '%".$search_term."%' ) 
  OR 
  ( VQbs2_users.user_login LIKE '%".$search_term."%' ) 
  OR ( VQbs2_users.user_email LIKE '%".$search_term."%' ) 
  OR 
  ( VQbs2_usermeta.meta_key = 'first_name' AND VQbs2_usermeta.meta_value LIKE '%".$search_term."%' ) 
OR 
  ( VQbs2_usermeta.meta_key = 'fullname' AND VQbs2_usermeta.meta_value LIKE '%".$search_term."%' ) 

  OR 
  ( VQbs2_usermeta.meta_key = 'last_name' AND VQbs2_usermeta.meta_value LIKE '%".$search_term."%' ) 
  OR 
  ( VQbs2_usermeta.meta_key = 'personal_phone' AND VQbs2_usermeta.meta_value LIKE '%".$search_term."%' ) 
  OR
  ( VQbs2_usermeta.meta_key = 'billing_phone' AND VQbs2_usermeta.meta_value LIKE '%".$search_term."%' ) 
  OR 
   ( VQbs2_usermeta.meta_key = 'user_email' AND VQbs2_usermeta.meta_value LIKE '%".$search_term."%' ) 
  OR 
  ( VQbs2_usermeta.meta_key = 'billing_email' AND VQbs2_usermeta.meta_value LIKE '%".$search_term."%' ) 
  OR 
  ( VQbs2_usermeta.meta_key = 'billing_address_1' AND VQbs2_usermeta.meta_value LIKE '%".$search_term."%' )
  OR 
  (VQbs2_users.ID LIKE '%".$search_term."%' )
) ORDER BY user_login ASC  ";
$pageposts = $wpdb->get_results($sql);
  $user_ids = [];

 foreach ($pageposts as $user):
   array_push($user_ids, $user->ID);
//$search_term = $user->ID;
       endforeach; 

$ids = implode(', ',$user_ids);
 if ($user_ids) {
	 	$searchitemsjoin = "LEFT JOIN VQbs2_postmeta AS mt9 ON ( VQbs2_posts.ID = mt9.post_id )";
$searchitemsquery= "AND (( ( mt9.meta_key = 'order_salesman' AND mt9.meta_value IN ($ids)  ) 
    OR ( mt9.meta_key = 'invoice_customer_id' AND mt9.meta_value IN ($ids)  )))";
	 
          
 }

}

		else {
	$postype=array('shop_order','imm-sale-project');
		
       if (in_array(get_post_type( $search_term ),$postype)) {
		  $searchitemsquery = 'AND VQbs2_posts.ID IN ('.$search_term.') ';
		} else{
		$searchitemsjoin = "LEFT JOIN VQbs2_postmeta AS mt9 ON ( VQbs2_posts.ID = mt9.post_id )";
	$searchitemsquery= "AND ( mt9.meta_key = 'custom_order_number' AND mt9.meta_value LIKE '%$search_term%' ) 
    OR ( mt9.meta_key = 'custom_project_number' AND mt9.meta_value LIKE '%$search_term%')";
		}	
			
	
	
	} 
if (!empty($statusorder) && $statusorder != 'Alla') {
	 $sojoin = "LEFT JOIN VQbs2_postmeta AS mt10 ON ( VQbs2_posts.ID = mt10.post_id )";
	$soquery =  "AND ( mt10.meta_key = 'order_accept_status' AND mt10.meta_value = '".$statusorder."' )";	 
	 }
  if (!empty($curntStatus) && $curntStatus != 'Alla' ) {
	$csjoin = "LEFT JOIN VQbs2_postmeta AS mt6 ON ( VQbs2_posts.ID = mt6.post_id )";
	$csquery =  "AND ( mt6.meta_key = 'internal_project_status_$current_department' AND mt6.meta_value = '".$curntStatus."' )";
}
if ($selected_office != 'order-by-office_project-ongoing') {
	$officejoin = "LEFT JOIN VQbs2_postmeta AS mt7 ON ( VQbs2_posts.ID = mt7.post_id )";
	$officequery =  "AND ( mt7.meta_key = 'order_office_connection_o' AND mt7.meta_value = '".$selected_office_value."' )"; 
 }
 if (!empty($projectType) && $projectType != 'Alla') {
	 $projectjoin = "LEFT JOIN VQbs2_postmeta AS mt8 ON ( VQbs2_posts.ID = mt8.post_id )";
	 $projectquery =  "AND ( mt8.meta_key = 'order_project_type' AND mt8.meta_value = '".$projectType."' )"; 
 }


  if ($_POST["current_department"] == 'alla') {

   $crntdepart = implode("','",$current_department_value);
   }
  else {
	$crntdepart = $current_department_value;
  }
  if ($mine_or_all === 'alla') {
	 
        $vsale = implode(',',$mine_or_all_value);
    } else {
        $vsale = $mine_or_all_value;
    }
 
   
  echo $newsql = "SELECT   VQbs2_posts.* FROM VQbs2_posts  LEFT JOIN VQbs2_postmeta ON (VQbs2_posts.ID = VQbs2_postmeta.post_id AND VQbs2_postmeta.meta_key = 'imm-sale_prepayment_invoice' )  LEFT JOIN VQbs2_postmeta AS mt1 ON ( VQbs2_posts.ID = mt1.post_id )  LEFT JOIN VQbs2_postmeta AS mt2 ON ( VQbs2_posts.ID = mt2.post_id )  LEFT JOIN VQbs2_postmeta AS mt3 ON ( VQbs2_posts.ID = mt3.post_id )  LEFT JOIN VQbs2_postmeta AS mt4 ON ( VQbs2_posts.ID = mt4.post_id )  LEFT JOIN VQbs2_postmeta AS mt5 ON ( VQbs2_posts.ID = mt5.post_id ) ".$csjoin." ".$officejoin." ".$projectjoin." ".$searchitemsjoin." ".$sojoin." WHERE 1=1  AND ( 
  ( 
    VQbs2_postmeta.post_id IS NULL
  ) 
  AND 
  ( mt1.meta_key = 'order_project_status_o' AND mt1.meta_value = '".$project_status."' ) 
  AND 
  ( 
    ( mt2.meta_key = 'order_salesman_o' AND mt2.meta_value IN (".$vsale.") )
  ) 
  AND 
  ( mt3.meta_key = 'order_department_o' AND mt3.meta_value IN ('".$crntdepart."') ) 
  AND 
  ( mt4.meta_key = 'postdate' AND mt4.meta_value > '".$from_date."' ) 
  AND 
  ( mt5.meta_key = 'postdate' AND mt5.meta_value < '".$to_date."' )
  ".$csquery." 
  ".$officequery." 
  ".$projectquery." 
  ".$searchitemsquery." 
  ".$soquery." 

) AND VQbs2_posts.post_type = 'shop_order' AND ((VQbs2_posts.post_status = 'wc-pending' OR VQbs2_posts.post_status = 'wc-processing' OR VQbs2_posts.post_status = 'wc-on-hold' OR VQbs2_posts.post_status = 'wc-completed' OR VQbs2_posts.post_status = 'wc-cancelled' OR VQbs2_posts.post_status = 'wc-refunded' OR VQbs2_posts.post_status = 'wc-failed')) GROUP BY VQbs2_posts.ID ORDER BY VQbs2_posts.ID DESC";

 $getposting = $wpdb->get_results($newsql);
 print_r($getposting);

    } else {
		$notsearch =1;
$args = array( 'orderby' => 'ID', 'post_type' => 'shop_order','post_status' => array_keys(wc_get_order_statuses()),           'posts_per_page' => $posts_per_page, 'meta_query' => 
array('relation' => 'AND', 
array('relation' => 'OR', 

array( 'key' => 'imm-sale_prepayment_invoice', 'value' => '1', 'compare' => 'NOT EXISTS' )
),
array('key' => 'order_project_status_o', 'value' => $project_status , ), 
array('relation' => 'OR', array( 'key' => 'order_salesman_o', 'value' => $mine_or_all_value, 'compare' => 'IN' ),
//array( 'key' => 'order_customer_o', 'value' => $mine_or_all_value, 'compare' => 'IN' )
),
array('key' => 'order_department_o', 'value' => $current_department_value, 'compare' => 'IN'),
array('key' => 'postdate', 'value' => $to_date , 'compare' => '<'),array('key' => 'postdate', 'value' => $from_date , 'compare' => '>')
 )); 
 
  if (!empty($curntStatus) && $curntStatus != 'Alla' ) {
	
array_push($args['meta_query'], array("key" => "internal_project_status_$current_department","value" => $curntStatus ));
 }
		
if ($selected_office != 'order-by-office_project-ongoing') {
array_push($args['meta_query'], array("key" => "order_office_connection_o","value" => $selected_office_value));
 }
 if (!empty($statusorder) && $statusorder != 'Alla') {
array_push($args['meta_query'], array('key' => 'order_accept_status', 'value' => array($statusorder), 'compare' => 'IN',));
        } 
		 if (empty($statusorder) && $statusorder != 'Alla') {
			$acceptorder = array('true','false','Kundfråga');
/* array_push($args['meta_query'], array('key' => 'order_accept_status', 'value' => array('true','false','Kundfråga'), 'compare' => 'NOT IN',)); */
        }  
if (!empty($projectType) && $projectType != 'Alla') {
array_push($args['meta_query'], array('key' => 'order_project_type', 'value' => $projectType, 'compare' => '='));
			}
		
		$getposting = get_posts( $args );
//print_r($getposting);		
	}
	

    $i = 1;


	$departmentuse = array('sale-administrator' => 'Sälj administrator', 'sale-salesman' => 'Sälj', 'sale-economy' => 'Ekonomi', 'sale-project-management' => 'Projektplanering', 'sale-technician' => 'Tekniker', 'sale-sub-contractor' => 'Underentreprenör');


foreach ( $getposting as $posts ) :  if($notsearch){ setup_postdata( $posts ) ; }

   if($order_term  || !empty($notsearch)){
	if (empty($statusorder) && $statusorder != 'Alla') {
		$orderget = get_post_meta($posts->ID,'order_accept_status',true);
		if(!in_array($orderget,$acceptorder))
			$ordid[] = $posts->ID;
	}else{
		$ordid[] = $posts->ID;
	}
				}
	else {
		$Orderargs = array(
            'orderby' => 'ID',
            'post_type' => 'shop_order',
            'post_status' => array('wc-refunded','wc-on-hold','wc-cancelled','wc-pending','wc-processing','wc-completed'),
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'imm-sale_project_connection',
                    'value' =>  $posts->ID,
                    'compare' => '='
                ),
				array('key' => 'order_accept_status','value' => array('true','false','Kundfråga','')
)				  
				
            )
        );
		$myposts = get_posts($Orderargs);
	
        foreach ($myposts as $post) : setup_postdata($post);
		
            $ordid[] = $post->ID;
        endforeach;
		wp_reset_postdata();
	}
	 
endforeach; 
wp_reset_postdata();
	//print_r($ordid);
	  $json_array = array();
        
 if(count($ordid) != 0){
	$totalcount=1;
    foreach ($ordid as $ordid) {
 //if ( get_post_type( $ordid ) == 'shop_order' ) 
 $project_id = get_post_meta($ordid, 'imm-sale_project_connection', true);
		$customer_id = get_post_meta($project_id, 'invoice_customer_id');
        $customer = get_userdata($customer_id[0]);
		if( $customer ===false)
		continue;


		if($totalcount != $posts_per_page){
		
       $order = new WC_Order($ordid);
        $project_types = get_post_meta($ordid, 'order_project_type', true);
       
	

$departmentstatus = get_post_meta($project_id, 'order_current_department', true);

		  /*   $current_department_fields = get_field_object('order_current_department');
			if(empty($current_department))
			 $current_department = get_field('order_current_department', $project_id);
			else
				$current_department=$current_department;
			*/
	   $internal_status = get_post_meta($project_id, 'internal_project_status_' . $departmentstatus, true);
        $custom_project_number = $customer_id[0] . "-" . $project_id. "-" . $ordid;


        $butik = get_post_meta($project_id, 'office_connection', true);

        $projuct_status = get_post_meta($project_id, 'imm-sale-project', true);
	

        if ($projuct_status === 'project-ongoing') {
            $projuct_status_value = 'Pågående';
        } elseif ($projuct_status === 'project-archived') {
            $projuct_status_value = 'Avslutade';
        }


        if (empty(get_post_meta($project_id, 'order_salesman', true))) {
            $salesman_id = get_post_meta($ordid, 'saljare_id', true);
        } else {
            $salesman_id = get_post_meta($project_id, 'order_salesman', true);
        }
        $salesman = get_userdata($salesman_id);

	
        //get_field('order_current_department', get_the_ID());
        // $ordid=get_field('parent_order_id_project', get_the_ID());
		$status = get_field('order_accept_status', $ordid);
                if ($status === 'true') {
                    $orderaccpet= 'Accepterat';
                } else if ($status === 'false') {
                    $orderaccpet= 'Nekats';
                } else if ($status === 'Kundfråga') {
                    $orderaccpet= 'Kundfråga';
                } else	 {
                    $orderaccpet= 'Väntar';
                }
				
	
		
		  $order_array = array(
            'i' => $i,
            'project_id' => $project_id,
            'custom_project_number' => $custom_project_number,
            'ordid' => $ordid,
            'time' => get_the_date('j F Y h:i:s A', $project_id),
            'status' => $departmentuse[$departmentstatus],
            'project_status' => $projuct_status_value,
            'store' => !empty($butik) ? get_the_title($butik) : '',
            'cusid' => $customer_id[0],
            'custname' => !empty(get_user_meta($customer->ID,'first_name',true)) ? get_user_meta($customer->ID,'first_name',true)." ".get_user_meta($customer->ID,'last_name',true) : $customer->display_name,
            'salesman' => !empty(get_user_meta($salesman->ID,'first_name',true)) ? get_user_meta($salesman->ID,'first_name',true)." ".get_user_meta($salesman->ID,'last_name',true) : $salesman->display_name,
            'total' => wc_price($order->get_total()),
            'internal_status' => !empty($internal_status) ? $internal_status :"",
			'orderaccpet'=>$orderaccpet,
			'project_types'=>get_project_name($project_types),
			'sale_email'=>$salesman->user_email
        );
    array_push($json_array, $order_array);
        $i++;
		$totalcount++;
		}
	
    }
		$result = json_encode($json_array, JSON_PRETTY_PRINT);
    echo $result;
 }else{ echo "1";} 
    die();

?>
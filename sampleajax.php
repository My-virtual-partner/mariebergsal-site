<?php
if ($_POST['action'] != 'search_and_display_projects')
    die;
$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path . '/wp-config.php');

global $wpdb;
function getHeadProduct($orderid){
	global $wpdb;
	 $sql = "SELECT wos.order_item_name FROM `{$wpdb->prefix}woocommerce_order_items` wos INNER JOIN `{$wpdb->prefix}woocommerce_order_itemmeta`  om ON wos.order_item_id = om.order_item_id
 WHERE `order_id` = '".$orderid."' AND `meta_key` = 'HEAD_ITEM' AND `meta_value` = '1'";
 $results = $wpdb->get_results($sql);

 
 return $results[0]->order_item_name;
}
$current_user_role = get_user_role();
$search_term = trim($_POST["search_term"]);
// $search_order = $_POST["search_order"];
$current_department = $_POST["current_department"];
$allSalesmanid = $_POST["mine_or_all"];
$project_status = $_POST["project_status"];
$selected_office = $_POST["selected_office"];
$posts_per_page = $_POST["posts_per_page"];
$curntStatus = $_POST['current_status'];
$projectType = $_POST['project_type'];
$orderStatus = $_POST['statusorder'];
$search_product = $_POST['search_product'];
$assign_project = $_POST['assign_project'];
$internalstatus = $_POST['internal_project_status'];
$department_search = array(1 => "Administratör", 2 => "Sälj", 3 => "Ekonomi", 4 => "Projektplanering", 5 => "Tekniker", 6 => "Underentreprenör");
$department_searchKey = array(1 => "sale-administrator", 2 => "sale-salesman", 3 => "sale-economy", 4 => "sale-project-management", 5 => "sale-technician", 6 => "sale-sub-contractor");
if (!empty($_POST["from_date"])) {
    $from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["from_date"]))));
}

if (!empty($_POST["to_date"])) {
    $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["to_date"]))));
}
//$searchCheck = " customer_number LIKE '%".$search_term."%' OR customer_email LIKE '%".$search_term."%' OR customer_name LIKE '%".$search_term."%' ";
$search_term1 = explode(' ', $search_term);

if (empty($search_term1[1]) && !empty($search_term)) {
    $searchCheck = "  CONCAT(vps.customer_number, vps.customer_email, vps.customer_name) LIKE '%" . $search_term . "%' AND";
}

if (!empty($search_term1[1]) && !empty($search_term)) {
    $searchCheck = " vps.customer_name LIKE '%" . $search_term1[0] . "%' AND vps.customer_name LIKE '%" . $search_term1[1] . "%' AND ";
}

if ($selected_office != 'order-by-office_project-ongoing') {
    $storeCheck = " vps.store_id = '" . $selected_office . "' AND";
}

if (!empty($current_department)) {
    $departmentCheck = " vps.department = '" . $current_department . "' AND";
}

if ($allSalesmanid != 'alla') {
    $allSalesmanidCheck = " vps.salesman_id = '" . $allSalesmanid . "' AND";
}

if ($projectType != 'Alla') {
    $projectTypeCheck = " vps.type_of_project = '" . $projectType . "' AND";
}

if ($project_status != 'Alla') {
    $projectStatusCheck = " vps.project_status = '" . $project_status . "' AND";
}

if ($orderStatus != 'Alla') {
    $orderStatusCheck = " vps.order_accept = '" . $orderStatus . "' AND";
}

if ($posts_per_page != '-1')
    $postperPageCheck = " LIMIT " . $posts_per_page;

if ($from_date) {
    $fromCheck = " vps.create_date  >  '" . $from_date . "' AND";
}

if ($to_date) {
    $toCheck = " vps.create_date  < '" . $to_date . "' AND";
}

if($search_product){
	$productsearchfield = " LEFT JOIN VQbs2_woocommerce_order_items  orderitems ON orderitems.order_id =  vps.id ";
	$productdata = " orderitems.order_item_name  LIKE '%" . $search_product . "%' AND ";
}
if (!empty($internalstatus)) {
		$internalstatusQuery = " LEFT JOIN VQbs2_Project_Search_Meta vpsm ON vps.id = vpsm.id ";
    $newcolumn = array('sale_administrator' => 'sale-administrator', 'sale_salesman' => 'sale-salesman', 'sale_economy' => 'sale-economy', 'sale_project_management' => 'sale-project-management', 'sale_technician' => 'sale-technician', 'sale_sub_contractor' => 'sale-sub-contractor');
    $internalstatusCheck = " `internal_project_status_" . array_search($department_searchKey[$current_department], $newcolumn) . "` = '" . $internalstatus . "' AND";
}

if ($current_user_role == 'sale-sub-contractor') {
    $curren_user_id = get_current_user_id();

    if ($assign_project != 'alla') {
         $allSalesmanid = " vps.responsible_salesman = $assign_project AND";
    } else {
        $args = array('role__in' => array('sale-sub-contractor'));
          $users = get_users( $args );
        foreach ($users as $user) {
            $current_user_company_name = get_user_meta($curren_user_id, 'sale-sub-contractor_company', true);
            $comapny_name = get_user_meta($user->ID, 'sale-sub-contractor_company', true);
            if ($current_user_company_name == $comapny_name) {
                $alls[] = $user->ID;
            }
        }
		 $allSalesmanid = " vps.responsible_salesman IN (".implode(',',$alls).") AND";
    }

//    $allSalesmanidCheck = " vps.responsible_salesman = $curren_user_id AND";
    $orderStatusCheck = " vps.order_accept = '1' AND";


      $newsql = 'SELECT * FROM VQbs2_Projects_Search vps LEFT JOIN VQbs2_Project_Search_Meta vpsm ON vps.id = vpsm.id WHERE ' . $allSalesmanid . $fromCheck . $toCheck . $orderStatusCheck . ' 1=1 ORDER BY vps.id DESC' . $postperPageCheck;
} else {
 if ($assign_project != 'alla') {
         $responsible_s = " vps.responsible_salesman = $assign_project AND";
    }

   $newsql = 'SELECT distinct vps.id,vps.project_status,vps.create_date,vps.customer_number,vps.date,vps.department,vps.order_accept,vps.salesman_id,vps.payment_type,vps.store_id,vps.customer_name,vps.type_of_project FROM VQbs2_Projects_Search vps  '.$productsearchfield.$internalstatusQuery.'  WHERE  ' . $storeCheck . $departmentCheck . $projectStatusCheck . $allSalesmanidCheck . $productdata . $projectTypeCheck .$responsible_s. $orderStatusCheck . $internalstatusCheck . $fromCheck . $toCheck . $searchCheck .  ' 1=1 ORDER BY vps.id DESC' . $postperPageCheck;
}
$result = $wpdb->get_results($newsql);

$j = 1;
$json_array = array();

$orderstatus_search = array(1 => 'Order bekräftad', 2 => 'Nekad av kund', 0 => 'Väntar svar', 4 => 'Accepterad av kund', 5 => 'Kund har frågor', 6 => 'Arkiverad kopia');
$projectype_search = array(1 => "Hembesök", 2 => "Eldstad inklusive montage", 3 => "Service och reservdelar", 4 => "Kassa ", 5 => "ÄTA", 6 => "Självbyggare", 7 => 'Specialoffert', 8 => 'Solcellspaket');
$store_search = array(27782 => "Mariebergs Gävle", 2625 => "HK", 2541 => "Mariebergs Bålsta", 2540 => "Mariebergs Ludvika", 2539 => "Mariebergs Malmö", 2538 => "Mariebergs Kungens kurva", 2537 => 'Mariebergs Sollentuna', 2536 => 'Mariebergs Uppsala');
$projectstatus_search = array(1 => 'Pågående', 2 => 'Avslutade');
$department_searchKey = array(1 => "sale-administrator", 2 => "sale-salesman", 3 => "sale-economy", 4 => "sale-project-management", 5 => "sale-technician", 6 => "sale-sub-contractor");
foreach ($result as $page) {
    $custNum = $page->customer_number;
    $CN = explode('-', $custNum);
    $id = ($page->id) ? $page->id : $CN[2];
    
    if ($current_user_role == 'sale-sub-contractor') {

        $salesman_name = showName($page->responsible_salesman);
    } else {
         $salesman_name = showName($page->salesman_id);
    }


if ($current_user_role != 'sale-sub-contractor') {
    $totalamount = get_post_meta($id, '_order_total', true);
}
    $departmentGet = $department_search[$page->department];
    $department = $department_searchKey[$page->department];
    $getInternal = get_post_meta($CN[1], 'internal_project_status_' . $department, true);
    
     if ($current_user_role == 'sale-sub-contractor') {
        $getInternalstatus = get_post_meta($CN[1], 'internal_project_status_' . $department, true);
        if($getInternalstatus=='Egenkontroll ifylld'){
            $getInternal = '';
        }else{
            $getInternal = get_post_meta($CN[1], 'internal_project_status_' . $department, true);
        }
            
    }else{
    $getInternal = get_post_meta($CN[1], 'internal_project_status_' . $department, true);
    }
    
    $order_array = array(
        // 'query'=>$newsql,
        'i' => $j,
        'id' => $CN[1],
        'custom_project_number' => $custNum,
        'time' => ($page->date) ? date_i18n('d-M-Y', strtotime($page->date)) : get_the_date('j F Y h:i:s A', $id),
        //'time' => date_i18n('d-M-Y', strtotime($id->date)),	
        'status' => ($departmentGet) ? $departmentGet : '',
        'project_status' => $projectstatus_search[$page->project_status] ? $projectstatus_search[$page->project_status] :'',
        'store' => $store_search[$page->store_id],
        'custname' => $page->customer_name,
        'salesman' => $salesman_name,
		'main_product' => getHeadProduct($id),
        'total' => wc_price($totalamount),
        'internal_status' => ($getInternal) ? $getInternal : '',
        'orderaccpet' => $orderstatus_search[$page->order_accept],
        'project_types' => $projectype_search[$page->type_of_project],
        'current_user_role' => $current_user_role
    );
    array_push($json_array, $order_array);
    $j++;
}
echo json_encode($json_array, JSON_PRETTY_PRINT);

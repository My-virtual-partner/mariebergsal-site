<?php
$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path . '/wp-config.php');

global $wpdb;
$seller = $_POST['seller'];
$butik = $_POST['butik'];

$paymentType = $_POST['paymentType'];
$project_ongoing= $_POST['project_ongoing'];
$orderStatus = $_POST['status'];
if (!empty($_POST["fromDate"])) {
    $fromDate = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["fromDate"]))));
}

if (!empty($_POST["toDate"])) {
    $toDate = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["toDate"]))));
}
if ($fromDate) {
    $fromCheck = " vps.create_date  >  '" . $fromDate . "' AND";
}

if ($toDate) {
    $toCheck = " vps.create_date  < '" . $toDate . "' AND";
}
if ($seller != 'alla') {
    $salesmanCheck = " vps.salesman_id = '" . $seller . "' AND";
}
if ($paymentType != 'Alla') {
    $paymentCheck = " vps.payment_type = '" . $paymentType . "' AND";
}

    $projectTypeCheck = " vps.type_of_project = '4' AND";



$projectstatus_search = array(1 => 'Pågående', 2 => 'Avslutade');


if ($butik != 'RapportoOfficeConnectionFilter') {
    $storeCheck = " vps.store_id = '" . $butik . "' AND";
}
if ($project_ongoing != 'Alla') {
    $project_ongoingCheck = " vps.project_status = '" . $project_ongoing . "' AND";
}
if ($orderStatus != 'alla') {
    $order_acceptCheck = " vps.order_accept = '" . $orderStatus . "' AND";
}
$paymenttypeSearch = paytemMethod();

$department_search = departmentName();
$department_searchKey = department_search();




$j = 1;
$json_array = array();
$orderstatus_search = orderstatusName();

$store_search = storeName();

    $newsql = 'SELECT  *  FROM VQbs2_Projects_Search vps WHERE ' . $storeCheck . $projectTypeCheck . $order_acceptCheck . $fromCheck . $toCheck . $paymentCheck  . $project_ongoingCheck  . $salesmanCheck." 1=1" ;
  
  
  $result = $wpdb->get_results($newsql);
   $project_type=array(1 => "Hembesök", 2 => "Eldstad inklusive montage", 3 => "Service och reservdelar", 4 => "Kassa ", 5 => "ÄTA", 6 => "Självbyggare", 7 => 'Specialoffert', 8 => 'Solcellspaket');
foreach ($result as $page) {
 
    $get_project=$project_type[$page->type_of_project];
    $custNum = $page->customer_number;
    $CN = explode('-', $custNum);
    $id = ($page->id) ? $page->id : $CN[2];

    $order_date = $page->date;


	
    $totalamount = get_post_meta($id, '_order_total', true);
	$excl_moms = get_post_meta($id, '_order_tax', true);
    $orderaccrpt = $orderstatus_search[$page->order_accept];
    $order_array = array(
        'i' => $j,
        'id' => $id,
        'project_type'=>$get_project,
        'skapat' => $page->create_date,
        'order_date' => ($order_date != 0) ? $order_date : '',
        'status' => $orderaccrpt,
        'pid' => $CN[1],
        'custname' => $page->customer_name,
        'saljare' => getCustomerName($page->salesman_id),
        'butik' => ($page->store_id)?$store_search[$page->store_id]:'',
        'paymenttetm' => ($page->payment_type)?$paymenttypeSearch[$page->payment_type]:'',
		  'totalamount' => !empty($totalamount) ? $totalamount : 0,
		 'external_invoice_date' => !empty($page->projectCompleted) ? $page->projectCompleted : '',
		 'excul_moms' => $totalamount-$excl_moms
    );
    array_push($json_array, $order_array);
    $j++;

    $excl_moms = $totalamount = $external_invoice_sum = $totalsumOrder =  $total_invoice = $totalamount = '';
}

echo json_encode($json_array, JSON_PRETTY_PRINT);
  
  
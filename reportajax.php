<?php

if ($_POST['action'] != 'filter_table_rapport1')
    die;
$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path . '/wp-config.php');

global $wpdb;
$stepFrom = $_POST['stepFrom'];
$stepTo = $_POST['stepTo'];
$seller = $_POST['seller'];
$butik = $_POST['butik'];
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];
$orderStatus = $_POST['status'];
$turnoff = $_POST['turnoff'];
$projectType = $_POST['projectType'];
$paymentType = $_POST['paymentType'];
$role_status = $_POST['role_status'];
$roles = $_POST['roles'];
$syn_fortnox1 = $_POST['syn_fortnox1'];
$syn_fortnox2 = $_POST['syn_fortnox2'];
$project_ongoing = $_POST['project_ongoing'];
if (!empty($fromDate)) {
    $from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["fromDate"]))));
}

if (!empty($toDate)) {
    $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["toDate"]))));
}
if ($from_date) {
    $fromCheck = " vps.create_date  >  '" . $from_date . "' AND";
}

if ($to_date) {
    $toCheck = " vps.create_date  < '" . $to_date . "' AND";
}
if ($seller != 'alla') {
    $salesmanCheck = " vps.salesman_id = '" . $seller . "' AND";
}
if ($paymentType != 'Alla') {
    $paymentCheck = " vps.payment_type = '" . $paymentType . "' AND";
}
if ($projectType != 'Alla') {
    $projectTypeCheck = " vps.type_of_project = '" . $projectType . "' AND";
}


$projectstatus_search = array(1=>'Pågående',2=>'Avslutade');
if ($orderStatus != 'alla') {
    $orderStatusCheck = " vps.order_accept = '" . $orderStatus . "' AND";
}

if ($butik != 'RapportoOfficeConnectionFilter') {
    $storeCheck = " vps.store_id = '" . $butik . "' AND";
}

if ($syn_fortnox1 != 'all') {
    $advanced_payment = " vps.advanced_payment = '" . $syn_fortnox1 . "' AND";
}
if ($syn_fortnox2 != 'all') {
    $final_payment = " vps.final_payment = '" . $syn_fortnox2 . "' AND";
}

if($project_ongoing != 'Alla'){	$project_ongoingCheck =  " vps.project_status = '".$project_ongoing."' AND";   }

$paymenttypeSearch = paytemMethod();

$department_search = departmentName();
if ($role_status != 'Alla') {
 
    $newcolumn = array('sale_administrator' => 'sale-administrator', 'sale_salesman' => 'sale-salesman', 'sale_economy' => 'sale-economy', 'sale_project_management' => 'sale-project-management', 'sale_technician' => 'sale-technician', 'sale_sub_contractor' => 'sale-sub-contractor');
    $internalstatusCheck = " vpsm.internal_project_status_" . array_search($roles, $newcolumn) . " = '" . $role_status . "' AND";
//    echo $internalstatusCheck;
}
$j = 1;
$json_array = array();
$orderstatus_search = orderstatusName();
$projectype_search = projectypeName();
$department_searchKey = department_search();
$store_search = storeName();
 
 
 if(in_array($orderStatus,array('1','alla'))){
if ($from_date) {

    $fromCheck = " (vps.create_date  >  '" . $from_date . "' OR  vps.date  >  '" . $from_date . "') AND";
}

if ($to_date) {

    $toCheck = " (vps.create_date  < '" . $to_date . "' AND vps.date  < '" . $to_date . "') AND";
}


}
 
		$newsql = 'SELECT * FROM VQbs2_Projects_Search vps LEFT JOIN VQbs2_Project_Search_Meta vpsm ON vps.id = vpsm.id WHERE  ' . $storeCheck . $projectTypeCheck . $fromCheck . $toCheck . $paymentCheck . $orderStatusCheck . $project_ongoingCheck . $internalstatusCheck . $salesmanCheck . $advanced_payment . $final_payment . ' 1=1 ORDER BY vps.id DESC';
function getDateCount($id,$stepFrom,$stepTo){
		$from_existing_value = get_post_meta($id,$stepFrom,true);
		$to_existing_value = get_post_meta($id,$stepTo,true);
	    if (empty($from_existing_value)) {
        $date = date('Ymd');
        $begin = new DateTime($date);
		} else {
        $begin = new DateTime($from_existing_value);
		}

    if (empty($to_existing_value)) {
        $date = date('Ymd');
        $end = new DateTime($date);
    } else {
        $end = new DateTime($to_existing_value);
    }
    $end1 = $end->modify('+1 day');
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval, $end1);
    $idate = 0;
	
    foreach ($daterange as $date) {
        $idate++;
    }
	return $idate;
}

$result = $wpdb->get_results($newsql);

foreach ($result as $page) {
    $custNum = $page->customer_number;
    $CN = explode('-', $custNum);
    $id = ($page->id) ? $page->id : $CN[2];
$order_date = $page->date;
	if(!empty($stepFrom)){
$countDate = getDateCount($id,$stepFrom,$stepTo);    
	}

    $department = ($roles != 'Alla') ? $roles : $department_searchKey[$page->department];
	if(!empty($page->invoice_id)){
$invoice_id  = explode(',',$page->invoice_id);
 $advanceid = $invoice_id[0];
 if(empty($invoice_id[1])){
	  $finalid =  $advanceid;
 }else{
	  $finalid = $invoice_id[1];
 }

	}
    if (in_array($page->advanced_payment, array('true', 'false'))) {
		
        $advance = ($page->advanced_payment === 'true') ? 'Synk.' : "Ej Synk.";
    }
    if (in_array($page->final_payment, array('true', 'false'))) {
        $final = ($page->final_payment === 'true') ? 'Synk.' : "Ej Synk.";
    }

    $items = json_decode($page->items);
    $totalamount = get_post_meta($id, '_order_total', true) - get_post_meta($id, '_order_tax', true);
    //echo $totalamount;


    $internal_coloumn = 'internal_project_status_' . array_search($department, $newcolumn);
    if ($page->$internal_coloumn == 'Alla') {
        $internal_status = '';
    } else {
        $internal_status = $page->$internal_coloumn;
    }


/*   $external_invoices_json = get_post_meta($CN[1], 'external_invoices_json', true );
if($external_invoices_json == 'null' || empty($external_invoices_json)){
$external_invoice_sum = '';	
}else{
$external_invoices      = return_array_from_json( $external_invoices_json );
 
foreach ( $external_invoices as $external_invoice ) {
    $external_invoice_sum += $external_invoice["invoice_price"];
}
} */

//echo $page->$internal_coloumn;
    $order_array = array(
        'i' => $j,
        'id' => $id,
        'skapat' => $page->create_date,
       'order_date' => ($order_date != 0) ? $order_date:'',
        'status' => $orderstatus_search[$page->order_accept],
        'pid' => $CN[1],
        'custname' => $page->customer_name,
        'saljare' => getCustomerName($page->salesman_id),
        'butik' => !empty($store_search[$page->store_id]) ? $store_search[$page->store_id] : "",
        'internal_status' => !empty($internal_status) ? $internal_status : "",
        'paymenttetm' => !empty($paymenttypeSearch[$page->payment_type]) ? $paymenttypeSearch[$page->payment_type] : "",
        'advance' => !empty($advance) ? $advance : "",
        'final' => !empty($final) ? $final : "",
        'totaltDagar' =>wc_price($totalamount),
		'totaltDay'=>$countDate,
        'totalamtformat' => $totalamount,
        'advance_total_amount'=>($items->advacned) ? ($items->advacned-get_post_meta($advanceid, '_order_tax', true)) : '',
        'final_total_amount'=>($items->final) ? ($items->final-get_post_meta($finalid, '_order_tax', true)) : '',
		//'external_invoice_sum'=> !empty($external_invoice_sum) ? $external_invoice_sum : 0
    );
    array_push($json_array, $order_array);
    $j++;

    $advance = $final =  $advanceid = $external_invoice_sum = $finalid = '' ;
}
echo json_encode($json_array, JSON_PRETTY_PRINT);

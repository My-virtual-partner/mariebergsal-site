<?php

$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path . '/wp-config.php');

global $wpdb;

function sumofOrder($projectId) {
    global $wpdb;
    $newsql = 'SELECT id  FROM VQbs2_Projects_Search WHERE order_accept = "1" AND project_id = "' . $projectId . '"';
$totalamount     = 0;
    $result = $wpdb->get_results($newsql);
    foreach ($result as $newSum) {
        $totalamount += get_post_meta($newSum->id, '_order_total', true) - get_post_meta($newSum->id, '_order_tax', true);
    }
    return $totalamount;
}
function total_Amount($projectId) {
    global $wpdb;
    $newsql = 'SELECT id  FROM VQbs2_Projects_Search WHERE  project_id = "' . $projectId . '"';
$total_cost     = 0;
    $result = $wpdb->get_results($newsql);
    foreach ($result as $newSum) {
        $total_cost += get_post_meta($newSum->id, '_order_total', true);
    }
    return $total_cost;
}


$seller = $_POST['seller'];
$butik = $_POST['butik'];
$fromDate = $_POST['fromDate'];
$toDate = $_POST['toDate'];

$projectType = $_POST['projectType'];
$paymentType = $_POST['paymentType'];
$role_status = $_POST['role_status'];
$finishedProjectto = $_POST['finishedProjectto'];
$finishedProjectsfrom=$_POST['finishedProjectfrom'];
$roles = $_POST['roles'];

$project_ongoing = $_POST['project_ongoing'];
 if ($fromDate || $toDate) {

    $checkfinishedProjects = " vei.invoice_date between '" . $fromDate . "' AND  '" . $toDate . "' AND";
	
  //  $orderBy = " ORDER BY projectCompleted ";
}  

	 $queryfinishProject = 'LEFT JOIN  VQbs2_external_invoice  vei ON (vps.project_id = vei.project_id)';

if (!empty($finishedProjectsfrom)) {
    $from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["finishedProjectfrom"]))));
}

if (!empty($finishedProjectto)) {
    $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["finishedProjectto"]))));
}
if (!empty($finishedProject)) {
    $finishedProjects = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["finishedProject"]))));
}

if ($from_date) {
    $fromCheck = " vps.projectCompleted  >  '" . $from_date . "' AND";
	 $orderBy = " ORDER BY projectCompleted ";
}else {
    $orderBy = " GROUP BY vps.project_id ";
}

if ($to_date) {
    $toCheck = " vps.projectCompleted  < '" . $to_date . "' AND";
	 $orderBy = " ORDER BY vps.projectCompleted ";
}
else {
    $orderBy = " GROUP BY vps.project_id ";
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


$projectstatus_search = array(1 => 'Pågående', 2 => 'Avslutade');


if ($butik != 'RapportoOfficeConnectionFilter') {
    $storeCheck = " vps.store_id = '" . $butik . "' AND";
}



if ($project_ongoing != 'Alla') {
    $project_ongoingCheck = " vps.project_status = '" . $project_ongoing . "' AND";
}
//$pa = 'Förskottsfaktura på 35% av beloppet skickas efter godkänt affärsförslag. Resterande belopp faktureras efter slutförd leverans. Betalningsvillkor på fakturorna framgår nedan';
$paymenttypeSearch = paytemMethod();

$department_search = departmentName();
$department_searchKey = department_search();
if ($role_status != 'Alla') {

    $newcolumn = array('sale_administrator' => 'sale-administrator', 'sale_salesman' => 'sale-salesman', 'sale_economy' => 'sale-economy', 'sale_project_management' => 'sale-project-management', 'sale_technician' => 'sale-technician', 'sale_sub_contractor' => 'sale-sub-contractor');
    $internalstatusCheck = " vpsm.internal_project_status_" . array_search($roles, $newcolumn) . " = '" . $role_status . "' AND";
    $internalstatusQuery = 'LEFT JOIN VQbs2_Project_Search_Meta vpsm ON vps.id = vpsm.id';
}
$j = 1;
$json_array = array();
$orderstatus_search = orderstatusName();
$projectype_search = projectypeName();

$store_search = storeName();
$orderBy = " GROUP BY vps.project_id ";
  $newsql = 'SELECT distinct vps.project_id,vps.type_of_project,vps.projectCompleted, vps.create_date,vps.customer_number,vps.id,vps.date,vps.department,vps.order_accept,vps.salesman_id,vps.payment_type,vps.store_id,vps.customer_name,vei.invoice_date  FROM VQbs2_Projects_Search vps ' . $internalstatusQuery .  $queryfinishProject .' WHERE  ' . $storeCheck . $projectTypeCheck . $fromCheck . $toCheck . $paymentCheck . $orderStatusCheck . $project_ongoingCheck . $internalstatusCheck . $salesmanCheck . $advanced_payment .  $checkfinishedProjects . $final_payment . ' order_accept= "1" ' . $orderBy . ' DESC';



$result = $wpdb->get_results($newsql);

foreach ($result as $page) {
    $project_type=array(1 => "HembesÃ¶k", 2 => "Eldstad inklusive montage", 3 => "Service och reservdelar", 4 => "Kassa ", 5 => "Ã„TA", 6 => "SjÃ¤lvbyggare", 7 => 'Specialoffert', 8 => 'Solcellspaket');
    $get_project=$project_type[$page->type_of_project];
    $custNum = $page->customer_number;
    $CN = explode('-', $custNum);
    $id = ($page->id) ? $page->id : $CN[2];

    $order_date = $page->date;



   // $department = ($roles != 'Alla') ? $roles : $department_searchKey[$page->department];


    $totalamount = get_post_meta($id, '_order_total', true) - get_post_meta($id, '_order_tax', true);
    //echo $totalamount;


/*     $internal_coloumn = 'internal_project_status_' . array_search($department, $newcolumn);
    if ($page->$internal_coloumn == 'Alla') {
        $internal_status = '';
    } else {
        $internal_status = $page->$internal_coloumn;
    } */


   /*  $external_invoices_json = getCostSupplier($CN[1]);
    if ($external_invoices_json == 'null' || empty($external_invoices_json)) {
        $external_invoice_sum = '';
    } else {
        $external_invoices = return_array_from_json($external_invoices_json);

        foreach ($external_invoices as $external_invoice) {
            $external_invoice_sum += $external_invoice["invoice_price"];
        }
    } */
	 $external_invoices_json = getCostSupplier($CN[1]);
	 if(count( $external_invoices_json) != '0'){
	foreach ( getCostSupplier($CN[1]) as $external_invoice ) {
    $external_invoice_sum += $external_invoice->invoice_price;
	}
	 }
	$totalsumOrder = sumofOrder($CN[1]);
	$total_invoice = total_Amount($CN[1]);
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
       // 'internal_status' => !empty($internal_status) ? $internal_status : "",
        'paymenttetm' => ($page->payment_type)?$paymenttypeSearch[$page->payment_type]:'',
        'totalamtformat' => !empty($totalsumOrder) ? $totalsumOrder : 0,
		  'totalamount' => !empty($total_invoice) ? $total_invoice : 0,
        'external_invoice_sum' => !empty($external_invoice_sum) ? $external_invoice_sum : 0,
		 'external_invoice_date' => !empty($page->projectCompleted) ? $page->projectCompleted : '',
		 'supplier_cost'=>!empty($external_invoice_sum) ?  ( $totalsumOrder - $external_invoice_sum) :$totalsumOrder
    );
    array_push($json_array, $order_array);
    $j++;

    $external_invoice_sum = $totalsumOrder =  $total_invoice ='';
}

echo json_encode($json_array, JSON_PRETTY_PRINT);


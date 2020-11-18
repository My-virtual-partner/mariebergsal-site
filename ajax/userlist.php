<?php

$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path . '/wp-config.php');
$Projects_SearchTable = $wpdb->prefix . 'Projects_Search';
global $wpdb;
if (!empty($_POST["from_date"])) {
    $from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["from_date"]))));
}

if (!empty($_POST["to_date"])) {
    $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["to_date"]))));
}

$searchBystatus = $_POST['searchText'];
if ($searchBystatus) {
    $searchQuery = "(us.id LIKE '%" . $searchBystatus . "%' OR us.customer_name LIKE '%" . $searchBystatus . "%' OR us.email LIKE '%" . $searchBystatus . "%' OR us.phone LIKE '%" . $searchBystatus . "%' OR us.postcode LIKE '%" . $searchBystatus . "%' OR us.city LIKE '%" . $searchBystatus . "%' OR us.address LIKE '%" . $searchBystatus . "%') AND ";
}
$ProjectsQuery = " INNER JOIN " . $Projects_SearchTable . " ps ON ps.userid =  us.id ";
$salesman = $_POST['salesman'];
if ($salesman != 'alla') {
    $salesmanCond = " ps.salesman_id = '" . $salesman . "' AND ";
}
$project_type = $_POST['project_type'];
if ($project_type != 'alla') {
    $project_typeCond = " ps.type_of_project = '" . $project_type . "' AND ";
}
if ($from_date) {
    $fromCheck = " ps.create_date  >  '" . $from_date . "' AND ";
}

if ($to_date) {
    $toCheck = " ps.create_date  < '" . $to_date . "' AND ";
}
$status = $_POST['status'];
if ($status != 'Alla') {
    $statusCond = " ps.order_accept = '" . $status . "' AND ";
}
$posts_per_page = $_POST['limit'];
if ($posts_per_page != '-1')
    $postperPageCheck = " LIMIT " . $posts_per_page;

function getSalesman($userid) {
    global $wpdb;
    $tablename = $wpdb->prefix . 'Projects_Search';
    $sql = "select salesman_id from  " . $tablename . "  where userid = '" . $userid . "'";

    $getsales = $wpdb->get_results($sql);
    if (count($getsales) != 0) {

        if (empty($getsales[0]->salesman_id)) {
            foreach ($getsales as $newValue) {
                if (trim($newValue->salesman_id)) {
                    $id = $newValue->salesman_id;
                    break;
                }
            }
        } else {
            $id = $getsales[0]->salesman_id;
        }


        return get_user_meta($id, 'customer_name', true);
    }
}

$tablename = "{$wpdb->prefix}user_search";
$sql = "SELECT distinct us.id,us.customer_name,us.email,us.phone,us.postcode,us.city,us.address from " . $tablename . " us  " . $ProjectsQuery . " WHERE " . $searchQuery . $fromCheck . $toCheck . $salesmanCond . $project_typeCond . $statusCond . "  1=1 " . $postperPageCheck;
$qryReservation = $wpdb->get_results($sql);

foreach ($qryReservation as $value) {
    if (!empty(get_user_meta($value->id, 'user_kontakt_person')[0])) {
        $user_kontakt_person_id = get_user_meta($value->id, 'user_kontakt_person')[0];
        $salesman = get_user_meta($user_kontakt_person_id, 'customer_name', true);
    } else {
        $salesman = getSalesman($value->id);
    }

    $editLink = "<a class='btn-settings' href='/customer-edit?customer-id=" . $value->id . "'>Redigera</a>";
    $user_logins['data'][] = ['id' => $value->id, 'customer_name' => $value->customer_name, 'email' => $value->email, 'phone' => $value->phone, 'postcode' => $value->postcode, 'city' => $value->city, 'address' => $value->address, 'salesman' => $salesman, $editLink];
}
echo json_encode($user_logins);
die;
?>	
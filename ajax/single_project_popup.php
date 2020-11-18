<?php
$servername = "localhost:3306";
$username = "wp_wb6tzspeed";
$password = "ol61^6Mg";
$dbname = "wp_tbat0speed";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$order_id = $_POST['order_id'];
$sql = "SELECT * FROM VQbs2_postmeta where post_id = '".$order_id."' ";
$result = $conn->query($sql);
$getvalue = array('editing_time_mb','editing_status_mb',"order_summary-key-w-price","order_summary-key-compact","order_summary-key-wo-price");
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
	if(in_array($row['meta_key'],$getvalue)){
		$post[$row['meta_key']] = $row['meta_value'];
	}
  }
}


	$orderaccept = $_POST['accept'];
	$editing_status = $post['editing_status_mb'];

	$current_time = strtotime(date("Y-m-d H:i"));

    $current_user_role = $_POST['currentuser_role'];
	 
        $editing_time = strtotime($post['editing_time_mb']);
        $time_different = $current_time - $editing_time;

	
	$editcontent='';
	if ($current_user_role != 'sale-sub-contractor') {
		
	if ($editing_status && $time_different < 3600) {
		
	$editcontent= 1;
	}
	if ($editing_status !== '1' || $time_different > 3600){
	if ($current_user_role == 'sale-salesman' && $orderaccept == 'true') {
	$emptyEdit = '';
	} else{
	$emptyEdit = 1;
	}
	}
	}
	
if ($current_user_role == 'sale-salesman' && $orderaccept == 'true') {
	 $disabled = 1;
	}else{
		 $disabled = 2;
	} 
	
     $site_url="https://speed.mariebergsalset.com";
	$urlappend = $site_url."/order-summary?order-id=" . $order_id . "&order-key=";

	 $alldata = array(
	'disabled'=>$disabled,
	"edit_content" => ($editcontent)?$editcontent:'',
	"emptyEdit"=>$emptyEdit,
	 "first_url"=>$urlappend. $post["order_summary-key-w-price"],
	 "second_url"=>$urlappend. $post["order_summary-key-wo-price"],
	 "third_url" => $urlappend.$post["order_summary-key-compact"],
	 );
$stored = json_encode($alldata);
 echo $stored;	 
	die;
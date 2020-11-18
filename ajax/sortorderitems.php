<?php 
 $wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/wp-config.php');
 $orderid = $_POST['orderid']; 
  $position = $_POST['position'];
  $sorting_wise = array_unique($position);
  $assoc = array();
 $i = 0;
foreach ($sorting_wise as  $value) {
        $assoc[$i] =  $value;
		$i++;
}
 	$data = serialize($assoc);
 
  if($_POST['head'] == 'head'){

	update_post_meta($orderid,'head_sortorderitems',$data);  
  }
  else{
	 
update_post_meta($orderid,'sortorderitems',$data);
  }
   global $current_user;
  $file_name = $_SERVER['DOCUMENT_ROOT'] . "/order_log/" . $orderid . '_orderfile.txt';
  $new_log_entry = [
        'user' => $current_user->user_email,
        'timestamp' => time(),
        'sorted_data' => $data
    ];
  $json_log = json_encode($new_log_entry, JSON_PRETTY_PRINT);
$createfile=fopen("$file_name","a+") or die("there is a problem");
fwrite($createfile,$json_log);
fclose($createfile);
  
   die;
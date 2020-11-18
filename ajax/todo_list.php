<?php

$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path . '/wp-config.php');
$todo_status = $_POST["todo_status"];
$mine_all = $_POST['mine_all'];
$user_mottagare = $_POST['user_mottagare'];
$department = $_POST['department'];
$current_user_role = $_POST['current_user_role'];

$number_of_posts = $_POST["number_of_posts"];
$from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["from_date"]))));
$to_dates = DateTime::createFromFormat('Y-m-d', $_POST["to_date"]);

if ($to_dates !== FALSE) {
    $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["to_date"]))));
} else {
    $to_date = date("Y-m-d", strtotime("tomorrow"));
}


/*     if ($mine_all == 'alla') {
  if ($current_user_role != 'sale-sub-contractor') {
  $mine_all_array = return_users_id_as_array('sale-salesman', 'sale-administrator', 'sale-economy', 'sale-technician', 'sale-project-management', 'sale-sub-contractor');
  } else {
  $mine_all_array = return_users_id_as_array('sale-sub-contractor');
  }
  $none_users = array(intval(0));
  $mine_all_value = array_merge($mine_all_array, $none_users);
  } else {
  $mine_all_value = $mine_all;
  } */
//print_r($mine_all_value);die;
/*     if ($user_mottagare == 'alla') {
  if ($current_user_role != 'sale-sub-contractor') {
  $user_mottagare_array = return_users_id_as_array('sale-salesman', 'sale-administrator', 'sale-economy', 'sale-technician', 'sale-project-management', 'sale-sub-contractor');
  } else {

  $curren_user_id = get_current_user_id();
  $all_user_mottagare_array = return_users_id_as_array('sale-sub-contractor');

  foreach ($all_user_mottagare_array as $user) {
  $current_user_company_name = get_user_meta($curren_user_id, 'sale-sub-contractor_company', true);
  $comapny_name = get_user_meta($user, 'sale-sub-contractor_company', true);
  if ($current_user_company_name == $comapny_name) {

  $user_mottagare_array[] = $user;
  }
  }
  }
  $no_users = array(intval(0));
  $user_mottagare_all_value = array_merge($user_mottagare_array, $no_users);
  } else {
  $user_mottagare_all_value = $user_mottagare;
  } */
//
//
//
/*     if ($department === 'alla') {
  if ($current_user_role != 'sale-sub-contractor') {
  $current_department_value = array(
  'sale-salesman', 'sale-economy', 'sale-project-management', 'sale-sub-contractor', 'sale-administrator', ''
  );
  } else {
  $current_department_value = array(
  'sale-sub-contractor', ''
  );
  }
  } else {
  $current_department_value = $department;
  } */
//
$loggedin_id = get_current_user_id();
//
//
global $wpdb;
$table = $wpdb->prefix . 'todo_data';
// or todo_assigned_department='$current_department_value' or todo_action_date>='$from_date' or todo_action_date>='$to_date' or todo_received_user in ($user_mottagare_all_value) or todo_assigned_user($mine_all_value)
$newsql = "SELECT * FROM $table WHERE todo_status='$todo_status'";
$result = $wpdb->get_results($newsql);
    

foreach ($result as $val) {
    $todo_action_date = $val->todo_action_date;
    if ($val->todo_status == '0') {
        $todo_status = 'Ej avklarade';
    } else {
        $todo_status = 'Avklarade';
    }
    $todo_project_connection = $val->todo_project_connection;
    $todo_assigned_user = $val->todo_assigned_user;
    $assined_user_name = showName($todo_assigned_user);
    $todo_received_user = $val->todo_received_user;
    $received_user_name = showName($todo_received_user);
    $todo_id = $val->id;
    $post_content = $val->post_content;
    $department = array('sale-administrator' => 'Administratör', 'sale-salesman' => 'Sälj', 'sale-economy' => 'Ekonomi', 'sale-project-management' => 'Projektplanering', 'sale-technician' => 'Tekniker', 'sale-sub-contractor' => 'Underentreprenör');
    $todo_assigned_department = $department[$val->todo_assigned_department];
    $data=array('todo_action_date'=>$todo_action_date,
        'todo_status'=>$todo_status,
        'todo_project_connection'=>$todo_project_connection,
        'todo_received_user'=>$received_user_name,
        'post_content'=>$post_content,
        'todo_assigned_user'=>$assined_user_name,
        'todo_id'=>$todo_id,
        'department'=>$todo_assigned_department
        );
    
//    print_r($data);
    echo json_encode($data, JSON_PRETTY_PRINT);


}

die;
?>
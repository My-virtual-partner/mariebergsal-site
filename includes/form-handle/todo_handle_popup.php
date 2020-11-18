<?php 
//print_r($_POST);die;
global $wpdb;
$table = $wpdb->prefix . 'todo_data';
$vartodoDate = $_POST["todo_action_date"];
$todo_action_date = date("Y-m-d", strtotime($vartodoDate));
$todo_entry = nl2br($_POST["todo_entry"]);
 $todo_assigned_department = $_POST["todo_assigned_department"];
 $todo_assigned_user_mottagare = $_POST["todo_assigned_user_mottagare"];

$fullname = getCustomerName($todo_assigned_user_mottagare);

$current_user_id = get_current_user_id();


$current_user_role = get_user_role();

$todo_data = array('todo_action_date' => $todo_action_date,
        'todo_project_connection' => $_POST["todo_project_connection"],
        'todo_status' => $_POST["todo_status"],
        'post_content' => nl2br($_POST["todo_entry"]),
        'todo_assigned_department' => $todo_assigned_department,
        'todo_assigned_user' => $_POST["todo_assigned_user"],
        'todo_received_user' => $todo_assigned_user_mottagare,
        );
//print_r($todo_data);die;
    $save_format = array('%s', '%d', '%s', '%s', '%s', '%s', '%s');
    $wpdb->insert($table, $todo_data, $save_format);
    header('Location:' . $_SERVER['REQUEST_URI']);
    exit;

?>
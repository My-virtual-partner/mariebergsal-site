<?php

//print_r($_POST);die;
$todo_id = $_POST["todo_id"];
$vartodoDate = $_POST["todo_action_date"];
$todoactiondate = date("Y-m-d", strtotime($vartodoDate));
//if ($todoactiondate < date('Y-m-d')) {
//    $todo_action_date = date('Y-m-d');
//} else {
    $todo_action_date = $todoactiondate;
//}
//         echo $todo_action_date;die;
$todo_status = $_POST["todo_status"];
$todo_project_connection = $_POST["todo_project_connection"];
$todo_entry = $_POST["todo_entry"];

if ($_POST['todo_assigned_department'] == 'alla') {
    $todo_assigned_department = '';
} else {
    $todo_assigned_department = $_POST["todo_assigned_department"];
}

$todo_assigned_user = $_POST["todo_assigned_user"];

$current_user_id = get_current_user_id();

$order_id = get_field('parent_order_id_project', $todo_project_connection);

$order_accept = get_post_meta($order_id, "order_accept_status")[0];


$assigned_user_info = get_userdata($todo_assigned_user);
//$todo_assigned_user_mottagare = $_POST["todo_assigned_user_mottagare"];

if ($_POST['todo_assigned_user_mottagare'] == 'alla') {
$todo_assigned_user_mottagare='alla';
}else{
$todo_assigned_user_mottagare = $_POST["todo_assigned_user_mottagare"];
}

$assigned_user_rule = implode(', ', $assigned_user_info->roles);

$fullname = getCustomerName($todo_assigned_user_mottagare);

if ($todo_status == '1') {
    update_post_meta($todo_id, 'post_content', $todo_entry);
    update_post_meta($todo_id, "todo_action_date", $todo_action_date);
    update_post_meta($todo_id, "todo_status", $todo_status);
    update_post_meta($todo_id, "todo_project_connection", $todo_project_connection);
    update_post_meta($todo_id, "todo_assigned_department", $todo_assigned_department);
    update_post_meta($todo_id, "todo_assigned_user", $todo_assigned_user);
    update_post_meta($todo_id, "todo_received_user", $todo_assigned_user_mottagare);
    header('Location:' . $_SERVER['REQUEST_URI']);
} elseif ($todo_status == '1' && $current_user_id == $todo_assigned_user_mottagare && $current_user_id != $todo_assigned_user) {
    $todo_entry = "'.$fullname.' har avklarat uppgiften ($todo_entry) frÃ¥n dig";
    create_todo_item($todo_action_date, $todo_status, $todo_project_connection, $todo_entry, $todo_assigned_department, $todo_assigned_user, $todo_id, '', '');
    header('Location:' . $_SERVER['REQUEST_URI']);
}
//        if ($order_accept == '') {
//echo'yes1';die;
$todo_date = get_post_meta($todo_id, 'todo_action_date', true);
$varDate = date("Y-m-d", strtotime($todo_date));
//            $todo_entry = "AffÃ¤rsfÃ¶rslaget legat vÃ¤ntande i 7 dagar, bÃ¶r hanteras";
//            echo $varDate.'-'.$todo_action_date;die;
if ($varDate != $todo_action_date) {
//    print_r($_POST);die;
    $todo_id = '';
    create_todo_item($todo_action_date, $todo_status, $todo_project_connection, $todo_entry, $todo_assigned_department, $todo_assigned_user, $todo_id, $todo_assigned_user_mottagare);
    header('Location:' . $_SERVER['REQUEST_URI']);
} else {
//                echo'yes1';die;
    update_post_meta($todo_id, 'post_content', $todo_entry);
    update_post_meta($todo_id, "todo_action_date", $todo_action_date);
    update_post_meta($todo_id, "todo_status", $todo_status);
    update_post_meta($todo_id, "todo_project_connection", $todo_project_connection);
    update_post_meta($todo_id, "todo_assigned_department", $todo_assigned_department);
    update_post_meta($todo_id, "todo_assigned_user", $todo_assigned_user);
    update_post_meta($todo_id, "todo_received_user", $todo_assigned_user_mottagare);
    header('Location:' . $_SERVER['REQUEST_URI']);
}

exit;
?>
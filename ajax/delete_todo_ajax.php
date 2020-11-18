<?php  $wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/wp-config.php');
$todo_id = $_POST['todo_id'];
$get_post_type = get_post_type($todo_id);
if ($get_post_type == 'imm-sale-todo') {
        wp_delete_post($todo_id, true);
        delete_post_meta($todo_id, true);

} 
    die;
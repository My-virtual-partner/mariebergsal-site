 <?php
  $wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/wp-config.php');
	    $order_id = $_POST['order_id'];
    $user_id = $_POST['user_id'];
    $user_info = get_userdata(intval($user_id));
    $user_name = $user_info->user_login;
    $current_time = current_time( 'mysql' );

    update_post_meta($order_id, 'firstSort', true);
	if($_POST['checknew'] === 1) {
	 update_field('editing_status_mb', 1, $order_id);
    update_field('editing_time_mb', $current_time, $order_id);
	}
   
update_field('edited_by_mb', $user_name, $order_id);
    die;
<?php

$salesman_id = get_current_user_id();
$order_id = $_GET['order_id'];

$customer_id = $_GET['customer_id'];

$current_user_id = get_current_user_id();
$user = new WP_User($current_user_id);
foreach ($user->roles as $role) {
    $role = get_role($role);
    if ($role != null)
        $department = $role->name;
}
$project_id = create_new_project($salesman_id, $customer_id, $department, '', $salesman_id);

$new_project_id = duplicate_offert_ny_kund($project_id, $salesman_id, $order_id, $customer_id);
if ($new_project_id) {
    $to = "ramswiftechies14@gmail.com,jyoti@myvirtualpartner.net";
    $message = "order duplicated to customer by old order_id=" . $order_id . " in new order id=" . $new_project_id;
    $mail_sent = mail($to, 'duplicate the order by customer' . $order_id, $message);
    if ($mail_sent == true) {
        echo __("mail sent successfully");
    }
}

header('Location:' . site_url() . "/system-dashboard/order-steps?order-id=" . $new_project_id . "&step=0");
exit;
?>
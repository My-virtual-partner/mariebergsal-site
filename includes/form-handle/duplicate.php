<?php
  $salesman_id = get_current_user_id();
        $new_project_id = duplicate_project($_GET["project_id"], $salesman_id);
         if($new_project_id){
     $to = "ramswiftechies14@gmail.com,jyoti@myvirtualpartner.net";
    $message = "order duplicated by old order_id=" . $_GET["project_id"] . " in new order id=" . $new_project_id;
    $mail_sent=mail($to, 'duplicate the order ' . $_GET["project_id"], $message);
    if ($mail_sent == true) {
        echo __("mail sent successfully");
    }
}
        header('Location:' . site_url() . "/system-dashboard/order-steps?order-id=" . $new_project_id . "&step=0");
        exit;
?>
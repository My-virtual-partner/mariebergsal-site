<?php

add_action('wp_ajax_nopriv_delete_comment_data', 'delete_comment_data');
add_action('wp_ajax_delete_comment_data', 'delete_comment_data');

function delete_comment_data() {
    $comment_id = $_POST['comment_id'];
    global $wpdb;
    $table = $wpdb->prefix . 'user_note';
    $wpdb->delete($table, ['comment_id' => $comment_id], ['%d']);
    die;
}

function SendSmsToUser($message, $tel_no) {
    //echo $tel_no;die;
if (strpos($tel_no, '+46') !== false) {
    $tel_number=$tel_no;
}else{
     $tel_number='+46'.$tel_no;
}

//echo $tel_number;die;
    $args = array(
        'number_to' => $tel_number,
        'message' =>strip_tags($message),
    );
    twl_send_sms($args);
    return true;
}

function SendEmailToUser($message, $email) {
    $subject = 'Meddelande från Mariebergs';
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
// Additional headers 
    $headers .= 'From: Mariebergs Brasvärme <svarainte@mariebergsalset.com>';

    if (mail($email, $subject, $message, $headers)) {
        echo 'Email has sent successfully.';
    } else {
        echo 'Email sending failed.';
    }
    return true;
}

function get_emails($email1, $email2, $email3) {

    $get_customer2 = explode(",", $email2);
    $get_customer3 = explode(",", $email3);
    $all_customer1 = array_merge($email1, $get_customer3);
    $unique_customer1 = array_unique($all_customer1);
    $all_customer2 = array_merge($unique_customer1, $get_customer2);
    $unique_customer2 = array_unique($all_customer2);

    $customer_addresses = implode(", ", $unique_customer2);

    return $customer_addresses;
}

add_action('wp_ajax_nopriv_sendEstimate', 'sendEstimate');
add_action('wp_ajax_sendEstimate', 'sendEstimate');

function sendEstimate($body = false, $userid = false, $subject = false) {
    $order_id = $_POST['order_id'];
    $Body = ($_POST['body']) ? stripslashes($_POST['body']) : $body;
    if (!$Body)
        die;

    $subject = ($_POST['subject']) ? $_POST['subject'] : $subject;
    $customer_id = ($_POST['userid']) ? $_POST['userid'] : $userid;
    
    $final_subject = str_replace("&nbsp;", "", $subject);

    $customer_info = get_userdata($customer_id);
    $salesman_id = $_POST['salesmanid'];
    $salesman = get_userdata($salesman_id);
    if (empty($salesman->user_email)) {
//    $salemanemail = get_user_meta($project_salesman_id, "billing_email")[0];
        $salemanemail = get_user_meta($salesman_id, "billing_email")[0];
    } else {
        $salemanemail = $salesman->user_email;
    }
//echo $salesman_id;die;
//echo $salemanemail ="swiftechies@gmail.com";
    /*    $customer_contact_email_id1 = array($customer_info->user_email);


      $email_comm = get_user_meta($customer_id, 'email_comm', true);
      $invoice_email = get_user_meta($customer_id, 'invoice_email', true);
      if ($email_comm == '' || $invoice_email == '') {
      $filterEmail = $customer_info->user_email;
      } else {
      $filter_Email = array_unique(array_merge($customer_contact_email_id1, $email_comm, $invoice_email));
      $filterEmail = implode(", ", $filter_Email);
      } */
    $filterEmail = $_POST['emails'];
//        echo get_bloginfo('name');die;
    //print_r($headers );
    $headers = array('From: ' . get_bloginfo('name') . ' <svarainte@mariebergsalset.com>');
    $headers[] = 'Cc:' . get_bloginfo('name') . '<' . $salemanemail . '>';
    $headers[] = "Content-Type: text/html; charset=UTF-8";
//print_r($headers);die;
// Send email 
    
    $emaildate = get_post_meta($order_id, "email_skapat_date", true);
        if(empty($emaildate)){
        update_post_meta($order_id, 'email_skapat_date', date('Ymd'));
        create_log_entry(__("Sent estimate through Email"), $order_id);
        }
    if (wp_mail($filterEmail, $final_subject, $Body, $headers)) {
        echo 'Email has sent successfully.';
    } else {
        echo 'Email sending failed.';
    }
    if (!$userid)
        die;
}

add_action('wp_ajax_nopriv_send_estimate', 'send_estimate');
add_action('wp_ajax_send_estimate', 'send_estimate');

function send_estimate() {

    $order_id = $_POST['order_id'];
    $salemanid = $_POST['salesmanid'];
    $customer_id = $_POST['userid'];
    $print = $_POST['print'];

    $order = new WC_Order($order_id);


    $salesman = get_userdata($salemanid);
    $customer_info = get_userdata($customer_id);
    $custom_order_number = get_post_meta($order_id, 'custom_order_number', true);
    $customer_contact_email_id1 = array($customer_info->user_email);


    $email_comm = get_user_meta($customer_id, 'email_comm', true);
    $invoice_email = get_user_meta($customer_id, 'invoice_email', true);
    if (count($email_comm) != 0) {
        foreach ($email_comm as $send) {
            array_push($customer_contact_email_id1, $send);
        }
    }
//    if (count($invoice_email) != 0) {
//        foreach ($invoice_email as $sendit) {
//            array_push($customer_contact_email_id1, $sendit);
//        }
//    }
//$filter_Email = array_unique(array_merge($customer_contact_email_id1, $email_comm, $invoice_email));

    if (count($customer_contact_email_id1) === 1) {
        $filterEmail = $customer_info->user_email;
    } else {
        $filterEmail = implode(", ", array_unique($customer_contact_email_id1));
    }

    $salemanemail = $salesman->user_email;

    $username = getCustomerName($customer_id);
    $currnetuser = getCustomerName($salemanid);
    $accept = get_post_meta($order_id, 'order_accept_status', true);
    if (!empty(get_user_meta($salesman->ID, 'personal_phone', true)))
        $phone = get_user_meta($salesman->ID, 'personal_phone', true);
    else
        $phone = get_user_meta($salesman->ID, 'billing_phone', true);
//    echo $accept;die;

    if ($accept == 'true') {

        if ($print == '1') {
            $subject = "Mariebergs Kassakvitto " . $custom_order_number;
        } else {
            $subject = 'Orderbekräftelse gällande affärsförslag ' . $custom_order_number;
        }

        $message = "<p  contenteditable='true'>Hej " . $username . ",<br/><br/>Här kan du se ditt Affärsförslag från Mariebergs<br/>
	<a class='url_form' href='" . $url . "'>Läs affärsförslaget här</a><br/><br/>
	Det går inte att svara på detta epostmeddelande, kontakta säljaren " . $currnetuser . " 
	på " . $salesman->user_email . " eller " . $phone . "<br/>
	<br/>Med vänliga hälsningar " . $currnetuser . " Mariebergs Brasvärme</p>";
    } else {
        if ($print == '1') {
            $subject = "Mariebergs kassakvitto " . $custom_order_number;
        } else {
            $subject = "Mariebergs affärsförslag " . $custom_order_number;
        }
        $message = "<p  contenteditable='true'>Hej " . $username . ",<br/><br/>Här kan du se ditt Affärsförslag från Mariebergs<br/>
	<a class='url_form' href='" . $url . "'>Läs affärsförslaget här</a><br/><br/>
	Det går inte att svara på detta epostmeddelande, kontakta säljaren " . $currnetuser . "
	på " . $salesman->user_email . " eller " . $phone . "
	<br/><br/>Med vänliga hälsningar " . $currnetuser . " Mariebergs Brasvärme</p>";
    }
    if ($print == '1') {
        $message = "<p  contenteditable='true'>Hej " . $username . ",<br/><br/>Här kommer ditt kassakvitto från Mariebergs<br/>
	<a class='url_form'  href='" . $url . "'>Se kassakvitto här</a><br/>
	<br/>Med vänliga hälsningar " . $currnetuser . " Mariebergs Brasvärme</p>";
    }
    echo json_encode(array('message' => $message, 'subject' => $subject, 'filterEmail' => $filterEmail));
    die;
}

function update_event_drop() {
    $calender_id = $_POST['calender_id'];
    $start_date = $_POST["start_date"];
    $enddate = $_POST["end_date"];
//    $end_date = date("Y-m-d", strtotime($enddate));
    $end_date = date('Y-m-d ', strtotime($enddate . ' -1 day'));
    $event_resource = $_POST["event_resource"];
    $project_id = $_POST["project_id"];

    $from_field = "work-date-from";
    $to_field = "work-date-to";
    $assigned_technician_select_field = "assigned-subcontractor-select";

    global $wpdb;
    $table = $wpdb->prefix . 'project_calender';
    $wpdb->update($table, array('work_date_from' => $start_date, 'work_date_to' => $end_date, 'assigned_subcontractor_select' => $event_resource), array('id' => $calender_id));
//    update_post_meta($project_id, $from_field, $start_date);
//    update_post_meta($project_id, $to_field, $end_date);
//    update_post_meta($project_id, $assigned_technician_select_field, $event_resource);
}

add_action('wp_ajax_nopriv_delete_calender_data', 'delete_calender_data');
add_action('wp_ajax_delete_calender_data', 'delete_calender_data');

function delete_calender_data() {
    $calender_id = $_POST['calender_id'];
    global $wpdb;
    $table = $wpdb->prefix . 'project_calender';
    $wpdb->delete($table, ['id' => $calender_id], ['%d']);
    die;
}

add_action('wp_ajax_nopriv_return_calender_modal_content', 'return_calender_modal_content');
add_action('wp_ajax_return_calender_modal_content', 'return_calender_modal_content');

function return_calender_modal_content() {
    $calender_id = $_POST["calender_id"];
    global $wpdb;
    $table = $wpdb->prefix . 'project_calender';
    $projectQuery = $wpdb->get_results("select * from $table where id = $calender_id");
    foreach ($projectQuery as $valProject) {

        $project_id = $valProject->project_id;
        $date_from = $valProject->work_date_from;
        $date_to = $valProject->work_date_to;
        $planning_note = $valProject->planning_note;
        $assignedsubcontractorselect = $valProject->assigned_subcontractor_select;
        $firstname = get_user_meta($assignedsubcontractorselect, 'first_name', true);
        $lastname = get_user_meta($assignedsubcontractorselect, 'last_name', true);
        $planning_type = $valProject->planning_type;
        if ($planning_type == 'orange') {
            $varPlanningtype = 'PreliminÃ¤r';
        } elseif ($planning_type == 'blue') {
            $varPlanningtype = 'Grov';
        } else {
            $varPlanningtype = 'Definitiv';
        }
    }
    ?>
    <div class="row">
        <form action="" method="post">
            <input type="hidden" value="true" name="calender_handle">
            <input type="hidden" value="<?php echo $calender_id ?>" name="calender_id">

            <div class="col-md-6">
                <label for="work-date-from"><?php echo __("Välj planeringstyp"); ?></label>
                <select class="form-control js-sortable-select" id="planning-type"
                        name="planning-type">
                    <option value="">Välj typ</option>
                    <option <?php
                    if ($planning_type == "orange") {
                        echo " selected ";
                    }
                    ?> value="orange">Preliminär
                    </option>                               
                    <option <?php
                    if ($planning_type == "blue") {
                        echo " selected ";
                    }
                    ?> value="blue">Grov
                    </option>

                    <option <?php
                    if ($planning_type == "green") {
                        echo " selected ";
                    }
                    ?> value="green">Definitiv
                    </option>
                </select>
            </div>



            <div class=" col-lg-6 col-md-6">
                <label class="top-buffer-half"
                       for="work-date-from"><?php echo __("Välj aktivitetsdatum fr.o.m"); ?> </label>
                <input type="date" value="<?php
                if (!empty($date_from)) {
                    echo $date_from;
                } else {
                    echo date('Y-m-d');
                }
                ?>" class="form-control"
                       name="work_date_from" id="work_date_to">
            </div>

            <div class=" col-lg-6 col-md-6">
                <label class="top-buffer-half"
                       for="work-date-to"><?php echo __("T.o.m"); ?> </label>
                <input type="date" value="<?php
                if (!empty($date_to)) {
                    echo $date_to;
                } else {
                    echo date('Y-m-d');
                }
                ?>" class="form-control"
                       name="work_date_to" id="work_date_to">
            </div>

            <div class="col-md-12">
                <label class="top-buffer-half"
                       for="planning_note"><?php echo __("Kommentar") ?></label>
                <textarea class="planning_note_calender" id="planning_note" name="planning_note"><?php echo $planning_note; ?></textarea>
            </div>
            <div class=" col-md-8">
                <label class="top-buffer-half"
                       for="assigned-subcontractor-select"><?php echo __("Välj underentreprenör för planering") ?></label>
                       <?php
                       $args = array(
                           'role__in' => array(
                               'sale-sub-contractor',
                           )
                       );
                       $users = get_users($args);
                       ?>

                <select class="form-control js-sortable-select" id="assigned-subcontractor-select"
                        name="assigned-subcontractor-select">
                    <option value=""><?php echo __("Ingen anvÃ¤ndare vald"); ?></option>
    <?php foreach ($users as $user) : ?>

                        <option <?php
                        if ($assignedsubcontractorselect == $user->ID) {
                            echo " selected ";
                        }
                        ?> value="<?php echo $user->ID ?>"><?php echo getCustomerName($user->ID) . " " . get_user_meta($user->ID, 'sale-sub-contractor_shortname', true) ?></option>

    <?php endforeach; ?>
                </select>
            </div>

            <div class=" col-lg-12 col-md-12">
                <button type="submit"

                        class="btn btn-brand btn-block top-buffer">
    <?php echo __("Spara") ?>
                </button>
            </div>
        </form>
    </div>


    <?php
    die;
}

function saleFunction($product, $productid, $orderprice) {
    $fromDate = get_post_meta($productid, '_sale_price_dates_from', true);
    $toDate = get_post_meta($productid, '_sale_price_dates_to', true);
    if (empty($fromDate) && empty($toDate)) {
        if (!empty($product->sale_price)) {
            $sale_price_name = ' Kampanjpris';
        } else {
            $sale_price_name = '';
        }
    } else {
        $_sale_price_dates_from = date('Y-m-d', $fromDate);
        if (!empty($_sale_price_dates_from)) {
            $Begin_date = date('Y-m-d', strtotime($_sale_price_dates_from . ' +1 day'));
        }
        $_sale_price_dates_to = date('Y-m-d', $toDate);
        if (!empty($_sale_price_dates_to)) {
            $End_date = date('Y-m-d', strtotime($_sale_price_dates_to . ' +1 day'));
        } else {
            if (!empty($_sale_price_dates_from)) {
                $End_date = date('Y-m-d', strtotime("+1 day"));
            }
        }
        $today = date("Y-m-d");

        if ($Begin_date <= $today && $today <= $End_date) {
            $sale_price_name = ' Kampanjpris';
        } else {
            $sale_price_name = '';
        }
    }
    $productSale = $product->sale_price * .25;
    if ($orderprice > $productSale + $product->sale_price) {
        $sale_price_name = '';
    }
    return $sale_price_name;
}

add_action('wp_ajax_nopriv_removeVat', 'removeVat');
add_action('wp_ajax_removeVat', 'removeVat');

function removeVat($vatid = false, $vatstatus = false) {
    $checkVat = ($vatstatus) ? $vatstatus : $_POST['checkVat'];
    $id = ($vatid) ? $vatid : $_POST['id'];
    $order = new WC_Order($id);
    if ($checkVat == '1') {
        $total_price = '';
        foreach ($order->get_items() as $order_item_id => $item) {
            wc_delete_order_item_meta($order_item_id, '_line_subtotal_tax');
            wc_delete_order_item_meta($order_item_id, '_line_tax');
            wc_delete_order_item_meta($order_item_id, '_line_tax_data');
            $total_price += wc_get_order_item_meta($order_item_id, '_line_total', true);
        }
        update_post_meta($id, '_order_tax', '');
        update_post_meta($id, '_order_total', $total_price);
        update_post_meta($id, 'remove_vats', true);
        update_post_meta($id, 'remove_vats_number', $_POST['vatNumber']);
    } else {
        delete_post_meta($id, 'remove_vats', '1');
        delete_post_meta($id, 'remove_vats_number', $_POST['vatNumber']);
        $order->calculate_totals();
        $order->save();
    }
    if (!$vatid) {
        die();
    }
}

function getReservartion($id) {
    global $wpdb;
    $tablename = $wpdb->prefix . 'reservation';
    if (is_array($id)) {
        return $wpdb->get_results("SELECT * FROM " . $tablename . " WHERE  id IN (" . implode(',', $id) . ") ");
    } elseif (empty($id)) {
        return $wpdb->get_results("SELECT * FROM " . $tablename);
    } else {
        $checkData = $wpdb->get_results("SELECT * FROM " . $tablename . " WHERE  project_type like'%" . $id . "%'");
        return $checkData[0]->id;
    }
}

function CustomerName($userid, $name) {
    global $wpdb;
    $tablename = $wpdb->prefix . 'Projects_Search';
    $sql = "select * from " . $tablename . " where CONCAT(customer_number, '-') like '" . $userid . "-%'";
    $newdata = $wpdb->get_results($sql);
    foreach ($newdata as $getData) {
        $wpdb->update($tablename, array('customer_name' => $name), array('id' => $getData->id));
    }
}

function getCostSupplier($projectid) {
    global $wpdb;
    $tablename = $wpdb->prefix . 'external_invoice';
    $sql = "select * from " . $tablename . " where project_id = '" . $projectid . "'";
    return $wpdb->get_results($sql,OBJECT);
  
}

function paytemMethod() {
    $pa = 'Förskottsfaktura och slutfaktura';
    $paymenttypeSearch = array(1 => "Delbetalas med kort i kassan", 2 => "Kortbetalning", 3 => "Swish", 4 => "Faktura", 6 => "Ecster privatlån", 7 => 'Förskottsfaktura 35% och slutfaktura', 8 => 'Betalas vid hämtning');
    return $paymenttypeSearch;
}

function storeName() {
    return array(27782 => "Mariebergs Gävle", 2625 => "HK", 2541 => "Mariebergs Bålsta", 2540 => "Mariebergs Ludvika", 2539 => "Mariebergs Malmö", 2538 => "Mariebergs Kungens kurva", 2537 => 'Mariebergs Sollentuna', 2536 => 'Mariebergs Uppsala');
}

function paymenttypeSearch($id, $colounm_name, $column_value) {
    $paymenttypeSearch = paytemMethod();
    updateSearchMeta($id, $colounm_name, $column_value);
}

function projectypeName() {
    return array(1 => "Hembesök", 2 => "Eldstad inklusive montage", 3 => "Service och reservdelar", 4 => "Kassa ", 5 => "ÄTA", 6 => "Självbyggare", 7 => 'Specialoffert', 8 => 'Solcellspaket');
}

function projectype_search() {
    return array(1 => "hem_visit_sale_system", 2 => "fireplace_with_assembly", 3 => "service", 4 => "accesories", 5 => "changes_and_new_work", 6 => "self_builder", 7 => 'hansa_offert_for_old_offert', 8 => 'solcellspaket');
}

function projectTypeSearch($id, $colounm_name, $column_value) {
    $projectype_search = projectype_search();
    updateSearchMeta($id, $colounm_name, array_search($column_value, $projectype_search));
}

function departmentName() {
    return array(1 => "Administratör", 2 => "Sälj", 3 => "Ekonomi", 4 => "Projektplanering", 5 => "Tekniker", 6 => "Underentreprenör");
}

function department_search() {
    return array(1 => "sale-administrator", 2 => "sale-salesman", 3 => "sale-economy", 4 => "sale-project-management", 5 => "sale-technician", 6 => "sale-sub-contractor");
}

function departmentSearch($id, $colounm_name, $column_value) {
    $department_search = department_search();
    updateSearchMeta($id, $colounm_name, array_search($column_value, $department_search));
}

function orderstatusName() {
    return array(0 => 'Väntar svar', 1 => 'Order bekräftad', 2 => 'Nekad av kund', 4 => 'Accepterad av kund', 5 => 'Kund har frågor', 6 => 'Arkiverad kopia');
}

function orderstatus_search() {
    return array(1 => 'true', 2 => 'false', 0 => '', 4 => 'Acceptavkund', 5 => 'Kundfråga', 6 => 'archieved');
}

function orderstatusSearch($id, $colounm_name, $column_value) {
    $orderstatus_search = orderstatus_search();
    $getValue = array_search($column_value, $orderstatus_search);

    updateSearchMeta($id, $colounm_name, $getValue);
}

function projectStatusSearch($id, $colounm_name, $column_value) {
    $projectstatus_search = array(1 => 'project-ongoing', 2 => 'project-archived');
    updateSearchMeta($id, $colounm_name, array_search($column_value, $projectstatus_search));
}

function updateSearchMeta($id, $colounm_name, $column_value) {
    global $wpdb;
    if (get_post_type($id) == 'imm-sale-project') {
        $args = array(
            'orderby' => 'ID',
            'post_type' => wc_get_order_types(),
            'post_status' => array_keys(wc_get_order_statuses()),
            'posts_per_page' => - 1,
            'order' => 'DESC',
            'meta_query' => array('relation' => 'AND',
                array('key' => 'imm-sale_project_connection', 'value' => $id)
            ),
        );
        $resultsss = get_posts($args);
        foreach ($resultsss as $post) : setup_postdata($post);
            $wpdb->update('VQbs2_Projects_Search', array($colounm_name => $column_value), array('id' => $post->ID));
        endforeach;
        wp_reset_postdata();
    }else {

        $wpdb->update('VQbs2_Projects_Search', array($colounm_name => $column_value), array('id' => $id));
    }
}

function projectsearchmetadata($roles) {
    $newcolumn = array('internal_project_status_sale_administrator' => 'internal_project_status_sale-administrator', 'internal_project_status_sale_salesman' => 'internal_project_status_sale-salesman', 'internal_project_status_sale_economy' => 'internal_project_status_sale-economy', 'internal_project_status_sale_project_management' => 'internal_project_status_sale-project-management', 'internal_project_status_sale_technician' => 'internal_project_status_sale-technician', 'internal_project_status_sale_sub_contractor' => 'internal_project_status_sale-sub-contractor');
    return array_search($roles, $newcolumn);
}

function updateSearchMetaInternal($id, $colounm_name, $column_value) {
    global $wpdb;
    if (get_post_type($id) == 'imm-sale-project') {
        $args = array(
            'orderby' => 'ID',
            'post_type' => wc_get_order_types(),
            'post_status' => array_keys(wc_get_order_statuses()),
            'posts_per_page' => - 1,
            'order' => 'DESC',
            'meta_query' => array('relation' => 'AND',
                array('key' => 'imm-sale_project_connection', 'value' => $id),
                array('key' => 'imm-sale_prepayment_invoice', 'compare' => 'NOT EXISTS'),
            ),
        );
        $metaresut = get_posts($args);
        foreach ($metaresut as $post) : setup_postdata($post);
            $wpdb->update('VQbs2_Project_Search_Meta', array(projectsearchmetadata($colounm_name) => $column_value), array('id' => $post->ID));
        endforeach;
        wp_reset_postdata();
    }
    else {
        $wpdb->update('VQbs2_Project_Search_Meta', array(projectsearchmetadata($colounm_name) => $column_value), array('id' => $id));
    }
}

function modify_projectType($key) {
    $projecttype = array('hem_visit_sale_system' => 'new_sales_hembesok', 'fireplace_with_assembly' => 'eld_inklusive_montage', 'service' => 'service_custom', 'self_builder' => 'sjalvbyggare', 'accesories' => 'project_typ_kassa', 'changes_and_new_work' => 'project_type_ata', 'hansa_offert_for_old_offert' => 'hansa_offert', 'solcellspaket' => 'solcellspaket');
    return ($key) ? $projecttype[$key] : $projecttype;
}

function getInvoicedCustomerid($id) {
    $projectid = get_post_meta($id, 'imm-sale_project_connection', true);
    return get_post_meta($projectid, 'invoice_customer_id', true);
}

add_action('wp_ajax_nopriv_updateinvoices', 'updateinvoices');
add_action('wp_ajax_updateinvoices', 'updateinvoices');

function updateinvoices() {
    $orderid = $_POST['order_id'];
    $porderid = $_POST['parent_orderid'];
    $order = new WC_Order($porderid);
    $parentorder = new WC_Order($orderid);
    $i = 0;
    foreach ($order->get_items() as $order_item_id => $item) {
        $line_item_note = wc_get_order_item_meta($order_item_id, 'line_item_note', true);
        $specialnote = wc_get_order_item_meta($order_item_id, 'line_item_special_note', true);
        $headitem = wc_get_order_item_meta($order_item_id, 'HEAD_ITEM', true);
        $qty = wc_get_order_item_meta($order_item_id, '_qty', true);
        $j = 0;
        foreach ($parentorder->get_items() as $porder_item_id => $pitem) {
            $pqty = wc_get_order_item_meta($porder_item_id, '_qty', true);

            if ($qty === $pqty && $i == $j) {

                wc_update_order_item_meta($porder_item_id, 'line_item_note', $line_item_note);
                wc_update_order_item_meta($porder_item_id, 'line_item_special_note', $specialnote);
                wc_update_order_item_meta($porder_item_id, 'HEAD_ITEM', $headitem);
            }
            $j++;
        }
        $i++;
    } die;
}

function getStore($id) {
    $store = array(27782 => 900, 2536 => 200, 2541 => 800, 2540 => 700, 2539 => 600, 2538 => 400, 2537 => 300);
    return $store[$id];
}

function orderrecordupdate($projectid, $customfield, $value) {

    $args = array(
        'orderby' => 'ID',
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => - 1,
        'order' => 'DESC',
        'meta_query' => array('relation' => 'AND',
            array('key' => 'imm-sale_project_connection', 'value' => $projectid,)
        ),
    );
    $resultsss = get_posts($args);
    foreach ($resultsss as $post) : setup_postdata($post);
        update_post_meta($post->ID, $customfield, $value);

    endforeach;
    wp_reset_postdata();
}

function update_Record($projectid, $serializedSettings) {
    global $wpdb;
    $wpdb->insert('VQbs2_CustPorject', array('orderid' => $projectid, 'alldata' => $serializedSettings), array('%d', '%s'));
    return true;
}

function getName($id) {
    $user = get_userdata($id);
    return (get_user_meta($id, 'first_name', true)) ? get_user_meta($id, 'first_name', true) . " " . get_user_meta($id, 'last_name', true) : $user->display_name;
}

function showName($id) {
    $user = get_userdata($id);
    return (get_user_meta($id, 'salesman_name', true)) ? get_user_meta($id, 'salesman_name', true) : $user->display_name;
}

function order_accept($order_id, $payment_type, $send_redirect, $ordertype) {
    global $roles_order_status;
    global $current_user;
    foreach ($current_user->roles as $role_user)
        $role_user = $role_user;

    $linked_project = get_post_meta($order_id, "imm-sale_project_connection")[0];
//        $project_author = get_post_field('post_author', $linked_project);
    $project_author = getuserid($order_id, $linked_project, 'saljare_id', 'order_salesman');
//        echo $project_author;die;
    $project_author_meta = get_userdata($project_author);
//    $project_author_roles = $project_author_meta->roles[0];
    $project_author_roles = empty($role_user) ? $project_author_meta->roles[0] : $role_user;
    $projectids = get_post_meta($order_id, "imm-sale_project_connection", true);

    $project_connection = get_post_meta($order_id, "imm-sale_project_connection")[0];
    update_post_meta($project_connection, "internal_project_status_sale-salesman", $roles_order_status["sale-salesman"][4]["internal_status"]);
    $current = get_post_meta($linked_project, 'order_current_department', true);
    $today = date("Y-m-d");
    update_internal_project_status_and_current_department($order_id, $current, 4);
    $order_accept_date = get_post_meta($order_id, "order_accept_date")[0];
    if (empty($order_accept_date)) {
        update_post_meta($order_id, 'order_accept_date', $today);
        update_post_meta($order_id, 'custom_accept_date_order', $today);
        updateSearchMeta($order_id, 'date', $today);
    }

    update_post_meta($order_id, 'order_accept_status', "true");
    /*        update_post_meta($_GET["order-id"], 'order_payment_method', $payment_type); */
    update_post_meta($order_id, 'imm-sale_converted_to_order', true);

    $redirect = $_SERVER['REQUEST_URI'];

    if ($payment_type == "default_checkout") {
        $redirect = $_SERVER['REQUEST_URI'] . "&payment_type=default_checkout";
    }
//    update_field('kund_accepterat_logs', date('Ymd'), $order_id);
    // update_field('kund_accepterat_p', date('Ymd'), $projectids);
    if ($ordertype == 'order_handle') {
        create_log_entry(__("Affärsförslag accepterat av kund through Order Steps on date " . $today), $order_id);
    } else {
        create_log_entry(__("Affärsförslag accepterat av kund through Project on date " . $today), $order_id);
    }
    $today = date('Y-m-d');
    $todo_action_date = date('Y-m-d', strtotime($today));

    $orders = wc_get_order($order_id);

    if ($orders->get_status() == 'pending')
        $orders->update_status('processing');

    $custom_project_number = get_post_meta($linked_project, 'custom_project_number', true) . '-' . $order_id;
    if (empty($custom_project_number)) {
        $customer_id = get_post_meta($linked_project, "invoice_customer_id")[0];
        $custom_project_number = $customer_id . '-' . $linked_project . '-' . $order_id;
    }

//    create_todo_item($todo_action_date, '0', $linked_project, __("Affärsförslaget accepterat ") . $custom_project_number, $project_author_roles, '', '', $project_author);
//        create_todo_item($todo_action_date, '1', $linked_project, __("Affärsförslaget accepterat. Skapa förskotts faktura ") . $linked_project, 'sale-economy', '', '');
//        create_todo_item($todo_action_date, '1', $linked_project, __("Affärsförslaget accepterat. Skickad till ekonomi för förskotts faktura. ") . $linked_project, 'sale-economy', $project_author, '');
    //$current=	get_post_meta($linked_project, 'order_current_department', true);
    // update_field('order_current_department', $current, $linked_project);
    if ($send_redirect == '1') {
        header('Location:' . $redirect);
        exit;
    }
}

function order_accept_by_customer($order_id, $payment_type, $send_redirect, $notemail, $log) {
//    echo'yes1';
//    die;
    global $roles_order_status;
    global $current_user;

    foreach ($current_user->roles as $role_user)
        $role_user = $role_user;

    $linked_project = get_post_meta($order_id, "imm-sale_project_connection")[0];
    $project_author = getuserid($order_id, $linked_project, 'saljare_id', 'order_salesman');
    $project_author_meta = get_userdata($project_author);
    $salesman_name = getCustomerName($project_author);
    $project_author_roles = empty($role_user) ? $project_author_meta->roles[0] : $role_user;
    $projectids = get_post_meta($order_id, "imm-sale_project_connection", true);

    $project_connection = get_post_meta($order_id, "imm-sale_project_connection")[0];
    update_post_meta($project_connection, "internal_project_status_sale-salesman", $roles_order_status["sale-salesman"][4]["internal_status"]);
    updateSearchMetaInternal($order_id, 'internal_project_status_sale-salesman', $roles_order_status["sale-salesman"][4]["internal_status"]);
    $current = get_post_meta($linked_project, 'order_current_department', true);
    $today = date("Y-m-d");
    update_internal_project_status_and_current_department($order_id, $current, 4);
    $order_accept_date_by_kund = get_post_meta($order_id, "order_accept_date_by_kund")[0];
    if (empty($order_accept_date_by_kund)) {
        update_post_meta($order_id, 'order_accept_date_by_kund', $today);
    }

    update_post_meta($order_id, 'order_accept_status', "Acceptavkund");
    delete_post_meta($order_id, 'imm-sale_converted_to_order', true);
    orderstatusSearch($order_id, 'order_accept', "Acceptavkund");

    $redirect = $_SERVER['REQUEST_URI'];

    if ($payment_type == "default_checkout") {
        $redirect = $_SERVER['REQUEST_URI'] . "&payment_type=default_checkout";
    }
     if (empty(get_post_meta($order_id, "kund_accepterat_logs", true)) || $log != 0) {
            update_post_meta($order_id, 'kund_accepterat_logs', date('Ymd'));
        }
    if ($log == 1) {
        create_log_entry(__("Order Accepted by customer from order estimate page on date " . $today), $order_id);
    } elseif ($log == '') {
//        create_log_entry(__("Order Accepted by salesman in Single Project Popup on date " . $today), $order_id);
        $useractivity = "Order Accepted on Single Project Popup through salesman " . $salesman_name;
        custom_userActivity($project_connection, $useractivity);
    } elseif ($log == 0) {
        create_log_entry(__("Order Accepted by customer from order steps on date " . $today), $order_id);
    }
//    create_log_entry(__("Order Accepted by customer"), $order_id);
    $today = date('Y-m-d');
    //orderstatusSearch($id,'date',$today);
    $todo_action_date = date('Y-m-d', strtotime($today));

    $orders = wc_get_order($order_id);

    if ($orders->get_status() == 'pending')
        $orders->update_status('processing');

    $custom_project_number = get_post_meta($linked_project, 'custom_project_number', true) . '-' . $order_id;
    if (empty($custom_project_number)) {
        $customer_id = get_post_meta($linked_project, "invoice_customer_id")[0];
        $custom_project_number = $customer_id . '-' . $linked_project . '-' . $order_id;
    }
    if ($notemail != 1) {
        include_once('includes/form-handle/order-accept/accept-true.php');
//        create_todo_item($todo_action_date, '0', $linked_project, __("Affärsförslaget accepterat ") . $custom_project_number, $project_author_roles, '', '', $project_author);
    }
    if ($log == 1) {
        create_todo_item($todo_action_date, '0', $linked_project, __("Affärsförslaget accepterat ") . $custom_project_number, $project_author_roles, '', '', $project_author);
    }
    if ($send_redirect == '1') {
        header('Location:' . $redirect);
        exit;
    }
}

function send_msg_to_customer() {
    $order_id = $_POST['order_id'];
    $project_id = get_post_meta($order_id, 'imm-sale_project_connection', true);
    $accept = get_post_meta($order_id, 'order_accept_status', true);
    $internalstatuss = get_post_meta($project_id, 'internal_project_status_sale-administrator', true);
    if ($internalstatuss == 'Offertarbete pågår' || empty($internalstatuss)) {
        update_post_meta($project_id, 'internal_project_status_sale-administrator', 'Offert skickad');
    }
    $tel_no = $_POST['tel_num'];

    $tel_msg = $_POST['tel_msg'];
    $lank = $_POST['tel_lank'];

    $args = array(
        'number_to' => $tel_no,
        'message' => $tel_msg . PHP_EOL . $lank,
    );
    $sent = twl_send_sms($args); //print_r($sent);
    /* 	if(!empty($sent->errors['api-error'][0])){

      echo $sent->errors['api-error'][0];
      }else{echo "send";} */
}

function send_invoice_to_customer() {
    global $current_user;

    $order_id = $_POST["order_id"];
    $order = new WC_Order($order_id);
    //$customer_id = $order->get_customer_id();
    $projectid = get_post_meta($order_id, 'imm-sale_project_connection', true);
    $customer_id = get_post_meta($projectid, 'invoice_customer_id', true);
    $salemanid = get_post_meta($projectid, 'order_salesman', true);
    $salesman = get_userdata($salemanid);
    $customer_info = get_userdata($customer_id);
    $custom_order_number = get_post_meta($order_id, 'custom_order_number', true);
    $url = $_POST["summary_url"];
    $to = $customer_info->user_email;
    $username = $customer_info->first_name;
    $currnetuser = getCustomerName($salemanid);
    $accept = get_post_meta($order_id, 'order_accept_status', true);
    if (!empty(get_user_meta($salesman->ID, 'personal_phone', true)))
        $phone = get_user_meta($salesman->ID, 'personal_phone', true);
    else
        $phone = get_user_meta($salesman->ID, 'billing_phone', true);
//    echo $accept;die;

    if ($accept == 'true') {

        if ($_POST['print'] == '1') {
            $subject = "Mariebergs Kassakvitto " . $custom_order_number;
        } else {
            $subject = 'Orderbekräftelse gällande affärsförslag ' . $custom_order_number;
        }



        $message = 'Hej ' . $username . ',<br>
Tack för förtroendet, vi ser fram emot att få leverera till dig!<br><br>

<a href=' . $url . '>Du ser din orderbekräftelse här!</a><br/><br/>Med vänliga hälsningar<br/>' . $currnetuser . '<br/> Mariebergs Brasvärme';
        $headers = array('From: ' . get_bloginfo('name') . ' <svarainte@mariebergsalset.com>');
        $headers[] = 'Cc:' . get_bloginfo('name') . '<' . $salesman->user_email . '>';
        $headers[] = "Content-Type: text/html; charset=UTF-8";
    } else {
        if ($_POST['print'] == '1') {
            $subject = "Mariebergs kassakvitto " . $custom_order_number;
        } else {
            $subject = "Mariebergs affärsförslag " . $custom_order_number;
        }

        $message = "Hej " . $username . ",<br/>Här kan du se ditt Affärsförslag från Mariebergs<br/><br/>
	<a href='" . $url . "'>Läs affärsförslaget här</a><br/>
	Det går inte att svara på detta epostmeddelande, kontakta säljaren " . $currnetuser . " <br/>
	på " . $salesman->user_email . " eller " . $phone . "
	<br/>Med vänliga hälsningar<br/>" . $currnetuser . "<br/> Mariebergs Brasvärme";
        $headers[] = 'From: Mariebergs Brasvärme <svarainte@mariebergsalset.com>';

        $headers[] = 'Cc: Mariebergs Brasvärme <' . $salesman->user_email . '>';
        $headers[] = "Content-Type: text/html; charset=UTF-8";
    }
    if ($_POST['print'] == '1') {
        $message = "Hej " . $username . ",<br/>Här kommer ditt kassakvitto från Mariebergs<br/><br/>
	<a href='" . $url . "'>Se kassakvitto här</a><br/>
	<br/>Med vänliga hälsningar<br/>" . $currnetuser . "<br/> Mariebergs Brasvärme";
    }
    $project_id = get_post_meta($order_id, 'imm-sale_project_connection', true);
    $internalstatuss = get_post_meta($project_id, 'internal_project_status_sale-administrator', true);
    if ($internalstatuss == 'Offertarbete pågår' || empty($internalstatuss)) {
        update_post_meta($project_id, 'internal_project_status_sale-administrator', 'Offert skickad');
    }

    $mail_sent = wp_mail($to, $subject, $message, $headers);
//    wp_mail($current_user->user_email, $subject, $message, $headers);
    if ($mail_sent == true) {
        echo __("Affärsförslaget har skickats till kund");
    } else {
        echo __("Något gick fel, kontakta driftansvarig vid återkommande problem");
    }


    die;
}

function getuserid($orderid = false, $projectid = false, $orderfield, $projectfield) {
    if (get_post_meta($orderid, $orderfield, true))
        $currentid = get_post_meta($orderid, $orderfield, true);
    else
        $currentid = get_post_meta($projectid, $projectfield, true);

    return $currentid;
}

function orderuserid($orderid = false, $projectid = false) {
    if (get_post_meta($orderid, $orderfield, true))
        $currentid = get_post_meta($orderid, '_customer_user', true);
    else
        $currentid = get_post_meta($projectid, 'invoice_customer_id', true);

    return $currentid;
}

function add_product_price_order_log($order_id,$product_name,$product_id,$price){
    global $current_user;
    $file_name = $_SERVER['DOCUMENT_ROOT']."/order_log/" . $order_id . '_orderfile.txt';
    $data=array('prodcut_name'=>$product_name,'product_id'=>$product_id,'price'=>$price);
  $new_log_entry = [
        'user' => $current_user->user_email,
        'timestamp' => time(),
        'log_action' => $data,
      'product_price'=>'product_price_data'
    ];
  $json_log = json_encode($new_log_entry, JSON_PRETTY_PRINT);
$createfile=fopen("$file_name","a+") or die("there is a problem");
fwrite($createfile,$json_log);
fclose($createfile);
}

function add_discount_product_to_offert() {
//    print_r($_POST);die;
    $loggedin_id = get_current_user_id();
    $get_custid = get_field('order_salesman_o', $_POST["order_id"]);
    if ($loggedin_id != $get_custid) {
        //return false;
    }
    $discount_value = $_POST['discount_value'];
    $discount_amount_value = $_POST['discount_amount_value'];
    $discount_product_name = $_POST['discount_product_name'];
    $discount_product_id = $_POST['discount_product_id'];
    $discount_product_price = $_POST['discount_product_price'];
    $discount_product_qty = $_POST['discount_product_qty'];
    if ($_POST['discount_value']) {
        $discount_calculation_qty = ($discount_product_price * $discount_value) / 100;
    } elseif ($_POST['discount_amount_value']) {
        $vat = ($discount_amount_value) * .8;
        $discount_calculation_qty = $vat;
    }
    $wc_pro_id = get_field('custom_discount_product', 'option');
    $order = new WC_Order($_POST['order_id']);
    foreach ($order->get_items() as $order_item_id => $item) {

        $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
        if (wc_get_order_item_meta($order_item_id, 'HEAD_ITEM', true) && $discount_product_id == $product_id) {
            $g = wc_get_order_item_meta($order_item_id, 'HEAD_ITEM', true);
        }
    };

    $custom_price_discount_product = new WC_Product($wc_pro_id);
    $line = create_custom_line_item($order, $custom_price_discount_product, $discount_calculation_qty, $discount_product_name, $g);
    
    add_product_price_order_log($_POST["order_id"],$discount_product_name,$discount_product_id,$discount_calculation_qty);


    $order->calculate_totals();
    $order->save();
    $remove_vats = get_post_meta($_POST['order_id'], 'remove_vats', true);
    if (!empty($remove_vats)) {
        removeVat($_POST['order_id'], 1);
        $order = new WC_Order($order_id);
    }
  /*   if (wc_get_order_item_meta($line, 'HEAD_ITEM', true)) {
        $data = unserialize(get_post_meta($_POST["order_id"], 'head_sortorderitems', true));
        $newdata = array_merge($data, array($line));
        update_post_meta($_POST["order_id"], 'head_sortorderitems', serialize($newdata));
    } else {
        $data = unserialize(get_post_meta($_POST["order_id"], 'sortorderitems', true));
        $newdata = array_merge($data, array($line));
        update_post_meta($_POST["order_id"], 'sortorderitems', serialize($newdata));
    } */
	update_post_meta($_POST["order_id"], 'firstSort',true);
    //print_r($wc_pro_id);
    die();
//      
}

add_action('wp_ajax_nopriv_get_create_lead', 'get_create_lead');
add_action('wp_ajax_get_create_lead', 'get_create_lead');

function get_create_lead() {
    $lead_email = $_POST["email"];
    // echo $lead_email;die;
    $meta_query = array(array('key' => 'lead_email', 'value' => $lead_email, 'compare' => '='));
    $args = array(
        'post_type' => 'imm-sale-leads',
        'post_status' => 'publish',
        'meta_query' => $meta_query);
    $products = new WP_Query($args);
    foreach ($products as $val) {
        $leadid = $val->ID;
        if ($leadid) {
            $lead_first_name = get_field('lead_first_name', $leadid);
//            $lead_last_name = get_field('lead_last_name', $leadid);
            $lead_phone = get_field('lead_phone', $leadid);
            $lead_city = get_field('lead_city', $leadid);
            $lead_postnummer = get_field('lead_postnummer', $leadid);
            $lead_customer_levernadress = get_field('lead_customer_levernadress', $leadid);
            $lead_customer_homenummer = get_field('lead_customer_homenummer', $leadid);
            $lead_typavlead = get_field('lead_typavlead', $leadid);
            $lead_other = get_field('lead_other', $leadid);
            $antal_kanaler_cb = get_field('antal_kanaler_cb', $leadid);
            $ca_meter_cb = get_field('ca_meter_cb', $leadid);
            $annat_yttertak_cb = get_field('annat_yttertak_cb', $leadid);
            if (get_field('braskamin_cb', $leadid)) {

                $braskamin_cb = 'checked';
            }
            if (get_field('kakelugn_cb', $leadid)) {

                $kakelugn_cb = 'checked';
            }
        }
        if (get_field('frimurning_cb', $leadid)) {

            $frimurning_cb = 'checked';
        }
        if (get_field('murspis_cb', $leadid)) {

            $murspis_cb = 'checked';
        }
        if (get_field('etanol_cb', $leadid)) {

            $etanol_cb = 'checked';
        }
        if (get_field('kassett_cb', $leadid)) {

            $kassett_cb = 'checked';
        }
        if (get_field('vedspis_cb', $leadid)) {

            $vedspis_cb = 'checked';
        }
        if (get_field('taljstensugn_cb', $leadid)) {

            $taljstensugn_cb = 'checked';
        }
        if (get_field('service_cb', $leadid)) {

            $service_cb = 'checked';
        }
        if (get_field('reservdel_cb', $leadid)) {

            $reservdel_cb = 'checked';
        }
        if (get_field('tillbehor_cb', $leadid)) {

            $tillbehor_cb = 'checked';
        }

        if (get_field('enplans_cb', $leadid)) {
            $enplans_cb = 'checked';
        }
        if (get_field('ett_och_halva_plan', $leadid)) {
            $ett_och_halva_plan = 'checked';
        }
        if (get_field('solceller_cb', $leadid)) {
            $solceller_cb = 'checked';
        }

        if (get_field('2_plans_cb', $leadid)) {
            $plans_cb = 'checked';
        }
        if (get_field('Fritishus_cb', $leadid)) {
            $Fritishus_cb = 'checked';
        } if (get_field('souterrang_cb', $leadid)) {
            $souterrang_cb = 'checked';
        } if (get_field('nybygge_cb', $leadid)) {
            $nybygge_cb = 'checked';
        } if (get_field('flerbistadshus_cb', $leadid)) {
            $flerbistadshus_cb = 'checked';
        } if (get_field('torpargrundkrypgrund_cb', $leadid)) {
            $torpargrundkrypgrund_cb = 'checked';
        } if (get_field('platta_pa_mark_cb', $leadid)) {
            $platta_pa_mark_cb = 'checked';
        } if (get_field('kallare_cb', $leadid)) {
            $kallare_cb = 'checked';
        } if (get_field('taksakerhet_finnssaknas_cb', $leadid)) {
            $taksakerhet_finnssaknas_cb = 'checked';
        }
        $takhojdbv_cb = get_field('takhojdbv_cb', $leadid);
        $byggar_cb = get_field('byggar_cb', $leadid);


        if (get_field('ny_skorsten_cb', $leadid)) {
            $ny_skorsten_cb = 'checked';
        }
        if (get_field('beffintlig_skorsten_cb', $leadid)) {
            $beffintlig_skorsten_cb = 'checked';
        } if (get_field('skorstenstatning_skorsten_cb', $leadid)) {
            $skorstenstatning_skorsten_cb = 'checked';
        }
        $response = array(
            'success' => true, 'firstname' => $lead_first_name,
//            'last_name' => $lead_last_name,
            'lead_phone' => $lead_phone,
            'lead_city' => $lead_city,
            'lead_postnummer' => $lead_postnummer,
            'lead_customer_levernadress' => $lead_customer_levernadress,
            'lead_customer_homenummer' => $lead_customer_homenummer,
            'braskamin_cb' => $braskamin_cb,
            'kakelugn_cb' => $kakelugn_cb,
            'frimurning_cb' => $frimurning_cb,
            'murspis_cb' => $murspis_cb,
            'etanol_cb' => $etanol_cb,
            'kassett_cb' => $kassett_cb,
            'vedspis_cb' => $vedspis_cb,
            'taljstensugn_cb' => $taljstensugn_cb,
            'service_cb' => $service_cb,
            'reservdel_cb' => $reservdel_cb,
            'tillbehor_cb' => $tillbehor_cb,
            'enplans_cb' => $enplans_cb,
            'ett_och_halva_plan' => $ett_och_halva_plan,
            'plans_cb' => $plans_cb,
            'Fritishus_cb' => $Fritishus_cb,
            'souterrang_cb' => $souterrang_cb,
            'nybygge_cb' => $nybygge_cb,
            'flerbistadshus_cb' => $flerbistadshus_cb,
            'torpargrundkrypgrund_cb' => $torpargrundkrypgrund_cb,
            'platta_pa_mark_cb' => $platta_pa_mark_cb,
            'kallare_cb' => $kallare_cb,
            'taksakerhet_finnssaknas_cb' => $taksakerhet_finnssaknas_cb,
            'takhojdbv_cb' => $takhojdbv_cb,
            'byggar_cb' => $byggar_cb,
            'lead_typavlead' => $lead_typavlead,
            'lead_other' => $lead_other,
            'antal_kanaler_cb' => $antal_kanaler_cb,
            'ca_meter_cb' => $ca_meter_cb,
            'annat_yttertak_cb' => $annat_yttertak_cb,
            'solceller_cb' => $solceller_cb
        );
    }
    echo json_encode($response);
    die;
}

add_action('wp_ajax_nopriv_deleteinoviced', 'deleteinoviced');
add_action('wp_ajax_deleteinoviced', 'deleteinoviced');

function deleteinoviced() {

    if (empty($_POST['invoicedid']))
        die;

    wp_delete_post($_POST['invoicedid']);
    die;
}

add_action('wp_ajax_nopriv_save_auto_pi', 'save_auto_pi');
add_action('wp_ajax_save_auto_pi', 'save_auto_pi');

function save_auto_pi() {
    $loggedin_id = get_current_user_id();
    $get_custid = get_field('saljare_id', $_POST["orderid"]);
    if ($loggedin_id != $get_custid) {
        return false;
    }
    $project_heading = $_POST['project_heading'];
    $orderid = $_POST['orderid'];
    $project_description = $_POST['project_description'];
    $order_summary_addon_heading = $_POST['order_summary_addon_heading'];
    $order_summary_addon_description = $_POST['order_summary_addon_description'];
    $affarsforslaget_gallertom = $_POST['affarsforslaget_gallertom'];

    update_order_summary_heading_and_description($orderid, $_POST["project_heading"], $_POST["project_description"], $_POST["order_summary_addon_heading"], $_POST["order_summary_addon_description"], $_POST['affarsforslaget_gallertom'], '');
//    }
}
?>
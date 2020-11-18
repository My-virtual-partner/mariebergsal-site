<?php
/**
 * Contains all AJAX functions for the plugin
 * TODO: Divide this file into multiple files for better structure.
 */
/* display the custom fields by default */
add_filter('acf/settings/remove_wp_meta_box', '__return_false');

add_action('wp_ajax_nopriv_kassakvito_print_data', 'kassakvito_print_data');
add_action('wp_ajax_kassakvito_print_data', 'kassakvito_print_data');
add_action('wp_ajax_getDepartmentValue', 'getDepartmentValue');
add_action('wp_ajax_nopriv_getDepartmentValue', 'getDepartmentValue');


add_action('wp_ajax_nopriv_addProductToPrepaymentOrder', 'addProductToPrepaymentOrder');
add_action('wp_ajax_addProductToPrepaymentOrder', 'addProductToPrepaymentOrder');

add_action('wp_ajax_nopriv_search_and_display_product_prepayment', 'search_and_display_product_prepayment');
add_action('wp_ajax_search_and_display_product_prepayment', 'search_and_display_product_prepayment');


add_action('wp_ajax_sales_get_variation_id', 'sales_get_variation_id');
add_action('wp_ajax_nopriv_sales_get_variation_id', 'sales_get_variation_id');

add_action('wp_ajax_return_product_information_for_list', 'return_product_information_for_list');
add_action('wp_ajax_nopriv_return_product_information_for_list', 'return_product_information_for_list');

add_action('wp_ajax_add_product_to_order', 'add_product_to_order');
add_action('wp_ajax_nopriv_add_product_to_order', 'add_product_to_order');

add_action('wp_ajax_remove_order_line_item_from_order', 'remove_order_line_item_from_order');
add_action('wp_ajax_nopriv_remove_order_line_item_from_order', 'remove_order_line_item_from_order');



add_action('wp_ajax_getDepartment', 'getDepartment');
add_action('wp_ajax_nopriv_getDepartment', 'getDepartment');

add_action('wp_ajax_search_and_display_leads', 'search_and_display_leads');
add_action('wp_ajax_nopriv_search_and_display_leads', 'search_and_display_leads');

add_action('wp_ajax_search_and_display_leads_filter', 'search_and_display_leads_filter');
add_action('wp_ajax_nopriv_search_and_display_leads_filter', 'search_and_display_leads_filter');



add_action('wp_ajax_order_and_display_projects_by_department', 'order_and_display_projects_by_department');
add_action('wp_ajax_nopriv_order_and_display_projects_by_department', 'order_and_display_projects_by_department');

add_action('wp_ajax_return_modal_content', 'return_modal_content');
add_action('wp_ajax_nopriv_return_modal_content', 'return_modal_content');

add_action('wp_ajax_return_lead_modal_content', 'return_lead_modal_content');
add_action('wp_ajax_nopriv_return_lead_modal_content', 'return_lead_modal_content');

add_action('wp_ajax_delete_lead', 'delete_lead');
add_action('wp_ajax_nopriv_delete_lead', 'delete_lead');

add_action('wp_ajax_delete_order', 'delete_order');
add_action('wp_ajax_nopriv_delete_order', 'delete_order');

add_action('wp_ajax_delete_project_order', 'delete_project_order');
add_action('wp_ajax_nopriv_delete_project_order', 'delete_project_order');

add_action('wp_ajax_get_projects_for_calendar', 'get_projects_for_calendar');
add_action('wp_ajax_nopriv_get_projects_for_calendar', 'get_projects_for_calendar');

add_action('wp_ajax_return_todo_modal_content', 'return_todo_modal_content');
add_action('wp_ajax_nopriv_return_todo_modal_content', 'return_todo_modal_content');

add_action('wp_ajax_return_more_objects', 'return_more_objects');
add_action('wp_ajax_nopriv_return_more_objects', 'return_more_objects');

add_action('wp_ajax_return_more_todos', 'return_more_todos');
add_action('wp_ajax_nopriv_return_more_todos', 'return_more_todos');

add_action('wp_ajax_return_internal_project_status_dropdown', 'return_internal_project_status_dropdown');
add_action('wp_ajax_nopriv_return_internal_project_status_dropdown', 'return_internal_project_status_dropdown');

add_action('wp_ajax_update_event_drop', 'update_event_drop');
add_action('wp_ajax_nopriv_update_event_drop', 'update_event_drop');

add_action('wp_ajax_filter_and_return_todos', 'filter_and_return_todos');
add_action('wp_ajax_nopriv_filter_and_return_todos', 'filter_and_return_todos');

add_action('wp_ajax_return_modal_project_content', 'return_modal_project_content');
add_action('wp_ajax_nopriv_return_modal_project_content', 'return_modal_project_content');

add_action('wp_ajax_paged_web_orders', 'paged_web_orders');
add_action('wp_ajax_nopriv_paged_web_orders', 'paged_web_orders');

add_action('wp_ajax_return_internal_project_status_and_users_modal_dropdowns', 'return_internal_project_status_and_users_modal_dropdowns');
add_action('wp_ajax_nopriv_return_internal_project_status_and_users_modal_dropdowns', 'return_internal_project_status_and_users_modal_dropdowns');


add_action('wp_ajax_send_invoice_to_customer', 'send_invoice_to_customer');
add_action('wp_ajax_nopriv_send_invoice_to_customer', 'send_invoice_to_customer');

add_action('wp_ajax_sync_to_fortnox', 'sync_to_fortnox');
add_action('wp_ajax_nopriv_sync_to_fortnox', 'sync_to_fortnox');


add_action('wp_ajax_project_files_upload', 'project_files_upload');
add_action('wp_ajax_nopriv_project_files_upload', 'project_files_upload');


add_action('wp_ajax_delete_project_file_function', 'delete_project_file_function');
add_action('wp_ajax_nopriv_delete_project_file_function', 'delete_project_file_function');

add_action('wp_ajax_update_offert_status_when_editing', 'update_offert_status_when_editing');
add_action('wp_ajax_nopriv_update_offert_status_when_editing', 'update_offert_status_when_editing');

add_action('wp_ajax_update_offert_status', 'update_offert_status');
add_action('wp_ajax_nopriv_update_offert_status', 'update_offert_status');


add_action('wp_ajax_send_msg_to_customer', 'send_msg_to_customer');
add_action('wp_ajax_nopriv_send_msg_to_customer', 'send_msg_to_customer');

add_action('wp_ajax_edit_subcontractor_info', 'edit_subcontractor_info');
add_action('wp_ajax_nopriv_edit_subcontractor_info', 'edit_subcontractor_info');

add_action('wp_ajax_create_subcontractor', 'create_subcontractor');
add_action('wp_ajax_nopriv_create_subcontractor', 'create_subcontractor');

add_action('wp_ajax_delete_subcontractor_info', 'delete_subcontractor_info');
add_action('wp_ajax_nopriv_delete_subcontractor_info', 'delete_subcontractor_info');

add_action('wp_ajax_filter_table_ordrar', 'filter_table_ordrar');
add_action('wp_ajax_nopriv_filter_table_ordrar', 'filter_table_ordrar');

add_action('wp_ajax_filter_table_rapport', 'filter_table_rapport');
add_action('wp_ajax_nopriv_filter_table_rapport', 'filter_table_rapport');

add_action('wp_ajax_order_files_upload', 'order_files_upload');
add_action('wp_ajax_nopriv_order_files_upload', 'order_files_upload');

add_action('wp_ajax_delete_order_file_function', 'delete_order_file_function');
add_action('wp_ajax_nopriv_delete_order_file_function', 'delete_order_file_function');

add_action('wp_ajax_delete_bild_render', 'delete_bild_render');
add_action('wp_ajax_nopriv_delete_bild_render', 'delete_bild_render');

add_action('wp_ajax_add_discount_product_to_offert', 'add_discount_product_to_offert');
add_action('wp_ajax_nopriv_add_discount_product_to_offert', 'add_discount_product_to_offert');


add_action('wp_ajax_update_data', 'update_data');
add_action('wp_ajax_nopriv_update_data', 'update_data');


add_action('wp_ajax_callback_send_email', 'callback_send_email');
add_action('wp_ajax_nopriv_callback_send_email', 'callback_send_email');

add_action('wp_ajax_call_meta', 'call_meta');
add_action('wp_ajax_nopriv_call_meta', 'call_meta');

add_action('wp_ajax_update_customerdata', 'update_customerdata');
add_action('wp_ajax_nopriv_update_customerdata', 'update_customerdata');

add_action('wp_ajax_completed_upgift', 'completed_upgift');
add_action('wp_ajax_nopriv_completed_upgift', 'completed_upgift');

add_action('wp_ajax_update_order_quantity', 'update_order_quantity');
add_action('wp_ajax_nopriv_update_order_quantity', 'update_order_quantity');

function getCustomerName($userid) {
    return get_user_meta($userid, 'customer_name', true);
}

function updateCustomerName($userid, $data) {
    update_user_meta($useid, 'customer_name', $data);
}

function update_customerdata() {
    $lead_id = $_POST["uid"];
    $lead_checkbox = $_POST['lead_checkbox'];
    $lead_checkboxid = $_POST['leadid'];

    $lead_first_name = $_POST["customer_first_name"];
    $lead_last_name = $_POST["customer_last_name"];
    $lead_email = $_POST["customer_email"];
    $lead_phone = $_POST["customer_phone"];
    $lead_city = $_POST["customer_city"];
    $lead_postnummer = $_POST["customer_postnummer"];
    $lead_typavlead = $_POST["customer_typavlead"];
    $lead_other = $_POST["customer_other"];

    $lead_customer_levernadress = $_POST["customer_levernadress"];
    $lead_customer_homenummer = $_POST["customer_homenummer"];

    foreach ($lead_checkbox as $metaValue) {
        $filter = explode('-', $metaValue);

        if (empty($filter[1])) {
            update_post_meta($lead_checkboxid, $metaValue, $metaValue);
        } else {
            update_post_meta($lead_checkboxid, $filter[0], '');
        }
    }



//    update_user_meta($lead_id, "first_name", $lead_first_name);
    updateCustomerName($lead_id, $lead_first_name);
//    update_user_meta($lead_id, "last_name", $lead_last_name);
    update_user_meta($lead_id, "billing_email", $lead_email);
    update_user_meta($lead_id, "billing_phone", $lead_phone);
    update_user_meta($lead_id, "billing_city", $lead_city);
    update_user_meta($lead_id, "billing_postcode", $lead_postnummer);
    update_user_meta($lead_id, "lead_typavlead", $lead_typavlead);

    update_user_meta($lead_id, "billing_address_1", $lead_customer_levernadress);
    update_user_meta($lead_id, "billing_address_1", $lead_customer_homenummer);

    update_post_meta($lead_checkboxid, "lead_other", $lead_other);
    update_post_meta($lead_checkboxid, "takhojdbv_cb", $_POST['takhojdbv_cb']);
    update_post_meta($lead_checkboxid, "byggar_cb", $_POST['byggar_cb']);
    update_post_meta($lead_checkboxid, "antal_kanaler_cb", $_POST['antal_kanaler_cb']);
    update_post_meta($lead_checkboxid, "ca_meter_cb", $_POST['ca_meter_cb']);
    update_post_meta($lead_checkboxid, "annat_yttertak_cb", $_POST['annat_yttertak_cb']);
    die();
}

function delete_bild_render() {

    $offertId = $_POST['offertId'];
    $placmentId = $_POST['placmentId'];
    $jsonName = $_POST['jsonName'];
    if ($placmentId != 'false') {
        delete_post_meta($offertId, $placmentId);
        delete_post_meta($offertId, $placmentId . '_image_description');
    }

    $JsonOrder_field = get_field('orderdata_json', $offertId);
    $JsonOrder_field_decode = json_decode($JsonOrder_field, JSON_PRETTY_PRINT);
    unset($JsonOrder_field_decode[$jsonName]);

    //  update_field('orderdata_json', json_encode($JsonOrder_field_decode), $offertId);
    delete_post_meta($offertId, "orderdata_json");
    add_post_meta($offertId, "orderdata_json", json_encode($JsonOrder_field_decode, JSON_UNESCAPED_UNICODE));
    die();
}

function delete_order_file_function() {
    $projectId = $_POST['projectId'];
    $rowNummber = $_POST['rowNummber'];
    $filUrl = $_POST['filUrl'];
    $fil_id = pippin_get_image_id($filUrl);
    $newdata = [];
    if ($_POST['arbet_file'] == 'yes') {
        $filedata = get_post_meta($projectId, 'file_order', true);
//        print_r($filedata);die;
        foreach ($filedata as $val) {
            $namn = $val['namn'];
            $url = $val['url'];
            if ($filUrl != $url) {
//                echo'yes1';die;
                $newdata[] = array('namn' => $namn, 'url' => $url);
            }
        }
        update_post_meta($projectId, 'file_order', $newdata);
    } else {

        delete_row('filer_order', $rowNummber, $projectId);
        echo $fil_id;
        wp_delete_attachment($fil_id, true);
    }
    die;
}

function arbet_order_files_upload($projectId, $files) {
//    print_r($file_name['files']['name']);die;
    //$projectId = $_POST['projectId'];
    $parent_post_id = isset($_POST['post_id']) ? $_POST['post_id'] : 0;  // The parent ID of our attachments
    //print_r($parent_post_id);
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "zip", "rar", "doc", "xls", "pdf", "txt", "jfif"); // Supported file types
    $max_file_size = 1024 * 5000; // in kb
    $max_image_upload = 5; // Define how many images can be uploaded to the current post
    $wp_upload_dir = wp_upload_dir();
    $path = $wp_upload_dir['path'] . '/';
    $count = 1;

    $lastarray = array();
    $current_img_array = [];

    $image_ids = get_field('file_order', $projectId);

    if ($image_ids) {
        foreach ($image_ids as $single_image) {

            $arg_current = [
                "namn" => $single_image['namn'],
                "url" => $single_image['url'],
            ];


            array_push($current_img_array, $arg_current);
        }
    }

    // Image upload handler
    // Check if user is trying to upload more than the allowed number of images for the current post
    if ((count($files['files']['name'])) > $max_image_upload) {
        $upload_message[] = "Tyvärr kan du bara ladda upp " . $max_image_upload . " bilder för varje uppladdning";
    } else {
        foreach ($files['files']['name'] as $f => $name) {

            $extension = pathinfo($name, PATHINFO_EXTENSION);

            // Generate a randon code for each file name
            $new_filename = $name . cvf_td_generate_random_code(3) . '.' . $extension;
//                echo $new_filename;

            if ($files['files']['error'][$f] == 4) {
                continue;
            }
            if ($files['files']['error'][$f] == 0) {

                // Check if image size is larger than the allowed file size
                if ($files['files']['size'][$f] > $max_file_size) {

                    $upload_message[] = "$name är för stor (max 5mb per bild)";
                    continue;

                    // Check if the file being uploaded is in the allowed file types
                } elseif (!in_array(strtolower($extension), $valid_formats)) {

                    $upload_message[] = "$name 'är inte ett godkänt format";
                    continue;
                } else {
                    // If no errors, upload the file...
                    if (move_uploaded_file($files["files"]["tmp_name"][$f], $path . $new_filename)) {
//echo $path.'jyoti'.$new_filename;
                        $count++;
                        $filename = $path . $new_filename;
                        $filetype = wp_check_filetype(basename($filename), null);
                        $wp_upload_dir = wp_upload_dir();
                        $attachment = array(
                            'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
                            'post_mime_type' => $filetype['type'],
                            'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );
//                            echo"<pre>";
//                            print_r($attachment);
                        // Insert attachment to the database
                        $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);

                        require_once(ABSPATH . 'wp-admin/includes/image.php');

                        // Generate meta data

                        $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
                        wp_update_attachment_metadata($attach_id, $attach_data);
                        $attachment_url = wp_get_attachment_url($attach_id);

                        // save a repeater field value

                        $arg = [
                            "namn" => $name,
                            "url" => $attachment_url
                        ];
                        array_push($lastarray, $arg);
                        $merged_array = array_merge($current_img_array, $lastarray);
                        update_field('file_order', $merged_array, $projectId);
                    }
                }
            }
        }
    }

    // Loop through each error then output it to the screen
    if (isset($upload_message)) :
        foreach ($upload_message as $msg) {
            printf(__('<p class="bg-danger">%s</p>', 'wp-trade'), $msg);
        }
        return $upload_message;
    endif;

    // If no error, show success message
    if ($count != 0) {
        printf(__('<p class = "bg-success">Filerna har lagts till!</p>', 'wp-trade'), $count);
        return '';
    }
}

function order_files_upload() {
    $projectId = $_POST['projectId'];
    $parent_post_id = isset($_POST['post_id']) ? $_POST['post_id'] : 0;  // The parent ID of our attachments
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "zip", "rar", "doc", "xls", "pdf", "txt"); // Supported file types
    $max_file_size = 1024 * 5000; // in kb
    $max_image_upload = 4; // Define how many images can be uploaded to the current post
    $wp_upload_dir = wp_upload_dir();
    $path = $wp_upload_dir['path'] . '/';
    $count = 1;

    $attachments = get_posts(array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_parent' => $parent_post_id,
        'exclude' => get_post_thumbnail_id() // Exclude post thumbnail to the attachment count
    ));
    $lastarray = array();
    $current_img_array = [];
    if ($_POST['arbetfile']) {
        $image_ids = get_field('file_order', $projectId);
    } else {
        $image_ids = get_field('filer_order', $projectId);
    }
    if ($image_ids) {
        foreach ($image_ids as $single_image) {

            $arg_current = [
                "namn" => $single_image['namn'],
                "url" => $single_image['url'],
            ];


            array_push($current_img_array, $arg_current);
        }
    }

    // Image upload handler
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        // Check if user is trying to upload more than the allowed number of images for the current post
        if ((count($_FILES['files']['name'])) > $max_image_upload) {
            $upload_message[] = "Tyvärr kan du bara ladda upp " . $max_image_upload . " bilder för varje uppladdning";
        } else {

            foreach ($_FILES['files']['name'] as $f => $name) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);

                // Generate a randon code for each file name
                $new_filename = $name . cvf_td_generate_random_code(3) . '.' . $extension;

                if ($_FILES['files']['error'][$f] == 4) {
                    continue;
                }

                if ($_FILES['files']['error'][$f] == 0) {
                    // Check if image size is larger than the allowed file size
                    if ($_FILES['files']['size'][$f] > $max_file_size) {
                        $upload_message[] = "$name är för stor!";
                        continue;

                        // Check if the file being uploaded is in the allowed file types
                    } elseif (!in_array(strtolower($extension), $valid_formats)) {
                        $upload_message[] = "$name 'är inte ett godkänt format";
                        continue;
                    } else {
                        // If no errors, upload the file...
                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path . $new_filename)) {

                            $count++;

                            $filename = $path . $new_filename;
                            $filetype = wp_check_filetype(basename($filename), null);
                            $wp_upload_dir = wp_upload_dir();
                            $attachment = array(
                                'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
                                'post_mime_type' => $filetype['type'],
                                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                                'post_content' => '',
                                'post_status' => 'inherit'
                            );
                            // Insert attachment to the database
                            $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);

                            require_once(ABSPATH . 'wp-admin/includes/image.php');

                            // Generate meta data
                            $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
                            wp_update_attachment_metadata($attach_id, $attach_data);
                            $attachment_url = wp_get_attachment_url($attach_id);

                            // save a repeater field value

                            $arg = [
                                "namn" => $name,
                                "url" => $attachment_url
                            ];
                            array_push($lastarray, $arg);

                            $merged_array = array_merge($current_img_array, $lastarray);
                            if ($_POST['arbetfile']) {
                                update_field('file_order', $merged_array, $projectId);
                            } else {
                                update_field('filer_order', $merged_array, $projectId);
                            }
                        }
                    }
                }
            }
        }
    }
    // Loop through each error then output it to the screen
    if (isset($upload_message)) :
        foreach ($upload_message as $msg) {
            printf(__('<p class="bg-danger">%s</p>', 'wp-trade'), $msg);
        }
        return $upload_message;
    endif;

    // If no error, show success message
    if ($count != 0) {
        printf(__('<p class = "bg-success">Filerna har lagts till!</p>', 'wp-trade'), $count);
    }

    exit();
}

function filter_table_ordrar() {

    $status = $_POST['status'];
    $imm_sale_order_saljare_filter = $_POST['imm_sale_order_saljare_filter'];


    if ($imm_sale_order_saljare_filter === 'alla') {
        $imm_sale_order_saljare_filter_value = return_users_id_as_array('sale-salesman', 'sale-administrator', 'sale-economy', 'sale-technician', 'sale-project-management', 'sale-sub-contractor');
    } else {
        $imm_sale_order_saljare_filter_value = $imm_sale_order_saljare_filter;
    }

    /* $from_date = $_POST['from_date']; */
    $from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["from_date"]))));
    $args_offices = [
        'post_type' => 'imm-sale-office',
        'posts_per_page' => -1,
    ];
    $offices = new WP_Query($args_offices);
    $ids_offices = array();
    while ($offices->have_posts()) {
        $offices->the_post();

        $office_connection = get_the_ID();
        array_push($ids_offices, $office_connection);
    }

    $to_dates = DateTime::createFromFormat('Y-m-d', $_POST["to_date"]);
    $all_office_in_mb = $_POST['all_office_in_mb'];
    if ($all_office_in_mb === 'office_connection_filter') {
        $all_office_in_mb_value = $ids_offices;
    } else {
        $all_office_in_mb_value = $all_office_in_mb;
    }

    if ($to_dates !== FALSE) {
        $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["to_date"]))));
    } else {
        $to_date = date("Y-m-d", strtotime("tomorrow"));
    }

    if ($status === 'alla') {
        $status_value = array(
            'false' => 'false',
            'true' => 'true',
            'wait' => '',
        );
    } else {
        $status_value = $status;
    }


    $current_id = get_current_user_id();

    $projects_id_array = array();
    $project_arg = array(
        'orderby' => 'ID',
        'post_type' => 'imm-sale-project',
        'meta_key' => 'order_salesman',
        'meta_value' => $current_id,
        'posts_per_page' => -1
    );
    $projects = new WP_Query($project_arg);
    while ($projects->have_posts()) {
        $projects->the_post();
        $projects_id = get_the_ID();
        array_push($projects_id_array, $projects_id);
    }
    if (empty($projects_id_array)) {
        $projects_id_array_users = 0;
    } else {
        $projects_id_array_users = $projects_id_array;
    }


    if (current_user_can('sale-administrator')) {

        $args = array(
            'orderby' => 'ID',
            'paged' => 1,
            'post_type' => wc_get_order_types(),
            'post_status' => array_keys(wc_get_order_statuses()),
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'imm-sale_project_connection',
                    'compare' => 'EXISTS',
                ), array(
                    'key' => 'order_office_connection',
                    'value' => $all_office_in_mb_value,
                ),
                array(
                    'key' => 'saljare_id',
                    'value' => $imm_sale_order_saljare_filter_value,
                ),
                array(
                    'key' => 'order_accept_status',
                    'value' => $status_value,
                ), array(
                    'key' => 'imm-sale_prepayment_invoice',
                    'compare' => 'NOT EXISTS',
                )
            ),
            'date_query' => array(
                array(
                    'after' => $from_date,
                    'before' => $to_date,
                ))
        );
    } else {
        $args = array(
            /* 'author' =>73, */
            'meta_key' => 'imm-sale_project_connection',
            'meta_value' => $projects_id_array_users,
            'orderby' => 'ID',
            'paged' => 1,
            'post_type' => wc_get_order_types(),
            'post_status' => array_keys(wc_get_order_statuses()),
            'posts_per_page' => -1,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'imm-sale_project_connection',
                    'compare' => 'EXISTS',
                ), array(
                    'key' => 'order_accept_status',
                    'value' => $status_value,
                )/* ,array(
              'key' => 'order_office_connection',
              'value' => $all_office_in_mb,
              ), */
            ),
            'date_query' => array(
                array(
                    'after' => $from_date,
                    'before' => $to_date,
                ))
        );
    }


    $orders = new WP_Query($args);

    $json_array = array();

    $i = 1;
    while ($orders->have_posts()) :

        $orders->the_post();
        $order = new WC_Order(get_the_ID());

        $order_statuses = wc_get_order_statuses();
        $id = get_the_ID();
        $skapat = $order->order_date;
        $exkl_moms = wc_price($order->get_total() - $order->get_total_tax());
        $moms = wc_price($order->get_total_tax());
        $totalt = wc_price($order->get_total());
        $totalt_2 = $order->get_total();
        $statusen = get_field('order_accept_status');
        $kopplad_project_id = get_field('imm-sale_project_connection', get_the_ID());
        $saljare_id = get_field('saljare_id', get_the_ID());
        $user_info = get_userdata($saljare_id);
        $saljare_name = getCustomerName($saljare_id);
        $koppad_butik_id = get_post_meta($kopplad_project_id, 'office_connection')[0];

        if ($koppad_butik_id) {
            $koppad_butik = get_the_title($koppad_butik_id);
        }

        if ($statusen === 'true') {
            $statusent = 'Accepterat';
        } elseif ($statusen === 'false') {
            $statusent = 'Nekats';
        } else {
            $statusent = 'Väntar';
        }
        $prjekt_id = get_field('imm-sale_project_connection');
        $kundens_namn = $order->get_billing_first_name() . " " . $order->get_billing_last_name();
        $order_office_connection = get_post_meta(get_the_ID(), 'order_office_connection')[0];
        $order_array = array(
            'i' => $i,
            'id' => $id,
            'skapat' => $skapat,
            'exl_moms' => $exkl_moms,
            'moms' => $moms,
            'totalt' => $totalt,
            'status' => $statusent,
            'pid' => $prjekt_id,
            'namn' => $kundens_namn,
            'saljare' => $saljare_name,
            'butik' => $koppad_butik,
            'totalt2' => $totalt_2,
            'office_connection' => $order_office_connection,
        );

        array_push($json_array, $order_array);
        $i++;
    endwhile;

    $result = json_encode($json_array, JSON_PRETTY_PRINT);
    echo $result;

    die();
}

function delete_subcontractor_info() {
    $user_id = $_POST['ue_id'];
    $ue_fname = $_POST['ue_fname'];
//    update_user_meta($user_id, 'first_name', '<span style="color:red">Bortagen_</span>' . $ue_fname);
    updateCustomerName($user_id, '<span style="color:red">Bortagen_</span>' . $ue_fname);
    /*    wp_delete_user( $user_id ,1); */
    die();
}

function create_subcontractor() {

    $sub_fornamn = $_POST['sub_fornamn'];
//    $sub_efternamn = $_POST['sub_efternamn'];
    $sub_epost = $_POST['sub_epost'];
    $sub_tel = $_POST['sub_tel'];
    $sub_company = $_POST['sub_company'];
    $sub_shortname = $_POST['sub_shortname'];


    $user_id = username_exists($sub_epost);
    if (!$user_id and email_exists($sub_epost) == false) {
        $random_password = wp_generate_password($length = 12, $include_standard_special_chars = false);
        $user_id = wp_create_user($sub_epost, $random_password, $sub_epost);

        update_user_meta($user_id, 'billing_email', $sub_epost);
        update_user_meta($user_id, 'first_name', $sub_fornamn);
        update_user_meta($user_id, "customer_name", $sub_fornamn);
        update_user_meta($user_id, "customer_name_backup", $sub_fornamn);
//        update_user_meta($user_id, 'last_name', $sub_efternamn);

        updateCustomerName($user_id, $sub_fornamn);

        update_user_meta($user_id, 'billing_first_name', $sub_fornamn);
//        update_user_meta($user_id, 'billing_last_name', $sub_efternamn);
        update_user_meta($user_id, 'billing_phone', $sub_tel);
        update_user_meta($user_id, 'personal_phone', $sub_tel);
        update_user_meta($user_id, 'sale-sub-contractor_company', $sub_company);
        update_user_meta($user_id, 'sale-sub-contractor_shortname', $sub_shortname);
        update_user_meta($user_id, 'personal_company', $sub_company);
        update_user_meta($user_id, 'billing_company', $sub_company);
        $user_id_role = new WP_User($user_id);
        $user_id_role->set_role('sale-sub-contractor');

        echo 'UE har skapats';
    } else {
        $random_password = __('Tyvärr, e-postadressen används redan. Vänligen prova en annan.');
        echo $random_password;
    }

    die();
}

function edit_subcontractor_info() {
    $user_id = $_POST['ue_id'];
    $sub_fornamn = $_POST['sub_fornamn'];
//    $sub_efternamn = $_POST['sub_efternamn'];
    $sub_epost = $_POST['sub_epost'];
    $sub_tel = $_POST['sub_tel'];
    $sub_company = $_POST['sub_company'];
    $sub_shortname = $_POST['sub_shortname'];


    update_user_meta($user_id, 'first_name', $sub_fornamn);

//    update_user_meta($user_id, 'last_name', $sub_efternamn);
    update_user_meta($user_id, "customer_name", $sub_fornamn);
    update_user_meta($user_id, "customer_name_backup", $sub_fornamn);

    updateCustomerName($user_id, $sub_fornamn);

    wp_update_user(array('ID' => $user_id, 'user_email' => $sub_epost));
    update_user_meta($user_id, 'personal_phone', $sub_tel);
    update_user_meta($user_id, 'sale-sub-contractor_company', $sub_company);
    update_user_meta($user_id, 'sale-sub-contractor_shortname', $sub_shortname);
    die();
}

function update_offert_status_when_editing() {
    $order_id = $_POST['order_id'];
    $user_id = $_POST['user_id'];
    $user_info = get_userdata(intval($user_id));
    $user_name = $user_info->user_login;
    $current_time = current_time( 'mysql' );

    update_post_meta($order_id, 'firstSort', true);
    update_field('editing_status_mb', 1, $order_id);
    update_field('edited_by_mb', $user_name, $order_id);
    update_field('editing_time_mb', $current_time, $order_id);
    create_log_entry(__("Artikel: Invoice Deleted"), $order_id);

    die;
}

function update_offert_status() {
    $order_id = $_POST['order_id'];
    $user_id = $_POST['user_id'];
    $user_info = get_userdata(intval($user_id));
    $user_name = $user_info->user_login;
    $current_time = date("Y-m-d h:i");
    update_field('edited_by_mb', $user_name, $order_id);


    die;
}

function pippin_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url));

    return $attachment[0];
}

function delete_project_file_function() {


    $projectId = $_POST['projectId'];
    $rowNummber = $_POST['rowNummber'];
    $filUrl = $_POST['filUrl'];
    $fil_id = pippin_get_image_id($filUrl);

    delete_row('filer_project', $rowNummber, $projectId);
    wp_delete_attachment($fil_id, true);
    die;
}

function project_files_upload() {
    $projectId = $_POST['projectId'];
    $parent_post_id = isset($_POST['post_id']) ? $_POST['post_id'] : 0;  // The parent ID of our attachments
    $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "zip", "rar", "doc", "xls", "pdf", "txt", "osv"); // Supported file types
    $max_file_size = 1024 * 5000; // in kb
    $max_image_upload = 4; // Define how many images can be uploaded to the current post
    $wp_upload_dir = wp_upload_dir();
    $path = $wp_upload_dir['path'] . '/';
    $count = 1;

    $attachments = get_posts(array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_parent' => $parent_post_id,
        'exclude' => get_post_thumbnail_id() // Exclude post thumbnail to the attachment count
    ));
    $lastarray = array();
    $current_img_array = [];
    $image_ids = get_field('filer_project', $projectId);
    if ($image_ids) {
        foreach ($image_ids as $single_image) {

            $arg_current = [
                "namn" => $single_image['namn'],
                "url" => $single_image['url'],
            ];


            array_push($current_img_array, $arg_current);
        }
    }

    // Image upload handler
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        // Check if user is trying to upload more than the allowed number of images for the current post
        if ((count($_FILES['files']['name'])) > $max_image_upload) {
            $upload_message[] = "Tyvärr kan du bara ladda upp " . $max_image_upload . " bilder för varje uppladdning";
        } else {

            foreach ($_FILES['files']['name'] as $f => $name) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);

                // Generate a randon code for each file name
                $new_filename = $name . cvf_td_generate_random_code(3) . '.' . $extension;

                if ($_FILES['files']['error'][$f] == 4) {
                    continue;
                }

                if ($_FILES['files']['error'][$f] == 0) {
                    // Check if image size is larger than the allowed file size
                    if ($_FILES['files']['size'][$f] > $max_file_size) {
                        $upload_message[] = "$name är för stor!";
                        continue;

                        // Check if the file being uploaded is in the allowed file types
                    } elseif (!in_array(strtolower($extension), $valid_formats)) {
                        $upload_message[] = "$name 'är inte ett godkänt format";
                        continue;
                    } else {
                        // If no errors, upload the file...
                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path . $new_filename)) {

                            $count++;

                            $filename = $path . $new_filename;
                            $filetype = wp_check_filetype(basename($filename), null);
                            $wp_upload_dir = wp_upload_dir();
                            $attachment = array(
                                'guid' => $wp_upload_dir['url'] . '/' . basename($filename),
                                'post_mime_type' => $filetype['type'],
                                'post_title' => preg_replace('/\.[^.]+$/', '', basename($filename)),
                                'post_content' => '',
                                'post_status' => 'inherit'
                            );
                            // Insert attachment to the database
                            $attach_id = wp_insert_attachment($attachment, $filename, $parent_post_id);

                            require_once(ABSPATH . 'wp-admin/includes/image.php');

                            // Generate meta data
                            $attach_data = wp_generate_attachment_metadata($attach_id, $filename);
                            wp_update_attachment_metadata($attach_id, $attach_data);
                            $attachment_url = wp_get_attachment_url($attach_id);

                            // save a repeater field value

                            $arg = [
                                "namn" => $name,
                                "url" => $attachment_url
                            ];
                            array_push($lastarray, $arg);

                            $merged_array = array_merge($current_img_array, $lastarray);
                            update_field('filer_project', $merged_array, $projectId);
                        }
                    }
                }
            }
        }
    }
    // Loop through each error then output it to the screen
    if (isset($upload_message)) :
        foreach ($upload_message as $msg) {
            printf(__('<p class="bg-danger">%s</p>', 'wp-trade'), $msg);
        }
    endif;

    // If no error, show success message
    if ($count != 0) {
        printf(__('<p class = "bg-success">Filerna har lagts till!</p>', 'wp-trade'), $count);
    }

    exit();
}

/* enable search by sku */

function tr_sku_search_helper($wp) {
    global $wpdb;

    //Check to see if query is requested
    if (!isset($wp->query['s']) || !isset($wp->query['post_type']) || $wp->query['post_type'] != 'product')
        return;
    $sku = $wp->query['s'];
    $ids = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value = %s;", $sku));
    if (!$ids)
        return;
    unset($wp->query['s']);
    unset($wp->query_vars['s']);
    $wp->query['post__in'] = array();
    foreach ($ids as $id) {
        $post = get_post($id);
        if ($post->post_type == 'product_variation') {
            $wp->query['post__in'][] = $post->post_parent;
            $wp->query_vars['post__in'][] = $post->post_parent;
        } else {
            $wp->query_vars['post__in'][] = $post->ID;
        }
    }
}

//add_filter('pre_get_posts', 'tr_sku_search_helper', 15);

// Random code generator used for file names.
function cvf_td_generate_random_code($length = 10) {

    $string = '';
    $characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }

    return $string;
}

function getDepartmentValue() {
    $department_search = array(1 => "sale-administrator", 2 => "sale-salesman", 3 => "sale-economy", 4 => "sale-project-management", 5 => "sale-technician", 6 => "sale-sub-contractor");
    $current_user_role = $department_search[$_POST['department']];
    $table_name = $_POST['table_name'];
    $class = $_POST['classes'];
    get_internal_project_status_dropdownValue($current_user_role, "internal_project_status_user", $table_name, "top-buffer-half", '', false, $class);
    die();
}

function getDepartment() {

    $current_user_role = $_POST['department'];
    $table_name = $_POST['table_name'];
    $class = $_POST['classes'];
    $newid = $_POST['newid'];
    get_internal_project_status_dropdown($current_user_role, $newid, $table_name, "top-buffer-half", $internal_status, false, $class);
    die();
}

function paged_web_orders() {
    $page = $_POST["page"];

    $args = array(
        'orderby' => 'ID',
        'paged' => $page,
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => 10,
        'meta_query' => array(
            array(
                'key' => 'imm-sale_project_connection',
                'compare' => 'NOT EXISTS',
            )
        )
    );
    $orders = new WP_Query($args);

    return_web_orders_table($orders);


    die();
}

function all_users_id_as_array() {
    $mine_all_array = return_users_id_as_array('sale-salesman', 'sale-administrator', 'sale-economy', 'sale-technician', 'sale-project-management', 'sale-sub-contractor');
    $none_users = array(intval(0));
    $mine_all_value = array_merge($mine_all_array, $none_users);
    return $mine_all_value;
}

function search_and_display_leads() {

    $search_term = $_POST["search_term"];
    $args = [
        'post_type' => "imm-sale-leads",
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'lead_first_name',
                'value' => $search_term,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'lead_last_name',
                'value' => $search_term,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'lead_email',
                'value' => $search_term,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'lead_phone',
                'value' => $search_term,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'lead_other',
                'value' => $search_term,
                'compare' => 'LIKE'
            )
            ,
            array(
                'key' => 'lead_postnummer',
                'value' => $search_term,
                'compare' => 'LIKE'
            )
            ,
            array(
                'key' => 'lead_city',
                'value' => $search_term,
                'compare' => 'LIKE'
            ),
            array(
                'key' => 'lead_typavlead',
                'value' => $search_term,
                'compare' => 'LIKE'
            )
        )
    ];
    return_leads_table($args);

    die();
}

function sales_get_variation_id() {
    $product_id = $_GET['prod_id'];
    $selected_values = $_GET['selected_values'];
    $attributes = [];

    foreach ($selected_values as $selected_value) {

        array_push($attributes, [
            'key' => $selected_value[0],
            'value' => $selected_value[1],
            'compare' => 'LIKE'
        ]);
    }

    $args = array(
        'post_type' => 'product_variation',
        'post_status' => array('private', 'publish'),
        'numberposts' => -1,
        'orderby' => 'menu_order',
        'order' => 'asc',
        'post_parent' => $product_id,
        'meta_query' => $attributes
    );
    $variations = get_posts($args);

    // get variations meta

    echo $variations[0]->ID;
    die();
}

function return_product_information_for_list($this_product_id = null, $order_line = null, $quantity = null, $custom_title = null) {
    $product_id = isset($_GET['prod_id']);

    if (!$product_id) {
        $product_id = $this_product_id;
    }
    $this_post = get_post($product_id);

    if ($custom_title) {
        $title = $custom_title;
    } else {
        $title = get_the_title($this_post->ID);

        $order_id = $order_line['order_id'];
        $order = wc_get_order($order_id);
        $beskrivning = $order_line["line_item_note"];
    }
//    echo $title;
    $product = wc_get_product($product_id);

    $this_post_id = $this_post->ID;

    $custom_price_adjust_product_id = get_field('custom_price_adjust_product_id', 'option');
    $custom_price_adjust_negative_product_id = get_field('custom_price_adjust_negative_product_id', 'option');
    $custom_price_adjust_arbetet_product_id = get_field('custom_price_adjust_arbetet_product_id', 'option');
    $custom_price_adjust_material_product_id = get_field('custom_price_adjust_material_product_id', 'option');
    $custom_discount_product = get_field('custom_discount_product', 'option');

    $custom_adjust_price_array = array(
        'custom_price_adjust_product_id' => $custom_price_adjust_product_id,
        'custom_price_adjust_negative_product_id' => $custom_price_adjust_negative_product_id,
        'custom_price_adjust_arbetet_product_id' => $custom_price_adjust_arbetet_product_id,
        'custom_price_adjust_material_product_id' => $custom_price_adjust_material_product_id,
            //'custom_discount_product' => $custom_discount_product
    );
//print_r($custom_adjust_price_array);
    if (!in_array($this_post_id, $custom_adjust_price_array)) {
        $html = "<li data-attribute-line-item-ids='" . $order_line->get_id() . "' class='sortingorder ' data-product_id='" . $this_post->ID . "'>" . $title . '-' . $beskrivning . " <i>" . wc_get_order_item_meta($order_line->get_id(), 'line_item_special_note', true) . "</i>" . " (x" . $quantity . ") " . wc_price($order_line["subtotal"] + $order_line["subtotal_tax"]) . " - <a href='#' data-attribute-line-item-id='" . $order_line->get_id() . "' data-attribute-product-id='" . $this_post->ID . "' class='remove-product' id='product-list-" . $this_post->ID . "' ><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a><a href='#' data-attribute-line-item-id='" . $order_line->get_id() . "' data-attribute-product-id='" . $this_post->ID . "' class='' data-toggle='modal' data-target='#stepsModalLong' style='padding:5px'><i class=\"fa fa-edit\" aria-hidden=\"true\"></i></a><a href='#' data-attribute-line-item-id='" . $order_line->get_id() . "' data-minus='1' class='increment_product' ><i class=\"fa fa-minus\" aria-hidden=\"true\"></i></a> <a href='#' data-attribute-line-item-id='" . $order_line->get_id() . "' class='increment_product' ><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></a>" . "</li>";
    } else {
        $html = "<li data-attribute-line-item-ids='" . $order_line->get_id() . "' class='sortingorder' data-product_id='" . $this_post->ID . "'>" . $beskrivning . " <i>" . wc_get_order_item_meta($order_line->get_id(), 'line_item_special_note', true) . "</i>" . " (x" . $quantity . ") " . wc_price($order_line["subtotal"] + $order_line["subtotal_tax"]) . " - <a href='#' data-attribute-line-item-id='" . $order_line->get_id() . "' data-attribute-product-id='" . $this_post->ID . "' class='remove-product' id='product-list-" . $this_post->ID . "' ><i class=\"fa fa-trash\" aria-hidden=\"true\"></i></a><a href='#' data-toggle='modal' data-attribute-line-item-id='" . $order_line->get_id() . "' data-attribute-product-id='" . $this_post->ID . "' class='' data-target='#stepsModalLong' style='padding:5px'><i class=\"fa fa-edit\" aria-hidden=\"true\"></i></a><a href='#' data-attribute-line-item-id='" . $order_line->get_id() . "' data-minus='1' class='increment_product' ><i class=\"fa fa-minus\" aria-hidden=\"true\"></i></a> <a href='#' data-attribute-line-item-id='" . $order_line->get_id() . "' class='increment_product' ><i class=\"fa fa-plus\" aria-hidden=\"true\"></i></a>" . "</li>";
    }


    return $html;
    //die();
}

function update_order_quantity() {
    $order = new WC_Order($_POST['orderId']);
    $order_item_id = $_POST['lineid'];
    $quantity = wc_get_order_item_meta($order_item_id, '_qty', true);
    if (!empty($_POST['minus'])) {
        if ($quantity == '1')
            die;

        $totalquantity = $quantity - 1;
    }
    else {
        $totalquantity = $quantity + 1;
    }

    $total = wc_get_order_item_meta($order_item_id, '_line_total', true) / $quantity;
    $totalsum = $total * $totalquantity;
    wc_update_order_item_meta($order_item_id, '_qty', $totalquantity);
    wc_update_order_item_meta($order_item_id, '_line_total', $totalsum);
    $order->calculate_totals();
    die();
}

function return_product_information_list_print($this_product_id = null, $order_line = null, $quantity = null, $custom_title = null) {

    $product_id = isset($_GET['prod_id']);

    if (!$product_id) {
        $product_id = $this_product_id;
    }

//    echo $product_id;
    $this_post = get_post($product_id);

    if ($custom_title) {
        $title = $custom_title;
    } else {
        $title = get_the_title($this_post->ID);

        $order_id = $order_line['order_id'];
        $order = wc_get_order($order_id);
        $beskrivning = $order_line["line_item_note"];
//        echo $order_id;
    }

    $product = wc_get_product($product_id);

    $this_post_id = $this_post->ID;

    $custom_price_adjust_product_id = get_field('custom_price_adjust_product_id', 'option');
    $custom_price_adjust_negative_product_id = get_field('custom_price_adjust_negative_product_id', 'option');
    $custom_price_adjust_arbetet_product_id = get_field('custom_price_adjust_arbetet_product_id', 'option');
    $custom_price_adjust_material_product_id = get_field('custom_price_adjust_material_product_id', 'option');
    $custom_adjust_price_array = array(
        'custom_price_adjust_product_id' => $custom_price_adjust_product_id,
        'custom_price_adjust_negative_product_id' => $custom_price_adjust_negative_product_id,
        'custom_price_adjust_arbetet_product_id' => $custom_price_adjust_arbetet_product_id,
        'custom_price_adjust_material_product_id' => $custom_price_adjust_material_product_id
    );
    if (!in_array($this_post_id, $custom_adjust_price_array)) {
//        if ($product_id != '12870') {
        $html .= "<span data-product_id='" . $this_post->ID . "'>" . $title . " <i>" . wc_get_order_item_meta($order_line->get_id(), 'line_item_special_note', true) . "</i></span>";
        $html .= "<span class='product-prce' style='float:right;' data-product_id='" . $this_post->ID . "'>" . wc_price($order_line["subtotal"] + $order_line["subtotal_tax"]) . " </span>";
//        }
    } else {
//        if ($product_id != '12870') {
        $html = "<span data-product_id='" . $this_post->ID . "'>" . $title . '-' . $order_line["line_item_note"] . " <i>" . wc_get_order_item_meta($order_line->get_id(), 'line_item_special_note', true) . "</i>" . " (x" . $quantity . ") " . wc_price($order_line["subtotal"] + $order_line["subtotal_tax"]) . "</span>";
//        }
    }


    return $html;
    //die();
}

function return_product_list($this_product_id = null, $order_line = null, $quantity = null, $custom_title = null) {

    $product_id = isset($_GET['prod_id']);

    if (!$product_id) {
        $product_id = $this_product_id;
    }
    $this_post = get_post($product_id);

    if ($custom_title) {
        $title = $custom_title;
    } else {
        $title = get_the_title($this_post->ID);

        $order_id = $order_line['order_id'];
        $order = wc_get_order($order_id);
        $beskrivning = $order_line["line_item_note"];
    }

    $product = wc_get_product($product_id);

    $this_post_id = $this_post->ID;

    $custom_price_adjust_product_id = get_field('custom_price_adjust_product_id', 'option');
    $custom_price_adjust_negative_product_id = get_field('custom_price_adjust_negative_product_id', 'option');
    $custom_price_adjust_arbetet_product_id = get_field('custom_price_adjust_arbetet_product_id', 'option');
    $custom_price_adjust_material_product_id = get_field('custom_price_adjust_material_product_id', 'option');
    $custom_adjust_price_array = array(
        'custom_price_adjust_product_id' => $custom_price_adjust_product_id,
        'custom_price_adjust_negative_product_id' => $custom_price_adjust_negative_product_id,
        'custom_price_adjust_arbetet_product_id' => $custom_price_adjust_arbetet_product_id,
        'custom_price_adjust_material_product_id' => $custom_price_adjust_material_product_id
    );

    if (!in_array($this_post_id, $custom_adjust_price_array)) {
        $html .= "<span data-product_id='" . $this_post->ID . "'>" . $title . " <i>" . wc_get_order_item_meta($order_line->get_id(), 'line_item_special_note', true) . "</i></span>";
    } else {
        $html = "<span data-product_id='" . $this_post->ID . "'>" . $beskrivning . " <i>" . wc_get_order_item_meta($order_line->get_id(), 'line_item_special_note', true) . "</i>" . " (x" . $quantity . ") " . wc_price($order_line["subtotal"] + $order_line["subtotal_tax"]) . "</span>";
    }


    return $html;
    //die();
}

function return_product_information_for_list_pi($this_product_id = null, $order_line = null, $quantity = null, $custom_title = null) {

    $product_id = isset($_GET['prod_id']);

    if (!$product_id) {
        $product_id = $this_product_id;
    }
    $this_post = get_post($product_id);

    if ($custom_title) {
        $title = $custom_title;
    } else {
        $title = get_the_title($this_post->ID);

        $order_id = $order_line['order_id'];
        $order = wc_get_order($order_id);

        if ($order_line["line_item_note"]) {
            $beskrivning = '-' . $order_line["line_item_note"];
        } else {
            $beskrivning = '';
        }
    }

    $product = wc_get_product($product_id);

    if ($product_id != '27944') {

        $html = "<option data-product_id='" . $this_post->ID . "' data-product_price='" . $order_line["subtotal"] . "' data-product_qty='" . $quantity . "' data-attribute-line-item-id='" . $order_line->get_id() . "'>" . $title . $beskrivning . " </option>";
    }
    return $html;
    //die();
}

function addProductToPrepaymentOrder() {
    $order_id = $_POST["orderid"];
    $product_id = $_POST['pid'];
    $quantity = $_POST["quantityPrepayment"];


    $order = new WC_Order($order_id);

    $line_item_id = null;
    $_pf = new WC_Product_Factory();

    $product = $_pf->get_product($product_id);
    //$order->add_product( $product, $quantity );
    $order->add_product($product, $quantity);



    $order->calculate_totals();



    die();
}

function save_add_product_order_log($order_id, $product_id, $note_name) {
    global $current_user;
    $file_name = $_SERVER['DOCUMENT_ROOT'] . "/order_log/" . $order_id . '_orderfile.txt';
    $data = array('note_name' => $note_name, 'product_id' => $product_id);
    $new_log_entry = [
        'user' => $current_user->user_email,
        'timestamp' => time(),
        'log_action' => $data,
        'product_data' => 'product_data'
    ];
    $json_log = json_encode($new_log_entry, JSON_PRETTY_PRINT);
    $createfile = fopen("$file_name", "a+") or die("there is a problem");
    fwrite($createfile, $json_log);
    fclose($createfile);
}

function add_product_to_order() {

    $order_id = $_POST["order_id"];
    $product_id = $_POST['product_id'];
    $quantity = $_POST["quantity"];
    $head_product = $_POST["head_product"];
    $line_item_special_note = $_POST["line_item_special_note"];
    $selected_cat_sum = 0;
    $loggedin_id = get_current_user_id();
    $projectid = get_field('imm-sale_project_connection', $order_id);
    $get_custid = get_field('invoice_customer_id', $projectid);
//    if ($loggedin_id == $get_custid) {

    $selected_product_category_for_price_adjustment = get_field('selected_product_category_for_price_adjustment', 'options');

    $order = new WC_Order($order_id);

    $line_item_id = null;
    $_pf = new WC_Product_Factory();

    /// $product = $_pf->get_product($product_id);
    $product = wc_get_product($product_id);
    $fromDate = get_post_meta($product_id, '_sale_price_dates_from', true);
    $toDate = get_post_meta($product_id, '_sale_price_dates_to', true);
    if ($_POST['not_sale'] == 1) {

        $regularprice = get_post_meta($product_id, '_regular_price', true);
        $line_item_id = $order->add_product($product, $quantity, [
            'subtotal' => $regularprice,
            'total' => $regularprice,
        ]);
    } else {
        if (empty($fromDate) && empty($fromDate)) {
            $line_item_id = $order->add_product($product, $quantity);
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
                $line_item_id = $order->add_product($product, $quantity);
            } else {
                $regularprice = get_post_meta($product_id, '_regular_price', true);
                $line_item_id = $order->add_product($product, $quantity, [
                    'subtotal' => $regularprice,
                    'total' => $regularprice,
                ]);
            }
        }
    }

    save_add_product_order_log($order_id, $product_id, $line_item_special_note);
    if ($head_product == "true") {
        wc_add_order_item_meta($line_item_id, "HEAD_ITEM", true);
    }
    wc_add_order_item_meta($line_item_id, "is_ordered_from_reseller", false);
    wc_add_order_item_meta($line_item_id, "line_item_special_note", $line_item_special_note);

    $order->calculate_totals();
    $remove_vats = get_post_meta($_POST['order_id'], 'remove_vats', true);
    if (!empty($remove_vats)) {
        removeVat($_POST['order_id'], 1);
        $order = new WC_Order($order_id);
    }
    foreach ($order->get_items() as $order_item_id => $item) {
        $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
        $line_item = $item;
        $terms = get_the_terms($product_id, 'product_cat');
        foreach ($terms as $term) {

            if (in_array($term->term_id, $selected_product_category_for_price_adjustment)) {
                $selected_cat_sum = $selected_cat_sum + $item->get_total();
            }
        }
    };


    $return = [];
    if ($head_product === "true") {
        $return["head"] = return_product_information_for_list($product_id, $line_item, $quantity);
    } else {
        $return["other"] = return_product_information_for_list($product_id, $line_item, $quantity);
    }
    $return["heading"] = $head_product;
    $return["line_item_id"] = $line_item_id;
    $return["formatted_total"] = $order->get_formatted_order_total();
    $return["selected_cat_sum"] = wc_price($selected_cat_sum);
    $return["tax_total"] = $order->get_total_tax();
    $return["no_tax-price-container"] = ($order->get_total() - $order->get_total_tax());
    $project_id = get_post_meta($order_id, 'imm-sale_project_connection', true);
    $internalstatuss = get_post_meta($project_id, 'internal_project_status_sale-administrator', true);
    if (count($order->get_items()) != 0 && $internalstatuss === 'Nytt' || empty($internalstatuss)) {
        update_post_meta($project_id, 'internal_project_status_sale-administrator', 'Offertarbete pågår');
        update_post_meta($order_id, 'internal_project_status_sale-administrator', 'Offertarbete pågår');
        updateSearchMetaInternal($order_id, 'internal_project_status_sale-administrator', 'Offertarbete pågår');
    }
    echo json_encode($return);
    create_log_entry(__("Artikel: ") . $product->get_title() . __(" tillagd i projekt"), $order->ID);

    die();
//    }
}

function remove_order_line_item_from_order() {

    $order_id = $_POST["order_id"];
    $line_item_id = $_POST["line_item_id"];
    $head_product = $_POST["head_product"];
    $selected_product_category_for_price_adjustment = get_field('selected_product_category_for_price_adjustment', 'options');
    $selected_cat_sum = 0;


    $projectid = get_field('imm-sale_project_connection', $order_id);
    $return = [];
    if (wc_get_order_item_meta($line_item_id, "HEAD_ITEM", true)) {
        $return["heading"] = 1;
    }
    $order = new WC_Order($order_id);
    foreach ($order->get_items() as $order_item_id => $item) {
        if ($order_item_id == $line_item_id) {
            $order->remove_item($line_item_id);
            $product_name = $item['name'];
        }
    }

    foreach ($order->get_items() as $order_item_id => $item) {
        $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();

        $terms = get_the_terms($product_id, 'product_cat');
        foreach ($terms as $term) {

            if (in_array($term->term_id, $selected_product_category_for_price_adjustment)) {
                $selected_cat_sum = $selected_cat_sum + $item->get_total();
            }
        }
    };


    $order->calculate_totals();
    $remove_vats = get_post_meta($_POST['order_id'], 'remove_vats', true);
    if (!empty($remove_vats)) {
        removeVat($_POST['order_id'], 1);
        $order = new WC_Order($order_id);
    }

    $return[0] = $order->get_formatted_order_total();
    $return[1] = $selected_cat_sum;
    $return[2] = $order->get_total_tax();
    $return[3] = $order->get_total() - $order->get_total_tax();

    $return["line_item_id"] = $line_item_id;
    echo json_encode($return);
    $project_id = get_post_meta($order_id, 'imm-sale_project_connection', true);
    $internalstatuss = get_post_meta($project_id, 'internal_project_status_sale-administrator', true);
    if (count($order->get_items()) == 0) {
        update_post_meta($project_id, 'internal_project_status_sale-administrator', 'Nytt');
        updateSearchMetaInternal($order_id, 'internal_project_status_sale-administrator', 'Nytt');
    }
    create_log_entry(__("Artikel: ") . $product_name . __(" raderad från projekt"), $order->ID);

    die();
//        }
}

function change_accept_order_status() {
    $order_id = $_POST["order-id"];
    $order_accepd = $_POST["order-accept"];

    update_post_meta($order_id, "order_accept_status", $order_accepd);

    echo "Delete Order item";
    die();
}

function deleteSearchOrder($myid) {
    global $wpdb;
    $wpdb->query('DELETE  FROM VQbs2_Project_Search_Meta WHERE id = ' . $myid);
    $wpdb->query('DELETE  FROM VQbs2_Projects_Search WHERE id = ' . $myid);
}

function delete_project_order() {
    $project_id = $_POST["project_id"];
    global $wpdb;

    $current_post = get_post($project_id, 'ARRAY_A');
    $current_post['post_status'] = 'draft';
    wp_update_post($current_post);
    $sql = "SELECT SQL_CALC_FOUND_ROWS  VQbs2_postmeta.* FROM VQbs2_postmeta  WHERE meta_key='imm-sale_project_connection' and meta_value='$project_id'";
    $qryOrderData = $wpdb->get_results($sql);
    foreach ($qryOrderData as $valOrder) {
        $order_id = $valOrder->post_id;
        $order = new WC_Order($order_id);
        $current_id = get_current_user_id();
        $order->update_status('failed', 'order_note');
        update_post_meta($order_id, 'failed_updated', true);
        deleteSearchOrder($order_id);
        create_log_entry(__("Project and order deleted by " . $current_id), $order_id);
    }
}

function return_modal_project_content() {

    $project_id = $_POST["project_id"];

    $project = get_post($project_id);

    $current_user_role = get_user_role();
    $current_department = get_field('order_current_department', $project_id);
    $custom_project_number = get_post_meta($project_id, 'custom_project_number')[0];
    ?>
    <input type="hidden" name="quick-project-id" value="<?php echo $project->ID; ?>">
    <input type="hidden" name="imm-sale-order-department" value="<?php echo $current_department; ?>">
    <meta charset="UTF-8">
    <div class="row">
        <div class="col-lg-3 col-sm-3">
            <ul class="list-unstyled top-buffer-half">
                <li>
                    <a href="#" id="toggle-dates"
                       class="btn btn-alpha btn-block top-buffer-half btn-toggle-hover"><?php echo __("Planering"); ?></a>
                </li>

                <li>
                    <a href="#" id="toggle-checklists"
                       class="btn btn-alpha btn-block top-buffer-half btn-toggle-hover"><?php echo __("Uppgifter"); ?></a>
                </li>
                <li>
                    <a href="#" id="toggle-invoices"
                       class="btn btn-alpha btn-block top-buffer-half btn-toggle-hover"><?php echo __("Offerter"); ?></a>
                </li>
                <li>
                    <button type="button"
                            class="btn btn-nova btn-block top-buffer-half toggle-todo-modal"
                            data-project-id="<?php echo $project_id ?>"><?php echo __("Skapa uppgift"); ?>
                    </button>
                </li>
                <li>
                    <a href="<?php echo site_url() . "/select-invoice-type?project-id=" . $project_id ?>"
                       class="btn btn-nova btn-block top-buffer-half"><?php echo __("Skapa offert"); ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-lg-9 col-sm-9">
            <h3><?php echo "Projekt #" . $custom_project_number; ?></h3>
    <?php
    $internal_status = get_post_meta($project->ID, 'internal_project_status')[0];
    $current_customer_id = get_post_meta($project->ID, 'invoice_customer_id')[0];
    ?>
            <hr>

            <ul class="list-inline">
                <li><?php echo getCustomerName($current_customer_id); ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_phone')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_phone_2')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_address_1')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_address_2')[0] ?></li>
                <li><?php echo get_user_meta($current_customer_id, 'billing_postcode')[0] . " " . get_user_meta($current_customer_id, 'billing_city')[0] ?> </li>
                <li>
                    <a href="<?php echo "/customer-edit?customer-id=" . $current_customer_id ?>"><?php echo __("Redigera kunduppgifter") ?></a>
                </li>
            </ul>
            <hr>

    <?php
    $project_status = get_post_meta($project->ID, 'imm-sale-project')[0];
    $office_connection = get_post_meta($project->ID, 'office_connection')[0];
    echo "<h3>" . __("Inställningar för projekt") . "</h3>";
    echo "<h4>" . __("Projektansvarig") . "</h4>";
    echo "<h4>" . __("Projektansvarig") . "</h4>";
    get_salesman_dropdown($project->ID, "order_salesman", null);
    get_office_dropdown("office_connection", null, $office_connection, "top-buffer-half");

    echo "<h4 class='top-buffer-half'>" . __("Projektstatus") . "</h4>";
    get_internal_project_status_dropdown($current_department, "internal_project_status_dropdown_modal", null, null, $internal_status);
    ?>
            <label class="top-buffer-half" for="imm-sale-project"><?php echo __("Projektstatus"); ?></label>
            <select name="imm-sale-project" class="form-control js-sortable-select" id="imm-sale-project">
                <option <?php
            if ($project_status == "project-ongoing") {
                echo " selected";
            }
            ?> value="project-ongoing"><?php echo __("Pågående"); ?></option>
                <option <?php
                if ($project_status == "project-archived") {
                    echo " selected";
                }
                ?> value="project-archived"><?php echo __("Avslutat"); ?></option>
            </select>

                <?php
                get_departments_dropdown("imm-sale-order-department", null, $current_department, false, null, "top-buffer-half");
                ?>
            <label class="top-buffer-half"
                   for="assigned-technician-select"><?php echo __("Ansvarig användare just nu") ?></label>
            <?php
            $args = array(
                'role__in' => array(
                    'sale-administrator',
                    'sale-salesman',
                    'sale-economy',
                    'sale-technician',
                    'sale-project-management',
                    'sale-sub-contractor'
                )
            );
            $users = get_users($args);
            $current_assigned_technician = get_post_meta($project->ID, "assigned-technician-select")[0];
            ?>

            <select class="form-control js-sortable-select" id="assigned-technician-select"
                    name="assigned-technician-select">
                <option value=""><?php echo __("Ingen användare vald"); ?></option>
                   <?php foreach ($users as $user) : ?>
                    <option <?php
               if ($current_assigned_technician == $user->ID) {
                   echo " selected ";
               }
                       ?> value="<?php echo $user->ID ?>"><?php echo getCustomerName($user->ID) . " " . get_user_meta($user->ID, 'sale-sub-contractor_company', true) ?></option>

                <?php endforeach; ?>
            </select>


            <div class="form-group top-buffer-half">
                <label for="project-notes"><?php echo __("Anteckningar för projekt"); ?></label>
                <textarea class="form-control" rows="5" name="project-notes"
                          id="project-notes"><?php echo get_post_meta($project->ID, "project-notes")[0]; ?></textarea>
            </div>
            <hr>
            <div class="top-buffer-half" id="dates">
                <h4><?php echo __("Planering"); ?></h4>
    <?php $planning_type = get_post_meta($project->ID, 'planning-type')[0]; ?>
                <label for="work-date-from"><?php echo __("Välj planeringstyp"); ?></label>
                <select class="form-control js-sortable-select" id="planning-type" name="planning-type">
                    <option <?php
    if ($planning_type == "blue") {
        echo " selected ";
    }
    ?> value="blue">Grov
                    </option>
                    <option <?php
                    if ($planning_type == "orange") {
                        echo " selected ";
                    }
                    ?> value="orange">Preliminär
                    </option>
                    <option <?php
                    if ($planning_type == "green") {
                        echo " selected ";
                    }
                    ?> value="green">Definitiv
                    </option>
                </select>

                <label class="top-buffer-half"
                       for="work-date-from"><?php echo __("Välj aktivitetsdatum fr.o.m") ?></label>
                <input value="<?php echo get_post_meta($project->ID, 'work-date-from')[0]; ?>" name="work-date-from"
                       type='date' class="form-control"/>
                <label class="top-buffer-half" for="work-date-to"><?php echo __("T.o.m") ?></label>
                <input value="<?php echo get_post_meta($project->ID, 'work-date-to')[0]; ?>" name="work-date-to"
                       type='date' class="form-control"/>
                <hr>

            </div>
            <div class="top-buffer-half" id="checklists">
                <h4><?php echo __("Uppgift"); ?></h4>

                <table class="table">
    <?php $table_name = "todo-modal"; ?>
                    <thead>
                        <tr>
                            <th class="sortable"
                                onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Åtgärdsdatumdatum"); ?></th>
                            <th class="sortable"
                                onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Status"); ?></th>

                            <th class="sortable"
                                onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Avdelning") ?></th>
                            <th class="sortable"
                                onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Notering") ?></th>
                        </tr>
                    </thead>
                    <tbody id="<?php echo $table_name ?>">
    <?php
    $args = [
        'posts_per_page' => -1,
        'meta_key' => 'todo_action_date',
        'orderby' => 'meta_value',
        'order' => 'asc',
        'post_type' => 'imm-sale-todo',
        'meta_query' => array(
            array(
                'key' => 'todo_project_connection',
                'value' => $project->ID,
                'compare' => '=',
            )
        )
    ];

    return_todo_table($args, true);
    ?>
                    </tbody>
                </table>
                <hr>
            </div>
            <div class="top-buffer-half" id="invoices">
                <h4><?php echo __("Offerter"); ?></h4>

                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo __("ID"); ?></th>
                            <th><?php echo __("Skapad datum"); ?></th>
                            <th><?php echo __("Typ"); ?></th>
                            <th></th>

                        </tr>
                    </thead>
                    <tbody>
    <?php
    $args = array(
        'orderby' => 'ID',
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => -1,
        'meta_query' => array(
            'relation' => 'LIKE',
            array(
                'key' => 'imm-sale_project_connection',
                'value' => $project->ID,
                'compare' => '='
            )
        )
    );

    $orders = new WP_Query($args);
    while ($orders->have_posts()) :
        $orders->the_post();
        $order = new WC_Order(get_the_ID());

        $project_roles_steps = get_field('project_type-' . $current_user_role, 'option');

        $this_project_type = __("Ej tillgängligt");
        $project_type_id = get_field('order_project_type', $order->ID);
        $custom_order_number = get_post_meta($order->ID, 'custom_order_number')[0];
        ?>
                            <tr>
                                <td><?php echo $custom_order_number; ?></td>
                                <td><?php echo $order->order_date ?></td>
                                <td><?php
                            foreach ($project_roles_steps as $project_type) {
                                if ($project_type_id == $project_type["project_type_id"]) {
                                    $this_project_type = $project_type["project_type_name"];
                                }
                            };
                            echo $this_project_type;
                            ?>
                                </td>
                                <td>
                                    <a href="<?php echo $order->get_id(); ?>" class="btn-settings toggle-settings-modal"
                                       data-order-id="<?php echo $order->get_id(); ?>"><?php echo __("Redigera"); ?>
                                    </a>
                                </td>
        <?php
    endwhile;
    wp_reset_postdata();
    ?>

                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
    <div class="row">

        <div class="col-sm-4 col-sm-push-8">
            <button type="submit" onclick="closeModalAndSendForm();"
                    class="btn btn-brand btn-block top-buffer-half">
    <?php echo __("Spara och uppdatera projekt"); ?>
            </button>
        </div>

    </div>


    <?php
    die;
}

function return_lead_modal_content() {
    $lead_id = $_POST["lead_id"];
    ?>
    <div class="row">
        <div class="col-lg-12">
            <ul class="list-unstyled">
                <li>
    <?php echo "<strong>" . __("Namn: ") . "</strong>" . get_field('lead_first_name', $lead_id); ?>
                </li>
                <li>
    <?php echo "<strong>" . __("E-post: ") . "</strong>" . get_field('lead_email', $lead_id); ?>
                </li>
                <li>
    <?php echo "<strong>" . __("Telefonnummer: ") . "</strong>" . get_field('lead_phone', $lead_id); ?>
                </li>
                <li>
    <?php echo "<strong>" . __("Postort: ") . "</strong>" . get_field('lead_city', $lead_id); ?>
                </li>
                <li>
    <?php echo "<strong>" . __("Övrigt: ") . "</strong>" . get_field('lead_other', $lead_id); ?>
                </li>

            </ul>
            <hr>
            <ul class="list-unstyled">
                <li>
                    <a href="<?php echo site_url(); ?>/new-project?lead-id=<?php echo $lead_id; ?>"
                       class="btn btn-alpha btn-block"><?php echo __("Konvertera lead till projekt") ?></a>
                </li>
                <li>
                    <a href="<?php echo site_url() ?>/new-lead?lead-id=<?php echo $lead_id; ?>"
                       class="btn btn-alpha btn-block top-buffer-half"><?php echo __("Öppna lead") ?></a>
                </li>
                <li>
                    <a href="#" data-lead-id="<?php echo $lead_id; ?>"
                       class="btn btn-alpha btn-block top-buffer-half delete-lead"><?php echo __("Ta bort lead") ?></a>
                </li>
            </ul>
        </div>


    </div>


    <?php
    die;
}

function delete_lead() {
    $lead_id = $_POST["lead_id"];
    wp_delete_post($lead_id, true);
}

function delete_order() {
    $order_id = $_POST["order_id"];
    $order = new WC_Order($order_id);
    $current_id = get_current_user_id();
    $order->update_status('failed', 'only order deleted by' . $current_id); // order note is optional, if you want to  add a note to order
    deleteSearchOrder($order_id);
    create_log_entry(__("only order deleted by " . $current_id), $order_id);
    // update_post_meta($order_id, 'failed_updated', true);
}

function get_projects_for_calendar() {
    $args = [
        'orderby' => 'ID',
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
        'posts_per_page' => -1,
    ];

    $dates = [];

    $orders = new WP_Query($args);
    while ($orders->have_posts()) {
        $orders->the_post();

        $project = new WC_Order(get_the_ID());
        $work_days = [
            'title' => $project->ID . " - Arbetsdatum",
            'start' => get_post_meta($project->ID, 'work-date-from')[0],
            'end' => get_post_meta($project->ID, 'work-date-to')[0],
            'url' => ''
        ];
        array_push($dates, $work_days);
    }

    echo json_encode($dates, JSON_PRETTY_PRINT);

    die;
}

function return_internal_project_status_dropdown() {
    global $roles_order_status;

    $current_user_role = $_POST["current_department"];
    $all = $_POST["all"];
    $return = [];

    if ($all === false) {
        array_push($return, "Alla");
    }

    foreach ($roles_order_status[$current_user_role] as $status) {
        array_push($return, $status["internal_status"]);
    }

    echo json_encode($return);
    die();
}

function return_internal_project_status_and_users_modal_dropdowns() {
    global $roles_order_status;

    $current_user_role = $_POST["current_department"];
    $all = $_POST["all"];

    $return = [];
    $internal_status_array = [];
    if ($all === false) {
        array_push($internal_status_array, "Alla");
    }

    foreach ($roles_order_status[$current_user_role] as $status) {
        array_push($internal_status_array, $status["internal_status"]);
    }
    $return[0] = $internal_status_array;

    $args = array(
        'role__in' => array(
            $current_user_role
        )
    );
    $users = get_users($args);

    $user_array = [];
    array_push($user_array, ["user_id" => "", 'user_display_name' => __("Ingen användare vald")]);
    foreach ($users as $user) {
        $salesman = get_userdata($user->ID);

        $u = ['user_id' => $salesman->ID, 'user_display_name' => getCustomerName($salesman->ID)];
        array_push($user_array, $u);
    }

    $return[1] = $user_array;

    echo json_encode($return);
    die();
}

function sync_to_fortnox() {
    //  include( WP_PLUGIN_DIR.'/woocommerce-fortnox-integration/plugin.php' );
    $order_id = $_POST["order_id"];

    $api = new \src\fortnox\api\WF_Orders();

// include( WP_PLUGIN_DIR . '/custom-functions-plugin/class-wf-order-modify.php' );

    $parentid = $_POST['parent_orderid'];
    $betal_methord = get_post_meta($parentid, 'order_payment_method', true);
    //$api = new Order_Modify();
    $check_fort = explode(' ', get_post_meta($_POST["order_id"], 'invoice_percentage_totalamnt', true));

    $return = $api::sync($order_id, $parentid);

    if ($return == 1) {
        $project_id = get_field('imm-sale_project_connection', $order_id);
        $current_department = get_field('order_current_department', $project_id);
        $current_value = get_post_meta($project_id, "internal_project_status_" . $current_department)[0];

        if ($current_value == 'Att fakturera') {

            $today = date("Y-m-d");
            $todo_action_date = date("Y-m-d", strtotime($today));
            $todo_status = "0";
            $todo_id = '';
            $salesman_id = getuserid($order_id, $project_id, 'saljare_id', 'order_salesman');
            $salesman = get_userdata($salesman_id);
            $salesman_name = getCustomerName($salesman_id);
            create_todo_item($todo_action_date, 0, $project_id, '' . $salesman_name . ' på
avdelningen {earlier_department} flyttade över projekt (' . $project_id . ')', '', $salesman_id, $todo_id);
        }


        if ($check_fort[1] == 'Förskottsfaktura') {
            update_post_meta($_POST["parent_orderid"], 'imm-sale_invoice_create_forts', date('Ymd'));
        } else {
            update_post_meta($_POST["parent_orderid"], 'imm-sale_invoice_create_slutfaktura', date('Ymd'));
        }


        if ($api::order_exists($order_id)) {
            global $wpdb;
            //updateSearchMeta($parentid,'advanced_payment','true');
            $wpdb->update('VQbs2_Projects_Search', array('advanced_payment' => 'true'), array('id' => $parentid));
            if ($check_fort[1] == 'Förskottsfaktura') {
                update_post_meta($_POST["parent_orderid"], 'advance_payment', true);
            } else {
                update_post_meta($_POST["parent_orderid"], 'advance_payment', true);
                update_post_meta($_POST["parent_orderid"], 'final_payment', true);
            }
            if (get_current_user_id() != '328') {
                update_post_meta($order_id, 'order_syn_fortnox', true);


                $to = "ramswiftechies14@gmail.com,jyotiverma1987@gmail.com";
                $message = "https://mariebergsalset.com/project?pid=" . $project_id;
                wp_mail($to, 'fortnox  sync ho gya ' . $order_id, $message);
            }
        } else {
            if (get_current_user_id() != '328') {
                $to = "ramswiftechies14@gmail.com,jyotiverma1987@gmail.com";
                $message = "https://mariebergsalset.com/project?pid=" . $project_id;
                wp_mail($to, 'fortnox sync nhi hoya ' . $order_id, $message);
            } delete_post_meta($order_id, '_fortnox_order_synced', 1);
            $response = array(
                'b' => "wrong"
            );
            echo json_encode($response);
            die;
        }
    }

    create_log_entry(__("customer syn invoice to fortnox " . $order_id), $parentid);
    echo $return;
    die;
}

function update_data() {
    global $wpdb;
    $my_postid = $_POST['id'];
//echo "SELECT * FROM VQbs2_posts  where post_type ='imm-sale-office' and ID='$my_postid'";
    $results = $wpdb->get_results("SELECT * FROM VQbs2_posts  where post_type ='imm-sale-office' and ID='$my_postid'");
    //echo the_content($_POST['id']);
    //print_r($results);

    foreach ($results as $reee) {
        echo $reee->post_content;
    }


    die;
}

function callback_send_email() {
    $orderid = $_POST['projectid'];
    $brandid = $_POST['brandid'];
    if (is_numeric($_POST['officeaddress'])) {
        $officeaddress = get_post_field('post_content', $_POST['officeaddress']);
        $store_title = get_post_field('post_title', $_POST['officeaddress']);

        $newOfficeAddress = "Leverans ska ske till: " . $store_title . " på address: " . $officeaddress;
    } else {
        $getid = explode('-', $_POST['officeaddress']);
        $projectid = get_field('imm-sale_project_connection', $orderid);
        $userid = $getid[1];
        $nameofcustomer = get_user_meta($userid, 'fullname')[0] . ' på address ' . get_user_meta($userid, 'billing_address_1')[0] . " " . get_user_meta($userid, 'billing_address_2')[0] . " " . get_user_meta($userid, 'billing_city')[0] . "" . get_user_meta($userid, 'billing_postcode')[0] . " " . get_user_meta($userid, 'billing_phone')[0];
        $newOfficeAddress = "Leverans ska ske till: " . $nameofcustomer;
        $store_id = get_post_meta($projectid, 'office_connection', true);
        $store_title = get_post_field('post_title', $store_id);
    }


    $order = new WC_Order($orderid);

    $emailidbrand = get_field('order_emailid', 'item_' . $brandid);


    $order_data = return_array_from_json(get_field('orderdata_json', $orderid));
    $filtered_data = [];

    foreach ($order_data as $data) {
        $newcheck = explode('uploads', $data["value"]);
        if (!in_array($data['label'], array('Arbetsorder', 'Information från kund', 'Ersättning enligt överenskommelse'))) {
            if (empty($newcheck[1]) && !empty($data["label"]) && !empty($data["value"])) {

                array_push($filtered_data, array($data['label'], $data['value']));
            }
        }
    }


    $product_data = [];
    foreach ($_POST['orderitemsid'] as $values) {
        $productid = wc_get_order_item_meta($values, '_product_id');

        $products = new WC_Product($productid);

        array_push($product_data, array($products->get_name(), $products->get_sku(), wc_get_order_item_meta($values, '_qty')));
    }
//$newOfficeAddress = "Leverans ska ske till: ".$store_title." på address:".$officeaddress;
    echo json_encode(array('otherinfo' => $filtered_data, 'product_data' => $product_data, 'officeaddress' => $newOfficeAddress, 'supplier_email' => $emailidbrand, 'store_title' => $store_title));
    die;

    //  echo json_encode(array('content'=>$message,'subject'=>$subject,'supplier_email'=>$emailidbrand));


    die;
}

add_action('wp_ajax_previewcallback', 'previewcallback');
add_action('wp_ajax_nopriv_previewcallback', 'previewcallback');

function previewcallback() {
    $orderid = $_POST['orderid'];
    $brandid = $_POST['brandid'];
    $value = get_post_meta($orderid, 'brand_' . $brandid);

    echo json_encode($value);

    die;
}

add_action('wp_ajax_preview_sent', 'preview_sent');
add_action('wp_ajax_nopriv_preview_sent', 'preview_sent');

function preview_sent() {

    $brand_id = $_POST['brand_nameget'];
    $supplier_email = $_POST['supplier_email'];
    $copy_email = $_POST['copy_email'];
    $orderid = $_POST['orderid'];

    $subject = $_POST['user_subject'];
    $project_log = get_post_meta($orderid, 'brand_' . $brand_id, true);
//	$project_log = json_decode(get_post_meta($orderid, 'brand_'.$brand_id)); 

    if (!empty(get_post_meta($orderid, 'brand_' . $brand_id, true))) {

        $full_log = $project_log;
    } else {
        $full_log = array();
    }
    $userid = get_current_user_id();
    $user_info = get_userdata($userid);
    $email = $user_info->user_email;
    $new_log_entry = array(
        'timestamp' => time(),
        'subject' => $subject,
        'user_id' => $userid,
        'cc' => $copy_email,
        'supplier_email' => $_POST['supplier_email'],
        'otherinforadd' => $_POST['otherinforadd'],
        'product_data' => $_POST['product_data'],
        'newblock' => $_POST['newblock'],
        'address' => $_POST['address'],
    );

    array_push($full_log, $new_log_entry);
    $message = $_POST['body'];

    $headers[] = 'MIME-Version: 1.0' . "\r\n";
    $headers[] = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers[] = 'From: Mariebergs <' . $email . '>';
    if (!empty($copy_email)) {
        $headers[] = 'Cc: ' . $copy_email;
    }

    $headers[] = "Content-Type: text/html; charset=UTF-8";

    $sent = wp_mail($_POST['supplier_email'], $subject, $message, $headers);

    if ($sent) {

        update_post_meta($orderid, 'brand_' . $brand_id, $full_log);
    } else {
        echo "not nt mail";
    } die;
}

function call_meta() {

    $project_type_id = $_POST["pid"];


    update_post_meta($project_type_id, 'type_of_service', $_POST["typeservices"]);

    update_post_meta($project_type_id, 'beskrivning', $_POST["beskrivning"]);
    die();
}

include('project_log.php');
include('custom_function.php');
include('todo_ajax.php');
include('todo_ajax_actions.php');

function get_payment_term($arg) {
    $val_1 = '0';
    $val_2 = '10';
    $val_3 = '15';
    $val_4 = '20';
    $val_5 = '30';
    $val_6 = 'AG';
    $val_7 = 'K';
    $val_8 = 'PF';
    $betal_array = array($val_1 => '0 dagar', $val_2 => '10 dagar', $val_3 => '15 dagar', $val_4 => '20 dagar', $val_5 => '30 dagar', $val_6 => 'Autogiro', $val_7 => 'Kontant', $val_8 => 'Postförskott');
    return $betal_array[$arg];
}

function getUserFromProject($id) {
    $projectid = get_post_meta($id, 'imm-sale_project_connection', true);
    return get_post_meta($projectid, 'invoice_customer_id', true);
}

//$url="https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//if($url === 'https://mariebergsalset.com/system-dashboard'){

//}
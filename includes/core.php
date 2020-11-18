<?php
/**
 * Core functions for the plugin
 * TODO: Structure code and divide into multiple files. Move and refactor functions that is not related to the 'core' of the plugin.
 */
// Add new status
// Add new menu
add_action('admin_menu', 'sales_add_pages');

function sales_add_pages() {

    //add_menu_page( 'Sales Overview', 'Säljsystem', 'manage_options', 'sales-startpoint', 'sales_overview_page', SALES_PATH . 'images/imm-logo.png' );
    //add_submenu_page( 'sales-startpoint', 'page-title', 'Inställningar', 'manage_options', 'sales-settings-page', 'sales_settings_page' );
    //Add page in the WP "Settings" tab for plugin settings
    add_options_page('Inställningar', 'Säljsystem', 'manage_options', 'sale-settings', 'plugin_options_frontpage');
}

add_action('wp_enqueue_scripts', 'imm_sale_resources');

function imm_sale_resources() {
//echo plugins_url('js/moment.js', __FILE__);

    /*   wp_register_style('sales_css', plugins_url('../css/style.css', __FILE__), false, '1.0.0', 'all');
      wp_enqueue_style('sales_css'); */

    wp_register_style('reset_css', plugins_url('../css/reset.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('reset_css');

    wp_register_style('layout_css', plugins_url('../css/layout.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('layout_css');

    wp_register_style('buttons_css', plugins_url('../css/buttons.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('buttons_css');

    wp_register_style('forms_css', plugins_url('../css/forms.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('forms_css');

    wp_register_style('helpers_css', plugins_url('../css/helpers.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('helpers_css');

    wp_register_style('lists_css', plugins_url('../css/lists.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('lists_css');

    wp_register_style('objects_css', plugins_url('../css/objects.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('objects_css');

    wp_register_style('fullcalendar_css', plugins_url('../css/fullcalendar.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('fullcalendar_css');

    wp_register_style('variables_css', plugins_url('../custom-css/variables.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('variables_css');


    wp_register_script('bootstrap_color_picker_js', plugins_url('../js/bootstrap-colorpicker.js', __FILE__), array('jquery'), '2.5.1');
    wp_enqueue_script('bootstrap_color_picker_js');

    wp_register_style('bootstrap_color_picker_css', plugins_url('../css/bootstrap-colorpicker.css', __FILE__), false, '1.0.0', 'all');
    wp_enqueue_style('bootstrap_color_picker_css');

    wp_register_script('select_2_js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', 50, array('jquery'), '2.5.1');
    wp_enqueue_script('select_2_js');

    wp_register_style('select_2_css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css', 50);
    wp_enqueue_style('select_2_css');

wp_register_script('sort_order', 'https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', 60, array('jquery'));
    wp_enqueue_script('sort_order');
 wp_register_style('css_base', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', 50);
    wp_enqueue_style('css_base');
    // Bootstrap CSS
    wp_register_style('css_bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', 50);
    wp_enqueue_style('css_bootstrap');

    wp_register_style('css_bootstrap_select_2', 'https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css', 50);
    wp_enqueue_style('css_bootstrap_select_2');


    wp_register_script('moment_js', plugins_url('../js/moment.js', __FILE__));
    wp_enqueue_script('moment_js');

    wp_register_style('fullcalendar', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css', 50);
    wp_enqueue_style('fullcalendar');

    wp_register_style('fullcalendar_sc', plugins_url('../css/scheduler.css', __FILE__));
    wp_enqueue_style('fullcalendar_sc');

    wp_register_script('js_fullcalendar', 'https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js');
    wp_enqueue_script('js_fullcalendar');

    wp_register_script('js_fullcalendar_sc', plugins_url('../js/scheduler.js', __FILE__), array('jquery'), '2.5.1');
    wp_enqueue_script('js_fullcalendar_sc');

    wp_register_script('sv', plugins_url('../js/sv.js', __FILE__));
    wp_enqueue_script('sv');
    //LoadingOverlay
    wp_enqueue_script('LoadingOverlay', plugins_url('../assets/loadingOverlay/loadingoverlay.min.js', __FILE__), false, null);

    wp_register_script('sales_js', plugins_url('../js/sales_js.js', __FILE__), array('jquery'), '2.5.1');
    wp_enqueue_script('sales_js');

    wp_register_script('ajax_js', plugins_url('../js/sales_ajax.js', __FILE__), array('jquery'), '2.5.1');
    wp_enqueue_script('ajax_js');
    
    wp_register_script('todo_js', plugins_url('../js/todo.js', __FILE__), array('jquery'), '2.5.1');
    wp_enqueue_script('todo_js');
    //optionspicker
    wp_register_style('optionspicker_css', plugins_url('../assets/selectoption_picker/select2OptionPicker.css', __FILE__));
    wp_enqueue_style('optionspicker_css');

    wp_register_script('optionspicker_js', plugins_url('../assets/selectoption_picker/jQuery.select2OptionPicker.js', __FILE__), false, null);
    wp_enqueue_script('optionspicker_js');
}

//Add overview page
function sales_overview_page() {
    $html = "<div class='col-lg-12'>";

    $html .= "<h2>" . __("Översikt") . "</h2>";
    $html .= "</div>";

    echo $html;
    exit;
}

function redirect_on_login($redirect_to, $request, $user) {
    //is there a user to check?
    if (isset($user->roles) && is_array($user->roles)) {
        //check for admins
        $office_connection = get_field('office_connection', 'user_' . $user->ID);
        setcookie('office_connection', $office_connection[0], time() + (86400 * 30), "/");
        if (!in_array('administrator', $user->roles)) {
            // redirect them to the default place
            $role_name = $user->roles[0];
            $redirects = get_redirects($role_name);
            foreach ($redirects as $redirect) {
                if (strtolower($role_name) == strtolower($redirect["user_role"])) {
                    $redirect_to = $redirect["redirect_url"];
                }
            }
        }
    }

    return $redirect_to;
}

add_filter('login_redirect', 'redirect_on_login', 10, 3);

//Return all the redirect url's from settings.
function get_redirects($current_role) {

    global $wp_roles;
    $custom_roles = [
        'sale-administrator',
        'sale-salesman',
        'sale-economy',
        'sale-project-management',
        'sale-technician',
        'sale-sub-contractor'
    ];
    $redirects = [];
    foreach ($wp_roles->roles as $editable_role) {
        if (in_array($current_role, $custom_roles)) {
            $the_redirect = home_url() . '/system-dashboard';
        }

        $key = array_search($editable_role["name"], $wp_roles->role_names);

        array_push($redirects, ['user_role' => $key, 'redirect_url' => $the_redirect]);
    }

    return $redirects;
}

/*
 * Display the custom logo on the login screen.
 */

function sales_custom_logo() {
    $logotype_url = get_option('logotype_image_url');
    $main_color = get_option('main_color');

    echo "<style type=\"text/css\">
		#login h1 a, .login h1 a {
			background-image: url( " . $logotype_url . ");
            height: 100px;
            width: 100%;
            background-size: 70%;
            background-repeat: no-repeat;
		}

        #wp-submit{
            background-color: " . $main_color . ";
            width: 100%;
            margin-top: 10px;
            box-shadow: none;
            border: 1px solid rgba(0, 0, 0, 0.08);
            height: 38px;
            text-shadow: 0 -1px 1px #9C9C9C, 1px 0 1px #9C9C9C, 0 1px 1px #9C9C9C, -1px 0 1px #9C9C9C;
        }
	</style>";
}

add_action('login_enqueue_scripts', 'sales_custom_logo', 35);

/*
 * Get all the options in a specific custom group by name
 */

function get_all_options_in_gropup($group_name) {
    global $new_whitelist_options;
    $a = [];
    $option_names = $new_whitelist_options[$group_name];

    foreach ($option_names as $option_name) {
        array_push($a, ['option_name' => $option_name, 'option_value' => get_option($option_name)]);
    }

    return $a;
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return $item;
        }
    }

    return false;
}

function get_user_role() {
    global $current_user;

    $user_roles = $current_user->roles;
    $user_role = array_shift($user_roles);

    return $user_role;
}

function get_order_for_current_salesman($salesman_id) {
    // Get all customer orders
    $customer_orders = get_posts(array(
        'numberposts' => -1,
        'meta_key' => 'order_salesman',
        'meta_value' => $salesman_id,
        'post_type' => wc_get_order_types(),
        'post_status' => array_keys(wc_get_order_statuses()),
    ));

    return $customer_orders;
}

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

function register_all_custom_status_for_imm_sale() {

    if (have_rows('custom_order_status', 'option')) {
        while (have_rows('custom_order_status', 'option')) {
            the_row();

            register_post_status(get_sub_field('order_status_id'), array(
                'label' => get_sub_field('order_status_name'),
                'public' => true,
                'exclude_from_search' => false,
                'show_in_admin_all_list' => true,
                'show_in_admin_status_list' => true,
                'label_count' => _n_noop(get_sub_field('order_status_name') . '<span class="count">(%s)</span>', get_sub_field('order_status_name') . '<span class="count">(%s)</span>')
            ));
        }
    }
}

//add_action('init', 'register_all_custom_status_for_imm_sale');

// Add to list of WC Order statuses
function add_all_custom_status_for_imm_sale($order_statuses) {
    if (have_rows('custom_order_status', 'option')) {

        $new_order_statuses = array();

        // add new order status after processing
        foreach ($order_statuses as $key => $status) {

            $new_order_statuses[$key] = $status;

            while (have_rows('custom_order_status', 'option')) {
                the_row();

                if ('wc-processing' === $key) {
                    $new_order_statuses[get_sub_field('order_status_id')] = get_sub_field('order_status_name');
                }
            }
        }

        return $new_order_statuses;
    }
}

//add_filter( 'wc_order_statuses', 'add_all_custom_status_for_imm_sale' );

add_action('template_redirect', 'summary_template_redirect');

function summary_template_redirect() {
    if (strpos($_SERVER['REQUEST_URI'], '/order-summary-technical') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/order-summary-technical.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/order-summary-economy') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/order-summary-economy.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/order-summary') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/order-summary.php');
        exit();
    }
	 if (strpos($_SERVER['REQUEST_URI'], '/order-design') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200); 
        include(dirname(__FILE__) . '/templates/order-design.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/new-project') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/new-project.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/select-invoice-type') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/select-invoice-type.php');
        exit();
    }
		if (strpos($_SERVER['REQUEST_URI'], '/adminside') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/adminside.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/order-steps') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/order-steps.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/system-dashboard') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/system-dashboard.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/customer-register') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/customer-register.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/customer-edit') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/customer-edit.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/sub-contractor-register') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/sub-contractor-register.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/sub-contractor-edit') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/sub-contractor-edit.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/new-lead') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/create-lead.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/articlar') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/articlar.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/brand-register') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/brand-register.php');
        exit();
    }
	if (strpos($_SERVER['REQUEST_URI'], '/meraview') !== false) {
		echo "asdasd";
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/project-single_new.php');
        exit();
    }
    if (strpos($_SERVER['REQUEST_URI'], '/project') !== false) {
        global $wp_query;
        $wp_query->is_404 = false;
        status_header(200);
        include(dirname(__FILE__) . '/templates/project-single.php');
        exit();
    }

}

function return_current_url() {
    $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    return $actual_link;
}

function viewport_meta() {

    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\">";
}

add_filter('wp_head', 'viewport_meta');

// Bootstrap pagination function

function wp_bs_pagination($pages = '', $range = 4) {

    $showitems = ($range * 2) + 1;


    global $paged;

    if (empty($paged)) {
        $paged = 1;
    }


    if ($pages == '') {

        global $wp_query;

        $pages = $wp_query->max_num_pages;

        if (!$pages) {

            $pages = 1;
        }
    }


    if (1 != $pages) {

        echo '<div class="text-center">';
        echo '<nav><ul class="pagination"><li class="disabled hidden-xs"><span><span aria-hidden="true">Page ' . $paged . ' of ' . $pages . '</span></span></li>';

        if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
            echo "<li><a href='" . get_pagenum_link(1) . "' aria-label='First'>&laquo;<span class='hidden-xs'> First</span></a></li>";
        }

        if ($paged > 1 && $showitems < $pages) {
            echo "<li><a href='" . get_pagenum_link($paged - 1) . "' aria-label='Previous'>&lsaquo;<span class='hidden-xs'> Previous</span></a></li>";
        }


        for ($i = 1; $i <= $pages; $i++) {

            if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {

                echo ($paged == $i) ? "<li class=\"active\"><span>" . $i . " <span class=\"sr-only\">(current)</span></span>
 
    </li>" : "<li><a href='" . get_pagenum_link($i) . "'>" . $i . "</a></li>";
            }
        }


        if ($paged < $pages && $showitems < $pages) {
            echo "<li><a href=\"" . get_pagenum_link($paged + 1) . "\"  aria-label='Next'><span class='hidden-xs'>Next </span>&rsaquo;</a></li>";
        }

        if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) {
            echo "<li><a href='" . get_pagenum_link($pages) . "' aria-label='Last'><span class='hidden-xs'>Last </span>&raquo;</a></li>";
        }

        echo "</ul></nav>";
        echo "</div>";
    }
}

function return_orders_table($args) {

    $orders = new WP_Query($args);
    while ($orders->have_posts()) : $orders->the_post();
        $order = new WC_Order(get_the_ID());
        $salesman_id = get_post_meta($order->get_id(), 'order_salesman');
        $salesman = get_userdata($salesman_id[0]);
        $order_accept = get_post_meta($order->get_id(), "order_accept_status")[0];
        $project_type_id = get_field('order_project_type', $order->ID);
        $this_project_type = __("Ej tillgängligt");
        $current_user_role = get_user_role();
        $project_roles_steps = get_field('project_type-' . $current_user_role, 'option');

        $internal_status = get_post_meta($order->ID, 'internal_project_status')[0];

        foreach ($project_roles_steps as $project_type) {
            if ($project_type_id == $project_type["project_type_id"]) {
                $this_project_type = $project_type["project_type_name"];
            }
        };
        ?>


        <tr>
            <td><?php echo $order->get_id(); ?></td>
            <td><?php echo $internal_status; ?></td>
            <td><?php echo $order->get_billing_first_name() . " " . $order->get_billing_last_name(); ?></td>
            <td><?php echo $salesman->user_email; ?></td>
            <td><?php echo $this_project_type; ?></td>
            <td><?php
                $current_department_fields = get_field_object('order_current_department');
                $current_department = get_field('order_current_department', $order->get_id());
                echo $current_department_fields["choices"][$current_department];
                ?></td>
            <td class="text-center"> <?php $project_id = get_field('order_project_type', $order->get_id()); ?>
                <ul class="list-inline">
                    <li>
                        <a href="<?php echo $order->ID ?>" type="button" class="btn-settings toggle-settings-modal"
                           data-order-id="<?php echo $order->ID ?>"><img
                                src="<?php echo SALES_PATH . 'images/pen-on-square-of-paper-interface-symbol.png' ?>"
                                alt="">
                        </a>
                    </li>

                </ul>
            </td>
        </tr>
        <?php
    endwhile;
}

function return_web_orders_table($orders) {

    while ($orders->have_posts()) :
        $orders->the_post();
        $order = new WC_Order(get_the_ID());
        $order_statuses = wc_get_order_statuses();
        ?>


        <tr class="clickable ">
            <td><?php echo get_the_ID(); ?></td>
            <td><?php echo $order->order_date; ?></td>
            <td><?php echo $order->get_billing_first_name() . " " . $order->get_billing_last_name(); ?></td>
            <td><?php echo $order->get_billing_address_1() . " " . $order->get_billing_address_2() . ", " . $order->get_billing_postcode() . " " . $order->get_billing_city(); ?></td>
            <td><?php echo $order_statuses["wc-" . $order->get_status()]; ?></td>
            <td><?php echo wc_price($order->get_total()); ?></td>
            <td>
                <a href="<?php echo site_url(); ?>/wp-admin/post.php?post=<?php echo $order->ID; ?>&action=edit"><?php echo __("Till order"); ?></a>
            </td>


        </tr>


        <?php
    endwhile;
}

function get_project_name($key) {
    $getvalue = array('hem_visit_sale_system' => 'Hembesök', 'fireplace_with_assembly' => 'Eldstad inklusive montage', 'service' => 'Service', "accesories" => 'Kassa', "changes_and_new_work" => "ÄTA", "self_builder" => "Självbyggare", "hansa_offert_for_old_offert" => "Hansa Offert");

    return $getvalue[$key];
}
function get_status_orderValue($selectid=false) {
	
    $orderstatus_search = array(1 => 'Order bekräftad', 2 => 'Nekad av kund', 0 => 'Väntar svar', 4 => 'Accepterad av kund', 5 => 'Kund har frågor', 6 => 'Arkiverad kopia');
    // $get_status = array('' => 'Väntar svar', 'true' => 'Order bekräftad', 'false' => 'Nekad av kund', 'Kundfråga' => 'Kund har frågor', 'archieved' => 'Arkiverad kopia', 'Acceptavkund' => 'Accepterad av kund');
    $html = "";
    $html .= "<label  class='top-buffer-half' for='order_statusid'>" . __("Status") . "</label>";
    $html .= "<select name='order_statusid' data-project_status='order_statusid'  data-table_name='all-table' class='js-sortable-select form-control ".$selectid."'
                      id='order_statusid'>";
    $html .= "
        <option value='Alla'>" . __("Alla") . "</option>
        ";


    foreach ($orderstatus_search as $key => $value) {
        if (empty($key))
            $checkkey = "";
        else
            $checkkey = $key;

        $html .= "<option value='" . $checkkey . "'>" . $value . "</option>";
    }


    $html .= "</select>";

    echo $html;
}
function get_status_order() {
    $get_status = array('' => 'Väntar svar', 'true' => 'Order bekräftad', 'false' => 'Nekad av kund', 'Kundfråga' => 'Kund har frågor', 'archieved' => 'Arkiverad kopia', 'Acceptavkund' => 'Accepterad av kund');
    $html = "";
    $html .= "<label  class='top-buffer-half' for='order_statusid'>" . __("Status") . "</label>";
    $html .= "<select name='order_statusid' data-project_status='order_statusid'  data-table_name='all-table' class='js-sortable-select form-control filter_project_tab'
                      id='order_statusid'>";
    $html .= "
        <option value='Alla'>" . __("Alla") . "</option>
        ";


    foreach ($get_status as $key => $value) {
        if (empty($key))
            $checkkey = "";
        else
            $checkkey = $key;

        $html .= "<option value='" . $checkkey . "'>" . $value . "</option>";
    }


    $html .= "</select>";

    echo $html;
}

function return_projects_table($args, $current_department = false, $projectType = false) {

    $projects = new WP_Query($args);
    $i = 1;

    while ($projects->have_posts()) : $projects->the_post();
        $Orderargs = array(
            'orderby' => 'ID',
            'post_type' => 'shop_order',
            'post_status' => array_keys(wc_get_order_statuses()),
            'posts_per_page' => 10,
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'imm-sale_project_connection',
                    'value' => get_the_ID(),
                    'compare' => '='
                )
            )
        );

        $myposts = get_posts($Orderargs);
        foreach ($myposts as $post) : setup_postdata($post);
            $ordid = $post->ID;
        endforeach;


        $project_types = get_post_meta($ordid, 'order_project_type', true);
        if ($projectType != 'Alla' && $projectType === $project_types) {
            $varr = 1;
        } else {
            $varr = 2;
        }
        $order = new WC_Order($ordid);
        if ($varr === 1 || $projectType === 'Alla' || empty($projectType)) {

            $customer_id = get_post_meta(get_the_ID(), 'invoice_customer_id');
            $customer = get_userdata($customer_id[0]);

            $current_department_fields = get_field_object('order_current_department');
            $current_department = get_field('order_current_department', get_the_ID());

            $internal_status = get_post_meta(get_the_ID(), 'internal_project_status_' . $current_department, true);
            $custom_project_number = $customer_id[0] . "-" . get_the_ID() . "-" . $ordid;


            $butik = get_field('office_connection', get_the_ID());
            //  $butik_namn = get_the_title($butik);
            $projuct_status = get_field('imm-sale-project', get_the_ID());


            if ($projuct_status === 'project-ongoing') {
                $projuct_status_value = 'Pågående';
            } elseif ($projuct_status === 'project-archived') {
                $projuct_status_value = 'Avslutade';
            }


            if (empty(get_post_meta(get_the_ID(), 'order_salesman', true))) {
                $salesman_id = get_post_meta($ordid, 'saljare_id', true);
            } else {
                $salesman_id = get_post_meta(get_the_ID(), 'order_salesman', true);
            }
            $salesman = get_userdata($salesman_id);
            
            //get_field('order_current_department', get_the_ID());
            // $ordid=get_field('parent_order_id_project', get_the_ID());
            ?>


            <tr class="clickable <?php echo $custom_project_number; ?>"  > 
                <td><?php
                    echo $i;
                    ?></td>
                <td class='custmnewtab' nowrap><a target="_new" href="/project?pid=<?php echo get_the_ID(); ?>"><?php echo $custom_project_number; ?>
                    </a></td> 


                <td><?php
                    $postId = get_the_ID();
                    echo get_the_date('j F Y h:i:s A', $postId);
                    ?>
                </td>
                <td><?php
                    echo $current_department_fields["choices"][$current_department];
                    //echo $internal_status;
                    ?>
                </td>
                <td><?php echo $projuct_status_value; ?></td>
                <td><?php !empty($butik) ? get_the_title($butik) : '' ?></td>
                <td>
                    <a target="_new" href="/project?pid=<?php echo get_the_ID(); ?>"><?php
                        echo getCustomerName($customer->ID);
                        ?></a>
                </td>
                <td>

                    <?php
                    echo getCustomerName($salesman_id);
                    ?></td>


                <td class='total-price'nowrap><?php echo wc_price($order->get_total()); ?></td>
                <td class='total-price'nowrap><?php echo $internal_status; ?></td>
                <td><?php
                    $status = get_field('order_accept_status', $ordid);
                    if ($status === 'true') {
                        echo 'Accepterat';
                    } else if ($status === 'false') {
                        echo 'Nekats';
                    } else if ($status === 'Kundfråga') {
                        echo 'Kundfråga';
                    } else {
                        echo 'Väntar';
                    }
                    ?></td>
                <td><?php echo get_project_name($project_types); ?></td>

            </tr>


            <?php
            $i++;
            $ordid = '';
        }

    endwhile;
}

function return_orders_for_customer_table($args) {
    $orders = new WP_Query($args);
    while ($orders->have_posts()) : $orders->the_post();
        $order = new WC_Order(get_the_ID());

        $salesman_id = get_post_meta($order->get_id(), 'order_salesman');
            $todo_project_connection = get_post_meta($order->get_id(), 'imm-sale_project_connection');
            $project_type = get_post_meta($order->get_id(), 'order_project_type');
        $project_status = get_post_meta($todo_project_connection[0], 'imm-sale-project')[0];

        if($project_status == "project-ongoing") {
            $projectstatus = 'Pågående';
        } elseif($project_status == "project-archived") {
            $projectstatus = 'Avslutat';
        }
//            echo $project_type[0];
        if ($project_type[0] == 'fireplace_with_assembly') {
            $project_name = 'Eldstad inklusive montage';
        } elseif ($project_type[0] == 'hem_visit_sale_system') {
            $project_name = 'Hembesök';
        } elseif ($project_type[0] == 'service') {
            $project_name = 'Service och reservdelar';
        } elseif ($project_type[0] == 'accesories') {
            $project_name = 'Kassa';
        } elseif ($project_type[0] == 'changes_and_new_work') {
            $project_name = 'ÄTA';
        } elseif ($project_type[0] == 'self_builder') {
            $project_name = 'Självbyggare';
        } elseif ($project_type[0] == 'hansa_offert_for_old_offert') {
            $project_name = 'Specialoffert';
        } elseif ($project_type[0] == 'solcellspaket') {
            $project_name = 'Solcellspaket';
        }
        $salesman = get_userdata($salesman_id[0]);
        $varOrderdate = $order->order_date;
        $orderdate = date('d-m-Y', strtotime($varOrderdate));
        ?>

        <tr>
        <?php if (!empty($todo_project_connection[0])) { ?>
                <td><?php echo $todo_project_connection[0] . '-' . $order->get_id(); ?></td>
                <td><?php echo $orderdate; ?></td>
                <td><?php echo $project_name; ?></td>
                <td><?php echo $salesman->user_email; ?></td>
                <td><?php
                    $current_department_fields = get_field_object('order_current_department');
                    $current_department = get_field('order_current_department', $order->get_id());
                    echo $projectstatus;
                    ?></td>
                <td class="text-center"> <?php $project_id = get_field('order_project_type', $order->get_id()); ?>
                    <ul class="list-inline">

                        <li><a class="btn-settings"
                               href="/project?pid=<?php echo $todo_project_connection[0]; ?>">
                                <img src="<?php echo SALES_PATH . 'images/pen-on-square-of-paper-interface-symbol.png' ?>"
                                     alt="">
                            </a>
                        </li>
                    </ul>
                </td> 
        <?php } ?>
        </tr>
        <?php
    endwhile;
}

function return_leads_table($args) {
    $leads = new WP_Query($args);

    while ($leads->have_posts()) : $leads->the_post();
//    echo get_field('lead_salesman');
        if (get_field('lead_salesman') == 'ingen') {
            $salesman_name = 'ingen';
        } else {
            $salesman = get_userdata(get_field('lead_salesman'));
//        print_r($salesman);
            
            $name = getCustomerName(get_field('lead_salesman'));
            if (!empty($name)) {
                $salesman_name = $name;
            } else {
                $salesman_name = $salesman->user_login;
            }
        }
        ?>
        <tr>
            <td><?php echo get_the_date('Y-m-d H:i:s') ?></td>
            <td><?php echo $salesman_name; ?></td>
            <td><?php echo get_field('lead_first_name') ?></td>
            <!--<td><?php // echo get_field('lead_last_name') ?></td>-->
            <td><?php echo get_field('lead_city') ?></td>
            <td><?php echo get_field('lead_postnummer') ?></td>
            <td><?php echo get_field('lead_typavlead') ?></td>
            <td><?php echo get_field('lead_email') ?></td>
            <td><?php echo get_field('lead_phone') ?></td>
            <td class="text-center ">

                <a href="#" class="btn-settings toggle-lead-modal"
                   data-lead-id="<?php the_ID(); ?>"><?php echo __("Öppna"); ?>
                </a>

            </td>
        </tr>
        <?php
    endwhile;
}

   function get_departments_dropdownValue($dropdown_id, $data_table = null, $current_department = null, $show_all_option = true, $project_status = null, $label_class = null, $select_class = null) {
				$department_search = array(1=>"Administratör",2=>"Sälj",3=>"Ekonomi",4=>"Projektplanering",5=>"Tekniker",6=>"Underentreprenör");
                   $html = "";
                   $html .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Ansvarig avdelning just nu") . "</label>";
                   $html .= "<select name='" . $dropdown_id . "'data-project_status='" . $project_status . "' data-table_name='" . $data_table . "' class='form-control js-sortable-select $select_class'
                      id='" . $dropdown_id . "'>";
                /*    $department = array('sale-administrator' => 'Sälj administrator', 'sale-salesman' => 'Sälj', 'sale-economy' => 'Ekonomi', 'sale-project-management' => 'Projektplanering', 'sale-technician' => 'Tekniker', 'sale-sub-contractor' => 'Underentreprenör'); */
                   if ($show_all_option) {
                       $html .= "
        <option value='alla'>" . __('Alla') . "</option>
        ";
                   }
                   foreach ($department_search as $key => $value) {
                       if ($key == $current_department)
                           $selected = "selected";
                       else
                           $selected = "";
                       $html .= "
        <option " . $selected . " value='" . $key . "'>" . __($value) . "</option>
        ";
                   }


                   $html .= "</select>";

                   echo $html;
               }
function get_departments_dropdown($dropdown_id, $data_table = null, $current_department = null, $show_all_option = true, $project_status = null, $label_class = null, $select_class = null) {
    $html = "";
    $html .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Ansvarig avdelning just nu") . "</label>";
    $html .= "<select name='" . $dropdown_id . "'data-project_status='" . $project_status . "' data-table_name='" . $data_table . "' class='form-control js-sortable-select $select_class'
                      id='" . $dropdown_id . "'>";
    $current_user_role = get_user_role();
    if ($current_user_role != 'sale-sub-contractor'){
    $department = array('sale-administrator' => 'Administratör', 'sale-salesman' => 'Sälj', 'sale-economy' => 'Ekonomi', 'sale-project-management' => 'Projektplanering', 'sale-technician' => 'Tekniker', 'sale-sub-contractor' => 'Underentreprenör');
    }else{
        if($dropdown_id=='imm-sale-order-department'){
        $department = array('sale-sub-contractor' => 'Underentreprenör', 'sale-economy' => 'Ekonomi', 'sale-project-management' => 'Projektplanering');
        }else{
            $department = array('sale-sub-contractor' => 'Underentreprenör');
        }
    }
    if ($current_user_role != 'sale-sub-contractor'){
    if ($show_all_option) {
        $html .= "
        <option value='alla'>" . __('Alla') . "</option>
        ";
    }
    }
    foreach ($department as $key => $value) {
        if ($key == $current_department)
            $selected = "selected";
        else
            $selected = "";
        $html .= "
        <option " . $selected . " value='" . $key . "'>" . __($value) . "</option>
        ";
    }


    $html .= "</select>";

    echo $html;
}

function get_order_by_city_dropdown($dropdown_id, $data_table = null, $current_department = null, $project_status = null, $label_class = null) {


    $html = "";
    $html .= "<label  class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Ort") . "</label>";
    $html .= "<select name='" . $dropdown_id . "'data-project_status='" . $project_status . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control'
                      id='" . $dropdown_id . "'>";
    $html .= "
        <option value=''>" . __("Alla orter") . "</option>
        ";

    $cities = return_order_cities();
    foreach ($cities as $city) {
        $html .= "
        <option value='" . $city . "'>" . $city . "</option>
        ";
    }


    $html .= "</select>";

    echo $html;
}

function get_office_dropdown($dropdown_id, $data_table = null, $current_office = null, $label_class = null, $dropdown_class = null) {


    $html = "";
    $html .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Butik") . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control $dropdown_class'
                      id='" . $dropdown_id . "'>";
    $html .= "
        <option value='" . $dropdown_id . "'>" . __("Alla butiker") . "</option>
        ";
    $args = [
        'post_type' => 'imm-sale-office',
        'posts_per_page' => -1,
    ];
    $offices = new WP_Query($args);

    while ($offices->have_posts()) {
        $offices->the_post();

        $selected = "";
        $office_connection = get_the_ID();

        if ($office_connection == $current_office) {
            $selected = " selected ";
        }

        $html .= "
        <option" . $selected . "  value='" . $office_connection . "'>" . get_the_title() . "</option>
        ";
    }


    $html .= "</select>";
    wp_reset_query();
    echo $html;
}

function get_my_or_all_dropdown($dropdown_id, $current_user_id, $data_table = null, $label_class = null, $select_class) {
     $current_user_role = get_user_role();
    if ($current_user_role == 'sale-sub-contractor') {
        $args = array(
            'role__in' => array(
                'sale-sub-contractor'
            )
        );
    } else {
    $args = array(
        'role__in' => array(
            'sale-salesman',
            'sale-administrator',
            'sale-economy',
            'sale-technician',
            'sale-project-management',
            'sale-sub-contractor'
        )
    );
    }
    $users = get_users($args);
    
    if($dropdown_id=='col8_filter'){
    
}else{
    if ($select_class == 'filter_project_tab' || $select_class == 'filter_project_tab1') {
        $name = 'Säljare';
    } else {
        $name = 'Avsändare';
    }
}

    $html = "";
    $html .= "<label class='" . $label_class . "	' for='" . $dropdown_id . "'>" . $name . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control $select_class'
                      id='" . $dropdown_id . "'>";
    $html .= "
        <option  value='alla'  data_val='alla' >" . __("Alla") . "</option>
        
        ";
    foreach ($users as $user) {
        $salesman = get_userdata($user->ID);

        if ($current_user_id == $user->ID) {
            $selected = " selected ";
        } else {
            $selected = "";
        }
        $html .= "
        <option value='" . $salesman->ID . "' " . $selected . " data_val='mina' data_roll='" . implode(', ', $salesman->roles) . "' >" . showName($salesman->ID) . "</option>
        ";
    }






    $html .= "</select>";
    echo $html;
}

function get_assigned_user_mottagare($dropdown_id, $current_user_id, $data_table = null, $label_class = null, $select_class) {
    $current_user_role = get_user_role();
    if ($current_user_role == 'sale-sub-contractor') {
        $args = array(
            'role__in' => array(
                'sale-sub-contractor'
            )
        );
    } else {
    $args = array(
        'role__in' => array(
            'sale-salesman',
            'sale-administrator',
            'sale-economy',
            'sale-technician',
            'sale-project-management',
            'sale-sub-contractor'
        )
    );
    }
    $users = get_users($args);


    $html = "";
    $html .= "<label class='" . $label_class . "	' for='" . $dropdown_id . "'>" . __("Mottagare") . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control $select_class'
                      id='" . $dropdown_id . "'>";
    $html .= "
        <option  value='alla'  data_val='alla' selected>" . __("Alla") . "</option>
        
        ";
    if ($current_user_role == 'sale-sub-contractor') {
               $curren_user_id = get_current_user_id();
               foreach ($users as $user) {
        $salesman = get_userdata($user->ID);
        
        

        if ($current_user_id == $user->ID) {
            $selected = " selected ";
        } else {
            $selected = "";
        }
        
        $current_user_company_name = get_user_meta($curren_user_id, 'sale-sub-contractor_company', true);
            $comapny_name = get_user_meta($user->ID, 'sale-sub-contractor_company', true);
            if ($current_user_company_name == $comapny_name) {
                $user = new WP_User( $user->ID );
//print wp_sprintf_l( '%l', $user->roles );
//                echo $user->ID;
        $html .= "
        <option value='" .$salesman->ID . "' $selected data_val='mina' data_roll='" . implode(', ', $salesman->roles) . "' >" . showName($salesman->ID) . "</option>
        ";
            }
               }
          }else{
               foreach ($users as $user) {
        $salesman = get_userdata($user->ID);
        
        

        if ($current_user_id == $user->ID) {
            $selected = " selected ";
        } else {
            $selected = "";
        }
                 $html .= "
        <option value='" . $salesman->ID . "' $selected data_val='mina' data_roll='" . implode(', ', $salesman->roles) . "' >" . showName($salesman->ID) . "</option>
        ";
            }
          
    }
    $html .= "</select>";
    echo $html;
}
function get_project_status_dropdownValue($dropdown_id, $data_table = null, $label_class = null, $select_class=null,$selected=null) {


    $html = "";
    $html .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Projektstatus") . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control $select_class'
                      id='" . $dropdown_id . "'>";
    $html .= "<option ".(($selected == 'Alla') ? 'selected':'')."  value='Alla'>" . _("Alla") . "</option>
  <option ".(($selected == 'project-ongoing') ? 'selected':'')." value='1'>" . _("Pågående") . "</option>
        <option ".(($selected == 'project-archived') ? 'selected':'')." value='2'>" . _("Avslutade") . "</option>
        ";
    $html .= "</select>";
    echo $html;
}
function get_project_status_dropdown($dropdown_id, $data_table = null, $label_class = null, $select_class = null, $selected = null) {


    $html = "";
    $html .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Projektstatus") . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control $select_class'
                      id='" . $dropdown_id . "'>";
    $html .= "<option " . (($selected == 'project-ongoing') ? 'selected' : '') . " value='project-ongoing'>" . _("Pågående") . "</option>
        <option " . (($selected == 'project-archived') ? 'selected' : '') . " value='project-archived'>" . _("Avslutat") . "</option>
        ";
    $html .= "</select>";
    echo $html;
}

function get_number_of_posts_dropdown($dropdown_id, $data_table = null, $label_class = null, $select_class) {


    $html = "";
    $html .= "<label class='" . $label_class . " antal-label' for='" . $dropdown_id . "'>" . __("Antal") . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control $select_class'
                      id='" . $dropdown_id . "'>";
    $html .= "
       <option selected value='10'>10</option>
        <option value='50'>50</option>
       <option value='100'>100</option>
        <option value='200'>200</option>
        <option value='-1'>Alla</option>
                   
        ";
    $html .= "</select>";
    echo $html;
}

function get_paged_dropdown($dropdown_id, $data_table = null, $label_class = null, $number_of_pages = 1) {


    $html = "";
    $html .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Välj sida") . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control'
                      id='" . $dropdown_id . "'>";
    for ($i = 1; $i < $number_of_pages; $i++) {
        $html .= "<option value='" . $i . "'>" . $i . "</option>";
    }

    $html .= "</select>";
    echo $html;
}

function get_project_types_dropdown($project_roles_steps, $dropdown_id, $data_table = null, $label_class = null) {


    $html = "";
    $html .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Välj typ av offert") . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='js-sortable-select form-control'
                      id='" . $dropdown_id . "'>";

    foreach ($project_roles_steps as $project_type) {
        $html .= "<option value='" . $project_type["project_type_id"] . "'>" . $project_type["project_type_name"] . "</option>";
    };

    $html .= "</select>";


    echo $html;
}

function get_project_types_list($project_roles_steps, $dropdown_id, $data_table = null, $label_class = null) {


    $html = "";
    $html .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Välj typ av offert") . "</label>";
    $html .= "<select name='" . $dropdown_id . "' data-table_name='" . $data_table . "' class='form-control'
                      id='" . $dropdown_id . "'>";

    foreach ($project_roles_steps as $project_type) {
        $html .= "<option value='" . $project_type["project_type_id"] . "'>" . $project_type["project_type_name"] . "</option>";
    };

    $html .= "</select>";


    echo $html;
}

function get_project_types_project_selectCustom($project_roles_steps, $dropdown_id = null, $data_table = null, $label_class = null) {

    foreach ($project_roles_steps as $key => $value) {

        //        echo get_option('options_' . $value . '_0_project_type_beskrivning', 'options');
//        echo get_option('options_' . $key . '_0_project_type_name', 'options');
//        print_r(get_option($value . '_0_project_type_name', 'options'));

        $html = '<div class=" col-lg-4  col-md-4 col-sm-4 ">';
        $html .= '<div class="panel panel-default">';
        $html .= '<div class="panel-footer project_card">';

        $html .= '<h3 style="text-align: center;">';
        $html .= get_option('options_' . $value . '_0_project_type_name', 'options');
        $html .= '</h3>';
        $html .= '<br>';
        $html .= '<ul class="list-inline text-center">';
        $html .= '<li class="invoice_content">' . get_option('options_' . $value . '_0_project_type_beskrivning', 'options') . '</li>';

        $html .= '<br>';


        $html .= "<li class='invoice_butn'><button class='btn btn-brand top-buffer-half' style='' type='submit' value='" . $key . "' name='" . $dropdown_id . "'> Skapa </button></li>";

        $html .= '</ul></div></div></div>';

        echo $html;
    };
}

function get_project_types_project_select($project_roles_steps, $dropdown_id, $data_table = null, $label_class = null) {


    /*        $html_n = "";

      $html_n .= "<div>";
      $html_n .= "<label class='" . $label_class . "' for='" . $dropdown_id . "'>" . __("Välj typ av offert") . "</label>";
      $html_n .= "<ul class='list-inline'>"; */

    foreach ($project_roles_steps as $project_type) {

        /*  $html_n .= "<li>";

          $html_n .= "<button class='btn btn-brand steps-btn top-buffer-half ' style='height: 150px;border-radius:0px!important;' type='submit' value='". $project_type["project_type_id"] ."' name='" . $dropdown_id . "'>" . $project_type["project_type_name"] . "<br><small>" . $project_type["project_type_beskrivning"] . "</small></button>";



          $html_n .= "</li>"; */

        $html = '<div class=" col-lg-4  col-md-4 col-sm-4 ">';
        $html .= '<div class="panel panel-default">';
        $html .= '<div class="panel-footer project_card">';

        $html .= '<h3 style="text-align: center;">';
        $html .= $project_type["project_type_name"];
        $html .= '</h3>';
        $html .= '<br>';
        $html .= '<ul class="list-inline text-center">';
        $html .= '<li class="invoice_content">' . $project_type["project_type_beskrivning"] . '</li>';

        $html .= '<br>';


        $html .= "<li class='invoice_butn'><button class='btn btn-brand top-buffer-half' style='' type='submit' value='" . $project_type["project_type_id"] . "' name='" . $dropdown_id . "'> Skapa </button></li>";

        $html .= '</ul></div></div></div>';

        echo $html;
    };
    /* $html_n .= "</ul>";
      $html_n .= "</div>"; */

    /*
      echo $html_n; */
}


            function get_internal_project_status_dropdownValue($current_user_role, $dropdown_id, $data_table = null, $label_class = null, $current_value = null, $limited_to_current_role = false, $class = false) {

                   global $roles_order_status;
                   $label = __("Intern projektstatus");
                   if ($limited_to_current_role == true) {

                       $current_department_nice_name = "";

                       if ($current_user_role == "sale-administrator") {
                           $current_department_nice_name = __('Administratör');
                       } elseif ($current_user_role == "sale-salesman") {
                           $current_department_nice_name = __('Sälj');
                       } elseif ($current_user_role == "sale-economy") {
                           $current_department_nice_name = __('Ekonomi');
                       } elseif ($current_user_role == "sale-project-management") {
                           $current_department_nice_name = __('Projektplanering');
                       } elseif ($current_user_role == "sale-technician") {
                           $current_department_nice_name = __('Tekniker');
                       } elseif ($current_user_role == "sale-sub-contractor") {
                           $current_department_nice_name = __('Underentreprenör');
                       }
                       //$label = __("Intern projektstatus") . " - " . $current_department_nice_name;
                       $label = __("Intern projektstatus");
                   }
				   $department_search = array(1=>"sale-administrator",2=>"sale-salesman",3=>"sale-economy",4=>"sale-project-management",5=>"sale-technician",6=>"sale-sub-contractor");
                   $html = "";
                   $html .= "<label class='" . $label_class . "' for='internal_project_status'>" . $label . "</label>";
                   $html .= "<select name='" . $dropdown_id . "' id='" . $dropdown_id . "' data-table_name='" . $data_table . "'  class='form-control js-sortable-select " . $class . "'>";

                   $html .= "
        <option value='Alla'>" . __("Alla") . "</option>
        ";




                       foreach ($roles_order_status[$current_user_role] as $status) {
                           if ($current_value == $status["internal_status"]) {
                               $selected = " selected ";
                           } else {
                               $selected = "";
                           }
                           $html .= "
        <option " . $selected . " value='" . $status["internal_status"] . "#".array_search($current_user_role,$department_search)."'>" . $status["internal_status"] . "</option>
        ";
                       }
    





                   $html .= "</select>";

                   echo $html;
               }
function get_internal_project_status_dropdown($current_user_role, $dropdown_id, $data_table = null, $label_class = null, $current_value = null, $limited_to_current_role = false, $class = false) {

    global $roles_order_status;
    $label = __("Intern projektstatus");
    if ($limited_to_current_role == true) {

        $current_department_nice_name = "";

        if ($current_user_role == "sale-administrator") {
            $current_department_nice_name = __('Administratör');
        } elseif ($current_user_role == "sale-salesman") {
            $current_department_nice_name = __('Sälj');
        } elseif ($current_user_role == "sale-economy") {
            $current_department_nice_name = __('Ekonomi');
        } elseif ($current_user_role == "sale-project-management") {
            $current_department_nice_name = __('Projektplanering');
        } elseif ($current_user_role == "sale-technician") {
            $current_department_nice_name = __('Tekniker');
        } elseif ($current_user_role == "sale-sub-contractor") {
            $current_department_nice_name = __('Underentreprenör');
        }
        //$label = __("Intern projektstatus") . " - " . $current_department_nice_name;
        $label = __("Intern projektstatus");
    }
    $html = "";
    $html .= "<label class='" . $label_class . "' for='internal_project_status'>" . $label . "</label>";
    $html .= "<select name='" . $dropdown_id . "' id='" . $dropdown_id . "' data-table_name='" . $data_table . "'  class='form-control js-sortable-select " . $class . "'>";

    $html .= "
        <option value='Alla'>" . __("Alla") . "</option>
        ";

    // $internal_status_array = array();
    if ($current_user_role === "alla") {

        $current_department_nice_name_array = array(
            "sale-administrator", "sale-salesman", "sale-economy", "sale-project-management", "sale-technician", "sale-sub-contractor");

        foreach ($current_department_nice_name_array as $current_user_roles) {
            foreach ($roles_order_status[$current_user_roles] as $status) {
                if ($current_value == $status["internal_status"]) {
                    $selected = " selected ";
                } else {
                    $selected = "";
                }
                $html .= "
        <option " . $selected . " value='" . $status["internal_status"] . "#" . $current_user_roles . "'>" . $status["internal_status"] . "</option>
        ";
            }
        }
    } else {


        foreach ($roles_order_status[$current_user_role] as $status) {
            if ($current_value == $status["internal_status"]) {
                $selected = " selected ";
            } else {
                $selected = "";
            }
            $html .= "
        <option " . $selected . " value='" . $status["internal_status"] . "'>" . $status["internal_status"] . "</option>
        ";
        }
    }





    $html .= "</select>";

    echo $html;
}

function get_salesman_dropdown($current_project_id, $dropdown_id, $data_table = null, $label_class = null, $current_value = null) {

    $args = array(
        'role__in' => array(
            'sale-salesman',
            'sale-administrator',
            'sale-economy',
            'sale-technician',
            'sale-project-management',
            'sale-sub-contractor'
        )
    );
    $users = get_users($args);
    if (get_post_meta($current_project_id, "order_salesman", true))
        $current_assigned_technician = get_post_meta($current_project_id, "order_salesman", true);
    else
        $current_assigned_technician = get_post_meta($_GET["order-id"], 'order_salesman_o', true);

    $html = "";
    $html .= "<label class='" . $label_class . " " . $current_assigned_technician . "' for='internal_project_status'>" . __("Säljare") . "</label>";
    
     $current_user_role = get_user_role();
     $disabled='';
    if ($current_user_role == 'sale-sub-contractor'){
        $disabled='disabled';
    }
    $html .= "<select name='" . $dropdown_id . "' id='" . $dropdown_id . "' data-table-name='" . $data_table . "'  class='form-control js-sortable-select' $disabled>";

    foreach ($users as $user) {
        $salesman = get_userdata($user->ID);

        if ($current_assigned_technician == $user->ID) {
            $selected = " selected ";
        } else {
            $selected = "";
        }
        $html .= "
        <option " . $selected . " value='" . $salesman->ID . "' data_roll='" . implode(', ', $salesman->roles) . "'>" . getCustomerName($salesman->ID) . "</option>";
    }


    $html .= "</select>";

    echo $html;
}

function get_all_sellers_dropdown() {

    $args = array(
        'role__in' => array(
            'sale-salesman',
            'sale-administrator',
            'sale-economy',
            'sale-technician',
            'sale-project-management',
            'sale-sub-contractor'
        )
    );
    $users = get_users($args);
    echo '<option value="alla" selected>Alla</option>';

    foreach ($users as $user) {
        $salesman = get_userdata($user->ID);
        echo '<option value="' . $salesman->ID . '">' . showName($salesman->ID) . '</option>';
    }
}

function return_users_id_as_array($sale_salesman, $sale_administrator, $saleeconomy, $saletechnican, $salepm, $sale_ue) {
    $users_args = array(
        'role__in' => array(
            $sale_salesman,
            $sale_administrator,
            $saleeconomy,
            $saletechnican,
            $salepm,
            $sale_ue
        )
    );
    $users = get_users($users_args);
    $all_users_id = array();
    foreach ($users as $user) {
        $salesman = get_userdata($user->ID);
        array_push($all_users_id, $salesman->ID);
    }
    return $all_users_id;
}

function get_tech_sub_dropdown($dropdown_id, $label_class = null) {
$current_user_role = get_user_role();
    
$current_user_id=get_current_user_id();
if ($current_user_role == 'sale-sub-contractor'){
    $args = array(
        'role__in' => array('sale-sub-contractor')
    );
}else{
    $args = array(
        'role__in' => array('sale-technician', 'sale-sub-contractor')
    );
}
    $users = get_users($args);

    $html = "";
    $html .= "<label class='" . $label_class . "' for='internal_project_status'>" . __("Välj användare") . "</label>";
    $html .= "<select name='" . $dropdown_id . "[]' id='" . $dropdown_id . "'  class='form-control js-sortable-select'  multiple='multiple' >";

    foreach ($users as $user) {
        
        if ($current_user_role == 'sale-sub-contractor'){
//            global $current_user;
             $current_user_company_name = get_user_meta($current_user_id, 'sale-sub-contractor_company', true);
                                        $comapny_name = get_user_meta($user->ID, 'sale-sub-contractor_company', true);
            
//        if($current_user_id==$user->ID){
                                        if ($current_user_company_name == $comapny_name) {
        $_user = get_userdata($user->ID);
        $html .= "
        <option  value='" . $user->ID . "'>" . getCustomerName($user->ID) . " " . get_user_meta($user->ID, 'sale-sub-contractor_company', true) . "</option>
        ";
    }
        }else{
           $_user = get_userdata($user->ID);
        $html .= "
        <option  value='" . $user->ID . "'>" . getCustomerName($user->ID) . " " . get_user_meta($user->ID, 'sale-sub-contractor_company', true) . "</option>
        "; 
        }
    }


    $html .= "</select>";

    echo $html;
}

function return_order_cities() {
    $cities = [];
    $a = ['posts_per_page' => -1];
    $o = wc_get_orders($a);

    foreach ($o as $order) {
        $city_name = get_post_meta($order->ID, "_billing_city", true);

        if (!in_array($city_name, $cities, true)) {
            array_push($cities, $city_name);
        }
    }

    return $cities;
}

function get_order_information_list(WC_Order $order, $json_data_as_array) {
	$remove_vats = get_post_meta($order->ID,'remove_vats',true);
	if(!empty($remove_vats)){	 
	removeVat($order->ID,1);
	$order = new WC_Order($order->ID);
	$texg = 'Total kostnad';
	}else{
		$texg = 'Totalkostnad inkl moms';
	} 
	
    $selected_cat_sum = false;
    $selected_product_category_for_price_adjustment = get_field('selected_product_category_for_price_adjustment', 'options');
    $selected_product_category_for_price_adjustment_names = [];
    $tax_deduction = get_field("imm-sale-tax-deduction", $order->ID);

    foreach ($selected_product_category_for_price_adjustment as $cat_id) {
        array_push($selected_product_category_for_price_adjustment_names, get_term($cat_id, 'product_cat')->name);
    }
    $gethousehold = get_post_meta($order->ID, 'household_vat_discount_json', true);

    $counthouse = json_decode($gethousehold, true);
    $count = 0;
    foreach ($counthouse as $key => $value) {
        if (!empty($value)) {
            $count++;
        }
    }
    if ($tax_deduction || get_post_meta($order->get_id(), "confirmed_rot_percentage", true)) {
        $rot_avdrag = get_post_meta($order->get_id(), "confirmed_rot_percentage", true);
        $display_price = $order->get_total() - $rot_avdrag;
    } else {
        $rot_avdrag = 0;
        $display_price = $order->get_total();
    }
//    print_r($rot_avdrag);
    if ($tax_deduction && $count != 0) {
        echo "<div id='tax_deduction' class='white-plate'>";
        echo "<label>" . __("ROT avdrag enligt kund") . "</label>";
        echo "<ul id='tax_deduction' class='list-unstyled'>";
        echo "<li>" . wc_price($tax_deduction) . "</li>";
        echo "</ul>";
        if ($rot_avdrag > 0) {
            $totalrot = ($order->get_total()) - ($rot_avdrag);
            echo "<label>" . __("ROT på denna") . "</label>";
            echo "<ul id='tax_deduction' class='list-unstyled'>";
            echo "<li>" . wc_price(0 - $rot_avdrag) . "</li>";
            echo "</ul>";
            echo "<label>" . __("Kostnad inkl moms efter Rot avdrag") . "</label>";
            echo "<ul id='tax_deduction' class='list-unstyled'>";
            echo "<li>" . wc_price($totalrot) . "</li>";
            echo "</ul>";
        }
        echo "</div>";
    }
    echo "<div id='total-price' class='white-plate'>";
    echo "<label>" . __("Totalsumma: ") . "</label>";
    echo "<div id='total-price-container'>" . $order->get_formatted_order_total() . "<span>  ".$texg ."</span></div>";
    echo "<i class='vat-tax'>" . __("varav ") . "<span id='tax-price-container'>" . $order->get_total_tax() . "</span> kr moms </i><br>";
    echo "<i class='exkl-vat'>" . __("varav ") . "<span id='no_tax-price-container'>" . ($order->get_total() - $order->get_total_tax()) . "</span> exkl. moms </i><br>";


    foreach ($order->get_items() as $order_item_id => $item) {
        $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();

        $terms = get_the_terms($product_id, 'product_cat');
        foreach ($terms as $term) {

            if (in_array($term->term_id, $selected_product_category_for_price_adjustment)) {
                $selected_cat_sum = $selected_cat_sum + $item->get_total();
            }
        }
    };

    echo "<i>" . __("varav ") . "<span id='selected_cat_sum'>" . wc_price($selected_cat_sum) . "</span>" . __(" i ");
    print join(', ', $selected_product_category_for_price_adjustment_names) . "</i>";
    echo "<i><span> exkl. moms</span></i>";
    echo "</div>";
    $productids = array();


    echo "<div id='selected-products_head' class='white-plate'>";
    echo "<label>" . __("Huvudprodukt") . "</label>";
      echo "<ul data-orderid='".$order->ID."' id='product-list_head' class='list-unstyled'>";
$head_sortorderitems = unserialize(get_post_meta($order->ID,'head_sortorderitems',true));  //print_r($head_sortorderitems);
//$head_sortorderitems = '';
if(empty($head_sortorderitems)){
                   $lineitemname = array();
                   foreach ($order->get_items() as $order_item_id => $item) {
                       $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
                       if (wc_get_order_item_meta($order_item_id, "HEAD_ITEM") ) {
                           $strr = str_replace(' ', '', wc_get_order_item_meta($order_item_id, 'line_item_note', true));
                           $lineitemname[$strr] = array($product_id, $item, $item->get_quantity());
                       }
                   };

                   foreach ($order->get_items() as $order_item_id => $item) {

                       $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();

                       if (wc_get_order_item_meta($order_item_id, "HEAD_ITEM") && $product_id != '27944') {
                           $productitle = str_replace(' ', '', get_the_title($product_id));
                           if (count($lineitemname[$productitle]) != 0) {
                               echo return_product_information_for_list($product_id, $item, $item->get_quantity());
                               echo return_product_information_for_list($lineitemname[$productitle][0], $lineitemname[$productitle][1], $lineitemname[$productitle][2]);
                           } else {
                               echo return_product_information_for_list($product_id, $item, $item->get_quantity());
                           }
                       }
                   };
 } else{
	   foreach ($order->get_items() as $order_item_id => $item) {
                       $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
                       if ($product_id === 0) {
                           $title = $item["name"];
                       } else {
                           $title = null;
                       }
                   
			if (wc_get_order_item_meta($order_item_id, "HEAD_ITEM")) {

			 $key =   array_keys($head_sortorderitems,$order_item_id);
		
			 if($key[0]){ 

$lineitemname[$order_item_id] = array($product_id, $item, $item->get_quantity(), $title);
				 }	  else{

					$lineitemname[$order_item_id] = array($product_id, $item, $item->get_quantity(), $title);
					$newarray[] =  $order_item_id;
				
				 }	
			}
		
                   }; 
				if(!empty($newarray)){
		$head_sortorderitems =	array_merge($head_sortorderitems,$newarray);
				}
	$head_sortorderitems =	array_unique($head_sortorderitems);

foreach($head_sortorderitems as $hvaluess){
	if(!empty($lineitemname[$hvaluess][0]))	 
  echo return_product_information_for_list($lineitemname[$hvaluess][0], $lineitemname[$hvaluess][1], $lineitemname[$hvaluess][2], $lineitemname[$hvaluess][3]);

}
}
                 echo "</ul>";
                   echo "</div>";


                   echo "<div id='selected-products' class='white-plate'>";
                   echo "<label>" . __("Övriga artiklar") . "</label>";
                   echo "<ul id='product-list' data-orderid='".$order->ID."'  class='list-unstyled'>";
				    	$sortorderitems = unserialize(get_post_meta($order->ID,'sortorderitems',true)); 

$sorting_wise = get_post_meta($order->ID, "sortorderitems", true); 

if(empty($sortorderitems)){
                   foreach ($order->get_items() as $order_item_id => $item) {
                       $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
                       if ($product_id === 0) {
                           $title = $item["name"];
                       } else {
                           $title = null;
                       }
                       if (!wc_get_order_item_meta($order_item_id, "HEAD_ITEM")) {
						    echo return_product_information_for_list($product_id, $item, $item->get_quantity());
                       
                       }
                   };

                /*    foreach ($order->get_items() as $order_item_id => $item) {

                       $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
                       if ($product_id === 0) {
                           $title = $item["name"];
                       } else {
                           $title = null;
                       }

                       if (!wc_get_order_item_meta($order_item_id, "HEAD_ITEM")) {
                           $productitle = str_replace(' ', '', get_the_title($product_id));

                           if (count($headitems[$productitle]) != 0) {
                               echo return_product_information_for_list($product_id, $item, $item->get_quantity(), $title);
                               echo return_product_information_for_list($headitems[$productitle][0], $headitems[$productitle][1], $headitems[$productitle][2], $headitems[$productitle][3]);
                           } else {
                               echo return_product_information_for_list($product_id, $item, $item->get_quantity());
                           }
                  
                       }
                   }; */

/* 				    $result=array_diff_key($totalshow,$notshow);
					if(!empty($result)){
				   foreach($result as $value){ echo $value; }				   } */
 } else{

	              foreach ($order->get_items() as $order_item_id => $item) {
                       $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();
                       if ($product_id === 0) {
                           $title = $item["name"];
                       } else {
                           $title = null;
                       }
                   
			if (!wc_get_order_item_meta($order_item_id, "HEAD_ITEM")) {
				 $keys =   array_keys($sortorderitems,$order_item_id);
			
			 if($keys[0]){ 

$headitems[$order_item_id] = array($product_id, $item, $item->get_quantity(), $title);
				 }	  else{
			
					 $headitems[$order_item_id] = array($product_id, $item, $item->get_quantity(), $title);
					$newarrays[] =  $order_item_id;
				
				 }		   
						   
			}
                   }; 
				
				 if(!empty($newarrays))
				$sortorderitems =	array_merge($sortorderitems,$newarrays); 
			
	if(empty($sortorderitems)){
		$sortorderitems =	$newarrays; 
	}
		$sortorderitems =	array_unique($sortorderitems);
	
foreach($sortorderitems as $valuess){
	if(!empty($headitems[$valuess][0]))	 
  echo return_product_information_for_list($headitems[$valuess][0], $headitems[$valuess][1], $headitems[$valuess][2], $headitems[$valuess][3]);

}
} 
    echo "</ul>";
    echo "</div>";
    if ($json_data_as_array) {
        $keys = array('Information-frn-kund' => 'Information från kund', 'Arbetsorder' => 'Arbetsorder');
        echo "<div class='white-plate'>";
        echo "<ul class='list-unstyled'>";

        foreach ($json_data_as_array as $data) {
            if ($data["value"] && $data["label"]) {
                if (in_array($data["label"], $keys)) {
                    $b = array_flip($keys);


                    if (get_post_meta($_GET["order-id"], $b[$data["label"]], true)) {
                        echo "<li><strong>" . $data["label"] . ": </strong>" . get_post_meta($_GET["order-id"], $b[$data["label"]], true) . "</li>";
                    } else {
                        echo "<li><strong>" . $data["label"] . ": </strong>" . $data["value"] . "</li>";
                    }
                } else {
                    echo "<li><strong>" . $data["label"] . ": </strong>" . $data["value"] . "</li>";
                }
            }
        }
        echo "</ul>";
        echo "</div>";
    }
}

function return_department_translations() {
    $department_translations = [
        'sale-salesman' => __("Säljare"),
        'sale-economy' => __("Ekonomi"),
        'sale-technician' => __("Tekniker"),
        'sale-sub-contractor' => __("Underentreprenör")
    ];

    return $department_translations;
}

add_action('woocommerce_product_options_pricing', 'imm_add_RRP_to_products');

function imm_add_RRP_to_products() {
    woocommerce_wp_text_input(array(
        'id' => 'rrp',
        'class' => 'short wc_input_price',
        'label' => __('Retail Price', 'woocommerce') . ' (' . get_woocommerce_currency_symbol() . ')'
            )
    );
}

add_action('save_post', 'imm_save_RRP');

function imm_save_RRP($product_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (isset($_POST['rrp'])) {
        if (is_numeric($_POST['rrp'])) {
            update_post_meta($product_id, 'rrp', $_POST['rrp']);
        }
    } else {
        delete_post_meta($product_id, 'rrp');
    }
}
function return_sorted_product_list_based_on_brand123($order_id) {
				   
                   $product_brands = [];
                   $order = new WC_Order($order_id);


                   $brands =  wpse29164_registerTaxonomy();
  
			   
                   foreach ($brands as $brand) {
                       array_push($product_brands[$brand->name], []);
                   }

                   foreach ($order->get_items() as $order_item_id => $item) {
                       $terms = get_the_terms($item->get_product_id(), 'item');

                       foreach ($terms as $term) {
                           if (in_array($term, $brands)) { 
                               $product_brands[$term->name][$order_item_id] = $item->get_product_id();
                          
                           }
                       }
                   }


                   return $product_brands;
               }
function return_sorted_product_list_based_on_brandRam($order_id) {
    $product_brands = [];
    $order = new WC_Order($order_id);


    $brands = get_terms([
        'taxonomy' => 'item',
        'hide_empty' => true,
    ]);
    //var_dump($brands);
   /*  foreach ($brands as $brand) {
        array_push($product_brands[$brand->name], []);
    } */


    foreach ($order->get_items() as $order_item_id => $item) {
        $terms = get_the_terms($item->get_product_id(), 'item');

        foreach ($terms as $term) {
            if (in_array($term, $brands)) {
                $product_brands[$term->term_id][$order_item_id] = $item->get_product_id();
                //array_push( $product_brands[ $term->name ][], 123 );
            }
        }
    }


    return $product_brands;
} 
               function return_sorted_product_list_based_on_brand($order_id) {
				   
                   $product_brands = [];
                   $order = new WC_Order($order_id);


                   $brands = get_terms(array(
                       'taxonomy' => 'item',
                       'hide_empty' => true,
                   ));
  
			 
                   foreach ($brands as $brand) { 
				$brand_email =  get_field('order_emailid',"item_".$brand->term_id); 
				 
                       array_push($product_brands[$brand_email], []);
                   }

                   foreach ($order->get_items() as $order_item_id => $item) {
 
                       $terms = get_the_terms($item->get_product_id(), 'item');

                       foreach ($terms as $term) {
                           if (in_array($term, $brands)) { 
							$brand_emails =  get_field('order_emailid',"item_".$term->term_id); 
                               $product_brands[$brand_emails][$order_item_id] = $item->get_product_id();
                          
                           }
                       }

                   }


                   return $product_brands;
               }
function return_locked_script() {

    echo "<script type='text/javascript'>
    jQuery(':input','.steps-page').attr(\"disabled\",true);
    </script>";
}

function update_internal_project_status_and_current_department($project_id, $user_role, $internal_status_index) {
    global $roles_order_status;
    $project_connection = get_post_meta($project_id, "imm-sale_project_connection")[0];
    update_post_meta($project_connection, "internal_project_status_" . $user_role, $roles_order_status[$user_role][$internal_status_index]["internal_status"]);
    update_field('order_current_department', $user_role, $project_connection);
}

function strpos_arr($haystack, $needle) {
    if (!is_array($needle))
        $needle = array($needle);
    foreach ($needle as $what) {
        if (($pos = strpos($haystack, $what)) !== false)
            return $pos;
    }
    return false;
}

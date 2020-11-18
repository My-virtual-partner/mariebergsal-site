<?php

add_action('wp_ajax_delete_todo_data', 'delete_todo_data');
add_action('wp_ajax_nopriv_delete_todo_data', 'delete_todo_data');

function delete_todo_data() {
    $todo_id = $_POST['todo_id'];
    $get_post_type = get_post_type($todo_id);
    if ($get_post_type == 'imm-sale-todo') {
        wp_delete_post($todo_id,true);
        delete_post_meta($todo_id,true);
        
    }
    die;
}

function search_and_display_leads_filter() {

    $from_date = date('Y-m-d', (strtotime('-1 day', strtotime($_POST["from_date"]))));

    $to_dates = DateTime::createFromFormat('Y-m-d', $_POST["to_date"]);

    if ($to_dates !== FALSE) {
        $to_date = date('Y-m-d', (strtotime('+1 day', strtotime($_POST["to_date"]))));
    } else {
        $to_date = date("Y-m-d", strtotime("tomorrow"));
    }

    $lead_typavlead = $_POST['lead_typavlead'];
    $lead_salesman = $_POST['lead_salesman'];
    $current_user_role = $_POST['data_role'];
    $project_roles_steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);
    $leads_array = array();
    $lead_salesman_array = array();



    foreach ($project_roles_steps as $single_step) {
        array_push($leads_array, $single_step["project_type_name"]);
    };


    if ($lead_typavlead == 'alla') {
        $lead_typavlead_value = $leads_array;
        array_push($args['meta_query'], array("key" => "lead_salesman", "value" => $lead_typavlead_value));
    } else {
        $lead_typavlead_value = $lead_typavlead;
        array_push($args['meta_query'], array("key" => "lead_salesman", "value" => $lead_typavlead_value));
    }

    $args = [
        'post_type' => "imm-sale-leads",
        'posts_per_page' => -1,
        'post_status' => array('publish', 'acf-disabled', 'future', 'pending', 'private'),
        'date_query' => array(
            array(
                'after' => $from_date,
                'before' => $to_date,
            ),
        ),
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'lead_typavlead',
                'value' => $lead_typavlead_value,
            )
        )
    ];
    if ($lead_salesman != 'alla') {
        array_push($args['meta_query'], array(
            "key" => "lead_salesman",
            "value" => $lead_salesman,
        ));
    }
//    echo"<pre>";
//    print_r($arg);
//    $products = new WP_Query($args);
////
// echo "<pre>";print_r($products);
    return_leads_table($args);

    die();
}


function return_modal_content() {


    $order = new WC_Order($_POST["order_id"]);

    $current_user_role = get_user_role();
    $wc_order_statuses = wc_get_order_statuses();
    $order_status = "wc-" . $order->get_status();

    $current_department_id = get_field('imm-sale_project_connection', $order->ID);
    $current_department = get_field('order_current_department', $current_department_id);
	$salemanid = get_post_meta($current_department_id, 'order_salesman', true);
$userid = get_post_meta($current_department_id, 'invoice_customer_id')[0];
    $custom_order_number = get_post_meta($order->get_id(), 'custom_order_number')[0];
    $invoice_or_order = __("Offert");
    $is_order = get_post_meta($order->ID, 'imm-sale_converted_to_order')[0];
    $todo_project_connection = get_field('imm-sale_project_connection', $_POST["order_id"]);
    $internal_status = get_post_meta($current_department_id, 'internal_project_status_' . $current_department, true);
    $order_id = $order->ID;
    $orderaccept = get_post_meta($order_id, 'order_accept_status', true);

    if ($is_order == true) {
        $invoice_or_order = __("Order", "imm-sale-system");
    }
    ?>
    <div class="container-fluid">
	<input type="hidden" value="<?=$userid?>" id="useridPI" />
	<input type="hidden" value="<?=$salemanid ?>" id="salesmanidPI"  />
   
        <input type="hidden" name="quick-order-id" value="<?php echo $order->ID; ?>">
        <input type="hidden" name="imm-sale-order-department" value="<?php echo $current_department; ?>">
        <meta charset="UTF-8">
        <h2><?php echo $invoice_or_order . " ".$userid."-".$current_department_id."-".$order->ID; ?></h2>
		<input type="hidden" id="orderformat" value="<?php echo $userid."-".$current_department_id."-".$order->ID; ?>" />
        <?php
        
        $editing_status = get_field('editing_status_mb', $order_id);
        $editing_by = get_field('edited_by_mb', $order_id);
        $current_time = strtotime(date("Y-m-d h:i"));
        $editing_time = strtotime(get_field('editing_time_mb', $order_id));
        $time_different = $current_time - $editing_time;
    //        $edit_link = '<a href="#" class="edit_by" data_order_ID='.$order_id.' data_current_user='.get_current_user_id().'>redigera nu</a>';
    if ($current_user_role == 'sale-salesman' && $orderaccept == 'true') {

            $edit_link = '<a href="/project?pid=' . $todo_project_connection . '" data_order_ID=' . $order_id . ' data_current_user=' . get_current_user_id() . '>redigera nu</a>';
    } else {
        $edit_link = '<a href="#" class="edit_by" data_order_ID=' . $order_id . ' data_current_user=' . get_current_user_id() . '>redigera nu</a>';
    }
if ($current_user_role != 'sale-sub-contractor') {
    if ($editing_status && $time_different < 3600) {

            echo '<div class="alert alert-danger" role="alert"> 
  Ordern redigeras av ' . $editing_by . '.Försök igen om ett par minuter eller ' . $edit_link . '
</div>';
        }
}
        ?>

<?php if ($current_user_role != 'sale-sub-contractor') { ?>
        <div class="row">
            <div class="col-md-12">

                <ul class="list-inline">
                    <?php
                    $order_id = $order->ID;
                    $editing_status = get_field('editing_status_mb', $order_id);
                    $editing_by = get_field('edited_by_mb', $order_id);
                    $current_time = strtotime(date("Y-m-d h:i"));
                    $editing_time = strtotime(get_field('editing_time_mb', $order_id));
                    $time_different = $current_time - $editing_time;


                    if ($editing_status !== '1' || $time_different > 3600):
                       if ($current_user_role == 'sale-salesman' && $orderaccept == 'true') {
                            ?>

        <?php } else { ?>
                                            <li class="redigera_offert_verktyg" data_orderID="<?php echo $order->get_id(); ?>"
                                            data_current_user_id="<?php echo get_current_user_id(); ?>">
                                            <a href="#" class="btn btn-alpha btn-block"><?php echo __("Redigera") ?></a>

                                        </li>


        <?php
        }
    endif;
        ?>
                    <?php // if (!$is_order) :  ?>
                    <li>
                        <a href="<?php echo site_url() ?>?duplicate=true&project_id=<?php echo $order->ID; ?>"
                           class="btn btn-alpha btn-block top-buffer-half"><?php echo __("Duplicera") . " " . strtolower($invoice_or_order); ?></a>
                    </li>
                    <li>
                        <a href="#" class="btn btn-alpha btn-block top-buffer-half"
                           id="valj_duplicated_project"><?php echo __("Duplicera till ny kund"); ?></a>
                    </li>

                    <?php // endif;      ?>

                    <li>
                        <a href="#" id="toggle-log"
                           class="btn btn-alpha btn-block top-buffer-half"><?php echo __("Öppna loggen"); ?></a>
                    </li>

                    <li>
                        <button type="submit" onclick="closeModalAndSendForm();"
                                class="btn btn-brand btn-block top-buffer-half">
                                    <?php echo __("Spara och uppdatera") . " " . strtolower($invoice_or_order); ?>
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" id="valt_duplicated_project" style="display: none;">
                <input type="hidden" id="project_id_inoffert">
                <input type="hidden" id="order_id_inoffert" value="<?php echo $order->ID; ?>">
                <label class="top-buffer-half"
                       for=""><?php echo __("Välj kund"); ?> </label>
                       <?php
                       $current_customer_id = $order->get_customer_id();
                       $allcustomers = get_users('orderby=nicename');
                       $args = [
                           'posts_per_page' => -1,
                           'post_type' => 'imm-sale-project',
                       ];
                       $projects = new WP_Query($args);

//                       print_r($_GET['pid']);
                       ?>

                <select class="form-control js-sortable-select" name="duplicate_offert_inside_project_new_customer"
                        id="duplicate_offert_inside_project_new_customer">
                            <?php
                            foreach ($allcustomers as $customer) {
                                if ($current_customer_id == $customer->ID) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                                $data=get_userdata($customer->ID);
                                if(empty($data->user_email)){
                                    $useremail=get_user_meta($customer->ID, 'billing_email' )[0];
                                }else{
                                    $useremail=$data->user_email;
                                }
                                $address = get_user_meta($customer->ID, 'billing_address_1', true) . " " . get_user_meta($customer->ID, 'billing_address_2', true);
                                echo "<option " . " value='" . $customer->ID . "' data_customerId=" . $customer->ID . ">" . $customer->ID.', '.showName($customer->ID) . ', '. $useremail. ' '.$address. "</option>";
                            }
                            wp_reset_query();
                            ?>

     



                </select>

                <a id='duplicate_offert_href' href=""
                   class="btn btn-alpha btn-block top-buffer-half"><?php echo __("Duplicera offert till ny kund") ?></a>

            </div>
            <div class="col-md-12">

                <?php
                $current_customer_id = $order->get_customer_id();

                $order_accept_status = get_post_meta($order->ID, 'order_accept_status')[0];
                ?>

                <hr>
                <?php /*
                $args = array(
                    'orderby' => 'ID',
                    'post_type' => wc_get_order_types(),
                    'post_status' => array_keys(wc_get_order_statuses()),
                    'posts_per_page' => - 1,
                    'meta_query' => array(
                        array(
                            'key' => 'imm-sale_parent_order',
                            'value' => $order_id,
                            'compare' => '='
                        )
                    )
                );
                $getorders = new WP_Query($args);
//                echo"<pre>";
//                print_r($getorders);
                $i = 1;
                while ($getorders->have_posts()) :
                    $getorders->the_post();
                    if ($i == 1) {
                        ?>

                        <input type="hidden" name="get-invoice" id="get-invoice" value="">

                        <?php
                    }
                    $i++;
                endwhile;
                wp_reset_postdata();
                ?><input type="hidden" name="order-id" id="order-id" value="<?php echo $order_id; ?>">
                 * 
                 */?>

                <div class="row">

                    <div class="col-md-12">
                        <div class="col-md-4">
					
                                <?php if ($current_user_role == 'sale-salesman' && $orderaccept == 'true') { ?>
                                    <select id="order-customer-status" class='form-control js-sortable-select' name="order-customer-status" disabled="true">
                                    <?php } else { ?>
                                        <select id="order-customer-status" class='form-control js-sortable-select' name="order-customer-status">
                                        <?php } ?>
                                        <option value="" <?php
                                if (empty($order_accept_status)) {
                                    echo "selected";
                                }
                                ?> >Väntar svar</option>
                                <option value="true" <?php
                                if ($order_accept_status === "true") {
                                    echo "selected";
                                }
                                ?>>Order bekräftad</option>
                                    <option value="false" <?php
                                if ($order_accept_status === "false") {
                                    echo "selected";
                                }
                                ?> >Nekad av kund</option>
                                <option value="Kundfråga" <?php
                                if ($order_accept_status === "Kundfråga") {
                                    echo "selected";
                                }
                                ?> >Kund har frågor</option>
                                    <option value="archieved" <?php
                                    if ($order_accept_status === "archieved") {
                                        echo "selected";
                                    }
                                    ?> >Arkiverad kopia</option>
                                        <option value="Acceptavkund" <?php
                                        if ($order_accept_status === "Acceptavkund") {
                                            echo "selected";
                                        }
                                        ?> >Accepterad av kund</option>
                                    </select>

                        </div>
				<div class="col-md-4">
                                    <input type="checkbox" name="notemail" value="1" <?php
                                               if (in_array($order_accept_status, array("Kundfråga", "false", "true", "Acceptavkund"))) {
                                                   echo "checked";
                                } ?> />	Skicka inte orderbekräftelse </div>
								<div class="col-md-4">	<?php
					$project_status = get_post_meta($current_department_id , "imm-sale-project")[0];
					get_project_status_dropdown( "order-by-this-project-status", $table_name, "top-buffer-half hidelabelorder" ,'',$project_status); ?>
						</div>
							
                    </div>

                </div>
				<?php
//echo $advance_payment = get_post_meta($order_id,'advance_payment',true);

//				if(!empty($advance_payment)){?>
<!--                <div id="popup" style="display:none">
                    <h3>Vill du ta bort skapade fakturaunderlag?</h3>
                    <input type='radio' name='group' id="group"  value='1' />Ja, ta bort
                    <input type='radio' name='group' id="group" value='0' />Nej, behåll
                    <br><span>När du vill ändra status på ordern måste du välja om du även vill ta bort de fakturaunderlag som skapats. Observera att dessa inte tas bort i fakturaprogrammet.</span>
                    <a id="close" href="">X</a>
                </div>-->
				<?php // } ?>
                <!--<hr>-->
<!--                <div class="row">
                    <div class="col-md-12">

                    </div>

                </div>-->
                <!--<hr>-->
                <?php

                if (get_post_meta($order->get_id(), 'order_accept_status', true) === 'true') {
                    $sms_message = 'Hej! Orderbekräftelse från Mariebergs:';
                } else {
                    $sms_message = 'Hej! Affärsförslag från Mariebergs:';
                }
                ?>


                <div class="form-group">
                    <div class="row text-center">
                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">
                                <li>
                                    <img class="img-prev"
                                         src="wp-content/plugins/imm-sale-system/images/spec-med-pris.png"
                                         alt="">
                                </li>
                                <li>
                                    <strong>
                                        <a class="btn btn-brand btn-sm" target="_blank"
                                           href="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-w-price", $order->get_id()) ?>">
                                               <?php echo __("Affärsförslag - Spec med pris"); ?>
                                        </a>
                                    </strong>
                                </li>
                                <li>
                                    <button type="button" data-order-id="<?php echo $order->get_id(); ?>"
                                            data-url="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-w-price", $order->get_id()) ?>"

                                            class="btn btn-xs btn-alpha"
                                            id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
                                            class="fa fa-angle-double-right"
                                            aria-hidden="true"></i>
                                    </button>
                                </li>
                                <li>

                                    <?php
                                    $order_data = $order->get_data();
						$getCode = substr(trim($order_data['billing']['phone']), 0, 3);
                      $order_billing_phone = ($getCode == '+46')? $order_data['billing']['phone']:'+46'.$order_data['billing']['phone'];
						 
//$order_billing_phone = '+46' . $order_data['billing']['phone'];
                                    // $sms_message = get_field('sms_meddelande', 'option');

                                    $order_link = site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-w-price", $order->get_id());
                                    echo '<a  class="btn btn-brand btn-sm send_sms"  data_tel="' . $order_billing_phone . '" data_msg ="' . $sms_message . '" data_lank ="' . $order_link . '" >Skicka sms</a>'
                                    ?>
                                </li>

                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">

                                <li>
                                    <img class="img-prev"
                                         src="wp-content/plugins/imm-sale-system/images/spec-utan-pris.png"
                                         alt="">
                                </li>
                                <li>
                                    <strong>
                                        <a class="btn btn-brand btn-sm" target="_blank"
                                           href="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-wo-price", $order->get_id()) ?>">
                                               <?php echo __("Affärsförslag - Spec utan pris"); ?>
                                        </a>
                                    </strong>
                                </li>
                                <li>
                                    <button type="button"
                                            data-order-id="<?php echo $order->get_id(); ?>"
                                            data-url="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-wo-price", $order->get_id()) ?>"
                                            class="btn btn-xs btn-alpha"
                                            id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
                                            class="fa fa-angle-double-right"
                                            aria-hidden="true"></i>
                                    </button>
                                </li>
                                <li>
                                    <?php
                                    //$order_data = $order->get_data();
                                   // $order_billing_phone = '+46' . $order_data['billing']['phone'];
                                    //$sms_message = get_field('sms_meddelande', 'option');
                                    $order_link = site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-wo-price", $order->get_id());
                                    echo '<a  class="btn btn-brand btn-sm send_sms"  data_tel="' . $order_billing_phone . '" data_msg ="' . $sms_message . '" data_lank ="' . $order_link . '" >Skicka sms</a>'
                                    ?>
                                </li>

                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">

                                <li>
                                    <img class="img-prev"
                                         src="wp-content/plugins/imm-sale-system/images/ospecat-med-pris.png"
                                         alt="">
                                </li>
                                <li>
                                    <strong>
                                        <a class="btn btn-brand btn-sm" target="_blank"
                                           href="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-compact", $order->get_id()) ?>">
                                               <?php echo __("Affärsförslag - Ospecat med pris"); ?>
                                        </a>
                                    </strong>
                                </li>
                                <li>
                                    <button type="button" data-order-id="<?php echo $order->get_id(); ?>"
                                            data-url="<?php echo site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-compact", $order->get_id()) ?>"
                                            class="btn btn-xs btn-alpha"
                                            id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
                                            class="fa fa-angle-double-right"
                                            aria-hidden="true"></i>
                                    </button>
                                </li>
                                <li>
                                    <?php
                               //     $order_data = $order->get_data();
                                 //   $order_billing_phone = '+46' . $order_data['billing']['phone'];
                                    //  $sms_message = get_field('sms_meddelande', 'option');
                                    $order_link = site_url() . "/order-summary?order-id=" . $order->get_id() . "&order-key=" . get_field("order_summary-key-compact", $order->get_id());
                                    echo '<a  class="btn btn-brand btn-sm send_sms"  data_tel="' . $order_billing_phone . '" data_msg ="' . $sms_message . '" data_lank ="' . $order_link . '" >Skicka sms</a>'
                                    ?>
                                </li>

                            </ul>
                        </div>
                    </div>
                    <hr>
<?php } ?>
                    <div class="row text-center">

                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">
                                <li>
                                    <img class="img-prev"
                                         src="wp-content/plugins/imm-sale-system/images/teknisk-sammanfattning.png"
                                         alt="">
                                </li>
                                <li>
                                    <a class="btn btn-brand btn-sm" target="_blank"
                                       href="<?php echo site_url() . "/order-summary-technical?order-id=" . $order->get_id(); ?>"><?php echo __("Teknisk
                                        sammanfattning"); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <?php if ($current_user_role != 'sale-sub-contractor') { ?>
                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">
                                <li>
                                    <img class="img-prev"
                                         src="wp-content/plugins/imm-sale-system/images/ekonomisk-sammanfattning.png"
                                         alt="">
                                </li>
                                <li>
                                    <a class="btn btn-brand btn-sm" target="_blank"
                                       href="<?php echo site_url() . "/order-summary-economy?order-id=" . $order->get_id(); ?>"><?php echo __("Ekonomisk
                                        sammanfattning"); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">
                                <li>
                                    <img class="img-prev"
                                         src="wp-content/plugins/imm-sale-system/images/visa-bestallningsunderlag.png"
                                         alt="">
                                </li>
                                <li>
                                    <a class="btn btn-brand btn-sm" href="#"
                                       id="toggle-order_documents"><?php echo __("Visa beställningsunderlag"); ?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <hr>

                    <div class="row text-center">

                        <div class="col-lg-4">
                            <ul class="list-unstyled list-spaced">
                                <li>
                                    <img class="img-prev"
                                         src="/wp-content/plugins/imm-sale-system/images/visa-bestallningsunderlag.png"
                                         alt="">
                                </li>
                                <li>
                                    <div class="print_order_icon btn btn-brand btn-sm" style="margin: auto;padding: 20px;"><?php echo __("Kassakvitto"); ?></div>
                                    <input type="hidden" name="order_id" id="order_id" value="<?php echo $order->get_id();?>">
                                </li>
                                <button type="button" data-print='1' data-order-id="<?php echo $order->get_id(); ?>"
                                        data-url="<?php echo site_url() . "/wp-content/plugins/imm-sale-system/includes/templates/kassakvitto_view.php?order-id=" . $order->get_id(); ?>"

                                        class="btn btn-xs btn-alpha"
                                        id="send_invoice_to_customer1"><?php echo __("Skicka till kund") ?> <i
                                        class="fa fa-angle-double-right"
                                        aria-hidden="true"></i>
                                </button>
                                <li style="margin-top: 5px;">
                                    <?php
                                  //  $order_data = $order->get_data();
                                   // $order_billing_phone = '+46' . $order_data['billing']['phone'];
                                    // $sms_message = get_field('sms_meddelande', 'option');
                                    $order_link = site_url() . "/wp-content/plugins/imm-sale-system/includes/templates/kassakvitto_view.php?order-id=" . $order->get_id();
                                    echo '<a  class="btn btn-brand btn-sm send_sms"  data_tel="' . $order_billing_phone . '" data_msg ="Här kommer ditt kassakvitto från Mariebergs" data_lank ="' . $order_link . '" >Skicka sms</a>'
                                    ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                        <?php } ?>
                </div>
                <script>
                    jQuery(document).ready(function ($) {
                        jQuery(".order_print_icon").on('click', function () {
                            w = window.open();
                            w.document.write($('.print_order_area').html());
                            w.print();
                            window.close();
                        });
                    });</script>
                
                
                <div class="order_printable_area" style="display: none;margin:40px;">
        <div class="col-md-12">
            <img src="/wp-content/uploads/2018/07/Mariebergs-Logo-Svart-ny.png" alt="" class="center-block"
                 style="margin:auto;margin-bottom: 20px;max-width: 370px;height:auto; display:block;">
            <br>

        </div>

      
        <table class="table table-striped" style="margin-top: 25px;width: 100%;max-width: 100%;margin-bottom: 20px;">
            <div class="date"><strong>Datum: </strong> <span class="ajax_date"></span></span> </div>
                <div> <span style="float:right"><strong>Kassakvittonummer: </strong><span class="cash_recipt" style="float:right"></span> </span></div>
            <div><strong>Tid: </strong><span class="ajatime"></span> </div>


            <tr class="tbl_hdng" style="background-color: #f9f9f9;">
                <th style="text-align:left; float:left;">Produkt</th>
                <th style="text-align:right;">Pris</th>
            </tr>
       
               

    
            <tr>
                <td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Momssats: "); ?></strong>
                </td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;">25%
                </td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Summa ex moms: "); ?></strong>
                </td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;" class="minustotal_taxs">
                </td>
            </tr>
            <tr><td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Moms: "); ?></strong></td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;" class="total_taxs"></tr>
            <tr style="background-color: #f9f9f9;"><td style="text-align: right;width: 70%;border-top: 1px solid #ddd;padding: 8px;"><strong><?php echo __("Totalsumma: "); ?></strong></td>
                <td style="text-align: right;width: 30%;border-top: 1px solid #ddd;padding: 8px;" class="rot"></td></tr>
        </table>

        <div class="col-md-12">
            <h4 style="margin-left: 265px;line-height:14px">Mariebergs Brasvärme AB</h4>


        </div>
        <div class="address" style="text-align: center;">
       
            <h4 style="margin:0;line-height:18px"><strong>Org. nr: </strong><span class="organisationajax"></span></h4>
            <span class="organ_content"></span><br>
        </div>
        <div class="footer_txt" style="text-align: center;">
            <h4 style="line-height:18px;font-size:15px"><strong>Tack För ditt köp!</strong></h4>
            <h4 style="line-height:18px;font-size:15px"><strong>Välkommen åter!</strong></h4>
        </div>
    </div>
                
                <?php if ($current_user_role == 'sale-salesman' || $current_user_role == "sale-administrator") : ?>

                    <?php
                    $log_json = get_post_meta($order->ID, 'order_log');
                    $order_log = return_array_from_json($log_json[0]);
                     $projectLog = getProjectLog($current_department_id);
                    ?>
                    <hr>

                    <div class="top-buffer-half col-lg-12" id="log" style="display: none">
                        <div class="top-buffer-half col-lg-6">
                            <h3>Order Log</h3>
                        <ul class="list-unstyled log-list">
                            <?php foreach ($order_log as $log_entry) : ?>
                                <li><?php echo $log_entry["user"] . ": " . date('Y-m-d G:i:s', $log_entry["timestamp"]) . " <br> " . $log_entry["log_action"] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                        
                        <div class="top-buffer-half col-lg-6">
                            <h3>Project Log</h3>
                            <ul class="list-unstyled log-list"> 
                                <?php foreach ($projectLog as $getEntry) : ?> 

                                    <?php // echo  "<h4 style='font-weight: bold;'>".getCustomerName($getEntry->userid)."</h4>";
                                    foreach (json_decode($getEntry->log) as $newlog) {
                                        ?>
                                        <li><?php echo getCustomerName($getEntry->userid) . ": " . $getEntry->created_date . " <br> " . $newlog; ?></li>
                                    <?php } ?>

        <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="top-buffer-half" id="checklists" style="display: none">
                    <table class="table">
                        <?php $table_name = "todo-modal"; ?>
                        <thead>
                            <tr>
                                <th class="sortable"
                                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Åtgärdsdatum"); ?></th>
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
                                        'value' => $order->ID,
                                        'compare' => '=',
                                    )
                                )
                            ];

                            return_todo_table($args, true);
                            ?>

                        </tbody>
                    </table>
                </div>

                <div class="top-buffer-half" id="dates" style="display: none">

                    <?php $planning_type = get_post_meta($order->ID, 'planning-type')[0]; ?>
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
                           for="assigned-technician-select"><?php echo __("Ansvarig användare just nu") ?></label>
                           <?php
                           $args = array(
                               'role__in' => array('sale-technician', 'sale-sub-contractor')
                           );
                           $users = get_users($args);
                           $current_assigned_technician = get_post_meta($order->ID, "assigned-technician-select")[0];
                           ?>

                    <select class="form-control js-sortable-select" id="assigned-technician-select"
                            name="assigned-technician-select">
                        <option value=""><?php echo __("Ingen användare vald"); ?></option>
                        <?php foreach ($users as $user) : ?>
                            <option <?php
                            if ($current_assigned_technician == $user->ID) {
                                echo " selected ";
                            }
                            ?> value="<?php echo $user->ID ?>"><?php echo $user->display_name . " " . get_user_meta($user->ID, 'sale-sub-contractor_company', true) ?></option>

                        <?php endforeach; ?>
                    </select>
                    <label class="top-buffer-half"
                           for="work-date-from"><?php echo __("Välj aktivitetsdatum fr.o.m") ?></label>
                    <input value="<?php echo get_post_meta($order->ID, 'work-date-from')[0]; ?>" name="work-date-from"
                           type='date' class="form-control"/>
                    <label class="top-buffer-half" for="work-date-to"><?php echo __("T.o.m") ?></label>
                    <input value="<?php echo get_post_meta($order->ID, 'work-date-to')[0]; ?>" name="work-date-to"
                           type='date' class="form-control"/>

                </div>

                <div class="top-buffer-half" id="order_documents" style="display: none">
                    <div class="form-group">

                        <?php
                        //Add more label fields if something is missing.
                        $haystack = ["H1", "H2", "H3", "H4", "H5", "H6"];

                        $order_data = return_array_from_json(get_field('orderdata_json', $order->ID));
                        $filtered_data = [];

                        foreach ($order_data as $data) {
                            if (strpos_arr($data["label"], $haystack) !== false) {
                                array_push($filtered_data, $data);
                            }
                        }
                        ?>
                        <h4 style="font-weight: bold;"><?php echo __("Skorstensinfo"); ?></h4>
                        <ul class="list-inline">
                            <?php foreach ($filtered_data as $filtered_data_entry) : ?>
                                <li><strong><?php echo $filtered_data_entry["label"]; ?>
                                        : </strong><?php echo $filtered_data_entry["value"]; ?></li>
                            <?php endforeach; ?>

                        </ul>
                        <strong><?php echo __("Genererat beställningsunderlag för leverantör"); ?></strong>
                        <div class="top-buffer-half" id="generated_order_notes"></div>
                    <?php
                            
                           
                             $nameofcustomer = get_user_meta($userid, 'fullname')[0];
					/* 	 . ' på address ' . get_user_meta($userid, 'billing_address_1')[0] . " " . get_user_meta($userid, 'billing_address_2')[0] . " " . get_user_meta($userid, 'billing_city')[0] . "" . get_user_meta($userid, 'billing_postcode')[0] . " " . get_user_meta($userid, 'billing_phone')[0] */
							//$myposts = get_posts(array('post_type'=> 'imm-sale-office'));
							 					$args = [
        'post_type' => 'imm-sale-office',
        'posts_per_page' => -1,
    ];
    $offices = new WP_Query($args);
                            ?>
                        <div class="col-lg-12" style="padding-left:0"	><div class="col-lg-4" style="padding-left:0"><h3>Leverans till:</h3><select name='customer_address' class='js-sortable-select form-control' id='customer_address'>
							<option value="">Välj leveransadress</option>
							 <option value="<?= "ram-".$userid ?>" ><?=$nameofcustomer?></option>
							<?php    while ($offices->have_posts()) { 
        $offices->the_post();
 ?> 
							
							<option value="<?php echo get_the_ID(); ?>"><?php echo get_the_title(); ?></option>
							<?php  }
							   wp_reset_query();  ?>
							  
							   </select></div>
							 
							   </div>
                        <?php
         $product_brands = return_sorted_product_list_based_on_brand($order->ID);

global $wpdb;


                        $project_id = get_post_meta($order->ID, 'imm-sale_project_connection', true);

                        $office_connection = get_post_meta($project_id, 'office_connection')[0];

                        foreach ($product_brands as $keys => $value) :

$getTermid = $wpdb->get_results("SELECT term_id FROM {$wpdb->prefix}termmeta WHERE `meta_key` = 'order_emailid' AND `meta_value` = '".$keys."'"); 

  $id = $getTermid[0]->term_id;
$newbrandname=[];
foreach($getTermid as $valu){

	 $get_cat_name = get_term_by('id',$valu->term_id,'item');
	 $newbrandname[] = $get_cat_name->name;
}
                            if ($value) :
 //$cat_id = get_term_by('name', $key, 'item');
   $cat_id = get_term_by('id', $id, 'item');
   $key= $cat_id->name;
                                $office_resellers = get_field('office_resellers', $office_connection);

                                foreach ($office_resellers as $reseller) {
                                    if (strtolower($reseller["single_reseller"]) == strtolower($key)) {
                                        $office_customer_number = $reseller["customer_number"];
                                    } else {
                                        $office_customer_number = "";
                                    }
                                }
                                $rbrand = str_replace(' ', '', $key);
                                ?>
                                <h3 class=""><?php echo implode(',',$newbrandname);  ?></h3>
                                <a data-brands="<?php echo $rbrand ?>" data-id="<?php echo $cat_id->term_id; ?>" class="generate_external_order_notes"
                                   href="#"><?php echo __("Generera underlag för beställning"); ?></a>
                                <h4 class=""><?php echo __("Kundnummer: ") . $office_customer_number; ?></h4>
                                <table class="table" id="<?php echo $rbrand; ?>" data-brand="<?php echo $key ?>">
                                    <thead>
                                        <tr>
                                            <th><?php echo __("Checkboxar"); ?></th>
                                            <th><?php echo __("Antal"); ?></th>
                                            <th><?php echo __("Art.nr"); ?></th>
                                            <th><?php echo __("Produktnamn"); ?></th>
                                            <th><?php echo __("Notering"); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody class="tbody">

                                        <?php
                                        $order = wc_get_order($order->ID);


                                        //print_r($order->get_items());
                                        //die();
                                        // Iterating through each "line" items in the order
                                        foreach ($order->get_items() as $item_id => $item_data) {

                                            $is_ordered_from_reseller = wc_get_order_item_meta($item_id, 'is_ordered_from_reseller');
                                            $quantity = wc_get_order_item_meta($item_id, '_qty');
                                            $line_item_note = wc_get_order_item_meta($item_id, 'line_item_note_internal');


                                            $line_item_is_ordered = wc_get_order_item_meta($item_id, 'line_item_is_ordered');
                                            $line_item_is_ordered_date = wc_get_order_item_meta($item_id, 'line_item_is_ordered_date');
                                            $line_item_order_recognition_received = wc_get_order_item_meta($item_id, 'line_item_order_recognition_received');
                                            $line_item_order_recognition_received_date = wc_get_order_item_meta($item_id, 'line_item_order_recognition_received_date');
                                            $line_item_order_goods_at_home = wc_get_order_item_meta($item_id, 'line_item_order_goods_at_home');
                                            $line_item_order_goods_at_home_date = wc_get_order_item_meta($item_id, 'line_item_order_goods_at_home_date');
                                            $line_item_order_delivered = wc_get_order_item_meta($item_id, 'line_item_order_delivered');
                                            $line_item_order_delivered_date = wc_get_order_item_meta($item_id, 'line_item_order_delivered_date');
                                            $line_item_order_rest = wc_get_order_item_meta($item_id, 'line_item_order_rest');
                                            $line_item_order_rest_date = wc_get_order_item_meta($item_id, 'line_item_order_rest_date');

                                            // get order item meta data (in an unprotected array)
                                            // Get an instance of corresponding the WC_Product object
                                            /*      echo '<pre>';
                                              var_dump($item_data);die;
                                              echo '</pre>'; */
                                            $product_variation_id = $item_data['variation_id'];
                                            if ($product_variation_id) {
                                                $products = new WC_Product($item_data['variation_id']);
                                            } else {
                                                $products = new WC_Product($item_data['product_id']);
                                            }
                                            $product = $item_data->get_product();

                                            $product_name = $item_data['name']; // Get the product name

                                            $product_sku = $products->get_sku();
                                            $item_quantity = $item_data['quantity']; // Get the item quantity
                                            ?>

                                            <?php if (in_array($item_data['product_id'], $value)) {
                                                ?>
                                                <tr id="<?php echo $item_id; ?>" class="line_item_row" >

                                                    <td><a href="#" data-toggle-id="checkbox_row_<?php echo $item_id; ?>"
                                                           id=""
                                                           class="toggles"><i
                                                                class="fa fa-angle-double-down" aria-hidden="true"></i>
                                                                <?php echo __("Visa"); ?>
                                                        </a>
                                                    </td>
                                                    <td id="<?php echo "qty_" . $item_data['product_id']; ?>" class="qty"><?php echo $item_quantity ?></td>
                                                    <td id="<?php echo "sku_" . $item_data['product_id']; ?>" class="sku"><?php echo $product_sku ?></td>
                                                    <td id="<?php echo "name_" . $item_data['product_id']; ?>" class="name"><?php echo $product_name ?></td>
                                                    <td><input class="<?php echo "Noteringval_" . $item_data['product_id']; ?>" id="Noteringval" type="text" name="line_item_note[<?php echo $item_id; ?>]"
                                                               value="<?php echo $line_item_note; ?>"></td>


                                                </tr>
                                                <tr style="display:none" id="checkbox_row_<?php echo $item_id; ?>">


                                                    <td>
                                                        <input class="order-checkbox" value="<?php echo $item_data['product_id']; ?>" <?php
                                                        if ($line_item_is_ordered) {
                                                            echo " checked ";
                                                        }
                                                        ?>
                                                               name="line_item_is_ordered[<?php echo $item_id; ?>]"
                                                               type="checkbox" data-brand="<?php echo str_replace(' ', '', $key) . "Bestalltval"; ?>">
                                                        <strong><?php echo __("Beställt") ?></strong>
                                                        <input data-brands="<?php echo str_replace(' ', '', $key) . "Bestalltval"; ?>" data="<?php echo "Bestalltval_" . $item_data['product_id']; ?>" id="Bestalltval" class="datebox"
                                                               name="line_item_is_ordered_date[<?php echo $item_id; ?>]"
                                                               type="date"
                                                               value="<?php echo $line_item_is_ordered_date; ?>">
                                                    </td>

                                                    <td>
                                                        <input value="<?php echo $item_data['product_id']; ?>" class="order-checkbox" <?php
                                                        if ($line_item_order_recognition_received) {
                                                            echo " checked ";
                                                        }
                                                        ?>
                                                               name="line_item_order_recognition_received[<?php echo $item_id; ?>]"
                                                               type="checkbox" data-brand="<?php echo str_replace(' ', '', $key) . "Ordererkannande"; ?>">
                                                        <strong><?php echo __("Ordererkännande") ?></strong>
                                                        <input data-brands="<?php echo str_replace(' ', '', $key) . "Ordererkannande"; ?>"data="<?php echo "Ordererkannande_" . $item_data['product_id']; ?>" id="Ordererkannande" class="datebox"
                                                               name="line_item_order_recognition_received_date[<?php echo $item_id; ?>]"
                                                               type="date"
                                                               value="<?php echo $line_item_order_recognition_received_date ?>">
                                                    </td>

                                                    <td>
                                                        <input value="<?php echo $item_data['product_id']; ?>" class="order-checkbox" <?php
                                                        if ($line_item_order_goods_at_home) {
                                                            echo " checked ";
                                                        }
                                                        ?> 
                                                               name="line_item_order_goods_at_home[<?php echo $item_id; ?>]"
                                                               type="checkbox" data-brand="<?php echo str_replace(' ', '', $key) . "Varorval"; ?>">
                                                        <strong><?php echo __("Planerad leverans") ?></strong>
                                                        <input data-brands="<?php echo str_replace(' ', '', $key) . "Varorval"; ?>" data="<?php echo "Varorval_" . $item_data['product_id']; ?>"  id="Varorval" class="datebox"
                                                               name="line_item_order_goods_at_home_date[<?php echo $item_id; ?>]"
                                                               type="date"
                                                               value="<?php echo $line_item_order_goods_at_home_date; ?>">
                                                    </td>
                                                    <td>
                                                        <input value="<?php echo $item_data['product_id']; ?>" class="order-checkbox" <?php
                                                        if ($line_item_order_delivered) {
                                                            echo " checked ";
                                                        }
                                                        ?>
                                                               name="line_item_order_delivered[<?php echo $item_id; ?>]"
                                                               type="checkbox" data-brand="<?php echo str_replace(' ', '', $key) . "Levereratval"; ?>">
                                                        <strong><?php echo __("Levererat") ?></strong>
                                                        <input data-brands="<?php echo str_replace(' ', '', $key) . "Levereratval"; ?>" data="<?php echo "Levereratval_" . $item_data['product_id']; ?>" id="Levereratval" class="datebox"

                                                               name="line_item_order_delivered_date[<?php echo $item_id; ?>]"
                                                               type="date"
                                                               value="<?php echo $line_item_order_delivered_date; ?>">
                                                    </td>
                                                    <td>
                                                        <input value="<?php echo $item_data['product_id']; ?>" class="order-checkbox" <?php
                                                        if ($line_item_order_rest) {
                                                            echo ' checked ';
                                                        }
                                                        ?>
                                                               name="line_item_order_rest[<?php echo $item_id; ?>]"
                                                               type="checkbox" data-brand="<?php echo str_replace(' ', '', $key) . "Restaval"; ?>">
                                                        <strong><?php echo __("Resta") ?></strong>
                                                        <input data-brands="<?php echo str_replace(' ', '', $key) . "Restaval"; ?>" data="<?php echo "Restaval_" . $item_data['product_id']; ?>" id="Restaval" class="datebox"
                                                               name="line_item_order_rest_date[<?php echo $item_id; ?>]"
                                                               type="date"
                                                               value="<?php echo $line_item_order_rest_date; ?>">
                                                    </td>


                                                    <td class="store_cust" style="display:none">
                                                        <strong>Delivery(Leverans till)</strong>

                                                        <select id="store_Address">
                                                            <option value="Store/Customer Address">Store/Customer Address</option>
                                                            <option id="myInput" value="" data="<?php echo $item_data['product_id']; ?>"></option>
                                                            <option  id="myInput1" value="1" data="<?php echo $item_data['product_id']; ?>"><?php echo $getAdresss; ?></option>
                                                          <!-- <option id="Adress" value="<?php // echo get_user_meta($current_customer_idddd, 'billing_address_1')[0];                     ?>">
                                                           </option> -->


                                                        </select>


                                                    </td>  </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>

                                </table>


                                <?php
                            endif;
                        endforeach;
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <?php  $orderaccept = get_post_meta($order->get_id(), 'order_accept_status', true); 
        if ($orderaccept != 'true' && $orderaccept != 'Acceptavkund') {
                ?>
        <div class="row">

            <div class="col-md-12 text-center">

                <a href="#" id="delete-estimate" data-order-id="<?php echo $order->get_id(); ?>"
                   class=""><?php echo __("Ta bort") . " " . strtolower($invoice_or_order); ?></a>


            </div>

            <!--            <div class="col-md-12 text-center">
            
                            <a href="#" id="delete-project-estimate" data-project-id="<?php // echo $project_id;    ?>"
                               class=""><?php // echo __("delete project");    ?></a>
            
            
                        </div>-->

        </div>
        <?php } ?>
    </div>

    <?php
    die;
}
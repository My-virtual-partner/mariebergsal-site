<!-- Begin Inspectlet Asynchronous Code -->
<?php
/**
 * This file is used to render all the steps when a new invoice is created.
 * TODO: Change some logic regarding the "step" parameter.
 */
include_once(plugin_dir_path(__FILE__) . 'head.php');

$current_user_role = get_user_role();

//$steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);

$project_type_id = get_field('order_project_type', $_GET["order-id"]);

$newvalue = modify_projectType($project_type_id);

$newproject = get_field($newvalue, 'options');

//$current_user_steps = in_array_r($project_type_id, $steps);
//print_r($current_user_steps);


$current_step = $_GET["step"];
$order_id = $_GET["order-id"];

//$new_steps = in_array_r($project_type_id, $steps, true);
$new_steps = in_array_r($project_type_id, $newproject, true);

$order_json_data = get_post_meta($order_id, 'orderdata_json');
$json_data_as_array = json_decode($order_json_data[0], JSON_PRETTY_PRINT);

$locked = true;

$total_steps = count($new_steps["steps"]);
$check = $new_steps['steps'][0]['input_falt'][0]['hembesok_newlead']['0'];


if ($check == 1) {
    if (empty($leadid)) {
        $total_steps = count($new_steps["steps"]);
    } else {
        $total_steps = count($new_steps["steps"]) - 1;
    }
}


$wc_order_statuses = wc_get_order_statuses();
$wc_order = new WC_Order();
$order_status = "wc-" . $wc_order->get_status();
$url = "order-steps?order-id=" . $order_id . "&step=";
$customer_information_url = "order-steps?order-id=" . $order_id;

if ($current_step > $total_steps) {
    header('Location:' . $url . ($total_steps));
    exit;
}
$project_locked_status = get_post_meta($order_id, 'project_locked_status', true);
?>
<div class="container-fluid project_main_div">

    <div>
        <button class="btn brand info_steps_btn " data-toggle="modal" data-target="#stepsModalLong"
                style="float: left!important;left: 20px;top:120px!important;position: fixed;z-index: 999;"><i
                class="fa fa-info fa-2x" style="color: #fafafa"></i></button>
        <!-- Modal -->
        <div class="modal fade" id="stepsModalLong" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="    width: 800px;">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Info om alla steg</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body help_offert_section">
                        <div>
                            <input type="button" value="Steg" id="steps_btn_modal" class="btn btn-brand">
                            <input type="button" value="Mer info" id="mer_info_btn_modal" class="btn btn-brand">
                            <input type="button" class="btn btn-brand" value="Räkna ut TB"
                                   id="retail_price_differentt">
                            <input type="button" class="btn btn-brand" value="Hur ROT beräknats "
                                   id="how_calculate_rut">
                        </div>
                        <div id="help_info_modal" style="display: none;margin-top: 10px;">
                            <?php
                            echo get_field('order_help_description', 'options');
                            ?>
                        </div>
                        <div id="steps_info_modal" style="display: block;margin-top: 10px;">
                            <?php
                            $project_roles_steps = modify_projectType(null);
                            $project_type = get_field('order_project_type', $order_id);

                            $project_type1 = $project_type;
                            foreach ($project_roles_steps as $single_step => $value) {
                                if ($project_type === $single_step):

                                    $i = 0;
                                    foreach ($new_steps['steps'] as $step):
                                        ?>

                                        <div style="padding-top: 10px;padding-bottom: 10px;">
                                            <strong>Steg <?php echo($i + 1); ?> : </strong><a
                                                href="/order-steps?order-id=<?php echo $order_id; ?>&step=<?php echo $i; ?>"
                                                style="color: #303030;"><?php echo $step['step_heading']; ?></a>
                                            <br>

                                        </div>

                                        <?php
                                        $i++;

                                    endforeach;
                                endif;
                            }
                            echo ' <strong>Steg ' . ($total_steps + 1) . ': </strong><a href="/order-steps?order-id=' . $order_id . '&step=' . $total_steps . '" style="color: #303030;">PI</a><br>';

                            /*  get_project_types_project_select( $project_roles_steps, "select_invoice_type" ); */
                            ?>

                        </div>
                        <div id='price_table_pid' style="display:none;">
                            <table class="table table-striped table-hover " style="margin-top: 20px; table-layout: fixed;">
                                <thead>
                                    <tr>
                                        <th>Namn</th>
                                        <th class="price-product">Pris ex moms</th>
                                        <th class="price-product">Moms</th>
                                        <th class="price-product">Totalt</th>
                                        <th class="price-product">Inköpspris</th>
                                        <th class="price-product">TB</th>
                                    </tr>
                                </thead>



                                <tbody>

                                    <?PHP
                                    global $product;
                                    $order = wc_get_order($order_id);
                                    $items = $order->get_items();

                                    $rrp_array = array();


                                    foreach ($items as $item) :
//                                        print_r($item);
                                        $product_id = $item['product_id'];
                                        if (!empty($item['internal_cost'])) {
                                            $rrp_price = $item['internal_cost'];
                                        } else {
//                                            echo"<br>";
//                                            echo $product_id;
                                            $rrp_price = str_replace(',', '', get_field('inkopspris_exkl_moms', $product_id));
                                        }
                                        if (!empty($item['line_item_note'])) {
                                            $product_name = $item['name'] . ' - ' . $item['line_item_note'];
                                        } else {
                                            $product_name = $item['name'];
                                        }


                                        $product_variation_id = $item['variation_id'];
//    $rrp_price = str_replace(',', '', get_field('inkopspris_exkl_moms', $product_id));
                                        $sale_price = get_post_meta($product_id, '_sale_price', true);
                                        $forskottfaktura_product_id = get_field('prepayment_deduction_invoice_product_id', 'option');
                                        //to not include forsköttfaktura in the tb
                                        if ($product_id != $forskottfaktura_product_id) {

                                            $product_price_array = array(
                                                'product_id' => $product_id,
                                                'product_name' => $product_name,
                                                'rrp_price' => $rrp_price,
                                                'regular_price' => $item['subtotal'],
                                                'tax_price' => $item['total_tax'],
                                                'sale_price' => $sale_price
                                            );
                                            array_push($rrp_array, $product_price_array);
                                        }
                                    endforeach;
                                    $newreg = 0;
                                    $newtax = 0;
                                    $newtotal = 0;
                                    $newrrp = 0;
                                    foreach ($rrp_array as $single_rrp_array):
                                        $product_id = $single_rrp_array['product_id'];
                                        $product_name = $single_rrp_array['product_name'];
                                        $rrp_prices = $single_rrp_array['rrp_price'];

                                        $regular_price = $single_rrp_array['regular_price'];
                                        $tax_price = $single_rrp_array['tax_price'];
                                        $total_price = $regular_price + $tax_price;
                                        $percentage = ($rrp_prices * 100) / $regular_price;

                                        $newreg += $regular_price;
                                        $newtax += $tax_price;
                                        $newtotal += $total_price;
                                        $newrrp += $rrp_prices;
                                        if ($single_rrp_array['sale_price']):
                                            $sale_price = $single_rrp_array['sale_price'];
                                        endif;
                                        ?>

                                        <tr>
                                            <td width="10%"><?php echo $product_name ?></td>
                                            <td><?php echo wc_price($regular_price); ?></td>
                                            <td><?php echo wc_price($tax_price); ?></td>
                                            <td><?php echo wc_price($total_price); ?></td>
                                            <td><?php echo wc_price($rrp_prices); ?></td>
                                            <td class="tb_class"><?php echo wc_price($regular_price - $rrp_prices); ?></td>


                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                <tfoot style="color:red">
                                    <tr>
                                        <td width="10%">Totalt:</td>
                                        <td class="total_class"><?php echo wc_price($newreg); ?></td>
                                        <td class="total_class"><?php echo wc_price($newtax); ?></td>
                                        <td class="total_class"><?php echo wc_price($newtotal); ?></td>
                                        <td class="total_class"><?php echo wc_price($newrrp); ?></td>
                                        <td class="total_class"><?php echo wc_price($newreg - $newrrp); ?></td>


                                    </tr>
                                </tfoot>

                                </tbody>

                            </table>
                        </div>
                        <div id='rot_how' style="display:none;margin-top: 20px;">
                            <?php
                            $order = new WC_Order($order_id);
                            $order_total_price = $order->get_total();

                            $ROT = get_field('imm-sale-tax-deduction', $order->get_id());

                            $ROT_PERCENTAGE = get_post_meta($order->get_id(), "confirmed_rot_percentage", true);

                            if (get_field('imm-sale-tax-deduction', $order->get_id()) || get_post_meta($order->get_id(), "confirmed_rot_percentage", true)) {
                                $rot_avdrag = get_post_meta($order->get_id(), "confirmed_rot_percentage", true);
                                $display_price = $order_total_price - $rot_avdrag;
                            } else {
                                $rot_avdrag = 0;
                                $display_price = $order_total_price;
                            }

                            echo '<strong>ROT beräkning</strong>';
                            echo '<table class="table"><body><thead><tr><td>Namn</td><td>Moms</td><td>Ex moms</td><td>Ink moms</td></tr></thead>';
                            $selected_cat_sum = false;
                            $selected_product_category_for_price_adjustment = get_field('selected_product_category_for_price_adjustment', 'options'); //choosen category from admon panel
                            foreach ($order->get_items() as $order_item_id => $item) {
                                $product_id = version_compare(WC_VERSION, '3.0', '<') ? $item['product_id'] : $item->get_product_id();

                                $terms = get_the_terms($product_id, 'product_cat');

                                foreach ($terms as $term) {


                                    if (in_array($term->term_id, $selected_product_category_for_price_adjustment)) {
                                        echo '<tr><td>' . $item['name'] . '</td><td>' . $item['subtotal_tax'] . '</td><td>' . $item['subtotal'] . '</td><td>' . ($item['subtotal_tax'] + $item['subtotal']) . '</td></tr>';

                                        $selected_cat_sum = $selected_cat_sum + ($item->get_total() + $item->get_total_tax());
                                    }
                                }
                            };


                            $selected_cat_sum_percented = (($selected_cat_sum * 30) / 100);
                            echo '<br>';
                            echo 'Totalt: ' . $selected_cat_sum . ' * 30 / 100 = ' . $selected_cat_sum_percented;
                            echo '<br>';
                            if ($ROT <= $selected_cat_sum_percented) {

                                echo 'ROT är ' . $ROT . ' eftersom det är mindre än ' . $selected_cat_sum_percented;
                            } elseif ($ROT > $selected_cat_sum_percented) {
                                echo 'ROT är ' . $selected_cat_sum_percented . ' vilken är 30% av totala arbetskosnaden.Uppgift max ROT belopp är:  ' . $ROT;
                            }

                            echo '<tfoot><tr><td></td><td></td><td></td><td style="color:red;">' . $selected_cat_sum . '</td></tr></tfoot>'
                            ?>
                            </body></table>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="color:#fafafa">
                            Stäng
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-lg-12">
            <form id="invoice-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="order-handle" value="true">
                <input type='hidden' id='grid_or_list' value='0'>
                <input type='hidden' id='save_order' value='' name="save_order">
                <input type='hidden' id='next_stepgo' value='' name="next_stepgo">
                <input type='hidden' id='step_no' value='<?php echo $_GET['step'] ?>'>
                <input type="hidden" name="project-type" value="<?php echo $project_type_id; ?>">
                <input type="hidden" id="order_id" name="order_id" value="<?php echo $_GET["order-id"]; ?>">

                <?php if ($current_step === 'no') : ?>
                    <input type="hidden" name="no" value="true">
                <?php endif; ?>

                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($order_id) : ?>
                            <?php if ($current_step !== 'no') : ?>
                                <div class="stepwizard">
                                    <div class="stepwizard-row">
                                        <?php
                                        for ($i = 0; $i < $total_steps; $i++) :
                                            $this_step = $i;

                                            $completed_step_value = $json_data_as_array["imm-sale-value_step_completed_" . create_id_from_name(strtolower($new_steps["steps"][$this_step]["step_heading"]))]["value"];

                                            $stepwizard_completed_class = "";

                                            if ($completed_step_value == 3) {
                                                $stepwizard_completed_class = " stepwizard-completed-3 ";
                                            } elseif ($completed_step_value == 0) {
                                                $stepwizard_completed_class = " stepwizard-completed-no ";
                                            } elseif ($completed_step_value == 1) {
                                                $stepwizard_completed_class = " stepwizard-completed-yes ";
                                            } elseif ($completed_step_value == 2) {
                                                $stepwizard_completed_class = " stepwizard-completed-between ";
                                            }
                                            ?>
                                            <div class="stepwizard-step">
                                                <a href="<?php echo $url . $this_step; ?>"
                                                   class="btn btn-default btn-circle  <?php
                                                   echo $stepwizard_completed_class;
                                                   if (isset($current_step) && $this_step === (int) $current_step) {
                                                       echo "stepwizard-active";
                                                   }
                                                   ?>"><?php echo $this_step + 1; ?></a>
                                            </div>

                                        <?php endfor; ?>
                                        <div class="stepwizard-step">
                                            <a href="<?php echo $url . ($total_steps); ?>"
                                               class="btn btn-default btn-circle <?php
                                               if ($current_step == ($total_steps)) {
                                                   echo "stepwizard-active";
                                               }
                                               ?>"><?php echo __("PI"); ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>


                    <div class="row top-buffer">
                        <div class="col-lg-4 col-md-8 col-sm-7">
                            <?php
                            $order_project = get_field('imm-sale_project_connection', $_GET['order-id']);
                            $current_customer_id = get_field('invoice_customer_id', $order_project);
                            $custom_order_number = get_post_meta($order_id, 'custom_order_number', true);
                            ?>

                            <ul class="list-unstyled">
                                <li>
                                    <a href="" id="submit-order"><?php echo __("Gå tillbaka till projektet") ?></a>
                                </li>
                                <li><strong><?php echo "#" . $custom_order_number; ?></strong></li>
                                <li><?php echo __('Kund: ') . "<strong>" . $current_customer_id . " - " . getCustomerName($current_customer_id) . "</strong>"; ?>
                                </li>
                                <li>
                                    <a target="_blank" href="<?php echo "/customer-edit?customer-id=" . $current_customer_id ?>"><?php echo __("Redigera kunduppgifter") ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-8 col-md-4 col-sm-5 row no-padding-right">

                            <div class="col-lg-3">
                                <label for="project_locked_status"><?php echo __("Lås projekt") ?></label>
                                <select id="project_locked_status" name="project_locked_status"
                                        class="form-control js-sortable-select">
                                    <option <?php
                                    if ($project_locked_status == 0) {
                                        echo " selected ";
                                    }
                                    ?> value="0">Öppet
                                    </option>
                                    <option <?php
                                    if ($project_locked_status == 1) {
                                        echo " selected ";
                                    }
                                    ?> value="1">Låst
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-3">
                                <label for="project_type"><?php echo __("Typ av projekt") ?></label>

                                <select id="project_type" name="project_type" class="form-control js-sortable-select">
                                    <?php
                                    $project_roles_steps = modify_projectType(null);
//                                        $project_roles_steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);
                                    foreach ($project_roles_steps as $key => $value) :
                                        ?>


                                        <option <?php
                                if ($project_type_id == $key) {
                                    echo " selected ";
                                }
                                        ?>
                                            value="<?php echo $key; ?>"><?php echo get_option('options_' . $value . '_0_project_type_name', 'options'); ?>
                                        </option>


                                    <?php endforeach; ?>


                                </select>
                            </div>
                            <?php // if($project_type1=="hem_visit_sale_system"){
                            ?>
                            <div class="col-lg-3 ">
                                <?php
                                $current_department = get_field('order_current_department', $order_project);

                                get_salesman_dropdown($order_project, 'sales_names', null, $current_department, false);
                                ?>
                            </div>
                            <?php //}   ?>
                            <div class="col-lg-3 ">
                                <?php
                                $current_department = get_field('order_current_department', $order_project);

                                get_departments_dropdown("imm-sale-order-department-steps", null, $current_department, false);
                                ?>
                            </div>

                        </div>
                    </div>
                    <hr>

                <?php endif; ?>
                <?php
                $step = $_GET["step"];

                $order_json_data = get_post_meta($_GET['order-id'], 'orderdata_json');
                $json_data_as_array = json_decode($order_json_data[0], JSON_PRETTY_PRINT);
                $fields_array = $new_steps["steps"];


                $html_completed_dropdown = "<div class='row'><div class='col-sm-4' id='markera_steg_som'>";
                /* 	$html_completed_dropdown .= "<label for=''>" . __( "Markera steg som" ) . "</label>"; */
                $html_completed_dropdown .= "<input value='' type='hidden' name='imm-sale-label_step_completed_" . create_id_from_name(strtolower($fields_array[$step]["step_heading"])) . "'>";

                $html_completed_dropdown .= "<select class='form-control done_notdone_pending' id='imm-sale-value_step_completed_" . create_id_from_name(strtolower($fields_array[$step]["step_heading"])) . "' name='" . "imm-sale-value_step_completed_" . create_id_from_name(strtolower($fields_array[$step]["step_heading"])) . "'>";

                $completed_step_value = $json_data_as_array["imm-sale-value_step_completed_" . create_id_from_name(strtolower($fields_array[$step]["step_heading"]))];
//print_r(completed_step_value);

                $selected_0 = "";
                $selected_1 = "";
                $selected_2 = "";

                if ($completed_step_value == 0) {
                    $selected_0 = " selected ";
                } elseif ($completed_step_value == 1) {
                    $selected_1 = " selected ";
                } elseif ($completed_step_value == 2) {
                    $selected_2 = " selected ";
                }


                $html_completed_dropdown .= "<option " . $selected_0 . " value='0' >" . __("Steget ej klart") . "</option>";
                $html_completed_dropdown .= "<option " . $selected_2 . " value='2' >" . __("Steget ej aktuellt") . "</option>";
                $html_completed_dropdown .= "<option " . $selected_1 . " value='1' >" . __("Steget klart") . "</option>";
                $html_completed_dropdown .= "</select>";
                $html_completed_dropdown .= "</div>";
                $html_completed_dropdown .= "</div>";
                $html_completed_dropdown .= "<br>";

                echo $html_completed_dropdown;
                ?>
                <div class="row next_back_row">
                    <?php
                    $offset_class = " col-lg-offset-9  col-md-offset-8 col-sm-offset-6";

                    if (isset($current_step) && $current_step != 0) :
                        $offset_class = " col-lg-offset-6  col-md-offset-4 col-sm-offset-0";
                        ?>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-sm-offset-0">
                            <input value="<?php echo __("&laquo; Spara och gå tillbaka") ?>" type="submit"
                                   name="back-step" class="btn btn-alpha steps-btn btn-block"
                                   id="">
                        </div>
                    <?php endif; ?>



                    <?php
                    if ($current_step == ($total_steps)) :
                        $order_accept_status = get_post_meta($order_id, 'order_accept_status', true);
                        ?>

                        <div class="col-lg-6 col-md-4  col-sm-3">
                            <div class="col-lg-4">
                               
                                <select id="order-customer-status" class=' form-control js-sortable-select' name="order-customer-status">
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
                                    <option value="false"  <?php
                                    if ($order_accept_status === "false") {
                                        echo "selected";
                                    }
                                    ?> >Nekad av kund</option>
                                    <option value="Kundfråga" <?php
                                    if ($order_accept_status === "Kundfråga") {
                                        echo "selected";
                                    }
                                    ?> >Kund har frågor</option><option value="archieved" <?php
                                            if ($order_accept_status === "archieved") {
                                                echo "selected";
                                            }
                                            ?> >Arkiverad kopia</option><option value="Acceptavkund" <?php
                                            if ($order_accept_status === "Acceptavkund") {
                                                echo "selected";
                                            }
                                            ?> >Accepterad av kund</option>
                                </select></div>
                            <div class="col-lg-4">
                                <input type="checkbox" name="notemail" value="1" <?php
                                if (in_array($order_accept_status, array("Kundfråga", "false", "true", "archieved"))) {
                                    echo "checked";
                                }
                                ?> />	Skicka inte orderbekräftelse</div>
                            <div class="col-lg-4"><?php
                                $project_status = get_post_meta($order_project, "imm-sale-project")[0];
                                get_project_status_dropdown("order-by-this-project-status", $table_name, "top-buffer-half hidelabelorder", '', $project_status);
                                ?>
                            </div>

                        </div>

                        <input type="hidden" name="complete-project" value="true">
                        <input type="hidden" name="save-back-button" value="true">
                        <div class="col-lg-3 col-md-4  col-sm-3 ">
                            <input value="<?php echo __("Spara"); ?>"
                                   type="submit"
                                   name="forward-step" class="btn btn-alpha btn-show-overlay steps-btn btn-block"
                                   id="affarsforslaget_pi_id">
                        </div>

                    <?php elseif ($current_step === 'no') : ?>
                        <div class="col-lg-3 <?php echo $offset_class; ?> col-md-4 col-sm-6">
                            <input value="<?php echo __("Spara"); ?>" type="submit"
                                   class="btn btn-brand steps-btn btn-block"
                                   id="">
                        </div>
                    <?php else : ?>
                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <input value="<?php echo __("Spara & gå vidare &raquo;"); ?>" type="submit"
                                   name="forward-step"
                                   class="spara_och_fortsatt btn  btn-alpha btn-show-overlay btn-block"
                                   id="">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row top-buffer <?php
                if ($project_locked_status == 1) {
                    echo "locked ";
                }
                ?>">
                         <?php
                         render_fields_for_new_projects($new_steps["steps"], $project_type_id);
                         ?>

                    <!-- </div>-->
                    <?php if ($current_step == ($total_steps)) { ?>

                        <div class="col-md-7 col-sm-7">

                            <div class="col-lg-5 col-md-4  col-sm-3 " style="margin-top: 5em;">
                                <input value="<?php echo __("Spara"); ?>"
                                       type="submit"
                                       name="forward-step" class="btn btn-alpha btn-show-overlay steps-btn btn-block"
                                       id="affarsforslaget_pi_id">
                            </div>

                        </div>
                    <?php } ?>
                    <hr>

                    </form>

                </div>
        </div>
    </div>
    <input type="hidden" id="orderidSort" value="<?php echo $_GET['order-id']; ?>" /> 
    <?php
    $firstSort = get_post_meta($_GET['order-id'], 'firstSort', true);
    if ($firstSort) {
        ?>
        <script>
            jQuery(document).ready(function () {
                var orderId = jQuery('#orderidSort').val();

                function newupdatesortOrder(data, orderid, head = false) {

                    jQuery.ajax({
                        url: '/wp-content/plugins/imm-sale-system/ajax/sortorderitems.php',
                        type: 'POST',
                        data: {position: data, orderid: orderid, head, head},
                        success: function (result) {
                        }
                    })
                }
                var headData = new Array();
                jQuery('ul#product-list_head .sortingorder').each(function () {
                    headData.push(jQuery(this).attr("data-attribute-line-item-ids"));

                });
                var sortData = new Array();
                jQuery('ul#product-list .sortingorder').each(function () {
                    sortData.push(jQuery(this).attr("data-attribute-line-item-ids"));
                });

                newupdatesortOrder(headData, orderId, 'head');
                newupdatesortOrder(sortData, orderId);

            });
        </script>
    <?php
    }
    update_post_meta($_GET['order-id'], 'firstSort', '');
    $gethousehold = get_post_meta($_GET['order-id'], 'household_vat_discount_json', true);

    $counthouse = json_decode($gethousehold, true);
    $count = 0;
    foreach ($counthouse as $key => $value) {
        if (!empty($value)) {
            $count++;
        }
    }



    $tax_deduction = get_post_meta($_GET['order-id'], "imm-sale-tax-deduction", true);
    $conf_deduction = get_post_meta($_GET['order-id'], "confirmed_rot_percentage", true);
    if (empty($tax_deduction) || $tax_deduction == 0 || $count == 0) {
        delete_post_meta($_GET['order-id'], "confirmed_rot_percentage", $conf_deduction);
    }

    if ($project_locked_status == 1) {
        return_locked_script();
    }

    wp_footer();
    ?>
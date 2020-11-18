<?php

/**
 * Render custom fields from the configured invoice types.
 *
 * @param $fields_array
 * @param $project_type_id
 */
function render_fields_for_new_project($fields_array, $project_type_id) {
    $current_user_role = get_user_role();

    $steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);

    $new_steps = in_array_r($project_type_id, $steps, true);

    $current_step = $_GET["step"];
    $total_steps = count($new_steps["steps"]);

    $order_id = $_GET['order-id'];
    $step = $_GET["step"];

    $order_json_data = get_post_meta($order_id, 'orderdata_json');
    $json_data_as_array = json_decode($order_json_data[0], JSON_PRETTY_PRINT);
    $order = wc_get_order($_GET["order-id"]);

    if ($step === null) {
    } elseif ((int) $current_step === ($total_steps)) {
        include('templates/create-project-summary.php');
    } elseif ($step === 'no') {

        echo "<div class='steps-page col-md-8 col-sm-7'>";


        foreach ($fields_array as $key => $value) {
            echo "<a class='btn btn-alpha btn-block top-buffer-half toggle-btn' data-toggle='collapse' href='#form-field_" . $key . "' role='button' aria-expanded='false'><i class='fa fa-chevron-down fa-lg' aria-hidden='true'></i>  " . $fields_array[$key]["step_heading"] . "</a>";
            echo "<input type='hidden' name='step-heading' value='" . $fields_array[$key]["step_heading"] . "'>";
            echo "<div class='row collapse multi-collapse' id='form-field_" . $key . "'>";
            foreach ($fields_array[$key] as $field) {

                foreach ($field as $single_field) {

                    if ($single_field["acf_fc_layout"] == "textbox") {
                        render_textbox($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                    } elseif ($single_field["acf_fc_layout"] == "text_area") {
                        render_text_area($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                    } elseif ($single_field["acf_fc_layout"] == "dropdown") {

                        render_dropdown($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                    } elseif ($single_field["acf_fc_layout"] == "file") {

                        render_file_input($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                    } elseif ($single_field["acf_fc_layout"] == "webshop") {

                        render_webshop($single_field["webshop_show_category_dropdown"], $single_field["webshop_category"], $single_field["required"]);
                    } elseif ($single_field["acf_fc_layout"] == "file_uploaded") {
                        render_file_upload($_GET['order-id']);
                    } elseif ($single_field["acf_fc_layout"] == "price_adjustment") {

                        include('templates/create-price-adjustments.php');
                    } elseif ($single_field["acf_fc_layout"] == "price_adjustment_lista") {

                        include('templates/listacreate-price-adjustments.php');
                    } elseif ($single_field["acf_fc_layout"] == "tax_deduction") {

                        include('templates/create-tax-deduction.php');
                    } elseif ($single_field["acf_fc_layout"] == "service_before_pi") {


                        include('fields/type_service.php');
                    } elseif ($single_field["acf_fc_layout"] == "hembesok") {

                        include('templates/create-lead_project.php');
                    }
                }
            }

            echo "</div>";
            include('fields/product-modal.php');

            echo "<hr>";
        }

        echo "<a class='btn btn-alpha btn-block top-buffer-half toggle-btn' data-toggle='collapse' href='#form-field_project_summary' role='button' aria-expanded='false'><i class='fa fa-chevron-down fa-lg' aria-hidden='true'></i>  " . __("Projektinformation") . "</a>";
        echo "<div class='row collapse multi-collapse' id='form-field_project_summary'>";
        echo "<div class='col-md-12 col-sm-12 top-buffer-half'>";
        include('templates/project-summary-part.php');
        echo "</div>";
        echo "</div>";


        echo "</div>";
        echo "<div class='col-md-4 col-sm-5'>";

        get_order_information_list($order, $json_data_as_array);


        echo "</div>";
    } else {

        $editing_status = get_field('editing_status_mb', $order_id);
        $editing_by = get_field('edited_by_mb', $order_id);
        $userid = get_user_by('login', $editing_by);
        $username = showName($userid->ID);

        if ($editing_status) {
            echo '<div class="alert alert-danger alert_redigera" role="alert">
 Denna redigeras just nu av ' . $username . '. Glöm inte att trycka på "spara" i steget "PI".
</div>';
        }


        echo "<div class='steps-page col-md-7 col-sm-7'>";
        echo "<h3>" . $fields_array[$step]["step_heading"] . "</h3>";


        /* $html_completed_dropdown = "<div class='row'><div class='col-sm-12' id='markera_steg_som'>";
        
        $html_completed_dropdown .= "<input value='' type='hidden' name='imm-sale-label_step_completed_" . create_id_from_name(strtolower($fields_array[$step]["step_heading"])) . "'>";

        $html_completed_dropdown .= "<select class='form-control done_notdone_pending' id='imm-sale-value_step_completed_" . create_id_from_name(strtolower($fields_array[$step]["step_heading"])) . "' name='" . "imm-sale-value_step_completed_" . create_id_from_name(strtolower($fields_array[$step]["step_heading"])) . "'>";

        $completed_step_value = $json_data_as_array["imm-sale-value_step_completed_" . create_id_from_name(strtolower($fields_array[$step]["step_heading"]))];

        $selected_d = "";
        $selected_0 = "";
        $selected_1 = "";
        $selected_2 = "";

        if ($completed_step_value == 3) {
            $selected_d = " selected ";
        } elseif ($completed_step_value == 0) {
            $selected_0 = " selected ";
        } elseif ($completed_step_value == 1) {
            $selected_1 = " selected ";
        } elseif ($completed_step_value == 2) {
            $selected_2 = " selected ";
        }

        $html_completed_dropdown .= "<option " . $selected_d . " value='3' >" . __("Markera steg som >>") . "</option>";
        $html_completed_dropdown .= "<option " . $selected_0 . " value='0' >" . __("Ej klart") . "</option>";
        $html_completed_dropdown .= "<option " . $selected_2 . " value='2' >" . __("Ej aktuellt") . "</option>";
        $html_completed_dropdown .= "<option " . $selected_1 . " value='1' >" . __("Klart") . "</option>";
        $html_completed_dropdown .= "</select>";
        $html_completed_dropdown .= "</div>";
        $html_completed_dropdown .= "</div>";
        $html_completed_dropdown .= "<hr>";

        echo $html_completed_dropdown; */

        echo "<input type='hidden' name='step-heading' value='" . $fields_array[$step]["step_heading"] . "'>";
        echo "<div class='row'>";


        foreach ($fields_array[$step] as $field) {

            foreach ($field as $single_field) {
//                echo"<pre>";
//                print_r($single_field["acf_fc_layout"]);

                if ($single_field["acf_fc_layout"] == "textbox") {

                    render_textbox($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                } elseif ($single_field["acf_fc_layout"] == "datepicker") {

                    render_date($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                } elseif ($single_field["acf_fc_layout"] == "time") {

                    render_time($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                } elseif ($single_field["acf_fc_layout"] == "dropdown") {

                    render_dropdown($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                } elseif ($single_field["acf_fc_layout"] == "text_area") {

                    render_text_area($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                } elseif ($single_field["acf_fc_layout"] == "file") {

                    render_file_input($single_field, $json_data_as_array['imm-sale-value_' . create_id_from_name($single_field["name"])]);
                } elseif ($single_field["acf_fc_layout"] == "webshop") {

                    render_webshop($single_field["webshop_show_category_dropdown"], $single_field["webshop_category"], $single_field["required"]);
                    include('fields/product-modal.php');
                }elseif ($single_field["acf_fc_layout"] == "file_uploaded") {
                        render_file_upload($_GET['order-id']);
                    } elseif ($single_field["acf_fc_layout"] == "price_adjustment") {
                    include('templates/create-price-adjustments.php');
                } elseif ($single_field["acf_fc_layout"] == "price_adjustment_lista") {

                    include('templates/listacreate-price-adjustments.php');
                } elseif ($single_field["acf_fc_layout"] == "tax_deduction") {

                    include('templates/create-tax-deduction.php');
                } elseif ($single_field["acf_fc_layout"] == "service_before_pi") {

                    include('fields/type_service.php');
                } elseif ($single_field["acf_fc_layout"] == "hembesok") {

                    include('templates/create-lead_project.php');
                }
            }
        }

        echo "</div>";
        include('fields/product-modal.php');

        echo "</div>";
        echo "<div class='col-md-5 col-sm-5'>";
        $order = wc_get_order($_GET["order-id"]);

        get_order_information_list($order, $json_data_as_array);


        echo "</div>";
    }
}

function render_file_upload($order_id){ ?>

   
<div class="top-buffer-half col-lg-12" id="all_files_project" >
 <label for="files_type"><strong><?php echo __("Ladda upp dokument för intern arbetsorder"); ?></strong></label>
    <div class = "upload-arbet-form-order-files">
        <div class= "upload-response"></div>
        <div class = "form-group">
            <label><?php __('Välj filer:', 'cvf-upload'); ?></label>
            <input type = "file" name = "files[]" accept = "" class = "files-data form-control" multiple />
            <input type = "hidden" name = "arbet_file" id="arbet_file" value="1" />
        </div>
       <!-- <div class = "form-group">
            <input type = "submit" value = "Ladda upp" class = "btn btn-brand btn-block top-buffer-half btn-upload-order" disabled/>
        </div>
		!-->
    </div>

    <table class="table">
        <?php $table_name = "todo-order_files";
//        $order_id = $_GET['order-id'];
        ?>
        <thead>
        <tr>
            <th class="sortable"
                onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Namn" ); ?></th>
            <th class="sortable"
                onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Ladda ner" ); ?></th>
            <th class="sortable"
                onclick="sortTable(1,  <?php echo "'" . $table_name . "'"; ?>)"><?php echo __( "Ta bort" ); ?></th>

        </tr>
        </thead>
        <tbody id="<?php echo $table_name ?>">
        <?php
                $filedata = get_post_meta($order_id, 'file_order', true); 
                
                $i = 1;
                foreach ($filedata as $val) {
                    $namn = $val['namn'];
                    $url = $val['url'];
                    echo '<tr data_row="' . $i . '"><td>' . $namn . '</td><td><a href="' . $url . '" class="project_file_url" download>Ladda ner</a></td><td data_row="' . $i . '" class="tabort_arbet_repeater_row_offert" data_url="' . $url . '"><a href="#"  >Ta bort</a></td></tr>';
                    $i++;
                }
                ?>
        </tbody>
    </table>
    <hr>


</div>
<?php }

function render_date($args, $current_value = null) {
    $required = $args["required"];
    $required_setting = null;
    $required_span = null;

    if ($required) {
        /*   $required_setting = " required "; */
        $required_setting = " ";
        $required_span = "<span style='color: red'>*</span>";
    }

    $html = "<div class='col-lg-6'>";

    $html .= "<label class='top-buffer-half' for='" . create_id_from_name($args['name']) . "'> " . $args['name'] . $required_span . "</label>";
    $html .= "<input value='" . $args['name'] . "' type='hidden' name='imm-sale-label_" . create_id_from_name($args['name']) . "'>";
    $html .= "<input  title='test tooltip' " . $required_setting . " value='" . $current_value["value"] . "' type='date' name='imm-sale-value_" . create_id_from_name($args['name']) . "' class='form-control $required_setting' id='" . create_id_from_name($args['name']) . "'>";
    $html .= "</div>";

    echo $html;
}

function render_time($args, $current_value = null) {
    $required = $args["required"];
    $required_setting = null;
    $required_span = null;

    if ($required) {
        /*   $required_setting = " required "; */
        $required_setting = " ";
        $required_span = "<span style='color: red'>*</span>";
    }

    $html = "<div class='col-lg-6'>";

    $html .= "<label class='top-buffer-half' for='" . create_id_from_name($args['name']) . "'> " . $args['name'] . $required_span . "</label>";
    $html .= "<input value='" . $args['name'] . "' type='hidden' name='imm-sale-label_" . create_id_from_name($args['name']) . "'>";
    $html .= "<input  title='test tooltip' " . $required_setting . " value='" . $current_value["value"] . "' type='time' name='imm-sale-value_" . create_id_from_name($args['name']) . "' class='form-control $required_setting' id='" . create_id_from_name($args['name']) . "'>";
    $html .= "</div>";

    echo $html;
}

function render_textbox($args, $current_value = null) {
    $required = $args["required"];
    $required_setting = null;
    $required_span = null;

    if ($required) {
        /*   $required_setting = " required "; */
        $required_setting = " ";
        $required_span = "<span style='color: red'>*</span>";
    }

    $html = "<div class='col-lg-6'>";

    $html .= "<label class='top-buffer-half' for='" . create_id_from_name($args['name']) . "'> " . $args['name'] . $required_span . "</label>";
    $html .= "<input value='" . $args['name'] . "' type='hidden' name='imm-sale-label_" . create_id_from_name($args['name']) . "'>";
    $html .= "<input  title='test tooltip' " . $required_setting . " value='" . $current_value["value"] . "' type='text' name='imm-sale-value_" . create_id_from_name($args['name']) . "' class='form-control $required_setting' id='" . create_id_from_name($args['name']) . "'>";
    $html .= "</div>";

    echo $html;
}

function render_text_area($args, $current_value = null) {
    $keys = array('Information-frn-kund', 'Arbetsorder');
    $required = $args["required"];
    $required_setting = null;
    $required_span = null;

    if (in_array(create_id_from_name($args['name']), $keys)) {

        if (get_post_meta($_GET["order-id"], create_id_from_name($args['name']), true)) {
            $newvalue = get_post_meta($_GET["order-id"], create_id_from_name($args['name']), true);
        } else {

            $newvalue = $current_value["value"];
        }
    } else {
        $newvalue = $current_value["value"];
    }


    if ($required) {
        $required_setting = " required ";
        $required_span = "<span style='color: red'>*</span>";
    }

    $html = "<div class='col-lg-12'>";

    $html .= "<label class='top-buffer-half' for='" . create_id_from_name($args['name']) . "'> " . $args['name'] . $required_span . "</label>";
    $html .= "<input value='" . $args['name'] . "' type='hidden' name='imm-sale-label_" . create_id_from_name($args['name']) . "'>";
    $html .= " <textarea " . $required_setting . "  class='form-control' rows='5' name='imm-sale-value_" . create_id_from_name($args['name']) . "'
                                  id='" . create_id_from_name($args['name']) . "'>" . $newvalue . "</textarea>";
    $html .= "</div>";

    echo $html;
}

function render_file_input($args, $current_value = null) {


    $html = "<div class='col-lg-12'>";

    $html .= "<label class='top-buffer-half' for='" . create_id_from_name($args['name']) . "'> " . $args['name'] . "</label><br>";
    if ($current_value["value"]) {
        $html .= '<div id="' . create_id_from_name($args['name']) . '">';
        $html .= "<a target='blank' href='" . $current_value["value"] . "'><img src='" . $current_value["value"] . "' height=\"80\" width=\"80\"></a>";
        $html .= "<a target='blank' href='#' data_placement='" . $current_value['summary_placement'] . "' data_order='" . $_GET['order-id'] . "' data_name = '" . 'imm-sale-value_' . create_id_from_name($args['name']) . "' data_div_id='" . create_id_from_name($args['name']) . "' class='tabort_bild_render'>Ta bort</a>";
        $html .= '</div>';
    }
    $html .= "<input value='" . $args['placement_summary'] . "' type='hidden' name='imm-sale-summary-placement_" . create_id_from_name($args['name']) . "'>";
    $html .= "<input value='" . $args['name'] . "' type='hidden' name='imm-sale-label_" . create_id_from_name($args['name']) . "'>";
    $html .= "<input value='" . $current_value["value"] . "' type='hidden' name='imm-sale-file_" . create_id_from_name($args['name']) . "'>";
    $html .= "<input value='" . $current_value["image_description"] . "' type='text' name='imm-sale-image-description_" . create_id_from_name($args['name']) . "' class='form-control' id='" . create_id_from_name($args['name']) . "' placeholder= " . __('Bildbeskrivning') . ">";
    $html .= "<input value='" . $current_value["value"] . "' accept='image/x-png,image/gif,image/jpeg'  type='file' name='imm-sale-value_" . create_id_from_name($args['name']) . "' class='' id='" . create_id_from_name($args['name']) . "'>";
    $html .= "</div>";

    echo $html;
}

function render_type_service() {
    include('fields/type_service.php');
}

function render_dropdown($args, $current_value = null) {

    $required = $args["required"];
    $required_setting = null;
    $required_span = null;

    if ($required) {
        $required_setting = " required ";
        $required_span = "<span style='color: red'>*</span>";
    }

    $html = "<div class='col-lg-6'>";
    $html .= "<label class='top-buffer-half' for='" . create_id_from_name($args['name']) . "'> " . $args['name'] . $required_span . "</label>";
    $html .= "<input value='" . $args['name'] . "' type='hidden' name='imm-sale-label_" . create_id_from_name($args['name']) . "'>";

    $html .= "<select class='form-control js-sortable-select' id='" . create_id_from_name($args['name']) . "' name='imm-sale-value_" . create_id_from_name($args['name']) . "'>";
    $html .= "<option " . $required_setting . " value='' >" . __("Inget värde valt") . "</option>";
    foreach ($args["values"] as $option) {
        $selected = "";
        if ($option["value"] == $current_value["value"]) {
            $selected = " selected ";
        }
        $html .= "<option " . $selected . " value='" . $option["value"] . "'> " . $option["text"] . "</option>";
    }

    $html .= "</select>";
    $html .= "</div>";
    echo $html;
}

function render_webshop($show_dropdown = null, $product_categories = null, $required_option = null) {
    $_GET["show_dropdown"] = $show_dropdown;
    $_GET["product_categories"] = $product_categories;
    $_GET["required"] = $required_option;
    include('fields/field-product-list.php');
}

function create_id_from_name($name) {
    $name = str_replace(' ', '-', $name);

    return preg_replace('/[^A-Za-z0-9\-]/', '', $name);
}

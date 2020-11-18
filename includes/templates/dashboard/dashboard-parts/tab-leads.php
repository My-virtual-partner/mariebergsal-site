<?php
/**
 * Lead tab in System Dashboard.
 */
?>
<div id="leads" class="tab-pane fade top-buffer-half">
    <?php $table_name = "leads-table"; ?>
    <div class="row top-buffer-half">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <label for="imm-sale-search-lead"> <?php echo __("Sök efter lead"); ?></label>
            <input value="" type="text" name="imm-sale-search-lead"
                   data-table_name="<?php echo $table_name; ?>"
                   class="form-control imm-sale-search-lead"
                   id="imm-sale-search-lead_<?php echo $table_name; ?>"
                   placeholder="<?php echo __("Sök efter lead..."); ?>">
        </div>
        <div class='col-lg-4 col-md-4 col-sm-6'>
            <label for='lead_typavlead'><?php echo __('Typ av lead'); ?></label>
            <select name="customer_typavlead" class="form-control js-sortable-select filter_lead_tab" id="lead_typavlead"   data-table_name="<?php echo $table_name; ?>">

                <option value="alla" selected>Alla</option>
                <?php
                $current_user_role = get_user_role();
                $project_roles_steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);

                foreach ($project_roles_steps as $single_step) :
                    ?>

                    <option value="<?php echo $single_step["project_type_name"] ?>" <?php if ($lead_id && $single_step["project_type_name"] == get_field('lead_typavlead', $lead_id)) : echo 'selected';
                endif;
                    ?>><?php echo $single_step["project_type_name"] ?></option>


                    <?php
                endforeach;
                ?>
            </select>
        </div>

        <div class='col-lg-4 col-md-4 col-sm-6'>
            <label for='user_kontakt_person'><?php echo __('Ansvarig säljare'); ?></label>
            <select name="user_kontakt_person" id="user_kontakt_person" class="form-control js-sortable-select filter_lead_tab" data-table_name="<?php echo $table_name; ?>">
                <option value="alla" selected>Alla</option>

                <?php
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

                foreach ($users as $user) :
                    $salesman = get_userdata($user->ID);
                    ?>

                    <option value='<?php echo $salesman->ID ?>'<?php
                    if ($lead_id && $salesman->ID == get_field('lead_salesman', $lead_id)) : echo 'selected';
                    endif;
                    ?>><?php echo showName($salesman->ID); ?></option>
                            <?php
                        endforeach;
                        ?>
            </select>

        </div>

        <div class="col-lg-4 col-md-4 col-sm-3">
            <label for="imm-sale-order-date_from" "> <?php echo __("Från"); ?></label>
            <input type="text" id="imm-sale-order-date_from_lead" class="filter_lead_tab cstm_date_picker"
                   data-table_name="<?php echo $table_name; ?>" placeholder="yyyy-mm-dd">
        </div>
        <div class="col-lg-4 col-md-4 col-sm-3">
            <label for="imm-sale-order-date_to" c> <?php echo __("Till"); ?></label>
            <input type="text" id="imm-sale-order-date_to_lead" class="filter_lead_tab cstm_date_picker"
                   data-table_name="<?php echo $table_name; ?>" placeholder="yyyy-mm-dd">
        </div>
    </div>
    <table class="table top-buffer-half">
        <thead>
            <tr>
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Åtgärdsdatum"); ?></th>
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Ansvarig säljare"); ?></th>
                <th class="sortable"
                    onclick="sortTable(0, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Namn / Företagsnamn"); ?></th>
                <?php/*<th class="sortable"
                    onclick="sortTable(1, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Efternamn"); ?></th>*/?>
                <th class="sortable"
                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Ort"); ?></th>
                <th class="sortable"
                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Postnummer"); ?></th>
                <th class="sortable"
                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Typ av lead"); ?></th>

                <th class="sortable"
                    onclick="sortTable(2, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("E-post"); ?></th>
                <th class="sortable"
                    onclick="sortTable(3, <?php echo "'" . $table_name . "'"; ?>)"><?php echo __("Telefonnummer"); ?></th>

                <th class="text-center"><?php echo( "Verktyg" ); ?></th>
            </tr>
        </thead>
        <tbody id="<?php echo $table_name ?>">
            <?php
            $args = [
                'posts_per_page' => -1,
                'post_type' => "imm-sale-leads",
                'post_status' => array('publish', 'acf-disabled', 'future', 'pending', 'private')
            ];
//            $query = new WP_Query($args);
// echo "<pre>"; print_r($query); echo "</pre>";
            return_leads_table($args);
            wp_reset_query();
            ?>
        </tbody>
    </table>
</div>
<script>
  jQuery(document).ready(function () {
 jQuery(".cstm_date_picker").datepicker();
   });  </script>
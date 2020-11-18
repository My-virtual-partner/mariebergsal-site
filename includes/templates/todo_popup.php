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
?>

<button type="button" class="btn btn-beta btn-block btn-menu" data-toggle="modal" data-target="#todo_Modal">Skapa uppgift new</button>
<div id="todo_Modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form action="" method="post">

                <input type="hidden" value="true" name="todo_handle_popup">
                <input type="hidden" value="" name="department_val">
                <input type="hidden" value="" id="selected_user_value">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">UPPGIFT</h4>
                </div>
                <div class="modal-body">
                    <div class=" col-lg-6 col-md-6">
                        <label class="top-buffer-half"
                               for="todo_action_date"><?php echo __("Åtgärdsdatum"); ?> </label>
                        <input type="date" value="<?php
                        if (!empty($todo_action_date)) {
                            echo $todo_action_date;
                        } else {
                            echo date('Y-m-d');
                        }
                        ?>" class="form-control"
                               name="todo_action_date" id="todo_action_date">
                    </div>


                    <div class=" col-lg-6 col-md-6">
                        <label class="top-buffer-half" for="todo_status"><?php echo __("Status"); ?> </label>

                        <select class="form-control js-sortable-select" name="todo_status" id="todo_status">
                            <option value="1"><?php echo __("Avklarad"); ?></option>
                            <option value="0"><?php echo __("Ej avklarad"); ?></option>

                        </select>
                    </div>

                    <div class=" col-lg-6 col-md-6">
                        <label class="top-buffer-half"
                               for="todo_assigned_department"><?php echo __("Avdelning"); ?> </label>
                        <select class="form-control js-sortable-select todo-assigned-department" name="todo_assigned_department"
                                id="todo_assigned_department">
                            <option value="alla"><?php echo __("Alla"); ?></option>

                            <option value="sale-administrator"><?php echo __("Administratör"); ?></option>

                            <option value="sale-salesman"><?php echo __("Sälj"); ?></option>

                            <option value="sale-economy"><?php echo __("Ekonomi"); ?></option>

                            <option value="sale-technician"><?php echo __("Tekniker"); ?></option>

                            <option value="sale-project-management"><?php echo __("Projektplanering"); ?></option>

                            <option value="sale-sub-contractor"><?php echo __("Underentreprenör"); ?></option>
                        </select>

                    </div>

                    <div class=" col-lg-6 col-md-6 ">
                        <label class="top-buffer-half"
                               for="todo_assigned_user"><?php echo __("Avsändare"); ?> </label>

                        <select class="form-control js-sortable-select" name="todo_assigned_user"
                                id="todo_assigned_user">
                            <option value="alla"><?php echo __("Alla"); ?></option>



                            <?php
                            foreach ($users as $user) :
                                ?>
                                <option <?php
                         if ($current_user->ID == $user->ID) {
                                echo " selected ";
                            }
                                    ?> value="<?php echo $user->ID ?>" data_roll='<?php
                                    $user_info = get_userdata($user->ID);
                                    echo implode(', ', $user_info->roles)
                                    ?>'><?php echo showName($user->ID); ?></option> <?php
                                    // } 
                                endforeach;
                                ?>
                        </select>

                    </div>



                    <div class=" col-lg-6 col-md-6 ">
                        <label class="top-buffer-half"
                               for="todo_assigned_user"><?php echo __("Mottagare"); ?> </label>

                        <select class="form-control js-sortable-select todo_assigned_user_mottagare" name="todo_assigned_user_mottagare" id="todo_assigned_user_mottagare">


                            <option value="alla"><?php echo __("Alla"); ?></option>

                            <?php
                            foreach ($users as $user) :
                                ?>
                                <option <?php
                                ?> value="<?php echo $user->ID ?>" data_roll='<?php
                                    $user_info = get_userdata($user->ID);
                                    echo implode(', ', $user_info->roles)
                                    ?>'><?php echo showName($user->ID); ?></option>

                                <?php
                                // }
                            endforeach;
                            ?>
                        </select>



                    </div>

                    <div class=" col-lg-6 col-md-6">
                        <label class="top-buffer-half"
                               for="todo_project_connection"><?php echo __("Projekt"); ?> </label>
                        <select class="form-control js-sortable-select" name="todo_project_connection"
                                id="todo_project_connection">
                            <option value=""><?php echo __("Inget värde valt"); ?></option>
                                    <?php
                                    $args = [
                                        'posts_per_page' => -1,
                                        'post_type' => 'imm-sale-project',
                                    ];
                                    $projects = new WP_Query($args);
                                    while ($projects->have_posts()) : $projects->the_post();
                                        $project_id = get_the_ID();
                                        $get_custid = get_field('invoice_customer_id', $project_id);
                                        $custom_project_number = get_post_meta($project_id, 'custom_project_number')[0];
                                        ?>
                                <option <?php ?> value="<?php echo $project_id; ?>"><?php echo $custom_project_number . '-' . showName($get_custid); ?></option>

                                <?php
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </select>


                    </div>

                    <div class=" col-lg-12 col-md-12">
                        <label class="top-buffer-half"
                               for="todo_entry"><?php echo __("Notering"); ?> </label>

                        <textarea class="form-control" rows="5" name="todo_entry"
                                  id="todo_entry"></textarea>
                    </div>


                    <div class=" col-lg-12 col-md-12">
                        <button type="submit" class="btn btn-brand btn-block top-buffer">
                        <?php echo __("Spara") ?>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>

            <div class="row" style="position:absolute; bottom:0px;">
                <div class=" col-lg-12 col-md-12 " style="text-align:left" >
                    <input type="checkbox" id="completed_task" /> <?php echo __("Avklarad"); ?> </div>
            </div>
        </div>

    </div>
</div>

<?php
/**
 * Template used to select the invoice type when a new project is created.
 * URL PATH: $_SERVER['REQUEST_URI'], '/select-invoice-type'
 */

include_once( plugin_dir_path( __FILE__ ) . 'head.php' );
?>
  <div class="top-buffer-half">




                    <div class=" col-lg-offset-2 col-lg-8">
                        <form id="create_invoice" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="create_invoice" value="true">

							<?php
							$current_user_role   = get_user_role();
                                                        //							$project_roles_steps = get_field('project_type-' . $current_user_role, 'options-' . $current_user_role);
//                                                        print_r($project_roles_steps);
                                                        $project_roles_steps = modify_projectType($project_type_id = '');

get_project_types_project_selectCustom($project_roles_steps, "select_invoice_type");
?>
                          <!--  <input value="<?php /*echo __( "Spara och skapa offert &raquo;" ); */?>" type="submit"
                                    class="btn btn-brand steps-btn btn-block top-buffer-half"
                                   id="">-->
                        </form>
                </div>





</div>
<?php wp_footer(); ?>
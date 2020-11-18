<?php
/*
 * Template Name: Order steps
 */
include_once( plugin_dir_path( __FILE__ ) . 'head.php' );
?>
    <div class="container top-buffer-half">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">

                    <div class=" col-lg-offset-3 col-lg-6">

						<?php
                        $lead_addon = "";
                        if(isset($_GET["lead-id"])){
                            $lead_addon = "&lead-id=" . $_GET["lead-id"];
                        }
						$current_user_role = get_user_role();
						$project_roles_steps = get_field( 'project_type-' . $current_user_role, 'options-' . $current_user_role );
						foreach ( $project_roles_steps as $project_type ) : ?>
                            <a href="order-steps?project_type=<?php echo $project_type["project_type_id"] . $lead_addon; ?>" type="button"
                               class="btn btn-brand btn-block"><?php echo $project_type["project_type_name"] ?></a>

						<?php endforeach; ?>

                    </div>

                </div>

            </div>
        </div>
    </div>
<?php wp_footer(); ?>
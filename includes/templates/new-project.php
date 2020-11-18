<?php
/**
 * Template used to create a new project.
 * URL PATH: $_SERVER['REQUEST_URI'], '/new-project'
 */
include_once( plugin_dir_path( __FILE__ ) . 'head.php' );
?>
    <div class="container top-buffer-half">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-lg-12">
                        <form id="create_new_project" method="post" enctype="multipart/form-data" >
                            <input type="hidden" name="create_new_project" value="true">
                            <div class="row">
                                <div class="col-lg-4 col-lg-push-8">
	                                <?php
	                                 $office_current = $_COOKIE['office_connection'];
	                               // $office_connection = get_field( 'office_connection', 'user_' . $current_user->ID );
								     $args = array(
                       'post_type' => 'imm-sale-office',
                       'posts_per_page' => -1,
                   );
				$myposts = get_posts( $args );

	                                ?>
                                    <label for="office_connection"><?php echo __("Välj din butikskoppling"); ?></label>
                                    <select id="set_office_connection" name="office_connection" class="form-control" required>
									<option value="">Select Store</option>
		                                <?php foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
                                            <option <?php if ( $office_current == $post->ID ) {
				                                echo " selected ";
			                                } ?> value="<?php echo  $post->ID; ?>"><?php echo get_the_title( $post ); ?></option>
		                                <?php endforeach; 
wp_reset_postdata(); ?>

                                    </select>
                                </div>
                            </div>
                            <div class="row">
								<?php include( 'create-customer-for-project.php' );
								?>
                            </div>

                            <div class="row top-buffer">
                                <div class="col-lg-12">
                                    <input value="<?php echo __( "Spara och skapa projekt &raquo;" ); ?>" type="submit"
                                           name="forward-step" class="btn btn-brand btn-block create_project_btn"
                                           id="">
                                </div>
                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
<?php wp_footer(); ?>
<?php

function plugin_options_frontpage() {
	$all_options = get_all_options_in_gropup( 'sales_options_group' );
	?>

    <div class="wrap">
    <div class="">
    <form onsubmit="return confirm('<?php echo __( "Är du säker på att du vill spara dina ändringar?" ); ?>')"
          action="options.php" method="post">
        <input type="hidden" name="sale-settings-update" value="true">

		<?php
		settings_fields( 'sales_options_group' );
		wp_enqueue_media();

		?>
        <h1><?php echo __( "Logotyp & Färger" ) ?></h1>
        <p><?php echo __( "Ställ in en logotyp samt färger som systemet ska använda" ); ?></p>

        <label for="image_url"><?php echo __( "Logotyp" ) ?></label>

        <div class="input-group">
            <input type="text" name="logotype_image_url" id="logotype_image_url"
                   value="<?php echo get_option( 'logotype_image_url' ); ?>"
                   class="form-control"
                   placeholder="<?php echo __( "Välj en logotyp att ladda upp..." ) ?>">
            <span class="input-group-btn">
                                    <button name="upload-btn" id="upload-btn" class="btn btn-default"
                                            type="button"><?php echo __( "Välj bild" ) ?></button>
                                </span>
        </div>
        <div class="top-buffer">
            <label for="primary-color"><?php echo __( "Primär färg" ); ?></label>
            <input type="text" class="colorpicker"
                   value="<?php echo get_option( 'main_color' ); ?>"
                   placeholder="<?php echo __( "Välj primär färg..." ) ?>" name="main_color">

            <label for="secondary-color"><?php echo __( "Sekundär färg" ); ?></label>
            <input type="text" class="colorpicker"
                   value="<?php echo get_option( 'second_color' ); ?>"
                   placeholder="<?php echo __( "Välj sekundär färg..." ) ?>"
                   name="second_color">
        </div>
        <hr>

        <input type="submit" class="button button-primary" value="<?php esc_attr_e( 'Save Changes' ); ?>"/>


    </form>


	<?php


}

function register_settings() {
	register_setting( 'sales_options_group', 'main_color' );
	register_setting( 'sales_options_group', 'second_color' );
	register_setting( 'sales_options_group', 'logotype_image_url' );

	foreach ( get_editable_roles() as $editable_role ) {
		register_setting( 'sales_options_group', $editable_role["name"] );
	}

}

add_action( 'admin_init', 'register_settings' );

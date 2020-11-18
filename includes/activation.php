<?php

//Check for required plugins on activation.
add_action( 'admin_init', 'check_if_wc_acf_is_active' );

add_action( "admin_init", function () {
	if ( get_option( $opt_name = "show_my_plugin_wizard_notice" ) ) {
		add_action( "admin_notices", "wizard_notice" );
	}

	return;
} );


//Check if WC and ACF is active. Prevent the plugn from activation if WC and ACF is not installed and active.
function check_if_wc_acf_is_active() {
	if ( is_admin() && current_user_can( 'activate_plugins' ) ) {

		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			deactivate_on_error();
			add_action( 'admin_notices', 'wc_plugin_notice' );
		}

		if ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) {
			deactivate_on_error();
			add_action( 'admin_notices', 'acf_plugin_notice' );
		}

	}
}

//WC not active error message.
function wc_plugin_notice() {
	echo "<div class='error'><p>" . __( "Detta plugin kräver att WooCommerce är installerat och aktiverat." ) . "</p></div>";

}

//ACF not active error message.
function acf_plugin_notice() {
	echo "<div class='error'><p>" . __( "Detta plugin kräver att Advanced Custom Fields är installerat och aktiverat." ) . "</p></div>";

}

//Deactivate plugin on error.
function deactivate_on_error() {
	deactivate_plugins( plugin_basename( PLUGIN_FILE ) );
	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}

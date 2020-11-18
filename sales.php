<?php
/**
 * Plugin Name: Säljsystem
 * Plugin URI: https://ideermedmera.se
 * Description: Idéer med mera säljsystem
 * Author: Kenny Rönnbäck
 * Author URI:https://ideermedmera.se
 * Version: 0.1
 * Domain Path: /languages
 */

/**
 * Define some static variables.
 */

if ( basename( dirname( __FILE__ ) ) == 'plugins' ) {
	define( "SALES_DIR", '' );
} else {
	define( "SALES_DIR", basename( dirname( __FILE__ ) ) . '/' );
}

if ( ! defined( 'PLUGIN_FILE' ) ) {
	define( 'PLUGIN_FILE', __FILE__ );
}

if(!defined('SALES_PATH')){
	define( "SALES_PATH", WP_PLUGIN_URL . "/" . SALES_DIR );
}


/**
 * File loader. Use this to include files to be able to access functions across the whole plugin.
 */

include( 'includes/file-loader.php' );

/**
 * Cointains all AJAX functions for the plugin.
 */

include ("ajax-functions.php");

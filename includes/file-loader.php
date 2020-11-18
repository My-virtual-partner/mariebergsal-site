<?php

/**
 * The file loader. Add files here to include globally.
 */

$file_names = [
	"core.php",
	"activation.php",
	"settings.php",
	"template-builder.php",
	"acf.php",
	"fields-render.php",
	"fields-renders.php",
	"cpt.php",
	"roles.php",
	"internal-project-status-settings.php",
	"form-handle.php",
	"form-handle-functions.php",
	"woocommerce.php",
	"custom-login.php",
	"templates/external-lead-creation/shortcode-functions.php",
];

//Load the files
imm_load_files( $file_names );

function imm_load_files($files) {

	$path = plugin_dir_path( __FILE__ );

	foreach ( $files as $file ) {
		require_once( $path . $file );

	}

}
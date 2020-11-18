<?php

/**
 * Add shortcode to display the lead create form
 */

function return_lead_form() {
	include ('lead-form.php');
}

add_shortcode( 'load_lead_form', 'return_lead_form' );

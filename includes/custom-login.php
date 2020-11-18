<?php

/**
 * Adds support to use a custom login screen.
 * Includes css and add_action
 */

function my_custom_login() {
	echo '<link rel="stylesheet" type="text/css" href="' . SALES_PATH . 'custom-css/imm-sale-custom-login-styles.css.css" />';
}
add_action('login_head', 'my_custom_login');
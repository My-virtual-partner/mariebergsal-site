<?php
/**
 * Add a custom ACF options page for the plugin.
 * This Options page is used to customize all the invoice types etc..
 */

$args = array(

	'page_title'  => __( 'Säljsystem' ),
	'menu_title'  => '',
	'menu_slug'   => 'imm_sales_steps',
	'capability'  => 'edit_posts',
	'position'    => 26,
	'parent_slug' => '',
	//'icon_url'    => SALES_PATH . 'images/imm-logo.png',
	'icon_url'    => 'dashicons-money',
	'redirect'    => true,
	'post_id'     => 'options',
	'autoload'    => false,
);


$args_sale_administrator          = array(

	'page_title'  => __( 'Steg admin' ),
	'menu_title'  => '',
	'menu_slug'   => 'imm_sales_steps-sale-administrator',
	'capability'  => 'edit_posts',
	'position'    => 26,
	'parent_slug' => '',
	'icon_url'    => 'dashicons-money',
	'redirect'    => true,
	'post_id'     => 'options-sale-administrator',
	'autoload'    => false,
);
$args_sale_salesman               = array(

	'page_title'  => __( 'Steg säljare' ),
	'menu_title'  => '',
	'menu_slug'   => 'imm_sales_steps-sale-salesman',
	'capability'  => 'edit_posts',
	'position'    => 26,
	'parent_slug' => '',
	'icon_url'    => 'dashicons-money',
	'redirect'    => true,
	'post_id'     => 'options-sale-salesman',
	'autoload'    => false,
);
$args_sale_economy                = array(

	'page_title'  => __( 'Steg ekonomi' ),
	'menu_title'  => '',
	'menu_slug'   => 'imm_sales_steps-sale-economy',
	'capability'  => 'edit_posts',
	'position'    => 26,
	'parent_slug' => '',
	'icon_url'    => 'dashicons-money',
	'redirect'    => true,
	'post_id'     => 'options-sale-economy',
	'autoload'    => false,
);
$args_sale_technician             = array(

	'page_title'  => __( 'Steg tekniker' ),
	'menu_title'  => '',
	'menu_slug'   => 'imm_sales_steps-sale-technician',
	'capability'  => 'edit_posts',
	'position'    => 26,
	'parent_slug' => '',
	'icon_url'    => 'dashicons-money',
	'redirect'    => true,
	'post_id'     => 'options-sale-technician',
	'autoload'    => false,
);
$args_sale_project_management     = array(

	'page_title'  => __( 'Steg projektplanering' ),
	'menu_title'  => '',
	'menu_slug'   => 'imm_sales_steps-sale-project-management',
	'capability'  => 'edit_posts',
	'position'    => 26,
	'parent_slug' => '',
	'icon_url'    => 'dashicons-money',
	'redirect'    => true,
	'post_id'     => 'options-sale-project-management',
	'autoload'    => false,
);
$args_sale_project_sub_contractor = array(

	'page_title'  => __( 'Steg UE' ),
	'menu_title'  => '',
	'menu_slug'   => 'imm_sales_steps-sale-sub-contractor',
	'capability'  => 'edit_posts',
	'position'    => 26,
	'parent_slug' => '',
	'icon_url'    => 'dashicons-money',
	'redirect'    => true,
	'post_id'     => 'options-sale-sub-contractor',
	'autoload'    => false,
);
if ( function_exists( 'acf_add_options_page' ) ) {

//	acf_add_options_page( $args_sale_administrator );
//	acf_add_options_page( $args_sale_salesman );
//	acf_add_options_page( $args_sale_economy );
//	acf_add_options_page( $args_sale_technician );
//	acf_add_options_page( $args_sale_project_management );
//	acf_add_options_page( $args_sale_project_sub_contractor );
//	acf_add_options_page( $args );


}



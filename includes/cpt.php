<?php

/**
 * Register all the needed custom post types in this file.
 */

function imm_sale_register_custom_post_types() {
	/** Lead */

	register_post_type(
		'imm-sale-leads',
		array(
			'labels'             => array(
				'name'          => __( 'Leads' ),
				'singular_name' => __( 'Lead' ),
			),
			'description'        => __( 'Alla leads' ),
			'public'             => true,
			'has_archive'        => false,
			'publicly_queryable' => false,
			//'menu_icon'    => SALES_PATH . 'images/imm-logo.png',
			'menu_icon'          => 'dashicons-smiley'
		)
	);
	register_post_type(
		'imm-sale-project',
		array(
			'labels'             => array(
				'name'          => __( 'Projekt' ),
				'singular_name' => __( 'Projekt' ),
			),
			'description'        => __( 'Alla projekt' ),
			'public'             => true,
			'has_archive'        => false,
			'publicly_queryable' => false,
			//'menu_icon'    => SALES_PATH . 'images/imm-logo.png',
			'menu_icon'          => 'dashicons-smiley'
		)
	);

	/** TO-DO */

	register_post_type(
		'imm-sale-todo',
		array(
			'labels'             => array(
				'name'          => __( "Uppgifter" ),
				'singular_name' => __( "Uppgift" ),
			),
			'description'        => __( "Alla uppgifter"),
			'public'             => true,
			'has_archive'        => false,
			'publicly_queryable' => false,
            'supports'           => array( 'title', 'editor', 'author' ),
			//'menu_icon'    => SALES_PATH . 'images/imm-logo.png',
			'menu_icon'          => 'dashicons-smiley'
		)
	);

	register_post_type(
		'imm-sale-office',
		array(
			'labels'             => array(
				'name'          => __( 'Butik' ),
				'singular_name' => __( 'Butik' ),
			),
			'description'        => __( 'Alla butiker' ),
			'public'             => true,
			'has_archive'        => false,
			'publicly_queryable' => false,
			//'menu_icon'    => SALES_PATH . 'images/imm-logo.png',
			'menu_icon'          => 'dashicons-store'
		)
	);


	flush_rewrite_rules();
}

add_action( 'init', 'imm_sale_register_custom_post_types' );
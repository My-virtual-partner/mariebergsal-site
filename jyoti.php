<?php 
//echo'yes1';die;
$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/wp-config.php');
//echo'yes1';die;
$args = array(
		'orderby'        => 'ID',
		'order'=>'ASC',
		'post_type'      => wc_get_order_types(),
		'post_status' => array('wc-processing','wc-pending', 'wc-on-hold','wc-completed','wc-refunded','wc-cancelled'),
		'posts_per_page' => - 1,
		'meta_query'     => array(
			array(
				'key'     => 'imm-sale_prepayment_invoice',
				'value'   => true,
				'compare' => '='
			),
		)

	);

	$orders = new WP_Query( $args );
	
	while ( $orders->have_posts() ) :
	$orders->the_post();
	$order = new WC_Order( get_the_ID() ); 
//        echo"<pre>";
//        echo $order->ID;
        $api = new \src\fortnox\api\WF_Orders();
        if ( $api::order_exists( $order->ID ) ) {
            update_post_meta($order->ID, 'order_syn_fortnox', true);
        }
        
        endwhile;
?>
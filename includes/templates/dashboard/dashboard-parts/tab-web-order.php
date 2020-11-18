<?php
/**
 * Web orders tab in System Dashboard. Displays wc orders with no project connection.
 */

$current_user_role = get_user_role();
?>
<div id="web-orders" class="tab-pane fade">
	<?php
	$table_name     = "all-table-web-orders";
	$args = array(
		'orderby'        => 'ID',
		'paged'          => 1,
		'post_type'      => wc_get_order_types(),
		'post_status'    => array_keys( wc_get_order_statuses() ),
		'posts_per_page' => 10,
		'meta_query'     => array(
			array(
				'key'     => 'imm-sale_project_connection',
				'compare' => 'NOT EXISTS',
			)
		)

	);

	$orders = new WP_Query( $args );

	?>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <?php get_paged_dropdown( "web-orders-page", null, null, $orders->max_num_pages ); ?>
        </div>
    </div>

    <table class="table top-buffer-half">
        <thead>
        <tr>
            <th><?php echo __( "Order ID" ); ?></th>
            <th><?php echo __( "Skapad datum" ) ?></th>
            <th><?php echo __( "Kund" ); ?></th>
            <th><?php echo __( "Fakturering" ) ?></th>
            <th><?php echo __( "Orderstatus" ) ?></th>
            <th><?php echo __( "Summa" ) ?></th>
            <th></th>

        </tr>
        </thead>
        <tbody id="<?php echo $table_name ?>">
		<?php



		return_web_orders_table( $orders );

		wp_reset_query();

		?>
        </tbody>
    </table>
</div>

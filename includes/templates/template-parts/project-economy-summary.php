<?php
$args                 = array(
    'orderby'        => 'ID',
    'post_type'      => wc_get_order_types(),
    'post_status'    => array_keys( wc_get_order_statuses() ),
    'posts_per_page' => - 1,
    'meta_query'     => array(
        'relation' => 'AND',
        array(
            'key'     => 'imm-sale_project_connection',
            'value'   => $project_id,
            'compare' => '='
        ),
        array(
            'key'     => 'imm-sale_converted_to_order',
            'value'   => true,
            'compare' => '='
        ),
    )

);
$orders_total_sum     = 0;
$profit_sum           = 0;
$external_invoice_sum = 0;

$orders = new WP_Query( $args );
while ( $orders->have_posts() ) {
    $orders->the_post();
    $order            = new WC_Order( get_the_ID() );
    $orders_total_sum += $order->get_total() - $order->get_total_tax();

}

//$external_invoices_json = get_post_meta( $project_id, 'external_invoices_json', true );
//$external_invoices      = return_array_from_json( $external_invoices_json );

foreach ( getCostSupplier($project_id) as $external_invoice ) {
    $external_invoice_sum += $external_invoice->invoice_price;
}


?>


<ul class="list-unstyled">
    <li><strong><?php echo __( "Ordervärde" ); ?>:</strong> <?php echo wc_price( $orders_total_sum ); ?></li>
    <li><strong><?php echo __( "Leverantörsfakturor" ); ?>:</strong> <?php echo wc_price( $external_invoice_sum ); ?>
    </li>
    <li><strong><?php echo __( "TB/Resultat" ); ?>
            :</strong> <?php echo wc_price( $orders_total_sum - $external_invoice_sum ); ?></li>
</ul>


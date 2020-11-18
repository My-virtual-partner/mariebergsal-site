<?php
/**
 * Container for the price adjustment part of the steps in project creation.
 */

$order                     = new WC_Order( $_GET["order-id"] );
$order_summary_heading     = get_field( 'order_summary_heading', $order->ID );
$order_summary_description = get_field( 'order_summary_description', $order->ID );

if ( ! $order_summary_description ) {
	$order_summary_description = get_field( 'order_summary_description', 'options' );
}

?>
<input type="hidden" id="order_id" name="order_id" value="<?php echo $_GET["order-id"]; ?>">


<?php include( 'price-adjust-part.php' ); ?>


<?php
/**
 * Container for the tax deduction part of the steps in project creation.
 */

$order                     = new WC_Order( $_GET["order-id"] );
$order_summary_heading     = get_field( 'order_summary_heading', $order->ID );
$order_summary_description = get_field( 'order_summary_description', $order->ID );
$tax_deduction             = get_field( "imm-sale-tax-deduction", $order->ID );
if ( ! $order_summary_description ) {
	$order_summary_description = get_field( 'order_summary_description', 'options' );
}

?>
<input type="hidden" id="order_id" name="order_id" value="<?php echo $_GET["order-id"]; ?>">

<div class="col-md-12">
    <label class="top-buffer-half" for="imm-sale-tax-deduction"><?php echo __( "Maximalt ROT-avdrag" ) ?></label>
    <i><?php echo __( "Fyll i det ROT avdrag kund uppger för att beräkna pris i affärsförslag" ) ?></i>

    <input value="<?php echo $tax_deduction; ?>" type="number"
           name="imm-sale-tax-deduction" class="form-control" id="imm-sale-tax-deduction">
</div>


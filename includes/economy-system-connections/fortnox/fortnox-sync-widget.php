<?php

$FN = new \Fortnox\Plugin();


$nonce = wp_create_nonce( "fortnox_woocommerce" );

$synced = $FN->is_order_synced( $order->ID );
echo "<ul class='list-unstyled'>";
echo "<li id='fortnox-message'></li>";
if ( $synced == 1 ) {
	echo '<li><h4 class="" > ' . __( "Projektet är synkat till Fortnox" ) . '</h4></li>';

} else {
	echo '<li><a href="#" class="btn btn-brand syncOrderToFortnox" data-order-id="' . $order->ID . '" data-nonce="' . $nonce . '" title="Sync order to Fortnox">' . __( "Synka till Fortnox" ) . '</a></li>';
	echo '<li><span class="spinner fortnox-spinner"></span></li>';

}

echo "</ul>";


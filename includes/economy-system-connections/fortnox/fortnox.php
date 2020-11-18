<?php


define( 'ACCESS_TOKEN', '9ac820b8-26b9-4f0c-aaec-90d99f6d0e0e' );
define( 'CLIENT_SECRET', 'O8XHJKEXT7' );
define( 'CONTENT_TYPE', 'application/json' );
define( 'ACCEPTS', 'application/json' );
define( 'ENDPOINT', 'https://api.fortnox.se/3/' );


add_action( 'init', 'init_loaded_fn' );
function init_loaded_fn() {


	function create_order( $order_id ) {
		$wc_order = new WC_Order( $order_id );

		return $wc_order;
	}


	function make_api_call_to_fortnox( WC_Order $order, $method ) {

		$ent = "orders/" . $order->get_id();

		$fortnox_order_from_fn = json_decode( apiCall( "GET", $ent ), JSON_PRETTY_PRINT );

		if ( $fortnox_order_from_fn["ErrorInformation"]["Error"] == 1 ) {

			$fortnox_order = [
				"Order" => [
					"YourOrderNumber" => $order->get_id(),
					"DocumentNumber"  => $order->get_id(),
					"CustomerNumber"  => 1,
					"OrderRows"       => [
						0 => [
							"ArticleNumber"     => 10,
							"DeliveredQuantity" => 10,
							"Description"       => "Artikel 10",
							"OrderedQuantity"   => 10,
							"Unit"              => "st"
						],

					]
				]
			];

			$response = apiCall( $method, 'orders/', json_encode( $fortnox_order ) );

		} else {
			$fortnox_order = [
				"Order" => [
					"CustomerNumber"  => 1,
					"OrderRows"       => [
						0 => [
							"ArticleNumber"     => 10,
							"DeliveredQuantity" => 100,
							"Description"       => "Artikel 10",
							"OrderedQuantity"   => 100,
							"Unit"              => "st"
						],

					]
				]
			];

			$response = apiCall( "PUT", 'orders/' . $order->get_id(), json_encode( $fortnox_order ) );
		}


		var_dump( $response );
		die;
	}

	//$o = create_order( 1067 );

	//make_api_call_to_fortnox( $o, "POST" );
}


function apiCall( $requestMethod, $entity, $body = null ) {

	$curl    = curl_init( ENDPOINT . $entity );
	$options = array(
		'Access-Token: ' . ACCESS_TOKEN . '',
		'Client-Secret: ' . CLIENT_SECRET . '',
		'Content-Type: ' . CONTENT_TYPE . '',
		'Accept: ' . ACCEPTS . ''
	);

	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $curl, CURLOPT_HTTPHEADER, $options );
	curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, $requestMethod );

	if ( $requestMethod == 'POST' || $requestMethod == 'PUT' ) {
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $body );
	}

	$curlResponse = curl_exec( $curl );
	curl_close( $curl );

	return $curlResponse;
}
<?php
 function make( $method, $path, $data = [] ) {

	
			$curl = curl_init();

			curl_setopt( $curl, CURLOPT_URL, "https://api.fortnox.se/3" . $path );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $curl, CURLOPT_HTTPHEADER, [
				'Access-Token: '. get_option( 'fortnox_access_token' ),
				'Client-Secret: 3zfQr9S51A',
				'Content-Type: application/json',
				'Accept: application/json'
			] );

		//	$dataJson = html_entity_decode(json_encode(clean_data( $data )));
$dataJson = json_encode($data);

		if( "POST" == $method )
				curl_setopt( $curl, CURLOPT_POST, true );

			if( "PUT" == $method || "DELETE" == $method )
                curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, $method );


			if( "POST" == $method || "PUT" == $method ){

                if( $dataJson == ''){
                    throw new Exception( __( "JSON Encoding error. Path: " . json_last_error() . ". METHOD: " . $method . "DATA: "
                        . print_r( clean_data( $data ), true ), 1 ) );
                }

				curl_setopt( $curl, CURLOPT_POSTFIELDS, $dataJson );
            }

			$response = curl_exec( $curl );
			curl_close( $curl );
		
	
			$response = json_decode( $response );

			return $response; 

	}
 

   function clean_data( $data )
    {
        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $data[$k] = clean_data($v);
            }
        } else if (is_string ($data)) {
            return htmlspecialchars( preg_replace('/[\/]/', '_', $data ) );
        }
        return stripslashes($data);
    }

				
function get( $email ) {
		
		if (empty($email) || !isset($email))
			$email = 'none@none.none';

		try {
			$response = make( "GET", "/customers?email=" . urlencode( $email ) );

			if( ! empty( $response->Customers ) )
				return $response->Customers[ 0 ];
		}
		catch( Exception $error ) {
			throw new Exception( $error->getMessage() );
		}
	}
	
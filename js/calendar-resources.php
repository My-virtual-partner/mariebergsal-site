<?php
require_once( "../../../../wp-load.php" );

$resources = [];

//$user_logins = $_GET["user_logins"];
$user_logins = $_POST["user_logins"];
//echo $user_logins;die;

if ( get_user_role() == "sale-sub-contractor" ) {


	$meta_value = get_user_meta(get_current_user_id(), 'sale-sub-contractor_company', true);

	$args  = array(
		'role__in' => array('sale-sub-contractor' ),
		'meta_key'     => 'sale-sub-contractor_company',
		'meta_value'   => $meta_value,

	);
	$users = get_users( $args );

} elseif ( $user_logins ) {

	$args  = array(
		'role__in' => array( 'sale-technician', 'sale-sub-contractor' ),
		'include' => $user_logins
	);
	$users = get_users( $args );

} else {

	$args  = array(
		'role__in' => array( 'sale-technician', 'sale-sub-contractor' ),

	);
	$users = get_users( $args );

}

foreach ( $users as $user ) {
    $company =  get_user_meta( $user->ID, 'sale-sub-contractor_company', true );
    $display_name = $user->display_name;
    $shortname = get_user_meta( $user->ID, 'sale-sub-contractor_shortname', true );
     if(!empty($company)){
         if($shortname) {
        $title_user =  $shortname;
    }else{
        $title_user =  $display_name;
    }
    }else{
        $title_user = 'Teknikan' .'-'.$display_name ;
    }

//    if($shortname) {
//        $title_user =  $shortname;
//    }else{
//            $title_user = 'Teknikan' .'-'.$display_name ;
//    }
	$single_resource = [
		'id'    => $user->ID,
		'title' => $title_user,
	];

	array_push( $resources, $single_resource );
}


echo json_encode( $resources, JSON_PRETTY_PRINT );

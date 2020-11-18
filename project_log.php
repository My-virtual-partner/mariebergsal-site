<?php
function getProjectLog($projectid){
global $wpdb;
$tablename = "{$wpdb->prefix}project_log";

$results = $wpdb->get_results( "SELECT * FROM ".$tablename." WHERE project_id =  '".$projectid."'", OBJECT );
return $results;	
}
function custom_userActivity($projectid,$activity){
	
global $wpdb;
$tablename = "{$wpdb->prefix}project_log";
$userid = get_current_user_id();
$results = $wpdb->get_results( "SELECT log FROM ".$tablename." WHERE userid = '".$userid."' AND project_id =  '".$projectid."' AND created_date =  CURDATE()", OBJECT );
 if(count($results) === 0){
$wpdb->insert($tablename, 
array( 'project_id'=> $projectid,'userid' => $userid,'created_date'=>date('Y-m-d'), 'log'=>json_encode(array($activity))), array( '%d', '%d', '%s', '%s' ));  
 } else{
	$updateLog = json_decode($results[0]->log);
	array_push($updateLog,$activity);
	$wpdb->update($tablename,array('log'=>json_encode($updateLog)),
	array( 'project_id' => $projectid, 'userid' => $userid, 'created_date'=>date('Y-m-d')), 
	array('%s'), array( '%d','%d','%s' )); 
 }
	//echo $wpdb->last_query; die;
}
function email_userActivity($id,$activity){
global $wpdb;
$tablename = "{$wpdb->prefix}email_log";
$userid = get_current_user_id();
$results = $wpdb->get_results( "SELECT log FROM ".$tablename." WHERE user_id = '".$userid."' AND order_id =  '".$id."' AND created_date =  CURDATE()", OBJECT );
 if(count($results) === 0){
$wpdb->insert($tablename, 
array( 'order_id'=> $id,'user_id' => $userid,'created_date'=>date('Y-m-d'), 'log'=>json_encode(array(date('Y-m-d h:i:s'),$activity))), array( '%d', '%d', '%s', '%s' ));  
 } else{
	$updateLog = json_decode($results[0]->log);
	array_push($updateLog,date('Y-m-d h:i:s'),$activity);
	$wpdb->update($tablename,array('log'=>json_encode($updateLog)),
	array( 'order_id' => $id, 'user_id' => $userid, 'created_date'=>date('Y-m-d')), 
	array('%s'), array( '%d','%d','%s' )); 
 }
	//echo $wpdb->last_query; die;
}
?>
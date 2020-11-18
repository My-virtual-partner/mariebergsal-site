<?php
$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path . '/wp-config.php');
$invoice_number = $_POST['invoice_number'];
$project_id = $_POST['project_id'];
global $wpdb;
$table = $wpdb->prefix . 'external_invoice';
$wpdb->delete($table, ['invoice_number' => $invoice_number,'project_id'=>$project_id], ['%s','%d']);
die;
?>
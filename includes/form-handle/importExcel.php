 <?php /* global $wpdb;
    if (isset($_FILES["importExcelfile"])) {
        if ($_FILES["importExcelfile"]["error"] > 0) {
            $excelError = "Return Code: " . $_FILES["importExcelfile"]["error"] . "<br />";
        } else {
            $file_ext = strtolower(end(explode('.', $_FILES['importExcelfile']['name'])));
            if ($file_ext == 'csv') {
                $row = 1;
                $userid = get_current_user_id();
                if (($handle = fopen($_FILES["importExcelfile"]["tmp_name"], "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                        $data = array_map("utf8_encode", $data);
                        $num = count($data);

                        $row++;
                        $getId = explode(',', $data[8]);
                        if (is_numeric($getId[0])) {
                            $checkPost = array('shop_order', 'imm-sale-project');
                            $postStatuts = get_post_type($getId[0]);

                            if (in_array($postStatuts, $checkPost)) {
                                if ($postStatuts != 'imm-sale-project') {
                                $projectid = get_post_meta($getId[0], 'imm-sale_project_connection', true);
                                } else {
                                 $projectid = $getId[0];
                                }
								$all[] = $projectid;
                                $price = explode(',', $data[9]);
								$date=date_create($data[1]);
 $newdate = date_format($date,"Y-m-d");
                                $newdataupload = array('invoice_number' => $data[0], 'invoice_description' => $data[7], 'invoice_price' => $price[0],'invoice_date'=>$newdate);
								$result = $wpdb->get_results('SELECT * FROM VQbs2_external_invoice WHERE invoice_number = "'. $data[0] .'" AND project_id = "'.$projectid.'"');
                                
                                if (count($result) == 0) {
									$wpdb->insert('VQbs2_external_invoice', array('invoice_number' => $data[0],'project_id' => $projectid), array('%s','%d'));
                                } 
								 $wpdb->update('VQbs2_external_invoice', $newdataupload, array('invoice_number' => $data[0],'project_id' => $projectid));
$newdataupload = $result = $getId = $projectid =  $price =  $postStatuts = $date= $newdate = '';

                            }
                        }
                    }
                  
                    $excelError = "File successfully uploaded ";
                    fclose($handle);
                }
            } else {
                $excelError = "File extension should be .csv ";
            }
        }
    }*/
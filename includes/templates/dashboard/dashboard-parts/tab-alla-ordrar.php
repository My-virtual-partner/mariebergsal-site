<?php
/**
 * Lead tab in System Dashboard.
 */
?>
<div id="alla-ordrar" class="tab-pane fade top-buffer-half">
  <?php global $wpdb;
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
								//print_r($price);
								$date=date_create($data[1]);
								$newdate = date_format($date,"Y-m-d");
								$description = trim($data[7]);
                                $newdataupload = array('invoice_number' => $data[0], 'invoice_description' => $description, 'invoice_price' => $price[0],'invoice_date'=>$newdate);
								//echo "<pre>"; print_r($newdataupload); echo "</pre>"; 
								$result = $wpdb->get_results('SELECT id FROM VQbs2_external_invoice WHERE invoice_number = "'. $data[0] .'" AND invoice_price = "'. $price[0] .'" AND invoice_description = "'. $description .'" AND invoice_date = "'. $newdate .'" AND project_id = "'.$projectid.'"');
								
                  $id = $result[0]->id;
                                if (count($result) == 0) {

									$wpdb->insert('VQbs2_external_invoice', array('project_id' => $projectid), array('%d'));
									
									$id = $wpdb->insert_id;
                                } 
								 $wpdb->update('VQbs2_external_invoice', $newdataupload, array('id' => $id));

                              $description =  $newdataupload = $id = $result = $getId = $projectid =  $price =  $postStatuts = $date= $newdate = '';

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
    }

    if (isset($excelError)) {
        ?>

        <div class="alert alert-info">
            <strong>Info!</strong> <?php echo $excelError; ?>
        </div>
    <?php } ?>

    <div class="row top-buffer-half">
        <div class="col-md-6">
            <form method="post" action="" enctype="multipart/form-data">




                <div class="form-group files">
                    <label><?php echo __("Ladda upp csv från Fortnox") ?> </label>
                    <input type="file" class="form-control" name="importExcelfile">
                </div>

                <div class="mt-3"> <input type="submit" class="btn btn-primary" name="importExcel" value="Importera" /></div>

            </form>


        </div>


    </div>
</div>

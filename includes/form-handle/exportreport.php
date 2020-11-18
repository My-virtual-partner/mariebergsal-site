<?php
$export_data = json_decode(stripslashes($_POST['export_data']));
//print_r($export_data);die;

 $wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/Classes/PHPExcel.php');



$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Govinda")
                             ->setLastModifiedBy("Govinda")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");




$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Order')
			->setCellValue('B1', 'Skapat')
			->setCellValue('C1', 'Orderdatum')	
			->setCellValue('D1', 'Status')
			->setCellValue('E1', 'Projekt id')
			->setCellValue('F1', 'Kund')			 
			->setCellValue('G1', 'Säljare')			 
			->setCellValue('H1', 'Butik')			 
			->setCellValue('I1', 'Betalningstyp')	
			->setCellValue('J1', 'Internal status')				
                        ->setCellValue('K1', 'Total')
        ->setCellValue('L1', 'Faktura 1')
        ->setCellValue('M1', 'Faktura 1 summa')
        ->setCellValue('N1', 'Faktura 2')
        ->setCellValue('O1', 'Faktura 2 summa');



$rowCount = 2;



foreach($export_data  as  $users)
{


	 $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $users->id);


	 $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount,$users->skapat);
	  $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount,$users->order_date);
	  
	   $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount,$users->status);
	  
	    $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount,$users->pid);
		 $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,$users->custname);
		  $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount,$users->saljare);
	  $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount,$users->butik);
	
	  $objPHPExcel->getActiveSheet()->setCellValue('I'.$rowCount,$users->paymenttetm);
	    $objPHPExcel->getActiveSheet()->setCellValue('J'.$rowCount,$users->internal_status);
		$objPHPExcel->getActiveSheet()->setCellValue('K' . $rowCount, $users->totalamtformat);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $rowCount, $users->advance);
    $objPHPExcel->getActiveSheet()->setCellValue('M' . $rowCount, $users->advance_total_amount);
    $objPHPExcel->getActiveSheet()->setCellValue('N' . $rowCount, $users->final);
    $objPHPExcel->getActiveSheet()->setCellValue('O' . $rowCount, $users->final_total_amount);


    $rowCount++;
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('UserList');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment;filename="userList.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
die;

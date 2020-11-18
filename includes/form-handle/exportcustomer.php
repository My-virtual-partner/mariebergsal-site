<?php
$export_data = json_decode(stripslashes($_POST['exportuserdata']));

$wp_path = $_SERVER["DOCUMENT_ROOT"];
include_once($wp_path.'/Classes/PHPExcel.php');



$objPHPExcel = new PHPExcel();
// Set document properties
$objPHPExcel->getProperties()->setCreator("Ram")
                             ->setLastModifiedBy("Ram")
                             ->setTitle("Office 2007 XLSX Test Document")
                             ->setSubject("Office 2007 XLSX Test Document")
                             ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                             ->setKeywords("office 2007 openxml php")
                             ->setCategory("Test result file");




$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1','Kundnummer')
			->setCellValue('B1', "Fullständigt namn")
			->setCellValue('C1', 'E - post')
			->setCellValue('D1', 'Telefonummer')
			->setCellValue('E1', 'Postnummer')
			->setCellValue('F1', 'Postort')			 
			->setCellValue('G1','Address')			 
			->setCellValue('H1', 'Säljare');		 


$rowCount = 2;



foreach($export_data->data  as  $users)
{


	 $objPHPExcel->getActiveSheet()->setCellValue('A'.$rowCount, $users->id);


	 $objPHPExcel->getActiveSheet()->setCellValue('B'.$rowCount,$users->customer_name);
	  $objPHPExcel->getActiveSheet()->setCellValue('C'.$rowCount,$users->email);
	   $objPHPExcel->getActiveSheet()->setCellValue('D'.$rowCount,$users->phone);
	    $objPHPExcel->getActiveSheet()->setCellValue('E'.$rowCount,$users->postcode);
		 $objPHPExcel->getActiveSheet()->setCellValue('F'.$rowCount,$users->city);
		  $objPHPExcel->getActiveSheet()->setCellValue('G'.$rowCount,$users->address);
	  $objPHPExcel->getActiveSheet()->setCellValue('H'.$rowCount,$users->salesman);

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

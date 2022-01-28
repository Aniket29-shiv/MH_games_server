<?php

require_once 'config.php';

    $email='';
    $from='';
    $to='';
    $refid='';

    if(isset($_GET['semail'])){ $email=$_GET['semail'];}
    if(isset($_GET['fdate'])){ $from=$_GET['fdate'];}
    if(isset($_GET['tdate'])){ $to=$_GET['tdate'];}
      if(isset($_GET['refid'])){ $refid=$_GET['refid'];}
   
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Kolkata');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("mbhitech")
							 ->setLastModifiedBy("mbhitech")
							 ->setTitle("Excel List")
							 ->setSubject("Excel List")
							 ->setDescription("Excel List")
							 ->setKeywords("Excel List")
							 ->setCategory("Excel List");


    
   
     $makequery="SELECT * FROM `referral_send`  where  1=1";
    
    if($refid != ''){ $makequery .=" and `ref_username` like '%$refid%' "; }
    if($email != ''){ $makequery .=" and `receiver`='$email'"; }
    if($from != ''){ $makequery .=" and  `date` >= '$from 00:00:00'"; }
    if($to != ''){ $makequery .=" and `date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY `date` DESC";

	$result=mysqli_query($conn,$makequery);



// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'DATE')
            ->setCellValue('B1', 'SENDER')
            ->setCellValue('C1', 'RECEIVER')
            ->setCellValue('D1', 'SUBJECT')
            ->setCellValue('E1', 'COUNT')
            
         ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;
	
            $date = $row['date'];
            $ref_username = $row['ref_username'];
            $receiver = $row['receiver'];
            $subject = $row['subject'];
            $content = strip_tags($row['content']);
            
           
		
		 
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $date);	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $ref_username);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $receiver);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $subject);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $content);
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('EMAIL-LIST-strip_tags(');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);





$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('FF1E4580');
$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
$cdate=date('d-m-Y');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="REFER-EMAIL-'.$cdate.'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
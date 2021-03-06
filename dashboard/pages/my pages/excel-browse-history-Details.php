<?php

require_once 'config.php';

    $searchval='';
    $from='';
    $to='';
   if(isset($_GET['userid'])){ $searchval=$_GET['userid'];}
   if(isset($_GET['fromdate'])){ $from=$_GET['fromdate'];}
   if(isset($_GET['todate'])){ $to=$_GET['todate'];}
    
    
     $fname="";
    $lname="";
 $getuser=mysqli_query($conn,"select first_name ,last_name from users where user_id='$searchval'");
 
 if(mysqli_num_rows($getuser) > 0){
 
     $listuser=mysqli_fetch_object( $getuser);
     $fname=$listuser->first_name;
     $lname=$listuser->last_name;
     
 }

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


$makequery="SELECT * FROM `browse_history` where user_id='$searchval'  ";
    
    if($from != ''){ $makequery .=" and  `created_date` >= '$from 00:00:00'"; }
    if($to != ''){ $makequery .=" and  `created_date` <= '$to 23:59:59'"; }
    $makequery .=" order by id desc";
    

	$result=mysqli_query($conn,$makequery);



// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Username')
            ->setCellValue('B1', 'BROWSE URL')
            ->setCellValue('C1', 'IP')
            ->setCellValue('D1', 'OS')
            ->setCellValue('E1', 'CITY')
            ->setCellValue('F1', 'REGION')
            ->setCellValue('G1', 'COUNTRY')
            ->setCellValue('H1', 'BROWSE DATE')
           
            
         ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;

   
    $username = $row['username'];
    $browse_url = $row['browse_url'];
    $ip = $row['ip'];
    $os = $row['os'];
    $city = $row['city'];
    $region = $row['region'];
    $country = $row['country'];
    $created_date = $row['created_date'];

	 $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $username);	
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $browse_url);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $ip);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $os);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $city);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $region);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $country);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $created_date);
    
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Login-History-Of- '.$fname.' '.$lname);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);






$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()->getStartColor()->setARGB('FF1E4580');
$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client???s web browser (Excel5)
$cdate=date('d-m-Y');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Browse-History-Of- '.$fname.' '.$lname.'-'.$cdate.'.xls"');
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

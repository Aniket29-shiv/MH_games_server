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


$makequery="SELECT * FROM `login_history` where userid='$searchval'  ";
    
    if($from != ''){ $makequery .=" and  `logindate` >= '$from 00:00:00'"; }
    if($to != ''){ $makequery .=" and  `logindate` <= '$to 23:59:59'"; }
    $makequery .=" order by id desc";
    

	$result=mysqli_query($conn,$makequery);



// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Username')
            ->setCellValue('B1', 'OS')
            ->setCellValue('C1', 'IP')
            ->setCellValue('D1', 'CITY')
            ->setCellValue('E1', 'REGION')
            ->setCellValue('F1', 'COUNTRY')
            ->setCellValue('G1', 'STATUS')
            ->setCellValue('H1', 'LOGIN DATE')
            ->setCellValue('I1', 'LOGOUT DATE')
            
         ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;

   
    $username = $row['username'];
    $os = $row['os'];
    $ip = $row['ip'];
    $city = $row['city'];
    $region = $row['region'];
    $country = $row['country'];
  
    $status = $row['status'];
    $logindate = $row['logindate'];
    $logouttime = $row['logouttime'];

	
		
		 
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $username);	
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $os);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $ip);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $city);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $region);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $country);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $status);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $logindate);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $logouttime);
   
	

	
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Login-History - '.$fname.' '.$lname);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);






$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->getStartColor()->setARGB('FF1E4580');
$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
$cdate=date('d-m-Y');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Login-History - '.$fname.' '.$lname.'-'.$cdate.'.xls"');
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
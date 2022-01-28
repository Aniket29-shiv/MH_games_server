<?php

require_once 'config.php';

    $searchval='';
   if(isset($_GET['searchtxt'])){ $searchval=$_GET['searchtxt'];}
     $from='';
    $to='';
    
    
    if(isset($_GET['fdate'])){ $from=$_GET['fdate'];}
    if(isset($_GET['tdate'])){ $to=$_GET['tdate'];}
   

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


//$result  = mysql_query("SELECT * FROM `feedback`");

//$result = mysql_query("SELECT f .*,f.FullName AS fulln, f.ContactNo AS cn, f.Emailid AS email FROM feedback AS f GROUP BY f.FullName, f.ContactNo, f.Emailid HAVING(
//COUNT( * ) >1 )");

/*$makequery="SELECT * from `bajaj_sheet`  WHERE `completed` != 1 and `lotno` ='$lotno' and `refferedout` != 1 and `response` = '$rsid' order by id";*/
	
    $makequery="SELECT 
							kd.*, kd.id as kycid,
							u.username, 
						u.first_name,u.middle_name,u.last_name, 
							u.mobile_no AS mobile_no, 
							u.email AS email
							
						
					from 
							users as u
							INNER JOIN user_kyc_details AS kd ON (kd.userid = u.user_id) ";
    if($searchval != ''){ $makequery .=" where  ( u.`first_name` like '$searchval%' or  u.`last_name` like '$searchval%' or  u.`mobile_no` like '$searchval%' or  u.`email` like '$searchval%' or  u.`username` like '$searchval%')"; }
     if($from != ''){ $makequery .=" and  kd.`updated_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  kd.`updated_date` <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY kd.id  desc";

	$result=mysqli_query($conn,$makequery);



// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NAME')
            ->setCellValue('B1', 'MOBILE NUMBER')
            ->setCellValue('C1', 'MOBILE NUMBER STATUS')
            ->setCellValue('D1', 'EMAIL')
            ->setCellValue('E1', 'EMAIL STATUS')
            ->setCellValue('F1', 'USERNAME')
            ->setCellValue('G1', 'ID PROOF')
            ->setCellValue('H1', 'PAN CARD')
          
            
         ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;
	
	
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$middle_name = $row['middle_name'];
	$name=$first_name.' '.$last_name.' '.$middle_name;
	$mobile_no = $row['mobile_no'];
	$email = $row['email'];
	$username = $row['username'];
	$id_proof_status = $row['id_proof_status'];
	$pan_status = $row['pan_status'];
    $mobile_status = $row['mobile_status'];
    $email_status = $row['email_status'];

		
		 
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $name);	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $mobile_no);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $mobile_status);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $email);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $email_status);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $username);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $id_proof_status);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $pan_status);
	

	
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('KYC-Details');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
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


// Redirect output to a client’s web browser (Excel5)
$cdate=date('d-m-Y');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="KYC-Details-'.$cdate.'.xls"');
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
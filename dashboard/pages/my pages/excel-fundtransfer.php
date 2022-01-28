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
						u.user_id, 
						u.username, 
						concat(ifnull(u.first_name,''),' ',ifnull(u.middle_name,''),' ',ifnull(u.last_name,'')) AS player_name, 
						ifnull(u.mobile_no,'') AS mobile_no, 
						ifnull(u.email,'') AS email,
						kd.amount,
						kd.transaction_id,
						kd.order_id,
						kd.payment_mode,
						kd.status
				from 
						users as u
						INNER JOIN fund_added_to_player AS kd ON (kd.user_id = u.user_id)
				where 
						kd.chip_type='Real'";
    
    if($searchval != ''){ $makequery .=" and  (`first_name` like '$searchval%' or `last_name` like '$searchval%' or`mobile_no` like '$searchval%' or`email` like '$searchval%' or u.`username` like '$searchval%')"; }
    if($from != ''){ $makequery .=" and  kd.`created_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  kd.`created_date` <= '$to 23:59:59'"; }
    $makequery .= " ORDER BY u.user_id asc";

	$result=mysqli_query($conn,$makequery);



// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'USER ID')
            ->setCellValue('B1', 'FULL NAME')
            ->setCellValue('C1', 'USER ANME')
            ->setCellValue('D1', 'EMAIL')
            ->setCellValue('E1', 'MOBILE NUMBER')
            ->setCellValue('F1', 'AMOUNT')
            ->setCellValue('G1', 'TRANSACTION ID')
            ->setCellValue('H1', 'ORDER ID')
            ->setCellValue('I1', 'PAYEMENT MODE')
            ->setCellValue('J1', 'STATUS')
            
         ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;
	
    $user_id = $row['user_id'];
    $player_name = $row['player_name'];
    $username = $row['username'];
    $email = $row['email'];
    $mobile_no = $row['mobile_no'];
    $amount = $row['amount'];
    $transaction_id = $row['transaction_id'];
    $order_id = $row['order_id'];
    $payment_mode = $row['payment_mode'];
    $status = $row['status'];

	
		
		 
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $user_id);	
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $player_name);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $username);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $email);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $mobile_no);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $amount);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $transaction_id);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $order_id);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $payment_mode);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $status);
	

	
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Fund-Transfer-Details');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);





$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFill()->getStartColor()->setARGB('FF1E4580');
$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
$cdate=date('d-m-Y');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Fund-Transfer-Details'.$cdate.'.xls"');
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
<?php

require_once 'config.php';

    $searchval='';
   
   if(isset($_GET['searchtxt'])){ $searchval=$_GET['searchtxt'];}
 

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
	
    $makequery="select bd.*,us.username,us.first_name,us.middle_name,us.last_name from bank_details bd LEFT JOIN users us ON bd.user_id=us.user_id ";
    if($searchval != ''){ $makequery .=" where ( us.`first_name` like '$searchval%' or us.`last_name` like '$searchval%' or us.`mobile_no` like '$searchval%' or us.`email` like '$searchval%' or us.`username` like '$searchval%')"; }
    $makequery .= " ORDER BY us.user_id asc";
    
    $result=mysqli_query($conn,$makequery);



// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'USER NAME')
            ->setCellValue('B1', 'FULL NAME')
            ->setCellValue('C1', 'BANK NAME')
            ->setCellValue('D1', 'ACCOUNT NUMBER')
            ->setCellValue('E1', 'IFSC')
           
        
            
         ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;

    
    $fullname = $row['first_name'].' '.$row['middle_name'].' '.$row['last_name'];
    $username = $row['username'];
    $bank_name = $row['bank_name'];
    $account_no = $row['account_no'];
    $ifsc_code = $row['ifsc_code'];
  

	
		
		 
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $username);	
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $fullname);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $bank_name);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $account_no);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $ifsc_code);

	
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Bank-Details');

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
header('Content-Disposition: attachment;filename="Bank-Details'.$cdate.'.xls"');
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
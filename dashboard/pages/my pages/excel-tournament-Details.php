<?php

require_once 'config.php';

    $searchval='';
    $from='';
    $to='';
   if(isset($_GET['searchtxt'])){ $searchval=$_GET['searchtxt'];}
   if(isset($_GET['fromdate'])){ $from=$_GET['fromdate'];}
   if(isset($_GET['todate'])){ $to=$_GET['todate'];}
    

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
	
        $makequery="select * from tournament where 1=1";
        
        if($searchval != ''){ $makequery .=" and  `title` like '$searchval%' "; }
        if($from != ''){ $makequery .=" and  start_date >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and start_date <= '$to 23:59:59'"; }
        
        $makequery .= " ORDER BY tournament_id asc";
        $result=mysqli_query($conn,$makequery);



            // Add some data
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Tournament ID')
            ->setCellValue('B1', 'Title')
            ->setCellValue('C1', 'Price')
            ->setCellValue('D1', 'Start Date')
            ->setCellValue('E1', 'Start Time')
            ->setCellValue('F1', 'Registration Start Date')
            ->setCellValue('G1', 'Registration Start Time')
            ->setCellValue('H1', 'Registration End Date')
            ->setCellValue('I1', 'Registration End Time')
            ->setCellValue('J1', 'Entry Fee')
            ->setCellValue('K1', 'No Of Player')
            ->setCellValue('L1', 'Date')
          ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;
	
	
	
        $tournament_id = $row['tournament_id'];
        $price = $row['price'];
        $title = $row['title'];
        $start_date = $row['start_date'];
        $start_time = $row['start_time'];
        $reg_start_date = $row['reg_start_date'];
        $reg_start_time = $row['reg_start_time'];
        $reg_end_date = $row['reg_end_date'];
        
        
        $reg_end_time = $row['reg_end_time'];
        $entry_fee = $row['entry_fee'];
        $no_of_player = $row['no_of_player'];
        $created_date = $row['created_date'];
   
		
		 
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $tournament_id);	
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $price);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $title);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $start_date);
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $start_time);
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $reg_start_date);
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $reg_start_time);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $reg_end_date);
    $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $reg_end_time);
    $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $entry_fee);
    $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $no_of_player);
    $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $created_date);
 
	

	
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Tournament-Details');

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
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);





$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setSize(11);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()->getStartColor()->setARGB('FF1E4580');
$objPHPExcel->getDefaultStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
$cdate=date('d-m-Y');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Tournament-Details'.$cdate.'.xls"');
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
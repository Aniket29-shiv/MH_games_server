<?php

require_once 'config.php';

    $game='';
    $players='';
    $bet='';
    $status='';
    $from='';
    $to='';
    $status='';
    $chiptype='';
    
    if(isset($_GET['games'])){ $game=$_GET['games'];}
    if(isset($_GET['player'])){ $players=$_GET['player'];}
    if(isset($_GET['fdate'])){ $from=$_GET['fdate'];}
    if(isset($_GET['tdate'])){ $to=$_GET['tdate'];}
     if(isset($_GET['ctype'])){ $chiptype=$_GET['ctype'];}
      if(isset($_GET['gstatus'])){ $status=$_GET['gstatus'];}
   
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
	
 $makequery="SELECT g.*,u.first_name,u.last_name,u.mobile_no,u.email FROM `game_transactions` as g left join users as u on u.user_id=g.user_id where 1=1 ";
    if($game != ''){ $makequery .=" and g.`game_type`='$game'"; }
    if($chiptype != ''){ $makequery .=" and g.`chip_type`='$chiptype'"; }
    if($status != ''){ $makequery .=" and g.`status`='$status'"; }
    if($players != ''){ $makequery .=" and (g.`player_name` like '%$players%' or u.`email` like '%$players%' or u.`mobile_no` like '%$players%' )"; }
    if($from != ''){ $makequery .=" and  g.`transaction_date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  g.`transaction_date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY g.`transaction_date`";

	$result=mysqli_query($conn,$makequery);



// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'DATE')
            ->setCellValue('B1', 'TABLE ID')
            ->setCellValue('C1', 'ROUND ID')
            ->setCellValue('D1', 'TABLE NAME')
            ->setCellValue('E1', 'PLAYER NAME')
            ->setCellValue('F1', 'GAME TYPE')
            ->setCellValue('G1', 'STATUS')
            ->setCellValue('H1', 'AMOUNT')
            ->setCellValue('I1', 'CHIP TYPE')
            ->setCellValue('J1', 'PLAYER FULL NAME')
            ->setCellValue('K1', 'EMAIL ID')
            ->setCellValue('L1', 'MOBILE NUMBER')
         ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;
            $date = $row['transaction_date'];
         $table_id = $row['table_id'];
          $round_id = $row['round_no'];
          $table_name = $row['table_name'];
          $players_name = $row['player_name'];
           $game_type = $row['game_type'];
           $status = $row['status'];
           $amount = $row['amount'];
           $chip_type = $row['chip_type'];
            $name = $row['first_name'].' '. $row['last_name'];
             $email = $row['email'];
              $mobile_no = $row['mobile_no'];

		
		 
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $date);	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $table_id);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $round_id);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $table_name);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $players_name);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $game_type);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $status);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $amount);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $chip_type);
		$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $name);
			$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $email);
				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $mobile_no);

	
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Player-Transaction-Details-');

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


// Redirect output to a client???s web browser (Excel5)
$cdate=date('d-m-Y');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Player-Transaction-Details-'.$cdate.'.xls"');
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
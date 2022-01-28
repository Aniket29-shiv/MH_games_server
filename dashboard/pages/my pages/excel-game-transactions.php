<?php

require_once 'config.php';

    $game='';
    $players='';
    $bet='';
    $status='';
    $from='';
    $to='';
    
    if(isset($_GET['games'])){ $game=$_GET['games'];}
    if(isset($_GET['player'])){ $players=$_GET['player'];}
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
	
 $makequery="SELECT * FROM `company_balance` where 1=1 ";
    if($game != ''){ $makequery .=" and `game_type`='$game'"; }
    if($players != ''){ $makequery .=" and `player_capacity`='$players'"; }
     if($from != ''){ $makequery .=" and  `date` >= '$from 00:00:00'"; }
        if($to != ''){ $makequery .=" and  `date` <= '$to 23:59:59'"; }
    $makequery .= "  ORDER BY `company_balance`.`date` DESC";

	$result=mysqli_query($conn,$makequery);



// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'TABLE ID')
            ->setCellValue('B1', 'ROUND ID')
            ->setCellValue('C1', 'PLAYER CAPACITY')
            ->setCellValue('D1', 'GAME TYPE')
            ->setCellValue('E1', 'COMMISSION')
            ->setCellValue('F1', 'TOTAL AMOUNT')
            ->setCellValue('G1', 'AMOUNY')
            ->setCellValue('H1', 'PLAYERS NAME')
            ->setCellValue('I1', 'DATE')
         ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;

	
        $table_id = $row['table_id'];
        $round_id = $row['round_id'];
        $player_capacity = $row['player_capacity'];
        $game_type = $row['game_type'];
        $commission = $row['commission'];
        $total_amount = $row['total_amount'];
        $amount = $row['amount'];
        $players_name = $row['players_name'];
        $date = $row['date'];

		
		 
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $table_id);	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $round_id);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $player_capacity);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $game_type);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $commission);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $total_amount);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $amount);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $players_name);
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $date);

	
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Game-Transaction-Details-');

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
header('Content-Disposition: attachment;filename="Game-Transaction-Details-'.$cdate.'.xls"');
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
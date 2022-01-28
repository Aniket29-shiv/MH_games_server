<?php

require_once 'config.php';

    $joker='';
    $players='';
    $bet='';
    $status='';
    
    
    if(isset($_GET['joke'])){ $joker=$_GET['joke'];}
    if(isset($_GET['play'])){ $players=$_GET['play'];}
    if(isset($_GET['bets'])){ $bet=$_GET['bets'];}
    if(isset($_GET['action'])){ $status=$_GET['action'];}

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
							 ->setLastModifiedBy("Ambhitech")
							 ->setTitle("Excel List")
							 ->setSubject("Excel List")
							 ->setDescription("Excel List")
							 ->setKeywords("Excel List")
							 ->setCategory("Excel List");


//$result  = mysql_query("SELECT * FROM `feedback`");

//$result = mysql_query("SELECT f .*,f.FullName AS fulln, f.ContactNo AS cn, f.Emailid AS email FROM feedback AS f GROUP BY f.FullName, f.ContactNo, f.Emailid HAVING(
//COUNT( * ) >1 )");

/*$makequery="SELECT * from `bajaj_sheet`  WHERE `completed` != 1 and `lotno` ='$lotno' and `refferedout` != 1 and `response` = '$rsid' order by id";*/
	
$makequery="select * from player_table where game='Cash Game' AND game_type='Pool Rummy' ";
    if($joker != ''){ $makequery .=" and `joker_type`='$joker'"; }
    if($players != ''){ $makequery .=" and `player_capacity`='$players'"; }
    if($bet != ''){ 
          
            if($bet == 'low'){   $makequery .= " and `min_entry` <= 100";}
            if($bet == 'medium'){   $makequery .= " and `min_entry` >= 101 and `min_entry` <= 1000";}
            if($bet == 'high'){   $makequery .= " and `min_entry` >= 1001";}
            
            
    }
    if($status != ''){ $makequery .=" and `table_status`='$status'"; }
    $makequery .= " ORDER BY table_id DESC";

	$result=mysqli_query($conn,$makequery);



// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Sr.No.')
            ->setCellValue('B1', 'TABLE NAME')
            ->setCellValue('C1', 'JOKER TYPE')
            ->setCellValue('D1', 'POINT VALUE')
            ->setCellValue('E1', 'MIN ENTRY')
            ->setCellValue('F1', 'STATUS')
            ->setCellValue('G1', 'PLAYER')
            ->setCellValue('H1', 'ACTION')
         ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;
	
	
	$table_name = $row['table_name'];
	$joker_type = $row['joker_type'];
	$point_value = $row['point_value'];
	$min_entry = $row['min_entry'];
	$status = $row['status'];
	$player_capacity = $row['player_capacity'];
	$table_status = $row['table_status'];

    $tstatustxt='';
    if($table_status == 'S'){ $tstatustxt='STOP'; }
    if($table_status == 'L'){ $tstatustxt='LIVE'; }
		
		 
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $j);	
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $table_name);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $joker_type);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $point_value);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $min_entry);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $status);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $player_capacity);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $tstatustxt);

	
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Cash-Pool-Lobby-Rummy');

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
header('Content-Disposition: attachment;filename="Cash-Pool-Lobby-Rummy-'.$cdate.'.xls"');
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
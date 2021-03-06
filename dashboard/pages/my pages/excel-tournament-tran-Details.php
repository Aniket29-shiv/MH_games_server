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
	   
    /* $makequery="SELECT ts.*,t.`title`,t. `price`,t.`entry_fee`,u.name FROM `tournament_transaction` as ts 
        left join `tournaments` as t on t.id=ts.tournament_id
        left join `users` as u on u.username=ts.player_id
        where ts.tournament_id='$searchval' ORDER BY ts.`position` asc";*/
        
         $makequery="SELECT ts.*,t.`title`,t. `price`,t.`entry_fee`,u.first_name,u.last_name,u.username FROM `tournament_transaction` as ts 
        left join `tournament` as t on t.tournament_id=ts.tournament_id
        left join `users` as u on u.user_id=ts.player_id
        where ts.tournament_id='$searchval' ORDER BY ts.`position` asc";
        $result=mysqli_query($conn,$makequery);



            // Add some data
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Username')
            ->setCellValue('B1', 'Player Name')
            ->setCellValue('C1', 'Position')
            ->setCellValue('D1', 'Score')
            ->setCellValue('E1', 'Tournament Title')
            ->setCellValue('F1', 'Entry_fee')
            ->setCellValue('G1', 'Entry_Date')
            ->setCellValue('H1', 'Taken Date')
           
            
          ;
			
$i = 1;
$j = 0;
                  
while($row = mysqli_fetch_array($result))
{



	$i++;
	$j++;
	

	
    
    $player_id = $row['username'];
    $name = $row['first_name'].' '.$row['last_name'];
    $position = $row['position'];
    $score = $row['score'];
    $title = $row['title'];
    $price = $row['price'];
    $entry_fee = $row['entry_fee'];
    $entry_date = $row['entry_date'];
    
    $taken_date = $row['taken_date'];
        
       
        
   
		
		 
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $player_id);	
    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $name);
    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $position);
    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $score);
   
    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $title);
    
    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $entry_fee);
   
    $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $entry_date);
    $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $taken_date);
    
 
	

	
	
}
		
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Tournament-Transaction-Details');

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


// Redirect output to a client???s web browser (Excel5)
$cdate=date('d-m-Y');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Tournament-Transaction-Details'.$cdate.'.xls"');
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
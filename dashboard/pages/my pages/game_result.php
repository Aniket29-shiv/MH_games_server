<?php 
	include ('lock.php');
	include ('config.php');
	 if(isset($_GET['roundid'])){ 
	     $roundid=$_GET['roundid']; 
	 

    $query = "SELECT * FROM `game_details` where round_id='$roundid' limit 1";
    $result = $conn->query($query);
    $row=$result->fetch_assoc();
     $user_id = $row['user_id'];
	  $group_id = $row['group_id'];
	   $round_id = $row['round_id'];
    $querywin = "SELECT * FROM `game_transactions` where round_no='$roundid' and player_name='$user_id'";
    //echo $querywin;
    $resultwin = $conn->query($querywin);  
    $rowwin=$resultwin->fetch_assoc();
    
	 }

?>

<!DOCTYPE html>
<html>
 <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Rummy Admin Panel</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.7 -->
	<link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
	<!-- Ionicons -->
		<link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	<link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
	<!-- Theme style -->
		<link rel="stylesheet" href="../../css/jquery-ui.css">
	<link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
	
	<link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
	<link rel="stylesheet" href="../../css/style.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<style>
.table>thead:first-child>tr:first-child>th {
     border-top: 1px solid #0a0909; 
}
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td {
    border: 1px solid #0a0909;
}
</style>
<body class="hold-transition skin-blue sidebar-mini">
	<div class="wrapper">
		<header class="main-header">
			<div id="header"></div>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar">
			<section class="sidebar">
				<div class="sidebar-menu" data-widget="tree" id="sidebar-menu"></div>
			</section>
		</aside>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Main content -->
			<section class="content">
				
							<div class="row">
					<div class="col-xs-12">
						<div class="box point-lobby-wrapper">
							<div class="box-body table-responsive">
							     <div class="box-header with-border">
							         <div class="col-md-8">
								        <h3 class="box-title">Game Result</h3>
								    </div>
								     
							</div>
							<hr style="border:0.5px solid; margin-top: 0px;">
                       <div class="col-xs-12" style="padding:10px;background: #101010;color: white;margin-bottom: 10px;font-size: 18px;">
                            <div class="col-xs-4"><b>Game Type : </b><?php echo $rowwin['game_type'];?></div> 
                            <div class="col-xs-4"><b>Roundid : </b><?php echo $roundid;?></div> 
                            <div class="col-xs-4"><b>Table Name : </b><?php echo $rowwin['table_name'];?></div> 
                           
                            </div>
								<div>
									<table  style="text-align:center" class="table table-bordered table-hover">
										<thead>
											<tr>
												<th>User Name</th>
												<th>Status</th>
												<th>Result</th>
												<th>Score</th>
											</tr>
										</thead>
										<tbody>
										   
										  	<?php if(isset($_GET['roundid'])){ $roundid=$_GET['roundid']; ?>
											<?php 
											
                                                $query = "SELECT * FROM `game_details` where round_id='$roundid'";
                                                $result = $conn->query($query);  
                                                
                                                $i=1; 
                                                if($result->num_rows > 0){ 
                                                while($row=$result->fetch_assoc()){ 
												 $user_id = $row['user_id'];
												  $group_id = $row['group_id'];
												   $round_id = $row['round_id'];
													$querywin = "SELECT * FROM `game_transactions` where round_no='$roundid' and player_name='$user_id'";
													//echo $querywin;
                                	                 $resultwin = $conn->query($querywin);  
											      	$rowwin=$resultwin->fetch_assoc();
											?>
											<tr>
											    </tr>
										     <tr>
												
											           
											            <td><? echo $row['user_id'];?></td>
											            <td><? echo $rowwin['status'];?></td>
											            <td>
											                <?php
                                                     $showhandcard=0;
                                                   //===================================Group 1====================================
                                                    
                                                            $group1 = $row['group1'];
                                                            if($group1 != ''){
                                                                
                                                            $group1array = explode(',', $group1);
                                                            $b=0;
                                                            foreach ($group1array as $item) {
                                                                $showhandcard=1;
                                                             $querygp1 = "SELECT card_path FROM `cards` where id='$item'";
                                            	             $resultgp1 = $conn->query($querygp1);
                                            	             $rowgp1=$resultgp1->fetch_assoc();
                                            	              if($b==0){
                                                                echo '<img src="../../../public/static/cards/'.$rowgp1['card_path'].'" style="width: 35px;margin-left: 25px;">';
                                            	              }else{
                                                	             echo '<img src="../../../public/static/cards/'.$rowgp1['card_path'].'" style="width: 35px; margin-left: -15px;">';
                                            	              }
                                            	               $b++;   
                                            	             }
                                                           
                                                                    }
											    
										            //===================================Group 2====================================
                                                    
											     
                                                        $group2 = $row['group2'];
                                                        if($group2 != ''){
                                                             
                                                        $group2array = explode(',', $group2);
                                                       $c=0;
                                                        foreach ($group2array as $item) {
                                                            $showhandcard=1;
                                                         $querygp2 = "SELECT card_path FROM `cards` where id='$item'";
                                        	             $resultgp2 = $conn->query($querygp2);
                                        	             $rowgp2=$resultgp2->fetch_assoc();
                                        	             if($c == 0){
                                                           echo '<img src="../../../public/static/cards/'.$rowgp2['card_path'].'" style="width: 35px;margin-left: 25px;">';
                                        	             }else{
                                        	                 echo '<img src="../../../public/static/cards/'.$rowgp2['card_path'].'" style="width: 35px;margin-left: -15px;">';
                                        	             }
                                                        $c++;
                                                        }
                                                     
                                                                }
											   //==================================Group 3====================================
                                                    
											     
                                                $group3 = $row['group3'];
                                                if($group3 != ''){
                                                    
                                                $group3array = explode(',', $group3);
                                               $d=0;
                                                foreach ($group3array as $item) {
                                                    $showhandcard=1;
                                                 $querygp3 = "SELECT card_path FROM `cards` where id='$item'";
                                	             $resultgp3 = $conn->query($querygp3);
                                	             $rowgp3=$resultgp3->fetch_assoc();
                                    	             if($d  == 0){
                                                       echo '<img src="../../../public/static/cards/'.$rowgp3['card_path'].'" style="width: 35px;margin-left: 25px;">';
                                    	             }else{
                                    	              echo '<img src="../../../public/static/cards/'.$rowgp3['card_path'].'" style="width: 35px;margin-left: -15px;">';
                                    	             }
                                    	             $d++;
                                                }
                                                }
											 //===================================Group4====================================
                                                    
                                                $group4 = $row['group4'];
                                                if($group4 != ''){
                                                    
                                                $group4array = explode(',', $group4);
                                               $e=0;
                                                foreach ($group4array as $item) {
                                                    $showhandcard=1;
                                                 $querygp4 = "SELECT card_path FROM `cards` where id='$item'";
                                	             $resultgp4 = $conn->query($querygp4);
                                	             $rowgp4=$resultgp4->fetch_assoc();
                                    	             if($e==0){
                                                        echo '<img src="../../../public/static/cards/'.$rowgp4['card_path'].'" style="width: 35px;margin-left: 25px;">';
                                    	             }else{
                                    	               echo '<img src="../../../public/static/cards/'.$rowgp4['card_path'].'" style="width: 35px;margin-left: -15px;">';
                                    	             }
                                    	             $e++;
                                                }
                                              
                                                        }
										 //===================================Group 5====================================
                                                    
											     
                                                $group5 = $row['group5'];
                                                if($group5 != ''){
                                                     
                                                $group5array = explode(',', $group5);
                                               $f=0;
                                                foreach ($group5array as $item) {
                                                    $showhandcard=1;
                                                 $querygp5 = "SELECT card_path FROM `cards` where id='$item'";
                                	             $resultgp5 = $conn->query($querygp5);
                                	             $rowgp5=$resultgp5->fetch_assoc();
                                	             if($f==0){
                                                   echo '<img src="../../../public/static/cards/'.$rowgp5['card_path'].'" style="width: 35px;margin-left: 25px;">';
                                	             }else{
                                	                  echo '<img src="../../../public/static/cards/'.$rowgp5['card_path'].'" style="width: 35px;margin-left: -15px;">';
                                	             }
                                                
                                	                 $f++;
                                	             }
                                               
                                                        }
										 //===================================Group6 ====================================
                                                    
											     
                                                $group6 = $row['group6'];
                                                if($group6 != ''){
                                                     
                                                $group6array = explode(',', $group6);
                                               $g=0;
                                                foreach ($group6array as $item) {
                                                    $showhandcard=1;
                                                 $querygp6 = "SELECT card_path FROM `cards` where id='$item'";
                                	             $resultgp6 = $conn->query($querygp6);
                                	             $rowgp6=$resultgp6->fetch_assoc();
                                	             if($g==0){
                                                   echo '<img src="../../../public/static/cards/'.$rowgp6['card_path'].'" style="width: 35px;margin-left: 25px;">';
                                	             }else{
                                	               echo '<img src="../../../public/static/cards/'.$rowgp6['card_path'].'" style="width: 35px;margin-left: -15px;">';
                                	             }
                                	             $g++;
                                                }
                                                
                                                        }
											 //===================================group 7====================================
                                                    
											     
                                                $group7 = $row['group7'];
                                                if($group7 != ''){
                                                     
                                                $group7array = explode(',', $group7);
                                               $h=0;
                                                foreach ($group7array as $item) {
                                                    $showhandcard=1;
                                                 $querygp7 = "SELECT card_path FROM `cards` where id='$item'";
                                	             $resultgp7 = $conn->query($querygp7);
                                	             $rowgp7=$resultgp7->fetch_assoc();
                                	             if($h==0){
                                                echo '<img src="../../../public/static/cards/'.$rowgp7['card_path'].'" style="width: 35px;margin-left: 25px;">';
                                	             }else{
                                	              echo '<img src="../../../public/static/cards/'.$rowgp7['card_path'].'" style="width: 35px;margin-left: -15px;">';
                                	           
                                	             }
                                	             $h++;
                                                }
                                               
                                                        }
                                                        
                                                        
                                                        
                                                 //===================================HAnd Card====================================
                                         if( $showhandcard == 0){
                                              $hand_cards = $row['hand_cards'];
                                              if($hand_cards != ''){
                                            
                                                    $hand_cardsarray = explode(',', $hand_cards);
                                                    $a=0;
                                                    foreach ($hand_cardsarray as $item) {
                                                        
                                                        $queryhand_card = "SELECT card_path FROM `cards` where id='$item'";
                                                        $resulthand_card = $conn->query($queryhand_card);
                                                        $rowhand_card=$resulthand_card->fetch_assoc();
                                                        if($a==0){
                                                        echo '<img src="../../../public/static/cards/'.$rowhand_card['card_path'].'" style="width: 35px;">';
                                                        }else{
                                                        echo '<img src="../../../public/static/cards/'.$rowhand_card['card_path'].'" style="width: 35px;margin-left: -15px;">';
                                                        }
                                                    $a++;
                                                    }
                                               
                                               }
                                         }
                                                    
											?>
											                
											 </td>
											           <td><? echo $rowwin['amount'];?></td>
											</tr>
											<?php 
											$i++; 
											  } 
											} 
											?>
											
												<?php 
											
                                                    $queryoc = "SELECT * FROM `game_details` where round_id='$roundid' order by id desc limit 1";
                                                    $resultoc = $conn->query($queryoc);  
                                                    
                                                    if($resultoc->num_rows > 0){ 
                                                            $rowoc=$resultoc->fetch_assoc(); 
                                                            $open_card = $rowoc['open_card'];
                                                            if($open_card != ''){
                                                                echo '<tr> <td>Open Card</td> <td colspan="3">';
                                                                $open_cardarray = explode(',', $open_card);
                                                                $k=0;
                                                                foreach ($open_cardarray as $item) {
                                                                    
                                                                    $queryopen_card = "SELECT card_path FROM `cards` where id='$item'";
                                                                    $resultopen_card = $conn->query($queryopen_card);
                                                                    $rowopen_card=$resultopen_card->fetch_assoc();
                                                                    if($k==0){
                                                                        echo '<img src="../../../public/static/cards/'.$rowopen_card['card_path'].'" style="width: 35px;">';
                                                                    }else{
                                                                         echo '<img src="../../../public/static/cards/'.$rowopen_card['card_path'].'" style="width: 35px;margin-left: -15px;">';
                                                                    }
                                                                  $k++;
                                                                }
                                                               echo '</td></tr>';
                                                           }
                                                    
                                                      }  
                                                      
                                                } ?>
                                                	<?php 
											
                                                    $queryoc = "SELECT joker FROM `game_details` where round_id='$roundid' order by id desc limit 1";
                                                    $resultoc = $conn->query($queryoc);  
                                                    
                                                      if($resultoc->num_rows > 0){ 
                                                            $rowoc=$resultoc->fetch_assoc(); 
                                                            $joker = $rowoc['joker'];
                                                            if($joker != ''){
                                                                echo '<tr> <td>Joker</td> <td colspan="3"><img src="../../../public/static/cards/'.$rowoc['joker'].'" style="width: 35px;"></td></tr>';
                                                           }
                                                    
                                                      }  
                                                ?>
										</tbody>
									</table>
									</div>
                                   
								</div>
							</div>
						</div>
						<!-- /.box -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->
		<footer class="main-footer">
			<div id="footer"></div>
		</footer>
		<!-- Control Sidebar -->
		<aside class="control-sidebar control-sidebar-dark" id="dashboard-settings"></aside>
		<div class="control-sidebar-bg"></div>
	</div>
	 <!-- ./wrapper -->
	<!-- jQuery 3 -->
	<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	<!-- SlimScroll -->
	<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<!-- FastClick -->
	
			<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
	<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
	<!-- AdminLTE App -->
	<script src="../../dist/js/adminlte.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="../../dist/js/demo.js"></script>
		<script src="../../js/jquery-ui.js"></script>  

	<script>
		$(function(){
		    $(".datepicker").datepicker({
					dateFormat:'dd-mm-yy'
				});
				$("#sidebar-menu").load("sidebar-menu.html"); 
				$("#header").load("header.html"); 
				$("#footer").load("footer.html"); 
				$("#dashboard-settings").load("dashboard-settings.html"); 
					$('#user_details').DataTable()
			});
	</script>
	
</body> 
</html>
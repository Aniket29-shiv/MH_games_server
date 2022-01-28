<?php
session_start();
 
 if(!isset($_SESSION['logged_user'])) 
{
header("Location:sign-in.php");
}
else
{
$loggeduser =  $_SESSION['logged_user'];
include 'database.php';

$sql = "SELECT u.*,acct.`play_chips`, acct.`real_chips` FROM users u left join accounts acct on u.user_id = acct.userid where u.username = '".$loggeduser."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc())
	{
		$play_chips = $row['play_chips'];
		$real_chips = $row['real_chips'];
	}
}
$sql_table= "SELECT * FROM `player_table` WHERE game = 'Cash Game' and `game_type` = 'Pool Rummy' and `table_status` = 'L' group by min_entry,player_capacity,pool order by min_entry ASC";
$result_table = $conn->query($sql_table);
$gamedomainlink='';
$getipconf = "SELECT * FROM `ip_conf`  where id = 1 ";
$resultipconf = $conn->query($getipconf);
$rowipconf = $resultipconf->fetch_assoc();
$gamedomainlink=$rowipconf['mlink'];
$conn->close();

?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link rel="shortcut icon" href="images/favicon.ico"/>
</head>
<body>
	<header>
		<div id="header"></div>
	</header>
	<main>
		<div class="container-fluid pa0 mt30">
			<div class="container account-cont-wrapper">
			     <span id="fail" style="display: none; color: red;text-align: center;">Table Not Found Please Select Other Values.</span>
		<div class="container-fluid mt35 pa0" style="margin-top: 0px;">
<p id="emptytablemsg" style="color: white; background: green; width: 50%; margin: auto; padding: 10px;display:none;">
			<div class="row black-ft mlr0" style="margin-top: 15px;">
				<div class="col-md-2 col-sm-3 col-xs-12">
					<h3 class="text-uppercase mt10" style="color:yellow;"><span>Quick Join : </span></h3>
				</div>
				<div class="col-md-8 col-sm-7 col-xs-12">
				     <span style="color: white; margin-top: 10px;">Players :</span>
				<div class="btn-group" role="group">
				   
                  <button type="button" class="btn " onclick="check_but(this.value);" style=" margin-top: 5px;color: #ffffff;
    background: -webkit-linear-gradient(#9b57f0, #4f2f77)" id="2_Players"name="2 Players" value="2" >2 </button>
                  <button type="button" class="btn " onclick="check_but(this.value);" value="6" style=" margin-top: 5px;color: #ffffff;
    background: -webkit-linear-gradient(#9b57f0, #4f2f77)" id="6_Players" name="6 Players">6 </button>
                 <input type="hidden"  name="btnval" id="btnval" value="2"/>
                </div>
                &nbsp;&nbsp;&nbsp;
               <div style="display: -webkit-inline-box;"> 
             <span style="color: white; margin-top: 10px;">Min Entry	:</span>
              <button class="btn" style=" margin-top: 5px;height: 34px;color: #fffff;
    background: -webkit-linear-gradient(#9b57f0, #4f2f77)" onclick="minus();">  	<i  class="glyphicon glyphicon-minus"  title="" style="color:#ffffff;"></i></button>
      	        </button><input type="text" style="width: 50px;text-align: -webkit-center;padding-bottom: 9px; margin-top: 5px;"name="points" style=" margin-top: 5px;"value="10" id="points" disabled />
                 <button class="btn " style=" margin-top: 5px;height: 34px;color: #000000;
    background: -webkit-linear-gradient(#9b57f0, #4f2f77)" onclick="plus();">	<i  class="glyphicon glyphicon-plus" title=""  style="color:#ffffff;"></i></button>
                </div> 
                 &nbsp;&nbsp;&nbsp;
                <div class="btn-group" role="group">
				   
                  <button type="button" class="btn " onclick="check_but2(this.value);" style=" margin-top: 5px;color: #ffffff;
    background: -webkit-linear-gradient(#9b57f0, #4f2f77)" id="101"name="101" value="101" >101 Pools</button>
                  <button type="button" class="btn " onclick="check_but2(this.value);" value="201" style=" margin-top: 5px;color: #ffffff;
    background: -webkit-linear-gradient(#9b57f0, #4f2f77)" id="201" name="201">201 Pools </button>
                 <input type="hidden"  name="btnval2" id="btnval2" value="101 Pools"/>
                </div>
                &nbsp;&nbsp;&nbsp;	
                  <input type="hidden" id="seltable" value="2">
                <input type="hidden" id="selpool" value="101">
                <a id="join" target="" onclick="join('<?php echo $loggeduser;?>')"><button  style=" margin-top: 5px;color: #ffffff;
    background: -webkit-linear-gradient(#9b57f0, #4f2f77)"class="btn ">Join</button></a>
				</div>
			
			</div>
	
	</div> 
				<div class="row point-rummy-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 game-type over-hid">
						<?php include 'takeseat.php';?></br>
						<div class="dropdown black-ft">
<select class="btn btn-default dropdown-toggle black-ft" id="game" style="color: white;">
<option value="">Game Type</option>
<option value="101 Pools">101 Pool</option>
<option value="201 Pools">201 Pool</option>
</select>
</div>
<input type="hidden" id="logid" value="<?php echo $loggeduser;?>">
<div class="dropdown black-ft">
<select class="btn btn-default dropdown-toggle black-ft" id="players" style="color: white;">
<option value="">Players</option>
<option value="2">2 Players</option>
<option value="6">6 Players</option>
</select>
</div>
<div class="dropdown black-ft">
<select class="btn btn-default dropdown-toggle black-ft" id="bet" style="color: white;">
<option value="">Bet Value</option>
<option value="low">Low (1-100)</option>
<option value="medium">Medium (101-1000)</option>
<option value="high">High (1001 and more)</option>
</select>
</div>
<div class="dropdown black-ft">


</div>
	<section>
						<div class="table-responsive horizontal">
							<table class="table table-bordered table-striped table-condensed">
								<thead>
									<tr>
										
										<th>Pool Type</th>
										<th>Min Entry</th>
										<th>Tabale Capacity</th>
										<th>Online Players</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="pointdata">
								<?php
									$pool='';
									if ($result_table->num_rows > 0) {
									    
									while($table = $result_table->fetch_assoc())
									{
									    
                                        if($table['pool']=='101 Pools')
                                        $pool='101';
                                        else if($table['pool']=='201 Pools')
                                        $pool='201';
										
										
										$tabl= $table['table_id'];
									    
									  
											
											
											$player_capacity= $table['player_capacity'];										  
											$min_entry= $table['min_entry'];	
											$game_type= $table['game_type'];	
											$game= $table['game'];	
											
											
											$sql1="select * from  user_tabel_join where `game_type` = 'Pool Rummy' and chip_type='real' and player_capacity='".$player_capacity."' AND min_entry='".$min_entry."'  ";
											// echo $sql1;
											$result_inn = $conn->query($sql1);
											$a = $result_inn->num_rows;
								
										
									?>
									<tr>										
										
										<td><?php echo $table['pool'];?></td>
										<td><?php echo $table['min_entry'];?></td>
										<td><?php echo $table['player_capacity'];?></td>
										<td><?php echo $a;?></td>
										<td>
											<?php if( $table['player_capacity'] == 2) { ?>
											<a id="two_pl_game" onclick="check_table('<?php echo $loggeduser;?>','<?php echo $player_capacity;?>','<?php echo $game_type;?>','<?php echo $game; ?>','<?php echo $min_entry;?>','<?php echo $pool;?>')"  target=""><button class="btn btn-primary">Join</button></a>
											<?php } ?>
											<?php if( $table['player_capacity'] == 6) { ?>
											<a id="six_pl_game" target="" onclick="check_table('<?php echo $loggeduser;?>','<?php echo $player_capacity;?>','<?php echo $game_type;?>','<?php echo $game; ?>','<?php echo $min_entry;?>','<?php echo $pool;?>')"><button class="btn btn-primary">Join</button></a>
											<?php } ?>
										</td>
									</tr>
								<?php  } } ?>
								</tbody>
							</table>
						</div>
						</section>
					<!--	<section>
						<div class="table-responsive horizontal">
							<table class="table table-bordered table-striped table-condensed">
								<thead>
									<tr>
										<th>Table Name</th>
										<th>Game Type</th>
										<th>Point Value</th>
										<th>Min Entry</th>
										<th>Status</th>
										<th>Players</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php
									/*$pool='';
									if ($result_table->num_rows > 0) {
									while($table = $result_table->fetch_assoc())
									{
									if($table['pool']=='101 Pools')
										$pool='101';
										else if($table['pool']=='101 Pools')
										$pool='201';
										
										
										  $tabl= $table['table_id'];
									    
									    $sql="select Count(*) as no_of from user_tabel_join where joined_table='$tabl' ";
									    
									    $result_inn = $conn->query($sql);
									    
									    if($result_inn->num_rows > 0){
									      	while($table_inn = $result_inn->fetch_assoc())
									    {  
									    $a=$table_inn['no_of'];
									      
									        
									     }
									        
									        
									    }else
									    
									    {
									        
									    }*/
								
										
									?>
									<tr>										
										<td><?php //echo $table['table_name'];?></td>
										<td><?php //echo $table['game_type'];?></td>
										<td><?php //echo $table['point_value'];?></td>
										<td><?php //echo $table['min_entry'];?></td>
										<td><?php //echo $table['status'];?></td>
										<td><?php //echo $a."/".$table['player_capacity'];?></td>
										<td>
											<?php //if( $table['player_capacity'] == 2) { ?>
											<a id="two_pl_game" onclick="check(<?php //echo $table['table_id'];?>,'<?php //echo $loggeduser;?>','<?php //echo $pool;?>')"  target=""><button class="btn btn-primary">Join</button></a>
											<?php //} ?>
											<?php //if( $table['player_capacity'] == 6) { ?>
											<a id="six_pl_game" target="" onclick="open_six_player_popup(<?php //echo $table['table_id'];?>,'<?php //echo $loggeduser;?>','<?php //echo $pool;?>')"><button class="btn btn-primary">Join</button></a>
											<?php //} ?>
										</td>
									</tr>
								<?php  //} } ?>
								</tbody>
							</table>
						</div>
						</section>-->
					</div>
				</div>
				<hr>
			</div>
			<input type="hidden" id="pointarray" name="pointarray[]" value="">
		</div>
	</main>
	<footer>
		<div id="footer"></div>
	</footer>
</body>


<script type="text/javascript"> 
//$(document).ready(
//{
	var popup_opened_once=false;
	var opened_table_id = 0;
	var six_pl_popup_opened_once=false;
	var six_pl_opened_table_id = 0;
	var check =function(table_id,player,pool) 
	{
		/** If same pop-up closed and opened again **/
		if(table_id ==opened_table_id)
		{ popup_opened_once = false; }
		
		if(popup_opened_once == false)
		{
			var w = window.open('<?php echo $gamedomainlink;?>/join_table?table_id='+table_id+'&user='+player+'','Two Player Rummy','width=900,height=600','_blank');
			popup_opened_once = true;
			opened_table_id = table_id;			
		}
		else if(popup_opened_once == true && table_id !=opened_table_id)
		{
			open_other_popup(table_id,player,pool); 
		}		
	}	
	var open_other_popup =function(table_id,player,pool) 
	{
			var ww = window.open('<?php echo $gamedomainlink;?>/join_table?table_id='+table_id+'&user='+player+'','Two Player Rummy Table_'+table_id,'width=900,height=600','_blank');
	}
	
	var open_six_player_popup=function(table_id,player,pool) 
	{
	
		/** If same pop-up closed and opened again **/
		if(table_id ==six_pl_opened_table_id)
		{ six_pl_popup_opened_once = false; }
		
		if(six_pl_popup_opened_once == false)
		{
			var w_six = window.open('<?php echo $gamedomainlink;?>/join_table?table_id='+table_id+'&user='+player+'','Six Player Rummy','width=1000,height=655','_blank');
			six_pl_popup_opened_once = true;
			six_pl_opened_table_id = table_id;
		}
		else if(six_pl_popup_opened_once == true && table_id !=six_pl_opened_table_id)
		{
			open_other_six_pl_popup(table_id,player,pool); 
		}
	}

	var open_other_six_pl_popup =function(table_id,player,pool) 
	{
			var ww_six = window.open('<?php echo $gamedomainlink;?>/join_table?table_id='+table_id+'&user='+player+'','Six Player Rummy Table_'+table_id,'width=1000,height=655','_blank');
	}
	
	//});
</script>


	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
<script type="text/javascript">
		
	 //var arr=["10", "25", "50","100","200","300","500","1000"];
function check_but(a){
    var a;
   $("#seltable").val(a);
     var pointval=a;
    if(a==2){
    
    $("#btnval").val(a);
    a="#2_Players";
    var b="#6_Players";
    $("#2_Players").css('background', '#A9A9A9'); 
    $("#6_Players").css('background', '#D3D3D3'); 
    }
    else{
    
    $("#btnval").val(a); 
    var a="#6_Players";
    var b="#2_Players";
    $("#6_Players").css('background', '#A9A9A9'); 
    $("#2_Players").css('background', '#D3D3D3'); 
    }
   
    var pool=$("#selpool").val();;
         var dataString ='getpoolvalue='+pointval+'&poolvalue='+pool;
   
        $.ajax({
        
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                  $('#pointarray').val('');
                  $('#pointarray').val(data);
                  
                    var arr1=$("#pointarray").val();
                    var arr = arr1.split(',');
                    var points= $("#points").val(); 
                    
                    var len=arr.length;
                    a = arr.indexOf(points)
                    
                    if(a!=len-1){
                    
                    var valu= arr[a+1];
                    $("#points").val(valu); 
                   
                    
                    }
                
                }
        });
  
   
    
}
function check_but2(a){
    var a;
     $("#selpool").val(a);
     var pool=a;
        if(a==101){
        
        $("#btnval2").val(a);
        a="#101";
        var b="#201";
        $("#101").css('background', '#A9A9A9'); 
        $("#201").css('background', '#D3D3D3'); 
        }
        else{
        
        $("#btnval2").val(a); 
        var a="#201";
        var b="#101";
        
        $("#201").css('background', '#A9A9A9'); 
        $("#101").css('background', '#D3D3D3'); 
        }
   
   var pointval=$("#seltable").val();;
         var dataString ='getpoolvalue='+pointval+'&poolvalue='+pool;
   
        $.ajax({
        
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                  $('#pointarray').val('');
                  $('#pointarray').val(data);
                  
                    var arr1=$("#pointarray").val();
                    var arr = arr1.split(',');
                    var points= $("#points").val(); 
                    
                    var len=arr.length;
                    a = arr.indexOf(points)
                    
                    if(a!=len-1){
                    
                    var valu= arr[a+1];
                    $("#points").val(valu); 
                   
                    
                    }
                
                }
        });
   
    
}

/*function plus(){
   
  var points= $("#points").val(); 
   //  alert("plus"+points);
     

  var len=arr.length;
     a = arr.indexOf(points)
   
     if(a!=len-1){
       
        
       var valu= arr[a+1];
      $("#points").val(valu); 
//  alert(valu); 
   }
}
function minus(){
  
    var points= $("#points").val(); 
     
  
   var len=arr.length;
   a = arr.indexOf(points)
   if(a!=0){
       
         var valu=  arr[a-1];
       $("#points").val(valu); 
     //  alert(valu);
   }
   
}*/

function plus(){
   var arr1=$("#pointarray").val();
   var arr = arr1.split(',');
        
  var points= $("#points").val(); 
   //  alert("plus"+points);
     

  var len=arr.length;
     a = arr.indexOf(points)
   
     if(a!=len-1){
       
        
       var valu= arr[a+1];
      $("#points").val(valu); 
//  alert(valu); 
   }
}
function minus(){
  var arr1=$("#pointarray").val();
   var arr = arr1.split(',');
      
    var points= $("#points").val(); 
     
  
   var len=arr.length;
   a = arr.indexOf(points)
   if(a!=0){
       
         var valu=  arr[a-1];
       $("#points").val(valu); 
     //  alert(valu);
   }
   
}
function jointableneww(){
 
  var tabid=$('#tabjoin').attr('data-tid');
  var usernewid=$('#tabjoin').attr('data-uid');
  var capid=$('#tabjoin').attr('data-capid');
  $("#emptytablemsg").html('');
    $("#emptytablemsg").hide(); 
    if(capid==2){
    
    check(tabid,usernewid);
    
    }else{
    
    open_six_player_popup(tabid,usernewid);
    
    }        

}

function jointablenewclose(){
 
  $("#emptytablemsg").html('');
    $("#emptytablemsg").hide(); 

}



function join(user){
       var pool = $("#btnval2").val(); 
        var username=user;
        var points= $("#points").val();
        var no_of_player= $("#btnval").val(); 
        var game="Cash Game";
        var game_type="Pool Rummy"
 //alert(no_of_player+"===="+pool+"=="+game+"=="+game_type+"=="+points);
			$.post("search_pool_player_table.php",
			{
				no_of_player:no_of_player,
				game:game,
				game_type:game_type,
				points:points,
				pool:pool,
			},
	function(data){
			  var data1 = JSON.parse(data);
			  
			 // alert(data1+"====="+data);
		  if(data1.table_details.length!=0){
		for (var i = 0; i < data1.table_details.length; i++) {
        var counter = data1.table_details[i];
        var  table_id = counter.table_id;
        var  player_capacity  =counter.player_capacity;
          
//alert(table_id+"=="+player_capacity+"=="+user);
    console.log(counter.table_id);
    
     if(data1.joined == 'join'){   
                            if(player_capacity==2){
                            
                            check(table_id,username);
                            }else{
                            
                            open_six_player_popup(table_id,username);
                            }
                                  
                         }else{

var htmldata=' running table is not available, do you want to seat on new table? <a style="margin: 5px;" onclick="jointableneww();" data-tid="'+table_id+'" data-uid="'+username+'" data-capid="'+player_capacity+'"  class="btn btn-primary" id="tabjoin">Yes</a><a onclick="jointablenewclose();" class="btn btn-danger" id="tabjoincancel">No</a>';
                          $("#emptytablemsg").html(htmldata);
                            $("#emptytablemsg").show();
                         }
   /* if(player_capacity==2){
        
        check(table_id,username);
    }else{
        
        open_six_player_popup(table_id,username);
    }*/
    
  
    
}
		}else{
		 	 $('#fail').fadeIn().delay(5000).fadeOut();
		}	});
		
			    
			    
		

}


function check_table(user,player_capacity,game_type,game,min_entry,pool){
       // var pool = $("#btnval2").val(); 
        var username=user;
      /*   var points= $("#points").val();
        var no_of_player= $("#btnval").val(); 
        var game="Free Game";
        var game_type="Pool Rummy" */
 //alert(no_of_player+"===="+pool+"=="+game+"=="+game_type+"=="+points);
			$.post("search_pool_player_table.php",
			{
				no_of_player:player_capacity,
				game:game,
				game_type:game_type,
				points:min_entry,
				pool:pool,
			},
	function(data){
			  var data1 = JSON.parse(data);
			  
			//  alert(data1+"====="+data);
		  if(data1.table_details.length!=0){
		for (var i = 0; i < data1.table_details.length; i++) {
        var counter = data1.table_details[i];
        var  table_id = counter.table_id;
        var  player_capacity  =counter.player_capacity;
          
//alert(table_id+"=="+player_capacity+"=="+user);
    console.log(counter.table_id);
     if(data1.joined == 'join'){   
                            if(player_capacity==2){
                            
								check(table_id,username);
                            }else{
                            
                            open_six_player_popup(table_id,username);
                            }
                                  
                         }else{


							jointable(table_id,username,player_capacity);
						
							/* var htmldata=' running table is not available, do you want to seat on new table? <a style="margin: 5px;" onclick="jointableneww();" data-tid="'+table_id+'" data-uid="'+username+'" data-capid="'+player_capacity+'"  class="btn btn-primary" id="tabjoin">Yes</a><a onclick="jointablenewclose();" class="btn btn-danger" id="tabjoincancel">No</a>';
                          $("#emptytablemsg").html(htmldata);
                            $("#emptytablemsg").show(); */
                         }
    
  
    
}
		}else{
			
		  // $('#fail').fadeIn().delay(5000).fadeOut();
		}	
		
		
		});
		
			    
			    
		

}


function jointable(table_id,username,player_capacity){
  
    if(player_capacity==2){
    
    check(table_id,username);
    
    } else {
    
    open_six_player_popup(table_id,username);
    
    }        

}

	
	$(document).ready(function() {
    
    /// Wait till page is loaded
    setInterval(timingLoad, 5000);
    function timingLoad() {
        
     //$('section').load('pool-lobby-rummy.php section', function() { });
                    var players = $("#players").val();
                    var game = $("#game").val();
                    var bet = $("#bet").val();
                    //var hide = $("#hide").val();
                    var logid = $("#logid").val();
                    var dataString ='poolplayers='+players+'&game='+game+'&bet='+bet+'&logid='+logid;
                   // alert(dataString);
                    $.ajax({
                    
                    type: "POST",
                    url:"ajax_function.php",
                    data: dataString,
                    cache: false,
                    success: function(data){
                    // alert(data);	
                    	$('#pointdata').html('');
                    $('#pointdata').html(data);
                    
                    }
                    });
    }
    
});

	</script>


	</script>
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		});
		
	
	</script>
	<script>
$(function(){
		
     	$("#players").change(function(){
	     	var players = $("#players").val();
	     	var game = $("#game").val();
	     	var bet = $("#bet").val();
	     	//var hide = $("#hide").val();
		   var logid = $("#logid").val();
	       var dataString ='poolplayers='+players+'&game='+game+'&bet='+bet+'&logid='+logid;
              //  alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                		
                $('#pointdata').html(data);
                
                }
                });

		
		
		});
		
		
		$("#game").change(function(){
	     	var players = $("#players").val();
	     	var game = $("#game").val();
	     	var bet = $("#bet").val();
	     	//var hide = $("#hide").val();
		   var logid = $("#logid").val();
	       var dataString ='poolplayers='+players+'&game='+game+'&bet='+bet+'&&logid='+logid;
	      // alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                
                	$('#pointdata').html('');
                $('#pointdata').html(data);
                
                }
                });

		
		
		});
		
		$("#bet").change(function(){
		    
                var players = $("#players").val();
                var game = $("#game").val();
                var bet = $("#bet").val();
                //var hide = $("#hide").val();
                var logid = $("#logid").val();
                var dataString ='poolplayers='+players+'&game='+game+'&bet='+bet+'&logid='+logid;
              //  alert(dataString);
                $.ajax({
                
                type: "POST",
                url:"ajax_function.php",
                data: dataString,
                cache: false,
                success: function(data){
                	
                	$('#pointdata').html('');
                $('#pointdata').html(data);
                
                }
                });

		
		
		});
		
		
		
	
});
	</script>
</html>
<?php } ?>
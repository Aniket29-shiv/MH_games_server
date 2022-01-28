<?php
session_start();
 if(!isset($_SESSION['logged_user']))
{
header("Location:sign-in.php");
}
else {
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
/* else {
header("Location:point-lobby-rummy.php");
} */
//$sql_table= "SELECT * FROM `player_table`  where game = 'Cash Game' ";
$sql_table= "SELECT * FROM `player_table` WHERE game = 'Cash Game' and `game_type` = 'papplu Rummy' and `table_status` = 'L' group by min_entry,player_capacity order by min_entry ASC";
$result_table = $conn->query($sql_table);

$gamedomainlink='';
$getipconf = "SELECT * FROM `ip_conf_papplu`  where id = 1 ";
$resultipconf = $conn->query($getipconf);
$rowipconf = $resultipconf->fetch_assoc();
$gamedomainlink=$rowipconf['mlink'];



?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
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
			    <span id="fail" style="display: none; color: white;text-align: center;">Table Not Found Please Select Other Values.</span>
			<div class="container-fluid mt35 pa0" style="margin-top: 0px;">
<p id="emptytablemsg" style="color: white; background: green; width: 50%; margin: auto; padding: 10px;display:none;">
			<div class="row black-bg mlr0" style="background: black; margin-top: 15px;">
				<div class="col-md-2 col-sm-3 col-xs-12">
					<h3 class="text-uppercase mt10" style="color:yellow;"><span>Quick Join : </span></h3>
				</div>
				<div class="col-md-8 col-sm-7 col-xs-12">
				     <span style="color: white; margin-top: 10px;">Players :</span>
				<div class="btn-group" role="group">

                  <button type="button" class="btn " onclick="check_but(this.value);" style=" margin-top: 5px;color: #000000;
    background:#A9A9A9" id="2_Players"name="2 Players" value="2" >2 </button>
                  <button type="button" class="btn " onclick="check_but(this.value);" value="6" style=" margin-top: 5px;color: #000000;
    background: #D3D3D3" id="6_Players" name="6 Players">6 </button>
                 <input type="hidden"  name="btnval" id="btnval" value="2"/>
                </div>
                &nbsp;&nbsp;&nbsp;
               <div style="display: -webkit-inline-box;">
    <span style="color: white; margin-top: 10px;">Min Entry	 :</span>
              <button class="btn " style=" margin-top: 5px;height: 34px;color: #000000;
    background: #D3D3D3" onclick="minus();">  	<i  class="glyphicon glyphicon-minus"   title="" style="color:#000000;"></i></button>
      	        </button><input type="text" style="width: 50px;text-align: -webkit-center;padding-bottom: 9px; margin-top: 5px;"name="points" style=" margin-top: 5px;"value="" id="points" disabled />
                 <button class="btn " style=" margin-top: 5px;height: 34px;color: #000000;
    background: #D3D3D3" onclick="plus();">	<i  class="glyphicon glyphicon-plus" title=""  style="color:#000000;"></i></button>
                </div>
                 &nbsp;&nbsp;&nbsp;
                <div class="btn-group" role="group">


                 <input type="hidden"  name="btnval2" id="btnval2" value="1 Deal "/>
                </div>
                &nbsp;&nbsp;&nbsp;	<a id="join" target="" onclick="join('<?php echo $loggeduser;?>')"><button  style=" margin-top: 5px;color: #000000;
    background: #D3D3D3"class="btn ">Join</button></a>
				</div>

			</div>

	</div>
				<div class="row point-rummy-wrapper mt20">
					<?php include 'leftbar.php'; ?>
						<div class="col-md-9 game-type over-hid">
					    <?php include 'takeseat.php';?>

					    <div class="dropdown">

					     <select class="btn btn-default dropdown-toggle" id="players">
					         <option value="">Players</option>
					         <option value="2">2 Players</option>
					         <option value="6">6 Players</option>
					         </select>
						</div>
					    <input type="hidden" id="logid" value="<?php echo $loggeduser;?>">
					    <div class="dropdown">

					     <select class="btn btn-default dropdown-toggle" id="min">
					         <option value="">Min Entry</option>
					         <option value="4">4</option>
					         <option value="10">10</option>
					         <option value="20">20</option>
					         <option value="50">50</option>
					         <option value="100">100</option>
					         <option value="200">200</option>
					         <option value="500">500</option>
					         <option value="1000">1000</option>
					         <option value="2000">2000</option>
					         <option value="3000">3000</option>
					          <option value="5000">5000</option>
					         </select>
						</div>


						 <div class="dropdown">

					     <select class="btn btn-default dropdown-toggle" id="max">
					         <option value="">Max Entry</option>
					        <option value="4">4</option>
					         <option value="10">10</option>
					         <option value="20">20</option>
					         <option value="50">50</option>
					         <option value="100">100</option>
					         <option value="200">200</option>
					         <option value="500">500</option>
					         <option value="1000">1000</option>
					         <option value="2000">2000</option>
					         <option value="3000">3000</option>
					          <option value="5000">5000</option>
					         </select>
						</div>


						

						<section>
						<div class="table-responsive horizontal">
							<table class="table table-bordered table-striped table-condensed">
								<thead>
									<tr>
									
										<th>Game Type</th>

										<th>Min Entry</th>
										<th>Table Capacity</th>
										<th>Online Players</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody id="pointdata">
								<?php
									if ($result_table->num_rows > 0) {
									while($table = $result_table->fetch_assoc())
									{
									    $tabl= $table['table_id'];

									     $player_capacity= $table['player_capacity'];										  
											$min_entry= $table['min_entry'];	
											$game_type= $table['game_type'];	
											$game= $table['game'];	
											$point_value= $table['point_value'];
									    
											$sql1="select * from  user_tabel_join where `game_type` = 'Papplu Rummy' and chip_type='real' and player_capacity=".$player_capacity." AND min_entry=".$min_entry."  ";											
											$result_inn = $conn->query($sql1);
											$a = $result_inn->num_rows;	
									?>
									<tr>
									
										<td><?php echo $table['game_type'];?></td>

										<td><?php echo $table['min_entry'];?></td>
										<td><?php echo $table['player_capacity'];?></td>
										<td id="pl_cap"><?php echo  $a;?></td>

										     	<td>
											<?php if ( $table['player_capacity'] == 2 ){ ?>

											<a id="two_pl_game" onclick="check_table('<?php echo $loggeduser;?>','<?php echo $player_capacity;?>','<?php echo $min_entry;?>','<?php echo $game_type;?>','<?php echo $game;?>')"  target="">
											<button   class="btn btn-primary">Join</button></a>

											<?php } else if( $table['player_capacity'] == 6) { ?>

                                                <a id="six_pl_game" target="" onclick="check_table('<?php echo $loggeduser;?>','<?php echo $player_capacity;?>','<?php echo $min_entry;?>','<?php echo $game_type;?>','<?php echo $game;?>')" >
                                                <button class="btn btn-primary">Join</button></a>

											<?php } ?>
										</td>
									</tr>
								<?php  } } ?>
								</tbody>
							</table>
						</div></section>
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

	var check =function(table_id,player)
	{
		//alert(table_id+"--"+player);
		/** If same pop-up closed and opened again **/
		if(table_id ==opened_table_id)
		{ popup_opened_once = false; }

		if(popup_opened_once == false)
		{
		//alert("first open");
			var w = window.open('<?php echo $gamedomainlink;?>/join_table?table_id='+table_id+'&user='+player+'','Two Player Rummy','width=900,height=600','_blank');
			popup_opened_once = true;
			opened_table_id = table_id;
		}
		else if(popup_opened_once == true && table_id !=opened_table_id)
		//else if( table_id !=opened_table_id)
		{
			open_other_popup(table_id,player);
		}
	}

	var open_other_popup =function(table_id,player)
	{
		//alert("another popup");
			var ww = window.open('<?php echo $gamedomainlink;?>/join_table?table_id='+table_id+'&user='+player+'','Two Player Rummy Table_'+table_id,'width=900,height=600','_blank');
	}

	var open_six_player_popup=function(table_id,player)
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
			open_other_six_pl_popup(table_id,player);
		}
	}

	var open_other_six_pl_popup =function(table_id,player)
	{
			var ww_six = window.open('<?php echo $gamedomainlink;?>/join_table?table_id='+table_id+'&user='+player+'','Six Player Rummy Table_'+table_id,'width=1000,height=655','_blank');
	}


	//});
</script>

	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
		$(function(){
		  $("#header").load("header.php");
		  $("#footer").load("footer.php");

			});
	</script>


			<script type="text/javascript">

			// var arr=["10", "25", "50","80","100","200","300","500","1000"];
function check_but(a){
            var a;
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


             var dataString ='getpappluvalue='+pointval;

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
   // alert(a);
    if(a=="1 Deal"){

         $("#btnval2").val(a);
    a="#Deal1";
    var b="#Deal2";
         //alert();
             $("#Deal1").css('background', '#A9A9A9');
             $("#Deal2").css('background', '#D3D3D3');
    }
    else{

           $("#btnval2").val(a);
  var a="#Deal2";
   var b="#Deal1";

 $("#Deal2").css('background', '#A9A9A9');
  $("#Deal1").css('background', '#D3D3D3');
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


function plus(){
   var arr1=$("#pointarray").val();
   var arr = arr1.split(',');
        var points= $("#points").val();

        var len=arr.length;
        a = arr.indexOf(points)
         //alert("plus"+a);
        if(a!=len-1){

            var valu= arr[a+1];
            $("#points").val(valu);
          //alert(valu);

        }
}

function minus(){
   var arr1=$("#pointarray").val();
   var arr = arr1.split(',');
    var points= $("#points").val();



   a = arr.indexOf(points)
   if(a!=0){

         var valu=  arr[a-1];
       $("#points").val(valu);
     //  alert(valu);
   }

}



function join(user){
       var pool = $("#btnval2").val();
        var username=user;
        var points= $("#points").val();
        var no_of_player= $("#btnval").val();
        var game="Cash Game";
        var game_type="papplu Rummy"

			$.post("search_papplu_player_table.php",
			{
				no_of_player:no_of_player,
				game:game,
				game_type:game_type,
				points:points,
				pool:pool,
			},
	function(data){
			  var data1 = JSON.parse(data);

   if(data1.table_details.length!=0){
		for (var i = 0; i < data1.table_details.length; i++) {
        var counter = data1.table_details[i];
        var  table_id = counter.table_id;
        var  player_capacity  =counter.player_capacity;

    //alert(table_id+"=="+player_capacity+"=="+user);
    console.log(counter.table_id);

    if(data1.joined == 'join'){

                           $("#emptytablemsg").hide();

                            if(player_capacity==2){

                                check(table_id,user);

                            }else{

                                open_six_player_popup(table_id,user);

                            }

                        }else{

                        var htmldata=' running table is not available, do you want to seat on new table? <a style="margin: 5px;" onclick="jointableneww();" data-tid="'+table_id+'" data-uid="'+username+'" data-capid="'+player_capacity+'"  class="btn btn-primary" id="tabjoin">Yes</a><a onclick="jointablenewclose();" class="btn btn-danger" id="tabjoincancel">No</a>';
                        $("#emptytablemsg").html(htmldata);
                        $("#emptytablemsg").show();

                        }



}
		}else{
		$('#fail').fadeIn().delay(5000).fadeOut();
		}	});





}


function check_table(user,player_capacity,min_entry,game_type,game){
    
   
		var username=user;
    	// var email = $("#email").val();
		// var user = $("#user").val();
		$.post("search_papplu_player_table.php",
		{
			no_of_player:player_capacity,
			game:game,
			game_type:game_type,
			points:min_entry,
		},
			
		function(data){
			
			var data1 = JSON.parse(data);
			if(data1.table_details.length!=0)
			{
				for (var i = 0; i < data1.table_details.length; i++) 
				{
					var counter = data1.table_details[i];
					var  table_id = counter.table_id;
					var  player_capacity  =counter.player_capacity;
						  
					//alert(table_id+"=="+player_capacity+"=="+user); emptytablemsg
					console.log(counter.table_id);
					if(data1.joined == 'join'){
						
						// $("#emptytablemsg_"+srNo).hide();
							if(player_capacity==2){
							
							  check(table_id,user);
							
							}else{
							
							 open_six_player_popup(table_id,user);
							 
							}
							
					} else {
						
						
						jointable(table_id,username,player_capacity);
					 }	
				}
						
			} else {
				
					 // $('#fail_'+srNo).fadeIn().delay(5000).fadeOut();
			}	
				
		});
	}
	
	
	
	function jointable(table_id,user,player_capacity){
		
		if(player_capacity==2){
    
			check(table_id,user);
    
		}else{
		
			open_six_player_popup(table_id,user);
		
		}        
  
	}





		$(document).ready(function() {

		/// Wait till page is loaded
        setInterval(timingLoad, 5000);
        function timingLoad() {

    var players = $("#players").val();
    var min = $("#min").val();
    var max = $("#max").val();
    var hide = $("#hide").val();

     var logid = $("#logid").val();

     var dataString ='pappluplayers='+players+'&min='+min+'&max='+max+'&hide='+hide+'&logid='+logid;

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



//$('section').load('deal_lobby_rummy.php section', function() {
/// can add another function here
//});
}
});

	</script>
			<script>
$(function(){

     	$("#players").change(function(){
	     	var players = $("#players").val();
	     	var min = $("#min").val();
	     	var max = $("#max").val();
	     	var hide = $("#hide").val();


             	var logid = $("#logid").val();

		      var dataString ='pappluplayers='+players+'&min='+min+'&max='+max+'&hide='+hide+'&logid='+logid;
               // alert(dataString);
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


		$("#min").change(function(){
	     	var players = $("#players").val();
	     	var min = $("#min").val();
	     	var max = $("#max").val();
	     	var hide = $("#hide").val();

             	var logid = $("#logid").val();

		      var dataString ='pappluplayers='+players+'&min='+min+'&max='+max+'&hide='+hide+'&logid='+logid;

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

		$("#max").change(function(){
	     var players = $("#players").val();
	     	var min = $("#min").val();
	     	var max = $("#max").val();
	     	var hide = $("#hide").val();
	     		var logid = $("#logid").val();

		      var dataString ='pappluplayers='+players+'&min='+min+'&max='+max+'&hide='+hide+'&logid='+logid;
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


			$("#hide").change(function(){
	       var players = $("#players").val();
	     	var min = $("#min").val();
	     	var max = $("#max").val();
	     	var hide = $("#hide").val();
		    	var logid = $("#logid").val();

		      var dataString ='pappluplayers='+players+'&min='+min+'&max='+max+'&hide='+hide+'&logid='+logid;
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

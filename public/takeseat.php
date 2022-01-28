<?php

 if(!isset($_SESSION['logged_user'])) 
{
header("Location:sign-in.php");
}
else {
$loggeduser =  $_SESSION['logged_user'];
include 'database.php';

//Take a seat
$sql_join= "SELECT * FROM `user_tabel_join` WHERE user_id = ".$_SESSION['user_id'] ;
$result_join = $conn->query($sql_join);

?>
<div class="table-responsive black-ft">
	<table class="table table-bordered">
			<thead>
				<tr style="color:white;">
					<th>Joined Table</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
				if ($result_join->num_rows > 0) {
				while($table = $result_join->fetch_assoc())
				{ 
					$hide = ''; 
					if($table['round_id']==0)
					{						  
						 $hide = 'style="display: none;"';
					}
					else
						$hide = 'style="color: white;"';
				?>
					
				
				<tr  <?php echo $hide;?> >
					<td  id="tbl_id"><?php echo $table['joined_table'];?></td>										
					<td>
						<?php if( $table['player_capacity'] == 2) { ?>
						<a id="two_pl_game" onclick="check(<?php echo $table['joined_table'];?>,'<?php echo $loggeduser;?>')"  target=""><button style="width:50%;" class="btn btn-primary">Take Your Seat</button></a>
						<?php } ?>
						<?php if( $table['player_capacity'] == 6) { ?>
						<a id="six_pl_game" target="" onclick="open_six_player_popup(<?php echo $table['joined_table'];?>,'<?php echo $loggeduser;?>')"><button class="btn btn-primary">Take Your Seat</button></a>
						<?php } ?>
					</td>
				</tr>
			<?php   } } ?>
			</tbody>
	</table>
</div>
<?php } ?>
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
		$first_name = $row['first_name'];
		$middle_name = $row['middle_name'];
		$last_name = $row['last_name'];
		$email = $row['email'];
		$gender = $row['gender'];
		$date_of_birth = $row['date_of_birth'];
		//echo $date_of_birth;
		if((strlen($date_of_birth)) >0)
		{
		$dob = explode('-',$date_of_birth);
		}
		else  $dob = null;
		$mobile_no = $row['mobile_no'];
		$pan_card_no = $row['pan_card_no'];
		$address = $row['address'];
		$addr = explode(',',$address);
		//print_r($addr);
		$state = $row['state'];
		$city = $row['city'];
		$pincode = $row['pincode'];
		
		
	}

}
else {
echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
header("Location:index.php");
}
$conn->close();

?>
</DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
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
				<!--	<div class="row user-name pb20">
					<div class="col-md-12">
						<div class="col-md-6 col-sm-5 black-bg">
							<h5 class="color-white">Welcome</h5>
							<h4><b><?php echo $loggeduser; ?></b></h4>
						</div>
						<div class="col-md-6 col-sm-7 black-bg">
							<h5 class="color-white">Free Money :</h5>
							<h4><b><?php
							if($play_chips!='') echo $play_chips; else echo 0;
							?>
							</b></h4>
							<h5 class="color-white">Real Money :</h5>
							<h4><b><?php
							if($real_chips!='') echo $real_chips; else echo 0;
							?></b></h4>
							<a href="buy-chips.php"><button>Add Money</button></a>
						</div>
					</div>
				</div>-->
				
				<hr>
				<div class="row profile-wrapper mt20">
					<?php include 'leftbar.php'; ?>
					<div class="col-md-9 col-sm-8">
						<div class="row">
							<h3 class="color-white text-center mt20"><b>Profile</b></h3>
							<div class="col-md-7">
								<div class="bg-grey">
									<h5 class="text-center mb0"><b>Personal Details</b></h5>
									<span id="update_success_personal" style="display: none; color: green;text-align: center;">Your  profile has been updated successfully.</span>
									<span id="update_failure_personal" style="display: none; color: red;text-align: center;">Something went wrong,profile not updated.</span>
									<hr class="mt0">
									<div>
										<form id="form_personal_details" action="update_personal_details.php" method="post">
											<h6><b>Note:</b><i> First name and Last name should be same as it appears on your bank account.</i></h6>
											<label>User Name</label>:
											<label><?php echo $loggeduser; ?></label>
											<label>First Name</label>:
											<input type="text" name="fname" id="fname" placeholder="First Name" value="<?php
												if($first_name!='') echo $first_name;?>" <?php if($first_name!='') { ?> disabled <?php } ?> autocomplete="off" >
											<label>Middle Name</label>:
											<input type="text" name="mname" id="mname" placeholder="Middle Name" value="<?php
												if($middle_name!='') echo $middle_name; ?>"  <?php if($middle_name!='') { ?> disabled <?php } ?>  autocomplete="off" >
											<label>Last Name</label>:
											<input type="text" name="lname" id="lname" placeholder="Last Name" value="<?php
												if($last_name!='') echo $last_name; ?>" <?php if($last_name!='') { ?> disabled <?php } ?>  autocomplete="off" >
											<label>Email ID</label>:
											<input type="email" name="email" id="email" placeholder="Email ID" <?php if($email!='') { ?> disabled <?php } ?>  value="<?php
												if($email!='') echo $email; ?>"  autocomplete="off" required>
											<label>Gender</label>:
											<select name="gender" id="gender">
												<option value="">Select</option>
												<option value="Male" <?php if($gender!='' && $gender=='Male'){?> selected = "true" <?php } ?> >Male</option>
												<option value="Female" <?php if($gender!='' && $gender=='Female'){?> selected = "true" <?php } ?> >Female</option>
											</select><br>
											<label>DOB</label>:
											<select name="dob_day" id="dob_day">
												<option value="">Select</option>
												<option value="01" <?php if($dob!='' && $dob[2]=='01'){?> selected = "true" <?php } ?>>01</option>
												<option value="02" <?php if($dob!='' && $dob[2]=='02'){?> selected = "true" <?php } ?>>02</option>
												<option value="03" <?php if($dob!='' && $dob[2]=='03'){?> selected = "true" <?php } ?>>03</option>
												<option value="04" <?php if($dob!='' && $dob[2]=='04'){?> selected = "true" <?php } ?>>04</option>
												<option value="05" <?php if($dob!='' && $dob[2]=='05'){?> selected = "true" <?php } ?>>05</option>
												<option value="06" <?php if($dob!='' && $dob[2]=='06'){?> selected = "true" <?php } ?>>06</option>
												<option value="07" <?php if($dob!='' && $dob[2]=='07'){?> selected = "true" <?php } ?>>07</option>
												<option value="08" <?php if($dob!='' && $dob[2]=='08'){?> selected = "true" <?php } ?>>08</option>
												<option value="09" <?php if($dob!='' && $dob[2]=='09'){?> selected = "true" <?php } ?>>09</option>
												<option value="10" <?php if($dob!='' && $dob[2]=='10'){?> selected = "true" <?php } ?>>10</option>
												<option value="11" <?php if($dob!='' && $dob[2]=='11'){?> selected = "true" <?php } ?>>11</option>
												<option value="12" <?php if($dob!='' && $dob[2]=='12'){?> selected = "true" <?php } ?>>12</option>
												<option value="13" <?php if($dob!='' && $dob[2]=='13'){?> selected = "true" <?php } ?>>13</option>
												<option value="14" <?php if($dob!='' && $dob[2]=='14'){?> selected = "true" <?php } ?>>14</option>
												<option value="15" <?php if($dob!='' && $dob[2]=='15'){?> selected = "true" <?php } ?>>15</option>
												<option value="16" <?php if($dob!='' && $dob[2]=='16'){?> selected = "true" <?php } ?>>16</option>
												<option value="17" <?php if($dob!='' && $dob[2]=='17'){?> selected = "true" <?php } ?>>17</option>
												<option value="18" <?php if($dob!='' && $dob[2]=='18'){?> selected = "true" <?php } ?>>18</option>
												<option value="19" <?php if($dob!='' && $dob[2]=='19'){?> selected = "true" <?php } ?>>19</option>
												<option value="20" <?php if($dob!='' && $dob[2]=='20'){?> selected = "true" <?php } ?>>20</option>
												<option value="21" <?php if($dob!='' && $dob[2]=='21'){?> selected = "true" <?php } ?>>21</option>
												<option value="22" <?php if($dob!='' && $dob[2]=='22'){?> selected = "true" <?php } ?>>22</option>
												<option value="23" <?php if($dob!='' && $dob[2]=='23'){?> selected = "true" <?php } ?>>23</option>
												<option value="24" <?php if($dob!='' && $dob[2]=='24'){?> selected = "true" <?php } ?>>24</option>
												<option value="25" <?php if($dob!='' && $dob[2]=='25'){?> selected = "true" <?php } ?>>25</option>
												<option value="26" <?php if($dob!='' && $dob[2]=='26'){?> selected = "true" <?php } ?>>26</option>
												<option value="27" <?php if($dob!='' && $dob[2]=='27'){?> selected = "true" <?php } ?>>27</option>
												<option value="28" <?php if($dob!='' && $dob[2]=='28'){?> selected = "true" <?php } ?>>28</option>
												<option value="29" <?php if($dob!='' && $dob[2]=='29'){?> selected = "true" <?php } ?>>29</option>
												<option value="30" <?php if($dob!='' && $dob[2]=='30'){?> selected = "true" <?php } ?>>30</option>
												<option value="31" <?php if($dob!='' && $dob[2]=='31'){?> selected = "true" <?php } ?>>31</option>
											</select>
											<select name="dob_month" id="dob_month">
												<option value="" selected="">Select</option>
												<option value="01" <?php if($dob!='' && $dob[1]=='01'){?> selected = "true" <?php } ?>>Jan</option>
												<option value="02" <?php if($dob!='' && $dob[1]=='02'){?> selected = "true" <?php } ?>>Feb</option>
												<option value="03" <?php if($dob!='' && $dob[1]=='03'){?> selected = "true" <?php } ?>>Mar</option>
												<option value="04" <?php if($dob!='' && $dob[1]=='04'){?> selected = "true" <?php } ?>>Apr</option>
												<option value="05" <?php if($dob!='' && $dob[1]=='05'){?> selected = "true" <?php } ?>>May</option>
												<option value="06" <?php if($dob!='' && $dob[1]=='06'){?> selected = "true" <?php } ?>>Jun</option>
												<option value="07" <?php if($dob!='' && $dob[1]=='07'){?> selected = "true" <?php } ?>>Jul</option>
												<option value="08" <?php if($dob!='' && $dob[1]=='08'){?> selected = "true" <?php } ?>>Aug</option>
												<option value="09" <?php if($dob!='' && $dob[1]=='09'){?> selected = "true" <?php } ?>>Sep</option>
												<option value="10" <?php if($dob!='' && $dob[1]=='10'){?> selected = "true" <?php } ?>>Oct</option>
												<option value="11" <?php if($dob!='' && $dob[1]=='11'){?> selected = "true" <?php } ?>>Nov</option>
												<option value="12" <?php if($dob!='' && $dob[1]=='12'){?> selected = "true" <?php } ?>>Dec</option>
												<!--<option value="Jan">Jan</option>
												<option value="Feb">Feb</option>
												<option value="Mar">Mar</option>
												<option value="Apr">Apr</option>
												<option value="May">May</option>
												<option value="Jun">Jun</option>
												<option value="Jul">Jul</option>
												<option value="Aug">Aug</option>
												<option value="Sep">Sep</option>
												<option value="Oct">Oct</option>
												<option value="Nov">Nov</option>
												<option value="Dec">Dec</option>-->
											</select>
											<select name="dob_year" id="dob_year">
												<option value="" selected="">Select</option>
												<option value="1999" <?php if($dob!='' && $dob[0]=='1999'){?> selected = "true" <?php } ?>>1999</option><option value="1998" <?php if($dob!='' && $dob[0]=='1998'){?> selected = "true" <?php } ?>>1998</option><option value="1997" <?php if($dob!='' && $dob[0]=='1997'){?> selected = "true" <?php } ?>>1997</option><option value="1996" <?php if($dob!='' && $dob[0]=='1996'){?> selected = "true" <?php } ?>>1996</option><option value="1995" <?php if($dob!='' && $dob[0]=='1995'){?> selected = "true" <?php } ?>>1995</option><option value="1994" <?php if($dob!='' && $dob[0]=='1994'){?> selected = "true" <?php } ?>>1994</option><option value="1993" <?php if($dob!='' && $dob[0]=='1993'){?> selected = "true" <?php } ?>>1993</option><option value="1992" <?php if($dob!='' && $dob[0]=='1992'){?> selected = "true" <?php } ?>>1992</option><option value="1991" <?php if($dob!='' && $dob[0]=='1991'){?> selected = "true" <?php } ?>>1991</option><option value="1990" <?php if($dob!='' && $dob[0]=='1990'){?> selected = "true" <?php } ?>>1990</option><option value="1989" <?php if($dob!='' && $dob[0]=='1989'){?> selected = "true" <?php } ?>>1989</option><option value="1988" <?php if($dob!='' && $dob[0]=='1988'){?> selected = "true" <?php } ?>>1988</option><option value="1987" <?php if($dob!='' && $dob[0]=='1987'){?> selected = "true" <?php } ?>>1987</option><option value="1986" <?php if($dob!='' && $dob[0]=='1986'){?> selected = "true" <?php } ?>>1986</option><option value="1985" <?php if($dob!='' && $dob[0]=='1985'){?> selected = "true" <?php } ?>>1985</option><option value="1984" <?php if($dob!='' && $dob[0]=='1984'){?> selected = "true" <?php } ?>>1984</option><option value="1983" <?php if($dob!='' && $dob[0]=='1983'){?> selected = "true" <?php } ?>>1983</option><option value="1982" <?php if($dob!='' && $dob[0]=='1982'){?> selected = "true" <?php } ?>>1982</option><option value="1981" <?php if($dob!='' && $dob[0]=='1981'){?> selected = "true" <?php } ?>>1981</option><option value="1980" <?php if($dob!='' && $dob[0]=='1980'){?> selected = "true" <?php } ?>>1980</option><option value="1979" <?php if($dob!='' && $dob[0]=='1979'){?> selected = "true" <?php } ?>>1979</option><option value="1978" <?php if($dob!='' && $dob[0]=='1978'){?> selected = "true" <?php } ?>>1978</option><option value="1977" <?php if($dob!='' && $dob[0]=='1977'){?> selected = "true" <?php } ?>>1977</option><option value="1976" <?php if($dob!='' && $dob[0]=='1976'){?> selected = "true" <?php } ?>>1976</option><option value="1975" <?php if($dob!='' && $dob[0]=='1975'){?> selected = "true" <?php } ?>>1975</option><option value="1974" <?php if($dob!='' && $dob[0]=='1974'){?> selected = "true" <?php } ?>>1974</option><option value="1973" <?php if($dob!='' && $dob[0]=='1973'){?> selected = "true" <?php } ?>>1973</option><option value="1972" <?php if($dob!='' && $dob[0]=='1972'){?> selected = "true" <?php } ?>>1972</option><option value="1971" <?php if($dob!='' && $dob[0]=='1971'){?> selected = "true" <?php } ?>>1971</option><option value="1970" <?php if($dob!='' && $dob[0]=='1970'){?> selected = "true" <?php } ?>>1970</option><option value="1969" <?php if($dob!='' && $dob[0]=='1969'){?> selected = "true" <?php } ?>>1969</option><option value="1968" <?php if($dob!='' && $dob[0]=='1968'){?> selected = "true" <?php } ?>>1968</option><option value="1967" <?php if($dob!='' && $dob[0]=='1967'){?> selected = "true" <?php } ?>>1967</option><option value="1966" <?php if($dob!='' && $dob[0]=='1966'){?> selected = "true" <?php } ?>>1966</option><option value="1965" <?php if($dob!='' && $dob[0]=='1965'){?> selected = "true" <?php } ?>>1965</option><option value="1964" <?php if($dob!='' && $dob[0]=='1964'){?> selected = "true" <?php } ?>>1964</option><option value="1963" <?php if($dob!='' && $dob[0]=='1963'){?> selected = "true" <?php } ?>>1963</option><option value="1962" <?php if($dob!='' && $dob[0]=='1962'){?> selected = "true" <?php } ?>>1962</option><option value="1961" <?php if($dob!='' && $dob[0]=='1961'){?> selected = "true" <?php } ?>>1961</option><option value="1960" <?php if($dob!='' && $dob[0]=='1960'){?> selected = "true" <?php } ?>>1960</option><option value="1959" <?php if($dob!='' && $dob[0]=='1959'){?> selected = "true" <?php } ?>>1959</option><option value="1958" <?php if($dob!='' && $dob[0]=='1958'){?> selected = "true" <?php } ?>>1958</option><option value="1957" <?php if($dob!='' && $dob[0]=='1957'){?> selected = "true" <?php } ?>>1957</option><option value="1956" <?php if($dob!='' && $dob[0]=='1956'){?> selected = "true" <?php } ?>>1956</option><option value="1955" <?php if($dob!='' && $dob[0]=='1955'){?> selected = "true" <?php } ?>>1955</option><option value="1954" <?php if($dob!='' && $dob[0]=='1954'){?> selected = "true" <?php } ?>>1954</option><option value="1953" <?php if($dob!='' && $dob[0]=='1953'){?> selected = "true" <?php } ?>>1953</option><option value="1952" <?php if($dob!='' && $dob[0]=='1952'){?> selected = "true" <?php } ?>>1952</option><option value="1951" <?php if($dob!='' && $dob[0]=='1951'){?> selected = "true" <?php } ?>>1951</option><option value="1950" <?php if($dob!='' && $dob[0]=='1950'){?> selected = "true" <?php } ?>>1950</option><option value="1949" <?php if($dob!='' && $dob[0]=='1949'){?> selected = "true" <?php } ?>>1949</option><option value="1948" <?php if($dob!='' && $dob[0]=='1948'){?> selected = "true" <?php } ?>>1948</option><option value="1947" <?php if($dob!='' && $dob[0]=='1947'){?> selected = "true" <?php } ?>>1947</option><option value="1946" <?php if($dob!='' && $dob[0]=='1946'){?> selected = "true" <?php } ?>>1946</option><option value="1945" <?php if($dob!='' && $dob[0]=='1945'){?> selected = "true" <?php } ?>>1945</option><option value="1944" <?php if($dob!='' && $dob[0]=='1944'){?> selected = "true" <?php } ?>>1944</option><option value="1943" <?php if($dob!='' && $dob[0]=='1943'){?> selected = "true" <?php } ?>>1943</option><option value="1942" <?php if($dob!='' && $dob[0]=='1942'){?> selected = "true" <?php } ?>>1942</option><option value="1941" <?php if($dob!='' && $dob[0]=='1941'){?> selected = "true" <?php } ?>>1941</option><option value="1940" <?php if($dob!='' && $dob[0]=='1940'){?> selected = "true" <?php } ?>>1940</option><option value="1939" <?php if($dob!='' && $dob[0]=='1939'){?> selected = "true" <?php } ?>>1939</option><option value="1938" <?php if($dob!='' && $dob[0]=='1938'){?> selected = "true" <?php } ?>>1938</option><option value="1937" <?php if($dob!='' && $dob[0]=='1937'){?> selected = "true" <?php } ?>>1937</option><option value="1936" <?php if($dob!='' && $dob[0]=='1936'){?> selected = "true" <?php } ?>>1936</option><option value="1935" <?php if($dob!='' && $dob[0]=='1935'){?> selected = "true" <?php } ?>>1935</option><option value="1934" <?php if($dob!='' && $dob[0]=='1934'){?> selected = "true" <?php } ?>>1934</option><option value="1933" <?php if($dob!='' && $dob[0]=='1933'){?> selected = "true" <?php } ?>>1933</option><option value="1932" <?php if($dob!='' && $dob[0]=='1932'){?> selected = "true" <?php } ?>>1932</option><option value="1931" <?php if($dob!='' && $dob[0]=='1931'){?> selected = "true" <?php } ?>>1931</option><option value="1930" <?php if($dob!='' && $dob[0]=='1930'){?> selected = "true" <?php } ?>>1930</option><option value="1929" <?php if($dob!='' && $dob[0]=='1929'){?> selected = "true" <?php } ?>>1929</option><option value="1928" <?php if($dob!='' && $dob[0]=='1928'){?> selected = "true" <?php } ?>>1928</option><option value="1927" <?php if($dob!='' && $dob[0]=='1927'){?> selected = "true" <?php } ?>>1927</option><option value="1926" <?php if($dob!='' && $dob[0]=='1926'){?> selected = "true" <?php } ?>>1926</option><option value="1925" <?php if($dob!='' && $dob[0]=='1925'){?> selected = "true" <?php } ?>>1925</option><option value="1924" <?php if($dob!='' && $dob[0]=='1924'){?> selected = "true" <?php } ?>>1924</option><option value="1923" <?php if($dob!='' && $dob[0]=='1923'){?> selected = "true" <?php } ?>>1923</option><option value="1922" <?php if($dob!='' && $dob[0]=='1922'){?> selected = "true" <?php } ?>>1922</option><option value="1921" <?php if($dob!='' && $dob[0]=='1921'){?> selected = "true" <?php } ?>>1921</option><option value="1920" <?php if($dob!='' && $dob[0]=='1920'){?> selected = "true" <?php } ?>>1920</option><option value="1919" <?php if($dob!='' && $dob[0]=='1919'){?> selected = "true" <?php } ?>>1919</option><option value="1918" <?php if($dob!='' && $dob[0]=='1918'){?> selected = "true" <?php } ?>>1918</option><option value="1917" <?php if($dob!='' && $dob[0]=='1917'){?> selected = "true" <?php } ?>>1917</option><option value="1916" <?php if($dob!='' && $dob[0]=='1916'){?> selected = "true" <?php } ?>>1916</option><option value="1915" <?php if($dob!='' && $dob[0]=='1915'){?> selected = "true" <?php } ?>>1915</option><option value="1914" <?php if($dob!='' && $dob[0]=='1914'){?> selected = "true" <?php } ?>>1914</option><option value="1913" <?php if($dob!='' && $dob[0]=='1913'){?> selected = "true" <?php } ?>>1913</option><option value="1912" <?php if($dob!='' && $dob[0]=='1912'){?> selected = "true" <?php } ?>>1912</option><option value="1911" <?php if($dob!='' && $dob[0]=='1911'){?> selected = "true" <?php } ?>>1911</option><option value="1910" <?php if($dob!='' && $dob[0]=='1910'){?> selected = "true" <?php } ?>>1910</option><option value="1909" <?php if($dob!='' && $dob[0]=='1909'){?> selected = "true" <?php } ?>>1909</option><option value="1908" <?php if($dob!='' && $dob[0]=='1908'){?> selected = "true" <?php } ?>>1908</option><option value="1907" <?php if($dob!='' && $dob[0]=='1907'){?> selected = "true" <?php } ?>>1907</option><option value="1906" <?php if($dob!='' && $dob[0]=='1906'){?> selected = "true" <?php } ?>>1906</option><option value="1905" <?php if($dob!='' && $dob[0]=='1905'){?> selected = "true" <?php } ?>>1905</option><option value="1904" <?php if($dob!='' && $dob[0]=='1904'){?> selected = "true" <?php } ?>>1904</option><option value="1903" <?php if($dob!='' && $dob[0]=='1903'){?> selected = "true" <?php } ?>>1903</option><option value="1902" <?php if($dob!='' && $dob[0]=='1902'){?> selected = "true" <?php } ?>>1902</option><option value="1901" <?php if($dob!='' && $dob[0]=='1901'){?> selected = "true" <?php } ?>>1901</option>
											</select> 
											<label>Mobile No</label>:
											<input type="tel" name="mobile" id="mobile" placeholder="Mobile No" <?php if($mobile_no!='') { ?> disabled <?php } ?>  value="<?php
												if($mobile_no!='') echo $mobile_no; ?>" autocomplete="off" maxlength="10" minlength="10" required>	<span id="mobilemsg" style="color: red;margin-left: 14px;"></span>
											<label>Pan Card No</label>:<!-- PANC CARD VALIDATION-->
											<input type="text" name="pan_no" maxlength="10" minlength="10" id="pan_no"  placeholder="Pan Card No" <?php if($pan_card_no!='') { ?> disabled <?php } ?> value="<?php
												if($pan_card_no!='') echo $pan_card_no; ?>" autocomplete="off" >
											<span id="pan_alert_msg" style="color: red;margin-left: 130px;"></span>
											<input type="hidden" name="user_email" id="user_email" value="<?php if($email!='') echo $email; ?>">
											<input type="hidden"  name="user_mobile" id="user_mobile" value="<?php if($mobile_no!='') echo $mobile_no; ?>">
											<input type="hidden" autocomplete="off" name="usernm" id="usernm" value="<?php echo $loggeduser; ?>">
											<div class="text-center"><button class="btn btn-default" style="margin:25px">Submit</button></div>
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-5 details-wrapper">
								<div class="bg-grey">
									<h5 class="text-center mb0"><b>Contact Details</b></h5>
									<span id="update_success_contact" style="display: none; color: green;text-align: center;">Your  profile has been updated successfully.</span>
									<span id="update_failure_contact" style="display: none; color: red;text-align: center;">Something went wrong,profile not updated.</span>
									<hr class="mt0">
									<div>
										<form  id="form_contact_details" action="update_contact_details.php" method="post">
											<label>Address</label>:
											<input type="text" name="address1" id="address1" value="<?php
												if($addr!='') echo $addr[0]; ?>"autocomplete="off" required>
											<label></label>:
											<input type="text" value="<?php
												if($addr!='' && sizeof($addr) >1) echo $addr[1]; ?>"autocomplete="off" name="address2" id="address2">
											<label>State</label>:
											<select name="state" id="state" required>
												<option value="">Please select State</option><option value="Andaman and Nicobar Islands" <?php if($state!='' && $state=='Andaman and Nicobar Islands'){?> selected = "true" <?php } ?>>Andaman and Nicobar Islands</option>
												<option value="Andhra Pradesh" <?php if($state!='' && $state=='Andhra Pradesh'){?> selected = "true" <?php } ?>>Andhra Pradesh</option>
												<option value="Arunachal Pradesh" <?php if($state!='' && $state=='Arunachal Pradesh'){?> selected = "true" <?php } ?>>Arunachal Pradesh</option>
												<option value="Assam" <?php if($state!='' && $state=='Assam'){?> selected = "true" <?php } ?>>Assam</option>
												<option value="Bihar" <?php if($state!='' && $state=='Bihar'){?> selected = "true" <?php } ?>>Bihar</option>
												<option value="Chandigarh" <?php if($state!='' && $state=='Chandigarh'){?> selected = "true" <?php } ?>>Chandigarh</option>
												<option value="Chhattisgarh" <?php if($state!='' && $state=='Chhattisgarh'){?> selected = "true" <?php } ?>>Chhattisgarh</option>
												<option value="Dadra and Nagar Haveli" <?php if($state!='' && $state=='Dadra and Nagar Haveli'){?> selected = "true" <?php } ?>>Dadra and Nagar Haveli</option>
												<option value="Daman and Diu" <?php if($state!='' && $state=='Daman and Diu'){?> selected = "true" <?php } ?>>Daman and Diu</option>
												<option value="Delhi" <?php if($state!='' && $state=='Delhi'){?> selected = "true" <?php } ?>>Delhi</option>
												<option value="Goa" <?php if($state!='' && $state=='Goa'){?> selected = "true" <?php } ?>>Goa</option>
												<option value="Gujarat" <?php if($state!='' && $state=='Gujarat'){?> selected = "true" <?php } ?>>Gujarat</option>
												<option value="Haryana" <?php if($state!='' && $state=='Haryana'){?> selected = "true" <?php } ?>>Haryana</option>
												<option value="Himachal Pradesh" <?php if($state!='' && $state=='Himachal Pradesh'){?> selected = "true" <?php } ?>>Himachal Pradesh</option>
												<option value="Jammu and Kashmir" <?php if($state!='' && $state=='Jammu and Kashmir'){?> selected = "true" <?php } ?>>Jammu and Kashmir</option>
												<option value="Jharkhand" <?php if($state!='' && $state=='Jharkhand'){?> selected = "true" <?php } ?>>Jharkhand</option>
												<option value="Karnataka" <?php if($state!='' && $state=='Karnataka'){?> selected = "true" <?php } ?>>Karnataka</option>
												<option value="Kerala" <?php if($state!='' && $state=='Kerala'){?> selected = "true" <?php } ?>>Kerala</option>
												<option value="Lakshadweep" <?php if($state!='' && $state=='Lakshadweep'){?> selected = "true" <?php } ?>>Lakshadweep</option>
												<option value="Madhya Pradesh" <?php if($state!='' && $state=='Madhya Pradesh'){?> selected = "true" <?php } ?>>Madhya Pradesh</option>
												<option value="Maharashtra" <?php if($state!='' && $state=='Maharashtra'){?> selected = "true" <?php } ?>>Maharashtra</option>
												<option value="Manipur" <?php if($state!='' && $state=='Manipur'){?> selected = "true" <?php } ?>>Manipur</option>
												<option value="Meghalaya" <?php if($state!='' && $state=='Meghalaya'){?> selected = "true" <?php } ?>>Meghalaya</option>
												<option value="Mizoram" <?php if($state!='' && $state=='Mizoram'){?> selected = "true" <?php } ?>>Mizoram</option>
												<option value="Nagaland" <?php if($state!='' && $state=='Nagaland'){?> selected = "true" <?php } ?>>Nagaland</option>
												<option value="Orissa" <?php if($state!='' && $state=='Orissa'){?> selected = "true" <?php } ?>>Orissa</option>
												<option value="Puducherry" <?php if($state!='' && $state=='Puducherry'){?> selected = "true" <?php } ?>>Puducherry</option>
												<option value="Punjab" <?php if($state!='' && $state=='Punjab'){?> selected = "true" <?php } ?>>Punjab</option>
												<option value="Rajasthan" <?php if($state!='' && $state=='Rajasthan'){?> selected = "true" <?php } ?>>Rajasthan</option>
												<option value="Sikkim" <?php if($state!='' && $state=='Sikkim'){?> selected = "true" <?php } ?>>Sikkim</option>
												<option value="Tamil Nadu" <?php if($state!='' && $state=='Tamil Nadu'){?> selected = "true" <?php } ?>>Tamil Nadu</option>
												<option value="Telangana" <?php if($state!='' && $state=='Telangana'){?> selected = "true" <?php } ?>>Telangana</option>
												<option value="Tripura" <?php if($state!='' && $state=='Tripura'){?> selected = "true" <?php } ?>>Tripura</option>
												<option value="Uttarakhand" <?php if($state!='' && $state=='Uttarakhand'){?> selected = "true" <?php } ?>>Uttarakhand</option>
												<option value="Uttar Pradesh" <?php if($state!='' && $state=='Uttar Pradesh'){?> selected = "true" <?php } ?>>Uttar Pradesh</option>
												<option value="West Bengal" <?php if($state!='' && $state=='West Bengal'){?> selected = "true" <?php } ?>>West Bengal</option>
											</select>
											<label>City</label>:
											<input type="text" name="city" id="city" value="<?php
												if($city!='') echo $city; ?>"  autocomplete="off" >
											<label>Country</label>:
											<h4>India</h4><br>
											<label>Pin Code</label>:
											<input type="text" name="pincode" id="pincode" value="<?php
												if($pincode!='') echo $pincode; ?>" autocomplete="off" />
											<input type="hidden" autocomplete="off" name="usernm" id="usernm" value="<?php echo $loggeduser; ?>">
											<div class="text-center"><button class="btn btn-default" style="margin:25px">Submit</button></div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<hr>
			</div>
		</div>
	</main>
	<footer>
		<div id="footer"></div>
	</footer>
</body>
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>-->
	<script>
		$(function(){
		  $("#header").load("header.php"); 
		  $("#footer").load("footer.php"); 
		  
		  $("#user_mobile").keypress(function(e)
			{
				if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				$("#mobilemsg").text("Enter Digits Only...!");
			}
			else  $("#mobilemsg").text("");
			});
			
			 $("#pan_no").blur(function()
			{
				var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
				 var txtpan = $("#pan_no").val(); 
				 if (txtpan.length == 10 ) { 
				  if(! txtpan.match(regExp) ){ 
				   $("#pan_alert_msg").text('Enter Valid PAN Number.')
				  }
				 } 
			});
			
			<?php  
		 $message = isset($_GET['profile_updated']) ? $_GET['profile_updated'] : '';
		 if($message == true)
		 {
		 ?>
				$('#success_msg').fadeIn().delay(15000).fadeOut();
		<?php } ?>
		
		var frm = $('#form_personal_details');
		frm.submit(function (e) {
			e.preventDefault();
			$.ajax({
				type: frm.attr('method'),
				url: frm.attr('action'),
				data: frm.serialize(),
				success: function (data) {
				//alert(data);
				if(data == 1)
					{ 
						//$('#form_personal_details').trigger("reset");
						$('#update_success_personal').fadeIn().delay(45000).fadeOut();
						var count = 10;
						var countdown1 = setInterval(function(){
						count--;
						 if (count == 0)
							{
								clearInterval(countdown1);  
								window.location=('my-profile.php');	
							}
							}, 1000);
						}
					else  if(data == 2)
					{
						//$('#form_personal_details').trigger("reset");
						$('#update_failure_personal').fadeIn().delay(25000).fadeOut();
						//window.location=('my-profile.php');
					}
					else  if(data == 3)
					{
						window.location=('my-profile.php');
					//alert("3");
						/* $('#form_personal_details').trigger("reset");
						$('#update_failure').fadeIn().delay(25000).fadeOut();
						window.location=('my-profile.php'); */
					}
				},
				error: function (data) {
					//$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
				},
			});
		});
		
		var frm1 = $('#form_contact_details');
		frm1.submit(function (e) {
			e.preventDefault();
			$.ajax({
				type: frm1.attr('method'),
				url: frm1.attr('action'),
				data: frm1.serialize(),
				success: function (data) {
				if(data == true)
					{ 
					 $('#form_contact_details').trigger("reset");
					 $('#update_success_contact').fadeIn().delay(25000).fadeOut();}
					else 
					{
						$('#form_contact_details').trigger("reset");
						$('#update_failure_contact').fadeIn().delay(25000).fadeOut();
					}
				},
				error: function (data) {
					//$('#login_failure_msg').fadeIn().delay(15000).fadeOut();
				},
			});
		});
		
		
		});
	</script>
</html>
<?php } ?>
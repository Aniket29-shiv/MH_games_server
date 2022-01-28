<?php
session_start();
include 'database.php';
$username = $_POST['username'];
$pass = $_POST['user_password'];
$userip='';
$usercity='';
$userregion='';
$usercountry='';

$devicetype='';
$ipaddress=$_SERVER['REMOTE_ADDR'];


if($ipaddress != ''){
   
        $url="http://ipinfo.io/".$ipaddress."/geo";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $curl_scraped_page = curl_exec($ch);
        curl_close($ch);
        
       // echo $curl_scraped_page;
        $resultdata= json_decode($curl_scraped_page, true);
        $userip=$resultdata['ip'];
        $usercity=$resultdata['city'];
        $userregion=$resultdata['region'];
        $usercountry=$resultdata['country'];

    
}
//====================client ip====================
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$ipaddress=get_client_ip();



 
//====device type

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

// If the user is on a mobile device, redirect them
if(isMobile()){$devicetype='MOBILE';}else{ $devicetype='Desktop';}

//=================OS client========================

$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}

$user_os= getOS();

$sql = "SELECT * FROM users where username = '".$username."' and password= '".md5($pass)."'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	while($row = $result->fetch_assoc()){ 
		if($row['login_status'] == 0){
        		$_SESSION['logged_user'] =  $username;
        		$_SESSION['user_id'] = $row['user_id'];
        		$_SESSION['email'] = $row['email'];
        		
        			$email=$row['email'];
            		$userid=$row['user_id'];
            		$cdate=date('Y-m-d H:i:s');
            		
            		$insert = "INSERT INTO `login_history`(`userid`, `email`, `username`, `os`, `ip`, `platform`, `city`, `region`, `country`,  `logindate`) VALUES ('".$userid."','".$email."','".$username."','".$user_os."','".$ipaddress."','".$user_agent."','".$usercity."','".$userregion."','".$usercountry."','".$cdate."')";
            	    $conn->query($insert);
            	    $last_id = $conn->insert_id;
            	    $_SESSION['loginid'] = $last_id; 
        		echo true;
        	    }else{
        	        echo 2;
        	    }
		//header("Location:point-fun-games.php");
		}
}
else {
echo false;
//echo '<script type="text/javascript">alert("Login Failed,Try Again...!");</script>';
//header("Location:index.php");
//exit();
}
$conn->close();

?>
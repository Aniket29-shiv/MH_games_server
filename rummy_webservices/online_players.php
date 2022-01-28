<?PHP

    $file = "../public/users.ini";
    // $ip = $_SERVER['REMOTE_ADDR'];
    // $time = time();
    // $content = @file_get_contents($file);
    // $new_content = $ip." = ".$time;
    // $content .= $new_content."\r\n";
    // @file_put_contents($file,$content);
    
    $users = @parse_ini_file($file);
    $count = 0;
    foreach($users as $ip=>$time){
    	if($time >= time() - 300){ // past 3 minutes
    		$count++;
    	}
    }
    
    //$user = "Invalid";
	$online_player = array('OnlinePlaye' => $count);
	header('Content-type: application/json');
echo json_encode(array('status'=>$online_player));
    
    //echo $count;

?>
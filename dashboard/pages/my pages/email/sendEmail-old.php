<?php


$getmaildetail=mysqli_query($conn,"SELECT * FROM `email_conf` WHERE id=1");
$lismaildetail=mysqli_fetch_object($getmaildetail);
//SELECT `id`, `sender`, `sendfrom`, `host`, `security`, `port`, `authentication`, `username`, `password`, `updated_date` FROM `email_conf` WHERE 1
$host=$lismaildetail->host;
$port= $lismaildetail->port;
$username=$lismaildetail->username;
$password= $lismaildetail->password;
$from=$lismaildetail->sender;
$fromname=$lismaildetail->sendfrom;
$security=$lismaildetail->security;
$authentication=$lismaildetail->authentication;

define('HOST',$host);
define('PORT',$port);
define('USERNAME',$username);
define('PASSWORD',$password);
define('FROM',$from);
define('FROMNAME',$fromname);
define('SECURITY',$security);
define('AUTHENTICATION',$authentication);
function sendmail($to,$subject,$message) {

    $mail = new PHPMailer(); 
    $mail->Host = HOST;  
	$mail->Port = PORT;       
	$mail->SMTPAuth = AUTHENTICATION;  
	$mail->SMTPDebug = 2;
	$mail->Username = USERNAME; 
	$mail->Password =PASSWORD; 
	$mail->SMTPSecure = SECURITY; 
	$mail->From = FROM;
	$mail->FromName = FROMNAME;
	$mail->AddAddress($to);
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->WordWrap = 50; 
	$mail->IsHTML(true);
    if($mail->Send()){
	
      return  'Message Send Successfully -'.$to;
      
	} else {

		return 'Error sending Message -'.$to; // ECHO Error sending message 
	}
	
}




?>
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


function bulkMail($to,$subject,$message) {
    
            $from = FROM;
            $to = $to;
            $crlf = "\n";
            $subject = $subject;
           // $body = $message;
            $headers = array(
            'From' => $from,
            'To' => $to,
            'Subject' => $subject
            );
            
            $mime = new Mail_mime(array('eol' => $crlf));

            //$mime->setTXTBody($subject);
            $mime->setHTMLBody($message);
            
            $body = $mime->get();
           $hdrs = $mime->headers($headers);
            
            $smtp = Mail::factory('smtp', array(
                'host' => HOST,
                'port' => PORT,
                'auth' => "PLAIN",
                'socket_options' => array('ssl' => array('verify_peer_name' => false)),
                 'debug'=>false,
                 'username' => USERNAME,
                'password' => PASSWORD
            ));
            
            
           
            $mail = $smtp->send($to, $hdrs, $body);
            
            //if (PEAR::isError($mail)) { echo('<p>' . $mail->getMessage() . '</p>');} else {echo('<p>Message successfully sent!</p>');}
            if (PEAR::isError($mail)) {  return false;} else {  return true;}
}
  
  
    
    
/*

function sendmail($to,$subject,$message) {
    
            $mail   = new PHPMailer; // call the class
            $mail->IsSMTP();
            $mail->Host = HOST; //Hostname of the mail server
            $mail->Port = PORT; //Port of the SMTP like to be 25, 80, 465 or 587
            $mail->SMTPAuth = true; //Whether to use SMTP authentication
            $mail->Username = USERNAME; //Username for SMTP authentication any valid email created in your domain
            $mail->Password = PASSWORD; //Password for SMTP authentication
            $mail->AddReplyTo(USERNAME, "Sudam Wanve"); //reply-to address
            $mail->SetFrom(USERNAME, "Sudam"); //From address of the mail
            // put your while loop here like below,
            $mail->Subject = $subject; //Subject od your mail
            $mail->AddAddress($to); 
            	$mail->Body = $message;//To address who will receive this email
           	$mail->IsHTML(true);//Put your body of the message you can place html code here
           //Attach a file here if any or comment this line,
            $send = $mail->Send(); //Send the mails
            
            if($send){
                return true;
            }
            else{
                return false;
            }
    	
    }
   




 $to='sudamwanve1992@gmail.com';
        $subject='testing by sudam';
        
        
        
        $sendmessage='<div style="background:rgb(41, 148, 201) ;font-family: Open Sans, sans-serif;font-size:14px;margin:0;padding:10px;color:#222;">
        <div style="background:#ffffff;padding:20px">
        <div style="padding-bottom:20px;margin-bottom:20px;border-bottom:1px solid rgb(206, 151, 51);">
        <div style=" text-align:center;">
        </div>
        </div>			  
        <div>
        <p style="margin:0px 0px 10px 0px">
        <p>Dear Admin,</p>
        <p>Hi HOw Are ou</p>
        <p>Thank you,</p>
        </div>
        <div>
        </div>
        </div>
        </div>';

    bulkMail($to,$subject,$sendmessage);
*/
?>
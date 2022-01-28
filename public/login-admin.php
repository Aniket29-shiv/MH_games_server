<?php
session_start();
include 'database.php';
$username = $_POST['username'];
$url= $_POST['url'];

if($_SESSION['logged_user']){
    unset($_SESSION["logged_user"]);
    unset($_SESSION["user_id"]);
    unset($_SESSION["email"]);
    unset($_SESSION["adminlogin"]);
    
}

$sql = "SELECT * FROM users where username = '".$username."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();
    $_SESSION['logged_user'] =  $username;
    $_SESSION['user_id'] = $row['user_id'];
    $_SESSION['email'] = $row['email'];
    $_SESSION['adminlogin'] = 1;
    
    echo '<script>window.location.href="'.$url.'"</script>';
}else{
  echo 'Somthing IS Wrong';
}

$conn->close();

?>
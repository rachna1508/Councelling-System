<?php

try{
    ini_set( "display_errors", 0); 
    session_destroy();
include 'db_init.php';
include 'forgot_id.html';
$link=new mysqli('localhost','root','','councelling');
if($link->connect_error)
    throw new Exception("Connection Error.");
$email=$_POST["email"];
print_r($email); 
$stmt=$link->prepare("select username from institute where mail=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result=$stmt->get_result();
$out=$result->fetch_array();
$user=$out["username"];
if($user!=""){
    
    
    echo "<script>document.getElementById('mail').value=' ".$email."';document.getElementById('id').value=' ".$user."';</script>";
}
 else
    throw new Exception("Invalid Mail.");


} catch (Exception $ex) {
        echo '<script>alert("'.$ex->getMessage().'")</script>'; 
}

?>


<?php
try{
    ini_set( "display_errors", 0); 
    session_destroy();
include 'db_init.php';
$link=new mysqli("localhost", "root", '', "councelling");
$username=$_POST["username"];
$password=$_POST["pass"];
if($username==""||$password=="")
    throw new Exception("Any fields are empty");
//do login word
    $stmt=$link->prepare("select * from inst_login where inst_username=? and password=?");
    $stmt->bind_param("ss", $username,$password);
    $stmt->execute();
    $result=$stmt->get_result();
    if($link->affected_rows>0){
        $stmt=$link->prepare("select Iid from institute where username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result=$stmt->get_result();
    
    if($result->num_rows>0){
        $result=$result->fetch_array();
        $iid=$result['Iid'];
        session_start();
            $_SESSION["username"]=$username;
            $_SESSION["password"]=$password;
            $_SESSION["id"]=$iid;
        header("Location:inst_main.php");
    }
    else
        throw new Exception("Error in login.");
    }
    else
        throw new Exception("Invalid Credentials.");
    
    
    
    } catch (Exception $ex) {
        include 'Institute-login.html';
          echo '<script>alert("'.$ex->getMessage().'")</script>';
}

?>
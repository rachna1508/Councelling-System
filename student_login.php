<?php
try{
    ini_set( "display_errors", 0); 
    session_destroy();
include 'student-login.html';
$link = mysqli_connect('localhost', 'root', '') or die('not connecting');
if ($link) {
    //connected to sql
    mysqli_query($link, "create database if not exists councelling");
    mysqli_select_db($link, "councelling");
    $username=$_POST["username"];
    $password=$_POST["password"];
    if($username==""||$password=="")
            throw new Exception ("Any field is empty.");
    $query="select * from st_login where username=? and password=?"; 
    $conn=new mysqli("localhost", "root", "", "councelling");
    $stmt=$conn->prepare($query);
    $stmt->bind_param("ss", $username,$password);
    $stmt->execute();
    $result=$stmt->get_result();
    if($result->num_rows>0)
        {
        $query2="select sid from student where username=?";
        $stmt2= $conn->prepare($query2);
        $stmt2->bind_param("s", $username);
        $stmt2->execute();
        $result2=$stmt2->get_result();
        $result3=$result2->fetch_array();
    
        $sid=$result3["sid"];
      
            //sucesslogin
            session_start();
            $_SESSION["username"]=$username;
            $_SESSION["password"]=$password;
            $_SESSION["id"]=$sid;
           
            header("Location:student_main.php");
            exit();
        }
        else
            throw new Exception ("Invalid credentials.");
       
}
 else {
   throw new Exception("Error in connecting database."); 
   }


} catch (Exception $ex) {
    echo '<script>alert("' . $ex->getMessage() . '")</script>';
}

?>
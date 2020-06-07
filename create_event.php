<?php
//try{
ini_set( "display_errors", 0); 
include 'db_init.php';
session_start();
$link=new mysqli("localhost", "root", '', "councelling");
$head=$_POST["head"];
$desc=$_POST["desc"];
$date=$_POST["ddate"];
if(!array_key_exists("title", $_POST))
        throw new Exception ("Select any Event.");

$event=$_POST["title"];
if($head==""||$desc==""||$date==""){
    include 'inst_main.html';
            echo '<script>alert("'.$ex->getMessage().'")</script>';
}
else{
if($stmt=$link->prepare("insert into events values(?,?,?,?,?,?)")){
$tid="";

$stmt->bind_param("ssssss", $id,$_SESSION["id"],$event,$head,$desc,$date);

$stmt->execute();
if($link->affected_rows>0){
    //header("Location:inst_main.php");
    include "inst_main.php";
    //header("Location: inst_main.php");
    echo '<script>alert("Event organized.")</script>';
    
    //exit();
}
else
throw new Exception("Error in organizing event.");
}
else
    throw new Exception("Error in organizing event.");
}
    
//} catch (Exception $ex) {
//            include 'inst_main.html';
//            echo '<script>alert("'.$ex->getMessage().'")</script>';
//}













//} catch (Exception $ex) {
//         echo '<script>alert("'.$ex->getMessage().'")</script>';
//}


?>
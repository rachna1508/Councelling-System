<?php

try {
    ini_set( "display_errors", 0); 
            session_start();
    $eid = $_GET["nam"];
    //print_r($eid);
    $link = new mysqli("localhost", "root", '', "councelling");
    $stmt = $link->prepare("insert into attende values(?,?,?,?)");
    $sid = $_SESSION["id"];
    $aid = "";
    $mdate=date('Y-m-d');
    $stmt->bind_param("ssss", $aid, $sid, $eid,$mdate );
    $result = $stmt->execute();
    if ($link->affected_rows > 0) {

        include "student_main.php";
        echo '<script>alert("Applied to Event.")</script>';
        
    } else
        throw Exception("Not Applied");
} catch (Exception $ex) {
    include 'student_main.php';
    echo '<script>alert("' . $ex->getMessage() . '")</script>';
}
?>


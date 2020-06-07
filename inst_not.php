<?php

try {
    ini_set( "display_errors", 0); 
   include 'inst_main.php';
    $eid = $_GET["nam"];
    $link = new mysqli("localhost", "root", '', "councelling");

    $stmt = $link->prepare("select * from events where eid=?");
    $stmt->bind_param("s", $eid);
    $result = $stmt->execute();
    $result = $stmt->get_result();

    $stmt2 = $link->prepare("select count(*) from attende where eid=?");
    $stmt2->bind_param("s", $eid);
    $result2 = $stmt2->execute();
    $result2 = $stmt2->get_result();
    $result2 = $result2->fetch_assoc();
    $count = $result2["count(*)"];
    $result = $result->fetch_assoc();
     header("refresh:0.0001; inst_main.php");
    $out = "Event type:" . $result["type"] . "\\nHeading:" . $result["heading"] . "\\nDescription:" . $result["description"] . "\\nApplied:" . $count . "\\nDeadline" . $result["deadline"] . "";
    echo '<script>alert("' . $out . '")</script>';
    exit();
        
} catch (Exception $ex) {
    echo '<script>alert("' . $ex->getMessage() . '")</script>';
}
 finally {
     
    
}
?>
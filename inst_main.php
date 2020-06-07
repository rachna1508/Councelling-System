<?php
try{
    
ini_set( "display_errors", 0); 
//include 'Institute-main.html';
session_start();
include 'db_init.php';
$link=new mysqli("localhost", "root", '', "councelling");
$stmt=$link->prepare("select * from events where Iid=?");
$id=$_SESSION["id"];

$stmt->bind_param("s", $id);
$result=$stmt->execute();
//print_r($id);
$result=$stmt->get_result();
//if($result->num_rows<=0)
  //      throw new Exception ("No Event found.");
 // print_r($result->num_rows);
if($result->num_rows>0){
$display="";
while($row=$result->fetch_array()){
    $stmt=$link->prepare("select count(*) from attende where eid=?");
    $stmt->bind_param("s", $row["eid"]);
    $stmt->execute();
    $re=$stmt->get_result();
    $re=$re->fetch_array();
    $count=$re[0];
    //print_r($row["heading"]);
    $display=$display.'<div class="notification">
                                <div class="head-desc">
                                    <p class="notif-heading">'.$row["heading"].'</p>
                                    <p class="notif-description">'.$row["description"].'</p>
                                </div>
                                <a href="inst_not.php?nam='.$row["eid"].'"><button class="apply-button" name="'.$row["eid"].'">View</button></a>
                            </div>';
            
            
//            .'
//    <div class="notification"><div class="head-desc"><p class="notif-heading">'.$row["heading"].'. applied:'.$count.', deadline:'.$row["deadline"].'</p><p> class="notif-description">'.$row["description"].'</p></div>
//                                <button class="apply-button">View</button>
//                            </div>';
}
libxml_use_internal_errors(true);
$html = 'Institute-main.html';
$dom = new DOMDocument();
$dom->loadHTMLFile($html);
$node = $dom->getElementById('notification');
$fragment = $dom->createDocumentFragment();
$fragment->appendXML($display);
$node->appendChild($fragment);
echo $dom->saveHTML();
}
else
{
    throw new Exception("No Event found.");
}

} catch (Exception $ex) {
    include 'Institute-main.html';
        echo '<script>alert("'.$ex->getMessage().'")</script>';
}

?>
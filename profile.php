<?php
try{
    ini_set( "display_errors", 0); 
include 'db_init.php';    
    session_start();
$link=new mysqli("localhost", "root", '', "councelling");
$stmt=$link->prepare("select * from institute where Iid=?");
$id=$_SESSION["id"];
$stmt->bind_param("s", $id);
$result=$stmt->execute();
//print_r($id);
$result=$stmt->get_result();
if($result->num_rows>0){
$row=$result->fetch_assoc();
    $out="";
$keys= array_keys($row);
foreach($keys as $key){
    $out=$out."<tr>
                    <th>".$key."</th>
                    <td>".$row[$key]."</td>
                </tr>";
}
    libxml_use_internal_errors(true);
$html = 'profile.html';
$dom = new DOMDocument();
$dom->loadHTMLFile($html);
$node = $dom->getElementById('mydata');
$fragment = $dom->createDocumentFragment();
$fragment->appendXML($out);
$node->appendChild($fragment);
echo $dom->saveHTML();
}
else 
    throw new Exception ("Session expired.");
} catch (Exception $ex) {
        include 'profile.html';
        echo '<script>alert("'.$ex->getMessage().'")</script>';
}

?>
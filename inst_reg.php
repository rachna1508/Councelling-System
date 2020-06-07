<?php
try{
    ini_set( "display_errors", 0); 
    session_destroy();
include 'db_init.php';
include 'Institute-login.html';
$link=new mysqli("localhost", "root", '', "councelling");
$name=$_GET['InstName'];
$username=$_GET["username"];
$password=$_GET["pass"];
$re_pass=$_GET['re_password'];
$mail=$_GET['mail'];
$rank=$_GET['Rank'];
$head_branch=$_GET['HBranch'];
$centers= array();
if(array_key_exists('center', $_GET))
        $centers=$_GET['center'];
$address=$_GET['addr'];
$website=$_GET['Website'];
$city=$_GET['city'];
$state=$_GET['state'];
$pin=$_GET['pin'];
$contact=$_GET['Contact'];
$phno=$_GET['phno'];
$about=$_GET['about'];
$vision=$_GET['vision'];
$NAAC_g=$_GET['grade'];
$enterance=$_GET["exam"];
//INSERTING OTHER DATA
$awards=Array();
$ug=Array();
$pg=Array();
$r=Array();
if(array_key_exists('award', $_GET))
        $awards=$_GET['award'];
if(array_key_exists('ug_name', $_GET))
        $ug=$_GET["ug_name"];
if(array_key_exists('pg_name', $_GET))
        $pg=$_GET["pg_name"];
if(array_key_exists('research_name', $_GET))
        $r=$_GET["research_name"];
if($password==""||$re_pass=="")
    throw new Exception ("Password not matched.");
elseif($contact==""||$city==""||$mail==""||$website==""){
    throw new Exception("Any field is empty.");
}
else{

    if($log=$link->prepare("insert into inst_login values(?,?)")){
        $log->bind_param("ss", $username,$password);
        $log->execute();
        $res=$log->get_result();
        if($link->affected_rows==1){
            //insert into institute table
            $qr="insert into institute values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt2=$link->prepare($qr);
            $iid="";
            $stmt2->bind_param("sssssssssssssss", $iid,$name,$username,$rank,$mail,$website,$address,$city,$state,$pin,$contact,$about,$vision,$NAAC_g,$enterance);
            $stmt2->execute();
            
            if($link->affected_rows==1)
            {
               $stmt=$link->prepare("select Iid from institute where username=?");
               $stmt->bind_param("s", $username);
               $stmt->execute();
               $res=$stmt->get_result();
               $res=$res->fetch_array();
               $id=$res["Iid"];
                //insreting other datas like awards
                //isnerting centers
               
                $stmt=$link->prepare("insert into centers values(?,?)");
                $cen="";
                 $stmt->bind_param("is",$id ,$cen);
                foreach ($centers as $cen)
                {
                    $stmt->execute();
                }
                //INSERTING AWARDS
                $stmt=$link->prepare("insert into awards values(?,?)");
                $cen="";
                 $stmt->bind_param("is",$id ,$cen);
                foreach ($awards as $cen)
                {
                    $stmt->execute();
                }
                //INSERTING PROGRAMS
                //FOR UG
                $level="UG";
                $query="insert into programs values(?,?,?)";
                $stmt=$link->prepare($query);
                $cen="";
                 $stmt->bind_param("iss",$id ,$level,$cen);
                foreach ($ug as $cen)
                {
                    $stmt->execute();
                }
                //FOR PG
                $level="PG";
                $stmt=$link->prepare($query);
                $cen="";
                 $stmt->bind_param("iss",$id ,$level,$cen);
                foreach ($pg as $cen)
                {
                    $stmt->execute();
                }
                //FOR RESEARCH
                $level="RESEARCH";
                $stmt=$link->prepare($query);
                $cen="";
                 $stmt->bind_param("iss",$id ,$level,$cen);
                foreach ($r as $cen)
                {
                    $stmt->execute();
                }
               echo '<script>alert("Account created.")</script>';
            }
            else{
                $stmt=$link->prepare("delete from inst_login where inst_username=?");
                $stmt->bind_param("d", $username);
                $stmt->execute();
                throw new Exception ("Error in creating account.");
            }
        }
        else{
            throw new Exception ("User already exists.");
        $stmt=$link->prepare("delete from inst_login where inst_username=?");
                $stmt->bind_param("d", $username);
                $stmt->execute();
            
        }
    }
}
    } catch (Exception $ex) {
        $username=$_POST["username"];
        $link=new mysqli("localhost", "root", '', "councelling");
        $stmt=$link->prepare("delete from inst_login where inst_username='?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        echo '<script>alert("'.$ex->getMessage().'")</script>';
}
?>
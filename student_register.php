<?php include 'student-register.html'; ?>
<?php

try {
    ini_set( "display_errors", 0); 
    session_destroy();
    include 'db_init.php';
    $link = mysqli_connect('localhost', 'root', '') or die('not connecting');
    if ($link) {
        //connected to sql
        mysqli_query($link, "create database if not exists councelling");
        mysqli_select_db($link, "councelling");

        //INSERTNG TABLE
        $name = $_POST["1name"] . " " . $_POST["2name"];
        $username = $_POST["user"];
        $password = $_POST["pass"];
        if (strcmp($password, $_POST["re_pass"])) {
            throw new Exception("Password not matched.");
        }
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $dob = $_POST["dateofbirth"];
        $gender = $_POST["gender"];
        $email = $_POST["mail"];
        $address = $_POST["addr"];
        $city = $_POST["incity"];
        $state = $_POST["instate"];
        $pin = $_POST["inpin"];
        $mobile = $_POST["mob"];
        //qualifications
        $qualifications = Array();
        //COLLECTING QUALIFICATIONS
        if (array_key_exists("hs", $_POST))
            $qualifications[] = $_POST["hs"];

        if (array_key_exists("tempname", $_POST))
            $qualifications[] = $_POST["tempname"];

        if (array_key_exists("ug", $_POST))
            $qualifications[] = $_POST["ug"];

        if (array_key_exists("pg", $_POST))
            $qualifications[] = $_POST["pg"];

        if (array_key_exists("phd", $_POST))
            $qualifications[] = $_POST["phd"];

        //GETTING CAREER OBJECTIVE
        $career = array();
        if (array_key_exists("carrear_objective", $_POST))
            $career = $_POST["carrear_objective"];

        //COLLECTING ACHIEVEMENTS
        $achievements = array();
        if (array_key_exists("achievement", $_POST))
            $achievements = $_POST["achievement"];
//    foreach($achievements as $val)
//        if(isset ($val))
//        echo $val."<br>";
//    
//    echo $name."<br> ".$username."<br> ".$password." <br>".$fname." <br>".$name." <br>".$dob."<br> ".$gender."<br> ".$email."<br> ".$address."<br> ".$city."<br> ".$state."<br> ".$pin."<br> ".$mobile."<br>";
        //INSERTING DATA INTO DATABASE
        //INSERTING USER LOGIN
        $query = "insert into st_login values('" . $username . "','" . $password . "')";
        $result = mysqli_query($link, $query);
        if (mysqli_affected_rows($link) <= 0)
            throw new Exception("Problem with Username or password.");
        $query = "insert into student values('','" . $name . "','" . $username . "','" . $fname . "','" . $mname . "','" . $dob . "','" . $gender . "','" . $email . "','" . $address . "','" . $city . "','" . $state . "','" . $pin . "','" . $mobile . "')";
        $result = mysqli_query($link, $query);
        if (!mysqli_affected_rows($link) > 0)
            throw new Exception("Error in regestration.");

        //insret achievements and more
        $result = mysqli_query($link, "select sid from student where username='" . $username . "'");
        $id = mysqli_fetch_array($result);

        if (!$id)
            throw new Exception("Error in regestration.");
        //GETTING STUDENT_ID
        $id = $id["sid"];
        //UPDATING CAREER OBJECTIVE
        $query = "insert into career_obj values(?,?)";
        if ($stmt = mysqli_prepare($link, $query)) {
            $obj = NULL;
            mysqli_stmt_bind_param($stmt, "ss", $id, $obj);
            foreach ($career as $val) {
                $obj = $val;
                mysqli_stmt_execute($stmt);
            }
        }
        $query = "insert into qualifications values(?,?)";
        if ($stmt = mysqli_prepare($link, $query)) {
            $qual = NULL;
            mysqli_stmt_bind_param($stmt, "ss", $id, $qual);
            foreach ($qualifications as $val) {
                $qual = $val;
                mysqli_stmt_execute($stmt);
            }
        }
        $query = "insert into achievements values(?,?)";
        if ($stmt = mysqli_prepare($link, $query)) {
            $qual = NULL;
            mysqli_stmt_bind_param($stmt, "ss", $id, $ach);
            foreach ($qualifications as $val) {
                $ach = $val;
                mysqli_stmt_execute($stmt);
            }
        }
        echo '<script>alert("Account created your Student ID : ' . $id . '.\nPleas Remember this")</script>';
    } else {
        throw new Exception("Not connected to database.");
    }
} catch (Exception $e) {


    echo '<script>alert("' . $e->getMessage() . '")</script>';
}
?>

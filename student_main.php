<?php

try {
ini_set( "display_errors", 0); 
    session_start();
//include 'student_main.html';
    $curdate = date('Y-m-d');
    include 'db_init.php';
    $link = new mysqli("localhost", "root", '', "councelling");
    $stmt = $link->prepare("select * from events where deadline>=?");
    $stmt->bind_param("s", $curdate);
    $result = $stmt->execute();
//print_r($id);
    $add = "";
    $enter = "";
    $result = $stmt->get_result();
    $stmt2 = $link->prepare("select eid from attende where sid=?");
    $id = $_SESSION["id"];
    $stmt2->bind_param("s", $id);
    $r = $stmt2->execute();
    $r = $stmt2->get_result();
    $result2 = array();
    if (($r->num_rows) > 0)
        while ($val = $r->fetch_array())
            $result2[] = $val["eid"];
//echo $_SESSION["id"].'<br>';
    while ($row = $result->fetch_assoc()) {
//    print_r($row);
//    print_r('<br>');
        if ($row["type"] == "Admission") {
            if (in_array($row["eid"], $result2))
                $button = '<a ><button class="apply-button" >Applied</button></a>';
            else
                $button = '<a href="apply_not.php?nam=' . $row["eid"] . '"><button class="apply-button">Apply</button></a>';
            $add = $add . '    <div class="st_notification">
                                <div class="shead-desc">
                                    <p class="notif-heading">' . $row["heading"] . '<p>Deadline: ' . $row["deadline"] . '</p></p>
                                    <p class="notif-description">' . $row["description"] . '</p>
                                </div>' . $button . '</div>';
        }
        else {
            if (in_array($row["eid"], $result2))
                $button = '<a><button class="apply-button" >Applied</button></a>';
            else
                $button = '<a href="apply_not.php?nam=' . $row["eid"] . '"><button class="apply-button">Apply</button></a>';

            $enter = $enter . ' <div class="st_notification">
                                <div class="shead-desc">
                                    <p class="notif-heading">' . $row["heading"] . '<p>Deadline: ' . $row["deadline"] . '</p></p>
                                    <p class="notif-description">' . $row["description"] . '</p>
                                </div>' . $button . '</div>';
        }
    }
    libxml_use_internal_errors(true);
    $html = 'student_main.html';
    $dom = new DOMDocument();
    $dom->loadHTMLFile($html);
    $node = $dom->getElementById('notification1');
    $fragment = $dom->createDocumentFragment();
    $fragment->appendXML($enter);
    $node->appendChild($fragment);
    $node = $dom->getElementById('notification2');
    $fragment = $dom->createDocumentFragment();
    $fragment->appendXML($add);
    $node->appendChild($fragment);
    echo $dom->saveHTML();
//                            <div class="notification">
//                                <div class="head-desc">
//                                    <p class="notif-heading">Heading</p>
//                                    <p class="notif-description">description</p>
//                                </div>
//                                <button class="apply-button">Apply</button>
//                            </div>
} catch (Exception $ex) {
    include 'student_main.html';
    echo '<script>alert("' . $ex->getMessage() . '")</script>';
}
?>

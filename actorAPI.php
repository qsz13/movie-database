<?php

if(isset($_GET['term'])) {
    $db = new mysqli('localhost', 'cs143', '', 'CS143');
    if ($db->connect_errno > 0) {
        die('Unable to connect to database [' . $db->connect_error . ']');
    }
    $term = "%".$db->real_escape_string(trim($_GET['term']))."%";
    $statement = $db->prepare("SELECT id, last, first FROM Actor WHERE CONCAT(Actor.first, ' ', Actor.last) LIKE ?");
    $statement->bind_param("s", $term);
    $statement->execute();
    $statement->store_result();
    $statement->bind_result($aid, $first, $last);
    while ($statement->fetch()) {
        $output[]=array('id'=>$aid,'text'=>$first.' '.$last);
    }
    header('Content-type: application/json');
    echo json_encode($output);
    $statement->close();
    $db->close();

}
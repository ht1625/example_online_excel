<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['arrr'])){
    $arr=$_POST['arrr'];
    $sql = "INSERT INTO files (file_name,last_modified) VALUES('$arr[0]','$arr[1]')";
    $conn->query($sql);
    echo $conn->insert_id;
}


?>
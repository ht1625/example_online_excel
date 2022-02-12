<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['fidd'])){
    $fid=$_POST['fidd'];
    $sql = "DELETE from files WHERE fid='$fid'";
    $conn->query($sql);
}


?>
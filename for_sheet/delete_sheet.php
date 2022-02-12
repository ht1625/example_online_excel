<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['sidd'])){
    $sid=$_POST['sidd'];
    $sql = "DELETE from sheets WHERE sid='$sid'";
    $conn->query($sql);
}


?>
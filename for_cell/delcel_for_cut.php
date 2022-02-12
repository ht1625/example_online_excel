<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['cidd'])){
    $cid=$_POST['cidd'];
    $sql ="UPDATE cells set data = '' where cid = '$cid'";
    $conn->query($sql);
}


?>
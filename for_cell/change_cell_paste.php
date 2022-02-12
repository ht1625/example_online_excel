<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['cidd']) && isset($_POST['data'])){
    $cid=$_POST['cidd'];
    $data=$_POST['data'];
    $sql ="UPDATE cells set data = '$data' where cid = '$cid'";
    $conn->query($sql);
}


?>
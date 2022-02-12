<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['newsid']) && isset($_POST['newrow'])){
    $new_sid=$_POST['newsid'];
    $new_row=$_POST['newrow'];

    $count_query=mysqli_query($conn,"SELECT roww from sheets where sid = '$new_sid'");//row sayısı sheet den +1 olmalı
    if($satir = mysqli_fetch_assoc($count_query)){ 
        $coll=$satir['roww']+1;
    }
    $sql = "UPDATE sheets set  roww = '$coll' WHERE sid = '$new_sid' ";
    $conn->query($sql);

    $queryyy=mysqli_query($conn,"SELECT * from cells where sid = '$new_sid' AND row > '$new_row'");
    while($row = mysqli_fetch_assoc($queryyy)){ //cell lerin sid sini update ediliyor
        $roww=$row['row']+1;
        $data=$row['cid'];
        $sql = "UPDATE cells set row = '$roww' WHERE cid = '$data' ";
        $conn->query($sql);
    }
}


?>
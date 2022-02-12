<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['newsid']) && isset($_POST['newcol'])){
    $new_sid=$_POST['newsid'];
    $new_col=$_POST['newcol'];

    $count_query=mysqli_query($conn,"SELECT cols from sheets where sid = '$new_sid'");//col sayısı sheet den +1 olmalı
    if($satir = mysqli_fetch_assoc($count_query)){ 
        $coll=$satir['cols']+1;
    }
    $sql = "UPDATE sheets set  cols = '$coll' WHERE sid = '$new_sid' ";
    $conn->query($sql);

    $queryyy=mysqli_query($conn,"SELECT * from cells where sid = '$new_sid' AND col >= '$new_col'");
    while($row = mysqli_fetch_assoc($queryyy)){ //cell lerin sid sini update ediliyor
        $roww=$row['col']+1;
        $data=$row['cid'];
        $sql = "UPDATE cells set  col = '$roww' WHERE cid = '$data' ";
        $conn->query($sql);
    }
}


?>
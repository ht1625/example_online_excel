<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['newsid']) && isset($_POST['oldsid']) && isset($_POST['oldrow']) && isset($_POST['newrow'])){
    $new_sid=$_POST['newsid'];
    $old_sid=$_POST['oldsid'];
    $new_row=$_POST['newrow'];
    $old_row=$_POST['oldrow'];

    $sql = "DELETE from cells WHERE sid = '$new_sid' AND row = '$new_row'";//cut edilecek onceki cell ler silinmeli
    $conn->query($sql);

    $queryy=mysqli_query($conn,"SELECT * from cells where sid = '$old_sid' AND row = '$old_row'");
    while($row = mysqli_fetch_assoc($queryy)){ //cell lerin yeni sini insert ediliyor
        $coll=$row['col'];
        $data=$row['data'];
        $sql = "INSERT INTO cells (row,col,data,sid) VALUES('$new_row','$coll','$data','$new_sid')";
        $conn->query($sql);
    }

    $sql = "DELETE from cells WHERE sid = '$old_sid' AND row = '$old_row'";//cut edilenler onceki cell ler silinmeli
    $conn->query($sql);

    $queryyy=mysqli_query($conn,"SELECT * from cells where sid = '$new_sid' AND row > '$old_row'");
    while($row = mysqli_fetch_assoc($queryyy)){ //cell lerin sid sini update ediliyor
        $col=$row['row']-1;
        $data=$row['cid'];
        $sql = "UPDATE cells set  row = '$col' WHERE cid = '$data' ";
        $conn->query($sql);
    }

    $count_query=mysqli_query($conn,"SELECT rows from sheets where sid = '$old_sid'");
    if($satir = mysqli_fetch_assoc($count_query)){ 
        $rowss=$satir['cols']-1;
    }

    $sql = "UPDATE sheets set  roww = '$rowss' WHERE sid = '$old_sid' ";
    $conn->query($sql);
}


?>
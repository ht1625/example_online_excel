<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['newsid']) && isset($_POST['oldsid']) && isset($_POST['oldcol']) && isset($_POST['newcol'])){
    $new_sid=$_POST['newsid'];
    $old_sid=$_POST['oldsid'];
    $new_col=$_POST['newcol'];
    $old_col=$_POST['oldcol'];

    $sql = "DELETE from cells WHERE sid = '$new_sid' AND col = '$new_col'";//cut edilecek onceki cell ler silinmeli
    $conn->query($sql);

    $queryy=mysqli_query($conn,"SELECT * from cells where sid = '$old_sid' AND col = '$old_col'");
    while($row = mysqli_fetch_assoc($queryy)){ //cell lerin sid sini update ediliyor
        $roww=$row['row'];
        $data=$row['data'];
        $sql = "INSERT INTO cells (row,col,data,sid) VALUES('$roww','$new_col','$data','$new_sid')";
        $conn->query($sql);
    }

    $sql = "DELETE from cells WHERE sid = '$old_sid' AND col = '$old_col'";//cut edilenler onceki cell ler silinmeli
    $conn->query($sql);

    $queryyy=mysqli_query($conn,"SELECT * from cells where sid = '$new_sid' AND col > '$old_col'");
    while($row = mysqli_fetch_assoc($queryyy)){ //cell lerin sid sini update ediliyor
        $roww=$row['col']-1;
        $data=$row['cid'];
        $sql = "UPDATE cells set  col = '$roww' WHERE cid = '$data' ";
        $conn->query($sql);
    }

    $count_query=mysqli_query($conn,"SELECT cols from sheets where sid = '$old_sid'");
    if($satir = mysqli_fetch_assoc($count_query)){ 
        $coll=$satir['cols']-1;
    }

    $sql = "UPDATE sheets set  cols = '$coll' WHERE sid = '$old_sid' ";
    $conn->query($sql);
}


?>
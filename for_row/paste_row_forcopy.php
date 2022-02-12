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
}


?>
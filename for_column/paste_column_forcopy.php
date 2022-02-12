<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['newsid']) && isset($_POST['oldsid']) && isset($_POST['oldcol']) && isset($_POST['newcol'])){
    $new_sid=$_POST['newsid'];
    $old_sid=$_POST['oldsid'];
    $new_col=$_POST['newcol'];
    $old_col=$_POST['oldcol'];

    $sql = "DELETE from cells WHERE sid = '$new_sid' AND col = '$new_col'";//paste edilecek onceki cell ler silinmeli
    $conn->query($sql);
    
    $queryy=mysqli_query($conn,"SELECT * from cells where sid = '$old_sid' AND col = '$old_col'");
    while($row = mysqli_fetch_assoc($queryy)){ //cell lerin sid sini update ediliyor
        $roww=$row['row'];
        $data=$row['data'];
        $sql = "INSERT INTO cells (row,col,data,sid) VALUES('$roww','$new_col','$data','$new_sid')";
        $conn->query($sql);
    }
}


?>
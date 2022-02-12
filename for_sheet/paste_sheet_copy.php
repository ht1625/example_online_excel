<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['copy_sid']) && isset($_POST['paste_sid'])){
    $copy_sid=$_POST['copy_sid'];
    $paste_sid=$_POST['paste_sid'];
    $sql = "DELETE from cells WHERE sid='$paste_sid'";//paste edilecek onceki cell ler silinmeli
    $conn->query($sql);
    $queryy=mysqli_query($conn,"SELECT * from cells where sid = '$copy_sid'");
    while($row = mysqli_fetch_assoc($queryy)){ //cell lerin sid sini update ediliyor
        $roww=$row['row'];
        $col=$row['col'];
        $data=$row['data'];
        $sql = "INSERT INTO cells (row,col,data,sid) VALUES('$roww','$col','$data','$paste_sid')";
        $conn->query($sql);
    }
}


?>
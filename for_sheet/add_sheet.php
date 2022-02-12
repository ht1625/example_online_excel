<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['fid'])){
    $data=$_POST['fid'];
    $count_query=mysqli_query($conn,"SELECT sname_case,position from sheets where fid = '$data' order by sid desc limit 1");
    if($satir = mysqli_fetch_assoc($count_query)){ 
        $sname_last=$satir['sname_case'];
        $position=($satir['position']+1);
    }
    $sname_last++;
    $sname="sheets".$sname_last;
    $sql = "INSERT INTO sheets (fid,sname,roww,cols,position,sname_case) VALUES('$data','$sname',10,10,'$position','$sname_last')";
    $conn->query($sql);
    echo $conn->insert_id;
}

?>
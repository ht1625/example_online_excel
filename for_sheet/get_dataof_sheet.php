<?php

include "db.php";
$conn=OpenCon();


if(isset($_POST['s_id'])){
    $sid=$_POST['s_id'];
    echo $sid;
    $sql="SELECT * FROM cells where  sid = $sid ";
    $def=mysqli_query($conn,$sql);
    $arr = array();
    $temp=array();
    $i=0;
    while($row=mysqli_fetch_assoc($def)){
        $temp[0]=$row['cid'];
        $temp[1]=$row['row'];
        $temp[2]=$row['col'];
        $temp[3]=$row['data'];
        $temp[4]=$row['sid'];
        $arr[$i]=$temp;
        $i++;
    }
    if($arr==null){
        echo null;
    }else{
        echo json_encode($arr);
    }
}

?>
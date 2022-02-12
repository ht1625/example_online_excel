<?php

include "db.php";
$conn=OpenCon();

if(isset($_POST['Data'])){
    $data=$_POST['Data'];
    if($data[0]==0){
        $sql = "INSERT INTO cells (row,col,data,sid) VALUES('$data[1]','$data[2]','$data[3]','$data[4]')";
        $conn->query($sql);
        echo $conn->insert_id;
    }else{
        $sql = "UPDATE cells set data = '$data[3]' where cid = '$data[0]'";
        $conn->query($sql); 
        echo 0;
    }
}

?>
<?php
function get_data_json($myquery,$def=0){
    $conn=OpenCon();
    $query = mysqli_query($conn,$myquery);

    if ( ! $query ) {
        echo mysqli_error();
        die;
    }    
    $data = array();    

    for ($x = 0; $x < mysqli_num_rows($query); $x++) {
        $data[] = mysqli_fetch_assoc($query);
    }

    if($def==0){
        $echo=json_encode($data);
        return json_decode($echo);
    }else{
        return json_encode($data);
    }
    //echo $echo1[0]->fid;    
}
?>
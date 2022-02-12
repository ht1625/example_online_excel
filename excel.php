<?php
$file_id = $_GET['fid'];
include "db.php";
$conn=OpenCon();
include "json_func.php";
$count_sheets=0;
$count_query=mysqli_query($conn,"SELECT count(1) as deger from sheets where fid = '$file_id' AND active = 1");
if($satir = mysqli_fetch_assoc($count_query)){ 
    $count_sheets=$satir['deger'];
}
$door=false; 
$sid_sheet;   
if($count_sheets!=0){
    $myquery = "SELECT * from sheets where fid = '$file_id'  AND active = 1 order by position ";
    $sheets=get_data_json($myquery);
    $door=true;
    $sid_sheet=$sheets[0]->sid;
    $cell_of_sheets=array();
    for($i=0;$i<$count_sheets;$i++){
        $deger=$sheets[$i]->sid;
        $myquery = "SELECT * from cells where sid = '$deger'";
        array_push($cell_of_sheets,get_data_json($myquery));
    }
}else{
    $sql = "INSERT INTO sheets (fid,sname,roww,cols,position,sname_case) VALUES('$file_id','sheets1',10,10,1,1)";
    $conn->query($sql);
    $sid_sheet=$conn->insert_id;
}
//echo $cell_of_sheets[0][0]->sid;

?>
<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
/* this css for context-menu of cell */
        .context-menu {
            position: absolute;
            text-align: center;
            background: lightgray;
            border: 1px solid #ddd;
        }
  
        .context-menu ul {
            padding: 0px;
            margin: 0px;
            min-width: 150px;
            list-style: none;
        }
  
        .context-menu ul li {
            padding-bottom: 7px;
            padding-top: 7px;
            border: 1px solid #ddd;
        }
  
        .context-menu ul li a {
            text-decoration: none;
            color: black;
        }
  
        .context-menu ul li:hover {
            background: darkgray;
        }
        .th{
            background: #ddd;
        }
</style>
</head>
<body>
<?php 
        
        $current_sheets=0;
        if($count_sheets==0){
                $current_row_count=10;
                $current_col_count=10;
        }
        else{
                $current_row_count=$sheets[0]->roww;
                $current_col_count=$sheets[0]->cols;
        }
    $width_of_page=" ".strval($current_col_count*10)."%";
?>
<div style="width:<?php if($count_sheets==0){ echo "100%";}else { echo $width_of_page; }?>" id="bodyy">
    <table class="table table-bordered" id="myTable">
    <thead>
        <tr>
        <th scope="col" class="th"  style="border:1px solid darkgray">&nbsp;&nbsp;#</th>
        <?php for($i=1;$i<$current_col_count+1;$i++){  ?>
                <th scope="col" class="th" id="column_th<?php echo $i; ?>" style="border:1px solid darkgray"><button  id="col_big<?php echo $i; ?>" style="width:100%;background-color:#ddd;border:none"  oncontextmenu = "rightClick(event,<?php echo $i; ?>,3)" ><?php echo $i; ?> </button>
                    <div id="col<?php echo $i; ?>" class="context-menu" style="display:none">
                        <ul>
                            <li><a href="#" style="font-weight:200" onclick="return theFunction3(1,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_row_count;?>,<?php echo $current_col_count;?>)">Cut</a></li>
                            <li><a href="#" style="font-weight:200" onclick="return theFunction3(2,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_row_count;?>,<?php echo $current_col_count;?>)">Copy</a></li>
                            <li><a href="#" style="font-weight:200" onclick="return theFunction3(3,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_row_count;?>,<?php echo $current_col_count;?>)">Paste</a></li>
                            <li><a href="#" style="font-weight:200" onclick="return theFunction3(4,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_row_count;?>,<?php echo $current_col_count;?>)">Delete</a></li>
                            <li><a href="#" style="font-weight:200" onclick="return theFunction3(5,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_row_count;?>,<?php echo $current_col_count;?>)">Add column to right</a></li>
                            <li><a href="#" style="font-weight:200" onclick="return theFunction3(6,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_row_count;?>,<?php echo $current_col_count;?>)">Add column to left</a></li>
                        </ul>
                    </div>           
                </th>
        <?php } ?>  
        </tr>
    </thead>
    <tbody>
        <?php
            for($i=1;$i<$current_row_count+1;$i++){ ?>
                <tr id="row_tr<?php echo $i; ?>">
                    <th scope="row" class="th" id="row_th<?php echo $i; ?>" style="border:1px solid darkgray"><button class="th" id="row_big<?php echo $i; ?>" style="width:100%;background-color:#ddd;border:none"  oncontextmenu = "rightClick(event,<?php echo $i; ?>,4)" ><?php echo $i; ?> </button>
                        <div id="row<?php echo $i; ?>" class="context-menu" style="display:none">
                            <ul>
                                <li><a href="#" style="font-weight:200" onclick="return theFunction4(1,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_col_count;?>,<?php echo $current_row_count;?>)">Cut</a></li>
                                <li><a href="#" style="font-weight:200" onclick="return theFunction4(2,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_col_count;?>,<?php echo $current_row_count;?>)">Copy</a></li>
                                <li><a href="#" style="font-weight:200" onclick="return theFunction4(3,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_col_count;?>,<?php echo $current_row_count;?>)">Paste</a></li>
                                <li><a href="#" style="font-weight:200" onclick="return theFunction4(4,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_col_count;?>,<?php echo $current_row_count;?>)">Delete</a></li>
                                <li><a href="#" style="font-weight:200" onclick="return theFunction4(5,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_col_count;?>,<?php echo $current_row_count;?>)">Add row to down</a></li>
                                <li><a href="#" style="font-weight:200" onclick="return theFunction4(6,<?php echo $sid_sheet; ?>,<?php echo $file_id;?>,<?php echo $i;?>,<?php echo $current_col_count;?>,<?php echo $current_row_count;?>)">Add row to up</a></li>
                            </ul>
                        </div>
                    </th>
                    <?php 
                    for($j=1;$j<$current_col_count+1;$j++){ 
                        $data_of_cell="";
                        $cid_of_cell=0;
                        //echo $cell_of_sheets[0][0]->sid;
                        if($door){
                            foreach($cell_of_sheets[0] as $cell){
                                //echo $cell->sid;
                                if($cell->col==$j && $cell->row==$i){
                                    $data_of_cell=$cell->data;
                                    $cid_of_cell=$cell->cid;
                                }
                            }
                        }
                        $id_menu=strval($i).strval($j).strval($sid_sheet);
                        ?>
                        <td contenteditable='true' id="td<?php echo $i; ?><?php echo $j; ?>"> <input type="text" id="value<?php echo $id_menu; ?>"  oncontextmenu = "rightClick(event,<?php echo $id_menu; ?>,1)"  
                        style='border:none;outline:none;' onkeyup="save_cell(<?php echo $i; ?>,<?php echo $j; ?>,<?php echo $cid_of_cell ?>,<?php echo $sid_sheet; ?>);" value="<?php echo $data_of_cell; ?>" />              
                        <input type="hidden" value="<?php echo $cid_of_cell ?>" id="cid<?php echo $id_menu; ?>"/>    
                        <div id="<?php echo $id_menu; ?>" class="context-menu" style="display:none">
                                <ul>
                                    <li><a href="#" style="font-weight:200" onclick="return theFunction(1,<?php echo $id_menu; ?>,<?php echo $cid_of_cell; ?>,0,0,0);">Cut</a></li>
                                    <li><a href="#" style="font-weight:200" onclick="return theFunction(2,<?php echo $id_menu; ?>,<?php echo $cid_of_cell; ?>,0,0,0);">Copy</a></li>
                                    <li><a href="#" style="font-weight:200" onclick="return theFunction(3,<?php echo $id_menu; ?>,<?php echo $cid_of_cell; ?>,<?php echo $i; ?>,<?php echo $j; ?>,<?php echo $sid_sheet; ?>);">Paste</a></li>
                                </ul>
                            </div>
                        </td>
                    <?php } ?>
                </tr> 
            <?php } ?>
    </tbody>
    </table>
</div>    
<div style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;position: fixed;bottom: 0;">
    <button style="font-size:large" onclick="add_sheet(<?php echo $file_id; ?>)">+</button>
    <input type="hidden" value="<?php echo ($count_sheets+1);?>" id="count_sheets"/>
    <div style="display:inline;font-size:large" id="sheet">
        <?php if($door==false){ ?>
            <button onclick="open_sheet(<?php echo $sid_sheet; ?>,10,10)" id="button<?php echo $sid_sheet; ?>" oncontextmenu = "rightClick(event,<?php echo $sid_sheet; ?>,2)"> sheets1 </buttton>
            <div id="<?php echo $sid_sheet; ?>" class="context-menu" style="display:none">
                <ul>
                    <li><a href="#" style="font-weight:200" onclick="return theFunction2(1,<?php echo $sid_sheet; ?>)">Delete</a></li>
                    <li><a href="#" style="font-weight:200" onclick="return theFunction2(3,<?php echo $sid_sheet; ?>)">Copy</a></li>
                    <li><a href="#" style="font-weight:200" onclick="return theFunction2(4,<?php echo $sid_sheet; ?>)">Paste</a></li>
                    <!--<li><a href="#" onclick="return theFunction2(5,<?php echo $sid_sheet; ?>)">YENİDEN ADLANDIR</a></li>-->
                </ul>
            </div>
        <?php } for($i=0;$i<$count_sheets;$i++){ ?>
            <button onclick="open_sheet(<?php echo $sheets[$i]->sid; ?>,<?php echo $sheets[$i]->roww; ?>,<?php echo $sheets[$i]->cols; ?>)"   id="button<?php echo $sheets[$i]->sid; ?>" oncontextmenu = "rightClick(event,<?php echo $sheets[$i]->sid; ?>,2)" ><?php echo $sheets[$i]->sname; ?></buttton>
            <div id="<?php echo $sheets[$i]->sid; ?>" class="context-menu" style="display:none">
                <ul>
                    <li><a href="#" style="font-weight:200" onclick="return theFunction2(1,<?php echo $sheets[$i]->sid; ?>)">Delete</a></li>
                    <li><a href="#" style="font-weight:200" onclick="return theFunction2(3,<?php echo $sheets[$i]->sid; ?>)">Copy</a></li>
                    <li><a href="#" style="font-weight:200" onclick="return theFunction2(4,<?php echo $sheets[$i]->sid; ?>)">Paste</a></li>
                    <!--<li><a href="#" onclick="return theFunction2(5,<?php echo $sheets[$i]->sid; ?>)">YENİDEN ADLANDIR</a></li>-->
                </ul>
            </div>
        <?php } ?>    
    <div>
</div>



<script> //cut copy paste add for row

var sidd=null;
var fidd=null;
var rowid=null;
var countcol=null;
var copyy_cutt=null;//1 for cut, 2 for copy


function theFunction4(choose,s_id,f_id,row_id,count_col,count_row){
    if(choose==1){//for cut

        copyy_cutt=1;
        sidd=s_id;
        fidd=f_id;
        rowid=row_id;
        countcol=count_col;
        document.getElementById("row_th"+row_id).style.border = "2px solid green";
        for(var ik=1;ik<countcol+1;ik++){
            document.getElementById("td"+row_id+ik).style.border = "2px solid green";
        }

    }else if(choose==2){//for copy

        copyy_cutt=2;
        sidd=s_id;
        fidd=f_id;
        rowid=row_id;
        countcol=count_col;

    }else if(choose==3){//for paste

        if(copyy_cutt==1){//for cut

            $.ajax({
                type: "POST",
                url: "for_row/paste_row_forcut.php",
                data: { newsid: s_id,newrow:row_id,oldsid:sidd,oldrow:rowid},
                success: function(data)
                {
                    open_sheet(s_id,count_row+1,count_col);
                }
            });

        }else if(copyy_cutt==2){//for copy

            $.ajax({
                type: "POST",
                url: "for_row/paste_row_forcopy.php",
                data: { newsid: s_id,newrow:row_id,oldsid:sidd,oldrow:rowid},
                success: function(data)
                {
                    open_sheet(s_id,count_row+1,count_col);
                }
            }); 

        }

    }else if(choose==4){//for delete
            $.ajax({
               type: "POST",
                url: "for_row/delete_row.php",
                data: { newsid: s_id,newrow:row_id},
                success: function(data)
                {
                    //column display block yap
                    document.getElementById("row_tr"+row_id).style.display="none";
                }
            });  

    }else if(choose==5){//for add down

            $.ajax({
                type: "POST",
                url: "for_row/shift_down_row.php",
                data: { newsid: s_id,newrow:row_id},
                success: function(data)
                {
                    //row ekle aşağı js le
                    open_sheet(s_id,count_row+1,count_col);
                }
            });

    }else{//for add up

            $.ajax({
                type: "POST",
                url: "for_row/shift_up_row.php",
                data: { newsid: s_id,newrow:row_id},
                success: function(data)
                {
                    //row ekle yukarı js le
                    open_sheet(s_id,count_row+1,count_col);
                }
            });

    }
}



</script>



<script>// cut, copy, paste, add for column

var sid=null;
var fid=null;
var colid=null;
var countrow=null;
var copy_cut=null;//1 for cut, 2 for copy

function theFunction3(choose,s_id,f_id,col_id,count_row,count_col){
    if(choose==1){//for cut
        
        copy_cut=1;
        sid=s_id;
        fid=f_id;
        colid=col_id;
        countrow=count_row;
        document.getElementById("column_th"+col_id).style.border = "2px solid blue";
        for(var ik=1;ik<count_row+1;ik++){
            document.getElementById("td"+ik+col_id).style.border = "2px solid blue";
        }

    }else if(choose==2){//for copy

        copy_cut=2;
        sid=s_id;
        fid=f_id;
        colid=col_id;
        countrow=count_row;

    }else if(choose==3){//for paste

        if(copy_cut==1){//for cut

            $.ajax({
                type: "POST",
                url: "for_column/paste_column_forcut.php",
                data: { newsid: s_id,newcol:col_id,oldsid:sid,oldcol:colid},
                success: function(data)
                {
                    open_sheet(s_id,count_row,count_col-1);
                }
            }); 
            
        }else if(copy_cut==2){//for copy
            $.ajax({
                type: "POST",
                url: "for_column/paste_column_forcopy.php",
                data: { newsid: s_id,newcol:col_id,oldsid:sid,oldcol:colid},
                success: function(data)
                {
                    open_sheet(s_id,count_row,count_col);
                }
            }); 
        }

    }else if(choose==4){//for delete

            $.ajax({
                type: "POST",
                url: "for_column/delete_column.php",
                data: { newsid: s_id,newcol:col_id},
                success: function(data)
                {
                    open_sheet(s_id,count_row,count_col-1);
                }
            });     

    }else if(choose==5){//for add col to right 

            $.ajax({
                type: "POST",
                url: "for_column/shift_right_col.php",
                data: { newsid: s_id,newcol:col_id},
                success: function(data)
                {
                    open_sheet(s_id,count_row,count_col+1);
                }
            });

    }else{//for add col to left
            count_col+=1;
            $.ajax({
                type: "POST",
                url: "for_column/shift_left_col.php",
                data: { newsid: s_id,newcol:col_id},
                success: function(data)
                {
                    open_sheet(s_id,count_row,count_col);
                }
            });

    }
}



</script>


<script> // cut rename copy paste for sheet

var s_id=null;
var copy_or_cut=null;//1 for copy and null anyone

function theFunction2(choose,sid){
    
    if(choose==1){//delete sheet

        $.ajax({
            type: "POST",
            url: "for_sheet/delete_sheet.php",
            data: { sidd: sid},
            success: function(data)
            {
                //alert("sxd");
                document.getElementById("button"+sid).style.display = "none";
            }
        });        

    }else if(choose==3){//copy sheet
        
        s_id=sid;
        copy_or_cut=2;

    }else if(choose==4){//paste sheet
   
        if(s_id!=null){
                //copy
                $.ajax({
                type: "POST",
                url: "for_sheet/paste_sheet_copy.php",
                data: { copy_sid: s_id,paste_sid:sid},
                success: function(data)
                {
                    //alert("sxd");
                    copy_or_cut=null;
                    s_id=null;
                    open_sheet(sid);
                }
                });
        }

    }else{//rename sheet

        alert("xcfvgbhn");
        
    }

}

</script>



<script> //cut copy paste for cell

var data_of_get=null;
var check_data=false;

function theFunction(choose,id,cid,i,j,sid){
    if(choose==1){//for cut

        check_data=true;
        data_of_get=document.getElementById("value"+id).value;
        document.getElementById("value"+id).value="";
        //delete from db
        if(cid!=0){
            $.ajax({
            type: "POST",
            url: "for_cell/delcel_for_cut.php",
            data: { cidd: cid},
            success: function(data)
            {
                //alert("sxd");
            }
            });
        }

    }else if(choose==2){//cell copy

        check_data=true;
        data_of_get=document.getElementById("value"+id).value;

    }else{//cell paste

        if(check_data){
            document.getElementById("value"+id).value=data_of_get;
            if(cid!=0){
                $.ajax({
                type: "POST",
                url: "for_cell/change_cell_paste.php",
                data: { cidd: cid , data: data_of_get},
                success: function(data)
                {
                     //alert("sxd");
                }
                });
            }else{
                var arr=new Array(cid,i,j,data_of_get,sid);
                $.ajax({
                    type: "POST",
                    url: "for_cell/add_cell.php",
                    data: { Data: arr},
                    success: function(data)
                    {
                        //alert("xdcfv");
                    }
                });
            }
        }

    }
}



</script>


<!--   context-menu script   -->

<script>

        var prev_id=null;
        document.onclick = hideMenuu;
        //document.oncontextmenu = rightClick;
  
        function hideMenuu() {
            if(prev_id!=null){
                document.getElementById(prev_id).style.display = "none";
                prev_id=null;
            }
        }

        function hideMenu(prevv_id) {
            document.getElementById(prevv_id).style.display = "none";
        }
  
        function rightClick(e,id,choose) {
            if(choose==3){
                id="col"+id;
                choose=1;
            }
            if(choose==4){
                id="row"+id;
                choose=1;
            }
            e.preventDefault();
            if(prev_id!=null){
                if (document.getElementById(prev_id).style.display == "block"){
                    hideMenu(prev_id);
                    var menu = document.getElementById(id)                 
                    menu.style.display = 'block';
                    menu.style.left = e.pageX + "px";
                    if(choose==1){
                        menu.style.top = e.pageY + "px";
                    }else{
                        menu.style.bottom = "0px";
                    }
                    prev_id=id;
                }
            }else{
                    var menu = document.getElementById(id)                 
                    menu.style.display = 'block';
                    menu.style.left = e.pageX + "px";
                    if(choose==1){
                        menu.style.top = e.pageY + "px";
                    }else{
                        menu.style.bottom = "0px";
                    }
                    prev_id=id;
            }
        }
</script>


<script>

var prev_sid_sheet=null;    

function open_sheet(sid,row,col){
    if(prev_sid_sheet!=null){
        document.getElementById("button"+prev_sid_sheet).style.color = "black";
        document.getElementById("button"+sid).style.color = "green";
        prev_sid_sheet=sid;
    }else{
        document.getElementById("button"+sid).style.color = "green";
        prev_sid_sheet=sid;
    }
    //alert("xsdcf");
    this.delete_table(col,row,sid);
   //get data of sheet
    var door=false;
    $.ajax({
        type: "POST",
        url: "for_sheet/get_dataof_sheet.php",
        data: { s_id: sid },
        success: function(data)
        {
                      
            var cut_border=0;
            var door=false;
            for(var i=0;i<data.length;i++){
                if(data[i]=="["){
                    cut_border=i;
                    if(data[i+1]=="]"){
                        door=true;
                    }
                    break;
                }
            }
            if(door){
                create_table_sheet(sid,0,row,col);
            }
            else{               
                data=data.substr(cut_border,(data.length+1));
                const obj = JSON.parse(data);
                create_table_sheet(sid,obj,row,col);
            }           

        }
    });
}


function save_cell(row,col,cid_td,sid){
    var id_menu="cid"+row+col+sid;
    var y = document.getElementById("myTable");
    x=y.rows[row].cells;
    var data_of_cell=x[col].children[0].value;
    cid_td=document.getElementById(id_menu).value;
    var arr=new Array(cid_td,row,col,data_of_cell,sid);
    $.ajax({
        type: "POST",
        url: "for_cell/add_cell.php",
        data: { Data: arr},
        success: function(data)
        {
            if(data!=0){
                document.getElementById(id_menu).value=data;
            }
        }
    });
}

function add_sheet(file_id){

    //go to php file and save sheet to db
    var sid_new=0;
    $.ajax({
        type: "POST",
        url: "for_sheet/add_sheet.php",
        data: { fid: file_id },
        success: function(data)
        {
            sid_new=data;
            delete_table(10,10,sid_new);
            create_table_sheet(sid_new,0,10,10);
            //create button for new sheet
            var count_sheet = document.getElementById("count_sheets").value;
            var myDiv = document.getElementById("sheet");
            var button = document.createElement("BUTTON");
            button.setAttribute("id","button"+sid_new);
            count_sheet=parseInt(count_sheet);
            button.innerHTML = "Sheet "+count_sheet+"<div id='"+sid_new+"' class='context-menu' style='display:none'>"+
                "<ul><li><a href='#' style='font-weight:200'  onclick='return theFunction2(1,"+sid_new+")'>Delete</a></li>"+
                    "<li><a href='#' style='font-weight:200' onclick='return theFunction2(3,"+sid_new+")'>Copy</a></li>"+
                    "<li><a href='#' style='font-weight:200' onclick='return theFunction2(4,"+sid_new+")'>Paste</a></li></ul></div>";
            myDiv.appendChild(button);
            
            document.getElementById("count_sheets").value=count_sheet;
            //add click function to button of sheet for opening 
            document.getElementById("button"+sid_new).onclick=function(){ open_sheet(sid_new,10,10)};
            button.addEventListener("contextmenu", (e) => {
                e.preventDefault();
                rightClick(event,sid_new,2);
            });
        }
    });

}


function delete_table(col,row,sid){
    //delete all of row
    var count_row=document.getElementById("myTable").rows.length;
    for(var i=count_row;i>0; i--){
        document.getElementById("myTable").deleteRow(i-1);
    }

    //set width of table
    var def=col*10;
    document.getElementById('bodyy').style.width=def+'%';
    //delete of more column
    var table = document.getElementById("myTable");

    tableHeaderRow = document.createElement("tr");
    table.appendChild(tableHeaderRow);

    var tableHeader = document.createElement("th");
    tableHeaderRow.appendChild(tableHeader);
    tableHeader.innerText=" # ";
    tableHeader.style.border="1px solid darkgray";
    tableHeader.style.background="#ddd";
    tableHeader.style.padding="10px";

    for(var i=1;i<col+1;i++){
        var cell1 = tableHeaderRow.insertCell();
        cell1.style.border="1px solid darkgray";
        cell1.style.background="#ddd";
        cell1.style.height="40px";
        cell1.id="column_th"+i;
        cell1.innerHTML="<button id='col_big"+i+"' style='width:100%;background-color:#ddd;border:none' oncontextmenu = 'rightClick(event,"+i+",3)' > "+i+" </button>"+
        "<div id='col"+i+"' class='context-menu' style='display:none'><ul>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction3(1,"+sid+",0,"+i+","+row+","+col+")'>Cut</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction3(2,"+sid+",0,"+i+","+row+","+col+")'>Copy</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction3(3,"+sid+",0,"+i+","+row+","+col+")'>Paste</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction3(4,"+sid+",0,"+i+","+row+","+col+")'>Delete</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction3(5,"+sid+",0,"+i+","+row+","+col+")'>Add column to right</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction3(6,"+sid+",0,"+i+","+row+","+col+")'>Add column to left</a></li>";
    }
    
}


function create_table_sheet(sid,arr,row,col){
    var table = document.getElementById("myTable");
    for(var j=0;j<row;j++){
        tableHeaderRow = document.createElement("tr");
        table.appendChild(tableHeaderRow);
        tableHeaderRow.id="row_tr"+(j+1);
        var tableHeader = document.createElement("th");
        tableHeaderRow.appendChild(tableHeader);
        tableHeader.id="row_th"+(j+1);
        tableHeader.style.background="#ddd";
        tableHeader.style.border="1px solid darkgray";
        tableHeader.innerHTML = "<button id='row_big"+(j+1)+"' style='width:100%;background-color:#ddd;border:none;padding-left:15px;padding-right:15px' oncontextmenu = 'rightClick(event,"+(j+1)+",4)' > "+(j+1)+" </button>"+
        "<div id='row"+(j+1)+"' class='context-menu' style='display:none'><ul>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction4(1,"+sid+",0,"+(j+1)+","+row+","+col+")'>Cut</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction4(2,"+sid+",0,"+(j+1)+","+row+","+col+")'>Copy</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction4(3,"+sid+",0,"+(j+1)+","+row+","+col+")'>Paste</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction4(4,"+sid+",0,"+(j+1)+","+row+","+col+")'>Delete</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction4(5,"+sid+",0,"+(j+1)+","+row+","+col+")'>Add row to down</a></li>"+
        "<li><a href='#'  style='font-weight:200' onclick='return theFunction4(6,"+sid+",0,"+(j+1)+","+row+","+col+")'>Add row to up</a></li>"+
        "</ul></div>";
        tableHeaderRow.style.height="40px";
        for(var i=0;i<col;i++){
            var cell1 = tableHeaderRow.insertCell();
            var data_of_cell=null,cid_cell=0;
            cell1.id="td"+(j+1)+(i+1);
            if(arr!=0){
                for(var k=0;k<arr.length;k++){
                    if(j+1==arr[k][1] && i+1==arr[k][2]){
                        data_of_cell=arr[k][3];
                        cid_cell=arr[k][0];
                    }
                }
            }
            if(data_of_cell==null){
                cell1.innerHTML="<input type='text' id='value"+(j+1)+(i+1)+sid+"'  oncontextmenu = 'rightClick(event,"+(j+1)+(i+1)+sid+",1)' onkeyup='save_cell("+(j+1)+","+(i+1)+","+0+","+sid+")' value='' style='border:none;outline:none;'/><input type='hidden' value='0' id='cid"+(j+1)+(i+1)+sid+"'/> <div id='"+(j+1)+(i+1)+sid+"' class='context-menu' style='display:none'><ul><li><a href='#'  style='font-weight:200' onclick='return theFunction(1,"+(j+1)+(i+1)+sid+",0,"+(j+1)+","+(i+1)+","+sid+");'>Cut</a></li><li><a href='#'  style='font-weight:200' onclick='return theFunction(2,"+(j+1)+(i+1)+sid+",0,"+(j+1)+","+(i+1)+","+sid+");'>Copy</a></li><li><a href='#'  style='font-weight:200' onclick='return theFunction(3,"+(j+1)+(i+1)+sid+",0,"+(j+1)+","+(i+1)+","+sid+");'>Paste</a></li></ul></div>";
            }else{
                cell1.innerHTML="<input type='text' id='value"+(j+1)+(i+1)+sid+"'  oncontextmenu = 'rightClick(event,"+(j+1)+(i+1)+sid+",1)'  onkeyup='save_cell("+(j+1)+","+(i+1)+","+cid_cell+","+sid+")' style='border:none;outline:none;' value='"+data_of_cell+"'/><input type='hidden' value='"+cid_cell+"' id='cid"+(j+1)+(i+1)+sid+"'/><div id='"+(j+1)+(i+1)+sid+"' class='context-menu' style='display:none'><ul><li><a href='#'  style='font-weight:200' onclick='return theFunction(1,"+(j+1)+(i+1)+sid+","+cid_cell+","+(j+1)+","+(i+1)+","+sid+");'>Cut</a></li><li><a href='#'  style='font-weight:200' onclick='return theFunction(2,"+(j+1)+(i+1)+sid+","+cid_cell+","+(j+1)+","+(i+1)+","+sid+");'>Copy</a></li><li><a href='#'  style='font-weight:200' onclick='return theFunction(3,"+(j+1)+(i+1)+sid+","+cid_cell+","+(j+1)+","+(i+1)+","+sid+");'>Paste</a></li></ul></div>";
            }
            cell1.setAttribute("contenteditable", "true");
            cell1.style.border="1px solid #ddd";
        }
    }
}
</script>    

</body>
</html>


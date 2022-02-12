<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>    
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
<?php 

include "db.php";
$conn=OpenCon();

?>
</head>
<body>

<h2>Excel Files</h2>

<table id="my_table">
  <thead>
    <tr>
        <th>File Name</th>
        <th>Create Date</th>
        <th>Transactions</th>
    </tr>
  </thead>  
  <tbody>
    <?php 
          $kayitKumesi = mysqli_query($conn, 'SELECT * FROM files ');
          while($satir = mysqli_fetch_assoc($kayitKumesi)){  
    ?> 
    <tr id="<?php echo $satir['fid']; ?>" >
        <td><?php echo $satir['file_name']; ?></td>
        <td><?php echo $satir['last_modified']; ?></td>
        <td><button onclick="open_file(<?php echo $satir['fid']; ?>)"  class="btn btn-info">Open</button>&nbsp;&nbsp;&nbsp;<button onclick="delete_file(<?php echo $satir['fid']; ?>)"  class="btn btn-info">Delete</button></td>
    </tr>
    <?php } ?>
  </tbod>
</table><br> <br>

<div>
<input type="text" id="fname" name="filename" placeholder="Enter file name..." style="width:50%">
<button onclick="add_file()"  class="btn btn-info">Add</button>
</div>

<script>

function add_file(){
    var today = new Date();
    var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    var data=document.getElementById('fname').value;
  
    var arr=new Array(data,date);
    $.ajax({
        type: "POST",
        url: "add_file.php",
        data: { arrr: arr },
        success: function(fid)
        {
            //alert("oldi");  
            var table = document.getElementById("my_table");
            var row = table.insertRow();
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            cell1.innerHTML = data;
            cell2.innerHTML = date;
            cell3.innerHTML = "<button onclick='open_file("+fid+")'  class='btn btn-info'>Open</button>&nbsp;&nbsp;&nbsp;<button onclick='delete_file("+fid+")'  class='btn btn-info'>Delete</button>";

            var boyut=document.getElementById("my_table").rows.length;
            document.getElementById("my_table").rows[boyut-1].id=fid;
        }
   });

}

function delete_file(fid){
  $.ajax({
        type: "POST",
        url: "delete_file.php",
        data: { fidd: fid },
        success: function()
        {
          var row = document.getElementById(fid);
	        row.parentElement.removeChild(row);
        }
   });
}

function open_file(fid){
  window.location = 'http://excel_six.test/excel.php?fid='+fid;
}

</script>    

</body>
</html>


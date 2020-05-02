    

<html>
<body>
<p style="text-align:right;"><a href="admin.php">Home</a></p>
<?php
include('templates/connection.php');
include('session.php');
$user_id =$_SESSION['userid'];
$document_list="SELECT title,doc_id,date FROM borrows , document where document_num = doc_id and returned =0 and reader_num =$user_id";
$result =mysqli_query($dbhandle,$document_list);
$documents ="<table style='width:100%'><tr><th>Title</th><th>ID</th><th>Borrow Date</th><th>Fine</th></tr>";
if(mysqli_num_rows($result)>0){
    while($row = $result->fetch_assoc()){
        $title = $row['title'];
        $id =$row['doc_id'];
        $date=$row['date'];
        $documents .="<tr><td>$title</td><td>$id</td><td>$date</td><td></td></tr>";
    }
    $documents .="</table>";
    echo $documents;
}else{echo "You didn't borrow any books!";}
?>
<style>
table, th, td {
  border: 1px solid black;
}
</style>

 </body>
 </html>

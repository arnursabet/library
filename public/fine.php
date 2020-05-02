    

<html>
<body>
<p style="text-align:right;"><a href="admin.php">Home</a></p>
<?php
include('templates/connection.php');
include('session.php');
$user_id =$_SESSION['userid'];
$document_list="SELECT title,doc_id,date FROM borrows , document where document_num = doc_id and returned =0 and reader_num =$user_id";
$result =mysqli_query($dbhandle,$document_list);
$documents ="<table style='width:80%;text-align:center;'><tr><th>Title</th><th>ID</th><th>Borrow Date</th><th>Fine</th></tr>";
$total = 0;
if(mysqli_num_rows($result)>0){
    while($row = $result->fetch_assoc()){
        $title = $row['title'];
        $id =$row['doc_id'];
        $date=$row['date'];
        $fine_query= mysqli_query($dbhandle,"SELECT DATEDIFF(CURDATE(),'$date') as days");
        while ($row = $fine_query->fetch_assoc()) {
    $fine = ($row['days'] -30) * 0.25 ;
    $total = $total +$fine ;
}
        
        
    $documents .="<tr><td>$title</td><td>$id</td><td>$date</td><td>$fine $</td></tr>";
    }
    $documents .="<tr><<td>Total Fine</td><td></td><td></td><td>$total$</td></tr></table>";
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

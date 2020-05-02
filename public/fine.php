
<?php
include('templates/connection.php');
include('session.php');
include("templates/header.php");
include("templates/navbar.php");
$user_id =$_SESSION['userid'];
$document_list="SELECT title,doc_id,date FROM borrows , document where document_num = doc_id and returned =0 and reader_num =$user_id";
$result =mysqli_query($dbhandle,$document_list);
$documents ="<table class='table'><tr><th>Title</th><th>ID</th><th>Borrow Date</th><th>Fine</th></tr>";
$total = 0;
if(mysqli_num_rows($result)>0){
    while($row = $result->fetch_assoc()){
        $title = $row['title'];
        $id =$row['doc_id'];
        $date=$row['date'];
        $fine_query= mysqli_query($dbhandle,"SELECT DATEDIFF(CURRENT_DATE ,'$date') as days");
        while ($row = $fine_query->fetch_assoc()) {
        if($row['days']>30){
    $fine = ($row['days'] -30) * 0.25 ;
    $total = $total +$fine ;}else{$fine=0;}
}
        
        
    $documents .="<tr><td>$title</td><td>$id</td><td>$date</td><td>$fine$</td></tr>";
    }
    $documents .="<tr><<td>Total Fine</td><td></td><td></td><td>$total$</td></tr></table>";
    echo $documents;
}else{echo "You didn't borrow any books!";}
?>



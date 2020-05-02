<?php

include("admin.php");   

$date_list= "select date from borrows where returned =0";
$result =mysqli_query($dbhandle,$date_list);
$total = 0;
if(mysqli_num_rows($result)>0){
    while($row = $result->fetch_assoc()){
        $date = $row['date'];
        $fine_query= mysqli_query($dbhandle,"SELECT DATEDIFF(CURDATE(),'$date') as days");
        while ($row = $fine_query->fetch_assoc()) {
        if($row['days']>30){
    $fine = ($row['days'] -30) * 0.25 ;
    $total = $total +$fine ;}else{$fine=0;}
}
        
    } $avg = $total / mysqli_num_rows(mysqli_query($dbhandle,"select * from reader"));
    $avg=round($avg,2);
    echo"The average fine paid by a reader is $avg $"  ;
}else{echo "No documents are currently borrowed";}

?>
<body><br>


 </body>
 </html>

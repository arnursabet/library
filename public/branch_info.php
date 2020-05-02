<html>
<body>

<?php

include('templates/connection.php');
include("session.php");
include("templates/header.php");
include("templates/navbar.php");
$branch_list="SELECT * FROM branch ORDER BY name ";
$result =mysqli_query($dbhandle,$branch_list);
$branches ="<table class='table'><tr><th>Branch Name</th><th>ID</th></tr>";
if(mysqli_num_rows($result)>0){
    while($row = $result->fetch_assoc()){
        $name = $row['name'];
        $num =$row['branch_id'];
        $branches .="<tr><td>$name</td><td>$num</td></tr>";
    }
    $branches .="</table>";
    echo $branches;
}else{echo "No branches found in db!";}
?>
<style>
table, th, td {
  border: 1px solid black;
}
</style>

 </body>
 </html>

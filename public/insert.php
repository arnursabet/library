<?php

include("templates/connection.php"); 
$tbl_name="User"; 

$fname=$_POST['fname']; 
$lname=$_POST['lname']; 
$username=$_POST['username']; 
$password=$_POST['password']; 
$usertype = $_POST['usertype']; 

$result = mysqli_query($dbhandle, "INSERT INTO $tbl_name (fname, lname, username, password, usertype) VALUES ('$fname','$lname','$username','$password','$usertype')");


if($result===TRUE)
{
echo "<script>alert('User Account has been saved in the database.');
      window.location='index.php';
      </script>";
}      
else
{
  echo"The query did not run";
} 
mysqli_close($result);


?>

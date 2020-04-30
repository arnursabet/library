<?php

include("templates/connection.php"); 
include("session.php");
$tbl_name="user"; 

$fname=$_POST['fname']; 
$lname=$_POST['lname']; 
$username=$_POST['username']; 
$password=$_POST['password']; 
$usertype = $_POST['usertype']; 

$query = "SELECT * FROM $tbl_name WHERE username='$username'";
$result1 = mysqli_query($dbhandle, $query);
$count = mysqli_num_rows($result1);

if ($count>0) {
echo '<script>alert("The username entered already exists.");
          window.location="signup.php";
          </script>';
} else {
    
    $result = mysqli_query($dbhandle, "INSERT INTO $tbl_name (fname, lname, username, password, usertype) VALUES ('$fname','$lname','$username','$password','$usertype')");
    if($result===TRUE) {
    echo "<script>alert('User Account has been saved in the database.');
          window.location='admin.php';
          </script>";
    } else {
    echo"The query did not run";
  } 
  mysqli_close($result);
}

?>

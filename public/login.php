<?php 
  include "templates/header.php"; 
  require("session.php")
?>

<?php
include("templates/connection.php"); 
$tbl_name="user"; 

$username=$_POST['username']; 
$password=$_POST['password']; 

$username = stripslashes($username);
$password = stripslashes($password);
$username = mysqli_real_escape_string($dbhandle,$username);
$password = mysqli_real_escape_string($dbhandle,$password);

$result = mysqli_query($dbhandle, "SELECT * FROM $tbl_name WHERE username='$username' AND password='$password'");

if(mysqli_num_rows($result) != 1){
      echo "<script>alert(' Wrong Username or Password Access Denied !!! Try Again');
      window.location='index.php';
      </script>";
     }else{
      $row = mysqli_fetch_assoc($result);
      session_start();
      $_SESSION['username'] = $row['username'];
      $_SESSION['fullname'] = $row['fname'] . " " . $row['lname'];
      $_SESSION['userid'] = $row['user_id'];

      if($row['usertype'] == "admin"){
       
       header('location: admin.php');
      }else if($row['usertype'] == "reader"){
       header("Location: reader.php");
      }
      else{
       echo "<script>alert('Wrong Username or Password Access Denied !!! Try Again');
      window.location='index.php';
      </script>";
      }
     }
     $dbhandle->close();

?>

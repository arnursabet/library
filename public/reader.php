<?php 
  include("session.php");
?>

<html>
  <head>
    <title> Reader Page </title>
 <head>
  <style>
    body {
    font-family:arial;
    background-color : yellow;
    color:blue;
    };
 </style>

 <?php 
    if(isset($_SESSION['username']) && $_SESSION['username'] != "") {
      echo $_SESSION["fullname"];
        echo "<br>";
    }
 
 ?>
<body><br>
 <h1 align="center">
  Welcome To Reader Page 
  </h1>
  <nav class="navbar bg-light">

<!-- Links -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="search.php">Search</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="checkout.php">Document Checkout</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="return.php">Document Return</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="reserve.php">Document Reserve</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="fine.php">Compute fine</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="reserved.php">Reserved documents</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="reserve.php">Document Reserve</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="publisher.php">Document's by publisher'</a>
  </li>
</ul>

</nav>

<a href="logout.php">Log out</a>
 </body>
 </html>
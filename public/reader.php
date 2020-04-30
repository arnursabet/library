<?php 
  include("session.php");
  include("templates/header.php");
?>

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
    <a class="nav-link" href="by_publisher.php">Document's by publisher'</a>
  </li>
</ul>

</nav>

<a href="logout.php">Log out</a>
 </body>
 </html>
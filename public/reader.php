<?php 
  include("session.php");
  include("templates/header.php");
  include("templates/navbar.php");

  if($_SESSION["usertype"]!="reader") {
          echo '<div class="alert alert-danger alert-dismissible" id="PresenceError">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Oops!</strong> You are not supposed to be here! <br>
                  <a href="index.php">Login</a> to continue.
                </div>'; 
    }  else {
?>

<body>
 
<nav class="navbar bg-light">
<!-- Links -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="search.php">Search</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="search.php">Document Checkout</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="search.php">Document Return</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="fine.php">Compute fine</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="by_publisher.php">Document's by publisher</a>
  </li>
</ul>

</nav>
    <?php } 
    include("templates/footer.php");
    
    ?>
<?php
include("session.php");
include("templates/header.php");
include("templates/navbar.php");

if($_SESSION["usertype"]!="admin") {
  echo '<div class="alert alert-danger alert-dismissible" id="PresenceError">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Oops!</strong> You are not supposed to be here! <br>
          <a href="index.php">Login</a> to continue.
        </div>'; 
}  else {
?>
<body><br>

<nav class="navbar bg-light">
<!-- Links -->
<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="insert_doc.php">Add a document</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="admin_search.php">Search document and check status</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="signup.php">Add new reader or admin</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="branch_info.php">Print branch information</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="10_borrowers.php">Print top 10 most frequent borrowers</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="10_borrowed.php">Print top 10 most borrowed books</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="10_popular.php">Print the 10 most popular books</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="average_fine.php">Find the average fine paid per reader</a>
  </li>
</ul>

</nav>
<?php } 
include("templates/footer.php");

?>


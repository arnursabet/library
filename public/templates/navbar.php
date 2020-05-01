<?php 
    
    if(isset($_SESSION["username"]) && $_SESSION["username"]!="") {
      $full_name = $_SESSION["fullname"];
    } else { 
    
          echo '<div class="alert alert-danger alert-dismissible" id="PresenceError">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Oops!</strong> You are not supposed to be here! <br>
                  <a href="index.php">Login</a> to continue.
                </div>'; 
    }  
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="reader.php">Library</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" >
    <ul class="navbar-nav" id="main-navbar">
      <li class="nav-item">
        <a class="nav-link" href="reader.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="search.php">Search</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item">
        <a class="nav-link" href="reader.php"><?php echo $full_name?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Log out</span></a>
      </li>
    </ul>
  </div>
</nav>
<script>
$('#main-navbar').dynamicMenu();
</script>
<br><br>
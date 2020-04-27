<?php 
  include("templates/connection.php");
  include("session.php");
?>
<?php
    //Set Session Variables
    session_start();
    
            //echo "Connected successfully<br>";

    $userid = $_SESSION["uname"]; 
    $isbn = $_GET["isbn"];
    $date = date("Y-m-d");
    //Create the SQL query
  
    $sql = "insert into borrow (reader_num, document_num, date) values";
    $sql = $sql. "('$userid','$isbn','$date')";
            //echo $sql;
	       	//Run the query
	  $result = $conn->query($sql);

    $sql = "";
    //Create the SQL query
    $sql = "update book set available=0 where ";
    $sql = $sql. "isbn = '$isbn'";
    //echo $sql;
	  //Run the query
	  $result = $conn->query($sql);
     
      echo "<br>Successfully borrowed book";
    $conn->close();
    

    
  
?>
<br>
<a href="logout.php">Sign Out</a>
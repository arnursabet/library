<?php
     include("templates/connection.php");
     include("session.php");

     if(isset($_SESSION["username"]) && $_SESSION["username"]!="") {
        echo $_SESSION["fullname"];
        echo "<br>";
?>
<br><br>
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Publisher: <input type="text" name="publisher"/>
    <br><br>
    <input type="submit" name="submit" value="Search"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value="Clear"/>
    <br><br>
</form>
<?php
if (isset($_GET['submit'])) {

  $tbl_name="document"; 
  $publisher = $_GET['publisher'];
  
  $publisher = stripslashes($publisher);

  $publisher = mysqli_real_escape_string($dbhandle,$publisher);
  
  $sql = "SELECT * FROM $tbl_name WHERE";
  $condition =  " publisher like '%$publisher%'";
  $sql .= $condition;
  $result = mysqli_query($dbhandle, $sql);

  if(mysqli_num_rows($result) == 0){
        echo "<h2>Nothing found</h2>";
  }else{ 
        echo '<table>';
        echo '<th>Document ID</th>';
      echo '<th>Title</th>';
      echo '<th>Type</th>';

        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
    
            echo '<td>'. $row['doc_id'].'</td>';
            echo '<td>'. $row['title'].'</td>';
            echo '<td>'. $row['doc_type'].'</td>';
          echo '</tr> ';
          
        } 
        echo '</tbody>';
        echo '</table>';
        $result->free();
       }
       $dbhandle->close();
  

}

?>

<?php
    } else {
            echo "You are not supposed to be here!<br>";
            echo "<a href='index.php'>Login</a> to continue.";
        }
 ?>           
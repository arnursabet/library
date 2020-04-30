<?php
     include("templates/connection.php");
     include("session.php");

     if(isset($_SESSION["username"]) && $_SESSION["username"]!="") {
        echo $_SESSION["fullname"];
        echo "<br>";
?>
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Document ID:  <input type="text" name="docid"/>
	  <br><br>
    Title: <input type="text" name="title"/>
    <br><br>
    Publisher: <input type="text" name="publisher"/>
    <br><br>
    <input type="submit" name="submit" value="Search"/>&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="reset" value="Clear"/>
    <br><br>
</form>
<?php
if (isset($_GET['submit'])) {

  $tbl_name="document"; 
  $docid = $_GET['docid']; 
  $title = $_GET['title']; 
  $publisher = $_GET['publisher'];
  
  $docid = stripslashes($docid);
  $title = stripslashes($title);
  $publisher = stripslashes($publisher);
  $docid = mysqli_real_escape_string($dbhandle,$docid);
  $title = mysqli_real_escape_string($dbhandle,$title);
  $publisher = mysqli_real_escape_string($dbhandle,$publisher);
  
  $sql = "SELECT * FROM $tbl_name";
  $condition = ($docid == '' && $title == '' && $publisher == '') ? '' : ' where ';
  $condition .= ($docid=='') ? "" : "doc_id = '$docid' ";
  $condition .= ($docid!='') ? (($publisher!='' || $title!='') ? "or" : "") : "";
  $condition .= ($title=='') ? "" : " title like '%$title%' ";
  $condition .= ($docid!='') ? (($publisher!='') ? "or" : "") : (($title!='') ? (($publisher!='') ? "or" : "") : "");
  $condition .= ($publisher=='') ? "" : " publisher like '%$publisher%' "; 
  
  $sql .= $condition;
  echo $sql;
  $result = mysqli_query($dbhandle, $sql);

  if(mysqli_num_rows($result) == 0){
        echo "<h2>Nothing found</h2>";
  }else{ 
        echo '<table>';
        echo '<th>Creator</th>';
        echo '<th>Document ID</th>';
        echo '<th>Title</th>';
        echo '<th>Publisher</th>';
        echo '<th>Quantity</th>';
        echo '<th>Type</th>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
          echo '<tr>';
          $document_id = (int) $row['doc_id'];
            if ($row['doc_type'] == 'book'){
              $book = mysqli_query($dbhandle, "select author from book where ISBN = $document_id");
              $row1 = $book -> fetch_assoc();
              //echo $row1;
              echo '<td>'. $row1['author'].'</td>';
              $book -> free();
            }
            else if($row['doc_type'] == 'journal'){
              $journal = mysqli_query($dbhandle, "select editor from journal where journal_id = $document_id");
              $row2 = $journal -> fetch_assoc();
              echo '<td>'. $row2['editor'].'</td>';
              $journal -> free();
            } else {
              $dvd = mysqli_query($dbhandle, "select director from dvd where DVD_id = $document_id");
              $row3 = $dvd -> fetch_assoc();
              echo '<td>'. $row3['director'].'</td>';
              $dvd -> free();
            }
            echo '<td>'. $row['doc_id'].'</td>';
            echo '<td>'. $row['title'].'</td>';
            echo '<td>'. $row['publisher'].'</td>';
            echo '<td>'. $row['quantity'].'</td>';
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
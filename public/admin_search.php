<?php
     include("templates/connection.php");
     include("session.php");

     if(isset($_SESSION["username"]) && $_SESSION["username"]!="") {
        echo "";
        echo "<br>";
?>
<h2>admin search and statues checker</h2>
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
  
  $sql = "SELECT * FROM $tbl_name WHERE ";
  $condition = "";
  $condition .= ($docid=='') ? "" : "doc_id like '%$docid%' ";
  $condition .= ($docid=='') ? "" : "or";
  $condition .= ($title=='') ? "" : " title like '%$title%' ";
  $condition .= ($docid!='') ? (($publisher!='') ? "or" : "") : (($title!='') ? (($publisher!='') ? "or" : "") : "");
  $condition .= ($publisher=='') ? "" : " publisher like '%$publisher%' "; 
  
  $sql .= $condition;
  
  $result = mysqli_query($dbhandle, $sql);
  
  if(mysqli_num_rows($result) == 0){
        echo "<h2>Nothing found</h2>";
  }else{ 
        while ($row = $result->fetch_assoc()) {
        $doc_id=$row['doc_id'];
        $quantity=$row['quantity'];
        $branch_num=$row['branch_num'];
        $avilable= $quantity-(mysqli_num_rows(mysqli_query($dbhandle,"SELECT * from document , borrows where document.doc_id = document_num and doc_id=$doc_id and document.branch_num = borrows.branch_num =$branch_num and returned =0")));
                                    
        print_r($row);
        print_r("The number of avilble copies is $avilable ");
          
        } 
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
<?php
include('templates/connection.php');
include("session.php");
include("templates/header.php");
include("templates/navbar.php");

     if(isset($_SESSION["username"]) && $_SESSION["username"]!="") {
       
?>
<div class="container">
<form method="get" class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="form-group">
    <label><strong>Document ID</strong></label> 
    <input type="text" class="form-control" name="docid" placeholder="ISBN, DVD ID or Journal ID"/>
  </div>
  <div class="form-group">
	  <label><strong>Title</strong></label>
    <input type="text" class="form-control" name="title" placeholder="Title"/>
  </div>
  <div class="form-group">
    <label><strong>Publisher</strong></label>
    <input type="text" class="form-control" name="publisher" placeholder="Publisher"/>
  </div>
    <input class="btn btn-primary"type="submit" name="submit" value="Search"/>
    <input class="btn btn-secondary"type="reset" value="Clear"/>
</form>
</div>
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
  
  $result = mysqli_query($dbhandle, $sql);
  
  if(mysqli_num_rows($result) == 0){
        echo "<h2>Nothing found</h2>";
  }else{    ?>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Creator</th>
                <th>Document ID</th>
                <th>Title</th>
                <th>Publisher</th>
                <th>Quantity</th>
                <th>Type</th>
                <th>Avilable copies</th>
              </tr>
            </thead>
        <tbody>
        <?php
        while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        $doc_id=(int) $row['doc_id'];
        $quantity=$row['quantity'];
        $branch_num=$row['branch_num'];
        $avilable= $quantity-(mysqli_num_rows(mysqli_query($dbhandle,"SELECT * from document , borrows where document.doc_id = document_num and doc_id=$doc_id and document.branch_num = borrows.branch_num =$branch_num and returned =0")));
        
        if ($row['doc_type'] == 'book'){
              $book = mysqli_query($dbhandle, "select author from book where ISBN = $doc_id") or die($dbhandle->error);
              $row1 = $book -> fetch_assoc();
              //echo $row1;
              echo '<td>'. $row1['author'].'</td>';
              $book -> free();
            }
            else if($row['doc_type'] == 'journal'){
              $journal = mysqli_query($dbhandle, "select editor from journal where journal_id = $doc_id") or die($dbhandle->error);
              $row2 = $journal -> fetch_assoc();
              echo '<td>'. $row2['editor'].'</td>';
              $journal -> free();
            } else {
              $dvd = mysqli_query($dbhandle, "select director from dvd where DVD_id = $doc_id") or die($dbhandle->error);
              $row3 = $dvd -> fetch_assoc();
              echo '<td>'. $row3['director'].'</td>';
              $dvd -> free();}
            
            echo '<td>'. $row['doc_id'].'</td>';
            echo '<td>'. $row['title'].'</td>';
            echo '<td>'. $row['publisher'].'</td>';
            echo '<td>'. $row['quantity'].'</td>';
            echo '<td>'. $row['doc_type'].'</td>';
            echo '<td>'. $avilable.'</td>';

          
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
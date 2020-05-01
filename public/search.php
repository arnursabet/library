<?php
     include("templates/connection.php");
     include("session.php");
     include("templates/header.php");
     include("templates/navbar.php");
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
<?php
$username = $_SESSION["username"];
$user_id_query = mysqli_query($dbhandle, "select user_id from user where username = '$username'") or die($dbhandle->error);
$user_id = $user_id_query -> fetch_assoc();
$_SESSION['user_id'] = $user_id["user_id"];

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

  $result = mysqli_query($dbhandle, $sql) or die($dbhandle->error);

  if(mysqli_num_rows($result) == 0){
        echo "<h2>Nothing found</h2>";
  }else{ 
        ?>
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
                <th>Action</th>
              </tr>
            </thead>
        <tbody>
        <?php
        
        while ($row = $result->fetch_assoc()) {
          echo '<tr>';
          $document_id = (int) $row['doc_id'];
            if ($row['doc_type'] == 'book'){
              $book = mysqli_query($dbhandle, "select author from book where ISBN = $document_id") or die($dbhandle->error);
              $row1 = $book -> fetch_assoc();
              //echo $row1;
              echo '<td>'. $row1['author'].'</td>';
              $book -> free();
            }
            else if($row['doc_type'] == 'journal'){
              $journal = mysqli_query($dbhandle, "select editor from journal where journal_id = $document_id") or die($dbhandle->error);
              $row2 = $journal -> fetch_assoc();
              echo '<td>'. $row2['editor'].'</td>';
              $journal -> free();
            } else {
              $dvd = mysqli_query($dbhandle, "select director from dvd where DVD_id = $document_id") or die($dbhandle->error);
              $row3 = $dvd -> fetch_assoc();
              echo '<td>'. $row3['director'].'</td>';
              $dvd -> free();
            }
            echo '<td>'. $row['doc_id'].'</td>';
            echo '<td>'. $row['title'].'</td>';
            echo '<td>'. $row['publisher'].'</td>';
            echo '<td>'. $row['quantity'].'</td>';
            echo '<td>'. $row['doc_type'].'</td>';

            
            $docnum = $row['doc_id'];
            $user_id = $_SESSION['user_id'];
            $borrows_query = mysqli_query($dbhandle, "select document_num, returned, branch_num from borrows where reader_num = $user_id and document_num = $docnum") or die($dbhandle->error);
            $borrows = $borrows_query -> fetch_assoc();
            
            if(mysqli_num_rows($borrows_query) == 0){ 
              $branchnum = $row['branch_num']; 
              ?>
              <td>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <input name="docid" type="hidden" value="<?php echo $docnum;?>">
                  <input name="branchnum" type="hidden" value="<?php echo $branchnum;?>">
                  <input type="submit" class="btn btn-success" name="borrow" value="Borrow">
                </form>
              </td>
            <?php }
            
            else {
              $branchnum = $borrows['branch_num'];
              $docnum = $borrows['document_num'];
              if($borrows['returned']==1) { ?>
               <td>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <input name="docid" type="hidden" value="<?php echo $docnum;?>">
                  <input name="branchnum" type="hidden" value="<?php echo $branchnum;?>">
                  <input type="submit" class="btn btn-warning" name="borrow" value="Borrow Again">
                </form>
              </td>
              <?php }
              else { ?>
                <td>
                  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <input name="docid" type="hidden" value="<?php echo $docnum;?>">
                    <input name="branchnum" type="hidden" value="<?php echo $branchnum;?>">
                    <input type="submit" class="btn btn-danger" name="return" value="Return">
                  </form>
                </td>
              <?php }
            } ?>
            
          </tr>
          
        <?php } ?>
        
                </tbody>
              </table>
            </div>
          </div>
        </form>
        </div>
        <?php 
        $result->free();
       }
       
       
       $dbhandle->close();
       

}
function borrow() {
  include('templates/connection.php');
  $user_id = $_SESSION['user_id'];
  $doc_id = $_POST["docid"];
  $branch_num = $_POST["branchnum"];
  $date = date("Y-m-d");
  //Create the SQL query
  $borrows_query = mysqli_query($dbhandle, "select document_num, returned, branch_num from borrows where reader_num = '$user_id' and document_num = '$doc_id'") or die($dbhandle->error);
  $borrows = $borrows_query -> fetch_assoc();
            
  if(mysqli_num_rows($borrows_query) == 0){ 
    $sql = "insert into borrows(reader_num, branch_num, document_num, date, returned) values";
    $sql .= "('$user_id', '$branch_num', '$doc_id', '$date', 0)";     
    $result = mysqli_query($dbhandle, $sql);
  } else {
      $sql = "update borrows set returned=0, date='$date' where ";
      $sql .= "reader_num='$user_id' and branch_num='$branch_num' and document_num='$doc_id'";     
      $result = mysqli_query($dbhandle, $sql);
  }
  $sql = "";
  //Create the SQL query
  $sql = "update document set n_reserved=n_reserved+1 where ";
  $sql = $sql. "doc_id = '$doc_id' and branch_num = '$branch_num'";
  
  $result = mysqli_query($dbhandle, $sql);

  $sql = "";
  $sql = "update reader set n_borrowed=n_borrowed+1 where ";
  $sql = $sql. "reader_id = $user_id";
  
  $result = mysqli_query($dbhandle, $sql);
  
  echo '<div class="container"><div class="alert alert-success alert-dismissible" id="borrowDocAlert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success!</strong> You borrowed the document.
        </div></div>
        <script>
        $(".close").click(function () {
          window.location="search.php?docid=&title=&publisher=&submit=Search";
        });
        </script>';
}
if(isset($_POST['docid']) && !isset($_POST['return'])){
  borrow();  
} 

function returnDoc() {
  include('templates/connection.php');
  $user_id = $_SESSION['user_id'];
  $doc_id = $_POST["docid"];
  $branch_num = $_POST["branchnum"];
  
  $sql = "update borrows set returned=1 where ";
  $sql .= "reader_num='$user_id' and branch_num='$branch_num' and document_num='$doc_id'";     
  $result = mysqli_query($dbhandle, $sql);

  $sql = "";
  $sql = "update document set n_reserved=n_reserved-1 where ";
  $sql = $sql. "doc_id = '$doc_id'";
  
  $result = mysqli_query($dbhandle, $sql);

  $sql = "";
  $sql = "update reader set n_borrowed=n_borrowed-1 where ";
  $sql = $sql. "reader_id = $user_id";
  
  $result = mysqli_query($dbhandle, $sql);
  
  echo '<div class="container"><div class="alert alert-success alert-dismissible" id="returnDocAlert">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>Success!</strong> You returned the document.
          </div></div>
        <script>
          $(".close").click(function () {
            window.location="search.php?docid=&title=&publisher=&submit=Search";
          });
        </script>';
}
if(isset($_POST['return'])){
  returnDoc();  
} 
?>
         



  

  
  
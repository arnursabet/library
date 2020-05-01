<?php
     include("templates/connection.php");
     include("session.php");
     include("templates/header.php");

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
                  <input type="submit" class="btn btn-success" name="borrow" value="Borrow Again">
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

  $sql = "insert into borrows(reader_num, branch_num, document_num, date, returned) values";
  $sql .= "('$user_id', '$branch_num', '$doc_id', '$date', 0)";
  echo $sql;      
  $result = mysqli_query($dbhandle, $sql);

  $sql = "";
  //Create the SQL query
  $sql = "update document set n_reserved=n_reserved+1 where ";
  $sql = $sql. "doc_id = '$doc_id'";
  
  $result = mysqli_query($dbhandle, $sql);

  $sql = "";
  $sql = "update reader set n_borrowed=n_borrowed+1 where ";
  $sql = $sql. "reader_id = $user_id";
  
  $result = mysqli_query($dbhandle, $sql);

  echo "<br>Successfully borrowed book";
}
if(isset($_POST['docid'])){
  borrow();
  
} 
?>

<?php
    } else {
            echo "You are not supposed to be here!<br>";
            echo "<a href='index.php'>Login</a> to continue.";
        }
 ?>           
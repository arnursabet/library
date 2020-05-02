<?php 

include('templates/connection.php');
include("session.php");
include("templates/header.php");
include("templates/navbar.php");

     if(isset($_SESSION["username"]) && $_SESSION["username"]!=""){

if(isset($_POST['doctype']) && isset($_POST['title']) && isset($_POST['id']) && isset($_POST['author']) && isset($_POST['quantity']) && isset($_POST['branch']) && isset($_POST['publisher']) ){
$tbl_name=$_POST['doctype'];
$title=$_POST['title'];
$id=$_POST['id'];
$author=$_POST['author'];
$quantity=$_POST['quantity'];
$branch=$_POST['branch'];
$publisher=$_POST['publisher'];
if(isset($_POST['volume'])){    
    $volume=$_POST['volume'];}
    
$sql_fetch_id="SELECT doc_id FROM document WHERE doc_id =$id";

$query_id=mysqli_query($dbhandle,$sql_fetch_id);

if(mysqli_num_rows($query_id)){
    mysqli_query($dbhandle,"UPDATE document"." SET quantity = (quantity+$quantity)"."WHERE doc_id = $id");
    echo "The quantity has been updated successfully." ;
    
    switch($tbl_name){
        case 'journal':
            $query_id=mysqli_query($dbhandle,"SELECT * FROM $tbl_name WHERE journal_id =$id");
            if(mysqli_num_rows($query_id)){break;}else{
            mysqli_query($dbhandle,"INSERT INTO $tbl_name VALUES ('$title','$id','$author','$volume')");
            break;
            }
        case 'dvd':
            $query_id=mysqli_query($dbhandle,"SELECT * FROM $tbl_name WHERE DVD_id =$id");
            if(mysqli_num_rows($query_id)){break;}else{
            mysqli_query($dbhandle,"INSERT INTO $tbl_name VALUES ('$title','$id','$author')");
            break;
            }
        case 'book':
            $query_id=mysqli_query($dbhandle,"SELECT * FROM $tbl_name WHERE ISBN =$id");
            if(mysqli_num_rows($query_id)){break;}else{
            mysqli_query($dbhandle,"INSERT INTO $tbl_name VALUES ('$title','$id','$author')");
            break;
            }
        
    }

    
}else{
    //how to insert in doc if there is no pub?
    $result = mysqli_query($dbhandle,"INSERT INTO document (doc_id,quantity,publisher,title,branch_num,doc_type) VALUES ('$id','$quantity','$publisher','$title','$branch','$tbl_name')");
    
      if($result===TRUE) {
          //if here to spreate if the boi is jounral and add volume 
    if($tbl_name != 'journal'){
    $result2 = mysqli_query($dbhandle,"INSERT INTO $tbl_name VALUES ('$title','$id','$author')");}
        else{
    $result2 = mysqli_query($dbhandle,"INSERT INTO $tbl_name VALUES ('$title','$id','$author','$volume')");
    }
    
    if($result2===TRUE){
        echo "<script>alert('Document has been added to the database');
          </script>";
    }else{echo"error has occurred";}
    } else {
    echo"filling all fields is required";
  } 
   
    }
}
    


?>

<html>
    <body>
       <div class="container">
           <div class="form-group">
        
            <form action="insert_doc.php" method="post" class="form">
            <select id="doctype" onchange="cahngefields()" name="doctype"> 
                <option value="book">Book</option>
                <option value="dvd">DVD</option>
                <option value="journal">Journal</option>
        </select>
                <input type="text" name="title" value = "" placeholder ="Title" id="title_box">
                <input type="text" name="id" value = "" placeholder ="ISBN" id="sec_box">
                <input type="text" name="author" value = "" placeholder ="Author" id="thir_box">
                <input type="text" name="quantity" value = "" placeholder ="Quantity" >
                <input type="text" name="publisher" value = "" placeholder ="Publisher" >
                <input type="text" name="branch" value = "" placeholder ="Branch Num" >
                <input type="text" name="volume" value = "" placeholder ="Volume Num" id="volume" hidden>
                <input class="btn btn-primary" type="submit" name="submit" value="Add"/>
                </div> </div>        
                <script>
function cahngefields() {
  var x = document.getElementById("doctype").value;
 switch (x){
     case "dvd":
         document.getElementById("sec_box").placeholder="ID";
         document.getElementById("thir_box").placeholder="Director";
         document.getElementById("volume").hidden= true; 
         
         break;
     case "book":
         document.getElementById("sec_box").placeholder="ISBN";
         document.getElementById("volume").hidden= true; 
         document.getElementById("thir_box").placeholder="Author";
         
         break;
    case "journal":
         document.getElementById("sec_box").placeholder="ID";
         document.getElementById("thir_box").placeholder="Editor";
         document.getElementById("volume").hidden= false;         
         break;
 }
}
</script>
                    
                    
        </form>
                
    </body>

</html>
<?php
    } else {
            echo "You are not supposed to be here!<br>";
            echo "<a href='index.php'>Login</a> to continue.";
        }
 ?>     
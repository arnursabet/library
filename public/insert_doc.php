<?php 

include('templates/connection.php'); 
include("templates/header.php"); 
$tbl_name=$_POST['doctype'];
$title=$_POST['title'];
$id=$_POST['id'];
$author=$_POST['author'];
$quantity=$_POST['quantity'];
$branch=$_POST['branch'];
$publisher=$_POST['publisher'];

$sql_fetch_id="SELECT doc_id FROM document WHERE doc_id =$id";

$query_id=mysqli_query($dbhandle,$sql_fetch_id);

if(mysqli_num_rows($query_id)){
    mysqli_query($dbhandle,"UPDATE document"." SET quantity = (quantity+$quantity)"."WHERE doc_id = $id");
}else{
    //how to insert in doc if there is no pub?
    $result = mysqli_query($dbhandle,"INSERT INTO document (doc_id,quantity,publisher,title,branch_num,doc_type) VALUES ('$id','$quantity','$publisher','$title','$branch','$tbl_name')");
   
    }

    


?>

<html>
 <?php include("templates/header.php"); ?>
    <body>
       
            <form action="insert_doc.php" method="post">
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
                <input type="submit" name="submit" value="Add">
        
                <script>
function cahngefields() {
  var x = document.getElementById("doctype").value;
 switch (x){
     case "dvd":
         document.getElementById("sec_box").placeholder="ID";
         document.getElementById("thir_box").placeholder="Director";
         
         break;
     case "book":
         document.getElementById("sec_box").placeholder="ISBN";
         
         document.getElementById("thir_box").placeholder="Author";
         
         break;
    case "journal":
         document.getElementById("sec_box").placeholder="ID";
         
         document.getElementById("thir_box").placeholder="Editor";
         
         break;
 }
}
</script>
                    
                    
        </form>
                
    </body>

</html>
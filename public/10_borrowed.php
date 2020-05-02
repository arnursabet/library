<?php
include('templates/connection.php');
include("session.php");
include("templates/header.php");
include("templates/navbar.php");
?>
<body><br>
	<form action ='#' method='POST'>
		<select name="branch_num"> 
			<option value=0></option>
			<option value=1>Branch 1</option>
			<option value=2>Branch 2</option>
		</select>
		<input type="submit" name="submit" value="Submit Branch Number" />
	</form>
<br>
<?php
	if (!empty($_POST['branch_num'])) {
                    $branch = $_POST['branch_num'];
                } else {
                    $branch = 0;
                }
 
	$sql = "SELECT `document_num`, COUNT(*) FROM `borrows` WHERE `returned` = 0 GROUP BY `document_num` LIMIT 10";
	
	$top_title = mysqli_query($dbhandle, $sql);
	
	
	if($branch!=0)
	{
	echo "Top Ten Most Borrowed Books Right Now in Branch $branch";
	echo "<br>";
	$count=1;
	while($top_doc = $top_title->fetch_assoc())
	{
		$doc = $top_doc['document_num'];
		$title_query = "SELECT * FROM `document` ";
		$title_query .= "WHERE `doc_id` =  $doc AND `branch_num` = $branch";
		
		$doc = mysqli_query($dbhandle, $title_query);
		while($doc_array = $doc->fetch_assoc())
		{
			echo $count,".", "   ", $doc_array['title'];
			echo "<br>";
			$count++;
		}
	}
	}
?>

 </body>
 </html>

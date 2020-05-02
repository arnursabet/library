<?php
include('templates/connection.php');
include("session.php");
include("templates/header.php");
include("templates/navbar.php");
?>
<body><br>
<?php
	$sql = "SELECT `document_num`, COUNT(*) FROM `borrows` GROUP BY `document_num` LIMIT 10";
	
	$top_title = mysqli_query($dbhandle, $sql);
	
	
	
	$doc_nums = array();
	echo "Top Ten Popular Books";
	echo "<br>";
	$count=1;
	while($top_doc = $top_title->fetch_assoc())
	{
		array_push($doc_nums, $top_doc['document_num']);
		$doc = $top_doc['document_num'];
		$title_query = "SELECT * FROM `document` ";
		$title_query .= "WHERE `doc_id` =  $doc";
		
		$doc = mysqli_query($dbhandle, $title_query);
		while($doc_array = $doc->fetch_assoc())
		{
			echo $count,".", "   ", $doc_array['title'];
			echo "<br>";
			$count++;
		}
	}
	
	

?>

 </body>
 </html>

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
 
	
	
	
	if($branch!=0)
	{
	$sql = "SELECT `reader_num`, COUNT(*) FROM `borrows` WHERE `document_num` IN ( 
		SELECT `doc_id` FROM `document` WHERE `branch_num` = $branch) GROUP BY `reader_num` LIMIT 10";
	
	$top_title = mysqli_query($dbhandle, $sql);
	
	echo "Top Ten Most Frequent Borrowers in Branch $branch";
	echo "<br>";
	$count=1;
	while($top_borrower = $top_title->fetch_assoc())
	{
		$reader_num = $top_borrower['reader_num'];
		$reader_query = "SELECT * FROM `reader` ";
		$reader_query .= "WHERE `reader_id` = $reader_num";
		
		$reader = mysqli_query($dbhandle, $reader_query);
		while($reader_array = $reader->fetch_assoc())
		{
			echo $count,".", "   ", $reader_array['fname'], $reader_array['lname'], "   ", "Number of books currently borrowed: ",$reader_array['n_borrowed'];
			echo "<br>";
			$count++;
		}
	}
	}
?>

 </body>
 </html>

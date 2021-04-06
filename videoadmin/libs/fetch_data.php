<?php 
function getcategories($id)
{
	require("conn.php");
	$sql = "SELECT name FROM video_categories  WHERE id = $id;";
	if ($result=mysqli_query($connect,$sql))
	{
      	//count number of rows in query result
		$rowcount=mysqli_num_rows($result);
      	//if no rows returned show no categories alert
		if ($rowcount==0) {
      		# code...
			echo 'No Categories';
		}
		//if there are rows available display all the results
		foreach ($result as $titles => $videoname) {
      	# code...
			echo ''.$videoname['name'].'';
		}
	}
	mysqli_close($connect);
} ?>

<?php 
function getblogtitle($id)
{
	require("conn.php");
	$sql = "SELECT title FROM blogs  WHERE id = $id;";
	if ($result=mysqli_query($connect,$sql))
	{
      	//count number of rows in query result
		$rowcount=mysqli_num_rows($result);
      	//if no rows returned show no categories alert
		if ($rowcount==0) {
      		# code...
			echo 'No Categories';
		}
		//if there are rows available display all the results
		foreach ($result as $titles => $videoname) {
      	# code...
			echo ''.$videoname['title'].'';
		}
	}
	mysqli_close($connect);
} ?>
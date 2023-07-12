<?php 
	include('connection.php');
	if (isset($_REQUEST['pid'])) {
		$Post_ID=$_REQUEST['pid'];
		
		// Disable foreign key check
		$disable_fk_check = "SET FOREIGN_KEY_CHECKS=0";
		mysqli_query($connect, $disable_fk_check);
		
		$Select="DELETE FROM posts WHERE Post_ID='$Post_ID'";
		$query=mysqli_query($connect, $Select);
		
		// Enable foreign key check
		$enable_fk_check = "SET FOREIGN_KEY_CHECKS=1";
		mysqli_query($connect, $enable_fk_check);
		
		if(!$query){
			echo "<script>alert(' Cannot Remove Current Idea')
			window.location='home.php'
			</script>";
		}
		else{
			echo "<script>alert('Idea was removed')
			window.location='home.php'
			</script>";
		}
	}
 ?>

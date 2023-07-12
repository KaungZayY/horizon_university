<?php 
	include('connection.php');
	session_start();

	if(!isset($_SESSION['User_ID']) || $_SESSION['Role_ID'] != "R-000001"){
  	echo "<script>window.alert('Login as QA Manager to Access this Page')</script>";
  	echo "<script>window.history.go(-1);</script>";
	}
	else{
		if (isset($_REQUEST['cid'])) {
		$Category_ID=$_REQUEST['cid'];
		$countQuery = "SELECT COUNT(*) FROM posts WHERE Category_ID = '$Category_ID'";
        $result = $connect->query($countQuery);
        // Get count value
        if ($result) {
            $countRow = mysqli_fetch_array($result);
            $uCount = $countRow[0];
        }

        if($uCount<=0){
        	 $Select="DELETE FROM categories WHERE Category_ID='$Category_ID'";
			$query=mysqli_query($connect, $Select);
		
			if(!$query){
				echo "<script>alert(' Cannot Remove Current Category')
				window.location='categories.php'
				</script>";
			}
			else{
					echo "<script>alert('Category was removed')
					window.location='categories.php'
					</script>";
				}
			}
		else{
				echo "<script>alert('Cannot Remove Category Yet')
					window.location='categories.php'
					</script>";
			}
       }
		
	}

	
 ?>


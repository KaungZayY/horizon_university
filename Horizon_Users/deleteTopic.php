<?php 
	include('connection.php');
	session_start();

	if(!isset($_SESSION['User_ID']) || $_SESSION['Role_ID'] != "R-000001"){
  	echo "<script>window.alert('Login as QA Manager to Access this Page')</script>";
  	echo "<script>window.history.go(-1);</script>";
	}
	else{
		if (isset($_REQUEST['tid'])) {
		$Topic_ID=$_REQUEST['tid'];
		$countQuery = "SELECT COUNT(*) FROM posts WHERE Tpoic_ID = '$Topic_ID'";
        $result = $connect->query($countQuery);
        // Get count value
        if ($result) {
            $countRow = mysqli_fetch_array($result);
            $uCount = $countRow[0];
        }

        if($uCount<=0){
        	 $Select="DELETE FROM topics WHERE Topic_ID='$Topic_ID'";
			$query=mysqli_query($connect, $Select);
		
			if(!$query){
				echo "<script>alert(' Cannot Remove Current Topic')
				window.location='topics.php'
				</script>";
			}
			else{
					echo "<script>alert('Topic was removed')
					window.location='topics.php'
					</script>";
				}
			}
		else{
				echo "<script>alert('Cannot Remove Topic Yet')
					window.location='topics.php'
					</script>";
			}
       }
		
	}

	
 ?>


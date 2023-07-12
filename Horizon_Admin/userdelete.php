<?php  
session_start();
include('connect.php');

$User_ID=$_GET['User_ID'];

$Delete="DELETE FROM users WHERE User_ID='$User_ID' ";
$ret=mysqli_query($connection,$Delete);

if($ret) 
{
	echo "<script>window.alert('User Successfully Deleted.')</script>";
	echo "<script>window.location='adminacc.php'</script>";
}
else
{
	echo "<p>Something went wrong" . mysqli_error($connection) . "</p>";
}
?>
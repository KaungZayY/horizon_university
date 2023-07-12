<?php  
session_start();
include('connect.php');

$Topic_ID=$_GET['Topic_ID'];

$Delete="DELETE FROM topics WHERE Topic_ID='$Topic_ID' ";
$ret=mysqli_query($connection,$Delete);

if($ret) 
{
	echo "<script>window.alert('Selected Topic Successfully Deleted.')</script>";
	echo "<script>window.location='admintopic.php'</script>";
}
else
{
	echo "<p>Something went wrong" . mysqli_error($connection) . "</p>";
}
?>
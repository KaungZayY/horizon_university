<?php
session_start();
include('connect.php');

$Post_ID = $_GET['Post_ID'];

$Delete = "DELETE FROM posts WHERE Post_ID='$Post_ID' ";
$ret = mysqli_query($connection, $Delete);

if ($ret) {
	echo "<script>window.alert('Post Successfully Deleted.')</script>";
	echo "<script>window.location='adminidea.php'</script>";
} else {
	echo "<p>Something went wrong" . mysqli_error($connection) . "</p>";
}
?>
<?php
session_start();
include('connect.php');

$Category_ID = $_GET['Category_ID'];

$Delete = "DELETE FROM categories WHERE Category_ID='$Category_ID' ";
$ret = mysqli_query($connection, $Delete);

if ($ret) {
	echo "<script>window.alert('Selected Category Successfully Deleted.')</script>";
	echo "<script>window.location='admincate.php'</script>";
} else {
	echo "<p>Something went wrong" . mysqli_error($connection) . "</p>";
}
?>
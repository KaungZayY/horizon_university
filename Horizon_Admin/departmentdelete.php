<?php
session_start();
include('connect.php');

$Department_ID = $_GET['Department_ID'];

$Delete = "DELETE FROM departments WHERE Department_ID='$Department_ID' ";
$ret = mysqli_query($connection, $Delete);

if ($ret) {
	echo "<script>window.alert('Department Successfully Deleted.')</script>";
	echo "<script>window.location='admindep.php'</script>";
} else {
	echo "<p>Something went wrong" . mysqli_error($connection) . "</p>";
}
?>
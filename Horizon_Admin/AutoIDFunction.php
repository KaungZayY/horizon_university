<?php 

function AutoID($tableName,$fieldName,$prefix,$noOfLeadingZeros)
{
	$connection=mysqli_connect("localhost","root","","horizon_university");
	$newID="";
	$sql="";
	$value=1;

	 $sql="SELECT ". $fieldName . " FROM ". $tableName ." ORDER BY ". $fieldName ." DESC ";
	$result=mysqli_query($connection,$sql);
	$noOfRow=mysqli_num_rows($result);
	$row=mysqli_fetch_array($result);

	if($noOfRow<1){
		return $prefix."000001";
	}
	else{
		$oldID=$row[$fieldName];
		$oldID=str_replace($prefix,"",$oldID);
		$value=(int)$oldID;
		$value++;
		$newID=$prefix.NumberFormatter($value,$noOfLeadingZeros);
		return $newID;
	}
}
function NumberFormatter($number,$n){
	return str_pad((int)$number,$n,"0",STR_PAD_LEFT);
}

 ?>
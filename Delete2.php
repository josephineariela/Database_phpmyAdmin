<?php

$api_key_value = "tPmAT5Ab3j7F9";
$servername = "localhost";
$username ="root";
$password = "";
$dbname = "absensilokerotomatis";
$value = 0;
		
$dbconnect = mysqli_connect($servername, $username, $password, $dbname);

	//$dbselect = mysqli_select_db($dbconnect, $dbname);

$sql="SELECT * FROM DummyOut2";
	
	//Then Delete all data from Dummy Out

$records = mysqli_query($dbconnect,$sql);

$numResults = mysqli_num_rows($records);

$row = mysqli_fetch_assoc($records);
	
$IdOut = $row['IdOut'];

if ( $numResults != $value){
	echo $IdOut;
} else{
	echo $value;
}

$sql= "DELETE FROM `DummyOut2` WHERE IdOut='{$IdOut}'";

mysqli_query($dbconnect, $sql);

?>

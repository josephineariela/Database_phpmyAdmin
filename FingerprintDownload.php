<?php
//Pendefinisian Variabel
$api_key_value = "tPmAT5Ab3j7F9";
$servername = "localhost";
$username ="root";
$password = "";
$dbname = "absensilokerotomatis";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$dbconnect = mysqli_connect($servername, $username, $password, $dbname);
	//$dbselect = mysqli_select_db($dbconnect, $dbname);

	//Mengambil NIM untuk Praktikum saat itu
	//$sql="SELECT NIM FROM jadwalpraktikum WHERE CONVERT(varchar(10), `date`, 100) = CONVERT(varchar(10), now(), 100)";
	$sql="SELECT jadwalpraktikum.NIM, DATE_FORMAT(jadwalpraktikum.date, '%Y-%m-%d') 
	FROM jadwalpraktikum 
	WHERE DATE(date) = CURDATE()";
	$query = mysqli_query($dbconnect,$sql);
	$numResults = mysqli_num_rows($query);		
	//$nim_array=array();
	for($i=0; $i<($numResults) ; $i++){
		$row = mysqli_fetch_assoc($query);
		$dummyNIM = $row['NIM'];	
		
		$sql= "SELECT * FROM fingerprint WHERE NIM = '$dummyNIM'";
		$query2 = mysqli_query($dbconnect, $sql);
		$row2 = mysqli_fetch_assoc($query2);
		$dummyID = $row2['Id'];
		$dummyTemplate = $row2['Template'];
		
		if( $row2['Id'] == ""){
		} else{
			$sql = "INSERT INTO fingerprinttoday(`Id`, `NIM`, `Template`) VALUES ('$dummyID', '$dummyNIM', '$dummyTemplate')";
			$dbconnect -> query($sql);	
		}
	
	}

//Mendapatkan seluruh data Fingerprint
	$sql = "SELECT * FROM fingerprinttoday";
	$records = mysqli_query($dbconnect, $sql);
	$numResults = mysqli_num_rows($records);
		
	echo $numResults;
	
} else{
//Menghubungkan PHP dengan Database
$dbconnect = mysqli_connect($servername, $username, $password, $dbname);
//$dbselect = mysqli_select_db($dbconnect, $dbname);

//Mengambil NIM untuk Praktikum saat itu
//$sql="SELECT NIM FROM jadwalpraktikum WHERE CONVERT(varchar(10), `date`, 100) = CONVERT(varchar(10), now(), 100)";

//Mendapatkan seluruh data Fingerprint
$sql = "SELECT * FROM fingerprinttoday";
$records = mysqli_query($dbconnect, $sql);

//$records = mysqli_query($dbconnect,$sql);

//Mempersiapkan pengiriman data dengan format JSon Array
$json_array=array();
while($row=mysqli_fetch_assoc($records))
{
	$json_array[]=$row;	
}
		/*echo '<pre>';
		print_r($json_array);
		echo '</pre>';*/
echo json_encode($json_array); //Mengirimkan data melalui echo

$sql= "DELETE FROM `fingerprinttoday` WHERE 1";

mysqli_query($dbconnect, $sql);


}
?>

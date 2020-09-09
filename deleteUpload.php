<?php
session_start();
include('database_conn.php');

$uploadID = $_SESSION['upload_id'];

$sqlDeleteUpload="DELETE FROM Uploads WHERE upload_id = $uploadID";
if ((mysqli_query($conn,$sqlDeleteUpload))===true){
	header('Location: ' . $_SERVER['HTTP_REFERER']);

}
else{
	echo"error";
}

?>  
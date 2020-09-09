<?php
session_start();
include('database_conn.php');
$eventID = $_SESSION['event_id'];

$embedLink = $_POST['embedFile'];
$sqlEmbed="UPDATE Event SET youtube_link ='$embedLink' WHERE event_id='$eventID'";
if ((mysqli_query($conn,$sqlEmbed))===true){
	header('Location: ' . $_SERVER['HTTP_REFERER']);
}
else{
	echo"error";
}
?>
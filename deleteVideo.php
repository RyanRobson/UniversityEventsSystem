<?php
session_start();
include('database_conn.php');

$eventID= $_SESSION['event_id'];

$sqlDeleteVideo="UPDATE Event SET youtube_link = NULL WHERE event_id = '$eventID'";
if ((mysqli_query($conn,$sqlDeleteVideo))===true){
	header('Location: ' . $_SERVER['HTTP_REFERER']);

}
else{
	echo"error";
}

?>  
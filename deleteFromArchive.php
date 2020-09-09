<?php
session_start();
include('database_conn.php');
$eventID = $_SESSION['event_id'];

$sqlDelete="DELETE FROM Archive_Event WHERE event_id = $eventID";
if (mysqli_query($conn,$sqlDelete)===true){
	header("Location: eventArchive.php");

}
else{
	echo "<p>error deleting event</p>";
}

  
?>
<?php 
session_start();
include('database_conn.php');
$event_id =$_SESSION['event_id'];
$commentID=$_GET['comment_id'];
$sql ="DELETE FROM Comments WHERE comment_id = '$commentID'";
if(mysqli_query($conn,$sql)=== true){
	echo "comment Deleted";
}
else{
	echo "error";
}

?>
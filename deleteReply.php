<?php 
session_start();
include('database_conn.php');
$threadID=$_SESSION['CurThread'];
$replyID=$_GET['reply_id'];
$sql ="DELETE FROM Thread_Reply WHERE reply_id = '$replyID'";
if(mysqli_query($conn,$sql)=== true){
	echo "reply Deleted";
}
else{
	echo "error";
}

?>
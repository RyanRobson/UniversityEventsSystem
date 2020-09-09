<?php
session_start();
include('database_conn.php');

$eventID=$_SESSION['event_id']; 
echo "This is the event id    $eventID";

?>
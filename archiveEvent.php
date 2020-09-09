<?php
session_start();
include('database_conn.php');
$eventID = $_SESSION['event_id'];

//copies the event into archive table
  $sqlArchive = "INSERT INTO Archive_Event  SELECT e.*
            	 FROM Event e
            	 WHERE Event_id = '$eventID'";

if (mysqli_query($conn, $sqlArchive) === true){
//3 queries used for deleting related data to an event 
	//removes all foreign keys in db to allow event to be removed. 
	
      		$sqlDeleteRegister="DELETE FROM Register_For_Event WHERE event_id ='$eventID'";
      		$sqlDeleteWaiting="DELETE FROM Waiting_List WHERE event_id ='$eventID'";
      		$sqlDeleteComments="DELETE FROM Comments WHERE event_id = '$eventID'";

	      	if(mysqli_query($conn,$sqlDeleteRegister)===true){
	      		echo "Reg deleted";
	      	}
	      	else{
	      		echo"reg error";
	      	}
	      	if(mysqli_query($conn,$sqlDeleteWaiting)){
	      		echo "waiting deleted";
	      	}
	      	else{
	      		echo"waiting error";
	      	}
			if(mysqli_query($conn,$sqlDeleteComments)){
	      		echo "comments deleted";
	      	}
	      	else{
	      		echo"comments error";
	      	}
	      	//pulls the email addresses for every user registered for the selected event
	      	  $sqlEmail="SELECT email_address FROM User, Register_For_Event WHERE Register_For_Event.event_id ='$eventID'
						AND Register_For_Event.user_id = User.user_id";
/*
							  if($res=mysqli_query($conn,$sqlEmail)){
							  	$row =mysqli_fetch_array($res,MYSQLI_ASSOC);
							  	$userInfo=array();
							  	 foreach($row as $key => $value){

							  	 	echo"<p>$value</p>";
            								$to = $value;
											$subject = "Event Removal Notification";
											$message = "Hello $value, The event with the ID: $event_id will no longer be taking place, appologies for any 
														inconveniences this may cause";
											
											$headers ="From: ryan.robson@northumbria.ac.uk";
											mail ($to ,$subject , $message, $headers );
							
						}
				}
				*/
				// deletes the event from Event table after it has been coppied over to Archive_Event 
				$sqlDrop="DELETE FROM Event WHERE event_id ='$eventID'";
	      		if(mysqli_query($conn,$sqlDrop)===true){
		      		echo"Table coppied to archive and deleted from event";
		      		header("Location: UserAccount.php");
		      	}
		      	else{
		      		echo"error deleting table";
		      		echo "$eventID";
		      	}
		      	
	      }
      		else {
      		echo"error deleting evert";
	      	}
?>
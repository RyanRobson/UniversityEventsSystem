<?php
include('database_conn.php');
session_start();
$event_id = $_SESSION['event_id'];
$user_id = $_SESSION['user_id'];

$sqlMaxAttend ="SELECT max_attendees FROM Event WHERE event_id = '$event_id'";
// retireves the maximum number of attendes from Event table, and stores this as $eventInfo[0], and passes this to $maxAttend. 
           if ($result =mysqli_query($conn, $sqlMaxAttend) ){
              $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
              $eventInfo =array();
              foreach($row as $key => $value){
                $eventInfo[] = $value;
              }
              $maxAttend = $eventInfo[0];
          }
          else{
          	echo "<p>maximum number of atendees error</p>";
          }

$sqlCurrentAttend = "SELECT COUNT(*)FROM Register_For_Event WHERE event_id = '$event_id'";
// retieves the number of registrants registered for an event, and passes this to $currentAtteend. 
 if ($result =mysqli_query($conn, $sqlCurrentAttend) ){
              $newRow = mysqli_fetch_array($result,MYSQLI_ASSOC);
              $countInfo =array();
              foreach($newRow as $key => $value){
                $countInfo[] = $value;
              }
              $currentAttend = $countInfo[0];
              	}
				else{
					echo"<p>current error</p>";
				}

if($currentAttend == $maxAttend){

			//automattically adds the person from the top of the waiting list to the registered table when space become available 
			
				$sqlSelectFromWaiting ="SELECT * FROM Waiting_List WHERE event_id = '$event_id' LIMIT 1";
				if ($waitingResult=mysqli_query($conn,$sqlSelectFromWaiting)){
					while($waitingRow =mysqli_fetch_assoc($waitingResult)){
					$waitingUserID = $waitingRow['user_id'];
					$sqlInsertIntoReg="INSERT INTO Register_For_Event (event_id, user_id) VALUES ('$event_id', '$waitingUserID')";
					mysqli_query($conn,$sqlInsertIntoReg);
					$sqlRemoveFromWaiting ="DELETE FROM Waiting_List WHERE user_id ='$waitingUserID' AND event_id ='$event_id'";
					mysqli_query($conn,$sqlRemoveFromWaiting);
					
					$sqlUserInfo="SELECT email_address,forename, middle_name,surname FROM User WHERE user_id ='$waitingUserID'";
					if($userInfo =mysqli_query($conn,$sqlUserInfo)){
					while($userRow=mysqli_fetch_assoc($userInfo)){
						$email = $userRow['email_address'];
						$forename =$userRow['forename'];
						$middleName=$userRow['middle_name'];
						$surname=$userRow['surname'];
						
						$to = $email;
						$subject = "Registered For event ";
						$message = "Hello $forename $middleName $surname, Registration spots for the event with the id: $event_id have opened up, you have been removed from the waiting list and registered to attend the event";
						$headers ="From: ryan.robson@northumbria.ac.uk";
						mail ($to ,$subject , $message, $headers );
					}
					
					}
			
	}
	}
}
$sql = "DELETE FROM Register_For_Event WHERE user_id ='$user_id' AND event_id ='$event_id'";
$sqlWait ="DELETE FROM Waiting_List WHERE user_id ='$user_id' AND event_id ='$event_id'";
if (mysqli_query($conn, $sql) === true){
	if(mysqli_query($conn, $sqlWait )===true){
		echo "<p>Unregistered</p>";
		echo"<input Type='button' value='Back' onClick='history.go(-1);return true;''>";

	}	
}
?>
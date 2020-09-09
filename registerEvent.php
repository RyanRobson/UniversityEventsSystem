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


//checks if the event is full or not using the previously retieved values
if($currentAttend >= $maxAttend){
	$sqlCountWaiting="SELECT COUNT(*) FROM Waiting_List WHERE user_id = '$user_id' AND event_id = '$event_id'";
	$countRow = mysqli_query($conn,$sqlCountWaiting);
	$result = mysqli_fetch_row($countRow);
	$isWaiting = $result[0];

			if($isWaiting >0){
				echo"<p>You are already on the waiting list</p>";
				echo"<input Type='button' value='Back' onClick='history.go(-1);return true;''>";
			}
			else
	{
					//adds user to waiting list if event  is full
						$sqlWaiting ="INSERT INTO `Waiting_List` (`event_id`, `user_id`)
						VALUES ('$event_id', '$user_id')";
						if(mysqli_query($conn, $sqlWaiting) === true){
								echo"<p>This event is fully booked, you have been placed on a waiting list</p/>";		
								echo"<input Type='button' value='Back' onClick='history.go(-1);return true;''>";		
						}
						else {
							echo " waiting error";
						}
}}


elseif($currentAttend < $maxAttend){
		// registers user for event 
				$sqlAlreadyRegistered ="SELECT COUNT(*) FROM Register_For_Event WHERE user_id = '$user_id' AND event_id = '$event_id'";
				$numberReg = mysqli_query($conn, $sqlAlreadyRegistered);
				$result = mysqli_fetch_row($numberReg);
				$row_returned = $result[0];
			
					if($row_returned >=1){
						echo"You have already registered for this event";
					}

					else{

						$sqlUpdateRegList="";
					}
					
				$sql ="INSERT INTO `Register_For_Event` (`event_id`, `user_id`) 
				VALUES ('$event_id', '$user_id')";

				if(mysqli_query($conn, $sql) === true){	

				 
							  $sqlMail="SELECT email_address,forename, middle_name,surname FROM User WHERE user_id ='$user_id'";
							  if($res=mysqli_query($conn,$sqlMail)){
							  	$row =mysqli_fetch_array($res,MYSQLI_ASSOC);
							  	$userInfo=array();
							  	 foreach($row as $key => $value){
            							$userInfo[] =$value;
            							}
 							$to = $userInfo[0];
							$subject = "Event Registration Confirmation";
							$message = "Hello $userInfo[1] $userInfo[2] $userInfo[3], You have been registered for the event: $event_id ";
							
							$headers ="From: ryan.robson@northumbria.ac.uk";
							mail ($to ,$subject , $message, $headers );
							echo ("You have registered for the event and will be emailed with Confirmation");
							header("Location: eventPage.php?event_id=".$event_id."");
				}}
				else{
				  echo "error";
				}
				}

?>

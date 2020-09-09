<?php
session_start();
include('database_conn.php');
$eventID = $_SESSION['event_id'];
echo "$eventID";

$sqlSelectArchive ="SELECT * FROM Archive_Event WHERE event_id ='$eventID'";

$sqlDeleteArchive="DELETE FROM Archive_Event WHERE event_id ='$eventID'";

	if ($result =mysqli_query($conn, $sqlSelectArchive) ){
              $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
              $archiveEventInfo =array();
              foreach($row as $key => $value){
                $archiveEventInfo[] = $value;
                echo "$value<br/>";
              }

              $sqlRestore="INSERT INTO Event (name, date, location, department, event_host, min_attendees, max_attendees, staff_needed, description, expected_attendees, actual_attendees)
              VALUES ('$archiveEventInfo[1]','$archiveEventInfo[2]','$archiveEventInfo[3]','$archiveEventInfo[4]','$archiveEventInfo[5]','$archiveEventInfo[6]',
              	'$archiveEventInfo[7]','$archiveEventInfo[8]','$archiveEventInfo[9]','$archiveEventInfo[10]','$archiveEventInfo[11]')";
              		if(mysqli_query($conn,$sqlRestore)===true){
							//echo "event restored";
								if(mysqli_query($conn,$sqlDeleteArchive)===true){
									//echo "event removed from archive";
									header("Location: index.php");
								}
								else{
									echo "event not removed from archive";
								}
						}
						else{
							echo"error restoring event";
						}
}	else{
		echo "error loading archive";
	}
?>
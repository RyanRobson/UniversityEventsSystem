<!DOCTYPE html>
<html >
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Create New Event</title>
  </head>
  <body> 
<div id = "wrapper">
		  <?php include('navigation.php');?>
		  <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">    </br>
		  <div id = "main_content">
  		
<?php 
include('database_conn.php');
session_start();
//prevents anyone who isnt logged in as as a staff member from accessing the page
if(!isset($_SESSION['staff'])){
	header("Location: index.php");
}
 elseif(isset($_SESSION['staff'])){
        echo("Welcome Staff Member ". $_SESSION['staff']);
          $emailAddress=$_SESSION['staff'];
	  }
//error messages set as blank strings 
$eventNameErr= $descErr= $deptErr =$dateErr = $locationErr= $hostErr= $noOfStaffErr= $maxErr = $minErr="";
$err=0;//used to track number of errors form input has
// validates form input, ensures value is present
 if($_SERVER["REQUEST_METHOD"] == "POST"){
 		if(empty($_POST['eventName'])){
 			$eventNameErr ="Event Name is required";
			$err++;
 		}
 		else {
 			$eventName =test_input($_POST['eventName']);
 		}
 		if(empty($_POST['department'])){
 			$deptErr ="Event Department is required";
			$err++;	
 		}
 		else {
 			$department =test_input($_POST['department']);
 		}
		if(empty($_POST['description'])){
 			$descErr ="Event Description is required";
			$err++;	
 		}
 		else {
 			$description =test_input($_POST['description']);
 		}
		if(empty($_POST['eventDate'])){
 			$dateErr ="Event Date is required";
			$err++;	 
 		}
 		else {
 			$eventDate =test_input($_POST['eventDate']);
 		}
 		if(empty($_POST['location'])){
 			$locationErr ="Event Location is required";
			$err++;
		}
 		else {
 			$location =test_input($_POST['location']);
 		}
 		if(empty($_POST['eventHost'])){
 			$hostErr ="Event Host is required";
			$err++;
 		}
 		else {
 			$eventHost =test_input($_POST['eventHost']);
 		}
 		if(empty($_POST['noOfStaff'])){
 			$noOfStaffErr ="Number of staff is required";
			$err++;	
 		}
 		else {
 			$noOfStaff =test_input($_POST['noOfStaff']);
 		}
 		if(empty($_POST['maxAttendees'])){
 			$maxErr ="Maximum number of attendees is required";
			$err++;
 		}
 		else {
 			$maxAttendees =test_input($_POST['maxAttendees']);
 		}
 		if(empty($_POST['minAttendees'])){
 			$minErr ="Minimum number of attendees is required";
 			$err++;
 		}
 		else {
 			$minAttendees =test_input($_POST['minAttendees']);
 		}
 		
		if($err === 0){
 		$sql ="INSERT INTO Event (name, date, location, department, event_host, min_attendees, max_attendees, staff_needed, description, expected_attendees, actual_attendees)
			VALUES ('$eventName', '$eventDate', '$location', '$department', '$eventHost', '$minAttendees', '$maxAttendees', '$noOfStaff', '$description', '0', '0')";

			 if(mysqli_query($conn, $sql) === true)
			 {
			 	$sqlThread ="INSERT INTO Bulletin_Board (`thread_title`, `thread_comments`) VALUES ('$eventName','')";
				mysqli_query($conn, $sqlThread);
			 	header("Location: index.php");
			 }
			 mysqli_close($conn);
 			}//cloeses line 90 if($err===0)
		}//closes line 24 if($_SERVER["REQUEST_METHOD"] == "POST")
?>
		  <form id ="createEvent"  action=""<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"" method="POST">
		  	<fieldset>
		  		<legend> New Event:</legend>

			<label for="eventName">Event Name:*     </label>
				<input type="text" name="eventName" id="eventName" maxlength="20" tabindex = "1" alt = "Enter the event name into the text box" accesskey = "n"
				placeholder="Event Name"/>
				<span class = "error"><?php echo $eventNameErr;?></span>
				<br/>		 
		
			<label for="description">Event Description:*  </label>
				<textarea name="description" id = "description" cols="30" rows="5" tabindex = "2" alt = "Enter event description into text box" accesskey = "d" placeholder="Event Description"></textarea><br/>
			    <span class = "error"><?php echo $descErr;?></span>
			    </br>

			     <label for "department"> Department:* </label>
			     	<Select name = "department" id = "department" tabindex ="3" alt ="Select a department from the list below">
			     		<option value ="0">
			     		<option value ="Faculty Of Engineering and Environment">Faculty Of Engineering and Environment
			     		<option value ="Faculty Of Arts, Design and Social sciences">Faculty Of Arts, Design and Social sciences
			     		<option value ="Faculty Of Buisiness and Law">Faculty Of Buisiness and Law
			     		<option value ="Faculty Of Health and Life Sciences">Faculty Of Health and Life Sciences
			     	</select>
			     	<span class="error"><?php echo $deptErr;?></span>
			     </br>

			    <label for = "date"> Event Date:*</label>
					<input type ="date" id ="eventDate" name = "eventDate" tabindex ="4" alt ="Select a datefor the event"/>
					<span class ="error"><?php echo $dateErr;?></span>
					<br/>
				<label for "location">Event Location:*</label>
					 <input type ="text" id ="location" name ="location" placeholder="Event Location" tabindex ="5" alt="Enter a location for the event"/>
					 <span class = "error"><?php echo $locationErr;?></span>
					 <br/>
				<label for "eventHost">Event Host:*</label>
					 <input type = "text" id="eventHost" name="eventHost" placeholder="Event Host" tabindex ="6" alt ="Enter the host of the event"/>
					 <span class = "error"><?php echo $hostErr;?></span>
					 <br/>
				<label for "noOfStaff">Required Number of staff:*</label>
					 <input type = "number" id="noOfStaff" name="noOfStaff" placeholder="Number of staff required" tabindex ="7" 
					 alt ="Enter the number of staff needed for the event"/>
					 <span class = "error"><?php echo $noOfStaffErr;?></span>
					 <br/>
				<label for "maxAttendees">Max number of attendees:*</label>
				<input type="number" name="maxAttendees" id="maxAttendees" maxlength="3" tabindex = "8" placeholder="Maximum number of attendees"
						alt = "Enter the maximum number of attendees into the text box" accesskey = "m"/>
				<span class = "error"><?php echo $maxErr;?></span>
				</br>

			<label for "minAttendees">Min number of attendees:*</label>
				<input type="number" name="minAttendees" id="minAttendees" maxlength="3" tabindex = "9" placeholder="Minimum number of attendees"
				alt = "Enter the minimum number of attendees into the text box" accesskey = "m"/>
				<span class = "error"><?php echo $minErr;?></span>
				</br>
						
			Required Fields*
			<br/>
				<button type ="submit" formaction = "createEvent.php" tabindex="5" alt ="Create an Event">Create event</button>
	    		<input type="reset" value="Clear" tabindex = "6" alt = "Click the button to clear the form" />
	    		</fieldset>
	    	</form>
	</div>
	<?php include ("footer.php"); ?>
</div>	   
</body>
</html>
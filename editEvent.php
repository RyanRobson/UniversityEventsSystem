<!DOCTYPE html >
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Edit Event Details</title>
  </head>
  <body> 
<div id = "wrapper">
      <?php include('navigation.php');?>
      <div id = "main_content">
          <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo"> 
              </br>
<?php
session_start();
include('database_conn.php');
//defaults error messages to blank strings
$eventNameErr= $descErr= $deptErr =$dateErr = $locationErr= $hostErr= $noOfStaffErr= $maxErr = $minErr="";
$err=0;
    if(isset($_SESSION['emailAddress'])){
      echo ("Welcome " . $_SESSION['emailAddress']."<br/>");
         }
       elseif(isset($_SESSION['staff'])){
          echo ("Welcome Staff Member " . $_SESSION['staff']);
       }
  if(!isset($_SESSION['staff'])){
    header('Location: index.php');
  }
  $event_id = $_SESSION['event_id'];

  //retireves all information from Event table and stores it in the array $eventInfo[]
  $sql= "SELECT * FROM Event WHERE event_id = '$event_id'";
           if ($result =mysqli_query($conn, $sql)){
              $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
              $eventInfo =array();

              foreach($row as $key => $value){
                $eventInfo[] = $value;
                }
            }
            //echoes each element of the event from the array
                echo "<p><b>Event ID:</b> $eventInfo[0]</p>";
                echo "<p><b>Event Name:</b> $eventInfo[1]</p>";
                echo "<p><b>Event Time and Date:</b> $eventInfo[2]</p>";
                 echo "<p><b>Event Location:</b> $eventInfo[3]</p>";
                 echo "<p><b>Event Department:</b>$eventInfo[4]</p>";
                 echo "<p><b>Event Host:</b> $eventInfo[5]</p>";
                echo "<p><b>Minimum Atendees:</b> $eventInfo[6]</p>";
                echo "<p><b>Maximium Atendees:</b> $eventInfo[7]</p>";
                echo "<p><b>Number of staff needed:</b> $eventInfo[8]</p>";
                echo "<p><b>Event Description:</b> $eventInfo[9]</p>";
 if($_SERVER["REQUEST_METHOD"] == "POST"){

  //checks all of the newly inputted fields, if they havve changed, a new variable is set with the value
  //if no change, the previous value is stroed in the new variable
                if(!empty($_POST['eventName'])){
                  $newEventName = test_input($_POST['eventName']);
                }
                else{
                  $newEventName= $eventInfo[1];
                }

                if(!empty($_POST['description'])){
                  $newDescription = test_input($_POST['description']);
                }
                else{
                  $newDescription= $eventInfo[9];
                }

                if(!empty($_POST['department'])){
                  $newDepartment = test_input($_POST['department']);
                }
                else{
                  $newDepartment =$eventInfo[4];
                }
                if(!empty($_POST['eventDate'])){
                  $newEventDate = test_input($_POST['eventDate']);
                }
                else{
                  $newEventDate =$eventInfo[2];
                }
                if(!empty($_POST['location'])){
                  $newLocation = test_input($_POST['location']);
                }
                else{
                  $newLocation =$eventInfo[3];
                }

                if(!empty($_POST['eventHost'])){
                  $newEventHost = test_input($_POST['eventHost']);
                }
                else{
                  $newEventHost =$eventInfo[5];
                }
                if(!empty($_POST['noOfStaff'])){
                  $newNoOfStaff = test_input($_POST['noOfStaff']);
                }
                else{
                  $newNoOfStaff =$eventInfo[8];
                }

                if(!empty($_POST['maxAttendees'])){
                  $newMaxAttendees = test_input($_POST['maxAttendees']);
                }
                else{
                  $newMaxAttendees =$eventInfo[7];
                }
                if(!empty($_POST['minAttendees'])){
                  $newMinAttendees = test_input($_POST['minAttendees']);
                }
                else{
                  $newMinAttendees =$eventInfo[6];
                }
//writes in all of the new vairables to Event table on the corresponding event
            $sqlUpdate ="UPDATE Event SET name='$newEventName', description='$newDescription', date='$newEventDate', location ='$newLocation',
             department='$newDepartment', event_host='$newEventHost',min_attendees='$newMinAttendees', max_attendees ='$newMaxAttendees',
             staff_needed='$newNoOfStaff' WHERE event_id = '$eventInfo[0]'";


if(mysqli_query($conn, $sqlUpdate) === true)
       {
       //returns to the page which sent the request
        header('Location: '.$_SERVER['REQUEST_URI']);
       }
       mysqli_close($conn);
      }    
?>
  <form id ="editEvent"  action=""<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"" method="POST">
        <fieldset>
          <legend> Edit Event:</legend>

      <label for="eventName">Event Name:</label>
        <input type="text" name="eventName" id="eventName" maxlength="20" tabindex = "1" alt = "Enter the event name into the text box" accesskey = "n"
        placeholder="Event Name"/>
        <span class = "error"><?php echo $eventNameErr;?></span>
        <br/>    
    
      <label for="description">Event Description:</label>
        <textarea name="description" id = "description" cols="30" rows="5" tabindex = "2" alt = "Enter event description into text box" accesskey = "d" placeholder="Event description"></textarea><br>
          <span class = "error"><?php echo $descErr;?></span>
          </br>

           <label for "department"> Department:</label>
            <Select name = "department" id = "department" tabindex ="3" alt ="Select a department from the list below">
              <option value ="0">
              <option value ="Faculty Of Engineering and Environment">Faculty Of Engineering and Environment
              <option value ="Faculty Of Arts, Design and Social sciences">Faculty Of Arts, Design and Social sciences
              <option value ="Faculty Of Buisiness and Law">Faculty Of Buisiness and Law
              <option value ="Faculty Of Health and Life Sciences">Faculty Of Health and Life Sciences
            </select>
            <span class="error"><?php echo $deptErr;?></span>
           </br>

          <label for = "date"> Event Date:</label>
          <input type ="date" id ="eventDate" name = "eventDate" tabindex ="4" alt ="Select a datefor the event"/>
          <span class ="error"><?php echo $dateErr;?></span>
          <br/>
        <label for "location">Event Location:</label>
           <input type ="text" id ="location" name ="location" placeholder="Event Location" tabindex ="5" alt="Enter a location for the event"/>
           <span class = "error"><?php echo $locationErr;?></span>
           <br/>
        <label for "eventHost">Event Host:</label>
           <input type = "text" id="eventHost" name="eventHost" placeholder="Event Host" tabindex ="6" alt ="Enter the host of the event"/>
           <span class = "error"><?php echo $hostErr;?></span>
           <br/>
        <label for "noOfStaff">Required Number of staff:</label>
           <input type = "number" id="noOfStaff" name="noOfStaff" placeholder="Number of staff required" tabindex ="7" 
           alt ="Enter the number of staff needed for the event"/>
           <span class = "error"><?php echo $noOfStaffErr;?></span>
           <br/>
        <label for "maxAttendees">Max number of attendees:</label>
        <input type="number" name="maxAttendees" id="maxAttendees" maxlength="3" tabindex = "8" placeholder="Maximum number of attendees"
            alt = "Enter the maximum number of attendees into the text box" accesskey = "m"/>
        <span class = "error"><?php echo $maxErr;?></span>
        </br>

      <label for "minAttendees">Min number of attendees:</label>
        <input type="number" name="minAttendees" id="minAttendees" maxlength="3" tabindex = "9" placeholder="Minimum number of attendees"
        alt = "Enter the minimum number of attendees into the text box" accesskey = "m"/>
        <span class = "error"><?php echo $minErr;?></span>
      <br/>
    
        <button type ="submit" formaction = "editEvent.php" tabindex="5" alt ="Edit Event">Update Event</button>
          <input type="reset" value="Clear" tabindex = "6" alt = "Click the button to clear the form" />
          </fieldset>
        </form>
      </div >

     <?php include ("footer.php"); ?>
          
</div>

</body>
</html>
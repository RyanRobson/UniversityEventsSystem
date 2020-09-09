<!DOCTYPE html>
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Archived Event Information</title>
    <script src="confim.js"></script>
  </head>
  <body> 
<div id = "wrapper">
     <?php include('navigation.php');?>
      <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">
      <div id = "main_content">
         
              </br>
<?php
session_start();

      include('database_conn.php');
    if(isset($_SESSION['emailAddress'])){
      echo ("Welcome " . $_SESSION['emailAddress']);
       $emailAddress=$_SESSION['emailAddress'];
     }
       elseif(isset($_SESSION['staff'])){
        echo("Welcome Staff Member ". $_SESSION['staff']);
          $emailAddress=$_SESSION['staff'];
       } 
       else{
        $emailAddress ="";
       }
  //blank error messages
  $subjectErr= $commentErr="";
//gets the event id from the url, not sure why its in a foreach, dont want to change as it currently works 
  
      foreach($_GET as $key => $value){
          $event_id = $value;
      }
   //pulls user info from User table for the currently logged in email
      // email address isnt PK, but it is unique so no issue 
      $sqlUser="SELECT user_id FROM User WHERE email_address ='$emailAddress'";
      if($res =mysqli_query($conn,$sqlUser)){
          $idRow =mysqli_fetch_array($res,MYSQLI_ASSOC);
          $userid =array();
          foreach($idRow as $key => $value){
            $userid[] =$value;
          }
      }
   
          //retireves all of the informationa bout an event using the event id passed from index
          // the event information is placed in an array called $eventInfo[] and echoed to the web page
          $sql= "SELECT * FROM Archive_Event WHERE event_id = '$event_id'";
           if ($result =mysqli_query($conn, $sql) ){
              $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
              $eventInfo =array();
              foreach($row as $key => $value){
                $eventInfo[] = $value;
              }
              //echoes out all fo the event information fot he archived event, stored in $eventInfo[]
              echo "<p>This event has been archived, and all previously registered users have been unregistered</p>";
              echo "<p>To restore this event use the button at the bottom of the page</p>";
              echo "<p><b>Event ID:</b> $eventInfo[0]</p>";
              echo "<p><b>Event Name:</b> $eventInfo[1]</p>";
              echo "<p><b>Event Time and Date:</b> $eventInfo[2]<p>";
              echo "<p><b>Event Description:</b> $eventInfo[9]</p>";
              echo "<p><b>Event Location:</b> $eventInfo[4]</p>";
              echo "<p><b>Event Host:</b> $eventInfo[5]<p>";
              // not sure why user id is stoered in session... 
              $_SESSION['user_id'] = $userid[0];
              $_SESSION['event_id'] = $eventInfo[0];
           }
           else{
                echo"<p>There are no Events currently arranged</p>";
           }

?>
          <input Type="button" value="Back" onClick="history.go(-1);return true;"/>
          <form id="restoreEvent" action ="restoreEvent.php" method ="get">
          <input type ="submit"  alt="Restore Event" value = "Restore Event"  />
          </form>
          <form id="deleteFromArchive" action="deleteFromArchive.php?.'$eventInfo[0].'" method="get">
          <input type ="submit" alt "Delete from Archive" value="Permenently Delete From Archive">
          </form>
      </div >
      <?php include ("footer.php"); ?>
 </div>
</form>
</body>
</html>
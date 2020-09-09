<!DOCTYPE html >
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Complete List Of Registrants</title>
    <script src="confim.js"></script>
  </head>
  <body> 
<div id = "wrapper">
       <?php include('navigation.php');?>
      <div id = "main_content">
         <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">
              </br>
<?php
session_start();
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
  
  $subjectErr= $commentErr="";
  $eventID=$_SESSION['event_id'];
  $eventName=$_SESSION['event_name'];


      include('database_conn.php');
       $sqlCount ="SELECT COUNT(*) FROM Register_For_Event WHERE event_id = '$eventID'";
            $rowNo = mysqli_query($conn, $sqlCount) ;
            $result = mysqli_fetch_row($rowNo);
            $row_returned = $result[0];
     
     echo "<br/>";
   echo"<p>Below is a list of all of the currently registrants for the event: $eventName</p>";
   echo "<p>There are $row_returned people registered for this event</p>";
$sqlRegForEvent="SELECT * FROM User,Register_For_Event WHERE Register_For_Event.event_id ='$eventID' AND Register_For_Event.user_id = User.user_id ";

 if ($result =mysqli_query($conn, $sqlRegForEvent) ){
              while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $title = $row['title'];
                $forename =$row['forename'];
                $surname =$row['surname'];
                $email= $row['email_address'];
                $dob = $row['D_O_B'];
                $gender = $row['gender'];
               
                echo "<p>";
                
                echo " $title";
                echo " $forename";
                echo " $surname";
                echo " $email";
                echo " $gender";
                echo "</p>";
               
}
}
          ?>
           <input Type="button" value="Back" onClick="history.go(-1);return true;"/>
      </div >
     <?php include ("footer.php"); ?>
          
</div>
</form>
</body>
</html>
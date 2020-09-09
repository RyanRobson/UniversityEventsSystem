<!DOCTYPE html>
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Event Information</title>
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
 if(isset($_SESSION['user_id'])) {
      $user_id = $_SESSION['user_id'];
}
else{
  $user_id=0;
}
  $subjectErr= $commentErr="";

      include('database_conn.php');
      foreach($_GET as $key => $value){
          $event_id = $value;
      }  
          //retireves all of the information about an event using the event id passed from index
          // the event information is placed in an array called $eventInfo[] and echoed to the web page
          $sql= "SELECT * FROM Event WHERE event_id = '$event_id'";
           if ($result =mysqli_query($conn, $sql) ){
              $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
              $eventInfo =array();
              foreach($row as $key => $value){
                $eventInfo[] = $value;

              }
              $event_id = $eventInfo[0];
            //returns the number of users registered for the current event
            $sqlCount ="SELECT COUNT(*) FROM Register_For_Event WHERE event_id = '$eventInfo[0]'";
            $rowNo = mysqli_query($conn, $sqlCount) ;
            $result = mysqli_fetch_row($rowNo);
            $row_returned = $result[0];
            // returns the average rating for the current event 
            $sqlAverage="SELECT AVG(rating) FROM Comments WHERE event_id= '$eventInfo[0]'";
            $avgNo =mysqli_query($conn,$sqlAverage); 
            $avgResult =mysqli_fetch_row($avgNo);
            $avgRating =$avgResult[0];        
            //outputs all of the current event information
                echo "<p><b>Event ID:</b> $eventInfo[0]</p>";
                echo "<p><b>Event Name:</b> $eventInfo[1]</p>";
                echo "<p><b>Event Time and Date:</b> $eventInfo[2]<p>";
                echo "<p><b>Event Description:</b> $eventInfo[9]</p>";
                echo "<p><b>Event Location:</b> $eventInfo[4]</p>";
                echo "<p><b>Event Host:</b> $eventInfo[5]</p>";
                echo "<p><b>Number of people registered for event:</b> $result[0]</p>";
                echo "<p><b>Average User Rating:</b> $avgRating</p>";
                
                echo "<p> <a href=viewComments.php> View all Comments</a></p>";
                if (isset($_SESSION['staff'])){
                  //only shows this if user is logged in as staff
                echo "<p> <a href=statistics.php?$event_id>  Event Statistics</a></p>";
                echo "<p> <a href=editEvent.php> Edit Event Details</a></p>"; 
              }
                //sets current event_id and eventName sessions to the current event
              //used to retireve data on other pages
                $_SESSION['event_id'] = $eventInfo[0];
                $_SESSION['event_name'] =$eventInfo[1];
           }
           else{
                echo"There are no Events currently arranged";
           }
        //processes the comment info from the form 
      if($_SERVER["REQUEST_METHOD"] == "POST"){
           if (empty($_POST['subject'])) {
            $subjectErr = "Subject is required";
           }
           else {
              $subject = test_input($_POST['subject']);
           }

            if (empty($_POST['comment'])){
              $commentErr ="Comment is required";
            } 
            else{
              $comment=test_input($_POST['comment']);
            } 
           }
?>
<?php 
      if (isset($_SESSION['staff'])){
        // only displays if user is logged in as staff member
        ?>
              <p><a href='registrantsList.php'>View All Registrants</a></p>
              <p><a href ='waitingList.php'>View Waiting List</a></p>
             
        <?php
        }
          
          // all upload info in assoc array 
	$sql= "SELECT * FROM Uploads WHERE event_id = '$eventInfo[0]'";
           if ($result =mysqli_query($conn, $sql) ){
            while ( $row = mysqli_fetch_assoc($result)){
                $uploadID=$row['upload_id'];
                $_SESSION['upload_id'] = $uploadID;
                $name=$row['name'];
                $link=$row['link'];
                $linkRep = str_replace("/home/~unn_w12009661/public_html/PSEP_PART_B/Part B/", "", $link);
              
                echo "<p><b>Uploaded file:</b><a href='$linkRep'>$name</a> <a href='deleteUpload.php'>  Remove</a></p>";
                echo "<img src='$linkRep' alt='$name'>";//embeds the image on the page
                echo"<br/>";
            }
              }

            $sqlEmbed="SELECT youtube_link FROM Event WHERE event_id = '$eventInfo[0]'";
            $embNo =mysqli_query($conn,$sqlEmbed); 
            $embResult =mysqli_fetch_assoc($embNo);
            $embedVideo=$embResult['youtube_link'];
            $videoRep =str_replace("/watch?v=","/embed/", $embedVideo);// replaces part of the url, allowing for the video to be embedded
              if( strlen($embedVideo) >0){ // checks the length of the url
                echo" <iframe width='560' height='315' src='$videoRep' frameborder='0' allowfullscreen></iframe>";
                if(isset($_SESSION['staff'])){
                  //more staff restriced functions
		
                 echo"<p><a href='deleteVideo.php'>Delete Video</a></p>";
		 }//closes line 141 if(isset($_SESSION[''staff[))

              }// cloeses line 141 if(strlen($embedVideo)>0)
	      if(isset($_SESSION['staff'])){
		echo"<form id='archiveEvent' action ='archiveEvent.php' method ='get'>";
                 echo"<input type ='submit'  alt='Archive Event' value = 'Archive Event'/>";
                 echo"</form>";
		 }
           if (isset($_SESSION['emailAddress'])){
              //only shows reg/unreg buttons if user is logged in, not for staff
              ?>
         <form action='registerEvent.php' method='get'>
         <input type='submit' value='Register' action 'registerEvent'>
        </form>
         <form action='unRegisterEvent.php' method='get'>
         <input type ='submit' value ='Unregister' alt='Unregister for Event'/>
        </form>

<?php
//compares devent date to current date
$today = Date("y-m-d");
$newDate =explode("-",$today);
$todayDate = "20" . $newDate[0]. "-".$newDate[1]."-".$newDate[2];

if($todayDate > $eventInfo[2] ){
  //only shows if event date os before todays date
  // stops feedback being left before an event has happened
?>

        <form id ='EventComment' action='comment.php' method='POST'>
        <fieldset>
        <legend> Leave a comment:</legend>
        <label for ='subject' >Comment Subject*</label>
        <input type ='text' name ='subject' id ='subject' alt ='Enter a subject for your comment' placeholder ='Subject' tabindex ='1'/>
        <span class='error' $subjectErr></span>
        </br>
        <label for ='comment'> Comment* </label>
        <textarea name='comment' id = 'comment' cols='30' rows='5' tabindex = '2' alt = 'Enter your comment into the box' accesskey = 'd' placeholder="Event comment"></textarea>
        <span class='error' $commentErr></span>
        <br/>
        <label for ='rating'> Leave a Rating:</label>
                <input type ='radio' name = 'rating' id ='rating' value ='1' alt ='Rating of 1' tabindex ='12'>1
                <input type ='radio' name = 'rating' id ='rating' value ='2' alt ='Rating of 2' tabindex ='12'>2
                <input type ='radio' name = 'rating' id ='rating' value ='3' alt ='Rating of 3' tabindex ='12'>3
                <input type ='radio' name = 'rating' id ='rating' value ='4' alt ='Rating of 4' tabindex ='12'>4
                <input type ='radio' name = 'rating' id ='rating' value ='5' alt ='Rating of 5' tabindex ='12'>5
                <br/>
        <button type ='submit' alt ='Submit your comment'>Submit Comment </button>
       </fieldset>
        <?php
      }
      elseif($todayDate < $eventInfo[2]){
        echo"<p>Once the event has taken place, you will be able to leave a comment below</p>";
      }
      }
if(isset($_SESSION['staff'])){
  //only allows staff members to upload files and embed images
?>
        <form id ="FileUpload"  action="fileUpload.php" method="POST" enctype="multipart/form-data">
            <fieldset>
              <legend> Upload an Image:</legend>
                <label for="name">Filename:</label>
                <input type="file" name="file" id="file"><br>
                <button type ="submit" alt ="Submit Upload">Submit Upload </button>
                 </fieldset>
             </form>

            <form id ="FileEmbed" action="fileEmbed.php" method ="POST">
                <fieldset>
                    <label for "embedFile">Paste a youtube link to embed on the event page:</label>
                    <input type ="text" id = "embedFile" name = "embedFile">
                    <button type ='submit' alt ='Submit your comment'>Submit Link </button>
               </fieldset>
            </form>
        <?php
}//closes line 205 if(isset($_SESSION['staff'])
?>
      </div >

<?php include ("footer.php"); ?>
          
</div>

</body>
</html>
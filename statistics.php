<!DOCTYPE html >
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Event Statistics</title>
  </head>
  <body> 
<div id = "wrapper">
             <?php include('navigation.php');?>
            <div id = "main_content">
               <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">    </br>

                <?php
                include('database_conn.php');
                session_start();

                 if(isset($_SESSION['emailAddress'])){
          echo ("Welcome " . $_SESSION['emailAddress']);
          
         }
       elseif(isset($_SESSION['staff'])){
          echo ("Welcome Staff Memeber " . $_SESSION['staff']);
       }
                    foreach($_GET as $key => $value){
                     
                      }
              $sql ="SELECT * FROM Event WHERE event_id = $key";
               if ($result =mysqli_query($conn, $sql)){

                  $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                  $eventInfo = array();
                    foreach($row as $key => $value){
                      $eventInfo[] = $value;
                    }

            $actAttend =($eventInfo[10] / 100) *$eventInfo[11];
            $sqlCount ="SELECT COUNT(*) FROM Register_For_Event WHERE event_id = '$eventInfo[0]'";
            $rowNo = mysqli_query($conn, $sqlCount) ;
            $result = mysqli_fetch_row($rowNo);
            $row_returned = $result[0];

            $sqlMale=" SELECT COUNT(*) AS Male,event_id FROM User JOIN Register_For_Event USING (user_id) WHERE gender='male' AND event_id  ='$eventInfo[0]'";
            $maleRes =mysqli_query($conn,$sqlMale);
            $mRes = mysqli_fetch_row($maleRes);
            $maleNo = $mRes[0];

            $sqlFemale=" SELECT COUNT(*) AS Female,event_id FROM User JOIN Register_For_Event USING (user_id) WHERE gender='female' AND event_id  ='$eventInfo[0]'";
            $femaleRes =mysqli_query($conn,$sqlFemale);
            $femRes = mysqli_fetch_row($femaleRes);
            $femaleNo = $femRes[0];

            $sqlAge="SELECT AVG( FLOOR( DATEDIFF( CURRENT_DATE( ) , D_O_B ) / 362.25 ) ) AS Age FROM User JOIN Register_For_Event WHERE event_id =$eventInfo[0]";
            $ageRes =mysqli_query($conn,$sqlAge);
            $ageRow=mysqli_fetch_row($ageRes);
            $avgAge=$ageRow[0];


            echo "<p>Statistical information about $eventInfo[1]</p>";
            echo "<p><b>Event ID:</b> $eventInfo[0]</p>";
            echo "<p><b>Event Name:</b> $eventInfo[1]</p>";
            echo "<p><b>Expected Number of attendees: </b> $row_returned </p>";
            echo "<p><b>Males Registered: </b> $maleNo </p>";
            echo "<p><b>Females Registered: </b> $femaleNo </p>";
            echo "<p><b>Average Age of Regestrants:</b> $avgAge</p>";
            
                    }
                ?>
                
  <input Type="button" value="Back" onClick="history.go(-1);return true;">
            </div >
          <?php include ("footer.php"); ?>
</div>

</form>
</body>
</html>
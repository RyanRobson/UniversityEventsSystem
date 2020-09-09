<!DOCTYPE html >
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Archived Events</title>
  </head>
<body> 
<div id = "wrapper">
          <?php include('navigation.php');?>
         <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">   
<br/>
   <div id = "main_content">
    <?php
    include('database_conn.php');
   session_start();
    if(isset($_SESSION['emailAddress'])){
      echo ("Welcome " . $_SESSION['emailAddress']);
    }
   elseif(isset($_SESSION['staff'])){
        echo("Welcome Staff Member ". $_SESSION['staff']);
   
         echo"<p>Below are the events which have been archived</p>";
          $sql ="SELECT event_id FROM Archive_Event";
      
          // retireves a list of all of the event ID's from th database, loads them into accosiative array
          //and for each of these ID's, retrieves the corosponding event name from the database
          // echos the event name and passes the event id as a value in the link request
        if($result =mysqli_query($conn,$sql)){
          while ($row= mysqli_fetch_array($result, MYSQLI_ASSOC)){
            foreach($row as $value =>$key){
                    $sqlEvt="SELECT name FROM Archive_Event WHERE event_id =$key";
                    $resultEvt=mysqli_query($conn,$sqlEvt);
                    $Evtnames =mysqli_fetch_array($resultEvt, MYSQLI_NUM);
                    foreach ($Evtnames as $values){
                           echo"<ul>";
                           echo"<li><p><a href=archivedEventPage.php?event_id=$key>$values</a></p></li>";
                           echo"</ul>";
                    }
                  }
                }
          }
        }
      //restricts access to the page unless a staff member is logged in 
      elseif(!isset($_SESSION['staff'])){
        echo"Only Staff Members can access this page";
      }
        ?>  
      </div>
     <?php include ("footer.php"); ?>
</div>
</body>
</html>
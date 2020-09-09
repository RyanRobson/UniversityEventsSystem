<!DOCTYPE html>
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>University Events</title>
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
      $email = $_SESSION['emailAddress'];
      $sqlUserInfo="SELECT user_id FROM User WHERE email_address= '$email'";
      if($res = mysqli_query($conn,$sqlUserInfo)===true){
       while($ret = mysqli_fetch_assoc($res)){
        $userID=$row['user_id'];
          $_SESSION['user_id'] = $user_id; 
       }
      }
    }
   elseif(isset($_SESSION['staff'])){
        echo("Welcome Staff Member ". $_SESSION['staff']);
       }

         echo" <h1> Welcome to Northumbria University Events</h1>";
         echo"<p>List of all upcoming university events, please <a href='createAccount.php'>register an account</a> or <a href='login.php'>log in</a> to sign up for events</p>";
          $sql ="SELECT event_id FROM Event";

          // probably not the most optimised way to do this but oh well
          // retireves a list of all of the event ID's from th database, loads them into accosiative array
          //and for each of these ID's, retrieves the corosponding event name from the database
          // echos the event name and passes the event id as a value in the link request
        if($result =mysqli_query($conn,$sql)){

          while ($row= mysqli_fetch_array($result, MYSQLI_ASSOC)){

          
              foreach($row as $value =>$key){

                    $sqlEvt="SELECT name FROM Event WHERE event_id =$key";
                    $resultEvt=mysqli_query($conn,$sqlEvt);
                    $Evtnames =mysqli_fetch_array($resultEvt, MYSQLI_NUM);
                    foreach ($Evtnames as $values){
                           echo"<ul>";
                           echo"<li><p><a href=eventPage.php?event_id=$key>$values</a></p></li>";
                           echo"</ul>";


                    }//closes line 44 foreach
                }//closes line 39 foreach
          }//closes line 36 while($row =mysqli_fetch_array($result,MYSQLI_ASSOC))
        }//closes line 34 if($result=mysqli_query($conn,$sql))
        ?>  
</div>
 <?php include ("footer.php"); ?>
</div>
</body>
</html>
<!DOCTYPE html>
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>User Account</title>
  </head>
  <body> 
<div id = "wrapper">
      <?php include('navigation.php');?>

       <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">
              </br>
      <div id = "main_content">
         
<?php
      session_start();
       include('database_conn.php');
       if(isset($_SESSION['emailAddress'])){
          echo ("Welcome " . $_SESSION['emailAddress']);
           $emailAddress=$_SESSION['emailAddress'];
         }
       elseif(isset($_SESSION['staff'])){
          echo ("Welcome Staff Member " . $_SESSION['staff']);
       }
     if(isset($_SESSION['emailAddress'])){
          //retireves all of the informationa bout an event using the event id passed from index
          // the event information is placed in an array called $eventInfo[] and echoed to the web page
	  $userID=$_SESSION['user_id'];
      $sqlUser="SELECT * FROM User WHERE email_address ='$emailAddress'";
      if($res =mysqli_query($conn,$sqlUser)){
          $idRow =mysqli_fetch_array($res,MYSQLI_ASSOC);
          $userInfo =array();
          foreach($idRow as $key => $value){
            $userInfo[] =$value;
          }
                echo "<p><b>User ID:</b> $userInfo[0]</p>";
                echo "<p><b>Title:</b> $userInfo[4]</p>";
                echo "<p><b>Forename:</b> $userInfo[1]</p>";
                echo "<p><b>Middle name:</b> $userInfo[3]</p>";
                echo "<p><b>Surname:</b> $userInfo[2]<p>";
                echo "<p><b>Email Address:</b> $userInfo[9]</p>";
                echo "<p><b>Date Of Birth:</b> $userInfo[5]<p>";
               echo "<a href =updateUserAccount.php> Edit Account details </a> ";
           }
           else{
            echo "error";       
           }
}
elseif(isset($_SESSION['staff'])){
  echo "<br/>";
    echo"<a href='createEvent.php'>Create a new event</a>";
    echo "<br/>";
    echo "<a href='eventArchive.php'>View Event Archive</a>";
}
else{
  echo "Please <a href = login.php> Log in </a> or <a href = createAccount.php> create an account </a> here to view account details";
}
?>
      </div >
     <?php include ("footer.php"); ?>
</div>
</form>
</body>
</html>
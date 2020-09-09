<?php
session_start();
include('database_conn.php');

      $emailAddress = $_SESSION['emailAddress'];

      $user_id =$_SESSION['user_id'];
      $event_id=$_SESSION['event_id'];
      $comment = $_POST['comment'];
      $subject = $_POST['subject'];
      $rating =$_POST['rating'];

      $sqlComment ="INSERT INTO Comments (subject, comment, user_id, event_id,rating ) VALUES('$subject', '$comment', '$user_id','$event_id',$rating)";

       if(mysqli_query($conn, $sqlComment) === true)
			 {
			 	echo ("Comment Posted");
			 }
       else {
        echo"Comment not posted - Error <br/>";
       }
			 mysqli_close($conn);
 			echo "$emailAddress <br/>";
      echo "$user_id <br/>";
      echo "$event_id <br/>";

     header('Location: ' . $_SERVER['HTTP_REFERER']);
    
?>
<?php
session_start();
include('database_conn.php');

      $emailAddress = $_SESSION['emailAddress'];
     
      $comment = $_POST['threadComment'];
      $thread_id = $_SESSION['CurThread'];

      $sqlComment ="INSERT INTO Thread_Reply (thread_id, reply_comment, poster ) VALUES('$thread_id', '$comment', '$emailAddress')";

       if(mysqli_query($conn, $sqlComment) === true)
			 {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
			 	
			 }
       else {
        echo"Comment not posted - Error <br/>";
       }
			 mysqli_close($conn);

    
?>
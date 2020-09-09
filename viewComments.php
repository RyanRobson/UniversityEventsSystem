<!DOCTYPE html >
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
      <div id = "main_content">
          <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">
              </br>
<?php
session_start();
 include('database_conn.php');
    if(isset($_SESSION['emailAddress'])){
      echo ("Welcome " . $_SESSION['emailAddress']);
       $emailAddress=$_SESSION['emailAddress'];
  }
  elseif(isset($_SESSION['staff'])){
    echo ("Welcome Staff Member " .$_SESSION['staff']);
  }
  $event_id =$_SESSION['event_id'];
   
echo "<p>Comments for event id $event_id </p>";


$sqlComments ="SELECT * FROM Comments WHERE event_id ='$event_id'";
if($result = mysqli_query($conn,$sqlComments)){
  
    while($commentRow = mysqli_fetch_assoc($result)){

              $subject =$commentRow["subject"];
              $comment= $commentRow["comment"];
              $rating =$commentRow["rating"];
              $userId=$commentRow['user_id'];
              $commentID=$commentRow['comment_id'];
                
                  $sqlUser ="SELECT * FROM User WHERE user_id = '$userId'";
                     if($res =mysqli_query($conn,$sqlUser)){
                              $idRow =mysqli_fetch_array($res,MYSQLI_ASSOC);
                              $userInfo =array();
                              foreach($idRow as $key => $value){
                                $userInfo[] =$value;
                              }


       
          echo"<fieldset>";
          echo "<p>Comment Subject:  $subject</p>";
          echo "<p>Comment:          $comment</p>";
          
          if ($rating >0){

            echo "<p>Rating:           $rating</p>";
          }

         echo "<p>Posted by:        $userInfo[9] - User ID - $userId</p>";
         if((isset($_SESSION['staff']))|| ($emailAddress === $userInfo[9])) {

            echo "<p><a href='deleteComment.php?comment_id=".$commentID."'>Delete Comment</a></p>";
          }

          echo "</fieldset>";
          echo "<br/>";        
          }
}
}
else{
  echo "<br/>No comments found for event";
}
 
?>       
<input Type="button" value="Back" onClick="history.go(-1);return true;" tabindex="23">
      </div >

      <?php include ("footer.php"); ?>
          
</div>
</form>
</body>
</html>
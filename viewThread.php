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
   $threadID = $_GET['thread_id'];
   $_SESSION['CurThread'] = $threadID;
echo "<br/>Comments for $threadID";
$commentErr="";
$sqlGetThread = "SELECT * FROM Bulletin_Board Where thread_title = '$threadID'";
if($result = (mysqli_query($conn,$sqlGetThread))){
      while($threadRow =mysqli_fetch_assoc($result)){
        $title = $threadRow["thread_title"];
        $comment = $threadRow['thread_comments'];
        $poster = $threadRow['thread_poster'];

         echo"<fieldset>";
          echo "<p>Thread Title:  $title</p>";
          echo "<p>Comment:          $comment</p>";
          echo "<p>Posted by:  $poster</p>";
          echo"</fieldset>";
          echo "<br/>";
      }
}
  $sqlGetComment="SELECT * FROM Thread_Reply WHERE thread_id = '$threadID'";
  if($commentResult = (mysqli_query($conn,$sqlGetComment))){
      while($commentRow =mysqli_fetch_assoc($commentResult)){

       $replyID=$commentRow['reply_id'];
        $reply = $commentRow['reply_comment'];
        $poster = $commentRow['poster'];

         echo"<fieldset>";
         
          echo "<p>Reply:          $reply</p>";
          echo "<p>Posted by:      $poster</p>";
           if((isset($_SESSION['staff']))|| ($emailAddress === $poster)) {
            echo "<p><a href='deleteReply.php?reply_id=".$replyID."'>Delete Comment</a></p>";
          }
          echo"</fieldset>";
          echo "<br/>";
      }//store date and sort date 
}
// loop to write out all replies to this thread
?>
<form id ="threadReply"  action="threadReply.php" method="POST">
      <fieldset>
      <legend> Reply to Thread:</legend>
        <label for ="threadComment"> Comment: </label>
        <textarea name="threadComment" id = "threadComment" cols="30" rows="5" tabindex = "2" alt = "Enter your comment into the box" placeholder="Thread Reply" accesskey = "d"></textarea>
                <span class="error"> <?php echo $commentErr;?></span>
                <br/>
         <button type ="submit" alt ="Post your reply">Post </button>
        </fieldset>
        </form>
        <br/>
        <input Type="button" value="Back" onClick="history.go(-1);return true;" tabindex="23">

      </div >
     <?php include ("footer.php"); ?>
          
</div>
</form>
</body>
</html>
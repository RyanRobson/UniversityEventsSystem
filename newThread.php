<!DOCTYPE html >
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>New Thread</title>
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
        echo("Welcome Staff Member ". $_SESSION['staff']);
          $emailAddress=$_SESSION['staff'];
       } 
       else{
        $emailAddress ="";
       }
//error variables set as blank strings 
$titleErr= $commentErr="";
//checks the user input exsists, if it does, process, otheriwse set error messages 
      if($_SERVER["REQUEST_METHOD"] == "POST"){
           if (empty($_POST['title'])) {
            $titleErr = "Title is required";
           }
           else {
              $title = test_input($_POST['title']);
           }

            if (empty($_POST['comment'])){
              $commentErr ="Comment is required";
            } 
            else{
              $comment=test_input($_POST['comment']);
            } 
          $sqlThread ="INSERT INTO Bulletin_Board (`thread_title`, `thread_comments`,`thread_poster`) VALUES ('$title','$comment','$emailAddress')";
                 if(mysqli_query($conn, $sqlThread) === true)
                     {
                      header('Location: ' . $_SERVER['PHP_SELF']); //reloads page 
                     }
                     else {
                      echo"<p>Comment not posted - Error </p>";
                     }
                     mysqli_close($conn);
}
?>
        <form id ="newThread"  action="newThread.php" method="POST">
            <fieldset>
              <legend> New Thread:</legend>

        <label for ="title" >Comment Subject*</label>
        <input type ="text" name ="title" id ="title" alt ="Enter a subject for your comment" placeholder ="Thread Title" tabindex ="1"/>
        <span class="error"> <?php echo $titleErr;?></span>
        </br>
        <label for ="comment"> Comment* </label>
        <textarea name="comment" id = "comment" cols="30" rows="5" tabindex = "2" alt = "Enter your comment into the box" accesskey = "d" placeholder="Thread content"></textarea>
                <span class="error"> <?php echo $commentErr;?></span>
                <br/>
         <button type ="submit" alt ="Submit your comment">Post Thread </button>
                   <input Type="button" value="Back" onClick="history.go(-1);return true;">
        </fieldset>

         
      </div >

     <?php include ("footer.php"); ?>
          
</div>
</form>
</body>
</html>
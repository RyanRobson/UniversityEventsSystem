<?php
session_start();
include('database_conn.php');
//vailidates the uploaded file, restricts both filetype and file extension
$allowedExts = array("gif", "jpeg", "jpg", "png"); 
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
  
&& ($_FILES["file"]["size"] < 20000)
&& in_array($extension, $allowedExts))
{
if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
    //sets location for file to be saved, sets name, link and event_id
    $filePath ="/home/~unn_w12009661/public_html/PSEP_PART_B/Part B/Uploads/";
    $name=$_FILES["file"]["name"];
    $link=$filePath . $_FILES["file"]["name"];
    $event_id=$_SESSION['event_id'];
     //moves file from temp loc to uploaded loc
      move_uploaded_file($_FILES["file"]["tmp_name"],"Uploads/" . $_FILES["file"]["name"]);
      
      $sqlComment ="INSERT INTO Uploads (name, link, event_id) VALUES('$name', '$link', $event_id)";

      if(mysqli_query($conn, $sqlComment) === true)
       {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
       }
       else {
        echo"File not Uploaded - Error <br/>";
       }
       mysqli_close($conn);
   }}   
else{
  echo "invalid file";
}
?>
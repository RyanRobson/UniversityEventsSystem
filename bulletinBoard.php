<!DOCTYPE html >
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Discussion Board</title>
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
       }
         echo" <h1>Northumbria Events Forum</h1>";
         
         //only shows the new thread link if the user is logged in as user or staff
         if((isset($_SESSION['emailAddress'])) || (isset($_SESSION['staff']))){
           echo "<p><a href ='newThread.php'>Start a new thread here</a> or comment on an open thread shown below<br/></p>";

        

          $sqlThreadList ="SELECT thread_title FROM Bulletin_Board";
          $result=mysqli_query($conn,$sqlThreadList);
           while ($row= mysqli_fetch_array($result, MYSQLI_ASSOC)){
               
                  foreach($row as $key => $value){
                    echo "<ul>";
                    echo "<p><li><a href ='viewThread.php?thread_id=$value'>$value</a></li></p>";
                    echo "</ul>";
                   }
              
            }
          }
          elseif(!isset($_SESSION['emailAddress'])){
              echo"<a href ='login.php'>Log in</a> or <a href='createAccount.php'>Create an account</a> to access the forums";

          }
          
        ?>  
      </div>
      <?php include ("footer.php"); ?>
</div>
</body>
</html>
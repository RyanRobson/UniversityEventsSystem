<!DOCTYPE html>
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Staff Member Log In</title>
  </head>
  <body> 
<div id = "wrapper">
		 <?php include('navigation.php');?>
	       <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">    </br>
	      	     <div id = "main_content">
		  		
<?php
include('database_conn.php');
		$emailErr= "";
		$passwordErr="";
	
	session_start();
	if(isset($_SESSION['staff'])){
    	echo ("Welcome Staff Member " . $_SESSION['staff']);
	}
		
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (empty($_POST['emailAddress'])){
			 		$emailErr="Email address is required";
					$emailAddress = $_POST['emailAddress'];
			 	}
			 	else {
			 		$emailAddress = test_input($_POST['emailAddress']);
			 	}
		
		if (empty($_POST['password'])){
			 		$passwordErr="Password is required";
					$password =$_POST['password'];
			 	}
			 		else {
			 			$password=test_input($_POST['password']);	
						}

			$sql ="SELECT * FROM Staff WHERE email_address ='$emailAddress' AND password ='$password'";
			$loginSql = mysqli_query ($conn, $sql);
			if(mysqli_fetch_row($loginSql)){


				$_SESSION['staff'] = $emailAddress;
				$_SESSION['password'] = $password;
				
				echo ("Welcome Staff Member" . $_SESSION['staff']);
				header("Location: ".$_SERVER['PHP_SELF']);
			}	
			else{
				echo ("Email Address or Password is incorrect");
				}			
}
?>
		  		  <form id = "login" action="login.php" method="POST"> 
		  		  	<fieldset>
				  <legend> Staff Log in:  </legend>
					<label for="emailAddress">Email address: </label>
					<input type="email" name="emailAddress" id="emailAddress" tabindex = "1" alt = "Enter your username into the text box" accesskey = "u" 
					placeholder="Email Address"/>
					<span class ="error"><?php echo $emailErr;?></span>
					<br />		 
				
					<label for="password">Password:  </label>
						<input type = "password" name ="password" id = "password" maxlength="20" tabindex = "2" alt = "Enter your password into the text box" 
						accesskey = "p" placeholder ="Password"/>
						<span class ="error"><?php echo $passwordErr;?></span>
					     <br/>
						<input type ="submit" formaction = "staffLogin.php" value ="Login" tabindex = "3" alt = "Click the button to log in to the system" />
					</form>
						<input Type="button" value="Back" onClick="history.go(-1);return true;">
						<p>Don't have an account? Create one <a href = "createAccount.php"> here</a> </p>
						<?php 
						if (isset($_SESSION['staff'])){
						echo"<p>Create a new staff account <a href = 'createStaffAccount.php'>here</a> </p>";
					}
					?>
						<p>Users can login <a href ="login.php"> here </a></p>
						</fieldset>
		 </div>  
		<?php include ("footer.php"); ?>
</div>
</body>
</html>

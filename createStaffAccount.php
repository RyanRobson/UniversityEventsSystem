<!DOCTYPE html>
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Create Staff Account</title>
  </head>
  <body> 
<div id = "wrapper">
	  <?php include('navigation.php');?>
	  <img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">   </br>
      			<div id = "main_content">	
      <?php
      include('database_conn.php');
      session_start();
      	if(isset($_SESSION['staff'])){
        echo("Welcome Staff Member ". $_SESSION['staff']);
    }
    if(!isset($_SESSION['staff'])){
    	header('Location: index.php');
    }
      // error variables used to output each error message to the form, initialised as a blank string
        $passwordErr= $confirmPasswordErr= "";
		$emailErr= 	$confirmEmailErr= "";
		$passCorrect=True;
		//checks each required input on the form for data entered, if empty, value of the error message is set
		// if data is in the field, the data is processed using the test_input() method
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if (empty($_POST['password'])){
				$passwordErr="Password is required";
				$password =$_POST['password'];
			}
				else {
					$password=test_input($_POST['password']);
				}
			if (empty($_POST['confirmPassword'])){
				$confirmPasswordErr ="Password confirmation is required";
				$confirmPassword=$_POST['confirmPassword'];
			}
				else {
					$confirmPassword=test_input($_POST['confirmPassword']);
			}
			if (empty($_POST['emailAddress'])){
				$emailErr="Email address is required";
				$emailAddress=$_POST['emailAddress'];
			}
			else {
				$emailAddress=test_input($_POST['emailAddress']);
			}
			if(empty($_POST['confirmEmail'])){
				$confirmEmailErr="Email address confirmation is required";
				$confirmEmail=$_POST['confirmEmail'];
			}
			else{
				$confirmEmail=test_input($_POST['confirmEmail']);
			}
				
			// checks the password for a minimum length of 8 characters
			if (strlen($password) < 8 && (strlen($confirmPassword) <8))
			{
				$passwordErr = "Password needs to be at least 8 characters";
				$passCorrect=false;
			}
			// checks the password and confirm password, and email address and confirm email are identical
			if ($password === $confirmPassword && $emailAddress === $confirmEmail && $passCorrect =true)
				{
					// querys the User table to check for the inputted email address to avoid duplicste accounts 
				$sqlEmail ="SELECT COUNT(*) FROM Staff WHERE email_address = '$emailAddress'";
				$rowNo = mysqli_query($conn, $sqlEmail) ;
				$result = mysqli_fetch_row($rowNo);
				$row_returned = $result[0];
						//email already exisits in table 
					if($row_returned >=1)
					{
						$emailErr ="Email Address has already been registered";
						$confirmEmailErr ="Email Address has already been registered";
					}
					else{ 
						//email address doesnt exist in table 
						$sql ="INSERT INTO Staff (password, email_address)
						VALUES ('$password', '$emailAddress')";

							if (mysqli_query($conn, $sql) === true)
						{
							// sends a confirmation email to the account holder
							$to = $emailAddress;
							$subject = "Account Confirmation";
							$message = "Hello $emailAddress, your staff account has been created using the following information: 
							Email address: $emailAddress 
							Password: $password";
							$headers ="From: ryan.robson@nortumbria.ac.uk";
							mail ($to ,$subject , $message, $headers );
							clear_data();
							echo("Account Created");
							
						}
						mysqli_close($conn);
					}		
			}
		}
		
	?>
		<form id = "createStaffAccount" action=""<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"" method="POST"> 
		<fieldset>
			
		  	<legend> Staff Account Information:</legend>
		  		
			  	<label for ="email">Email address:*</label>
					 <input type = "email" name = "emailAddress" id = "emailAddress" tabindex = "5" alt = "Enter your email address" 
					 accesskey="e" placeholder="Email Address"/>
					 <span class ="error"> <?php echo $emailErr;?></span>
					 <br/>
				<label for ="confirmEmail">Confirm your email address:*</label>
					 <input type = "email" name = "confirmEmail" id = "confirmEmail" tabindex = "6" alt = "Confrim your email address" 
					 accesskey="a" placeholder="Email Address" />
					 <span class ="error"> <?php echo $confirmEmailErr;?></span>
					 <br/>	
				<label for="password">Password (Minimum 8 characters):*</label>
				     <input type="password" name="password" id="password" maxlength="20" tabindex="7" alt="Enter your password into the text box"
				      accesskey="p" placeholder="Password"/>
				     <span class ="error"> <?php echo $passwordErr;?></span>
				     <br/>
				<label for="passwordConfim">Confirm your password:*</label>
				     <input type = "password" name ="confirmPassword" id = "confirmPassword" maxlength="20" tabindex = "8"
				      alt = "Confirm password in the text box" accesskey = "c" placeholder="Password"/>
				     <span class ="error"> <?php echo $confirmPasswordErr;?></span>
				     <br/>	
				     <button type ="submit" formaction = "createStaffAccount.php" alt ="Create an account" tabindex ="21">Create account </button>
				     <input type="reset" value="Clear" tabindex = "22" alt = "Click the button to clear the form" />
				     <input Type="button" value="Back" onClick="history.go(-1);return true;" tabindex="23">

				     </fieldset>
					</form>
			    </div> 
			 <?php include ("footer.php"); ?>
</div>
</body>
</html>
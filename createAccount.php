<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />


    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Create Account</title>
  </head>
  <body> 
<div id = "wrapper">
	 <?php include('navigation.php');?>
      <?php
      session_start();
      include('database_conn.php');
      // error variables used to output each error message to the form, initialised as a blank string
        $titleErr= $fornameErr= $surnameErr= $passwordErr= $confirmPasswordErr= "";
		$emailErr= 	$confirmEmailErr= $genderErr= $address1Err = $postcodeErr= "";
		$passMatchErr= $emailMatchErr= $dobErr= $contactNoErr="";

		//checks each required input on the form for data entered, if empty, value of the error message is set
		// if data is in the field, the data is processed using the test_input() method
		if($_SERVER["REQUEST_METHOD"] == "POST"){
			if(empty($_POST['title'])){
				$titleErr ="Title Is required";
			}
			else{
				$title = test_input($_POST['title']);
			}
			if (empty($_POST['forname'])){
				$fornameErr="Forename is required";
				$forname=$_POST['forname'];
			 }
				else{
					$forname = test_input($_POST['forname']);
			}
			if (empty($_POST['surname'])){
				$surnameErr ="Surname is required";
				$surname=$_POST['surname'];
			}
				else{
					$surname = test_input($_POST['surname']);			 			
			}
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
			if(empty($_POST['gender'])){
				$genderErr="Gender is required";
			}
			else {
				$gender=test_input($_POST['gender']);
			}
			if(empty($_POST['address1'])){
				$address1Err="Address line 1 is required";
			}
			else {
				$address1=test_input($_POST['address1']);
			}
			if (empty($_POST['postcode'])){
				$postcodeErr="Postcode is required";
			}
			else {
				$postcode =test_input($_POST['postcode']);
			}
			if (empty($_POST['dob'])){
				$dobErr ="Date Of Birth is required";
			}
			else{
				$dob = ($_POST['dob']);
			
			if(empty($_POST['contactNo'])){
				$contactNoErr="Contact Number is required";
			}
			else{
				$contactNo=test_input($_POST['contactNo']);
				}
			// sets the value of the not required fields 
			$middleName=test_input($_POST['middleName']);
			$address2=test_input($_POST['address2']);
			$town =test_input($_POST['town']);
			$city=test_input($_POST['city']);
			$county=test_input($_POST['county']);
			
			$user_type =false; // only creates registrant accounts, not used to make staf accounts 
				
			// checks the password for a minimum length of 8 characters
			if (strlen($password) < 8 && (strlen($confirmPassword) <8))
			{
				$passwordErr = "Password needs to be at least 8 characters";
				$passCorrect=false;
			}
			// checjs the password and confirm password, and email address and confirm email are identical
			if ($password === $confirmPassword && $emailAddress === $confirmEmail && $passCorrect =true)
				{
					// querys the User table to check for the inputted email address to avoid duplicste accounts 
				$sqlEmail ="SELECT COUNT(*) FROM User WHERE email_address = '$emailAddress'";
				$rowNo = mysqli_query($conn, $sqlEmail) ;
				$result = mysqli_fetch_row($rowNo);
				$row_returned = $result[0];
				
					if($row_returned >=1)
					{
						$emailErr ="Email Address has already been registered";
						$confirmEmailErr ="Email Address has already been registered";
						$newEmail =False;
					}
					else{ 
						
						$sql ="INSERT INTO User (forename, surname, middle_name, title, D_O_B, user_type, gender, password, email_address, addressline1, addressline2, town, city, county, postcode, mobile_number)
						VALUES ('$forname', '$surname', '$middleName', '$title', '$dob','$user_type', '$gender', '$password', '$emailAddress', '$address1','$address2','$town','$city','$county','$postcode','$contactNo')
						";

							if (mysqli_query($conn, $sql) === true)
						{
							// sends a confermation email to the account holder
							
							$to = $emailAddress;
							$subject = "Account Confirmation";
							$message = "Hello $forname $middleName $surname, your account has been created using the following information: 
							Email address: $emailAddress 
							Password: $password";
							$headers ="From: webmaster@northumbriaEvents.ac.uk";
							mail ($to ,$subject , $message, $headers );
							clear_data();
							echo("Account Created");
							
						}
						mysqli_close($conn);
					}		
			}
		}
		}
		
	?>
	<img src="Res/northumbriaLogo.png" alt = "Northumbria University Logo">    </br>
			<div id = "main_content">
				
					<form id = "createAccount" action=""<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"" method="POST"> 
					<fieldset>
						
					  	<legend> Account Information:</legend>
					  		<label for "title">Title:*</label>
					  			<select name = "title" id="title" tabindex="1" accesskey="1" alt = "Enter your title into the box">
									<option value="0">
					  				<option value="Mr">Mr
					  				<option value="Mrs">Mrs
					  				<option value="Ms">Ms
					  				<option value="Dr">Dr
					  			</select>
					  			<span class ="error"> <?php echo $titleErr;?></span>
					  			<br/>
						  	<label for ="forname">Forename:*</label>
						  		<input type ="text" name ="forname" id ="forname" maxlength = "20" tabindex = "2" alt = "Enter your forname into the text box"
						  		accesskey="f" placeholder ="Forename"/>
						  		<span class="error"> <?php echo $fornameErr;?></span>
						  		<br/>
						  	<label for ="middleName">Middle name:</label>
						  		<input type ="text" name ="middleName" id="middleName" maxlength="20" tabindex ="3" alt="Enter your middle name into the text box"
						  	     accesskey = "m" placeholder="Middle Name" />
						  		<br/>
						  	<label for ="surname">Surname:*</label>
						  		 <input type = "text" name ="surname" id="surname" maxlength = "20" tabindex = "4" alt = "Enter your surname into the text box"
						  		  accesskey="s" placeholder="Surname"/>
						  		 <span class ="error"> <?php echo $surnameErr;?></span>
						  		 <br/>	

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
							<label for "DOB">Date Of Birth:(DD-MM-YYYY)*</label>
								<input type ="date" name="dob" id="dob"/>
								<span class ="error"> <?php echo $dobErr;?></span>
								</br>
							<label for "gender">Gender:*</label>
								<input type ="radio" name = "gender" id ="gender" value ="male" alt ="Male Gender" tabindex ="12">Male
								<br/>
								<input type ="radio" name = "gender" id ="gender" value ="female" alt ="Female Gender" tabindex ="13">Female
								<span class ="error"> <?php echo $genderErr;?></span>
								<br/>
								<legend><b>Address</b></legend>
							<label for "address1">Address line 1:*</label>
									<input type ="text" name ="address1" id ="address1" alt="Enter your address line 1 into the textbox" 
									accesskey="1" placeholder="Address Line 1" tabindex ="14"/>
									<span class ="error"> <?php echo $address1Err;?></span>
									<br/>
							<label for "address2">Address line 2:</label>
									<input type ="text" name ="address2" id ="address2" alt="Enter your address line 2 into the textbox" 
									accesskey="2" placeholder="Address Line 2" tabindex ="15" />
									<br/>
							<label for "town">Town:</label>
									<input type ="text" name ="town" id ="town" alt ="Enter your town into the textbox" 
									accesskey ="3" placeholder ="Town" tabindex ="16"/>
									<br/>
							<label for "city">City:</label>
									<input type ="text" name ="city" id = "city" alt="Enter your city into the textbox" 
									accesskey = "4" placeholder = "City" tabindex ="17"/>
									<br/>
							<label for "county">County:</label>
									<input type ="text" name="county" id="county" alt="Enter your county into the textbox" 
									accesskey ="5" placeholder ="County" tabindex ="18"/>
									<br/>
							<label for "postcode">Postcode:*</label>
									<input type ="text" name="postcode" id="postcode" maxlength="8" alt ="Enter your postcode into the textbox" 
									accesskey ="6" placeholder ="Postcode" tabindex ="19"/>
									<span class ="error"> <?php echo $postcodeErr;?></span>
									<br/>
							<label for "contactNo">Contact Phone Number*</label>
									<input type ="number" name ="contactNo" id ="contactNo" maxlength="11" alt ="Enter your contact phone number into the textbox" 
									accesskey="7" placeholder="Contact Number" tabindex ="20"/>
									<span class ="error"><?php echo $contactNoErr;?></span>
									<br/>
									<p>* Required fields</p>
									<br/>
						
							     <button type ="submit" formaction = "createAccount.php" alt ="Create an account" tabindex ="21">Create account </button>
							     <input type="reset" value="Clear" tabindex = "22" alt = "Click the button to clear the form" />
							     <input Type="button" value="Back" onClick="history.go(-1);return true;" tabindex="23">

							     </fieldset>
								</form>
			    </div> 
			<?php include ("footer.php"); ?>
</div>
</body>
</html>
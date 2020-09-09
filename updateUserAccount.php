<!DOCTYPE html>
  <head>
  	<link href="mystyle.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="Content-Type"
	  content="text/html;
	  charset=utf-8" />
    <title>Update Account Information</title>
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
     
    
          //retireves all of the informationa bout an event using the event id passed from index
          // the event information is placed in an array called $eventInfo[] and echoed to the web page
      $sqlUser="SELECT * FROM User WHERE email_address ='$emailAddress'";
      if($res =mysqli_query($conn,$sqlUser)){
          $idRow =mysqli_fetch_array($res,MYSQLI_ASSOC);
          $userInfo =array();
          foreach($idRow as $key => $value){
            $userInfo[] =$value;
          }
      
                echo "<p><b>User ID:</b> $userInfo[0]</p>";
                echo "<p><b>Title:</b> $userInfo[4]</p>";
                echo "<p><b>Forename:</b> $userInfo[1]</p>";
                echo "<p><b>Middle name:</b> $userInfo[3]</p>";
                echo "<p><b>Surname:</b> $userInfo[2]<p>";
                echo "<p><b>Email Address:</b> $userInfo[9]</p>";
                
                echo "<p><b>Date Of Birth:</b> $userInfo[5]<p>";

               
           }
           else{
            echo " id error";       
           }



if($_SERVER["REQUEST_METHOD"] == "POST"){
      if(!empty($_POST['title'])){
                  $newTitle = test_input($_POST['title']);
                }
                else{
                  $newTitle= $userInfo[4];
                }

      if(!empty($_POST['forname'])){
                  $newForname = test_input($_POST['forname']);
                }
                else{
                  $newForname= $userInfo[1];
                }
      if(!empty($_POST['middleName'])){
                  $newMiddleName = test_input($_POST['middleName']);
                }
                else{
                  $newMiddleName= $userInfo[3];
                }
      if(!empty($_POST['surname'])){
                  $newSurname = test_input($_POST['surname']);
                }
                else{
                  $newSurname= $userInfo[2];
                }

       if(!empty($_POST['address1'])){
                  $newAddress1 = test_input($_POST['address1']);
                }
                else{
                  $newAddress1= $userInfo[10];
                }
      if(!empty($_POST['address2'])){
                  $newAddress2 = test_input($_POST['address2']);
                }
                else{
                  $newAddress2= $userInfo[11];
                }
      if(!empty($_POST['town'])){
                  $newTown = test_input($_POST['town']);
                }
                else{
                  $newTown= $userInfo[12];
                }
     if(!empty($_POST['city'])){
                  $newCity = test_input($_POST['city']);
                }
                else{
                  $newCity= $userInfo[13];
                }
      if(!empty($_POST['county'])){
                  $newCounty = test_input($_POST['county']);
                }
                else{
                  $newCounty= $userInfo[14];
                }
      if(!empty($_POST['postcode'])){
                  $newPostcode = test_input($_POST['postcode']);
                }
                else{
                  $newPostcode= $userInfo[15];
                }

      if(!empty($_POST['contactNo'])){
                  $newContactNo = test_input($_POST['contactNo']);
                }
                else{
                  $newContactNo= $userInfo[16];
                }
                $sql = "UPDATE User SET title = '$newTitle' , forename ='$newForname', surname ='$newSurname', middle_name ='$newMiddleName',
                 addressline1 = '$newAddress1', addressline2='$newAddress2', town ='$newTown', city = '$newCity', county = '$newCounty', 
                 postcode='$newPostcode', mobile_number ='$newContactNo' WHERE user_id = '$userInfo[0]'";

 if(mysqli_query($conn, $sql) === true)
       {
        
        header('Location: '.$_SERVER['REQUEST_URI']);
        echo ("Account Updated");
       }
       mysqli_close($conn);
      }  
}

else{
  echo "Please <a href = login.php> Log in </a> or <a href = createAccount.php> create an account </a> here to view account details";
}
?>
          <form id = "updateUserAccount" action=""<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"" method="POST"> 
          <fieldset>
            
              <legend> New Account Information:</legend>
                <label for "title">Title:</label>
                  <select name = "title" id="title" tabindex="1" accesskey="1" alt = "Enter your title into the box">
                  <option value="0">
                    <option value="Mr">Mr
                    <option value="Mrs">Mrs
                    <option value="Ms">Ms
                    <option value="Dr">Dr
                  </select>
           
                  <br/>
                <label for ="forname">Forename:</label>
                  <input type ="text" name ="forname" id ="forname" maxlength = "20" tabindex = "2" alt = "Enter your forname into the text box"
                  accesskey="f" placeholder ="Forename"/>
            
                  <br/>
                <label for ="middleName">Middle name:</label>
                  <input type ="text" name ="middleName" id="middleName" maxlength="20" tabindex ="3" alt="Enter your middle name into the text box"
                     accesskey = "m" placeholder="Middle Name" />
                  <br/>
                <label for ="surname">Surname:</label>
                   <input type = "text" name ="surname" id="surname" maxlength = "20" tabindex = "4" alt = "Enter your surname into the text box"
                    accesskey="s" placeholder="Surname"/>
       
                   <br/>  
                <legend><b>Address</b></legend>
              <label for "address1">Address line 1:</label>
                  <input type ="text" name ="address1" id ="address1" alt="Enter your address line 1 into the textbox" 
                  accesskey="1" placeholder="Address Line 1" tabindex ="14"/>
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
              <label for "postcode">Postcode:</label>
                  <input type ="text" name="postcode" id="postcode" maxlength="8" alt ="Enter your postcode into the textbox" 
                  accesskey ="6" placeholder ="Postcode" tabindex ="19"/>
                 
                  <br/>
              <label for "contactNo">Contact Phone Number</label>
                  <input type ="number" name ="contactNo" id ="contactNo" maxlength="11" alt ="Enter your contact phone number into the textbox" 
                  accesskey="7" placeholder="Contact Number" tabindex ="20"/>
                  
                  <br/>
                  <p>* Required fields</p>
                  <br/>
            
                   <button type ="submit" formaction = "updateUserAccount.php" alt ="update account information" tabindex ="21">Update account </button>
                   <input type="reset" value="Clear" tabindex = "22" alt = "Click the button to clear the form" />
                   <input Type="button" value="Back" onClick="history.go(-1);return true;" tabindex="23">

                   </fieldset>
                </form>
      </div >

      <div id ="footer" >
            <?php include ("footer.php"); ?>
          
</div>
</form>
</body>
</html>
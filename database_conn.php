<?php
	$host = 'localhost';
	$username = 'unn_w12009661';
	$password = 'group6';
	
	$conn = mysqli_connect ($host,$username ,$password ) 
	or die("Could Not Connect to MySQL!");
	mysqli_select_db($conn,"unn_w12009661")
	or die("Could Not Open Database:".mysqli_error());

// trims data, and removes and special characters
//used to parse user input from forms
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
//clears data from the user input 
function clear_data(){
unset($title, $forname, $surname, $middleName, $emailAddress, $confirmEmail,$password, $confirmPassword, $gender, $address1, $address2, $town,
	$city, $county, $postcode,$home, $mobNo);
}
?>


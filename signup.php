<?php

     
    // validation expected data exists
    if(/*!isset($_GET['id']) ||*/
		!isset($_GET['name']) ||
		!isset($_GET['email']) ||
        !isset($_GET['password']) 
        ) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');      
    }
    
     
	//$id = $_GET['id'];
	$name = $_GET['name'] ;
	$email=$_GET['email'] ;
     $password=$_GET['password'];

    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
  if(!preg_match($email_exp,$email)) {
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
  }
    $string_exp = "/^[A-Za-z .'-]+$/";
  if(!preg_match($string_exp,$name)) {
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
  }

  if(strlen($error_message) > 0) {
    died($error_message);
  }

$con = mysql_connect("localhost", "campuswa_jungtae", "jungtae") ;
//$con = mysql_connect("localhost", "root", "") ;
if (!$con)
  {

  die('Could not connect: ' . mysql_error());
  }
 else
 {

     mysql_select_db("campuswa_simple");
     //mysql_select_db("simple");
     
     $find_duplicate = mysql_query("SELECT email FROM user WHERE email = '$email' AND authentication = 'approved'");
     if(mysql_fetch_array($find_duplicate)) {
         echo "This email has already been registered." ;
         
     }

     else{
         $authentication = rand_string(15);
         $sql = "INSERT INTO user(name,email,password,authentication) VALUES( '$name', '$email', SHA1('$password'),'$authentication')";
         mysql_query ($sql);
         
         echo "Registration authentication has been sent to your registered email." ;
         
         
         $contact = $email;
         $subject = "Welcome to CampusWave!";
         
         $message = "<html><center>";
	 $message .= "<head><font size=5 color=\"green\">Thank you for signing up with CampusWave!</font></head><body>";
 	 $message .= "<a href=\"http://campuswave.ca/authentication.php?authentication=$authentication&email=$email\">Click here to confirm your registration.</a>";
         $message = rtrim(chunk_split(base64_encode($message)));
        
         $headers = "From: cwteam@campuswave.ca\r\n";
	 $headers .= "Reply-To: cwteam@campuswave.ca\r\n";
	 $headers .= "Return-Path: cwteam@campuswave.ca\r\n";
	 $headers .= "MIME-Version: 1.0\r\n";
	 $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	 $headers .= "Content-Transfer-Encoding: base64\r\n";
         
         mail($contact, $subject, $message, $headers);
         
     }
 }

    
 
//echo "Your account has been created." ;




function died($error) {
        // your error code can go here
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br /><br />";
        echo $error."<br /><br />";
        echo "Please go back and fix these errors.<br /><br />";
        die();
    }
    
function rand_string( $length ) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

	$size = strlen( $chars );
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[ rand( 0, $size - 1 ) ];
	}

	return $str;
}    
    
?>
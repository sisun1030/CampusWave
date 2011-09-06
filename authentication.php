<?php

   if(/*!isset($_GET['id']) ||*/
		!isset($_GET['authentication']) ||
		!isset($_GET['email'])
        ) {
        died('We are sorry, but there appears to be a problem with the form you submitted.');      
    }
    else{
        
        $email = $_GET['email'];
             
        $con = mysql_connect("localhost", "campuswa_jungtae", "jungtae") ;
        //$con = mysql_connect("localhost", "root", "") ;
        if (!$con)
          {

          die('Could not connect: ' . mysql_error());
          }
         else
         {
            mysql_select_db("campuswa_simple");
            $sql = "UPDATE user SET authentication = 'approved' WHERE email = '$email'";
            mysql_query ($sql);
            //echo "$sql";
            header("Location: http://campuswave.ca");
        }
    }
?>
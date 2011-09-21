
<?php
echo $this->Session->flash('auth');

?>


<?php echo $this->Html->css('login'); ?>



<?php


/*
define('APP_ID', '141843382572716');

define('APP_SECRET', '2a4bfe0b0671e6d785af912cd81d269e');



 function get_facebook_cookie($app_id, $app_secret) {

  $args = array();

  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);

  ksort($args);

  $payload = '';

  foreach ($args as $key => $value) {

    if ($key != 'sig') {

      $payload .= $key . '=' . $value;

    }

  }

  if (md5($payload . $app_secret) != $args['sig']) {

    return null;

  }

  return $args;

}



$cookie = get_facebook_cookie(APP_ID, APP_SECRET);

*/

/*

error:https:// wrapper is disabled in the server configuration by allow_url_fopen=0

$user = json_decode(file_get_contents(

    'https://graph.facebook.com/me?access_token=' .

    $cookie['access_token'])); */

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"

   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

   <meta http-equiv="Content-type" content="text/html; charset=utf-8">

   <title>Campus Wave</title>

</head>
<?php 
	
	echo $this->Html->script('jquery-1.6.1');
	?>


   <div id="fb-root"></div>

   <script src="http://connect.facebook.net/en_US/all.js"></script>

   <script>

      FB.init({ 

         appId:'141843382572716', cookie:true, 

         status:true, xfbml:true 

      });

      FB.Event.subscribe('auth.login', function(response) {

        window.location.reload();

      });

   </script>

   





<script type="text/javascript" charset="utf-8">


	//POPUP  

	//0 means disabled; 1 means enabled;  

	var popupStatus = 0;  

	

	function loadPopup(){  



		if(popupStatus==0){  

			$("#backgroundPopup").css({  

			"opacity": "0.8"  

			});  

			$("#backgroundPopup").fadeIn("slow");  

			$("#popupContact").fadeIn("slow");  

			popupStatus = 1;  

		}  

	}  

	

	function disablePopup(){  

		if(popupStatus==1){  

			$("#backgroundPopup").fadeOut("slow");  

			$("#popupContact").fadeOut("slow");  

			popupStatus = 0;  

		}  

	}  

	

	function centerPopup(){   

		var windowWidth = document.documentElement.clientWidth;  

		var windowHeight = document.documentElement.clientHeight;  

		var popupHeight = $("#popupContact").height();  

		var popupWidth = $("#popupContact").width();  



		$("#popupContact").css({  "position": "absolute",  "top": windowHeight/2-popupHeight/2,  

			"left": windowWidth/2-popupWidth/2  });  

		  

		$("#backgroundPopup").css({  

		"height": windowHeight  

		});  

		   

	}  

	function validateEmail(email)
	{
		var x=email;
		var atpos=x.indexOf("@");
		var dotpos=x.lastIndexOf(".");
		if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
		  {
		  return false;
		  }
		else
		{
			return true;
			}
	}


	function trim(str) {
		return str.replace(/^\s*/, "").replace(/\s*$/, "");
	}
	

	function check()
	{
		var pswd = (document.getElementById("passwordparam")).value;
		var pswd2 =(document.getElementById("passwordparam2")).value;
		var name = (document.getElementById("nameparam")).value;
		var email = (document.getElementById("emailparam")).value;
		
		if (name == "" || email == "" || pswd == "" || pswd2 == "")
		{
			alert("Please fill in all the fields.");
			return false;
		}
		
		if ((trim(name) != name)||(trim(email) != email)||(trim(pswd) != pswd)||(trim(pswd2) != pswd2))
		{
			alert("Please remove any padding spaces in any of the fields.");
			return false;
		}
		
		if (!validateEmail(email))
		{
			alert("Not a valid email.");
			return false;
		}
		
		if (pswd != pswd2)
		{
			alert("The passwords do not match.");
			return false;
		}
		
		
		
	}

	function ajaxSubmit() {

		var password=(document.getElementById("passwordparam")).value;

		var password2=(document.getElementById("passwordparam2")).value;

		if(password == password2)

		{

			var xmlhttp;

			if (window.XMLHttpRequest)

			  {// code for IE7+, Firefox, Chrome, Opera, Safari

			  xmlhttp=new XMLHttpRequest();

			  }

			else

			  {// code for IE6, IE5

			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

			  }



			var name=(document.getElementById("nameparam")).value;	

			var email=(document.getElementById("emailparam")).value;

			

			var file="signup.php?name="+name+"&email="+email+"&password="+password;

			

			xmlhttp.onreadystatechange=function(){

				if (xmlhttp.readyState==4 && xmlhttp.status==200){

				

					alert(xmlhttp.responseText);

				}

					

			}

			

			xmlhttp.open("GET", file, true);

			xmlhttp.send();

		}

		else

		{

			alert("the passwords do not match");

		}		

	}

	//TABMENU
	$(document).ready(function() {	
		//Get all the LI from the #tabMenu UL
		$('#tabMenu > li').click(function(){
			//remove the selected class from all LI    
			$('#tabMenu > li').removeClass('selected');
			//Reassign the LI
			$(this).addClass('selected');
		    //Hide all the DIV in .boxBody
			$('.boxBody div').hide();
			//Look for the right DIV in boxBody according to the Navigation UL index, therefore, the arrangement is very important.
			$('.boxBody div:eq(' + $('#tabMenu > li').index(this) + ')').slideDown('1500');

		}).mouseover(function() {
		//Add and remove class, Personally I dont think this is the right way to do it, anyone please suggest    

		$(this).addClass('mouseover');
		$(this).removeClass('mouseout');   
		}).mouseout(function() {
			//Add and remove class
			$(this).addClass('mouseout');
			$(this).removeClass('mouseover');    
		});

		//Mouseover with animate Effect for Category menu list
		$('.boxBody #category li').mouseover(function() {
			//Change background color and animate the padding
			$(this).css('backgroundColor','#888');
			$(this).children().animate({paddingLeft:"20px"}, {queue:false, duration:300});
		}).mouseout(function() {

			//Change background color and animate the padding
			$(this).css('backgroundColor','');
			$(this).children().animate({paddingLeft:"0"}, {queue:false, duration:300});
		});  		

		//Mouseover effect for Posts, Comments, Famous Posts and Random Posts menu list.
		$('.boxBody li').click(function(){
			window.location = $(this).find("a").attr("href");
		}).mouseover(function() {
			$(this).css('backgroundColor','#888');
		}).mouseout(function() {
			$(this).css('backgroundColor','');
		});  	
	});

</script>


<body onload="init();">

<?php //if(!$cookie) {//or our login cookie ?>

	<script type="text/javascript" charset="utf-8">

		$(document).ready(function(){  

			centerPopup();

			loadPopup();

		});

	</script>

<?php //} ?>



   

    <div id="popupContact">  

	<div class="box">

		<ul id="tabMenu">

			<li class="signin selected">Sign In</li>

			<li class="signup">Sign Up!</li>

		</ul>

		<div class="boxTop"></div>



		<div class="boxBody">

	  

			<div id="signin" class="show">
				
				<?php /* echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' =>'login')));
echo $this->Form->input('User.email');
echo $this->Form->input('User.password');
echo $this->Form->end('Login');*/ ?>
				
				<table>   
				<form id="UserLoginForm" method="post" action="/index.php/users/login" accept-charset="utf-8">
					<input type="hidden" name="_method" value="POST" />
					<tr>

						<td><label for='email' style="font-size:12px" >Email:</label></td>

						<td><input name="data[User][email]" type="text" maxlength="50" id="UserEmail" /></td>

					</tr>

					<tr>

						<td><label for='password' style="font-size:12px" >Password:</label></td>

						<td><input type="password" name="data[User][password]" id="UserPassword" maxlength="50"/></td>

					</tr>

					
					<tr>

						<td/>

						<td><input type="checkbox" name="remember" value="remember" style='float:left;'>

							<label for='remember' style="font-size:12px; float:left;" >Remember Me</label>

							<input type='submit' name='Submit' value='Login' style="background-color:#F8D300; float:right;" /></td>
							
					</tr>
				</form>
				</table>

				<a href='' style='float:right; padding-right:15px; padding-top:5px;'>Forgot your password?</a>

				<fb:login-button style='float:right; padding:5px 15px 0 0;'>Login with Facebook</fb:login-button>

			</div>  

		  

			<div id="signup">

				 <table>
					<form id="UserSignupForm" method="post" action="/index.php/users/signup" accept-charset="utf-8">
					<input type="hidden" name="_method" value="POST" />
					<tr>

						<td><label for='name' style="font-size:12px" >Full Name:</label></td>

						<td><input type='text' name='data[User][name]' id='nameparam' style="width:200px"  maxlength="50" /></td>

					</tr>

					<tr>

						<td><label for='email' style="font-size:12px" >Email:</label></td>

						<td><input type='text' name='data[User][email]' id='emailparam' style="width:200px"  maxlength="50" /></td>

					</tr>

					<tr>

						<td><label for='password' style="font-size:12px" >Password:</label></td>

						<td><input type='password' name='data[User][password]' id='passwordparam' maxlength="50" style="width:200px" /></td>

					</tr>

						<td><label for='password2' style="font-size:12px" >Confirm:</label></td>

						<td><input type='password' name='password2' id='passwordparam2' maxlength="50" style="width:200px"/></td>

					</tr>

					<tr>

						<td/>

						<td><input type='submit' name='Submit' value='Submit' style="background-color:#F8D300; float:right;" onClick="return check();" /></td>

					</tr>
				</form>
				</table>

			</div>



		</div>



		<div class="boxBottom"></div>



	</div>

   </div><!--popup--> 

     

   <div id="backgroundPopup"></div>

   

   <div id ="footer" class="footer">

 

   </div>

   



</body>
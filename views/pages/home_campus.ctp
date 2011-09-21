

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"

   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

   <meta http-equiv="Content-type" content="text/html; charset=utf-8">

   <title>Campus Wave</title>

</head>


   

   <script src="./scripts/dhtmlxScheduler/codebase/dhtmlxscheduler.js" type="text/javascript" charset="utf-8"></script>

   <link rel="stylesheet" href="./scripts/dhtmlxScheduler/codebase/dhtmlxscheduler.css" type="text/css" media="screen" title="no title" charset="utf-8">



	<script src="./scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_minical.js" type="text/javascript" charset="utf-8"></script>

	<link rel="stylesheet" href="./scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_ext.css" type="text/css" media="screen" title="no title" charset="utf-8">



<style type="text/css" media="screen">



</style>



<script type="text/javascript" charset="utf-8">

	function init() {

	

		scheduler.form_blocks["campus_editor"]={

			render:function(sns){

				return "<div class=\"dhx_cal_ltext\" style=\"height:60px;\"><textarea rows=\"3\" cols=\"25\" readonly=\"readonly\">This is a readonly description </textarea></div>";

			},

			set_value:function(node,value,ev){

				node.childNodes[1].value=value||"";

				node.childNodes[4].value=ev.details||"";

			},

			get_value:function(node,ev){

				ev.location = node.childNodes[4].value;

				return node.childNodes[1].value;

			},

			focus:function(node){

				var a=node.childNodes[1]; a.select(); a.focus(); 

			}

		}

		

		/*scheduler.form_blocks["campus_event_title"]={

			render:function(sns){			

				return "<div class='campus_event_title' style='height:10px;'><form><label>Title<img src='/images/title.jpg' alt='title' /> </label></form></div>";

			},

			set_value:function(node,value,ev){ //this is a place holder

				node.firstChild.value=value||"";

				node.firstChild.disabled = ev.disabled;

			}

		}*/

		

		scheduler.form_blocks["campus_organizer"]={

			render:function(sns){			

				return "<label id='Organizer' style='height:50px;'>This is organizer</label><label id='name'></label>";

			},

			set_value:function(node,value,ev){ //this is a place holder

				node.firstChild.value=value||"";

				node.firstChild.disabled = ev.disabled;

			}

		}

		

		scheduler.config.lightbox.sections=[

			/*{ name:"title", height:10, map_to:"auto", type:"campus_event_title"},*/			

			{ name:"organizer", height:50,map_to:"",type:"campus_organizer" },

			{ name:"description", height:200, map_to:"text", type:"campus_editor", focus:true },			

			{ name:"time", height:72, type:"time", map_to:"auto"}	

		]

	

	

		scheduler.config.multi_day = true;

		

		scheduler.config.xml_date="%Y-%m-%d %H:%i";

		scheduler.init('scheduler_here',null,"week");

		scheduler.load("./scripts/dhtmlxScheduler/common/events.xml");

		

		

		

	}

	

	function show_minical(){

		if (scheduler.isCalendarVisible())

			scheduler.destroyCalendar();

		else

			scheduler.renderCalendar({

				position:"dhx_minical_icon",

				date:scheduler._date,

				navigation:true,

				handler:function(date,calendar){

					scheduler.setCurrentView(date);

					scheduler.destroyCalendar()

				}

			});

	}

			

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



	<script language='javascript'>

		

	</script>


   <div id="scheduler_here" class="dhx_cal_container" style='width:900px; height:425px; position:absolute; top:175px; left:50px;padding-bottom:30px;'>

      <div class="dhx_cal_navline">

         <div class="dhx_cal_prev_button">&nbsp;</div>

         <div class="dhx_cal_next_button">&nbsp;</div>

         <div class="dhx_cal_today_button"></div>

         <div class="dhx_cal_date"></div>

         <div class="dhx_minical_icon" id="dhx_minical_icon" onclick="show_minical()">&nbsp;</div>

         <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>

         <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>

         <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>

      </div>

      <div class="dhx_cal_header">

      </div>

      <div class="dhx_cal_data">

      </div>

   </div>

   

    <div id="popupContact">  

	<div class="box">

		<ul id="tabMenu">

			<li class="signin selected">Sign In</li>

			<li class="signup">Sign Up!</li>

		</ul>

		<div class="boxTop"></div>



		<div class="boxBody">

	  

			<div id="signin" class="show">

				<table>   

					<tr>

						<td><label for='email' style="font-size:12px" >Email:</label></td>

						<td><input type='text' name='Email' id='email' style="width:200px"  maxlength="50" /></td>

					</tr>

					<tr>

						<td><label for='password' style="font-size:12px" >Password:</label></td>

						<td><input type='password' name='password' id='password' maxlength="100" style="width:200px" /></td>

					</tr>

					<tr>

						<td/>

						<td><input type="checkbox" name="remember" value="remember" style='float:left;'>

							<label for='remember' style="font-size:12px; float:left;" >Remember Me</label>

							<input type='submit' name='Submit' value='Log In' style="background-color:#F8D300; float:right;" /></td>

					</tr>

				</table>

				<a href='' style='float:right; padding-right:15px; padding-top:5px;'>Forgot your password?</a>

				<fb:login-button style='float:right; padding:5px 15px 0 0;'>Login with Facebook</fb:login-button>

			</div>  

		  

			<div id="signup">

				 <table>

					<tr>

						<td><label for='name' style="font-size:12px" >Full Name:</label></td>

						<td><input type='text' name='name' id='nameparam' style="width:200px"  maxlength="50" /></td>

					</tr>

					<tr>

						<td><label for='email' style="font-size:12px" >Email:</label></td>

						<td><input type='text' name='email' id='emailparam' style="width:200px"  maxlength="50" /></td>

					</tr>

					<tr>

						<td><label for='password' style="font-size:12px" >Password:</label></td>

						<td><input type='password' name='password' id='passwordparam' maxlength="100" style="width:200px" /></td>

					</tr>

						<td><label for='password2' style="font-size:12px" >Confirm:</label></td>

						<td><input type='password' name='password2' id='passwordparam2' maxlength="100" style="width:200px" /></td>

					</tr>

					<tr>

						<td/>

						<td><input type='submit' name='Submit' value='Submit' style="background-color:#F8D300; float:right;" onClick="ajaxSubmit();" /></td>

					</tr>

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
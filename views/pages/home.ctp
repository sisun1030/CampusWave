<html>
	<?php 
	
	echo $this->Html->script('jquery');
	echo $this->Html->script('/scripts/dhtmlxScheduler/codebase/dhtmlxscheduler');
	echo $this->Html->script('/scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_tooltip.js');
	echo $this->Html->css('/scripts/dhtmlxScheduler/codebase/dhtmlxscheduler');
	echo $this->Html->script('/scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler');
	echo $this->Html->css('/scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler');
	echo $this->Html->css('main');
	?>

<div id="fb-root"></div>

   <script src="http://connect.facebook.net/en_US/all.js"></script>

   <script>

      FB.init({ 

         appId:'141843382572716', cookie:true, 

         status:true, xfbml:true 

      });
      </script>

	<script type="text/javascript" charset="utf-8">

 function init() {

 /*

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

  

  scheduler.form_blocks["campus_event_title"]={

   render:function(sns){   

    return "<div class='campus_event_title' style='height:10px;'><form><label>Title<img src='/images/title.jpg' alt='title' /> </label></form></div>";

   },

   set_value:function(node,value,ev){ //this is a place holder

    node.firstChild.value=value||"";

    node.firstChild.disabled = ev.disabled;

   }

  }


  */
  
  //renders lightbox readonly if user is not creator of event
  scheduler.form_blocks.textarea.set_value=function(node,value,ev){
       
	    node.firstChild.value=value||"";
		var notOwnEvent = true;
		
		if(ev.user_id == <?php echo $this->Session->read('Auth.User.id'); ?>)
			notOwnEvent = false;
		
        node.firstChild.disabled = notOwnEvent; // or just = true; disable for all events
    }
	

	scheduler.config.lightbox.sections=[

   { name:"organizer", height:20, map_to:"organizer",type:"textarea", focus:true },

   { name:"description", height:50, map_to:"description", type:"textarea"},

   { name:"location", height:20, map_to:"location", type:"textarea"},   

   { name:"time", height:72, type:"time", map_to:"auto"} 

  ]
  
    
  scheduler.locale.labels.section_title = "title";
  scheduler.locale.labels.section_location = "location";
  scheduler.locale.labels.section_organizer = "organizer";

  scheduler.config.multi_day = true;

  scheduler.config.xml_date="%Y-%m-%d %H:%i";

  scheduler.init('scheduler_here',null,"month");
    
  scheduler.load("/app/webroot/scripts/dhtmlxScheduler/allevents.php");
 
  var dp = new dataProcessor("/app/webroot/scripts/dhtmlxScheduler/allevents.php?user=<?php echo $this->Session->read('Auth.User.id'); ?>");
  
  dp.init(scheduler);
  
  //verifies if user is creator of event
  function allow_own(id)
  {
	var ev = this.getEvent(id);
	return ev.user_id == <?php echo $this->Session->read('Auth.User.id'); ?>;
  }

   //only allow creator to double click
   scheduler.attachEvent("onDblClick",allow_own);
  
  
   scheduler.attachEvent("onBeforeDrag", allow_own);
   
	//provide a limited view of icons when clicked once, if user is not the owner
	scheduler.attachEvent("onClick", function(event_id, native_event_object){
			
			var event_object = this.getEvent(event_id);
			
			if(event_object.user_id != <?php echo $this->Session->read('Auth.User.id'); ?>)
				scheduler.config.icons_select=["icon_details"];
			else
				scheduler.config.icons_select=["icon_details","icon_edit","icon_delete"];
			
			return true;
   });
 
	//provide a limited view of icons in lightbox if user is not the owner
	scheduler.attachEvent("onBeforeLightbox", function(event_id) {
			
		var event_object = this.getEvent(event_id);
	
		if(event_object.user_id != <?php echo $this->Session->read('Auth.User.id'); ?>) {
		
			scheduler.config.buttons_left=["dhx_cancel_btn"];
			scheduler.config.buttons_right=[];
		}
		else
		{
			scheduler.config.buttons_left=["dhx_save_btn","dhx_cancel_btn"];
			scheduler.config.buttons_right=["dhx_delete_btn"];
			
		 }
		 
		 scheduler.resetLightbox();
		 
		 return true;
	});

  
  //default properties of new event
   scheduler.attachEvent("onEventCreated",function(id)
   {
      var ev = this.getEvent(id);
	  ev.user_id = <?php echo $this->Session->read('Auth.User.id'); ?>; //just for rendering on client, will not affect server data
   });
  
  
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
	
</script>
	
<body onload='init()'>
<div class='header'><div class='banner'></div><div class='headerright'></div></div>

<a class='log' href="/index.php/users/logout">Logout <b>></b></a>

<div class='bar'><div class='barleft'></div>
	<ul>
		<li><a href='/index.php' id='home'>Home</a></li>
		<li><a href=''>How It Works</a></li>
		<li><a href=''>What's Hot</a></li>
		<li><a href=''>Event Listings</a></li>
		<li><a href=''>Groups</a></li>
		
		
	</ul>
	<div class='barright'></div>
</div>


<div class='box'>
   What's going on this month?
   <hr style='width:800px;position:absolute;left:20px;top:32px;color:#6c8395;background-color:#6c8395;border:0;height:1px;'>
   <div id="scheduler_here" class="dhx_cal_container" style='width:800px; height:350px; position:absolute; top:50px; left:20px;padding-bottom:30px;text-transform:none'>

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
   
 <!-- taken out for live
 <div class="box_right">
	Sort Events By
	<hr style='width:350px;position:absolute;top:12px;color:#6c8395;background-color:#6c8395;border:0;height:1px;'>
</div>
-->
   
<div class='box_bot'>
	<form method="">
		Search this month's events
		<input type='text' style='height:26px;margin-right:0'><input type='submit' class='search_submit' value=''>
		or
		<button class="quick_start_event"><span>Quick Start Event</span></button>
	</form>
</div>

</div>
   <div class="bot">
	<ul id="botlist">
		Campuswave
		<li>Sign Up</li>
		<li>Login</li>
		<li>About Us</li>
		<li>Contact Us</li>
		<li>Blog</li>
		<li>Terms of Service</li>
		<li>Privacy Policy</li>
	</ul>
	<hr style='width:420px; position:absolute; left:40px;top:28px;color:#6c8395;background-color:#6c8395;border:0;height:1px;'>

	<ul id="botlist" style="position:absolute; left:300px; top:0px;">
		Events
		<li>Start Event</li>
		<li>Follow Event</li>
		<li>What's Hot</li>
		<li>Featured</li>
		<li>Search Event</li>
	</ul>
	
        <fb:like-box style="position:absolute; top:10px; left:600px; background-color:white;" data-href="http://www.facebook.com/pages/CampusWave/211446602221731" data-width="300" data-height="255" data-show-faces="true" data-stream="false" data-header="false" data-colorscheme='light'></fb:like-box>
   </div>
			
<div class="footer">
	Copyright (C) Campus Wave 2011, All right reserved.
</div>



</body>
</html>
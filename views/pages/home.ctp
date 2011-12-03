<html>
	<?php 
	echo $this->Html->css('main');
	echo $this->Html->script('jquery-1.6.1');
	
	
	echo $this->Html->script('/scripts/dhtmlxScheduler/codebase/dhtmlxscheduler');
	echo $this->Html->script('/scripts/dhtmlxScheduler/codebase/dhtmlxscheduler_editors');
	echo $this->Html->script('/scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler_tooltip');
	echo $this->Html->css('/scripts/dhtmlxScheduler/codebase/dhtmlxscheduler');
	echo $this->Html->script('/scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler');
	echo $this->Html->css('/scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler');
	
	echo $this->Html->css('/scripts/dhtmlxEditor/codebase/skins/dhtmlxeditor_dhx_skyblue');
	echo $this->Html->script('/scripts/dhtmlxEditor/codebase/dhtmlxcommon');
	echo $this->Html->script('/scripts/dhtmlxEditor/codebase/dhtmlxeditor3'); 
	echo $this->Html->script('/scripts/dhtmlxEditor/codebase/ext/dhtmlxeditor_ext');
	
	echo $this->Html->css('/scripts/dhtmlxToolbar/codebase/skins/dhtmlxtoolbar_dhx_skyblue');
	echo $this->Html->script('/scripts/dhtmlxToolbar/codebase/dhtmlxtoolbar');
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
	
 /* attach a submit handler to the form */
  $("#uploadpic").submit(function(event) {
	alert('hello');
    /* stop form from submitting normally */
    event.preventDefault(); 
        
    /* get some values from elements on the page: */
    var $form = $( this ),
        term = $form.find( 'input[name="add"]' ).val(),
        url = $form.attr( 'action' );

    /* Send the data using post and put the results in a div */
    $.post( url, { s: term },
      function( data ) {
          var content = $( data ).find( '#content' );
          $( "#imgResult" ).empty().append( content );
      }
    );
  });
  

 function init() {
 
 scheduler.templates.event_class=function(start,end,event){
	
 
    switch (event.category_id)	//if date in past
	{
		 case "1" : return "cat_arts";
		 case "2" : return "cat_business";
		 case "3" : return "cat_science_tech";
	}
	
	
  }
  
  scheduler.templates.tooltip_text = function(start,end,event) {
	
	return "<b>TOOOOOOOOOL</b> "+event.text+"<br/><b>Start date:</b> "+scheduler.templates.tooltip_date_format(start)+"<br/><b>End date:</b> "+scheduler.templates.tooltip_date_format(end);
}
  /*
  scheduler.form_blocks["event_img"]={
		render:function(sns){
		
			<?php
					$img = "'/app/webroot/img/big/" . $this->Session->read('Upload.img') . "'";
				?>

				var upload = "<img src=<?php echo $img ?> /><form id='uploadpic' enctype='multipart/form-data' method='post' action='/index.php/uploads/display'>" +
						 "<input id='ImageName1' type='file' name='data[Upload][Image]'>" +
						 "<input type='submit' name='add' value='Add Image' /></form></center>";
		
			return upload;
		},
		set_value:function(node,value,ev){
		
			
		
			
				document.getElementById('imgResult').innerHTML = upload;
			
			
		},
		get_value:function(node,ev){
		
			return node.innerHtml;
		},
		focus:function(node){
			//var a=node.childNodes[1]; a.select(); a.focus(); 
		}

	}
	*/
  
  
 //Used only to display organizer name as default when creating event, do we want this? Might be good to limit who creates what.
 scheduler.form_blocks["event_organizer"]={
		render:function(sns){
			return "<div class='dhx_cal_ltext' style='height:15px;'><?php echo $this->Session->read('Auth.User.name'); ?></div>";
		},
		set_value:function(node,value,ev){
		
			//node.childNodes[1].value= value||"";
		},
		get_value:function(node,ev){
			//ev.location = node.childNodes[4].value;
			//return node.childNodes[1].value;
		},
		focus:function(node){
			//var a=node.childNodes[1]; a.select(); a.focus(); 
		}
	}

 scheduler.form_blocks["event_desc"]={
		render:function(sns){
			return "<div id='editorDesc' style='width: 100%; height: 200px; border: #a4bed4 1px solid;'></div>";
		},
		set_value:function(node,value,ev){
			
			if(allow_own(ev.id, this))
			{
				createEditor('editorDesc');

				if(value == null)
					value = "";
			
				var iframe = node.childNodes[0].childNodes[1].childNodes[0];
				iframe.contentWindow.document.body.innerHTML = value;
			}
			else
			{
				document.getElementById('editorDesc').innerHTML = value;
			}
		},
		get_value:function(node,ev){
		
			//location of iframe editor value
			var iframe = node.childNodes[0].childNodes[1].childNodes[0];
			return iframe.contentWindow.document.body.innerHTML;
		},
		focus:function(node){
			//var a=node.childNodes[1]; a.select(); a.focus(); 
		}

	}
	
	scheduler.form_blocks["event_name"]={
		render:function(sns){
			return "<div id='editorName' style='width: 100%; height: 50px; border: #a4bed4 1px solid;'></div>";
		},
		set_value:function(node,value,ev){
			
			if(allow_own(ev.id, this))
			{
				createEditor('editorName');
				
				if(value == null)
					value = "";
				
				var iframe = node.childNodes[0].childNodes[1].childNodes[0];
				iframe.contentWindow.document.body.innerHTML = value;
			}
			else
			{
				document.getElementById('editorName').innerHTML = value;
			}
		},
		get_value:function(node,ev){
		
			//location of iframe editor value
			var iframe = node.childNodes[0].childNodes[1].childNodes[0];
			return iframe.contentWindow.document.body.innerHTML;
		},
		focus:function(node){
			//var a=node.childNodes[1]; a.select(); a.focus(); 
		}

	}
	
	scheduler.form_blocks["event_location"]={
		render:function(sns){
			return "<div id='editorLocation' style='width: 100%; height: 50px; border: #a4bed4 1px solid;'></div>";
		},
		set_value:function(node,value,ev){
			
			if(allow_own(ev.id, this))
			{
				createEditor('editorLocation');
				
				if(value == null)
					value = "";
				
				var iframe = node.childNodes[0].childNodes[1].childNodes[0];
				iframe.contentWindow.document.body.innerHTML = value;
			}
			else
			{
				document.getElementById('editorLocation').innerHTML = value;
			}
		},
		get_value:function(node,ev){
		
			//location of iframe editor value
			var iframe = node.childNodes[0].childNodes[1].childNodes[0];
			return iframe.contentWindow.document.body.innerHTML;
		},
		focus:function(node){
			//var a=node.childNodes[1]; a.select(); a.focus(); 
		}

	}
	

	
  //renders all textareas in lightbox readonly if user is not creator of event
  scheduler.form_blocks.textarea.set_value=function(node,value,ev){
       
	    node.firstChild.value=value||"";
		var notOwnEvent = true;
		
		if(allow_own(ev.id, this))
			notOwnEvent = false;
		
        node.firstChild.disabled = notOwnEvent; 
	}
	
  //renders all selects in lightbox readonly if user is not creator of event
  scheduler.form_blocks.select.set_value=function(node,value,ev){
       
	    node.firstChild.value=value||"";
		var notOwnEvent = true;
		
		if(allow_own(ev.id, this))
			notOwnEvent = false;
		
        node.firstChild.disabled = notOwnEvent;
    }
	
	//category list, will eventually replace w/a for loop extracting info from category table
	var category = [
	{ key: 1, label: 'Arts' },
	{ key: 2, label: 'Business' },
	{ key: 3, label: 'Science & Technology' }
	];

	scheduler.config.lightbox.sections=[
	
 // { name:"image", height:20, map_to:"image", type:"event_img"},
   
   { name:"text", height:20, map_to:"text", type:"event_name"},

   { name:"organizer", height:20, map_to:"organizer",type:"event_organizer" },

   { name:"description", height:20, map_to:"description", type:"event_desc"},

   { name:"location", height:20, map_to:"location", type:"event_location" },

   { name:"category", options: category, map_to:"category_id", type:"select" },

   { name:"time", height:72, type:"time", map_to:"auto"} 

  ]
  
  //scheduler.locale.labels.section_image = "";
  scheduler.locale.labels.section_text = "event";
  scheduler.locale.labels.section_location = "location";
  scheduler.locale.labels.section_organizer = "organizer";
  scheduler.locale.labels.section_category = "category";

  scheduler.config.multi_day = true;
  scheduler.config.xml_date="%Y-%m-%d %H:%i";
  scheduler.init('scheduler_here',null,"month");
  scheduler.load("/app/webroot/scripts/dhtmlxScheduler/allevents.php");
 
  var dp = new dataProcessor("/app/webroot/scripts/dhtmlxScheduler/allevents.php?user=<?php echo $this->Session->read('Auth.User.id'); ?>");
  dp.init(scheduler);
  

   //only allow to double click in full month view. Dbl clicking in other views will render the event editable to anyone.
   scheduler.attachEvent("onDblClick",function (event_id, native_event_object){
	
		if(this.getState().mode == "month")
			return true;
			
		return false; 
    });
   
    scheduler.attachEvent("onBeforeDrag", function (event_id, mode, native_event_object){

		if(event_id == null)
			return true;
		
       return allow_own(event_id, this);
  });
   
   
	//provide a limited view of icons when clicked once, if user is not the owner
	scheduler.attachEvent("onClick", function(event_id, native_event_object){
	
			if(this.getState().mode == "month")
				bubble_event_list(event_id, this);
				
			if(!allow_own(event_id, this))
				scheduler.config.icons_select=["icon_details"];
			else
				scheduler.config.icons_select=["icon_details","icon_edit","icon_delete"];
			
			return true;
   });
   
   scheduler.attachEvent("onMouseMove", function (event_id, native_event_object){
   
		
   });
   
   
 
	//provide a limited view of icons in lightbox if user is not the owner
	scheduler.attachEvent("onBeforeLightbox", function(event_id) {
			
		var event_object = this.getEvent(event_id);
	
		if(!allow_own(event_id, this)) {
		
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

  
  //default properties of new event. Add user id to event.
   scheduler.attachEvent("onEventCreated",function(id)
   {
      var ev = this.getEvent(id);
	  ev.user_id = <?php echo $this->Session->read('Auth.User.id'); ?>; 
   });
  
  
 }
 

 
 //verifies if user is creator of event
 function allow_own(id, schedulerObj)
 {
	var ev = schedulerObj.getEvent(id);
	return ev.user_id == <?php echo $this->Session->read('Auth.User.id'); ?>;
 }


  //takes in the id of the event clicked and returns an array w/all events for that day
  function bubble_event_list(event_id, schedulerObj)
  {
	var eventFullDate = "" + schedulerObj.getEventStartDate(event_id);
	var eventDay = new Date(eventFullDate.substring(0, 15));
	
	var eventNextDay = new Date(eventDay);
	eventNextDay.setDate(eventNextDay.getDate() + 1);
	
	var eventList = schedulerObj.getEvents(eventDay,eventNextDay);
		
	//to access properties just use the name assigned in the lightbox
	//alert(eventList[0].text);
	
	return eventList;
  }
  
  function showbubble()
  {
		
  }
  
  var editor;
  dhtmlx.image_path = "/app/webroot/scripts/dhtmlxEditor/codebase/imgs/";
  //creates an editor object and initializes it with saved value if present
  function createEditor(editorName) 
  {	
    editor = new dhtmlXEditor(editorName);
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
<body onload='init();'>
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
<form id='uploadpic' enctype='multipart/form-data' method='post' action='/index.php/uploads/display'>
						 <input id='ImageName1' type='file' name='data[Upload][Image]'> 
						 <input type='submit' name='add' value='Add Image' /></form></center></form>
</body>
</html>
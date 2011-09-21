<html>
	<?php 
	
	echo $this->Html->script('jquery');
	echo $this->Html->script('/scripts/dhtmlxScheduler/codebase/dhtmlxscheduler');
	echo $this->Html->css('/scripts/dhtmlxScheduler/codebase/dhtmlxscheduler');
	echo $this->Html->script('/scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler');
	echo $this->Html->css('/scripts/dhtmlxScheduler/codebase/ext/dhtmlxscheduler');
	?>

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

  scheduler.load("/app/webroot/scripts/dhtmlxScheduler/common/events.xml");

  

  

  

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


<a href="/index.php/users/logout">Logout</a>
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


</body>
</html>
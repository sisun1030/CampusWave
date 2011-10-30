<?php
	include ('codebase/connector/scheduler_connector.php');
	include ('common/config.php');

	$res=mysql_connect($server, $user, $pass);
	mysql_select_db($db_name);
	
	$scheduler = new schedulerConnector($res);

	//$scheduler->enable_log("log.txt",true);
	//$scheduler->render_sql("select * from events_shared where event_type=1 AND userId = ".$user_id,"event_id","start_date,end_date,text,event_type,userId");
	$scheduler->render_table("events","id","start_date,end_date,text,description,location,organizer");
	
?>
<?php
	include ('codebase/connector/scheduler_connector.php');
	include ('common/config.php');
	

	$res=mysql_connect($server, $user, $pass);
	mysql_select_db($db_name);
	
	$scheduler = new schedulerConnector($res);
	$user_id = $_GET['user'];
	$scheduler->enable_log("log.txt",true);
	//$scheduler->render_sql("select * from events","id","start_date,end_date,text,description,location,organizer,user_id,category_id");
	$scheduler->render_table("events","id","start_date,end_date,text,description,location,organizer,user_id,category_id");
?>
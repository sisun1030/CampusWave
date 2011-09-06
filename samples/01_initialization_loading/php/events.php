<?php
	include ('../../../codebase/scheduler_connector.php');
	include ('../../common/config.php');
	
	$res=mysql_connect('localhost', 'root', '');
	mysql_select_db('simple');
	
	$scheduler = new schedulerConnector($res);
	//$scheduler->enable_log("log.txt",true);
	$scheduler->render_table("event","id","start_date,end_date,title,text");
?>
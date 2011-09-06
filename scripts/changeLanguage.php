<?php

require ('wampserver.lib.php');

require 'config.inc.php';

$wampIniNewContents['language'] = $_SERVER['argv'][1];
wampIniSet($configurationFile, $wampIniNewContents);
?>
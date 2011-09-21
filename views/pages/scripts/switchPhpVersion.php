<?php

require 'wampserver.lib.php';



$newPhpVersion = $_SERVER['argv'][1];
switchPhpVersion($newPhpVersion);


?>
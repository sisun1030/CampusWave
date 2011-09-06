<?php

//v1.0 by Romain Bourdon

require 'config.inc.php';


$httpdFileContents = @file_get_contents($c_apacheConfFile ) or die ("httpd.conf file not found");

// on remplace la ligne
if ($_SERVER['argv'][2] == 'on')
{
    $findTxt  = 'LoadModule '.$_SERVER['argv'][1];
    $replaceTxt  = '#LoadModule '.$_SERVER['argv'][1];
}
else
{
    $findTxt  = '#LoadModule '.$_SERVER['argv'][1];
    $replaceTxt  = 'LoadModule '.$_SERVER['argv'][1];
}

$httpdFileContents = str_replace($findTxt,$replaceTxt,$httpdFileContents);


$fphttpd = fopen($c_apacheConfFile ,"w");
fwrite($fphttpd,$httpdFileContents);
fclose($fphttpd);


?>
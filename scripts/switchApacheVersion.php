<?php

require 'wampserver.lib.php';
require 'config.inc.php';

$newApacheVersion = $_SERVER['argv'][1];

// on charge le fichier de configuration du php courant
require $c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/'.$wampBinConfFiles;

// on verifie que la nouvelle version de apache est compatible avec le php courant
$newApacheVersionTemp = $newApacheVersion;
while (!isset($phpConf['apache'][$newApacheVersionTemp]) && $newApacheVersionTemp != '')
{
    $pos = strrpos($newApacheVersionTemp,'.');
    $newApacheVersionTemp = substr($newApacheVersionTemp,0,$pos);
}
if ($newApacheVersionTemp == '')
{
    exit();
}
    


// on charge le fichier de conf de la nouvelle version
require $c_apacheVersionDir.'/apache'.$newApacheVersion.'/'.$wampBinConfFiles;

$apacheConf['apacheVersion'] = $newApacheVersion;
wampIniSet($configurationFile, $apacheConf);


?>
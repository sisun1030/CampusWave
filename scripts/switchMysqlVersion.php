<?php

require 'wampserver.lib.php';
require 'config.inc.php';

$newMysqlVersion = $_SERVER['argv'][1];

//on charge le fichier de conf de la nouvelle version
require $c_mysqlVersionDir.'/mysql'.$newMysqlVersion.'/'.$wampBinConfFiles;

$mysqlConf['mysqlVersion'] = $newMysqlVersion;

wampIniSet($configurationFile, $mysqlConf);

?>
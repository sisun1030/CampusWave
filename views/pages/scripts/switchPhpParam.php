<?php


require 'config.inc.php';

$phpIniFileContents = @file_get_contents($c_phpConfFile) or die ("php.ini file not found");



if ($_SERVER['argv'][2] == 'off')
{
    $findTxt  = $_SERVER['argv'][1].' = On';
    $replaceTxt  = $_SERVER['argv'][1].' = Off';
}
else
{
    $findTxt  = $_SERVER['argv'][1].' = Off';
    $replaceTxt  = $_SERVER['argv'][1].' = On';
}


$phpIniFileContents = str_ireplace($findTxt,$replaceTxt,$phpIniFileContents);

$fpPhpIni = fopen($c_phpConfFile,"w");
fwrite($fpPhpIni,$phpIniFileContents);
fclose($fpPhpIni);


?>
<?php

//v1.0 by Romain Bourdon

require 'config.inc.php';

$phpIniFileContents = @file_get_contents($c_phpConfFile) or die ("php.ini file not found");

// on remplace la ligne
if ($_SERVER['argv'][2] == 'on')
{
    $findTxt  = ';extension='.$_SERVER['argv'][1].'.dll';
    $replaceTxt  = 'extension='.$_SERVER['argv'][1].'.dll';
}
else
{
    $findTxt  = 'extension='.$_SERVER['argv'][1].'.dll';
    $replaceTxt  = ';extension='.$_SERVER['argv'][1].'.dll';
}
$phpIniFileContents2 = str_replace($findTxt,$replaceTxt,$phpIniFileContents);


// on ajoute la ligne si elle n'existe pas
if ($phpIniFileContents2 == $phpIniFileContents)
{
       
   $findTxt  = 
';;;;;;;;;;;;;;;;;;;
; Module Settings ;';

    $replaceTxt  = 
'extension='.$_SERVER['argv'][1].'.dll
;;;;;;;;;;;;;;;;;;;
; Module Settings ;';

    $phpIniFileContents2 = str_replace($findTxt,$replaceTxt,$phpIniFileContents);
}

$fpPhpIni = fopen($c_phpConfFile,"w");
fwrite($fpPhpIni,$phpIniFileContents2);
fclose($fpPhpIni);

?>
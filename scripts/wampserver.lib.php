<?php


function wampIniSet($iniFile, $params)
{
    $iniFileContents = @file_get_contents($iniFile);
    foreach ($params as $param => $value)
        $iniFileContents = preg_replace('|'.$param.' = .*|',$param.' = '.'"'.$value.'"',$iniFileContents);
    $fp = fopen($iniFile,'w');
    fwrite($fp,$iniFileContents);
    fclose($fp);
}


function listDir($dir,$toCheck = '')
{
    if ($handle = opendir($dir)) 
    {    
        while (false !== ($file = readdir($handle))) 
        {
            if ($file != "." && $file != ".." && is_dir($dir.'/'.$file)) 
            {
                if ($toCheck != '')
                {
                    eval('$result ='." $toCheck('$dir','$file');");
                }
                if (!isset($result) || $result == 1)
                    $list[] = $file;
            }
        }
    closedir($handle);
    }
    if (isset($list))
        return($list);
    else
        return (NULL);
}


function checkPhpConf($baseDir,$version)
{
    global $wampBinConfFiles;
    global $phpConfFileForApache;
    
    if (!is_file($baseDir.'/'.$version.'/'.$wampBinConfFiles))
        return (0);
    if (!is_file($baseDir.'/'.$version.'/'.$phpConfFileForApache))
        return (0);    
    return(1);
}

function checkApacheConf($baseDir,$version)
{
    global $wampBinConfFiles;
    
    if (!is_file($baseDir.'/'.$version.'/'.$wampBinConfFiles))
        return (0);    
    return(1);
}

function checkMysqlConf($baseDir,$version)
{
    global $wampBinConfFiles;
    
    if (!is_file($baseDir.'/'.$version.'/'.$wampBinConfFiles))
        return (0);    
    return(1);
}


function switchPhpVersion($newPhpVersion)
{
    require 'config.inc.php';
    
    //on charge le fichier de conf de la nouvelle version
    require $c_phpVersionDir.'/php'.$newPhpVersion.'/'.$wampBinConfFiles;
    
    
    
    //on determine les textes httpd.conf en fonction de la version d'apache
    $apacheVersion = $wampConf['apacheVersion'];
    while (!isset($phpConf['apache'][$apacheVersion]) && $apacheVersion != '')
    {
        $pos = strrpos($apacheVersion,'.');
        $apacheVersion = substr($apacheVersion,0,$pos);

    }
    
    // on sauvegarde le php.ini courant
    copy($c_phpConfFile,$c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/'.$phpConfFileForApache);
    
    //on place le nouveau php.ini
    copy($c_phpVersionDir.'/php'.$newPhpVersion.'/'.$phpConfFileForApache,$c_phpConfFile);
    
    
    // on modifie le fichier de conf d'apache  
    $httpdContents = file($c_apacheConfFile);
    foreach ($httpdContents as $line)
    {
        if (strstr($line,'LoadModule') && strstr($line,'php'))
        {
            $newHttpdContents .= 'LoadModule '.$phpConf['apache'][$apacheVersion]['LoadModuleName'].' "'.$c_phpVersionDir.'/php'.$newPhpVersion.'/'.$phpConf['apache'][$apacheVersion]['LoadModuleFile'].'"'."\r\n";
        }
        elseif ($phpConf['apache'][$apacheVersion]['AddModule'] != '' && strstr($line,'AddModule') && strstr($line,'php'))
            $newHttpdContents .= 'AddModule '.$phpConf['apache'][$apacheVersion]['AddModule']."\r\n";
        else
            $newHttpdContents .= $line;
    }
    file_put_contents($c_apacheConfFile,$newHttpdContents);
    
    
    //on copie des dll
    foreach ($phpDllToCopy as $dll)
    {
        if (is_file($c_phpVersionDir.'/php'.$newPhpVersion.'/'.$dll))
        {
            unlink($c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$dll);
            copy($c_phpVersionDir.'/php'.$newPhpVersion.'/'.$dll,$c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$dll);
        }
    }
    
    //on modifie la conf de wampserver
    $wampIniNewContents['phpIniDir'] = $phpConf['phpIniDir'];
    $wampIniNewContents['phpExeDir'] = $phpConf['phpExeDir'];
    $wampIniNewContents['phpConfFile'] = $phpConf['phpConfFile'];
    $wampIniNewContents['phpVersion'] = $newPhpVersion;
    wampIniSet($configurationFile, $wampIniNewContents);
    

}


?>
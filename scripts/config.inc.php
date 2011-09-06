<?php


$configurationFile = '../wampmanager.conf';
$templateFile = '../wampmanager.tpl';
$wampserverIniFile = '../wampmanager.ini';
$langDir = '../lang/';
$aliasDir = '../alias/';
$modulesDir = 'modules/';
$logDir = 'logs/';
$wampBinConfFiles = 'wampserver.conf';
$phpConfFileForApache = 'phpForApache.ini';


// on charge la conf locale
$wampConf = @parse_ini_file($configurationFile);


//on renseigne les variables du template avec la conf locale
$c_installDir = $wampConf['installDir'];
$c_wampVersion = $wampConf['wampserverVersion'];
$c_navigator = $wampConf['navigator'];
$c_phpCliVersion = $wampConf['phpCliVersion'];
$c_mysqlVersion = $wampConf['mysqlVersion'];
$c_mysqlServiceInstallParams = $wampConf['mysqlServiceInstallParams'];
$c_mysqlServiceRemoveParams = $wampConf['mysqlServiceRemoveParams'];
$c_apacheServiceInstallParams = $wampConf['apacheServiceInstallParams'];
$c_apacheServiceRemoveParams = $wampConf['apacheServiceRemoveParams'];
$c_webgrind = "webGrind";



// on construit les variables correspondant aux chemins 
$c_apacheVersionDir = $wampConf['installDir'].'/bin/apache';
$c_phpVersionDir = $wampConf['installDir'].'/bin/php';
$c_mysqlVersionDir = $wampConf['installDir'].'/bin/mysql';
$c_apacheConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheConfDir'].'/'.$wampConf['apacheConfFile'];
$c_apacheExe = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$wampConf['apacheExeFile'];
$c_phpConfFile = $c_apacheVersionDir.'/apache'.$wampConf['apacheVersion'].'/'.$wampConf['apacheExeDir'].'/'.$wampConf['phpConfFile'];
$c_mysqlExe = $c_mysqlVersionDir.'/mysql'.$wampConf['mysqlVersion'].'/'.$wampConf['mysqlExeDir'].'/'.$wampConf['mysqlExeFile'];
$c_mysqlConfFile = $c_mysqlVersionDir.'/mysql'.$wampConf['mysqlVersion'].'/'.$wampConf['mysqlConfDir'].'/'.$wampConf['mysqlConfFile'];
$c_phpExe = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpExeFile'];
$c_phpCli = $c_phpVersionDir.'/php'.$c_phpCliVersion.'/'.$wampConf['phpCliFile'];
$c_mysqlConsole = $c_mysqlVersionDir.'/mysql'.$c_mysqlVersion.'/'.$wampConf['mysqlExeDir'].'/mysql.exe';

$phpExtDir = $c_phpVersionDir.'/php'.$wampConf['phpVersion'].'/ext/';
$helpFile = $c_installDir.'/help/wamp5.chm';
$wwwDir = $c_installDir.'/www';



$phpDllToCopy = array (
                        'fdftk.dll',
                        'fribidi.dll',
                        'libeay32.dll',
                        'libmhash.dll',
                        'libmysql.dll',
                        'msql.dll',
                        'libmysqli.dll',
                        'ntwdblib.dll',
                        'php5activescript.dll',
                        'php5isapi.dll',
                        'php5nsapi.dll',
                        'ssleay32.dll',
                        'yaz.dll',
                        'libmcrypt.dll',
                        'php5ts.dll',
                        'php4ts.dll');
                        





$phpParams = array (
                        'ze1 compatibility mode'=>'zend.ze1_compatibility_mode',
                        '(XDebug) :  Remote debug' => 'xdebug.remote_enable',
                        '(XDebug) :  Profiler' => 'xdebug.profiler_enable',
                        '(XDebug) :  Profiler Enable Trigger' => 'xdebug.profiler_enable_trigger',
                        'short open tag' => 'short_open_tag',
                        'asp tags' => 'asp_tags',
                        'output buffering' => 'output_buffering',
                        'y2k compliance'=>'y2k_compliance',
                        'zlib output compression'=>'zlib.output_compression',
                        'implicit flush'=>'implicit_flush',
                        'allowc call time pass reference'=>'allow_call_time_pass_reference',
                        'safe mode'=>'safe_mode',
                        'expose PHP'=>'expose_php',
                        'display errors'=>'display_errors',
                        'display startup errors'=>'display_startup_errors',
                        'log errors' => 'log_errors',
                        'ignore repeated errors'=>'ignore_repeated_errors',
                        'ignore repeated source'=>'ignore_repeated_source',
                        'report memleaks'=>'report_memleaks',
                        'track errors'=>'track_errors',
                        'register globals'=>'register_globals',
                        'register long arrays'=>'register_long_arrays',
                        'register argc argv'=>'register_argc_argv',
                        'magic quotes gpc'=>'magic_quotes_gpc',
                        'magic quotes runtime'=>'magic_quotes_runtime',
                        'magic quotes sybase'=>'magic_quotes_sybase',
                        'enable dl'=>'enable_dl',
                        'file uploads'=>'file_uploads',
                        'allow url fopen'=>'allow_url_fopen',
                        'allow url include' => 'allow_url_include');

?>

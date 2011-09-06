<?php
$fp = @fsockopen("127.0.0.1", 80, $errno, $errstr, 1);
   $out = "GET / HTTP/1.1\r\n";
   $out .= "Host: 127.0.0.1\r\n";
   $out .= "Connection: Close\r\n\r\n";
if ($fp)
{
           echo  'Your port 80 is actually used by :

';
   fwrite($fp, $out);
   while (!feof($fp)) 
   {
        $line = fgets($fp, 128);
        if (ereg('Server: ',$line))
        {
            echo $line;
            $gotInfo = 1;
        }
    
    }
    fclose($fp);
    if ($gotInfo != 1)
        echo 'Information not available (might be Skype).';
    echo '
Cannot install the Apache service, please stop this application and try again.

Press Enter to exit...';
trim(fgets(STDIN));
}
else
{
    echo 'Your port 80 is available, Install will proceed.';
    echo '

Press Enter to continue...';
    trim(fgets(STDIN));
}


?> 
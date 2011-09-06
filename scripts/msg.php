<?php

$msgId = $_SERVER['argv'][1];

if ($msgId != 0)
{
    switch ($msgId)
    {
        case 1 :
        echo "Sorry,
        
This PHP version doesn't seem to be compatible with your actual Apache Version.
Switch cancelled.
";
        break;
        
        
        
        case 2 :
        echo "Sorry,
        
This Apache version doesn't seem to be compatible with your actual PHP Version.
Switch cancelled.
";
        break;



    }
    echo 'Press ENTER to continue...';
    trim(fgets(STDIN));
}


?>
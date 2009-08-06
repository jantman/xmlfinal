<?php

$s = simplexml_load_file('visitormap.xml');
foreach($s->marker as $marker)
{
    echo "lat=".$marker->lat." lng=".$marker->lng."\n";
}


?>
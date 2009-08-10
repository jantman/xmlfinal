<?php

echo '<pre>';
$s = simplexml_load_file('visitormap.xml');
$arr = array();
foreach($s->marker as $marker)
{
    $foo = array("lat" => $marker->lat, "long" => $marker->lng, "type" => $marker->type, "tooltip" => $marker->tooltip);
    echo $marker->views."\n";
}

echo '</pre>';

?>
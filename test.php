<?php

echo '<pre>';
$a = array(38.57, 6.17, 5.02, 4.58, 3.88, 3.69, 3.43, 2.54, 2.355, 1.527);
foreach($a as $val)
{
    echo $val." = ".log($val)."\n";
}
echo '</pre>';

?>
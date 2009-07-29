<html>
<head>
</head>

<body>
<?php

include_once 'config.inc.php';

$chart = new QMapGoogleGraph;
$chart	->addColumns(
			array(
				array('number', 'Lat'),
				array('number', 'Lon'),
				array('string', 'Name')
				)
			)
		->setValues(
			array(
				array(0, 0, 37.4232),
		        array(0, 1, -122.0853),
		        array(0, 2, 'Work'),
				array(1, 0, 37.4289),
		        array(1, 1, -122.1697),
		        array(1, 2, 'University'),
				array(2, 0, 37.6153),
		        array(2, 1, -122.3900),
		        array(2, 2, 'Airport'),
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();

?>
</body>
</html>
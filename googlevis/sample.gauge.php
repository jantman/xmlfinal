<html>
<head>
</head>

<body>
<?php

include_once 'config.inc.php';

$chart = new QGaugeGoogleGraph;
$chart	->addColumns(
			array(
				array('string', 'Label'),
				array('number', 'Value')
				)
			)
		->setValues(
			array(
				array(0, 0, 'Memory'),
		        array(0, 1, 80),
		        array(1, 0, 'CPU'),
		        array(1, 1, 55),
		        array(2, 0, 'Network'),
		        array(2, 1, 68),
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();

?>
</body>
</html>
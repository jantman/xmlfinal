<html>
<head>
</head>

<body>
<?php

include_once 'config.inc.php';


$chart = new QScatterchartGoogleGraph;
$chart	->addDrawProperties(
			array(
				"width" => 400,
				"height" => 240,
				"titleX" => "Age",
				"titleY" => "Weight",
				"legend" => "none",
				"pointSize" => 5
			)
		)
		->addColumns(
			array(
				array('number', 'Age'),
				array('number', 'Weight')
				)
			)
		->setValues(
			array(
		        array(0, 0, 8),
		        array(0, 1, 12),
		        array(1, 0, 4),
		        array(1, 1, 5.5),
		        array(2, 0, 11),
		        array(2, 1, 14),
		        array(3, 0, 4),
		        array(3, 1, 5),
		        array(4, 0, 3),
		        array(4, 1, 3.5),
		        array(5, 0, 6.5),
		        array(5, 1, 7),
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();


?></body>
</html>
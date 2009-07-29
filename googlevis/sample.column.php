<html>
<head>
</head>

<body>
<?php
include_once 'config.inc.php';
$chart = new QColumnchartGoogleGraph;
$chart	->addDrawProperties(
			array(
				"title"=>'Company Performance',
				'isStacked'=>'true'
				)
			)
		->addColumns(
			array(
				array('string', 'Year'),
				array('number', 'Sales'),
				array('number', 'Expenses')
				)
			)
		->setValues(
			array(
				array(0, 0, '2004'),
				array(0, 1, 1000),
				array(0, 2, 400),
				array(1, 0, '2005'),
				array(1, 1, 1170),
				array(1, 2, 460),
				array(2, 0, '2006'),
				array(2, 1, 660),
				array(2, 2, 1120),
				array(3, 0, '2007'),
				array(3, 1, 1030),
				array(3, 2, 540),
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();

?></body>
</html>
<html>
<head>
</head>

<body>
<?php

include_once 'config.inc.php';


$chart = new QMotionchartGoogleGraph;
$chart	->addDrawProperties(
			array(
				"title"=>'Company Performance',
				)
			)
		->addColumns(
			array(
				array('string', 'Department'),
		        array('number', 'Year'),
		        array('number', 'Sales'),
		        array('number', 'Expenses'),
				)
			)
		->setValues(
			array(
		        array(0, 0, 'Dogs'),
		        array(0, 1, 1995),
		        array(0, 2, 1000),
		        array(0, 3, 300),
		        array(1, 0, 'Cats'),
		        array(1, 1, 1995),
		        array(1, 2, 950),
		        array(1, 3, 200),
		        array(2, 0, 'Dogs'),
		        array(2, 1, 1996),
		        array(2, 2, 1200),
		        array(2, 3, 400),
		        array(3, 0, 'Cats'),
		        array(3, 1, 1996),
		        array(3, 2, 900),
		        array(3, 3, 150),
		        array(4, 0, 'Dogs'),
		        array(4, 1, 1997),
		        array(4, 2, 1250),
		        array(4, 3, 800),
		        array(5, 0, 'Cats'),
		        array(5, 1, 1997),
		        array(5, 2, 200),
					
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();


?></body>
</html>
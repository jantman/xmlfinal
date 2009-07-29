<html>
<head>
</head>
<body>
<?php

include_once 'config.inc.php';


$chart = new QAnnotatedtimelineGoogleGraph();
$chart	
		//->ignoreContainer()
		->addDrawProperties(
			array(
				"title"=>'Company Performance',
				)
			)
		->addColumns(
			array(
		        array('date', 'Date'),
		        array('number', 'Sold Pencils'),
		        array('number', 'Sold Pens'),
		        array('string', 'title'),
		        array('string', 'text'),			
				)
			)
		->setValues(
			array(
		        array(0, 0, 'new Date(2008, 1 ,1)'),
		        array(0, 1, 30000),
		        array(0, 2, 40645),
		        array(1, 0, 'new Date(2008, 1 ,2)'),
		        array(1, 1, 14045),
		        array(1, 2, 20374),
		        array(2, 0, 'new Date(2008, 1 ,3)'),
		        array(2, 1, 55022),
		        array(2, 2, 50766),
		        array(3, 0, 'new Date(2008, 1 ,4)'),
		        array(3, 1, 75284),
		        array(3, 2, 14334),
		        array(3, 3, 'Out of Stock'),
		        array(3, 4, 'Ran out of stock on pens at 4pm'),
		        array(4, 0, 'new Date(2008, 1 ,5)'),
		        array(4, 1, 46476),
		        array(4, 2, 56467),
		        array(4, 3, 'Bought Pens'),
		        array(4, 4, 'Bought 200k pens at 11am'),
		        array(5, 0, 'new Date(2008, 1 ,6)'),
		        array(5, 1, 33322),
		        array(5, 2, 39463),
										
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();


?></body>
</html>
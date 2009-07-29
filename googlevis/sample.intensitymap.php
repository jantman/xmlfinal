<html>
<head>
</head>

<body>
<?php

include_once 'config.inc.php';


$chart = new QIntensitymapGoogleGraph;
$chart	->addDrawProperties(
			array(
				"title"=>'Company Performance',
				)
			)
		->addColumns(
			array(
		        array('string', '', 'Country'),
		        array('number', 'Population (mil)', 'a'),
		        array('number', 'Area (km2)', 'b'),
				)
			)
		->setValues(
			array(
		        array(0, 0, 'CN'),
		        array(0, 1, 1324),
		        array(0, 2, 9640821),
		        array(1, 0, 'IN'),
		        array(1, 1, 1133),
		        array(1, 2, 3287263),
		        array(2, 0, 'US'),
		        array(2, 1, 304),
		        array(2, 2, 9629091),
		        array(3, 0, 'ID'),
		        array(3, 1, 232),
		        array(3, 2, 1904569),
		        array(4, 0, 'BR'),
		        array(4, 1, 187),
		        array(4, 2, 8514877),					
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();


?></body>
</html>
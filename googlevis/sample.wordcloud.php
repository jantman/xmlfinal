<html>
<head>
</head>

<body>
<?php

include_once 'config.inc.php';


$chart = new QWordcloudGoogleGraph;
$chart	->noPackage()
		->addColumns(array(array('string', 'Text1'),array('string', 'Text1')))
		->setValues(
			array(
				array(0, 0, 'This is a test'),
		        array(0, 1, 'This test is quite hard'),
		        array(1, 0, 'A hard test or not?'),
		        array(1, 1, 'This was not too hard'),
		        array(2, 0, 'Hard hard hard this is so hard !!!'),
		        array(2, 1, 'For every test there is a solution. For every one'),
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();


?></body>
</html>
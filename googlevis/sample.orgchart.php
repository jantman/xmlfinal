<html>
<head>
</head>

<body>
<?php

include_once 'config.inc.php';

$chart = new QOrgchartGoogleGraph;
$chart	->addDrawProperties(
			array(
				"size" => "small"
				)
			)
		->addColumns(
			array(
				array('string', 'Task'),
				array('string', 'Manager')
				)
			)
		->setValues(
			array(
		        array(0, 0, 'Mike'),
		        array(1, 0, 'Jim'),
		        array(1, 1, 'Mike'),
		        array(2, 0, 'Alice'),
		        array(2, 1, 'Mike'),
		        array(3, 0, 'Bob'),
		        array(3, 1, 'Jim'),
		        array(4, 0, 'Carol'),
		        array(4, 1, 'Bob'),
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();

?>
</body>
</html>
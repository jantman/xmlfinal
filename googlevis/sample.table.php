<html>
<head>
</head>

<body>
<?php

include_once 'config.inc.php';

$chart = new QTableGoogleGraph;
$chart	->addDrawProperties(array('showRowNumber'=>'true',"allowHtml"=>'true','pageSize'=>2,'page'=>'enable'))

		->addColumns(
			array(
				array('string', 'Name'),
				array('number', 'Salary'),
				array('boolean', 'Full Time')
				)
			)
		->setValues(
			array(
			  array(0, 0, '<b>John</b>'),
			  array(0, 1, 10000, '$10,000'),
			  array(0, 2, true),
			  array(1, 0, 'Mary'),
			  array(1, 1, 25000, '$25,000'),
			  array(1, 2, true),
			  array(2, 0, 'Steve'),
			  array(2, 1, 8000, '$8,000'),
			  array(2, 2, true),
			  array(3, 0, 'Ellen'),
			  array(3, 1, 20000, '$20,000'),
			  array(3, 2, true),
			  array(4, 0, 'Mike'),
			  array(4, 1, 12000, '$12,000'),
			  array(4, 2, true),
						
			)
		);
echo $chart->render();

echo $chart->getReferenceLink();

?></body>
</html>
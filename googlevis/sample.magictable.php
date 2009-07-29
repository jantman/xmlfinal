<?php
	include_once 'config.php';

	$data = array();
	$i = 15;
	do
      {
         $j = 4;
         do
         {
            $data[] = array($i, $j, round(rand(0,10),0));
         }
         while ($j-- > 0); 
      }
      while ($i-- > 0);

	
    $chart = new QMixupGoogleGraph;
	
    $chart	->addMember(QChart::getInstance('QMagictableGoogleGraph')->noPackage())
    		->noPackage()
			->addColumns(array(
				array('number', 'column 1'),
				array('number', 'column 2'),
				array('number', 'column 3'),
				array('number', 'column 4'),
				array('number', 'column 5'),
				)
			)->setValues($data);

	$chart->render();

$result = $chart->render();

?><html>
<head>
<?php
echo $result->script;
?>
</head>
<body>
<div class="clearfix" style="height:25px"></div>
<?php
echo $result->MagicTable;
?>
</body>
</html>	
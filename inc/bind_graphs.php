<?php
// index.php
//
// +----------------------------------------------------------------------+
// | XML Final Project      http://xmlfinal.jasonantman.com               |
// +----------------------------------------------------------------------+
// | Copyright (c) 2009 Jason Antman.                                     |
// |                                                                      |
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License as published by |
// | the Free Software Foundation; either version 3 of the License, or    |
// | (at your option) any later version.                                  |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to:                           |
// |                                                                      |
// | Free Software Foundation, Inc.                                       |
// | 59 Temple Place - Suite 330                                          |
// | Boston, MA 02111-1307, USA.                                          |
// +----------------------------------------------------------------------+
// |Please use the above URL for bug reports and feature/support requests.|
// +----------------------------------------------------------------------+
// | Authors: Jason Antman <jason@jasonantman.com>                        |
// +----------------------------------------------------------------------+
// | $LastChangedRevision::                                             $ |
// | $HeadURL::                                                         $ |
// +----------------------------------------------------------------------+

/**
 * Generate HTML for a graph and table div of BIND queries by host and type.
 * @param int $age show results from this many seconds ago
 * @return string
 */

function bind_queryByHostType($age = 604800)
{
    $timeperiod = ageToTimePeriod($age);

    $res = '<div class="graphDiv" style="height: 480px; width: 640px;">'."\n";
    $chart = new QColumnchartGoogleGraph;
    $chart->addDrawProperties(array('title' => 'Incoming Queries by Type and Host, last '.$timeperiod, 'isStacked' => 'true', 'width' => 640, 'height' => 480, 'titleY' => 'Number of Queries', 'titleX' => 'Query Type'));
    $subquery = "SELECT SUM(i.iq_value) AS iq_value,i.iq_type,sr.sr_host FROM incoming_queries AS i LEFT JOIN stats_runs AS sr ON i.iq_sr_key=sr.sr_key WHERE sr_ts>=".(time() - $age)." GROUP BY i.iq_type ,sr.sr_host";
    $query = "SELECT DISTINCT i.iq_type,i1.iq_value AS svcs1_value,i2.iq_value AS web2_value FROM incoming_queries AS i LEFT JOIN (".$subquery.") AS i1 ON i1.iq_type=i.iq_type AND i1.sr_host='svcs1' LEFT JOIN (".$subquery.") AS i2 ON i2.iq_type=i.iq_type AND i2.sr_host='web2.jasonantman.com';";
    
    $chart->addColumns(array(array('string', 'Query Type'),array('number', 'svcs1'),array('number', 'web2')));
    
    $tableStr = '<tr><th>Type</th><th>svcs1</th><th>web2</th></tr>'."\n";
    $values = array();
    $result = mysql_query($query) or dberror($query, mysql_error());
    $count = 0;
    while($row = mysql_fetch_assoc($result))
    {
	$values[] = array($count, 0, $row['iq_type']);
	$values[] = array($count, 1, (int)$row['svcs1_value']);
	$values[] = array($count, 2, (int)$row['web2_value']);
	$tableStr .= '<tr><td>'.$row['iq_type'].'</td><td>'.$row['svcs1_value'].'</td><td>'.$row['web2_value'].'</td></tr>'."\n";
	$count++;
    }
    $chart->setValues($values);
    $res .= $chart->render(false, true)."\n";
    $res .= '</div> <!-- close graphDiv -->'."\n";
    $res .= '<div class="tableDiv">'."\n".'<table class="minorTableFloat">'."\n";
    $res .= $tableStr."\n";
    $res .= '</table>'."\n";
    $res .= '</div> <!-- close tableDiv -->'."\n";
    return $res;
}

?>
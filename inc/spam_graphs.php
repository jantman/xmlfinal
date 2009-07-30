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
 * Generate HTML for a graph table of spam percentage over a specified period.
 * @param int $age show results from this many seconds ago
 * @return string
 */

function spam_percentSpamGraph($age = 604800)
{
    $timeperiod = ageToTimePeriod($age);

    $res = '<div class="graphDiv" style="height: 480px; width: 640px;">'."\n";
    $chart = new QLinechartGoogleGraph;
    $chart->addDrawProperties(array('title' => 'Percentage of Incoming Mail marked as Spam, last '.$timeperiod, 'width' => 640, 'height' => 480, 'titleY' => 'Percent Spam', 'titleX' => 'Date', "pointSize" => 0, "smoothLine" => true, "legend" => "none"));

    $query = "SELECT DATE(FROM_UNIXTIME(log_ts)),COUNT(*),SUM(spamStatus) FROM messages WHERE DATE(FROM_UNIXTIME(log_ts))!= '2009-12-31' AND DATE(FROM_UNIXTIME(log_ts)) >= '".date("Y-m-d", (time() - $age))."' GROUP BY DATE(FROM_UNIXTIME(log_ts));";

    //echo '<p>'.$query.'</p>'."\n";

    $chart->addColumns(array(array('string', 'Date'),array('number', 'Spam Percent')));
    
    $values = array();
    $result = mysql_query($query) or dberror($query, mysql_error());
    $count = 0;
    while($row = mysql_fetch_assoc($result))
    {
	if($count == 0 || ($count % 3) == 0)
	{
	    $values[] = array($count, 0, $row['DATE(FROM_UNIXTIME(log_ts))']);
	}
	else
	{
	    $values[] = array($count, 0, "");
	}
	$values[] = array($count, 1, (((float)$row['SUM(spamStatus)']) / ((float)$row['COUNT(*)'])) * 100.0);
	$count++;
    }
    $chart->setValues($values);
    $res .= $chart->render(false, true)."\n";
    $res .= '</div> <!-- close graphDiv -->'."\n";
    return $res;
}

?>
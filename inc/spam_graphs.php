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

function spam_percentSpamGraph()
{
    global $config_spam_db_host, $config_spam_db_user, $config_spam_db_pass, $config_spam_db_name;
    $conn = mysql_connect($config_spam_db_host, $config_spam_db_user, $config_spam_db_pass) or die("Unable to connect to MySQL database for SPAM.<br />");
    mysql_select_db($config_spam_db_name) or die("Unable to select database: ".$config_spam_db_name.".<br />");

    $age = -1;
    $timeperiod = ageToTimePeriod($age);

    $res = "";
    $chart = new QAnnotatedtimelineGoogleGraph;
    $chart->ignoreContainer();
    $chart->addDrawProperties(array('title' => 'Percentage of Incoming Mail marked as Spam, last '.$timeperiod, 'width' => 640, 'height' => 480, 'titleY' => 'Percent Spam', 'titleX' => 'Date', "pointSize" => 0, "smoothLine" => true, "legend" => "none", "allValuesSuffix" => "%", ));

    $query = "SELECT DATE(FROM_UNIXTIME(log_ts)),COUNT(*),SUM(spamStatus) FROM messages WHERE DATE(FROM_UNIXTIME(log_ts))!= '2009-12-31' ";
    if($age != -1){     $query .= "AND DATE(FROM_UNIXTIME(log_ts)) >= '".date("Y-m-d", (time() - $age))."'";}
    $query .= "GROUP BY DATE(FROM_UNIXTIME(log_ts));";

    $chart->addColumns(array(array('date', 'Date'),array('number', 'Spam Percent')));
    
    $values = array();
    $result = mysql_query($query) or dberror($query, mysql_error());
    $count = 0;
    while($row = mysql_fetch_assoc($result))
    {
	$values[] = array($count, 0, makeJSDate($row['DATE(FROM_UNIXTIME(log_ts))']));
	$values[] = array($count, 1, (((float)$row['SUM(spamStatus)']) / ((float)$row['COUNT(*)'])) * 100.0);
	$count++;
    }
    $chart->setValues($values);
    $res .= $chart->render(false, true)."\n";
    $res = str_replace('<script type="text/javascript">', "", $res);
    $res = str_replace('</script>', "", $res);
    return $res;
}

function spam_byHour()
{
    global $config_spam_db_host, $config_spam_db_user, $config_spam_db_pass, $config_spam_db_name;
    $conn = mysql_connect($config_spam_db_host, $config_spam_db_user, $config_spam_db_pass) or die("Unable to connect to MySQL database for SPAM.<br />");
    mysql_select_db($config_spam_db_name) or die("Unable to select database: ".$config_spam_db_name.".<br />");

    $age = -1;
    $timeperiod = ageToTimePeriod($age);

    $res = '';
    $chart = new QLinechartGoogleGraph;
    $chart->addDrawProperties(array('title' => 'Spam Messages by Hour of Day (for all time)', 'isStacked' => 'true', 'width' => 640, 'height' => 480, 'titleY' => 'Number of Messages', 'titleX' => 'Hour of Day', 'legend' => 'none'));

    $query = "SELECT HOUR(FROM_UNIXTIME(log_ts)),COUNT(*) FROM messages GROUP BY HOUR(FROM_UNIXTIME(log_ts));";
    
    $chart->addColumns(array(array('string', 'Hour'),array('number', 'Number of Messages')));
    
    $values = array();
    $result = mysql_query($query) or dberror($query, mysql_error());
    $count = 0;
    while($row = mysql_fetch_assoc($result))
    {
	$values[] = array($count, 0, $row['HOUR(FROM_UNIXTIME(log_ts))']);
	$values[] = array($count, 1, (int)$row['COUNT(*)']);
	$count++;
    }
    $chart->setValues($values);
    $chart->ignoreContainer();
    $res .= $chart->render(false, true)."\n";
    $res = str_replace('<script type="text/javascript">', "", $res);
    $res = str_replace('</script>', "", $res);
    return $res;
}

function spam_byDay()
{
    global $config_spam_db_host, $config_spam_db_user, $config_spam_db_pass, $config_spam_db_name;
    $conn = mysql_connect($config_spam_db_host, $config_spam_db_user, $config_spam_db_pass) or die("Unable to connect to MySQL database for SPAM.<br />");
    mysql_select_db($config_spam_db_name) or die("Unable to select database: ".$config_spam_db_name.".<br />");

    $age = -1;
    $timeperiod = ageToTimePeriod($age);

    $res = ''."\n";
    $chart = new QLinechartGoogleGraph;
    $chart->addDrawProperties(array('title' => 'Spam Messages by Day of Week (for all time)', 'isStacked' => 'true', 'width' => 640, 'height' => 480, 'titleY' => 'Number of Messages', 'titleX' => 'Day of Week', 'legend' => 'none'));

    $query = "SELECT DAYNAME(FROM_UNIXTIME(log_ts)),COUNT(*) FROM messages GROUP BY DAYOFWEEK(FROM_UNIXTIME(log_ts));";
    
    $chart->addColumns(array(array('string', 'Day'),array('number', 'Number of Messages')));
    
    $values = array();
    $result = mysql_query($query) or dberror($query, mysql_error());
    $count = 0;
    while($row = mysql_fetch_assoc($result))
    {
	$values[] = array($count, 0, $row['DAYNAME(FROM_UNIXTIME(log_ts))']);
	$values[] = array($count, 1, (int)$row['COUNT(*)']);
	$count++;
    }
    $chart->setValues($values);
    $chart->ignoreContainer();
    $res .= $chart->render(false, true)."\n";
    $res = str_replace('<script type="text/javascript">', "", $res);
    $res = str_replace('</script>', "", $res);
    return $res;
}

?>
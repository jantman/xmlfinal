<?php
// logs_spam.php
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
$SVN_rev = "\$LastChangedRevision$";
$SVN_headURL = "\$HeadURL$";

require_once('config/config.php');
require_once('inc/common.php');
require_once('googlevis/config.inc.php');

$conn = mysql_connect($config_spam_db_host, $config_spam_db_user, $config_spam_db_pass) or die("Unable to connect to MySQL database for SPAM.<br />");
mysql_select_db($config_spam_db_name) or die("Unable to select database: ".$config_spam_db_name.".<br />");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Spam Stats</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h2>spamd stats</h2>

<?php
$query = "SELECT log_ts FROM messages WHERE DATE(FROM_UNIXTIME(log_ts))!= '2009-12-31' ORDER BY log_ts DESC LIMIT 1;";
$result = mysql_query($query) or dberror($query, mysql_error());
$row = mysql_fetch_assoc($result);
$foo = $row['log_ts'];
?>

<h3>mailmaster.jasonantman.com, data as of <?php echo date($config_header_date_format, $foo); ?></h3>

<div>
<label for="type">Type: </label>
<select name="type" id="type">
<option value="percent">Spam vs Ham</option>
<option value="hour">Spam by Hour of Day</option>
<option value="day">Spam by Day of Week</option>
</select>
<em>(changing selection populates the below (outlined blue) div for that zone)</em>
</div>

<div class="graphPageContainer">

<?php require_once("inc/spam_graphs.php"); ?>

<!-- BEGIN ONE GRAPH -->
<div class="graphContainer" id="graphContainer1" style="height: 100%;">
<?php
echo spam_percentSpamGraph(604800); // 7 days
?>
</div> <!-- close graphContainer Div -->
<!-- END ONE GRAPH -->

<!-- <div class="clearing"></div> -->

<!-- BEGIN ONE GRAPH -->
<div class="graphContainer" id="graphContainer2" style="height: 100%;">
<?php
//echo spam_percentSpamGraph(2592000); // 7 days
?>
</div> <!-- close graphContainer Div -->
<!-- END ONE GRAPH -->

</div> <!-- close graphPageContainer DIV -->

</div> <!-- close content DIV -->

<?php printFooter(); ?>
</body>

</html>

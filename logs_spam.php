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

if(isset($_GET['type'])){ $type = $_GET['type'];} else { $type = "percent";}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Spam Stats</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
<script language="javascript" type="text/javascript" src="inc/forms.js"></script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h2>spamd stats</h2>

<?php
$conn = mysql_connect($config_spam_db_host, $config_spam_db_user, $config_spam_db_pass) or die("Unable to connect to MySQL database for SPAM.<br />");
mysql_select_db($config_spam_db_name) or die("Unable to select database: ".$config_spam_db_name.".<br />");
$query = "SELECT log_ts FROM messages WHERE DATE(FROM_UNIXTIME(log_ts))!= '2009-12-31' ORDER BY log_ts DESC LIMIT 1;";
$result = mysql_query($query) or dberror($query, mysql_error());
$row = mysql_fetch_assoc($result);
$foo = $row['log_ts'];
mysql_close($conn);
?>

<h3>mailmaster.jasonantman.com, data as of <?php echo date($config_header_date_format, $foo); ?></h3>

<div>
<label for="type">Type: </label>
<select name="type" id="type" onchange="spamUpdate();">
<option value="percent" selected="selected">Spam vs Ham</option>
<option value="hour">Spam by Hour of Day</option>
<option value="day">Spam by Day of Week</option>
</select>
</div>

<div class="graphPageContainer" id="graphPageContainer">

<?php require_once("inc/spam_graphs.php"); ?>

<!-- BEGIN ONE GRAPH -->
<div class="graphContainer" id="graphContainer1" style="height: 100%;">
<?php
echo '<div class="graphDiv" style="height: 480px; width: 640px;">';
echo '<div id="linechart"></div><div id="annotatedtimeline" style="width:740px;height:240px;"></div>'."\n";
echo '<script type="text/javascript">';
if($type == "percent")
{
    echo spam_percentSpamGraph(604800);
}
elseif($type == "day")
{
    echo spam_byDay();
}
else
{
    echo spam_byHour();
}
echo '</script>';
echo '</div> <!-- close graphDiv -->'."\n";
?>
</div> <!-- close graphContainer Div -->
<!-- END ONE GRAPH -->

</div> <!-- close graphPageContainer DIV -->

<p><em><strong>Description:</strong>This chart pulls data from a local MySQL data source and graphs it using Google Visualization. The only complaint that I have is that the Google Vis API does not seem to have a way to set the zoom to default to 1 month for the annotated timeline.</em></p>

</div> <!-- close content DIV -->

<?php printFooter(); ?>
</body>

</html>

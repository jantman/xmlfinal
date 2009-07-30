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
require_once('config/config.php');
require_once('inc/common.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Bind Stats</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h2>BIND statistics</h2>

<?php
require_once('googlevis/config.inc.php');
$conn = mysql_connect($config_bind_db_host, $config_bind_db_user, $config_bind_db_pass) or die("Unable to connect to MySQL database for BIND.<br />");
mysql_select_db($config_bind_db_name) or die("Unable to select database: ".$config_bind_db_name.".<br />");

?>

<div>
<label for="zone">Site: </label>
<select name="zone" id="zone">
<option value="all">ALL ZONES</option>
<option value="1">1.example.com</option>
<option value="2">2.example.com</option>
<option value="3">3.example.com</option>
<option value="4">4.example.com</option>
<option value="5">5.example.com</option>
</select>
<em>(changing selection populates the below (outlined blue) div for that zone)</em>
</div>

<div>
<label for="view">View: </label>
<input type="radio" name="view" id="view_both" checked="checked" /><label for="view_both">Both</label>
<input type="radio" name="view" id="view_inside" /><label for="view_inside">Inside</label>
<input type="radio" name="view" id="view_outside" /><label for="view_outside">Outside</label>
<em>(changing selection populates the below (outlined blue) div for that view)</em>
</div>

<div>
<label for="comparison">Comparison: </label>
<br />
<input type="radio" name="comparison" id="comparison_dayweek" checked="checked" /><label for="comparison_dayweek">Comarison of all NSs, 24 hours and 7 days, by NS</label>
<br />
<input type="radio" name="comparison" id="comparison_week" /><label for="comparison_inside">All NSs, last 7 days and last year, by NS</label>
<br />
<input type="radio" name="comparison" id="comparison_zone" /><label for="comparison_zone">Comarison of all NSs, 24 hours and 7 days, by Zone</label>
<em>(changing selection populates the below (outlined blue) div for that comparison)</em>
</div>

<div class="graphPageContainer">

<?php require_once("inc/bind_graphs.php"); ?>

<!-- BEGIN ONE GRAPH -->
<div class="graphContainer" id="graphContainer1" style="height: 100%;">
<?php
echo bind_queryByHostType(604800); // 7 days
?>
</div> <!-- close graphContainer Div -->
<!-- END ONE GRAPH -->

<!-- <div class="clearing"></div> -->

<!-- BEGIN ONE GRAPH -->
<div class="graphContainer" id="graphContainer2" style="height: 100%;">
<?php
echo bind_queryByHostType(86400); // 7 days
?>
</div> <!-- close graphContainer Div -->
<!-- END ONE GRAPH -->

</div> <!-- close graphPageContainer DIV -->

</div> <!-- close content DIV -->

<?php printFooter(); ?>
</body>

</html>

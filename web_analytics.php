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
<title>XML Final</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<div>
<label for="analytics_site">Site: </label>
<select name="analytics_site" id="analytics_site">
<option value="1">1.example.com</option>
<option value="2">2.example.com</option>
<option value="3">3.example.com</option>
<option value="4">4.example.com</option>
<option value="5">5.example.com</option>
</select>
<em>(changing selection populates the below (outlined blue) div for that site)</em>
</div>

<div id="siteContainer" style="margin-left: auto; margin-right: auto; width: 100%; border: 1px solid blue; margin-top: 2em;">

<div>
<label for="analytics_metric">Metric: </label>
<select name="analytics_metric" id="analytics_metric">
<option value="summary">Summary</option>
<option value="visits">Visits</option>
<option value="sources">Traffic Sources</option>
<option value="content">Content</option>
<option value="search">Search Engines</option>
</select>
<em>(changing this select populates the below div with data)</em>
</div>

<div id="siteData" style="margin-left: auto; margin-right: auto; width: 90%; border: 1px solid red; margin-top: 2em;">

<!-- FILLER -->
<div style="margin-left: auto; margin-right: auto; margin-top: 2px; margin-bottom: 1px; border: 2px dashed black; width: 640px; height: 480px;"><p style="text-align: center; font-weight: bold; font-style: italic;">(graph goes here)</p></div>
<div style="margin-left: auto; margin-right: auto; margin-top: 2px; margin-bottom: 1px; border: 2px dashed black; width: 640px; height: 200px;"><p style="text-align: center; font-weight: bold; font-style: italic;">(table with data here)</p></div>
<!-- END FILLER -->

</div> <!-- close siteData div -->

</div> <!-- close siteContainer div -->

<?php error_log("PAGE NOT IMPLEMENTED: ".$_SERVER["SCRIPT_FILENAME"]); ?>

</div>

<?php printFooter(); ?>
</body>

</html>

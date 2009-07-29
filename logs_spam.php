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

<h2>spamd stats</h2>
<h3>(server name, date/time of newest data)</h3>
<?php error_log("PAGE NOT IMPLEMENTED: ".$_SERVER["SCRIPT_FILENAME"]); ?>

<div style="margin-left: auto; margin-right: auto; margin-top: 2px; margin-bottom: 1px; border: 2px dashed black; width: 640px; height: 480px;"><p style="text-align: center; font-weight: bold; font-style: italic;">(column graph of spam rule hits (as percentage of total hits) for week, month, year)</p></div>

<div style="margin-left: auto; margin-right: auto; margin-top: 2px; margin-bottom: 1px; border: 2px dashed black; width: 640px; height: 480px;"><p style="text-align: center; font-weight: bold; font-style: italic;">(column graph of total number of spam messages by hour of day for week, month, year)</p></div>

<div style="margin-left: auto; margin-right: auto; margin-top: 2px; margin-bottom: 1px; border: 2px dashed black; width: 640px; height: 200px;"><p style="text-align: center; font-weight: bold; font-style: italic;">(table of all spamd rules used with name, description, link to SpamAssassin wiki page)</p></div>

</div>

<?php printFooter(); ?>
</body>

</html>

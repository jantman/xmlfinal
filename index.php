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
// | $LastChangedRevision:: 1                                           $ |
// | $HeadURL:: http://svn.jasonantman.com/multibindadmin/index.php     $ |
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

<p><a href="antman_final_proposal.pdf">PDF of proposal</a></p>

<p>After doing the below storyboard as a base for the site (took screenshot of another site I did with this layout and changed text) I realized that it was taking me MUCH longer to edit things together in a paint program than it would to just do up some quick-and-dirty HTML. So, for the storyboards, I have non-functional, rough-layout-only versions of a few of the pages for this site. Obviously, the design is quite rough and missing many key elements (and Im not yet sure about the dual navigation menu setup). </p>
<ul>
<li><a href="logs_spam.php">spamd (SpamAssassin) logs - MySQL data source, Google Visualization API</a></li>
<li><a href="logs_bind.php">bind (named) logs - MySQL data source, Google Visualization API</a></li>
<li><a href="web_webmaster.php">Google Webmaster Tools API</a></li>
<li><a href="web_analytics.php">Google Analytics API - Google Analytics XML raw data, Google Visualization API</a></li>
<li><a href="nagios.php">Nagios - Nagios statusXML feed, most likely a simple table display.</a></li>
</ul>

<img src="main.jpeg" width="800" height="817" alt="main_storyboard" style="border: 2px solid black;" />

<br /><br />

<h3>Planned Data Sources:</h3>
<table class="mainTable">
<tr><th>Data Source</th><th>Location</th><th>Have data?</th><th>Implemented?</th></tr>
<tr><td>Nagios</td><td>XML feed</td><td>yes</td><td>Partially</td></tr>
<tr><td>Webmaster Tools</td><td>XML API </td><td>Yes </td><td>no </td></tr>
<tr><td>G Analytics </td><td>XML feed </td><td>partial </td><td>no </td></tr>
<tr><td>spamd logs </td><td>MySQL </td><td>yes </td><td>table only </td></tr>
<tr><td>BIND logs </td><td>MySQL </td><td>NO </td><td>no </td></tr>
<tr><td colspan="4"><em>optional data sources</em></td></tr>
<tr><td>MySQL stats </td><td>MySQL </td><td>partial </td><td>table only </td></tr>
<tr><td>Webalizer </td><td>standalone HTML </td><td>&nbsp; </td><td>&nbsp; </td></tr>
<tr><td>AWstats </td><td>standalone HTML </td><td>&nbsp; </td><td>&nbsp; </td></tr>
<tr><td>syslog </td><td>MySQL? </td><td>NO </td><td>no </td></tr>
</table>

</div>

<?php printFooter(); ?>
</body>

</html>

<?php
// nagios.php
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>XML Final</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
<!-- nagios-specific -->
<link rel="stylesheet" type="text/css" href="css/systemStatus.css" />
<!-- nagios-specific -->
<script language="javascript" type="text/javascript" src="inc/forms.js"></script>
</head>

<body>
<?php
printHeader(); 
if(isset($_GET['filter'])){ $filter = $_GET['filter'];}
if(isset($_GET['host'])){ $host = $_GET['host'];}
?>

<div id="content">

<h2>Nagios Current Problems</h2>

<p><em><strong>Note:</strong> To limit load on the monitoring server, this example page is using a static copy of status.xml. The data is only updated every 30 minutes.</em></p>

<?php
require_once('inc/parseNagiosXML.php');


echo getFieldDescriptionP();
?>

<div id="formDiv">
<strong>Filter: </strong>
<select name="filter" id="filter" onchange="updateHostDiv()">
<?php
if(isset($filter) && $filter == "host")
{
    echo '<option value="onlybad">Only Problems</option>';
    echo '<option value="all">All</option>';
    echo '<option value="host" selected="selected">Host</option>';
}
elseif(isset($filter) && $filter == "all")
{
    echo '<option value="onlybad">Only Problems</option>';
    echo '<option value="all" selected="selected">All</option>';
    echo '<option value="host">Host</option>';
}
else
{
    echo '<option value="onlybad" selected="selected">Only Problems</option>';
    echo '<option value="all">All</option>';
    echo '<option value="host">Host</option>';
}
echo '</select>'."\n";

echo "\n".'<div id="hostDiv"';
if(! isset($host)){ echo ' style="display: none;"';}
echo '>'."\n";
echo '<strong>Host: </strong>';
echo '<select name="host" id="host">'."\n";
foreach($hosts as $value)
{
    $name = $value->getElementsByTagName("host_name")->item(0)->nodeValue;
    echo '<option value="'.$name.'">'.$name.'</option>';
}
echo "\n".'</select>'."\n";
echo '</div> <!-- close hostDiv -->'."\n";
?>
</select>
<p><a href="javascript:updateNagios()">Update</a>&nbsp;&nbsp;&nbsp;<a href="javascript:resetNagios()">Reset</a></p>

</div> <!-- close formDiv -->

<div id="nagiosContainer">
<?php
echo getProgramInfo();
echo getTableHeader();
echo getStatusTRs(true);
echo getTableFooter();
?>
</div> <!-- close nagiosContainer DIV -->

</table>

<p><em>Description:</em>On the Nagios server, the <a href="http://svn.jasonantman.com/nagios-xml/statusXML.php">statusXML.php</a> script parses the Nagios (v2 or v3) status.dat file into XML. On the web server, <a href="http://svn.jasonantman.com/nagios-xml/parseNagiosXML.php">parseNagiosXML.php</a> is used to parse the XML and return an associative array of values, which is used to populate the table.</p>

</div>

<?php printFooter(); ?>
</body>

</html>

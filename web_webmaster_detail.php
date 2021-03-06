<?php
// web_webmaster_detail.php
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
require_once('inc/google_webmaster.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Google Webmaster Tools Detail</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
<script language="javascript" type="text/javascript" src="inc/forms.js"></script>
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h2>Google Webmaster Tools</h2>

<?php

$id = $_GET['site'];

$conn = mysql_connect($config_bind_db_host, $config_bind_db_user, $config_bind_db_pass) or die("Unable to connect to MySQL database for BIND.<br />");
mysql_select_db('site') or die("Unable to select database: site.<br />");

echo '<select name="site" id="site" onchange="updateWebmaster()">'."\n";
$query = "SELECT id FROM webmaster_tools;";
$result = mysql_query($query);
while($row = mysql_fetch_assoc($result))
{
    echo '<option value="'.urlencode($row['id']).'" ';
    if($id == $row['id']){ echo 'selected="selected"';}
    echo '>'.$row['id'].'</option>';
}
echo "\n".'</select>'."\n";

echo '<div id="webmasterTools">'."\n";
echo googlewebm_show_details($id);
echo '</div> <!-- close webmasterTools DIV -->'."\n";

?>

<p><em><strong>Description:</strong> This pulls data in real time from the Google Webmaster Tools XML API.</em></p>

</div>

<?php printFooter(); ?>
</body>

</html>

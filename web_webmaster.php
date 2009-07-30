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

<h3>Google Webmaster Tools</h3>

<table class="mainTable">
<tr><th>Site</th><th>Google Data</th><th>Indexed</th><th>Crawled</th><th>Crawl Rate</th><th>Verified</th></tr>

<?php

require_once('inc/google_data.php');
$client = null;
$auth_result = google_auth_start($CREDENTIAL_google_webmaster_user, $CREDENTIAL_google_webmaster_pass, $client);
if($auth_result != "success"){ echo $auth_result; printFooter(); }

require_once('inc/google_webmaster.php');
$foo = googlewebm_list_sites($client);
foreach($foo as $name => $arr)
{
    echo '<tr>'."\n";

    echo '<td><a href="'.$name.'">'.$name.'</td>';

    echo '<td><a href="web_webmaster_detail.php?site='.urlencode($name).'">Detail</a></td>';

    if(isset($arr['indexed'])){ echo '<td>yes</td>';} else { echo '<td><strong>NO</strong></td>';}

    if(isset($arr['crawled']))
    {
	echo '<td>'.$arr['crawled'].'</td>';
    }
    else
    {
	echo '<td><strong>NO</strong></td>';
    }

    if(isset($arr['crawl-rate'])){ echo '<td>'.$arr['crawl-rate'].'</td>';} else { echo '<td>&nbsp;</td>';}

    if(isset($arr['verified'])){ echo '<td>yes</td>';} else { echo '<td><strong>NO</strong></td>';}

    echo '</tr>'."\n";
}


?>



</table>

<ul>
<li><strong>Site</strong> - site name, link to DHTML popup with detailed site information</li>
<li><strong>Sitemaps</strong> - yes/no, link adds td with colspan=4 to table showing detailed sitemap information, link to add or remove site maps</li>
<li><strong>Messages</strong> - shows number of messages waiting in Webmaster Tools, link to DHTML popup that lists all messages and subjects. Each message within the popup has a link that will reload the popup with the message text.</li>
<li><strong>Crawl Errors</strong> - lists number of issues found while crawling. clicking on the number of issues (link) adds a full width TD below the current row in the table, showing all crawl issues.</li>
</ul>

</div>

<?php printFooter(); ?>
</body>

</html>

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
// | $LastChangedRevision:: 7                                           $ |
// | $HeadURL:: http://svn.jasonantman.com/xmlfinal/web_webmaster.php   $ |
// +----------------------------------------------------------------------+
$SVN_rev = "\$LastChangedRevision: 31 $";
$SVN_headURL = "\$HeadURL: http://svn.jasonantman.com/ncd/index.php $";

require_once('config/config.php');
require_once('inc/common.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Google Webmaster Tools Detail</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h2>Google Webmaster Tools</h2>
<h2><?php echo '<a href="'.$_GET['site'].'">'.$_GET['site'].'</a>';?></h2>

<?php
require_once('inc/google_data.php');
$client = null;
$auth_result = google_auth_start($CREDENTIAL_google_webmaster_user, $CREDENTIAL_google_webmaster_pass, "sitemaps", $client);
if($auth_result != "success"){ echo $auth_result; printFooter(); }

require_once('inc/google_webmaster.php');

// sitemaps
$foo = googlewebm_site_details($client, $_GET['site'], "sitemaps");

echo '<h3>Sitemaps</h3>';

echo '<table class="mainTable">'."\n";
echo '<tr><th>URL</th><th>Type</th><th>Status</th><th>Last Downloaded</th><th>URL Count</th></tr>'."\n";
if(count($foo) == 0)
{
    echo '<tr><td colspan="5" style="text-align: center; font-style: italic;"><span>None.</span></td></tr>'."\n";
}
else
{
    foreach($foo as $key => $arr)
    {
	echo '<tr>';
	echo '<td><a href="'.$arr['type'].'">'.$arr['type'].'</a></td>';
	echo '<td>'.$arr['sitemap-type'].'</td>';
	echo '<td>'.$arr['sitemap-status'].'</td>';
	echo '<td>'.$arr['sitemap-last-downloaded'].'</td>';
	echo '<td>'.$arr['sitemap-url-count'].'</td>';
	echo '</tr>'."\n";
    }
}
echo '</table>'."\n";

// messages
echo '<h3>Messages</h3>';
$foo = googlewebm_site_details($client, $_GET['site'], "messages");
if(count($foo) == 0)
{
    echo '<p style="font-style: italic;">None.</p>'."\n";
}
else
{
    echo "<p>=========================\n";
    echo var_dump($foo);
    echo "=========================</p>\n";
}

// crawl issues
$foo = googlewebm_site_details($client, $_GET['site'], "crawlissues");
echo '<h3>Crawl Issues</h3>';

echo '<table class="mainTable">'."\n";
echo '<tr><th>Crawl Type</th><th>Issue Type</th><th>URL</th><th>Date Detected</th><th>Detail</th></tr>'."\n";
if(count($foo) == 0)
{
    echo '<tr><td colspan="5" style="text-align: center; font-style: italic;"><span>None.</span></td></tr>'."\n";
}
else
{
    foreach($foo as $key => $arr)
    {
	echo '<tr>';
	echo '<td>'.$arr['crawl-type'].'</td>';
	echo '<td>'.$arr['issue-type'].'</td>';
	echo '<td><a href="'.$arr['url'].'">'.$arr['url'].'</a></td>';
	echo '<td>'.$arr['date-detected'].'</td>';
	echo '<td>'.$arr['detail'].'</td>';
	echo '</tr>'."\n";
    }
}
echo '</table>'."\n";


?>


</div>

<?php printFooter(); ?>
</body>

</html>

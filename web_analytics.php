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
<title>Google Analytics</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
</head>

<body>
<?php printHeader(); ?>

<div id="content">

<h3>Analytics</h3>

<?php

require_once('inc/google_data.php');
$client = null;
$auth_result = google_auth_start($CREDENTIAL_google_webmaster_user, $CREDENTIAL_google_webmaster_pass, "analytics", $client);
if($auth_result != "success"){ echo $auth_result; printFooter(); die(); }

require_once('inc/google_analytics.php');
googleana_update_sites($client, $CREDENTIAL_google_webmaster_user);
$sites = googleana_list_sites();

$first_site_id = "";

echo '<p>'."\n";
echo '<label for="siteID">Site: </label><select name="site" id="site">';
foreach($sites as $name => $id)
{
    echo '<option value="'.$id.'">'.$name.'</option>';
    if($first_site_id==""){ $first_site_id = $id;}
}
echo '</select>'."\n";
echo '</p>'."\n";

?>

<div id="analyticsContainer">

<?php
echo '<pre>';
echo $first_site_id."\n";
echo getGoogleAnaContent($client, $first_site_id);
echo '</pre>';
?>

</div> <!-- END analyticsContainer DIV -->


</div>

<?php printFooter(); ?>
</body>

</html>

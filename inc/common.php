<?php
// common.php - common functions
//
// +----------------------------------------------------------------------+
// | MultiBindAdmin      http://multibindadmin.jasonantman.com            |
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
// | $HeadURL:: http://svn.jasonantman.com/multibindadmin/inc/common.ph#$ |
// +----------------------------------------------------------------------+


// setup MySQL connection
//$conn = mysql_connect($config_db_host, $config_db_user, $config_db_pass) or die("Unable to connect to MySQL database.<br />");
//mysql_select_db($config_db_name) or die("Unable to select database: ".$config_db_name.".<br />");

function printHeader()
{
    $links = array();
    $links["#"] = "&nbsp;";
    $links["index.php"] = "Home";
    $links["logs.php"] = "Logs";
    $links["web.php"] = "Web";
    $links["syslog.php"] = "Syslog";

    $catLinks = array();
    $catLinks["Home"] = array("#" => "&nbsp;", "index.php" => "Home",  "hosts.php" => "Hosts", "sites.php" => "Sites", "nagios.php" => "Nagios");
    $catLinks["Logs"] = array("#" => "&nbsp;", "logs.php" => "Summary", "logs_spam.php" => "spamd", "logs_bind.php" => "BIND", "logs_mysql.php" => "MySQL");
    $catLinks["Web"] = array("#" => "&nbsp;", "web.php" => "Summary", "web_webmaster.php" => "Google Webmaster", "web_analytics.php" => "Google Analytics", "web_webalizer.php" => "Webalizer");
    $catLinks["Syslog"] = array("#" => "&nbsp;", "syslog.php" => "Summary", "syslog_tail.php" => "Tail", "syslog_search.php" => "Search", "syslog_stats.php" => "Stats");

    // find current page name
    $currentScript = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/")+1);    
    if(isset($links[$currentScript])){ $currentCat = $links[$currentScript];}
    else
    {
	foreach($catLinks as $catName => $arr)
	{
	    if(array_key_exists($currentScript, $arr)){ $currentCat = $catName;}
	}
    }

    echo '<div id="headerContainer">'."\n";
    echo '<div id="header">'."\n";
    echo '	<h1>PHP Admin Portal</h1>'."\n";
    echo '</div>'."\n";
    echo '<ul id="nav">'."\n";

    $count = 0;
    foreach($links as $url => $name)
    {
	$count++;
	if($name == $currentCat)
	{
	    echo '	<li id="nav-'.$count.'" class="activeNav"><a href="'.$url.'">'.$name.'</a></li>'."\n";
	    $currentName = $name;
	}
	else
	{
	    echo '	<li id="nav-'.$count.'"><a href="'.$url.'">'.$name.'</a></li>'."\n";
	}
    }
    echo '</ul>'."\n";
    echo '<ul id="navLower">'."\n";

    $count = 0;
    $subLinks = $catLinks[$currentCat];
    foreach($subLinks as $url => $name)
    {
	$count++;
	if($url == $currentScript)
	{
	    echo '	<li id="nav-'.$count.'" class="activeNavLower"><a href="'.$url.'">'.$name.'</a></li>'."\n";
	}
	else
	{
	    echo '	<li id="nav-'.$count.'"><a href="'.$url.'">'.$name.'</a></li>'."\n";
	}
    }
    echo '</ul>'."\n";
    echo '</div> <!-- close headerContainer DIV -->'."\n";
    echo '<div class="clearing"></div>'."\n";
}

function printFooter()
{
    echo '<div id="footer">'."\n";
    
    echo '</div> <!-- close footer DIV -->'."\n";
}

function dberror($query, $error)
{
    error_log("Database error!\nQuery: $query\nError: $error\n");
    die("Database error. Script dieing...<br />");
}

function makeZoneSerial($current)
{
    if(substr($current, 0, 8) == date("Ymd"))
    {
	$ser = (int)substr($current, 8);
	$ser++;
	return date("Ymd").sprintf("%'02u", $ser);
    }
    else
    {
	$ser = 0;
	return date("Ymd").sprintf("%'02u", $ser);
    }

}

function updateZoneSerial($zone_id, $view)
{
    if($view == "both" || $view == "inside")
    {
	$query = "SELECT current_serial FROM soa_records WHERE zone_id=".((int)$zone_id)." AND view='inside';";
	$result = mysql_query($query) or dberror($query, mysql_error());
	$row = mysql_fetch_assoc($result);
	$new = makeZoneSerial($row['current_serial']);
	$query = "UPDATE soa_records SET current_serial=".$new." WHERE zone_id=".((int)$zone_id)." AND view='inside';";
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
    if($view == "both" || $view == "outside")
    {
	$query = "SELECT current_serial FROM soa_records WHERE zone_id=".((int)$zone_id)." AND view='outside';";
	$result = mysql_query($query) or dberror($query, mysql_error());
	$row = mysql_fetch_assoc($result);
	$new = makeZoneSerial($row['current_serial']);
	$query = "UPDATE soa_records SET current_serial=".$new." WHERE zone_id=".((int)$zone_id)." AND view='outside';";
	$result = mysql_query($query) or dberror($query, mysql_error());
    }
}

?>
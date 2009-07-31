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
// | $LastChangedRevision::                                             $ |
// | $HeadURL::                                                         $ |
// +----------------------------------------------------------------------+


// setup MySQL connection
//$conn = mysql_connect($config_db_host, $config_db_user, $config_db_pass) or die("Unable to connect to MySQL database.<br />");
//mysql_select_db($config_db_name) or die("Unable to select database: ".$config_db_name.".<br />");

function printHeader()
{
    $links = array();
    $links["#"] = "&nbsp;";
    $links["index.php"] = "Home";
    $links["logs.php"] = "Stats";
    $links["web.php"] = "Web";
    $links["syslog.php"] = "Syslog";

    $catLinks = array();
    $catLinks["Home"] = array("#" => "&nbsp;", "index.php" => "Home",  "hosts.php" => "Hosts", "sites.php" => "Sites", "nagios.php" => "Nagios");
    $catLinks["Stats"] = array("#" => "&nbsp;", "logs.php" => "Summary", "logs_spam.php" => "spamd", "logs_bind.php" => "BIND", "logs_mysql.php" => "MySQL");
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
    global $SVN_rev, $SVN_headURL;
    echo '<div id="footer">'."\n";
    if($_SERVER['REQUEST_URI'] != "/" && $_SERVER['REQUEST_URI'] != "/index.php")
    {
	echo '<a href="index.php">Home</a><br />'."\n";
    }

    echo '<p>Copyright 2009 <a href="http://www.jasonantman.com">Jason Antman</a> All Rights Reserved.<br />This project was written for a college course at Rutgers University, and incorporates software written by the author for other purposes, as well as software written by other parties.</p>.';

    echo 'Page Generated at '.date("Y-m-d H:i:s").' on '.$_SERVER['SERVER_NAME'].' ('.trim(exec("hostname")).')<br />'."\n";
    echo 'File last modified at '.date("Y-m-d H:i:s", filemtime("/srv/www/vhosts/sandbox.jasonantman.com".$_SERVER["SCRIPT_NAME"]))."<br />\n";
    if(isset($SVN_rev) && isset($SVN_headURL)){ echo "Subversion Revision: ".stripSVNstuff($SVN_rev)." Head: <a href=\"".stripSVNstuff($SVN_headURL)."\">".stripSVNstuff($SVN_headURL)."</a>\n";}
    echo $_SERVER["SERVER_SIGNATURE"]."<br />"."\n";
    echo '</div> <!-- close footer DIV -->'."\n";
}

/**
 * Strip out junk from subversion keyword-replaced variables
 * @param string $s original string
 * @return string
 */
function stripSVNstuff($s)
{
    $s = substr($s, strpos($s, ":")+1);
    $s = str_replace("$", "", $s);
    return trim($s);
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

/**
 * Converts a numeric age in seconds to a textual time period
 * @param int $age age in seconds
 * @return string
 */
function ageToTimePeriod($age)
{
    switch ($age)
    {
	case 604800:
	    return "7 Days";
	case 86400:
	    return "24 Hours";
	case 2592000:
	    return "30 Days";
    }
    return $age." seconds";
}

?>
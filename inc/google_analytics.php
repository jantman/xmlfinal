<?php
// inc/google_analytics.php
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
// | $LastChangedRevision:: 6                                           $ |
// | $HeadURL:: http://svn.jasonantman.com/xmlfinal/inc/google_webmaste#$ |
// +----------------------------------------------------------------------+

require_once('Zend/Gdata.php');
require_once('Zend/Gdata/Query.php');

/**
 * Return a list of the names of the sites in a analytics account, along with the side IDs.
 *  Also update the list in MySQL.
 * @param Zend_Http_Client $client an established authenticated connection to Google.
 * @param string $email_address
 * @return boolean
 */
function googleana_update_sites(&$client, $email_address)
{
    global $config_googleana_cache_db_host, $config_googleana_cache_db_user, $config_googleana_cache_db_pass, $config_googleana_cache_db_name, $config_googleana_cache_table, $config_googleana_cache_ttl;
    $conn = mysql_connect($config_googleana_cache_db_host, $config_googleana_cache_db_user, $config_googleana_cache_db_pass) or die("Unable to connect to MySQL database for SPAM.<br />");
    mysql_select_db($config_googleana_cache_db_name) or die("Unable to select database: ".$config_googleana_cache_db_name.".<br />");

    $query = "SELECT MAX(last_update_ts) FROM ".$config_googleana_cache_table.";";
    $result = mysql_query($query) or dberror($query, mysql_error());
    $row = mysql_fetch_assoc($result);
    $last_update = $row['MAX(last_update_ts)'];

    if($last_update >= (time() - $config_googleana_cache_ttl)) { return false;}

    $feed = google_get_feed($client, 'https://www.google.com/analytics/feeds/accounts/default');

    foreach ($feed as $entry)
    {
	foreach($entry->extensionElements as $elem)
	{
	    if(trim((string)$elem->rootElement) == "tableId")
	    {
		$elem = (string)$elem;
		$id = (int)trim(substr($elem, strpos($elem, ":")+1));
		$query = "INSERT INTO ".$config_googleana_cache_table." SET name='".$entry->title->text."',id=".$id.",last_update_ts=".time()." ON DUPLICATE KEY UPDATE id=".$id.",last_update_ts=".time().";";
		echo $query."\n";
		$result = mysql_query($query) or dberror($query, mysql_error());
	    }
	}
    }
    return true;
}

/**
 * Return a list of the names of the sites in a analytics account, along with the side IDs.
 * @param Zend_Http_Client $client an established authenticated connection to Google.
 * @param string $email_address
 * @return array
 */
function googleana_list_sites()
{
    global $config_googleana_cache_db_host, $config_googleana_cache_db_user, $config_googleana_cache_db_pass, $config_googleana_cache_db_name, $config_googleana_cache_table, $config_googleana_cache_ttl;
    $conn = mysql_connect($config_googleana_cache_db_host, $config_googleana_cache_db_user, $config_googleana_cache_db_pass) or die("Unable to connect to MySQL database for SPAM.<br />");
    mysql_select_db($config_googleana_cache_db_name) or die("Unable to select database: ".$config_googleana_cache_db_name.".<br />");

    $res = array();

    $query = "SELECT name,id FROM ".$config_googleana_cache_table.";";
    $result = mysql_query($query) or dberror($query, mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
	$res[$row['name']] = $row['id'];
    }

    return $res;
}

/**
 * Return the HTML div content for Google Analytics data on a specific site.
 * @param Zend_Http_Client $client an established authenticated connection to Google.
 * @param int $siteID the profile ID
 * @return string
 */
function getGoogleAnaContent($client, $siteID)
{
    $res = "";
    echo "client=$client,siteID=$siteID\n";
    $url = "https://www.google.com/analytics/feeds/data?start-date=2009-07-01&end-date=2009-07-30&dimensions=ga:source,ga:medium&metrics=ga:visits,ga:bounces&sort=-ga:visits&filters=ga:medium%3D%3Dreferral&max-results=5&ids=ga:$siteID&prettyprint=true";
    echo $url."\n";
    $feed = google_get_feed($client, $url);

    return $feed;

    foreach ($feed as $entry)
    {
	foreach($entry->extensionElements as $elem)
	{
	    if(trim((string)$elem->rootElement) == "tableId")
	    {
		$elem = (string)$elem;
		$id = (int)trim(substr($elem, strpos($elem, ":")+1));
		$query = "INSERT INTO ".$config_googleana_cache_table." SET name='".$entry->title->text."',id=".$id.",last_update_ts=".time()." ON DUPLICATE KEY UPDATE id=".$id.",last_update_ts=".time().";";
		echo $query."\n";
		$result = mysql_query($query) or dberror($query, mysql_error());
	    }
	}
    }

    return $res;
}


?>
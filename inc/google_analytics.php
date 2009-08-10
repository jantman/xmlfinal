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
// | $LastChangedRevision::                                             $ |
// | $HeadURL::                                                         $ |
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
function getGoogleAnaContent($client, $siteID, $query)
{
    $res = "";
    $url = "https://www.google.com/analytics/feeds/data?$query&ids=ga:$siteID"; // &prettyprint=true
    $feed = google_get_feed($client, $url);

    $res = array();

    // DEBUG
    foreach ($feed as $entry)
    {
	$arr = array();
	foreach($entry->extensionElements as $elem)
	{
	    $foo = array();
	    foreach($elem->extensionAttributes as $name => $ext)
	    {
		$foo[$name] = $ext["value"];
	    }
	    $arr[$elem->rootElement] = $foo;
	}
	$res[$entry->title->text] = $arr;

    }

    return $res;
}

function getPageViewsByCountry($client, $siteID, $start, $end)
{
    $googleQuery = "start-date=$start&end-date=$end&dimensions=ga:country&sort=ga:pageviews&metrics=ga:pageviews&max-results=1000";

    require_once('iso3166.php');

    $ret = array();

    $max = 0;
    $foo = getGoogleAnaContent($client, $siteID, $googleQuery);
    foreach($foo as $title => $arr)
    {
	$country = $arr['dimension']['value'];
	if(isset($_ISO3166["country_to_code"][strtoupper($country)]))
	{
	    $ret[$_ISO3166["country_to_code"][strtoupper($country)]] = $arr['metric']['value'];
	    $max += (int)$arr['metric']['value'];
	}
    }

    foreach($ret as $country => $val)
    {
	$val = ($val / $max) * 100;
	$ret[$country] = $val;
    }

    return $ret;
}

function getPageViewsByLatLong($client, $siteID, $start, $end)
{
    $googleQuery = "start-date=$start&end-date=$end&dimensions=ga:latitude,ga:longitude&sort=ga:pageviews&metrics=ga:pageviews&max-results=1000";

    $ret = array();

    $foo = getGoogleAnaContent($client, $siteID, $googleQuery);
    foreach($foo as $title => $arr)
    {
	$bar = explode("|", $title);
	$bar[0] = trim(substr($bar[0], strpos($bar[0], "=")+1));
	$bar[1] = trim(substr($bar[1], strpos($bar[1], "=")+1));
	$baz = array("lat" => $bar[0], "long" => $bar[1], "pageviews" => $arr["metric"]["value"]);
	$ret[] = $baz;
    }
    return $ret;
}

function makeGoogleMapXML($arr)
{
    // Start XML file, create parent node
    $xmltext = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<markers></markers>";
    $xmlobj = simplexml_load_string($xmltext);

    foreach($arr as $key => $vals)
    {
	$node = $xmlobj->addChild("marker");

	$node->addChild("lat", $vals['lat']);
	$node->addChild("lng", $vals['long']);
	$node->addChild("type", "place");
	$node->addChild("tooltip", $vals['pageviews']." views");
	$node->addChild("views", $vals['pageviews']);
    }
    
    $xmlfile = $xmlobj->asXML();
    return $xmlfile;
}

function loadGoogleMapXML($file)
{
    $s = simplexml_load_file($file);
    $arr = array();
    foreach($s->marker as $marker)
    {
	$foo = array("lat" => $marker->lat, "long" => $marker->lng, "type" => $marker->type, "tooltip" => $marker->tooltip, "views" => $marker->views);
	$arr[] = $foo;
    }
    return $arr;
}

function google_intensitymap($div_name, $values, $xlabel, $ylabel)
{
    $s = "<script type='text/javascript' src='http://www.google.com/jsapi'></script>\n";
    $s .= "<script type='text/javascript'>\n";
    $s .= "google.load('visualization', '1', {packages:['intensitymap']});\n";
    $s .= "google.setOnLoadCallback(drawChart);\n";
    $s .= "function drawChart() {\n";
    $s .= "var data = new google.visualization.DataTable();\n";
    $s .= "data.addColumn('string', '', '".$xlabel."');\n";
    $s .= "data.addColumn('number', '".$ylabel."', 'a');\n";
    $s .= "data.addRows(".count($values).");\n";
    foreach($values as $label => $val)
    {
        $s .= "data.setValue(0, 0, '".$label."');\n";
        $s .= "data.setValue(0, 1, ".$val.");\n";
    }

    $s .= "var chart = new google.visualization.IntensityMap(document.getElementById('".$div_name."'));\n";
    $s .= "chart.draw(data, {});\n";
    $s .= "}\n";
    $s .= "</script>\n";
    return $s;
}

?>
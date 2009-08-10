<?php
// web_analytics.php
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

$start = "2009-07-01";
$end = "2009-07-30";

require_once('config/config.php');
require_once('inc/common.php');
require_once('/srv/www/APIkeys.php');
require_once('inc/google_analytics.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Google Analytics</title>
<link rel="stylesheet" type="text/css" href="css/common.css" />
<link rel="stylesheet" type="text/css" href="css/nav.css" />
<?php

require_once('inc/google_data.php');
$client = null;
$auth_result = google_auth_start($CREDENTIAL_google_webmaster_user, $CREDENTIAL_google_webmaster_pass, "analytics", $client);
if($auth_result != "success"){ echo $auth_result; printFooter(); die(); }
googleana_update_sites($client, $CREDENTIAL_google_webmaster_user);
$sites = googleana_list_sites();
$first_site_id = "";
foreach($sites as $name => $id)
{
    if($first_site_id==""){ $first_site_id = $id;}
}

require_once('googlemaps/GoogleMapAPI.class.php');
$map = new GoogleMapAPI('map');
$map->disableSidebar();
$map->setHeight('500px');
$map->setWidth('800px');
$map->setAPIKey($APIKEY_google_maps);
$map->printHeaderJS();

// check map XML, if it's old then redo it
if(! file_exists('visitormap.xml') || filemtime('visitormap.xml') < (time() - 3600))
{
    $fh = fopen('visitormap.xml', "w");
    $foo = getPageViewsByLatLong($client, $first_site_id, $start, $end);
    fwrite($fh, makeGoogleMapXML($foo));
    fclose($fh);
}

$foo = loadGoogleMapXML('visitormap.xml');

// create some map markers
foreach($foo as $arr)
{
    $map->addMarkerByCoords($arr['long'],$arr['lat'], $tooltip = $arr['tooltip']);
    if($arr['views'] <= 5)
    {
	$map->addMarkerIcon($iconImage = 'http://xmlfinal.jasonantman.com/img/largeTDBlueIcons/marker'.$arr['views'].'.png', $iconShadowImage = '', $iconAnchorX = 10, $iconAnchorY = 34);
    }
    elseif($arr['views'] <=12)
    {
	$map->addMarkerIcon($iconImage = 'http://xmlfinal.jasonantman.com/img/largeTDGreenIcons/marker'.$arr['views'].'.png', $iconShadowImage = '', $iconAnchorX = 10, $iconAnchorY = 34);
    }
    elseif($arr['views'] <= 20)
    {
	$map->addMarkerIcon($iconImage = 'http://xmlfinal.jasonantman.com/img/largeTDYellowIcons/marker'.$arr['views'].'.png', $iconShadowImage = '', $iconAnchorX = 10, $iconAnchorY = 34);
    }
    else
    {
	$map->addMarkerIcon($iconImage = 'http://xmlfinal.jasonantman.com/img/largeTDRedIcons/marker'.$arr['views'].'.png', $iconShadowImage = '', $iconAnchorX = 10, $iconAnchorY = 34);
    }
}

$map->printMapJS();

$countryVals = getPageViewsByCountry($client, $first_site_id, $start, $end);
echo google_intensitymap("analytics2", $countryVals, "Country", "Page Views");

?>
</head>

<body onload="onLoad()">
<?php printHeader(); ?>

<div id="content">

<h2>Analytics</h2>

<div id="analyticsContainer">
<h3>Page Views by location, last 30 days - JasonAntman.com</h3>
<?php

/*
echo '<pre>';

$googleQuery = "start-date=$start&end-date=$end&dimensions=ga:source,ga:medium&metrics=ga:visits&sort=-ga:visits&max-results=500";
$googleQuery = "start-date=$start&end-date=$end&dimensions=ga:latitude,ga:longitude&sort=ga:pageviews&metrics=ga:pageviews&max-results=1000";
getGoogleAnaContent($client, $first_site_id, $googleQuery);
echo '</pre>';
*/


/* possible dimensions:
ga:browser
city
connectionSpeed
countOfVisits
date
daysSinceLastVisit
kour
language
latitude,longitude
operatingSystem
screenResolution
visitorType
*/


$map->printMap();


echo '<p><strong>Key:</strong> <img src="http://xmlfinal.jasonantman.com/img/largeTDBlueIcons/blank.png" width="20" height="34" /> Blue - 1-5 views. <img src="http://xmlfinal.jasonantman.com/img/largeTDGreenIcons/blank.png" width="20" height="34" /> Green - 6-12 views. <img src="http://xmlfinal.jasonantman.com/img/largeTDYellowIcons/blank.png" width="20" height="34" /> Yellow - 13-20 views. <img src="http://xmlfinal.jasonantman.com/img/largeTDRedIcons/blank.png" width="20" height="34" /> Red - 21+ views.</p>';
echo '<p><em>Description: This page pulls data from the <a href="http://code.google.com/apis/analytics/">Google Analytics</a> raw data XML API on load (at most once per hour) and dumps the necessary data into an XML file. At each load, it parses the XML and uses Monte Ohrt\'s <a href="http://www.phpinsider.com/php/code/GoogleMapAPI/">PHP GoogleMapAPI</a> to generate a Google Map.</em> <strong>Note: tooltips are used.</strong></p>';
?>

</div> <!-- END analyticsContainer DIV -->

<h3>Percent of Total Page Views by Country, last 30 days - JasonAntman.com</h3>
<div id="analytics2">

<?php
//echo '<pre>';
//$foo = getPageViewsByCountry($client, $first_site_id, $start, $end);
//echo var_dump($foo);
//echo '</pre>';
?>

</div> <!-- END analytics2 DIV -->

<p><em>Description: This pulls data from the <a href="http://code.google.com/apis/analytics/">Google Analytics</a> raw data XML API and charts it using the <a href="http://code.google.com/apis/visualization/documentation/gallery/intensitymap.html">Intensity Map</a> visualization. Unfortunately, the intensity scale is quite difficult to notice - in this particular set, the US has 606 hits and the UK, Germany, and a number of other countries have 90+ hits, though only the US stands out in the map.</em></p>

</div>

<?php printFooter(); ?>
</body>

</html>

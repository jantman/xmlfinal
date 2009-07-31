<?php
// inc/google_webmaster.php
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


/**
 * Return an array of the names of the sites in a webmaster tools account, along with the other information on them.
 * @param Zend_Http_Client $client an established authenticated connection to Google.
 * @return array
 */
function googlewebm_list_sites(&$client)
{
    $feed = google_get_feed($client, 'https://www.google.com/webmasters/tools/feeds/sites/');

    $res = array();

    foreach ($feed as $entry)
    {
	$arr = array();
	$arr['id'] = $entry->id;
	foreach($entry->extensionElements as $elem)
	{
	    $arr[$elem->rootElement] = (string)$elem;
	}
	$res[$entry->title->text] = $arr;
    }
    return $res;
}


/** 
 * Get the details of crawl issues as an array
 * @param Zend_Http_Client $client an established authenticated connection to Google.
 * @param string $siteID the site ID/URL
 * @param string $feedType the typs of feed to get (sitemaps|messages|crawlissues)
 * @return string
 */
function googlewebm_site_details(&$client, $site, $feedType = "sitemaps")
{
    if($feedType == "sitemaps"){ $url = "https://www.google.com/webmasters/tools/feeds/".urlencode($site)."/sitemaps/";}
    elseif($feedType == "messages") { $url = "https://www.google.com/webmasters/tools/feeds/messages/";}
    else { $url = "https://www.google.com/webmasters/tools/feeds/".urlencode($site)."/crawlissues/";}

    $feed = google_get_feed($client, $url);

    $res = array();

    foreach ($feed as $entry)
    {
	$arr = array();
	$arr['type'] = $entry->title->text;
	foreach($entry->extensionElements as $elem)
	{
	    $arr[$elem->rootElement] = (string)$elem;
	}
	$res[] = $arr;
    }

    return $res;
}

?>
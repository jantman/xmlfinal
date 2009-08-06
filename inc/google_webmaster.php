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

function googlewebm_show_details($id)
{
    $s = "";
    $s .= '<p><strong><a href="'.$id.'">'.$id.'</a></strong>&nbsp;&nbsp;&nbsp;&nbsp;<a href="nagios.php?filter=host&host=WEB1">nagios for host</a></p>';

    require_once('inc/google_data.php');
    $client = null;
    $auth_result = google_auth_start($CREDENTIAL_google_webmaster_user, $CREDENTIAL_google_webmaster_pass, "sitemaps", $client);
    if($auth_result != "success"){ $s .= $auth_result; printFooter(); }
    
// sitemaps
    $foo = googlewebm_site_details($client, $id, "sitemaps");
    
    $s .= '<h3>Sitemaps</h3>';
    
    $s .= '<table class="mainTable">'."\n";
    $s .= '<tr><th>URL</th><th>Type</th><th>Status</th><th>Last Downloaded</th><th>URL Count</th></tr>'."\n";
    if(count($foo) == 0)
    {
	$s .= '<tr><td colspan="5" style="text-align: center; font-style: italic;"><span>None.</span></td></tr>'."\n";
    }
    else
    {
	foreach($foo as $key => $arr)
	{
	    $s .= '<tr>';
	    $s .= '<td><a href="'.$arr['type'].'">'.$arr['type'].'</a></td>';
	    $s .= '<td>'.$arr['sitemap-type'].'</td>';
	    $s .= '<td>'.$arr['sitemap-status'].'</td>';
	    $s .= '<td>'.$arr['sitemap-last-downloaded'].'</td>';
	    $s .= '<td>'.$arr['sitemap-url-count'].'</td>';
	    $s .= '</tr>'."\n";
	}
    }
    $s .= '</table>'."\n";
    
// messages
    $s .= '<h3>Messages</h3>';
    $foo = googlewebm_site_details($client, $id, "messages");
    if(count($foo) == 0)
    {
	$s .= '<p style="font-style: italic;">None.</p>'."\n";
    }
    else
    {
	$s .= "<p>=========================\n";
	$s .= var_dump($foo);
	$s .= "=========================</p>\n";
    }
    
// crawl issues
    $foo = googlewebm_site_details($client, $id, "crawlissues");
    $s .= '<h3>Crawl Issues</h3>';
    
    $s .= '<table class="mainTable">'."\n";
    $s .= '<tr><th>Crawl Type</th><th>Issue Type</th><th>URL</th><th>Date Detected</th><th>Detail</th></tr>'."\n";
    if(count($foo) == 0)
    {
	$s .= '<tr><td colspan="5" style="text-align: center; font-style: italic;"><span>None.</span></td></tr>'."\n";
    }
    else
    {
	foreach($foo as $key => $arr)
	{
	    $s .= '<tr>';
	    $s .= '<td>'.$arr['crawl-type'].'</td>';
	    $s .= '<td>'.$arr['issue-type'].'</td>';
	    $s .= '<td><a href="'.$arr['url'].'">'.$arr['url'].'</a></td>';
	    $s .= '<td>'.$arr['date-detected'].'</td>';
	    $s .= '<td>'.$arr['detail'].'</td>';
	    $s .= '</tr>'."\n";
	}
    }
    $s .= '</table>'."\n";
    return $s;
}

?>
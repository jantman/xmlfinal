<?php
// inc/google_data.php
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
 * Return a list of the names of the sites in a webmaster tools account, along with the side IDs.
 * @param Zend_Http_Client $client an established authenticated connection to Google.
 * @return array
 */
function googlewebm_list_sites($client)
{
    $gdata = new Zend_Gdata($client);
    $query = new Zend_Gdata_Query('https://www.google.com/webmasters/tools/feeds/sites/');
    $query->setMaxResults(0);
    $feed = $gdata->getFeed($query);

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


?>
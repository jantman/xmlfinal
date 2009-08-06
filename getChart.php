<?php
// getChart.php
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

require_once('config/config.php');
require_once('inc/common.php');
require_once('googlevis/config.inc.php');

if(isset($_GET['page'])) { $page = $_GET['page']; }
if(isset($_GET['type'])) { $type = $_GET['type']; }
if(isset($_GET['view'])) { $view = $_GET['view']; }

if($page == "spam")
{
    require_once("inc/spam_graphs.php");

    if($type == "percent")
    {
	echo spam_percentSpamGraph();
    }
    elseif($type == "hour")
    {
	echo spam_byHour();
    }
    elseif($type == "day")
    {
	echo spam_byDay();
    }
    else
    {
	graphError();
    }

}
else
{
    graphError();
}

function graphError()
{
    echo '<div class="errorDiv">ERROR: I\'m sorry, but it appears that this graph type is not defined or is not yet implemented.</div>'."\n";
}

?>
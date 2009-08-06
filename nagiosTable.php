<?php
// nagiosTable.php
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
// | $LastChangedRevision:: 8                                           $ |
// | $HeadURL:: http://svn.jasonantman.com/xmlfinal/nagios.php          $ |
// +----------------------------------------------------------------------+
$SVN_rev = "\$LastChangedRevision: 8 $";
$SVN_headURL = "\$HeadURL: http://svn.jasonantman.com/xmlfinal/nagios.php $";

require_once('config/config.php');
require_once('inc/common.php');

if(isset($_GET['filter'])){ $filter = $_GET['filter'];}
if(isset($_GET['host'])){ $host = $_GET['host'];}

require_once('inc/parseNagiosXML.php');

echo getProgramInfo();
echo getTableHeader();
if(! isset($filter))
{
    echo getStatusTRs(true);
}
elseif($filter == "all")
{
    echo getStatusTRs(false);
}
elseif($filter == "host")
{
    echo getHostTRs($host);
}
echo getTableFooter();

?>
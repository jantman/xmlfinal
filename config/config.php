<?php
// config/config.php
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


$config_long_date_format = "Y-m-d H:i:s";
$config_header_date_format = "Y-m-d";

$config_bind_db_host = "";
$config_bind_db_user = "";
$config_bind_db_pass = "";
$config_bind_db_name = "bind_stats";

$config_spam_db_host = "";
$config_spam_db_user = "";
$config_spam_db_pass = "";
$config_spam_db_name = "spam_data";

$config_googleana_cache_db_host = "";
$config_googleana_cache_db_user = "";
$config_googleana_cache_db_pass = "";
$config_googleana_cache_db_name = "site";
$config_googleana_cache_table = "googleana_sites";
$config_googleana_cache_ttl = 86400;

$config_nagios_xml_path = "http://mon1.jasonantman.com/scripts/statusXML.php";
$config_nagios_host = "MON1";

?>
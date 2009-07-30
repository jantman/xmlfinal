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

require_once('/srv/www/APIkeys.php');
require_once('Zend/Gdata.php');
require_once('Zend/Gdata/ClientLogin.php');
require_once('Zend/Gdata/App/CaptchaRequiredException.php');
require_once('Zend/Gdata/App/AuthException.php');


/**
 * Authenticate to google. Returns "success" or an error message to be shown to the user on failure.
 * @param string $user 
 * @param string $pass
 * @param Zend_Http_Client $client
 * @return string
 */
function google_auth_start($user, $password, &$client)
{
    try
    {
	if(isset($_POST['GDA_captcha']))
	{
	    $client = Zend_Gdata_ClientLogin::getHttpClient($user, $password, 'sitemaps', null, 'Zend-ZendFramework', $_POST['GDA_captcha'], $_POST['GDA_captcha_answer']);
	}
	else
	{
	    $client = Zend_Gdata_ClientLogin::getHttpClient($user, $password, 'sitemaps');
	}
    }
    catch (Zend_Gdata_App_CaptchaRequiredException $cre)
	{
	    $str = '<div class="errorDiv">'."\n";
	    $str .= '<form name="GDA_captcha" method="POST">'."\n";
	    $str .= "<strong><p>Google has demanded that a CAPTCHA be submitted.</strong></p>\n";
	    $str .= '<img src="'.$cre->getCaptchaUrl().'" /><br />'."\n";
	    $str .= '<label for="GDA_captcha_answer">Please enter the string in the above image: </label><input type="text" size="10" name="GDA_captcha_answer" id="GDA_captcha_answer" />'."\n";
	    $str .= '<input type="hidden" name="GDA_captcha" value="'.$cre->getCaptchaToken().'" >'."\n";
	    $str .= '<input type="submit" value="submit" />'."\n";
	    $str .= '</form>'."\n";
	    $str .= '</div>'."\n";
	    return $str;
	}
    catch (Zend_Gdata_App_AuthException $ae)
	{
	    echo '<div class="errorDiv">Problem authenticating: ' . $ae->getMessage() . "</div>\n";
	    die(); // TODO - this should just return, and handle the error in the calling function
	}
    return "success";
}

?>
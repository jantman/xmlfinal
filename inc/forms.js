// forms.js
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

var http = createRequestObject(); 
var spamtype = "percent";

function updateHostDiv()
{
  var filter = document.getElementById("filter").value;
  if(filter == "host")
    {
      document.getElementById("hostDiv").style.display = 'block';
    }
  else
    {
      document.getElementById("hostDiv").style.display = 'none';
    }
}

function updateWebmaster()
{
  var site = document.getElementById("site").value;
  webmasterLoading();
  doHTTPrequest('webmasterTools.php?site=' + site, handleUpdateWebmaster);  
}

function nagiosLoading()
{
  var foo = '<div style="text-align: center; background-color: #D8D8D8;"><h2>&nbsp;<br />Loading...</h2> <img src="bigrotation2.gif" width="32" height="32" alt="animation" /><h2>&nbsp;</h2></div>';
  document.getElementById('nagiosContainer').innerHTML = foo;
}

function webmasterLoading()
{
  var foo = '<div style="text-align: center; background-color: #D8D8D8;"><h2>&nbsp;<br />Loading...</h2> <img src="bigrotation2.gif" width="32" height="32" alt="animation" /><h2>&nbsp;</h2></div>';
  document.getElementById('webmasterTools').innerHTML = foo;
}

function spamLoading()
{
  var foo = '<div style="text-align: center; background-color: #D8D8D8;"><h2>&nbsp;<br />Loading...</h2> <img src="bigrotation2.gif" width="32" height="32" alt="animation" /><h2>&nbsp;</h2></div>';
  document.getElementById('graphPageContainer').innerHTML = foo;
}

function updateNagios()
{
  var filter = document.getElementById("filter").value;
  var host = document.getElementById("host").value;
  if(filter == "host")
    {
      nagiosLoading();
      doHTTPrequest('nagiosTable.php?filter=host&host=' + escape(host), handleUpdateNagios);
    }
  else if(filter == "all")
    {
      nagiosLoading();
      doHTTPrequest('nagiosTable.php?filter=all', handleUpdateNagios);
    }
  else
    {
      nagiosLoading();
      doHTTPrequest('nagiosTable.php', handleUpdateNagios);
    }
}

function resetNagios()
{
  document.getElementById("filter").selectedIndex = 0;
  document.getElementById("hostDiv").style.display = 'none';
  nagiosLoading();
  doHTTPrequest('nagiosTable.php', handleUpdateNagios);
}

function spamUpdate()
{
  // TODO: had to comment most of this out, DHTML wasn't working
  var foo = document.getElementById("type").value;
  //spamLoading();
  if(foo == "percent")
    {
      spamtype = "percent";
      //doHTTPrequest('getChart.php?page=spam&type=percent', handleUpdateGraphs);
      window.location = "logs_spam.php?type=percent";
    }
  else if(foo == "hour")
    {
      spamtype = "hour";
      //doHTTPrequest('getChart.php?page=spam&type=hour', handleUpdateGraphs);
      window.location = "logs_spam.php?type=hour";
    }
  else
    {
      spamtype = "day";
      //doHTTPrequest('getChart.php?page=spam&type=day', handleUpdateGraphs);
      window.location = "logs_spam.php?type=day";
    }
}

function handleUpdateGraphs()
{
  if(http.readyState == 4)
  {
    var response = http.responseText;
    if(spamtype == "percent")
      {
	document.getElementById('graphPageContainer').innerHTML = '<div id="annotatedtimeline" style="width:740px;height:240px;"></div>';
      }
    else
      {
	document.getElementById('graphPageContainer').innerHTML = '<div id="linechart"></div>';
      }
    eval(response);
  }
}

function handleUpdateNagios()
{
  if(http.readyState == 4)
  {
    var response = http.responseText;
    document.getElementById('nagiosContainer').innerHTML = response;
  }
}

function handleUpdateWebmaster()
{
  if(http.readyState == 4)
  {
    var response = http.responseText;
    document.getElementById('webmasterTools').innerHTML = response;
  }
}

//
// UTILITY FUNCTIONS
//

function createRequestObject()
{
	var request_o;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer")
	{
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
		request_o = new XMLHttpRequest();
	}
	return request_o;
}

function doHTTPrequest($url, $handler)
{
  // TODO - get this working with older Firefox, using abort()
  http.open('get', $url);
  http.onreadystatechange = $handler;
  http.send(null);
}

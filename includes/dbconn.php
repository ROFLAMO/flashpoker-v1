<?php
define("DEFAULT_PAGE", "index.php");

if (($_SERVER['HTTP_HOST']=='127.0.0.1') || (strtolower($_SERVER['HTTP_HOST'])=='localhost') || (strtolower($_SERVER['HTTP_HOST'])=='192.168.1.208'))
{
	
	/*define('DB_ADDRESS',"127.0.0.1");
	define('DB_NAME',"flashpoker");
	define('DB_USER',"root");
	define('DB_PASS',"");*/
	require "remotedbconn.php";
	
	//Timeout di disconnessione in secondi.
	define("PKR_PLAYING_TIMEOUT",25); //-->AWAYOUT
	define("PKR_AWAY_TIMEOUT", 25); //-->0 default 25
	define("PKR_GENERIC_TIMEOUT",25); //-->60 default
	define("PKR_STALL_TIMEOUT",25);
	
	define("SECURITY", false);
	define("PKR_TIMER", 1);
}
else
{	
	/*	
	define('DB_ADDRESS',"localhost");
	define('DB_NAME',"flashpoker");
	define('DB_USER',"root");
	define('DB_PASS',"webdir");
	*/
	require "remotedbconn.php";
	
	//Timeout di disconnessione in secondi.
	define("PKR_PLAYING_TIMEOUT",25); //-->AWAYOUT
	define("PKR_AWAY_TIMEOUT",25); //-->0 default 25
	define("PKR_GENERIC_TIMEOUT",25); //-->60 default
	define("PKR_STALL_TIMEOUT",25);
	
	define("SECURITY", true);
	define("PKR_TIMER", 1);
}


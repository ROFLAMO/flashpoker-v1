<?php
//Enable more player with same IP on same table
$__ip_allowed = array("127.0.0.1");
$__myip = $_SERVER["REMOTE_ADDR"];
if (in_array($__myip,$__ip_allowed))
	define('IP_ALLOWED',true);
else
	define('IP_ALLOWED',false);
?>
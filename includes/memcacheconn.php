<?php
require "remotememcacheconn.php";

if ($_SESSION['memcache'] == 'justFalseChecked') 
	$usememcache = false;
else {
	$usememcache = false;
	if (class_exists('Memcache')) {
		$GLOBALS['memcache'] = new Memcache;
		if (@$GLOBALS['memcache']->connect(MEMCACHE_HOST, MEMCACHE_PORT)) {
			$usememcache = true;
		}
		else
			$_SESSION['memcache'] = 'justFalseChecked';
	}	
}
define("USE_MEMCACHE",$usememcache);
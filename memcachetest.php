<?php
$host = ($_GET['host']!="") ? $_GET['host'] : '127.0.0.1';
$port = ($_GET['port']!="") ? $_GET['port'] : 11211;

echo "check memcache in $host:$port";
echo "<br>";
$memcache = new Memcache;
$memcache->connect($host, $port) or die ("Could not connect to ".$host.":".$port);

$version = $memcache->getVersion();
echo "Server's version: ".$version."<br/>\n";

$tmp_object = new stdClass;
$tmp_object->str_attr = 'test';
$tmp_object->int_attr = 123;

$memcache->set('key', $tmp_object, false, 10) or die ("Failed to save data at the server");
echo "Store data in the cache (data will expire in 10 seconds)<br/>\n";

$get_result = $memcache->get('key');
echo "Data from the cache:<br/>\n";

var_dump($get_result);
?>
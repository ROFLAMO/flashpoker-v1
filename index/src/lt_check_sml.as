var DEBUG:Boolean = false;
var CHECK_URL:String = "http://194.116.82.22/flashpoker/index/list_tables_sml.swf";
var LOCAL_URL:String = "http://127.0.0.1/poker/index/list_tables_sml.swf";
if (_url == "file:///C|/wamp/www/poker/index/list%5Ftables%5Fsml.swf") {
	DEBUG = true;
	var master_url:String = 'http://127.0.0.1/poker/index/index.php';
} else {
	var master_url:String = _level0._myurl;
}
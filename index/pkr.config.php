<?php
error_reporting(E_ALL ^ E_NOTICE);

//#################################################################
//# DON'T MOVE OR CHANGE
//#################################################################
// Money Symbol
define("PKR_CURRENCY_SYMBOL",'$');

//Define type hand
//Common hands
define("CHECK_SITTING","check_sitting");
define("POSTBLINDS","postblinds");
define("HOLECARDS","holecards");

//HOLDEM HANDS
define("PREFLOP","preflop");
define("BURNING_AND_FLOP","burningandflop");
define("FLOP","flop");
define("BURNING_AND_TURN","burningandturn");
define("TURN","turn");
define("BURNING_AND_RIVER","burningandriver");
define("RIVER","river");

//5CARD DRAW HANDS
define("FIRSTROUND","firstround");
define("ENDROUND","endround");
define("DRAW","draw");
define("SECONDROUND","secondround");

//Common hands
define("SHOWDOWN","showdown");
define("ELABORATE","elaborate");
define("SHOWWIN","showwin");
define("SHOWWIN_FOLD","showwin_fold");
define("CREATE_NEW_GAME","createnewgame");

//HOLDEM SUBHAND
//Define type subhand
define("POSTSB","postsb");
define("POSTBB","postbb");
define("BET","bet");
define("FOLD","fold");
define("CHECK","check");
define("CALL","call");
define("RAISE","raise");
define("SITOUT","sitout");
define("WINS","wins");
define("CHANGE","change");

//Remin Sit but not play
define("SITTINGOUT","sittingout");
define("LEAVESEAT","leaveseat");
//#################################################################
//# DON'T MOVE OR CHANGE
//#################################################################


date_default_timezone_set("Europe/Rome");

// REMOTE SEND MAIL (using if your server doesn't have local SMTP for PHP mail function)
define("USE_REMOTE_SENDMAIL", false);
define("URL_SENDMAIL", "http://www.flashpoker.pl/sendmail.php");

header('Content-type: text/html; charset=iso-8859-2');

/**
* dbconn.php set url, timeout and security constants
* @link ../includes/dbconn.php
*/
require("../includes/dbconn.php");

/**
* memcacheconn.php set memcache connection
* @link ../includes/memcacheconn.php
*/
require("../includes/memcacheconn.php");

/**
* accessconfig.php set access admin configuration
* @link ../includes/accessconfig.php
*/
require("../includes/accessconfig.php");

define("PKR_DOLOG",true);
define("PKR_LOG_DEBUG","DEBUG");

if ((($_SERVER['HTTP_HOST']=='127.0.0.1') || (strtolower($_SERVER['HTTP_HOST'])=='localhost')) && ($_REQUEST['debug']=="1")) 
	define('DEBUG',true);
else {
	if ($_GET['debug']=='qwerty')
		define('DEBUG',true);
	else
		define('DEBUG',false);
}

// protocol xml/json
define("CORE_PROTOCOL",'json');

//Enter in all table contemporary
define("ALL_TABLE_PLAYING_ALLOWED", false);

//const mails to CHANGE !!
define('CONST_ADMIN_MAIL',"admin@flashpoker.pl");
define('CONST_SITE_MAIL',"info@flashpoker.pl");
define('CONST_BUG_MAIL',"bug@flashpoker.pl");
define("PAYPAL_ACCOUNT","billing@flashpoker.pl");

define("PKR_ADMIN","pkr_admin");
	define("PKR_MAIN_MENU","pkr_mainmenu");
	define("PKR_MANAGE_PLAYERS","pkr_manage_plrs");
	define("PKR_MANAGE_TABLES","pkr_manage_tbls");
	define("PKR_MANAGE_ROOMS","pkr_manage_rooms");
	define("PKR_DEL_TABLE","pkr_del_tbl");
	define("PKR_DEL_ROOM","pkr_del_room");	
	define("PKR_MOD_PLAYER","pkr_mod_plr");
	define("PKR_DEL_PLAYER","pkr_del_plr");
	define("PKR_DEL_NOT_CONFIRMED_PLAYERS","pkr_del_not_confirmed_players");
	define("PKR_INIT_ALL","pkr_init_all");
	define("PKR_RESET_ALL","pkr_reset_all");
	define("PKR_NEWSLETTER","pkr_newsletter");
		define("PKR_PREPARE_NEWSLETTER","pkr_prepare_newsletter");	
		define("PKR_SEND_NEWSLETTER","pkr_send_newsletter");	
		define("PKR_MOD","pkr_mod");
	define("PKR_SHOW_LOGS","pkr_show_logs");
		define("PKR_VIEW_LOG","pkr_view_log");
		define("PKR_DEL_LOG","pkr_del_log");
	define("PKR_CROPGAME","pkr_crop");
		
// Do shuffle to last deal !
define("PKR_GET_LAST_DEAL", true);
define("PKR_DEFAUL_GET_CREDIT",1000);
define("PKR_STAKESPLAY_COEFF",100);
define("MSG_FOR_SYSTEM",0);
define("MSG_FOR_CHAT",1);
//MIN char to register usr e pswd and mail
define("MIN_REGISTATION_CHAR",5);
// Ranking elements page
define('ELEMENTS_PAGE',20);

// Core engine timer
define("GAME_CLOCK",3);

// Time to delete account 30 days
define("PKR_TIME_TO_DELETE_ACCOUNT",30);

// Type of games (dont modify!)
define("HOLDEM", 'holdem');
define("FIVECARD", 'fivecard');

// Active file caching for velocity constant or database_only
// if true insert dir data with write attribute
define('PKR_DATA_FILE','../data/');
define('SITE_NAME',"poker.j3j.org");
define('SERVER_NAME',"http://poker.j3j.org");
define('CONST_PUBIC_PATH',"../public/");
define('CONST_IMAGE_PATH',"../public/imgs/");
define('BACKGROUND_IMAGE',"../images/bkg.gif");
define('PKR_SITE_TITLE',"poker.j3j.org - Poker OnLine Free Texas Holdem");
define('CONST_LOG_PATH',"../log/");

//SITE CONSTS
define("PKR_CONFIRM","confirm");
define("PKR_WWW","pkr_www");
	define("PKR_HOME","pkr_home");
	define("PKR_USR_PROFILE","pkr_usr_profile");
	define("PKR_USRS_PROFILE","pkr_usrs_profile");
	define("PKR_LOGIN","pkr_login");
	define("PKR_2LOGIN","pkr_2login");
	define("PKR_3LOGIN","pkr_3login");	
	define("PKR_REGISTER","pkr_register");
	define("PKR_2REGISTER","pkr_2register");
	define("PKR_TABLE","pkr_table");
	define("PKR_VIEWRANKING","pkr_viewranking");
	define("PKR_SND_MAIL_PSWD","pkr_snd_mail_pswd");
	define("PKR_CHANGE_PSWD","pkr_change_pswd");
	define("PKR_SET_NEW_PSWD","pkr_set_new_pswd");
	define("PKR_VIEWYOURSITEPOKER","pkr_viewyoursitepoker");
	define("PKR_VIEWBUY","pkr_viewbuy");
	
//EXTERNA SITE CONSTS
define("PKR_EXT_WWW","pkr_ext_www");
	define("PKR_PUBLIC_EXT_HOME","pkr_public_ext_home");
	define("PKR_EXT_USR_PROFILE","pkr_ext_usr_profile");
	define("PKR_EXT_LOGIN","pkr_ext_login");
	define("PKR_EXT_2LOGIN","pkr_ext_2login");
	define("PKR_EXT_3LOGIN","pkr_ext_3login");
		
	
//COSTANTS RUN
define("PKR_REQDATAPLR","reqdataplr");
define("PKR_REQCREDIT","reqcredit");
define("PKR_REQDATATABLE","reqdatatable");
define("PKR_REQSEATOPEN","reqseatopen");
define("PKR_RESPACTION","respaction");
define("PKR_RESPCHATMSG","respchatmsg");
define("PKR_REQTABLEPROPERTIES","reqtableproperties");
define("PKR_REQTABLES","reqtables");
define("PKR_REQSITTINGORIDLE","reqsittingoridle");
define("PKR_REQLEAVESEAT","reqleaveseat");
define("PKR_SETSERVER","pkr_setserver");
define("PKR_VIEWRULES",'pkr_viewrules');
define("PKR_VIEWGAMEHISTORY","pkr_viewgamehistory");
define("PKR_REQPLRCREDIT","pkr_reqplrcredit");
define("PKR_SETPLRTBLCREDIT","pkr_setplrtblcredit");
define("PKR_GETDATALANGUAGES","pkr_getdatalang");

//Bot
define("PKR_REQDATABOT","reqdatabot");

// create tbl
define("PKR_CREATETBL","pkr_createtbl");
define("PKR_CREATEROOM","pkr_createroom");

//special stat
define("CONTINUEHAND","continue");
define("PKR_ENDGAME","end");

//Define del tipo di uso dei dati da visualizzare
define('INSERT',"insert");
define('VIEW',"view");
define('UPDATE',"update");

//Error Codes
define('ERROR_TO_COPY_FILE',"1,Errore generico nella copia del File");
define('ERROR_SIZE_FILE',"2,Errore: il file è ha un size troppo elevato");
define('ERROR_TO_DEL_FILE_DB',"3,Errore nella cancellazione del file da db");
define('ERROR_TO_DEL_FILE',"4,Errore nella cancellazione del file da filesystem (probabilmente sono assenti i permessi di scrittura)");
define('ERROR_TO_SEND_MAIL',"5,Errore nell'invio mail ! Controlla i parametri di amministrazione !");
define('ERROR_TO_USER_PASSWD',"6,Errore userid e/o password di amministrazione");

//PLAYER
//Player Status
DEFINE("SITTINGIDLE",1);
DEFINE("PLAYING",2);
DEFINE("AWAY",3);
DEFINE("AWAYOUT",4);
DEFINE("SITTING",5);

//Const max cards
DEFINE("MAXNCARDS",5);

//POST
//Define type type_post
define("FIRST",1);
define("SECOND",2);
define("THIRT",3);
define("FOUR",4);
define("FIVE",5);

//DEALER AND CARDS
//Define part of board
define("BOARD",0);
define("BURNING_SEAT",11);
define("BOARD_PLAYER",0);

//CARD RANKS TO TRANSLATE !!
define("PKR_ROYALFLUSH","pokerkrólewski__");
define("PKR_STRAIGHTFLUSH","poker__");
define("PKR_FOUROFAKIND","kareta__");
define("PKR_FULLHOUSE","ful__");
define("PKR_FLUSH","kolor__");
define("PKR_STRAIGHT","strit__");
define("PKR_THREEOFAKIND","trójka__");
define("PKR_TWOPAIR","dwiepary__");
define("PKR_PAIR","para__");
define("PKR_HIGHCARD","wysokakarta__");

//PKR PLAYER
$arr_pkr_player_tbl["usr"] = 10;
$arr_pkr_player_tbl["pswd"] = 20;
$arr_pkr_player_tbl["mail"] = 255;
$arr_pkr_player_tbl["city"] = 50;

//DATA PKR_PLAYER MOD (don't modify!)
$plr_view = array("idplayer","usr" ,"city","mail","virtual_money","n_credit_update","ptg","confirmed","supporter","bonus","isbot");
$plr_type = array("num"		,"text","text","num" ,"num"			 ,"num"			   ,"num","num"		 ,"num"		 ,"num"	 ,"num");
$plr_key = "idplayer";

define("FILE_DONORS",'../public/donors.txt');
define("DEF_DONOR","5€");

//NAME OF TEMPORARY TABLE FOR RANKING
define("VIEWTBL", "view_ranking");

define("MOD_UPDATE_RANKING", 7);

require "globals.php";	
require "common.php";

unset($__view_lan);
unset($__client_lan);
unset($__tbl_lan);
?>
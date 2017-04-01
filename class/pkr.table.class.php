<?php
require("../class/pkr.chatengine.class.php");

/**
 * Table Class 
 *
 * Core Table Class System
 *
 * @version 1.8 Final
 * @created Dic/08
 */
class Table extends ChatEngine 
{
	var $now;
	var $curr_session;
	var $curr_player;
	var $n_playing_plrs = 0;
	var $n_sittingidle_plrs = 0;	
	var $max_plrs = 10;
	var $curr_table;	
	var $curr_plr_server = 0;
	var $curr_seat_server = 0;	
	
	//Tbl data	
	var $sblind;
	var $bblind;
	var $limited;
	var $fast;
	var $all_in;
	var $min_tbl_credit_to_play = 0;
	var $max_tbl_credit_to_play = 0;	
	
	//Array to put V card on board
	var $arr_start_end = array();		
	var $curr_arr_plrs = array();
	var $curr_arr_plrs_seat_ordered = array();	
	var $curr_arr_all_plrs_seat_ordered = array();
	var $curr_arr_si_plrs = array();
	var $curr_arr_si_plrs_seat_ordered = array();
	
	var $rule;
	
	var $__id_allowed = array(11, 637, 63, 64, 94);
	
	public static $__lang = array();
	public static $__clang = array();
	
	static function setLangs() {
		
//TO CHANGE
self::$__clang["btn_lbl_change"] = "Change";		
	
self::$__lang["get_plr_credit_error1"] = "You are not able to play on this table because the minimun credit to play is ";
self::$__lang["get_plr_credit_error2"] = "You must update your credit";
self::$__lang["credit_update_error1"] = "Credit update error !";
self::$__lang["credit_update_error2"] = "Credit could not be update during a game";
self::$__lang["credit_update_error3"] = "Credit must be between ";
self::$__lang["msg_credit_updated"] = "#Dealer: Credit updated";
self::$__lang["msg_credit_not_updated"] = "#Dealer: Credit not updatable";
self::$__lang["plr_just_seated"] = "Sorry! You are just seat on TABLE #";
self::$__lang["plr_just_seated_this_table"] = "Sorry! You are just seat on this TABLE !";
self::$__lang["seat_occuped"] = "SEAT OCCUPED";
self::$__lang["plr_just_seated_this_table2"] = "You are just seated on this TABLE !";
self::$__lang["guest_entered"] = "...a guest is here !";
self::$__lang["plr_entered"] = "...is here !";
self::$__lang["plr_must_seat1"] = "You must be seat and idle or playing on table to sitting.";
self::$__lang["plr_must_seat2"] = "You must be seat on table to sitting.";
self::$__lang["plr_must_seat3"] = "You must be seat on table to leave seat.";
self::$__lang["plr_cannot_leave"] = "You cannot leave seat.";		

self::$__clang["currency_symbol"] = PKR_CURRENCY_SYMBOL;
self::$__clang["str_infotbl"] = "Loading..";
self::$__clang["windowfocus"] = "Window Focus";
self::$__clang["disablemusic"] = "Disable Music";
self::$__clang["disablechatsounds"] = "Disable Chat Sounds";
self::$__clang["autopostblinds"] = "Auto Post Blinds";
self::$__clang["submitButton"] = "SEND";

self::$__clang["btn_font_size"] = 8;
self::$__clang["btn_font_family"] = "arial";//"verdana";
self::$__clang["cashier"] = "CASHIER";
self::$__clang["leavetable"] = "LEAVE TABLE";
self::$__clang["sittingout_idle"] = "LEAVE GAME";
self::$__clang["btn_lbl_leaveseat"] = "LEAVE SEAT";


self::$__clang["str_idle"] = "IDLE";
self::$__clang["str_away"] = "AWAY";
self::$__clang["str_bye"] = "BYE";
self::$__clang["str_sitout"] = "SITOUT";
self::$__clang["str_empty"] = "EMPTY";
self::$__clang["str_playing"] = "PLAYING";			
self::$__clang["chat_start_label1"] = "Welcome to flashpoker.it version 1.8.4 stable.";
self::$__clang["chat_start_label2"] = "For info write to info@flashpoker.it";
self::$__clang["chat_start_label3"] = "-------------------------------------------------";
self::$__clang["chat_start_label4"] = "Donate to:";
self::$__clang["chat_start_label5"] = "svinci@virtuasport.it";
self::$__clang["btn_lbl_call_allin"] = "ALL-IN";
self::$__clang["btn_lbl_call"] = "CALL ";
self::$__clang["btn_lbl_fold"] = "FOLD";
self::$__clang["btn_lbl_postsb"] = "POSTSB";
self::$__clang["btn_lbl_postbb"] = "POSTBB";
self::$__clang["btn_lbl_sitout"] = "SITOUT";
self::$__clang["btn_lbl_check"] = "CHECK";
self::$__clang["btn_lbl_raise"] = "RAISE ";
self::$__clang["btn_lbl_bet"] = "BET ";
self::$__clang["chat_input_msg_nologged"] = "Chat disabled. You must login.";
self::$__clang["str_itsyourturn"] = " it's your turn ";
self::$__clang["str_sec"] = " sec.";
self::$__clang["str_game_c"] = "Game #";
self::$__clang["str_guest"] = "Guest";
self::$__clang["str_seat"] = "SEAT ";
self::$__clang["str_hand_burning"] = "HAND BURNING";
self::$__clang["str_hand"] = "HAND";
self::$__clang["str_pocket"] = "Pocket ";
self::$__clang["str_draw"] = "THE DRAW";
self::$__clang["your_credit_is"] = "Your credit is:";
self::$__clang["getcredit"] = "GET CREDIT";
self::$__clang["_continue"] = "CONTINUE";
self::$__clang["how_much_play"] = "HOW MUCH DO YOU WANT TO PLAY ?";
self::$__clang["_play"] = "PLAY";
self::$__clang["str_please_wait"] = "please wait";
self::$__clang["btn_seatopen"] = "SEAT OPEN";
self::$__clang["cashier_alert_text"] = "To open cashier your status must not be playable !";
self::$__clang["cashier_alert_title"]= "Info";
self::$__clang["leaveseat_alert_text"] = "Are you sure to change leave seat ?";
self::$__clang["leaveseat_alert_title"] = "Leave Seat";
self::$__clang["leavegame_alert_text"] = "Are you sure to change your game status ?";
self::$__clang["leavegame_alert_title"] = "Leave Game";
self::$__clang["leavetable_alert_text"] = "Are you sure to leave table ?";
self::$__clang["leavetable_alert_title"] = "Leave Table";
self::$__clang["alert_notenoughtmoney_text"] = "Sorry !!\nYou don't have enought money to play !\nClick on CASHIER to get credit";
self::$__clang["alert_notenoughtmoney_title"] = "Request Seat";
self::$__clang["str_requested_seat"] = " requested... please wait";
self::$__clang["FLASHERROR"] = "FlashError";
self::$__clang["CLIENTERROR"] = "ClientError";
self::$__clang["REDIRECTION"] = "Redirection";
self::$__clang["SERVERERROR"] = "ServerError";
self::$__clang["INFORMATIONAL"] = "Information";
self::$__clang["SUCCESSFUL"] = "Successful";

self::$__clang["chat_opponent_fold"] = "opponent fold";
self::$__clang["chat_dealer"] = "#Dealer";
self::$__clang["chat_wins_game_text"] = "Wins [Game #%s] %s, %s %s, %sh [%s]";
self::$__clang["chat_goaway"] = " go away";
self::$__clang["chat_wins_game"] = "Wins [Game #%s] %s, ".self::$__clang["chat_opponent_fold"];
self::$__clang["chat_wins_game_fold"] = "Wins [Game #%s] ".self::$__clang["chat_opponent_fold"];
self::$__clang["chat_returned"] = "Returned %s";
self::$__clang["chat_change_cards"] = "changes %s cards";
self::$__clang["chat_change_card"] = "changes %s card";

self::$__clang[CHECK_SITTING] = "check sitting";
self::$__clang[POSTBLINDS] = "postblinds__";
self::$__clang[HOLECARDS] = "holecards_";
self::$__clang[PREFLOP] = "preflop_";
self::$__clang[BURNING_AND_FLOP] = "burning and flop";
self::$__clang[FLOP] = "flop";
self::$__clang[BURNING_AND_TURN] = "burning and turn";
self::$__clang[TURN] = "turn";
self::$__clang[BURNING_AND_RIVER] = "burning and river";
self::$__clang[RIVER] = "river";
self::$__clang[FIRSTROUND] = "firstround";
self::$__clang[ENDROUND] = "endround";
self::$__clang[DRAW] = "draw";
self::$__clang[SECONDROUND] = "secondround";
self::$__clang[SHOWDOWN] = "showdown";
self::$__clang[ELABORATE] = "elaborate";
self::$__clang[SHOWWIN] = "showwin";
self::$__clang[SHOWWIN_FOLD] = "showwin fold";
self::$__clang[CREATE_NEW_GAME] = "create new game";
self::$__clang[POSTSB] = "postsb_";
self::$__clang[POSTBB] = "postbb";
self::$__clang[BET] = "bet";
self::$__clang[FOLD] = "fold";
self::$__clang[CHECK] = "check";
self::$__clang[CALL] = "call";
self::$__clang[RAISE] = "raise";
self::$__clang[SITOUT] = "sitout";
self::$__clang[WINS] = "wins";
self::$__clang[CHANGE] = "change";
self::$__clang[SITTINGOUT] = "sittingout";
self::$__clang[LEAVESEAT] = "leaveseat";

			
	}
	
	/**
	* Table Constructor
	* 
	* Init all variables and set all current variable reguards this table, this game and this player
	*
	* @param int $idplayer 
	* @param int $idtable 	
	*/		
	function Table($idplayer, $idtable)
	{
		//self::$__lang = $_SESSION["__tbl_lan"];
		self::setLangs();
		//self::$__clang = $_SESSION["__client_lan"];
		
		//time();
		$this->now = $_SERVER['REQUEST_TIME'];
				
		$this->curr_player = $idplayer;
		$this->curr_table = $idtable;
				
		//Check session
		$this->checkSecurity();		
		
		if ($this->curr_player>0)
			$this->alive();
		
		$_SESSION["tbl_".$this->curr_table]['is_guest'] = false;
		if ($this->curr_player == 0)
			$_SESSION["tbl_".$this->curr_table]['is_guest'] = true;
		
		$row = $this->getTableFieldsValue();
		$this->type_game = $row["type_game"];		
		$this->sblind = $row["stakes_min"];
		$this->min_tbl_credit_to_play = ($this->sblind * PKR_STAKESPLAY_COEFF);
		$this->bblind = ($row["stakes_max"]>($this->sblind*2)) ? ($this->sblind*2) : $row["stakes_max"];
		$this->max_tbl_credit_to_play = ($this->bblind * PKR_STAKESPLAY_COEFF);
		$this->limited = $row["limited"];
		$this->fast = $row["fast"];
		$this->all_in = $row["all_in"];
		$this->max_plrs = $row["max_plrs"];
		unset($row);
						
		$data_game = $this->getLastGame();
		$this->curr_game = $data_game[0]['idgame'];
		$this->curr_d = $data_game[0]['d'];
		$this->curr_endround_seat = $data_game[0]['endround_seat'];
		$this->curr_endround_nextseat = $data_game[0]['endround_nextseat'];		
		$this->curr_end = $data_game[0]['end'];
		$this->curr_all_allin = $data_game[0]['all_allin'];
		unset($data_game);
			
		$this->curr_hand = $this->getLastHand();		
		$this->curr_type_hand = $this->getTypeHand();
							
		$this->lastsubhand = $this->getLastSubHand();
		$this->curr_subhand = $this->lastsubhand[0]['idsubhand'];		
		
		$this->curr_type_subhand = $this->getTypeSubHand();		
		$this->curr_post = $this->getLastPost();		
		$this->curr_subpost = $this->getLastSubPost();	
		
		//PLAYING
		$this->curr_arr_plrs = $this->getArrPlrs();	
		$this->n_playing_plrs = count($this->curr_arr_plrs);
		$this->curr_arr_plrs_seat_ordered = $this->getArrPlrs(true,PLAYING);
							
		// ALL
		$this->curr_arr_all_plrs_seat_ordered = $this->getArrPlrs(false,PLAYING,true);
				
		//SITTINGIDLE
		$this->curr_arr_si_plrs = $this->getArrPlrs(false,SITTINGIDLE);
		$this->n_sittingidle_plrs = count($this->curr_arr_si_plrs);
		$this->curr_arr_si_plrs_seat_ordered = $this->getArrPlrs(true,SITTINGIDLE);		
					
		//SET FIRST OF ALL PLAYER PLAYING/IDLE
		//$this->curr_plr_server = $this->curr_arr_all_plrs_seat_ordered[0]['player'];
		//$this->curr_seat_server = $this->curr_arr_all_plrs_seat_ordered[0]['seat_number'];		
				
		if ($this->n_playing_plrs > 1)
		{
			// SEARCH ON PLAYING
			if //( 
				(isset($this->curr_arr_plrs_seat_ordered[$this->curr_d])) //&& ($this->curr_arr_plrs_seat_ordered[$this->curr_d]['player'] != $this->lastsubhand[0]["player"])
			    //)
 			{
				$this->curr_plr_server = $this->curr_arr_plrs_seat_ordered[$this->curr_d]['player'];
				$this->curr_seat_server = $this->curr_arr_plrs_seat_ordered[$this->curr_d]['seat_number'];
			}
			else {
				foreach ($this->curr_arr_plrs_seat_ordered as $k) {
					//if ($this->lastsubhand[0]["player"] != $k['player']) {
						$this->curr_plr_server = $k['player'];
						$this->curr_seat_server = $k['seat_number'];	
						break;
					//}
				}
			}
		}
		else
		{
			foreach ( isset($this->curr_arr_all_plrs_seat_ordered) ? $this->curr_arr_all_plrs_seat_ordered : array($this->curr_arr_all_plrs_seat_ordered)  as $k) {
				//if ($this->lastsubhand[0]["player"] != $k['player']) {
					$this->curr_plr_server = $k['player'];
					$this->curr_seat_server = $k['seat_number'];	
					break;
				//}
			}			
		}
		
		$this->type_subhands = Array
								   (
								   	CHECK => self::$__clang[CHECK],
								   	POSTSB => self::$__clang[POSTSB],
								   	POSTBB => self::$__clang[POSTBB],
								   	FOLD => self::$__clang[FOLD],
								   	CALL => self::$__clang[CALL],
								   	BET => self::$__clang[BET],
								   	CHECK => self::$__clang[CHECK],
								   	RAISE => self::$__clang[RAISE],
								   	SITOUT => self::$__clang[SITOUT],
								   	WINS => self::$__clang[WINS]		   	
									);		
		
		switch ($this->type_game) 
		{
			case HOLDEM:
			
				/*$this->type_hands = Array 
									   (
									   	CHECK_SITTING => "check_sitting",
									   	POSTBLINDS => "postblinds",
										HOLECARDS => "holecards", //2 carte a testa
										PREFLOP => "preflop", //I giro di scommesse
										BURNING_AND_FLOP => "burning and flop",						
										FLOP => "flop",
										BURNING_AND_TURN => "burning and turn",
										TURN => "turn",
										BURNING_AND_RIVER => "burning and river",
										RIVER => "river",
										ELABORATE => "elaborate",
										SHOWDOWN => "showdown",
										SHOWWIN => "showwin",
										CREATE_NEW_GAME => "createnewgame"
										);
										*/
				$this->type_hands = Array
									   (										
										CHECK_SITTING => self::$__clang[CHECK_SITTING],
									   	POSTBLINDS => self::$__clang[POSTBLINDS],
										HOLECARDS => self::$__clang[HOLECARDS], //2 carte a testa
										PREFLOP => self::$__clang[PREFLOP], //I giro di scommesse
										BURNING_AND_FLOP => self::$__clang[BURNING_AND_FLOP],						
										FLOP => self::$__clang[FLOP],
										BURNING_AND_TURN => self::$__clang[BURNING_AND_TURN],
										TURN => self::$__clang[TURN],
										BURNING_AND_RIVER => self::$__clang[BURNING_AND_RIVER],
										RIVER => self::$__clang[RIVER],
										ELABORATE => self::$__clang[ELABORATE],
										SHOWDOWN => self::$__clang[SHOWDOWN],
										SHOWWIN => self::$__clang[SHOWWIN],
										CREATE_NEW_GAME => self::$__clang[CREATE_NEW_GAME]										
										);
			
				$this->num_type_hands = Array 
										(
									   	CHECK_SITTING => 0,
									   	POSTBLINDS => 1,
										HOLECARDS => 2, //2 carte a testa
										PREFLOP => 3, //I giro di scommesse
										BURNING_AND_FLOP => 4,						
										FLOP => 5,
										BURNING_AND_TURN => 6,
										TURN => 7,
										BURNING_AND_RIVER => 8,
										RIVER => 9,
										ELABORATE => 10,
										SHOWDOWN => 11,
										SHOWWIN => 12,
										CREATE_NEW_GAME => 13
										);
										
				//Array to put V card on board
				$this->arr_start_end[BURNING_AND_FLOP]["start"] = 1;
				$this->arr_start_end[BURNING_AND_FLOP]["end"] = 3;
				
				$this->arr_start_end[BURNING_AND_TURN]["start"] = 4;
				$this->arr_start_end[BURNING_AND_TURN]["end"] = 4;				
				
				$this->arr_start_end[BURNING_AND_RIVER]["start"] = 5;
				$this->arr_start_end[BURNING_AND_RIVER]["end"] = 5;

			break;
			
			case FIVECARD:			
				/*$this->type_hands = Array 
									   (
									   	CHECK_SITTING => "check_sitting",
									   	POSTBLINDS => "postblinds",
										HOLECARDS => "holecards", //5 carte a testa
										FIRSTROUND => "first round", //I giro di scommesse
										ENDROUND => "end first round", //I giro di scommesse
										DRAW => "the draw",									
										SECONDROUND => "second round",										
										ELABORATE => "elaborate",
										SHOWDOWN => "showdown",
										SHOWWIN => "showwin",
										CREATE_NEW_GAME => "createnewgame"
										);*/
										
				$this->type_hands = Array 
									   (
									   	CHECK_SITTING => self::$__clang[CHECK_SITTING],
									   	POSTBLINDS => self::$__clang[POSTBLINDS],
										HOLECARDS => self::$__clang[HOLECARDS], //5 carte a testa
										FIRSTROUND => self::$__clang[FIRSTROUND], //I giro di scommesse
										ENDROUND => self::$__clang[ENDROUND], //I giro di scommesse
										DRAW => self::$__clang[DRAW],									
										SECONDROUND => self::$__clang[SECONDROUND],										
										ELABORATE => self::$__clang[ELABORATE],
										SHOWDOWN => self::$__clang[SHOWDOWN],
										SHOWWIN => self::$__clang[SHOWWIN],
										CREATE_NEW_GAME => self::$__clang[CREATE_NEW_GAME]
										);										
			
				$this->num_type_hands = Array 
									   (
									   	CHECK_SITTING => 0,
									   	POSTBLINDS => 1,
										HOLECARDS => 2, //5 carte a testa
										FIRSTROUND => 3, //I giro di scommesse
										ENDROUND => 4,
										DRAW => 5,											
										SECONDROUND => 6, //II giro di scommesse
										ELABORATE => 7,
										SHOWDOWN => 8,
										SHOWWIN => 9,
										CREATE_NEW_GAME => 10
										);
														
				unset($this->arr_start_end);
			break;			
		}		
				
		/*
		###################################
		arr_list_plrs_seat_ordered:
		Array
		(
		    [6] => Array
		        (
		            [idtable] => 1
		            [player] => 64
		            [seat_number] => 6
		            [outnexthand] => 0
		            [status] => 2
		        )
		)
		####################################
		*/
	}
	
	/**
	* Destructor
	* 
	* Destroy all array and objects for clear memory (util for php4)
	*/	
	function destroy()
	{
		if (isset($this->arr_start_end))
			unset($this->arr_start_end);
			
		unset($this->curr_arr_plrs);
		unset($this->curr_arr_plrs_seat_ordered);
		unset($this->curr_arr_all_plrs_seat_ordered);
		unset($this->curr_arr_si_plrs);
		unset($this->curr_arr_si_plrs_seat_ordered);

		unset($this->type_hands);
		unset($this->num_type_hands);
		unset($this->curr_table);
		unset($this->curr_player);
		unset($this->curr_game);
		unset($this->curr_hand);
		unset($this->lastsubhand);		
	}
	
	/**
	* Get List Tables
	* 
	* Get info table and init client and send it to clien using send_data global function
	*/
	function getListTables($idroom = 0)
	{
		// Del all player $curr_player with status >= AWAY...
		$query = "update pkr_seat set player = ?, status = ? where (status > ? and player not in (select idplayer from pkr_alive where alive >= DATE_SUB(NOW(),INTERVAL ".PKR_AWAY_TIMEOUT." SECOND))) or ((status = ? or status = ?) and player not in (select idplayer from pkr_alive where alive >= DATE_SUB(NOW(),INTERVAL 30 SECOND)))";
		$params = array (0, 0, PLAYING, SITTINGIDLE, SITTING);
		$GLOBALS['mydb']->update($query,$params);
		
		//###############################################################################
		$query = "select * from pkr_table where room = ".$idroom." order by idtable desc";
		$rows['tables'] = $GLOBALS['mydb']->select_tables($query);
		$rows['totElements'] = count($rows['tables']);
		//###############################################################################
				
		//LAST MSG
		$rows["response"]="OK";
		
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);					
	}	
	
	/**
	* check Session
	*
	* Security session check
	*
	*/
	function checkSecurity()
	{
		if ((SECURITY) && (!$_SESSION['isbot'])) 
		{
			if (!DEBUG)
			{
				//If not Guest		
				if ($this->curr_player>0) {
					$this->curr_session = $this->getSession();	
					//echo "<br>".$this->curr_session." - ".session_id()."<br>";
					if ($this->curr_session != session_id()) {
						echo "hacking!";
						exit();
					}
				}			
			}
		}	
	}
	
	/**
	* Get Session
	* 
	* Get current session player
	*
	* @return string 
	*/			
	function getSession()
	{
		$query = "select sess from pkr_player where idplayer=".$this->curr_player;
		$sess = $GLOBALS['mydb']->select($query);
		$sess = $sess[0]["sess"];
		return $sess;
	}	
		
	/**
	* Get table information
	* 
	* Get information about table as: max players, stakes min and max, limited, allin allowed, is fast table and type of game
	*
	* @return array 
	*/	
	function getTableFieldsValue()
	{
		$query = "select max_plrs,stakes_min,stakes_max,limited,all_in,fast,type_game from pkr_table where idtable=".$this->curr_table;
		$rows = $GLOBALS['mydb']->select($query);		
		$rows = $rows[0];
		return $rows;
	}
	
	/**
	* Update player credit
	* 
	* This functions check all controls when player finish his credit and wants to update it
	* Array credits information by send_data global function, send data to the client
	*/
	function getPlayerInfoCredit()
	{
		$rows = array();
		
		$query = "select virtual_money from pkr_player where idplayer=".$this->curr_player;
		$res = $GLOBALS['mydb']->select($query);
		$res = $res[0]['virtual_money'];
		
		$rows['totcredit'] = $res;		
		$rows['getcredit'] = 0;
		$rows['notabletoplay'] = 0;
		
		//If credit < of min table credit
		if ($res < $this->min_tbl_credit_to_play)
		{
			//If min general credit < of min table credit
			//This table is not playable to this player
			if (PKR_DEFAUL_GET_CREDIT < $this->min_tbl_credit_to_play) {
				$rows['text_response'] = self::$__lang["get_plr_credit_error1"].$this->min_tbl_credit_to_play.PKR_CURRENCY_SYMBOL;
				$rows['notabletoplay'] = 1;
			}
			//To play to this table must update cash credit
			else {
				$rows['text_response'] = self::$__lang["get_plr_credit_error2"];
				$rows['getcredit'] = 1;
			}
		}
		
		$rows['response'] = "OK";
		
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);
		
		unset($rows);		
	}
	
	/**
	* Update Player Table Cash
	* 
	* This functions set player cash for current table and send result to client using send_data global function
	*
	* @param double $credit
	*/	
	function setPlayerTableCash($credit)
	{
		$rows = array();
		
		$query = "select virtual_money from pkr_player where idplayer=".$this->curr_player;
		$res = $GLOBALS['mydb']->select($query);
		$res = $res[0]['virtual_money'];
		
		$query = "select status from pkr_seat where idtable = ".$this->curr_table." and player = ".$this->curr_player;
		$sts = $GLOBALS['mydb']->select($query);
		$sts = $sts[0]['status'];
		
		if (
			(($res - $credit >= 0) && ($credit >= $this->min_tbl_credit_to_play) && ($credit <= $this->max_tbl_credit_to_play)) 
			&&
				(
				(
				($this->num_type_hands[$this->curr_type_hand] < ($this->num_type_hands[POSTBLINDS])) || 
				($this->num_type_hands[$this->curr_type_hand] > ($this->num_type_hands[SHOWDOWN])) 
				) || ($sts != PLAYING) 
				)
			)
		{
			if (isset($credit)) 
			{
				$query = "insert into pkr_tablecash (idtable, idplayer, virtual_money) values (?, ?, ?) ON DUPLICATE KEY UPDATE virtual_money = ?";
				$params = array ($this->curr_table, $this->curr_player, $credit, $credit);
				$GLOBALS['mydb']->update($query,$params);
				
				$rows['response'] = "OK";
				
				$this->away2sittingidle();
				
				$this->removePtg($this->curr_player, $this->min_tbl_credit_to_play);
			}
			else 
			{
				$rows['response'] = self::$__lang["credit_update_error1"];
			}							
		}
		else 
		{
			if (!
				(
				(
				($this->num_type_hands[$this->curr_type_hand] < ($this->num_type_hands[POSTBLINDS])) || 
				($this->num_type_hands[$this->curr_type_hand] > ($this->num_type_hands[SHOWDOWN])) 
				) || ($sts != PLAYING) 
				)			
				)
			
				$rows['response'] = self::$__lang["credit_update_error2"];				
			else
				$rows['response'] = self::$__lang["credit_update_error3"].$this->min_tbl_credit_to_play.PKR_CURRENCY_SYMBOL."/".$this->max_tbl_credit_to_play.PKR_CURRENCY_SYMBOL;
		}
	
		if (DEBUG)
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);
		
		unset($rows);		
	}
	
	/**
	* Update player credit
	* 
	* This functions check all controls when player finish his credit and wants to update it
	* Array credits information by send_data global function, send data to the client
	*/	
	function getCredit()
	{
		$query = "select virtual_money from pkr_player where idplayer=".$this->curr_player;
		$res = $GLOBALS['mydb']->select($query);
		$res = $res[0]['virtual_money'];		
		
		$query = "select status from pkr_seat where idtable = ".$this->curr_table." and player = ".$this->curr_player;
		$sts = $GLOBALS['mydb']->select($query);
		$sts = $sts[0]['status'];
				
		if (($res < PKR_DEFAUL_GET_CREDIT) && ($sts != PLAYING))
		{
			$query = "update pkr_player set virtual_money = (virtual_money + ".PKR_DEFAUL_GET_CREDIT."), n_credit_update = (n_credit_update + 1) where idplayer = ?";
			$params = array ( $this->curr_player );
			$GLOBALS['mydb']->update($query,$params);	
				
			$rows['response'] = "OK";
			$rows['message'] = self::$__lang["msg_credit_updated"];
			
			$this->removePtg($this->curr_player, $this->max_tbl_credit_to_play);
			
			$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","getCredit()","Srv ".$this->curr_plr_server,$this->curr_player." get credit ".PKR_DEFAUL_GET_CREDIT.PKR_CURRENCY_SYMBOL);
		}
		else
		{
			$rows['response'] = "KO";
			$rows['message'] = self::$__lang["msg_credit_not_updated"]; 
		}	
		
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";
		}
		else
			send_data($rows);				
	}
	
	/**
	* Get Winner Cards
	* 
	* Get all player winner cards of this game and this table at End Game
	*
	* @return array
	*/	
	function getWinnerCards()
	{
		//$query = "select number,card,seed,seat from (pkr_dealer d inner join pkr_seat s on d.seat=s.seat_number) where seat in (select seat from pkr_typepost where idtable=".$this->curr_table." and game=".$this->curr_game.") and s.player not in (select player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game.") and game=".$this->curr_game." and d.idtable=".$this->curr_table." and s.status = ".PLAYING." order by seat, number";
		$query = "select number,card,seed,seat from pkr_dealer where idtable=".$this->curr_table." and game=".$this->curr_game." and seat in (select seat from pkr_typepost where idtable=".$this->curr_table." and game=".$this->curr_game.") and player in (select player from pkr_seat where idtable=".$this->curr_table." and status=". PLAYING .") and seat not in (select seat from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game.") order by seat, number";
		return $GLOBALS['mydb']->select($query);
	}
	
	/**
	* Get Allin Cards
	* 
	* Get all player winner cards of this game and this table for all allin status game
	*
	* @return array
	*/	
	function getAllinCards()
	{
		//$query = "select number,card,seed,seat from (pkr_dealer d inner join pkr_seat s on d.seat=s.seat_number) where game=".$this->curr_game." and d.idtable=".$this->curr_table." and s.player not in (select player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game.") and s.status = ".PLAYING." order by seat, number";
		$query = "select number,card,seed,seat from pkr_dealer where idtable=".$this->curr_table." and game=".$this->curr_game." and seat not in (select seat from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game.") and player in (select player from pkr_seat where idtable=".$this->curr_table." and status=". PLAYING .") order by seat, number";
		return $GLOBALS['mydb']->select($query);	
	}
	
	/**
	* Set End Round Seat
	* 
	* Set end round seat on database
	*
	* @param int $seat 
	*/	
	function setEndRound_Seat($seat = null)
	{
		if ((isset($seat)) && (isset($this->curr_game))) {
			$query = "update pkr_game set endround_seat = ? where idtable = ? and idgame = ?";
			$params = array ($seat, $this->curr_table, $this->curr_game);
			$GLOBALS['mydb']->update($query,$params);
		}
	}
	
	/**
	* Set End Round Next Seat 
	* 
	* Set End Round Next Seat
	*/	
	function setEndRound_NextSeat()
	{
		if (isset($this->curr_game)) {
			$query = "update pkr_game set endround_nextseat = ? where idtable = ? and idgame = ?";
			$params = array (1, $this->curr_table, $this->curr_game);
			$GLOBALS['mydb']->update($query,$params);
		}
	}	
	
	/**
	* Set All Allin
	* 
	* Set All Allin
	*/	
	function setAll_Allin()
	{
		$query = "update pkr_game set all_allin = ? where idtable = ? and idgame = ?";
		$params = array (1, $this->curr_table, $this->curr_game);
		$GLOBALS['mydb']->update($query,$params);
	}	
	
	/**
	* Set End Round Moved
	* 
	* Set End Round Moved
	*/	
	function setEndRoundMoved()
	{
		$query = "update pkr_game set endround_seat = ? where idtable = ? and idgame = ?";
		$params = array (0, $this->curr_table, $this->curr_game);
		$GLOBALS['mydb']->update($query,$params);
	}
	
	/**
	* Get Game Seat Folder
	* 
	* Get all player folder of this game and this table
	*
	* @param int $idpost
	* @return array
	*/	
	function getGameSeatFolder($idpost = null)
	{
		//Prendo i fold solo delle persone che stanno giocando...
		if (isset($this->curr_game)) {
			if (isset($idpost))
				$query = "select seat from pkr_game_fold where idpost=".$idpost." and idtable=".$this->curr_table." and game=".$this->curr_game." and seat in (select seat_number from pkr_seat where idtable=".$this->curr_table." and status = ".PLAYING.")";
			else
				$query = "select seat from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game." and seat in (select seat_number from pkr_seat where idtable=".$this->curr_table." and status = ".PLAYING.")";
				
			return $GLOBALS['mydb']->select_singlefield($query, "seat");
		}
		else
			return null;
	}
	
	/**
	* Get Game Player Winner
	* 
	* Get all player that wins current game
	*
	* @return array
	*/	
	function getGamePlayerWinner()
	{
		if (isset($this->curr_game)) {
			$query = "select player from pkr_game_win where seat>0 and idtable=".$this->curr_table." and game=".$this->curr_game;
			return $GLOBALS['mydb']->select_singlefield($query, "player");
		}
		else
			return null;			
	}	
	
	/**
	* Get N Game Seat Folder
	* 
	* Get count of seats that does fold
	*
	* @return int
	*/	
	function getNGameSeatFolder()
	{
		$n = 0;
		if (isset($this->curr_game)) {
			$query = "select count(*) as n from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game;
			$n = $GLOBALS['mydb']->select($query);
			$n = $n[0]['n'];
		}
		return $n;	
	}
	
	/**
	* Check Money
	* 
	* Set to AWAY status all player of this table that are out of credit
	*/	
	function checkMoney()
	{		
		//$query = "update pkr_seat s left join pkr_player p on s.player = p.idplayer set status = ? where idtable = ? and status = ? and p.virtual_money < ?";
		//$query = "update pkr_seat s, pkr_tablecash p set status = ? where s.player = p.idplayer and s.idtable = p.idtable and s.idtable = ? and status = ? and p.virtual_money < ?";
		$query = "update pkr_seat set status = ? where idtable = ? and player > 0 and player in (select idplayer from pkr_tablecash where idtable = ? and virtual_money < ?)";
		//$params = array (AWAY, $this->curr_table, PLAYING, $this->min_tbl_credit_to_play);
		$minval = $this->bblind;
		$params = array (AWAY, $this->curr_table, $this->curr_table, $minval);
		$GLOBALS['mydb']->update($query,$params);
	}

	/**
	* Update Ptg
	* 
	* Update points of a player
	* Points = (Pot/(BigBlind*2)) * PTG
	*
	* @param int $player
	* @param double $ptg
	* @param double $pot
	*/		
	function updatePtg($player, $ptg, $pot)
	{
		$delta = $this->bblind*2;
		$coeff = floor($pot/$delta);
		$my_ptg = $ptg * $coeff;
		if ($my_ptg>0) {
			$query = "update LOW_PRIORITY pkr_player set ptg = (ptg + ?) where idplayer = ?";
			$params = array ($my_ptg, $player);
			$GLOBALS['mydb']->update($query, $params);
			$this->insChatMsg("+".$my_ptg.self::$__lang['points'], MSG_FOR_SYSTEM, $player);
		}
	}
	
	/**
	* Remove Ptg
	* 
	* Remove points from player profile
	*
	* @param int $player
	* @param double $ptg
	*/		
	function removePtg($player, $ptg)
	{
		$query = "update LOW_PRIORITY pkr_player set ptg = (ptg - ?) where idplayer = ?";
		$params = array ($ptg, $player);
		$GLOBALS['mydb']->update($query, $params);
	}
	
	/**
	* Update Money
	* 
	* Set ('diff' or 'sum') credit ($post) of this player
	*
	* @param int $post
	* @param string $op
	* @param int $player		
	* @return int
	*/
	function updateVMoney($post, $op = 'diff', $player = null)
	{
		//If money are 0$ --> Warning !! check this event
		$val = $post;
				
		if (isset($player))
		{
			$params = array ($player);
			$params_cash = array ($this->curr_table, $player);
		}
		else 
		{
			$params = array ($this->curr_player);
			$params_cash = array ($this->curr_table, $this->curr_player);
		}
					
		if ($op == 'diff')
		{			
			$query = "select virtual_money from pkr_tablecash where idtable=".$this->curr_table." and idplayer=". $params[0] ;
			$mypot = $GLOBALS['mydb']->select($query);
			$mypot = $mypot[0]["virtual_money"];
			
			$query = "select virtual_money from pkr_player where idplayer=". $params[0] ;
			$pocket = $GLOBALS['mydb']->select($query);
			$pocket = $pocket[0]["virtual_money"];			
			
			if ($mypot > $post)
			{
				$newpot = $mypot - $post;
				$val = $post;
			}
			else
			{
				//ALL IN
				$newpot = 0;
				$val = $mypot;
			}
			
			$val = number_format($val,2,'.', '');
			$val = str_replace(",","",$val);
			
			$newpot = number_format($newpot,2,'.', '');
			$newpot = str_replace(",","",$newpot);
			
			$query = "update pkr_player set virtual_money=virtual_money-'".$val."' where idplayer=?";
			$query_cash = "update pkr_tablecash set virtual_money='".$newpot."' where idtable=? and idplayer=?";
		}
		else 
		{			
			$newpot = number_format($post,2,'.', '');
			$newpot = str_replace(",","",$newpot);
			
			$query = "update pkr_player set virtual_money=(virtual_money+'".$newpot."') where idplayer=?";
			$query_cash = "update pkr_tablecash set virtual_money=(virtual_money+'".$newpot."') where idtable=? and idplayer=?";
		}
			
		$GLOBALS['mydb']->update($query,$params);
		$GLOBALS['mydb']->update($query_cash,$params_cash);
				
		return $val;
	}
	
	/**
	* Alive
	* 
	* Set player alive date on database
	*/
	function alive() 
	{
		//Inserire alive solo se si sta giocando 
		if (isset($this->curr_player) && $this->curr_player>0) {
			$query = "insert into pkr_alive (idtable, idplayer, alive) values (?, ?, NOW()) ON DUPLICATE KEY UPDATE alive = NOW()";
			$params = array ($this->curr_table, $this->curr_player);
			$GLOBALS['mydb']->update($query,$params);
		}
	}	
	
	/**
	* Get Array Players
	* 
	* Get players array for a status (default PLAYING) 
	*
	* @param bool $seat_ordered
	* @param int $status
	* @param bool $all
	* @return array
	*/
	function getArrPlrs($seat_ordered = false, $status = PLAYING, $all = false)
	{	
		if ($all)
			$query = "select SQL_CACHE seat_number,player,status from pkr_seat where idtable=".$this->curr_table." and status>0 and status <= ".$status." and player in (select idplayer from pkr_alive where idtable = ".$this->curr_table." and alive >= DATE_SUB(NOW(),INTERVAL ".PKR_PLAYING_TIMEOUT." SECOND)) order by seat_number";
		else
			$query = "select SQL_CACHE seat_number,player,status from pkr_seat where idtable=".$this->curr_table." and status = ".$status." and player in (select idplayer from pkr_alive where idtable = ".$this->curr_table." and alive >= DATE_SUB(NOW(),INTERVAL ".PKR_PLAYING_TIMEOUT." SECOND)) order by seat_number";
		
		if ($seat_ordered)
		{
			$rows = $GLOBALS['mydb']->special_select($query,"seat_number");
		} 
		else 
		{	
			$rows = $GLOBALS['mydb']->select($query);
		}
		return $rows;
	}
	
	/**
	* Get Players Folder
	* 
	* Get players array that folds
	*
	* @return array
	*/
	function getPlrsFolder()
	{
		$query = "select seat, player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game;
		return $GLOBALS['mydb']->select($query);	
	}	
	
	/**
	* Get Array Players
	* 
	* Get players array that do allin
	*
	* @return array
	*/
	function getPlrsAllin()
	{
		$query = "select seat, player from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." and isallin = 1 group by seat";
		return $GLOBALS['mydb']->select($query);
	}
	
	/**
	* Get Players Numbers
	* 
	* Get players number that have that status (default PLAYING)
	*
	* @param int $status
	* @return array
	*/
	function getPlrNumbers($status = PLAYING)
	{
		$query = "select count(*) as n_plrs from pkr_seat where player>0 and status=".$status." and idtable=".$this->curr_table;		
		$n_plrs = $GLOBALS['mydb']->select($query);
		$n_plrs = $n_plrs[0]['n_plrs'];		
		return $n_plrs;
	}
	
	/**
	* Get Data Player
	* 
	* Get information data of current player
	*
	* @return array
	*/	
	function getDataPlayer() 
	{
		$data1 = array();
		$query = "select SQL_CACHE usr,virtual_money as tot_vitual_money from pkr_player where idplayer = ".$this->curr_player;
		$data1 = $GLOBALS['mydb']->select($query);
		$data1 = $data1[0];
		
		$data2 = array();
		$query = "select SQL_CACHE virtual_money from pkr_tablecash where idtable = ".$this->curr_table." and idplayer = ".$this->curr_player;
		$data2 = $GLOBALS['mydb']->select($query);
		$data2 = $data2[0];
		
		if (!isset($data2))
			$data2['virtual_money'] = 0.00;

		if (isset($data1))
			$rows = array_merge($data1,$data2);
		else
			$rows = $data2;
		
		unset($data1);
		unset($data2);
		
		return $rows;
	}
	
	/**
	* Insert Player on current table
	* 
	* Allow current player to seat on current table (from 0 seat to 9 seat in a table of 10 seat). Array that function returns is send to client by send_data global function
	*
	* @param int $curr_player
	* @param int $curr_req_seat_number
	*/
	function insPlayerInTable($curr_player, $curr_req_seat_number)
	{	
		if ($curr_req_seat_number>0) 
		{
			$ip = $_SERVER["REMOTE_ADDR"];
			
			$query = "select count(*) as n from pkr_player where ip = '".$ip."' and idplayer != ".$curr_player." and idplayer in (select player from pkr_seat where idtable=".$this->curr_table.")";
			$nip = $GLOBALS['mydb']->select($query);
			$nip = $nip[0]['n'];
			
			if ( (in_array($this->curr_player,$this->__id_allowed)) || (IP_ALLOWED) || ($_SESSION['isbot']) || ($nip == 0) || (($nip > 0) && (!SECURITY)) )
			{			
				//Da sistemare....diverso dal player corrente....
				$query = "select player from pkr_seat where idtable=".$this->curr_table." and seat_number=".$curr_req_seat_number;
				$player = $GLOBALS['mydb']->select($query);
				$player = $player[0]['player'];
				
				if ($player == 0)
				{
					// Search on this table
					$query = "select count(*) as n from pkr_seat where idtable=".$this->curr_table." and player=".$curr_player;
					$n_thistbl = $GLOBALS['mydb']->select($query);
					$n_thistbl = $n_thistbl[0]["n"];
					
					if ($n == 0) 
					{									
						if (ALL_TABLE_PLAYING_ALLOWED)
						{						
							$query = "update pkr_seat set player=?, status=? where seat_number=? and idtable=?";
							$params = array ($curr_player, SITTINGIDLE, $curr_req_seat_number, $this->curr_table);
							$GLOBALS['mydb']->update($query,$params);
							
							$rows["response"]="OK";					
						}
						else
						{							
							// Cancello tutti i player $curr_player con status >= AWAY...
							$query = "update pkr_seat set player = ?, status = ? where player = ? and status > ? and status != ?";
							$params = array (0, 0, $curr_player, 0, PLAYING);
							$GLOBALS['mydb']->update($query,$params);							
							
							// Search on all tables
							$query = "select t.idtable, name from pkr_table t , pkr_seat s where t.idtable=s.idtable and player=".$curr_player." and s.seat_number>0 and s.status>0 and s.status<=".PLAYING;
							$oth_table = $GLOBALS['mydb']->select($query);
																
							if (!isset($oth_table))
							{												
								//$query = "select virtual_money from pkr_player where idplayer=".$curr_player;
								$query = "select virtual_money from pkr_tablecash where idtable=".$this->curr_table." and idplayer=".$curr_player;
								$res = $GLOBALS['mydb']->select($query);
								$res = $res[0]['virtual_money'];
								
								if ($res >= $this->min_tbl_credit_to_play)
								{												
									$query = "update pkr_seat set player=?, status=? where seat_number=? and idtable=?";
									$params = array ($curr_player, SITTINGIDLE, $curr_req_seat_number, $this->curr_table);
									$GLOBALS['mydb']->update($query,$params);
									
									$query = "update pkr_player set ip = ? where idplayer=?";
									$params = array ($ip, $curr_player);
									$GLOBALS['mydb']->update($query,$params);									
									
									$rows["response"]="OK";
								}
							}
							else
								$rows["response"] = self::$__lang["plr_just_seated"].$oth_table[0]['idtable']." [".$oth_table[0]['name']."]";
						}					
					}
					else
						$rows["response"] = self::$__lang["plr_just_seated_this_table"];
				}
				else
					$rows["response"] = self::$__lang["seat_occuped"]; 
			}
			else
				$rows["response"] = self::$__lang["plr_just_seated_this_table2"];
		} 
		else 
			$rows["response"] = "OK";	
		
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);

	}		
	
	/**
	* Get Table Properties
	* 
	* Get table properties and data send to client by send_data global function
	*/
	function getTableProperties()
	{
		$query = "insert into pkr_tablecash (idtable, idplayer, virtual_money) values (?, ?, ?) ON DUPLICATE KEY UPDATE virtual_money = ?";
		$params = array ($this->curr_table, $this->curr_player, 0, 0);
		$GLOBALS['mydb']->update($query,$params);
			
		$query = "update pkr_seat set status=? where player=?";
		$params = array (AWAYOUT, $this->curr_player);
		$GLOBALS['mydb']->update($query,$params);
		
		$query = "select * from pkr_table t where idtable=".$this->curr_table;
		
		$rows['table'] = $GLOBALS['mydb']->select($query);		
		$rows['table'] = $rows['table'][0];
		$rows['table']['min_to_play'] = $this->min_tbl_credit_to_play.PKR_CURRENCY_SYMBOL;
		$rows['table']['max_to_play'] = $this->max_tbl_credit_to_play.PKR_CURRENCY_SYMBOL;
		$rows['table']['timer'] = PKR_TIMER;
		
		//LAST MSG
		$rows["response"]="OK";
		
		if ($this->curr_player == 0)
			$this->insChatMsg(self::$__lang["guest_entered"], MSG_FOR_SYSTEM);
		else
			$this->insChatMsg(self::$__lang["plr_entered"], MSG_FOR_CHAT, $this->curr_player);
		
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);					
	}

	/**
	* Get Data Seat
	* 
	* Get all information data about seat occuped on this table
	*
	* @return array
	*/	
	function getDataSeat()
	{	
		// If table does not exists create it
		/*if (!$GLOBALS['mydb']->table_exists(VIEWTBL))
		{			
			$query = "SELECT (virtual_money-(n_credit_update*".PKR_DEFAUL_GET_CREDIT.")) as w, usr, idplayer FROM pkr_player WHERE confirmed=1 ORDER BY w DESC";
    		$GLOBALS['mydb']->create_table(VIEWTBL,$query);
		}
		// Destroy it for update
		else 
		{*/
			if (DEBUG)
				unset($_SESSION[VIEWTBL]);
			
			// If session ranking does not setted create it
			if (!isset($_SESSION[VIEWTBL]))
			{
				//$query = "SELECT * FROM ".VIEWTBL;
				$query = "SELECT SQL_CACHE usr, idplayer, (virtual_money-(n_credit_update*".PKR_DEFAUL_GET_CREDIT.")) as w FROM pkr_player WHERE confirmed=1 ORDER BY w DESC";
				$res = $GLOBALS['mydb']->special_select($query, "idplayer");
				if (!empty($res)) {
					// Insert pos field in player ranking array
					array_walk($res,'setPos');
				}
				$_SESSION[VIEWTBL] = $res;
				
			}
			else // use Session ranking
			{
				$res = array();
				$res = $_SESSION[VIEWTBL];
			}
						
			if (($this->curr_game % MOD_UPDATE_RANKING == 0) && ($this->curr_type_hand == CHECK_SITTING)) 
			{
				if (isset($_SESSION[VIEWTBL]))
					unset($_SESSION[VIEWTBL]);

				//$GLOBALS['mydb']->drop_table();
			}
		//}
										
		$query = "SELECT usr,s.player as idplayer,seat_number,status,mail,city,supporter,bonus,t.virtual_money as virtual_money,p.ptg as points from pkr_seat s, pkr_player p, pkr_tablecash t where s.player=p.idplayer and s.player=t.idplayer and t.idtable=".$this->curr_table." and s.idtable=".$this->curr_table." order by seat_number asc";
		$rows = $GLOBALS['mydb']->select($query);
		
		if (!isset($rows)) return $rows;
		
		// Insert pos for user on table
		array_walk($rows,'addElement',$res);
		unset($res);		

		return $rows;
	}
	
	/**
	* Get Last Winner
	* 
	* Get data player that wins on current table and current game
	*
	* @param bool $number_ordered
	* @return array
	*/
	function getLastWinner($number_ordered = false)
	{
		$query = "select * from pkr_game_win where idtable=".$this->curr_table." and game=".$this->curr_game." order by number";
		$res = $GLOBALS['mydb']->select($query);
	
		$tmp = array();
		$c_res = count($res);
		for($i=0; $i < $c_res; $i++)
			$tmp[$res[$i]["number"]] = $res[$i];
		
		if ($number_ordered)
			return $tmp;
		else
			return $res;
	}	
	
	/**
	* Get Array Data Table
	* 
	* Get all status and data information about situation of current table
	*
	* @param array &$rows
	*/
	function getArrDataTable(&$rows)
	{		
		$rows['nplrs'] = $this->n_playing_plrs;		
		$rows['plr'] = $this->getDataPlayer();
		
		if ($rows['plr']['virtual_money'] >= $this->min_tbl_credit_to_play)
			$rows['plr']['playable'] = 1;
		else
			$rows['plr']['playable'] = 0;

		$rows['seat'] = $this->getDataSeat();

		if ( (isset($this->curr_game)) && (isset($this->curr_post)) )
		{			
			$rows['hand'] = $this->getLastDataHand();
			$rows['subhand'] = $this->getDataLastSubHand($rows['hand']['idhand']);			
			
			if (
				($this->num_type_hands[$rows['hand']['type_hand']] >= ($this->num_type_hands[POSTBLINDS])) &&
				($this->num_type_hands[$rows['hand']['type_hand']] <= ($this->num_type_hands[SHOWWIN]))
				)			
				$rows['curr_idsubhand'] = $rows['subhand'][0]['idsubhand'];
			
			$rows['reset_game'] = 0;
						
			$rows['game'] = $this->getDataGame();			
			$rows['current_game'] = $this->curr_game;

						
			// I FOLD PER QUESTO GAME	
			$rows["fold"] = $this->getPlrsFolder();

			// GLI ALLIN PER QUESTO GAME	
			$rows["allin"] = $this->getPlrsAllin();			
											
			if (
				($this->num_type_hands[$rows['hand']['type_hand']] >= ($this->num_type_hands[POSTBLINDS])) &&
				($this->num_type_hands[$rows['hand']['type_hand']] <= ($this->num_type_hands[SHOWWIN]))
				)
			{				
				// Instanzio la classe Dealer...
				require("../class/pkr.dealer.class.php");
				$deal = new Dealer($this->curr_table, $this->curr_game, $this->curr_player);
								
				$rows['post'] = $this->getSubPostSeatOrdered();
				$rows['data_post'] = $this->getAllPost();
				$rows['data_post']['boardpost'] = $this->getPosts();
				$rows['data_post']['maxhandpost'] = number_format($rows['data_post']['maxhandpost'],0,'.', '');
				$rows['data_post']['mytothandpost'] = number_format($rows['data_post']['mytothandpost'],0,'.', '');
				$rows['data_post']['call'] = number_format($rows['data_post']['maxhandpost'] - $rows['data_post']['mytothandpost'],0,'.', '');
				$rows['data_post']['raise'] = number_format(($rows['data_post']['call'] * 2),0,'.', '');
				$rows['data_post']['bet'] = number_format($rows['data_post']['stakes_min'],0,'.', '');
				$rows['n_post_this_hand'] = $this->getNumSubPost();
				
				if ($this->type_game == HOLDEM)
					$rows['board'] = $deal->getBoardCards();
				
				if ($this->num_type_hands[$rows['hand']['type_hand']] >= ($this->num_type_hands[HOLECARDS]))			
				{
					$rows['plrs'] = $this->curr_arr_plrs;	
					$rows['plrs_seat_ordered'] = $this->curr_arr_plrs_seat_ordered;							
					$rows['card'] = $deal->getCard();
				}
			}
			
			switch ($rows['hand']['type_hand'])
			{
				case CHECK_SITTING:
				case CREATE_NEW_GAME:
					
					$rows['all_allin'] = 0;			
					$rows['showdown'] = 0;
					$rows['reset_game'] = 1;
				
				break;
				
				case SHOWWIN_FOLD:
				
					$rows['all_allin'] = 0;
					$rows['showdown'] = 0;
					$rows['reset_game'] = 0;
									
				break;
														
				case ELABORATE:
				case SHOWDOWN:
				case SHOWWIN:
				
					$rows['all_allin'] = 0;
					$rows['reset_game'] = 0;
					$rows['showdown'] = 1;
					
					//$rows['n_winners'] = $this->getNPots();				
					$rows['winners'] = $this->getLastWinner();
					$rows['n_winners'] = count($rows['winners']);
					$rows['winners_number_ordered'] = $this->getLastWinner(true);
					$rows['n_pots'] = count($rows['winners_number_ordered']);
					$rows['winner_cards'] = $this->getWinnerCards();			
				
				break;
												
				default:
				
					$rows['all_allin'] = $rows['game']['all_allin'];
					$rows['showdown'] = 0;					
					$rows['reset_game'] = 0;
					
					if ($rows['all_allin'] == 1)
						$rows['allin_card'] = $this->getAllinCards();										
					
					$rows['sec'] = intval($this->now - $rows['subhand'][0]['time']);	
						
				break;		
			}			
		}
		else 
		{		
			$rows['all_allin'] = 0;	
			$rows['showcards'] = 0;
			$rows['reset_game'] = 1;
		}
		
		// Recheck MemCached
		if ($rows['hand']['type_hand'] == CHECK_SITTING)
			unset($_SESSION['memcache']);		

		//LAST MSG
		$rows["response"]="OK";		
	}	
	
	/**
	* Get Data Table
	* 
	* Get all data about current table and send it to client by send_data global function
	*/
	function getDataTable()
	{
		$rows = array();
		
		/*if (
			( (!isset($_SESSION["tbl_".$this->curr_table]['rows'])) || 
			  ($_SESSION["tbl_".$this->curr_table]['rows']["subhand"][0]["idsubhand"] != $this->lastsubhand[0]["idsubhand"]) ||
			  ($_SESSION["tbl_".$this->curr_table]['rows']["hand"]["idhand"] != $this->curr_hand)
			 ) ||			  
		   	($this->num_type_hands[$this->curr_type_hand]==0)
			)
		{*/
		if (
			( (!isset($_SESSION["tbl_".$this->curr_table]['rows'])) || 
			  (!isset($_SESSION["tbl_".$this->curr_table]['idsubhand_inserted'])) ||
			  ($this->lastsubhand[0]["idsubhand"] > $_SESSION["tbl_".$this->curr_table]['idsubhand_inserted']) ||
			  ($_SESSION["tbl_".$this->curr_table]['rows']["hand"]["idhand"] != $this->curr_hand)
			 ) ||			  
		   	($this->num_type_hands[$this->curr_type_hand] == 0)
			)
		{
			$_SESSION["tbl_".$this->curr_table]['idsubhand_inserted'] = $this->lastsubhand[0]["idsubhand"];
			$rows['chat'] = $this->getChatMsg();
			$this->getArrDataTable($rows);
			$_SESSION["tbl_".$this->curr_table]['rows'] = array();
			$_SESSION["tbl_".$this->curr_table]['rows'] = $rows;			
		}
		else 
		{
			$_SESSION["tbl_".$this->curr_table]['rows']['chat'] = $this->getChatMsg();
			$rows = $_SESSION["tbl_".$this->curr_table]['rows'];
		}
			
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);
		
		unset($rows);
	}

	/**
	* Get Response Subhand
	* 
	* Depending on type_game of current table is called setAction of type game Class (holdem, fivecard, ecc..)
	*
	* @param string $user_response
	* @param double $post
	* @param int $curr_seat
	* @param int $idplr
	* @param bool $forced
	* @param string $card_changed
	*/
	function getResponseSubHand($user_response, $post, $curr_seat, $idplr = null, $forced = false, $card_changed = null)
	{				
		if ($user_response == FOLD) {
			$query = "select sum(post) as post from pkr_subpost where game=".$this->curr_game." and idtable=".$this->curr_table." and player=".$this->curr_player;
			$res = $GLOBALS['mydb']->select_tables($query);
			$res = floor($res[0]['post']);
			if ($res>$this->bblind)
				$this->removePtg($this->curr_player, $res);
			else
				$this->removePtg($this->curr_player, $this->bblind);
		}			
					
		switch ($this->type_game)
		{
			case HOLDEM:
				require("../class/holdem.php");
				$this->rule = new holdem($this);
				$this->rule->setAction($user_response, $post, $curr_seat, $idplr, $forced);
			break;

			case FIVECARD:
				require("../class/fivecard.php");
				$this->rule = new fivecard($this);
				$this->rule->setAction($user_response, $post, $curr_seat, $idplr, $forced, $card_changed);				
			break;
		}		
	}
	
	/**
	* set Player Switch Sitting Idle
	* 
	* Function change status to Sitting or Sitting to Idle (Leave Game). Send to Client array using send_data global function
	*
	* @param int $curr_seat
	*/
	function setPlayerSwitchSitting_Idle($curr_seat)
	{
		$status = $this->getPlayerStatus($curr_seat);
		if (isset($status))
		{
			//If iam seated and sittingidle or playing, set to sitting 
			//else 
			//If iam seated but just sitting set to sittingidle
			if ($status <= PLAYING) {
				$this->sitting($curr_seat);
				$rows['is'] = SITTING;
				$rows['to'] = self::$__clang['_play'];
				$rows['response'] = "OK";
			} elseif ($status == SITTING) {
				$this->sitting2idle($curr_seat);
				$rows['is'] = IDLE;
				$rows['to'] = self::$__clang['btn_lbl_leaveseat'];
				$rows['response'] = "OK";
			} else
				$rows['response'] = self::$__lang["plr_must_seat1"];
				
		}
		else
			$rows['response'] = self::$__lang["plr_must_seat2"];
			
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);
		
		unset($rows);			
	}
	
	
	/**
	* set Player Leave Seat
	* 
	* Function allow Player to sit out from table (Leave Seat). Send to Client array using send_data global function
	*
	* @param int $curr_seat
	*/
	function setPlayerLeaveSeat($curr_seat)
	{
		$status = $this->getPlayerStatus($curr_seat);
		if (isset($status))
		{
			//If iam seated and sittingidle or playing, set to sitting 
			//else 
			//If iam seated but just sitting set to sittingidle
			if (($status <= PLAYING) || ($status == SITTING) || ($status == AWAY)) {
				$this->awayout($curr_seat);
				$rows['response'] = "OK";
			} else
				$rows['response'] = self::$__lang["plr_cannot_leave"];
		}
		else
			$rows['response'] = self::$__lang["must_seat3"]; 
			
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);
		
		unset($rows);			
	}
	
	/**
	* Get idplayer of a bot player
	*
	* @return array
	*/
	function getBotIdPlayer($getIdPlayer = true)
	{
		$res = array();
		$rows = array();
			
		if ($getIdPlayer) {
			$_SESSION['isbot'] = true;
			$query = "select idplayer from pkr_player where isbot = 1 and idplayer not in (select player from pkr_seat where status != ".PLAYING." or status != ".SITTINGIDLE.")";
			$res = $GLOBALS['mydb']->select($query);
			$idplr = $res[0]["idplayer"];			
		}
		
		$query = "select seat_number from pkr_seat where player = 0 and status = 0 and idtable = ".$this->curr_table." limit 1";
		$res = $GLOBALS['mydb']->select($query);
		$seat = $res[0]["seat_number"];
		unset($res);
				
		if ($getIdPlayer) {
			$rows["idplayer"] = $idplr;		
		}
		$rows["seat"] = $seat;
		$rows['response'] = "OK";
		
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);
		
		unset($rows);		
	}
	
	/**
	* getDataLanguages
	*
	*/
	function getDataLanguages() {
		$rows['lang'] = self::$__clang;
		//LAST MSG
		$rows["response"]="OK";
		
		if (DEBUG) 
		{
			echo "<pre>";	
			print_r($rows);
			echo "</pre>";	
		}
		else
			send_data($rows);	
	}	
}
?>

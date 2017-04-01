<?php
require("../class/pkr.post.class.php");

/**
 * SubHand Class 
 *
 * Class that Manage SubHand
 * Extends Post Class
 * 
 */
class Subhand extends Post {
				
	var $curr_subhand;
	var $curr_type_subhand;
	var $lastsubhand;	
	var $type_subhands = Array();
					
	/**
	* Constructor
	* 
	* do nothing
	*/
	function Subhand()
	{}

	/**
	* Num of Changer
	* 
	* Get Number of changer (used on fivecards)
	*
	* @return int
	*/
	function numOfChanger()
	{
		//hand=".$this->curr_hand." and 
		$query = "select count(distinct(player)) as n from pkr_subhand WHERE game=".$this->curr_game." and response = '".CHANGE."'";
		$n = $GLOBALS['mydb']->select($query);
		$n = $n[0]['n'];
		return $n;
	}
	
	/**
	* Get Data Last SubHand
	* 
	* Get idsubhand,usr,seat_number,sh.player as player,status,type_subhand,response,time from Last SubHand 
	*
	* @param int $last_idhand
	* @return array
	*/
	function getDataLastSubHand($last_idhand)
	{
		$query = "select idsubhand,usr,seat_number,sh.player as player,status,type_subhand,response,time from pkr_subhand sh left join pkr_player p on sh.player=p.idplayer where idtable=".$this->curr_table." and hand=".$last_idhand." and game=".$this->curr_game." order by idsubhand desc limit 1";
		return $GLOBALS['mydb']->select($query);
	}
	
	/**
	* Create SubHand
	* 
	* Create a subhand line on database
	*
	* @param int $player
	* @param int $seat_number
	* @param string $type_subhand
	*/
	function createSubHand($player, $seat_number, $type_subhand)
	{
		if (!isset($player)) 
			$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","createSubHand()","Srv ".$this->curr_plr_server,"ERROR PLAYER [SEAT ".$seat_number."] DOES NOT EXISTS !");
		
		if (isset($this->curr_game) && isset($this->curr_hand)) {
			$query = "insert into pkr_subhand (hand, idtable, game, player, seat_number, time, type_subhand) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$params = array ($this->curr_hand, $this->curr_table, $this->curr_game, $player, $seat_number, time(), $type_subhand);
			$GLOBALS['mydb']->insert($query,$params);
		}
	}
	
	/**
	* Check Last Response Action
	* 
	* Check if last player action was allowed
	*
	* @param string $user_response
	* @return bool
	*/
	function checkLastRespAction($user_response)
	{
		if (!isset($this->curr_game) && (($user_response == SITOUT) || ($user_response == PKR_ENDGAME)))
			return true;
			
		if ( (!isset($this->curr_table)) || (!isset($this->curr_player)) || (!isset($user_response)) )
			return false;
			
		$query = "select status from pkr_subhand where (idtable = '".$this->curr_table."') and (game = '".$this->curr_game."') and (player = '".$this->curr_player."') and (response = '".$user_response."') order by idsubhand desc limit 1";
		$val = $GLOBALS['mydb']->select($query);
		$val = $val[0]["status"];
		if (isset($val)) 
		{			
			if ($val == 1)
				return true;
			else
				return false;
		}
		else
			return true;		
	}
	
	/**
	* Update SubHand
	* 
	* Update a subhand
	*
	* @param string $response
	* @return bool
	*/
	function updateSubHand($response)
	{
		$query = "select status, response from pkr_subhand where idsubhand=".$this->curr_subhand." and hand=".$this->curr_hand;
		$res = $GLOBALS['mydb']->select($query);
		$res = $res[0];
		
		if (($res["status"] == 0) && ($res["response"] == null)) {	
			$query = "update pkr_subhand set status=?, response=?, time=? where idsubhand=? and hand=?";
			$params = array (1, $response, time(), $this->curr_subhand, $this->curr_hand);
			$GLOBALS['mydb']->update($query,$params);
			return true;		
		}
		else
			return false;
	}
	
	/**
	* Get Last SubHand
	* 
	* Get idsubhand,seat_number,time,player,status,response from Last SubHand
	*
	* @return array
	*/
	function getLastSubHand()
	{
		//if ((isset($this->curr_hand)) && (isset($this->curr_game))) {
		if (isset($this->curr_game)) {
			//$query = "select idsubhand,seat_number,time,player,status,response from pkr_subhand where idtable=".$this->curr_table." and hand=".$this->curr_hand." and game=".$this->curr_game." order by idsubhand desc limit 1";
			$query = "select idsubhand,seat_number,time,player,status,response from pkr_subhand where idtable=".$this->curr_table." and game=".$this->curr_game." order by idsubhand desc limit 1";
			$lastid = $GLOBALS['mydb']->select($query);
			return $lastid;
		}
	}		
	
	/**
	* Get Type SubHand
	* 
	* Get Type SubHand
	*
	* @return string
	*/
	function getTypeSubHand()
	{
		if (isset($this->curr_subhand))	{
			$query = "select type_subhand from pkr_subhand where idsubhand=".$this->curr_subhand;
			$type = $GLOBALS['mydb']->select($query);
			$type = $type[0]['type_subhand'];
			return $type;		
		}
	}
}
?>
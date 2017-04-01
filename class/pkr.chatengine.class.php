<?php
require("../class/pkr.game.class.php");

/**
 * ChatEngine Class
 *
 * Class Chat Engine
 * 
 */
Class ChatEngine extends Game
{
	var $curr_msg;
	
	/**
	* Constructor
	* 
	* do nothing
	*/	
	function ChatEngine()
	{}
	
	/**
	* Set Current Message
	* 
	* Set Current Message of the chat
	*
	* @param int $idmsg
	*/
	function setCurrMsg($idmsg)
	{
		$this->curr_msg = $idmsg;
	}
		
	/**
	* Get Data Chat
	* 
	* Get Data Chat and send it to the client by send_data global function
	*/
	function getDataChat()
	{
		$rows = array();
		$rows['chat'] = $this->getChatMsg();		
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
	* Get Chat Messages
	* 
	* Get all last data messages
	*
	* @return array
	*/	
	function getChatMsg()
	{
		$a = "\\\''";
		$b = "''";
		
		if ($this->curr_msg>0)
			$query = "select idmsg,COALESCE(usr, '#Dealer') as usr,REPLACE(msg, '".$a."', '".$b."') as msg,time,type from pkr_msg m left join pkr_player p on m.player=p.idplayer where idmsg>".$this->curr_msg." and idtable=".$this->curr_table." order by idmsg desc";
		else
			$query = "select idmsg,COALESCE(usr, '#Dealer') as usr,REPLACE(msg, '".$a."', '".$b."') as msg,time,type from pkr_msg m left join pkr_player p on m.player=p.idplayer where idtable=".$this->curr_table." order by idmsg desc limit 10";
			
		$msgs = $GLOBALS['mydb']->select($query);
		
		return $msgs;
	}
	
	
	/**
	* Insert Chat Message
	* 
	* Insert chat message into database. The message could be type 0 system or 1 player message
	*
	* @param string $msg
	* @param int $type
	* @param int $plr
	*/
	function insChatMsg($msg, $type, $plr = null, $return = false)
	{		
		if ((isset($msg)) && ($msg != "undefined"))	{
			
			$new_msg = clean($msg);
		
			if (isset($this->curr_game)) {
			
				// type 0 system e 1 player
				if (!isset($plr))
				{
					$query = "INSERT DELAYED INTO pkr_msg (idtable, game, player, time, msg, type) VALUES (?, ?, ?, ?, ?, ?)";
					$params = array ($this->curr_table, $this->curr_game, $this->curr_player, time(), $new_msg, $type);
				}
				else 
				{
					$query = "INSERT DELAYED INTO pkr_msg (idtable, game, player, time, msg, type) VALUES (?, ?, ?, ?, ?, ?)";
					$params = array ($this->curr_table, $this->curr_game, $plr, time(), $new_msg, $type);
				}
				$GLOBALS['mydb']->insert($query,$params);
			
			}
			else
		    {		 
				// type 0 system e 1 player
				if (!isset($plr))
				{
					$query = "INSERT DELAYED INTO pkr_msg (idtable, game, player, time, msg, type) VALUES (?, ?, ?, ?, ?, ?)";
					$params = array ($this->curr_table, 0, $this->curr_player, time(), $new_msg, $type);
				}
				else 
				{
					$query = "INSERT DELAYED INTO pkr_msg (idtable, game, player, time, msg, type) VALUES (?, ?, ?, ?, ?, ?)";
					$params = array ($this->curr_table, 0, $plr, time(), $new_msg, $type);
				}
				$GLOBALS['mydb']->insert($query,$params);		       
			    
		    }	    
		}
		
		if ($return) 
		{
			$rows = array();
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
	}
}

?>
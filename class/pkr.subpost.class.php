<?php

/**
 * SubPost Class 
 *
 * Class that Manage SubPost
 * 
 */
class Subpost
{
	var $curr_subpost;
	
	/**
	* Constructor
	* 
	* do nothing
	*/	
	function Subpost()
	{}

	/**
	* Get All Post
	* 
	* Get all post from current table
	*
	* @return array
	*/
	function getAllPost()
	{		
		$query = "select stakes_min, stakes_max from pkr_table where idtable = ".$this->curr_table;
		$result = $GLOBALS['mydb']->select($query);
		
		$row['stakes_min'] = $result[0]["stakes_min"];
		$row['stakes_max'] = $result[0]["stakes_max"];
		
		$query = "select sum(post) as maxpost from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." and idpost=".$this->curr_post." group by seat order by maxpost desc limit 1";
		$row["maxhandpost"] = $GLOBALS['mydb']->select($query);
		$row["maxhandpost"] = $row["maxhandpost"][0]['maxpost'];		
		
		if (!isset($row["maxhandpost"]))
			$row["maxhandpost"] = 0;	
		
		$query = "select sum(post) as sumpost from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." and idpost=".$this->curr_post." and player=".$this->curr_player;
		$row["mytothandpost"] = $GLOBALS['mydb']->select($query);
		$row["mytothandpost"] = $row["mytothandpost"][0]['sumpost'];
		
		if (!isset($row["mytothandpost"]))
			$row["mytothandpost"] = 0;
		
		return $row;		
	}		
	
	/**
	* Must Set EndRound Seat
	* 
	* Return the seat that is endround seat
	*
	* @return int
	*/
	function mustSetEndRound_Seat($curr_seat, $next_seat, $user_response, $isallin)
	{
		if (
			( ($this->curr_endround_seat == 0) && ( ($user_response == FOLD) || ($user_response == SITOUT) ) ) 
			|| 
			( ( ($this->curr_endround_seat > 0) && ($this->curr_endround_seat == $curr_seat) ) && ( ($user_response == FOLD) || ($user_response == SITOUT) ) )
			||
		    ( ($this->curr_endround_seat > 0) && ($this->curr_endround_seat == $curr_seat) && ($user_response == CALL) && ($isallin) ) 
		   )
		 	return $next_seat;
		else if (($this->curr_endround_seat == 0) || ($user_response == BET) || ($user_response == RAISE)) 
		{
			if ($isallin)
				return $next_seat;
			else
				return $curr_seat;
		}
		else
			return null;
		
	}
	
	/**
	* Are Sum Equals
	* 
	* Check if sums of hand are equals
	*
	* @param int $nfolder
	* @param int $nallin
	* @return bool
	*/
	function areSumEquals($nfolder, $nallin)
	{		
		$somme_uguali = true;
				
		$query = "select seat, count(*) as n, sum(post) as sum, max(isallin) as isallin from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." and idpost=".$this->curr_post." and player not in (select player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game.") and player in (select player from pkr_seat where idtable=".$this->curr_table." and status=".PLAYING.") group by seat order by sum desc";
		$arr = $GLOBALS['mydb']->select($query);		
				
		if (isset($arr))		
			$nposts = count($arr);
		else 
			$nposts = 0;	
			
		$first_sum = $arr[0]['sum'];
		for ($i = 1; $i<$nposts; $i++)
		{			
			if (($arr[$i]['sum']==$first_sum) || (($arr[$i]['sum']<=$first_sum) && ($arr[$i]['isallin']==1))) 
			{
				//nothing
			}
			else
			{
				$somme_uguali = false;
				break;							
			}			
		}

		return $somme_uguali;		
	}

	/**
	* Get All Post Board
	* 
	* Return all post of board of current game and current table
	*
	* @param bool $asArray
	* @return array
	*/
	function getAllBoardPost($asArray = false)
	{
		//All old hand sum money on board
		$query = "select sum(post) as post from pkr_typepost where idtable=".$this->curr_table." and post>0 and game=".$this->curr_game." and idpost<".$this->curr_post;
		$rows = $GLOBALS['mydb']->select($query);
		$old_hand_post = $rows[0]['post'];
				
		//Sum of folder/away user's money for current post only
		$query = "select sum(post) as post from pkr_subpost where idtable=".$this->curr_table." and post>0 and game=".$this->curr_game." and idpost=".$this->curr_post." and player in (select player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game." and idpost=".$this->curr_post.")";
		$rows = $GLOBALS['mydb']->select($query);
		$folder_post = $rows[0]['post'];		
		
		$sums = array();
		$temp = array();
		$plrs = array();
		$allin = array();	
		
		//All post about this hand only and about Playing players
		$query = "select post,seat,player,isallin from pkr_subpost where idtable=".$this->curr_table." and post>0 and game=".$this->curr_game." and idpost=".$this->curr_post." and player in (select player from pkr_seat where idtable=".$this->curr_table." and status>=".PLAYING.") and player not in (select player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game.") order by idsubpost";
		$rows = $GLOBALS['mydb']->select($query);
				
		if ((!$asArray) && (!isset($rows))) return 0;
		
		if (isset($rows)) {
		
			foreach ( $rows as $n => $item)
			{
				$sums[$item["seat"]]+=$item["post"];
				$plrs[$item["seat"]]=$item["player"];
				$allin[$item["seat"]]=$item["isallin"];
			}
			
			if (count($sums)>1)	
				asort($sums);
	
			$i = 0;
			while (!$this->value_arr_equals($sums))
			{
				$minsum = $sums[key($sums)];						
				foreach ($sums as $seat => $sum)
				{	
					if ($sum <= $minsum) {
						$sums[$seat] = $minsum;
					}
					else 
					{
						// only for allin and there is an allin check rest
						$sums[$seat] = $minsum;
						
						if ($sum - $minsum > 0) {
							$temp[$seat] = $sum - $minsum;
							$temp[$seat] = number_format($temp[$seat],2,'.','');
						}
					}
				}
				$i++;
			}		
		}
		
		if ($folder_post>0) {
			$folder_post = number_format($folder_post,2,'.','');
			$sums[BOARD_PLAYER] = $folder_post;
		}
		if ($old_hand_post>0) {
			$old_hand_post = number_format($old_hand_post,2,'.','');
			$sums[BOARD_PLAYER] += $old_hand_post;
		}		
		
		if ($asArray) 
		{
			$res = array();
			$res['sums'] = $sums;
			$res['rest'] = $temp;
			$res['plrs'] = $plrs;
		
			unset($sums);
			unset($plrs);
			unset($temp);
			unset($allin);
			
			return $res;				
		} 
		else 
		{
			$sum = array_sum($sums);

			unset($sums);
			unset($plrs);
			unset($temp);
			unset($allin);						
			
			return $sum;
		}
	}			
	
	/**
	* Get Board Post
	* 
	* Return board post of current game and current table
	*
	* @param int $npot
	* @return array
	*/
	function getBoardPost($npot)
	{
		$query = "select sum(post) as boardpost from pkr_typepost where idtable=".$this->curr_table." and game=".$this->curr_game." and number=".$npot;
		$row["boardpost"] = $GLOBALS['mydb']->select($query);
		$row["boardpost"] = $row["boardpost"][0]['boardpost'];
		
		if (!isset($row["boardpost"]))
			$row["boardpost"] = 0.00;
		
		return $row["boardpost"];
	}	
		
	/**
	* Get Max N Pot
	* 
	* Return the max pot of this hand
	*
	* @return double
	*/
	function getMaxNpot()
	{
		$query = "select max(number) as number from pkr_typepost where idtable=".$this->curr_table." and game=".$this->curr_game;
		$val = $GLOBALS['mydb']->select($query);
		return $val[0]["number"];
	}
	
	/**
	* Get N Pot Players
	* 
	* Return number of pot of this hand
	*
	* @param int $npot
	* @return int
	*/
	function getNPotPlrs($npot)
	{
		$query = "select count(*) as n from pkr_typepost where idtable=".$this->curr_table." and game=".$this->curr_game." and number=".$npot;
		$val = $GLOBALS['mydb']->select($query);
		return $val[0]["n"];
	}
	
	/**
	* Last Allin
	* 
	* Return the last allin of this hand
	*
	* @return int
	*/
	function LastAllIn()
	{							
		$query = "select count(*) as n from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." and idpost = ".$this->curr_post." and isallin = 1";
		$n = $GLOBALS['mydb']->select($query);
		$n = $n[0]["n"];
		return $n;		
	}	
	
	/**
	* Get Subpost Seat Ordered
	* 
	* Return array of pot ordered by seats
	*
	* @return array
	*/
	function getSubPostSeatOrdered()
	{
		//$query = "select * from pkr_subpost where idtable=".$this->curr_table." and idpost=".$this->curr_post." order by seat";
		$query = "select sum(post) as post,seat from pkr_subpost where idtable=".$this->curr_table." and idpost=".$this->curr_post." and game=".$this->curr_game." group by seat order by idsubpost";
		$rows = $GLOBALS['mydb']->select($query);
		return $rows;
	}
	
	/**
	* Create Subpost
	* 
	* Create Subpost
	*
	* @param int $seat_number
	* @param double $post
	* @param bool $isAllIn
	*/
	function createSubPost($seat_number, $post, $isAllIn = false)
	{
		if (isset($this->curr_game) && isset($this->curr_post)) 
		{		
			/*$query = "select seat from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." and idpost = ".$this->curr_post." order by idsubpost desc limit 1";
			$last_seat = $GLOBALS['mydb']->select($query);
			$last_seat = $last_seat[0]["seat"];			
							
			if ($last_seat != $seat_number) {*/
			
				if ($isAllIn) {
					$query = "insert into pkr_subpost (idpost, idtable, game, player, seat, post, isallin) VALUES (?, ?, ?, ?, ?, ?, ?)";
					$params = array ($this->curr_post, $this->curr_table, $this->curr_game, $this->curr_player, $seat_number, $post, 1);
				}
				else {
					$query = "insert into pkr_subpost (idpost, idtable, game, player, seat, post) VALUES (?, ?, ?, ?, ?, ?)";
					$params = array ($this->curr_post, $this->curr_table, $this->curr_game, $this->curr_player, $seat_number, $post);
				}				
				$GLOBALS['mydb']->insert($query,$params);
				
			//}		
		}		
	}
	
	/**
	* Update Subpost
	* 
	* Update Subpost
	*
	* @param int $post
	*/
	function updateSubPost($post)
	{
		$query = "update pkr_subpost set post=? where idsubpost=? and post=?";
		$params = array ($post, $this->curr_subpost, $this->curr_post);
		$GLOBALS['mydb']->update($query,$params);
	}
	
	/**
	* Get Last Subpost
	* 
	* Get last subpost and return last idinserted
	*
	* @return int
	*/
	function getLastSubPost()
	{
		if ((isset($this->curr_post)) && (isset($this->curr_game))) {
			$query = "select idsubpost from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." and post=".$this->curr_post." order by idsubpost desc limit 1";
			$lastid = $GLOBALS['mydb']->select($query);
			$lastid = $lastid[0]['idsubpost'];
			return $lastid;
		}
	}		
	
	/**
	* Get Type Subpost
	* 
	* Get Type Subpost
	*
	* @return string
	*/
	function getTypeSubPost()
	{
		if (isset($this->curr_subpost))	{
			$query = "select type_subpost from pkr_subpost where idtable=".$this->curr_table." and idsubpost=".$this->curr_subpost;
			$type = $GLOBALS['mydb']->select($query);
			$type = $type[0]['type_subpost'];		
			return $type;		
		}
	}	
	
	/**
	* Get Number Subpost
	* 
	* Get count of line of subpost inserted
	*
	* @return int
	*/
	function getNumSubPost() {
		$query = "select count(*) as n from pkr_subpost s where post>0 and idtable=".$this->curr_table." and game=".$this->curr_game." and idpost=".$this->curr_post;
		$val = $GLOBALS['mydb']->select($query);
		$val = $val[0]['n'];
		return $val;
	}	
}
?>
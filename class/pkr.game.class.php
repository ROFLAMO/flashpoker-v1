<?php
require("../class/pkr.hand.class.php");

/**
 * Game Class 
 *
 * Class that Manage Game
 * Extends Hand Class
 * 
 */
class Game extends Hand 
{
	var $curr_game;	
	var $curr_d;
	var $curr_endround_seat;
	var $curr_endround_nextseat;
	var $curr_end;
	var $curr_all_allin;
	var $type_game;	
	
	/**
	* Constructor
	* 
	* do nothing
	*/				
	function Game()
	{}
	
	/**
	* Get Data Game
	* 
	* Get Data of current Game
	*
	* @return array
	*/	
	function getDataGame()
	{
		if (isset($this->curr_game)) 
		{
			$query = "select * from pkr_game where idtable=".$this->curr_table." and idgame=".$this->curr_game;
			$val = $GLOBALS['mydb']->select($query);	
			$val = $val[0];	
			return $val;		
		}
	}
	
	/**
	* Update Game Pot
	* 
	* set game tot_pot
	*
	* @param double $post
	*/	
	function updateGamePot($post)
	{
		if (isset($this->curr_game)) {
			$query = "update pkr_game set tot_pot='".number_format($post, 2, '.', '')."' where idgame=?";
			$params = array ($this->curr_game);
			$GLOBALS['mydb']->update($query,$params);	
		}
	}
	
	/**
	* Create Game
	* 
	* Create a new Game.
	*
	* @param int $curr_d
	* @return bool
	*/
	function createGame($curr_d)
	{
		/*
		$query = "select idgame from pkr_game where idtable=".$this->curr_table." and end = 0 order by idgame desc limit 1";
		$curr_idgame = $GLOBALS['mydb']->select($query);
		$curr_idgame = $curr_idgame[0]['idgame'];
		
		if (!isset($curr_idgame)) {
		*/
			
			$query = "insert into pkr_game (idtable, d, endround_seat) VALUES (?, ?, ?)";
			$params = array ($this->curr_table, $curr_d, 0);
			$GLOBALS['mydb']->insert($query,$params);
			
			return true;
		/*
		}
		else
		{
			return false;
		}
		*/
	}	

	/**
	* Set End Game
	* 
	* Set to end a game
	*
	* @param bool $inschatmsg
	*/
	function setEndGame($inschatmsg = true)
	{
		if (isset($this->curr_game)) 
		{			
			$g = $this->curr_game;
			
			$query = "select end from pkr_game where idgame=".$g;
			$end = $GLOBALS['mydb']->select($query);
			$end = $end[0]["end"];
			
			if ($end == 0) 
			{
				$query = "update pkr_game set end = ? where idgame = ?";
				$params = array (1, $g);
				$GLOBALS['mydb']->update($query,$params);
				$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","setEndGame()","Srv ".$this->curr_plr_server,"# END GAME #".$g."<br>");
				if ($inschatmsg)
					$this->insChatMsg(printf($this->__lang['chat_end_game_text'],$g), MSG_FOR_SYSTEM, 0);
			}
		}
	}	
	
	/**
	* Reset Game
	* 
	* Reset a game and insert in chat a system message
	*/
	function resetGame()
	{
		$this->insChatMsg("[Game #".$this->curr_game."] Cancelled", MSG_FOR_SYSTEM, 0);
		
		$this->reset_awayout();
		$this->sittingidle();
		$this->setEndGame();
		
		$query = "select idsubpost,seat,player,sum(post) as post from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." group by player order by idsubpost desc";
		$data = $GLOBALS['mydb']->select($query);
		
		foreach ($data as $n => $values)
		{
			$this->updateVMoney($values['post'], 'sum', $values['player']);
			
			$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","resetGame()","Srv ".$this->curr_plr_server,"GAME RESET -> $".$values['post']." RETURNED TO SEAT ".$values['seat']);
			
			$this->insChatMsg("$".$values['post']." returned to seat ".$values['seat'], MSG_FOR_SYSTEM, 0);
		}

		$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","resetGame()","Srv ".$this->curr_plr_server,"GAME #".$this->curr_game." FORCED RESET");
		$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","resetGame()","Srv ".$this->curr_plr_server,"ENDGAME R.12");
	}		
	
	//######################################################################
	// PLAYER STATUS CHANGE ENGINE
	//######################################################################	
	
	/**
	* Away
	* 
	* set to AWAY current seat of current table and current player
	*
	* @param int $curr_seat
	*/
	function away($curr_seat)
	{
		$query = "update pkr_seat set status = ? where idtable = ? and seat_number = ? and player = ?";
		$params = array (AWAY, $this->curr_table, $curr_seat, $this->curr_player);
		$GLOBALS['mydb']->update($query, $params);
	}
	
	/**
	* Awayout
	* 
	* set to AWAYOUT current seat of current table and current player
	*
	* @param int $curr_seat
	*/
	function awayout($curr_seat)
	{
		$query = "update pkr_seat set status = ? where idtable = ? and seat_number = ? and player = ?";
		$params = array (AWAYOUT, $this->curr_table, $curr_seat, $this->curr_player);
		$GLOBALS['mydb']->update($query, $params);
	}
	
	/**
	* Idle
	* 
	* set to IDLE a PLAYING current player of current table
	*/
	function sittingidle()
	{
		$query = "update pkr_seat set status = ? where idtable = ? and status = ?";
		$params = array (SITTINGIDLE, $this->curr_table, PLAYING);
		$GLOBALS['mydb']->update($query,$params);			
	}	
	
	/**
	* Playing to Away
	* 
	* set to AWAY a PLAYING player of current table if there is a timeout, PKR_PLAYING_TIMEOUT
	*/
	function playing2away()
	{
		$query = "update pkr_seat set status = ? where idtable = ? and status = ? and player > 0 and player in (select idplayer from pkr_alive where idtable = ? and alive < DATE_SUB(NOW(),INTERVAL ? SECOND))";
		$params = array (AWAY, $this->curr_table, PLAYING, $this->curr_table, PKR_PLAYING_TIMEOUT);
		$GLOBALS['mydb']->update($query,$params);			
	}
	
	/**
	* Sitting to Awayout
	* 
	* set to AWAYOUT a SITTING player of current table if there is a timeout, 30 sec of timeout
	*/
	function sitting2awayout()
	{
		$query = "update pkr_seat set status = ? where idtable = ? and status = ? and player in (select idplayer from pkr_alive where idtable = ? and alive < DATE_SUB(NOW(),INTERVAL ? SECOND))";
		$params = array (AWAYOUT, $this->curr_table, SITTING, $this->curr_table, 30);
		$GLOBALS['mydb']->update($query,$params);			
	}	
	
	/**
	* Sitting
	* 
	* set to SITTING current seat of current table and current player
	*
	* @param int $curr_seat
	*/
	function sitting($curr_seat)
	{
		$query = "update pkr_seat set status = ? where idtable = ? and seat_number = ? and player = ?";
		$params = array (SITTING, $this->curr_table, $curr_seat, $this->curr_player);
		$GLOBALS['mydb']->update($query, $params);
	}
	
	/**
	* Sitting
	* 
	* set to IDLE current seat of current table and current player that are SITTING
	*
	* @param int $curr_seat
	*/
	function sitting2idle($curr_seat)
	{
		$query = "update pkr_seat set status = ? where idtable = ? and seat_number = ? and player = ? and status = ?";
		$params = array (SITTINGIDLE, $this->curr_table, $curr_seat, $this->curr_player, SITTING);
		$GLOBALS['mydb']->update($query, $params);
	}	
	
	/**
	* Away to Awayout
	* 
	* set to AWAYOUT an AWAY current player of current table if there is a timeout, PKR_AWAY_TIMEOUT
	*
	* @param bool $instant_awayout
	*/
	function away2awayout($instant_awayout = false)
	{
		if (!$instant_awayout) {
			$query = "update pkr_seat set status = ? where idtable = ? and status = ? and player in (select idplayer from pkr_alive where idtable = ? and alive < DATE_SUB(NOW(),INTERVAL ? SECOND))";
			$params = array (AWAYOUT, $this->curr_table, AWAY, $this->curr_table, PKR_AWAY_TIMEOUT);
			$GLOBALS['mydb']->update($query,$params);
		}
		else
		{
			$query = "update pkr_seat set status = ? where idtable = ? and status = ?";
			$params = array (AWAYOUT, $this->curr_table, AWAY);
			$GLOBALS['mydb']->update($query,$params);			
		}
	}
	
	/**
	* Away to Idle
	* 
	* set to IDLE an AWAY current player of current table
	*/
	function away2sittingidle()
	{
		$query = "update pkr_seat set status = ? where idtable = ? and status = ?";
		$params = array (SITTINGIDLE, $this->curr_table, AWAY);
		$GLOBALS['mydb']->update($query,$params);
	}	
	
	/**
	* Reset Awayout
	* 
	* set to 0 an AWAYOUT current player of current table
	*/
	function reset_awayout()
	{	
		$query = "update pkr_seat set status = ?, player = ? where idtable = ? and (status = ? or (status = ? and player = ?))";
		$params = array (0, 0, $this->curr_table, AWAYOUT, AWAY, $this->curr_player);
		$GLOBALS['mydb']->update($query,$params);	
	}

	/**
	* Idle to Playing
	* 
	* set to PLAYING an IDLE current player of current table
	*/	
	function sittingidle2playing()
	{		
		$query = "update pkr_seat set status = ? where idtable = ? and status = ?";
		$params = array (PLAYING, $this->curr_table, SITTINGIDLE);
		$GLOBALS['mydb']->update($query,$params);
	}
	
	/**
	* Force Reset to Away
	* 
	* set to 0 current player of current table if there is a timeout, PKR_AWAY_TIMEOUT
	*
	* @param bool $instant_awayout
	*/
	function force_resetaway()
	{
		$query = "update pkr_seat set status = ?, player = ? where idtable = ?";
		$params = array (0, 0, $this->curr_table, $this->curr_player);
		$GLOBALS['mydb']->update($query,$params);		
	}
	
	/**
	* Update Status Table
	* 
	* reset the AWAYOUT players, set to AWAYOUT the AWAY timedout and to AWAY the PLAYING timedout
	*/
	function updateStatusTables()
	{
		//AWAYOUT --> 0
		$this->reset_awayout();			
		//PKR_AWAY_TIMEOUT
		$this->away2awayout();		
		//PKR_PLAYING_TIMEOUT
		$this->playing2away();
		//SITTING --> 0
		$this->sitting2awayout();
	}	
	
	//######################################################################
	// PLAYER STATUS CHANGE ENGINE
	//######################################################################	
		
	/**
	* Insert Winner
	* 
	* insert a winner into the database
	*/	
	function insertWinner($player, $seat, $rank, $best5, $high, $high_s, $card1, $seed1, $card2, $seed2, $card3, $seed3, $card4, $seed4, $card5, $seed5, $pot = 0, $number_of_typepot = 1)
	{
		if (isset($this->curr_game)) {
			$query = "INSERT INTO pkr_game_win (idtable, game, player, seat, rank, best5, high, high_s, card1, seed1, card2, seed2, card3, seed3, card4, seed4, card5, seed5, pot, number) VALUES 
											   (?, 			?, 		?, 	  ?, 	?, 	   ?,    ?,      ?,     ?,     ?,     ?,     ?,     ?,     ?,     ?,     ?,     ?,     ?,   ?,      ?)";
			$params = array ($this->curr_table, $this->curr_game, $player, $seat, $rank, $best5, $high, $high_s, $card1, $seed1,  $card2, $seed2,  $card3, $seed3,  $card4, $seed4,  $card5, $seed5, $pot, $number_of_typepot);
			$GLOBALS['mydb']->insert($query,$params);			
		}
	}	
	
	/**
	* Insert Folder
	* 
	* Insert a folder player into the database
	*/
	function insertFolder($curr_seat)
	{			
		if (isset($this->curr_game) && isset($this->curr_player) && isset($this->curr_post)) {
			$query = "INSERT INTO pkr_game_fold (idtable, game, player, seat, idpost) VALUES (?, ?, ?, ?, ?)";
			$params = array ($this->curr_table, $this->curr_game, $this->curr_player, $curr_seat, $this->curr_post);
			$GLOBALS['mydb']->insert($query,$params);
		}
	}		
	
	/**
	* Postblinds Sitout Games
	* 
	* reset game when hand status is Postblinds
	*/
	function postblindsSitoutGame()
	{
		$query = "select idsubpost,seat,s.player as player,sum(post) as post from pkr_subpost s right join pkr_post h on s.post=h.idpost where s.idtable=".$this->curr_table." and s.game=".$this->curr_game." group by s.player order by s.idsubpost desc";
		$data = $GLOBALS['mydb']->select($query);
		
		if (isset($data)) {
			foreach ( $data as $n => $values)
			{
				$this->updateVMoney($values['post'], 'sum', $values['player']);
				$this->insChatMsg("Zwrot ".$values['post'].PKR_CURRENCY_SYMBOL." za postblinds opponents", MSG_FOR_SYSTEM, $values['player']);
				$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","postblindsSitoutGame()","Srv ".$this->curr_plr_server,"RETURNED TO SEAT ".$values['seat'].", ".$values['post'].PKR_CURRENCY_SYMBOL." FOR SITOUT POSTBLINDS OPPONENTS ");
			}
		}
		
		$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","postblindsSitoutGame()","Srv ".$this->curr_plr_server,"ENDGAME R.00");
		
		$this->reset_awayout();
		$this->sittingidle();		
		$this->setEndGame();
	}
	
	/**
	* Get Last Game
	* 
	* Get idgame, end, d, endround_seat, endround_nextseat, all_allin from current game
	*
	* @return array
	*/
	function getLastGame()
	{
		$query = "select SQL_CACHE idgame, end, d, endround_seat, endround_nextseat, all_allin from pkr_game where idtable=".$this->curr_table." and end = 0 order by idgame desc limit 1";
		$last_idgame = $GLOBALS['mydb']->select($query);
		//$last_idgame = $last_idgame[0]['idgame'];		
		return $last_idgame;
	}
	
	/**
	* Check Are Winners
	* 
	* check if there are winners of this game
	*
	* @return bool
	*/
	function checkAreWinners()
	{
		if (isset($this->curr_game)) {
			$query = "select count(*) as n from pkr_game_win where idtable=".$this->curr_table." and game=".$this->curr_game;
			$n = $GLOBALS['mydb']->select($query);
			$n = $n[0]["n"];
			
			if ($n>0)
				return true;
			else
				return false;
		} else
			return false;
		
	}	

	//#########################################################################################################
	// START SERVER ENGINE
	//#########################################################################################################
			
	/**
	* Start First Game
	* 
	* function that manage the start of first (or in general a) game.
	* If there are minimun 2 player idle the game starts
	*
	* @return array
	*/
	function startFirstGame()
	{			
		if ( (($this->n_sittingidle_plrs>=2) && ($this->n_playing_plrs == 0)) ||
			(($this->n_sittingidle_plrs>=1) && ($this->n_playing_plrs == 1)) )
		{			
			if (!isset($this->curr_game))
			{								
				$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","startFirstGame()","Srv ".$this->curr_plr_server,"################ START FIRST GAME #".$this->curr_game." ###############");
					
				$this->reset_awayout();
				$this->checkMoney();				
				$this->sittingidle2playing();
				
				reset($this->type_hands);
				reset($this->type_subhands);
				$curr_type_hand = key($this->type_hands);
				$curr_type_subhand = key($this->type_subhands);
								
				//Se il button ce l'ha il primo
				$curr_d = $this->curr_arr_si_plrs[0]["seat_number"];
				
				$this->n_playing_plrs = $this->getPlrNumbers();
				
				$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","startFirstGame()","Srv ".$this->curr_plr_server,$this->n_playing_plrs." PLAYERS ON TABLE");
				
				if ($this->n_playing_plrs>=2)
				{
					//Il giocatore a sinistra del button parla
					$curr_seat_number = $this->curr_arr_si_plrs[(count($this->curr_arr_si_plrs)-1)]["seat_number"];
									
					//$curr_seat = $this->curr_arr_plrs[count($this->curr_arr_plrs)]["seat_number"];
					$player = $this->curr_arr_si_plrs_seat_ordered[$curr_seat_number]["player"];
				}
				else
				{
					//Il giocatore a sinistra del button parla
					$curr_seat_number = $this->curr_arr_si_plrs[0]["seat_number"];
									
					//$curr_seat = $this->curr_arr_plrs[count($this->curr_arr_plrs)]["seat_number"];
					$player = $this->curr_arr_si_plrs_seat_ordered[$curr_seat_number]["player"];
				}

				if (!isset($player)) 
					return;
				
				if ($this->createGame($curr_d))
				{
					$data_game = $this->getLastGame();	
					
					$this->curr_game = $data_game[0]['idgame'];
					
					unset($data_game);
					
					$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","startFirstGame()","Srv ".$this->curr_plr_server,"CREATE GAME ".$this->curr_game);
					
					$this->createHand($curr_type_hand);
									
					$this->curr_hand = $this->getLastHand();
					
					$this->createSubHand($player, $curr_seat_number, $curr_type_subhand);
					
					//creo il primo post !
					$this->createPost(FIRST);
					
					$rows["response"]="OK";			
				
				}
				else 
					$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","startFirstGame()","Srv ".$this->curr_plr_server,"GAME JUST CREATED");
					
				return $rows;	
			}
		}		
	}	
	
	/**
	* Get Player Status
	* 
	* Get status of current player seat on current table
	* @return int
	*/	
	function getPlayerStatus($seat, $idplr = null)
	{
		if (!isset($idplr))
			$idplr = $this->curr_player;
		
		// controllo se l'ultima mano è proprio di qualcuno che è OUT e cambio la mano!!!
		$query = "select status from pkr_seat where idtable=". $this->curr_table ." and seat_number = ". $seat ." and player=". $idplr;
		$status = $GLOBALS['mydb']->select($query);
		$status = $status[0]["status"];
		return $status;
	}
	
	/**
	* Change Sub Hand Seat
	* 
	* Function called if a player go to AWAY and close his client. 
	* So this function do an action as it be that player.
	*/
	function changeSubHandSeat()
	{
		if ($_SESSION["tbl_".$this->curr_table]["entered"]) return;
		$_SESSION["tbl_".$this->curr_table]["entered"]=true;	

		if (
			($this->n_playing_plrs > 1) && 
			($this->curr_plr_server > 0) &&
			($this->curr_player != $this->curr_plr_server)
			)
		{
			$_SESSION["tbl_".$this->curr_table]["entered"]=false;
			return;
		}
				
		$this->updateStatusTables();
		
		if (!$_SESSION["tbl_".$this->curr_table]['in_action']) 
		{
			if (!$_SESSION["tbl_".$this->curr_table]['is_guest']) 
			{
				if ((isset($this->curr_player)) && ($this->curr_player>0))
				{					
					if (isset($this->curr_game))
					{														
						// Se ci sono almeno 2 giocatori giocanti
						if ($this->n_playing_plrs > 1)
						{
							//Dati ultima subhand
							$idplr = $this->lastsubhand[0]["player"];
							
							if ( (isset($idplr)) && (isset($this->lastsubhand)) )
							{						
								$seat = $this->lastsubhand[0]["seat_number"];													
								$idsh = $this->lastsubhand[0]["idsubhand"];
								$shstatus = $this->lastsubhand[0]["status"];
								$response = $this->lastsubhand[0]["response"];
								$sh_time = $this->lastsubhand[0]["time"];
								$current_timeout = $this->now - $sh_time;
								$isTimeout = ($current_timeout > PKR_GENERIC_TIMEOUT);
								$isInitTimeout = $isTimeout && ($current_timeout > PKR_STALL_TIMEOUT);						
								
								$status = $this->getPlayerStatus($seat, $idplr);
									
								if ($shstatus == 0)
								{
									//Se a chi tocca non ha lo stato PLAYING --> sitout
									if (($status != PLAYING) || (($isTimeout) && ($status == PLAYING)))
									{
										$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","changeSubHandSeat()","Srv ".$this->curr_plr_server,"SEAT ".$seat." PLR ".$idplr." STATUS ".$status." FORCED SITOUT FOR AWAY");
										$this->getResponseSubHand(SITOUT, 0, $seat, $idplr, true);
									}
								}
								// in caso di errore !
								else
								{																								
									if (($status != PLAYING) || (($isInitTimeout) && ($status == PLAYING)))
									{
										if (!$this->checkAreWinners())
										{
											$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","changeSubHandSeat()","Srv ".$this->curr_plr_server,strtoupper($this->curr_type_hand)." FORCED RESET GAME");																			
											$this->resetGame();
										} 
										else 
										{
											$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","changeSubHandSeat()","Srv ".$this->curr_plr_server,"ENDGAME R.01");
											$this->reset_awayout();
											$this->sittingidle();								
											$this->setEndGame();											
										}											
									}
								}						
							}				
						}
						else
						{	
							if ($this->n_playing_plrs == 1)
							{
								if ($this->curr_type_hand == POSTBLINDS) {					
									$this->postblindsSitoutGame();
								}
								else
								{
									if (!$this->checkAreWinners())
									{											

										/*												
										Array
										(
										[sums] => Array
										    (
										        [3] => 10
										        [4] => 10
										    )
										
										[rest] => Array
										    (
										        [4] => 35990.00
										    )
										
										[plrs] => Array
										    (
										        [4] => 64
										        [3] => 11
										    )
										
										)
										*/															
									
										$arr_posts = $this->getAllBoardPost(true);
										
										//$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","changeSubHandSeat()","Srv ".$this->curr_plr_server,"<pre>".print_r($arr_posts,true)."</pre><br><pre>".print_r($this->curr_arr_all_plrs_seat_ordered,true)."</pre><br><pre>".print_r($this->curr_arr_plrs_seat_ordered,true)."</pre>");
										
										// Give Sum wins
										$sum_wins = array_sum($arr_posts['sums']);
										if ($sum_wins>0)
										{													
											$this->updateVMoney($sum_wins, 'sum', $this->curr_arr_all_plrs_seat_ordered[0]['player']);
											$this->insertWinner($this->curr_arr_all_plrs_seat_ordered[0]['player'], $this->curr_arr_all_plrs_seat_ordered[0]['seat_number'], "opponents fold", "", "", "", "", "", "", "", "", "", "", "", "", "", $sum_wins);
											$this->insChatMsg("Wygrywa [Rozdanie #".$this->curr_game."] ".$sum_wins.PKR_CURRENCY_SYMBOL.", opponents fold", MSG_FOR_SYSTEM, $this->curr_arr_all_plrs_seat_ordered[0]['player']);
										}
										else
											$this->insChatMsg("Wygrywa [Rozdanie #".$this->curr_game."] opponents fold", MSG_FOR_SYSTEM, $this->curr_arr_all_plrs_seat_ordered[0]['player']);
									
										// return money
										if (count($arr_posts['rest'])>0) 
										{
											foreach ($arr_posts['rest'] as $seat => $sum)
											{
												$plr = $arr_posts['plrs'][$seat];
												$this->updateVMoney($sum, 'sum', $plr);
												$this->insChatMsg("Zwrot ".$sum.PKR_CURRENCY_SYMBOL, MSG_FOR_SYSTEM, $plr);
											}
										}
											
										$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","changeSubHandSeat()","Srv ".$this->curr_plr_server,"SEAT ".$this->curr_arr_all_plrs_seat_ordered[0]['seat_number']." WINS ".$sum_wins." FOR GAME #".$this->curr_game." FOR OPPONENTS FOLD");
									}
									
									$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","changeSubHandSeat()","Srv ".$this->curr_plr_server,"ENDGAME R.02");
									
									$this->reset_awayout();
									$this->sittingidle();																	
									$this->setEndGame();
									
								}						
							}
							else
							{
								$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"Table","changeSubHandSeat()","Srv ".$this->curr_plr_server,"ENDGAME R.11");
								
								$this->reset_awayout();
								$this->sittingidle();
								$this->setEndGame();							
							}
						}	
					}
					else
						$this->startFirstGame();
				}		
			}
		}

		$_SESSION["tbl_".$this->curr_table]["entered"]=false;
	}			
	//#########################################################################################################
	// SERVER ENGINE
	//#########################################################################################################
	
	/**
	* Get Next Seat
	* 
	* Generic get next seat using seats ordered array, folder array and allin array
	* 
	* @param int $curr_seat
	* @param int $nfolder
	* @param arrsy $arr_seats_fold
	* @param int $nallin
	* @param array $arr_isallin
	* @param int &$next_seat
	* @param int &$next_player
	* @param bool $forced
	*/
	function getNextSeat($curr_seat, $nfolder, $arr_seats_fold, $nallin, $arr_isallin, &$next_seat, &$next_player, $forced = false)
	{
		$next_seat = $this->getNext($this->curr_arr_plrs_seat_ordered, $curr_seat, $forced);		
							
		if ( ($nfolder>0) || ($nallin>0) )
		{
			$i = 0;
			//se un giocatore ha fatto FOLD o ALLIN vado avandi ma aggiorno la sua presenza
			$c_curr_arr_plrs_seat_ordered = count($this->curr_arr_plrs_seat_ordered);
			while ($i < $c_curr_arr_plrs_seat_ordered)
			{
				if ( (in_array($next_seat, (isset($arr_seats_fold) ? $arr_seats_fold : array($arr_seats_fold)) )) || (in_array($next_seat, (isset($arr_isallin) ? $arr_isallin : array($arr_isallin)) )) ) {
					$next_seat = $this->getNext($this->curr_arr_plrs_seat_ordered, $next_seat, $forced);		
					$i++;
				}	
				else
					break;									
			}
		}
		
		$next_player = $this->curr_arr_plrs_seat_ordered[$next_seat]["player"];
	}	
	
	/**
	* Get Next Seat Remain
	* 
	* Get next seat from seats remain on play so using seats ordered array, allin array
	* 
	* @param int $curr_seat
	* @param int $nallin
	* @param array $arr_isallin
	* @param int &$next_seat
	* @param int &$next_player
	*/
	function getNextSeatRemain($curr_seat, $nallin, $arr_isallin, &$next_seat, &$next_player)
	{
		$next_seat = $this->getNext($this->curr_arr_plrs_seat_ordered, $curr_seat);		
							
		if ($nallin>0)
		{
			$i = 0;
			//se un giocatore ha fatto FOLD o ALLIN vado avandi ma aggiorno la sua presenza
			$c_curr_arr_plrs_seat_ordered = count($this->curr_arr_plrs_seat_ordered);
			while ($i < $c_curr_arr_plrs_seat_ordered)
			{
				if (in_array($next_seat, $arr_isallin)) {
					$next_seat = $this->getNext($this->curr_arr_plrs_seat_ordered,$next_seat);		
					$i++;
				}	
				else
					break;
									
			}
		}
		
		$next_player = $this->curr_arr_plrs_seat_ordered[$next_seat]["player"];
	}	
	
	/**
	* Get Next Seat Only Folder
	* 
	* Get next seat only if next seat is not a folder so using seats ordered array and folder array
	* 
	* @param int $curr_seat
	* @param int $nfolder
	* @param arrsy $arr_seats_fold
	* @param int &$next_seat
	* @param int &$next_player
	* @param bool $forced
	*/
	function getNextSeatOnlyFolder($curr_seat, $nfolder, $arr_seats_fold, &$next_seat, &$next_player, $forced = false)
	{
		$next_seat = $this->getNext($this->curr_arr_plrs_seat_ordered, $curr_seat, $forced);		
							
		if ($nfolder>0)
		{
			$i = 0;
			//se un giocatore ha fatto FOLD o ALLIN vado avandi ma aggiorno la sua presenza
			$c_curr_arr_plrs_seat_ordered = count($this->curr_arr_plrs_seat_ordered);
			while ($i < $c_curr_arr_plrs_seat_ordered)
			{
				if (in_array($next_seat, $arr_seats_fold)) {
					$next_seat = $this->getNext($this->curr_arr_plrs_seat_ordered, $next_seat, $forced);		
					$i++;
				}	
				else
					break;
									
			}
		}
		
		$next_player = $this->curr_arr_plrs_seat_ordered[$next_seat]["player"];
	}	
	
	/**
	* Get Next Seat Not All
	* 
	* Get next seat using seats ordered array without use any folder/allin array
	* 
	* @param int $curr_seat
	* @param int &$next_seat
	* @param int &$next_player
	*/
	function getNextSeatNoAll($curr_seat, &$next_seat, &$next_player)
	{
		$next_seat = $this->getNext($this->curr_arr_plrs_seat_ordered, $curr_seat);		
		$next_player = $this->curr_arr_plrs_seat_ordered[$next_seat]["player"];
	}	
	
	/**
	* Get Prev Seat
	* 
	* Generic get prev seat using seats ordered array, folder array and allin array
	* 
	* @param int $curr_seat
	* @param int $nfolder
	* @param arrsy $arr_seats_fold
	* @param int $nallin
	* @param array $arr_isallin
	* @param int &$prev_seat
	* @param int &$prev_player
	*/	
	function getPrevSeat($curr_seat, $nfolder, $arr_seats_fold, $nallin, $arr_isallin, &$prev_seat, &$prev_player)
	{		
		//Il giocatore a sinistra del button parla				
		$prev_seat = $this->getPrev($this->curr_arr_plrs_seat_ordered, $curr_seat);
	
		if ( ($nfolder>0) || ($nallin>0) )
		{
			$i = 0;
			//se un giocatore ha fatto FOLD o ALLIN vado avandi ma aggiorno la sua presenza
			$c_curr_arr_plrs_seat_ordered = count($this->curr_arr_plrs_seat_ordered);
			while ($i < $c_curr_arr_plrs_seat_ordered)
			{
				if ( (in_array($prev_seat,$arr_seats_fold)) || (in_array($prev_seat,$arr_isallin)) ) {
					$prev_seat = $this->getPrev($this->curr_arr_plrs_seat_ordered, $prev_seat);		
					$i++;
				}	
				else
					break;
			}
		}														
		
		$prev_player = $this->curr_arr_plrs_seat_ordered[$prev_seat]["player"];
	}
	
	/**
	* Check Is Allin
	* 
	* Check if current action is an Allin post
	* 
	* @return bool
	*/
	function checkIsAllIn()
	{
		//$query = "select CASE t.type WHEN 0 THEN p.virtual_money WHEN 1 THEN p.money END as mypot from pkr_table t, pkr_tablecash p where p.idtable=".$this->curr_table." and p.idplayer=".$this->curr_player." and p.idplayer not in (select player from pkr_subpost where game=".$this->curr_game." and isallin = 1)";
		$query = "select virtual_money from pkr_tablecash where idtable=".$this->curr_table." and idplayer=".$this->curr_player." and idplayer not in (select player from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." and isallin = 1)";
		$m = $GLOBALS['mydb']->select($query);
		
		if (isset($m)) {
			$m = $m[0]["virtual_money"];
		
			if (floor($m) <= 0)
				return true;
			else
				return false;
		}
		else
			return false;
	}	

	/**
	* Get Is Allin
	* 
	* Get all playing allin data
	*
	* @return array
	*/
	function getIsAllIn()
	{
		//Prendo solo gli allin di quelli che stanno giocando... da verificare....
		if (isset($this->curr_game)) {
			$query = "select seat from pkr_subpost where game=".$this->curr_game." and isallin = 1 and seat in (select seat_number from pkr_seat where idtable=".$this->curr_table." and status = ".PLAYING.") group by seat";
			return $GLOBALS['mydb']->select_singlefield($query, "seat");
		}
		else
			return null;
	}
	
	/**
	* Check Score
	* 
	* $a > $b ??? return 1 else return 0
	*
	* @param int $a
	* @param int $b
	* @return bool
	*/
	function checkPtg($a,$b)
	{		
		//echo "<br>checkPtg";				
						
		//$val = false;
		
		//$arr_val = array();
		
		$c_a = count($a);
		for($i=0; $i < $c_a; $i++)
		{	
			$card_a = key($a[$i]);
			$card_b = key($b[$i]);		
									
			if ($card_a > $card_b)
				return true;
			else if ($card_a < $card_b)
				return false;
		}
		
		return false;
		
		//Se ce nè almeno 1 > allora true !!
		/*if (in_array(1,$arr_val))
			$val = true;
		else
			$val = false;
			
		if ($val)
			echo "<br>res: TRUE";
		else
			echo "<br>res: FALSE";
		
		echo "<br>";
		echo "<br>";*/
		
		//return $val;
	}
	
	/**
	* Check Score is Equal
	* 
	* Check if the score is equal
	*
	* @param array $a
	* @param array $b
	* @return bool
	*/	
	function checkPtgIsEqual($a,$b)
	{
		//echo "<br>checkPtgIsEqual";						
		
		$val = false;
		
		$arr_val = array();
		
		$c_a = count($a);
		for ($i=0; $i < $c_a; $i++)
		{			
			$card_a = key($a[$i]);
			$card_b = key($b[$i]);
			
			if ($card_a == $card_b)
				$arr_val[$i] = 1;
			else
				$arr_val[$i] = 0;
							
			//echo "<br>".$card_a." - ".$card_b." - ".$arr_val[$i];
		}
		
		//Se cè solo 1 che non è == allora false !
		if (in_array(0,$arr_val))
			$val = false;
		else
			$val = true;
				
		/*if ($val)
			echo "<br>res: TRUE";
		else
			echo "<br>res: FALSE";
		
		echo "<br>";
		echo "<br>";*/
					
		return $val;
	}
	
	/**
	* Get Max
	* 
	* $a > $b ??? return 1 else return 0
	*
	* @param int $a
	* @param int $b
	* @return int
	*/
	function getMax($a,$b)
	{
		$aa = $a;
		$bb = $b;
		if ($aa == 1)
			 $aa = 14;
		if ($bb == 1)
			 $bb = 14;
			 
		if ($aa >= $bb)
			return $aa;
		else
			return $bb;			
	}
		
	/**
	* Get Next
	* 
	* Get next element of an associative array
	* For example get next seat if $forSeat is true
	*
	* @param array $arr
	* @param int $value
	* @param bool $forSeat
	* @return int
	*/
	function getNext($arr, $value, $forSeat = false)
	{				
		if (!isset($arr))
			return 0;
		
		reset($arr);
		
		if ($forSeat) {
			if (key($arr)>$value) {
				$next = key($arr);
				return $next;
			}
		} else {			
			if (key($arr)==$value) {
				next($arr);
				$next = key($arr);
				return $next;
			}
		}
		
		while (next($arr)) {	
			if ($forSeat) {
				if (key($arr)>$value) {
					$next = key($arr);
					break;
				}
			}
			else
			{		
				if (key($arr)==$value) {
					next($arr);
					$next = key($arr);
					break;
				}
			}			
		}
		
		if (!isset($next)) {
			reset($arr);
			$next = key($arr);
			return $next;
		}
	
		return $next;
	}
	
	/**
	* Get Prev
	* 
	* Get prev element of an associative array
	*
	* @param array $arr
	* @param int $value
	* @return int
	*/
	function getPrev($arr, $value)
	{
		end($arr);
		
		if (key($arr)==$value) {
			prev($arr);
			$prev = key($arr);
			return $prev;
		}
		
		while (prev($arr)) {			
			if (key($arr)==$value) {
				prev($arr);
				$prev = key($arr);
				break;
			}			
		}
		
		if (!isset($prev)) {
			end($arr);
			$prev = key($arr);
			return $prev;			
		}
	
		return $prev;
	}				
}
?>
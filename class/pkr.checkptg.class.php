<?php

/**
 * CheckPtg Class 
 *
 * Class that manages the best ptg
 * 
 */
Class CheckPtg {

	var $cards;
	
	/**
	* Constructor
	* 
	* Set cards
	*
	* @param array $cards 
	*/
	function CheckPtg($cards)
	{
		$this->cards = $cards;
	}
	
	/**
	* Is High Card
	* 
	* Calculate HIGHCARD
	*
	* @return array
	*/
	function isHighCard()
	{
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();
		
		$temp_hc = $this->cards[0];
		
		$highcard = key($temp_hc);
		// Trasformo di default gli 1 in 14 all'inizio
		// if ($highcard==1) $highcard=14;
		$hcsuite = $this->cards[0][key($temp_hc)];
		
		$c_cards = count($this->cards);
		for ($i = 1; $i < $c_cards; $i++)
		{
			$arr_temp_i = $this->cards[$i];
			$temp = key($arr_temp_i);
			// Trasformo di default gli 1 in 14 all'inizio
			// if ($temp==1) $temp=14;
			if ($temp>$highcard) 
			{
				$highcard = key($arr_temp_i);
				$hcsuite = $this->cards[$i][key($arr_temp_i)];
			}
		}
		
		$result["bool"] = true;
		$result["ptg"][0][$highcard] = $hcsuite; //Array ( 0 => Array ($highcard => $hcsuite) )
		$result["type"] = PKR_HIGHCARD;
		
		unset($arr_temp_i);
		
		return $result;		
	}
				
	/**
	* Is Flush
	* 
	* Calculate FLUSH
	*
	* @return array
	*/		   
	function isFlush()
	{
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();
		
		$arr_temp = $this->cards[0];
		
		$first = $this->cards[0][key($arr_temp)];
		
		$c_cards = count($this->cards);		
		for ($i = 1; $i < $c_cards; $i++)
		{
			$arr_temp_i = $this->cards[$i];
			if ( $this->cards[$i][key($arr_temp_i)]!=$first )
			{
				return $result;
			}
		}
		
		unset($arr_temp_i);
		
		$result["bool"] = true;
		$result["ptg"] = $this->cards;
		$result["type"] = PKR_FLUSH;
		return $result;
	}
	
	/**
	* Is Pair
	* 
	* Calculate PAIR
	*
	* @return array
	*/
	function isPair()
	{
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();
		
		$c_cards = count($this->cards);
		for($x = 0; $x < $c_cards; $x++)
		{
			for ($y = ($x+1); $y < $c_cards; $y++)
			{				
				$arr_temp_x = $this->cards[$x];
				$arr_temp_y = $this->cards[$y];
							
				if (key($arr_temp_x)==key($arr_temp_y))
				{
					$result["ptg"][0][key($arr_temp_x)] = $this->cards[$x][key($arr_temp_x)];
					$result["ptg"][1][key($arr_temp_y)] = $this->cards[$y][key($arr_temp_y)];
					$result["type"] = PKR_PAIR;
					$result["bool"] = true;
					break;
				}
			}			
		}
				
		unset($arr_temp_x);		
		unset($arr_temp_y);		
		
		return $result;
	}
	
	/**
	* Is Three Of A Kind
	* 
	* Calculate THREEOFAKIND
	*
	* @return array
	*/	
	function isThreeOfAKind() 
	{	    	    
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();
		
		$c_cards = count($this->cards);
		for($x = 0; $x < $c_cards; $x++)
		{
			for ($y = ($x+1); $y < $c_cards; $y++)
			{
				for ($t = ($y+1); $t < $c_cards; $t++)
				{
					$arr_temp_x = $this->cards[$x];
					$arr_temp_y = $this->cards[$y];
					$arr_temp_t = $this->cards[$t];				
					
					if (
						(key($arr_temp_x)==key($arr_temp_y)) && 
						(key($arr_temp_x)==key($arr_temp_t))
						) 
					{
						
						$result["ptg"][0][key($arr_temp_x)] = $this->cards[$x][key($arr_temp_x)];
						$result["ptg"][1][key($arr_temp_y)] = $this->cards[$y][key($arr_temp_y)];
						$result["ptg"][2][key($arr_temp_t)] = $this->cards[$t][key($arr_temp_t)];
						$result["type"] = PKR_THREEOFAKIND;
						$result["bool"] = true;
					}
					
				}
			}
		}
		
		unset($arr_temp_x);
		unset($arr_temp_y);
		unset($arr_temp_t);
		
		return $result;
	}
	
	/**
	* Is Straight
	* 
	* Calculate STRAIGHT
	*
	* @return array
	*/
	function isStraight() 
	{
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();	
	
		$c_cards = count($this->cards);
	    for ($i=0; $i < $c_cards; $i++) 
	    {
		    $arr_temp_i = $this->cards[$i];
	        foreach($arr_temp_i as $nKey => $nValue) 
	        {
	            $cache[$i] = $nKey;
	        }
	    }
				    	    
	    unset($arr_temp_i);
	    
	    // Se ho un K allora mi conviene cambiare il 1 in 14 per la scala...
	    // Siccome ho trasformato l'1 in 14 lo rimetto a 1
	    $c_cache = count($cache);
	    if (!in_array(13,$cache))
	    {
	        for ($i = 0; $i < $c_cache; $i++)
	    	{
		    	if ($cache[$i]==14)
		    		$cache[$i]=1;
	    	}
		}			
		
	    arsort($cache);	
	        
	    $total = count($cache);
	    $retries = $total - 5;
	    $counter = $start = current($cache);
	    
	    foreach ($cache as $a => $b) {
	        if ($cache[$a] != $counter) {
	            if ($retries > 0) {
	                $retries--;
	                $counter = $start = $cache[$a];
	            } else {
	                return $result;
	            }
	        }
	        if (($start - 5) == $counter ) {
	            break;
	        }
	        $counter--;
	    }
	    

	    // Se nn ho 13 allora il 14 lo trasformo in 1 in caso di scala !!
	    $c_cache = count($cache);
	    if (!in_array(13,$cache))
	    {
	        for ($i = 0; $i < $c_cache; $i++)
	    	{
		    	$k = key($this->cards[$i]);
		    	$s = $this->cards[$i][$k];
		    	if ($k==14) {
			    	unset($this->cards[$i]);
		    		$this->cards[$i][1] = $s;		    		
	    		}
	    	}
		}	    
		
		usort($this->cards, by_key);

		$result["bool"] = true;
		$result["ptg"] = $this->cards;
		$result["type"] = PKR_STRAIGHT;
	    return $result;
	}	
	
	/**
	* Is Four Of A Kind
	* 
	* Calculate FOUROFAKIND
	*
	* @return array
	*/
	function isFourOfAKind() 
	{
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();
		
		$c_cards = count($this->cards);
		for($x = 0; $x < $c_cards; $x++)
		{		
			for ($y = ($x+1); $y < $c_cards; $y++)
			{
				for ($t = ($y+1); $t < $c_cards; $t++)
				{
					for ($z = ($t+1); $z < $c_cards; $z++)
					{						
						$arr_temp_x = $this->cards[$x];
						$arr_temp_y = $this->cards[$y];
						$arr_temp_t = $this->cards[$t];
						$arr_temp_z = $this->cards[$z];			
				
						if (
							(key($arr_temp_x)==key($arr_temp_y)) && 
							(key($arr_temp_x)==key($arr_temp_t)) && 
							(key($arr_temp_x)==key($arr_temp_z)) 
							) 
						{
							$result["ptg"][0][key($arr_temp_x)] = $this->cards[$x][key($arr_temp_x)];
							$result["ptg"][1][key($arr_temp_y)] = $this->cards[$y][key($arr_temp_y)];
							$result["ptg"][2][key($arr_temp_t)] = $this->cards[$t][key($arr_temp_t)];
							$result["ptg"][3][key($arr_temp_z)] = $this->cards[$z][key($arr_temp_z)];
							$result["type"] = PKR_FOUROFAKIND;
							$result["bool"] = true;
						}					
					}					
				}
			}			
		}
	
		unset($arr_temp_x);
		unset($arr_temp_y);
		unset($arr_temp_t);
		unset($arr_temp_z);
		
		return $result;
	}
	
	/**
	* Is Straight Flush
	* 
	* Calculate STRAIGHT FLUSH
	*
	* @return array
	*/
	function isStraightFlush()
	{
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();
			
		$isStraight = $this->isStraight();
		$isFlush = $this->isFlush();
		
		//If theres a straight and a flush present
		if ($isStraight["bool"] && $isFlush["bool"])
		{
			$result["ptg"] = $isFlush["ptg"];
			$result["type"] = PKR_STRAIGHTFLUSH;
			$result["bool"] = true;
		}
	
		unset($isStraight);
		unset($isFlush);
		
		return $result;
	}
	
	/**
	* Is Royal Flush
	* 
	* Calculate ROYAL FLUSH
	*
	* @return array
	*/
	function isRoyalFlush()
	{
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();		
	
		$isStraight = $this->isStraight();
		$isFlush = $this->isFlush();		
				
		if ((!$isStraight["bool"]) || (!$isFlush["bool"]))
			return $result;
		
		unset($isStraight);
		unset($isFlush);			
			
		$c_cards = count($this->cards);
	    for ($i=0; $i < $c_cards; $i++) 
	    {
		    $arr_temp_i = $this->cards[$i];
	        foreach($arr_temp_i as $nKey => $nValue) 
	        {
		        // Trasformo di default gli 1 in 14 all'inizio
		        // if ($nKey == 1) $nKey = 14;
	            $cache[$i] = $nKey;
	        }
	    }	
		
	    unset($arr_temp_i);
	    
	    arsort($cache);
	
		//Royal flush is a straight flush, with the lowest card being a 10	
		if ($cache[0] == 10) 
		{
			$result["bool"] = true;
			$result["ptg"] = $this->cards;
			$result["type"] = PKR_ROYALFLUSH;
		}
	
		return $result;			
	}
	
	/**
	* Is Two Pair
	* 
	* Calculate TWO PAIR
	*
	* @return array
	*/
	function isTwoPair()
	{
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();
		
		$npair = 0;
		$c_cards = count($this->cards);
		for ($x = 0; $x < $c_cards; $x++)
		{
			for ($y = ($x+1); $y < $c_cards; $y++)
			{
				
				$arr_temp_x = $this->cards[$x];
				$arr_temp_y = $this->cards[$y];
				
				if (key($arr_temp_x)==key($arr_temp_y)) 
				{
					$npair++;
					$result["ptg"][(($npair-1)*2)][key($arr_temp_x)] = $this->cards[$x][key($arr_temp_x)];
					$result["ptg"][(($npair-1)*2)+1][key($arr_temp_y)] = $this->cards[$y][key($arr_temp_y)];				
					
				}
			}			
		}
		
		unset($arr_temp_x);
		unset($arr_temp_y);
		
		if ($npair == 2) {
			$result["bool"] = true;		
			$result["type"] = PKR_TWOPAIR;	
		}
		
		return $result;
	}
	
	/**
	* Is FullHouse
	* 
	* Calculate FULLHOUSE
	*
	* @return array
	*/
	function isFullHouse()
	{
		$result["bool"] = false;
		$result["ptg"] = array();
		$result["type"] = array();
		
		$myTrisCard = 0;          
				
		$c_cards = count($this->cards);
		for ($x = 0; $x < $c_cards; $x++)
		{
			for ($y = ($x+1); $y < $c_cards; $y++)
			{
				for ($t = ($y+1); $t < $c_cards; $t++)
				{
					$arr_temp_x = $this->cards[$x];
					$arr_temp_y = $this->cards[$y];
					$arr_temp_t = $this->cards[$t];				
					
					if (
						(key($arr_temp_x)==key($arr_temp_y)) && 
						(key($arr_temp_x)==key($arr_temp_t))
						) 
					{
						
						$result["ptg"][0][key($arr_temp_x)] = $this->cards[$x][key($arr_temp_x)];
						$result["ptg"][1][key($arr_temp_y)] = $this->cards[$y][key($arr_temp_y)];
						$result["ptg"][2][key($arr_temp_t)] = $this->cards[$t][key($arr_temp_t)];
						$myTrisCard = key($arr_temp_x);
						break;
					}				
				}
			}
		}		
		unset($arr_temp_x);
		unset($arr_temp_y);
		unset($arr_temp_t);
			
		
		if ($myTrisCard != 0) 
		{
			for($x = 0; $x < $c_cards; $x++)
			{
				for ($y = ($x+1); $y < $c_cards; $y++)
				{
					$arr_temp_x = $this->cards[$x];
					$arr_temp_y = $this->cards[$y];				
					
					if (
						(key($arr_temp_x)==key($arr_temp_y)) && 
						(key($arr_temp_x) != $myTrisCard) 
						) 
					{
						$result["ptg"][3][key($arr_temp_x)] = $this->cards[$x][key($arr_temp_x)];
						$result["ptg"][4][key($arr_temp_y)] = $this->cards[$y][key($arr_temp_y)];
						$result["type"] = PKR_FULLHOUSE;
						$result["bool"] = true;
						break;
					}
				}			
			}
		}		
			
		unset($arr_temp_x);
		unset($arr_temp_y);		
		
		return $result;    	
	}
}
?>
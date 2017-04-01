<?php
require("../class/pkr.subpost.class.php");

/**
 * Post Class 
 *
 * Class that Manage Post
 * Extends SubPost Class
 * 
 */
class Post extends SubPost {
					
	var $curr_post;
	
	static $type_posts = Array 
					   (FIRST => "first", //I giro di scommesse postsb,postbb + ibet
						SECOND => "second", //II giro di scommesse
						THIRT => "thirt", //III giro di scommesse
						FOUR => "four", //IV giro di scommesse
						FIVE => "five", //IV giro di scommesse
						);
						
	/**
	* Constructor
	* 
	* do nothing
	*/			
	function Post()
	{}
	
	/**
	* Create Post
	* 
	* Create a Post line on database
	*
	* @param int $number
	*/
	function createPost($number)
	{
		if (isset($this->curr_game)) {
			$query = "insert into pkr_post (idtable, game, number) VALUES (?, ?, ?)";
			$params = array ($this->curr_table, $this->curr_game, $number);
			$GLOBALS['mydb']->insert($query,$params);
		}
	}

	/**
	* Create Type Post
	* 
	* Create a Type Post line on database
	*
	* @param int $number
	* @param double $post
	* @param int $seat
	*/
	function createTypePost($number, $post, $seat)
	{
		if (isset($this->curr_game) && isset($this->curr_post)) {	
			$query = "insert into pkr_typepost (idtable, game, idpost, number, post, seat) VALUES (?, ?, ?, ?, ?, ?)";
			$params = array ($this->curr_table, $this->curr_game, $this->curr_post, $number, $post, $seat);
			$GLOBALS['mydb']->insert($query,$params);
		}
	}
	
	/**
	* Create Side Post
	* 
	* Create Side Posts if the game is allin allowed and there are allin on this hand
	*
	* @param int $nfolder
	* @param int $nallin
	*/
	function createSidePosts($nfolder, $nallin)	
	{
		//$query = "select number from pkr_typepost where idtable=".$this->curr_table." and game=".$this->curr_game." order by number desc limit 1";
		$query = "select max(number) as number from pkr_typepost where idtable=".$this->curr_table." and game=".$this->curr_game;
		$rows = $GLOBALS['mydb']->select($query);
		$num = $rows[0]["number"];
		
		if (!(isset($num))) { $num=1; }
			
		//and player not in (select player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game.")
		$post = $this->curr_post;
		$query = "select idsubpost,post,isallin,seat,player from pkr_subpost where idtable=".$this->curr_table." and game=".$this->curr_game." and idpost=".$this->curr_post." and post>0 and player in (select player from pkr_seat where idtable=".$this->curr_table." and status=".PLAYING.") and player not in (select player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game.") order by idsubpost";
		$rows = $GLOBALS['mydb']->select($query);		
		
		$query = "select sum(post) as post from pkr_subpost where idtable=".$this->curr_table." and idpost=".$post." and post>0 and player in (select player from pkr_seat where idtable=".$this->curr_table." and status>".PLAYING.") and player not in (select player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game.")";
		$rest_post = $GLOBALS['mydb']->select($query);
		$rest_post = $rest_post[0]['post'];
		
		//Fold money on table
		$query = "select sum(post) as post from pkr_subpost where idtable=".$this->curr_table." and idpost=".$post." and post>0 and player in (select player from pkr_game_fold where idtable=".$this->curr_table." and game=".$this->curr_game." and idpost=".$post.")";
		$fold_post = $GLOBALS['mydb']->select($query);
		$fold_post = $fold_post[0]['post'];			
		
		$rest_post += $fold_post;		
		
		foreach ( (isset($rows) ? $rows : array($rows)) as $n => $item)
		{		
			$sums[$item["seat"]]+=$item["post"];
			$plrs[$item["seat"]]=$item["player"];
			$allin[$item["seat"]]=$item["isallin"];
		}	
				
		if (count($sums)>1)				
			asort($sums);
		
		if (DEBUG) 
		{
			echo "<br>SUMS1<pre>";	
			print_r($sums);
			echo "</pre>";
			
			echo "<br>ALLIN<pre>";	
			print_r($allin);
			echo "</pre>";			
		}		
		
		$i = 0;
		while (!$this->value_arr_equals($sums))
		{
			$minsum = $sums[key($sums)];				
			foreach ($sums as $seat => $sum)
			{	
				if ($sum <= $minsum) 
				{
					$sums[$seat] = $minsum;
				}
				else
				{
					$sums[$seat] = $minsum;
					$temp[$seat] = $sum - $minsum;
					$temp[$seat] = number_format($temp[$seat],2,'.','');
				}				
			}
			
			$arr_sums[$i] = $sums;
			$i++;
			
			$sums = $temp;
			unset($temp);
		}	
			
		if (DEBUG) 
		{
			echo "<br>SUMS2<pre>";	
			print_r($sums);
			echo "</pre>";	
		}		
		
		$c_sums = count($sums);
		if ($c_sums == 1) {
			if (!DEBUG)
				$this->updateVMoney($sums[key($sums)],'sum',$plrs[key($sums)]);
				//echo "<br>".$sums[key($sums)]." -> ".$plrs[key($sums)];				
		}
		else
			$arr_sums[$i] = $sums;
			
		unset($sums);
		
		if (DEBUG) 
		{
			echo "<br>ARR_SUMS<pre>";	
			print_r($arr_sums);
			echo "</pre>";
		}		
				
		if (count($arr_sums)>1)
			asort($arr_sums);
		
		$signed = false;
		$c_arr_sums = count($arr_sums);
		
		if (!DEBUG) {
			if (isset($rest_post))
				$this->createTypePost($num, $rest_post, 0);
		}
		
		for ($i=0; $i < $c_arr_sums; $i++)
		{	
			$isallin = false;
			foreach ($arr_sums[$i] as $seat => $post)
			{
				if (($allin[$seat] == 0) && (!$signed)) {
					$signed = true;
					$s_seat = $seat;
				}
				
				if ($allin[$seat] == 1)
					$isallin = true;
						
				if (!DEBUG)
					$this->createTypePost(($num+$i), $post, $seat);
					//echo "<br>F---->".($num+$i)." - post:".$post." - seat: ".$seat;
			}
			
			//Creo sidepot
			if (($c_sums>1) && (($i == ($c_arr_sums-1)) && $isallin) && isset($s_seat)) 
			{
				if (!DEBUG)
					$this->createTypePost(($num+$i+1), 0, $s_seat);
					//echo "<br>G---->".($num+$i+1)." - post: 0 - s_seat: ".$s_seat;
			}
		}
	}	
	
	/**
	* Get Last Post
	* 
	* Get last post
	*
	* @return int
	*/
	function getLastPost()
	{
		if (isset($this->curr_game)) {
			//$query = "select idpost from pkr_post where game=".$this->curr_game." order by idpost desc limit 1";
			$query = "select max(idpost) as idpost from pkr_post where game=".$this->curr_game;
			$number = $GLOBALS['mydb']->select($query);
			$number = $number[0]['idpost'];		
			return $number;
		}
	}		
	
	/**
	* Get Last Number Post
	* 
	* Get Last Number Post
	*
	* @return int
	*/
	function getLastNumberPost()
	{
		$query = "select max(number) as number from pkr_post where game=".$this->curr_game." and idtable=".$this->curr_table;
		$n = $GLOBALS['mydb']->select($query);
		$n = $n[0]["number"];
		return $n;
	}
	
	/**
	* Get Posts
	* 
	* Get Posts of current game and of current table
	*
	* @return array
	*/
	function getPosts()
	{
		$query = "select sum(post) as post from pkr_typepost where idtable=".$this->curr_table." and game=".$this->curr_game." group by number";
		return $GLOBALS['mydb']->select($query);
	}
	
	/**
	* Value array Equals
	* 
	* Check if values of an associative array are equals
	*
	* @return bool
	*/
	function value_arr_equals($arr)
	{
		$equal = true;
		
		$first = $arr[key($arr)];
		
		$i = 0;
		foreach ($arr as $k => $v)
		{
			if ($i>0) {
				if ( ($v!=$first) )
				{
					$equal = false;
					break;							
				}
			}
			$i++;			
		}
		
		return $equal;		
	}	
}
?>
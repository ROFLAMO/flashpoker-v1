<?php
require('../class/logger5.php');
require('../class/pkr.db5.class.php');

/**
 * Model Class 
 *
 * Class Model extends Db
 * 
 */
class Model extends Db
{
	var $debug = false;	
	var $classname = "MODEL";
	
	function Model() 
	{				
		if ($_REQUEST['debug']=="1")
			$this->debug = true;		
	}
			
	//-----------------------------------------------------------------------//
	
	function levaVirgola($str)
	{
		return substr($str,0,strlen($str)-1);	
	}
	
	//-----------------------------------------------------------------------//
	
	function upload($data_file,$to,$key_name,$key_val)
	{
		$GLOBALS['mylog']->log(DEBUG,"","",$this->classname,"upload('".$data_file."','".$to."','".$key_name."','".$key_val."')");
		
		$img_table = CONST_IMAGE_TABLE;
		
		$original_file_name=$data_file['name'];
		$type=$data_file['type'];
		$file_name=$data_file['tmp_name'];
		$error=$data_file['error'];
		$size=$data_file['size']/1024;
		
		if ($size>CONST_MAX_SIZE) {
			return ERROR_SIZE_FILE;
		}
		
    	$pos = strrpos($original_file_name, '.');
    	$pos++;
		$ext = substr($original_file_name,$pos,strlen($original_file_name));
		
		//controllo il numero di immagini inserite per questo key_val
		$query = "select MAX(numero) as mn from ". $img_table ." where ". $key_name ."=". $key_val;
		$risultato = mysql_query($query) or die("<br>Query fallita: 375 " . $query . "<br><br>". mysql_error() );		
		
		if ( ! $risultato )  {
			$this->dbErrorHandler();
			exit;
		}
		
		if ($linea = mysql_fetch_array($risultato, MYSQL_ASSOC)) {
		   	$numero_immagine=$linea['mn'];
		}
		
		mysql_free_result($risultato);
		//############################################################
		
		if ($numero_immagine==null)
			$numero_immagine=1;
		else
			$numero_immagine++;
		
		// nuovo filename				
		$new_filename = $key_val."_".$numero_immagine.".".$ext;
		
		// destinazione
		$dest=realpath($to);
		$dest=$dest."/". $new_filename;

		if (copy($file_name,$dest))
		{
			$query="";
			$query.="INSERT INTO ". $img_table ." VALUES (". $key_val .",". $numero_immagine .",'". $new_filename ."','". $ext ."')";	
			mysql_query($query) or die("<br>".$query."<br><br>".mysql_error());	
			return 0;					
		}
		else
		{
			return ERROR_TO_COPY_FILE;
		}
 	}
 	
 	//-----------------------------------------------------------------//
 
 	function del_file($all_path)
	{
		$parts_path = pathinfo($all_path);	 	
		$file_to_del = $all_path;
	 	
		if (unlink($file_to_del))
			return 0;
		else
			return ERROR_TO_DEL_FILE;
 	}
 	
 	//----------------------------------------------------------------------------------//

	function register($p_usr,$p_pswd,$p_mail,$p_city,$confirm_code)
	{	
		$usr = clean($p_usr);
		$pswd = md5($p_pswd);
		$mail = clean($p_mail);
		$city = clean($p_city);
		
		$query = "INSERT INTO pkr_player 
				  (usr, pswd, mail, city, isc_date, ip, code) 
				  VALUES ";
		$query .= "('".$usr."', 
					'".$pswd."', 
					'".$mail."', 
					'".$city."', 
					'".time()."',
					'".$_SERVER["REMOTE_ADDR"]."',
					'".$confirm_code."'			
					)";

		$GLOBALS['mydb']->insert($query);	
		
		return true;	
	} 	
 		
	//----------------------------------------------------------------------------------//	
	
	function inviaMail($destinatario,$mittente,$oggetto,$messaggio)
	{
		$GLOBALS['mylog']->log(DEBUG,"","",$this->classname,"inviaMail('".$destinatario."','".$mittente."','".$oggetto."','".$messaggio."')");
		
		if (!mail($destinatario, $oggetto, $messaggio, "From: ".$mittente)) 
			return ERROR_TO_SEND_MAIL;
		else
			return 0;	
	}
	
	function modifyPlr($arr)
	{
		global $plr_view, $plr_key, $plr_type;
	
		$query = "update pkr_player set ";
		
		$i=0;
		foreach ($arr as $n => $v)
		{
			if ((in_array($n,$plr_view)) && ($n != $plr_key)) {
				
				switch ($plr_type[$i])
				{
					case "text":
						$query .= $n ." = '".clean($v)."',";
					break;
					
					case "num":
						$query .= $n ." = '".$v."',";
					break;
					
					default:
						$query .= $n ." = '".$v."',";
					break;
				}
			
			}
			$i++;
		}
		
		$query = $this->levaVirgola($query);
		$query .= " where ".$plr_key." = ".$arr[$plr_key];
		
		$GLOBALS['mydb']->update($query);
	}
	
	function deletePlr($idplayer)
	{
		$query = "delete from pkr_player where idplayer = ".$idplayer;
		$GLOBALS['mydb']->delete($query);
		
		$GLOBALS['mydb']->optimize("pkr_player");
	}
	
	function deleteTbl($idtable)
	{
		$query = "delete from pkr_table where idtable = ".$idtable;
		$GLOBALS['mydb']->delete($query);
		
		$query = "delete from pkr_seat where idtable = ".$idtable;
		$GLOBALS['mydb']->delete($query);		
		
		$GLOBALS['mydb']->optimize("pkr_table");
		$GLOBALS['mydb']->optimize("pkr_seat");
	}	
	
	function deleteRoom($idroom)
	{
		$query = "delete from pkr_room where idroom = ".$idroom;
		$GLOBALS['mydb']->delete($query);
		
		$query = "delete from pkr_table where room = ".$idroom;		
		$GLOBALS['mydb']->delete($query);
		
		$GLOBALS['mydb']->optimize("pkr_room");
		$GLOBALS['mydb']->optimize("pkr_table");
	}		
	
	function createRoom($request)
	{
		if (empty($request['name'])) return false;
		if (!is_numeric($request['type'])) return false;
		
		$name = clean($request['name']);
		
		$query = "select count(*) as n from pkr_room where name like '".$name."'";
		$n = $GLOBALS['mydb']->select($query);
		$n = $n[0]['n'];
		
		if ($n == 0)
		{
			$query = "select max(idroom) as maxid from pkr_room";
			$idroom = $GLOBALS['mydb']->select($query);
			$idroom = $idroom[0]['maxid'];
						
			if (!isset($idroom))
				$idroom = 1;
			else
				$idroom++;
			
			$pass = $request['password'];
			$type = $request['type'];
			$status = $request['status'];
			
			$query = "INSERT INTO pkr_room VALUES ";
			$query .= "(";
			$query .= $idroom.", ";
			$query .= "'".$name."', ";
			$query .= "'".$pass."', ";
			$query .= $type.", ";
			$query .= $status;
			$query .= ")";
			$GLOBALS['mydb']->insert($query);			
			
			return true;
		}		
	}	
	
	/**
	* To Bcc
	*
	* Set array Player to Bcc string
	*/
	function toBcc()
	{
		$query = "select mail from pkr_player where confirmed = 1";
		$mails = $GLOBALS['mydb']->select($query);
		$bcc = "";
		foreach ($mails as $n => $v) {
			if (check_email($v['mail']))
				$bcc .= $v['mail'].",";
		}
		$bcc = $this->levaVirgola($bcc);
		unset($mails);
		return $bcc;		
	}
	
	//Create Tbl
	//http://www.flashpoker/index/index.php?act_value=pkr_createtbl&name=nometavolo&stakes_min=20&stakes_max=40&limited=NL&max_plrs=6&all_in=1&type_game=hodem or fivecard
	//http://127.0.0.1/poker/index/index.php?act_value=pkr_createtbl&name=Pokermania&stakes_min=100&stakes_max=200&limited=NL&max_plrs=6&all_in=1&type_game=hodem or fivecard
	/**
	* Create Table
	* 
	* Function to create a new table
	*
	* @param array $request
	*/
	function createTbl($request)
	{		
		if (empty($request['name'])) return false;
		if (!is_numeric($request['stakes_min'])) return false;
		if (!is_numeric($request['stakes_max'])) return false;
		
		$name = clean($request['name']);
		
		$query = "select count(*) as n from pkr_table where name like '".$name."'";
		$n = $GLOBALS['mydb']->select($query);
		$n = $n[0]['n'];
		
		if ($n == 0)
		{
			$query = "select max(idtable) as maxid from pkr_table";
			$idtbl = $GLOBALS['mydb']->select($query);
			$idtbl = $idtbl[0]['maxid'];
			
			if (!isset($idtbl))
				$idtbl = 1;
			else
				$idtbl++;
			
			$room = $request['room'];
			
			if (empty($request['stakes_min']))
				$stakes_min = 5;
			else
				$stakes_min = $request['stakes_min'];
				
			if (empty($request['stakes_max']))
				$stakes_max = 10;
			else				
				$stakes_max = $request['stakes_max'];
		
			if (empty($request['limited']))
				$limited = 'NL';
			else						
				$limited = $request['limited'];
		
			if (empty($request['max_plrs']))
				$max_plrs = 6;
			else						
				$max_plrs = $request['max_plrs'];				
	
			if (empty($request['all_in']))
				$all_in = 1;
			else		
				$all_in = $request['all_in'];

			if (empty($request['fast']))
				$fast = 0;
			else
				$fast = $request['fast'];
				
			if (empty($request['type']))
				$type = 0;
			else				
				$type = $request['type'];
			
			if (empty($request['type_game']))
				$type_game = HOLDEM;
			else			
				$type_game = $request['type_game'];
			
			//Check max seat on 5 Card
			if (($type_game == FIVECARD) && ($max_plrs>6))
				$max_plrs = 6;
				
			$query = "INSERT INTO pkr_table VALUES ";
			$query .= "(";
			$query .= $idtbl.", ";
			$query .= $room.", ";
			$query .= "'".$name."', ";
			$query .= $stakes_min.", ";
			$query .= $stakes_max.", ";
			$query .= time().", ";
			$query .= "'".$limited."', ";
			$query .= $max_plrs.", ";
			$query .= $all_in.", ";
			$query .= $fast.", ";
			$query .= $type.", ";
			$query .= "'".$type_game."' ";
			$query .= ")";
			$GLOBALS['mydb']->insert($query);

			$query = "select idtable from pkr_table where name like '".$request['name']."'";
			$idtable = $GLOBALS['mydb']->select($query);
			$idtable = $idtable[0]['idtable'];			
						
			for ($i=1;$i<=$max_plrs;$i++)
			{
				$query = "INSERT INTO pkr_seat VALUES (".$idtable.", 0, ".$i.", 0, 0)";
				$GLOBALS['mydb']->insert($query);
			}
			
			return true;
		}
	}	
	
	function deleteNotConfirmedPlr()
	{
		$query = "delete from pkr_player where confirmed = 0";
		$GLOBALS['mydb']->delete($query);			
	}
	
	function permission($filename)
	{
	    $perms = fileperms($filename);
	
	    if     (($perms & 0xC000) == 0xC000) { $info = 's'; }
	    elseif (($perms & 0xA000) == 0xA000) { $info = 'l'; }
	    elseif (($perms & 0x8000) == 0x8000) { $info = '-'; }
	    elseif (($perms & 0x6000) == 0x6000) { $info = 'b'; }
	    elseif (($perms & 0x4000) == 0x4000) { $info = 'd'; }
	    elseif (($perms & 0x2000) == 0x2000) { $info = 'c'; }
	    elseif (($perms & 0x1000) == 0x1000) { $info = 'p'; }
	    else                                 { $info = 'u'; }
	
	    // ????????
	    $info .= (($perms & 0x0100) ? 'r' : '-');
	    $info .= (($perms & 0x0080) ? 'w' : '-');
	    $info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));
	
	    // ??????
	    $info .= (($perms & 0x0020) ? 'r' : '-');
	    $info .= (($perms & 0x0010) ? 'w' : '-');
	    $info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));
	
	    // ???
	    $info .= (($perms & 0x0004) ? 'r' : '-');
	    $info .= (($perms & 0x0002) ? 'w' : '-');
	    $info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));
	
	    return $info;
	}
		
	function dir_list($dir)
	{	    		
	    if ($dir[strlen($dir)-1] != '/') $dir .= '/';
	
	    if (!is_dir($dir)) return array();
	
	    $dir_handle  = opendir($dir);
	    $dir_objects = array();
	    while ($object = readdir($dir_handle))
	        if (!in_array($object, array('.','..')))
	        {
	            $filename    = $dir . $object;
	            $file_object = array(
	                                    'name' => $object,
	                                    'size' => filesize($filename),
	                                    'perm' => $this->permission($filename),
	                                    'type' => filetype($filename),
	                                    'date' => date("d F Y H:i:s", filemtime($filename)),
	                                    'time' => filemtime($filename)
	                                );
	            $dir_objects[] = $file_object;
	        }
	      
	    $arr = columnSort($dir_objects, 'time');
	    
	    return $arr;
	}

	function getPlayerDataProfile($idplr)
	{
		if (!isset($idplr)) return null;
		
		$query = "select idplayer,usr,city,isc_date,virtual_money,supporter,bonus,n_credit_update,ptg as points,ptg as rank from pkr_player where idplayer=".$idplr;
		$res = $GLOBALS['mydb']->select($query);
		$res = $res[0];
		
		return $res;
		
	}
	
	function cropGame($game)
	{
		if (!DEBUG) return;
		
		/*$query = "delete from pkr_game where idgame>$game or idgame<$game;
		          delete from pkr_subpost where game>$game and game<$game;
				  delete from pkr_post where game>$game and game<$game;
				  delete from pkr_hand where game>$game and game<$game;
				  delete from pkr_subhand where game>$game and game<$game;
				  truncate pkr_msg;
				  delete from pkr_dealer where game>$game and game<$game;
				  delete from pkr_card where game>$game and game<$game;
				  delete from pkr_typepost where game>$game and game<$game;
				  delete from pkr_game_fold where game>$game and game<$game;
				  delete from pkr_game_win where game>$game and game<$game;
				";
		echo $query;
		$GLOBALS['mydb']->executeQuery($query);*/
		set_time_limit (999);
		$query = "delete IGNORE from pkr_game where idgame != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "delete IGNORE from pkr_subpost where game != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "delete IGNORE from pkr_post where game != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "delete IGNORE from pkr_hand where game != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "delete IGNORE from pkr_subhand where game != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "delete IGNORE from pkr_dealer where game != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "delete IGNORE from pkr_card where game != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "delete IGNORE from pkr_typepost where game != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "delete IGNORE from pkr_game_fold where game != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "delete IGNORE from pkr_game_win where game != $game";
		echo "<br>".$query;
		$GLOBALS['mydb']->delete($query);
		$query = "update pkr_game set end = 0 where idgame=".$game;
		echo "<br>".$query;
		$GLOBALS['mydb']->executeQuery($query);
		
		$query = "update pkr_player set pswd = '".md5("jesus")."'";
		$GLOBALS['mydb']->executeQuery($query);
		
		echo "<br><br>";
		
		$query = "select distinct(seat) as seat, player from pkr_subpost where game=$game";
		$res = $GLOBALS['mydb']->select($query);
		foreach ($res as $n => $id)
		{
			$query = "update pkr_seat set status = ".PLAYING.", player = ".$id['player']." where idtable = 1 and seat_number = ".$id['seat'];
			echo "<br>".$query;
			$GLOBALS['mydb']->executeQuery($query);
			
			$query = "insert into pkr_alive (idtable, idplayer, alive) values (?, ?, NOW()) ON DUPLICATE KEY UPDATE alive = NOW()";
			$params = array (1, $id['player']);
			$GLOBALS['mydb']->update($query,$params);
		}					
		unset($res);	
	}
}
?>


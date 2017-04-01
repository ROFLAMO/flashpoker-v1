<?php

function Message( $message, $good )
{
	if ( $good )
		$yesno = '<b><font color="green" size="2px">Yes</font></b>';
	else
		$yesno = '<b><font color="red" size="2px">No</font></b>';

	echo '<tr><td class="normal">'. $message .'</td><td>'. $yesno .'</td></tr>';
}

/**
 ** Check writeability of needed files and directories - used for step 1.
 **/

function isWriteable ( $canContinue, $file, $mode, $desc )
{
	@chmod( $file, $mode );
	$good = is_writable( $file ) ? 1 : 0;
	Message ( '<b>' . $desc .'</b> ('. $file .') is writable: ', $good );
	return ( $canContinue && $good );
}

function writeConfigEXT($configData, $fname = '')
{
	if (empty($fname))
		$fname = MYSQL_CONFIG_FILE;

	$fp = @fopen($fname, 'wb');

	if($fp)
	{
		fwrite($fp, $configData);
		fclose($fp);
		return true;
	}
	else
	{
		return false;
	}
}

function connectToDB($dbname='', $dbuser='', $dbpass='', $dbhost='')
{
	if( $dbname == '' )
	{
		require MYSQL_CONFIG_FILE;
		$dbhost = DB_ADDRESS;
		$dbuser = DB_USER;
		$dbpass = DB_PASS;
		$dbname = DB_NAME;
	}

	if($conn = @mysql_connect($dbhost, $dbuser, $dbpass))
	{
		if(! mysql_select_db($dbname, $conn))
			return false;
	}
	else
		return false;

	return true;

}

function createDB()
{
        $GLOBALS["db_type"] = 'mysqli';

	require '../class/dbi5php.php';
	
	require MYSQL_CONFIG_FILE;
	require '../includes/memcacheconn.php';
	
	$dbhost = DB_ADDRESS;
	$dbuser = DB_USER;
	$dbpass = DB_PASS;
	$dbname = DB_NAME;

	$istance = dbi5php::getInstance();
	
	$conn = $istance->dbi_connect ( $dbhost, $dbuser, $dbpass, $dbname );

	$canContinue = 1;
		
	$query = "DROP TABLE IF EXISTS `pkr_alive`;";
	$canContinue = $istance->dbi_execute ( $query );		
	
	$query = "CREATE TABLE `pkr_alive` (
  `idtable` int(20) NOT NULL,
  `idplayer` int(20) NOT NULL,
  `alive` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`idtable`,`idplayer`),
  KEY `alive` (`alive`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1; ";
	$canContinue = $istance->dbi_execute ( $query ); 
	Message ( 'pkr_alive created: ', $canContinue ); if (!$canContinue) return false;

	$query = "DROP TABLE IF EXISTS `pkr_card`;";
	$canContinue = $istance->dbi_execute ( $query );
	
$query = "CREATE TABLE `pkr_card` (
  `game` int(20) NOT NULL,
  `seq` smallint(2) unsigned default NULL COMMENT '52',
  `number` varchar(2) NOT NULL COMMENT '1,2,3,4,5,6,7,8,9,10,J,Q,K',
  `seed` varchar(1) NOT NULL COMMENT 'c,q,f,p',
  PRIMARY KEY  (`game`,`number`,`seed`),
  KEY `number` (`number`,`seed`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1; ";
	$canContinue = $istance->dbi_execute ( $query );
	Message ( 'pkr_card created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_dealer`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_dealer` (
  `idtable` int(20) NOT NULL,
  `game` int(20) NOT NULL,
  `seat` tinyint(2) NOT NULL,
  `player` int(20) NOT NULL,
  `card` varchar(2) NOT NULL,
  `seed` varchar(2) NOT NULL,
  `number` tinyint(1) default '1' COMMENT '1,2',
  PRIMARY KEY  (`idtable`,`game`,`seat`,`player`,`card`,`seed`),
  KEY `card` (`card`,`seed`),
  KEY `game` (`game`),
  KEY `seat` (`seat`),
  KEY `player` (`player`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );
	Message ( 'pkr_dealer created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_game`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_game` (
  `idgame` int(20) NOT NULL auto_increment,
  `idtable` int(20) NOT NULL,
  `tot_pot` double(10,2) default '0.00',
  `d` tinyint(2) NOT NULL,
  `endround_seat` tinyint(2) NOT NULL,
  `endround_nextseat` tinyint(1) NOT NULL default '0',
  `all_allin` tinyint(1) NOT NULL default '0',
  `end` tinyint(1) default '0',
  PRIMARY KEY  (`idgame`,`idtable`),
  KEY `idtable` (`idtable`),
  KEY `end` (`end`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );
	Message ( 'pkr_game created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_game_fold`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_game_fold` (
  `idtable` int(20) NOT NULL,
  `game` int(20) NOT NULL,
  `player` int(20) NOT NULL,
  `seat` tinyint(2) default NULL,
  `idpost` int(20) NOT NULL,
  PRIMARY KEY  (`idtable`,`game`,`player`),
  KEY `game` (`game`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );
	Message ( 'pkr_game_fold created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_game_win`;";
	$canContinue = $istance->dbi_execute ( $query );							
	
	$query = "CREATE TABLE `pkr_game_win` (
  `idgame_win` int(20) NOT NULL auto_increment,
  `idtable` int(20) NOT NULL,
  `game` int(20) NOT NULL,
  `player` int(20) NOT NULL,
  `seat` tinyint(2) NOT NULL,
  `rank` varchar(50) default NULL,
  `best5` varchar(50) default NULL,
  `high` varchar(2) default NULL,
  `high_s` varchar(2) default NULL,
  `card1` varchar(2) default NULL,
  `seed1` varchar(2) default NULL,
  `card2` varchar(2) default NULL,
  `seed2` varchar(2) default NULL,
  `card3` varchar(2) default NULL,
  `seed3` varchar(2) default NULL,
  `card4` varchar(2) default NULL,
  `seed4` varchar(2) default NULL,
  `card5` varchar(2) default NULL,
  `seed5` varchar(2) default NULL,
  `pot` double(20,2) default '0.00',
  `number` tinyint(3) NOT NULL default '1',
  PRIMARY KEY  (`idgame_win`,`idtable`,`game`,`player`),
  KEY `idtable` (`idtable`,`game`,`seat`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );
	Message ( 'pkr_game_win created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_hand`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_hand` (
  `idhand` int(20) NOT NULL auto_increment,
  `idtable` int(20) NOT NULL,
  `game` int(20) NOT NULL,
  `type_hand` varchar(30) NOT NULL COMMENT 'postblinds,holecards,preflop,burning,flop,2bet,burning,turn,3bet,burning,river,4bet,showdown',
  PRIMARY KEY  (`idhand`,`idtable`,`game`),
  KEY `type_hand` (`type_hand`),
  KEY `game` (`game`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );
	Message ( 'pkr_hand created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_msg`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_msg` (
  `idmsg` int(20) NOT NULL auto_increment,
  `idtable` int(20) NOT NULL,
  `game` int(20) NOT NULL,
  `player` int(20) NOT NULL,
  `time` int(20) default NULL,
  `msg` varchar(80) default NULL,
  `type` tinyint(1) default '0' COMMENT '0 system',
  PRIMARY KEY  (`idmsg`),
  KEY `idtable` (`idtable`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );					
	Message ( 'pkr_msg created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_player`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_player` (
  `idplayer` int(20) NOT NULL auto_increment,
  `usr` varchar(20) default NULL,
  `pswd` varchar(32) default NULL,
  `mail` varchar(255) default NULL,
  `city` varchar(70) default NULL,
  `facepic` varchar(255) default NULL,
  `isc_date` bigint(20) default NULL,
  `money` double(10,2) default '0.00',
  `virtual_money` double(10,2) default '1000.00',
  `n_credit_update` int(10) NOT NULL default '1',
  `ptg` double(10,0) NOT NULL default '0',
  `supporter` tinyint(3) default '0',
  `bonus` tinyint(3) NOT NULL default '0',
  `confirmed` tinyint(1) default '0',
  `ip` varchar(15) NOT NULL,
  `sess` varchar(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `lastenter` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `lastgetcredit` timestamp NOT NULL default '0000-00-00 00:00:00',
  `isbot` tinyint(1) default '0',
  PRIMARY KEY  (`idplayer`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );					
	Message ( 'pkr_player created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_post`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_post` (
  `idpost` int(20) NOT NULL auto_increment,
  `idtable` int(20) NOT NULL,
  `game` int(20) NOT NULL,
  `number` tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (`idpost`,`idtable`,`game`),
  KEY `number` (`number`),
  KEY `game` (`game`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );					
	Message ( 'pkr_post created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_room`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_room` (
  `idroom` int(20) NOT NULL auto_increment,
  `name` varchar(50) default NULL,
  `password` varchar(100) default NULL,
  `type` tinyint(1) default '0',
  `status` tinyint(1) default '1',
  PRIMARY KEY  (`idroom`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );					
	Message ( 'pkr_room created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "insert into `pkr_room` (`idroom`,`name`,`status`) values (1,'External Public Room',1);";
	$canContinue = $istance->dbi_execute ( $query );	
	Message ( '[External Public Room] created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_seat`;";
	$canContinue = $istance->dbi_execute ( $query );
		
	$query = "CREATE TABLE `pkr_seat` (
  `idtable` int(20) NOT NULL default '0',
  `player` int(20) default NULL,
  `seat_number` tinyint(2) NOT NULL default '0',
  `outnexthand` tinyint(1) default '0',
  `status` tinyint(1) default '0' COMMENT '0 sittingout,1 sitting idle,2 playing',
  PRIMARY KEY  (`idtable`,`seat_number`),
  KEY `seat_number` (`seat_number`),
  KEY `status` (`status`),
  KEY `player` (`player`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );
	Message ( 'pkr_seat created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_subhand`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_subhand` (
  `idsubhand` int(20) NOT NULL auto_increment,
  `hand` int(20) NOT NULL,
  `idtable` int(20) NOT NULL,
  `game` int(20) NOT NULL,
  `player` int(20) NOT NULL,
  `type_subhand` varchar(20) NOT NULL default 'postsb' COMMENT 'postsb,postbb,fold,check,bet,raise',
  `seat_number` tinyint(2) NOT NULL,
  `time` bigint(20) NOT NULL,
  `response` varchar(20) default NULL,
  `status` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`idsubhand`,`hand`,`idtable`,`game`,`player`),
  KEY `type_subhand` (`type_subhand`),
  KEY `hand` (`hand`),
  KEY `game` (`game`),
  KEY `player` (`player`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );	
	Message ( 'pkr_subhand created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_subpost`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_subpost` (
  `idsubpost` int(20) NOT NULL auto_increment,
  `idtable` int(20) NOT NULL,
  `game` int(20) NOT NULL,
  `idpost` int(20) NOT NULL,
  `player` int(20) NOT NULL,
  `seat` tinyint(2) NOT NULL,
  `post` double(10,2) default NULL,
  `isallin` tinyint(1) default '0' COMMENT '0 no, 1 si',
  PRIMARY KEY  (`idsubpost`,`idtable`,`game`,`idpost`,`player`,`seat`),
  KEY `idpost` (`idpost`),
  KEY `game` (`game`),
  KEY `player` (`player`),
  KEY `isallin` (`isallin`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );	
	Message ( 'pkr_subpost created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_table`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_table` (
  `idtable` int(20) NOT NULL auto_increment,
  `room` int(5) default '0',
  `name` varchar(20) default NULL,
  `stakes_min` int(5) default NULL COMMENT '5/10,...,1000/10000',
  `stakes_max` int(10) default NULL,
  `created` bigint(20) default NULL,
  `limited` varchar(2) NOT NULL default 'NL' COMMENT 'PL,NL,Fixed',
  `max_plrs` tinyint(3) NOT NULL default '10' COMMENT '2,3,4,5,6,7,8,9,10',
  `all_in` tinyint(1) NOT NULL default '1' COMMENT '0 no,1 si',
  `fast` tinyint(1) NOT NULL default '0',
  `type` tinyint(1) NOT NULL default '0' COMMENT '0 chip, 1 money',
  `type_game` varchar(20) NOT NULL default 'holdem' COMMENT 'holdem,5cards',
  PRIMARY KEY  (`idtable`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );	
	Message ( 'pkr_table created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "insert into `pkr_table` (`idtable`,`room`,`name`,`stakes_min`,`stakes_max`,`created`,`limited`,`max_plrs`,`all_in`,`fast`,`type`,`type_game`) values (1,0,'First Field',5,10,1193130205,'NL',6,1,0,0,'holdem');";
	$canContinue = $istance->dbi_execute ( $query );	
	Message ( '[First Field] Room 0 Table created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "insert into `pkr_seat` values (1,0,1,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (1,0,2,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (1,0,3,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (1,0,4,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (1,0,5,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (1,0,6,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	
	$query = "insert into `pkr_table` (`idtable`,`room`,`name`,`stakes_min`,`stakes_max`,`created`,`limited`,`max_plrs`,`all_in`,`fast`,`type`,`type_game`) values (2,1,'Super Poker',5,10,1193130205,'NL',6,1,0,0,'holdem');";
	$canContinue = $istance->dbi_execute ( $query );	
	Message ( '[Super Poker] Room 1 Table created: ', $canContinue ); if (!$canContinue) return false;	
	
	$query = "insert into `pkr_seat` values (2,0,1,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (2,0,2,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (2,0,3,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (2,0,4,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (2,0,5,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	$query = "insert into `pkr_seat` values (2,0,6,0,0);";
	$canContinue = $istance->dbi_execute ( $query );	
	
	$query = "DROP TABLE IF EXISTS `pkr_tablecash`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_tablecash` (
  `idtable` int(20) NOT NULL,
  `idplayer` int(20) NOT NULL,
  `virtual_money` double(10,2) NOT NULL default '0.00',
  `money` double(10,2) NOT NULL default '0.00',
  PRIMARY KEY  (`idtable`,`idplayer`),
  KEY `idplayer` (`idplayer`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );						
	Message ( 'pkr_tablecash created: ', $canContinue ); if (!$canContinue) return false;
	
	$query = "DROP TABLE IF EXISTS `pkr_typepost`;";
	$canContinue = $istance->dbi_execute ( $query );
	
	$query = "CREATE TABLE `pkr_typepost` (
  `idtypepost` int(20) NOT NULL auto_increment,
  `idtable` int(20) NOT NULL,
  `game` int(20) NOT NULL,
  `idpost` int(20) NOT NULL,
  `number` tinyint(2) NOT NULL,
  `post` double(20,2) default '0.00',
  `seat` tinyint(2) NOT NULL,
  PRIMARY KEY  (`idtypepost`,`idtable`,`game`,`idpost`,`number`),
  KEY `idtable` (`idtable`,`game`),
  KEY `number` (`number`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;";
	$canContinue = $istance->dbi_execute ( $query );						
	Message ( 'pkr_typepost created: ', $canContinue ); if (!$canContinue) return false;

	return true;
}

?>
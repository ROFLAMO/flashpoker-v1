<?php
include 'dbi5php.php';

// Global settings for dbi4php
$GLOBALS['db_type'] = 'mysqli';
$GLOBALS["db_persistent"] = false;

/**
 * Db Class 
 *
 * Class used to manage database
 * Use Abstraction db connectino
 * 
 */
class Db 
{	
	private static $istance;
	private static $conn = null;	
	private static $db_host;
	private static $db_login;
	private static $db_password;
	private static $db_database;
	
	/**
	 * Constructor
	 *
	 * Init connection to database setting host, login, password and database 
	 */	
	function Db() 
	{
		self::$istance = dbi5php::getInstance();		
		self::$db_host = DB_ADDRESS;
		self::$db_login = DB_USER;
		self::$db_password = DB_PASS;
		self::$db_database = DB_NAME;		
		$this->connect();		
		$GLOBALS['mydb'] = $this;
	}
	
	/**
	 * Connect
	 *
	 * Open connection to database
	 */	
	public function connect() 
	{
		self::$conn = self::$istance->dbi_connect ( self::$db_host, self::$db_login, self::$db_password, self::$db_database );

		if ( ! self::$conn ) {
			DB::dbErrorHandler($query, self::$istance->dbi_error (),"connect()");
		}
			
		//self::$no_autocommit();
	}

	/**
	 * Disconnect
	 *
	 * Close connection to database
	 */			
	public function disconnect() {	
		self::$istance->dbi_close (self::$conn);
		unset($GLOBALS['mydb']);
	}
	
	/**
	* Get Last Insert Id
	*
	* Get last id into database
	*
	* @return int
	*/	
	public function getlastinsertid()
	{
		return self::$istance->dbi_getlastinsertid();	
	}
	
	/**
	* Database Error Handler
	*
	* Db error Handler
	*
	* @access public
	* @params string $query
	* @params string $err
	* @params string $func
	*/
	public function dbErrorHandler($query, $err, $func) {
		if (isset($GLOBALS['mylog'])) {
	 		$GLOBALS['mylog']->log(PKR_LOG_DEBUG,"DB",$func,join(',',$_REQUEST),$query."  Error: ".$err);
 		} else {
		 	echo "Error; ".$err." - ".$query;
		 	if ((strpos($err,"Unknown error")!==false) || 
		 		(strpos($err,"doesn't exist")!==false))
		 		header("Location: ../install.php");
		 	exit();
	 	}	 		
	}
	
	/**
	* Select Single Field
	*
	* Return an associative array from select to database
	*
	* @param string $query
	* @param string $field
	* @return array
	*/	
	public function select_singlefield($query, $field)
	{
		$res = self::$istance->dbi_query ( $query );
		
		if ( ! $res ) {
		 	DB::dbErrorHandler($query, self::$istance->dbi_error(),"select_singlefield()");
		}
		
		$rows = null;
		$i=0;
		while ($row = self::$istance->dbi_fetch_row ( $res ))
		{
			$rows[$i]=$row[$field];
			$i++;
		}
		
		return $rows;		
	}
	
	/**
	* Select Tables
	*
	* Return an associative array of tables and relative playing/idle/sitting players
	*
	* @param string $query
	* @return array
	*/		
	public function select_tables($query)
	{	
		$res = self::$istance->dbi_query ( $query );
		
		if ( ! $res ) {
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"select_tables()");
		}
		
		$i=0;
		while ($row = self::$istance->dbi_fetch_row ( $res ))
		{
			$rows[$i] = $row;
			$rows[$i]["min_to_play"] = ($row["stakes_min"] * PKR_STAKESPLAY_COEFF).PKR_CURRENCY_SYMBOL;
			$rows[$i]["max_to_play"] = ($row["stakes_max"] * PKR_STAKESPLAY_COEFF).PKR_CURRENCY_SYMBOL;
			
			if (!empty($row["idtable"])) {
				$q2 = "select usr,city,virtual_money from pkr_player where idplayer in (select player from pkr_seat where idtable=".$row["idtable"]." and (status=".SITTINGIDLE." or status=".SITTING."))";
				$rows[$i]["idles"] = $this->select($q2);
				$rows[$i]["waiting"] = count($rows[$i]["idles"]);
							
				$q1 = "select usr,city,virtual_money from pkr_player where idplayer in (select player from pkr_seat where idtable=".$row["idtable"]." and status=".PLAYING.")";
				$rows[$i]["players"] = $this->select($q1);
				$rows[$i]["playing"] = count($rows[$i]["players"]);
			}			
			$i++;	
		}
			
		return $rows;
			
	}

	/**
	* Special Select
	*
	* Return an associative array from a special select array
	*
	* @param string $query
	* @param string $field
	* @return array
	*/			
	public function special_select($query, $field)
	{	
		$res = self::$istance->dbi_query ( $query );
		
		if ( ! $res ) {
		  DB::dbErrorHandler($query, self::$istance->dbi_error(),"special_select()");
		}
		
		while ($row = self::$istance->dbi_fetch_row ( $res )) {
			$rows[$row[$field]]=$row;
		}
		
		if (isset($rows))
			return $rows;
		else
			return null;
	}
	
	/**
	* No Autocommit
	*
	* Set to false autocommit
	*/	
	public function no_autocommit()
	{
		$query = "SET AUTOCOMMIT=0";
		if ( ! self::$istance->dbi_execute ( $query ) ) {
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"no_autocommit()");
		}			
	}
	
	/**
	* Select
	*
	* Doing a select into database
	*
	* @param string $query
	* @return array
	*/	
	public function select($query)
	{	
		$res = self::$istance->dbi_query ( $query );
		
		if ( ! $res ) {
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"select()");
		}
		
		$i=0;
		while ($row = self::$istance->dbi_fetch_row ( $res ))
		{
			$rows[$i]=$row;
			$i++;	
		}
		
		if (isset($rows))
			return $rows;
		else
			return null;
			
	}
	
	/**
	* executeQuery
	*
	* Execute a generic query that contain INSERT,UPDATE,DELETE
	*
	* @param string $query
	* @param array $params
	*/	
	public function executeQuery($query,$params = null)
	{
		if ( ! self::$istance->dbi_execute ( $query, $params ) ) {
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"executeQuery()");
		}			
	}	
	
	/**
	* Update
	*
	* Doing an update into database
	*
	* @param string $query
	* @param array $params
	*/	
	public function update($query,$params = null)
	{
		if ( ! self::$istance->dbi_execute ( $query, $params ) ) {
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"update()");
		}			
	}
	
	/**
	* Insert
	*
	* Doing an insert into database
	*
	* @param string $query
	* @param array $params
	* @param bool $return_id
	* @return int
	*/
	public function insert($query,$params = null,$return_id = false)
	{
		if (! self::$istance->dbi_execute ( $query, $params ) ) {
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"insert()");
		}
		if ($return_id)
			return self::$istance->getlastinsertid();
	}
	
	/**
	* Delete
	*
	* Doing a delete into database
	*
	* @param string $query
	* @param array $params
	*/
	public function delete($query,$params = null)
	{	
		if (!self::$istance->dbi_execute ( $query, $params ) ) {
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"delete()");	  
		}		
	}	
	
	/**
	* Optimize
	*
	* Doing an optimize of tables into database
	*
	* @param string $tbl
	*/	
	public function optimize($tbl)
	{
		$query = "optimize table ".$tbl;
		if (!self::$istance->dbi_execute ($query, mull)) {
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"delete()");	  
		}				
	}

	/**
	* Lock Table
	*
	* Doing a lock on table into database
	*
	* @param string $tbl
	* @param string $locktype
	*/
	public function lockTable($tbl,$locktype = "WRITE")
	{
		//$query = "LOCK TABLES Class WRITE, Student WRITE";
		$query = "LOCK TABLES ".$tbl." ".$locktype;
		self::$istance->dbi_query ( $query );
	}

	/**
	* UnLock Table
	*
	* Doing a unlock on table into database
	*/	
	public function unlockTable()
	{
		//$query = "LOCK TABLES Class WRITE, Student WRITE";
		$query = "UNLOCK TABLES";
		self::$istance->dbi_query ( $query );
	}	

	/**
	* Optimize Table
	*
	* Doing an optimize table into database
	*
	* @param string $tbl
	*/	
	public function optimizeTable($tbl = null)
	{
		if (isset($tbl))
		{
		   	$query = "OPTIMIZE TABLE ".$tbl;
			if (!self::$istance->dbi_execute ($query,null))
				DB::dbErrorHandler($query, self::$istance->dbi_error(),"optimize()");			
		}
		else 
		{
			$qry = "SHOW TABLES";
			$res = self::$istance->dbi_query($qry);
			while ($table = self::$istance->dbi_fetch_row ($res))
			{		
			   
			   foreach ($table as $db => $tablename)
			   {				   
				   	$query = "OPTIMIZE TABLE ".$tablename;
					if (!self::$istance->dbi_execute ($query,null))
						DB::dbErrorHandler($query, self::$istance->dbi_error(),"optimize()");	  	          
			   }		  
			}
		}
	}
	
	/**
	* Update Credit
	*
	* Set all player credit to a default value (PKR_DEFAUL_GET_CREDIT)
	*/	
	public function updateCredit()
	{
		$query = "update pkr_player set n_credit_update = 1, virtual_money = ".PKR_DEFAUL_GET_CREDIT;
		if (!self::$istance->dbi_execute ($query,null))
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"updateCredit()");
	}	
	
	/**
	* Reset Seats
	*
	* Reset all tables seat
	*/		
	public function resetSeats()
	{
		$query = "update pkr_seat set status=0, player=0";
		if (!self::$istance->dbi_execute ($query,null))
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"resetSeats()");		
	}
	
	/**
	* Reset Games
	*
	* Del all games from database using a truncate on game table
	*/		
	public function resetGames()
	{
		$arr_tbls = array("pkr_game","pkr_hand","pkr_subhand","pkr_dealer","pkr_card","pkr_post","pkr_subpost","pkr_game_fold","pkr_game_win","pkr_msg","pkr_typepost");
		foreach ($arr_tbls as $tbl) {
			$query = "truncate ".$tbl;
			if (!self::$istance->dbi_execute ($query,null))
				DB::dbErrorHandler($query, self::$istance->dbi_error(),"resetGames()");	
		}		
	}
	
	/**
	* Init Db
	*
	* Truncate all database tables
	*/	
	public function initdb($truncateAll = false, $upd_credit = false, $optimizeAll = false)
	{
		if ($truncateAll) 
			self::$resetGames();
		
		if ($optimizeAll)
			self::$optimizeTable();
		
		if ($upd_credit)
			self::$updateCredit();
	}

	/**
	* Reset Db
	*
	* Reset all db users
	*/	
	public function resetdb(&$array_bonus)
	{	
		$res = self::$istance->dbi_query ( "select idplayer,virtual_money,supporter,bonus from pkr_player where confirmed = 1" );
		
		if ( ! $res ) {
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"resetdb()");
		}
		
		while ($row = self::$istance->dbi_fetch_row ( $res ))
		{
			//echo "<br>".$row['idplayer']." prima ".$row['virtual_money']." - dopo [".$array_bonus[$row['bonus']]." + ".($row['virtual_money']/10)."+".PKR_DEFAUL_GET_CREDIT."] = ";
			
			if ($row['supporter']>0)
				$new_vmoney = floor($row['virtual_money']/10) + PKR_DEFAUL_GET_CREDIT + $array_bonus[$row['bonus']];
			else
				$new_vmoney = PKR_DEFAUL_GET_CREDIT;
				
			$q = "update pkr_player set n_credit_update = 1, virtual_money = ? where idplayer = ?";
			$p = array($new_vmoney, $row['idplayer']);
			
			if (!self::$istance->dbi_execute ($q, $p))
				DB::dbErrorHandler($query, self::$istance->dbi_error(),"resetdb() on idplayer ".$row['idplayer']);
				
			//echo $new_vmoney;
		}		
			
		unset($p);
	}	
	
	/**
	* table exists
	*
	* Check if table exists. Used for View or Temporary Tables
	* @param string $table
	* @return bool
	*/	
	public function table_exists ($table) 
	{
		$query = "SHOW TABLES LIKE '".$table."'";
		
		switch ($GLOBALS['db_type'])
		{
			case 'mysql':
				if (mysql_num_rows(mysql_query($query))==1) 
					return true;
				else
					return false;
			break;
			
			case 'mysqli':
				if (mysqli_num_rows(mysqli_query($GLOBALS["db_connection"],$query))==1) 
					return true;
				else
					return false;			
			break;
		}
		
	    /*
	    $tables = mysql_list_tables ($db);
	    while (list ($temp) = mysql_fetch_array ($tables)) {
	        if ($temp == $table) {
	            return TRUE;
	        }
	    }
	    return FALSE;
	    */
	}
	
	/**
	* Create View
	*
	* Create a View
	* @param string $name_view 
	* @param string $sub_query 
	*/	
	public function create_view($name_view,$sub_query)
	{
		$query = "CREATE VIEW ".$name_view." AS ".$sub_query;
		if (!self::$istance->dbi_execute ($query,null))
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"create_view()");
	}
	
	/**
	* Create Table
	*
	* Create a Table
	* @param string $name_view 
	* @param string $sub_query 
	*/	
	public function create_table($name_view,$sub_query)
	{
		$query = "CREATE TABLE IF NOT EXISTS ".$name_view." (".$sub_query.")";
		if (!self::$istance->dbi_execute ($query,null))
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"create_table()");
	}
	
	/**
	* Drop Table
	*
	* Drop a Table
	* @param string $nametbl default is VIEWTBL temporary View ranking table 
	*/	
	public function drop_table($nametbl = VIEWTBL)
	{
		$query = "DROP TABLE IF EXISTS ".$nametbl;
		if (!self::$istance->dbi_execute ($query,null))
			DB::dbErrorHandler($query, self::$istance->dbi_error(),"drop_table()");
	}
}
?>
<?php
/**
* dbi5php - Generic Singleton database access for PHP5
*
* The functions defined in this file are meant to provide a single API to the
* different PHP database APIs.  Unfortunately, this is necessary since PHP
* does not yet have a common db API.  The value of
* <var>$GLOBALS["db_type"]</var> should be defined somewhere to one of the
* following:
* - mysql
* - mysqli
* - mssql
* - oracle (This uses the Oracle8 OCI API, so Oracle 8 libs are required)
* - postgresql
* - odbc
* - ibase (Interbase)
* - sqlite
* - ibm_db2
* <b>Limitations:</b>
* - This assumes a single connection to a single database for the sake of
*   simplicity.  Do not make a new connection until you are completely
*   finished with the previous one.  However, you can execute more than query
*   at the same time.
* - Rather than use the associative arrays returned with xxx_fetch_array(),
*   normal arrays are used with xxx_fetch_row().  (Some db APIs don't support
*   xxx_fetch_array().)
*
* @version 1.0
* @package dbi5php
*/
class dbi5php
{
	private static $return_false_on_error = true;
	private static $old_textlimit = "";
	private static $old_textsize = "";
	
	// object instan
	private static $instance;
	
	/**
	* Private constructor
	* 
	*/
	private function __construct() {	
	}
	
	/** 
	*The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
	* thus eliminating the possibility of duplicate objects.  The methods can be empty, or
	* can contain additional code (most probably generating error messages in response
	* to attempts to call).
	*
	*/
	public function __clone() {
		trigger_error('Clone is not allowed.', E_USER_ERROR);
	}
	public function __wakeup() {
		trigger_error('Deserializing is not allowed.', E_USER_ERROR);
	}
	
	/**
	* This method must be static, and must return an instance of the object if the object
	* does not already exist.
	*
	*/
	public static function getInstance() {
		if (!self::$instance instanceof self) { 
		  self::$instance = new self;
		}
		return self::$instance;
	}
	
	/**
	* Open up a database connection.
	*
	* Use a pooled connection if the db supports it and
	* the <var>db_persistent</var> setting is enabled.
	*
	* <b>Notes:</b>
	* - The database type is determined by the global variable
	*   <var>db_type</var>
	* - For ODBC, <var>$host</var> is ignored, <var>$database</var> = DSN
	* - For Oracle, <var>$database</var> = tnsnames name
	* - Use the {@link $this->dbi_error()} function to get error information if the connection
	*   fails
	*
	* @param string $host     Hostname of database server
	* @param string $login    Database login
	* @param string $password Database login password
	* @param string $database Name of database
	* 
	* @return resource The connection
	*/
	public function dbi_connect ( $host, $login, $password, $database ) 
	{
		if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) {
		if ($GLOBALS["db_persistent"]) {
		  $c = mysql_pconnect ( $host, $login, $password );
		} else {
		  $c = mysql_connect ( $host, $login, $password );
		}
		if ( $c ) {
		  if ( ! mysql_select_db ( $database ) )
		    return false;
		  return $c;
		} else {
		  return false;
		}
		} else if ( strcmp ( $GLOBALS["db_type"], "mysqli" ) == 0 ) {
		if ($GLOBALS["db_persistent"]) {
		  $c = @mysqli_connect ( $host, $login, $password, $database);
		} else {
		  $c = @mysqli_connect ( $host, $login, $password, $database);
		}
		if ( $c ) {
		  /*
		  if ( ! mysqli_select_db ( $c, $database ) )
		    return false;
		  */
		  $GLOBALS["db_connection"] = $c;
		  return $c;
		} else {
		  return false;
		}
		} else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
		self::$old_textlimit = ini_get ( 'mssql.textlimit' );
		self::$old_textsize = ini_get ( 'mssql.textsize' );
		ini_set( 'mssql.textlimit', '2147483647' );
		ini_set( 'mssql.textsize', '2147483647' );
		if ($GLOBALS["db_persistent"]) {
		  $c = mssql_pconnect ( $host, $login, $password );
		} else {
		  $c = mssql_connect ( $host, $login, $password );
		}
		if ( $c ) {
		  if ( ! mssql_select_db ( $database ) )
		    return false;
		  return $c;
		} else {
		  return false;
		}
		} else if ( strcmp ( $GLOBALS["db_type"], "oracle" ) == 0 ) {
		if ( strlen ( $host ) && strcmp ( $host, "localhost" ) )
		  $c = OCIPLogon ( "$login@$host", $password, $database );
		else
		  $c = OCIPLogon ( $login, $password, $database );
		$GLOBALS["oracle_connection"] = $c;
		return $c;
		} else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
		if ( strlen ( $password ) ) {
		  if ( strlen ( $host ) ) {
		    $dbargs = "host=$host dbname=$database user=$login password=$password";
		  } else {
		    $dbargs = "dbname=$database user=$login password=$password";
		  }
		} else {
		  if ( strlen ( $host ) ) {
		    $dbargs = "host=$host dbname=$database user=$login";
		  } else {
		    $dbargs = "dbname=$database user=$login";
		  }
		}
		if ($GLOBALS["db_persistent"]) {
		  $c = pg_pconnect ( $dbargs );
		} else {
		  $c = pg_connect ( $dbargs );
		}
		$GLOBALS["postgresql_connection"] = $c;
		if ( ! $c ) {
		    return false;    
		}
		return $c;
		} else if ( strcmp ( $GLOBALS["db_type"], "odbc" ) == 0 ) {
		if ($GLOBALS["db_persistent"]) {
		  $c = odbc_pconnect ( $database, $login, $password );
		} else {
		  $c = odbc_connect ( $database, $login, $password );
		}
		$GLOBALS["odbc_connection"] = $c;
		return $c;
		} else if ( strcmp ( $GLOBALS["db_type"], "ibm_db2" ) == 0 ) {
		if ($GLOBALS["db_persistent"]) {
		  $c = db2_pconnect ( $database, $login, $password );
		} else {
		  $c = db2_connect ( $database, $login, $password );
		}
		$GLOBALS["ibm_db2_connection"] = $c;
		return $c;
		} else if ( strcmp ( $GLOBALS["db_type"], "ibase" ) == 0 ) {
		$host = $host . ":" . $database;
		if ($GLOBALS["db_persistent"]) {
		  $c = ibase_pconnect ( $host, $login, $password );
		} else {
		  $c = ibase_connect ( $host, $login, $password );
		}
		return $c;
		} else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
		if ($GLOBALS["db_persistent"]) {
		  $c = sqlite_popen ( $database, 0666, $sqliteerror);
		} else {
		  $c = sqlite_open ( $database, 0666, $sqliteerror);
		}
		if ( ! $c ) {   
		  echo "Error connecting to database\n";
		  exit;
		}
		 $GLOBALS["sqlite_c"]  = $c;
		return $c;
		} else {
		if ( empty ( $GLOBALS["db_type"] ) )
		  $this->dbi_fatal_error ( "dbi_connect(): db_type not defined." );
		else
		  $this->dbi_fatal_error ( "dbi_connect(): invalid db_type '" .
		    $GLOBALS["db_type"] . "'" );
		}
	}
	
	/**
	* Get Last inserted id
	*
	* Get last inserted id from last connection
	*
	* @return int last id
	*/
	public function dbi_getlastinsertid() {
		switch ($GLOBALS["db_type"])
		{
			case 'mysql':
				return mysql_insert_id();
			break;
		
			case 'mysqli':
				return mysqli_insert_id($GLOBALS["db_connection"]);
			break;
			
			default:
				echo "error ins function like mysql_insert_id()";
			break;
		}
	}
	
	/**
	* Close a database connection.
	*
	* This is not necessary for any database that uses pooled connections such as
	* MySQL, but a good programming practice.
	*
	* @param resource $conn The database connection
	*
	* @return bool True on success, false on error
	*/
	public function dbi_close ( $conn ) 
	{
		if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) {
		return mysql_close ( $conn );
		} else if ( strcmp ( $GLOBALS["db_type"], "mysqli" ) == 0 ) {
		return mysqli_close ( $conn );
		} else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
		if ( ! empty ( self::$old_textlimit ) ) {
		  ini_set( 'mssql.textlimit', self::$old_textlimit );
		  ini_set( 'mssql.textsize', self::$old_textsize );        
		}
		return mssql_close ( $conn );
		} else if ( strcmp ( $GLOBALS["db_type"], "oracle" ) == 0 ) {
		return OCILogOff ( $conn );
		} else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
		return pg_close ( $GLOBALS["postgresql_connection"] );
		} else if ( strcmp ( $GLOBALS["db_type"], "odbc" ) == 0 ) {
		return odbc_close ( $GLOBALS["odbc_connection"] );
		} else if ( strcmp ( $GLOBALS["db_type"], "ibm_db2" ) == 0 ) {
		return db2_close ( $GLOBALS["ibm_db2_connection"] );
		} else if ( strcmp ( $GLOBALS["db_type"], "ibase" ) == 0 ) {
		return ibase_close ( $conn );
		} else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
		return sqlite_close ( $conn );
		} else {
		$this->dbi_fatal_error ( "dbi_close(): db_type not defined." );
		}
	}
	
	/**
	* Execute a SQL query.
	*
	* <b>Note:</b> Use the {@link $this->dbi_error()} function to get error information
	* if the connection fails.
	*
	* @param string $sql          SQL of query to execute
	* @param bool   $fatalOnError Abort execution if there is a database error?
	* @param bool   $showError    Display error to user (including possibly the
	*                             SQL) if there is a database error?
	*
	* @return mixed The query result resource on queries (which can then be
	*               passed to the {@link $this->dbi_fetch_row()} function to obtain the
	*               results), or true/false on insert or delete queries.
	*/
	public function dbi_query ( $sql, $fatalOnError=true, $showError=true ) 
	{
		if (USE_MEMCACHE) 
		{
			if ($res = $GLOBALS['memcache']->get(MD5($sql)))
				return $res;
			else 
			{								
				global $phpdbiVerbose;
				if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) 
				{
					$res = mysql_query ( $sql );
					if ( ! $res )
					  $this->dbi_fatal_error ( "Error executing query." .
					    $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
					    "", $fatalOnError, $showError );
					    
					$GLOBALS['memcache']->set(MD5($sql), $res, 0, MEMCACHE_TIMEOUT);
					//$GLOBALS['memcache']->close();
					
					return $res;			
				} else if ( strcmp ( $GLOBALS["db_type"], "mysqli" ) == 0 ) {
				$res = mysqli_query ( $GLOBALS["db_connection"], $sql );
					if ( ! $res )
					  $this->dbi_fatal_error ( "Error executing query." .
					    $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
					    "", $fatalOnError, $showError );
					return $res;
				} else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
					$res = mssql_query ( $sql );
					if ( ! $res )
					  $this->dbi_fatal_error ( "Error executing query." .
					    $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
					    "", $fatalOnError, $showError );
					return $res;
				} else if ( strcmp ( $GLOBALS["db_type"], "oracle" ) == 0 ) {
					$GLOBALS["oracle_statement"] =
					  OCIParse ( $GLOBALS["oracle_connection"], $sql );
					return OCIExecute ( $GLOBALS["oracle_statement"],
					  OCI_COMMIT_ON_SUCCESS );
				} else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
					$res =  pg_exec ( $GLOBALS["postgresql_connection"], $sql );
					if ( ! $res )
					  $this->dbi_fatal_error ( "Error executing query." .
					    $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
					    "", $fatalOnError, $showError );
					return $res;
				} else if ( strcmp ( $GLOBALS["db_type"], "odbc" ) == 0 ) {
					return odbc_exec ( $GLOBALS["odbc_connection"], $sql );
				} else if ( strcmp ( $GLOBALS["db_type"], "ibm_db2" ) == 0 ) {
					$res = db2_exec ( $GLOBALS["ibm_db2_connection"], $sql );
					if ( ! $res )
					  $this->dbi_fatal_error ( "Error executing query." .
					    $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
					    "", $fatalOnError, $showError );
					return $res;
				} else if ( strcmp ( $GLOBALS["db_type"], "ibase" ) == 0 ) {
					$res = ibase_query ( $sql );
					if ( ! $res )
					  $this->dbi_fatal_error ( "Error executing query." .
					    $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
					    "", $fatalOnError, $showError );
					return $res;
				} else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
					$res = sqlite_query ( $GLOBALS["sqlite_c"], $sql, SQLITE_NUM );
					if ( ! $res )
					  $this->dbi_fatal_error ( "Error executing query." .
					    $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
					    "", $fatalOnError, $showError );
					return $res;
				} else {
					$this->dbi_fatal_error ( "dbi_query(): db_type not defined." );
				}
				}
		} 
		else 
		{
		  global $phpdbiVerbose;
		  //do_debug ("SQL:" . $sql);
		  if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) {
		    $res = mysql_query ( $sql );
		    if ( ! $res )
		      $this->dbi_fatal_error ( "Error executing query." .
		        $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
		        "", $fatalOnError, $showError );
		    return $res;
		  } else if ( strcmp ( $GLOBALS["db_type"], "mysqli" ) == 0 ) {
		    $res = mysqli_query ( $GLOBALS["db_connection"], $sql );
		    if ( ! $res )
		      $this->dbi_fatal_error ( "Error executing query." .
		        $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
		        "", $fatalOnError, $showError );
		    return $res;
		  } else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
		    $res = mssql_query ( $sql );
		    if ( ! $res )
		      $this->dbi_fatal_error ( "Error executing query." .
		        $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
		        "", $fatalOnError, $showError );
		    return $res;
		  } else if ( strcmp ( $GLOBALS["db_type"], "oracle" ) == 0 ) {
		    $GLOBALS["oracle_statement"] =
		      OCIParse ( $GLOBALS["oracle_connection"], $sql );
		    return OCIExecute ( $GLOBALS["oracle_statement"],
		      OCI_COMMIT_ON_SUCCESS );
		  } else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
		    $res =  pg_exec ( $GLOBALS["postgresql_connection"], $sql );
		    if ( ! $res )
		      $this->dbi_fatal_error ( "Error executing query." .
		        $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
		        "", $fatalOnError, $showError );
		    return $res;
		  } else if ( strcmp ( $GLOBALS["db_type"], "odbc" ) == 0 ) {
		    return odbc_exec ( $GLOBALS["odbc_connection"], $sql );
		  } else if ( strcmp ( $GLOBALS["db_type"], "ibm_db2" ) == 0 ) {
		    $res = db2_exec ( $GLOBALS["ibm_db2_connection"], $sql );
		    if ( ! $res )
		      $this->dbi_fatal_error ( "Error executing query." .
		        $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
		        "", $fatalOnError, $showError );
		    return $res;
		  } else if ( strcmp ( $GLOBALS["db_type"], "ibase" ) == 0 ) {
		    $res = ibase_query ( $sql );
		    if ( ! $res )
		      $this->dbi_fatal_error ( "Error executing query." .
		        $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
		        "", $fatalOnError, $showError );
		    return $res;
		  } else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
		    $res = sqlite_query ( $GLOBALS["sqlite_c"], $sql, SQLITE_NUM );
		    if ( ! $res )
		      $this->dbi_fatal_error ( "Error executing query." .
		        $phpdbiVerbose ? ( $this->dbi_error() . "\n\n<br />\n" . $sql ) : "" .
		        "", $fatalOnError, $showError );
		    return $res;
		  } else {
		    $this->dbi_fatal_error ( "dbi_query(): db_type not defined." );
		  }
		}
	}
	
	/**
	* Retrieve a single row from the database and returns it as an array.
	*
	* <b>Note:</b> We don't use the more useful xxx_fetch_array because not all
	* databases support this function.
	*
	* <b>Note:</b> Use the {@link $this->dbi_error()} function to get error information
	* if the connection fails.
	*
	* @param resource $res The database query resource returned from
	*                      the {@link dbi_query()} function.
	*
	* @return mixed An array of database columns representing a single row in
	*               the query result or false on an error.
	*/
	public function dbi_fetch_row ( $res , $val = MYSQL_ASSOC ) 
	{
		if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) {
		return mysql_fetch_array ( $res, $val );
		} else if ( strcmp ( $GLOBALS["db_type"], "mysqli" ) == 0 ) {
		return mysqli_fetch_array ( $res, $val  );
		} else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
		return mssql_fetch_array ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "oracle" ) == 0 ) {
		if ( OCIFetchInto ( $GLOBALS["oracle_statement"], $row,
		  OCI_NUM + OCI_RETURN_NULLS  ) )
		  return $row;
		return 0;
		} else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
		//Note:  row became optional in PHP 4.1.0.
		$r =  pg_fetch_array ( $res, NULL, PGSQL_NUM );
		    if ( ! $r ) {
		    return false;
		}
		return $r;
		} else if ( strcmp ( $GLOBALS["db_type"], "odbc" ) == 0 ) {
		if ( ! odbc_fetch_into ( $res, $ret ) )
		  return false;
		return $ret;
		} else if ( strcmp ( $GLOBALS["db_type"], "ibm_db2" ) == 0 ) {
		return db2_fetch_array ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "ibase" ) == 0 ) {
		return ibase_fetch_row ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
		return sqlite_fetch_array ( $res );
		} else {
		$this->dbi_fatal_error ( "dbi_fetch_row(): db_type not defined." );
		}
	}
	
	/**
	* Return the number of rows affected by the last INSERT, UPDATE or DELETE.
	*
	* <b>Note:</b> Use the {@link $this->dbi_error()} function to get error information
	* if the connection fails.
	*
	* @param resource $conn The database connection
	* @param resource $res  The database query resource returned from
	*                       the {@link dbi_query()} function.
	*
	* @return int The number or database rows affected.
	*/
	public function dbi_affected_rows ( $conn, $res ) 
	{
		if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) {
		return mysql_affected_rows ( $conn );
		} else if ( strcmp ( $GLOBALS["db_type"], "mysqli" ) == 0 ) {
		return mysqli_affected_rows ( $conn );
		} else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
		return mssql_rows_affected ( $conn );
		} else if ( strcmp ( $GLOBALS["db_type"], "oracle" ) == 0 ) {
		if ( $GLOBALS["oracle_statement"] >= 0 ) {
		  return OCIRowCount ( $GLOBALS["oracle_statement"] );
		} else {
		  return -1;
		}
		} else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
		return pg_affected_rows ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "odbc" ) == 0 ) {
		return odbc_num_rows ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "ibm_db2" ) == 0 ) {
		return db2_num_rows ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "ibase" ) == 0 ) {
		return ibase_affected_rows ( $conn );
		} else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
		return sqlite_changes ( $conn );
		} else {
		$this->dbi_fatal_error ( "dbi_free_result(): db_type not defined." );
		}
	}
	
	/**
	* Update a BLOB (binary large object) in the database with the contents
	* of the specified file.
	* A BLOB field should be created in a separete INSERT statement using
	* NULL as the initial value prior to this call.
	*
	* @param resource $table  the table name that contains the blob
	* @param resource $column  the table column name for the blob
	* @param resource $key  the key for updating the table row
	* @param resource $data   the data to insert
	*
	* @return bool True on success
	*/
	function dbi_update_blob ( $table, $column, $key, $data ) 
	{
		assert ( '! empty ( $table )' );
		assert ( '! empty ( $column )' );
		assert ( '! empty ( $key )' );
		assert ( '! empty ( $data )' );
		
		if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) {
		if ( function_exists ( "mysql_real_escape_string" ) )
		  return $this->dbi_execute ( "UPDATE $table SET $column = '" .
		    mysql_real_escape_string ( $data ) .
		    "' WHERE $key" );
		else {
		  return $this->dbi_execute ( "UPDATE $table SET $column = '" .
		    addslashes ( $data ) .
		    "' WHERE $key" );
		}
		} else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
		return $this->dbi_execute ( "UPDATE $table SET $column = '" .
		  sqlite_udf_encode_binary ( $data ) .
		  "' WHERE $key" );
		} else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
		return $this->dbi_execute ( "UPDATE $table SET $column = 0x" .
		  bin2hex( $data ) . 
		  " WHERE $key" );
		} else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
		return $this->dbi_execute ( "UPDATE $table SET $column = '" .
		  pg_escape_bytea ( $data ) .
		  "' WHERE $key" );
		} else {
		// TODO!
		die_miserable_death ( "Unfortunately, there is no implementation " .
		  "for dbi_update_blob for your database (" . $GLOBALS["db_type"] . ")" );
		}
	}
	
	
	/**
	* Get a BLOB (binary large object) from the database.
	*
	* @param resource $table  the table name that contains the blob
	* @param resource $column  the table column name for the blob
	* @param resource $key  the key for updating the table row
	*
	* @return bool True on success
	*/
	public function dbi_get_blob ( $table, $column, $key ) 
	{
		$ret = '';
		assert ( '! empty ( $table )' );
		assert ( '! empty ( $column )' );
		assert ( '! empty ( $key )' );
		
		if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) {
		$res = $this->dbi_execute ( "SELECT $column FROM $table WHERE $key" );
		if ( ! $res )
		  return false;
		if ( $row = $this->dbi_fetch_row ( $res ) )
		  $ret = $row[0];
		$this->dbi_free_result ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
		$res = $this->dbi_execute ( "SELECT $column FROM $table WHERE $key" );
		if ( ! $res )
		  return false;
		if ( $row = $this->dbi_fetch_row ( $res ) )
		  $ret = sqlite_udf_decode_binary ( $row[0] );
		$this->dbi_free_result ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
		$res = $this->dbi_execute ( "SELECT $column FROM $table WHERE $key" );
		if ( ! $res )
		  return false;
		if ( $row = $this->dbi_fetch_row ( $res ) )
		  $ret =  $ret = $row[0];
		$this->dbi_free_result ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
		$res = $this->dbi_execute ( "SELECT $column FROM $table WHERE $key" );
		if ( ! $res )
		  return false;
		if ( $row = $this->dbi_fetch_row ( $res ) )
		  $ret = pg_unescape_bytea ( $row[0] );
		$this->dbi_free_result ( $res );
		} else {
		// TODO!
		die_miserable_death ( "Unfortunately, there is no implementation " .
		  "for dbi_update_blob for your database (" . $GLOBALS["db_type"] . ")" );
		}
		
		return $ret;
	}
	
	/**
	* Free a result set.
	*
	* @param resource $res The database query resource returned from
	*                      the {@link dbi_query()} function.
	*
	* @return bool True on success
	*/
	public function dbi_free_result ( $res ) 
	{
		if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) {
		return mysql_free_result ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "mysqli" ) == 0 ) {
		return mysqli_free_result ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
		return mssql_free_result ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "oracle" ) == 0 ) {
		// Not supported.  Ingore.
		if ( $GLOBALS["oracle_statement"] >= 0 ) {
		  OCIFreeStatement ( $GLOBALS["oracle_statement"] );
		  $GLOBALS["oracle_statement"] = -1;
		}
		} else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
		return pg_freeresult ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "odbc" ) == 0 ) {
		return odbc_free_result ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "ibm_db2" ) == 0 ) {
		return db2_free_result ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "ibase" ) == 0 ) {
		return ibase_free_result ( $res );
		} else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
		// Not supported
		} else {
		$this->dbi_fatal_error ( "dbi_free_result(): db_type not defined." );
		}
	}
	
	/**
	* Get the latest database error message.
	*
	* @return string The text of the last database error.  (The type of
	*                information varies depending on the which type of database
	*                is being used.)
	*/
	public function dbi_error () 
	{
		if ( strcmp ( $GLOBALS["db_type"], "mysql" ) == 0 ) {
		$ret = mysql_error ();
		} else if ( strcmp ( $GLOBALS["db_type"], "mysqli" ) == 0 ) {
		//$ret = mysqli_error ($GLOBALS["db_connection"]);
		$ret = mysqli_error ($GLOBALS["db_connection"]);
		} else if ( strcmp ( $GLOBALS["db_type"], "mssql" ) == 0 ) {
		// no real mssql_error function. this is as good as it gets
		$ret = mssql_get_last_message ();
		} else if ( strcmp ( $GLOBALS["db_type"], "oracle" ) == 0 ) {
		$ret = OCIError ( $GLOBALS["oracle_connection"] );
		} else if ( strcmp ( $GLOBALS["db_type"], "postgresql" ) == 0 ) {
		$ret = pg_errormessage ( $GLOBALS["postgresql_connection"] );
		} else if ( strcmp ( $GLOBALS["db_type"], "odbc" ) == 0 ) {
		// no way to get error from ODBC API
		$ret = "Unknown ODBC error";
		} else if ( strcmp ( $GLOBALS["db_type"], "ibase" ) == 0 ) {
		$ret = ibase_errmsg ();
		} else if ( strcmp ( $GLOBALS["db_type"], "ibm_db2" ) == 0 ) {
		$ret = db2_conn_errormsg ();
		if ( $ret == '' )
		   $ret = db2_stmt_errormsg ();
		} else if ( strcmp ( $GLOBALS["db_type"], "sqlite" ) == 0 ) {
		$ret = sqlite_last_error ($GLOBALS["sqlite_c"]);
		} else {
		$ret = "dbi_error(): db_type not defined.";
		}
		if ( strlen ( $ret ) )
		return $ret;
		else
		return "Unknown error";
	}
	
	/**
	* Display a fatal database error and aborts execution.
	*
	* @param string $msg       The database error message
	* @param bool   $doExit    Abort execution?
	* @param bool   $showError Show the details of the error (possibly including
	*                          the SQL that caused the error)?
	*/
	public function dbi_fatal_error ( $msg, $doExit=true, $showError=true ) 
	{
		if (self::$return_false_on_error)
			return false;
		
		if ( $showError ) {
		    echo "<h2>Error</h2>\n";
		    echo "<!--begin_error(dbierror)-->\n";
		    echo "$msg\n";
		    echo "<!--end_error-->\n";
		}
		
		if ( $doExit )
			exit;
	}
	
	/**
	* Escape a string accordingly to the DB type. 
	*
	* @param string $string       SQL of query to execute
	*
	* @return string              The escaped string
	*/
	public function dbi_escape_string( $string )
	{
		// return the string in original form; all possible escapings by 
		// magic_quotes_gpc (and possibly magic_quotes_sybase) will be 
		// rolled back, but also we may roll back escaping we have done
		// ourself
		//(maybe this should be removed)
		//if ( get_magic_quotes_gpc() )
		$string = stripslashes( $string );
		
		switch ( $GLOBALS["db_type"] )
		{
		case "mysql":
		  return mysql_real_escape_string( $string );
		case "mysqli":
		  return mysqli_real_escape_string( $GLOBALS["db_connection"], $string );
		case "mssql":
		case "ibase":
		  return str_replace( "'", "''", $string );
		case "postgresql":
		  return pg_escape_string( $string );
		case "sqlite":
		  return sqlite_escape_string( $string );
		case "oracle":
		case "odbc":
		case "ibm_db2":
		default:
		  return addslashes( $string );
		}
	}
	
	/**
	* Execute a SQL query, supporting parameter binding in the ?-style
	*
	* <b>Note:</b> Use the {@link $this->dbi_error()} function to get error information
	* if the connection fails.
	*
	* @param string $sql            SQL of query to execute. May contain ?-placeholders
	* @param array  $params         An array containing the values to put in placeolders.
	*                               These values will be escaped with dbi_escape_string()
	*                               and will be put in single quotes. A NULL param will
	*                               be replaced with NULL without quotes around it.
	* @param bool   $fatalOnError   Abort execution if there is a database error?
	* @param bool   $showError      Display error to user (including possibly the
	*                               SQL) if there is a database error?
	*
	* @return mixed                 The query result resource on queries (which can then be
	*                               passed to the {@link $this->dbi_fetch_row()} function to obtain the
	*                               results), or true/false on insert or delete queries.
	*/
	public function dbi_execute( $sql, $params=array(), $fatalOnError=true, $showError=true )
	{	
		if ( count( $params ) == 0 )
		return $this->dbi_query( $sql, $fatalOnError, $showError );
		
		$prepared = '';
		$phindex = 0;
		$offset = 0;
		
		while ( ( $pos = strpos( $sql, '?', $offset ) ) !== false ) {
		$prepared .= substr( $sql, $offset, $pos - $offset ) .
		  ( ( is_null( $params[ $phindex ] ) ) ? "NULL" : ( "'" . $this->dbi_escape_string( $params[ $phindex ] ) . "'" ) );
		$offset = $pos + 1;
		$phindex++;
		}
		$prepared .= substr( $sql, $offset );
		
		//if ((USE_MEMCACHE) && (strpos("insert",$prepared)>0) && (strpos("pkr_subhand",$prepared)>0))
			//$GLOBALS['memcache']->flush();  
		
		return $this->dbi_query( $prepared, $fatalOnError, $showError );
	}
	
	
}


?>

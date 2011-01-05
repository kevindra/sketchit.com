<?php
/**
 * @class Database
 * @file  database.lib.php
 * @deps  connections.ini.php
 * @desc  This class is a abstraction of the MySQL database connection link.
 *        Wrapper for mysql C style functions and wraps them in OOPs to provide
 *        individual links to the database of choice.
 * @note  Default DB link is to 'main'
 *
 * @date   Oct 6th 2010
 * @author Kevindra
 * @copyright ShareYourTrip Pvt Ltd
 *
 * Change History
 * Kevindra  06-oct-2010  1.0  Created
 */

define('CONNECTIONS_FILE', 'connections.ini');
define('CNNXNS_FILE',      'connections.ini.php');
define('DEFAULT_DATABASE', 'main');

include_once CNNXNS_FILE;

class Database {
	var $_conn;

  /**
   * @function __construct
   * @param1   $arg
   *           i.  Can be just a name of the DB OR
   *           ii. Is a array of connection details host, user, pass
   *
   * @note User will not be able to use this constructor. Must only
   *       use Database::GetInstance
   */
  private function __construct($arg) {
    $host; $user; $pass;

    ///
    // DB name. Get the connection details from connections.ini file
    ///
    if(is_array($arg) == false) {
      list($host, $user, $pass) = self::GetDBDetails($arg);
      ///
      // EXIT if the link is invalid
      ///
      if($host == null) { return null; }
    }
    ///
    // DB Details sent in the function itself
    ///
    else {
      list($host, $user, $pass) = $arg;
    }

    $this->_conn = ($pass == "")? mysql_pconnect($host, $user): mysqli_connect($host, $user, $pass);
  }

  /**
   * @function GetDBDetails
   * @desc     Returns the connection details of the DB when the name is given
   * @note     connections.ini must exist
   * @note     Must have a default db of name 'main'
   */
  static public function GetDBDetails($name) {
    global $_CONNECTIONS; $connections;
    $host; $user; $pass;

    if(isset($_CONNECTIONS)) {			
      $connections = $_CONNECTIONS;
    }
    else {
      $connections = parse_ini_file(CONNECTIONS_FILE, true);
    }

    ///
    // EXIT if the DB link is not present in ini
    ///
    if(isset($connections[$name]) == false) { return null; }
   
    $host = $connections[$name]['host'];
    $user = $connections[$name]['user'];
    $pass = $connections[$name]['password'];

    return array($host, $user, $pass);
  }

  /**
   * @desc   This is the function that is at the heart of Database class.
   *         - Maintains a cache of all created DB connections
   *         - If a connection is not found in its cache, it creates one
   *           on the fly and stores it in the cache.
   * @note   Default DB connection is 'main'
   * @note   connections.ini MUST have a 'main' section
   * @return Returns the DB connection object
   */
  static public function GetInstance($name = DEFAULT_DATABASE) {
    static $ConnectionsCache = array();

    if(isset($ConnectionsCache[$name]) == true) {
      return $ConnectionsCache[$name];
    }
    else {
      $ConnectionsCache[$name] = new Database($name);

      ///
      // Failsafe - MUST return a database conn
      ///
      if(!$ConnectionsCache[$name])
        $ConnectionsCache[$name] = new Database(DEFAULT_DATABASE);
      return $ConnectionsCache[$name];
    }

    return null;
  }

  public function __destruct() {
    if($this->_conn) { mysqli_close($this->_conn); }
  }

  public function conn() {
    if($this->_conn) { return $this->_conn; }
    return null;
  }
  public function select_db($dbname) {
    return mysqli_select_db($this->_conn, $dbname);
  } 

  public function query($query) {
    $rs = mysqli_query($this->_conn, $query);
    return $rs;
  }

  public function multi_query($query) {
    $link = $this->_conn;
    $res  = $link->multi_query($query) or die(mysqli_error($link));
    $rs   = $link->store_result();

    return $rs;
  }

  public function error() { return mysqli_error($this->_conn); }

  public function errno() { return mysqli_errno($this->_conn); }

  /**
   * $result is the result which is returned by mysqli_query
   * $cursor is the cursor created in Oracle
   * $column_num is the count of the field being requested. Count starts from 0.
   */
  public function field_name($result,$cursor,$column_num) {
    return mysqli_field_name($result,$column_num, $this->_conn);
  }

  /**
   * For all the below fucntions $query is the query that has to be executed !!
   * @return the number of fields in a result set.
   */
  public function num_fields($query) {
    return mysqli_num_fields($query, $this->_conn);
  }

  /**
   * @return the number of rows in a result set
   */
  public function num_rows($resultset) { return mysqli_num_rows($resultset); }

  /**
   * @return result row as an enumerated array 
   */
  public function fetch_row($resultset) { return mysqli_fetch_row($resultset); }

  /**
   * @result returns a row as a hash.
   */
  public function fetch_assoc($result) { return mysqli_fetch_assoc($result); }

  /**
   * @result returns a row as a array (hash or enumerated array)
   */
  public function fetch_array($result, $result_type = MYSQL_ASSOC) {
    return mysqli_fetch_array($result, $result_type);
  }

}

?>

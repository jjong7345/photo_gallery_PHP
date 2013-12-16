<?php
require_once("config.php");

class MySQLDatabase {

  private $con;
  public $last_query;
  private $magic_quote_active;
  private $mysql_escape_string_exist;

  function __construct(){
    $this->open_connection();
    $this->magic_quote_active = get_magic_quotes_gpc();
    $this->mysql_escape_string_exist = function_exists("mysql_real_escape_string"); //i.e. PHP >= v4.3.0
  }

  public function open_connection() {
    //1. Create a database connection
    $this->con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
    if (!$this->con) {
      die("Database connection failed: ". mysql_error());
    }
    else {
      //2. Select a database to use
      $db_select = mysql_select_db(DB_NAME, $this->con);
      if (!$db_select) {
        die("Database selection failed: ". mysql_error());
      }

    }
  }

  public function close_connection() {
    //5.Close connection
    if(isset($this->con)) {
      mysql_close($this->con);
      unset($this->con);
    }
  }

  public function query($sql) {
    $this->last_query = $sql;
    $result = mysql_query($sql, $this->con);
    $this->confirm_query($result);
    return $result;
  }

  public function escape_value($value) {
    //$magic_quote_active = get_magic_quotes_gpc();
    //$new_enough_php = function_exists("mysql_real_escape_string"); //i.e. PHP >= v4.3.0
    if ($this->mysql_escape_string_exist) { // PHP V4.3.0 or higher
      //undo any magic quote effect so mysql_real_escape_string can do the work
      if ($this->magic_quote_active) { $value = stripcslashes($value); }
      // Quote if not a number
      /*if (!is_numeric($value))
      {
        $value = "'" . mysql_real_escape_string($value) . "'";
      }*/
      $value = mysql_real_escape_string($value);
    }
    else { // before PHP V4.3.0
      //if magic quotes aren't already on then add slashes manually
      if (!$this->magic_quote_active) { $value = addcslashes($value); }
      //if magic quotes are active, then the slashes already exist
    }
    return $value;
  }

  // database-neutural methods
  public function fetch_array($result_set) {
    return mysql_fetch_array($result_set);
  }

  public function num_rows($result_set) {
    return mysql_num_rows($result_set);
  }

  public function insert_id() {
    //get the last id inserted over the current db connection
    return mysql_insert_id($this->con);
  }
  public function afected_rows() {
    return mysql_affected_rows($this->con);
  }

  private function confirm_query($result){
    if (!$result) {
      $output = "Database query failed: ".mysql_error()."<br/><br/>";
      $output.= "Last SQL query: ". $this->last_query;
      die($output);
    }
  }

}
$database = new MySQLDatabase();
$db =& $database;

?>
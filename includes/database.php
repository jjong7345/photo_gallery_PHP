<?php
require_once("config.php");

class MySQLDatabase {

  private $con;

  function __construct(){
    $this->open_connection();
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
    $result = mysql_query($sql, $con);
    $this->confirm_query($result);
    return $result;
  }

  public function mysql_prep($value) {
    $magic_quote_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists("mysql_real_escape_string"); //i.e. PHP >= v4.3.0
    if ($new_enough_php) { // PHP V4.3.0 or higher
      //undo any magic quote effect so mysql_real_escape_string can do the work
      if ($magic_quote_active) { $value = stripcslashes($value); }
      // Quote if not a number
      /*if (!is_numeric($value))
      {
        $value = "'" . mysql_real_escape_string($value) . "'";
      }*/
      $value = mysql_real_escape_string($value);
    }
    else { // before PHP V4.3.0
      //if magic quotes aren't already on then add slashes manually
      if (!$magic_quote_active) { $value = addcslashes($value); }
      //if magic quotes are active, then the slashes already exist
    }
    return $value;
  }

  private function confirm_query($result){
    if (!$resilt) {
      die("Database query failed: ".mysql_error());
    }
  }

}
$database = new MySQLDatabase();
$db =& $database;


//1. Create a database connection
$con = mysql_connect(DB_SERVER, DB_USER, DB_PASS);
if (!$con) {
  die("Database connection failed: ". mysql_error());
}

//2. Select a database to use
$db_select = mysql_select_db(DB_NAME, $con);
if (!$db_select) {
  die("Database selection failed: ". mysql_error());
}

//3. Perform database query
$sql = "SELECT * FROM subjects";
$result = mysql_query($sql, $con);
if (!$result) {
  die("Database query failed: ".mysql_error());
}

//4. Use returned data
while ($row = mysql_fetch_array($result)){
  //output data
}

//5.Close connection
if(isset($con)) {
  mysql_close($con);
  unset($con);
}


?>
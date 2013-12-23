<?php
require_once ("../includes/functions.php");
require_once ("../includes/database.php");
//require_once ("../includes/user.php");

// if (isset($database)) {
//   echo "true";
// } else {
//   echo "false";
// }


//echo $database->escape_value("It's working?<br />");

//$sql = "INSERT INTO users (id, username, password, first_name, last_name) VALUES (2, 'kskoglund', 'secretpwd', 'Kevin', 'Skoglund')";
// $result = $database->query($sql);

// $sql = "SELECT * FROM users WHERE id = 1";
// $result_set = $database->query($sql);
// $found_user = $database->fetch_array($result_set);

//echo $found_user['username'];

//echo "<hr />";

$user = User::find_by_id(1);
echo $user->full_name();

echo "<hr />";

$users = User::find_all();
foreach($users as $user) {
  echo "User: ".$user->username ."<br/>";
  echo "Name:".$user->full_name()."<br/><br/>";
}

// $user_set = User::find_all();
// while ($user = $database->fetch_array($user_set)) {
//   echo "User: ".$user['username'] ."<br/>";
//   echo "Name: ".$user['first_name'] ." " .$user['last_name']."<br/><br/>";

// }


?>
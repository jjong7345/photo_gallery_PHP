<?php
  require_once("../../includes/functions.php");
  require_once("../../includes/database.php");
  require_once("../../includes/session.php");
  require_once("../../includes/user.php");

  if ($session->is_logged_in()) {
    redirect_to("index.php");
  }
  //remember to give your form's submit tag a name="submit" attribute!
  if(isset($_POST["submit"])) {//Form ha been submitted.
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    //Check database to see if username/password exist.
    $found_user = User::authenticate($username, $password);
    if ($found_user) {
      echo "gggg";
      //$session->login($found_user);
      redirect_to("index.php");
    }
    else {
      // username/password combo was not found in the database
      $message = "Username/password combination incorrect.";
    }
  }
  else { // Form has not been submitted
    $usernmae = "";
    $password = "";
  }
?>

<html>
  <head>
    <title>Photo Gallery</title>
    <link href="../css/main.css" media="all" rel="stylesheet" type="text/css" />
  </head>
  <body>
      <div id="head">
        <h1>Photo Gallery</h1>
      </div>
      <div id="main">
        <h2>Staff Login</h2>
        <?php echo output_message($message); ?>
        <form action="login.php" method="post">
          <table>
            <tr>
              <td>Username:</td>
              <td>
                <input type="text" nname="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
              </td>
            </tr>
            <tr>
              <td>Password:</td>
              <td>
                <input type="password" nname="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
              </td>
            </tr>
            <tr>
              <td colspan="2">
                <input type="submit" name="submit"  value="Login" />
              </td>
            </tr>
          </table>
        </form>
      </div>
      <div id="footer">
        Copyright <?php echo date("Y", time()); ?>, Jong Park
      </div>
  </body>
</html>
<?php if (isset($database)) { $database->close_connection(); } ?>
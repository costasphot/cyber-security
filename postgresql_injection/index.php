<?php
  /**
   * index.php
   * 
   * Full Name: George Constantine Fotopoulos
   * R.N.: 1117202200234
   */

  require_once("common.php");
?>

<!DOCTYPE html>
  <html lang="en">

  <!-- Head -->

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 3 - <?php echo EscapeHtml(APP_TITLE) ?></title>

    <link rel="stylesheet" href="css/style.css">

    <script src="js/login_validation.js"></script>
  </head>

  <!-- Body -->

  <body>
    <h1><?php echo EscapeHtml(APP_TITLE) ?></h1>

    <p>
      This application demonstrates how an SQL injection attack can bypass
      vulnerable authentication systems and gain unauthorised access.
    </p>

    <form method="post" action="vulnerable_login.php" onsubmit="return ValidateLoginForm();">
      <label for="username">Username</label>
      <input type="text" id="username" name="username">

      <label for="password">Password</label>
      <input type="password" id="password" name="password">

      <br>

      <button type="submit" formaction="vulnerable_login.php">
        Vulnerable Login
      </button>

      <button type="submit" formaction="multi_statement_login.php">
        Multi-Statement Demo
      </button>

      <button type="submit" formaction="safe_login.php">
        Safe Login
      </button>
    </form>
  </body>
</html>

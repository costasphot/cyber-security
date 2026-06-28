<?php
  /**
   * vulnerable_login.php
   * 
   * Full Name: George Constantine Fotopoulos
   * R.N.: 1117202200234
   */

  require_once("common.php");

  # --- Request Handling Logic ---

  if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("[Error] Invalid request method.");
  }

  $username = trim($_POST["username"] ?? "");
  $password = trim($_POST["password"] ?? "");

  if ($username === "" || $password === "") {
    die("[Error] Both the username and password are required.");
  }

  $connection = ConnectToDatabase();

  /*
   * This query is intentionally vulnerable to SQL injection.
   * 
   * Reason:
   * - The user input is directly concatenated into the SQL command.
   * 
   * Fix:
   * - Structure it as a **parameterised query**; with '$1' and '$2',
   *   instead of '$username' and '$password'.
   * 
   *   This makes it so that SQL expressions like "' OR '1'='1" is not
   *   seen as SQL logic, but rather as a simple password's value.
   */
  $query =
      "SELECT username " .
      "FROM " . TABLE_USERS . " " .
      "WHERE username = '" . $username . "' " .
      "AND password = '" . $password . "'";

  $result = pg_query($connection, $query);

  if ($result === false) {
    die("[Error] The authentication query failed.");
  }

  $user = pg_fetch_assoc($result);
?>

<!DOCTYPE html>
  <html lang="en">

  <!-- Head -->

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment 3 - <?php echo EscapeHtml(APP_TITLE) ?></title>

    <link rel="stylesheet" href="css/style.css">
  </head>

  <!-- Body -->

  <body>
    <h1><?php echo EscapeHtml(APP_TITLE) ?></h1>

    <?php if ($user === false): ?>
      <div class="message-area">
        <p>Access denied.</p>
        <p>You do not have permission to access the product data.</p>
      </div>
    <?php else: ?>
      <div class="message-area">
        <p>Access granted.</p>
        <p>Authenticated user: <?php echo EscapeHtml($user["username"]); ?></p>
      </div>
    <?php endif; ?>

    <p>
      <a href="index.php">Back to login form</a>
    </p>
  </body>
</html>

<?php
  /**
   * multi_statement_login.php
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

  $sned_result = pg_send_query($connection, $query);

  if ($send_result === false) {
    die("[Error] The multi-statement query could not be sent.");
  }

  $authentication_result = pg_get_result($connection);

  if ($authentication_result === false) {
    die("[Error] The authentication query could not be read.");
  }

  $user = pg_fetch_assoc($authentication_result);

  // Consume any additional results produced by the extra injected SQL statements.
  while (pg_get_result($connection) !== false) {}

  $products_result = false;

  if ($user !== false) {
    $products_query =
        "SELECT product_id, product_name, price " .
        "FROM " . TABLE_PRODUCT . " " .
        "ORDER BY product_id";

    $products_result = pg_query($connection, $products_query);

    if ($products_result === false) {
      die("[Error] The products query failed.");
    }
  }
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

      <table class="product-table">
        <thead>
          <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
          </tr>
        </thead>

        <tbody>
          <?php while (($product = pg_fetch_assoc($products_result)) !== false): ?>
            <tr>
              <td><?php echo EscapeHtml($product["product_id"]); ?></td>
              <td><?php echo EscapeHtml($product["product_name"]); ?></td>
              <td><?php echo EscapeHtml($product["price"]); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <p>
      <a href="index.php">Back to login form</a>
    </p>
  </body>
</html>

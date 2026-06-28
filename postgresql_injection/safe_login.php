<?php
  /**
   * safe_login.php
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
   * This query is protected aganst SQL injection.
   * 
   * The $1 and $2 placeholders are replaced safely by PostgreSQL.
   * Therefore, the user input is treated as data, rather than SQL code.
   */
  $query =
      "SELECT username " .
      "FROM " . TABLE_USERS . " " .
      "WHERE username = $1 " .
      "AND password = $2";

  $result = pg_query_params($connection, $query, [$username, $password]);

  if ($result === false) {
    die("[Error] The authentication query failed.");
  }

  $user = pg_fetch_assoc($result);

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

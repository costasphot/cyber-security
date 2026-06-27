<?php

use Pdo\Pgsql;
  /**
   * common.php
   * 
   * Full Name: George Constantine Fotopoulos
   * R.N.: 1117202200234
   */

  # --- Constants ---

  define ("APP_TITLE", "PostgreSQL Injection");

  define("DATABASE_HOST", "localhost");
  define("DATABASE_PORT", "5432");
  define("DATABASE_NAME", "sql_injection");
  define("DATABASE_USERNAME", "postgres");
  define("DATABASE_PASSWORD", "postgres");

  define("TABLE_USERS",   "Users");
  define("TABLE_PRODUCT", "Product");
  
  # --- Helper Functions ---

  function EscapeHtml(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
  }

  function ConnectToDatabase(): \PgSql\Connection {
    $connection_string = 
        "host="      . DATABASE_HOST .
        " port="     . DATABASE_PORT .
        " dbname="   . DATABASE_NAME .
        " user="     . DATABASE_USERNAME .
        " password=" . DATABASE_PASSWORD;

    $connection = pg_connect($connection_string);

    if ($connection === false) {
      die("[Error] Failed to connect to the PostgreSQL database.");
    }

    return $connection;
  }
?>

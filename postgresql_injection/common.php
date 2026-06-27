<?php
  /**
   * common.php
   * 
   * Full Name: George Constantine Fotopoulos
   * R.N.: 1117202200234
   */

  # --- Constants ---

  define ("APP_TITLE", "PostgreSQL Injection");

  define("DATABASE_NAME", "web_development");

  define("TABLE_USERS",   "Users");
  define("TABLE_PRODUCT", "Product");
  
  # --- Helper Functions ---

  function EscapeHtml(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, "UTF-8");
  }
?>

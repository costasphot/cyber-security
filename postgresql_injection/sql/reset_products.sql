-- sql/reset_products.sql
--
-- Full Name: George Constantine Fotopoulos
-- R.N.: 1117202200234

-- Remove all product rows and reset the identity counter back to 1.
TRUNCATE TABLE Product RESTART IDENTITY;

INSERT INTO Product (product_name, price)
VALUES
  ("Laptop",   2899.99),
  ("Mouse",    59.99),
  ("Keyboard", 119.99),
  ("Monitor",  379.99);

-- sql/schema.sql
--
-- Full Name: George Constantine Fotopoulos
-- R.N.: 1117202200234

--
-- 1. Setup the tables
--

DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Users;

--
-- 2. Create the tables
--

CREATE TABLE Users (
  username VARCHAR(30)  PRIMARY KEY,
  password VARCHAR(255) NOT NULL,
);

CREATE TABLE Product (
  product_id   INTEGER        GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
  product_name VARCHAR(100)   NOT NULL,
  price        NUMERIC(10, 2) NOT NULL
);

--
-- 3. Insert the users and 
--

INSERT INTO Users (username, password)
VALUES
  ("Mort",   "pizza"),
  ("Bob",    "bob123"),
  ("admin",  "admin");

INSERT INTO Product (product_name, price)
VALUES
  ("Laptop",   2899.99),
  ("Mouse",    59.99),
  ("Keyboard", 119.99),
  ("Monitor",  379.99);

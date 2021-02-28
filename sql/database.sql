DROP DATABASE IF EXISTS customerdb;
CREATE DATABASE customerdb;
use customerdb;

CREATE TABLE Customers
( CustomerID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Name CHAR(50) NOT NULL,
  Address CHAR(100) not null,
  City CHAR(30) not null
);

INSERT INTO Customers VALUES
  (1, 'Julie Smith', '25 Oak Street', 'Airport West'),
  (2, 'Alan Wong', '1/47 Haines Avenue', 'Box Hill'),
  (3, 'Michelle Arthur', '357 North Road', 'Yarraville');



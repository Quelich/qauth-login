SELECT * FROM accounts; /*with prepared statement*/

SELECT id, password FROM accounts WHERE username = ?; /*with prepared statement*/
/*Create an initial account in the accounts table*/
INSERT INTO accounts (id, username, password, email)VALUES (1, 'test', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'test@test.com');

INSERT INTO accounts (username, password, email) VALUES (?, ?, ?); /*with prepared statement */

UPDATE accounts SET username = ?, email = ?, password = ?, phone = ?, address = ? WHERE id = ?; /*with prepared statement */
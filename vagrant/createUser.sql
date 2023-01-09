CREATE USER IF NOT EXISTS 'admin'@'%' IDENTIFIED BY '123';
GRANT ALL PRIVILEGES ON *.* TO 'admin'@'%';
FLUSH PRIVILEGES;
SHOW GLOBAL VARIABLES like 'bind_address';
SELECT host, user, password FROM mysql.user;
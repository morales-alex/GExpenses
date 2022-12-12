CREATE OR REPLACE USER admin@'%' IDENTIFIED BY '123';
GRANT ALL ON *.* TO admin@'%';
/*FLUSH PRIVILEGES;
SHOW GLOBAL VARIABLES like 'bind_address';
SELECT host, user, password FROM mysql.user;*/
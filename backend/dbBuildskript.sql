/* Löschen und erzeugen der Datenbank */
DROP DATABASE IF EXISTS dbgesundhait;
CREATE DATABASE dbgesundhait;
USE dbgesundhait;

/* Löschen und erzeugen der Tabellen mit jeweiligen Fremdschlüsseln */
DROP TABLE IF EXISTS users;
 
CREATE TABLE users
(ID INTEGER AUTO_INCREMENT PRIMARY KEY,
 u_surname VARCHAR(50),
 u_forename VARCHAR(50),
 u_number VARCHAR(20),
 u_mail VARCHAR(50),
 u_username VARCHAR(50),
 u_password VARCHAR(100),
 u_active BOOLEAN,
 u_created TIMESTAMP
 );
 
/* Erzeugen der TRIGGER, damit beim einfügen in b_passwort automatisch verschlüsselt wird */
 CREATE TRIGGER hashPasswortInsert BEFORE INSERT ON users FOR EACH ROW SET NEW.u_password = sha2(NEW.u_password, 224);
 CREATE TRIGGER hashPasswortUpdate BEFORE UPDATE ON users FOR EACH ROW SET NEW.u_password = sha2(NEW.u_password, 224);
 
/* Einfügen von BeispielDaten */
INSERT INTO users (u_surname, u_forename, u_number, u_mail, u_username, u_password, u_active) 
	VALUES ('Mustermann','Max','0511123456','blub@www.de','bv', '123456', TRUE);
INSERT INTO users (u_surname, u_forename, u_number, u_mail, u_username, u_password, u_active) 
	VALUES ('Mueller','Peter','0511654321','bla@www.de','bv', '123456', TRUE);

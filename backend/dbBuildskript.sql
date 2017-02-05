/* Löschen und erzeugen der Datenbank */
DROP DATABASE IF EXISTS dbgesundhait;
CREATE DATABASE dbgesundhait;
USE dbgesundhait;

/* Löschen und erzeugen der Tabellen mit jeweiligen Fremdschlüsseln */
DROP TABLE IF EXISTS customer;
 
CREATE TABLE customer
(ID INTEGER AUTO_INCREMENT PRIMARY KEY,
 c_surname VARCHAR(50),
 c_forename VARCHAR(50),
 c_number VARCHAR(20),
 c_mail VARCHAR(50),
 c_username VARCHAR(50),
 c_password VARCHAR(100),
 c_active BOOLEAN
 );
 
/* Erzeugen der TRIGGER, damit beim einfügen in b_passwort automatisch verschlüsselt wird */
 CREATE TRIGGER hashPasswortInsert BEFORE INSERT ON customer FOR EACH ROW SET NEW.c_password = sha2(NEW.c_password, 224);
 CREATE TRIGGER hashPasswortUpdate BEFORE UPDATE ON customer FOR EACH ROW SET NEW.c_password = sha2(NEW.c_password, 224);
 
/* Einfügen von BeispielDaten */
INSERT INTO customer (c_surname, c_forename, c_number, c_mail, c_username, c_password, c_active) 
	VALUES ('Mustermann','Max',0511123456,'blub@www.de','bv', '123456', TRUE);
INSERT INTO customer (c_surname, c_forename, c_number, c_mail, c_username, c_password, c_active) 
	VALUES ('Mueller','Peter',0511654321,'bla@www.de','bv', '123456', TRUE);

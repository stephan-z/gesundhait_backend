/* Löschen und erzeugen der Datenbank */
DROP DATABASE IF EXISTS dbgesundhait;
CREATE DATABASE dbgesundhait;
USE dbgesundhait;

/* Löschen und erzeugen der Tabellen mit jeweiligen Fremdschlüsseln */
DROP TABLE IF EXISTS benutzer;
 
CREATE TABLE benutzer
(ID INTEGER AUTO_INCREMENT PRIMARY KEY,
 b_name VARCHAR(50),
 b_vorname VARCHAR(50),
 b_telefonnummer VARCHAR(20),
 b_email VARCHAR(50),
 b_kennung VARCHAR(50),
 b_passwort VARCHAR(100),
 b_aktiv BOOLEAN
 );
 
/* Erzeugen der TRIGGER, damit beim einfügen in b_passwort automatisch verschlüsselt wird */
 CREATE TRIGGER hashPasswortInsert BEFORE INSERT ON benutzer FOR EACH ROW SET NEW.b_passwort = sha2(NEW.b_passwort, 224);
 CREATE TRIGGER hashPasswortUpdate BEFORE UPDATE ON benutzer FOR EACH ROW SET NEW.b_passwort = sha2(NEW.b_passwort, 224);
 
/* Einfügen von BeispielDaten */
INSERT INTO benutzer (b_name, b_vorname, b_telefonnummer, b_email, b_kennung, b_passwort, b_aktiv) 
	VALUES ('Mustermann','Max',0511123456,'blub@www.de','bv', '123456', TRUE);
INSERT INTO benutzer (b_name, b_vorname, b_telefonnummer, b_email, b_kennung, b_passwort, b_aktiv) 
	VALUES ('Müller','Peter',0511654321,'bla@www.de','bv', '123456', TRUE);

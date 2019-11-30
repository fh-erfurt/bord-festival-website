-- Erstellungsskript für BORD-Festival-PHP
-- Github-Repo: https://github.com/fh-erfurt/bord-festival-website
-- erstellt am 27.11.2019
-- von Raphael Freybe, Daniel Depta

-- Erstellen der Datenbank festival

DROP DATABASE IF EXISTS festival;
CREATE DATABASE IF NOT EXISTS festival DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

-- Wechseln in den Kontext festival

USE festival;


-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle adressen
--
DROP TABLE IF EXISTS addresses;

CREATE TABLE IF NOT EXISTS addresses
	(
		ADDRESSID int(7) NOT NULL AUTO_INCREMENT,
		STREET varchar(100) NOT NULL,
		ZIP varchar(10) NOT NULL,
		CITY varchar(100) NOT NULL,
		COUNTRY varchar(30) default 'GER',
		CONSTRAINT addresses_pk PRIMARY KEY (ADDRESSID)
	);

--
-- Tabellenstruktur für Tabelle clients
--
DROP TABLE IF EXISTS clients;

CREATE TABLE clients 
(
  CLIENTID int(7) NOT NULL AUTO_INCREMENT,
  MAIL varchar(100) NOT NULL,
  FIRSTNAME varchar(50) NOT NULL,
  LASTNAME varchar(50) NOT NULL,
  DATEOFBIRTH date NOT NULL,
  PASSWORD binary(60) NOT NULL,
  SALT varchar(100) NOT NULL,
  CREATEDAT datetime NOT NULL,
  UPDATEDAT datetime NOT NULL,
  ADDRESSID int (7) NOT NULL,
  CONSTRAINT clients_pk PRIMARY KEY (CLIENTID),
  CONSTRAINT mail_uq UNIQUE (MAIL),
  CONSTRAINT clients_addresses_fk FOREIGN KEY (ADDRESSID) REFERENCES ADDRESSES (ADDRESSID)
);

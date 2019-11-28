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
DROP TABLE IF EXISTS adressen;

CREATE TABLE IF NOT EXISTS adressen
	(
		ADRESSID int(7) NOT NULL AUTO_INCREMENT,
		STRASSE_HNR varchar(100) NOT NULL,
		PLZ varchar(10) NOT NULL,
		ORT varchar(100) NOT NULL,
		LAND varchar(30) default 'GER',
		CONSTRAINT adressen_pk PRIMARY KEY (ADRESSID)
	);

--
-- Tabellenstruktur für Tabelle clients
--

CREATE TABLE clients (
  CLIENTID int(7) NOT NULL AUTO_INCREMENT,
  MAIL varchar(100) NOT NULL,
  VORNAME varchar(50) NOT NULL,
  NACHNAME varchar(50) NOT NULL,
  GEBURTSDATUM date NOT NULL,
  PASSWORD binary(60) NOT NULL,
  SALT varchar(100) NOT NULL,
  ADRESSID int (7) NOT NULL,
  CONSTRAINT clients_pk PRIMARY KEY (CLIENTID),
  CONSTRAINT mail_uq UNIQUE (MAIL),
  CONSTRAINT clients_adressen_fk FOREIGN KEY (ADRESSID) REFERENCES ADRESSEN (ADRESSID)
);

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
  CREATEDAT datetime NOT NULL,
  UPDATEDAT datetime NOT NULL,
  ADDRESSID int (7) NOT NULL,
  CONSTRAINT clients_pk PRIMARY KEY (CLIENTID),
  CONSTRAINT mail_uq UNIQUE (MAIL),
  CONSTRAINT clients_addresses_fk FOREIGN KEY (ADDRESSID) REFERENCES ADDRESSES (ADDRESSID)
);

--
-- Tabellenstruktur für Tabelle items
--
DROP TABLE IF EXISTS items;

CREATE TABLE items 
(
  ITEMID int(2) NOT NULL AUTO_INCREMENT,
  NAME varchar(100) NOT NULL,
  DESCRIPTION varchar(500) NOT NULL,
  PRICE decimal(6,2) NOT NULL,
  TYPE varchar(30) NOT NULL,
  CATEGORY varchar(30),
  COLOR varchar(30),
  GENDER varchar(30),
  IMAGEURL varchar(100) NOT NULL,
  CONSTRAINT items_pk PRIMARY KEY (ITEMID),
  CONSTRAINT itemname_uq UNIQUE (NAME)
);

--
-- Tabellenstruktur für Tabelle carts
--
DROP TABLE IF EXISTS carts;

CREATE TABLE carts 
(
  CARTID int(7) NOT NULL AUTO_INCREMENT,
  TOTALPRICE decimal(8,2),
  TOTALCOUNT int(6),
  LASTUPDATED datetime NOT NULL,
  CLIENTID int(7) NOT NULL,
  CONSTRAINT carts_pk PRIMARY KEY (CARTID),
  CONSTRAINT carts_clients_fk FOREIGN KEY (CLIENTID) REFERENCES clients (CLIENTID)
);

--
-- Tabellenstruktur für Tabelle caritems
--
DROP TABLE IF EXISTS cartitems;

CREATE TABLE cartitems 
(
  CARTITEMID int(10) NOT NULL AUTO_INCREMENT,
  CARTID int(7) NOT NULL,
  ITEMID int(7) NOT NULL,
  QUANTITY int(3) NOT NULL,
  CONSTRAINT cartitems_pk PRIMARY KEY (CARTITEMID),
  CONSTRAINT cartitems_carts_fk FOREIGN KEY (CARTID) REFERENCES carts (CARTID),
  CONSTRAINT cartitems_items_fk FOREIGN KEY (ITEMID) REFERENCES items (ITEMID)
);

--
-- Tabellenstruktur für Tabelle purchases
--
DROP TABLE IF EXISTS purchases;

CREATE TABLE purchases 
(
  PURCHASEID int(7) NOT NULL AUTO_INCREMENT,
  PURCHASEDAT datetime NOT NULL,
  CLIENTID int(7) NOT NULL,
  CONSTRAINT purchases_pk PRIMARY KEY (PURCHASEID),
  CONSTRAINT purchases_clients_fk FOREIGN KEY (CLIENTID) REFERENCES clients (CLIENTID)
);

--
-- Tabellenstruktur für Tabelle purchaseitems
--
DROP TABLE IF EXISTS purchaseitems;

CREATE TABLE purchaseitems 
(
  PURCHASEITEMID int(10) NOT NULL AUTO_INCREMENT,
  PURCHASEID int(7) NOT NULL,
  ITEMID int(7) NOT NULL,
  QUANTITY int(3) NOT NULL,
  PRICE decimal(6,2) NOT NULL,
  CONSTRAINT purchaseitems_pk PRIMARY KEY (PURCHASEITEMID),
  CONSTRAINT purchaseitems_purchases_fk FOREIGN KEY (PURCHASEID) REFERENCES purchases (PURCHASEID),
  CONSTRAINT purchaseitems_items_fk FOREIGN KEY (ITEMID) REFERENCES items (ITEMID)
);

--
-- Tabellenstruktur für Tabelle newsletter
--
DROP TABLE IF EXISTS newsletter;

CREATE TABLE newsletter 
(
  NEWSLETTERID int(10) NOT NULL AUTO_INCREMENT,
  MAIL varchar(100) NOT NULL,
  CREATEDAT datetime NOT NULL,
  CONSTRAINT newsletter_pk PRIMARY KEY (NEWSLETTERID)
);

--
-- Tabellenstruktur für Tabelle support_mails
--
DROP TABLE IF EXISTS support_mails;

CREATE TABLE support_mails
(
  MAILID int(10) NOT NULL AUTO_INCREMENT,
  FIRSTNAME varchar(50) NOT NULL,
  LASTNAME varchar(50) NOT NULL,
  MAIL varchar(100) NOT NULL,
  PROBLEM varchar(30) NOT NULL,
  INFORMATION varchar(2048) NOT NULL,
  CREATEDAT datetime NOT NULL,
  CONSTRAINT support_mails_pk PRIMARY KEY (MAILID)
);

--
-- Initialbefüllung für Item-Tabelle
--
INSERT INTO `items` (`ITEMID`, `NAME`, `DESCRIPTION`, `PRICE`, `TYPE`, `CATEGORY`, `COLOR`, `GENDER`, `IMAGEURL`) VALUES 
                      (NULL, 'Tagesticket Freitag', 'Gültig am Freitag', '49.99', 'tickets', null, null, null, 'assets/img/item/ticket_freitag.png'), 
                      (NULL, 'Tagesticket Samstag', 'Gültig am Samstag', '69.99', 'tickets', null, null, null, 'assets/img/item/ticket_samstag.png'), 
                      (NULL, 'Tagesticket Sonntag', 'Gültig am Sonntag', '39.99', 'tickets', null, null, null, 'assets/img/item/ticket_sonntag.png'), 
                      (NULL, '3-Tages-Ticket', 'Für alle Festival-Fans. Gültig von Freitag bis Sonntag', '149.99', 'tickets', null, null, null, 'assets/img/item/ticket_3tage.png'), 
                      (NULL, 'VIP', 'für die Bonzen', '999.99', 'tickets', null, null, null, 'assets/img/item/ticket_vip.png'),
                      (NULL, 'Original BORD Hoodie', 'Aus echter Baumwolle', '49.99', 'merchandise', 'Bekleidung', 'schwarz', 'Männer', 'assets/img/item/hoodie.jpg'),
                      (NULL, 'BORD Cap', 'Written Logo', '24.99', 'merchandise', 'Kopfbedeckung', 'schwarz', 'unisex', 'assets/img/item/cap.jpg'),
                      (NULL, 'BORD Festival Feuerzeug schwarz', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'schwarz', 'unisex', 'assets/img/item/lighter.jpg'),
                      (NULL, 'BORD Festival Feuerzeug pink', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'pink', 'unisex', 'assets/img/item/lighter.jpg'),
                      (NULL, 'BORD Festival Feuerzeug grün', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'grün', 'unisex', 'assets/img/item/lighter.jpg'),
                      (NULL, 'BORD Festival Feuerzeug rot', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'rot', 'unisex', 'assets/img/item/lighter.jpg'),
                      (NULL, 'BORD Festival Feuerzeug lila', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'lila', 'unisex', 'assets/img/item/lighter.jpg'),
                      (NULL, 'BORD Festival Poster', '1% Chance für gratis Autogramm', '9.99', 'merchandise', 'sonstige', 'keine', 'unisex', 'assets/img/item/poster.jpg'),
                      (NULL, 'BORD Beanie', 'Perfekt für kalte Festivaltage', '19.99', 'merchandise', 'Kopfbedeckung', 'schwarz', 'Frauen', 'assets/img/item/beanie.jpg'),
                      (NULL, 'BORD Festival Flaschenöffner', 'Flaschenöffner - super für den Festivalalltag', '5.99', 'merchandise', 'sonstige', 'schwarz', 'unisex', 'assets/img/item/bottleopener.jpg'),
                      (NULL, 'BORD Mütze', 'hält warm und schützt gegen den Wind', '19.99', 'merchandise', 'Kopfbedeckung',  'schwarz',  'unisex', 'assets/img/item/muetze.jpg'),
                      (NULL, 'BORD Festival Shirt', 'Shirt für BORD-Festival-Fans', '29.99', 'merchandise', 'Bekleidung', 'schwarz', 'Männer', 'assets/img/item/shirt.jpg'),
                      (NULL, 'BORDhub Aufkleber', 'Selbstklebender Sticker, 1 Stück', '2.99', 'merchandise', 'sonstige',  'keine',  'unisex', 'assets/img/item/bordhub.png');
                      
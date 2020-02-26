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
		addressid int(7) NOT NULL AUTO_INCREMENT,
		street varchar(100) NOT NULL,
		zip varchar(10) NOT NULL,
		city varchar(100) NOT NULL,
		country varchar(30) default 'GER',
		CONSTRAINT addresses_pk PRIMARY KEY (addressid)
	);

--
-- Tabellenstruktur für Tabelle clients
--
DROP TABLE IF EXISTS clients;

CREATE TABLE clients 
(
  clientid int(7) NOT NULL AUTO_INCREMENT,
  mail varchar(100) NOT NULL,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  dateofbirth date NOT NULL,
  password binary(60) NOT NULL,
  createdat datetime NOT NULL,
  updatedat datetime NOT NULL,
  addressid int (7) NOT NULL,
  CONSTRAINT clients_pk PRIMARY KEY (clientid),
  CONSTRAINT mail_uq UNIQUE (mail),
  CONSTRAINT clients_addresses_fk FOREIGN KEY (addressid) REFERENCES ADDRESSES (addressid)
);

--
-- Tabellenstruktur für Tabelle items
--
DROP TABLE IF EXISTS items;

CREATE TABLE items 
(
  itemid int(2) NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  description varchar(500) NOT NULL,
  price decimal(6,2) NOT NULL,
  type varchar(30) NOT NULL,
  category varchar(30),
  color varchar(30),
  gender varchar(30),
  imageurl varchar(100) NOT NULL,
  CONSTRAINT items_pk PRIMARY KEY (itemid),
  CONSTRAINT itemname_uq UNIQUE (name)
);

--
-- Tabellenstruktur für Tabelle carts
--
DROP TABLE IF EXISTS carts;

CREATE TABLE carts 
(
  cartid int(7) NOT NULL AUTO_INCREMENT,
  totalprice decimal(8,2),
  totalcount int(6),
  lastupdated datetime NOT NULL,
  clientid int(7) NOT NULL,
  CONSTRAINT carts_pk PRIMARY KEY (cartid),
  CONSTRAINT carts_clients_fk FOREIGN KEY (clientid) REFERENCES clients (clientid)
);

--
-- Tabellenstruktur für Tabelle caritems
--
DROP TABLE IF EXISTS cartitems;

CREATE TABLE cartitems 
(
  cartitemid int(10) NOT NULL AUTO_INCREMENT,
  cartid int(7) NOT NULL,
  itemid int(7) NOT NULL,
  quantity int(3) NOT NULL,
  CONSTRAINT cartitems_pk PRIMARY KEY (cartitemid),
  CONSTRAINT cartitems_carts_fk FOREIGN KEY (cartid) REFERENCES carts (cartid),
  CONSTRAINT cartitems_items_fk FOREIGN KEY (itemid) REFERENCES items (itemid)
);

--
-- Tabellenstruktur für Tabelle purchases
--
DROP TABLE IF EXISTS purchases;

CREATE TABLE purchases 
(
  purchaseid int(7) NOT NULL AUTO_INCREMENT,
  purchasedat datetime NOT NULL,
  clientid int(7) NOT NULL,
  CONSTRAINT purchases_pk PRIMARY KEY (purchaseid),
  CONSTRAINT purchases_clients_fk FOREIGN KEY (clientid) REFERENCES clients (clientid)
);

--
-- Tabellenstruktur für Tabelle purchaseitems
--
DROP TABLE IF EXISTS purchaseitems;

CREATE TABLE purchaseitems 
(
  purchaseitemid int(10) NOT NULL AUTO_INCREMENT,
  purchaseid int(7) NOT NULL,
  itemid int(7) NOT NULL,
  quantity int(3) NOT NULL,
  price decimal(6,2) NOT NULL,
  CONSTRAINT purchaseitems_pk PRIMARY KEY (purchaseitemid),
  CONSTRAINT purchaseitems_purchases_fk FOREIGN KEY (purchaseid) REFERENCES purchases (purchaseid),
  CONSTRAINT purchaseitems_items_fk FOREIGN KEY (itemid) REFERENCES items (itemid)
);

--
-- Tabellenstruktur für Tabelle newsletter
--
DROP TABLE IF EXISTS newsletter;

CREATE TABLE newsletter 
(
  newsletterid int(10) NOT NULL AUTO_INCREMENT,
  mail varchar(100) NOT NULL,
  createdat datetime NOT NULL,
  CONSTRAINT newsletter_pk PRIMARY KEY (newsletterid)
);

--
-- Tabellenstruktur für Tabelle support_mails
--
DROP TABLE IF EXISTS support_mails;

CREATE TABLE support_mails
(
  mailid int(10) NOT NULL AUTO_INCREMENT,
  firstname varchar(50) NOT NULL,
  lastname varchar(50) NOT NULL,
  mail varchar(100) NOT NULL,
  problem varchar(30) NOT NULL,
  information varchar(2048) NOT NULL,
  createdat datetime NOT NULL,
  CONSTRAINT support_mails_pk PRIMARY KEY (mailid)
);

--
-- Initialbefüllung für Item-Tabelle
--
INSERT INTO `items` (`itemid`, `name`, `description`, `price`, `type`, `category`, `color`, `gender`, `imageurl`) VALUES 
                      (NULL, 'Tagesticket Freitag', 'Gültig am Freitag', '49.99', 'tickets', null, null, null, 'assets/img/item/ticket_freitag.png'), 
                      (NULL, 'Tagesticket Samstag', 'Gültig am Samstag', '69.99', 'tickets', null, null, null, 'assets/img/item/ticket_samstag.png'), 
                      (NULL, 'Tagesticket Sonntag', 'Gültig am Sonntag', '39.99', 'tickets', null, null, null, 'assets/img/item/ticket_sonntag.png'), 
                      (NULL, '3-Tages-Ticket', 'Für alle Festival-Fans. Gültig von Freitag bis Sonntag', '149.99', 'tickets', null, null, null, 'assets/img/item/ticket_3tage.png'), 
                      (NULL, 'VIP', 'für die Bonzen', '999.99', 'tickets', null, null, null, 'assets/img/item/ticket_vip.png'),
                      (NULL, 'Original BORD Hoodie', 'Aus echter Baumwolle', '49.99', 'merchandise', 'Bekleidung', 'schwarz', 'Männer', 'assets/img/item/hoodie.jpg'),
                      (NULL, 'BORD Cap', 'Written Logo', '24.99', 'merchandise', 'Kopfbedeckung', 'schwarz', 'unisex', 'assets/img/item/cap.jpg'),
                      (NULL, 'BORD Festival Feuerzeug schwarz', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'schwarz', 'unisex', 'assets/img/item/lighter.jpg'),
                      (NULL, 'BORD Festival Feuerzeug pink', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'pink', 'unisex', 'assets/img/item/lighter_pink.png'),
                      (NULL, 'BORD Festival Feuerzeug grün', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'grün', 'unisex', 'assets/img/item/lighter_gruen.png'),
                      (NULL, 'BORD Festival Feuerzeug rot', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'rot', 'unisex', 'assets/img/item/lighter_rot.png'),
                      (NULL, 'BORD Festival Feuerzeug lila', 'In vielen verschiedenen Farben', '3.99', 'merchandise', 'sonstige', 'lila', 'unisex', 'assets/img/item/lighter_lila.png'),
                      (NULL, 'BORD Festival Poster', '1% Chance für gratis Autogramm', '9.99', 'merchandise', 'sonstige', 'keine', 'unisex', 'assets/img/item/poster.jpg'),
                      (NULL, 'BORD Beanie', 'Perfekt für kalte Festivaltage', '19.99', 'merchandise', 'Kopfbedeckung', 'schwarz', 'Frauen', 'assets/img/item/beanie.jpg'),
                      (NULL, 'BORD Festival Flaschenöffner', 'Flaschenöffner - super für den Festivalalltag', '5.99', 'merchandise', 'sonstige', 'schwarz', 'unisex', 'assets/img/item/bottleopener.jpg'),
                      (NULL, 'BORD Mütze', 'hält warm und schützt gegen den Wind', '19.99', 'merchandise', 'Kopfbedeckung',  'schwarz',  'unisex', 'assets/img/item/muetze.jpg'),
                      (NULL, 'BORD Festival Shirt', 'Shirt für BORD-Festival-Fans', '29.99', 'merchandise', 'Bekleidung', 'schwarz', 'Männer', 'assets/img/item/shirt.jpg'),
                      (NULL, 'BORDhub Aufkleber', 'Selbstklebender Sticker, 1 Stück', '2.99', 'merchandise', 'sonstige',  'keine',  'unisex', 'assets/img/item/bordhub.png');

DROP VIEW IF EXISTS item_categories;

CREATE VIEW `item_categories` AS SELECT distinct category FROM `items` WHERE category is not null;

DROP VIEW IF EXISTS item_colors;

CREATE VIEW `item_colors` AS SELECT distinct color FROM `items` WHERE color is not null;

DROP VIEW IF EXISTS item_gender;

CREATE VIEW `item_gender` AS SELECT distinct gender FROM `items` WHERE gender is not null;

--
-- Initialbefüllung für Test-Account-Erstellung
--
INSERT INTO `addresses` (`addressid`, `street`, `zip`, `city`, `country`) VALUES
(1, 'Altonaer Str. 25', '99085', 'Erfurt', 'Germany');

INSERT INTO `clients` (`clientid`, `mail`, `firstname`, `lastname`, `dateofbirth`, `password`, `createdat`, `updatedat`, `addressid`) VALUES
(1, 'test@fh-erfurt.de', 'Maximilian', 'Mustermann', '1990-01-01', 0x24327924313024353467674539504d7a374d3768456d62676871306e6563686a6d546a49647737313158466b4a3136696b6639304852327557387743, '2020-02-03 21:37:10', '2020-02-03 21:37:10', 1);
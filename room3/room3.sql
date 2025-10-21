CREATE DATABASE IF NOT EXISTS escape_room CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE escape_room;

DROP TABLE IF EXISTS room3_items;
CREATE TABLE room3_items (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  theme ENUM('prog','net','db','web','kyb') NOT NULL,
  text VARCHAR(255) NOT NULL,
  is_good TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX(theme),
  INDEX(is_good)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO room3_items (theme,text,is_good) VALUES
-- PROGRAMOVANIE
('prog','for (i=0;i<10;i++)',1),
('prog','if (x > 0)',1),
('prog','class Ship {}',1),
('prog','function init()',1),
('prog','array.push()',1),
('prog','try { } catch(e){}',1),
('prog','DNS query',0),
('prog','ARP request',0),
('prog','SELECT * FROM users',0),
('prog','<div class="box">',0),

-- SIETE
('net','IP 192.168.1.10',1),
('net','DNS A record',1),
('net','TCP 3-way handshake',1),
('net','HTTPS 443',1),
('net','DHCP ACK',1),
('net','TLS handshake',1),
('net','PRIMARY KEY',0),
('net','flexbox',0),
('net','array.map()',0),
('net','INSERT INTO log',0),

-- DATABÁZY
('db','SELECT * FROM users',1),
('db','INSERT INTO table VALUES (...)',1),
('db','INNER JOIN',1),
('db','PRIMARY KEY',1),
('db','ACID',1),
('db','ROLLBACK',1),
('db','ICMP echo',0),
('db','<button>',0),
('db','while(true)',0),
('db','TLS handshake',0),

-- WEB
('web','<html>',1),
('web','CSS grid',1),
('web','flexbox',1),
('web','fetch()',1),
('web','<img src="...">',1),
('web','<button>',1),
('web','FOREIGN KEY',0),
('web','UDP datagram',0),
('web','PID controller',0),
('web','ROLLBACK',0),

-- KYBERNETIKA
('kyb','PID controller',1),
('kyb','setpoint',1),
('kyb','feedback loop',1),
('kyb','actuator',1),
('kyb','Ziegler–Nichols',1),
('kyb','derivácia',1),
('kyb','SELECT COUNT(*)',0),
('kyb','HTTP 80',0),
('kyb','<script>',0),
('kyb','array.reduce()',0);

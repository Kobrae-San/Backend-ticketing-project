CREATE DATABASE billeterie; 
USE billeterie;

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_name` varchar(120) NOT NULL,
  `event_place` varchar(255) NOT NULL,
  `event_date` varchar(18) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visitor_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `public_code` varchar(60) NOT NULL,
  `private_key` varchar(60) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (event_id) REFERENCES events(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `visitors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `last_name` varchar(128) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (event_id) REFERENCES events(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

  ALTER TABLE `tickets`
  ADD FOREIGN KEY (visitor_id) REFERENCES visitors(id);
CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `event_name` varchar(120) NOT NULL,
  `event_place` varchar(255) NOT NULL,
  `event_date` varchar(18) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `ticket` (
  `id` int(11) NOT NULL,
  `visitor_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `public_code` varchar(60) NOT NULL,
  `private_key` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `visitor` (
  `id` int(11) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `first_name` varchar(128) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `visitor_id` (`visitor_id`),
  ADD KEY `event_id` (`event_id`);

ALTER TABLE `visitor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`);

ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
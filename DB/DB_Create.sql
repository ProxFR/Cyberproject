CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_first_name` varchar(255) NOT NULL,
  `user_last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `user_student_id` varchar(255) NOT NULL,
  `user_phone_number` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_dob` varchar(255) NOT NULL,
  `user_profile_picture` longblob NOT NULL,
  `user_medical_declaration` longblob NOT NULL,
  `user_medical_conditions` varchar(255) NOT NULL,
  `doctor_first_name` varchar(255) NOT NULL,
  `doctor_last_name` varchar(255) NOT NULL,
  `doctor_address_street` varchar(255) NOT NULL,
  `doctor_address_city` varchar(255) NOT NULL,
  `doctor_address_state` varchar(255) NOT NULL,
  `doctor_address_country` varchar(255) NOT NULL,
  `doctor_phone_number` varchar(255) NOT NULL,
  `doctor_email` varchar(255) NOT NULL,
  `kin_first_name` varchar(255) NOT NULL,
  `kin_last_name` varchar(255) NOT NULL,
  `kin_address_street` varchar(255) NOT NULL,
  `kin_address_city` varchar(255) NOT NULL,
  `kin_address_state` varchar(255) NOT NULL,
  `kin_address_country` varchar(255) NOT NULL,
  `kin_phone_number` varchar(255) NOT NULL,
  `kin_email` varchar(255) NOT NULL,
  `iv` varchar(32) NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `is_completed` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `clubs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `registrations` (
  `USER_ID` INT(11) NOT NULL,
  `CLUB_ID` INT(11) NOT NULL,
  INDEX (`USER_ID`),
  INDEX (`CLUB_ID`)
) ENGINE = InnoDB;

INSERT INTO `clubs`(`name`) VALUES 
('Airsoft'),
('Archery'),
('Athletics'),
('Badminton'),
('Men’s Basketball'),
('Women’s Basketball'),
('Recreational Basketball'),
('Boxing'),
('Cricket'),
('Cycling/Triathlon'),
('Canoeing/Kayaking'),
('Ballroom'),
('Hip Hop'),
('Salsa'),
('Irish Dancing'),
('Equestrian'),
('Men’s Gaelic Football'),
('Ladies Gaelic Football'),
('Hurling'),
('Camogie'),
('Handball'),
('Golf'),
('Hill Walking'),
('Karting'),
('Olympic Handball'),
('Pilates'),
('Pool'),
('Powerlifting/Weightlifting'),
('Men’s Rugby'),
('Women’s Rugby'),
('Men’s Soccer'),
('Women’s Soccer'),
('Futsal'),
('Wexford Men’s Soccer'),
('Recreational Soccer'),
('Swimming'),
('Table Tennis'),
('Tennis'),
('Men’s Volleyball'),
('Women’s Volleyball'),
('Yoga'),
('Zumba');

ALTER TABLE `registrations`
  ADD CONSTRAINT `registrations_ibfk_1` FOREIGN KEY (`USER_ID`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `registrations_ibfk_2` FOREIGN KEY (`CLUB_ID`) REFERENCES `clubs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
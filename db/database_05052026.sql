-- Autorendi andmebaasi struktuur

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mark` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `engine` varchar(50) DEFAULT NULL,
  `fuel` varchar(30) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `year` int(11) DEFAULT NULL,
  `transmission` varchar(30) DEFAULT NULL,
  `seats` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('vaba','renditud','hoolduses') DEFAULT 'vaba',
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
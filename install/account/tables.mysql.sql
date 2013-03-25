
CREATE TABLE IF NOT EXISTS `account` (
  `acc_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `birthday` date NOT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `nickname` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `activated` enum('Yes','No') NOT NULL DEFAULT 'No',
  `email` varchar(255) NOT NULL,
  `email_canonical` varchar(255) NOT NULL,
  `mobile_phone` varchar(16) NOT NULL,
  `location_iso2` varchar(2) NOT NULL,
  `timezone` varchar(64) NOT NULL,
  `lang_iso2` varchar(2) NOT NULL,
  `algorithm` varchar(16) NOT NULL,
  `salt` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `last_logged_at` datetime DEFAULT NULL,
  `last_logged_ip` varchar(64) NOT NULL,
  `role` varchar(32) NOT NULL,
  `locked` enum('Yes','No') NOT NULL DEFAULT 'No',
  `lock_reason` varchar(255) NOT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `activation_expires_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deletion_requested_at` datetime DEFAULT NULL,
  `deletion_scheduled_at` datetime DEFAULT NULL,
  `deleted` enum('Yes','No') NOT NULL DEFAULT 'No',
  PRIMARY KEY (`acc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `account_activity` (
  `act_id` int(11) NOT NULL AUTO_INCREMENT,
  `acc_id` int(11) DEFAULT NULL,
  `act_type` varchar(64) NOT NULL,
  `act_ip` varchar(64) NOT NULL,
  `act_count` int(11) NOT NULL DEFAULT '1',
  `act_at` datetime NOT NULL,
  `act_expire_at` datetime NOT NULL,
  PRIMARY KEY (`act_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


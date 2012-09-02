#SUMCake sql generated on: 2012-01-18 03:24:16 : 1326857056

DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `users`;


CREATE TABLE `permissions` (
  `id` char(36) NOT NULL,
  `name` varchar(60) NOT NULL,
  `role` varchar(10) NOT NULL,
  `copied_from` varchar(10) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`role`),
  KEY `copied_from` (`copied_from`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `roles` (
  `id` char(36) NOT NULL,
  `name` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `users` (
  `id` varchar(36) NOT NULL,
  `username` varchar(48) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'User',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  `token_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `authenticator_key` varchar(16) DEFAULT NULL,
  `password_requested` varchar(36) NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `emial` (`email_address`),
  UNIQUE KEY `username` (`username`),
  KEY `disabled` (`disabled`),
  KEY `active` (`active`),
  KEY `password_requested` (`password_requested`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

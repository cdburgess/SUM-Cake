#SUMCake sql generated on: 2012-01-18 03:24:16 : 1326857056

DROP TABLE IF EXISTS `permissions`;
DROP TABLE IF EXISTS `users`;


CREATE TABLE `permissions` (
	`id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '',
	`name` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '',
	`role` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '',
	`copied_from` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '',
	`created` datetime NOT NULL COMMENT '',
	`modified` datetime NOT NULL COMMENT '',	PRIMARY KEY  (`id`),
	KEY `role` (`role`),
	KEY `copied_from` (`copied_from`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

CREATE TABLE `users` (
	`id` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '',
	`email_address` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '',
	`password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '',
	`first_name` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '',
	`last_name` varchar(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '',
	`role` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT 'User' NOT NULL COMMENT '',
	`active` tinyint(1) DEFAULT '0' NOT NULL COMMENT '',
	`disabled` tinyint(1) DEFAULT '0' NOT NULL COMMENT '',
	`password_requested` varchar(36) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '0' NOT NULL COMMENT '',
	`created` datetime NOT NULL COMMENT '',
	`modified` datetime NOT NULL COMMENT '',	PRIMARY KEY  (`id`),
	UNIQUE KEY `username` (`email_address`),
	KEY `disabled` (`disabled`),
	KEY `active` (`active`),
	KEY `password_requested` (`password_requested`))	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=MyISAM;

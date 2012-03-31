
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c5b18b3-1774-41ad-b46d-3007e4ca782d', '*', 'Admin', NULL, '2010-08-05 14:01:55', '2010-08-05 14:21:32');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c5e4476-8260-4c6e-a790-45cde4ca782d', 'Users:login', 'User', NULL, '2010-08-07 23:45:26', '2010-08-07 23:45:26');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c67452c-715c-4b73-968f-119de4ca782d', 'Users:index', 'User', NULL, '2010-08-14 19:38:52', '2010-08-14 19:38:52');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c674534-e200-4b6b-843f-119de4ca782d', 'Users:view', 'User', NULL, '2010-08-14 19:39:00', '2010-08-14 19:39:00');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c67453b-684c-4530-b5b8-119de4ca782d', 'Users:edit', 'User', NULL, '2010-08-14 19:39:07', '2010-08-14 19:39:07');
INSERT INTO `permissions` (`id`, `name`, `role`, `copied_from`, `created`, `modified`) VALUES('4c6751af-d284-4449-8f8b-12f8e4ca782d', 'Users:change_password', 'User', NULL, '2010-08-14 20:32:15', '2010-08-14 20:32:15');


INSERT INTO `users` (`id`, `email_address`, `password`, `first_name`, `last_name`, `role`, `active`, `disabled`, `password_requested`, `created`, `modified`) VALUES('4c5b1927-5e14-4379-95d1-3009e4ca782d', 'admin@example.com', '5cca727f3f7ee0c868a1980cdf9252415fd7a1d1', 'Admin', 'User', 'Admin', '1', '0', '0', '2010-08-05 14:03:51', '2012-01-15 00:56:08');
INSERT INTO `users` (`id`, `email_address`, `password`, `first_name`, `last_name`, `role`, `active`, `disabled`, `password_requested`, `created`, `modified`) VALUES('4dfec325-c338-49e5-983c-43a8e4ca782d', 'user@example.com', '5cca727f3f7ee0c868a1980cdf9252415fd7a1d1', 'Example', 'User', 'User', '1', '0', '0', '2011-06-19 21:48:53', '2012-01-15 00:27:44');

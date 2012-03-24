--
-- Baza danych: `simple_task_manager`
--

--
-- Struktura tabeli dla  `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(4) NOT NULL,
  `priority` int(4) NOT NULL,
  `message` varchar(255) NOT NULL,
  `status_id` int(4) NOT NULL,
  `updated` int(10) NOT NULL,
  `created` int(10) NOT NULL,
  `deadline` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla  `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `user_token` varchar(32) NOT NULL,
  `created` int(10) NOT NULL,
  `updated` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Struktura tabeli dla  `api_tokens`
--

CREATE TABLE IF NOT EXISTS `api_tokens` (
`id` INT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`user_id` INT( 3 ) NOT NULL ,
`token` VARCHAR( 32 ) NOT NULL ,
`expiration_date` INT( 10 ) NOT NULL
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci;

--
-- Baza danych: `simple_task_manager`
--

--
-- Struktura tabeli dla  `tasks`
--

CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(4) NOT NULL,
  `message` varchar(255) NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `updated` int(10) NOT NULL,
  `created` int(10) NOT NULL,
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
  `created` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `%prefix%_bans` (
  `bid` INT NOT NULL AUTO_INCREMENT,
  `player_ip` VARCHAR(16) NOT NULL,
  `player_last_ip` VARCHAR(16) NOT NULL DEFAULT 'Unknown',
  `player_id` VARCHAR(30) NOT NULL,
  `player_nick` VARCHAR(32) NOT NULL,
  `admin_ip` VARCHAR(16) NOT NULL DEFAULT 'Unknown',
  `admin_id` VARCHAR(30) NOT NULL DEFAULT 'Unknown',
  `admin_nick` VARCHAR(32) NOT NULL,
  `ban_type` VARCHAR(7) NOT NULL,
  `ban_reason` VARCHAR(100) NOT NULL,
  `ban_created` INT NOT NULL,
  `ban_length` INT NOT NULL,
  `server_ip` VARCHAR(23) NOT NULL DEFAULT 'IP_LAN',
  `server_name` VARCHAR(64) NOT NULL DEFAULT 'WEBSITE',
  `ban_kicks` INT NOT NULL DEFAULT 0,
  `expired` INT(1) NOT NULL,
  `c_code` VARCHAR(35) NOT NULL DEFAULT 'unknown',
  `update_ban` INT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (bid)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE IF NOT EXISTS `%prefix%_levels` (
  `level` int(12) NOT NULL DEFAULT '0',
  `bans_add` enum('yes','no') DEFAULT 'no',
  `bans_edit` enum('yes','no','own') DEFAULT 'no',
  `bans_delete` enum('yes','no','own') DEFAULT 'no',
  `bans_unban` enum('yes','no','own') DEFAULT 'no',
  `bans_import` enum('yes','no') DEFAULT 'no',
  `bans_export` enum('yes','no') DEFAULT 'no',
  `webadmins_view` enum('yes','no') DEFAULT 'no',
  `webadmins_edit` enum('yes','no') DEFAULT 'no',
  `websettings_view` enum('yes','no') DEFAULT 'no',
  `websettings_edit` enum('yes','no') DEFAULT 'no',
  `permissions_edit` enum('yes','no') DEFAULT 'no',
  `prune_db` enum('yes','no') DEFAULT 'no',
  `ip_view` enum('yes','no') DEFAULT 'no',
  PRIMARY KEY (`level`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `%prefix%_levels` (`level`, `bans_add`, `bans_edit`, `bans_delete`, `bans_unban`, `bans_import`, `bans_export`, `webadmins_view`, `webadmins_edit`, `websettings_view`, `websettings_edit`, `permissions_edit`, `prune_db`, `ip_view`) VALUES
(1, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes');

CREATE TABLE IF NOT EXISTS `%prefix%_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(11) DEFAULT NULL,
  `ip` varchar(32) DEFAULT NULL,
  `username` varchar(32) DEFAULT NULL,
  `action` varchar(64) DEFAULT NULL,
  `remarks` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `%prefix%_logs` (`id`, `timestamp`, `ip`, `username`, `action`, `remarks`) VALUES
(1, UNIX_TIMESTAMP(), '127.0.0.1', 'admin', 'Install', 'Installation CS:Bans');

CREATE TABLE IF NOT EXISTS `%prefix%_usermenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pos` int(11) DEFAULT NULL,
  `activ` tinyint(1) NOT NULL DEFAULT '1',
  `lang_key` varchar(64) DEFAULT NULL,
  `url` varchar(64) DEFAULT NULL,
  `lang_key2` varchar(64) DEFAULT NULL,
  `url2` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `%prefix%_usermenu` VALUES ('1', '1', '1', '_HOME', '/bans/index', '_HOME', '/bans/index');


CREATE TABLE IF NOT EXISTS `%prefix%_webadmins` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `level` int(11) DEFAULT '99',
  `logcode` varchar(64) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `last_action` int(11) DEFAULT NULL,
  `try` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `%prefix%_webconfig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cookie` varchar(32) DEFAULT NULL,
  `bans_per_page` int(11) DEFAULT NULL,
  `design` varchar(32) DEFAULT NULL,
  `banner` varchar(64) DEFAULT NULL,
  `banner_url` varchar(128) NOT NULL,
  `default_lang` varchar(32) DEFAULT NULL,
  `start_page` varchar(64) DEFAULT NULL,
  `auto_prune` int(1) NOT NULL DEFAULT '0',
  `show_kick_count` int(1) DEFAULT '1',
  `use_capture` INT(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `%prefix%_webconfig` (`id`, `cookie`, `bans_per_page`, `design`, `banner`, `banner_url`, `default_lang`, `start_page`, `auto_prune`, `show_kick_count`,`use_capture`) VALUES
(1, 'csbans', 50, 'dark', 'amxbans.png', '', 'english', '/bans/index', 0, 0, 1);

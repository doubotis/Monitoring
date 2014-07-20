-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Dim 20 Juillet 2014 à 15:24
-- Version du serveur: 5.1.66
-- Version de PHP: 5.3.3-7+squeeze16

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `monitoring`
--

-- --------------------------------------------------------

--
-- Structure de la table `alarms`
--

CREATE TABLE IF NOT EXISTS `alarms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) NOT NULL,
  `type` int(11) NOT NULL,
  `email` tinyint(1) NOT NULL,
  `sms` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `alarms`
--

INSERT INTO `alarms` (`id`, `name`, `type`, `email`, `sms`) VALUES
(1, 'Avertissement SityTrail', 1, 0, 0),
(2, 'Important SityTrail', 2, 1, 0),
(3, 'Danger SityTrail', 3, 1, 1),
(4, 'Avertissement SityZen', 1, 0, 0),
(5, 'Important SityZen', 2, 1, 0),
(6, 'Danger SityZen', 3, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `alarm_id` bigint(20) NOT NULL,
  `controller_id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `exception` text,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_interv` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `resolved` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `alerts`
--

INSERT INTO `alerts` (`id`, `alarm_id`, `controller_id`, `user_id`, `exception`, `timestamp`, `last_interv`, `resolved`) VALUES
(1, 1, 4, NULL, 'Exception in thread "Thread-2" java.lang.IllegalStateException: Component must have a valid peer\r\n    at java.awt.Component$FlipBufferStrategy.createBuffers(Unknown Source)\r\n    at java.awt.Component$FlipBufferStrategy.<init>(Unknown Source)\r\n    at java.awt.Component$FlipSubRegionBufferStrategy.<init>(Unknown Source)\r\n    at java.awt.Component.createBufferStrategy(Unknown Source)\r\n    at java.awt.Canvas.createBufferStrategy(Unknown Source)\r\n    at java.awt.Component.createBufferStrategy(Unknown Source)\r\n    at java.awt.Canvas.createBufferStrategy(Unknown Source)\r\n    at Game1Test.Base.render(Base.java:46)\r\n    at Game1Test.Base.run(Base.java:33)\r\n    at java.lang.Thread.run(Unknown Source)', '2014-07-13 12:25:00', '2014-07-13 15:25:56', 1),
(2, 3, 5, NULL, 'Exception in thread "Animation Thread" java.lang.NullPointerException\r\n	at sketch_apr20a.displayStar(sketch_apr20a.java:36)\r\n	at sketch_apr20a.draw(sketch_apr20a.java:65)\r\n	at processing.core.PApplet.handleDraw(Unknown Source)\r\n	at processing.core.PApplet.run(Unknown Source)\r\n	at java.lang.Thread.run(Thread.java:662)', '2014-07-12 12:43:44', '2014-07-13 12:43:44', 1),
(3, 5, 3, NULL, 'java.lang.IllegalStateException: java.lang.IllegalAccessException: Class org.openide.util.WeakListenerImpl$ProxyListener can not access a member of class org.openide.filesystems.$Proxy0 with modifiers "public"\r\n	at org.openide.util.WeakListenerImpl$ProxyListener.<init>(WeakListenerImpl.java:423)\r\n	at org.openide.util.WeakListenerImpl.create(WeakListenerImpl.java:164)\r\n	at org.openide.util.WeakListeners.create(WeakListeners.java:271)\r\n	at org.openide.filesystems.MultiFileObject.<init>(MultiFileObject.java:132)\r\n	at org.openide.filesystems.MultiFileObject.<init>(MultiFileObject.java:149)\r\n	at org.openide.filesystems.MultiFileSystem.getMultiRoot(MultiFileSystem.java:278)\r\n	at org.openide.filesystems.MultiFileSystem.findResource(MultiFileSystem.java:366)\r\n	at org.openide.filesystems.FileUtil.getConfigFile(FileUtil.java:2091\r\n	at org.openide.filesystems.FileUtil.getConfigRoot(FileUtil.java:2121)\r\n	at org.netbeans.core.startup.Main.getModuleSystem(Main.java:170)\r\n	at org.netbeans.core.startup.Main.getModuleSystem(Main.java:150)\r\n	at org.netbeans.core.startup.Main.start(Main.java:307)\r\n	at org.netbeans.core.startup.TopThreadGroup.run(TopThreadGroup.java:123)\r\n	at java.lang.Thread.run(Thread.java:724)', '2014-07-13 20:14:48', '2014-07-13 23:34:15', 1),
(4, 5, 3, NULL, 'java.lang.NotFoundMessageException', '2014-07-14 01:07:36', '2014-07-16 01:17:14', 1);

-- --------------------------------------------------------

--
-- Structure de la table `controllers`
--

CREATE TABLE IF NOT EXISTS `controllers` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `descr` text NOT NULL,
  `alarm_count` int(11) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `strict` tinyint(1) NOT NULL DEFAULT '0',
  `interval` int(11) NOT NULL DEFAULT '15',
  `control_type` varchar(100) NOT NULL DEFAULT 'TrueControlDescriptor',
  `control_code` text NOT NULL,
  `alarm_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Contenu de la table `controllers`
--

INSERT INTO `controllers` (`id`, `name`, `descr`, `alarm_count`, `enabled`, `strict`, `interval`, `control_type`, `control_code`, `alarm_id`) VALUES
(3, 'JournÃ©es du Patrimoine - Encodage', 'Test HTTP sur le site d''encodage pour JDP.', 0, 0, 1, 15, 'PDOControlDescriptor', '{"host":"192.168.1.60:8971","username":"test","password":"sample","db":"sample"}', 5),
(4, 'SityZen - VisÃ©', 'RÃ©ponse JSON de sz1.sityzen.net', 0, 1, 0, 15, 'TrueControlDescriptor', '', 4),
(5, 'SityTrail - Portail', 'Test HTTP sur la page principale', 0, 0, 0, 15, 'HTTPStatusCodeControlDescriptor', '{"url":"http:\\/\\/www.sitytrail.com","timeout":"3000","status_code":"200"}', 3),
(14, 'SityZen - OEWB', '', 0, 1, 0, 15, 'TrueControlDescriptor', '', 5),
(15, 'SityTrail - Carto', 'Tests sur tc2, tc2dev, tc2ter', 0, 1, 0, 15, 'TrueControlDescriptor', '', 1),
(16, 'JournÃ©es du Patrimoine - Viewer', '', 0, 1, 0, 15, 'TrueControlDescriptor', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `interventions`
--

CREATE TABLE IF NOT EXISTS `interventions` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `alert_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `start_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `end_timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Structure de la table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `locked` tinyint(1) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `projects`
--

INSERT INTO `projects` (`id`, `name`, `locked`, `visible`) VALUES
(1, 'Demo', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `email_active` tinyint(1) NOT NULL,
  `phone` varchar(100) NOT NULL DEFAULT '',
  `phone_active` tinyint(1) NOT NULL,
  `rights` varchar(300) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `email_active`, `phone`, `phone_active`, `rights`) VALUES
(-1, 'root', 'dc76e9f0c0006e8f919e0c515c66dbba3982f785', '', 0, '', 0, 'superadmin');

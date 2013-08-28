-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 28, 2013 at 03:55 AM
-- Server version: 5.5.29
-- PHP Version: 5.3.10-1ubuntu3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `g6`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `userid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `friends` text NOT NULL,
  `blocked` text NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`userid`, `name`, `password`, `email`, `friends`, `blocked`) VALUES
(6, 'sakti', '1234', 'def@abc.com', 'a:1:{i:0;s:1:"7";}', ''),
(7, 'sugetha', '1234', 'sugetha24@gmail.com', 'a:1:{i:0;s:1:"6";}', ''),
(8, 'metube', '1234', 'metube@you.com', '', ''),
(9, 'vaishnavi', '123', 'vaishnavisusendran@gmail.com', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `account_channel`
--

CREATE TABLE IF NOT EXISTS `account_channel` (
  `userid` int(10) NOT NULL,
  `subid` int(10) NOT NULL,
  `subscribe_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mediaid` int(20) unsigned NOT NULL,
  KEY `userid` (`userid`),
  KEY `subid` (`subid`),
  KEY `mediaid` (`mediaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `account_channel`
--

INSERT INTO `account_channel` (`userid`, `subid`, `subscribe_time`, `mediaid`) VALUES
(7, 6, '2013-04-28 05:33:37', 75);

-- --------------------------------------------------------

--
-- Table structure for table `acc_group`
--

CREATE TABLE IF NOT EXISTS `acc_group` (
  `userid` int(10) NOT NULL COMMENT 'Member user_id',
  `group_id` int(10) unsigned NOT NULL COMMENT 'Group ID',
  KEY `userid` (`userid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `acc_group`
--

INSERT INTO `acc_group` (`userid`, `group_id`) VALUES
(7, 6),
(6, 6);

-- --------------------------------------------------------

--
-- Table structure for table `blocked_users`
--

CREATE TABLE IF NOT EXISTS `blocked_users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sender` int(10) NOT NULL,
  `recipient` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `blocked_users`
--

INSERT INTO `blocked_users` (`id`, `sender`, `recipient`) VALUES
(12, 7, 8),
(13, 6, 8);

-- --------------------------------------------------------

--
-- Table structure for table `comments_tutor`
--

CREATE TABLE IF NOT EXISTS `comments_tutor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `url` varchar(255) COLLATE utf8_bin NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text COLLATE utf8_bin NOT NULL,
  `mediaid` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mediaid` (`mediaid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=66 ;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_forums`
--

CREATE TABLE IF NOT EXISTS `discussion_forums` (
  `discussionid` int(10) NOT NULL AUTO_INCREMENT COMMENT 'Discussion Id',
  `dtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `userid` int(10) NOT NULL COMMENT 'Account id of users participating in the discussion',
  `discussion_message` text NOT NULL COMMENT 'discussion messages',
  `group_id` int(10) unsigned NOT NULL COMMENT 'Group ID',
  PRIMARY KEY (`discussionid`,`userid`,`group_id`),
  KEY `userid` (`userid`),
  KEY `groupid` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Details of the different discussions' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `discussion_forums`
--

INSERT INTO `discussion_forums` (`discussionid`, `dtime`, `userid`, `discussion_message`, `group_id`) VALUES
(8, '2013-04-28 05:28:22', 7, 'hi\r\n', 6),
(9, '2013-04-28 05:28:32', 7, 'hello\r\n', 6);

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE IF NOT EXISTS `downloads` (
  `downloadid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `mediaid` int(20) unsigned NOT NULL,
  `downloadtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`downloadid`),
  KEY `mediaid` (`mediaid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `fav_media`
--

CREATE TABLE IF NOT EXISTS `fav_media` (
  `userid` int(10) NOT NULL,
  `mediaid` int(20) unsigned NOT NULL,
  KEY `userid` (`userid`),
  KEY `mediaid` (`mediaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fav_media`
--

INSERT INTO `fav_media` (`userid`, `mediaid`) VALUES
(7, 74);

-- --------------------------------------------------------

--
-- Table structure for table `friendship_requests`
--

CREATE TABLE IF NOT EXISTS `friendship_requests` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sender` int(10) NOT NULL,
  `recipient` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `friendship_requests`
--

INSERT INTO `friendship_requests` (`id`, `sender`, `recipient`) VALUES
(17, 7, 6);

-- --------------------------------------------------------

--
-- Table structure for table `friend_foe_list`
--

CREATE TABLE IF NOT EXISTS `friend_foe_list` (
  `account_userid` int(10) NOT NULL COMMENT 'id of the user account',
  `friend_foe_userid` int(10) NOT NULL COMMENT 'id of the friend/foe',
  `category` varchar(20) NOT NULL DEFAULT '1' COMMENT 'friend or foe',
  PRIMARY KEY (`account_userid`,`friend_foe_userid`),
  KEY `friend_foe_userid` (`friend_foe_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='lists the friends or foes';

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id for the group',
  `group_name` varchar(30) NOT NULL COMMENT 'name of the group',
  `userid` int(10) NOT NULL COMMENT 'account id of the user',
  `category` varchar(30) NOT NULL COMMENT 'type of group',
  PRIMARY KEY (`group_id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='holds details of the Groups' AUTO_INCREMENT=7 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`group_id`, `group_name`, `userid`, `category`) VALUES
(6, 'test', 7, 'Gaming');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `mediaid` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL COMMENT 'name of the media',
  `userid` int(10) NOT NULL,
  `path` varchar(50) NOT NULL COMMENT 'media path',
  `type` varchar(20) NOT NULL COMMENT 'type of the media (i.e) audio, video or image',
  `category` varchar(20) NOT NULL COMMENT 'category of the media',
  `description` varchar(100) DEFAULT NULL COMMENT 'description of the media',
  `format` varchar(20) NOT NULL COMMENT 'extension of the file',
  `visibility` int(1) unsigned NOT NULL DEFAULT '1' COMMENT '1 indicates public which is default, 2 for private',
  `uploadtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'time when uploaded',
  `last_access` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'last when accessed',
  `count` int(11) NOT NULL,
  PRIMARY KEY (`mediaid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=80 ;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`mediaid`, `name`, `userid`, `path`, `type`, `category`, `description`, `format`, `visibility`, `uploadtime`, `last_access`, `count`) VALUES
(72, '20051210-w50s.wmv', 6, 'uploads/', 'video', 'Entertainment', 'auto race', 'video/x-ms-wmv', 1, '2013-04-27 22:36:46', '2013-04-28 06:52:37', 11),
(74, 'paw.gif', 6, 'uploads/', 'image', 'News', 'paw pic', 'image/gif', 1, '2013-04-27 22:40:31', '2013-04-28 07:20:11', 22),
(75, '485879_482179811815851_537029256_n.jpg', 7, 'uploads/', 'image', 'Nature', 'this is a test picture', 'image/jpeg', 1, '2013-04-28 03:21:15', '2013-04-28 07:17:33', 9),
(79, 'facepalm.png', 6, 'uploads/', 'image', 'Nature', 'sample pci', 'image/png', 1, '2013-04-28 06:55:52', '2013-04-28 06:56:45', 2);

-- --------------------------------------------------------

--
-- Table structure for table `mediatags`
--

CREATE TABLE IF NOT EXISTS `mediatags` (
  `tags_id` int(9) NOT NULL,
  `mediaid` int(20) unsigned NOT NULL,
  KEY `tags_id` (`tags_id`),
  KEY `mediaid` (`mediaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mediatags`
--

INSERT INTO `mediatags` (`tags_id`, `mediaid`) VALUES
(72, 72),
(74, 74),
(75, 75),
(79, 79);

-- --------------------------------------------------------

--
-- Table structure for table `media_playlist`
--

CREATE TABLE IF NOT EXISTS `media_playlist` (
  `playlistid` int(10) NOT NULL,
  `mediaid` int(20) unsigned NOT NULL,
  KEY `mediaid` (`mediaid`),
  KEY `playlistid` (`playlistid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media_playlist`
--

INSERT INTO `media_playlist` (`playlistid`, `mediaid`) VALUES
(16, 74);

-- --------------------------------------------------------

--
-- Table structure for table `media_rating`
--

CREATE TABLE IF NOT EXISTS `media_rating` (
  `rating` int(5) NOT NULL DEFAULT '0',
  `userid` int(10) NOT NULL,
  `mediaid` int(20) unsigned NOT NULL,
  KEY `userid` (`userid`),
  KEY `mediaid` (`mediaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media_rating`
--

INSERT INTO `media_rating` (`rating`, `userid`, `mediaid`) VALUES
(3, 7, 74);

-- --------------------------------------------------------

--
-- Table structure for table `media_rec`
--

CREATE TABLE IF NOT EXISTS `media_rec` (
  `userid` int(10) NOT NULL,
  `mediaid` int(20) unsigned NOT NULL,
  KEY `userid` (`userid`),
  KEY `mediaid` (`mediaid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `media_rec`
--

INSERT INTO `media_rec` (`userid`, `mediaid`) VALUES
(7, 74);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(9) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL COMMENT 'account id of the destination',
  `sender_accountid` int(10) NOT NULL COMMENT 'account id of the sender',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'time the message was sent',
  `contents` text COMMENT 'body of the message',
  `subject` text NOT NULL COMMENT 'message header',
  `sender_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Flag to check if message exists in outbox',
  `recv_flag` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Flag to check if message exists in inbox',
  `unread` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Flag to check if message is read/unread',
  PRIMARY KEY (`message_id`),
  KEY `sender_accountid` (`sender_accountid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `userid`, `sender_accountid`, `timestamp`, `contents`, `subject`, `sender_flag`, `recv_flag`, `unread`) VALUES
(12, 7, 6, '2013-04-28 03:38:06', 'Helloooo', 'heeeyyy', 0, 0, 1),
(13, 6, 7, '2013-04-28 03:38:13', 'adskfas;dkfj', 'gotcha', 0, 0, 1),
(14, 6, 7, '2013-04-28 05:27:27', 'Hey Saktiman and Sugeman\r\n\r\nWell done, commendable!!! This devil did eat up into all\r\nyour sleep and time.\r\n\r\nWay to go\r\n\r\nsriniman', '', 0, 0, 1),
(15, 6, 7, '2013-04-28 05:33:09', 'Saktiman and sugeman\r\n\r\nWell done!! Commendable! Al the tabs are working fine. I\r\nlike it, and this devil ate into all your sleep, food!!\r\nImpressive girls!!\r\n\r\nWell done\r\nsriniman\r\n', 'adagapadathuena na', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE IF NOT EXISTS `playlists` (
  `playlistid` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `userid` int(10) NOT NULL,
  PRIMARY KEY (`playlistid`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`playlistid`, `name`, `userid`) VALUES
(16, 'suge', 7),
(17, 'p1', 6);

-- --------------------------------------------------------

--
-- Table structure for table `search`
--

CREATE TABLE IF NOT EXISTS `search` (
  `searchid` int(10) NOT NULL AUTO_INCREMENT,
  `keyword` varchar(30) NOT NULL,
  `count` int(10) NOT NULL,
  PRIMARY KEY (`searchid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `search`
--

INSERT INTO `search` (`searchid`, `keyword`, `count`) VALUES
(30, 'paw', 16),
(31, '', 6),
(32, 'sunrise', 19),
(33, 'cricket', 1),
(34, ' Type the name of the media..!', 1),
(35, 'vaish', 1),
(36, 'life', 1),
(37, 'gangnam style', 1),
(38, 'floral', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE IF NOT EXISTS `tags` (
  `tags_id` int(9) NOT NULL,
  `tags` varchar(100) NOT NULL,
  PRIMARY KEY (`tags_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`tags_id`, `tags`) VALUES
(72, 'auto, race'),
(74, 'paw ,pic'),
(75, 'sunrise'),
(79, 'i,j,l');

-- --------------------------------------------------------

--
-- Table structure for table `tag_count`
--

CREATE TABLE IF NOT EXISTS `tag_count` (
  `tags` varchar(20) DEFAULT NULL COMMENT 'all the tags',
  `count` int(20) NOT NULL DEFAULT '0' COMMENT 'count for the tags',
  `tagid` int(20) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`tagid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `tag_count`
--

INSERT INTO `tag_count` (`tags`, `count`, `tagid`) VALUES
('sunrise', 19, 24),
('life', 1, 25),
('goes', 0, 26),
('on', 0, 27),
('life', 1, 28),
('goes', 0, 29),
('on', 0, 30),
('happy', 0, 31),
('i', 0, 32),
('j', 0, 33),
('l', 0, 34);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_channel`
--
ALTER TABLE `account_channel`
  ADD CONSTRAINT `account_channel_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_channel_ibfk_2` FOREIGN KEY (`subid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_channel_ibfk_3` FOREIGN KEY (`mediaid`) REFERENCES `media` (`mediaid`) ON DELETE CASCADE;

--
-- Constraints for table `acc_group`
--
ALTER TABLE `acc_group`
  ADD CONSTRAINT `acc_group_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `acc_group_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `acc_group_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `acc_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE;

--
-- Constraints for table `discussion_forums`
--
ALTER TABLE `discussion_forums`
  ADD CONSTRAINT `discussion_forums_ibfk_19` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_20` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_10` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_11` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_12` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_13` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_14` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_15` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_16` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_17` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_18` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_5` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_6` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_7` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_8` FOREIGN KEY (`group_id`) REFERENCES `groups` (`group_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `discussion_forums_ibfk_9` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `fav_media`
--
ALTER TABLE `fav_media`
  ADD CONSTRAINT `fav_media_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `fav_media_ibfk_2` FOREIGN KEY (`mediaid`) REFERENCES `media` (`mediaid`) ON DELETE CASCADE;

--
-- Constraints for table `friend_foe_list`
--
ALTER TABLE `friend_foe_list`
  ADD CONSTRAINT `friend_foe_list_ibfk_1` FOREIGN KEY (`account_userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `friend_foe_list_ibfk_2` FOREIGN KEY (`friend_foe_userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `groups`
--
ALTER TABLE `groups`
  ADD CONSTRAINT `groups_ibfk_6` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_ibfk_3` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_ibfk_4` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE,
  ADD CONSTRAINT `groups_ibfk_5` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`);

--
-- Constraints for table `mediatags`
--
ALTER TABLE `mediatags`
  ADD CONSTRAINT `mediatags_ibfk_1` FOREIGN KEY (`mediaid`) REFERENCES `media` (`mediaid`),
  ADD CONSTRAINT `mediatags_ibfk_2` FOREIGN KEY (`tags_id`) REFERENCES `tags` (`tags_id`);

--
-- Constraints for table `media_playlist`
--
ALTER TABLE `media_playlist`
  ADD CONSTRAINT `media_playlist_ibfk_1` FOREIGN KEY (`playlistid`) REFERENCES `playlists` (`playlistid`),
  ADD CONSTRAINT `media_playlist_ibfk_2` FOREIGN KEY (`mediaid`) REFERENCES `media` (`mediaid`),
  ADD CONSTRAINT `media_playlist_ibfk_3` FOREIGN KEY (`playlistid`) REFERENCES `playlists` (`playlistid`),
  ADD CONSTRAINT `media_playlist_ibfk_4` FOREIGN KEY (`mediaid`) REFERENCES `media` (`mediaid`),
  ADD CONSTRAINT `media_playlist_ibfk_5` FOREIGN KEY (`playlistid`) REFERENCES `playlists` (`playlistid`),
  ADD CONSTRAINT `media_playlist_ibfk_6` FOREIGN KEY (`mediaid`) REFERENCES `media` (`mediaid`);

--
-- Constraints for table `media_rating`
--
ALTER TABLE `media_rating`
  ADD CONSTRAINT `media_rating_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`),
  ADD CONSTRAINT `media_rating_ibfk_2` FOREIGN KEY (`mediaid`) REFERENCES `media` (`mediaid`);

--
-- Constraints for table `media_rec`
--
ALTER TABLE `media_rec`
  ADD CONSTRAINT `media_rec_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`),
  ADD CONSTRAINT `media_rec_ibfk_2` FOREIGN KEY (`mediaid`) REFERENCES `media` (`mediaid`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_accountid`) REFERENCES `account` (`userid`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`) ON DELETE CASCADE;

--
-- Constraints for table `playlists`
--
ALTER TABLE `playlists`
  ADD CONSTRAINT `playlists_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `account` (`userid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

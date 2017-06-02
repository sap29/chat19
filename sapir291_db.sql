-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Jun 02, 2017 at 01:28 PM
-- Server version: 5.6.35-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sapir291_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `calendar of events`
--

CREATE TABLE IF NOT EXISTS `calendar of events` (
  `Serial Number` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Beginning time` time DEFAULT NULL,
  `End time` time DEFAULT NULL,
  `Title` text CHARACTER SET utf8 NOT NULL,
  `Content` text CHARACTER SET utf8 NOT NULL,
  `Done` text CHARACTER SET utf8,
  `Remarks` text CHARACTER SET utf8,
  PRIMARY KEY (`Serial Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE IF NOT EXISTS `chats` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_name` varchar(255) NOT NULL,
  `is_private` tinyint(1) NOT NULL DEFAULT '1',
  `admin_user_id` int(11) DEFAULT NULL,
  `allowed_users` text NOT NULL,
  `allowed_users_2` text NOT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chat_id`, `chat_name`, `is_private`, `admin_user_id`, `allowed_users`, `allowed_users_2`) VALUES
(1, 'עקרונות שפות תכנות', 0, 1, '', ',1,303034433,204458855,203668553,201631751,203128293,300300300'),
(2, 'אבטחת מערכות תוכנה', 0, 1, '', ',1,303034433,204458855,203668553,201631751,203128293,300300300'),
(3, 'סמינר', 0, 1, '', ',1,303034433,204458855,203668553,201631751,203128293,300300300'),
(4, 'מבוא לסיבוכיות וחישוביות', 0, 1, '', ',1,303034433,204458855,203668553,201631751,203128293,300300300'),
(5, 'מבוא ללמידה חישובית', 0, 1, '', ',1,303034433,204458855,203668553,201631751,203128293,300300300'),
(6, 'כללי', 1, 1, ',303034433,204458855,203668553', ''),
(14, 'מבוא לסטטיסטיקה', 0, 1, '', ',1'),
(19, 'פרויקט גמר', 1, 1, ',1,204458855,303034433', ''),
(23, 'היי', 1, 201631751, ',201631751', '');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE IF NOT EXISTS `chat_messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `message` text CHARACTER SET utf8 NOT NULL,
  `messgae_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`message_id`, `chat_id`, `user_id`, `user_name`, `message`, `messgae_time`) VALUES
(12, 1, 204458855, 'ספיר דדון', 'שלום חברים', '2017-05-21 06:49:40'),
(13, 1, 201631751, 'נצר משאלי', 'היי!', '2017-05-21 06:49:46'),
(14, 1, 204458855, 'ספיר דדון', 'אתם מוזמנים לדבר\r\n', '2017-05-21 06:50:03'),
(15, 1, 303034433, 'עופר שושן', 'שלום:)', '2017-05-21 06:50:05'),
(16, 1, 303034433, 'עופר שושן', 'טטטאההה', '2017-05-21 06:50:15'),
(17, 1, 201631751, 'נצר משאלי', 'אני צירפתי את הסילבוס\r\n', '2017-05-21 06:50:21');

-- --------------------------------------------------------

--
-- Table structure for table `course rooms`
--

CREATE TABLE IF NOT EXISTS `course rooms` (
  `Course Number` int(11) NOT NULL,
  `Year` int(4) NOT NULL,
  PRIMARY KEY (`Course Number`,`Year`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `Course Number` int(11) NOT NULL,
  `Year` int(4) NOT NULL,
  `Course Name` text CHARACTER SET utf8 NOT NULL,
  `Lecturer` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`Course Number`,`Year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `private rooms`
--

CREATE TABLE IF NOT EXISTS `private rooms` (
  `Room Number` int(11) NOT NULL AUTO_INCREMENT,
  `Room Name` text CHARACTER SET utf8 NOT NULL,
  `Room Manager` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`Room Number`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(9) NOT NULL,
  `User_Name` text NOT NULL,
  `Full_Name` text NOT NULL,
  `gender` text,
  `Password` text NOT NULL,
  `e-Mail` text NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `User_Name`, `Full_Name`, `gender`, `Password`, `e-Mail`) VALUES
(0, 'Daniel', 'Daniel', NULL, '12345', 'ע'),
(1, 'admin', 'admin', '1', 'admin', 'sapir291192@gmail.com'),
(123456789, 'מתן אוחיון', 'מתן אוחיון', NULL, '123456', 'test@test.com'),
(201631751, 'נצר משאלי', 'נצר משאלי', NULL, '12345', 'netzer7@gmail.com'),
(203128293, 'מיכאל כהן', 'מיכאל כהן', NULL, '11071991', 'mc11079@gmail.com'),
(203668553, 'גל אברהמי', 'גל אברהמי', '1', '203668553', 'gal.avrahami92@gmail.com'),
(204458855, 'ספיר דדון', 'ספיר דדון', '1', '204458855', 'sapir291192@gmail.com'),
(300300300, 'יניב וולוטקר', 'יניב וולוטקר', NULL, 'yaniv', 'Yanivvalo@gmail.com'),
(303034433, 'עופר שושן', 'עופר שושן', '1', '303034433', 'ofershushan@gmail.com'),
(304081250, 'Roman', 'Roman sima', NULL, '12345', 'R1o1m1a1@gmail.com'),
(304803968, 'דניאל', 'דניאל יצחק ברגר ', NULL, '12345678', 'Danielberger659@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

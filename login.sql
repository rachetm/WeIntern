-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2018 at 02:18 PM
-- Server version: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login`
--

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `username` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `checkin` time NOT NULL,
  `checkout` time DEFAULT NULL,
  `total_hrs` time DEFAULT NULL,
  `temp` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `log`
--

INSERT INTO `log` (`username`, `date`, `checkin`, `checkout`, `total_hrs`, `temp`) VALUES
('rmudnur', '2018-07-11', '13:58:42', '14:28:22', '00:00:35', '14:28:12');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(256) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `user_status` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `name`, `email`, `password`, `hash`, `status`, `user_status`) VALUES
('admin', 'Sachin Kulgod', 'sachin@wetrunk.in', '$2y$10$9iiLN6Zb4BKK/9C174KGYOlyb7swTNBjh1dprLe.3PUBS7nBwNwCy', '$2y$10$uSBoUD84afxUU06zQ3hGK.zAUdKgAIMB3M51vIAopybMPixND9kHO', 0, 1),
('arpita', 'Arpita Rao', 'arpitarao21@gmail.com', '$2y$10$9plUMVApUglo.3D2rjS6k.xRerqPy/dCjugeOz0P01CCYvYzi0R0u', '$2y$10$utrRXT6JHnMcNIS9KLJUIeMadZS29Yea8fVhaGhtfCKEKZLn1HA9G', 0, 1),
('ashwini', 'Ashwini SF', 'sfashwini@gmail.com', '$2y$10$BBIlcZM5ETJiQFrypGajzOdFT3YYcju/QZjD8eOorc/hCNWoOEkT2', '$2y$10$/IwlcViHmcT8yHfXV4oIk.BZSrbwp9eIVWs621.lF9mRkmFw5sE0i', 0, 1),
('krishna', 'Krishna Gavas', 'krishna.gavas@gmail.com', '$2y$10$BV/pVOwiIM3DwM5gX1cMreb8zQpxhy/ZlbIE0zGRRtqN.1FOBki2a', '$2y$10$tVtCf4ZIh62NaT2qeJ/h3O/43wxFfMGJ9InuaokwvMODbHo7GlFN6', 0, 1),
('lucifyer', 'Vishnu Gawas', 'gawasvishnu26@gmail.com', '$2y$10$yb0n1BQzMD7t5dhIOcZnXekfqsmf/DsaqrtFvSom9BJMPAMxt1tpS', '$2y$10$82peDV1yR3ZkOeXMwhpj4eo7uxuuUPOagkcXTf0sxLoIbkfvIfzRC', 0, 1),
('rmudnur', 'Rachet Mudnur', 'rmudnur@gmail.com', '$2y$10$DuYz5Vbrt/BG8LTzYD7m.eKd4Ox3/y74W/uPKxv.vVixLoyDDyOOu', '$2y$10$64hcKdrnAHcgaBST9d.G4OiKLhRwqHb3h9a4VTR9zb5Ya9jEsDSD.', 0, 1),
('suraj', 'Suraj Nagare', 'surajnagare42@gmail.com', '$2y$10$NnvAgRj8Pxpk7.Mge7wMJeMb1dO4eTtDa8M7J7LvBp99yFhQ43w.K', '$2y$10$4qHOJTT.B6i8.NuDcrDRp.ypAdL/ng0sq/ZuYfVqwMqILHpSc1dPm', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `time` time DEFAULT NULL,
  `content` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`username`,`date`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`);

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `clr_notif` ON SCHEDULE EVERY 1 DAY STARTS '2018-07-10 00:00:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Clear Notifications' DO TRUNCATE notification$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

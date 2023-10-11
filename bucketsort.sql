-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2017 at 07:05 AM
-- Server version: 5.5.39
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bucketsort`
--

-- --------------------------------------------------------

--
-- Table structure for table `file_details`
--

CREATE TABLE IF NOT EXISTS `file_details` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(155) NOT NULL,
  `variable_i` smallint(6) NOT NULL,
  `variable_j` smallint(6) NOT NULL,
  `variable_total` smallint(6) NOT NULL,
  `variable_option` tinyint(4) NOT NULL,
  `var_stage` smallint(6) NOT NULL,
  `prev_stage_pivot` smallint(6) NOT NULL,
  `pivot_value` smallint(6) NOT NULL,
  `pivot_index1` smallint(6) NOT NULL,
  `pivot_index2` smallint(6) NOT NULL,
  `pivot_index3` smallint(6) NOT NULL,
  `var_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `saved` tinyint(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `file_details`
--

INSERT INTO `file_details` (`id`, `user_id`, `filename`, `variable_i`, `variable_j`, `variable_total`, `variable_option`, `var_stage`, `prev_stage_pivot`, `pivot_value`, `pivot_index1`, `pivot_index2`, `pivot_index3`, `var_time`, `saved`) VALUES
(1, 0, 'version2 sample.csv', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2017-09-11 08:09:05', 0),
(3, 0, 'version2 sample.csv', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2017-09-20 08:24:32', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sort_data`
--

CREATE TABLE IF NOT EXISTS `sort_data` (
`id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `file_id` int(11) NOT NULL,
  `data_value` varchar(255) NOT NULL,
  `data_index` smallint(6) NOT NULL,
  `urgency_rank` smallint(6) NOT NULL,
  `importance_rank` smallint(6) NOT NULL,
  `difficulty_rank` smallint(6) NOT NULL,
  `time_sort` smallint(6) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `sort_data`
--

INSERT INTO `sort_data` (`id`, `user_id`, `file_id`, `data_value`, `data_index`, `urgency_rank`, `importance_rank`, `difficulty_rank`, `time_sort`) VALUES
(1, 0, 1, 'Catch up with my old friend jerry (10)', 0, 3, 1, 0, 0),
(2, 0, 1, 'go to the doctor and fix my arm (6)', 1, 1, 3, 0, 0),
(3, 0, 1, 'take my child to school after it opens (4)', 2, 1, 2, 1, 0),
(4, 0, 1, 'hire someone to make a ranking program (8)', 3, 2, 2, 0, 0),
(5, 0, 1, 'go apply for a new credit card with better interest rates (11)', 4, 3, 2, 0, 0),
(6, 0, 1, 'go hire a new nanny because my nanny is stealing from me (7)', 5, 2, 1, 0, 0),
(7, 0, 1, 'fix the air conditioner because it''s hot and the couch is melting (2)', 6, 1, 1, 2, 0),
(8, 0, 1, 'find out why my computer turns off every 10 minutes (1)', 7, 1, 1, 1, 0),
(9, 0, 1, 'go drop off my clothing at the dry cleaner''s office (5)', 8, 1, 2, 2, 0),
(10, 0, 1, 'catch up with my old friend thomas (9)', 9, 2, 3, 0, 0),
(11, 0, 1, 'go dry my cat after the bath (3)', 10, 1, 1, 3, 0),
(23, 0, 3, 'Catch up with my old friend jerry (10)', 0, 3, 0, 0, 0),
(24, 0, 3, 'go to the doctor and fix my arm (6)', 1, 0, 0, 0, 0),
(25, 0, 3, 'take my child to school after it opens (4)', 2, 0, 0, 0, 0),
(26, 0, 3, 'hire someone to make a ranking program (8)', 3, 0, 0, 0, 0),
(27, 0, 3, 'go apply for a new credit card with better interest rates (11)', 4, 0, 0, 0, 0),
(28, 0, 3, 'go hire a new nanny because my nanny is stealing from me (7)', 5, 2, 0, 0, 0),
(29, 0, 3, 'fix the air conditioner because it''s hot and the couch is melting (2)', 6, 0, 0, 0, 0),
(30, 0, 3, 'find out why my computer turns off every 10 minutes (1)', 7, 0, 0, 0, 0),
(31, 0, 3, 'go drop off my clothing at the dry cleaner''s office (5)', 8, 0, 0, 0, 0),
(32, 0, 3, 'catch up with my old friend thomas (9)', 9, 0, 0, 0, 0),
(33, 0, 3, 'go dry my cat after the bath (3)', 10, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE IF NOT EXISTS `user_details` (
`id` int(11) NOT NULL,
  `user_email` varchar(155) NOT NULL,
  `user_password` varchar(200) NOT NULL,
  `var_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file_details`
--
ALTER TABLE `file_details`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sort_data`
--
ALTER TABLE `sort_data`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file_details`
--
ALTER TABLE `file_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `sort_data`
--
ALTER TABLE `sort_data`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

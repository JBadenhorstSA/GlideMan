-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2016 at 01:31 AM
-- Server version: 5.6.15-log
-- PHP Version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `glidemantst`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

DROP TABLE IF EXISTS `tbl_accounts`;
CREATE TABLE IF NOT EXISTS `tbl_accounts` (
  `account_no` int(11) NOT NULL AUTO_INCREMENT,
  `mem_no` int(11) NOT NULL,
  `balance` decimal(11,2) NOT NULL,
  PRIMARY KEY (`account_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_creditnote`
--

DROP TABLE IF EXISTS `tbl_creditnote`;
CREATE TABLE IF NOT EXISTS `tbl_creditnote` (
  `note_no` int(11) NOT NULL AUTO_INCREMENT,
  `account_no` int(11) NOT NULL,
  `cdate` date NOT NULL,
  `tot_credit` decimal(11,2) NOT NULL,
  PRIMARY KEY (`note_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_credit_items`
--

DROP TABLE IF EXISTS `tbl_credit_items`;
CREATE TABLE IF NOT EXISTS `tbl_credit_items` (
  `note_no` int(11) NOT NULL,
  `item_no` int(11) NOT NULL,
  `item_descr` varchar(50) NOT NULL,
  `item_ammount` decimal(11,2) NOT NULL,
  KEY `note_no` (`note_no`,`item_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_flights`
--

DROP TABLE IF EXISTS `tbl_flights`;
CREATE TABLE IF NOT EXISTS `tbl_flights` (
  `flight_no` int(11) NOT NULL AUTO_INCREMENT,
  `timesheet` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `glider_reg` varchar(6) NOT NULL,
  `flight_duration` decimal(11,2) NOT NULL,
  `payment_resp` varchar(25) NOT NULL,
  `pax_name_surname` varchar(25) NOT NULL,
  `p1` varchar(50) NOT NULL,
  `p2` varchar(50) NOT NULL,
  `flight_type` varchar(15) NOT NULL,
  `take_off_time` varchar(5) NOT NULL,
  `landing_time` varchar(5) NOT NULL,
  `tug_time` decimal(11,2) NOT NULL,
  `no_landings` int(11) NOT NULL,
  `launch_method` varchar(25) NOT NULL,
  `tacho_start` decimal(11,2) NOT NULL,
  `tacho_end` decimal(11,2) NOT NULL,
  PRIMARY KEY (`flight_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gliders`
--

DROP TABLE IF EXISTS `tbl_gliders`;
CREATE TABLE IF NOT EXISTS `tbl_gliders` (
  `reg` varchar(6) NOT NULL,
  `type_name` varchar(25) DEFAULT NULL,
  `callsign` varchar(5) DEFAULT NULL,
  `owner` varchar(25) NOT NULL,
  `auth_fly` char(1) NOT NULL,
  `ls1_exp` date NOT NULL,
  `radio_exp_date` date NOT NULL,
  `weight_bal_exp_date` date NOT NULL,
  `hours` decimal(11,2) DEFAULT NULL,
  `tacho` decimal(11,2) NOT NULL,
  `land` int(11) DEFAULT NULL,
  `tot_launch` int(11) DEFAULT NULL,
  `s_launch` int(11) DEFAULT NULL,
  `w_launch` int(11) DEFAULT NULL,
  `a_launch` int(11) DEFAULT NULL,
  `m_launch` int(11) DEFAULT NULL,
  `notes` text,
  `charge_option` varchar(10) NOT NULL,
  `charge_calculation` varchar(20) NOT NULL,
  `active` char(1) NOT NULL,
  PRIMARY KEY (`reg`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_history`
--

DROP TABLE IF EXISTS `tbl_history`;
CREATE TABLE IF NOT EXISTS `tbl_history` (
  `change_no` int(11) NOT NULL AUTO_INCREMENT,
  `changer_mem_no` int(11) NOT NULL,
  `change_made` varchar(100) NOT NULL,
  `change_date` date NOT NULL,
  `change_table` varchar(20) NOT NULL,
  PRIMARY KEY (`change_no`),
  FULLTEXT KEY `change_table` (`change_table`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_history`
--

INSERT INTO `tbl_history` (`change_no`, `changer_mem_no`, `change_made`, `change_date`, `change_table`) VALUES
(1, 1, 'User Test1 User1 Logged in.', '2016-10-23', 'History');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_instructors`
--

DROP TABLE IF EXISTS `tbl_instructors`;
CREATE TABLE IF NOT EXISTS `tbl_instructors` (
  `member_no` int(11) NOT NULL,
  `instructor_grade` varchar(10) NOT NULL,
  `renewal_date` date NOT NULL,
  PRIMARY KEY (`member_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoices`
--

DROP TABLE IF EXISTS `tbl_invoices`;
CREATE TABLE IF NOT EXISTS `tbl_invoices` (
  `inv_no` int(11) NOT NULL AUTO_INCREMENT,
  `idate` date NOT NULL,
  `account_no` int(11) NOT NULL,
  `mem_name` varchar(10) NOT NULL,
  `mem_surname` varchar(25) NOT NULL,
  `tot_ammount` decimal(11,2) NOT NULL,
  PRIMARY KEY (`inv_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inv_items`
--

DROP TABLE IF EXISTS `tbl_inv_items`;
CREATE TABLE IF NOT EXISTS `tbl_inv_items` (
  `inv_no` int(11) NOT NULL,
  `item_no` int(11) NOT NULL,
  `item_descr` varchar(50) NOT NULL,
  `item_ammount` decimal(11,2) NOT NULL,
  KEY `item_no` (`item_no`),
  KEY `inv_no` (`inv_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

DROP TABLE IF EXISTS `tbl_items`;
CREATE TABLE IF NOT EXISTS `tbl_items` (
  `item_no` int(11) NOT NULL AUTO_INCREMENT,
  `item_descr` varchar(25) NOT NULL,
  `item_cost` decimal(11,2) NOT NULL,
  `item_charge` decimal(11,2) NOT NULL,
  PRIMARY KEY (`item_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_licenses`
--

DROP TABLE IF EXISTS `tbl_licenses`;
CREATE TABLE IF NOT EXISTS `tbl_licenses` (
  `lic_no` int(11) NOT NULL AUTO_INCREMENT,
  `member_no` int(11) NOT NULL,
  `lic_ren_date` date NOT NULL,
  `lic_first_date` date NOT NULL,
  `radio_lic_no` varchar(10) NOT NULL,
  `med_exp_date` date NOT NULL,
  `winch_rated` varchar(1) NOT NULL,
  `aerotow_rated` varchar(1) NOT NULL,
  `auto_rated` varchar(1) NOT NULL,
  `tmg_rated` varchar(1) NOT NULL,
  PRIMARY KEY (`lic_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_members`
--

DROP TABLE IF EXISTS `tbl_members`;
CREATE TABLE IF NOT EXISTS `tbl_members` (
  `mem_no` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `id_no` varchar(13) NOT NULL,
  `cell` varchar(12) NOT NULL,
  `tel` varchar(12) NOT NULL,
  `email` varchar(30) NOT NULL,
  `physical_add` varchar(100) NOT NULL,
  `postal_add` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `next_of_kin` varchar(30) NOT NULL,
  `mem_type` varchar(20) NOT NULL,
  `username` varchar(10) NOT NULL,
  `password` varchar(15) NOT NULL,
  `access_group` varchar(10) NOT NULL,
  `photo_url` varchar(30) NOT NULL,
  `active` char(1) NOT NULL,
  PRIMARY KEY (`mem_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_members`
--

INSERT INTO `tbl_members` (`mem_no`, `name`, `surname`, `id_no`, `cell`, `tel`, `email`, `physical_add`, `postal_add`, `birthday`, `next_of_kin`, `mem_type`, `username`, `password`, `access_group`, `photo_url`, `active`) VALUES
(1, 'Test1', 'User1', '', '', '', '', '', '', '0000-00-00', '', 'Normal Coprorate', 'Test', 'password', 'Admin', '', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_membership`
--

DROP TABLE IF EXISTS `tbl_membership`;
CREATE TABLE IF NOT EXISTS `tbl_membership` (
  `type` varchar(20) NOT NULL,
  `monthly_amount` float(11,2) NOT NULL,
  UNIQUE KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_membership`
--

INSERT INTO `tbl_membership` (`type`, `monthly_amount`) VALUES
('Normal Corporate', 208.34),
('Student', 104.17),
('Executive', 416.67),
('Honorary', 0.00),
('Social', 104.17),
('Family', 104.17),
('Country', 104.17),
('Special', 0.00),
('Temporary', 104.17);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payments`
--

DROP TABLE IF EXISTS `tbl_payments`;
CREATE TABLE IF NOT EXISTS `tbl_payments` (
  `payment_no` int(11) NOT NULL AUTO_INCREMENT,
  `account_no` int(11) NOT NULL,
  `pdate` date NOT NULL,
  `description` varchar(50) NOT NULL,
  `ammount` decimal(11,2) NOT NULL,
  PRIMARY KEY (`payment_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pos_items`
--

DROP TABLE IF EXISTS `tbl_pos_items`;
CREATE TABLE IF NOT EXISTS `tbl_pos_items` (
  `pos_item_no` int(11) NOT NULL AUTO_INCREMENT,
  `pos_item_description` varchar(25) NOT NULL,
  `pos_item_cost` decimal(11,2) NOT NULL,
  `pos_item_charge` decimal(11,2) NOT NULL,
  `pos_item_barcode` varchar(15) NOT NULL,
  `pos_item_qty` int(11) DEFAULT NULL,
  PRIMARY KEY (`pos_item_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pos_receipts`
--

DROP TABLE IF EXISTS `tbl_pos_receipts`;
CREATE TABLE IF NOT EXISTS `tbl_pos_receipts` (
  `receipt_no` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_date` date NOT NULL,
  `receipt_total` decimal(11,2) NOT NULL,
  PRIMARY KEY (`receipt_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pos_receipt_items`
--

DROP TABLE IF EXISTS `tbl_pos_receipt_items`;
CREATE TABLE IF NOT EXISTS `tbl_pos_receipt_items` (
  `receipt_no` int(11) NOT NULL,
  `pos_item_no` int(11) NOT NULL,
  `pos_item_description` varchar(25) NOT NULL,
  `pos_item_price` decimal(11,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_snags`
--

DROP TABLE IF EXISTS `tbl_snags`;
CREATE TABLE IF NOT EXISTS `tbl_snags` (
  `snag_no` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `aircraft_equip_name` varchar(10) NOT NULL,
  `notes` text NOT NULL,
  `member_no` int(11) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`snag_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_timesheets`
--

DROP TABLE IF EXISTS `tbl_timesheets`;
CREATE TABLE IF NOT EXISTS `tbl_timesheets` (
  `sheet_no` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `duty_officer` varchar(25) NOT NULL,
  `locked` char(1) NOT NULL,
  UNIQUE KEY `sheet_no` (`sheet_no`,`date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tugs`
--

DROP TABLE IF EXISTS `tbl_tugs`;
CREATE TABLE IF NOT EXISTS `tbl_tugs` (
  `tug_reg` varchar(6) NOT NULL,
  `owner` varchar(20) NOT NULL,
  `hours_tugged` decimal(11,2) NOT NULL,
  `flights_tugged` int(11) NOT NULL,
  `charge_min` decimal(11,2) NOT NULL,
  PRIMARY KEY (`tug_reg`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_tugs`
--

INSERT INTO `tbl_tugs` (`tug_reg`, `owner`, `hours_tugged`, `flights_tugged`, `charge_min`) VALUES
('ZS-PGF', 'Jonker Syndicate', '20.14', 116, '49.00'),
('ZS-LFX', 'Goudriaan Syndicate', '0.00', 0, '49.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tug_sheets`
--

DROP TABLE IF EXISTS `tbl_tug_sheets`;
CREATE TABLE IF NOT EXISTS `tbl_tug_sheets` (
  `flight_no` int(11) NOT NULL,
  `date` date NOT NULL,
  `tug_reg` varchar(6) NOT NULL,
  `glider_reg` varchar(6) NOT NULL,
  `tacho_start` decimal(11,2) NOT NULL,
  `tacho_finish` decimal(11,2) NOT NULL,
  `tug_time_tot` int(11) NOT NULL,
  UNIQUE KEY `flight_no` (`flight_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_winches`
--

DROP TABLE IF EXISTS `tbl_winches`;
CREATE TABLE IF NOT EXISTS `tbl_winches` (
  `name` varchar(20) NOT NULL,
  `tacho_hours` decimal(11,2) NOT NULL,
  `tot_launches` int(11) NOT NULL,
  `tot_fuel_uplift` decimal(11,2) NOT NULL,
  `tot_eng_oil_uplift` decimal(11,2) NOT NULL,
  `tot_gear_oil_uplift` decimal(11,2) NOT NULL,
  `tot_cable_breaks` int(11) NOT NULL,
  `launch_cost` decimal(11,2) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_winches`
--

INSERT INTO `tbl_winches` (`name`, `tacho_hours`, `tot_launches`, `tot_fuel_uplift`, `tot_eng_oil_uplift`, `tot_gear_oil_uplift`, `tot_cable_breaks`, `launch_cost`) VALUES
('AVPWinch', '234.60', 118, '0.00', '0.00', '0.00', 0, '90.00'),
('NouwensWinch', '7.00', 0, '0.00', '0.00', '0.00', 0, '90.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_winch_sheets`
--

DROP TABLE IF EXISTS `tbl_winch_sheets`;
CREATE TABLE IF NOT EXISTS `tbl_winch_sheets` (
  `sheet_no` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `winch_name` varchar(20) NOT NULL,
  `fuel_uplift` decimal(11,2) NOT NULL,
  `eng_oil_uplift` decimal(11,2) NOT NULL,
  `water_uplift` decimal(11,2) NOT NULL,
  `gear_oil_uplift` int(11) NOT NULL,
  `radio_status` varchar(1) NOT NULL,
  `driver_name` varchar(25) NOT NULL,
  PRIMARY KEY (`sheet_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_winch_sheet_items`
--

DROP TABLE IF EXISTS `tbl_winch_sheet_items`;
CREATE TABLE IF NOT EXISTS `tbl_winch_sheet_items` (
  `launch_no` int(11) NOT NULL AUTO_INCREMENT,
  `sheet_no` int(11) NOT NULL,
  `glider_reg` int(11) NOT NULL,
  `drum` varchar(5) NOT NULL,
  `cable_break` varchar(1) NOT NULL,
  `tacho_start` decimal(11,2) NOT NULL,
  `tacho_finish` decimal(11,2) NOT NULL,
  `launch_time_tot` decimal(11,2) NOT NULL,
  PRIMARY KEY (`launch_no`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

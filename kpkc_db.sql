-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 16, 2014 at 02:53 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kpkc_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_details`
--

CREATE TABLE IF NOT EXISTS `bill_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_unit_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `bill_no` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `bill_details`
--

INSERT INTO `bill_details` (`id`, `product_id`, `product_name`, `product_unit_price`, `quantity`, `bill_no`) VALUES
(1, 4, 'wire 36x36', 100, 2, 1),
(2, 5, 'wire 52x52', 200, 1, 1),
(3, 4, 'wire 36x36', 100, 1, 2),
(4, 5, 'wire 52x52', 200, 2, 2),
(5, 4, 'wire 36x36', 100, 4, 3),
(6, 5, 'wire 52x52', 200, 0, 3),
(7, 6, 'wire wire2', 5000, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `customers_bill`
--

CREATE TABLE IF NOT EXISTS `customers_bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `total_bill_amount` double NOT NULL,
  `amount_paid` double NOT NULL,
  `payment_method` varchar(100) NOT NULL,
  `bill_status` tinyint(1) NOT NULL,
  `bill_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `customers_bill`
--

INSERT INTO `customers_bill` (`id`, `customer_name`, `customer_phone`, `total_bill_amount`, `amount_paid`, `payment_method`, `bill_status`, `bill_date`) VALUES
(1, 'rehmatullah', '123456', 400, 200, '', 0, '2014-12-11 13:11:35'),
(2, 'rehmatullah', '123456', 500, 100, '1232656565', 0, '2014-12-11 14:29:48'),
(3, 'alibaba', '454545', 5400, 0, '', 0, '2014-12-14 21:43:43');

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `member_email_id` varchar(100) NOT NULL,
  `passwd` varchar(100) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `user_type` varchar(50) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`member_email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `members`
--

INSERT INTO `members` (`member_email_id`, `passwd`, `firstname`, `lastname`, `user_type`, `status`, `date_created`) VALUES
('rehmat@google.com', 'e10adc3949ba59abbe56e057f20f883e', 'rehmat', 'ullah', 'super_admin', 1, '2014-12-04 11:04:58'),
('tahir@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'tahir', 'yasin', 'super_admin', 0, '2014-12-04 07:50:02'),
('askjd@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'baog', 'askjdk', 'admin_user', 0, '2014-12-04 11:58:17'),
('dhfkjshfk@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'dsfsdjkjkl', 'dsifdskj', 'super_admin', 0, '2014-12-04 12:00:24'),
('alibaba@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'aliban', 'bhatti', 'admin_user', 0, '2014-12-14 21:41:49');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_name` varchar(100) NOT NULL,
  `sender_email` varchar(100) NOT NULL,
  `message_title` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `message_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_name`, `sender_email`, `message_title`, `message`, `message_date`) VALUES
(1, 'bhati gg', 'rehmatullahbhatti@gmail.com', 'hi sunny', 'hi i need this product .......', '2014-12-15 07:18:28'),
(2, 'khan sab', 'laraka@google.com', 'hi laka', 'laka, i nedd prductssss', '2014-12-15 07:37:25');

-- --------------------------------------------------------

--
-- Table structure for table `payment_history`
--

CREATE TABLE IF NOT EXISTS `payment_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `amount_paid` int(11) NOT NULL,
  `checkno` varchar(100) NOT NULL,
  `paid_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `payment_history`
--


-- --------------------------------------------------------

--
-- Table structure for table `product_stock`
--

CREATE TABLE IF NOT EXISTS `product_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(150) NOT NULL,
  `coil_stock` int(11) NOT NULL,
  `coil_price` int(11) NOT NULL,
  `gauge_size` int(11) NOT NULL,
  `number_cores` int(11) NOT NULL,
  `wire_type` tinyint(1) NOT NULL,
  `coil_weight` float NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `product_stock`
--

INSERT INTO `product_stock` (`id`, `product_name`, `coil_stock`, `coil_price`, `gauge_size`, `number_cores`, `wire_type`, `coil_weight`, `date_added`) VALUES
(4, 'wire 36x36', 45, 100, 52, 7, 0, 20, '2014-12-10 23:43:20'),
(5, 'wire 52x52', 8, 200, 52, 3, 1, 20, '2014-12-11 00:09:11'),
(6, 'wire wire2', 19, 5000, 32, 1, 1, 20, '2014-12-14 21:40:23'),
(7, 'gango taar', 50, 2000, 40, 1, 0, 15, '2014-12-15 11:54:35');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE IF NOT EXISTS `replies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `reply_title` varchar(200) NOT NULL,
  `reply_text` text NOT NULL,
  `reply_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `replies`
--

INSERT INTO `replies` (`id`, `message_id`, `reply_title`, `reply_text`, `reply_date`) VALUES
(1, 2, 'dskfjdsjfk', 'dsnfndhfn ssdfhjsd sdfjhsd                                           ', '2014-12-15 11:27:59'),
(2, 1, 'you are youuuuu yuuuuu', '                                           gannnnnnnnnnnnnnnnnnnnnnnnnn\r\nank,samd,am,m,a asdlkasldk', '2014-12-15 11:48:50');

-- --------------------------------------------------------

--
-- Table structure for table `unit_rates`
--

CREATE TABLE IF NOT EXISTS `unit_rates` (
  `copper_rate` float NOT NULL,
  `aluminium_rate` float NOT NULL,
  `pvc_rate` float NOT NULL,
  `pvc_lead_rate` float NOT NULL,
  `labor_rate` float NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_rates`
--

INSERT INTO `unit_rates` (`copper_rate`, `aluminium_rate`, `pvc_rate`, `pvc_lead_rate`, `labor_rate`, `add_date`) VALUES
(500, 200, 100, 150, 250, '2014-12-06 02:03:28');

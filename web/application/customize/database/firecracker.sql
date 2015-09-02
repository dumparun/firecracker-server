-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 30, 2015 at 09:25 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `firecracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `dailyexpense`
--

CREATE TABLE IF NOT EXISTS `dailyexpense` (
  `expense_seq_no` bigint(20) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(500) NOT NULL,
  `category` int(2) NOT NULL COMMENT '1-Credit Cards, 2-Loans/Debts Paid Back, 3-Food at Hotels, 	4-Grocery & Home Stuffs, 5-Home Routine Expense, 6-LIC/Investement, 7-Educational Expense, 8-Medical Expense, 9-Others, 10-Gas, 11-Snacks, 12-Leisure & Shopping, 13-Vehicle Expenses, 14-Business Initiative, 15-Giving Back, 16-Travelling Expense',
  `paymenttype` int(2) NOT NULL COMMENT '1-CASH, 2-Amex, 3-BOA, 4-CITI, 5-US Bank, 6-CapitalOne',
  `amount` double NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dailyexpense`
--
ALTER TABLE `dailyexpense`
  ADD PRIMARY KEY (`expense_seq_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dailyexpense`
--
ALTER TABLE `dailyexpense`
  MODIFY `expense_seq_no` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

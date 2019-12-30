-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 30, 2019 at 06:18 PM
-- Server version: 10.1.41-MariaDB-0+deb9u1
-- PHP Version: 7.0.33-0+deb9u6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farvodb`
--
CREATE DATABASE IF NOT EXISTS `farvodb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `farvodb`;

-- --------------------------------------------------------

--
-- Table structure for table `tb_access`
--

CREATE TABLE `tb_access` (
  `access_id` int(11) NOT NULL,
  `access_user_id` int(11) NOT NULL,
  `access_level` int(11) NOT NULL,
  `access_company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_access`
--

INSERT INTO `tb_access` (`access_id`, `access_user_id`, `access_level`, `access_company_id`) VALUES
(0, 0, 5, 0),
(87, 0, 4, 35),
(88, 61, 4, 36),
(89, 58, 1, 36),
(90, 60, 2, 36),
(91, 0, 4, 37),
(92, 58, 1, 37),
(93, 62, 3, 36);

-- --------------------------------------------------------

--
-- Table structure for table `tb_batch`
--

CREATE TABLE `tb_batch` (
  `batch_uid` varchar(255) NOT NULL,
  `batch_name` varchar(100) NOT NULL,
  `batch_type` int(11) NOT NULL,
  `batch_company` int(11) NOT NULL,
  `batch_date` varchar(100) NOT NULL,
  `batch_status` int(11) NOT NULL,
  `batch_cycle_id` int(11) NOT NULL,
  `batch_end_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_batch`
--

INSERT INTO `tb_batch` (`batch_uid`, `batch_name`, `batch_type`, `batch_company`, `batch_date`, `batch_status`, `batch_cycle_id`, `batch_end_date`) VALUES
('224b70d5-e834-b6a4-4af9-6d21ae18b821', 'test', 10, 36, '2019-12-19', 18, 2, '2019-12-19'),
('309c0beb-90d2-5e6a-f530-a658bfb442ac', 'eee', 10, 36, '2019-12-19', 17, 3, ''),
('630f68e7-0eaf-f6e9-64b8-b3525ad7dbff', 'test 3', 10, 36, '2019-12-19', 25, 3, ''),
('8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 'batch_demo', 10, 35, '2019-12-19', 17, 1, ''),
('a1ff7ee5-32d1-5162-e3b3-a94c5cd8368c', 'b1', 10, 37, '2019-12-24', 18, 4, '2019-12-24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_batch_house`
--

CREATE TABLE `tb_batch_house` (
  `bh_id` int(11) NOT NULL,
  `bh_house_id` int(11) NOT NULL,
  `bh_batch_uid` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_batch_house`
--

INSERT INTO `tb_batch_house` (`bh_id`, `bh_house_id`, `bh_batch_uid`) VALUES
(1, 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(2, 2, '224b70d5-e834-b6a4-4af9-6d21ae18b821'),
(3, 2, '309c0beb-90d2-5e6a-f530-a658bfb442ac'),
(4, 2, '630f68e7-0eaf-f6e9-64b8-b3525ad7dbff'),
(5, 3, 'a1ff7ee5-32d1-5162-e3b3-a94c5cd8368c');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bird`
--

CREATE TABLE `tb_bird` (
  `bird_id` int(11) NOT NULL,
  `bird_death` int(11) NOT NULL,
  `bird_cull` int(11) NOT NULL,
  `bird_catch` int(11) NOT NULL,
  `bird_balance` int(11) NOT NULL,
  `bird_record_date` varchar(50) NOT NULL,
  `bird_house_id` int(11) NOT NULL,
  `bird_batch_uid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_bird`
--

INSERT INTO `tb_bird` (`bird_id`, `bird_death`, `bird_cull`, `bird_catch`, `bird_balance`, `bird_record_date`, `bird_house_id`, `bird_batch_uid`) VALUES
(1, 0, 0, 0, 1000, '2019-12-19', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(2, 5, 1, 0, 994, '2019-12-19', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(3, 10, 2, 0, 982, '2019-12-20', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(4, 0, 2, 0, 980, '2019-12-21', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(5, 2, 2, 0, 976, '2019-12-22', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(6, 5, 5, 0, 966, '2019-12-23', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(7, 2, 2, 0, 962, '2019-12-24', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(8, 5, 2, 0, 955, '2019-12-25', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(9, 2, 2, 0, 951, '2019-12-26', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(10, 1, 2, 0, 948, '2019-12-27', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(11, 0, 0, 0, 948, '2019-12-28', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(12, 0, 0, 500, 448, '2019-12-30', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(13, 1, 1, 0, 446, '2019-12-31', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(14, 0, 0, 0, 446, '2020-1-1', 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(15, 0, 0, 0, 100, '2019-12-19', 2, '224b70d5-e834-b6a4-4af9-6d21ae18b821'),
(16, 0, 0, 100, 0, '2019-12-19', 2, '224b70d5-e834-b6a4-4af9-6d21ae18b821'),
(17, 0, 0, 0, 100, '2019-12-19', 2, '309c0beb-90d2-5e6a-f530-a658bfb442ac'),
(18, 5, 1, 0, 94, '2019-12-19', 2, '309c0beb-90d2-5e6a-f530-a658bfb442ac'),
(19, 0, 0, 0, 100, '2019-12-19', 2, '630f68e7-0eaf-f6e9-64b8-b3525ad7dbff'),
(20, 0, 0, 0, 1000, '2019-12-24', 3, 'a1ff7ee5-32d1-5162-e3b3-a94c5cd8368c'),
(21, 1000, 0, 0, 0, '2019-12-24', 3, 'a1ff7ee5-32d1-5162-e3b3-a94c5cd8368c');

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `category_id` int(11) NOT NULL,
  `category_level` varchar(100) NOT NULL,
  `category_code` int(11) NOT NULL,
  `category_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`category_id`, `category_level`, `category_code`, `category_desc`) VALUES
(0, 'SYSTEM', 0, 'SYSTEM'),
(1, 'company', 1, 'comp_cat_1'),
(2, 'company', 2, 'comp_cat_2'),
(3, 'farm', 1, 'farm_cat_1'),
(4, 'farm', 2, 'farm_cat_2'),
(5, 'house', 1, 'Free Range'),
(6, 'house', 2, 'Partial Intensive'),
(7, 'house_status', 1, 'active'),
(8, 'house_status', 2, 'maintenance'),
(9, 'house_status', 3, 'closed'),
(10, 'batch', 1, 'broiler'),
(11, 'batch', 2, 'kampung'),
(15, 'company', -1, 'Deactivated'),
(16, 'batch_status', 1, 'scheduled'),
(17, 'batch_status', 2, 'active'),
(18, 'batch_status', 3, 'completed'),
(19, 'feed', 1, 'Grower'),
(20, 'feed', 2, 'Crumble'),
(21, 'feed', 3, 'Starter'),
(25, 'batch_status', 4, 'initialized'),
(27, 'record_type', 1, 'restock'),
(28, 'record_type', 2, 'feeding'),
(29, 'event', 1, 'weight'),
(30, 'event', 2, 'notice'),
(31, 'cycle_status', 1, 'active'),
(32, 'cycle_status', 2, 'completed'),
(33, 'cost', 1, 'feed'),
(34, 'cost', 2, 'day 0 chick'),
(35, 'cost', 3, 'maintenance'),
(36, 'cost', 4, 'field work'),
(37, 'feed_price', 19, '10'),
(39, 'feed_price', 20, '12'),
(40, 'feed_price', 21, '10'),
(54, 'batch_price', 10, '2'),
(55, 'batch_price', 11, '2'),
(58, 'house', 3, 'Lower Intensive'),
(59, 'house', 4, 'Upper Intensive'),
(60, 'house', 5, 'Intensive'),
(61, 'house', 6, 'Traditional');

-- --------------------------------------------------------

--
-- Table structure for table `tb_company`
--

CREATE TABLE `tb_company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_address` varchar(100) NOT NULL,
  `company_ssm` varchar(100) NOT NULL,
  `company_joinDt` date NOT NULL,
  `company_cat` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_company`
--

INSERT INTO `tb_company` (`company_id`, `company_name`, `company_address`, `company_ssm`, `company_joinDt`, `company_cat`) VALUES
(0, '2', '1', '1', '2019-11-13', 2),
(35, 'Demo company', 'Skudai', '1236', '2019-12-19', 1),
(36, 'Test Company', 'utm', '123', '2019-12-19', 1),
(37, 'SADAM', 'UTM', '123', '2019-12-24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_cost`
--

CREATE TABLE `tb_cost` (
  `cost_id` int(11) NOT NULL,
  `cost_date` varchar(100) NOT NULL,
  `cost_category` int(11) NOT NULL,
  `cost_amount` double NOT NULL,
  `cost_note` text NOT NULL,
  `cost_cycle_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_cost`
--

INSERT INTO `tb_cost` (`cost_id`, `cost_date`, `cost_category`, `cost_amount`, `cost_note`, `cost_cycle_id`) VALUES
(1, '2019-12-19', 34, 2000, '1000 birds x RM2.0 = RM2000', 1),
(2, '2019-12-19', 33, 530, 'Grower 15 bag(s) (15 X RM10 = RM150 ) \nCrumble 15 bag(s) (15 X RM12 = RM180 ) \nStarter 20 bag(s) (20 X RM10 = RM200 ) \n', 1),
(3, '2019-12-19', 33, 160, 'Grower 5 bag(s) (5 X RM10 = RM50 ) \nCrumble 5 bag(s) (5 X RM12 = RM60 ) \nStarter 5 bag(s) (5 X RM10 = RM50 ) \n', 2),
(4, '2019-12-19', 34, 150, '100 birds x RM1.5 = RM150', 2),
(5, '2019-12-19', 35, 100, 'maintain', 2),
(6, '2019-12-19', 34, 150, '100 birds x RM1.5 = RM150', 3),
(7, '2019-12-19', 34, 150, '100 birds x RM1.5 = RM150', 3),
(8, '2019-12-24', 33, 320, 'Grower 10 bag(s) (10 X RM10 = RM100 ) \nCrumble 10 bag(s) (10 X RM12 = RM120 ) \nStarter 10 bag(s) (10 X RM10 = RM100 ) \n', 4),
(9, '2019-12-24', 34, 1600, '1000 birds x RM1.60 = RM1600', 4);

-- --------------------------------------------------------

--
-- Table structure for table `tb_cycle`
--

CREATE TABLE `tb_cycle` (
  `cycle_id` int(11) NOT NULL,
  `cycle_farm_id` int(11) NOT NULL,
  `cycle_init_date` varchar(100) NOT NULL,
  `cycle_status` int(11) NOT NULL,
  `cycle_name` varchar(100) NOT NULL,
  `cycle_end_date` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_cycle`
--

INSERT INTO `tb_cycle` (`cycle_id`, `cycle_farm_id`, `cycle_init_date`, `cycle_status`, `cycle_name`, `cycle_end_date`) VALUES
(1, 108, '2019-12-22', 31, 'demo', ''),
(2, 109, '2019-12-19', 32, 'test cycle', '2019-12-19'),
(3, 109, '2019-12-19', 31, 'test 2', ''),
(4, 110, '2019-12-24', 32, 'F1 C1', '2019-12-24');

-- --------------------------------------------------------

--
-- Table structure for table `tb_cycle_batch`
--

CREATE TABLE `tb_cycle_batch` (
  `cb_id` int(11) NOT NULL,
  `cb_cycle_id` int(11) NOT NULL,
  `cb_batch_uid` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_cycle_batch`
--

INSERT INTO `tb_cycle_batch` (`cb_id`, `cb_cycle_id`, `cb_batch_uid`) VALUES
(1, 1, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15'),
(2, 2, '224b70d5-e834-b6a4-4af9-6d21ae18b821'),
(3, 3, '309c0beb-90d2-5e6a-f530-a658bfb442ac'),
(4, 3, '630f68e7-0eaf-f6e9-64b8-b3525ad7dbff'),
(5, 4, 'a1ff7ee5-32d1-5162-e3b3-a94c5cd8368c');

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

CREATE TABLE `tb_event` (
  `event_id` int(11) NOT NULL,
  `event_type` int(11) NOT NULL,
  `event_date` varchar(100) NOT NULL,
  `event_batch_uid` varchar(255) CHARACTER SET utf8 NOT NULL,
  `event_state` int(11) NOT NULL,
  `event_note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_event`
--

INSERT INTO `tb_event` (`event_id`, `event_type`, `event_date`, `event_batch_uid`, `event_state`, `event_note`) VALUES
(1, 29, '2019-12-25', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(2, 29, '2019-12-25', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(3, 29, '2019-12-25', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(4, 29, '2019-12-25', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(5, 29, '2019-12-25', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(6, 29, '2019-12-25', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(7, 29, '2019-12-30', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(8, 29, '2019-12-30', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(9, 29, '2019-12-30', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(10, 29, '2019-12-30', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(11, 29, '2019-12-30', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 0, ''),
(12, 29, '2019-12-02', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1, ''),
(13, 29, '2019-12-02', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1, ''),
(14, 29, '2019-12-02', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1, ''),
(15, 29, '2019-12-02', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1, ''),
(16, 29, '2019-12-06', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1, ''),
(17, 29, '2020-01-02', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1, ''),
(18, 29, '2020-01-06', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1, ''),
(19, 29, '2020-01-06', '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1, ''),
(20, 29, '2019-12-19', '224b70d5-e834-b6a4-4af9-6d21ae18b821', 0, ''),
(21, 29, '2019-11-24', 'a1ff7ee5-32d1-5162-e3b3-a94c5cd8368c', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_farm`
--

CREATE TABLE `tb_farm` (
  `farm_id` int(11) NOT NULL,
  `farm_address` varchar(100) NOT NULL,
  `farm_joinDt` varchar(30) NOT NULL,
  `farm_company_id` int(11) NOT NULL,
  `farm_cat` int(11) NOT NULL,
  `farm_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_farm`
--

INSERT INTO `tb_farm` (`farm_id`, `farm_address`, `farm_joinDt`, `farm_company_id`, `farm_cat`, `farm_name`) VALUES
(108, '123', '2019-12-19 06:35:54', 35, 3, 'Demo'),
(109, 'yutm', '2019-12-19 11:08:04', 36, 3, 'Test farm'),
(110, '123', '2019-12-24 17:29:22', 37, 3, 'F1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_farm_access`
--

CREATE TABLE `tb_farm_access` (
  `fa_id` int(11) NOT NULL,
  `fa_farm_id` int(11) NOT NULL,
  `fa_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_farm_access`
--

INSERT INTO `tb_farm_access` (`fa_id`, `fa_farm_id`, `fa_user_id`) VALUES
(1, 109, 58);

-- --------------------------------------------------------

--
-- Table structure for table `tb_house`
--

CREATE TABLE `tb_house` (
  `house_id` int(11) NOT NULL,
  `house_name` varchar(100) NOT NULL,
  `house_capacity` int(11) NOT NULL,
  `house_cat` int(11) NOT NULL,
  `house_farm_id` int(11) NOT NULL,
  `house_status` int(11) NOT NULL,
  `house_used_capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_house`
--

INSERT INTO `tb_house` (`house_id`, `house_name`, `house_capacity`, `house_cat`, `house_farm_id`, `house_status`, `house_used_capacity`) VALUES
(1, 'demo_house', 10000, 5, 108, 7, 446),
(2, 'test house', 1000, 5, 109, 7, 194),
(3, 'h1', 1000, 5, 110, 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_profit`
--

CREATE TABLE `tb_profit` (
  `profit_id` int(11) NOT NULL,
  `profit_bird_id` int(11) NOT NULL,
  `profit_bird_price` double NOT NULL,
  `profit_amount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_profit`
--

INSERT INTO `tb_profit` (`profit_id`, `profit_bird_id`, `profit_bird_price`, `profit_amount`) VALUES
(1, 12, 2, 1200),
(2, 16, 2, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock`
--

CREATE TABLE `tb_stock` (
  `stock_id` int(11) NOT NULL,
  `stock_farm_id` int(11) NOT NULL,
  `stock_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_stock`
--

INSERT INTO `tb_stock` (`stock_id`, `stock_farm_id`, `stock_name`) VALUES
(1, 108, 'demo_stock'),
(2, 109, 'test stock'),
(3, 110, 'S1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock_balance`
--

CREATE TABLE `tb_stock_balance` (
  `sb_id` int(11) NOT NULL,
  `sb_stock_id` int(11) NOT NULL,
  `sb_item` int(11) NOT NULL,
  `sb_balance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_stock_balance`
--

INSERT INTO `tb_stock_balance` (`sb_id`, `sb_stock_id`, `sb_item`, `sb_balance`) VALUES
(1, 1, 19, 10.5),
(2, 1, 20, 10.5),
(3, 1, 21, 13),
(4, 2, 19, 3),
(5, 2, 20, 3),
(6, 2, 21, 3),
(7, 3, 19, 9),
(8, 3, 20, 8),
(9, 3, 21, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock_record`
--

CREATE TABLE `tb_stock_record` (
  `sr_id` int(11) NOT NULL,
  `sr_stock` int(11) NOT NULL,
  `sr_item` int(11) NOT NULL,
  `sr_item_quantity` float NOT NULL,
  `sr_record_date` varchar(50) NOT NULL,
  `sr_record_type` int(11) NOT NULL,
  `sr_batch_uid` varchar(255) NOT NULL,
  `sr_house_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_stock_record`
--

INSERT INTO `tb_stock_record` (`sr_id`, `sr_stock`, `sr_item`, `sr_item_quantity`, `sr_record_date`, `sr_record_type`, `sr_batch_uid`, `sr_house_id`) VALUES
(1, 1, 19, 0, '2019-12-19', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(2, 1, 20, 0, '2019-12-19', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(3, 1, 21, 0.5, '2019-12-19', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(4, 1, 19, 15, '2019-12-19', 27, '', 0),
(5, 1, 20, 15, '2019-12-19', 27, '', 0),
(6, 1, 21, 20, '2019-12-19', 27, '', 0),
(7, 1, 19, 0, '2019-12-20', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(8, 1, 20, 0, '2019-12-20', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(9, 1, 21, 1, '2019-12-20', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(10, 1, 19, 0.5, '2019-12-21', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(11, 1, 20, 0, '2019-12-21', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(12, 1, 21, 0, '2019-12-21', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(13, 1, 19, 0, '2019-12-22', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(14, 1, 20, 0.5, '2019-12-22', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(15, 1, 21, 2, '2019-12-22', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(16, 1, 19, 0, '2019-12-23', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(17, 1, 20, 1, '2019-12-23', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(18, 1, 21, 1, '2019-12-23', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(19, 1, 19, 1, '2019-12-24', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(20, 1, 20, 1.5, '2019-12-24', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(21, 1, 21, 0, '2019-12-24', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(22, 1, 19, 1, '2019-12-25', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(23, 1, 20, 1, '2019-12-25', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(24, 1, 21, 1, '2019-12-25', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(25, 1, 19, 0, '2019-12-26', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(26, 1, 20, 0, '2019-12-26', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(27, 1, 21, 0.5, '2019-12-26', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(28, 1, 19, 0.5, '2019-12-27', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(29, 1, 20, 0.5, '2019-12-27', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(30, 1, 21, 0, '2019-12-27', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(31, 1, 19, 0, '2019-12-28', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(32, 1, 20, 0, '2019-12-28', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(33, 1, 21, 0.5, '2019-12-28', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(34, 1, 19, 1.5, '2019-12-30', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(35, 1, 20, 0, '2019-12-30', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(36, 1, 21, 0, '2019-12-30', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(37, 1, 19, 0, '2019-12-31', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(38, 1, 20, 0, '2019-12-31', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(39, 1, 21, 1, '2019-12-31', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(40, 1, 19, 0, '2020-1-1', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(41, 1, 20, 0, '2020-1-1', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(42, 1, 21, 0, '2020-1-1', 28, '8b93b7f6-3a2e-d08c-a54d-8ca1ecdabb15', 1),
(43, 2, 19, 5, '2019-12-19', 27, '', 0),
(44, 2, 20, 5, '2019-12-19', 27, '', 0),
(45, 2, 21, 5, '2019-12-19', 27, '', 0),
(46, 2, 19, 1, '2019-12-19', 28, '224b70d5-e834-b6a4-4af9-6d21ae18b821', 2),
(47, 2, 20, 1, '2019-12-19', 28, '224b70d5-e834-b6a4-4af9-6d21ae18b821', 2),
(48, 2, 21, 1, '2019-12-19', 28, '224b70d5-e834-b6a4-4af9-6d21ae18b821', 2),
(49, 2, 19, 1, '2019-12-19', 28, '309c0beb-90d2-5e6a-f530-a658bfb442ac', 2),
(50, 2, 20, 1, '2019-12-19', 28, '309c0beb-90d2-5e6a-f530-a658bfb442ac', 2),
(51, 2, 21, 1, '2019-12-19', 28, '309c0beb-90d2-5e6a-f530-a658bfb442ac', 2),
(52, 3, 19, 10, '2019-12-24', 27, '', 0),
(53, 3, 20, 10, '2019-12-24', 27, '', 0),
(54, 3, 21, 10, '2019-12-24', 27, '', 0),
(55, 3, 19, 1, '2019-12-24', 28, 'a1ff7ee5-32d1-5162-e3b3-a94c5cd8368c', 3),
(56, 3, 20, 2, '2019-12-24', 28, 'a1ff7ee5-32d1-5162-e3b3-a94c5cd8368c', 3),
(57, 3, 21, 3, '2019-12-24', 28, 'a1ff7ee5-32d1-5162-e3b3-a94c5cd8368c', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_phone` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_email`, `user_address`, `user_phone`, `user_password`, `user_name`) VALUES
(0, 'systemadmin@gmail.com', '123', '0129210283', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'System Admin'),
(58, 'f@gmail.com', 'UTM', '0178347834', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Farmer'),
(60, 's@gmail.com', 'utm', '017394594', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Stakeholder'),
(61, 'ca@gmail.com', 'UTM', '0127855201', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Company admin'),
(62, 'cs@gmail.com', 'UTM', '0189899009', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Company Staff'),
(63, '', '', '', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', 'sfsfsdf');

-- --------------------------------------------------------

--
-- Table structure for table `tb_weight`
--

CREATE TABLE `tb_weight` (
  `weight_id` int(11) NOT NULL,
  `weight_bird_id` int(11) NOT NULL,
  `weight_data` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_weight`
--

INSERT INTO `tb_weight` (`weight_id`, `weight_bird_id`, `weight_data`) VALUES
(1, 8, 1),
(2, 12, 1.2),
(3, 16, 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_access`
--
ALTER TABLE `tb_access`
  ADD PRIMARY KEY (`access_id`),
  ADD KEY `access_user_id` (`access_user_id`),
  ADD KEY `access_company_id` (`access_company_id`);

--
-- Indexes for table `tb_batch`
--
ALTER TABLE `tb_batch`
  ADD PRIMARY KEY (`batch_uid`),
  ADD KEY `project_type` (`batch_type`),
  ADD KEY `project_status` (`batch_status`),
  ADD KEY `batch_cycle_id` (`batch_cycle_id`),
  ADD KEY `batch_company` (`batch_company`);

--
-- Indexes for table `tb_batch_house`
--
ALTER TABLE `tb_batch_house`
  ADD PRIMARY KEY (`bh_id`),
  ADD KEY `bh_house_id` (`bh_house_id`),
  ADD KEY `bh_batch_uid` (`bh_batch_uid`(191)),
  ADD KEY `bh_batch_uid_2` (`bh_batch_uid`);

--
-- Indexes for table `tb_bird`
--
ALTER TABLE `tb_bird`
  ADD PRIMARY KEY (`bird_id`),
  ADD KEY `bird_coop_id` (`bird_house_id`),
  ADD KEY `bird_project_uid` (`bird_batch_uid`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`category_id`,`category_level`);

--
-- Indexes for table `tb_company`
--
ALTER TABLE `tb_company`
  ADD PRIMARY KEY (`company_id`,`company_name`),
  ADD KEY `company_cat` (`company_cat`);

--
-- Indexes for table `tb_cost`
--
ALTER TABLE `tb_cost`
  ADD PRIMARY KEY (`cost_id`),
  ADD KEY `cost_category` (`cost_category`),
  ADD KEY `cost_cycle_id` (`cost_cycle_id`);

--
-- Indexes for table `tb_cycle`
--
ALTER TABLE `tb_cycle`
  ADD PRIMARY KEY (`cycle_id`),
  ADD KEY `cycle_farm_id` (`cycle_farm_id`),
  ADD KEY `cycle_status` (`cycle_status`);

--
-- Indexes for table `tb_cycle_batch`
--
ALTER TABLE `tb_cycle_batch`
  ADD PRIMARY KEY (`cb_id`),
  ADD KEY `cb_cycle_id` (`cb_cycle_id`),
  ADD KEY `cb_batch_id` (`cb_batch_uid`(191)),
  ADD KEY `cb_batch_uid` (`cb_batch_uid`);

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `event_type` (`event_type`),
  ADD KEY `event_project_uid` (`event_batch_uid`(191)),
  ADD KEY `event_batch_uid` (`event_batch_uid`(191)),
  ADD KEY `event_batch_uid_2` (`event_batch_uid`);

--
-- Indexes for table `tb_farm`
--
ALTER TABLE `tb_farm`
  ADD PRIMARY KEY (`farm_id`),
  ADD KEY `company_farm` (`farm_company_id`),
  ADD KEY `farm_cat` (`farm_cat`);

--
-- Indexes for table `tb_farm_access`
--
ALTER TABLE `tb_farm_access`
  ADD PRIMARY KEY (`fa_id`),
  ADD KEY `fa_user_id` (`fa_user_id`),
  ADD KEY `fa_farm_id` (`fa_farm_id`);

--
-- Indexes for table `tb_house`
--
ALTER TABLE `tb_house`
  ADD PRIMARY KEY (`house_id`),
  ADD KEY `farm_coop` (`house_farm_id`),
  ADD KEY `coop_cat` (`house_cat`);

--
-- Indexes for table `tb_profit`
--
ALTER TABLE `tb_profit`
  ADD PRIMARY KEY (`profit_id`),
  ADD KEY `profit_bird_id` (`profit_bird_id`);

--
-- Indexes for table `tb_stock`
--
ALTER TABLE `tb_stock`
  ADD PRIMARY KEY (`stock_id`),
  ADD KEY `store_farm_id` (`stock_farm_id`);

--
-- Indexes for table `tb_stock_balance`
--
ALTER TABLE `tb_stock_balance`
  ADD PRIMARY KEY (`sb_id`),
  ADD KEY `sb_store_id` (`sb_stock_id`),
  ADD KEY `sb_item` (`sb_item`);

--
-- Indexes for table `tb_stock_record`
--
ALTER TABLE `tb_stock_record`
  ADD PRIMARY KEY (`sr_id`),
  ADD KEY `sr_store` (`sr_stock`),
  ADD KEY `sr_item` (`sr_item`),
  ADD KEY `sr_type` (`sr_record_type`),
  ADD KEY `sr_project_uid` (`sr_batch_uid`),
  ADD KEY `sr_house_id` (`sr_house_id`),
  ADD KEY `sr_house_id_2` (`sr_house_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tb_weight`
--
ALTER TABLE `tb_weight`
  ADD PRIMARY KEY (`weight_id`),
  ADD KEY `weight_bird_id` (`weight_bird_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_access`
--
ALTER TABLE `tb_access`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- AUTO_INCREMENT for table `tb_batch_house`
--
ALTER TABLE `tb_batch_house`
  MODIFY `bh_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tb_bird`
--
ALTER TABLE `tb_bird`
  MODIFY `bird_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;
--
-- AUTO_INCREMENT for table `tb_company`
--
ALTER TABLE `tb_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `tb_cost`
--
ALTER TABLE `tb_cost`
  MODIFY `cost_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tb_cycle`
--
ALTER TABLE `tb_cycle`
  MODIFY `cycle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tb_cycle_batch`
--
ALTER TABLE `tb_cycle_batch`
  MODIFY `cb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `tb_farm`
--
ALTER TABLE `tb_farm`
  MODIFY `farm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT for table `tb_farm_access`
--
ALTER TABLE `tb_farm_access`
  MODIFY `fa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `tb_house`
--
ALTER TABLE `tb_house`
  MODIFY `house_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_profit`
--
ALTER TABLE `tb_profit`
  MODIFY `profit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tb_stock`
--
ALTER TABLE `tb_stock`
  MODIFY `stock_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_stock_balance`
--
ALTER TABLE `tb_stock_balance`
  MODIFY `sb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tb_stock_record`
--
ALTER TABLE `tb_stock_record`
  MODIFY `sr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `tb_weight`
--
ALTER TABLE `tb_weight`
  MODIFY `weight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_access`
--
ALTER TABLE `tb_access`
  ADD CONSTRAINT `access_company` FOREIGN KEY (`access_company_id`) REFERENCES `tb_company` (`company_id`),
  ADD CONSTRAINT `access_user` FOREIGN KEY (`access_user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_batch`
--
ALTER TABLE `tb_batch`
  ADD CONSTRAINT `project_cat` FOREIGN KEY (`batch_type`) REFERENCES `tb_category` (`category_id`),
  ADD CONSTRAINT `tb_batch_ibfk_1` FOREIGN KEY (`batch_company`) REFERENCES `tb_company` (`company_id`);

--
-- Constraints for table `tb_batch_house`
--
ALTER TABLE `tb_batch_house`
  ADD CONSTRAINT `tb_batch_house_ibfk_1` FOREIGN KEY (`bh_batch_uid`) REFERENCES `tb_batch` (`batch_uid`),
  ADD CONSTRAINT `tb_batch_house_ibfk_2` FOREIGN KEY (`bh_house_id`) REFERENCES `tb_house` (`house_id`);

--
-- Constraints for table `tb_bird`
--
ALTER TABLE `tb_bird`
  ADD CONSTRAINT `tb_bird_ibfk_1` FOREIGN KEY (`bird_house_id`) REFERENCES `tb_house` (`house_id`),
  ADD CONSTRAINT `tb_bird_ibfk_2` FOREIGN KEY (`bird_batch_uid`) REFERENCES `tb_batch` (`batch_uid`);

--
-- Constraints for table `tb_company`
--
ALTER TABLE `tb_company`
  ADD CONSTRAINT `company_cat` FOREIGN KEY (`company_cat`) REFERENCES `tb_category` (`category_id`);

--
-- Constraints for table `tb_cost`
--
ALTER TABLE `tb_cost`
  ADD CONSTRAINT `tb_cost_ibfk_1` FOREIGN KEY (`cost_category`) REFERENCES `tb_category` (`category_id`),
  ADD CONSTRAINT `tb_cost_ibfk_2` FOREIGN KEY (`cost_cycle_id`) REFERENCES `tb_cycle` (`cycle_id`);

--
-- Constraints for table `tb_cycle`
--
ALTER TABLE `tb_cycle`
  ADD CONSTRAINT `tb_cycle_ibfk_1` FOREIGN KEY (`cycle_farm_id`) REFERENCES `tb_farm` (`farm_id`),
  ADD CONSTRAINT `tb_cycle_ibfk_2` FOREIGN KEY (`cycle_status`) REFERENCES `tb_category` (`category_id`);

--
-- Constraints for table `tb_cycle_batch`
--
ALTER TABLE `tb_cycle_batch`
  ADD CONSTRAINT `tb_cycle_batch_ibfk_1` FOREIGN KEY (`cb_batch_uid`) REFERENCES `tb_batch` (`batch_uid`),
  ADD CONSTRAINT `tb_cycle_batch_ibfk_2` FOREIGN KEY (`cb_cycle_id`) REFERENCES `tb_cycle` (`cycle_id`);

--
-- Constraints for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD CONSTRAINT `tb_event_ibfk_1` FOREIGN KEY (`event_batch_uid`) REFERENCES `tb_batch` (`batch_uid`),
  ADD CONSTRAINT `tb_event_ibfk_2` FOREIGN KEY (`event_type`) REFERENCES `tb_category` (`category_id`);

--
-- Constraints for table `tb_farm`
--
ALTER TABLE `tb_farm`
  ADD CONSTRAINT `company_farm` FOREIGN KEY (`farm_company_id`) REFERENCES `tb_company` (`company_id`),
  ADD CONSTRAINT `tb_farm_ibfk_1` FOREIGN KEY (`farm_cat`) REFERENCES `tb_category` (`category_id`);

--
-- Constraints for table `tb_farm_access`
--
ALTER TABLE `tb_farm_access`
  ADD CONSTRAINT `tb_farm_access_ibfk_1` FOREIGN KEY (`fa_farm_id`) REFERENCES `tb_farm` (`farm_id`),
  ADD CONSTRAINT `tb_farm_access_ibfk_2` FOREIGN KEY (`fa_user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_house`
--
ALTER TABLE `tb_house`
  ADD CONSTRAINT `coop_cat` FOREIGN KEY (`house_cat`) REFERENCES `tb_category` (`category_id`),
  ADD CONSTRAINT `farm_coop` FOREIGN KEY (`house_farm_id`) REFERENCES `tb_farm` (`farm_id`);

--
-- Constraints for table `tb_profit`
--
ALTER TABLE `tb_profit`
  ADD CONSTRAINT `tb_profit_ibfk_1` FOREIGN KEY (`profit_bird_id`) REFERENCES `tb_bird` (`bird_id`);

--
-- Constraints for table `tb_stock`
--
ALTER TABLE `tb_stock`
  ADD CONSTRAINT `tb_stock_ibfk_1` FOREIGN KEY (`stock_farm_id`) REFERENCES `tb_farm` (`farm_id`);

--
-- Constraints for table `tb_stock_balance`
--
ALTER TABLE `tb_stock_balance`
  ADD CONSTRAINT `tb_stock_balance_ibfk_1` FOREIGN KEY (`sb_stock_id`) REFERENCES `tb_stock` (`stock_id`),
  ADD CONSTRAINT `tb_stock_balance_ibfk_2` FOREIGN KEY (`sb_item`) REFERENCES `tb_category` (`category_id`);

--
-- Constraints for table `tb_stock_record`
--
ALTER TABLE `tb_stock_record`
  ADD CONSTRAINT `tb_stock_record_ibfk_1` FOREIGN KEY (`sr_stock`) REFERENCES `tb_stock` (`stock_id`),
  ADD CONSTRAINT `tb_stock_record_ibfk_2` FOREIGN KEY (`sr_item`) REFERENCES `tb_category` (`category_id`),
  ADD CONSTRAINT `tb_stock_record_ibfk_3` FOREIGN KEY (`sr_record_type`) REFERENCES `tb_category` (`category_id`),
  ADD CONSTRAINT `tb_stock_record_ibfk_4` FOREIGN KEY (`sr_house_id`) REFERENCES `tb_house` (`house_id`),
  ADD CONSTRAINT `tb_stock_record_ibfk_5` FOREIGN KEY (`sr_batch_uid`) REFERENCES `tb_batch` (`batch_uid`);

--
-- Constraints for table `tb_weight`
--
ALTER TABLE `tb_weight`
  ADD CONSTRAINT `tb_weight_ibfk_1` FOREIGN KEY (`weight_bird_id`) REFERENCES `tb_bird` (`bird_id`);
--
-- Database: `phpmyadmin`
--
CREATE DATABASE IF NOT EXISTS `phpmyadmin` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `phpmyadmin`;

-- --------------------------------------------------------

--
-- Table structure for table `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int(11) NOT NULL,
  `dbase` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `query` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Table structure for table `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_length` text COLLATE utf8_bin,
  `col_collation` varchar(64) COLLATE utf8_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8_bin DEFAULT '',
  `col_default` text COLLATE utf8_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Table structure for table `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int(5) UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `settings_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Settings related to Designer';

--
-- Dumping data for table `pma__designer_settings`
--

INSERT INTO `pma__designer_settings` (`username`, `settings_data`) VALUES
('root', '{\"angular_direct\":\"direct\",\"snap_to_grid\":\"on\",\"relation_lines\":\"true\",\"pin_text\":\"false\",\"small_big_all\":\"v\",\"full_screen\":\"on\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `template_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Table structure for table `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Table structure for table `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Table structure for table `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `page_nr` int(10) UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `tables` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Recently accessed tables';

--
-- Dumping data for table `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"farvodb\",\"table\":\"tb_house\"},{\"db\":\"farvodb\",\"table\":\"tb_category\"},{\"db\":\"farvodb\",\"table\":\"tb_cost\"},{\"db\":\"farvodb\",\"table\":\"tb_batch\"},{\"db\":\"farvodb\",\"table\":\"tb_profit\"},{\"db\":\"farvodb\",\"table\":\"tb_stock_record\"},{\"db\":\"farvodb\",\"table\":\"tb_farm\"},{\"db\":\"farvodb\",\"table\":\"tb_cycle_batch\"},{\"db\":\"farvodb\",\"table\":\"tb_batch_house\"},{\"db\":\"farvodb\",\"table\":\"tb_event\"}]');

-- --------------------------------------------------------

--
-- Table structure for table `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Table structure for table `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int(5) UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `pdf_page_number` int(11) NOT NULL DEFAULT '0',
  `x` float UNSIGNED NOT NULL DEFAULT '0',
  `y` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `prefs` text COLLATE utf8_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Tables'' UI preferences';

--
-- Dumping data for table `pma__table_uiprefs`
--

INSERT INTO `pma__table_uiprefs` (`username`, `db_name`, `table_name`, `prefs`, `last_update`) VALUES
('root', 'farvodb', 'tb_access', '{\"sorted_col\":\"`access_id` ASC\"}', '2019-12-18 22:31:46'),
('root', 'farvodb', 'tb_batch', '{\"sorted_col\":\"`tb_batch`.`batch_uid` ASC\"}', '2019-12-30 09:05:25'),
('root', 'farvodb', 'tb_bird', '{\"sorted_col\":\"`bird_record_date`  DESC\",\"CREATE_TIME\":\"2019-12-12 18:13:27\",\"col_visib\":[\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\",\"1\"]}', '2019-12-18 20:12:52'),
('root', 'farvodb', 'tb_category', '{\"sorted_col\":\"`category_level`  DESC\"}', '2019-12-18 18:38:05'),
('root', 'farvodb', 'tb_company', '{\"sorted_col\":\"`company_cat`  DESC\"}', '2019-12-18 22:33:42'),
('root', 'farvodb', 'tb_event', '{\"sorted_col\":\"`event_id` DESC\"}', '2019-12-18 20:14:18'),
('root', 'farvodb', 'tb_stock_balance', '[]', '2019-12-07 12:12:26'),
('root', 'farvodb', 'tb_stock_record', '{\"sorted_col\":\"`sr_id` DESC\"}', '2019-12-18 20:16:31'),
('root', 'zettadb', 'tb_store_record', '{\"sorted_col\":\"`sr_id`  DESC\"}', '2019-12-10 00:40:11');

-- --------------------------------------------------------

--
-- Table structure for table `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `version` int(10) UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8_bin NOT NULL,
  `schema_sql` text COLLATE utf8_bin,
  `data_sql` longtext COLLATE utf8_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8_bin DEFAULT NULL,
  `tracking_active` int(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Table structure for table `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Dumping data for table `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2019-11-27 08:40:33', '{\"collation_connection\":\"utf8mb4_unicode_ci\"}');

-- --------------------------------------------------------

--
-- Table structure for table `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Table structure for table `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='Users and their assignments to user groups';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Indexes for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Indexes for table `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Indexes for table `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Indexes for table `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Indexes for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Indexes for table `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Indexes for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Indexes for table `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Indexes for table `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Indexes for table `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Indexes for table `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Indexes for table `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Indexes for table `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT;--
-- Database: `zettadb`
--
CREATE DATABASE IF NOT EXISTS `zettadb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `zettadb`;

-- --------------------------------------------------------

--
-- Table structure for table `tb_access`
--

CREATE TABLE `tb_access` (
  `access_id` int(11) NOT NULL,
  `access_user_id` int(11) NOT NULL,
  `access_level` int(11) NOT NULL,
  `access_company_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_access`
--

INSERT INTO `tb_access` (`access_id`, `access_user_id`, `access_level`, `access_company_id`) VALUES
(5, 1, 5, 0),
(101, 58, 4, 56),
(103, 60, 4, 57),
(106, 61, 1, 57),
(108, 62, 3, 57),
(109, 63, 4, 59),
(110, 61, 4, 60),
(111, 62, 2, 60),
(112, 64, 4, 61),
(113, 1, 4, 62),
(114, 58, 3, 62),
(115, 59, 4, 56);

-- --------------------------------------------------------

--
-- Table structure for table `tb_bird`
--

CREATE TABLE `tb_bird` (
  `bird_id` int(11) NOT NULL,
  `bird_death` int(11) NOT NULL,
  `bird_cull` int(11) NOT NULL,
  `bird_catch` int(11) NOT NULL,
  `bird_balance` int(11) NOT NULL,
  `bird_record_date` varchar(50) NOT NULL,
  `bird_coop_id` int(11) NOT NULL,
  `bird_project_uid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_bird`
--

INSERT INTO `tb_bird` (`bird_id`, `bird_death`, `bird_cull`, `bird_catch`, `bird_balance`, `bird_record_date`, `bird_coop_id`, `bird_project_uid`) VALUES
(240, 0, 0, 0, 1000, '2019-12-10', 40, '4911fc5c-b885-5993-aba9-d76c94516b87'),
(241, 0, 0, 0, 10000, '2019-12-10', 41, '7ee58199-2ad3-2efc-4428-140391f7b045'),
(242, 3, 2, 0, 9995, '2019-12-10', 41, '7ee58199-2ad3-2efc-4428-140391f7b045'),
(243, 0, 0, 0, 11, '2019-12-10', 44, 'e3075f83-5469-fbb1-c5da-41c28f67bdef'),
(244, 0, 0, 90, -79, '2019-12-10', 44, 'e3075f83-5469-fbb1-c5da-41c28f67bdef'),
(245, 0, 0, 0, -79, '2019-12-10', 44, 'e3075f83-5469-fbb1-c5da-41c28f67bdef'),
(246, 10000, 5000, 0, -25000, '2019-12-10', 44, 'e9350c78-ef83-788d-12d1-ad8f30971a4d'),
(247, 0, 0, 0, -79, '2019-12-10', 44, 'e3075f83-5469-fbb1-c5da-41c28f67bdef'),
(248, 0, 0, 0, 80000, '2019-12-10', 45, 'e9350c78-ef83-788d-12d1-ad8f30971a4d'),
(249, 0, 0, 0, 30000, '2019-12-10', 45, '153c0c8c-21ee-302b-4a82-8cf57aec953d'),
(250, 0, 0, 0, -79, '2019-12-10', 44, 'e3075f83-5469-fbb1-c5da-41c28f67bdef'),
(251, 0, 0, 0, 100000, '2019-12-10', 48, '4fe3dca0-0e15-41c7-1e4b-ab7f8428d5d7'),
(252, 0, 0, 0, 1000000, '2019-12-11', 50, '3ca15cdc-baeb-659c-c522-147d60714da4');

-- --------------------------------------------------------

--
-- Table structure for table `tb_category`
--

CREATE TABLE `tb_category` (
  `category_id` int(11) NOT NULL,
  `category_level` varchar(100) NOT NULL,
  `category_code` int(11) NOT NULL,
  `category_desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_category`
--

INSERT INTO `tb_category` (`category_id`, `category_level`, `category_code`, `category_desc`) VALUES
(0, 'SYSTEM', 0, 'SYSTEM'),
(1, 'company', 1, 'comp_cat_1'),
(2, 'company', 2, 'comp_cat_2'),
(3, 'farm', 1, 'farm_cat_1'),
(4, 'farm', 2, 'farm_cat_2'),
(5, 'coop', 1, 'coop_cat_1'),
(6, 'coop', 2, 'coop_cat_2'),
(7, 'coop_status', 1, 'active'),
(8, 'coop_status', 2, 'maintenance'),
(9, 'coop_status', 3, 'closed'),
(10, 'project', 1, 'project_type_1'),
(11, 'project', 2, 'project_type_2'),
(15, 'company', -1, 'Deactivated'),
(16, 'project_status', 1, 'scheduled'),
(17, 'project_status', 2, 'active'),
(18, 'project_status', 3, 'completed'),
(19, 'feed', 1, 'Grower'),
(20, 'feed', 2, 'Crumble'),
(21, 'feed', 3, 'Starter'),
(25, 'project_status', 4, 'initialized'),
(27, 'record_type', 1, 'restock'),
(28, 'record_type', 2, 'feeding'),
(29, 'event', 1, 'weight'),
(30, 'event', 2, 'notice'),
(31, 'feed', 1, 'try'),
(32, 'feed', 1, 'try'),
(33, 'feed', 1, 'try');

-- --------------------------------------------------------

--
-- Table structure for table `tb_company`
--

CREATE TABLE `tb_company` (
  `company_id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `company_address` varchar(100) NOT NULL,
  `company_ssm` varchar(100) NOT NULL,
  `company_joinDt` date NOT NULL,
  `company_cat` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_company`
--

INSERT INTO `tb_company` (`company_id`, `company_name`, `company_address`, `company_ssm`, `company_joinDt`, `company_cat`) VALUES
(0, 'SYSTEM', '-', '-', '2019-11-13', 0),
(53, 'Try', 'Skudai', '123', '2019-12-10', 1),
(56, 'Try', 'Skudai', '1', '2019-12-10', 2),
(57, 'lll', 'll', 'lkl', '2019-12-10', 15),
(58, 'hilmanhandsome', '1345', '321642136847', '2019-12-10', 15),
(59, 'AyamAyamMaya', 'Skudai', 'sm123', '2019-12-10', 1),
(60, 'AyamKu Sedap', 'disitu', '2014', '2019-12-10', 1),
(61, '1', '1', '1112', '2019-12-10', 1),
(62, 'qwe', 'qwqe', 'qwe', '2019-12-11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_coop`
--

CREATE TABLE `tb_coop` (
  `coop_id` int(11) NOT NULL,
  `coop_name` varchar(100) NOT NULL,
  `coop_capacity` int(11) NOT NULL,
  `coop_cat` int(11) NOT NULL,
  `coop_farm_id` int(11) NOT NULL,
  `coop_status` int(11) NOT NULL,
  `coop_vacant_capacity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_coop`
--

INSERT INTO `tb_coop` (`coop_id`, `coop_name`, `coop_capacity`, `coop_cat`, `coop_farm_id`, `coop_status`, `coop_vacant_capacity`) VALUES
(40, 'val c', 10000000, 5, 47, 7, 9999000),
(41, 'f1c1', 10000000, 5, 48, 7, 9990005),
(42, 'f2c1', 0, 5, 49, 7, 0),
(43, 'f2c1', 10000000, 5, 49, 7, 10000000),
(44, 'Coop UTM', 90000, 5, 51, 7, 90079),
(45, 'Coop 2', 100000, 5, 51, 7, 70000),
(46, 'Ayam Kampung', 5000, 5, 52, 7, 5000),
(47, 'f2c1', 10000000, 5, 48, 7, 10000000),
(48, '1', 1, 5, 54, 7, -99999),
(49, 'c1', 0, 5, 55, 7, 0),
(50, '1', 10000000, 5, 56, 7, 9000000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_event`
--

CREATE TABLE `tb_event` (
  `event_id` int(11) NOT NULL,
  `event_type` int(11) NOT NULL,
  `event_date` varchar(100) NOT NULL,
  `event_project_uid` varchar(255) NOT NULL,
  `event_state` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_event`
--

INSERT INTO `tb_event` (`event_id`, `event_type`, `event_date`, `event_project_uid`, `event_state`) VALUES
(1, 29, '2019-12-06', 'e3210219-9cda-dcc4-97fd-3686a7a12e64', 1),
(2, 29, '2019-12-05', 'e3210219-9cda-dcc4-97fd-3686a7a12e64', 1),
(3, 29, '2019-12-07', 'e3210219-9cda-dcc4-97fd-3686a7a12e64', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_farm`
--

CREATE TABLE `tb_farm` (
  `farm_id` int(11) NOT NULL,
  `farm_address` varchar(100) NOT NULL,
  `farm_joinDt` varchar(30) NOT NULL,
  `farm_company_id` int(11) NOT NULL,
  `farm_cat` int(11) NOT NULL,
  `farm_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_farm`
--

INSERT INTO `tb_farm` (`farm_id`, `farm_address`, `farm_joinDt`, `farm_company_id`, `farm_cat`, `farm_name`) VALUES
(47, 'hi', '2019-12-10 09:18:49', 53, 3, 'val1'),
(48, 'johor', '2019-12-10 09:25:08', 56, 3, 'f1'),
(49, 'skudai', '2019-12-10 09:25:23', 56, 3, 'f2'),
(50, 'johor', '2019-12-10 09:25:37', 56, 3, 'f3'),
(51, 'UTM', '2019-12-10 09:46:15', 57, 3, 'Farm UTM'),
(52, 'skudai', '2019-12-10 10:02:17', 59, 3, 'Ayam Serama'),
(53, '11', '2019-12-10 10:20:55', 60, 3, 'chickelicious'),
(54, '1', '2019-12-10 22:40:02', 61, 3, '1'),
(55, '1', '2019-12-11 00:04:59', 56, 3, 'f4'),
(56, 'q', '2019-12-11 00:05:58', 62, 3, 'q');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pc`
--

CREATE TABLE `tb_pc` (
  `pc_id` int(11) NOT NULL,
  `pc_coop_id` int(11) NOT NULL,
  `pc_project_uid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_pc`
--

INSERT INTO `tb_pc` (`pc_id`, `pc_coop_id`, `pc_project_uid`) VALUES
(1, 40, '4911fc5c-b885-5993-aba9-d76c94516b87'),
(2, 40, 'fc48a88d-70aa-8d2b-a8c6-717a45374ef7'),
(3, 41, '7ee58199-2ad3-2efc-4428-140391f7b045'),
(4, 44, 'e3075f83-5469-fbb1-c5da-41c28f67bdef'),
(5, 44, 'e9350c78-ef83-788d-12d1-ad8f30971a4d'),
(6, 45, '153c0c8c-21ee-302b-4a82-8cf57aec953d'),
(7, 43, 'd87823a8-462a-24b2-8e92-0527cdbd27a7'),
(8, 48, '4fe3dca0-0e15-41c7-1e4b-ab7f8428d5d7'),
(9, 50, '3ca15cdc-baeb-659c-c522-147d60714da4');

-- --------------------------------------------------------

--
-- Table structure for table `tb_project`
--

CREATE TABLE `tb_project` (
  `project_uid` varchar(255) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `project_type` int(11) NOT NULL,
  `project_company` int(11) NOT NULL,
  `project_date` varchar(100) NOT NULL,
  `project_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_project`
--

INSERT INTO `tb_project` (`project_uid`, `project_name`, `project_type`, `project_company`, `project_date`, `project_status`) VALUES
('153c0c8c-21ee-302b-4a82-8cf57aec953d', 'Project HAHA', 10, 57, '2019-12-10 09:59:36', 17),
('3ca15cdc-baeb-659c-c522-147d60714da4', '2', 11, 62, '2019-12-11 14:36:58', 25),
('4911fc5c-b885-5993-aba9-d76c94516b87', 'val_p1', 11, 53, '2019-12-10 09:19:40', 25),
('4fe3dca0-0e15-41c7-1e4b-ab7f8428d5d7', '1', 10, 61, '2019-12-10 23:00:25', 25),
('7ee58199-2ad3-2efc-4428-140391f7b045', 'f1p1', 10, 56, '2019-12-10 09:29:22', 17),
('d87823a8-462a-24b2-8e92-0527cdbd27a7', '1', 10, 56, '2019-12-10 21:58:21', 16),
('e3075f83-5469-fbb1-c5da-41c28f67bdef', 'Project UTM', 10, 57, '2019-12-10 09:50:29', 17),
('e9350c78-ef83-788d-12d1-ad8f30971a4d', 'Project 2', 10, 57, '2019-12-10 09:55:34', 25),
('fc48a88d-70aa-8d2b-a8c6-717a45374ef7', 'p_2', 10, 53, '2019-12-10 09:21:57', 16);

-- --------------------------------------------------------

--
-- Table structure for table `tb_store`
--

CREATE TABLE `tb_store` (
  `store_id` int(11) NOT NULL,
  `store_farm_id` int(11) NOT NULL,
  `store_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_store`
--

INSERT INTO `tb_store` (`store_id`, `store_farm_id`, `store_name`) VALUES
(27, 47, 'val_s1'),
(28, 48, 'f1s1'),
(29, 49, 'f2s1'),
(30, 51, 'Store UTM'),
(31, 52, 'Ayam Geprek'),
(32, 48, '12'),
(33, 54, '1'),
(34, 55, 's1'),
(35, 56, '12');

-- --------------------------------------------------------

--
-- Table structure for table `tb_store_balance`
--

CREATE TABLE `tb_store_balance` (
  `sb_id` int(11) NOT NULL,
  `sb_store_id` int(11) NOT NULL,
  `sb_item` int(11) NOT NULL,
  `sb_balance` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_store_balance`
--

INSERT INTO `tb_store_balance` (`sb_id`, `sb_store_id`, `sb_item`, `sb_balance`) VALUES
(61, 27, 19, 1),
(62, 28, 19, 0),
(63, 28, 20, 1),
(64, 28, 21, 2),
(65, 30, 20, 80040),
(66, 30, 19, 90800),
(67, 30, 21, 90000),
(68, 32, 19, 1),
(69, 33, 19, 1),
(70, 33, 20, 5),
(71, 34, 19, 10),
(72, 35, 19, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tb_store_record`
--

CREATE TABLE `tb_store_record` (
  `sr_id` int(11) NOT NULL,
  `sr_store` int(11) NOT NULL,
  `sr_item` int(11) NOT NULL,
  `sr_item_quantity` float NOT NULL,
  `sr_record_date` varchar(50) NOT NULL,
  `sr_record_type` int(11) NOT NULL,
  `sr_project_uid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_store_record`
--

INSERT INTO `tb_store_record` (`sr_id`, `sr_store`, `sr_item`, `sr_item_quantity`, `sr_record_date`, `sr_record_type`, `sr_project_uid`) VALUES
(200, 27, 19, 1, '2019-12-10', 27, ''),
(201, 28, 19, 1, '2019-12-10', 27, ''),
(202, 28, 20, 2, '2019-12-10', 27, ''),
(203, 28, 21, 3, '2019-12-10', 27, ''),
(204, 28, 19, 1, '2019-12-10', 28, '7ee58199-2ad3-2efc-4428-140391f7b045'),
(205, 28, 20, 1, '2019-12-10', 28, '7ee58199-2ad3-2efc-4428-140391f7b045'),
(206, 28, 21, 1, '2019-12-10', 28, '7ee58199-2ad3-2efc-4428-140391f7b045'),
(207, 30, 20, 40, '2019-12-10', 27, ''),
(208, 30, 19, 800, '2019-12-10', 27, ''),
(209, 30, 21, 90000, '2019-12-10', 27, ''),
(210, 30, 19, 90000, '2019-12-10', 27, ''),
(211, 30, 20, 80000, '2019-12-10', 27, ''),
(212, 32, 19, 1, '2019-12-10', 27, ''),
(213, 33, 19, 1, '2019-12-10', 27, ''),
(214, 33, 20, 5, '2019-12-10', 27, ''),
(215, 34, 19, 10, '2019-12-11', 27, ''),
(216, 35, 19, 10, '2019-12-11', 27, '');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_address` varchar(100) NOT NULL,
  `user_phone` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`user_id`, `user_email`, `user_address`, `user_phone`, `user_password`, `user_name`) VALUES
(1, 'systemadmin@gmail.com', '9, Lorong Galing 47\r\nJalan Galing 2', '0129210283', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'chan'),
(58, 'val@gmail.com', '1', '011', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'val'),
(59, 'ca@gmail.com', 'ca', '10926754632', '6959097001d10501ac7d54c0bdb8db61420f658f2922cc26e46d536119a31126', 'ca'),
(60, 'Kennard9989@hotmail.com', '246,hahaha', '0175915911', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Kenat'),
(61, 'linda@gmail.com', 'Kuching,Sarawak', '0125478963', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Linda Yunos'),
(62, 'batrisyiaomar98@gmail.com', 'UTM', '0111111111', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'Bet'),
(63, 'anakin515@gmail.com', 'UTM', '0123', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'HilmanHashim'),
(64, '1@gmail.com', '1', '1', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '1'),
(65, '', '', '', 'e3b0c44298fc1c149afbf4c8996fb92427ae41e4649b934ca495991b7852b855', ''),
(66, 'try1@gmail', 'Skudai', '0123456789', 'f92b6d44a00813066f1a8f4e5be21de8dd2675efc1d238516bce046236ceaa3c', 'Try1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_weight`
--

CREATE TABLE `tb_weight` (
  `weight_id` int(11) NOT NULL,
  `weight_bird_id` int(11) NOT NULL,
  `weight_data` double NOT NULL,
  `weight_event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_weight`
--

INSERT INTO `tb_weight` (`weight_id`, `weight_bird_id`, `weight_data`, `weight_event_id`) VALUES
(4, 215, 5, 2),
(5, 216, 10, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_access`
--
ALTER TABLE `tb_access`
  ADD PRIMARY KEY (`access_id`),
  ADD KEY `access_user_id` (`access_user_id`),
  ADD KEY `access_company_id` (`access_company_id`);

--
-- Indexes for table `tb_bird`
--
ALTER TABLE `tb_bird`
  ADD PRIMARY KEY (`bird_id`),
  ADD KEY `bird_coop_id` (`bird_coop_id`),
  ADD KEY `bird_project_uid` (`bird_project_uid`);

--
-- Indexes for table `tb_category`
--
ALTER TABLE `tb_category`
  ADD PRIMARY KEY (`category_id`,`category_level`);

--
-- Indexes for table `tb_company`
--
ALTER TABLE `tb_company`
  ADD PRIMARY KEY (`company_id`,`company_name`),
  ADD KEY `company_cat` (`company_cat`);

--
-- Indexes for table `tb_coop`
--
ALTER TABLE `tb_coop`
  ADD PRIMARY KEY (`coop_id`),
  ADD KEY `farm_coop` (`coop_farm_id`),
  ADD KEY `coop_cat` (`coop_cat`);

--
-- Indexes for table `tb_event`
--
ALTER TABLE `tb_event`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `event_type` (`event_type`),
  ADD KEY `event_project_uid` (`event_project_uid`(191));

--
-- Indexes for table `tb_farm`
--
ALTER TABLE `tb_farm`
  ADD PRIMARY KEY (`farm_id`),
  ADD KEY `company_farm` (`farm_company_id`);

--
-- Indexes for table `tb_pc`
--
ALTER TABLE `tb_pc`
  ADD PRIMARY KEY (`pc_id`),
  ADD KEY `pc_coop_id` (`pc_coop_id`),
  ADD KEY `pc_project_uid` (`pc_project_uid`);

--
-- Indexes for table `tb_project`
--
ALTER TABLE `tb_project`
  ADD PRIMARY KEY (`project_uid`),
  ADD KEY `project_type` (`project_type`),
  ADD KEY `project_status` (`project_status`);

--
-- Indexes for table `tb_store`
--
ALTER TABLE `tb_store`
  ADD PRIMARY KEY (`store_id`),
  ADD KEY `store_farm_id` (`store_farm_id`);

--
-- Indexes for table `tb_store_balance`
--
ALTER TABLE `tb_store_balance`
  ADD PRIMARY KEY (`sb_id`),
  ADD KEY `sb_store_id` (`sb_store_id`),
  ADD KEY `sb_item` (`sb_item`);

--
-- Indexes for table `tb_store_record`
--
ALTER TABLE `tb_store_record`
  ADD PRIMARY KEY (`sr_id`),
  ADD KEY `sr_store` (`sr_store`),
  ADD KEY `sr_item` (`sr_item`),
  ADD KEY `sr_type` (`sr_record_type`),
  ADD KEY `sr_project_uid` (`sr_project_uid`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tb_weight`
--
ALTER TABLE `tb_weight`
  ADD PRIMARY KEY (`weight_id`),
  ADD KEY `weight_bird_id` (`weight_bird_id`),
  ADD KEY `weight_event_id` (`weight_event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_access`
--
ALTER TABLE `tb_access`
  MODIFY `access_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;
--
-- AUTO_INCREMENT for table `tb_bird`
--
ALTER TABLE `tb_bird`
  MODIFY `bird_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=253;
--
-- AUTO_INCREMENT for table `tb_category`
--
ALTER TABLE `tb_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `tb_company`
--
ALTER TABLE `tb_company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `tb_coop`
--
ALTER TABLE `tb_coop`
  MODIFY `coop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `tb_event`
--
ALTER TABLE `tb_event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `tb_farm`
--
ALTER TABLE `tb_farm`
  MODIFY `farm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `tb_pc`
--
ALTER TABLE `tb_pc`
  MODIFY `pc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `tb_store`
--
ALTER TABLE `tb_store`
  MODIFY `store_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `tb_store_balance`
--
ALTER TABLE `tb_store_balance`
  MODIFY `sb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT for table `tb_store_record`
--
ALTER TABLE `tb_store_record`
  MODIFY `sr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=217;
--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `tb_weight`
--
ALTER TABLE `tb_weight`
  MODIFY `weight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_access`
--
ALTER TABLE `tb_access`
  ADD CONSTRAINT `access_company` FOREIGN KEY (`access_company_id`) REFERENCES `tb_company` (`company_id`),
  ADD CONSTRAINT `access_user` FOREIGN KEY (`access_user_id`) REFERENCES `tb_user` (`user_id`);

--
-- Constraints for table `tb_company`
--
ALTER TABLE `tb_company`
  ADD CONSTRAINT `company_cat` FOREIGN KEY (`company_cat`) REFERENCES `tb_category` (`category_id`);

--
-- Constraints for table `tb_coop`
--
ALTER TABLE `tb_coop`
  ADD CONSTRAINT `coop_cat` FOREIGN KEY (`coop_cat`) REFERENCES `tb_category` (`category_id`),
  ADD CONSTRAINT `farm_coop` FOREIGN KEY (`coop_farm_id`) REFERENCES `tb_farm` (`farm_id`);

--
-- Constraints for table `tb_farm`
--
ALTER TABLE `tb_farm`
  ADD CONSTRAINT `company_farm` FOREIGN KEY (`farm_company_id`) REFERENCES `tb_company` (`company_id`);

--
-- Constraints for table `tb_pc`
--
ALTER TABLE `tb_pc`
  ADD CONSTRAINT `pc_coop` FOREIGN KEY (`pc_coop_id`) REFERENCES `tb_coop` (`coop_id`),
  ADD CONSTRAINT `pc_project` FOREIGN KEY (`pc_project_uid`) REFERENCES `tb_project` (`project_uid`);

--
-- Constraints for table `tb_project`
--
ALTER TABLE `tb_project`
  ADD CONSTRAINT `project_cat` FOREIGN KEY (`project_type`) REFERENCES `tb_category` (`category_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

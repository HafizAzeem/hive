-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 15, 2020 at 08:28 AM
-- Server version: 5.7.18
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_mgmt_latest`
--

-- --------------------------------------------------------

--
-- Table structure for table `alert_templates`
--

DROP TABLE IF EXISTS `alert_templates`;
CREATE TABLE `alert_templates` (
  `id` int(11) NOT NULL,
  `template` longtext NOT NULL,
  `type` enum('sms','email') NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1-Checkin,2-Checkout,3-food bill',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alert_templates`
--

INSERT INTO `alert_templates` (`id`, `template`, `type`, `status`, `updated_at`, `created_at`) VALUES
(1, 'Hi ##NAME##,Welcome to Quickbuzz Paradise Hotel.For any kind of requirement or you wish to order food please contact below.Wish you a happy stay.', 'sms', 2, NULL, '2019-10-28 15:05:34'),
(2, 'Thanks for visiting Quickbuzz Paradise Hotel.We hope you like our services.We wish to serve you again,contact for room booking & restaurant services.', 'sms', 1, NULL, '2019-10-28 15:05:34'),
(3, 'Hi ##NAME##,Thanks for visiting Quickbuzz Paradise Hotel.We wish to serve you again,For room booking & food order or parties,contact-', 'sms', 3, NULL, '2019-10-28 15:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

DROP TABLE IF EXISTS `amenities`;
CREATE TABLE `amenities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `name`, `description`, `status`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, 'Double Bed\r\n', 'sssss', 1, 0, '2019-08-27 12:49:29', '2019-08-27 07:19:29'),
(2, 'Ac', NULL, 1, 0, '2019-08-27 12:50:14', '2019-08-27 07:20:14'),
(3, 'Free Newspaper', NULL, 1, 0, '2019-08-27 14:38:52', '2019-08-27 09:08:52'),
(4, 'Coffee Maker', NULL, 1, 0, '2019-08-27 14:39:00', '2019-08-27 09:09:00'),
(5, '50\" LED TV', NULL, 1, 0, '2019-08-27 14:39:08', '2019-08-27 09:09:08'),
(6, 'Free Wi-Fi', NULL, 1, 0, '2019-08-27 14:39:15', '2019-08-27 09:09:15'),
(7, 'Air Conditioner', NULL, 1, 0, '2019-08-27 14:39:24', '2019-08-27 09:09:24'),
(8, 'Breakfast Include', NULL, 1, 0, '2019-08-27 14:39:32', '2019-08-27 09:09:32'),
(9, '24h Butler Service', 'kjjljl', 1, 0, '2019-08-30 11:40:28', '2019-08-27 09:09:44'),
(10, 'B19', 'ss', 1, 0, '2019-08-29 04:03:12', '2019-08-28 22:33:12'),
(11, 'bheem', NULL, 1, 1, '2019-08-29 04:23:32', '2019-08-28 22:33:41');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `father_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `nationality` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zipcode` int(11) DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `is_deleted` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `amount` float(10,2) NOT NULL DEFAULT '0.00',
  `attachment` varchar(255) DEFAULT NULL,
  `remark` text,
  `datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `expense_categories`
--

DROP TABLE IF EXISTS `expense_categories`;
CREATE TABLE `expense_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `food_categories`
--

DROP TABLE IF EXISTS `food_categories`;
CREATE TABLE `food_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_categories`
--

INSERT INTO `food_categories` (`id`, `name`, `status`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, 'Everyday (green) foods', 1, 0, '2020-11-15 08:17:00', '2020-11-15 02:47:00'),
(2, 'Aamber foods', 1, 0, '2020-11-15 08:22:28', '2020-11-15 02:52:28'),
(3, 'Occasionally (red) foods.', 1, 0, '2020-11-15 08:22:36', '2020-11-15 02:52:36');

-- --------------------------------------------------------

--
-- Table structure for table `food_items`
--

DROP TABLE IF EXISTS `food_items`;
CREATE TABLE `food_items` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  `description` text,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `food_items`
--

INSERT INTO `food_items` (`id`, `category_id`, `name`, `price`, `description`, `status`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, 1, 'Breads and cereals', 80.00, NULL, 1, 0, '2020-11-15 08:23:32', '2020-11-15 02:53:32'),
(2, 1, 'Rice', 30.00, NULL, 1, 0, '2020-11-15 08:23:51', '2020-11-15 02:53:51'),
(3, 1, 'Pasta', 40.00, NULL, 1, 0, '2020-11-15 08:24:07', '2020-11-15 02:54:07'),
(4, 1, 'Noodles', 45.00, NULL, 1, 0, '2020-11-15 08:24:22', '2020-11-15 02:54:22'),
(5, 2, 'Milk', 5.00, NULL, 1, 0, '2020-11-15 08:24:53', '2020-11-15 02:54:53'),
(6, 2, 'Yoghurt and cheese', 20.00, NULL, 1, 0, '2020-11-15 08:25:10', '2020-11-15 02:55:10'),
(7, 2, 'Breakfast bars', 10.00, NULL, 1, 0, '2020-11-15 08:25:36', '2020-11-15 02:55:36'),
(8, 2, 'Cereal bars', 10.00, NULL, 1, 0, '2020-11-15 08:25:50', '2020-11-15 02:55:50'),
(9, 2, 'Fruit bars', 10.00, NULL, 1, 0, '2020-11-15 08:26:00', '2020-11-15 02:56:00'),
(10, 3, 'Crisps', 5.00, NULL, 1, 0, '2020-11-15 08:26:46', '2020-11-15 02:56:46'),
(11, 3, 'Chips', 5.00, NULL, 1, 0, '2020-11-15 08:27:04', '2020-11-15 02:57:04'),
(12, 3, 'Biscuits', 5.00, NULL, 1, 0, '2020-11-15 08:27:15', '2020-11-15 02:57:15');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `key` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `ar` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Arabic',
  `bn` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Bengali',
  `zh` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Chinese',
  `en` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'English',
  `fr` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'French',
  `de` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'German',
  `hi` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Hindi',
  `it` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Italian',
  `pt` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Portuguese',
  `rm` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Romansh',
  `ru` text CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT 'Russian',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `media_files`
--

DROP TABLE IF EXISTS `media_files`;
CREATE TABLE `media_files` (
  `id` int(11) NOT NULL,
  `tbl_id` int(11) NOT NULL,
  `type` enum('id_cards','expenses','') NOT NULL DEFAULT 'id_cards',
  `file` varchar(255) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `invoice_num` varchar(200) DEFAULT NULL,
  `table_num` varchar(10) DEFAULT NULL,
  `gst_apply` int(11) DEFAULT '0' COMMENT '1=Yes',
  `gst_perc` float(10,2) DEFAULT '0.00',
  `gst_amount` float(10,2) DEFAULT '0.00',
  `cgst_perc` float(10,2) DEFAULT '0.00',
  `cgst_amount` float(10,2) DEFAULT '0.00',
  `discount` float(10,2) DEFAULT '0.00',
  `total_amount` float(10,2) DEFAULT '0.00',
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `address` text,
  `mobile` varchar(15) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `payment_mode` int(11) DEFAULT NULL,
  `num_of_person` int(11) DEFAULT NULL,
  `waiter_name` varchar(255) DEFAULT NULL,
  `waiter_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `original_date` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_histories`
--

DROP TABLE IF EXISTS `order_histories`;
CREATE TABLE `order_histories` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `table_num` varchar(10) NOT NULL,
  `is_book` int(11) NOT NULL DEFAULT '1' COMMENT '1=Booked',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_history_id` int(11) DEFAULT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_price` float(10,2) NOT NULL,
  `item_qty` int(11) NOT NULL,
  `json_data` text,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1=Pending,2=Process,3=Delivered,4=Cancelled',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` text,
  `slug` varchar(255) NOT NULL,
  `super_admin` int(11) NOT NULL DEFAULT '1',
  `admin` int(11) NOT NULL DEFAULT '1',
  `receptionist` int(11) NOT NULL DEFAULT '1',
  `permission_type` enum('menu','route') NOT NULL DEFAULT 'route',
  `status` int(11) NOT NULL DEFAULT '1',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `parent_id`, `description`, `slug`, `super_admin`, `admin`, `receptionist`, `permission_type`, `status`, `updated_at`, `created_at`) VALUES
(1, NULL, 'Dashboard', 'dashboard', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:56:50'),
(2, NULL, 'Check In : Reservation', 'check-in', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:58:01'),
(3, 2, 'Add Check In', 'add-check-in', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(4, 2, 'List Check In', 'list-check-in', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(5, NULL, 'Users', 'users', 1, 0, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(6, 5, 'Users : Add', 'add-users', 1, 0, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(7, 5, 'Users : List', 'list-users', 1, 0, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(8, NULL, 'Food : Category', 'food-category', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(9, 8, 'Food : Category Add', 'add-food-category', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(10, 8, 'Food : Category List', 'list-food-category', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(11, NULL, 'Food : Item', 'food-item', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(12, 11, 'Food : Item Add', 'add-food-item', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(13, 11, 'Food : Item List', 'list-food-item', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(14, NULL, 'Stocks', 'stocks', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(15, 14, 'Stocks: Product Add', 'add-product', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(16, 14, 'Stock : Product List', 'list-product', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(17, 14, 'Stock : Add', 'add-stock', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(18, 14, 'Stock : History', 'history-stock', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(19, NULL, 'Room Types', 'room-type', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(20, 19, 'Room Type : Add', 'add-room-type', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(21, 19, 'Room Type : List', 'list-room-type', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(22, NULL, 'Rooms', 'rooms', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(23, 22, 'Rooms : Add', 'add-room', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(24, 22, 'Rooms : List', 'list-room', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(25, NULL, 'Amenities', 'amenities', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(26, 25, 'Amenities : Add', 'add-amenities', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(27, 25, 'Amenities : List', 'list-amenities', 1, 1, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(28, NULL, 'Dashboard', 'dashboard', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 13:07:07'),
(29, NULL, 'Profile', 'profile', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 13:07:07'),
(30, NULL, 'Save Profile', 'save-profile', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 13:07:07'),
(31, NULL, 'Add User', 'add-user', 1, 0, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:24:04'),
(32, NULL, 'Edit User', 'edit-user', 1, 0, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:24:42'),
(33, NULL, 'Save User', 'save-user', 1, 0, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:24:42'),
(34, NULL, 'List User', 'list-user', 1, 0, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:25:56'),
(35, NULL, 'Delete User', 'delete-user', 1, 0, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:25:56'),
(36, NULL, 'Add Room', 'add-room', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:25:56'),
(37, NULL, 'Edit Room', 'edit-room', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:25:56'),
(38, NULL, 'Save Room', 'save-room', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:26:41'),
(39, NULL, 'All Rooms', 'list-room', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:26:41'),
(40, NULL, 'Delete Room', 'delete-room', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:26:41'),
(41, NULL, 'Add Room Types', 'add-room-types', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:26:41'),
(42, NULL, 'Edit Room Types', 'edit-room-types', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:27:50'),
(43, NULL, 'Save Room Types', 'save-room-types', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:27:50'),
(44, NULL, 'List Room Types', 'list-room-types', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:27:50'),
(45, NULL, 'Delete Room Types', 'delete-room-types', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:27:50'),
(46, NULL, 'Add Amenities', 'add-amenities', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(47, NULL, 'Edit Amenities', 'edit-amenities', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(48, NULL, 'Save Amenities', 'save-amenities', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(49, NULL, 'List Amenities', 'list-amenities', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(50, NULL, 'Delete Amenities', 'delete-amenities', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(51, NULL, 'room-reservation', 'room-reservation', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(52, NULL, 'edit-reservation', 'edit-reservation', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(53, NULL, 'Save Reservation', 'save-reservation', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(54, NULL, 'check-out-room', 'check-out-room', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(55, NULL, 'check-out', 'check-out', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:29:41'),
(56, NULL, 'list-reservation', 'list-reservation', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(57, NULL, 'view-reservation', 'view-reservation', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(58, NULL, 'delete-reservation', 'delete-reservation', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(59, NULL, 'add-food-category', 'add-food-category', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(60, NULL, 'Save Food Category', 'save-food-category', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(61, NULL, 'list-food-category', 'list-food-category', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(62, NULL, 'delete-food-category', 'delete-food-category', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(63, NULL, 'add-food-item', 'add-food-item', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(64, NULL, 'edit-food-item', 'edit-food-item', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(65, NULL, 'Save Food Item', 'save-food-item', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:31:49'),
(66, NULL, 'list-food-item', 'list-food-item', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:32:43'),
(67, NULL, 'delete-food-item', 'delete-food-item', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:32:43'),
(68, NULL, 'food-order', 'food-order', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(69, NULL, 'Save Food Order', 'save-food-order', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(70, NULL, 'orders-list', 'orders-list', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(71, NULL, 'add-product', 'add-product', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(72, NULL, 'edit-product', 'edit-product', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(73, NULL, 'Save Product', 'save-product', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(74, NULL, 'list-product', 'list-product', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(75, NULL, 'delete-product', 'delete-product', 1, 1, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(76, NULL, 'io-stock', 'io-stock', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(77, NULL, 'Save Stock', 'save-stock', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(78, NULL, 'Stock History', 'stock-history', 1, 0, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 14:34:54'),
(79, NULL, 'invoice', 'invoice', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(80, NULL, 'Settings', 'settings', 1, 0, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(81, NULL, 'Settings', 'settings', 1, 0, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(82, NULL, 'Save Settings', 'save-settings', 1, 0, 0, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(83, NULL, 'List Checkouts', 'list-check-outs', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(84, NULL, 'List Checkouts', 'list-check-outs', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(85, NULL, 'order invoice', 'order-invoice', 1, 1, 1, 'route', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(86, NULL, 'order invoice final', 'order-invoice-final', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(87, NULL, 'food order final', 'food-order-final', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(88, NULL, 'food order table', 'food-order-table', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(89, NULL, 'kitchen invoice', 'kitchen-invoice', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(90, NULL, 'delete order item', 'delete-order-item', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(91, NULL, 'Search Orders', 'search-orders', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(92, NULL, 'export orders', 'export-orders', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(93, NULL, 'Search Stocks', 'search-stocks', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(94, NULL, 'export stocks', 'export-stocks', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(95, NULL, 'Search Checkins', 'search-checkins', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(96, NULL, 'export checkins', 'export-checkins', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(97, NULL, 'Search Checkouts', 'search-checkouts', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(98, NULL, 'export checkouts', 'export-checkouts', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(99, NULL, 'Delete Media File', 'delete-mediafile', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(100, NULL, 'Permissions', 'permissions', 1, 0, 0, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 11:59:02'),
(101, NULL, 'Update Permission', 'save-permissions', 1, 1, 0, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(102, NULL, 'List Permission', 'permissions-list', 1, 1, 0, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(103, NULL, 'Customers', 'customers', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(104, 103, 'Customers : Add', 'add-customers', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(105, 103, 'Customers : List', 'list-customers', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(106, NULL, 'Add Customer', 'add-customer', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(107, NULL, 'Edit Customer', 'edit-customer', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(108, NULL, 'Save Customer', 'save-customer', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(109, NULL, 'List Customer', 'list-customer', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(110, NULL, 'Delete Customer', 'delete-customer', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(111, NULL, 'Expense', 'expenses', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(112, 111, 'Expense : Add', 'add-expenses', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(113, 111, 'Expense : List', 'list-expenses', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(114, NULL, 'Add Expense', 'add-expense', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(115, NULL, 'Edit Expense', 'edit-expense', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(116, NULL, 'Save Expense', 'save-expense', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(117, NULL, 'List Expense', 'list-expense', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(118, NULL, 'Delete Expense', 'delete-expense', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(119, NULL, 'Expense Category', 'expense-categories', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(120, 119, 'Expense Category : Add', 'add-expense-category', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(121, 119, 'Expense Category : List', 'list-expense-category', 1, 1, 1, 'menu', 1, '2020-11-14 10:40:37', '2019-09-07 15:20:44'),
(122, NULL, 'Add Expense Category', 'add-expense-category', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(123, NULL, 'Edit Expense Category', 'edit-expense-category', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(124, NULL, 'Save Expense Category', 'save-expense-category', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(125, NULL, 'List Expense Category', 'list-expense-category', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(126, NULL, 'Delete Expense Category', 'delete-expense-category', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(127, NULL, 'Search Expense', 'search-expenses', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44'),
(128, NULL, 'Export Expense', 'export-expenses', 1, 1, 1, 'route', 1, '2020-11-14 10:40:38', '2019-09-07 15:20:44');

-- --------------------------------------------------------

--
-- Table structure for table `person_lists`
--

DROP TABLE IF EXISTS `person_lists`;
CREATE TABLE `person_lists` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `address` text,
  `idcard_type` int(11) DEFAULT NULL,
  `idcard_no` varchar(80) DEFAULT NULL,
  `reservation_id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `measurement` int(11) DEFAULT NULL,
  `stock_qty` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `invoice_num` varchar(255) DEFAULT NULL,
  `guest_type` enum('new','existing') DEFAULT NULL,
  `customer_id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `room_num` varchar(200) DEFAULT NULL,
  `room_qty` int(11) NOT NULL DEFAULT '1',
  `per_room_price` float(10,2) DEFAULT '0.00',
  `check_in` datetime NOT NULL,
  `check_out` datetime DEFAULT NULL,
  `duration_of_stay` int(11) DEFAULT '0',
  `adult` int(11) NOT NULL DEFAULT '0',
  `kids` int(11) DEFAULT '0',
  `booked_by` varchar(255) DEFAULT NULL,
  `referred_by` varchar(80) DEFAULT NULL,
  `referred_by_name` varchar(100) DEFAULT NULL,
  `checked_out_by` varchar(255) DEFAULT NULL,
  `vehicle_number` varchar(80) DEFAULT NULL,
  `advance_payment` float(10,2) DEFAULT '0.00',
  `gst_perc` float(10,2) DEFAULT '0.00',
  `cgst_perc` float(10,2) DEFAULT '0.00',
  `amount_json` text,
  `idcard_type` int(11) DEFAULT NULL,
  `idcard_no` varchar(255) DEFAULT NULL,
  `idcard_image` varchar(255) DEFAULT NULL,
  `booking_type` enum('Online','Offline') NOT NULL DEFAULT 'Offline',
  `payment_status` int(11) NOT NULL DEFAULT '0' COMMENT '0=Pending 1=Success',
  `payment_mode` int(11) DEFAULT NULL,
  `reason_visit_stay` text,
  `remark_amount` float(10,2) DEFAULT NULL,
  `remark` text,
  `company_gst_num` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `created_at_checkin` datetime DEFAULT NULL,
  `created_at_checkout` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `slug`, `updated_at`, `created_at`) VALUES
(1, 'Super Admin', 'super_admin', NULL, '2019-08-27 05:12:15'),
(2, 'Admin', 'admin', NULL, '2019-08-27 05:12:15'),
(3, 'Receptionist', 'receptionist', NULL, '2019-08-27 05:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_type_id` int(11) NOT NULL,
  `room_no` varchar(80) NOT NULL,
  `floor` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_type_id`, `room_no`, `floor`, `status`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, 1, '101', 1, 1, 0, '2019-08-30 10:48:31', '2019-08-30 05:18:31'),
(2, 1, '102', 1, 1, 0, '2019-08-30 10:48:31', '2019-08-30 05:18:31'),
(3, 2, '104', 1, 1, 0, '2019-08-30 10:48:31', '2019-08-30 05:18:31'),
(4, 2, '105', 1, 1, 0, '2019-08-30 10:48:31', '2019-08-30 05:18:31'),
(5, 2, '106', 1, 1, 0, '2019-08-30 10:48:31', '2019-08-30 05:18:31'),
(6, 2, '107', 1, 1, 0, '2019-08-30 10:48:31', '2019-08-30 05:18:31'),
(7, 1, '103', 1, 1, 0, '2019-08-30 10:48:31', '2019-08-30 05:18:31');

-- --------------------------------------------------------

--
-- Table structure for table `room_types`
--

DROP TABLE IF EXISTS `room_types`;
CREATE TABLE `room_types` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `short_code` varchar(10) NOT NULL,
  `adult_capacity` int(11) DEFAULT '0',
  `kids_capacity` int(11) NOT NULL DEFAULT '0',
  `base_price` float(10,2) DEFAULT '0.00',
  `amenities` varchar(255) DEFAULT NULL,
  `description` longtext,
  `status` int(11) NOT NULL DEFAULT '1',
  `is_deleted` int(11) NOT NULL DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `room_types`
--

INSERT INTO `room_types` (`id`, `title`, `short_code`, `adult_capacity`, `kids_capacity`, `base_price`, `amenities`, `description`, `status`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, 'Superior Queen Room', 'SQR', 2, 3, 700.00, '9,7,8,4,1,6', NULL, 1, 0, '2019-08-31 03:28:20', '2019-08-27 06:54:39'),
(2, 'Superior King Room', 'SKR', 2, 2, 550.00, '9,7,4,1,6', NULL, 1, 0, '2019-08-31 03:29:07', '2019-08-27 09:13:11'),
(3, 'Premium King Room', 'PKR', 2, 2, 1200.00, '2,7,8,4,1,3,6', NULL, 1, 0, '2019-08-31 03:29:43', '2019-08-30 21:59:43'),
(4, 'Superior Extra Queen Room', 'SEQR', 5, 2, 1500.00, '9,5,10,4,6', NULL, 1, 0, '2019-08-31 03:30:24', '2019-08-30 22:00:24');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `updated_at`, `created_at`) VALUES
(1, 'site_page_title', 'Quickbuzz Pardise', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(2, 'site_language', 'en', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(3, 'hotel_name', 'QUICKBUZZ PARADISE', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(4, 'hotel_tagline', 'HOTEL & RESTAURANT', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(5, 'hotel_email', 'contact@quickbuzz.in', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(6, 'hotel_phone', '0151-123456', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(7, 'hotel_mobile', '+91-1234567890,', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(8, 'hotel_website', 'www.google.com', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(9, 'hotel_address', 'Hno:449/a, Road No 20, Jubilee Hills', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(10, 'gst_num', '06CBHPS2421P1ZA', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(11, 'gst', '18.9', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(12, 'cgst', '4.75', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(13, 'food_gst', '5.42', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(14, 'food_cgst', '2.25', '2020-11-15 07:55:55', '2020-07-19 06:16:19'),
(15, 'currency', 'USD', '2020-11-15 07:55:55', '2020-11-10 00:41:22'),
(16, 'currency_symbol', '$', '2020-11-15 07:55:55', '2020-11-10 00:41:22'),
(17, 'sms_api_active', '0', '2020-11-15 07:55:55', '2020-11-15 02:25:55'),
(18, 'default_nationality', '81', '2020-11-15 07:55:55', '2020-11-15 02:25:55'),
(19, 'default_country', 'India', '2020-11-15 07:55:55', '2020-11-15 02:25:55'),
(20, 'invoice_term_condition', '<h1 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">Terms and Conditions</h1><h1 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">General Site Usage</h1><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">Last Revised: December 16, 2013</p><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">Welcome to www.lorem-ipsum.info. This site is provided as a service to our visitors and may be used for informational purposes only. Because the Terms and Conditions contain legal obligations, please read them carefully.</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">1. YOUR AGREEMENT</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">By using this Site, you agree to be bound by, and to comply with, these Terms and Conditions. If you do not agree to these Terms and Conditions, please do not use this site.</p><blockquote style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">PLEASE NOTE: We reserve the right, at our sole discretion, to change, modify or otherwise alter these Terms and Conditions at any time. Unless otherwise indicated, amendments will become effective immediately. Please review these Terms and Conditions periodically. Your continued use of the Site following the posting of changes and/or modifications will constitute your acceptance of the revised Terms and Conditions and the reasonableness of these standards for notice of changes. For your information, this page was last updated as of the date at the top of these terms and conditions.</blockquote><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">2. PRIVACY</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">Please review our Privacy Policy, which also governs your visit to this Site, to understand our practices.</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">3. LINKED SITES</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">This Site may contain links to other independent third-party Web sites (\"Linked Sites”). These Linked Sites are provided solely as a convenience to our visitors. Such Linked Sites are not under our control, and we are not responsible for and does not endorse the content of such Linked Sites, including any information or materials contained on such Linked Sites. You will need to make your own independent judgment regarding your interaction with these Linked Sites.</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">4. FORWARD LOOKING STATEMENTS</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">All materials reproduced on this site speak as of the original date of publication or filing. The fact that a document is available on this site does not mean that the information contained in such document has not been modified or superseded by events or by a subsequent document or filing. We have no duty or policy to update any information or statements contained on this site and, therefore, such information or statements should not be relied upon as being current as of the date you access this site.</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">5. DISCLAIMER OF WARRANTIES AND LIMITATION OF LIABILITY</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">A. THIS SITE MAY CONTAIN INACCURACIES AND TYPOGRAPHICAL ERRORS. WE DOES NOT WARRANT THE ACCURACY OR COMPLETENESS OF THE MATERIALS OR THE RELIABILITY OF ANY ADVICE, OPINION, STATEMENT OR OTHER INFORMATION DISPLAYED OR DISTRIBUTED THROUGH THE SITE. YOU EXPRESSLY UNDERSTAND AND AGREE THAT: (i) YOUR USE OF THE SITE, INCLUDING ANY RELIANCE ON ANY SUCH OPINION, ADVICE, STATEMENT, MEMORANDUM, OR INFORMATION CONTAINED HEREIN, SHALL BE AT YOUR SOLE RISK; (ii) THE SITE IS PROVIDED ON AN \"AS IS\" AND \"AS AVAILABLE\" BASIS; (iii) EXCEPT AS EXPRESSLY PROVIDED HEREIN WE DISCLAIM ALL WARRANTIES OF ANY KIND, WHETHER EXPRESS OR IMPLIED, INCLUDING, BUT NOT LIMITED TO IMPLIED WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, WORKMANLIKE EFFORT, TITLE AND NON-INFRINGEMENT; (iv) WE MAKE NO WARRANTY WITH RESPECT TO THE RESULTS THAT MAY BE OBTAINED FROM THIS SITE, THE PRODUCTS OR SERVICES ADVERTISED OR OFFERED OR MERCHANTS INVOLVED; (v) ANY MATERIAL DOWNLOADED OR OTHERWISE OBTAINED THROUGH THE USE OF THE SITE IS DONE AT YOUR OWN DISCRETION AND RISK; and (vi) YOU WILL BE SOLELY RESPONSIBLE FOR ANY DAMAGE TO YOUR COMPUTER SYSTEM OR FOR ANY LOSS OF DATA THAT RESULTS FROM THE DOWNLOAD OF ANY SUCH MATERIAL.</p><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">B. YOU UNDERSTAND AND AGREE THAT UNDER NO CIRCUMSTANCES, INCLUDING, BUT NOT LIMITED TO, NEGLIGENCE, SHALL WE BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, PUNITIVE OR CONSEQUENTIAL DAMAGES THAT RESULT FROM THE USE OF, OR THE INABILITY TO USE, ANY OF OUR SITES OR MATERIALS OR FUNCTIONS ON ANY SUCH SITE, EVEN IF WE HAVE BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. THE FOREGOING LIMITATIONS SHALL APPLY NOTWITHSTANDING ANY FAILURE OF ESSENTIAL PURPOSE OF ANY LIMITED REMEDY.</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">6. EXCLUSIONS AND LIMITATIONS</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF CERTAIN WARRANTIES OR THE LIMITATION OR EXCLUSION OF LIABILITY FOR INCIDENTAL OR CONSEQUENTIAL DAMAGES. ACCORDINGLY, OUR LIABILITY IN SUCH JURISDICTION SHALL BE LIMITED TO THE MAXIMUM EXTENT PERMITTED BY LAW.</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">7. OUR PROPRIETARY RIGHTS</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">This Site and all its Contents are intended solely for personal, non-commercial use. Except as expressly provided, nothing within the Site shall be construed as conferring any license under our or any third party\'s intellectual property rights, whether by estoppel, implication, waiver, or otherwise. Without limiting the generality of the foregoing, you acknowledge and agree that all content available through and used to operate the Site and its services is protected by copyright, trademark, patent, or other proprietary rights. You agree not to: (a) modify, alter, or deface any of the trademarks, service marks, trade dress (collectively \"Trademarks\") or other intellectual property made available by us in connection with the Site; (b) hold yourself out as in any way sponsored by, affiliated with, or endorsed by us, or any of our affiliates or service providers; (c) use any of the Trademarks or other content accessible through the Site for any purpose other than the purpose for which we have made it available to you; (d) defame or disparage us, our Trademarks, or any aspect of the Site; and (e) adapt, translate, modify, decompile, disassemble, or reverse engineer the Site or any software or programs used in connection with it or its products and services.</p><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">The framing, mirroring, scraping or data mining of the Site or any of its content in any form and by any method is expressly prohibited.</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">8. INDEMNITY</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">By using the Site web sites you agree to indemnify us and affiliated entities (collectively \"Indemnities\") and hold them harmless from any and all claims and expenses, including (without limitation) attorney\'s fees, arising from your use of the Site web sites, your use of the Products and Services, or your submission of ideas and/or related materials to us or from any person\'s use of any ID, membership or password you maintain with any portion of the Site, regardless of whether such use is authorized by you.</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">9. COPYRIGHT AND TRADEMARK NOTICE</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">Except our generated dummy copy, which is free to use for private and commercial use, all other text is copyrighted. generator.lorem-ipsum.info © 2013, all rights reserved</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">10. INTELLECTUAL PROPERTY INFRINGEMENT CLAIMS</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">It is our policy to respond expeditiously to claims of intellectual property infringement. We will promptly process and investigate notices of alleged infringement and will take appropriate actions under the Digital Millennium Copyright Act (\"DMCA\") and other applicable intellectual property laws. Notices of claimed infringement should be directed to:</p><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">generator.lorem-ipsum.info</p><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">126 Electricov St.</p><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">Kiev, Kiev 04176</p><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">Ukraine</p><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">contact@lorem-ipsum.info</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">11. PLACE OF PERFORMANCE</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">This Site is controlled, operated and administered by us from our office in Kiev, Ukraine. We make no representation that materials at this site are appropriate or available for use at other locations outside of the Ukraine and access to them from territories where their contents are illegal is prohibited. If you access this Site from a location outside of the Ukraine, you are responsible for compliance with all local laws.</p><h2 style=\"font-size: 13px; color: rgb(0, 0, 0); font-family: &quot;Times New Roman&quot;; font-weight: bold !important;\">12. GENERAL</h2><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">A. If any provision of these Terms and Conditions is held to be invalid or unenforceable, the provision shall be removed (or interpreted, if possible, in a manner as to be enforceable), and the remaining provisions shall be enforced. Headings are for reference purposes only and in no way define, limit, construe or describe the scope or extent of such section. Our failure to act with respect to a breach by you or others does not waive our right to act with respect to subsequent or similar breaches. These Terms and Conditions set forth the entire understanding and agreement between us with respect to the subject matter contained herein and supersede any other agreement, proposals and communications, written or oral, between our representatives and you with respect to the subject matter hereof, including any terms and conditions on any of customer\'s documents or purchase orders.</p><p style=\"font-family: &quot;Times New Roman&quot;; font-size: medium;\">B. No Joint Venture, No Derogation of Rights. You agree that no joint venture, partnership, employment, or agency relationship exists between you and us as a result of these Terms and Conditions or your use of the Site. Our performance of these Terms and Conditions is subject to existing laws and legal process, and nothing contained herein is in derogation of our right to comply with governmental, court and law enforcement requests or requirements relating to your use of the Site or information provided to or gathered by us with respect to such use.</p>', '2020-11-15 07:55:55', '2020-11-15 02:25:55'),
(21, 'files', NULL, '2020-11-15 07:55:55', '2020-11-15 02:25:55');

-- --------------------------------------------------------

--
-- Table structure for table `stock_history`
--

DROP TABLE IF EXISTS `stock_history`;
CREATE TABLE `stock_history` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` float(10,2) DEFAULT NULL,
  `stock_is` enum('add','subtract') DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
CREATE TABLE `units` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_deleted` int(11) NOT NULL DEFAULT '0' COMMENT '1=Deleted',
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `is_deleted`, `updated_at`, `created_at`) VALUES
(1, 'Gm', 0, NULL, '2019-11-26 17:23:48'),
(2, 'Kg', 0, NULL, '2019-11-26 17:23:48'),
(3, 'Item', 0, NULL, '2019-11-26 17:24:03'),
(4, 'Piece', 0, NULL, '2019-11-26 17:24:03'),
(5, 'Set', 0, NULL, '2019-11-26 17:24:23'),
(6, 'Bottles', 0, NULL, '2019-11-26 17:24:23'),
(7, 'Cartoons', 0, NULL, '2019-11-26 17:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role_id`, `name`, `gender`, `email`, `email_verified_at`, `password`, `mobile`, `address`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Super Admin', 'Male', 'quickbuzzin@gmail.com', NULL, '$2y$10$J5YAgGZsHmh0U8O9EU0C4OgHFPlAW0fOZ4g5QCSjAEuPsdfcXFsIG', '9001456808', NULL, 1, NULL, NULL, '2019-09-07 04:36:21'),
(2, 2, 'Admin', 'Male', 'admin@gmail.com', NULL, '$2y$10$yb8Bsf15kZfPgyR.NpFAy.Dr.6nBh99lLcCjBINooWEdu9.2boQYC', '9001456808', 'H.No.439 Rani Bazar', 1, NULL, '2019-09-07 03:53:13', '2019-09-07 09:41:18'),
(3, 3, 'Receptionist', 'Male', 'receptionist@gmail.com', NULL, '$2y$10$aXVzok8TKexA6AsuaEiLVejLpuF5S1.cliCDXLSsHoXwWol18O55i', '1234567890', 'HNo 56', 1, NULL, '2019-09-07 09:42:29', '2019-09-07 09:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

DROP TABLE IF EXISTS `user_logs`;
CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(255) DEFAULT NULL,
  `action_as` varchar(255) DEFAULT NULL,
  `controller` varchar(255) DEFAULT NULL,
  `method` varchar(255) DEFAULT NULL,
  `counts` int(11) NOT NULL DEFAULT '1',
  `json_data` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `log_type` varchar(200) DEFAULT NULL,
  `log_date` date DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `user_id`, `title`, `uri`, `action_as`, `controller`, `method`, `counts`, `json_data`, `log_type`, `log_date`, `updated_at`, `created_at`) VALUES
(1, 1, NULL, 'admin/save-food-category', 'save-food-category', 'App\\Http\\Controllers\\AdminController@saveFoodCategory', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"name\":\"Aamber foods\",\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:22:28', '2020-11-15 02:52:28'),
(2, 1, NULL, 'admin/add-food-category', 'add-food-category', 'App\\Http\\Controllers\\AdminController@addFoodCategory', 'GET', 2, NULL, NULL, '2020-11-15', '2020-11-15 08:22:36', '2020-11-15 02:52:28'),
(3, 1, NULL, 'admin/save-food-category', 'save-food-category', 'App\\Http\\Controllers\\AdminController@saveFoodCategory', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"name\":\"Occasionally (red) foods.\",\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:22:36', '2020-11-15 02:52:36'),
(4, 1, NULL, 'admin/add-food-item', 'add-food-item', 'App\\Http\\Controllers\\AdminController@addFoodItem', 'GET', 13, NULL, NULL, '2020-11-15', '2020-11-15 08:27:16', '2020-11-15 02:52:39'),
(5, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"1\",\"name\":\"Breads and cereals\",\"price\":\"80\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:23:32', '2020-11-15 02:53:32'),
(6, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"1\",\"name\":\"Rice\",\"price\":\"30\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:23:51', '2020-11-15 02:53:51'),
(7, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"1\",\"name\":\"Pasta\",\"price\":\"40\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:24:07', '2020-11-15 02:54:07'),
(8, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"1\",\"name\":\"Noodles\",\"price\":\"45\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:24:22', '2020-11-15 02:54:22'),
(9, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"2\",\"name\":\"Milk\",\"price\":\"5\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:24:53', '2020-11-15 02:54:53'),
(10, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"2\",\"name\":\"Yoghurt and cheese\",\"price\":\"20\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:25:10', '2020-11-15 02:55:10'),
(11, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"2\",\"name\":\"Breakfast bars\",\"price\":\"10\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:25:36', '2020-11-15 02:55:36'),
(12, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"2\",\"name\":\"Cereal bars\",\"price\":\"10\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:25:50', '2020-11-15 02:55:50'),
(13, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"2\",\"name\":\"Fruit bars\",\"price\":\"10\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:26:00', '2020-11-15 02:56:00'),
(14, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"3\",\"name\":\"Crisps\",\"price\":\"5\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:26:46', '2020-11-15 02:56:46'),
(15, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"3\",\"name\":\"Chips\",\"price\":\"5\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:27:04', '2020-11-15 02:57:04'),
(16, 1, NULL, 'admin/save-food-item', 'save-food-item', 'App\\Http\\Controllers\\AdminController@saveFoodItem', 'POST', 1, '{\"_token\":\"tDh4QEt3xhDKxskO01aRP4cse112VFVfg96D09Oe\",\"category_id\":\"3\",\"name\":\"Biscuits\",\"price\":\"5\",\"description\":null,\"status\":\"1\"}', NULL, '2020-11-15', '2020-11-15 08:27:15', '2020-11-15 02:57:15'),
(17, 1, NULL, 'admin/list-food-category', 'list-food-category', 'App\\Http\\Controllers\\AdminController@listFoodCategory', 'GET', 1, NULL, NULL, '2020-11-15', '2020-11-15 08:27:18', '2020-11-15 02:57:18'),
(18, 1, NULL, 'admin/list-food-item', 'list-food-item', 'App\\Http\\Controllers\\AdminController@listFoodItem', 'GET', 1, NULL, NULL, '2020-11-15', '2020-11-15 08:27:22', '2020-11-15 02:57:22'),
(19, 1, NULL, 'admin/dashboard', 'dashboard', 'App\\Http\\Controllers\\AdminController@index', 'GET', 1, NULL, NULL, '2020-11-15', '2020-11-15 08:27:30', '2020-11-15 02:57:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alert_templates`
--
ALTER TABLE `alert_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_categories`
--
ALTER TABLE `food_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_items`
--
ALTER TABLE `food_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_files`
--
ALTER TABLE `media_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_histories`
--
ALTER TABLE `order_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person_lists`
--
ALTER TABLE `person_lists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_types`
--
ALTER TABLE `room_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_history`
--
ALTER TABLE `stock_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_categories`
--
ALTER TABLE `food_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `food_items`
--
ALTER TABLE `food_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_files`
--
ALTER TABLE `media_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_histories`
--
ALTER TABLE `order_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `person_lists`
--
ALTER TABLE `person_lists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `room_types`
--
ALTER TABLE `room_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `stock_history`
--
ALTER TABLE `stock_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

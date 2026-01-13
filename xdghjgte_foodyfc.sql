-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 30, 2025 at 04:30 AM
-- Server version: 8.0.43-34
-- PHP Version: 8.3.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xdghjgte_foodyfc`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password_show` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `gender` varchar(11) NOT NULL,
  `active` tinyint UNSIGNED DEFAULT NULL,
  `group_id` varchar(100) NOT NULL DEFAULT '5',
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL DEFAULT '',
  `country_code` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL DEFAULT '',
  `logo` varchar(255) NOT NULL,
  `social` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT '',
  `newsletter` tinyint NOT NULL COMMENT '1 mean subscribtion for newsletter 0 means else',
  `source` varchar(11) NOT NULL,
  `token` longtext NOT NULL,
  `fcm_no` varchar(255) NOT NULL,
  `created_on` varchar(255) NOT NULL,
  `type` varchar(11) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `ip_address` varchar(15) NOT NULL,
  `forgotten_password_time` int UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `last_login` varchar(255) NOT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `razorpay_customer_id` varchar(255) NOT NULL,
  `wallet_amount` varchar(25) NOT NULL,
  `wallet_amt_reason` varchar(255) NOT NULL,
  `latitude` varchar(25) NOT NULL,
  `longitude` varchar(25) NOT NULL,
  `otp` int NOT NULL,
  `otp_count` int NOT NULL,
  `otp_date_time` varchar(50) NOT NULL,
  `is_verified` varchar(11) NOT NULL DEFAULT 'no',
  `image` varchar(255) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `date_of_birth` varchar(255) NOT NULL,
  `seller_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password_show`, `password`, `email`, `address`, `gender`, `active`, `group_id`, `first_name`, `last_name`, `country_code`, `phone`, `logo`, `social`, `newsletter`, `source`, `token`, `fcm_no`, `created_on`, `type`, `activation_code`, `ip_address`, `forgotten_password_time`, `remember_code`, `last_login`, `forgotten_password_code`, `razorpay_customer_id`, `wallet_amount`, `wallet_amt_reason`, `latitude`, `longitude`, `otp`, `otp_count`, `otp_date_time`, `is_verified`, `image`, `category_id`, `date_of_birth`, `seller_id`) VALUES
(1, 'webmaster', '123123', '$2y$10$jYYc0vyuRGWQWCC0bMTvletCshKESGUJHRxbq6sGTveE6kzMunq2K', 'webmaster', '7205 heart land', '', 1, '1', 'Persausive', '', '', '512 608 85', '9614.jpg', '', 0, 'web', '', '', '2019', 'admin', NULL, '', NULL, 'sqGVf8KgJg155gmjJsAtXu', '', NULL, '', '', '', '', '', 0, 0, '', 'no', '', '', '', 0),
(2, 'girish@persausive.com', '123456', '$2y$10$LTrwfqk8uDvdFyBqBY.DFuu5ZAeEXe57rhZqIIvzEHwn4CIJf3L8y', 'girish@persausive.com', '', '', 1, '5', 'Girish Bhumkar', '', '', '8149169115', '', 'normal', 0, 'android', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJDSSBCb290c3RyYXAgMyIsImlhdCI6MTcyNTExMTkzOCwianRpIjoiNjk5Njk0Mzc1IiwicGFzc3dvcmQiOiIxMjM0NTYiLCJpZCI6IjI4In0.T9TiredprVSYXQSCupkyWp5ztbMFkzljlaRLktxBJaE', 'f3QxtvERQUe8PNWLUnwgH6:APA91bHWhr37f2kBnS8dGmScLuX41WWqQ6L7CJs99jWRCSgT_iJpOpb4tcQQw7FZzZZOtRRI4H7QmUqHjswJW5_yNagks04oJ4xPXAQIWcrTb-6Q-xzpNGw7uZY6vy0LJJBjIiSeiRbv', '2024/07/23 10:15:47', 'user', NULL, '', NULL, NULL, '2024-08-24 05:55:53', NULL, '', '', '', '19.0645', '74.7089', 0, 0, '', 'yes', '', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `attribute`
--

CREATE TABLE `attribute` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `item_priority` varchar(255) NOT NULL,
  `display_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attribute`
--

INSERT INTO `attribute` (`id`, `name`, `item_priority`, `display_type`) VALUES
(19, 'Color', '1', 'color'),
(20, 'Size', '2', 'dropdown');

-- --------------------------------------------------------

--
-- Table structure for table `attribute_item`
--

CREATE TABLE `attribute_item` (
  `id` int NOT NULL,
  `a_id` int NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `i_priority` varchar(255) NOT NULL,
  `item_value` varchar(255) NOT NULL,
  `status` int NOT NULL DEFAULT '1',
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attribute_item`
--

INSERT INTO `attribute_item` (`id`, `a_id`, `item_name`, `i_priority`, `item_value`, `status`, `created_date`) VALUES
(1, 20, 'Medium ', '1', 'Medium ', 0, ''),
(2, 20, 'Large ', '1', 'Large ', 0, ''),
(3, 20, '1 Kg', '1', '1 Kg', 1, ''),
(4, 20, '250 Gm', '1', '250 Gm', 1, ''),
(5, 20, '500 Gm', '1', '500 Gm', 1, ''),
(6, 20, '2 Kg', '1', '2 Kg', 1, ''),
(7, 20, '1/2 kg', '1', '1/2 kg', 1, ''),
(8, 20, '800 gm', '1', '800 gm', 1, ''),
(9, 20, 'one piece', '1', 'one piece', 1, ''),
(10, 20, '24 pieces', '1', '24 pieces', 1, ''),
(11, 20, '48 pieces', '1', '48 pieces', 1, ''),
(12, 20, '6 pieces', '1', '6 pieces', 1, ''),
(13, 20, '486 gm', '1', '486 gm', 1, ''),
(14, 20, '44 pieces', '1', '44 pieces', 1, ''),
(15, 20, '21 pieces', '1', '21 pieces', 1, ''),
(16, 20, '5 kg', '1', '5 kg', 1, ''),
(17, 20, '70 pieces', '1', '70 pieces', 1, ''),
(18, 20, '900 gm', '1', '900 gm', 1, ''),
(19, 20, '10 pieces', '1', '10 pieces', 1, ''),
(20, 20, '4 kg', '1', '4 kg', 1, ''),
(21, 20, '350 ml', '1', '350 ml', 1, ''),
(22, 20, '1500 gm', '1', '1500 gm', 1, ''),
(23, 20, '12 pieces', '1', '12 pieces', 1, ''),
(24, 20, '4 pieces', '1', '4 pieces', 1, ''),
(25, 20, '450 gm', '1', '450 gm', 1, ''),
(26, 20, '400 gm', '1', '400 gm', 1, ''),
(27, 20, 'large', '1', 'large', 1, ''),
(28, 20, '2500 gm', '1', '2500 gm', 1, ''),
(29, 20, '10 pieces', '1', '10 pieces', 1, ''),
(30, 20, '400 ml', '1', '400 ml', 1, ''),
(31, 20, '1 Litre', '1', '1 Litre', 1, ''),
(32, 20, '260', '1', '260', 1, ''),
(33, 20, '200 ml', '1', '200 ml', 1, ''),
(34, 20, '500 ml', '1', '500 ml', 1, ''),
(35, 20, '8 Pieces', '1', '8 Pieces', 1, ''),
(36, 20, '16 Pieces', '1', '16 Pieces', 1, ''),
(37, 20, '24 Pieces', '1', '24 Pieces', 1, ''),
(38, 20, '32 Pieces', '1', '32 Pieces', 1, ''),
(39, 20, '77777', '1', '77777', 0, ''),
(40, 20, '500 gm', '1', '500 gm', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `banner`
--

CREATE TABLE `banner` (
  `id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `category` varchar(10) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'active',
  `language` varchar(25) NOT NULL,
  `created_date` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banner`
--

INSERT INTO `banner` (`id`, `image`, `type`, `category`, `status`, `language`, `created_date`) VALUES
(9, '6489.png', 'application', '15', 'active', 'en', '2024/02/20 19:23:35'),
(10, '5626.png', 'application', '15', 'active', 'en', '2024/02/20 19:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `building_list`
--

CREATE TABLE `building_list` (
  `id` int NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `status` varchar(25) NOT NULL DEFAULT 'active',
  `created_date` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `building_name`
--

CREATE TABLE `building_name` (
  `id` int NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `building_wise`
--

CREATE TABLE `building_wise` (
  `id` int NOT NULL,
  `product_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `size` varchar(255) NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `wing_name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `size_add` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `display_name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `short_description` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `banner_image` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `parent` int NOT NULL DEFAULT '0',
  `has_product` int NOT NULL,
  `display_name_ar` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `display_name_ku` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `display_name`, `short_description`, `image`, `banner_image`, `status`, `parent`, `has_product`, `display_name_ar`, `display_name_ku`) VALUES
(42, 'Hellmann\'s', '', '', '', 'active', 0, 1, '', ''),
(43, 'knorr', '', '', '', 'active', 0, 0, '', ''),
(44, 'buzdagi', '', '', '', 'active', 0, 1, '', ''),
(45, 'vibi', '', '', '', 'active', 0, 1, '', ''),
(31, 'mayza products', '', '', '', 'active', 0, 1, '', ''),
(32, 'dixie mills Sauce', '', '', '', 'active', 0, 0, '', ''),
(33, 'melis', '', '', '', 'active', 0, 0, '', ''),
(34, 'vibi pizza', '', '', '', 'active', 0, 0, '', ''),
(35, 'puck ', '', '', '', 'active', 0, 0, '', ''),
(36, 'arla', '', '', '', 'active', 0, 1, '', ''),
(37, 'Lurpak', '', '', '', 'active', 0, 0, '', ''),
(38, 'mccain ', '', '', '', 'active', 0, 1, '', ''),
(39, 'Martin’s potato rolls and bread', '', '1011.jpg', '', 'active', 0, 1, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_page`
--

CREATE TABLE `contact_page` (
  `id` int NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title_arebic` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_page`
--

INSERT INTO `contact_page` (`id`, `phone`, `email`, `title`, `title_arebic`) VALUES
(1, '00962792509333', 'info@flexmotion.com', 'Looking for help? Fill the form and start a new adventure.', 'تبحث عن مساعدة؟ املأ النموذج وابدأ مغامرة جديدة.');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` varchar(25) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cron_notification`
--

CREATE TABLE `cron_notification` (
  `id` int NOT NULL,
  `user_id` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `title` varchar(2555) COLLATE utf8mb3_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(1000) COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `send` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'no',
  `show_listing` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `updated_date` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_slot`
--

CREATE TABLE `delivery_slot` (
  `id` int NOT NULL,
  `day` varchar(11) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_slot`
--

INSERT INTO `delivery_slot` (`id`, `day`) VALUES
(1, 'sunday'),
(2, 'monday '),
(3, 'tuesday '),
(4, 'wednesday'),
(5, 'thursday'),
(6, 'friday'),
(7, 'saturday');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_slot_time`
--

CREATE TABLE `delivery_slot_time` (
  `id` int NOT NULL,
  `delivery_slot_id` int NOT NULL,
  `day_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `slot_type` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` varchar(25) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery_slot_time`
--

INSERT INTO `delivery_slot_time` (`id`, `delivery_slot_id`, `day_name`, `slot_type`, `start_time`, `end_time`, `status`, `created_date`) VALUES
(2, 1, 'sunday', 'evening_slot', '17:00', '19:00', 'active', '2023/06/09 15:27:30'),
(4, 1, 'sunday', 'morning_slot', '07:00', '11:00', 'active', '2023/06/09 15:56:45'),
(5, 7, 'saturday', 'morning_slot', '07:00', '10:00', 'active', '2023/06/09 15:59:39'),
(6, 7, 'saturday', 'evening_slot', '17:00', '19:00', 'active', '2023/06/09 16:00:05'),
(7, 6, 'friday', 'morning_slot', '07:00', '10:00', 'active', '2023/06/09 16:00:27'),
(8, 6, 'friday', 'evening_slot', '17:00', '20:00', 'active', '2023/06/09 16:00:50'),
(9, 5, 'thursday', 'morning_slot', '07:00', '11:00', 'active', '2023/06/09 16:01:14'),
(10, 5, 'thursday', 'evening_slot', '17:00', '20:00', 'active', '2023/06/09 16:01:33'),
(11, 4, 'wednesday', 'morning_slot', '07:00', '10:00', 'active', '2023/06/09 16:04:32'),
(12, 4, 'wednesday', 'morning_slot', '17:00', '20:00', 'active', '2023/06/09 16:04:43'),
(13, 3, 'tuesday ', 'morning_slot', '07:00', '11:00', 'active', '2023/06/09 16:04:57'),
(14, 3, 'tuesday ', 'evening_slot', '17:00', '21:00', 'active', '2023/06/09 16:05:17'),
(15, 2, 'monday ', 'morning_slot', '07:00', '11:00', 'active', '2023/06/09 16:05:33'),
(16, 2, 'monday ', 'evening_slot', '17:00', '18:00', 'active', '2023/06/09 16:05:48'),
(17, 4, 'wednesday', 'morning_slot', '12:00', '14:00', 'active', '2023/06/14 11:32:38');

-- --------------------------------------------------------

--
-- Table structure for table `items_extra_data`
--

CREATE TABLE `items_extra_data` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `pc_attri_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(3,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `json_request`
--

CREATE TABLE `json_request` (
  `id` int NOT NULL,
  `request` longtext NOT NULL,
  `user_id` int NOT NULL,
  `api` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'Pending'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `my_cart`
--

CREATE TABLE `my_cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `content` mediumtext COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_date` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` varchar(11) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `created_date`, `user_id`) VALUES
(1, 'a@a.k', '2024-07-27 10:33:03', '30'),
(2, 'girishbhumkar5@gmail.com', '2024-07-27 17:10:49', '29'),
(3, 'a@asd', '2024-09-09 10:18:25', '38'),
(4, 'a@asd.asd', '2024-10-22 11:34:42', ''),
(5, 'a@as.h', '2024-11-13 10:22:24', '32'),
(6, 's@asd.asd', '2024-11-19 11:22:42', ''),
(7, 'info@allerstudios.co', '2025-09-29 14:07:50', ''),
(8, 'Dhalyahya@yahoo.com', '2025-12-02 17:07:05', '');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `image` varchar(255) NOT NULL,
  `product_id` varchar(11) NOT NULL,
  `user_id` longtext NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_date` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `order_comment`
--

CREATE TABLE `order_comment` (
  `id` int NOT NULL,
  `order_comment` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `oid` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_date` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_email_notification`
--

CREATE TABLE `order_email_notification` (
  `id` int NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `firebase` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `display_order_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `order_status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_date` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `order_email_notification`
--

INSERT INTO `order_email_notification` (`id`, `user_id`, `firebase`, `display_order_id`, `order_status`, `created_date`, `email`) VALUES
(1, NULL, '', '202411191119271', 'Pending', '2024/11/19 11:19:27', 'send'),
(2, NULL, '', '202411211007572', 'Pending', '2024/11/21 10:07:57', 'send'),
(3, NULL, '', '202501131606053', 'Pending', '2025/01/13 16:06:05', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `order_invoice`
--

CREATE TABLE `order_invoice` (
  `invoice_id` int NOT NULL,
  `order_no` int NOT NULL,
  `item_ids` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `payment_status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `payment_mode` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT '',
  `order_comment` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seller_id` int NOT NULL,
  `shipping_cost` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tax` decimal(65,0) NOT NULL,
  `sub_total` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `net_total` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `commission` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `order_status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `display_order_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `distance` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `source` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `order_invoice`
--

INSERT INTO `order_invoice` (`invoice_id`, `order_no`, `item_ids`, `payment_status`, `payment_mode`, `order_comment`, `created_date`, `seller_id`, `shipping_cost`, `tax`, `sub_total`, `net_total`, `commission`, `order_status`, `display_order_id`, `distance`, `source`) VALUES
(1, 1, '1', 'pending', 'cash-on-del', '', '2024-11-19 05:49:27', 51, '0', 0, '50', '50', '', 'pending', '202411191119271', '', ''),
(3, 3, '3', 'pending', 'cash-on-del', '', '2025-01-13 22:06:05', 0, '0', 0, '120', '120', '', 'pending', '202501131606053', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int NOT NULL,
  `order_no` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int DEFAULT NULL,
  `product_id` int NOT NULL,
  `seller_id` int NOT NULL DEFAULT '0',
  `product_name` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL,
  `quantity` int NOT NULL,
  `price` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL,
  `shipping_cost` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `sub_total` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tax` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `payment_status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `payment_mode` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `order_comment` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `delivery_date` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `commision` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `attribute` varchar(1000) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `grocery_shipment` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'no',
  `points` int NOT NULL,
  `extra_added` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `extra_added_amt` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `tax_percentage` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `product_unit` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_no`, `user_id`, `product_id`, `seller_id`, `product_name`, `quantity`, `price`, `shipping_cost`, `sub_total`, `tax`, `created_date`, `order_status`, `payment_status`, `payment_mode`, `order_comment`, `delivery_date`, `commision`, `attribute`, `grocery_shipment`, `points`, `extra_added`, `extra_added_amt`, `tax_percentage`, `product_unit`) VALUES
(1, '1', NULL, 29, 51, 'Shrimp taco', 10, '5', '', '50', '0', '2024-11-19 05:49:27', 'pending', 'Unpaid', 'cash-on-del', '', '', NULL, '', 'no', 0, '', '0', '0.00', ''),
(3, '3', NULL, 71, 0, 'McCAIN SPICY WEDGES 5X2,5KG', 1, '120', '', '120', '0', '2025-01-13 22:06:05', 'pending', 'Unpaid', 'cash-on-del', '', '', NULL, '', 'no', 0, '', '0', '0.00', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_master`
--

CREATE TABLE `order_master` (
  `order_master_id` int NOT NULL,
  `display_order_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `user_id` int DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `mobile_no` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL,
  `order_datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `shipping_charge` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL,
  `sub_total` double NOT NULL DEFAULT '0',
  `tax` double NOT NULL DEFAULT '0',
  `tax_percentage` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `extra_amt` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL,
  `tip_amount` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `net_total` double NOT NULL DEFAULT '0',
  `order_status` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Pending',
  `payment_mode` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'Paid',
  `payment_status` varchar(500) COLLATE utf8mb3_unicode_ci NOT NULL,
  `delivery_date` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `order_comment` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `source` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `voucher_id` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `voucher_code` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `voucher_type` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `voucher_amount` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `time_slot` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `driver_id` int NOT NULL,
  `admin_notification` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `landmark` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `order_count` int NOT NULL,
  `order_cancel_reason` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `order_cancel_date_time` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `online_unpaid_check` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `packed_date_time` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `ready_to_ship_date_time` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `delivered_date_time` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `canceled_date_time` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `admin_note` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `delivery_note` varchar(1000) COLLATE utf8mb3_unicode_ci NOT NULL,
  `wallet_amount` decimal(10,0) NOT NULL,
  `account_minus` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `account_minus_reason` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `pickup_code` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `saved_amount` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `address_id` int NOT NULL,
  `distance` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `address_lat` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `address_lng` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `trans_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `order_master`
--

INSERT INTO `order_master` (`order_master_id`, `display_order_id`, `user_id`, `name`, `mobile_no`, `email`, `order_datetime`, `shipping_charge`, `sub_total`, `tax`, `tax_percentage`, `extra_amt`, `tip_amount`, `net_total`, `order_status`, `payment_mode`, `payment_status`, `delivery_date`, `order_comment`, `source`, `voucher_id`, `voucher_code`, `voucher_type`, `voucher_amount`, `time_slot`, `driver_id`, `admin_notification`, `address`, `landmark`, `area`, `city`, `order_count`, `order_cancel_reason`, `order_cancel_date_time`, `online_unpaid_check`, `packed_date_time`, `ready_to_ship_date_time`, `delivered_date_time`, `canceled_date_time`, `admin_note`, `delivery_note`, `wallet_amount`, `account_minus`, `account_minus_reason`, `pickup_code`, `saved_amount`, `address_id`, `distance`, `address_lat`, `address_lng`, `trans_id`) VALUES
(1, '202411191119271', NULL, 'Girish Bhumkar', '8149169115', 'girish@gmail.com', '2024-11-19 05:49:27', '0', 50, 0, '0.00', '0', '0', 50, 'Pending', 'cash-on-del', 'Unpaid', '', NULL, 'Web', '', '', '', '0', 'Pending', 0, 'seen', 'Kedgaon', 'Ahmednagar', '', '', 0, '', '', '', '', '', '', '', '', 'Order Notes ', 0, '0', '', '9417', '450', 69, '', '', '', ''),
(3, '202501131606053', NULL, 'huzefa', '0503222728', 'mhozayfa@hotmail.com', '2025-01-13 22:06:05', '0', 120, 0, '0.00', '0', '0', 120, 'Pending', 'cash-on-del', 'Unpaid', '', NULL, 'Web', '', '', '', '0', 'Pending', 0, '', 'hih', 'bjhghjhj', '', '', 0, '', '', '', '', '', '', '', '', '', 0, '0', '', '2568', '1', 71, '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `otp_list`
--

CREATE TABLE `otp_list` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `otp` int NOT NULL,
  `phone` varchar(255) NOT NULL,
  `created_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `our_supplies`
--

CREATE TABLE `our_supplies` (
  `id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(25) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'active',
  `created_date` varchar(25) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `our_supplies`
--

INSERT INTO `our_supplies` (`id`, `image`, `status`, `created_date`) VALUES
(1, 'cli_1.jpg', 'active', ''),
(2, 'cli_2.jpg', 'active', ''),
(3, 'cli_3.jpg', 'active', ''),
(4, 'cli_4.jpg', 'active', ''),
(5, 'cli_5.jpg', 'active', ''),
(6, 'cli_6.jpg', 'active', ''),
(7, 'cli_7.jpg', 'active', '');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `editor` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `status`, `editor`, `slug`) VALUES
(1, 'About', 'active', '<h3><strong>Lorem ipsum odor amet,</strong></h3>\r\n\r\n<p>Lorem ipsum odor amet, consectetuer adipiscing elit. Posuere adipiscing platea hac rutrum interdum fusce. Netus facilisi suspendisse proin laoreet tempor tempus mattis sagittis sollicitudin. Montes ex eleifend a blandit, nisl sed. Amet condimentum fusce luctus rhoncus erat. Magna primis at, aliquet diam hac nostra mattis per.</p>\r\n\r\n<p>Dapibus risus elit enim cursus, tellus egestas laoreet varius. Curabitur tellus est semper lobortis dolor. Vulputate hendrerit ex pretium vestibulum blandit maecenas; vivamus ante odio. Volutpat lectus pellentesque semper vehicula iaculis venenatis risus a auctor. Nostra erat litora maximus arcu posuere dis ullamcorper. Nibh sed suspendisse non adipiscing ut rutrum luctus. Erat cursus facilisi erat pretium ultricies feugiat. Magnis velit accumsan purus nam praesent elementum lobortis consequat.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Morbi ante metus dictumst ante imperdiet lacus ac. Dis per phasellus sagittis iaculis natoque donec nostra ipsum. Justo ut platea class commodo auctor suspendisse. Cubilia consequat sociosqu duis ut per aptent pulvinar. Enim dignissim luctus donec luctus vitae sollicitudin. Orci nulla orci mollis nascetur eu aenean. Elit felis dictumst maecenas etiam hendrerit arcu nec est. Blandit eu cras litora turpis platea turpis consectetur. Platea euismod tincidunt pulvinar enim elit velit efficitur facilisis himenaeos.</p>\r\n\r\n<p>Finibus ligula ligula rhoncus, eleifend laoreet facilisis massa. Dis leo hac cras cursus sem eros. Elit rutrum vitae nisl aptent mollis vehicula convallis. Convallis habitant ante luctus odio, montes ad adipiscing. Nam cubilia aliquet hac mi libero ante mollis. Malesuada auctor ornare vivamus fermentum integer. Eleifend euismod porttitor tempor vestibulum magna. Eleifend aenean facilisi iaculis adipiscing lacinia posuere nisl nascetur sit. Tempor per nullam proin suscipit ullamcorper, phasellus curae imperdiet hendrerit.</p>\r\n\r\n<p>Himenaeos aenean hac velit dictumst auctor platea. Rhoncus ipsum accumsan euismod luctus vehicula nulla, dolor ipsum congue. Hendrerit laoreet risus ullamcorper, morbi maecenas hac. Efficitur tristique blandit non vel pretium netus. Sapien id ultrices malesuada ornare nisl sed torquent. Mauris aliquet et etiam nibh aliquam molestie at. Massa imperdiet aliquam consectetur justo montes ornare venenatis nam. Porttitor tellus penatibus; id sollicitudin ante fusce iaculis. Nec viverra cursus vel finibus scelerisque molestie. Volutpat habitant pretium cursus hac; sem turpis.</p>\r\n\r\n<h3>&nbsp;</h3>\r\n\r\n<h3><strong>Lorem ipsum odor amet,</strong></h3>\r\n\r\n<p>Lorem ipsum odor amet, consectetuer adipiscing elit. Posuere adipiscing platea hac rutrum interdum fusce. Netus facilisi suspendisse proin laoreet tempor tempus mattis sagittis sollicitudin. Montes ex eleifend a blandit, nisl sed. Amet condimentum fusce luctus rhoncus erat. Magna primis at, aliquet diam hac nostra mattis per.</p>\r\n\r\n<p>Dapibus risus elit enim cursus, tellus egestas laoreet varius. Curabitur tellus est semper lobortis dolor. Vulputate hendrerit ex pretium vestibulum blandit maecenas; vivamus ante odio. Volutpat lectus pellentesque semper vehicula iaculis venenatis risus a auctor. Nostra erat litora maximus arcu posuere dis ullamcorper. Nibh sed suspendisse non adipiscing ut rutrum luctus. Erat cursus facilisi erat pretium ultricies feugiat. Magnis velit accumsan purus nam praesent elementum lobortis consequat.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Morbi ante metus dictumst ante imperdiet lacus ac. Dis per phasellus sagittis iaculis natoque donec nostra ipsum. Justo ut platea class commodo auctor suspendisse. Cubilia consequat sociosqu duis ut per aptent pulvinar. Enim dignissim luctus donec luctus vitae sollicitudin. Orci nulla orci mollis nascetur eu aenean. Elit felis dictumst maecenas etiam hendrerit arcu nec est. Blandit eu cras litora turpis platea turpis consectetur. Platea euismod tincidunt pulvinar enim elit velit efficitur facilisis himenaeos.</p>\r\n\r\n<p>Finibus ligula ligula rhoncus, eleifend laoreet facilisis massa. Dis leo hac cras cursus sem eros. Elit rutrum vitae nisl aptent mollis vehicula convallis. Convallis habitant ante luctus odio, montes ad adipiscing. Nam cubilia aliquet hac mi libero ante mollis. Malesuada auctor ornare vivamus fermentum integer. Eleifend euismod porttitor tempor vestibulum magna. Eleifend aenean facilisi iaculis adipiscing lacinia posuere nisl nascetur sit. Tempor per nullam proin suscipit ullamcorper, phasellus curae imperdiet hendrerit.</p>\r\n\r\n<p>Himenaeos aenean hac velit dictumst auctor platea. Rhoncus ipsum accumsan euismod luctus vehicula nulla, dolor ipsum congue. Hendrerit laoreet risus ullamcorper, morbi maecenas hac. Efficitur tristique blandit non vel pretium netus. Sapien id ultrices malesuada ornare nisl sed torquent. Mauris aliquet et etiam nibh aliquam molestie at. Massa imperdiet aliquam consectetur justo montes ornare venenatis nam. Porttitor tellus penatibus; id sollicitudin ante fusce iaculis. Nec viverra cursus vel finibus scelerisque molestie. Volutpat habitant pretium cursus hac; sem turpis.</p>\r\n\r\n<h3>&nbsp;</h3>\r\n\r\n<h3><strong>Lorem ipsum odor amet,</strong></h3>\r\n\r\n<p>Lorem ipsum odor amet, consectetuer adipiscing elit. Posuere adipiscing platea hac rutrum interdum fusce. Netus facilisi suspendisse proin laoreet tempor tempus mattis sagittis sollicitudin. Montes ex eleifend a blandit, nisl sed. Amet condimentum fusce luctus rhoncus erat. Magna primis at, aliquet diam hac nostra mattis per.</p>\r\n\r\n<p>Dapibus risus elit enim cursus, tellus egestas laoreet varius. Curabitur tellus est semper lobortis dolor. Vulputate hendrerit ex pretium vestibulum blandit maecenas; vivamus ante odio. Volutpat lectus pellentesque semper vehicula iaculis venenatis risus a auctor. Nostra erat litora maximus arcu posuere dis ullamcorper. Nibh sed suspendisse non adipiscing ut rutrum luctus. Erat cursus facilisi erat pretium ultricies feugiat. Magnis velit accumsan purus nam praesent elementum lobortis consequat.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Morbi ante metus dictumst ante imperdiet lacus ac. Dis per phasellus sagittis iaculis natoque donec nostra ipsum. Justo ut platea class commodo auctor suspendisse. Cubilia consequat sociosqu duis ut per aptent pulvinar. Enim dignissim luctus donec luctus vitae sollicitudin. Orci nulla orci mollis nascetur eu aenean. Elit felis dictumst maecenas etiam hendrerit arcu nec est. Blandit eu cras litora turpis platea turpis consectetur. Platea euismod tincidunt pulvinar enim elit velit efficitur facilisis himenaeos.</p>\r\n\r\n<p>Finibus ligula ligula rhoncus, eleifend laoreet facilisis massa. Dis leo hac cras cursus sem eros. Elit rutrum vitae nisl aptent mollis vehicula convallis. Convallis habitant ante luctus odio, montes ad adipiscing. Nam cubilia aliquet hac mi libero ante mollis. Malesuada auctor ornare vivamus fermentum integer. Eleifend euismod porttitor tempor vestibulum magna. Eleifend aenean facilisi iaculis adipiscing lacinia posuere nisl nascetur sit. Tempor per nullam proin suscipit ullamcorper, phasellus curae imperdiet hendrerit.</p>\r\n\r\n<p>Himenaeos aenean hac velit dictumst auctor platea. Rhoncus ipsum accumsan euismod luctus vehicula nulla, dolor ipsum congue. Hendrerit laoreet risus ullamcorper, morbi maecenas hac. Efficitur tristique blandit non vel pretium netus. Sapien id ultrices malesuada ornare nisl sed torquent. Mauris aliquet et etiam nibh aliquam molestie at. Massa imperdiet aliquam consectetur justo montes ornare venenatis nam. Porttitor tellus penatibus; id sollicitudin ante fusce iaculis. Nec viverra cursus vel finibus scelerisque molestie. Volutpat habitant pretium cursus hac; sem turpis.</p>\r\n', 'about'),
(5, 'Privacy Policy', 'active', '<p><strong>Flexmotion SuperMarket&nbsp;</strong> built the&nbsp;<strong>&nbsp;Flexmotion SuperMarket&nbsp; </strong>app as a Commercial app. This SERVICE is provided by&nbsp;<strong>Flexmotion SuperMarket&nbsp;</strong> and is intended for use as is.</p>\r\n\r\n<p>This page is used to inform visitors regarding our policies with the collection, use, and disclosure of Personal Information if anyone decided to use our Service.</p>\r\n\r\n<p>If you choose to use our Service, then you agree to the collection and use of information in relation to this policy. The Personal Information that we collect is used for providing and improving the Service. We will not use or share your information with anyone except as described in this Privacy Policy.</p>\r\n\r\n<p>The terms used in this Privacy Policy have the same meanings as in our Terms and Conditions, which is accessible at<strong> Flexmotion SuperMarket&nbsp;</strong> unless otherwise defined in this Privacy Policy.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Information Collection and Use</strong></p>\r\n\r\n<p>For a better experience, while using our Service, we may require you to provide us with certain personally identifiable information. The information that we request will be retained by us and used as described in this privacy policy.</p>\r\n\r\n<p>The app does use third-party services that may collect information used to identify you.</p>\r\n\r\n<p>Link to the privacy policy of third party service providers used by the app</p>\r\n\r\n<p><strong>Google Play Services</strong></p>\r\n\r\n<p><br />\r\n<strong>Log Data</strong></p>\r\n\r\n<p>We want to inform you that whenever you use our Service, in a case of an error in the app we collect data and information (through third party products) on your phone called Log Data. This Log Data may include information such as your device Internet Protocol (&ldquo;IP&rdquo;) address, device name, operating system version, the configuration of the app when utilizing our Service, the time and date of your use of the Service, and other statistics.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Cookies</strong></p>\r\n\r\n<p>Cookies are files with a small amount of data that are commonly used as anonymous unique identifiers. These are sent to your browser from the websites that you visit and are stored on your device&#39;s internal memory.</p>\r\n\r\n<p>This Service does not use these &ldquo;cookies&rdquo; explicitly. However, the app may use third party code and libraries that use &ldquo;cookies&rdquo; to collect information and improve their services. You have the option to either accept or refuse these cookies and know when a cookie is being sent to your device. If you choose to refuse our cookies, you may not be able to use some portions of this Service.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Service Providers</strong></p>\r\n\r\n<p>We may employ third-party companies and individuals due to the following reasons:</p>\r\n\r\n<p>To facilitate our Service;<br />\r\nTo provide the Service on our behalf;<br />\r\nTo perform Service-related services; or<br />\r\nTo assist us in analyzing how our Service is used.<br />\r\nWe want to inform users of this Service that these third parties have access to your Personal Information. The reason is to perform the tasks assigned to them on our behalf. However, they are obligated not to disclose or use the information for any other purpose.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Security</strong></p>\r\n\r\n<p>We value your trust in providing us your Personal Information, thus we are striving to use commercially acceptable means of protecting it. But remember that no method of transmission over the internet, or method of electronic storage is 100% secure and reliable, and we cannot guarantee its absolute security.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Links to Other Sites</strong></p>\r\n\r\n<p>This Service may contain links to other sites. If you click on a third-party link, you will be directed to that site. Note that these external sites are not operated by us. Therefore, we strongly advise you to review the Privacy Policy of these websites. We have no control over and assume no responsibility for the content, privacy policies, or practices of any third-party sites or services.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Children&rsquo;s Privacy</strong></p>\r\n\r\n<p>These Services do not address anyone under the age of 13. We do not knowingly collect personally identifiable information from children under 13. In the case we discover that a child under 13 has provided us with personal information, we immediately delete this from our servers. If you are a parent or guardian and you are aware that your child has provided us with personal information, please contact us so that we will be able to do the necessary actions.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Changes to This Privacy Policy</strong></p>\r\n\r\n<p>We may update our Privacy Policy from time to time. Thus, you are advised to review this page periodically for any changes. We will notify you of any changes by posting the new Privacy Policy on this page. These changes are effective immediately after they are posted on this page.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Contact Us</strong></p>\r\n\r\n<p>If you have any questions or suggestions about our Privacy Policy, do not hesitate to contact us info@<strong>Flexmotion.com</strong></p>\r\n', 'privacy-policy'),
(7, 'Returns', 'deactive', '<div class=\"maf-container static-page\" style=\"border:0px; padding:20px 12px\">\r\n<div class=\"customer-service main\" style=\"border:0px; margin-bottom:20px; padding:0px\">\r\n<div class=\"maf-container static-page\" style=\"border:0px; padding:20px 12px\">\r\n<div class=\"customer-service main\" style=\"border:0px; margin-bottom:20px; margin-top:12px; padding:0px\">\r\n<h3><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:24px\">We are happy to assist you and manage all your requests for return and/or exchange!</span></span></span></h3>\r\n\r\n<div>From the day you receive your item, our return policy is valid for 7 days.</div>\r\n\r\n<div>Item(s) purchased on <strong>Flexmotion </strong>may be returned and/or exchanged either by pickup or directly in your nearest Carrefour hypermarket.</div>\r\n\r\n<div>For items sold by third party sellers through <strong>Flexmotion </strong>please consult on the seller detail page for instructions on how to proceed for returning the item.</div>\r\n\r\n<div>Please ensure that returned item(s) are supplemented with your order confirmation, a copy of your delivery note along with all accessories and free of charge gifts.</div>\r\n\r\n<div>If you have received an item(s) that is defective (e.g. delivered with ripped or missing parts, or other damage) it may be returned for a replacement or full credit upon approval.</div>\r\n\r\n<div>Please remember:</div>\r\n\r\n<div>The item(s) should be in its original and including unopened seal, along with the corresponding original order confirmation, delivery note, accessories and free gifts.</div>\r\n\r\n<div>For a pickup service, delivery charges may apply.</div>\r\n\r\n<div>To carry or retain the original box of product for 7 days to assist for any kind of return complain.</div>\r\n\r\n<div>For further information, please do not hesitate to <a href=\"https://www.Aboaleez.com/contact\">contact us</a>. We&rsquo;ll be happy to serve you.</div>\r\n\r\n<div>&nbsp;</div>\r\n\r\n<div><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:24px\">Our Returns and Exchanges promise:</span></span></span></div>\r\n\r\n<div style=\"border:0px; padding:0px; text-align:left; width:952px\">\r\n<div style=\"border:0px; padding:0px; text-align:left; width:952px\">\r\n<ul>\r\n	<li>\r\n	<div style=\"border:0px; padding:0px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><img alt=\"\" src=\"https://www.Aboaleez.com/medias/sys_master/root/h08/h01/8797909745694/Calender7.png\" style=\"border:0px; box-sizing:border-box; font-size:14px; max-width:160px; outline:0px; padding:0px; vertical-align:baseline; width:0px\" /></span></span></span></span></span><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><strong>7 Days Returns</strong><br />\r\n	From the day you receive your item, our return policy is valid for&nbsp;<strong>7 days.</strong></span></span></span></span></span></span></div>\r\n	</li>\r\n</ul>\r\n\r\n<div style=\"border:0px; padding:0px\">&nbsp;</div>\r\n\r\n<ul>\r\n	<li>\r\n	<div style=\"border:0px; padding:0px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><img alt=\"\" src=\"https://www.Aboaleez.com/medias/sys_master/root/ha0/h6e/8797915381790/boxhandle.png\" style=\"border:0px; box-sizing:border-box; font-size:14px; max-width:160px; outline:0px; padding:0px; vertical-align:baseline; width:0px\" /></span></span></span></span></span><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><strong>Easy Returns and Exchanges</strong><br />\r\n	You can visit us in any Hypermarket in the UAE for items sold directly by Carrefour or one of its suppliers.</span></span></span></span></span></span></div>\r\n	</li>\r\n</ul>\r\n\r\n<div style=\"border:0px; padding:0px\">&nbsp;</div>\r\n\r\n<ul>\r\n	<li>\r\n	<div style=\"border:0px; padding:0px\">\r\n	<p><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><strong>Get a refund</strong><br />\r\n	If the item is defective on delivery* (upon approval of after sales service).</span></span></span></span></span></span></p>\r\n	</div>\r\n	</li>\r\n</ul>\r\n</div>\r\n</div>\r\n\r\n<hr />\r\n<h3><br />\r\n<span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:24px\">Frequently Asked Questions (FAQs)</span></span></span></h3>\r\n\r\n<h3><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:24px\">In-Store Refund Policy Our promise</span></span></span></h3>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"color:#0e5aa7\"><strong>Q. Our general return policy</strong></span><br />\r\nYou can return an item upon approval within&nbsp;<strong>7 days</strong>&nbsp;of purchase.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"color:#0e5aa7\"><strong>Q. What do I do if an electrical product I&#39;ve purchased is damaged?</strong></span><br />\r\nPlease&nbsp;<a href=\"https://www.Aboaleez.com/store-finder\" style=\"box-sizing:border-box; padding:0px; font-size:14px; vertical-align:baseline; outline:none; text-decoration:none; color:#0e5aa7\">visit your nearest store</a>&nbsp;customer service desk for personalized service. We will assist you</span></span></span></p>\r\n\r\n<h3><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:24px\">e-Store Return &amp; Refunds</span></span></span></h3>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"color:#0e5aa7\"><strong>Q. Which documents do I need to bring to store for a refund or exchange?</strong></span><br />\r\nThe order confirmation and the delivery note are both mandatory for any refund or exchange to be proceeded.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"color:#0e5aa7\"><strong>Q. What is your Returns and Refund policy?</strong></span><br />\r\nOur return policy is a One Week Exchange and/or Refund upon approval.<br />\r\nIf for some reasons, you are not satisfied and you wish to return your purchase, you will need to reach our customer service on&nbsp;<a href=\"tel:80073232\" style=\"box-sizing:border-box; padding:0px; font-size:14px; vertical-align:baseline; outline:none; text-decoration:none; color:#0e5aa7\">800-732-32</a>&nbsp;or contact us on this page</span></span></span></p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\">. We&#39;ll be happy to serve you.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"color:#0e5aa7\"><strong>Q. What if I have receive a defective product?</strong></span><br />\r\nDefective items (e.g., items delivered with ripped or missing parts, or other damage) may be returned for a replacement or full credit upon approval. &nbsp;They must be reported within&nbsp;<strong>7 days</strong>&nbsp;from the date of reception of the item. Please contact us on this page&nbsp;, or reach our customer service on&nbsp;<a href=\"tel:80073232\" style=\"box-sizing:border-box; padding:0px; font-size:14px; vertical-align:baseline; outline:none; text-decoration:none; color:#0e5aa7\">800-732-32</a>&nbsp;as soon as possible. We&#39;ll be happy to serve you.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"color:#0e5aa7\"><strong>Q. Can you pick up my item for refund?</strong></span><br />\r\nYes, we can arrange this for you. Note that the delivery charge might be deducted in some cases. &nbsp;Please contact us on this page&nbsp;, or reach our customer service on&nbsp;<a href=\"tel:80073232\" style=\"box-sizing:border-box; padding:0px; font-size:14px; vertical-align:baseline; outline:none; text-decoration:none; color:#0e5aa7\">800-732-32</a>&nbsp;as soon as possible. We&#39;ll be happy to serve you.</span></span></span></p>\r\n\r\n<p><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"font-size:14px\"><span style=\"color:#0e5aa7\"><strong>Q. Can I get a refund for a Downloadable item?</strong></span><br />\r\nPlease contact us on this page&nbsp;or reach our customer service on&nbsp;<a href=\"tel:80073232\" style=\"box-sizing:border-box; padding:0px; font-size:14px; vertical-align:baseline; outline:none; text-decoration:none; color:#0e5aa7\">800-732-32</a>&nbsp;as soon as possible. We&#39;ll be happy to serve you.</span></span></span></p>\r\n</div>\r\n</div>\r\n</div>\r\n</div>\r\n', 'return'),
(8, 'Frequently Asked Questions (FAQ)', 'active', '<h3><strong>In-Store Refund Policy Our promise</strong></h3>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Q. Our general return policy</strong><br />\r\nYou can return an item upon approval within&nbsp;<strong>7 days</strong>&nbsp;of purchase.</p>\r\n\r\n<p><strong>Q. What do I do if an electrical product I&#39;ve purchased is damaged?</strong><br />\r\nPlease&nbsp;<a href=\"https://www.Aboaleez.com/store-finder\">visit your nearest store</a>&nbsp;customer service desk for personalized service. We will assist you</p>\r\n\r\n<h3>&nbsp;</h3>\r\n\r\n<h3><strong>e-Store Return &amp; Refunds</strong></h3>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Q. Which documents do I need to bring to store for a refund or exchange?</strong><br />\r\nThe order confirmation and the delivery note are both mandatory for any refund or exchange to be proceeded.</p>\r\n\r\n<p><strong>Q. What is your Returns and Refund policy?</strong><br />\r\nOur return policy is a One Week Exchange and/or Refund upon approval.<br />\r\nIf for some reasons, you are not satisfied and you wish to return your purchase, you will need to reach our customer service on&nbsp;<a href=\"tel:80073232\">800-732-32</a>&nbsp;or contact us on this page.&nbsp;We&#39;ll be happy to serve you.</p>\r\n\r\n<p><strong>Q. What if I have receive a defective product?</strong><br />\r\nDefective items (e.g., items delivered with ripped or missing parts, or other damage) may be returned for a replacement or full credit upon approval. &nbsp;They must be reported within&nbsp;<strong>7 days</strong>&nbsp;from the date of reception of the item. Please contact us on this page&nbsp;&nbsp;or reach our customer service on&nbsp;<a href=\"tel:80073232\">800-732-32</a>&nbsp;as soon as possible. We&#39;ll be happy to serve you.</p>\r\n\r\n<p><strong>Q. Can you pick up my item for refund?</strong><br />\r\nYes, we can arrange this for you. Note that the delivery charge might be deducted in some cases. &nbsp;Please contact us on this page&nbsp;or reach our customer service on&nbsp;<a href=\"tel:80073232\">800-732-32</a>&nbsp;as soon as possible. We&#39;ll be happy to serve you.</p>\r\n\r\n<p><strong>Q. Can I get a refund for a Downloadable item?</strong><br />\r\nPlease contact us on this page&nbsp;or reach our customer service on&nbsp;<a href=\"tel:80073232\">800-732-32</a>&nbsp;as soon as possible. We&#39;ll be happy to serve you.</p>\r\n', 'frequently-asked-questions-faq'),
(9, 'Terms & Conditions', 'active', '<p><strong>Acceptance of the Terms and Conditions:</strong></p>\r\n\r\n<p>This website and mobile application are operated by Flexmotion . The following Terms and Conditions, govern your access to and use of our website, including content, functionality and services offered on or through our website, and our online applications that run on smartphones, tablets and other devices which provide dedicated non-browser-based interaction between you and our website and / or app whether as a guest or registered user.</p>\r\n\r\n<p>By using the website you agree to the Terms of Conditions and our Privacy Policy. If you do not agree to the Terms and Conditions you must not access or use the website.</p>\r\n\r\n<p>The contract between you and ourselves is formed when you accept the Terms and Conditions. Please understand that if you do not accept these Terms and Conditions you will unable to activate your Membership.</p>\r\n\r\n<p>By purchasing from the App offered by Flexmotion SuperMarket , through the website or online applications that run on smartphones, tablets and other devices you agree to these Terms and Conditions.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Changes to the Terms and Conditions:</strong></p>\r\n\r\n<p>We may revise and update these Terms and Conditions from time to time at our sole discretion. All changes are effective immediately and apply to all access and use of the website and app thereafter</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Access to the Website and App:</strong></p>\r\n\r\n<p>We reserve the right to withdraw or amend the website, and/or any material found on the website without notice. We will not be liable if for any reason if all or any part of the website is unavailable at any time or for any period. We may restrict access to parts of the website, or the entire website to users, including registered users.</p>\r\n\r\n<p>You are responsible for ensuring that all persons who access the website through your internet connection are aware of the Terms and Conditions and comply with them.</p>\r\n\r\n<p>To access the website or app, you may be asked to provide certain registration details or other information. All information you provide must be correct, current and complete. All information you provide is governed by our Privacy Policy and you consent to all actions we take with respect to your information consistent with our Privacy Policy.</p>\r\n\r\n<p>If you chose, or are provided with a user name, password or other information as part of our security procedures, you must treat such information as confidential, and you must not disclose it to any other person or entity.&nbsp; Your account is personal to you and agrees not to provide any other person with access to the app using your security information. You should notify us immediately of any unauthorized access, use of your username and password or any other breach of security.</p>\r\n\r\n<p>We have the right to disable your account at any time for any reason if we believe you have violated any of the points in the Terms and Conditions.&nbsp;</p>\r\n\r\n<p><strong>Disclaimer of Warranties:</strong></p>\r\n\r\n<p>We cannot guarantee that files available for download from the internet or the website will be free from viruses. You are responsible for implementing sufficient procedures for anti-virus protection.</p>\r\n\r\n<p>We will not be liable for any loss or damage caused by viruses or other harmful technology that may infect your computer or equipment, due to your use of the website or app.</p>\r\n\r\n<p>Your use to the website, its content and any services or items obtained through the website is at your own risk.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Orders:</strong></p>\r\n\r\n<p>When you attempt to purchase from the app on our website or directly through the app, by clicking &lsquo;purchase&rsquo;, this establishes an offer to buy the product. Your purchase, however, is not complete until you receive an email confirming the transaction. We reserve the right to reject your offer and not conclude a sale agreement with you.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Pricing:</strong></p>\r\n\r\n<p>We reserve the right to change, modify substitute, suspend or remove without any notice any information related to items for sale. Changes will not affect orders in respect of which we have already sent you confirmation.</p>\r\n\r\n<p>If we have made an error or omission and you have already purchased a product, if the actual price is less than stated at the time of purchase, we will charge you the lower price or refund the difference.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Payment:</strong></p>\r\n\r\n<p>Payment for the app can be made on our website or via the app with a valid credit or Cash.</p>\r\n\r\n<p>We reserve the right to make amendments to pricing without notice.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Liability Limitations:</strong></p>\r\n\r\n<p>In no event will Flexmotion SuperMarket, be liable for damages of any kind, under any legal theory, arising out of or in connection with your purchase or use.</p>\r\n\r\n<p>In no event will Flexmotion SuperMarket, be liable for loss of revenue, loss of profits, loss of business or anticipated savings, loss of use, loss of data, and breach of contract or otherwise.</p>\r\n\r\n<p>In no event will Flexmotion SuperMarket be liable if you cannot access the App due to technical issues beyond our control. This includes unavailability, connectivity and technical issues with your device.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Agreement:</strong></p>\r\n\r\n<p>This Terms and Conditions and other documents found on our website establishes the sole agreement between you and Flexmotion SuperMarket with respect to your purchase of the product and replaces all prior understandings, agreements, representations and warranties, both written and verbal, with respect to such purchase.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Written Communication:</strong></p>\r\n\r\n<p>Applicable laws require that the information or communication we send to you will be in writing. When using our site, you accept that communication with us will be via email.</p>\r\n\r\n<p>All notices given by you to us must be sent to Customer&rsquo;s Services at info@Flexmotion.com</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>General:</strong></p>\r\n\r\n<p>If we fail to enforce a right under this agreement, that failure will not prevent us from enforcing other rights, or the same type of right on a later occasion.</p>\r\n\r\n<p>If any provision of these terms and conditions is held to be unlawful, invalid or unenforceable, that provision shall be deemed severed and the validity and enforceability of the remaining conditions shall not be affected.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Entire agreement:</strong></p>\r\n\r\n<p>This document sets out the entire agreement and understanding between the parties and supersedes all prior agreements, understandings or arrangements (whether verbal or written) in respect of the subject matter in this agreement. Neither party shall have any liability in respect of any other representation or warranty (whether made innocently or negligently) that is not set out in these terms and conditions or the documents referred to in them.</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Feedback and Comments:</strong></p>\r\n\r\n<p>All feedback, comments, requests for technical support relating to the website and app should be directed to info@Flexmotion.com</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'terms-conditions');

-- --------------------------------------------------------

--
-- Table structure for table `pcustomize_title`
--

CREATE TABLE `pcustomize_title` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `add_limit` tinyint NOT NULL,
  `type` tinyint NOT NULL COMMENT '1 means radio 2 means checkbox',
  `status` tinyint NOT NULL COMMENT '1 means active',
  `delete_status` tinyint NOT NULL COMMENT '1 means deleted',
  `slug` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `product_name_ar` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `product_name_ku` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `seller_id` int NOT NULL DEFAULT '0',
  `category` int NOT NULL DEFAULT '0',
  `category_status` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `short_description` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0.00',
  `stock_status` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `stock` int NOT NULL DEFAULT '0',
  `sale` int NOT NULL DEFAULT '0',
  `sku` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `product_image` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `image_gallery` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '' COMMENT '1 - Active, 0 - Deactive',
  `tags` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `price_select` tinyint NOT NULL COMMENT '1 means single price 2 means multi price',
  `special_menu` tinyint NOT NULL COMMENT '1 means special menu',
  `customize` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `product_delete` tinyint NOT NULL COMMENT '1 means product deleted',
  `category_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `view_count` int NOT NULL,
  `tax` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `shop_id` int NOT NULL,
  `incremental_qty` int NOT NULL DEFAULT '1',
  `minimum_add_to_cart` int NOT NULL DEFAULT '1',
  `product_weight` int NOT NULL,
  `type_qty_piece_name` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `avg_rating` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '0',
  `short_description_ar` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `description_ar` longtext COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `product_name_ar`, `product_name_ku`, `seller_id`, `category`, `category_status`, `description`, `short_description`, `price`, `sale_price`, `stock_status`, `stock`, `sale`, `sku`, `product_image`, `image_gallery`, `created_date`, `status`, `tags`, `price_select`, `special_menu`, `customize`, `product_delete`, `category_name`, `view_count`, `tax`, `shop_id`, `incremental_qty`, `minimum_add_to_cart`, `product_weight`, `type_qty_piece_name`, `avg_rating`, `short_description_ar`, `description_ar`) VALUES
(50, 'Martins Potato Bun -4 Inch - 48 Pcs', '', '', 0, 39, 'active', '<p>Martins Potato Bun -4 Inch - 48 Pcs&nbsp;</p><p>&nbsp;4x12</p>', 'Martins Potato Bun -4 Inch - 48 Pcs - 4x12', 100.00, '99', 'instock', 1000, 0, '520524', '5517.png', 'b6df56d6b5568e48eaf59e700e16c4321.png', '2024-12-11 11:03:29', '1', '', 1, 0, '', 0, 'Martin’s potato rolls and bread', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(51, 'Martin Long Potato 8*8', '', '', 0, 39, 'active', '<p>Martin Long Potato 8*8</p><p>8x8</p>', 'Martin Long Potato 8*8', 116.00, '115', 'instock', 1000, 0, '520530', '6815.png', '22ffe09d23515534888c085c07ff19351.png', '2024-12-11 11:08:28', '1', '', 1, 0, '', 0, 'Martin’s potato rolls and bread', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(74, 'McCAIN Suercrisp 6*6 12.5 KG **SKIN ON', '', '', 0, 38, 'active', '<p>McCAIN Suercrisp 6*6 12.5 KG **SKIN ON&nbsp;</p>', 'McCAIN Suercrisp 6*6 12.5 KG **SKIN ON', 133.00, '132', 'instock', 1000, 0, '7739', '9013.jpg', '008899e7c34d3e0705770b6f4cfdf0281.jpg', '2024-12-12 11:09:21', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(75, 'McCAIN SUPERCRISPS SPICY FRIES6X5 LB LATIN', '', '', 0, 38, 'active', '<p>McCAIN SUPERCRISPS SPICY FRIES6X5 LB&nbsp;<br>LATIN</p>', 'McCAIN SUPERCRISPS SPICY FRIES6X5 LB LATIN', 163.00, '162', 'instock', 1000, 0, '5565', '5901.jpeg', 'fd8b0c3fc2a8eb464403c3c1c35147a71.jpeg', '2024-12-12 11:10:37', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(76, 'McCAIN Sure crisp 9 x 9 Skin on (4*2.5 KG )', '', '', 0, 38, 'active', '<p>McCAIN Sure crisp 9 x 9 Skin on (4*2.5 KG )</p>', 'McCAIN Sure crisp 9 x 9 Skin on (4*2.5 KG )', 110.00, '109', 'instock', 1000, 0, '7564', '201.jpg', '4888d50cb7ff209295a2cc2146f2e3fb1.jpg', '2024-12-12 11:13:15', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(77, 'McCAIN Surecrisp Crinckle 4*2.5 KG', '', '', 0, 38, 'active', '<p>McCAIN Surecrisp Crinckle 4*2.5 KG</p>', 'McCAIN Surecrisp Crinckle 4*2.5 KG', 110.00, '109', 'instock', 1000, 0, '8022', '8578.png', 'e1377de36b6af397941ac06826217bac1.png', '2024-12-12 11:15:15', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(78, 'McCAIN Sweet Harvest Splendor Fries 6*1.13 kg', '', '', 0, 38, 'active', '<p>McCAIN Sweet Harvest Splendor Fries&nbsp;<br>6*1.13 kg</p>', 'McCAIN Sweet Harvest Splendor Fries 6*1.13 kg', 181.00, '180', 'instock', 1000, 0, '497391/ 10262', '7464.jpg', '38f0e05205145e3db7b1fbcdb4a404381.jpg', '2024-12-12 11:16:54', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(79, 'McCAIN-Our-Original-Choice-Rosti-Taler￾Pommes-paillasson 6x1.5Kg', '', '', 0, 38, 'active', '<p>McCAIN-Our-Original-Choice-Rosti-Taler￾Pommes-paillasson 6x1.5Kg</p>', 'McCAIN-Our-Original-Choice-Rosti-Taler￾Pommes-paillasson 6x1.5Kg', 125.00, '124', 'instock', 1000, 0, '135616', '6462.png', '8f103ffec984a9c892e8b705aacd3a431.png', '2024-12-12 11:17:52', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(80, 'SMILES McCAIN 12*750 GM', '', '', 0, 38, 'active', '<p>SMILES McCAIN 12*750 GM&nbsp;</p>', 'SMILES McCAIN 12*750 GM', 121.00, '120', 'instock', 1000, 0, '7675', '1920.jpg', '89b8b62251af740ae734f34ab81bac1e1.jpg', '2024-12-12 11:18:56', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(81, 'BATTERED EXTRUDED ONION RINGS 8x1Kg', '', '', 0, 38, 'active', '<p>BATTERED EXTRUDED ONION RINGS 8x1Kg</p>', 'BATTERED EXTRUDED ONION RINGS 8x1Kg', 211.00, '210', 'instock', 1000, 0, '1442', '7530.png', 'e3f84aa6ee57b3c9bc3e7dd59e9e283a1.png', '2024-12-12 11:20:36', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(82, 'ARLA Pro 6X1100g Glass Jar', '', '', 0, 36, 'active', '<p>ARLA Pro 6X1100g Glass Jar</p>', 'ARLA Pro 6X1100g Glass Jar', 101.00, '100', 'instock', 1000, 0, '602237', '9885.png', '5f195fcc0041c3e7140c4688cdba065f1.png', '2024-12-12 11:35:39', '1', '', 1, 0, '', 0, 'arla', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(83, 'PC SOS Ched Veg Fat26% ArlaPro', '', '', 0, 36, 'active', '<p>PC SOS Ched Veg Fat26% ArlaPro&nbsp;</p>', 'PC SOS Ched Veg Fat26% ArlaPro', 211.00, '210', 'instock', 1000, 0, '603701', '640.webp', '', '2024-12-12 11:38:05', '1', '', 1, 0, '', 0, 'arla', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(84, 'LURPAK UNSALTED BUTTER 20X500G', '', '', 0, 36, 'active', '<p>LURPAK UNSALTED BUTTER 20X500G</p>', 'LURPAK UNSALTED BUTTER 20X500G', 471.00, '470', 'instock', 1000, 0, '86543', '3985.jpeg', '88815f71af2e31a74b044abe7b122e791.jpeg', '2024-12-12 11:39:29', '1', '', 1, 0, '', 0, 'arla', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(85, 'ARLA PRO 8X2.3KG PIZZA TOPPING BLOCK', '', '', 0, 36, 'active', '<p>ARLA PRO 8X2.3KG PIZZA TOPPING BLOCK&nbsp;</p>', 'ARLA PRO 8X2.3KG PIZZA TOPPING BLOCK', 286.00, '285', 'instock', 1000, 0, '582435', '2495.webp', '', '2024-12-12 11:41:28', '1', '', 1, 0, '', 0, 'arla', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(86, 'ARLA PRO WHIPPING CREAM 10X1L', '', '', 0, 36, 'active', '<p>ARLA PRO WHIPPING CREAM 10X1L</p>', 'ARLA PRO WHIPPING CREAM 10X1L', 241.00, '240', 'instock', 1000, 0, '86183', '5343.webp', '', '2024-12-12 11:48:34', '1', '', 1, 0, '', 0, 'arla', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(87, 'ARLA Cream Whip & Cook 10X1L', '', '', 0, 36, 'active', '<p>ARLA Cream Whip &amp; Cook 10X1L</p>', 'ARLA Cream Whip & Cook 10X1L', 121.00, '120', 'instock', 1000, 0, '596902', '2766.png', 'e63f3c2660372e4bea7d378f57aaad271.png', '2024-12-12 11:49:57', '1', '', 1, 0, '', 0, 'arla', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(88, 'ARLA Pro CREAM CHEESE BLOCK 3X1.8KG', '', '', 0, 36, 'active', '<p>ARLA Pro CREAM CHEESE BLOCK 3X1.8KG</p>', 'ARLA Pro CREAM CHEESE BLOCK 3X1.8KG', 161.00, '160', 'instock', 1000, 0, '63854', '1356.png', 'af489a6a7e0fccf7c93ed145e15104c51.png', '2024-12-12 11:51:09', '1', '', 1, 0, '', 0, 'arla', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(89, 'LURPAK 1X5KG SPREADABLE BUTTER UNS', '', '', 0, 36, 'active', '<p>LURPAK 1X5KG SPREADABLE BUTTER UNS</p>', 'LURPAK 1X5KG SPREADABLE BUTTER UNS', 186.00, '185', 'instock', 1000, 0, '796359', '1155.webp', '', '2024-12-12 11:52:05', '1', '', 1, 0, '', 0, 'arla', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(90, 'LURPAK COOKING MIST 8X200ML', '', '', 0, 36, 'active', '<p>LURPAK COOKING MIST 8X200ML&nbsp;</p>', 'LURPAK COOKING MIST 8X200ML', 161.00, '160', 'instock', 1000, 0, '89111', '6126.webp', '', '2024-12-12 11:53:01', '1', '', 1, 0, '', 0, 'arla', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(91, 'Natural Mineral Water 330MlX12', '', '', 0, 44, 'active', '<p>Natural Mineral Water 330MlX12</p>', 'Natural Mineral Water 330MlX12', 31.00, '30', 'instock', 1000, 0, '5005242', '5926.webp', '', '2024-12-12 11:59:03', '1', '', 1, 0, '', 0, 'buzdagi', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(92, 'Natural Mineral Water 750MlX6', '', '', 0, 44, 'active', '<p>Natural Mineral Water 750MlX6</p>', 'Natural Mineral Water 750MlX6', 31.00, '30', 'instock', 1000, 0, '5005243', '8962.webp', '', '2024-12-12 12:00:49', '1', '', 1, 0, '', 0, 'buzdagi', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(93, 'Margherita Pizza Sauce 1 x 40', '', '', 0, 45, 'active', '<p>Margherita Pizza Sauce 1 x 40</p>', 'Margherita Pizza Sauce 1 x 40', 391.00, '390', 'instock', 1000, 0, '54390', '3798.png', 'df12c24f61268f8952f237d17d99d4611.png', '2024-12-12 12:02:49', '1', '', 1, 0, '', 0, 'vibi', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(94, 'Four Cheese Pizza 1 x 40', '', '', 0, 45, 'active', '<p>Four Cheese Pizza 1 x 40</p>', 'Four Cheese Pizza 1 x 40', 391.00, '390', 'instock', 1000, 0, '54390', '8861.png', '4fbea4dc185042617601a8540b8081391.png', '2024-12-12 12:06:32', '1', '', 1, 0, '', 0, 'vibi', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(95, 'Pesto Pizza Sauce with Basil 1 x 40', '', '', 0, 45, 'active', '<p>Pesto Pizza Sauce with Basil 1 x 40</p>', 'Pesto Pizza Sauce with Basil 1 x 40', 391.00, '390', 'instock', 1000, 0, '54390', '3016.png', '084af1f77bc255b4a902fb4a538f58661.png', '2024-12-12 12:08:39', '1', '', 1, 0, '', 0, 'vibi', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(54, 'Hellmann’s Classic Mayonnaise 4x3.78Ltr', '', '', 0, 42, 'active', '<p>Hellmann’s Classic Mayonnaise -4x3.78Ltr</p>', 'Hellmann’s Classic Mayonnaise -4x3.78Ltr', 281.00, '279.64', 'instock', 1000, 0, '10455', '1399.jpg', 'db44969320dcc8531b0e4efa5fe920ad1.jpg', '2024-12-12 07:27:33', '1', '', 1, 0, '', 0, 'Hellmann\'s', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(55, 'Hellmann\'s Real Ketchup 5 kg 4X5 Kg', '', '', 0, 42, 'active', '<p>Hellmann\'s Real Ketchup 5 kg 4X5 Kg</p>', 'Hellmann\'s Real Ketchup 5 kg 4X5 Kg', 179.00, '177.87', 'instock', 1000, 0, '10456', '2563.jpg', 'b505408cd4afb035f07361b1186c66a61.jpg', '2024-12-12 07:31:13', '1', '', 1, 0, '', 0, 'Hellmann\'s', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(56, 'McCAIN SPICY SPIRAL ARABIC 4X2.5 KG ( Curly Fries)', '', '', 0, 38, 'active', '<p>McCAIN SPICY SPIRAL ARABIC 4X2.5 KG&nbsp;<br>( Curly Fries)</p>', 'McCAIN SPICY SPIRAL ARABIC 4X2.5 KG ( Curly Fries)', 131.00, '130', 'instock', 1000, 0, '400632', '8103.png', '91ec70f29d3c064fa64832c792158e4f1.png', '2024-12-12 10:36:36', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(57, 'McCAIN 3 Kant Triangles 2*2.5 KG', '', '', 0, 38, 'active', '<p>McCAIN 3 Kant Triangles 2*2.5 KG&nbsp;</p>', 'McCAIN 3 Kant Triangles 2*2.5 KG', 137.00, '136', 'instock', 1000, 0, '210816', '7651.png', '0aafa4bf719c8a0e343cfb6f1a1da1cd1.png', '2024-12-12 10:40:12', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(58, 'McCAIN Battered Mozza Stick ( 6 X 2.5LB )', '', '', 0, 38, 'active', '<p>McCAIN Battered Mozza Stick ( 6 X 2.5LB )&nbsp;</p>', 'McCAIN Battered Mozza Stick ( 6 X 2.5LB )', 264.00, '263', 'instock', 1000, 0, '10890', '260.png', '133d636ef101628d8cf621593ee8de9c1.png', '2024-12-12 10:41:51', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(59, 'McCAIN Breaded Onion Rings - HOLLAND Origin -10*1KG', '', '', 0, 38, 'active', '<p>McCAIN Breaded Onion Rings - HOLLAND&nbsp;<br>Origin -10*1KG</p>', 'McCAIN Breaded Onion Rings - HOLLAND Origin -10*1KG', 196.00, '195', 'instock', 1000, 0, '110605', '5989.png', '417e1f8d7e44d2297a47bf755c7ef1f11.png', '2024-12-12 10:43:47', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(60, 'McCAIN Chilli Cheese Nugget 6*1 kg', '', '', 0, 38, 'active', '<p>McCAIN Chilli Cheese Nugget 6*1 kg</p>', 'McCAIN Chilli Cheese Nugget 6*1 kg', 211.00, '210', 'instock', 1000, 0, '9974', '1647.png', '5d93103f0c5328dc08720426e4ac7ad71.png', '2024-12-12 10:45:04', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(61, 'McCAIN CRINCKLE FRENCH FRIES 9/9 5X2.5KG', '', '', 0, 38, 'active', '<p>McCAIN CRINCKLE FRENCH FRIES 9/9&nbsp;<br>5X2.5KG</p>', 'McCAIN CRINCKLE FRENCH FRIES 9/9 5X2.5KG', 120.00, '119', 'instock', 1000, 0, '1957', '9270.png', 'c8e6fd0c0b84f1a1281116de7f354a6b1.png', '2024-12-12 10:46:14', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(62, 'McCAIN Crispers 12.5 KG', '', '', 0, 38, 'active', '<p>McCAIN Crispers 12.5 KG&nbsp;</p>', 'McCAIN Crispers 12.5 KG', 134.00, '133', 'instock', 1000, 0, '10545', '5987.jpg', '60815dbf725af0779c251081006c175f1.jpg', '2024-12-12 10:48:14', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(63, 'McCAIN Home Style Choice Cubes 2.5 kg', '', '', 0, 38, 'active', '<p>McCAIN Home Style Choice Cubes 2.5 kg</p>', 'McCAIN Home Style Choice Cubes 2.5 kg', 134.00, '133', 'instock', 1000, 0, '111705', '7733.png', '166aef82446e6039f1378655e6ad1c861.png', '2024-12-12 10:49:43', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(64, 'McCAIN Italian Mozzarella Sticks (4 x 3 LB)', '', '', 0, 38, 'active', '<p>McCAIN Italian Mozzarella Sticks (4 x 3 LB)</p>', 'McCAIN Italian Mozzarella Sticks (4 x 3 LB)', 211.00, '210', 'instock', 1000, 0, '1434', '3685.png', '4c8715e2438f45bbb36b34e79e0e08571.png', '2024-12-12 10:50:59', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(65, 'McCAIN Julienne Fries 6*6 (5*2.5 KG )', '', '', 0, 38, 'active', '<p>McCAIN Julienne Fries 6*6 (5*2.5 KG )</p>', 'McCAIN Julienne Fries 6*6 (5*2.5 KG )', 145.00, '114', 'instock', 1000, 0, '100246', '9552.png', '2e9274a67b7f8f35973e1950c50cb32f1.png', '2024-12-12 10:52:09', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(66, 'McCAIN MINI CRISPY ONION RINGS 6 KG', '', '', 0, 38, 'active', '<p>McCAIN MINI CRISPY ONION RINGS 6 KG</p>', 'McCAIN MINI CRISPY ONION RINGS 6 KG', 141.00, '140', 'instock', 1000, 0, '9959', '4909.png', '824ec2119dbfe84bca666b19cd2324d81.png', '2024-12-12 10:53:18', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(67, 'McCAIN Mini Jalapeno Cheese Bites ( 6 X 2.5 LB)', '', '', 0, 38, 'active', '<p>McCAIN Mini Jalapeno Cheese Bites&nbsp;<br>( 6 X 2.5 LB)&nbsp;</p>', 'McCAIN Mini Jalapeno Cheese Bites ( 6 X 2.5 LB)', 136.00, '235', 'instock', 1000, 0, '4386', '6129.png', 'c89cef94a00e9dbd4c2a616f522b7c561.png', '2024-12-12 10:54:35', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(68, 'McCAIN ORIGINAL FRIES 9/9 5X2,5KG', '', '', 0, 38, 'active', '<p>McCAIN ORIGINAL FRIES 9/9 5X2,5KG</p>', 'McCAIN ORIGINAL FRIES 9/9 5X2,5KG', 118.00, '117', 'instock', 1000, 0, '10375', '1313.png', '9f0223809d99070e2d5bb352103104591.png', '2024-12-12 10:56:15', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(69, 'McCAIN Queso Triangle ( 1.81 KG ) 2 Bags', '', '', 0, 38, 'active', '<p>McCAIN Queso Triangle ( 1.81 KG ) 2 Bags</p>', 'McCAIN Queso Triangle ( 1.81 KG ) 2 Bags', 160.00, '159', 'instock', 1000, 0, '10767', '1276.png', '5a58e5c84c9f967933651c4608ac61211.png', '2024-12-12 10:57:29', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(70, 'McCAIN Spicy Onion Rings 6*1 kg', '', '', 0, 38, 'active', '<p>McCAIN Spicy Onion Rings 6*1 kg&nbsp;</p>', 'McCAIN Spicy Onion Rings 6*1 kg', 166.00, '165', 'instock', 1000, 0, '8023', '3008.png', '7d52e3f41c0fdcd6e8168e253040fcf71.png', '2024-12-12 11:02:18', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(71, 'McCAIN SPICY WEDGES 5X2,5KG', '', '', 0, 38, 'active', '<p>McCAIN SPICY WEDGES 5X2,5KG&nbsp;</p>', 'McCAIN SPICY WEDGES 5X2,5KG', 121.00, '120', 'instock', 999, 0, '10370', '3784.jpg', 'bd614a043c59b505946bc17846112bd41.jpg', '2024-12-12 11:03:46', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(72, 'McCAIN STEAK HOUSE 9/18 12.5 KG', '', '', 0, 38, 'active', '<p>McCAIN STEAK HOUSE 9/18 12.5 KG</p>', 'McCAIN STEAK HOUSE 9/18 12.5 KG', 121.00, '120', 'instock', 1000, 0, '197100', '950.png', 'feff0d9ab4c9ac5d7cfc8243edd769ce1.png', '2024-12-12 11:05:02', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(73, 'McCAIN Suercrisp 6*6 12.5 KG **SKIN OFF', '', '', 0, 38, 'active', '<p>McCAIN Suercrisp 6*6 12.5 KG **SKIN OFF</p>', 'McCAIN Suercrisp 6*6 12.5 KG **SKIN OFF', 133.00, '132', 'instock', 1000, 0, '7738', '4034.png', 'dc2862a961bd698402bc217178777e7b1.png', '2024-12-12 11:07:10', '1', '', 1, 0, '', 0, 'mccain ', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(52, 'Martin bun 5 INCH', '', '', 0, 39, 'active', '<p>Martin bun 5 INCH- 4x8</p>', 'Martin bun 5 INCH', 91.00, '90', 'instock', 1000, 0, '520523', '6551.png', 'ed0fa270a7397a9ee13a2ef50a707dc21.png', '2024-12-11 11:14:08', '1', '', 1, 0, '', 0, 'Martin’s potato rolls and bread', 0, '', 0, 1, 1, 0, '', '0', '', ''),
(96, 'Shredded Mozzarella Mayza (6*2Kg)', '', '', 0, 31, 'active', '<p>Shredded Mozzarella Mayza (6*2Kg)</p>', 'Shredded Mozzarella Mayza (6*2Kg)', 286.00, '285', 'instock', 100, 0, '', '7951.jpeg', 'a52b021af57dcf298d89a34e0c89b6231.jpeg', '2024-12-14 09:03:19', '1', '', 1, 0, '', 0, 'mayza products', 0, '', 0, 1, 1, 0, '', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_attribute`
--

CREATE TABLE `product_attribute` (
  `id` int NOT NULL,
  `attribute_id` int DEFAULT NULL,
  `p_id` varchar(255) DEFAULT NULL,
  `item_id` int NOT NULL,
  `sale_price` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '1000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product_custimze_details`
--

CREATE TABLE `product_custimze_details` (
  `id` int NOT NULL,
  `pid` int NOT NULL,
  `pcustomize_title_id` int NOT NULL,
  `pcustomize_attribute_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `recent_view_product`
--

CREATE TABLE `recent_view_product` (
  `id` int NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `pid` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int NOT NULL,
  `percentage` decimal(10,2) NOT NULL,
  `shipping_charges` decimal(5,2) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `percentage`, `shipping_charges`, `timezone`, `start_time`, `end_time`) VALUES
(1, 0.00, 0.00, 'Asia/Kolkata', '08:00', '23:59');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` int NOT NULL,
  `display_order_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `payment_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_phone` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `method` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `paid_amt` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `order_amt` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `random` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `display_order_id`, `payment_id`, `payment_status`, `user_id`, `user_email`, `user_phone`, `method`, `created_at`, `paid_amt`, `order_amt`, `random`, `transaction_id`) VALUES
(13, '202410261138442', '', '', '32', '', '', '', '2024-10-26 11:38:46', '', '414', 'fY75o18lmQ', 'cs_test_a1YqIrE8On6oKMbf5aSjrABA4cJDQgtxtvO1EeUlLUY58klg0GGsy45DRt'),
(14, '202410261145093', 'pi_3QE3HWRxqwM6qTPu0ozO2wpJ', 'paid', '32', 'girish@persausive.com', '', '', '2024-10-26 11:45:10', '414', '414', 'bEiisyhzuF', 'cs_test_a17SzL1qDaobyzermZmfDKr8OEvzKWz4R349GJWaf3Ndqw9cEe8pAiT6bw'),
(15, '202410261149544', 'pi_3QE3MBRxqwM6qTPu0Ph9EK9S', 'paid', '32', 'girish@persausive.com', '', '', '2024-10-26 11:49:55', '311', '311', 'UzPKGjE4mf', 'cs_test_a1PmOsBs0S0ltlBwzSv29rLJXoHUbqbtTiR5STYfMh2eJf9Eeb1xOdDCtU'),
(16, '202410261151515', 'pi_3QE3O1RxqwM6qTPu0UwoMfQw', 'paid', '32', 'girish@persausive.com', '', '', '2024-10-26 11:51:52', '136', '136', 'TrFAjtIXcj', 'cs_test_a1xvCGiCk0IXW317p5tefDO3Vd7ct2RKks599c6EJQIxV300FsHfVEc06T'),
(17, '202410261153216', '', 'unpaid', '32', '', '', '', '2024-10-26 11:53:23', '', '1387', 'Hl7CuJbTC9', 'cs_test_a1RzgzQcWqKvNrzvWDthIc6CqbJqWYBKmdhacUBep5y0uwMAJyujXLMpMn'),
(18, '202410261201057', '', 'unpaid', '32', '', '', '', '2024-10-26 12:01:06', '', '6956', 'HvDlNMlbhG', 'cs_test_a15Jl22OJJkoW6ItofpAI1cStMpvIytoKJAHluffPXCl4HhAVODzYUZ0jr'),
(19, '202411131046479', 'pi_3QKYx3RxqwM6qTPu0kNKo0BM', 'paid', '32', 'girish@persausive.com', '', '', '2024-11-13 10:46:49', '253', '253', 'B22Tcl0CHa', 'cs_test_a1YBAAnTAnTJzl1IeiAeo2pH2Fe1XK8ByJuEmu8a5hA4qliy5bINr1xNxN');

-- --------------------------------------------------------

--
-- Table structure for table `user_account_delete`
--

CREATE TABLE `user_account_delete` (
  `id` int NOT NULL,
  `uid` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `created_date` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_address`
--

CREATE TABLE `user_address` (
  `id` int NOT NULL,
  `user_id` int NOT NULL DEFAULT '0',
  `receiver_name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `receiver_number` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `receiver_email` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `vila_flat_number` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `address_lat` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `address_lng` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `landmark` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `place_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_date` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `user_address`
--

INSERT INTO `user_address` (`id`, `user_id`, `receiver_name`, `receiver_number`, `receiver_email`, `city`, `area`, `vila_flat_number`, `address`, `address_lat`, `address_lng`, `landmark`, `place_id`, `created_date`) VALUES
(1, 32, 'Girish Bhumkar', '8149169115', 'girishbhumkar5@gmail.com', 'Pune', 'area', 'Flat number 11', 'MH', '18.654', '73.654', 'Kedgaon ahmednagar', '', '2024/08/28 15:12:01'),
(25, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:41:51'),
(26, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:43:51'),
(27, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:44:38'),
(28, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:44:54'),
(29, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:45:30'),
(30, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:45:47'),
(31, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:45:58'),
(32, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:46:26'),
(33, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:46:43'),
(34, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:46:58'),
(35, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:47:56'),
(36, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:48:50'),
(37, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:49:18'),
(38, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 16:49:28'),
(39, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 17:09:33'),
(40, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 17:12:00'),
(41, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kothrud, Pune, Maharashtra, India', '18.5073514', '73.8076543', 'Ndndndjjd', 'ChIJnYSvMre_wjsR8ET-s0iLB9Q', '2024/10/25 17:26:57'),
(42, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kothrud, Pune, Maharashtra, India', '18.5073514', '73.8076543', 'Ndndndjjd', 'ChIJnYSvMre_wjsR8ET-s0iLB9Q', '2024/10/25 17:27:18'),
(43, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 18:02:06'),
(44, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Ndndndjjd', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 18:03:11'),
(45, 32, 'Ty I', '83837737383737', 'girish@persausive.com', '', '', '', 'Kothrud, Pune, Maharashtra, India', '18.5073514', '73.8076543', 'Ndndndjjd', 'ChIJnYSvMre_wjsR8ET-s0iLB9Q', '2024/10/25 18:08:41'),
(46, 32, 'Girish', '81491691115', 'girish@gmail.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Mue', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 18:11:52'),
(47, 32, 'Girish', '81491691115', 'girish@gmail.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Mue', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 18:12:18'),
(48, 32, 'Girish', '81491691115', 'girish@gmail.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Mue', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 18:13:23'),
(49, 32, 'Girish', '81491691115', 'girish@gmail.com', '', '', '', 'Gesundbrunnen, Berlin, Germany', '52.5523454', '13.381467', 'Mue', 'ChIJW8YNHjtSqEcRoBHFVBY5skY', '2024/10/25 18:17:43'),
(50, 32, 'Girish', '81491691115', 'girish@gmail.com', '', '', '', 'Delhi, India', '28.7040592', '77.10249019999999', 'Mue', 'ChIJLbZ-NFv9DDkRQJY4FbcFcgM', '2024/10/25 18:18:08'),
(51, 32, 'Girish', '81491691115', 'girish@gmail.com', '', '', '', 'Delhi, India', '28.7040592', '77.10249019999999', 'Mue', 'ChIJLbZ-NFv9DDkRQJY4FbcFcgM', '2024/10/25 18:21:57'),
(52, 32, 'Girish', '81491691115', 'girish@gmail.com', '', '', '', 'Delhi, India', '28.7040592', '77.10249019999999', 'Mue', 'ChIJLbZ-NFv9DDkRQJY4FbcFcgM', '2024/10/25 18:22:09'),
(53, 32, 'Girish Bhumkar', '8149169115', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Near Rangoli Hotel', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/25 18:34:19'),
(54, 32, 'Girish Bhumkar', '8149169115', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Near Rangoli Hotel', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/26 11:38:44'),
(55, 32, 'Girish Bhumkar', '8149169115', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Near Rangoli Hotel', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/10/26 11:45:09'),
(56, 32, 'Girish Bhumkar', '8149169115', 'girish@persausive.com', '', '', '', 'Baner Road, Baner, Pune, Maharashtra, India', '18.5639861', '73.7816273', 'Near Rangoli Hotel', 'EilCYW5lciBSZCwgQmFuZXIsIFB1bmUsIE1haGFyYXNodHJhLCBJbmRpYSIuKiwKFAoSCeO-4N48v8I7EZjYAcSYNk2REhQKEgnL013wz77COxF9q3_7lxKRoQ', '2024/10/26 11:49:54'),
(57, 32, 'Girish Bhumkar', '8149169115', 'girish@persausive.com', '', '', '', 'Baner - Pashan Link Road, Pashan, Pune, Maharashtra, India', '18.5491346', '73.79128949999999', 'Near Rangoli Hotel', 'EjhCYW5lciAtIFBhc2hhbiBMaW5rIFJkLCBQYXNoYW4sIFB1bmUsIE1haGFyYXNodHJhLCBJbmRpYSIuKiwKFAoSCclL1jInv8I7EQYP7-4Ey-mnEhQKEglt5HmL477COxF-2Xc9Gr-lgw', '2024/10/26 11:51:51'),
(58, 32, 'Girish Bhumkar', '8149169115', 'girish@persausive.com', '', '', '', 'Delhi, India', '28.7040592', '77.10249019999999', 'Near Rangoli Hotel', 'ChIJLbZ-NFv9DDkRQJY4FbcFcgM', '2024/10/26 11:53:21'),
(59, 32, 'Girish Bhumkar', '8149169115', 'girish@persausive.com', '', '', '', 'Aachen, Germany', '50.7753455', '6.083886800000001', 'Near Rangoli Hotel', 'ChIJHRmKsHyZwEcRT0QOC64Oo2M', '2024/10/26 12:01:05'),
(60, 32, 'Girish Bhumkar', '8149169115', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Near Rangoli Hotel', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/11/13 10:10:07'),
(61, 32, 'Girish Bhumkar', '8149169115', 'girish@persausive.com', '', '', '', 'Kedgaon, Ahmednagar, Maharashtra, India', '19.0645141', '74.70894489999999', 'Near Rangoli Hotel', 'ChIJs-UaAiGx3DsR27UzbuRtwtY', '2024/11/13 10:46:47'),
(62, 0, 'asd', '8149169555', 'asd@sad.asd', '', '', '', 'asdas', '18.1231', '74.6544', 'asd', 'place_12313', '2024/11/19 11:08:16'),
(63, 0, 'asd', '8149169555', 'asd@sad.asd', '', '', '', 'asdas', '18.1231', '74.6544', 'asd', 'place_12313', '2024/11/19 11:09:07'),
(64, 0, 'asd', '8149169555', 'asd@sad.asd', '', '', '', 'asdas', '18.1231', '74.6544', 'asd', 'place_12313', '2024/11/19 11:09:34'),
(65, 0, 'asd', '8149169555', 'asd@sad.asd', '', '', '', 'asdas', '', '', 'asd', '', '2024/11/19 11:12:21'),
(66, 0, 'asd', '8149169555', 'asd@sad.asd', '', '', '', 'asdas', '', '', 'asd', '', '2024/11/19 11:15:09'),
(67, 0, 'asd', '8149169555', 'asd@sad.asd', '', '', '', 'asdas', '', '', 'asd', '', '2024/11/19 11:16:17'),
(68, 0, 'asd', '8149169555', 'asd@sad.asd', '', '', '', 'asdas', '', '', 'asd', '', '2024/11/19 11:16:45'),
(69, 0, 'Girish Bhumkar', '8149169115', 'girish@gmail.com', '', '', '', 'Kedgaon', '', '', 'Ahmednagar', 'place_12313', '2024/11/19 11:19:27'),
(70, 0, 'Girish', '8149169115', 'girish@persausive.com', '', '', '', 'Suchetanagar, Bhushannagar, Kedgaon Ahmednagar', '', '', 'Near Bhandari Chauk', 'place_12313', '2024/11/21 10:07:57'),
(71, 0, 'huzefa', '0503222728', 'mhozayfa@hotmail.com', '', '', '', 'hih', '', '', 'bjhghjhj', 'place_12313', '2025/01/13 16:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_rating`
--

CREATE TABLE `user_rating` (
  `id` int NOT NULL,
  `order_id` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `uid` int NOT NULL DEFAULT '0',
  `pid` int NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `rating` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `comment` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'product',
  `status` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_date` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `updated_date` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `user_rating`
--

INSERT INTO `user_rating` (`id`, `order_id`, `uid`, `pid`, `name`, `rating`, `title`, `comment`, `type`, `status`, `created_date`, `updated_date`) VALUES
(7, '2024080113033911', 32, 17, 'Girish Bhumkar ', '5', 'Hello', 'Comment', 'product', 'accept', '2024/08/02 10:34:18', '2024/08/02 11:26:36'),
(10, '2024080113033911', 32, 18, 'Girish Bhumkar ', '5', 'Hello', 'as asda', 'product', 'accept', '2024/08/02 11:19:02', '2024/08/02 11:26:23'),
(12, '', 36, 18, 'Aarav', '1', 'asd', 'asd', 'product', 'accept', '2024/08/02 11:21:40', '2024/08/02 11:26:31'),
(13, '2024091114210261', 32, 38, 'Girish Bhumkar ', '4', 'G', 's sdf', 'product', 'pending', '2024/10/23 16:14:47', ''),
(14, '2024091114210261', 32, 38, 'Girish Bhumkar ', '5', 'asd', 'asd asd', 'product', 'pending', '2024/10/23 16:14:54', '');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` int NOT NULL,
  `code` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `start_date` varchar(80) COLLATE utf8mb3_unicode_ci NOT NULL,
  `end_date` varchar(80) COLLATE utf8mb3_unicode_ci NOT NULL,
  `status` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'active',
  `type` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'percent',
  `amount` decimal(6,2) NOT NULL,
  `min_amount_to_apply` int NOT NULL,
  `city_id` int NOT NULL,
  `payment_method` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb3_unicode_ci NOT NULL,
  `title` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_date` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `updated_date` varchar(25) COLLATE utf8mb3_unicode_ci NOT NULL,
  `max_discount` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `private_coupon` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `use_type` varchar(11) COLLATE utf8mb3_unicode_ci NOT NULL DEFAULT 'one'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`id`, `code`, `start_date`, `end_date`, `status`, `type`, `amount`, `min_amount_to_apply`, `city_id`, `payment_method`, `description`, `title`, `created_date`, `updated_date`, `max_discount`, `private_coupon`, `use_type`) VALUES
(6, 'GRB', '', '', 'Active', 'percent', 3.00, 10, 4, 'both', 'Sumaiya Mehboob  (3% Discount)', 'Sumaiya Mehboob ', '2023/03/21 14:46:58', '2024/02/28 10:54:49', '', 'yes', 'multiple'),
(11, 'GB', '', '', 'Active', 'flat', 100.00, 100, 0, 'both', '', '', '2024/02/28 10:47:14', '2024/07/31 10:51:19', '', 'yes', 'one'),
(12, 'GIRI40%', '', '', 'Active', 'percent', 40.00, 0, 0, 'both', '', 'Get 40% OFF', '2024/07/31 10:50:31', '', '', 'no', 'one'),
(13, '1 off', '2024-08-27', '2024-09-29', 'Active', 'flat', 1.00, 5, 0, 'both', '1  off', '1  off', '2024/08/29 18:58:56', '2024/09/10 15:53:13', '', 'yes', 'multiple');

-- --------------------------------------------------------

--
-- Table structure for table `wing_list`
--

CREATE TABLE `wing_list` (
  `id` int NOT NULL,
  `building_id` varchar(255) NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `wing_name` varchar(255) NOT NULL,
  `created_date` varchar(25) NOT NULL,
  `status` varchar(11) NOT NULL DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute`
--
ALTER TABLE `attribute`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_item`
--
ALTER TABLE `attribute_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banner`
--
ALTER TABLE `banner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `building_list`
--
ALTER TABLE `building_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `building_name`
--
ALTER TABLE `building_name`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `building_wise`
--
ALTER TABLE `building_wise`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_page`
--
ALTER TABLE `contact_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cron_notification`
--
ALTER TABLE `cron_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_slot`
--
ALTER TABLE `delivery_slot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_slot_time`
--
ALTER TABLE `delivery_slot_time`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items_extra_data`
--
ALTER TABLE `items_extra_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `json_request`
--
ALTER TABLE `json_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `my_cart`
--
ALTER TABLE `my_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_comment`
--
ALTER TABLE `order_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_email_notification`
--
ALTER TABLE `order_email_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_invoice`
--
ALTER TABLE `order_invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `order_master`
--
ALTER TABLE `order_master`
  ADD PRIMARY KEY (`order_master_id`);

--
-- Indexes for table `otp_list`
--
ALTER TABLE `otp_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `our_supplies`
--
ALTER TABLE `our_supplies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pcustomize_title`
--
ALTER TABLE `pcustomize_title`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_attribute`
--
ALTER TABLE `product_attribute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_id` (`attribute_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `product_custimze_details`
--
ALTER TABLE `product_custimze_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recent_view_product`
--
ALTER TABLE `recent_view_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_account_delete`
--
ALTER TABLE `user_account_delete`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_address`
--
ALTER TABLE `user_address`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_rating`
--
ALTER TABLE `user_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wing_list`
--
ALTER TABLE `wing_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `attribute`
--
ALTER TABLE `attribute`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `attribute_item`
--
ALTER TABLE `attribute_item`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `banner`
--
ALTER TABLE `banner`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `building_list`
--
ALTER TABLE `building_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `building_name`
--
ALTER TABLE `building_name`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `contact_page`
--
ALTER TABLE `contact_page`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cron_notification`
--
ALTER TABLE `cron_notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_slot`
--
ALTER TABLE `delivery_slot`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `delivery_slot_time`
--
ALTER TABLE `delivery_slot_time`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `json_request`
--
ALTER TABLE `json_request`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `my_cart`
--
ALTER TABLE `my_cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_comment`
--
ALTER TABLE `order_comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_email_notification`
--
ALTER TABLE `order_email_notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_invoice`
--
ALTER TABLE `order_invoice`
  MODIFY `invoice_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `order_master`
--
ALTER TABLE `order_master`
  MODIFY `order_master_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `otp_list`
--
ALTER TABLE `otp_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `our_supplies`
--
ALTER TABLE `our_supplies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT for table `product_attribute`
--
ALTER TABLE `product_attribute`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_custimze_details`
--
ALTER TABLE `product_custimze_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recent_view_product`
--
ALTER TABLE `recent_view_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_account_delete`
--
ALTER TABLE `user_account_delete`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_address`
--
ALTER TABLE `user_address`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `user_rating`
--
ALTER TABLE `user_rating`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wing_list`
--
ALTER TABLE `wing_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

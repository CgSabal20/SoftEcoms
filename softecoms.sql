-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2026 at 12:14 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `softecoms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_changelog`
--

CREATE TABLE `admin_changelog` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `action_type` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_changelog`
--

INSERT INTO `admin_changelog` (`id`, `admin_id`, `action_type`, `description`, `created_at`) VALUES
(1, 2, 'order_update', 'he updated the order to success', '2026-05-10 00:10:29'),
(2, 2, 'ORDER_UPDATE', 'Changed order CO00058 status to completed', '2026-05-10 00:12:47'),
(3, 1, 'LOGIN', 'Admin logged into the system', '2026-05-10 00:18:58'),
(4, 1, 'LOGIN', 'Admin logged into the system', '2026-05-10 00:20:43'),
(5, 1, 'LOGOUT', 'Admin logged out of the system', '2026-05-10 00:23:41'),
(6, 2, 'LOGIN', 'Admin logged into the system', '2026-05-14 06:39:58'),
(7, 2, 'ORDER_UPDATE', 'Changed order CO00061 status to pending', '2026-05-14 06:40:17'),
(8, 2, 'LOGOUT', 'Admin logged out of the system', '2026-05-14 06:40:41'),
(9, 12, 'LOGOUT', 'Admin logged out of the system', '2026-05-17 06:29:18'),
(10, 1, 'LOGIN', 'Admin logged into the system', '2026-05-19 03:02:19'),
(11, 1, 'LOGIN', 'Admin logged into the system', '2026-05-19 04:45:38'),
(12, 1, 'LOGOUT', 'Admin logged out of the system', '2026-05-19 04:55:59'),
(13, 1, 'LOGIN', 'Admin logged into the system', '2026-05-19 10:38:05'),
(14, 1, 'ORDER_UPDATE', 'Changed order CO00066 status to cancelled', '2026-05-19 10:41:20'),
(15, 1, 'ORDER_UPDATE', 'Changed order CO00066 status to pending', '2026-05-19 10:41:54'),
(16, 1, 'ORDER_UPDATE', 'Changed order CO00066 status to completed', '2026-05-19 10:41:56'),
(17, 1, 'ORDER_UPDATE', 'Changed order CO00066 status to cancelled', '2026-05-19 10:41:58'),
(18, 1, 'ORDER_UPDATE', 'Changed order CO00065 status to cancelled', '2026-05-19 10:42:00'),
(19, 1, 'ORDER_UPDATE', 'Changed order CO00064 status to cancelled', '2026-05-19 10:42:02'),
(20, 1, 'ORDER_UPDATE', 'Changed order CO00063 status to cancelled', '2026-05-19 10:42:03'),
(21, 1, 'ORDER_UPDATE', 'Changed order CO00061 status to cancelled', '2026-05-19 10:42:05'),
(22, 1, 'ORDER_UPDATE', 'Changed order CO00061 status to completed', '2026-05-19 10:42:17'),
(23, 1, 'ORDER_UPDATE', 'Changed order CO00061 status to pending', '2026-05-19 10:42:18'),
(24, 1, 'ORDER_UPDATE', 'Changed order CO00061 status to completed', '2026-05-19 10:42:20'),
(25, 1, 'ORDER_UPDATE', 'Changed order CO00061 status to pending', '2026-05-19 10:42:21'),
(26, 1, 'ORDER_UPDATE', 'Changed order CO00061 status to cancelled', '2026-05-19 10:42:22'),
(27, 1, 'ORDER_UPDATE', 'Changed order CO00061 status to pending', '2026-05-19 10:42:23'),
(28, 1, 'ORDER_UPDATE', 'Changed order CO00067 status to completed', '2026-05-19 13:20:44'),
(29, 1, 'ORDER_UPDATE', 'Changed order CO00067 status to pending', '2026-05-19 13:20:45'),
(30, 1, 'LOGIN', 'Admin logged into the system', '2026-05-21 18:03:21'),
(31, 1, 'ORDER_UPDATE', 'Changed order CO00068 status to completed', '2026-05-21 18:06:41'),
(32, 1, 'LOGIN', 'Admin logged into the system', '2026-05-21 18:13:59'),
(33, 1, 'ORDER_UPDATE', 'Changed order CO00068 status to cancelled', '2026-05-21 18:14:07'),
(34, 1, 'LOGOUT', 'Admin logged out of the system', '2026-05-21 18:16:54'),
(35, 1, 'LOGIN', 'Admin logged into the system', '2026-05-21 18:20:40'),
(36, 1, 'ORDER_UPDATE', 'Changed order CO00063 status to completed', '2026-05-21 18:39:08'),
(37, 1, 'ORDER_UPDATE', 'Changed order CO00064 status to completed', '2026-05-21 18:39:10'),
(38, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:34:12'),
(39, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:34:45'),
(40, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:34:56'),
(41, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:35:22'),
(42, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:35:25'),
(43, 1, 'ORDER_UPDATE', 'Changed order CO00068 status to completed', '2026-05-21 21:35:35'),
(44, 1, 'ORDER_UPDATE', 'Changed order CO00067 status to completed', '2026-05-21 21:35:37'),
(45, 1, 'ORDER_UPDATE', 'Changed order CO00066 status to completed', '2026-05-21 21:35:38'),
(46, 1, 'ORDER_UPDATE', 'Changed order CO00065 status to completed', '2026-05-21 21:35:39'),
(47, 1, 'ORDER_UPDATE', 'Changed order CO00062 status to completed', '2026-05-21 21:36:01'),
(48, 1, 'ORDER_UPDATE', 'Changed order CO00061 status to completed', '2026-05-21 21:36:02'),
(49, 1, 'ORDER_UPDATE', 'Changed order CO00054 status to completed', '2026-05-21 21:36:24'),
(50, 1, 'ORDER_UPDATE', 'Changed order CO00053 status to completed', '2026-05-21 21:36:36'),
(51, 1, 'ORDER_UPDATE', 'Changed order CO00069 status to completed', '2026-05-21 21:37:47'),
(52, 1, 'ORDER_UPDATE', 'Changed order CO00070 status to completed', '2026-05-21 21:38:24'),
(53, 1, 'ORDER_UPDATE', 'Changed order CO00071 status to completed', '2026-05-21 21:38:25'),
(54, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:38:59'),
(55, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:39:02'),
(56, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:39:04'),
(57, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:39:06'),
(58, 1, 'ORDER_UPDATE', 'Changed order 0 status to completed', '2026-05-21 21:39:09'),
(59, 1, 'LOGOUT', 'Admin logged out of the system', '2026-05-22 04:02:05'),
(60, 1, 'LOGIN', 'Admin logged into the system', '2026-05-28 04:38:52'),
(61, 1, 'ORDER_UPDATE', 'Changed order CO00072 status to completed', '2026-05-28 04:46:51'),
(62, 1, 'LOGIN', 'Admin logged into the system', '2026-05-29 04:13:52'),
(63, 1, 'LOGOUT', 'Admin logged out of the system', '2026-05-29 04:15:53'),
(64, 1, 'LOGIN', 'Admin logged into the system', '2026-05-29 04:16:21'),
(65, 1, 'LOGOUT', 'Admin logged out of the system', '2026-05-29 04:16:36'),
(66, 1, 'LOGIN', 'Admin logged into the system', '2026-05-29 04:20:39'),
(68, 1, 'UPDATE', 'Updated customer profile: samsfasfasfsaf roque and changed password', '2026-05-29 04:23:03'),
(69, 1, 'UPDATE', 'Updated customer profile: samsfasfasfsaf roque and changed password', '2026-05-29 04:23:17'),
(70, 1, 'UPDATE', 'Updated customer profile: sam roque and changed password', '2026-05-29 04:23:40'),
(71, 1, 'LOGOUT', 'Admin logged out of the system', '2026-05-29 04:27:47'),
(72, 1, 'LOGIN', 'Admin logged into the system', '2026-05-29 04:47:07'),
(73, 1, 'ORDER_UPDATE', 'Changed order CO00074 status to completed', '2026-05-29 04:47:41'),
(74, 1, 'UPDATE', 'Updated customer profile: sammmss roque', '2026-05-29 04:48:34'),
(75, 1, 'LOGOUT', 'Admin logged out of the system', '2026-05-29 04:50:22'),
(76, 1, 'LOGIN', 'Admin logged into the system', '2026-09-02 13:02:36'),
(77, 1, 'LOGOUT', 'Admin logged out of the system', '2026-09-02 13:11:53'),
(78, 2, 'LOGIN', 'Admin logged into the system', '2026-09-02 13:12:32'),
(79, 2, 'LOGOUT', 'Admin logged out of the system', '2026-09-02 13:12:51'),
(80, 1, 'LOGIN', 'Admin logged into the system', '2026-09-02 13:14:55'),
(81, 1, 'LOGIN', 'Admin logged into the system', '2026-09-02 19:46:56'),
(82, 1, 'LOGIN', 'Admin logged into the system', '2026-09-09 18:56:03'),
(83, 1, 'LOGOUT', 'Admin logged out of the system', '2026-09-09 19:10:25'),
(84, 1, 'LOGIN', 'Admin logged into the system', '2026-09-17 04:36:18'),
(85, 1, 'ORDER_UPDATE', 'Changed order CO00075 status to completed', '2026-09-17 04:53:12'),
(86, 1, 'LOGOUT', 'Admin logged out of the system', '2026-09-17 04:55:04');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(5, 19, 2, 2),
(118, 7, 3, 3),
(121, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `userId`, `firstName`, `lastName`, `email`, `subject`, `message`, `created_at`) VALUES
(1, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'fa', 'fa', '2026-05-20 13:59:27'),
(2, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'fa', 'fa', '2026-05-20 13:59:30'),
(3, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'fa', 'fa', '2026-05-20 15:13:40'),
(4, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', '', 'fa', '2026-05-20 15:13:42'),
(5, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'fa', 'faff', '2026-05-20 15:13:44'),
(6, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'fa', 'fa', '2026-05-20 15:14:45'),
(7, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'ga', 'ga', '2026-05-20 15:15:04'),
(8, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'hahahah', 'ahaha', '2026-05-20 15:15:07'),
(9, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'fa', 'fa', '2026-05-20 15:23:17'),
(10, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'fa', 'fa', '2026-05-20 15:23:20'),
(11, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'fa', 'fa', '2026-05-20 15:24:27'),
(12, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'goodwow', 'wow', '2026-05-21 18:03:00'),
(13, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'fafa', 'fafafafa', '2026-05-28 04:54:37'),
(14, 12, 'samsfasfasfsaf', 'roque', 'sammy12@gmail.com', 'wow', 'product good', '2026-05-28 04:55:13'),
(15, 22, 'sam', 'roque', 'marjons@gmail.com', 'Nice!', 'chada kag product woah', '2026-05-29 04:46:08');

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 2, 2, 3, 0.00),
(2, 2, 1, 1, 0.00),
(3, 2, 3, 1, 0.00),
(4, 3, 1, 1, 0.00),
(5, 3, 6, 1, 0.00),
(6, 4, 2, 3, 0.00),
(9, 9, 2, 1, 130.00),
(10, 10, 1, 1, 120.00),
(11, 10, 3, 4, 140.00),
(12, 11, 2, 1, 0.00),
(13, 11, 8, 3, 0.00),
(14, 12, 7, 3, 420.00),
(15, 13, 7, 1, 140.00),
(16, 14, 2, 3, 390.00),
(17, 14, 7, 2, 280.00),
(18, 14, 1, 2, 240.00),
(19, 14, 6, 3, 450.00),
(20, 15, 2, 3, 390.00),
(21, 15, 6, 3, 450.00),
(22, 16, 4, 3, 405.00),
(23, 17, 2, 1, 130.00),
(24, 18, 2, 2, 260.00),
(25, 19, 3, 1, 140.00),
(26, 20, 3, 5, 700.00),
(27, 21, 2, 4, 520.00),
(28, 22, 2, 13, 1690.00),
(29, 22, 6, 1, 150.00),
(30, 24, 3, 1, 140.00),
(31, 25, 3, 1, 140.00),
(32, 26, 3, 1, 140.00),
(33, 28, 3, 1, 140.00),
(34, 29, 2, 3, 390.00),
(35, 30, 3, 1, 140.00),
(36, 31, 2, 1, 130.00),
(37, 31, 3, 1, 140.00),
(38, 32, 2, 1, 130.00),
(39, 33, 1, 1, 120.00),
(40, 34, 2, 1, 130.00),
(41, 35, 3, 1, 140.00),
(42, 36, 3, 1, 140.00),
(43, 37, 3, 1, 140.00),
(44, 38, 3, 1, 140.00),
(45, 39, 2, 3, 130.00),
(46, 40, 2, 1, 130.00),
(47, 41, 3, 1, 140.00),
(48, 41, 2, 1, 130.00),
(49, 41, 1, 1, 120.00),
(50, 42, 2, 2, 130.00),
(51, 43, 3, 1, 140.00),
(52, 43, 1, 1, 120.00),
(53, 43, 4, 1, 135.00),
(54, 44, 3, 1, 140.00),
(55, 45, 3, 1, 140.00),
(56, 46, 3, 1, 140.00),
(57, 47, 4, 5, 135.00),
(58, 48, 2, 2, 130.00),
(59, 49, 2, 1, 130.00),
(60, 50, 2, 1, 130.00),
(61, 51, 3, 1, 140.00),
(62, 52, 3, 4, 140.00),
(63, 53, 2, 2, 130.00),
(64, 53, 1, 3, 120.00),
(65, 54, 3, 2, 140.00),
(66, 55, 3, 1, 140.00),
(67, 57, 2, 1, 130.00),
(68, 58, 7, 3, 140.00),
(69, 59, 3, 2, 140.00),
(70, 60, 4, 3, 135.00),
(71, 61, 5, 3, 145.00),
(72, 62, 2, 3, 130.00),
(73, 63, 2, 1, 130.00),
(74, 64, 2, 2, 130.00),
(75, 66, 2, 1, 130.00),
(76, 67, 2, 2, 130.00),
(77, 68, 3, 1, 140.00),
(78, 68, 2, 1, 130.00),
(79, 69, 2, 2, 130.00),
(80, 70, 4, 1, 135.00),
(81, 71, 5, 2, 145.00),
(82, 72, 10, 1, 120.00),
(83, 73, 2, 1, 130.00),
(84, 74, 2, 7, 130.00),
(85, 75, 2, 1, 130.00),
(86, 76, 2, 2, 130.00),
(87, 76, 1, 3, 120.00),
(88, 76, 3, 3, 140.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `COnumber` varchar(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contactNumber` varchar(20) DEFAULT NULL,
  `paymentMethod` varchar(50) DEFAULT NULL,
  `status` enum('pending','cancelled','completed','') DEFAULT 'pending',
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `subtotal` decimal(10,2) DEFAULT NULL,
  `tax` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `uuid`, `COnumber`, `user_id`, `totalPrice`, `address`, `contactNumber`, `paymentMethod`, `status`, `DateCreated`, `subtotal`, `tax`) VALUES
(1, '95725fd5-51d7-11f1-b3aa-d843aec840f7', '0', 12, 715.00, 'nazareth, nazareth, cdo', '0905212451', '', 'completed', '2026-04-13 19:32:39', NULL, NULL),
(2, '95726e6d-51d7-11f1-b3aa-d843aec840f7', '0', 12, 715.00, 'pabayo hayes', '0905212451', '', 'completed', '2026-04-13 19:33:10', NULL, NULL),
(3, '95726eec-51d7-11f1-b3aa-d843aec840f7', '0', 12, 297.00, 'pabayo hayes', '0905212451', '', 'completed', '2026-04-13 19:38:12', NULL, NULL),
(4, '95726f2e-51d7-11f1-b3aa-d843aec840f7', '0', 12, 429.00, 'pabayo hayes', '0905212451', 'gcash', 'completed', '2026-04-13 19:42:19', NULL, NULL),
(5, '95726f6b-51d7-11f1-b3aa-d843aec840f7', '0', 12, 143.00, 'pabayo hayes', '0905212451', 'Cash on delievery', 'completed', '2026-04-13 19:47:01', NULL, NULL),
(6, '95726fb0-51d7-11f1-b3aa-d843aec840f7', '0', 12, 143.00, 'pabayo hayes', '0905212451', 'Cash on delievery', 'completed', '2026-04-13 19:48:30', NULL, NULL),
(7, '95726fe6-51d7-11f1-b3aa-d843aec840f7', '0', 12, 143.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'completed', '2026-04-13 19:49:44', NULL, NULL),
(8, '95727019-51d7-11f1-b3aa-d843aec840f7', '0', 12, 143.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'completed', '2026-04-13 19:51:31', NULL, NULL),
(9, '95727048-51d7-11f1-b3aa-d843aec840f7', '0', 12, 143.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'completed', '2026-04-13 19:53:02', NULL, NULL),
(10, '9572707b-51d7-11f1-b3aa-d843aec840f7', '0', 12, 748.00, 'nazareth, nazareth, cdo', '0905212451', 'COD', 'completed', '2026-04-13 19:53:35', NULL, NULL),
(11, '957270af-51d7-11f1-b3aa-d843aec840f7', '0', 12, 638.00, 'nazareth, nazareth, cdo', '0905212451', 'COD', 'pending', '2026-04-13 20:00:16', NULL, NULL),
(12, '957270df-51d7-11f1-b3aa-d843aec840f7', 'CO00012', 12, 462.00, 'nazareth, nazareth, cdo', '0905212451', 'cod', 'pending', '2026-04-13 20:02:49', NULL, NULL),
(13, '95727113-51d7-11f1-b3aa-d843aec840f7', 'CO00013', 12, 0.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'pending', '2026-04-17 19:44:48', NULL, NULL),
(14, '95727146-51d7-11f1-b3aa-d843aec840f7', 'CO00014', 12, 0.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'pending', '2026-04-17 20:04:42', NULL, NULL),
(15, '95727176-51d7-11f1-b3aa-d843aec840f7', 'CO00015', 12, 0.00, 'nazareth, nazareth, cdo', '0905212451', 'cash', 'pending', '2026-04-17 20:07:38', NULL, NULL),
(16, '957271a7-51d7-11f1-b3aa-d843aec840f7', 'CO00016', 12, 0.00, 'nazareth, nazareth, cdo', '0905212451', 'cash', 'pending', '2026-04-17 20:08:33', NULL, NULL),
(17, '957271d9-51d7-11f1-b3aa-d843aec840f7', 'CO00017', 12, 0.00, 'nazareth, nazareth, cdo', '0905212451', 'cash', 'pending', '2026-04-17 20:12:56', NULL, NULL),
(18, '9572720b-51d7-11f1-b3aa-d843aec840f7', 'CO00018', 20, 0.00, 'nazareth, nazareth, cdo', '901209421042', 'cash', 'pending', '2026-04-17 21:27:49', NULL, NULL),
(19, '9572723d-51d7-11f1-b3aa-d843aec840f7', 'CO00019', 20, 0.00, 'nazareth, nazareth, cdo', '901209421042', 'cash', 'pending', '2026-04-17 21:31:39', NULL, NULL),
(20, '95727272-51d7-11f1-b3aa-d843aec840f7', 'CO00020', 12, 0.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'pending', '2026-04-21 05:58:00', NULL, NULL),
(21, '957272a6-51d7-11f1-b3aa-d843aec840f7', 'CO00021', 12, 572.00, 'nazareth, nazareth, cdo', '0905212451', 'gcash', 'pending', '2026-04-21 06:17:04', NULL, NULL),
(22, '957272d6-51d7-11f1-b3aa-d843aec840f7', 'CO00022', 1, 2024.00, 'tomasaco, nazareto, cdo', '0941249012', 'Cash on delievery', 'pending', '2026-04-24 18:31:47', NULL, NULL),
(23, '9572730d-51d7-11f1-b3aa-d843aec840f7', 'CO00023', 1, 0.00, 'tomasaco, nazareto, cdo', '0941249012', '', 'pending', '2026-04-24 18:33:22', NULL, NULL),
(24, '95727341-51d7-11f1-b3aa-d843aec840f7', 'CO00024', 1, 154.00, 'tomasaco, manok, cdo', '0941249012', 'cashj', 'pending', '2026-04-24 19:50:13', NULL, NULL),
(25, '95727374-51d7-11f1-b3aa-d843aec840f7', 'CO00025', 1, 154.00, 'tomasaco, manok, cdo', '0941249012', '', 'pending', '2026-04-24 19:50:38', NULL, NULL),
(26, '957273a5-51d7-11f1-b3aa-d843aec840f7', 'CO00026', 1, 154.00, 'tomasaco, manok, cdo', '0941249012', '', 'pending', '2026-04-24 19:53:30', NULL, NULL),
(27, '957273d5-51d7-11f1-b3aa-d843aec840f7', 'CO00027', 1, 0.00, 'tomasaco, manok, cdo', '0941249012', 'cash', 'pending', '2026-04-24 19:53:40', NULL, NULL),
(28, '95727403-51d7-11f1-b3aa-d843aec840f7', 'CO00028', 1, 154.00, 'tomasaco, manok, cdo', '0941249012', 'cash', 'pending', '2026-04-24 19:53:49', NULL, NULL),
(29, '95727431-51d7-11f1-b3aa-d843aec840f7', 'CO00029', 1, 429.00, 'tomasaco, manok, cdo', '0941249012', 'cash', 'pending', '2026-04-24 19:54:23', NULL, NULL),
(30, '95727461-51d7-11f1-b3aa-d843aec840f7', 'CO00030', 1, 154.00, 'tomasaco, manok, cdo', '0941249012', '', 'completed', '2026-04-24 19:54:52', NULL, NULL),
(31, '95727490-51d7-11f1-b3aa-d843aec840f7', 'CO00031', 12, 297.00, 'cdo, cdo, cdo', '0894012421', '', 'pending', '2026-04-24 20:02:04', NULL, NULL),
(32, '957274bf-51d7-11f1-b3aa-d843aec840f7', 'CO00032', 12, 143.00, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-24 20:03:06', NULL, NULL),
(33, '957274ee-51d7-11f1-b3aa-d843aec840f7', 'CO00033', 12, 132.00, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-24 20:05:09', NULL, NULL),
(34, '9572752b-51d7-11f1-b3aa-d843aec840f7', 'CO00034', 12, 143.00, 'cdo, cdo, cdo', '0894012421', '', 'pending', '2026-04-24 20:08:48', NULL, NULL),
(35, '9572755a-51d7-11f1-b3aa-d843aec840f7', 'CO00035', 12, 154.00, 'cdo, cdo, cdo', '0894012421', '', 'pending', '2026-04-24 20:08:56', NULL, NULL),
(36, '95727588-51d7-11f1-b3aa-d843aec840f7', 'CO00036', 12, 154.00, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-24 20:09:41', NULL, NULL),
(37, '957275b7-51d7-11f1-b3aa-d843aec840f7', 'CO00037', 12, 154.00, 'cdo, cdo, cdo', '0894012421', '', 'pending', '2026-04-24 20:10:40', NULL, NULL),
(38, '957275e5-51d7-11f1-b3aa-d843aec840f7', 'CO00038', 12, 154.00, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-24 20:11:39', NULL, NULL),
(39, '95727613-51d7-11f1-b3aa-d843aec840f7', 'CO00039', 12, 429.00, 'cdo, cdo, cdo', '0894012421', 'gcash', 'pending', '2026-04-24 20:14:51', NULL, NULL),
(40, '95727644-51d7-11f1-b3aa-d843aec840f7', 'CO00040', 12, 143.00, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-24 20:15:12', NULL, NULL),
(41, '95727673-51d7-11f1-b3aa-d843aec840f7', 'CO00041', 12, 429.00, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-24 20:26:11', NULL, NULL),
(42, '957276a0-51d7-11f1-b3aa-d843aec840f7', 'CO00042', 12, 286.00, 'cdo, cdo, cdo', '0894012421', 'cash', 'completed', '2026-04-24 20:35:18', NULL, NULL),
(43, '957276ce-51d7-11f1-b3aa-d843aec840f7', 'CO00043', 12, 434.50, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-25 03:05:20', NULL, NULL),
(44, '957276fe-51d7-11f1-b3aa-d843aec840f7', 'CO00044', 12, 156.80, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-25 03:11:05', 140.00, 16.80),
(45, '95727732-51d7-11f1-b3aa-d843aec840f7', 'CO00045', 12, 156.80, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-25 03:13:10', 140.00, 16.80),
(46, '95727763-51d7-11f1-b3aa-d843aec840f7', 'CO00046', 12, 156.80, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-25 03:13:51', 140.00, 16.80),
(47, '95727791-51d7-11f1-b3aa-d843aec840f7', 'CO00047', 12, 756.00, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-25 03:14:29', 675.00, 81.00),
(48, '957277bf-51d7-11f1-b3aa-d843aec840f7', 'CO00048', 12, 291.20, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-27 18:01:07', 260.00, 31.20),
(49, '957277ed-51d7-11f1-b3aa-d843aec840f7', 'CO00049', 12, 145.60, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-04-30 04:30:33', 130.00, 15.60),
(50, '9572781b-51d7-11f1-b3aa-d843aec840f7', 'CO00050', 12, 145.60, 'cdo, cdo, cdo', '0894012421', 'cash', 'completed', '2026-04-30 04:50:35', 130.00, 15.60),
(51, '9572784a-51d7-11f1-b3aa-d843aec840f7', 'CO00051', 12, 156.80, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-05-05 08:31:33', 140.00, 16.80),
(52, '9572791b-51d7-11f1-b3aa-d843aec840f7', 'CO00052', 12, 627.20, 'cdo, cdo, cdo', '0894012421', 'cash', 'pending', '2026-05-05 08:32:44', 560.00, 67.20),
(53, '95727954-51d7-11f1-b3aa-d843aec840f7', 'CO00053', 12, 694.40, 'cdo, cdo, cdo', '0894012421', 'cash', 'completed', '2026-05-08 00:54:08', 620.00, 74.40),
(54, '95727983-51d7-11f1-b3aa-d843aec840f7', 'CO00054', 12, 313.60, 'cdo, cdo, cdo', '0894012421', 'gcash', 'completed', '2026-05-08 11:08:53', 280.00, 33.60),
(55, '957279b2-51d7-11f1-b3aa-d843aec840f7', 'CO00055', 12, 156.80, 'cdo, cdo, cdo', '0894012421', 'GCash', 'completed', '2026-05-08 12:42:18', 140.00, 16.80),
(56, '957279e0-51d7-11f1-b3aa-d843aec840f7', 'CO00056', 12, 0.00, 'cdo, cdo, cdo', '0894012421', 'GCash', 'completed', '2026-05-08 13:26:41', 0.00, 0.00),
(57, '95727a11-51d7-11f1-b3aa-d843aec840f7', 'CO00057', 12, 145.60, 'cdo, cdo, cdo', '0894012421', 'GCash', 'completed', '2026-05-08 13:28:13', 130.00, 15.60),
(58, '95727a41-51d7-11f1-b3aa-d843aec840f7', 'CO00058', 12, 470.40, 'cdo, cdo, cdo', '0894012421', 'Cash', 'completed', '2026-05-09 13:38:57', 420.00, 50.40),
(59, '95727b42-51d7-11f1-b3aa-d843aec840f7', 'CO00059', 12, 313.60, 'cdo, cdo, cdo', '0894012421', 'GCash', 'completed', '2026-05-09 17:02:25', 280.00, 33.60),
(60, '95727b8d-51d7-11f1-b3aa-d843aec840f7', 'CO00060', 1, 453.60, 'tomasaco, manok, cdo', '0941249012', 'GCash', 'completed', '2026-05-09 18:17:13', 405.00, 48.60),
(61, '95727bc5-51d7-11f1-b3aa-d843aec840f7', 'CO00061', 1, 487.20, 'tomasaco, manok, cdo', '0941249012', 'Cash', 'completed', '2026-05-09 18:18:41', 435.00, 52.20),
(62, '95727bfb-51d7-11f1-b3aa-d843aec840f7', 'CO00062', 12, 436.80, 'Nazareth, Cdo, cdo', '0894012421', 'Cash', 'completed', '2026-05-14 06:41:02', 390.00, 46.80),
(63, '95727c31-51d7-11f1-b3aa-d843aec840f7', 'CO00063', 12, 145.60, 'Nazareth, Cdo, cdo', '0894012421', 'Cash', 'completed', '2026-05-17 06:59:48', 130.00, 15.60),
(64, NULL, 'CO00064', 12, 291.20, 'Nazareth, Cdo, cdo', '0894012421', 'Cash', 'completed', '2026-05-17 10:05:59', 260.00, 31.20),
(65, 'f5ba9c65-7806-4092-b580-06972b6f7109', 'CO00065', 12, 0.00, 'Nazareth, Cdo, cdo', '0894012421', 'Cash', 'completed', '2026-05-17 10:07:15', 0.00, 0.00),
(66, 'e84eb6aa-1f89-4915-a739-e0fe444ed6d5', 'CO00066', 12, 145.60, 'Nazareth, Cdo, cdo', '0894012421', 'Cash', 'completed', '2026-05-17 10:12:52', 130.00, 15.60),
(67, '7ab70d6f-f50c-426d-a9d4-b937733315da', 'CO00067', 12, 291.20, 'Nazareth, Cdo, cdo', '0894012421', 'Cash', 'completed', '2026-05-19 03:11:51', 260.00, 31.20),
(68, '8904466b-a99e-46d0-acce-fa94265d5806', 'CO00068', 12, 302.40, 'Nazareth, Cdo, cdo', '0894012421', 'Cash', 'completed', '2026-05-20 13:53:24', 270.00, 32.40),
(69, '4041321a-e90d-431c-9836-20a4b56b8a57', 'CO00069', 1, 291.20, 'tomasaco, manok, cdo', '0941249012', 'Cash', 'completed', '2026-05-21 21:37:43', 260.00, 31.20),
(70, 'd2a40683-8340-469d-b80c-1d1c7a515e23', 'CO00070', 1, 151.20, 'tomasaco, manok, cdo', '0941249012', 'Cash', 'completed', '2026-05-21 21:38:10', 135.00, 16.20),
(71, 'e2b1c25f-aa53-46bb-b408-ff774b090c7e', 'CO00071', 1, 324.80, 'tomasaco, manok, cdo', '0941249012', 'GCash', 'completed', '2026-05-21 21:38:22', 290.00, 34.80),
(72, '51efe3c1-3a52-41a4-bab4-d865aa0f60e1', 'CO00072', 12, 134.40, 'Nazareth, Cdo, cdo', '0894012421', 'Cash', 'completed', '2026-05-27 22:58:03', 120.00, 14.40),
(73, 'd1c4e1df-0d61-4210-a3a2-a7672f38cea3', 'CO00073', 7, 145.60, 'pabayo , nazareth, cdo', '090525315211', 'Cash', 'pending', '2026-05-29 04:32:41', 130.00, 15.60),
(74, '5f07a90b-2167-4e78-9da8-fc092669eea0', 'CO00074', 22, 1019.20, 'cdo, cdo, cdo', '09052314544', 'Cash', 'completed', '2026-05-29 04:45:09', 910.00, 109.20),
(75, 'baecdbcd-ba9e-4b5b-a285-492e4b2a3fd7', 'CO00075', 1, 145.60, 'tomasaco, manok, cdo', '0941249012', 'Cash', 'completed', '2026-09-02 20:00:28', 130.00, 15.60),
(76, '2a9304c9-5e2e-4ec3-ad60-fb5468c674a2', 'CO00076', 4, 1164.80, 'pabayo, uptown?, cdo', '090524124', 'GCash', 'pending', '2026-09-17 04:55:21', 1040.00, 124.80);

-- --------------------------------------------------------

--
-- Table structure for table `product_item`
--

CREATE TABLE `product_item` (
  `id` int(11) NOT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `productName` varchar(255) DEFAULT NULL,
  `productDescription` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `img` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_item`
--

INSERT INTO `product_item` (`id`, `uuid`, `productName`, `productDescription`, `price`, `img`) VALUES
(1, '4a4bf0e7-51bc-11f1-b3aa-d843aec840f7', 'Regular Choco', 'Classic éclair filled with smooth chocolate cream and topped with a rich chocolate glaze.', 120.00, 'chocoReg.jpg'),
(2, '4a4c00b4-51bc-11f1-b3aa-d843aec840f7', 'Choco Lucent pair', 'Light and airy éclairs filled with sweet strawberry cream, finished with a delicate chocolate drizzle.', 130.00, 'chocoLucent.jpg'),
(3, '4a4c0127-51bc-11f1-b3aa-d843aec840f7', 'Dark Choco crumbs', 'A rich chocolate éclair coated with crunchy dark chocolate crumbs for added texture and flavor.', 140.00, 'chocoCrumbs.jpg'),
(4, '4a4c0161-51bc-11f1-b3aa-d843aec840f7', 'Heavy Yema Glaze', 'Soft éclair filled with creamy yema custard and topped with a thick caramelized glaze.', 135.00, 'heavyYema.jpg'),
(5, '4a4c0192-51bc-11f1-b3aa-d843aec840f7', 'Yema Peanut pair ', 'A delightful éclair filled with sweet yema and topped with roasted peanuts for a nutty crunch.', 145.00, 'yema.jpg'),
(6, '4a4c01c4-51bc-11f1-b3aa-d843aec840f7', 'Special Tops with Mellow Frosting ', 'Filipino-inspired éclair filled with creamy ube and topped with smooth, mellow frosting.', 150.00, 'STops.jpg'),
(7, '4a4c01f4-51bc-11f1-b3aa-d843aec840f7', 'Choco Nutty Toppings', 'Chocolate éclair topped with roasted nuts and coated in a silky chocolate finish.', 140.00, 'chocoNut.jpg'),
(8, '4a4c0221-51bc-11f1-b3aa-d843aec840f7', 'Vanilla Filled Choco', 'Soft éclair filled with rich vanilla cream and covered in a smooth chocolate glaze.', 150.00, 'vanillaField.jpg'),
(9, '4a4c0251-51bc-11f1-b3aa-d843aec840f7', 'Fluffy Matcha', 'A light and fluffy éclair infused with matcha cream, offering a subtle earthy sweetness.', 145.00, 'fluffyMatcha.jpg'),
(10, '4a4c0281-51bc-11f1-b3aa-d843aec840f7', 'Frosty Berry Tops', 'Éclair topped with mixed berry frosting and a refr', 120.00, 'frostBerry.jpg'),
(11, '4a4c02b2-51bc-11f1-b3aa-d843aec840f7', 'Hazel Nut Glazzed ', 'Creamy hazelnut-filled éclair coated with a glossy chocolate-hazelnut glaze.', 170.00, 'hazelNut.jpg'),
(12, '4a4c02f2-51bc-11f1-b3aa-d843aec840f7', 'Hazzy Choco Twins', 'Twin éclairs filled with hazelnut and chocolate cream for a rich, indulgent bite.', 165.00, 'hazzyChoco.jpg'),
(13, '4a4c031e-51bc-11f1-b3aa-d843aec840f7', 'Velet Toffee Eclair', 'A delicate éclair filled with rich cream and topped with a smooth caramel glaze for a perfectly indulgent treat', 150.00, 'Velvet.jpg'),
(14, '4a4c0353-51bc-11f1-b3aa-d843aec840f7', 'Red Vel Powder puff', 'Éclair inspired by red velvet, dusted with powder and filled with cream cheese filling.', 137.00, 'redVel.jpg'),
(15, '4a4c037e-51bc-11f1-b3aa-d843aec840f7', 'Pinky Meya', 'Sweet pink-colored éclair filled with yema cream and a light sugary topping.', 135.00, 'pinkyMeya.jpg'),
(16, '4a4c03b0-51bc-11f1-b3aa-d843aec840f7', 'Pink Glazed duo', 'Pair of éclairs coated in pink glaze with a smooth vanilla cream filling.', 120.00, 'pinkGlazed.jpg'),
(17, '4a4c03de-51bc-11f1-b3aa-d843aec840f7', 'Strawberry Glaze Special', 'Éclair filled with cream and topped with a fresh strawberry glaze.', 110.00, 'strawberryGlaze.jpg'),
(18, '4a4c040c-51bc-11f1-b3aa-d843aec840f7', 'Vanilla Soft Flakes', 'Vanilla-filled éclair topped with soft flaky crumbs for a delicate crunch.', 125.00, 'vanillaSoft.jpg'),
(19, '4a4c043b-51bc-11f1-b3aa-d843aec840f7', 'Frosty Luscent Frop', 'Chilled éclair with a frosty finish and light cream filling for a refreshing bite.', 140.00, 'frostyLuscent.jpg'),
(20, '4a4c0466-51bc-11f1-b3aa-d843aec840f7', 'Yin and Yang', 'Éclair featuring a mix of vanilla and chocolate cream, symbolizing balance in flavor.', 155.00, 'yinyang.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `middleName` varchar(255) DEFAULT NULL,
  `emailAddress` varchar(255) DEFAULT NULL,
  `contactNumber` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `barangay` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `profile` varchar(255) NOT NULL,
  `role` enum('customer','admin') NOT NULL,
  `dateCreated` timestamp NOT NULL DEFAULT current_timestamp(),
  `accountStatus` varchar(20) NOT NULL DEFAULT 'unverified',
  `emailVerificationToken` varchar(64) DEFAULT NULL,
  `emailVerificationExpires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `uuid`, `firstName`, `lastName`, `middleName`, `emailAddress`, `contactNumber`, `username`, `password`, `street`, `barangay`, `city`, `profile`, `role`, `dateCreated`, `accountStatus`, `emailVerificationToken`, `emailVerificationExpires`) VALUES
(1, '0fc8bb7f-51ba-11f1-b3aa-d843aec840f7', 'sam', 'rookie', NULL, 'sam@gmail.com', '0941249012', 'sammy', 'manok', 'tomasaco', 'manok', 'cdo', '1777044203_Kawaragi Momoka (1).jpg', 'admin', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(2, '0fc8d46f-51ba-11f1-b3aa-d843aec840f7', 'sam', 'roque', '', 'sams1@gmail.com', '40194120941', 'manoks', 'manok', 'pabao', 'naza', 'cdo', '', 'admin', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(3, '0fc8d4fc-51ba-11f1-b3aa-d843aec840f7', 'sam', 'roque', '', 'samroque959@gmail.com', '312321', 'what', '$2y$10$aflhdlzKVOi3rOjG7WkOge5yC5wcHUYpqBDEqenDBb6HKPhP0ajIO', 'Pabayo St', '12345', 'Cagayan de Oro', '', 'customer', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(4, '0fc8d54b-51ba-11f1-b3aa-d843aec840f7', 'marjon', 'osa', '', 'marjon@gmail.com', '090524124', 'marjons', '$2b$12$EikEXBIx.y6icKgfEh41aukHmFxnN1oHNk36Hfo88owwUFgq3UOfO', 'pabayo', 'uptown?', 'cdo', '', 'customer', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(5, '0fc8d588-51ba-11f1-b3aa-d843aec840f7', 'Sam', 'Roque', 'lagcao', 'roque.sam025@gmail.com', '0905253', 'manokannssss', 'manok', '', '', '', '', 'customer', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(6, '0fc8d5c5-51ba-11f1-b3aa-d843aec840f7', 'Sam', 'Roque', 'lagcao', 'roque.sam052@gmail.com', '09052531699', 'manny', 'sammy', 'hayes', 'nazareth', 'cdo', '', '', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(7, '0fc8d602-51ba-11f1-b3aa-d843aec840f7', 'sam', 'rookie', '', 'samms@gmail.com', '090525315211', 'manok', 'sammy', 'pabayo ', 'nazareth', 'cdo', '', '', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(8, '0fc8d63c-51ba-11f1-b3aa-d843aec840f7', 'sam', 'rookie', '', 'sammss@gmail.com', '090525315211', 'manokanss', 'sam', 'pabayo ', 'nazareth', 'cdo', '', '', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(9, '0fc8d676-51ba-11f1-b3aa-d843aec840f7', 'carlo', 'veloso', '', 'carlo@gmail.com', '090942121', 'carlotta', 'mans', 'pabayo ', 'nazareth', 'cdo', '', '', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(10, '0fc8d6ab-51ba-11f1-b3aa-d843aec840f7', 'sam', 'rookie', '', 'sammsssss@gmail.com', '090525315211', 'manoka2', 'sam', 'pabayo ', 'nazareth', 'cdo', '', '', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(11, '0fc8d6e2-51ba-11f1-b3aa-d843aec840f7', 'sam', 'rookie', '', 'sammfafsss@gmail.com', '090525315211', 'manok1', '1234', 'pabayo ', 'nazareth', 'cdo', '', '', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(12, '0fc8d719-51ba-11f1-b3aa-d843aec840f7', 'sam', 'roque', 'manok', 'sammy12@gmail.com', '0894012421', 'manokansabuko', '$2y$10$i8bFThKBg2sd6eJg6CBbSOVuX31xpFWuf.hUd2CAtg.sNR7Z1vGRm', 'Nazarethh', 'Cdo', 'cdo', '1777524607_rupass.jpg', '', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(13, '0fc8d752-51ba-11f1-b3aa-d843aec840f7', 'sam', 'roque', NULL, 'manokan2@gmail.com', '901209421042', 'sammypopo', 'manok', 'nazareth', 'nazareth', 'cdo', '', 'admin', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(14, '0fc8d78c-51ba-11f1-b3aa-d843aec840f7', 'sam', 'rookie', '', 'roque.sam0541@gmail.com', '0905215213', 'samms', 'manok', 'pabayo', 'nazareth', 'cdo', '', '', '2026-04-02 06:07:45', 'unverified', NULL, NULL),
(15, '0fc8d7c3-51ba-11f1-b3aa-d843aec840f7', 'sam', 'roque', '', 'manokss@gmail.com', '0905921', 'sammy121', 'manok', 'pabayo', 'nazareth', 'cdo', '', '', '2026-04-02 06:08:16', 'unverified', NULL, NULL),
(16, '0fc8d7fa-51ba-11f1-b3aa-d843aec840f7', 'sam', 'roque', '', 'sammm@gmail.com', '0905213121', 'sammyss', 'manok', 'tomasaco', 'nazreth', 'cdo', '', '', '2026-04-03 06:08:20', 'unverified', NULL, NULL),
(17, '0fc8d831-51ba-11f1-b3aa-d843aec840f7', 'sam', 'roque', '', 'sam959222@gmail.com', '090052244', 'sammy212', 'manok', 'tomasaco', 'nazareth', 'cdo', '', '', '2026-04-03 06:58:54', 'unverified', NULL, NULL),
(18, '0fc8d868-51ba-11f1-b3aa-d843aec840f7', 'sam', 'roque', '', 'roque.sam0521@gmail.com', '095215215', 'sammy1', 'manok', 'tomasaco', 'nazareth', 'cdo', '', '', '2026-04-06 07:19:07', 'unverified', NULL, NULL),
(19, '0fc8d89e-51ba-11f1-b3aa-d843aec840f7', 'sam', 'roque', '', 'rookies1@gmail.com', '094211241', 'sammy2', 'manok', 'tomasaco', 'nazareths', 'cdo', '', '', '2026-04-06 07:21:06', 'unverified', NULL, NULL),
(20, '0fc8d8d4-51ba-11f1-b3aa-d843aec840f7', 'sammy', 'roque', 'lagcaos', 'manokan2@gmail.com', '901209421042', 'samgag', 'manok', 'nazareth', 'nazareth', 'cdoss', '1778346612_GIRLS BAND CRY.jpg', '', '2026-04-17 21:27:10', 'unverified', NULL, NULL),
(21, 'aaf7db6e-da8c-5b76-a957-e272f76b62ac', 'skys', 'board', '', 'sky@gmail.com', '0905253142142', 'manokans', '$2y$10$5BJg71BMgLj8swsL8XSmE.pgly3RhxrVYu5KfmY4Ir2OeQm5.J5XO', 'manok', 'manok', 'manok', '', '', '2026-05-17 06:29:40', 'unverified', NULL, NULL),
(22, '60af2b82-6236-6d7c-9c73-9ac8d3c1328c', 'sammmss', 'roque', 'manok', 'marjons@gmail.com', '09052314544', 'marjonss', '$2y$10$iNvC.nCuDCS18NOXD9J.L.RDVTeu8HLB6oxt7gREfpOTEyGdC6WLa', 'cdo', 'cdo', 'cdo', '1780029999_download.jfif', '', '2026-05-29 04:44:03', 'unverified', NULL, NULL),
(23, '3bc5a0a4-f654-5981-bd7b-5591e975c698', 'safsfa', 'fsafasf', 'fsafasfas', 'fsafassf@gmail.com', '0940129412', 'manokmanok', '$2y$10$RJ0RXWO867YtQZyWVqReVOWYohPNsUzANe0MdIlMVabyeN8OckBaK', 'manok', 'manok', 'manok', '', '', '2026-10-16 04:26:34', 'unverified', NULL, NULL),
(25, 'f6f4098a-63fe-4d1e-818e-970dd20377b1', 'sam', 'roque', 'lagcaos', 'roque.sam05@gmail.com', '401240912490', 'skyssss3', '$2b$12$nwEp33AenflnTsp9wwN8H.hl3f/z1n4/M6i6E7brRJ.s5B9lVbqjC', 'manok', 'manok', 'manok', '', 'customer', '2026-10-17 06:26:36', 'active', NULL, NULL),
(26, '83b5024c-61b9-43d1-945b-fb4ad8b61b5d', 'lawrence', 'sendais', 'sendais', 'borgygong@gmail.com', 'manok', 'BORGYGONG', '$2b$12$yc.QcSlgpc7lrzmV7.2C0.OnCtfqoKE1XhvEJO8bqXuu3R5yx2OXq', 'manok', 'manok', 'manok', '', 'customer', '2026-10-17 06:28:53', 'unverified', 'e40397835947a9fc9d2886ee7477d75309bcd7f9f7511bae5b12cad3817d7bbe', '2026-10-17 14:58:53'),
(27, '9a210cda-9c29-4c75-9ed1-04131e1d7d16', 'carl', 'sabal', 'carl', 'samroque87@gmail.com', '09341203912', 'carlgibson', '$2b$12$t3iqUtY10XC/ATeaCrPDiOSFAbv7/Ge46FkuMPpCKCs6vwBe96UJW', 'manok', 'manok', 'manok', '', 'customer', '2026-10-17 09:25:51', 'active', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_changelog`
--
ALTER TABLE `admin_changelog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`),
  ADD KEY `fk_product_id` (`product_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `product_item`
--
ALTER TABLE `product_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_changelog`
--
ALTER TABLE `admin_changelog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `product_item`
--
ALTER TABLE `product_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_changelog`
--
ALTER TABLE `admin_changelog`
  ADD CONSTRAINT `admin_changelog_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_product_id` FOREIGN KEY (`product_id`) REFERENCES `product_item` (`id`),
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orderitems_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `orderitems_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_item` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

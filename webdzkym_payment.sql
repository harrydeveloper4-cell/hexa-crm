-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 05, 2026 at 07:34 AM
-- Server version: 11.4.13-MariaDB-cll-lve
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webdzkym_payment`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminiy`
--

CREATE TABLE `adminiy` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adminiy`
--

INSERT INTO `adminiy` (`id`, `role_id`, `name`, `email`, `is_active`, `is_deleted`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'Admin', 'admin@project.com', 1, 0, '$2y$12$riYw4r9haNCGXGH.hY06..ZxEAoptsucCRUacJQeuz6QXhbuUZ9Ha', NULL, '2024-09-19 04:50:19', '2025-02-27 01:42:02'),
(2, 1, 'Saqib Nasir', 'saqib@teamomentum.com', 1, 0, '$2y$10$y8znzhl1oj1jhnrF0DHHo.2eeurHpOOa.qSKd.vtE1HkMMNmCFc.a', NULL, '2025-04-22 21:12:33', '2025-06-12 16:31:21'),
(11, 2, 'Gloria Daniel', 'daqax@mailinator.com', 1, 0, '$2y$10$UkPu.spP9O4CTehbLMOc4.ic/9nKWOYCi3AXpWfLSluVWR9F7KNLm', NULL, '2025-06-13 12:10:03', '2025-06-13 12:10:03'),
(12, 2, 'zeron zeronex', 'zeronex.ftw@gmail.com', 1, 0, '$2y$10$UcZeQ0mkSPg2lgJ53046q.ZidDIL1HnE/yAm1xbQmsgGf610IF6Au', NULL, '2025-08-26 22:17:41', '2025-08-26 22:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `redirect_url` varchar(255) DEFAULT NULL,
  `currency` text DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `phonenumber`, `email_address`, `logo`, `desc`, `link`, `redirect_url`, `currency`, `status`, `created_at`, `updated_at`) VALUES
(5, 'Temp', 'Temp', '(346) 781-5302', 'idea@test.com', 'brand_uploads/1745360703_brand_logo.png', 'We believe in collaboration and ourselves as an extension of your existing team. For this reason we have created an entire process which allows us to ensure you are always up to date with the progress of your project.', 'https://test.com/', NULL, '[\"USD\"]', 'active', '2025-04-22 18:46:45', '2025-04-22 22:25:03'),
(7, 'test', 'google', '1231231231', 'test@test.com', 'brand_uploads/1749837894_brand_logo.png', 'test', 'https://google.com', NULL, '[\"EUR\",\"USD\"]', 'active', '2025-06-13 13:04:54', '2025-06-13 13:04:54'),
(8, 'AWD', 'portal', '123456789', 'info@demolink.com', 'brand_uploads/1756245835_brand_logo.jpg', 'adsad', 'https://portal.allinflo.com/brands/create', NULL, '[\"USD\"]', 'active', '2025-08-26 22:03:55', '2025-08-26 22:03:55');

-- --------------------------------------------------------

--
-- Table structure for table `brand_merchants`
--

CREATE TABLE `brand_merchants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `config_keys` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand_merchants`
--

INSERT INTO `brand_merchants` (`id`, `brand_id`, `merchant_id`, `title`, `config_keys`, `status`, `created_at`, `updated_at`) VALUES
(12, 5, 2, NULL, '{\"stripe_key\":\"pk_test_51RHDNTGhdJegGbD8eVQ6TVsV5AtePe2vL8U1hLFlsm8DlYT6Dj8ABMaJvaVJfo606yx2byZMvNv0TPdYIpgGfw2600sMFHQlJD\",\"stripe_secret_key\":\"sk_test_51RHDNTGhdJegGbD8utY5YgKCOuT2dJbB7es0eTeAKw4R2L11BD883UT6ulPUPQqUaVZbPTDSBXg10tGKpzQWXMLR00QLqBw80A\"}', 'active', '2025-04-22 18:51:17', '2025-04-24 18:49:30'),
(15, 7, 3, 'square new', '{\"app_id\":\"tes\",\"access_token\":\"Accusantium nisi arc\",\"location_id\":\"test\"}', 'active', '2025-06-13 13:05:22', '2025-06-16 14:11:38'),
(16, 7, 2, 'Stripe new', '{\"stripe_key\":\"test\",\"stripe_secret_key\":\"test\"}', 'active', '2025-06-13 13:05:22', '2025-06-16 14:11:55'),
(17, 7, 3, 'square new 2', '{\"app_id\":\"tes\",\"access_token\":\"Accusantium nisi arc\",\"location_id\":\"test\"}', 'active', '2025-06-13 13:05:22', '2025-06-16 14:11:55'),
(19, 8, 2, 'Stripe 001', '{\"stripe_key\":\"12323456asd\",\"stripe_secret_key\":\"12323456asd\"}', 'active', '2025-08-26 22:06:05', '2025-08-26 22:06:05'),
(20, 8, 1, 'Paypal', '{\"client_id\":\"12345\",\"secret_key\":\"123456\"}', 'active', '2025-08-26 22:06:05', '2025-08-26 22:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `card_details`
--

CREATE TABLE `card_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner` varchar(255) DEFAULT NULL,
  `cardNumber` varchar(255) DEFAULT NULL,
  `cvv` varchar(255) DEFAULT NULL,
  `expiration_month` varchar(255) DEFAULT NULL,
  `expiration_year` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) NOT NULL,
  `merchant` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `phone_code` varchar(255) NOT NULL,
  `phone_number_limit` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `phone_code`, `phone_number_limit`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Afghanistan', 'AF', '+93', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(2, 'Åland Islands', 'AX', '+358', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(3, 'Albania', 'AL', '+355', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(4, 'Algeria', 'DZ', '+213', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(5, 'American Samoa', 'AS', '+1684', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(6, 'Andorra', 'AD', '+376', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(7, 'Angola', 'AO', '+244', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(8, 'Anguilla', 'AI', '+1264', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(9, 'Antarctica', 'AQ', '+672', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(10, 'Antigua and Barbuda', 'AG', '+1268', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(11, 'Argentina', 'AR', '+54', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(12, 'Armenia', 'AM', '+374', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(13, 'Aruba', 'AW', '+297', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(14, 'Australia', 'AU', '+61', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(15, 'Austria', 'AT', '+43', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(16, 'Azerbaijan', 'AZ', '+994', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(17, 'Bahamas', 'BS', '+1242', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(18, 'Bahrain', 'BH', '+973', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(19, 'Bangladesh', 'BD', '+880', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(20, 'Barbados', 'BB', '+1246', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(21, 'Belarus', 'BY', '+375', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(22, 'Belgium', 'BE', '+32', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(23, 'Belize', 'BZ', '+501', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(24, 'Benin', 'BJ', '+229', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(25, 'Bermuda', 'BM', '+1441', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(26, 'Bhutan', 'BT', '+975', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(27, 'Bolivia, Plurinational State of', 'BO', '+591', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(28, 'Bonaire, Sint Eustatius and Saba', 'BQ', '+599', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(29, 'Bosnia and Herzegovina', 'BA', '+387', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(30, 'Botswana', 'BW', '+267', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(31, 'Bouvet Island', 'BV', '+55', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(32, 'Brazil', 'BR', '+55', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(33, 'British Indian Ocean Territory', 'IO', '+246', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(34, 'Brunei Darussalam', 'BN', '+673', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(35, 'Bulgaria', 'BG', '+359', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(36, 'Burkina Faso', 'BF', '+226', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(37, 'Burundi', 'BI', '+257', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(38, 'Cambodia', 'KH', '+855', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(39, 'Cameroon', 'CM', '+237', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(40, 'Canada', 'CA', '+1', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(41, 'Cape Verde', 'CV', '+238', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(42, 'Cayman Islands', 'KY', '+1345', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(43, 'Central African Republic', 'CF', '+236', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(44, 'Chad', 'TD', '+235', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(45, 'Chile', 'CL', '+56', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(46, 'China', 'CN', '+86', '11', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(47, 'Christmas Island', 'CX', '+61', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(48, 'Cocos (Keeling) Islands', 'CC', '+61', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(49, 'Colombia', 'CO', '+57', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(50, 'Comoros', 'KM', '+269', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(51, 'Congo', 'CG', '+242', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(52, 'Congo, the Democratic Republic of the', 'CD', '+243', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(53, 'Cook Islands', 'CK', '+682', '5', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(54, 'Costa Rica', 'CR', '+506', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(55, 'Côte d Ivoire', 'CI', '+225', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(56, 'Croatia', 'HR', '+385', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(57, 'Cuba', 'CU', '+53', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(58, 'Curaçao', 'CW', '+599', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(59, 'Cyprus', 'CY', '+357', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(60, 'Czech Republic', 'CZ', '+420', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(61, 'Denmark', 'DK', '+45', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(62, 'Djibouti', 'DJ', '+253', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(63, 'Dominica', 'DM', '+1767', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(64, 'Dominican Republic', 'DO', '+1809', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(65, 'Ecuador', 'EC', '+593', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(66, 'Egypt', 'EG', '+20', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(67, 'El Salvador', 'SV', '+503', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(68, 'Equatorial Guinea', 'GQ', '+240', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(69, 'Eritrea', 'ER', '+291', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(70, 'Estonia', 'EE', '+372', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(71, 'Eswatini', 'SZ', '+268', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(72, 'Ethiopia', 'ET', '+251', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(73, 'Falkland Islands (Malvinas)', 'FK', '+500', '5', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(74, 'Faroe Islands', 'FO', '+298', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(75, 'Fiji', 'FJ', '+679', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(76, 'Finland', 'FI', '+358', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(77, 'France', 'FR', '+33', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(78, 'French Guiana', 'GF', '+594', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(79, 'French Polynesia', 'PF', '+689', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(80, 'French Southern Territories', 'TF', '+262', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(81, 'Gabon', 'GA', '+241', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(82, 'Gambia', 'GM', '+220', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(83, 'Georgia', 'GE', '+995', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(84, 'Germany', 'DE', '+49', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(85, 'Ghana', 'GH', '+233', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(86, 'Gibraltar', 'GI', '+350', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(87, 'Greece', 'GR', '+30', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(88, 'Greenland', 'GL', '+299', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(89, 'Grenada', 'GD', '+1473', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(90, 'Guadeloupe', 'GP', '+590', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(91, 'Guam', 'GU', '+1671', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(92, 'Guatemala', 'GT', '+502', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(93, 'Guernsey', 'GG', '+44', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(94, 'Guinea', 'GN', '+224', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(95, 'Guinea-Bissau', 'GW', '+245', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(96, 'Guyana', 'GY', '+592', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(97, 'Haiti', 'HT', '+509', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(98, 'Heard Island and McDonald Islands', 'HM', '+672', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(99, 'Holy See (Vatican City State)', 'VA', '+39', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(100, 'Honduras', 'HN', '+504', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(101, 'Hong Kong', 'HK', '+852', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(102, 'Hungary', 'HU', '+36', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(103, 'Iceland', 'IS', '+354', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(104, 'India', 'IN', '+91', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(105, 'Indonesia', 'ID', '+62', '11', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(106, 'Iran, Islamic Republic of', 'IR', '+98', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(107, 'Iraq', 'IQ', '+964', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(108, 'Ireland', 'IE', '+353', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(109, 'Isle of Man', 'IM', '+44', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(110, 'Israel', 'IL', '+972', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(111, 'Italy', 'IT', '+39', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(112, 'Jamaica', 'JM', '+1876', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(113, 'Japan', 'JP', '+81', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(114, 'Jersey', 'JE', '+44', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(115, 'Jordan', 'JO', '+962', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(116, 'Kazakhstan', 'KZ', '+7', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(117, 'Kenya', 'KE', '+254', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(118, 'Kiribati', 'KI', '+686', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(119, 'Korea, Democratic Peoples Republic of', 'KP', '+850', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(120, 'Korea, Republic of', 'KR', '+82', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(121, 'Kuwait', 'KW', '+965', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(122, 'Kyrgyzstan', 'KG', '+996', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(123, 'Lao Peoples Democratic Republic', 'LA', '+856', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(124, 'Latvia', 'LV', '+371', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(125, 'Lebanon', 'LB', '+961', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(126, 'Lesotho', 'LS', '+266', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(127, 'Liberia', 'LR', '+231', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(128, 'Libya', 'LY', '+218', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(129, 'Liechtenstein', 'LI', '+423', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(130, 'Lithuania', 'LT', '+370', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(131, 'Luxembourg', 'LU', '+352', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(132, 'Macao', 'MO', '+853', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(133, 'Macedonia, the Former Yugoslav Republic of', 'MK', '+389', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(134, 'Madagascar', 'MG', '+261', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(135, 'Malawi', 'MW', '+265', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(136, 'Malaysia', 'MY', '+60', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(137, 'Maldives', 'MV', '+960', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(138, 'Mali', 'ML', '+223', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(139, 'Malta', 'MT', '+356', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(140, 'Marshall Islands', 'MH', '+692', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(141, 'Martinique', 'MQ', '+596', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(142, 'Mauritania', 'MR', '+222', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(143, 'Mauritius', 'MU', '+230', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(144, 'Mayotte', 'YT', '+262', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(145, 'Mexico', 'MX', '+52', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(146, 'Micronesia, Federated States of', 'FM', '+691', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(147, 'Moldova, Republic of', 'MD', '+373', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(148, 'Monaco', 'MC', '+377', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(149, 'Mongolia', 'MN', '+976', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(150, 'Montenegro', 'ME', '+382', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(151, 'Montserrat', 'MS', '+1664', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(152, 'Morocco', 'MA', '+212', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(153, 'Mozambique', 'MZ', '+258', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(154, 'Myanmar', 'MM', '+95', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(155, 'Namibia', 'NA', '+264', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(156, 'Nauru', 'NR', '+674', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(157, 'Nepal', 'NP', '+977', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(158, 'Netherlands', 'NL', '+31', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(159, 'New Caledonia', 'NC', '+687', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(160, 'New Zealand', 'NZ', '+64', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(161, 'Nicaragua', 'NI', '+505', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(162, 'Niger', 'NE', '+227', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(163, 'Nigeria', 'NG', '+234', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(164, 'Niue', 'NU', '+683', '4', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(165, 'Norfolk Island', 'NF', '+672', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(166, 'Northern Mariana Islands', 'MP', '+1670', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(167, 'Norway', 'NO', '+47', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(168, 'Oman', 'OM', '+968', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(169, 'Pakistan', 'PK', '+92', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(170, 'Palau', 'PW', '+680', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(171, 'Palestine, State of', 'PS', '+970', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(172, 'Panama', 'PA', '+507', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(173, 'Papua New Guinea', 'PG', '+675', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(174, 'Paraguay', 'PY', '+595', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(175, 'Peru', 'PE', '+51', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(176, 'Philippines', 'PH', '+63', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(177, 'Pitcairn', 'PN', '+64', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(178, 'Poland', 'PL', '+48', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(179, 'Portugal', 'PT', '+351', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(180, 'Puerto Rico', 'PR', '+1939', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(181, 'Qatar', 'QA', '+974', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(182, 'Réunion', 'RE', '+262', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(183, 'Romania', 'RO', '+40', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(184, 'Russian Federation', 'RU', '+7', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(185, 'Rwanda', 'RW', '+250', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(186, 'Saint Barthélemy', 'BL', '+590', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(187, 'Saint Helena, Ascension and Tristan da Cunha', 'SH', '+290', '4', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(188, 'Saint Kitts and Nevis', 'KN', '+1869', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(189, 'Saint Lucia', 'LC', '+1758', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(190, 'Saint Martin (French part)', 'MF', '+590', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(191, 'Saint Pierre and Miquelon', 'PM', '+508', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(192, 'Saint Vincent and the Grenadines', 'VC', '+1784', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(193, 'Samoa', 'WS', '+685', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(194, 'San Marino', 'SM', '+378', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(195, 'Sao Tome and Principe', 'ST', '+239', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(196, 'Saudi Arabia', 'SA', '+966', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(197, 'Senegal', 'SN', '+221', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(198, 'Serbia', 'RS', '+381', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(199, 'Seychelles', 'SC', '+248', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(200, 'Sierra Leone', 'SL', '+232', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(201, 'Singapore', 'SG', '+65', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(202, 'Sint Maarten (Dutch part)', 'SX', '+1721', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(203, 'Slovakia', 'SK', '+421', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(204, 'Slovenia', 'SI', '+386', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(205, 'Solomon Islands', 'SB', '+677', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(206, 'Somalia', 'SO', '+252', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(207, 'South Africa', 'ZA', '+27', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(208, 'South Georgia and the South Sandwich Islands', 'GS', '+500', '5', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(209, 'South Sudan', 'SS', '+211', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(210, 'Spain', 'ES', '+34', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(211, 'Sri Lanka', 'LK', '+94', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(212, 'Sudan', 'SD', '+249', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(213, 'Suriname', 'SR', '+597', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(214, 'Svalbard and Jan Mayen', 'SJ', '+47', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(215, 'Sweden', 'SE', '+46', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(216, 'Switzerland', 'CH', '+41', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(217, 'Syrian Arab Republic', 'SY', '+963', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(218, 'Taiwan, Province of China', 'TW', '+886', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(219, 'Tajikistan', 'TJ', '+992', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(220, 'Tanzania, United Republic of', 'TZ', '+255', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(221, 'Thailand', 'TH', '+66', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(222, 'Timor-Leste', 'TL', '+670', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(223, 'Togo', 'TG', '+228', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(224, 'Tokelau', 'TK', '+690', '4', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(225, 'Tonga', 'TO', '+676', '5', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(226, 'Trinidad and Tobago', 'TT', '+1868', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(227, 'Tunisia', 'TN', '+216', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(228, 'Turkey', 'TR', '+90', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(229, 'Turkmenistan', 'TM', '+993', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(230, 'Tuvalu', 'TV', '+688', '5', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(231, 'Uganda', 'UG', '+256', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(232, 'Ukraine', 'UA', '+380', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(233, 'United Arab Emirates', 'AE', '+971', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(234, 'United Kingdom', 'GB', '+44', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(235, 'United States', 'US', '+1', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(236, 'Uruguay', 'UY', '+598', '8', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(237, 'Uzbekistan', 'UZ', '+998', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(238, 'Vanuatu', 'VU', '+678', '7', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(239, 'Venezuela, Bolivarian Republic of', 'VE', '+58', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(240, 'Viet Nam', 'VN', '+84', '10', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(241, 'Wallis and Futuna', 'WF', '+681', '6', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(242, 'Western Sahara', 'EH', '+212', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(243, 'Yemen', 'YE', '+967', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(244, 'Zambia', 'ZM', '+260', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL),
(245, 'Zimbabwe', 'ZW', '+263', '9', '2025-02-13 07:26:50', '2025-02-13 07:26:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currency`
--

CREATE TABLE `currency` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currency`
--

INSERT INTO `currency` (`id`, `country`, `currency`, `code`, `symbol`) VALUES
(1, 'Albania', 'Leke', 'ALL', 'Lek'),
(2, 'Afghanistan', 'Afghanis', 'AFN', '؋'),
(3, 'Argentina', 'Pesos', 'ARS', '$'),
(4, 'Aruba', 'Guilders', 'AWG', 'ƒ'),
(5, 'Australia', 'Dollars', 'AUD', '$'),
(6, 'Azerbaijan', 'New Manats', 'AZN', '₼'),
(7, 'Bahamas', 'Dollars', 'BSD', '$'),
(8, 'Barbados', 'Dollars', 'BBD', '$'),
(9, 'Belarus', 'Rubles', 'BYR', 'p.'),
(10, 'Belgium', 'Euro', 'EUR', '€'),
(11, 'Beliz', 'Dollars', 'BZD', 'BZ$'),
(12, 'Bermuda', 'Dollars', 'BMD', '$'),
(13, 'Bolivia', 'Bolivianos', 'BOB', '$b'),
(14, 'Bosnia and Herzegovina', 'Convertible Marka', 'BAM', 'KM'),
(15, 'Botswana', 'Pula', 'BWP', 'P'),
(16, 'Bulgaria', 'Leva', 'BGN', 'лв'),
(17, 'Brazil', 'Reais', 'BRL', 'R$'),
(18, 'Brunei Darussalam', 'Dollars', 'BND', '$'),
(19, 'Cambodia', 'Riels', 'KHR', '៛'),
(20, 'Canada', 'Dollars', 'CAD', '$'),
(21, 'Cayman Islands', 'Dollars', 'KYD', '$'),
(22, 'Chile', 'Pesos', 'CLP', '$'),
(23, 'China', 'Yuan Renminbi', 'CNY', '¥'),
(24, 'Colombia', 'Pesos', 'COP', '$'),
(25, 'Costa Rica', 'Colón', 'CRC', '₡'),
(26, 'United States', 'Dollars', 'USD', '$');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `amount` double NOT NULL,
  `payment_link` varchar(255) NOT NULL,
  `is_paid` enum('paid','unpaid') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `order_id`, `amount`, `payment_link`, `is_paid`, `created_at`, `updated_at`) VALUES
(51, 108, 123, 'https://portal.allinflo.com/hexaflowagency/order/aaaabU', 'paid', '2025-04-22 20:22:21', '2025-04-22 20:22:21'),
(52, 109, 123, 'https://portal.allinflo.com/hexaflowagency/order/aaaabV', 'paid', '2025-04-22 20:23:47', '2025-04-22 20:23:47'),
(53, 110, 123, 'https://portal.allinflo.com/hexaflowagency/order/aaaabW', 'paid', '2025-04-22 20:48:32', '2025-04-22 20:48:32'),
(54, 111, 1, 'https://portal.allinflo.com/hexaflowagency/order/aaaabX', 'paid', '2025-04-22 20:49:05', '2025-04-22 20:49:05'),
(55, 112, 1, 'https://portal.allinflo.com/hexaflowagency/order/bY0000', 'paid', '2025-04-22 20:52:45', '2025-04-22 20:52:45'),
(56, 113, 1200, 'https://portal.allinflo.com/hexaflowagency/order/aaaabZ', 'paid', '2025-04-22 21:17:42', '2025-04-22 21:17:42'),
(57, 114, 123, 'https://portal.allinflo.com/hexaflowagency/order/aaaab0', 'paid', '2025-04-22 21:29:18', '2025-04-22 21:29:18'),
(58, 115, 1, 'https://portal.allinflo.com/hexaflowagency/order/aaaab1', 'paid', '2025-04-24 18:46:27', '2025-04-24 18:46:27'),
(59, 116, 20, 'https://portal.allinflo.com/hexaflowagency/order/aaaab2', 'paid', '2025-04-24 18:53:33', '2025-04-24 18:53:33'),
(60, 117, 10, 'http://127.0.0.1:8000/hexaflowagency/order/aaaab3', 'paid', '2025-06-12 13:20:15', '2025-06-12 13:20:15'),
(61, 118, 12, 'http://127.0.0.1:8000/americanwebtronics/order/aaaab4', 'paid', '2025-06-13 12:13:43', '2025-06-13 12:13:43'),
(62, 119, 10, 'http://127.0.0.1:8000/google/order/aaaab5', 'paid', '2025-06-13 13:06:06', '2025-06-13 13:06:06'),
(63, 120, 74, 'https://portal.allinflo.com/Temp/order/aaaab6', 'paid', '2025-06-23 19:45:40', '2025-06-23 19:45:40'),
(64, 121, 12345, 'https://portal.allinflo.com/portal/order/aaaab7', 'paid', '2025-08-26 22:07:15', '2025-08-26 22:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `merchants`
--

CREATE TABLE `merchants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merchant` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merchants`
--

INSERT INTO `merchants` (`id`, `merchant`, `status`, `created_at`, `updated_at`) VALUES
(1, 'PayPal', 'active', NULL, NULL),
(2, 'Stripe', 'active', NULL, NULL),
(3, 'Square', 'active', NULL, NULL),
(4, 'Authorize.net', 'active', NULL, NULL),
(5, 'Rapyd.net', 'active', NULL, NULL),
(6, 'Chase', 'active', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_09_17_081719_create_roles_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2024_09_18_155201_create_adminiy_table', 1),
(6, '2024_09_18_155946_create_brands_table', 1),
(7, '2024_09_19_073640_create_merchants_table', 1),
(8, '2024_09_19_074128_create_brand_merchants_table', 1),
(9, '2024_09_19_074440_create_currency_table', 1),
(10, '2024_09_19_075018_create_orders_table', 1),
(11, '2024_09_19_075922_create_packages_table', 1),
(12, '2024_09_19_080340_create_order_packages_table', 1),
(13, '2024_09_19_080651_create_order_payment_transactions_table', 1),
(14, '2024_09_19_081351_create_permissions_table', 1),
(15, '2024_09_19_082310_create_user_brands_table', 1),
(16, '2024_09_19_082543_create_user_permissions_table', 1),
(17, '2024_09_19_082913_create_card_details_table', 1),
(18, '2024_09_19_083229_create_invoices_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `payment_type` int(11) NOT NULL,
  `order_number` varchar(255) DEFAULT NULL,
  `sale_amount` double NOT NULL,
  `sale_currency` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `brand_name` varchar(255) NOT NULL,
  `payment_gateway` varchar(255) NOT NULL,
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `sales_email` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `status` enum('pending','processing','completed','discarded','refunded') NOT NULL,
  `payment_status` enum('unpaid','paid') NOT NULL,
  `payment_link` text DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `signature` text DEFAULT NULL,
  `pdf_agreement` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `payment_type`, `order_number`, `sale_amount`, `sale_currency`, `description`, `brand_name`, `payment_gateway`, `merchant_id`, `sales_email`, `customer_email`, `status`, `payment_status`, `payment_link`, `expires_at`, `signature`, `pdf_agreement`, `created_at`, `updated_at`) VALUES
(108, 1, '00108', 123, 'USD', 'Custom Package', '5', 'Stripe', 2, 'harrydeveloper4@gmail.com', 'harrydeveloper4@gmail.com', 'pending', 'unpaid', 'https://portal.allinflo.com/hexaflowagency/order/aaaabU', '2025-05-22 00:00:00', NULL, NULL, '2025-04-22 20:22:21', '2025-04-22 20:22:21'),
(109, 1, '00109', 123, 'USD', 'Custom Package', '5', 'Stripe', 2, 'harrydeveloper4@gmail.com', 'harrydeveloper4@gmail.com', 'pending', 'unpaid', 'https://portal.allinflo.com/hexaflowagency/order/aaaabV', '2025-05-22 00:00:00', NULL, NULL, '2025-04-22 20:23:47', '2025-04-22 20:23:47'),
(110, 1, '00110', 123, 'USD', 'Custom Package', '5', 'Stripe', 2, 'harrydeveloper4@gmail.com', 'harrydeveloper4@gmail.com', 'pending', 'unpaid', 'https://portal.allinflo.com/hexaflowagency/order/aaaabW', '2025-05-22 00:00:00', NULL, NULL, '2025-04-22 20:48:32', '2025-04-22 20:48:32'),
(111, 1, '00111', 1, 'USD', 'Custom Package', '5', 'Stripe', 2, 'harrydeveloper4@gmail.com', 'harrydeveloper4@gmail.com', 'pending', 'unpaid', 'https://portal.allinflo.com/hexaflowagency/order/aaaabX', '2025-05-22 00:00:00', NULL, NULL, '2025-04-22 20:49:05', '2025-04-22 20:49:05'),
(112, 1, '00112', 1, 'USD', 'Custom Package', '5', 'Stripe', 2, 'harrydeveloper4@gmail.com', 'harrydeveloper4@gmail.com', 'pending', 'unpaid', 'https://portal.allinflo.com/hexaflowagency/order/bY0000', '2025-05-22 00:00:00', NULL, NULL, '2025-04-22 20:52:45', '2025-04-22 20:52:45'),
(113, 1, '00113', 1200, 'USD', 'Custom Package', '5', 'Stripe', 2, 'idea@teamomentum.com', 'idea@teamomentum.com', 'pending', 'unpaid', 'https://portal.allinflo.com/hexaflowagency/order/aaaabZ', '2025-05-22 00:00:00', NULL, NULL, '2025-04-22 21:17:42', '2025-04-22 21:17:42'),
(114, 1, '00114', 123, 'USD', 'Custom Package', '5', 'Stripe', 2, 'idea@teamomom.ctom', 'idea@teamomentum.com', 'pending', 'unpaid', 'https://portal.allinflo.com/hexaflowagency/order/aaaab0', '2025-05-22 00:00:00', NULL, NULL, '2025-04-22 21:29:18', '2025-04-22 21:29:18'),
(115, 1, '00115', 1, 'USD', 'Custom Package', '5', 'Stripe', 2, 'harrydeveloper4@gmail.com', 'harrydeveloper4@gmail.com', 'pending', 'paid', NULL, '2025-05-24 00:00:00', '', '', '2025-04-24 18:46:27', '2025-04-24 18:51:09'),
(116, 1, '00116', 20, 'USD', 'Custom Package', '5', 'Stripe', 2, 'harrydeveloper4@gmail.com', 'arsalan.mazhar@teamomentum.com', 'pending', 'paid', NULL, '2025-05-24 00:00:00', '', '', '2025-04-24 18:53:33', '2025-08-26 22:11:17'),
(117, 1, '00117', 10, 'USD', 'Custom Package', '5', 'Stripe', 2, 'harrydeveloper4@gmail.com', 'harrydeveloper4@gmail.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/hexaflowagency/order/aaaab3', '2025-07-11 19:00:00', NULL, NULL, '2025-06-12 13:20:15', '2025-06-12 13:20:15'),
(118, 1, '00118', 12, 'USD', 'Custom Package', '6', 'PayPal', 1, 'daqax@mailinator.com', 'daqax@mailinator.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/americanwebtronics/order/aaaab4', '2025-07-12 19:00:00', NULL, NULL, '2025-06-13 12:13:43', '2025-06-13 12:13:43'),
(119, 1, '00119', 10, 'EUR', 'Custom Package', '7', 'PayPal', 1, 'test@gmail.com', 'test2@gmail.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/google/order/aaaab5', '2025-07-12 19:00:00', NULL, NULL, '2025-06-13 13:06:06', '2025-06-13 13:06:06'),
(120, 1, '00120', 74, 'USD', 'Custom Package', '5', 'Stripe', 2, 'zeronex.ftw@gmail.com', 'zigexezeda@mailinator.com', 'pending', 'unpaid', 'https://portal.allinflo.com/Temp/order/aaaab6', '2025-07-23 00:00:00', NULL, NULL, '2025-06-23 19:45:40', '2025-06-23 19:45:40'),
(121, 1, '00121', 12345, 'USD', 'Custom Package', '8', 'Stripe', 2, 'info@demolink.com', 'info@demolink.com', 'pending', 'unpaid', 'https://portal.allinflo.com/portal/order/aaaab7', '2025-09-26 00:00:00', NULL, NULL, '2025-08-26 22:07:15', '2025-08-26 22:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_packages`
--

CREATE TABLE `order_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `package_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_packages`
--

INSERT INTO `order_packages` (`id`, `order_id`, `package_id`, `created_at`, `updated_at`) VALUES
(65, 108, 14, '2025-04-22 20:22:21', '2025-04-22 20:22:21'),
(66, 109, 14, '2025-04-22 20:23:47', '2025-04-22 20:23:47'),
(67, 110, 14, '2025-04-22 20:48:32', '2025-04-22 20:48:32'),
(68, 111, 14, '2025-04-22 20:49:05', '2025-04-22 20:49:05'),
(69, 112, 14, '2025-04-22 20:52:45', '2025-04-22 20:52:45'),
(70, 113, 14, '2025-04-22 21:17:42', '2025-04-22 21:17:42'),
(71, 114, 14, '2025-04-22 21:29:18', '2025-04-22 21:29:18'),
(72, 115, 18, '2025-04-24 18:46:27', '2025-04-24 18:46:27'),
(73, 116, 14, '2025-04-24 18:53:33', '2025-04-24 18:53:33'),
(74, 117, 14, '2025-06-12 13:20:15', '2025-06-12 13:20:15'),
(76, 119, 20, '2025-06-13 13:06:06', '2025-06-13 13:06:06'),
(77, 120, 14, '2025-06-23 19:45:40', '2025-06-23 19:45:40'),
(78, 121, 21, '2025-08-26 22:07:15', '2025-08-26 22:07:15'),
(79, 121, 22, '2025-08-26 22:07:15', '2025-08-26 22:07:15');

-- --------------------------------------------------------

--
-- Table structure for table `order_payment_transactions`
--

CREATE TABLE `order_payment_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `payer_id` varchar(255) NOT NULL,
  `sale_currency` varchar(255) NOT NULL,
  `sale_amount` int(11) NOT NULL,
  `paid_amount` int(11) NOT NULL,
  `last_digit` int(11) DEFAULT NULL,
  `response` text DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `country` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `postalcode` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `billing_phonenumber` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_payment_transactions`
--

INSERT INTO `order_payment_transactions` (`id`, `order_id`, `payment_id`, `payer_id`, `sale_currency`, `sale_amount`, `paid_amount`, `last_digit`, `response`, `firstname`, `lastname`, `billing_address`, `country`, `state`, `city`, `postalcode`, `email`, `billing_phonenumber`, `created_at`, `updated_at`) VALUES
(21, 115, 'pi_3RHUn22c4NnhAp3p091qSczM', 'pi_3RHUn22c4NnhAp3p091qSczM', 'USD', 1, 1, NULL, '{\r\n  \"id\": \"pi_3RHUn22c4NnhAp3p091qSczM\",\r\n  \"object\": \"payment_intent\",\r\n  \"amount\": 100,\r\n  \"amount_details\": {\r\n    \"tip\": {}\r\n  },\r\n  \"automatic_payment_methods\": {\r\n    \"allow_redirects\": \"always\",\r\n    \"enabled\": true\r\n  },\r\n  \"canceled_at\": null,\r\n  \"cancellation_reason\": null,\r\n  \"capture_method\": \"automatic_async\",\r\n  \"client_secret\": \"pi_3RHUn22c4NnhAp3p091qSczM_secret_lH4IJyKTbMxBqSsj8RAJjO3eT\",\r\n  \"confirmation_method\": \"automatic\",\r\n  \"created\": 1745520388,\r\n  \"currency\": \"usd\",\r\n  \"description\": \"Payment from - Hexa Flow Agency\",\r\n  \"last_payment_error\": null,\r\n  \"livemode\": false,\r\n  \"next_action\": null,\r\n  \"payment_method\": \"pm_1RHUrY2c4NnhAp3pGsUZopFU\",\r\n  \"payment_method_configuration_details\": {\r\n    \"id\": \"pmc_1REaul2c4NnhAp3psoThB0Sg\",\r\n    \"parent\": null\r\n  },\r\n  \"payment_method_types\": [\r\n    \"card\",\r\n    \"link\",\r\n    \"cashapp\",\r\n    \"amazon_pay\"\r\n  ],\r\n  \"processing\": null,\r\n  \"receipt_email\": null,\r\n  \"setup_future_usage\": \"off_session\",\r\n  \"shipping\": null,\r\n  \"source\": null,\r\n  \"status\": \"succeeded\"\r\n}', 'harry', 'dev', '556565656', 231, 'None', 'hjghjj', '65412', 'harrydeveloper4@gmail.com', '556565656', '2025-04-24 18:51:09', '2025-04-24 18:51:09'),
(22, 116, 'pi_3RHUtuGhdJegGbD818qFSrNY', 'pi_3RHUtuGhdJegGbD818qFSrNY', 'USD', 20, 20, NULL, '{\r\n  \"id\": \"pi_3RHUtuGhdJegGbD818qFSrNY\",\r\n  \"object\": \"payment_intent\",\r\n  \"amount\": 2000,\r\n  \"amount_details\": {\r\n    \"tip\": {}\r\n  },\r\n  \"automatic_payment_methods\": {\r\n    \"allow_redirects\": \"always\",\r\n    \"enabled\": true\r\n  },\r\n  \"canceled_at\": null,\r\n  \"cancellation_reason\": null,\r\n  \"capture_method\": \"automatic_async\",\r\n  \"client_secret\": \"pi_3RHUtuGhdJegGbD818qFSrNY_secret_jyfDZ1b36gfITI2szaPEKBm9n\",\r\n  \"confirmation_method\": \"automatic\",\r\n  \"created\": 1745520814,\r\n  \"currency\": \"usd\",\r\n  \"description\": \"Payment from - Hexa Flow Agency\",\r\n  \"last_payment_error\": null,\r\n  \"livemode\": false,\r\n  \"next_action\": null,\r\n  \"payment_method\": \"pm_1RHUunGhdJegGbD8ns82TGS0\",\r\n  \"payment_method_configuration_details\": {\r\n    \"id\": \"pmc_1RHDO1GhdJegGbD8tmzF9CO2\",\r\n    \"parent\": null\r\n  },\r\n  \"payment_method_types\": [\r\n    \"card\",\r\n    \"link\",\r\n    \"cashapp\",\r\n    \"amazon_pay\"\r\n  ],\r\n  \"processing\": null,\r\n  \"receipt_email\": null,\r\n  \"setup_future_usage\": \"off_session\",\r\n  \"shipping\": null,\r\n  \"source\": null,\r\n  \"status\": \"succeeded\"\r\n}', 'harry', 'dev', '965656565665', 235, 'None', 'hjghjj', '65412', 'arsalan.mazhar@teamomentum.com', '965656565665', '2025-04-24 18:54:30', '2025-04-24 18:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `price` int(11) DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `package_name`, `price`, `brand_id`, `status`, `is_deleted`, `created_at`, `updated_at`) VALUES
(14, 'Website Design and Development', NULL, 5, 'active', '0', '2025-04-22 18:47:34', '2025-04-22 18:47:34'),
(15, 'Branding and Graphic Design', NULL, 5, 'active', '0', '2025-04-22 18:47:34', '2025-04-22 18:47:34'),
(16, 'Digital Marketing Services', NULL, 5, 'active', '0', '2025-04-22 18:47:34', '2025-04-22 18:47:34'),
(17, 'Creative Content Building', NULL, 5, 'active', '0', '2025-04-22 18:47:34', '2025-04-22 18:47:34'),
(18, 'Mobile App', NULL, 5, 'active', '0', '2025-04-24 18:39:18', '2025-04-24 18:39:18'),
(20, 'Logo', NULL, 7, 'active', '0', '2025-06-13 13:05:29', '2025-06-13 13:05:29'),
(21, 'Logo', NULL, 8, 'active', '0', '2025-08-26 22:04:18', '2025-08-26 22:04:42'),
(22, 'Website', NULL, 8, 'active', '0', '2025-08-26 22:04:28', '2025-08-26 22:04:28'),
(23, 'Book', NULL, 8, 'active', '0', '2025-08-26 22:04:37', '2025-08-26 22:04:37');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `slug`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Create Order', 'create_order', 1, 0, '2024-09-19 04:50:19', '2024-09-19 04:50:19'),
(2, 'View Order', 'view_order', 1, 0, '2024-09-19 04:50:19', '2024-09-19 04:50:19'),
(3, 'View Transaction', 'view_transaction', 1, 0, '2024-09-19 04:50:19', '2024-09-19 04:50:19'),
(4, 'View Brand', 'view_brand', 1, 0, '2024-09-19 04:50:19', '2024-09-19 04:50:19'),
(5, 'View User', 'view_user', 1, 0, '2024-09-19 04:50:19', '2024-09-19 04:50:19'),
(6, 'View Payment', 'view_payment', 1, 0, '2024-09-19 04:50:19', '2024-09-19 04:50:19'),
(7, 'View Packages', 'view_packages', 1, 0, '2024-09-19 04:50:19', '2024-09-19 04:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role`, `created_at`, `updated_at`) VALUES
(1, 'User', '2024-09-19 04:50:19', '2024-09-19 04:50:19'),
(2, 'Customer', '2024-09-19 04:50:19', '2024-09-19 04:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `billing_address` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `postalcode` varchar(255) DEFAULT NULL,
  `billing_phonenumber` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 2,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `billing_address`, `country`, `state`, `city`, `postalcode`, `billing_phonenumber`, `role_id`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(35, 'harry', 'dev', '556565656', '231', 'None', 'hjghjj', '65412', '556565656', 2, 'harrydeveloper4@gmail.com', NULL, '$2a$12$0zJS4AgQOfy0k4Zn1BwHeOHXHftYm54OOiUJDqfraBCL9MebprPbS', NULL, '2025-04-24 18:51:09', '2025-04-24 18:51:09'),
(36, 'harry', 'dev', '965656565665', '235', 'None', 'hjghjj', '65412', '965656565665', 2, 'arsalan.mazhar@teamomentum.com', NULL, NULL, NULL, '2025-04-24 18:54:30', '2025-04-24 18:54:30');

-- --------------------------------------------------------

--
-- Table structure for table `user_brands`
--

CREATE TABLE `user_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_brands`
--

INSERT INTO `user_brands` (`id`, `user_id`, `brand_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(7, 12, 8, 1, 0, '2025-08-26 22:17:41', '2025-08-26 22:17:41');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `permissions_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT 1,
  `is_deleted` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `user_id`, `permissions_id`, `is_active`, `is_deleted`, `created_at`, `updated_at`) VALUES
(23, 11, 1, 1, 0, '2025-06-13 12:10:03', '2025-06-13 12:10:03'),
(24, 11, 2, 1, 0, '2025-06-13 12:10:03', '2025-06-13 12:10:03'),
(25, 11, 3, 1, 0, '2025-06-13 12:10:03', '2025-06-13 12:10:03'),
(26, 12, 1, 1, 0, '2025-08-26 22:17:41', '2025-08-26 22:17:41'),
(27, 12, 2, 1, 0, '2025-08-26 22:17:41', '2025-08-26 22:17:41'),
(28, 12, 4, 1, 0, '2025-08-26 22:17:41', '2025-08-26 22:17:41'),
(29, 12, 7, 1, 0, '2025-08-26 22:17:41', '2025-08-26 22:17:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminiy`
--
ALTER TABLE `adminiy`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adminiy_email_unique` (`email`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brand_merchants`
--
ALTER TABLE `brand_merchants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_merchants_brand_id_foreign` (`brand_id`),
  ADD KEY `brand_merchants_merchant_id_foreign` (`merchant_id`);

--
-- Indexes for table `card_details`
--
ALTER TABLE `card_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currency`
--
ALTER TABLE `currency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoices_order_id_foreign` (`order_id`);

--
-- Indexes for table `merchants`
--
ALTER TABLE `merchants`
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
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_merchant_id_foreign` (`merchant_id`);

--
-- Indexes for table `order_packages`
--
ALTER TABLE `order_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_packages_order_id_foreign` (`order_id`),
  ADD KEY `order_packages_package_id_foreign` (`package_id`);

--
-- Indexes for table `order_payment_transactions`
--
ALTER TABLE `order_payment_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_payment_transactions_order_id_foreign` (`order_id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `packages_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_brands`
--
ALTER TABLE `user_brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_brands_user_id_foreign` (`user_id`),
  ADD KEY `user_brands_brand_id_foreign` (`brand_id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_permissions_user_id_foreign` (`user_id`),
  ADD KEY `user_permissions_permissions_id_foreign` (`permissions_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminiy`
--
ALTER TABLE `adminiy`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `brand_merchants`
--
ALTER TABLE `brand_merchants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `card_details`
--
ALTER TABLE `card_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `currency`
--
ALTER TABLE `currency`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `order_packages`
--
ALTER TABLE `order_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `order_payment_transactions`
--
ALTER TABLE `order_payment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `user_brands`
--
ALTER TABLE `user_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `brand_merchants`
--
ALTER TABLE `brand_merchants`
  ADD CONSTRAINT `brand_merchants_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `brand_merchants_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_merchant_id_foreign` FOREIGN KEY (`merchant_id`) REFERENCES `merchants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_packages`
--
ALTER TABLE `order_packages`
  ADD CONSTRAINT `order_packages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_packages_package_id_foreign` FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_payment_transactions`
--
ALTER TABLE `order_payment_transactions`
  ADD CONSTRAINT `order_payment_transactions_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `packages`
--
ALTER TABLE `packages`
  ADD CONSTRAINT `packages_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_brands`
--
ALTER TABLE `user_brands`
  ADD CONSTRAINT `user_brands_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_brands_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `adminiy` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_adminiy_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `adminiy` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_permissions_permissions_id_foreign` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `adminiy` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

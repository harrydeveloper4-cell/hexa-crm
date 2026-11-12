-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 03:52 PM
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
-- Database: `terminal_db`
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
(1, 1, 'Admin', 'admin@terminalpays.com', 1, 0, '$2y$10$q/vuoY8VOut80geiMPjJQuoo1u1tDp5pRV4.Q.sDD7LYenyTs0Fee', NULL, '2024-09-19 04:50:19', '2024-09-19 04:50:19');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
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

INSERT INTO `brands` (`id`, `name`, `logo`, `desc`, `link`, `redirect_url`, `currency`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Test', 'brand_uploads/1726742289_brand_logo.png', 'this is testing brand', 'https://www.google.com/', NULL, '[\"USD\"]', 'active', '2024-09-19 05:01:02', '2024-09-19 05:38:09'),
(2, 'Test2', 'brand_uploads/1737711695_brand_logo.jpg', 'Neque minim error anim el', 'https://www.jurisosa.com', NULL, '[\"BZD\",\"BMD\",\"BWP\",\"CNY\",\"CRC\",\"USD\"]', 'active', '2025-01-24 04:41:35', '2025-01-24 04:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `brand_merchants`
--

CREATE TABLE `brand_merchants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `merchant_id` bigint(20) UNSIGNED NOT NULL,
  `config_keys` text NOT NULL,
  `status` enum('active','inactive') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brand_merchants`
--

INSERT INTO `brand_merchants` (`id`, `brand_id`, `merchant_id`, `config_keys`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '{\"client_id\":\"AboKMlQI56bUWbbXQI4DgwPgg4lPysLSbCCPjk0u-VbwDPEdBbYDKwQxRXZUFjIN_xWzYTAQwYgsFATO\",\"secret_key\":\"EJrefTVwX3MK2Hq54ZUM3f8OOuryKaL352rtVfglpmiVDKuPkR9MG2kCSICF1zPHFAhrKZJiAqUEKO0S\"}', 'active', '2024-09-19 05:02:00', '2024-09-19 05:02:00'),
(2, 1, 2, '{\"stripe_key\":\"pk_test_51Pok1rCu6SvFHAijhtHI80msGCCTseVWATlU7dniTc1f30zhmLgxbbzXuD435ayjkrhORTifKs4ifHMxYzc8euJ800G0ic9wz6\",\"stripe_secret_key\":\"sk_test_51Pok1rCu6SvFHAijlrupu1eK4GnWto6BPMv9WK4Lp8h5h4pv3pe42WD7F6CUOnGvdo6nVoHRVXI0P2pGiBf9tigm00FbNvr3rP\"}', 'active', '2024-09-19 05:02:00', '2024-09-19 05:02:00'),
(3, 1, 3, '{\"app_id\":\"sandbox-sq0idb--ftpiC33aWpI9BxnoUDtHQ\",\"access_token\":\"EAAAl6V4PXibzXLDfqC51QjfDHFTwGfl-2uWCKlmmS_VLXizwyzovNW2s8oxEulG\",\"location_id\":\"LB7K5AWQTJ3JF\"}', 'active', '2024-09-19 05:02:00', '2024-09-19 05:02:00'),
(4, 1, 4, '{\"merchant_login_id\":\"3PyjevSQ87p4\",\"merchant_transaction_key\":\"756Q7U62EwyVw2yx\"}', 'active', '2024-09-19 05:02:00', '2024-09-19 05:02:00'),
(5, 1, 5, '{\"access_key\":\"1ECF87BE75BFF5F9BF03\",\"secret_key\":\"ac3cf922ddad38258d9a64b2d9da8a20cf2a459e5e5f6594f5b994dcbcd37a2eba14729f60dad3a3\"}', 'active', '2024-09-19 05:02:00', '2024-09-19 05:02:00'),
(6, 2, 2, '{\"stripe_key\":\"pk_test_51Pok1rCu6SvFHAijhtHI80msGCCTseVWATlU7dniTc1f30zhmLgxbbzXuD435ayjkrhORTifKs4ifHMxYzc8euJ800G0ic9wz6\",\"stripe_secret_key\":\"sk_test_51Pok1rCu6SvFHAijlrupu1eK4GnWto6BPMv9WK4Lp8h5h4pv3pe42WD7F6CUOnGvdo6nVoHRVXI0P2pGiBf9tigm00FbNvr3rP\"}', 'active', '2025-01-24 04:42:22', '2025-01-24 04:42:22'),
(7, 2, 3, '{\"app_id\":\"sandbox-sq0idb--ftpiC33aWpI9BxnoUDtHQ\",\"access_token\":\"EAAAl6V4PXibzXLDfqC51QjfDHFTwGfl-2uWCKlmmS_VLXizwyzovNW2s8oxEulG\",\"location_id\":\"LB7K5AWQTJ3JF\"}', 'active', '2025-01-24 04:42:44', '2025-01-24 04:42:44');

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

--
-- Dumping data for table `card_details`
--

INSERT INTO `card_details` (`id`, `owner`, `cardNumber`, `cvv`, `expiration_month`, `expiration_year`, `customer_email`, `merchant`, `created_at`, `updated_at`) VALUES
(1, 'James', '5424 0000 0000 0015', '999', '01', '2027', 'bohyxe@mailinator.com', 'authorize.net', '2024-09-19 05:07:00', '2024-09-19 05:07:00'),
(2, 'Michael', '4111 1111 1111 1111', '111', '01', '28', 'wonugaseri@mailinator.com', 'Rapyd', '2024-09-19 05:08:18', '2024-09-19 05:08:18'),
(3, 'James', '5424 0000 0000 0015', '999', '01', '2026', 'jevegosela@mailinator.com', 'authorize.net', '2024-09-19 05:20:17', '2024-09-19 05:20:17'),
(4, 'Rauf', '4111 1111 1111 1111', '123', '06', '2025', 'max22@gmail.com', 'authorize.net', '2025-01-24 04:46:11', '2025-01-24 04:46:11');

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
(1, 1, 670, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6ImpOdkszTFNXOGNBMGJ5a0F2dkhsbHc9PSIsInZhbHVlIjoiQmRDMjh4ZkhxSnV2VThjK0Y1R2hvZz09IiwibWFjIjoiYjY1NjFkYmRjMGQzZTg5OWE4Y2YxMmU3ZmVhMDQ2YjM1MTRkZmE0ZWEwYTAyZThlOTkxY2YyMjQwZWEwZDM3NiIsInRhZyI6IiJ9', 'paid', '2024-09-19 05:02:31', '2024-09-19 05:02:31'),
(2, 2, 99, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IkhTK3RxMTg3TXRtMzBFZmVqN0hZSFE9PSIsInZhbHVlIjoiQzI3SmUxZmFiK2UrZE9zMmhFRkx2QT09IiwibWFjIjoiMTljMTRmMmE0ZmY0OTAyYjM0ZTY2MDRjYTUzOWUwYWEzYTI1YTEzMTVkMmQ4YWI3YzE1MGVhODc5YzZhZGY2NSIsInRhZyI6IiJ9', 'paid', '2024-09-19 05:04:49', '2024-09-19 05:04:49'),
(4, 4, 760, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IkhvL1ZJVElGYjhnUWMvd2dLMmpQRUE9PSIsInZhbHVlIjoiT1gwVWtmeDFNUGZoNUhaRWZFWFl4dz09IiwibWFjIjoiZWEzNzEwNDA3MDFiNWI2MTY0ZTNjNDUwMzAxZjUwMDQ4NDg5MDlmZTg3NmZmOGJiNTBmODNmOWMwMTMxMDFlYSIsInRhZyI6IiJ9', 'paid', '2024-09-19 05:05:46', '2024-09-19 05:05:46'),
(6, 6, 1700, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IjRiUFpmV1FBbWZFbDloME9TQzgyWnc9PSIsInZhbHVlIjoiVjlaZlR2eFBCanhpZzh4WW05VDZIZz09IiwibWFjIjoiNjYyOTczZDM3N2IwNGUyYTQ1NDY1MWI1ZDE1YTFiYjMwZjEwZDQ2ZDI4ZjRmY2QxMjAzZjNlZjQ1NGU4YzEwNyIsInRhZyI6IiJ9', 'paid', '2024-09-19 05:07:45', '2024-09-19 05:07:45'),
(7, 7, 480, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6ImdNWUtrVklLYm05MGNTTVM0WTNaY2c9PSIsInZhbHVlIjoicjcxQ1VCN000eUd4dE0vcFJLUnhmdz09IiwibWFjIjoiYzc0YmY2NDViYTdmMDAyM2JhYjY0NDQxYzJkYWRiOGEzMWUyMzYzNTA1MzFhYzA0NDM0YmM2MThhZjA5OTk4YyIsInRhZyI6IiJ9', 'paid', '2024-09-19 05:19:51', '2024-09-19 05:19:51'),
(8, 8, 2976, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6InV6eUVOSVVBNm1EMzFsQllZOU9DTlE9PSIsInZhbHVlIjoidlVvMVdnczRaMXoyVlRnNkVjOUNtZz09IiwibWFjIjoiYzA1ZTU1ZGE4YzUyMGU3MTE3MDVkMDY1ODVjYWMzNzgwYWNlNzY4NDk0M2RhOGQwNDFmMzY1Yjk5YTRjNGM1ZSIsInRhZyI6IiJ9', 'paid', '2024-10-09 03:46:26', '2024-10-09 03:46:26'),
(9, 9, 1000, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6ImRQZmkxblkycEtJakQzREtTVlRrRFE9PSIsInZhbHVlIjoiTWFuTzdnTkNNSGZtQVJNa1pKVkcxUT09IiwibWFjIjoiMmFjZTNiYzQxYmNkMjY2N2NkMmRmYzczMjI4MjdjYTk3NGZiM2M5NjlhYmJjYTVlYTliYjYxNWY2MTdiZjJkMiIsInRhZyI6IiJ9', 'paid', '2024-11-05 07:28:44', '2024-11-05 07:28:44'),
(10, 10, 100, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IlV3cVUyb28wUUh3S1gxd2N5bjRHK2c9PSIsInZhbHVlIjoiNHE3R1M0M3lGTDBqRlFCVkg1UWdqUT09IiwibWFjIjoiODM1ZmJmYzY1NGQ1NjI2ZWUxZjU1NDBjYzdjMmU0YmZmOGE2YzM1N2Q0NjdlMWJkZGMxZjdkMWY1NmNhNDIxMiIsInRhZyI6IiJ9', 'paid', '2024-11-05 07:37:07', '2024-11-05 07:37:07'),
(11, 11, 100, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6ImZ3SG04aTJ6dmgwQ0dwQk1vbzJNdnc9PSIsInZhbHVlIjoiRldtaCtFUldRc1dyN0hIZThVN29UQT09IiwibWFjIjoiZTQ3YzM3NGYwZmUzODA3OTFkMjVkYWI3Mzk0MTc4MjE5NTUyNDYyNTVmNWQxNDg3MDI0MDJlNDFkYmNjMGNhNSIsInRhZyI6IiJ9', 'paid', '2024-11-05 07:38:18', '2024-11-05 07:38:18'),
(12, 12, 100, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IjFZMmY2MGQxMWdlQkpoelg4b1JLNkE9PSIsInZhbHVlIjoiay9Udk9Sd2lnbURkSlpUNHJDK2N6UT09IiwibWFjIjoiZDVmZTE1YzFhMDhhMWQxZGE2ZGQwOTcyZjZlZGUxYzRiYmQ0ZjJmYWNkMjRjZGUzNjMyMzJkYzlkMDIzZmM2YSIsInRhZyI6IiJ9', 'paid', '2024-11-05 07:39:02', '2024-11-05 07:39:02'),
(13, 13, 100, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IlorenQwZ2VlaDJCYzdkQ2xKQWtVQmc9PSIsInZhbHVlIjoidUNaR1N6bFBtVjFONjZJQUQrT1hFdz09IiwibWFjIjoiYmQ3NTEyZWEwM2EwZTdlY2FhYjQ2MDY2MmMwMTI3YTJiMTdhMjY4YjNmNjVkOWExNmM4ZDMxODc3ODYzMWUyMiIsInRhZyI6IiJ9', 'paid', '2025-01-24 04:32:04', '2025-01-24 04:32:04'),
(14, 14, 100, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IjFiYTZMbW5lL0hIMVFqV1owcW1qV1E9PSIsInZhbHVlIjoiMXlDNjJJU1NtaTVpV1liNzJpV1RDQT09IiwibWFjIjoiZjViYzE1ZTA5ZDE2YjRlMzRiODQ4YzVlMWRlNzM2YmFiNjg4ZjFjNjA3ZGM2MWM3OWQ4ODY1ZDRlZDUyMzY0ZSIsInRhZyI6IiJ9', 'paid', '2025-01-24 04:43:34', '2025-01-24 04:43:34'),
(15, 15, 100, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IlBMYjVpdGxvUVRSTkRJb2xDMnE2Wmc9PSIsInZhbHVlIjoiSTNYV3M3eTY0TDRuejMzalh4QjQrUT09IiwibWFjIjoiNjdkZDA1NmMwMWE2NGI4MmQxMTgxNDk1OWQ1ZTEwNDIwY2MxMDQ1MDVhYjNhMmY3NTdmYWYwNjFiYzI3MjgyNiIsInRhZyI6IiJ9', 'paid', '2025-01-24 04:44:41', '2025-01-24 04:44:41'),
(16, 16, 100, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IkNtVDN2dWZYanQxWFFPTXdWc3BXaVE9PSIsInZhbHVlIjoiMVQyMzRrRDh4bzZsQmlJeXZGQTVOdz09IiwibWFjIjoiMDQ3ZTRjNDNmNmViYTMxM2EzZjdmZjlhMzQxYmQzODVjMjE4MWQyM2MyNTljNTFiNWI2ZTRlZDdjZTJjNzE2NCIsInRhZyI6IiJ9', 'paid', '2025-01-24 04:45:48', '2025-01-24 04:45:48'),
(17, 17, 250, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IkNWM3ZPamlxTjRsWmw0UzgxS0owbGc9PSIsInZhbHVlIjoiWm1tUEFYNjRVRTJvQTJMM3NoMk1BUT09IiwibWFjIjoiYTM3ODdkMWM4NmU4MGY4Y2ZiMmE2N2VjZGNkODYwMTFkNzY3YmE2ZWQ0YmM1MDM0MzM0MThlYWQ5ZWNhMGRjNyIsInRhZyI6IiJ9', 'paid', '2025-01-24 04:47:06', '2025-01-24 04:47:06'),
(18, 18, 85, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6ImlOMENPa0JGY3NmN2dKdWh4cmJwdWc9PSIsInZhbHVlIjoia0xhRHQ5QUIrS244clRCN3M2cExrQT09IiwibWFjIjoiOGVhMTc1YTQ3N2RjN2RkNzgxNjQzNzk0ZDlhMTRiYWJiMzQzZGRmNGEzZGQzNzQ1NDUxMDJhY2QyN2UwYzk2NyIsInRhZyI6IiJ9', 'paid', '2025-01-24 05:05:26', '2025-01-24 05:05:26'),
(19, 19, 150, 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IlpQeGNsR0xXdmRmOVlFaGJoWDBJMlE9PSIsInZhbHVlIjoiNnhpLzlEVDJLenZKODF5MUR1UFdBdz09IiwibWFjIjoiNmMwOTEzODA2ZmQ0ZmI3MDNhODYwNTYzZWMyZTljNTMzNGNiOWY4OTE2NzUxOWI5OWE1ZWUxNTllNTYxNTQ0OCIsInRhZyI6IiJ9', 'paid', '2025-01-24 08:59:47', '2025-01-24 08:59:47'),
(20, 20, 100, 'http://localhost:8000/payment_terminal/eyJpdiI6Ijd3K1JFb09CY3JOcW5TZTZjazM1Vnc9PSIsInZhbHVlIjoieFlXKzJKYjRKWmNWdFRreXNtU1R2Zz09IiwibWFjIjoiYjQ5ZDRhN2U3MDNiNjY0NGFiYzAwYWY0MmI3MTIwNDM2N2M5YTU3NjFlZGIwZmI0NTBiNmEwMjUwMGVlMmE0NSIsInRhZyI6IiJ9', 'paid', '2025-01-24 09:20:41', '2025-01-24 09:20:41');

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
(5, 'Rapyd.net', 'active', NULL, NULL);

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
  `status` enum('pending','processed','completed','discarded') NOT NULL,
  `payment_status` enum('unpaid','paid') NOT NULL,
  `payment_link` text DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `payment_type`, `order_number`, `sale_amount`, `sale_currency`, `description`, `brand_name`, `payment_gateway`, `merchant_id`, `sales_email`, `customer_email`, `status`, `payment_status`, `payment_link`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 1, '00001', 670, 'USD', 'Custom Package', '1', 'PayPal', 1, 'vezufyliv@mailinator.com', 'tifafa@mailinator.com', 'pending', 'paid', NULL, '2024-09-20 19:00:00', '2024-09-19 05:02:31', '2024-09-19 05:04:19'),
(2, 1, '00002', 99, 'USD', 'Custom Package', '1', 'Stripe', 2, 'lysuqa@mailinator.com', 'dociguk@mailinator.com', 'pending', 'paid', NULL, '2024-09-19 19:00:00', '2024-09-19 05:04:49', '2024-09-19 05:05:07'),
(4, 1, '00004', 760, 'USD', 'Custom Package', '1', 'Square', 3, 'meho@mailinator.com', 'wyjydyx@mailinator.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IkhvL1ZJVElGYjhnUWMvd2dLMmpQRUE9PSIsInZhbHVlIjoiT1gwVWtmeDFNUGZoNUhaRWZFWFl4dz09IiwibWFjIjoiZWEzNzEwNDA3MDFiNWI2MTY0ZTNjNDUwMzAxZjUwMDQ4NDg5MDlmZTg3NmZmOGJiNTBmODNmOWMwMTMxMDFlYSIsInRhZyI6IiJ9', '2024-09-26 19:00:00', '2024-09-19 05:05:46', '2024-09-19 05:05:46'),
(6, 1, '00006', 1700, 'USD', 'Custom Package', '1', 'Rapyd.net', 5, 'dubybuqozo@mailinator.com', 'wonugaseri@mailinator.com', 'pending', 'paid', NULL, '2024-09-24 19:00:00', '2024-09-19 05:07:45', '2024-09-19 05:08:18'),
(7, 1, '00007', 480, 'USD', 'Custom Package', '1', 'Authorize.net', 4, 'fazaki@mailinator.com', 'jevegosela@mailinator.com', 'pending', 'paid', NULL, '2024-09-23 19:00:00', '2024-09-19 05:19:51', '2024-09-19 05:20:17'),
(8, 1, '00008', 2976, 'USD', 'Custom Package', '1', 'Stripe', 2, 'rivuxom@mailinator.com', 'womycobag@mailinator.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6InV6eUVOSVVBNm1EMzFsQllZOU9DTlE9PSIsInZhbHVlIjoidlVvMVdnczRaMXoyVlRnNkVjOUNtZz09IiwibWFjIjoiYzA1ZTU1ZGE4YzUyMGU3MTE3MDVkMDY1ODVjYWMzNzgwYWNlNzY4NDk0M2RhOGQwNDFmMzY1Yjk5YTRjNGM1ZSIsInRhZyI6IiJ9', '2024-10-23 19:00:00', '2024-10-09 03:46:26', '2024-10-09 03:46:26'),
(9, 1, '00009', 1000, 'USD', 'Custom Package', '1', 'Stripe', 2, 'max@gmail.com', 'max@gmail.com', 'pending', 'paid', NULL, '2024-11-06 19:00:00', '2024-11-05 07:28:44', '2024-11-05 07:30:18'),
(10, 1, '00010', 100, 'USD', 'Custom Package', '1', 'Stripe', 2, 'max@gmail.com', 'max@gmail.com', 'pending', 'paid', NULL, '2024-11-06 19:00:00', '2024-11-05 07:37:07', '2024-11-05 07:37:25'),
(11, 1, '00011', 100, 'USD', 'Custom Package', '1', 'PayPal', 1, 'max@gmail.com', 'max@gmail.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6ImZ3SG04aTJ6dmgwQ0dwQk1vbzJNdnc9PSIsInZhbHVlIjoiRldtaCtFUldRc1dyN0hIZThVN29UQT09IiwibWFjIjoiZTQ3YzM3NGYwZmUzODA3OTFkMjVkYWI3Mzk0MTc4MjE5NTUyNDYyNTVmNWQxNDg3MDI0MDJlNDFkYmNjMGNhNSIsInRhZyI6IiJ9', '2024-11-06 19:00:00', '2024-11-05 07:38:18', '2024-11-05 07:38:18'),
(12, 1, '00012', 100, 'USD', 'Custom Package', '1', 'Stripe', 2, 'max@gmail.com', 'max@gmail.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IjFZMmY2MGQxMWdlQkpoelg4b1JLNkE9PSIsInZhbHVlIjoiay9Udk9Sd2lnbURkSlpUNHJDK2N6UT09IiwibWFjIjoiZDVmZTE1YzFhMDhhMWQxZGE2ZGQwOTcyZjZlZGUxYzRiYmQ0ZjJmYWNkMjRjZGUzNjMyMzJkYzlkMDIzZmM2YSIsInRhZyI6IiJ9', '2024-11-06 19:00:00', '2024-11-05 07:39:02', '2024-11-05 07:39:02'),
(13, 1, '00013', 100, 'USD', 'Custom Package', '1', 'Stripe', 2, 'max@gmail.com', 'max@gmail.com', 'pending', 'paid', NULL, '2025-01-29 19:00:00', '2025-01-24 04:32:04', '2025-01-24 04:32:23'),
(14, 1, '00014', 100, 'CRC', 'Custom Package', '2', 'Square', 3, 'max11@gmail.com', 'max22@gmail.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IjFiYTZMbW5lL0hIMVFqV1owcW1qV1E9PSIsInZhbHVlIjoiMXlDNjJJU1NtaTVpV1liNzJpV1RDQT09IiwibWFjIjoiZjViYzE1ZTA5ZDE2YjRlMzRiODQ4YzVlMWRlNzM2YmFiNjg4ZjFjNjA3ZGM2MWM3OWQ4ODY1ZDRlZDUyMzY0ZSIsInRhZyI6IiJ9', '2025-01-24 19:00:00', '2025-01-24 04:43:34', '2025-01-24 04:43:34'),
(15, 1, '00015', 100, 'USD', 'Custom Package', '1', 'Square', 3, 'max@gmail.com', 'max@gmail.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IlBMYjVpdGxvUVRSTkRJb2xDMnE2Wmc9PSIsInZhbHVlIjoiSTNYV3M3eTY0TDRuejMzalh4QjQrUT09IiwibWFjIjoiNjdkZDA1NmMwMWE2NGI4MmQxMTgxNDk1OWQ1ZTEwNDIwY2MxMDQ1MDVhYjNhMmY3NTdmYWYwNjFiYzI3MjgyNiIsInRhZyI6IiJ9', '2025-01-24 19:00:00', '2025-01-24 04:44:41', '2025-01-24 04:44:41'),
(16, 1, '00016', 100, 'USD', 'Custom Package', '1', 'Authorize.net', 4, 'max11@gmail.com', 'max22@gmail.com', 'pending', 'paid', NULL, '2025-01-24 19:00:00', '2025-01-24 04:45:48', '2025-01-24 04:46:11'),
(17, 1, '00017', 250, 'USD', 'Custom Package', '1', 'Rapyd.net', 5, 'max33@gmail.com', 'max444@gmail.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IkNWM3ZPamlxTjRsWmw0UzgxS0owbGc9PSIsInZhbHVlIjoiWm1tUEFYNjRVRTJvQTJMM3NoMk1BUT09IiwibWFjIjoiYTM3ODdkMWM4NmU4MGY4Y2ZiMmE2N2VjZGNkODYwMTFkNzY3YmE2ZWQ0YmM1MDM0MzM0MThlYWQ5ZWNhMGRjNyIsInRhZyI6IiJ9', '2025-01-29 19:00:00', '2025-01-24 04:47:06', '2025-01-24 04:47:06'),
(18, 2, '00018', 85, 'USD', 'Custom Package', '1', 'Square', 3, 'lemoqo@mailinator.com', 'hunid@mailinator.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6ImlOMENPa0JGY3NmN2dKdWh4cmJwdWc9PSIsInZhbHVlIjoia0xhRHQ5QUIrS244clRCN3M2cExrQT09IiwibWFjIjoiOGVhMTc1YTQ3N2RjN2RkNzgxNjQzNzk0ZDlhMTRiYWJiMzQzZGRmNGEzZGQzNzQ1NDUxMDJhY2QyN2UwYzk2NyIsInRhZyI6IiJ9', '2025-01-24 19:00:00', '2025-01-24 05:05:26', '2025-01-24 05:05:26'),
(19, 1, '00019', 150, 'USD', 'Custom Package', '1', 'Square', 3, 'max123@gmail.com', 'max456@gmail.com', 'pending', 'unpaid', 'http://127.0.0.1:8000/payment_terminal/eyJpdiI6IlpQeGNsR0xXdmRmOVlFaGJoWDBJMlE9PSIsInZhbHVlIjoiNnhpLzlEVDJLenZKODF5MUR1UFdBdz09IiwibWFjIjoiNmMwOTEzODA2ZmQ0ZmI3MDNhODYwNTYzZWMyZTljNTMzNGNiOWY4OTE2NzUxOWI5OWE1ZWUxNTllNTYxNTQ0OCIsInRhZyI6IiJ9', '2025-01-27 19:00:00', '2025-01-24 08:59:47', '2025-01-24 08:59:47'),
(20, 1, '00020', 100, 'USD', 'Custom Package', '1', 'Square', 3, 'max@gmail.com', 'max@gmail.com', 'pending', 'paid', NULL, '2025-01-29 19:00:00', '2025-01-24 09:20:40', '2025-01-24 09:21:02');

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
(1, 1, 1, '2024-09-19 05:02:31', '2024-09-19 05:02:31'),
(2, 2, 1, '2024-09-19 05:04:49', '2024-09-19 05:04:49'),
(4, 4, 2, '2024-09-19 05:05:46', '2024-09-19 05:05:46'),
(6, 6, 2, '2024-09-19 05:07:45', '2024-09-19 05:07:45'),
(7, 7, 1, '2024-09-19 05:19:51', '2024-09-19 05:19:51'),
(8, 8, 1, '2024-10-09 03:46:26', '2024-10-09 03:46:26'),
(9, 9, 1, '2024-11-05 07:28:44', '2024-11-05 07:28:44'),
(10, 10, 1, '2024-11-05 07:37:07', '2024-11-05 07:37:07'),
(11, 11, 1, '2024-11-05 07:38:18', '2024-11-05 07:38:18'),
(12, 12, 1, '2024-11-05 07:39:02', '2024-11-05 07:39:02'),
(13, 13, 1, '2025-01-24 04:32:04', '2025-01-24 04:32:04'),
(14, 14, 6, '2025-01-24 04:43:34', '2025-01-24 04:43:34'),
(15, 15, 1, '2025-01-24 04:44:41', '2025-01-24 04:44:41'),
(16, 16, 1, '2025-01-24 04:45:48', '2025-01-24 04:45:48'),
(17, 17, 1, '2025-01-24 04:47:06', '2025-01-24 04:47:06'),
(18, 18, 1, '2025-01-24 05:05:26', '2025-01-24 05:05:26'),
(19, 19, 1, '2025-01-24 08:59:47', '2025-01-24 08:59:47'),
(20, 20, 1, '2025-01-24 09:20:41', '2025-01-24 09:20:41');

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
  `country` varchar(255) NOT NULL,
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
(1, 1, '70A0014070961722H', 'MQZVJ2AXR9ESC', 'USD', 670, 670, NULL, '[{\"reference_id\":\"default\",\"amount\":{\"currency_code\":\"USD\",\"value\":\"670.00\"},\"payee\":{\"email_address\":\"sb-eoziw32249812@business.example.com\",\"merchant_id\":\"AQWMSN6SNKW5J\"},\"soft_descriptor\":\"PAYPAL *TEST STORE\",\"shipping\":{\"name\":{\"full_name\":\"Jake Sparrow\"},\"address\":{\"address_line_1\":\"Kingston\",\"admin_area_2\":\"New York\",\"admin_area_1\":\"NM\",\"postal_code\":\"12345\",\"country_code\":\"US\"}},\"payments\":{\"captures\":[{\"id\":\"8MT86724N0298811N\",\"status\":\"COMPLETED\",\"amount\":{\"currency_code\":\"USD\",\"value\":\"670.00\"},\"final_capture\":true,\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"create_time\":\"2024-09-19T10:04:18Z\",\"update_time\":\"2024-09-19T10:04:18Z\"}]}}]', 'Nigel', 'Nielsen', 'Sed quis quia eum libero', 'None', 'None', 'None', 'None', 'tifafa@mailinator.com', '+1 (914) 102-5953', '2024-09-19 05:04:19', '2024-09-19 05:04:19'),
(2, 2, 'pi_3Q0hEECu6SvFHAij03rUKDV4', 'pi_3Q0hEECu6SvFHAij03rUKDV4', 'USD', 99, 99, NULL, '{\r\n  \"id\": \"pi_3Q0hEECu6SvFHAij03rUKDV4\",\r\n  \"object\": \"payment_intent\",\r\n  \"amount\": 9900,\r\n  \"amount_details\": {\r\n    \"tip\": {}\r\n  },\r\n  \"automatic_payment_methods\": {\r\n    \"allow_redirects\": \"always\",\r\n    \"enabled\": true\r\n  },\r\n  \"canceled_at\": null,\r\n  \"cancellation_reason\": null,\r\n  \"capture_method\": \"automatic_async\",\r\n  \"client_secret\": \"pi_3Q0hEECu6SvFHAij03rUKDV4_secret_MDytqYCesww3L65hYahldFVuw\",\r\n  \"confirmation_method\": \"automatic\",\r\n  \"created\": 1726740290,\r\n  \"currency\": \"usd\",\r\n  \"description\": \"Payment from - Test\",\r\n  \"last_payment_error\": null,\r\n  \"livemode\": false,\r\n  \"next_action\": null,\r\n  \"payment_method\": \"pm_1Q0hEUCu6SvFHAijzJNsiXuo\",\r\n  \"payment_method_configuration_details\": {\r\n    \"id\": \"pmc_1PokJiCu6SvFHAij2w8DADpK\",\r\n    \"parent\": null\r\n  },\r\n  \"payment_method_types\": [\r\n    \"card\",\r\n    \"link\",\r\n    \"cashapp\"\r\n  ],\r\n  \"processing\": null,\r\n  \"receipt_email\": null,\r\n  \"setup_future_usage\": \"off_session\",\r\n  \"shipping\": null,\r\n  \"source\": null,\r\n  \"status\": \"succeeded\"\r\n}', 'Candice', 'Scott', 'Consectetur autem quae qu', 'None', 'None', 'None', 'None', 'dociguk@mailinator.com', '+1 (689) 887-5685', '2024-09-19 05:05:07', '2024-09-19 05:05:07'),
(7, 6, 'payment_abd0bbe1fc88e8817eb1b653f00bcec2', 'cus_19a664dbba0754436b561489786f5a57', 'USD', 1, 1, NULL, '{\"id\":\"payment_abd0bbe1fc88e8817eb1b653f00bcec2\",\"amount\":1,\"original_amount\":1,\"is_partial\":false,\"currency_code\":\"USD\",\"country_code\":\"GB\",\"status\":\"CLO\",\"description\":\"\",\"merchant_reference_id\":\"\",\"customer_token\":\"cus_19a664dbba0754436b561489786f5a57\",\"payment_method\":null,\"payment_method_data\":{\"id\":null,\"type\":\"gb_visa_card\",\"category\":\"card\",\"metadata\":null,\"image\":\"\",\"webhook_url\":\"\",\"supporting_documentation\":\"\",\"next_action\":\"not_applicable\",\"name\":\"Michael\",\"last4\":\"1111\",\"acs_check\":\"unchecked\",\"cvv_check\":\"unchecked\",\"bin_details\":{\"type\":\"DEBIT\",\"brand\":\"VISA\",\"level\":\"CREDIT\",\"issuer\":\"JPMORGAN CHASE BANK, N.A.\",\"country\":\"US\",\"bin_number\":\"411111\"},\"expiration_year\":\"28\",\"expiration_month\":\"01\",\"fingerprint_token\":\"ocfp_0ef9b389a758e9dd44944f8b5afff32e\"},\"auth_code\":null,\"expiration\":1727345298,\"captured\":true,\"refunded\":false,\"refunded_amount\":0,\"receipt_email\":\"\",\"redirect_url\":\"\",\"complete_payment_url\":\"\",\"error_payment_url\":\"\",\"receipt_number\":\"\",\"flow_type\":\"\",\"address\":null,\"statement_descriptor\":\"N\\/A\",\"transaction_id\":\"\",\"created_at\":1726740498,\"metadata\":{},\"failure_code\":\"\",\"failure_message\":\"\",\"paid\":true,\"paid_at\":1726740498,\"dispute\":null,\"refunds\":null,\"order\":null,\"outcome\":null,\"visual_codes\":{},\"textual_codes\":{},\"instructions\":[],\"ewallet_id\":\"ewallet_5f7d0901b6de62f47059c0970eb79a64\",\"ewallets\":[{\"ewallet_id\":\"ewallet_5f7d0901b6de62f47059c0970eb79a64\",\"amount\":1,\"percent\":100,\"refunded_amount\":0}],\"payment_method_options\":{},\"payment_method_type\":\"gb_visa_card\",\"payment_method_type_category\":\"card\",\"fx_rate\":1,\"merchant_requested_currency\":null,\"merchant_requested_amount\":null,\"fixed_side\":\"\",\"payment_fees\":null,\"invoice\":\"\",\"escrow\":null,\"group_payment\":\"\",\"cancel_reason\":null,\"initiation_type\":\"customer_present\",\"mid\":\"\",\"next_action\":\"not_applicable\",\"error_code\":\"\",\"remitter_information\":{},\"save_payment_method\":false}', 'Germaine', 'Fernandez', 'Optio nostrum similique', 'None', 'None', 'None', 'None', 'wonugaseri@mailinator.com', '+923123435355', '2024-09-19 05:08:18', '2024-09-19 05:08:18'),
(8, 7, '0', '000000', 'USD', 480, 480, NULL, '{\"responseCode\":\"1\",\"authCode\":\"000000\",\"avsResultCode\":\"P\",\"cvvResultCode\":\"\",\"cavvResultCode\":\"\",\"transId\":\"0\",\"refTransID\":\"\",\"transHash\":\"\",\"testRequest\":\"1\",\"accountNumber\":\"XXXX0015\",\"accountType\":\"MasterCard\",\"messages\":{\"message\":[{\"code\":\"1\",\"description\":\"This transaction has been approved.\"}]},\"transHashSha2\":\"840650954681AD7AE1E02D31BE10443D9B185178413DDACCD207A3B71E591189D2C9B759CA2CD1B5DD1942ABE2875B938A87D0E36CF370EE8E472E40E31ECCE8\"}', 'Kaitlin', 'Hartman', 'In eiusmod voluptatum nul', 'None', 'None', 'None', 'None', 'jevegosela@mailinator.com', '+1 (629) 222-9030', '2024-09-19 05:20:17', '2024-09-19 05:20:17'),
(9, 10, 'pi_3QHm0OCu6SvFHAij1AWSPFkj', 'pi_3QHm0OCu6SvFHAij1AWSPFkj', 'USD', 100, 100, NULL, '{\r\n  \"id\": \"pi_3QHm0OCu6SvFHAij1AWSPFkj\",\r\n  \"object\": \"payment_intent\",\r\n  \"amount\": 10000,\r\n  \"amount_details\": {\r\n    \"tip\": {}\r\n  },\r\n  \"automatic_payment_methods\": {\r\n    \"allow_redirects\": \"always\",\r\n    \"enabled\": true\r\n  },\r\n  \"canceled_at\": null,\r\n  \"cancellation_reason\": null,\r\n  \"capture_method\": \"automatic_async\",\r\n  \"client_secret\": \"pi_3QHm0OCu6SvFHAij1AWSPFkj_secret_bZ7xxJNLPt1cX2HqXUIirIMU1\",\r\n  \"confirmation_method\": \"automatic\",\r\n  \"created\": 1730810228,\r\n  \"currency\": \"usd\",\r\n  \"description\": \"Payment from - Test\",\r\n  \"last_payment_error\": null,\r\n  \"livemode\": false,\r\n  \"next_action\": null,\r\n  \"payment_method\": \"pm_1QHm0eCu6SvFHAijR42saz0o\",\r\n  \"payment_method_configuration_details\": {\r\n    \"id\": \"pmc_1PokJiCu6SvFHAij2w8DADpK\",\r\n    \"parent\": null\r\n  },\r\n  \"payment_method_types\": [\r\n    \"card\",\r\n    \"link\",\r\n    \"cashapp\"\r\n  ],\r\n  \"processing\": null,\r\n  \"receipt_email\": null,\r\n  \"setup_future_usage\": \"off_session\",\r\n  \"shipping\": null,\r\n  \"source\": null,\r\n  \"status\": \"succeeded\"\r\n}', 'Vernon', 'Solomon', 'Abdul Thornton', 'None', 'None', 'None', 'None', 'max@gmail.com', '76876986', '2024-11-05 07:37:25', '2024-11-05 07:37:25'),
(10, 13, 'pi_3QkjFBCu6SvFHAij0p9VNzGc', 'pi_3QkjFBCu6SvFHAij0p9VNzGc', 'USD', 100, 100, NULL, '{\r\n  \"id\": \"pi_3QkjFBCu6SvFHAij0p9VNzGc\",\r\n  \"object\": \"payment_intent\",\r\n  \"amount\": 10000,\r\n  \"amount_details\": {\r\n    \"tip\": {}\r\n  },\r\n  \"automatic_payment_methods\": {\r\n    \"allow_redirects\": \"always\",\r\n    \"enabled\": true\r\n  },\r\n  \"canceled_at\": null,\r\n  \"cancellation_reason\": null,\r\n  \"capture_method\": \"automatic_async\",\r\n  \"client_secret\": \"pi_3QkjFBCu6SvFHAij0p9VNzGc_secret_BQevzBVEWsQ8yd4yJCBv0fCoc\",\r\n  \"confirmation_method\": \"automatic\",\r\n  \"created\": 1737711125,\r\n  \"currency\": \"usd\",\r\n  \"description\": \"Payment from - Test\",\r\n  \"last_payment_error\": null,\r\n  \"livemode\": false,\r\n  \"next_action\": null,\r\n  \"payment_method\": \"pm_1QkjFSCu6SvFHAijTurCgbdM\",\r\n  \"payment_method_configuration_details\": {\r\n    \"id\": \"pmc_1PokJiCu6SvFHAij2w8DADpK\",\r\n    \"parent\": null\r\n  },\r\n  \"payment_method_types\": [\r\n    \"card\",\r\n    \"link\",\r\n    \"cashapp\"\r\n  ],\r\n  \"processing\": null,\r\n  \"receipt_email\": null,\r\n  \"setup_future_usage\": \"off_session\",\r\n  \"shipping\": null,\r\n  \"source\": null,\r\n  \"status\": \"succeeded\"\r\n}', 'Joel', 'Mcfadden', 'Sit nulla blanditiis est', 'None', 'None', 'None', 'None', 'max@gmail.com', '+1 (283) 147-5672', '2025-01-24 04:32:23', '2025-01-24 04:32:23'),
(11, 16, '0', '000000', 'USD', 100, 100, NULL, '{\"responseCode\":\"1\",\"authCode\":\"000000\",\"avsResultCode\":\"P\",\"cvvResultCode\":\"\",\"cavvResultCode\":\"\",\"transId\":\"0\",\"refTransID\":\"\",\"transHash\":\"\",\"testRequest\":\"1\",\"accountNumber\":\"XXXX1111\",\"accountType\":\"Visa\",\"messages\":{\"message\":[{\"code\":\"1\",\"description\":\"This transaction has been approved.\"}]},\"transHashSha2\":\"9B712D1CD92901B8A4F147F4EF24A9839316B2E20501A313EBDE49527AFC836F0253CAD6E93F56E5B423A5D3D25BADAC22742C87AFE93E48CC13635ADD44D4E6\"}', 'Vernon', 'Solomon', 'Abdul Thornton', 'None', 'None', 'None', 'None', 'max22@gmail.com', '76876986', '2025-01-24 04:46:11', '2025-01-24 04:46:11'),
(12, 20, 'zjDPU0kOJmx1vcIk4JJU0IaVwgHZY', '411111', 'USD', 100, 100, 1111, '{\"id\":\"zjDPU0kOJmx1vcIk4JJU0IaVwgHZY\",\"created_at\":\"2025-01-24T14:21:01.757Z\",\"updated_at\":\"2025-01-24T14:21:01.986Z\",\"amount_money\":{\"amount\":100,\"currency\":\"USD\"},\"total_money\":{\"amount\":100,\"currency\":\"USD\"},\"approved_money\":{\"amount\":100,\"currency\":\"USD\"},\"status\":\"COMPLETED\",\"delay_duration\":\"PT168H\",\"delay_action\":\"CANCEL\",\"delayed_until\":\"2025-01-31T14:21:01.757Z\",\"source_type\":\"CARD\",\"card_details\":{\"status\":\"CAPTURED\",\"card\":{\"card_brand\":\"VISA\",\"last_4\":\"1111\",\"exp_month\":11,\"exp_year\":2027,\"fingerprint\":\"sq-1-oau8_aK5oyO-6iqGiU698gxg5Fe5huT4Woy7X-TvebugA0wY4x8gF_BFcXQNgVX3UQ\",\"card_type\":\"CREDIT\",\"prepaid_type\":\"NOT_PREPAID\",\"bin\":\"411111\"},\"entry_method\":\"KEYED\",\"cvv_status\":\"CVV_ACCEPTED\",\"avs_status\":\"AVS_ACCEPTED\",\"statement_description\":\"SQ *DEFAULT TEST ACCOUNT\",\"card_payment_timeline\":{\"authorized_at\":\"2025-01-24T14:21:01.887Z\",\"captured_at\":\"2025-01-24T14:21:01.986Z\"}},\"location_id\":\"LB7K5AWQTJ3JF\",\"order_id\":\"8TmyDgUyoZHWZPaWiQiaMPvbdh4F\",\"risk_evaluation\":{\"created_at\":\"2025-01-24T14:21:01.887Z\",\"risk_level\":\"NORMAL\"},\"receipt_number\":\"zjDP\",\"receipt_url\":\"https://squareupsandbox.com/receipt/preview/zjDPU0kOJmx1vcIk4JJU0IaVwgHZY\",\"application_details\":{\"square_product\":\"ECOMMERCE_API\",\"application_id\":\"sandbox-sq0idb--ftpiC33aWpI9BxnoUDtHQ\"},\"version_token\":\"PoIkHDNpv5Zj7g7sw2MSEdKiJsdM93qBclJwXwM318M6o\"}', 'Vernon', 'Solomon', 'Abdul Thornton', 'None', 'None', 'None', 'None', 'max@gmail.com', '+76876986', '2025-01-24 09:21:02', '2025-01-24 09:21:02');

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
(1, 'Testing Package1', NULL, 1, 'active', '0', '2024-09-19 05:01:14', '2024-09-19 05:01:14'),
(2, 'Testing Package2', NULL, 1, 'active', '0', '2024-09-19 05:01:14', '2024-09-19 05:01:14'),
(3, 'Testing Package1', NULL, 2, 'active', '0', '2025-01-24 04:41:59', '2025-01-24 04:41:59'),
(4, 'Testing Package2', NULL, 2, 'active', '0', '2025-01-24 04:41:59', '2025-01-24 04:41:59'),
(5, 'Testing Package3', NULL, 2, 'active', '0', '2025-01-24 04:41:59', '2025-01-24 04:41:59'),
(6, 'Testing Package4', NULL, 2, 'active', '0', '2025-01-24 04:41:59', '2025-01-24 04:41:59');

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
(1, 'Nigel', 'Nielsen', 'Sed quis quia eum libero', 'None', 'None', 'None', 'None', '+1 (914) 102-5953', 2, 'tifafa@mailinator.com', NULL, NULL, NULL, '2024-09-19 05:04:19', '2024-09-19 05:04:19'),
(2, 'Candice', 'Scott', 'Consectetur autem quae qu', 'None', 'None', 'None', 'None', '+1 (689) 887-5685', 2, 'dociguk@mailinator.com', NULL, NULL, NULL, '2024-09-19 05:05:07', '2024-09-19 05:05:07'),
(3, 'Sophia', 'Hodge', 'Provident veniam except', 'None', 'None', 'None', 'None', '+1 (887) 167-8674', 2, 'bohyxe@mailinator.com', NULL, NULL, NULL, '2024-09-19 05:07:00', '2024-09-19 05:07:01'),
(4, 'Germaine', 'Fernandez', 'Optio nostrum similique', 'None', 'None', 'None', 'None', '+923123435355', 2, 'wonugaseri@mailinator.com', NULL, NULL, NULL, '2024-09-19 05:08:18', '2024-09-19 05:08:18'),
(5, 'Kaitlin', 'Hartman', 'In eiusmod voluptatum nul', 'None', 'None', 'None', 'None', '+1 (629) 222-9030', 2, 'jevegosela@mailinator.com', NULL, NULL, NULL, '2024-09-19 05:20:17', '2024-09-19 05:20:17'),
(6, 'Vernon', 'Solomon', 'Abdul Thornton', 'None', 'None', 'None', 'None', '+76876986', 2, 'max@gmail.com', NULL, NULL, NULL, '2024-11-05 07:30:18', '2025-01-24 09:21:02'),
(7, 'Vernon', 'Solomon', 'Abdul Thornton', 'None', 'None', 'None', 'None', '76876986', 2, 'max22@gmail.com', NULL, NULL, NULL, '2025-01-24 04:46:11', '2025-01-24 04:46:11');

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `brand_merchants`
--
ALTER TABLE `brand_merchants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `card_details`
--
ALTER TABLE `card_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `merchants`
--
ALTER TABLE `merchants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_packages`
--
ALTER TABLE `order_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_payment_transactions`
--
ALTER TABLE `order_payment_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_brands`
--
ALTER TABLE `user_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `user_brands_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD CONSTRAINT `user_permissions_permissions_id_foreign` FOREIGN KEY (`permissions_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
